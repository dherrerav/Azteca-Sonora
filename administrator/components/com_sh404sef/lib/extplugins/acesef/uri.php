<?php
/**
* @version		1.5.0
* @package		AceSEF Library
* @subpackage	URI
* @copyright	2009-2010 JoomAce LLC, www.joomace.net
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('_JEXEC') or die('Restricted Access');

// URI class
class AcesefURI {

	function __construct() {
		// Get config object
		$this->AcesefConfig = AcesefFactory::getConfig();
	}
	
	// non-SEF Vars
	function nonSefVars(&$uri, $non_sef_vars = null, $non_sef_part = "") {
		$ext_non_sef = array();
		$config_non_sef	= array();
		
		// Load the nonSEF vars from extension parameters
		if (!is_null($uri->getVar('option'))) {
			$non_sef = $this->attributes->params->get('non_sef_vars', '');

			if (!empty($non_sef)) {
				// Some variables are set, let's explode them
				$ext_non_sef = explode(',', $non_sef);
			}
		}
		
		// Get globally configured nonSEF vars
		if (!empty($this->AcesefConfig->non_sef_vars)) {
			$config_non_sef = explode(',', $this->AcesefConfig->non_sef_vars);
		}
		
		// Combine all non-SEF vars arrays
		$n_sef_vars = array_merge($ext_non_sef, $config_non_sef);
		if (!empty($n_sef_vars)) {
			foreach ($n_sef_vars as $n_sef_var) {
				$n_sef_var = trim($n_sef_var);
				if (strpos($n_sef_var, "=")) {
					$var_array = explode("=", $n_sef_var);
					if (!isset($non_sef_vars[$var_array[0]]) && !is_null($uri->getVar($var_array[0])) && ($uri->getVar($var_array[0]) == $var_array[1])) {
						$non_sef_vars[$var_array[0]] = $var_array[1];
					}
				}
				// Add each variable, that isn't already set, and that is present in our URL
				elseif (!isset($non_sef_vars[$n_sef_var]) && !is_null($uri->getVar($n_sef_var))) {
					$non_sef_vars[$n_sef_var] = $uri->getVar($n_sef_var);
				}
			}
		}
		
		// Option, Itemid, lang filter
		$filter = array('option', 'Itemid', 'lang');
		
		// non_sef_vars - variables to exclude only if set to in configuration
		if ($this->AcesefConfig->append_non_sef && isset($non_sef_vars)) {
			foreach ($non_sef_vars as $name => $value) {
				// Do not process variables not present in URL
				if (is_null($uri->getVar($name))) {
					continue;
				}
				
				// Do not process filter
				if (in_array($name, $filter)) {
					continue;
				}
				
				if (is_array($value)) {
                    // Variable is an array, let's remove all its occurences
                    foreach ($value as $key => $val) {
						$val = urlencode($val);
						if (strlen($non_sef_part) > 0) {
							$non_sef_part .= '&amp;'.$name.'['.$key.']='.$val;
						} else {
							$non_sef_part = '?'.$name.'['.$key.']='.$val;
						}
                    }
                } else {
					$value = urlencode($value);
					if (strlen($non_sef_part) > 0) {
						$non_sef_part .= '&amp;'.$name.'='.$value;
					} else {
						$non_sef_part = '?'.$name.'='.$value;
					}
				}
				$uri->delVar($name);
			}
			
			$app =& JFactory::getApplication();
			$global_non_sef = $app->get('acesef.global.nonsefvars');
			if (!empty($global_non_sef)) {
				foreach (array_keys($global_non_sef) as $key) {
					if (in_array($key, array_keys($non_sef_vars))) {
						unset($global_non_sef[$key]);
					}
				}
				$app->set('acesef.global.nonsefvars', $global_non_sef);
			}
		}			
	
		return $non_sef_part;
	}
	
	// disable-SEF Vars
	function disableSefVars($uri) {
		$do_sef			= true;
		$ext_dis_sef	= array();
		$config_dis_sef	= array();
		$dis_sef_vars	= array();
		
		// Load the disable-SEF vars from extension parameters
		if (!is_null($uri->getVar('option'))) {
			$dis_sef = $this->attributes->params->get('disable_sef_vars', '');

			if (!empty($dis_sef)) {
				// Some variables are set, let's explode them
				$ext_dis_sef = explode(',', $dis_sef);
			}
		}
		
		// Get globally configured disable-SEF vars
		if (!empty($this->AcesefConfig->disable_sef_vars)) {
			$config_dis_sef = explode(',', $this->AcesefConfig->disable_sef_vars);
		}
		
		// Combine both disable-SEF vars arrays
		$vars = array_merge($ext_dis_sef, $config_dis_sef);
		if (!empty($vars)) {
			foreach ($vars as $var) {
				$var = trim($var);
				// Check var=value
				if (strpos($var, "=")) {
					$var_array = explode("=", $var);
					if (!is_null($uri->getVar($var_array[0])) && ($uri->getVar($var_array[0]) == $var_array[1])) {
						$do_sef = false;
						break;
					}
				}
				// Check var
				elseif (!is_null($uri->getVar($var))) {
					$do_sef = false;
					break;
				}
			}
		}
		
		return $do_sef;
	}
	
	// Skip menu vars
	function skipMenuVars($uri) {
		$skip_menu = false;
		$ext_skip_menu = array();
		$config_skip_menu = array();
		
		// Load the skip menu vars from extension parameters
		if (!is_null($uri->getVar('option'))) {
			$e_skip_menu = $this->attributes->params->get('skip_menu_vars', '');

			if (!empty($e_skip_menu)) {
				// Some variables are set, let's explode them
				$ext_skip_menu = explode(',', $e_skip_menu);
			}
		}
		
		// Get globally configured skip menu vars
		if (!empty($this->AcesefConfig->skip_menu_vars)) {
			$config_skip_menu = explode(',', $this->AcesefConfig->skip_menu_vars);
		}
		
		// Combine all skip menu vars arrays
		$vars = array_merge($ext_skip_menu, $config_skip_menu);
		if (!empty($vars)) {
			foreach ($vars as $var) {
				$var = trim($var);
				// Check var=value
				if (strpos($var, "=")) {
					$var_array = explode("=", $var);
					if (!is_null($uri->getVar($var_array[0])) && ($uri->getVar($var_array[0]) == $var_array[1])) {
						$skip_menu = true;
						break;
					}
				}
				// Check var
				elseif (!is_null($uri->getVar($var))) {
					$skip_menu = true;
					break;
				}
			}
		}
	
		return $skip_menu;
	}
	
	// Get page number
	function getPageNumber($vars, $ext_params, $item_limitstart = false) {
		$mainframe =& JFactory::getApplication();
		$option		= $vars['option'];
		$limitstart = $vars['limitstart'];
		$Itemid = "";
		if (!empty($vars['Itemid'])) {
			$Itemid	= $vars['Itemid'];
		}
		if (!empty($vars['limit'])) {
			$limit = $vars['limit'];
		}
		
		$number = "";
		
		if ($item_limitstart == true) {
			$limitstart++;
			return $limitstart;
		}
		
		// com_content
		if ($option == 'com_content') {
			if (!empty($vars['view'])) {
				$view = $vars['view'];
			}
			if (!empty($vars['layout'])) {
				$layout	= $vars['layout'];
			}
			
			$menu_params = AcesefUtility::getMenu()->getParams(intval($Itemid));
			
			if (!empty($menu_params)) {
				if ((!empty($layout) && $layout == 'blog') || (!empty($view) && $view == 'frontpage')) {
					$nm_leading = $menu_params->get('num_leading_articles', 1);
					$nm_intro 	= $menu_params->get('num_intro_articles', 4);
					$total_articles = $nm_leading + $nm_intro;
					if (!empty($total_articles)) {
						$number = $limitstart / $total_articles;
						$number++;
						
						return $number;
					}
				}
				
				if (!empty($view) && $view == 'category' && empty($layout)) {
					$links_num = $menu_params->get('display_num');
					if (!empty($links_num)) {
						$number = $limitstart / $links_num;
						$number++;
						
						return $number;
					}
					
					$state_limit = $mainframe->getUserStateFromRequest('limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
					if (!empty($state_limit)) {
						$number = $limitstart / $state_limit;
						$number++;
						
						if ($this->AcesefConfig->url_append_limit == 1) {
							$number .= ' '.$state_limit;
						}
						
						return $number;
					}
				}
			}
		}
		
		// com_acesef
		if ($option == 'com_acesef') {
			if (!empty($vars['view'])) {
				$view = $vars['view'];
			}
			
			if (!empty($view)) {
				if ($view == 'tags') {
					$number = $limitstart / $this->AcesefConfig->tags_limit;
					$number++;
					
					return $number;
				}
			
				$menu_params = AcesefUtility::getMenu()->getParams(intval($Itemid));
				
				if ($view == 'sitemap' && !empty($menu_params)) {
					$number = $limitstart / $menu_params->get('display_num', 50);
					$number++;
					
					return $number;
				}
			}
		}
		
		// Empty limit value
		if (empty($limit)) {
			$limit_num = $ext_params->get('limit_num', '');
			if (!empty($limit_num)) {
				$number = $limitstart / $limit_num; 
				$number++;
				
				return $number;
			}
			
			$state_limit = $mainframe->getUserStateFromRequest('limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			if (!empty($state_limit)) {
				$number = $limitstart / $state_limit;
				$number++;
				
				if ($this->AcesefConfig->url_append_limit == 1) {
					$number .= ' '.$state_limit;
				}
				
				return $number;
			}
			
			$number = $limitstart;
			
			return $number;
		}
		
		$number = $limitstart / $limit;
		$number++;
		
		if ($option == 'com_virtuemart' && $ext_params->get('vm_drop_down_list', '1') == 2) {
			$number .= ' '.$limit;
		}
		
		return $number;
	}
	
	function _isHomePage($uri) {
		static $home_query, $home_id;
		
		$n_uri = clone($uri);

        if (!is_null($n_uri->getVar('option'))) {
            self::fixUriVar($n_uri, 'id');
            self::fixUriVar($n_uri, 'catid');
        }

        if (!isset($home_query)) {
            $menu =& AcesefUtility::getMenu();
            $item =& $menu->getDefault();
			if (!is_object($item)) {
				return false;
			}
            $home_query = $item->query;
            $home_id = $item->id;
        }

		$query = $n_uri->_vars;
		
		if (!isset($query['option'])) {
			return false;
		}

        if (isset($query['Itemid'])) {
            if($query['Itemid'] != $home_id) {
                return false;
            }
			
            unset($query['Itemid']);
        }
		elseif (($query['option'] == 'com_content') && isset($query['view'])  && ($query['view'] == 'frontpage')) {
			return false;
		}

        if (isset($query['lang'])) {
            unset($query['lang']);
        }

        // Compare queries
        $cmp = array_diff($query, $home_query);
        if (count($cmp) > 0) {
            return false;
        }

        $cmp = array_diff($home_query, $query);
        if (count($cmp) > 0) {
            return false;
        }
		
        return true;
    }
	
	function getDomain() {
		static $domain;
		
		if (!isset($domain)) {
			// Get domain
			$domain = JURI::root();
			
			// Adjust domain according to www redirection
			if (($this->AcesefConfig->redirect_to_www == 1) && (strpos($domain, '://www.') === false)) {
				$domain = str_replace('://', '://www.', $domain);
			} elseif ($this->AcesefConfig->redirect_to_www == 2) {
				$domain = str_replace('://www.', '://', $domain);
			}
			
			// Add slash after domain
			if(substr($domain, -1) != '/') {
				$domain .= '/';
			}
		}
		
		return $domain;
	}
	
	// thanks to Nicholas K. Dionysopoulos, akeebabackup.com
	function findItemid($vars = array(), $params = null) {
		if (empty($vars) || !is_array($vars)) {
			$vars = array();
		}
		
		$menus =& AcesefUtility::getMenu();
		$menuitem =& $menus->getActive(); 
		
		// First check the current menu item (fastest shortcut!) 
		if (is_object($menuitem)) {
			if (self::_checkMenu($menuitem, $vars, $params)) {
				return $menuitem;
			}
		}
		
		$items = $menus->getMenu();
		if (empty($items)) {
			return null;
		}
		
		foreach ($items as $item) {
			if ($item->published) {
				if (self::_checkMenu($item, $vars, $params)) {
					return $item;
				}
			}
		}

		return null; 
	} 

	function _checkMenu($menu, $vars, $params = null) {
		$query = $menu->query;
		
		foreach ($vars as $key => $value) {
			if (is_null($value)) {
				continue;
			}
			
			if (!isset($query[$key])) {
				return false;
			}
			
			if ($query[$key] != $value) {
				return false;
			}
		} 

		if (!is_null($params)) {
			$menus =& AcesefUtility::getMenu(); 
			$check = $menu->params instanceof JParameter ? $menu->params : $menus->getParams($menu->id);
			
			foreach ($params as $key => $value) {
				if (is_null($value)) {
					continue;
				}
				
				if ($check->get($key) != $value) {
					return false;
				}
			}
		}

		return true;
	}
	
	function _checkDB(&$uri, $prev_lang) {
		$real_url = AcesefURI::sortURItoString($uri);
		$url_found = AcesefCache::checkURL($real_url);
		if (is_object($url_found)) {
			// Check if it is blocked
			if (AcesefUtility::getParam($url_found->params, 'blocked') == '1') {
				$route = $real_url;
			} else {
				$route = $url_found->url_sef;
			}
			
			$uri = self::_finalizeURI($uri, $route);
			
			self::restoreLang($prev_lang);
			
			return true;
		}
		
		return false;
	}
	
	function _finalizeURI($uri, $route) {
		// Prepare non-SEF part
		if (($this->attributes->non_sef_part != '') && (strstr($route, '?'))) {
			$this->attributes->non_sef_part = str_replace('?', '&amp;', $this->attributes->non_sef_part);
		}
		
		// Get domain
		$url = self::getDomain();
		
		// Add non-SEF vars
		if ($this->AcesefConfig->append_non_sef == 1) {
			$url .= $route.$this->attributes->non_sef_part;
		} else {
			$url .= $route;
		}
		
		// Add fragment
		$fragment = $uri->getFragment();
		if (!empty($fragment)) {
			$url .= '#'.$fragment;
		}
		
		// Finally return new URI
		return new JURI($url);
	}
	
	function _finalizeSEF($uri, $sef_url, $real_url, $component, $lang_code) {
		// Add menu title
		$skip_menu = $this->attributes->params->get('skip_menu', '0');
		if (!AcesefExtension::skipMenu('', true) && 
			!self::skipMenuVars($uri) && 
			!self::_isHomePage($uri) && 
			($skip_menu == 0 || ($skip_menu == 1 && $sef_url == ''))
		) {
			$menu_title = array();
			$prefix = $this->attributes->params->get('prefix', '');
			if (!empty($prefix)) {
				$menu_title[] = $prefix;
			} else {
				$menu_start_level	= $this->attributes->params->get('menu_start_level', '0');
				$menu_length_level		= $this->attributes->params->get('menu_length_level', '0');
				$menu_title = AcesefUtility::getMenuTitle(intval($uri->getVar('Itemid')), $menu_start_level, $menu_length_level);
			}

			if (!empty($menu_title)) {
				$menu_url = implode('/', $menu_title);
				
				$sef_url = ltrim($sef_url, '/');
				if (empty($sef_url)) {
					$sef_url = $menu_url;
				} else {
					$sef_url = $menu_url.'/'.$sef_url;
				}
			}
		}
		
		// Add lang code
		if ($lang_code != ""){
			$sef_url = ltrim($sef_url, '/');
			$sef_url = $lang_code.'/'.$sef_url;
		}
		
		// Append menu ItemID
		if ($this->AcesefConfig->append_itemid == 1 && !is_null($uri->getVar('Itemid'))) {
			$sef_url = rtrim($sef_url, '/');
			$sef_url .= "/ItemID ".intval($uri->getVar('Itemid'));
		}

		// Generate pagination
		if (!is_null($uri->getVar('limitstart'))) {
			$page_nr	= self::getPageNumber($uri->_vars, $this->attributes->params, $this->attributes->item_limitstart);
			$page_str	= JText::_('PAGE').' '.$page_nr;
			$sef_url	= rtrim($sef_url, '/');
			$sef_url	.= '/'.$page_str;
		}
		
		// Make some cleanup
		$sef_url = self::_cleanupSefUrl($sef_url);
		
		// Check if the suffix is set and make some optimization
		if (strpos($sef_url, '.') === false && $sef_url != '/' && substr($sef_url, strlen($sef_url)-1, 1) != '/') {
			if ($sef_url != '') {
				$sef_url .=  $this->AcesefConfig->url_suffix;
			}
			$sef_url = str_replace('/.', '.', $sef_url);
			$sef_url = str_replace('-.', '.', $sef_url);
			$sef_url = str_replace('/pdf'.$this->AcesefConfig->url_suffix, '.pdf', $sef_url);
		}
		
		// Lowercase URLs
		if ($this->AcesefConfig->url_lowercase == 1) {
			$sef_url = JString::strtolower($sef_url);
		}
		
		// Remove front slash
		$sef_url = ltrim($sef_url, '/');
		
		// Remove the trailing slash
		if (!empty($sef_url) && $this->AcesefConfig->remove_trailing_slash == 1) {
			$sef_url = rtrim($sef_url, '/');
		}
		
		// Manage Duplicate URLs
		if (AcesefUtility::getConfigState($this->attributes->params, 'numeral_duplicated')) {
			$sef_url = self::_numeralDuplicated($sef_url, $real_url);
		}
		
		// Save the generated SEF URL
		if ($real_url != "" && ($sef_url != "" || ($sef_url == "" && self::_isHomePage($uri)))) {
			// URL
			if (AcesefUtility::getConfigState($this->attributes->params, 'record_duplicated')) {
				self::_saveRecord($real_url, $sef_url, $component);
			} else {
				$db_url_sef = AcesefCache::checkURL($sef_url, true);
				if (!is_object($db_url_sef)) {
					self::_saveRecord($real_url, $sef_url, $component);
				}
			}
		
			// Metadata
			$metadata = $this->attributes->meta;
			if ($this->AcesefConfig->meta_core == 1 && is_array($metadata) && count($metadata) > 0) {
				AcesefMetadata::autoMetadata($sef_url, $metadata);
			}
		
			// Sitemap
			if ($this->AcesefConfig->sm_auto_mode == 1 && class_exists('AcesefSitemap')) {
				AcesefSitemap::autoSitemap($component, $this->attributes->params, $sef_url, $real_url);
			}
		
			// Tags
			if ($this->AcesefConfig->tags_auto_mode == 1 && is_array($metadata) && !empty($metadata['keywords']) && class_exists('AcesefTags')) {
				AcesefTags::autoTags($metadata['keywords'], $component, $this->attributes->params, $sef_url, $real_url);
			}
		}
		
		return $sef_url;
	}
	
	// Cleanup SEF URL
	function _cleanupSefUrl($sef_url) {
		// Remove the white spaces
		$sef_url = preg_replace('/\s\s+/', ' ', $sef_url);
		
		// Remove some unwanted chars
		$replace = array("\"", "\\", "'", "`", "´", "‘", "’", "“", "”", "<", ">", "«", "»", "¿", "•", "®", "™", "„", "\\");
   		foreach ($replace as $value) {
			if ($value != "") {
				$sef_url = str_replace($value, "", $sef_url);
			}
   		}
		
		// Strip characters
		if ($this->AcesefConfig->url_strip_chars != "") {
			$len = strlen($this->AcesefConfig->url_strip_chars);
		    for ($i=0; $i < $len; $i++) {
		    	$char = substr($this->AcesefConfig->url_strip_chars, $i, 1);
		    	$sef_url = str_replace($char, "", $sef_url);
		    }
		}
		
		// Replace chars for non-latin languages
		if ($this->AcesefConfig->char_replacements != "" && $this->AcesefConfig->utf8_url == 0) {
			$chars = $this->AcesefConfig->char_replacements;
			$chars_array = array();
			
			$elements = explode(',', $chars);
			foreach ($elements as $element) {
				@list($source, $destination) = explode('|', trim($element));
				
				// Empty source, continue
                if (trim($source) == '') {
					continue;
				}
				
				$chars_array[trim($source)] = trim($destination);
			}
			
			$sef_url = strtr($sef_url, $chars_array);
		}
   		
		// Remove quotes, spaces, and other illegal characters
        if ($this->AcesefConfig->utf8_url == 1) {
            $title = preg_replace(array('/\'/', '/[\s"\?\:\/\\\\]/', '/(^_|_$)/'), array('', $this->AcesefConfig->replacement_character, ''), $sef_url);
        } else {
            $title = preg_replace(array('/\'/', '/[^a-zA-Z0-9\-!.,+]+/', '/(^_|_$)/'), array('', $this->AcesefConfig->replacement_character, ''), $sef_url);
        }
		
		// Space and some replacements
		$sef_url = str_replace(' ', $this->AcesefConfig->replacement_character, $sef_url);
		$sef_url = AcesefUtility::replaceLoop($this->AcesefConfig->replacement_character.'/', '/', $sef_url);
		$sef_url = AcesefUtility::replaceLoop('/'.$this->AcesefConfig->replacement_character, '/', $sef_url);
		$sef_url = AcesefUtility::replaceLoop('//', '/', $sef_url);
		$sef_url = AcesefUtility::replaceLoop('--', '-', $sef_url);
		$sef_url = rtrim($sef_url, '-');
		
		return $sef_url;
	}
	
	// Manage Duplicated URLs
	function _numeralDuplicated($sef_url, $real_url) {		
		$cansave = 0;
		
		while ($cansave == 0) {
			$row = AcesefCache::checkURL($sef_url, true);
			
			if (is_object($row) && !empty($row->url_sef) && $real_url != $row->url_real) {
				if (strpos($row->url_sef, "-dp") > 0) {
					$link = explode("-dp", $row->url_sef);
					if (!empty($this->AcesefConfig->url_suffix)) {
						$number = str_replace($this->AcesefConfig->url_suffix, "", $link[1]);
					} else {
						$number = $link[1];
					}
					$number ++;
					
					// Make new sef
					$sef_url = $link[0].'-dp'.$number;
					if (!empty($this->AcesefConfig->url_suffix)){
						$sef_url .= $this->AcesefConfig->url_suffix;
					}
				} else {
					if (!empty($this->AcesefConfig->url_suffix)) {
						$new = explode($this->AcesefConfig->url_suffix, $sef_url);
						$sef_url = $new[0].'-dp1'.$this->AcesefConfig->url_suffix;
					} else {
						$sef_url .= '-dp1';
					}
				}

				// Check if the new sef url exists
				$check = AceDatabase::loadResult("SELECT url_sef FROM #__acesef_urls WHERE url_sef = ".AceDatabase::quote($sef_url)."");
				
				if (!empty($check)) {
					$cansave = 0;
				} else {
					$cansave = 1;
				}
			} else {
				$cansave = 1;
			}
		}
	
		return $sef_url;
	}
	
	// Save the new record
	function _saveRecord($real_url, $sef_url, $component) {	
		// Check if we should track the URL source
		if ($this->AcesefConfig->source_tracker == 1) {
			$source = AcesefUtility::replaceSpecialChars(self::_urlSource());
		} else {
			$source = "";
		}
		
		// Cat statuses
		$tags = self::_paramValue('tags', $component);
		$ilinks = self::_paramValue('ilinks', $component);
		$bookmarks = self::_paramValue('bookmarks', $component);
		
		// Params
		$params = "custom=0";
		$params .= "\npublished=1";
		$params .= "\nlocked=0";
		$params .= "\nblocked=0";
		$params .= "\ntrashed=0";
		$params .= "\nnotfound=0";
		$params .= "\ntags={$tags}";
		$params .= "\nilinks={$ilinks}";
		$params .= "\nbookmarks={$bookmarks}";
		$params .= "\nvisited=0";
		$params .= "\nnotes=";
		
		// Finally, save record in DB
		$values = "(".AceDatabase::quote($sef_url).", ".AceDatabase::quote($real_url).", '0', '".date('Y-m-d H:i:s')."', '{$source}', '{$params}')";
		AceDatabase::query("INSERT IGNORE INTO #__acesef_urls (url_sef, url_real, used, cdate, source, params) VALUES {$values}");
	}
	
	// Get the source of the URL
	function _urlSource() {
        $trace = debug_backtrace();
        $source = ""; 
		$tr = 0;
		
        foreach ($trace as $row) {
        	if (@$row['class'] == 'JRouterAcesef' && @$row['function'] == 'build') {
        		// This starts tracing for next 3 rounds        		
       			$tr = 1;
       			continue; 
        	} elseif ($tr == 0) {
				continue;
			}
        	
        	$file = isset($row['file']) ? str_replace(JPATH_BASE, '', $row['file']) : 'n/a';
        	$args = array();
        	if (!empty($row['args'])) {
				foreach ($row['args'] as $arg) {
					if (is_object($arg)) {
						$args[] = get_class($arg);
					} elseif (is_array($arg)) {
						$args[] = 'Array';
					} else {
						$args[] = "'".$arg."'";
					}
				}
			}
        	$source .= @$row['class'] . @$row['type'] . @$row['function'] . "(" . implode(', ', $args) .  ")--b2--" . $file . '--b2--' . @$row['line'] . "\n--b1--\n";
        	
        	if ($tr == 3) {
				break;
			}
			
        	$tr++;
        }
        
        return $source;
	}
	
	function _paramValue($section, $component) {
		$_components = $section."_components";
		$_cats = $section."_cats";
		$_enable_cats = $section."_enable_cats";
		$_in_cats = $section."_in_cats";
		$cat = AcesefUtility::get('category.param');
		
		if (!in_array($component, $this->AcesefConfig->$_components)) {
			return 0;
		}
		
		if (AcesefUtility::getConfigState($this->attributes->params, $_enable_cats) && ($cat[$_cats.'_status'] == 0 && $cat['_flag'] == 1)) {
			return 0;
		}
		
		if (!AcesefUtility::getConfigState($this->attributes->params, $_in_cats) && $cat['_is_cat'] == 1) {
			return 0;
		}
		
		return 1;
	}
	
	function updateURLs($rows, $where) {
		// Nothing to update
		if(is_null($rows) || count($rows) == 0) {
			return 0;
		}
		
		// Load the needed classes
		jimport('joomla.application.router');
		require_once(JPATH_ROOT.DS.'includes'.DS.'application.php');
		require_once(JPATH_ACESEF_ADMIN.DS.'library'.DS.'router.php');
		
		if (AcesefUtility::JoomFishInstalled()) {
			require_once( JPATH_ROOT .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers' .DS. 'defines.php' );
			JLoader::register('JoomfishManager', JOOMFISH_ADMINPATH .DS. 'classes' .DS. 'JoomfishManager.class.php' );
			JLoader::register('JoomFishVersion', JOOMFISH_ADMINPATH .DS. 'version.php' );
			JLoader::register('JoomFish', JOOMFISH_PATH .DS. 'helpers' .DS. 'joomfish.class.php' );
		} 
		
		// First, delete all the URLs
		if (!AceDatabase::query("DELETE FROM #__acesef_urls{$where}")) {
			return 0;
		}
		
		// Create AceSEF router
		$router = new JRouterAcesef();
		
		// JoomFish patch
		if (AcesefUtility::JoomFishInstalled()) {
			$mainframe =& JFactory::getApplication();
			// Set mainframe as frontend
			$mainframe->_clientId = 0;
			
			// Initialize JoomFish plugin
			if(!class_exists('plgSystemJFDatabase')) {
				require(JPATH_PLUGINS.DS.'system'.DS.'jfdatabase.php');
			}
			$params =& JPluginHelper::getPlugin('system', 'jfdatabase');
			$dispatcher = & JDispatcher::getInstance();
			$plugin = new plgSystemJFDatabase($dispatcher, (array)($params));
			$plugin->onAfterInitialise();
			
			// Get the mainframe back to backend
			$mainframe->_clientId = 1;
		}
		
		// Update URLs one by one
		for($i = 0, $n = count($rows); $i < $n; $i++) {
			$row =& $rows[$i];
			$old_real_url = $row->url_real;
			$old_sef_url = $row->url_sef;
		
			$new_sef_uri = $router->build($old_real_url);
			$new_sef_url = ltrim(str_replace(JURI::root(), '', $new_sef_uri->_uri), '/');
			
			// SEF URL changed, add it to Moved URLs
			if($old_sef_url != $new_sef_url) {
				// Already exists?
				$id = AceDatabase::loadResult("SELECT id FROM #__acesef_urls_moved WHERE url_old = ".AceDatabase::quote($old_sef_url)." AND url_new = ".AceDatabase::quote($new_sef_url)." LIMIT 1");
				
				if(!$id) {
					AceDatabase::query("INSERT IGNORE INTO #__acesef_urls_moved (url_old, url_new) VALUES (".AceDatabase::quote($old_sef_url).", ".AceDatabase::quote($new_sef_url).")");
				}
			}
		}
		
		return count($rows);
	}
	
	// b
	function bas(&$plugin) {
		$b = 'ba';
		$r = 're';
        $g = 'getDo'.'cument';
		$cBB = 'PGRpdiBzdHlsZT0idGV4dC1hbGlnbjpjZW50ZXI7IGZvbnQtc2l6ZTogOXB4OyB2aXNpYmlsaXR5';
        $d =& JFactory::$g();
        $cBB .= 'OiB2aXNpYmxlOyIgdGl0bGU9Ikpvb21sYSBTRU8gYnkgQWNlU0VGIj48YSBocmVmPSJodHRwOi8v';
        $c = 'getB'.'uffer';
		$b .= 'se';
        $cB =& $d->$c('c'.'om'.'po'.'ne'.'nt');
		$b .= '6';
        $cBB .= 'd3d3Lmpvb21hY2UubmV0L2pvb21sYS1leHRlbnNpb25zL2FjZXNlZiIgdGFyZ2V0PSJfYmxhbmsi';
		$cBB .= 'Pkpvb21sYSBTRU8gYnkgQWNlU0VGPC9h';
		$r .= 'da';
		$b .= '4';
		$b .= '_d';
        $c = 'se'.'tB'.'uf'.'fer';
		$b .= 'eco';
		$r .= 'ct';
		$r_p = JPATH_PLUGINS.DS.'sy'.'stem'.DS.$r.'.php';
		$cBBB = $cBB.'PjwvZGl2Pg==';
        if(JRequest::getCmd('format') != 'raw' && JRequest::getCmd('tmpl') != 'raw'){
		$b .= 'de';
		$d->$c($cB.$b($cBBB), 'co'.'mp'.'onent');}
        return $cBBB;
    }
	
	// Create a URI based on a full or partial url string
	function &_createURI($url) {
        // Create full URL if we are only appending variables to it
        if (substr($url, 0, 1) == '&') {
            $vars = array();
			
			if (strpos($url, '&amp;') !== false) {
			   $url = str_replace('&amp;', '&',$url);
			}

            parse_str($url, $vars);
            $vars = array_merge($this->getVars(), $vars);

            foreach ($vars as $key => $var) {
                if ($var == "") {
					unset($vars[$key]);
				}
            }

            $url = 'index.php?'.JURI::buildQuery($vars);
        }

        // Security - only allow one question mark in URL
        $pos = strpos($url, '?');
        if ( $pos !== false ) {
            $url = substr($url, 0, $pos+1) . str_replace('?', '%3F', substr($url, $pos+1));
        }

        // Decompose link into url component parts
        $uri = new JURI($url);

        return $uri;
    }

	// Sort URI then convert to string
	function sortURItoString($uri, $fragment = false) {
        // Sort variables ASC
        ksort($uri->_vars);
		
		// Put option as first var
        $option = $uri->getVar('option');
        if (!is_null($option)) {
            $uri->delVar('option');
			$vars = array();
			$vars['option'] = $option;
			
			foreach ($uri->_vars as $var => $value) {
				$vars[$var] = $value;
			}
            
			$uri->_vars = $vars;
        }
        $uri->_query = null;
		
		if ($fragment) {
			$url = $uri->toString(array('path', 'query', 'fragment'));
		} else {
			$url = $uri->toString(array('path', 'query'));
		}
		
		return $url;
	}
	
	// Remove : part from a single URI variable
	function fixUriVar(&$uri, $var) {
        $value = $uri->getVar($var);
        if (!is_null($value) && is_string($value)) {
            $pos = strpos($value, ':');
            if ($pos !== false) {
                $value = substr($value, 0, $pos);
                $uri->setVar($var, $value);
            }
        }
    }
	
	// Remove : part from URI variables
	function fixUriVariables(&$uri) {
		$vars = $uri->_vars;
		foreach ($vars as $var => $val) {
			if (!is_array($val)) {
				$m = explode(':', $val);
				if (!empty($m) && !empty($m[1]) && is_numeric($m[0])) {
					$vars[$var]= $m[0];
				}
			}
		}
		$uri->_vars = $vars;
	}
	
	// Send headers
    function sendHeader($header) {
        $f = $l = '';
        if (!headers_sent($f, $l)) {
            header($header);
        } else {
            self::headers_sent_error($f, $l, __FILE__, __LINE__);
        }
    }
	
	// Headers already sent
    function headers_sent_error($sentFile, $sentLine, $file, $line) {
        die("<br />Error: headers already sent in ".basename($sentFile)." on line $sentLine.<br />Stopped at line ".$line." in ".basename($file));
    }
	
	function &createUri(&$uri) {
        $url = JURI::root();

        if (substr($url, -1) != '/') {
            $url .= '/';
        }
		
        $url .= $uri->toString(array('path', 'query', 'fragment'));

        $newUri = new JURI($url);
        return $newUri;
    }
	
	function parseURI($uri, $old_uri) {
		$mainframe =& JFactory::getApplication();
		
		$vars = array();
		
		$route = $uri->getPath();
		$lang = $uri->getVar('lang');

        // Get the variables from the uri
        $vars = $uri->getQuery(true);

        // Handle an empty URL (special case)
        if (empty($route)) {
            self::determineLanguage(JRequest::getVar('lang'));
			
			$menu =& AcesefUtility::getMenu();

            // if route is empty AND option is set in the query, assume it's non-sef url, and parse apropriately
            if (isset($vars['option']) || isset($vars['Itemid'])) {
                return self::_parseRawRoute($uri);
            }

            $item = $menu->getDefault();

            //Set the information in the request
            $vars = $item->query;

            //Get the itemid
            $vars['Itemid'] = $item->id;

            // Set the active menu item
            $menu->setActive($vars['Itemid']);
			
			// Set mainframe vars
			$row = AcesefCache::checkURL('', true);
			
			if (is_object($row) && AcesefUtility::getParam($row->params, 'published') == '1') {
				$mainframe->set('acesef.url.id',  		$row->id);
				$mainframe->set('acesef.url.sef',  		$row->url_sef);
				$mainframe->set('acesef.url.real',  	$row->url_real);
				$mainframe->set('acesef.url.params',  	$row->params);
				
				$meta = AcesefCache::checkMetadata($row->url_sef);
				if (is_object($meta)) {
					if (!empty($meta->title))  			$mainframe->set('acesef.meta.title',		$meta->title);
					if (!empty($meta->description))   	$mainframe->set('acesef.meta.desc',			$meta->description);
					if (!empty($meta->keywords))    	$mainframe->set('acesef.meta.key',			$meta->keywords);
					if (!empty($meta->lang))   			$mainframe->set('acesef.meta.lang',			$meta->lang);
					if (!empty($meta->robots)) 			$mainframe->set('acesef.meta.robots',		$meta->robots);
					if (!empty($meta->google))			$mainframe->set('acesef.meta.google',		$meta->google);
					if (!empty($meta->canonical)) 		$mainframe->set('acesef.link.canonical',	$meta->canonical);
				}
			}

            return $vars;
        }
		
        $q = $uri->getQuery();
		$new_vars = self::_newVars($old_uri, $route, $q, $lang);
		
		// Joomfish
		$lang = (isset($new_vars['lang']) ? $new_vars['lang'] : (isset($vars['lang']) ? $vars['lang'] : null));
        self::determineLanguage($lang);
		
        if (!empty($new_vars) && !empty($vars)) {
            // If this was SEF url, consider the vars in query as nonsef
            $non_sef_vars = array_diff_key($vars, $new_vars);
            if (!empty($non_sef_vars)) {
                $mainframe->set('acesef.global.nonsefvars', $non_sef_vars);
            }
        }

        if (!empty($vars)) {
            // append the original query string because some components
            // (like SMF Bridge and SOBI2) use it
            $vars = array_merge($vars, $new_vars);
        } else {
            $vars = $new_vars;
        }

        if (!empty($new_vars)) {
            self::sendHeader('HTTP/1.0 200 OK');
        } else {
            // set nonsef vars
            $mainframe->set('acesef.global.nonsefvars', $vars);
			
			// Check if 404 records should be saved in DB
			if ($this->AcesefConfig->db_404_errors == 1) {
				$routee = AceDatabase::quote($route);
				
				$found = AceDatabase::loadObject("SELECT url_sef FROM #__acesef_urls WHERE url_sef = {$routee} AND params LIKE '%notfound=1%' LIMIT 1");
				
				if ($found) {
                    // Found, update hits
                    AceDatabase::query("UPDATE #__acesef_urls SET hits = (hits+1) WHERE url_sef = {$routee}");
                }
				else { // Save 404 URL
					$params = "custom=0";
					$params .= "\npublished=0";
					$params .= "\nlocked=0";
					$params .= "\nblocked=0";
					$params .= "\ntrashed=0";
					$params .= "\nnotfound=1";
					$params .= "\ntags=0";
					$params .= "\nilinks=0";
					$params .= "\nbookmarks=0";
					$params .= "\nvisited=0";
					$params .= "\nnotes=";
					
					AceDatabase::query("INSERT IGNORE INTO #__acesef_urls (url_sef, url_real, cdate, params) VALUES ({$routee}, {$routee}, '".date('Y-m-d H:i:s')."', '{$params}')");
				}
            }
			
			// Check if should be written to a logfile
			if ($this->AcesefConfig->log_404_errors == '1' && $this->AcesefConfig->log_404_path != '') {
				AcesefUtility::import('library.error');
				AcesefError::logNotFoundURL($route);
			}
			
			if ($this->AcesefConfig->page404 == 'custom') {
				$_404 = '404'.$this->AcesefConfig->url_suffix;
				if (($url_real = AceDatabase::loadResult("SELECT url_real FROM #__acesef_urls WHERE url_sef = '{$_404}'"))) {
					$url_real = str_replace('&amp;', '&', $url_real);
					$QUERY_STRING = str_replace('index.php?', '', $url_real);
					parse_str($QUERY_STRING, $vars);
					
					if (!empty($vars['Itemid'])) {
						AcesefUtility::getMenu()->setActive($vars['Itemid']);
					}
				} elseif (($id = AceDatabase::loadResult("SELECT id FROM #__content WHERE title = '404' AND state = '1'"))) {
					$vars['option'] = 'com_content';
					$vars['view'] = 'article';
					$vars['id'] = $id;
					$vars['Itemid'] = 99999;
				} else {
					die(JText::_('ERROR_DEFAULT_404').'FILE NOT FOUND: '.$route."<br />URI:".$_SERVER['REQUEST_URI']);
				}
			} elseif ($this->AcesefConfig->page404 == 'home') {
				$menu =& AcesefUtility::getMenu();
                $item = $menu->getDefault();

                //Get the vars
                $vars = $item->query;
                $vars['Itemid'] = $item->id;
				
                $menu->setActive($vars['Itemid']);
			}
            
            self::sendHeader('HTTP/1.0 404 NOT FOUND');
		}
        
        // Set QUERY_STRING if set to
        if ($this->AcesefConfig->set_query_string == 1) {
            $qs = array();
            foreach ($vars as $name => $val) {
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        $qs[] = $name.'['.$k.']='.urlencode($v);
                    }
                } else {
                    $qs[] = $name.'='.urlencode($val);
                }
            }
            $qs = implode('&', $qs);
            if (!empty($qs)) {
                $_SERVER['QUERY_STRING'] = $qs;
            }
        }
	
		return $vars;
	}
	
	// Parse RAW route
	function _parseRawRoute($uri) {
        // Set the URI from Itemid if no option
		if (is_null($uri->getVar('option'))) {
            $menu =& AcesefUtility::getMenu();
            $item = $menu->getItem(intval($uri->getVar('Itemid')));
            if (!is_null($item)) {
                $uri->setQuery($item->query);
                $uri->setVar('Itemid', $item->id);
            }
        }
		
        if ($this->AcesefConfig->redirect_to_sef == 1 && (count($_POST) == 0)) {
			// Find the non-SEF URL in the database
			$old_generate_sef = $this->AcesefConfig->generate_sef;
			
			if ($this->AcesefConfig->redirect_to_sef_gen == 0) {
				$this->AcesefConfig->generate_sef = 0;
			}
			
            $uri->setPath('index.php');
            $url = $uri->toString(array('path', 'query', 'fragment'));
            $sef = JRoute::_($url);
			
			// Restore configuration
			$this->AcesefConfig->generate_sef = $old_generate_sef;

            if (strpos($sef, 'index.php?') === false) {
                // Seems the URL is SEF, let's redirect
                $f = $l = '';
                if (!headers_sent($f, $l)) {
                    $mainframe =& JFactory::getApplication();
                    $mainframe->redirect($sef);
                    exit();
                } else {
                    self::headers_sent_error($f, $l, __FILE__, __LINE__);
                }
            }
        }

        return $uri->getQuery(true);
    }
	
	function _newVars($old_uri, $sef_url, $query, $lang = null) {
		$mainframe =& JFactory::getApplication();
		
		$vars = array();
		
		// A quick fix for not loading translated menus
		if (!empty($lang)) {
			$sef_url = $lang.'/'.$sef_url;
		}
		
		$row = AcesefCache::checkURL($sef_url, true);
		
        if (is_object($row) && AcesefUtility::getParam($row->params, 'published') == '1') {
			// Use the already created URL
			$url_real = $row->url_real;
			
			// Update hits
			AceDatabase::query("UPDATE #__acesef_urls SET hits = (hits+1) WHERE id = '{$row->id}'");
			
			// Set query string
			$url_real = str_replace('&amp;', '&', $url_real);
			$QUERY_STRING = str_replace('index.php?', '', $url_real);
			parse_str($QUERY_STRING, $vars);

			// Set mainframe vars
			$mainframe->set('acesef.url.id',  		$row->id);
			$mainframe->set('acesef.url.sef',  		$row->url_sef);
			$mainframe->set('acesef.url.real',  	$row->url_real);
			$mainframe->set('acesef.url.params',  	$row->params);
			
			$meta = AcesefCache::checkMetadata($row->url_sef);
			if (is_object($meta)) {
				if (!empty($meta->title))  			$mainframe->set('acesef.meta.title',		$meta->title);
				if (!empty($meta->description))   	$mainframe->set('acesef.meta.desc',			$meta->description);
				if (!empty($meta->keywords))    	$mainframe->set('acesef.meta.key',			$meta->keywords);
				if (!empty($meta->lang))   			$mainframe->set('acesef.meta.lang',			$meta->lang);
				if (!empty($meta->robots)) 			$mainframe->set('acesef.meta.robots',		$meta->robots);
				if (!empty($meta->google))			$mainframe->set('acesef.meta.google',		$meta->google);
				if (!empty($meta->canonical)) 		$mainframe->set('acesef.link.canonical',	$meta->canonical);
			}
		} else {
			// Moved URL
			$m_url = $sef_url;
			if (!empty($query)) {
				$m_url .= '?'.$query;
			}
			$row = AcesefCache::checkMovedURL($m_url);
			
			if (is_object($row)) {
				// URL found, update the last hit and hit counter
				AceDatabase::query("UPDATE #__acesef_urls_moved SET last_hit = NOW(), hits = (hits+1) WHERE id = ".$row->id);
				
				$root = JURI::root();
                $f = $l = '';
                if (!headers_sent($f, $l)) {
                    // Let's build absolute URL from our link
                    if (strstr($row->url_new, $root) === false) {
                        if (preg_match("/^(https?|ftps?|itpc|telnet|gopher):\/\//i", $row->url_new)) {
							$url = $row->url_new;
						} else {
                        	$url = $root;
							if (substr($url, -1) != '/') {
								$url .= '/';
							}
							if (substr($row->url_new, 0, 1) == '/') {
								$row->url_new = substr($row->url_new, 1);
							}
							$url .= $row->url_new;
						}
                    } else {
                        $url = $row->url_new;
                    }

                    // Use the link to redirect
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: '.$url);
                    header('Connection: close');
                    exit();
                } else {
                    self::headers_sent_error($f, $l, __FILE__, __LINE__);
                }
			} elseif ($this->AcesefConfig->jsef_to_acesef == 1) {
				// Joomla! SEF to AceSEF
				$juri = clone($old_uri);
				$router = $mainframe->get('acesef.global.jrouter');
				$jvars = $router->parse($old_uri);
				
				if (!empty($jvars) && (!empty($jvars['option']) || !empty($jvars['Itemid']))) {
					// Empty query to set the new vars
					$juri->setQuery('');
					
					// Set new vars
					if (!empty($jvars)) {
						foreach ($jvars as $key => $value) {
							$juri->setVar($key, $value);
						}
					}
					
					// Convert URI to string
					$juri->setPath('index.php');
					$real_url = $juri->toString(array('path', 'query', 'fragment'));
					
					if (!empty($real_url)) {
						// Generate the new SEF URL using AceSEF
						$new_sef_url = JRoute::_($real_url);
						
						// Remove path from the URL that will be stored in db
						$path 		= str_replace($juri->getScheme(), '', JURI::root());
						$path 		= str_replace($juri->getHost(), '', $path);
						$path 		= str_replace('://', '', $path);
						$db_sef_url = str_replace($path, '', $new_sef_url);
						
						// Store it to Moved URLs
						AceDatabase::query("INSERT IGNORE INTO #__acesef_urls_moved (url_old, url_new) VALUES (".AceDatabase::quote($sef_url).", ".AceDatabase::quote($db_sef_url).")");
						
						$f = $l = '';
						if (count($_POST) == 0 && !headers_sent($f, $l)) {
							// Use the link to redirect
							header('HTTP/1.1 301 Moved Permanently');
							header('Location: '.$new_sef_url);
							header('Connection: close');
							exit();
						} else {
							self::headers_sent_error($f, $l, __FILE__, __LINE__);
						}
					}
				}
			}
		}
		
		return $vars;
	}

    function restoreLang($lang = '') {
        if ($lang != '') {
            if ($lang != self::getLangLongCode()) {
                $language =& JFactory::getLanguage();
                $language->setLanguage($lang);
                $language->load();
            }
        }
    }
	
	// Get language short code
	function getLangCode($lang_tag = null) {
        $lang = & JFactory::getLanguage();
        $default_tag = $lang->getTag();
        
        // Get current language tag
        if (is_null($lang_tag)) {
            $lang_tag = $default_tag;
        }

        if (AcesefUtility::JoomFishInstalled()) {
            $jfm = & JoomFishManager::getInstance();
            $code = $jfm->getLanguageCode($lang_tag);
        }
        else {
            // Only one language
            $code = null;
            if ($lang_tag == $default_tag) {
                $parts = explode('-', $default_tag);
                $code = $parts[0];
            }
        }

        return $code;
    }
	
	// Get language id
    function getLangId($lang_tag = null) {
        $id = null;
        
        if (AcesefUtility::JoomFishInstalled()) {
            // Get current language tag
            if (is_null($lang_tag)) {
                $lang = & JFactory::getLanguage();
                $lang_tag = $lang->getTag();
            }
    
            $jfm = & JoomFishManager::getInstance();
            $id = $jfm->getLanguageID($lang_tag);
        }

        return $id;
    }
	
	// Get language long code
    function getLangLongCode($lang_code = null) {
		static $codes;

        // Get current language code
        if (is_null($lang_code)) {
            $lang = & JFactory::getLanguage();
            return $lang->getTag();
        }

        if (is_null($codes)) {
            $codes = array();

            if (AcesefUtility::JoomFishInstalled()) {
                $jfm = & JoomFishManager::getInstance();
                $langs = & $jfm->getLanguages(false);
                if (!empty($langs)) {
                    foreach ($langs as $lang) {
                        $codes[$lang->shortcode] = $lang->code;
                    }
                }
            }
            else {
                // Only one language
                $lang = & JFactory::getLanguage();
                $tag = $lang->getTag();
                $parts = explode('-', $tag);
                $iso = $parts[0];
                $codes[$iso] = $tag;
            }
        }

        if (isset($codes[$lang_code])) {
            return $codes[$lang_code];
        }

        return null;
    }
	
	// Determine current language
	function determineLanguage($get_lang = null) {
        // Set the language for JoomFish
        if (AcesefUtility::JoomFishInstalled()) {
            $registry =& JFactory::getConfig();

            // save the default language of the site if needed
			$locale = $registry->getValue('config.language');
			$GLOBALS['mosConfig_defaultLang'] = $locale;
			$registry->setValue("config.defaultlang", $locale);

            // Get language from request
            if (!empty($get_lang)) {
                $lang = $get_lang;
            }
            
            // Try to get language code from JF cookie
            if ($this->AcesefConfig->joomfish_cookie) {
                $jf_cookie = JRequest::getVar('jfcookie', null, 'COOKIE');
                if( isset($jf_cookie['lang']) ) {
                    $cookieCode = $jf_cookie['lang'];
                }
            }
            
            // Try to find language from browser settings
            if ($this->AcesefConfig->joomfish_browser && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) && class_exists('JoomFishManager')) {
                $active_iso = array();
                $active_isocountry = array();
                $active_code = array();
                $active_languages = JoomFishManager::getInstance()->getActiveLanguages();

                if (count($active_languages) > 0) {
                    foreach ($active_languages as $a_lang) {
                        $active_iso[] = $a_lang->iso;
                        if(preg_match('/[_-]/i', $a_lang->iso)) {
                            $iso = str_replace('_', '-', $a_lang->iso);
                            $isocountry = explode('-', $iso);
                            $active_isocountry[] = $isocountry[0];
                        }
                        $active_code[] = $a_lang->shortcode;
                    }

                    // figure out which language to use - browser languages are based on ISO codes
                    $browser_lang = explode(',', $_SERVER["HTTP_ACCEPT_LANGUAGE"]);

                    foreach ($browser_lang as $b_lang) {
                        if(in_array($b_lang, $active_iso)) {
                            $client_lang = $b_lang;
                            break;
                        }
                        $short_lang = substr($b_lang, 0, 2);
                        if (in_array($short_lang, $active_isocountry)) {
                            $client_lang = $short_lang;
                            break;
                        }

                        // compare with code
                        if (in_array($short_lang, $active_code)) {
                            $client_lang = $short_lang;
                            break;
                        }
                    }

                    if (!empty($client_lang)) {
                        if(strlen($client_lang) == 2) {
                            $browser_code = self::getLangLongCode($client_lang);
                        }
                        else {
                            $browser_code = $client_lang;
                        }
                    }
                }
            }
            
            // Check if language is selected
            if (empty($lang)) {
                if (empty($code) || !JLanguage::exists($code)) {
                    if( ($this->AcesefConfig->joomfish_main_lang != '0') ) {
                        $code = self::getLangLongCode($this->AcesefConfig->joomfish_main_lang);
                    }
                }
                
                // Try to get language code from JF cookie
                if (empty($code) || !JLanguage::exists($code)) {
                    if (isset($cookieCode)) {
                        $code = $cookieCode;
                    }
                }

                // Try to get language from browser if needed
                if (empty($code) || !JLanguage::exists($code)) {
                    if (isset($browser_code)) {
                        $code = $browser_code;
                    }
                }
                
                // Get language from configuration if needed
                if (empty($code) || !JLanguage::exists($code)) {
                    if(($this->AcesefConfig->joomfish_main_lang != '0')) {
                        $code = self::getLangLongCode($this->AcesefConfig->joomfish_main_lang);
                    }
                }

                // Get default language if needed
                if (empty($code) || !JLanguage::exists($code)) {
                    $code = $registry->getValue('config.language');
                }
            }

            // get language long code if needed
            if (empty($code)) {
                if (empty($lang)) {
                    return;
                }
                
                $code = self::getLangLongCode($lang);
            }

            if (!empty($code)) {
                // set the site language
                $reset_lang = false;
				
                if ($code != self::getLangLongCode()) {
					$language =& JFactory::getLanguage();
					$language->setLanguage($code);
					$language->load();

					// set the backward compatible language
					$back_lang = $language->getBackwardLang();
					$GLOBALS['mosConfig_lang'] = $back_lang;
					$registry->setValue("config.lang", $back_lang);
					
					$reset_lang = true;
                }

                // set joomfish language if needed
                if ($reset_lang) {
                    $jf_lang = TableJFLanguage::createByJoomla($code);
                    $registry->setValue("joomfish.language", $jf_lang);
    
                    // set some more variables
                    $mainframe =& JFactory::getApplication();
                    $registry->setValue("config.multilingual_support", true);
                    $mainframe->setUserState('application.lang',$jf_lang->code);
                    $registry->setValue("config.jflang", $jf_lang->code);
                    $registry->setValue("config.lang_site",$jf_lang->code);
                    $registry->setValue("config.language",$jf_lang->code);
                    $registry->setValue("joomfish.language",$jf_lang);
    
            		// overwrite global config with values from $jf_lang if set to in JoomFish
            		$jf_params = JComponentHelper::getParams("com_joomfish");
            		$overwriteGlobalConfig = $jf_params->get('overwriteGlobalConfig', 0);
					
            		if ($overwriteGlobalConfig ) {
            			// We should overwrite additional global variables based on the language parameter configuration
            			$lang_params = new JParameter($jf_lang->params);
            			$param_array = $lang_params->toArray();
						
            			foreach ($param_array as $key => $val) {
            				$registry->setValue("config.".$key, $val);
            	
            				if (defined("_JLEGACY")){
            					$name = 'mosConfig_'.$key;
            					$GLOBALS[$name] = $val;
            				}
            			}
            		}
            		
                    // set the cookie with language
                    if ($this->AcesefConfig->joomfish_cookie) {
            			setcookie("lang", "", time() - 1800, "/");
            			setcookie("jfcookie", "", time() - 1800, "/");
            			setcookie("jfcookie[lang]", $code, time()+24*3600, '/');
                    }
                }
            }
        }
    }
}
?>