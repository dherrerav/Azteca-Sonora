<?php
/*
# ------------------------------------------------------------------------
# JA T3 System plugin for Joomla 1.6
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
# Author: J.O.O.M Solutions Co., Ltd
# Websites: http://www.joomlart.com - http://www.joomlancers.com
# ------------------------------------------------------------------------
*/

class T3Head extends JObject {	
	function proccess() {
		$document =& JFactory::getDocument();
		//proccess stylesheets
		$themes = T3Common::get_active_themes();
		//$themes[] = array('core', 'default'); //default now move to template root folder
		//$themes[] = array('engine', 'default');
		$themes = array_reverse($themes);
		
		$scripts = array();
		$css_urls = array();
		$css_urls['site'] = array();
		foreach ($themes as $theme) {
			$css_urls[$theme[0].'.'.$theme[1]] = array();
		}
		foreach ($themes as $theme) {
			$css_urls[$theme[0].'.'.$theme[1].'-browser'] = array();
		}
		
		if (T3Common::isRTL()) {
			foreach ($themes as $theme) {
				$css_urls[$theme[0].'.'.$theme[1].'-rtl'] = array();
			}
		}
		
		
		$bname = T3Common::getBrowserSortName();
		$bver = T3Common::getBrowserMajorVersion();
		$optimize_css = T3Parameter::get('optimize_css', 2);
		$optimize_js = T3Parameter::get('optimize_js', 2);
		foreach ($document->_styleSheets as $strSrc => $strAttr )
		{
			$path = T3Head::cleanUrl ($strSrc);
			if (!$path) {
				//External url
				$css_urls['site'][] = array ('', $strSrc);
				continue;
			}
			
			$intemplate = false;
			if (preg_match ('/^templates\/'.T3_ACTIVE_TEMPLATE.'\//', $path)) {
				$path = preg_replace ('/^templates\/'.T3_ACTIVE_TEMPLATE.'\//', '', $path);
				$intemplate = true;
			}
			/*
			if (!$intemplate && $optimize_css < 2) // don't read file content => keep original link
			{
				$css_urls['site'][] = array ('', $strSrc);
				continue;
			}
			*/
			$paths = array();
			$paths[] = array ('', $path, $strSrc); //The third element is the original url
			//if ($intemplate) {
				//only load other css files if in T3v2 template
				$ext = '';
				if (preg_match ('#\.[^.]+$#', $path, $matches)) $ext = $matches[0];
				//$file_info = pathinfo($path);
				//$ext = $file_info['extension'];
				if ($ext) {
					$paths[] = array('-browser', str_replace($ext, "-$bname$ext", $path));
					$paths[] = array('-browser', str_replace($ext, "-$bname$bver$ext", $path));
					if (T3Common::isRTL()) {
						$paths[] = array('-rtl', str_replace($ext, "-rtl$ext", $path));
						$paths[] = array('-rtl', str_replace($ext, "-$bname-rtl$ext", $path));
						$paths[] = array('-rtl', str_replace($ext, "-$bname$bver-rtl$ext", $path));
					}
				}
			//}
			
			foreach ($paths as $path) {
				//
				if ($intemplate) {
					if (($urls = T3Path::get ($path[1], true))) {
						foreach ($urls as $theme=>$url) {
							$css_urls [$theme.$path[0]][$url[0]] = $url;
						}
					}
				} else {
					if (is_file (T3Path::path($path[1])))
						$css_urls['site'][T3Path::path($path[1])] = array (T3Path::path($path[1]), count($path)>2?$path[2]:T3Path::url($path[1])); //use original url ($path[2]) if exists
				}
			}
		}
		//remove current stylesheets
		$document->_styleSheets = array();
		foreach ($document->_scripts as $strSrc => $strType) {
			$srcurl = T3Head::cleanUrl ($strSrc);
			if (!$srcurl) {
				$scrips[] = array ('', $strSrc);
				continue;
			}
			
			if (preg_match ('/^templates\/'.T3_ACTIVE_TEMPLATE.'\//', $srcurl)) {
				//in template
				$srcurl = preg_replace ('/^templates\/'.T3_ACTIVE_TEMPLATE.'\//', '', $srcurl);
				$path = str_replace ('/', DS, $srcurl);
				if (($url = T3Path::get ($path))) {
					$scrips[] = $url;
				}
			} else {
				if ($optimize_js < 1) // don't read file content => keep original link
				{
					$scrips[] = array ('', $strSrc);
					continue;
				}
				$path = str_replace ('/', DS, $srcurl);
				$scrips[] = array (JPATH_SITE.DS.$path, JURI::base(true).'/'.$srcurl);
			}
		}
		//remove current scripts
		$document->_scripts = array();
		
		$css_urls = T3Head::optimizecss($css_urls);
		//if ($url) $css_urls = array(array(array('', $url)));
	
		//re-add stylesheet to head
		foreach ($css_urls as $urls) {
			foreach ($urls as $url) {
				$document->addStylesheet ($url[1]);
			}
		}
			
		$scrips = T3Head::optimizejs($scrips);
		//re-add stylesheet to head
		foreach ($scrips as $url) {
			$document->addScript ($url[1]);
		}
	} 
	
	function cleanUrl ($strSrc) {
		$strSrc = preg_replace ('#[?\#]+.*$#', '', $strSrc);
		//if (!preg_match ('#\.(css|js)$#', $strSrc)) return false; //not static file
		if (preg_match ('/^https?\:/', $strSrc)) {
			if (!preg_match ('#^'.preg_quote(JURI::base()).'#', $strSrc)) return false; //external css
			$strSrc = str_replace (JURI::base(), '', $strSrc);
		} else if (preg_match ('/^\//', $strSrc) && JURI::base(true)) {
			if (!preg_match ('#^'.preg_quote(JURI::base(true)).'#', $strSrc)) return false; //same server, but outsite website
			$strSrc = preg_replace ('#^'.preg_quote(JURI::base(true)).'#', '', $strSrc);
		}
		$strSrc = str_replace ('//', '/', $strSrc); //replace double slash by one
		$strSrc = preg_replace ('/^\//', '', $strSrc); //remove first slash
		return $strSrc;
	}
	
	function optimizecss_ ($css_urls) {
		$content = '';
		$optimize_css = T3Parameter::get('optimize_css', 2);
		if (!$optimize_css) return $css_urls; //no optimize css
		$output = array();
		$optimize_exclude = trim(T3Parameter::get('optimize_exclude', ''));
		$optimize_exclude_regex = null;
		if ($optimize_exclude) 
			$optimize_exclude_regex = '#'.preg_replace ('#[\r\n]+#','|', preg_quote ($optimize_exclude)).'#';
		$files = '';
		jimport('joomla.filesystem.file');
		$filelimit = 20; //limit files import into a css file (in IE7, only first 30 css files are loaded)
		$filecount = 0;
		foreach ($css_urls as $theme=>$urls) {
			foreach ($urls as $url) {
				$ignorefile = false;				
				if ($url[0]) {
					if (!preg_match ('#\.css$#', $url[0])) $ignorefile = true; //ignore dynamic css file
					else $filecontent = @JFile::read ($url[0]);
					if (preg_match ('#@import\s+url#', $filecontent)) $ignorefile = true; //ignore css file which import other file
				}
				
				if ($filecount==$filelimit || !$url[0] 
						|| ($optimize_exclude_regex && preg_match ($optimize_exclude_regex,$url[1]))) $ignorefile = true;

				if ($ignorefile) {
					if ($files && $content) {
						//optimize those files
						$file = md5 ($files);
						$ourl = T3Head::store_file ($content, $file, 'css', $optimize_css==3);
						if (!$ourl) return $css_urls;
						$output[] = array ('', $ourl);
					}
					$files = '';
					$content = '';
					$output[] = $url;
					$filecount = 0;
				} else {
					$files .= $url[1];
					if ($optimize_css >= 2) { //Advnced: join files and minify contents
						//join css files into one file
						//description for the file
						if ($theme == 'site') {
							$filedesc = basename ($url[0]);
						} else {
							$themes = preg_split ('/\./', $theme, 2);
							if ($themes[0] == 'engine') {
								$filedesc = 'engine: '.basename ($url[0]);
							} else if ($themes[0] == 'template') {
								$filedesc = 'default: '.basename ($url[0]);
							} else {
								$filedesc = $theme.': '.basename ($url[0]);
							}
						}
						$content .= "/* $filedesc */\n".T3Head::compresscss($filecontent, $url[1])."\n\n";
					} else { //Basic: just import
						//import css
						$content .= "@import url(\"{$url[1]}\");\n";
						$filecount++;
					}
				}
			}
		}
		if ($files && $content) {
			//optimize those files
			$file = md5 ($files);
			$ourl = T3Head::store_file ($content, $file, 'css', $optimize_css==3);
			if (!$ourl) return $css_urls;
			$output[] = array ('', $ourl);
		}
		
		return array($output);
	}
	


	function optimizejs_ ($js_urls) {
		$content = '';
		$optimize_js = T3Parameter::get('optimize_js', 1);
		if (!$optimize_js) return $js_urls;

		$output = array();
		$optimize_exclude = trim(T3Parameter::get('optimize_exclude', ''));
		$optimize_exclude_regex = null;
		if ($optimize_exclude) 
			$optimize_exclude_regex = '#'.preg_replace ('#[\r\n]+#','|', preg_quote ($optimize_exclude)).'#';
		
		$files = '';
		jimport('joomla.filesystem.file');
		foreach ($js_urls as $url) {
			if (!$url[0] || !preg_match ('#\.js$#', $url[0]) 
				|| ($optimize_exclude_regex && preg_match ($optimize_exclude_regex,$url[1]))) {
				if ($files && $content) {
					//optimize those files
					$file = md5 ($files);
					$ourl = T3Head::store_file ($content, $file, 'js', $optimize_js==3);
					if (!$ourl) return $js_urls;
					$output[] = array ('', $ourl);
				}
				$files = '';
				$content = '';
				$output[] = $url;
			} else {
				$files .= $url[1];
				//join css files into one file
				//description for the file
				$filedesc = basename ($url[0]);
				$content .= "/* $filedesc */\n".T3Head::compressjs(@JFile::read ($url[0]), $url[1])."\n\n";
			}
		}
		
		if ($files && $content) {
			$file = md5 ($files);
			$ourl = T3Head::store_file ($content, $file, 'js', $optimize_js==3);
			if (!$ourl) return $js_urls;
			$output[] = array ('', $ourl);
		}
		
		return $output;
	}
	
	function optimizejs ($js_urls) {
		$content = '';
		$optimize_js = T3Parameter::get('optimize_js', 1);
		if (!$optimize_js) return $js_urls;

		$output = array();
		$optimize_exclude = trim(T3Parameter::get('optimize_exclude', ''));
		$optimize_exclude_regex = null;
		if ($optimize_exclude) 
			$optimize_exclude_regex = '#'.preg_replace ('#[\r\n]+#','|', preg_quote ($optimize_exclude)).'#';
		
		$files = array();
		$t3cache = T3Cache::getInstance();
		$cachepath = T3Path::path (T3Parameter::get('optimize_folder', 't3-assets'));
		$needupdate = false;
		jimport('joomla.filesystem.file');
		foreach ($js_urls as $url) {
			if (!$url[0] || !preg_match ('#\.js$#', $url[0]) 
				|| ($optimize_exclude_regex && preg_match ($optimize_exclude_regex,$url[1]))) 
			{
				//ignore if not a local file or not a static js file 
				//output to file
				if (count($files)) {
					$ourl = T3Head::store_file2 ($files, 'js', $needupdate);
					if (!$ourl) return $js_urls;
					//put result into output
					$output[] = array ('', $ourl);
				}
				//put this ignore file into ouput
				$output[] = $url;
				
				//reset the flag for file update
				$needupdate = false;
				$files = array();
			} else {
				//for static local file
				if ($optimize_js > 1) {
					//need optimized
					//Check if this file is changed from the last optimized
					$cfile = $cachepath.DS.md5($url[0]).'.'.basename ($url[0]);
					if (!is_file ($cfile) || @filemtime ($url[0]) > @filemtime ($cfile)) { //this file is changed/modified after cached
						//get file content
						$data = T3Head::compressjs(@JFile::read ($url[0]), $url[1]);				
						//write to cache file
						@JFile::write($cfile, $data);
						//make a flag for updating cache file
						$needupdate = true;
					}
					$files[] = array($cfile,'');
				} else {
					//just keep original
					$files[] = $url;
				}
			}
		}
		
		if (count($files)) {
			//output to file
			$ourl = T3Head::store_file2 ($files, 'js', $needupdate);
			if (!$ourl) return $js_urls;
			//put result into output
			$output[] = array ('', $ourl);
		}
		
		return $output;
	}
	
	function optimizecss ($css_urls) {
		$content = '';
		$optimize_css = T3Parameter::get('optimize_css', 2);
		if (!$optimize_css) return $css_urls; //no optimize css
		$output = array();
		$optimize_exclude = trim(T3Parameter::get('optimize_exclude', ''));
		$optimize_exclude_regex = null;
		if ($optimize_exclude) 
			$optimize_exclude_regex = '#'.preg_replace ('#[\r\n]+#','|', preg_quote ($optimize_exclude)).'#';
		
		$files = array();
		$t3cache = T3Cache::getInstance();
		$cachepath = T3Path::path (T3Parameter::get('optimize_folder', 't3-assets'));
		$needupdate = false;
		$filelimit = ($optimize_css == 1)?20:999; //limit files import into a css file (in IE7, only first 30 css files are loaded). other case, load unlimited
		$filecount = 0;
		
		jimport('joomla.filesystem.file');
		foreach ($css_urls as $theme=>$urls) {
			foreach ($urls as $url) {
				$ignore = false;
				$import = false;
				$importupdate = false;					
				//check ignore to optimize
				// - not a local file
				// - not a css file
				// - in ignore list
				if (!$url[0]) $ignore = true;
				else if (!preg_match ('#\.css$#', $url[0])) $ignore = true; //ignore dynamic css file
				else if (($optimize_exclude_regex && preg_match ($optimize_exclude_regex,$url[1]))) $ignore = true;
				if (!$ignore && $optimize_css > 1) {
					//check if need update. for css, the cache should be [filename] or [filename]-import
					//[filename]-import - for the case there's @import inside
					//in the ignore of @import, file still optimize but will be put into a sigle file
					$cfile = $cachepath.DS.md5($url[0]).'.'.basename ($url[0]);
					if (!(is_file($cfile) && @filemtime ($url[0]) < @filemtime ($cfile))
						&& !(is_file($cfile.'-import') && @filemtime ($url[0]) < @filemtime ($cfile.'-import'))
					){
						//Need update
						$data = T3Head::compresscss(@JFile::read ($url[0]), $url[1]);
						//check if contain @import
						if (preg_match ('#@import\s+.+#', $data)) {
							$import = true;
							$importupdate = true;
							$cfile = $cfile.'-import';
						}
						//delete old file if exists
						@JFile::delete($cfile);
						@JFile::delete($cfile.'-import');
						//write to cache file
						@JFile::write($cfile, $data);
						//make a flag for updating cache file
						$needupdate = true;
					} else if (is_file ($cfile.'-import')) {
						$import = true;
						$importupdate = false;
						$cfile = $cfile.'-import';
					}
				}
				//match ignore file, or import file, or reach the limit: flush previous files out
				if ($ignore || $import || count($files)==$filelimit) {
					if (count ($files)) {
						$ourl = T3Head::store_file2 ($files, 'css', $needupdate);
						if (!$ourl) return $css_urls;
						//put result into output
						$output[] = array ('', $ourl);
					}
					//reset the flag for file update
					$needupdate = false;
					$files = array();
				}
				//write out the @import file
				if ($import) {
					$ourl = T3Head::store_file2 (array(array($cfile,'')), 'css', $importupdate);
					if (!$ourl) return $css_urls;
					//put result into output
					$output[] = array ('', $ourl);
				} else if ($ignore) {
					$output[] = $url;
				} else {
					if ($optimize_css > 1) {
						$files[] = array($cfile,'');
					} else {
						$files[] = $url;
					}
				}
			}
		}
		if (count ($files)) {
			$ourl = T3Head::store_file2 ($files, 'css', $needupdate);
			if (!$ourl) return $css_urls;
			//put result into output
			$output[] = array ('', $ourl);
		}
		
		return array($output);
	}
	
	function compresscss($data, $url) {	
		global $current_css_url;
		//if ($url[0] == '/') $url = JURI::root(false, '').substr($url, 1);
		$current_css_url = $url;
		/* remove comments */
	    $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
		/* remove tabs, spaces, new lines, etc. */        
	    $data = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $data);
		/* remove unnecessary spaces */
	    $data = preg_replace ('/[ ]+([{};,:])/', '\1', $data);
	    $data = preg_replace ('/([{};,:])[ ]+/', '\1', $data);
	    /* remove empty class */
	    $data = preg_replace ('/(\}([^\}]*\{\})+)/', '}', $data);
	    /* replace url*/
	    $data = preg_replace_callback ('/url\(([^\)]*)\)/', array('T3Head', 'replaceurl'), $data);
		return $data;
	}
	
	function compressjs($data, $url) {
		$optimize_js = T3Parameter::get('optimize_js', 1);
		if ($optimize_js < 2) return $data; //no compress
		//compress using jsmin
		t3import ('core.libs.jsmin');
		
		return JSMin::minify ($data);
	}
	function replaceurl ($matches) {
		$url = str_replace (array('"', '\''), '', $matches[1]);
		global $current_css_url;
		$url = T3Head::converturl ($url, $current_css_url);
		return "url('$url')";
	}
	
	function converturl ($_url, $cssurl) {
		$url = $_url;
		$base = dirname ($cssurl);
		$base = str_replace (JURI::base(), JURI::base(true).'/', $base);
		$optimize_css = T3Parameter::get('optimize_css', 2);
		if ($optimize_css < 3) {
			//compress - using absolute path
			//not compress - convert to relative path
			$base = T3Head::cleanUrl($base);
			$cache_path = T3Parameter::get('optimize_folder', 't3-assets');
			while ($cache_path && $cache_path != '.') {
				$cache_path = dirname($cache_path);
				$base = '../'.$base;
			}
		}
		if (preg_match ('/^(\/|http)/', $url)) return $url; /*absolute or root*/
		while (preg_match ('/^\.\.\//', $url)) {
			$base = dirname ($base);
			$url = substr ($url, 3);
		}
		
		$url = $base.'/'.$url;
		return $url;
	}
	
	//use a shorter and readable filename. use version to tell the browser that the file content is change.
	function store_file ($content, $file, $ext, $compress = false) {
		$cache_path = T3Parameter::get('optimize_folder', 't3-assets');
		$path = T3Path::path ($cache_path);
		if (!is_dir ($path)) {
			if (! @JFolder::create ($path)) return false; //cannot create cache folder for js/css optimize
		}
		if (!is_file ($path.DS.'index.html')) {
			$indexcontent = '<html><body></body></html>';
			if (! @JFile::write ($path.DS.'index.html', $indexcontent)) return false; //cannot create blank index.html to prevent list files
		}
				
		static $filemap = array();
		//data.php contain filename maps
		$datafile = $path.'/data.php';		
		if (is_file ($datafile)) include_once ($datafile);
		
		$cdata = md5 ($content);		
		//$fileversion = substr($cdata, 0, 4);
		
		if (isset($filemap[$ext][$file]) && isset($filemap[$ext][$file]) && $filemap[$ext][$file][1]==$cdata) {
			$filename = "{$ext}{$filemap[$ext][$file][0]}.$ext";
			$fileversion = $filemap[$ext][$file][2];
		} else {
			if (!isset($filemap[$ext]))
				$filemap[$ext] = array();			
			if (!isset($filemap[$ext][$file])) {
				//$fname = count ($filemap[$ext])+1;
				$fname = substr($file, 0, 5);
				$filemap[$ext][$file] = array($fname, '', 0);
			}
			$filemap[$ext][$file][1] = $cdata;	//data key
			$filemap[$ext][$file][2] = (isset($filemap[$ext][$file][2]) && $filemap[$ext][$file][2]<999)?++$filemap[$ext][$file][2]:1; //version
			$filename = "{$ext}{$filemap[$ext][$file][0]}.$ext";
			$fileversion = $filemap[$ext][$file][2];
			//update datafile
			$filemapdata = '<?php $filemap = '.var_export ($filemap, true).'; ?>';
			@JFile::write($datafile, $filemapdata);
			
			//delete old file
			@ JFile::delete ($path.DS.$filename);
		}
			
		if (!is_file ($path.DS.$filename)) {
			//create new file
			if (! @JFile::write ($path.DS.$filename, $content)) return false; //cannot create file
		}
		
		//return result
		//check if need compress
		if ($compress) {
			$url = JRoute::_("index.php?jat3action=gzip&type=$ext&file=".urlencode ($cache_path.'/'.$filename)."&v=$fileversion");
			return $url;
		}
		return T3Path::url ($cache_path).'/'.$filename."?v=$fileversion";
	}
	
	//use a shorter and readable filename. use version to tell the browser that the file content is change.
	//read content from array of files $files and write to one cached file if need update $needupdate or cached file not exists
	//return the new file url
	function store_file2 ($files, $ext, $needupdate) {
		$cache_path = T3Parameter::get('optimize_folder', 't3-assets');
		$optimize_level = T3Parameter::get('optimize_'.$ext, 1);
		$path = T3Path::path ($cache_path);
		if (!is_dir ($path)) {
			if (! @JFolder::create ($path)) return false; //cannot create cache folder for js/css optimize
		}
		if (!is_file ($path.DS.'index.html')) {
			$indexcontent = '<html><body></body></html>';
			if (! @JFile::write ($path.DS.'index.html', $indexcontent)) return false; //cannot create blank index.html to prevent list files
		}
				
		static $filemap = array();
		//data.php contain filename maps
		$datafile = $path.'/data.php';		
		if (is_file ($datafile)) include_once ($datafile);
		//get a salt
		if (!isset($filemap['salt']) || !$filemap['salt']) {
			$filemap['salt'] = rand ();
		}
		//build destination file
		$file = md5 ($filemap['salt'].serialize($files));
		$filename = $ext.substr($file, 0, 5).".$ext";
		$destfile = $path.DS.$filename;
		
		//re-populate $needupdate in case $destfile exists & keep original (not minify)
		if ($optimize_level == 1 && is_file($destfile)) {
			foreach ($files as $f) {
				if (@filemtime ($f[0]) > @filemtime ($destfile)) {
					$needupdate = true;
					break;
				}
			}
		}
		//check if need update
		if (!$needupdate && is_file ($destfile)) {
			$fileversion = isset($filemap[$ext])&& isset($filemap[$ext][$file]) ? $filemap[$ext][$file] : 1;
			$fileversion = $fileversion==1?"":"?v=".$filemap[$ext][$file];
			return T3Path::url ($cache_path).'/'.$filename.$fileversion;
		}
		
		//get files content
		$content = '';
		foreach ($files as $f) {
			if ($ext == 'css' && $optimize_level == 1) {
				$content .= "@import url(\"{$f[1]}\");\n";
			} else {
				$content .= "/* ".substr(basename($f[0]), 33)." */\n".@JFile::read ($f[0])."\n\n";
			}
		}
		
		if (!isset($filemap[$ext])) $filemap[$ext] = array();
		if (!isset($filemap[$ext][$file])) $filemap[$ext][$file] = 0; //store file version 
		//update file version
		$filemap[$ext][$file] = $filemap[$ext][$file] + 1;		
		$fileversion = $filemap[$ext][$file]==1?"":"?v=".$filemap[$ext][$file];
		//update datafile
		$filemapdata = '<?php $filemap = '.var_export ($filemap, true).'; ?>';
		@JFile::write($datafile, $filemapdata);
			
		//create new file
		if (! @JFile::write($destfile, $content) ) return false; //cannot create file
		
		//return result
		//check if need compress
		if ($optimize_level == 3) { //compress
			$url = JRoute::_("index.php?jat3action=gzip&type=$ext&file=".urlencode ($cache_path.'/'.$filename).$fileversion);
			return $url;
		}
		return T3Path::url ($cache_path).'/'.$filename.$fileversion;
	}	
}