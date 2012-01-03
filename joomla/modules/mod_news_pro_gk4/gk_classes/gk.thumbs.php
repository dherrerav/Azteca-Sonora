<?php

/**
* Image class
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

/*

	This class uses options of module:
	- cache time
	- quality
	- image width
	- image height
	- background color
	- image stretch

*/

class NSP_GK4_Thumbs {
	/*
		function to change file path to filename.
		For example:
		./images/stories/demo.jpg
		will be translated to:
		stories.demo.jpg
		(in this situation mirror of ./images/ directory isn't necessary)
	*/
	function translateName($name,$mod_id, $k2_mode = false) {
		$name = NSP_GK4_Thumbs::getRealPath($name, $k2_mode);
		$start = ($k2_mode) ? strpos($name, DS.'media'.DS) : strpos($name, DS.'images'.DS);
		$name = ($k2_mode) ? substr($name, $start+7) : substr($name, $start+8);
		$ext = substr($name, -4);
		$name = substr($name, 0, -4);
		$name = str_replace(DS,'.',$name);
		$name .= $mod_id.$ext;
		return $name;
	}
	// function to change file path to  real path.
	function getRealPath($path, $k2_mode = false) {
		$start = ($k2_mode) ? strpos($path, 'media/') : strpos($path, 'images/');
		$path = './'.substr($path, $start);
		return realpath($path);
	}
	/*
		function to check cache
		
		this function checks if file exists in cache directory
		and checks if time of file life isn't too long
	*/
	function checkCache($filename, $cache_time) {
		$cache_dir = JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS;
		$file = $cache_dir.$filename;
		
		return (!is_file($file) || $cache_time == 0) ? FALSE : (filemtime($file) + 60 * $cache_time > time());
	}
	// Creating thumbnails
	function createThumbnail($path, $config, $k2_mode = false) {
		if(NSP_GK4_Thumbs::checkCache(NSP_GK4_Thumbs::translateName($path,$config['module_id'], $k2_mode), $config['cache_time'], $config['module_id'])){
			return TRUE;	
		}else{
			// importing classes
			jimport('joomla.filesystem.file');
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.path');
			//script configuration - increase memory limit to 64MB
			ini_set('memory_limit', '64M');
			// cache dir
			$cache_dir = JPATH_ROOT.DS.'modules'.DS.'mod_news_pro_gk4'.DS.'cache'.DS;
			// file path
			$file = NSP_GK4_Thumbs::getRealPath($path, $k2_mode);
			// filename
			$filename = NSP_GK4_Thumbs::translateName($path,$config['module_id'], $k2_mode);
			// Getting informations about image
			if(is_file($file)){
				$imageData = getimagesize($file);
				$img_w = str_replace('px','',str_replace('%','',$config['img_width']));
				$img_h = str_replace('px','',str_replace('%','',$config['img_height']));
				// loading image depends from type of image		
				if($imageData['mime'] == 'image/jpeg' || $imageData['mime'] == 'image/pjpeg' || $imageData['mime'] == 'image/jpg') $imageSource = @imagecreatefromjpeg($file);
				elseif($imageData['mime'] == 'image/gif') $imageSource = @imagecreatefromgif($file);
				else $imageSource = @imagecreatefrompng($file); 
				// here can be exist an error when image is to big - then class return blank page	
				// setting image size in variables
				$imageSourceWidth = imagesx($imageSource);
				$imageSourceHeight = imagesy($imageSource);
				// Creating blank canvas
				if($config['img_keep_aspect_ratio']) {
                    // calculate ratio for first scaling
					$ratio = ($imageSourceWidth > $imageSourceHeight) ? $img_w / $imageSourceWidth : $img_h / $imageSourceHeight;
					// calculate new image size
					$imageSourceNWidth = $imageSourceWidth * $ratio;
					$imageSourceNHeight = $imageSourceHeight * $ratio;
					// calculate ratio for second scaling
					if($img_w > $img_h){					
						if($imageSourceNHeight > $img_h){
							$ratio2 = $img_h / $imageSourceNHeight;
							$imageSourceNHeight *= $ratio2;
							$imageSourceNWidth *= $ratio2;
						}
					}else{
						if($imageSourceNWidth > $img_w){
							$ratio2 = $img_w / $imageSourceNWidth;
							$imageSourceNHeight *= $ratio2;
							$imageSourceNWidth *= $ratio2;
						}
					}
					
					$img_w = $imageSourceNWidth;
					$img_h = $imageSourceNHeight;
				}
                $imageBG = imagecreatetruecolor($img_w, $img_h);
				// If image is JPG or GIF
				if($imageData['mime'] == 'image/jpeg' || $imageData['mime'] == 'image/pjpeg' || $imageData['mime'] == 'image/jpg' || $imageData['mime'] == 'image/gif') {
					// when bg is set to transparent - use black background
					if($config['img_bg'] == 'transparent'){
						$bgColorR = 0;
						$bgColorG = 0;
						$bgColorB = 0;				
					}else{ // in other situation - translate hex to RGB
						$bg = $config['img_bg'];
						if(strlen($bg) == 4) $bg = $bg[0].$bg[1].$bg[1].$bg[2].$bg[2].$bg[3].$bg[3];
						$hex_color = strtolower(trim($bg,'#;&Hh'));
			  			$bg = array_map('hexdec',explode('.',wordwrap($hex_color, ceil(strlen($hex_color)/3),'.',1)));
						$bgColorR = $bg[0];
						$bgColorG = $bg[1];
						$bgColorB = $bg[2];
					}
					// Creating color
					$rgb = imagecolorallocate($imageBG, $bgColorR, $bgColorG, $bgColorB);
					// filling canvas with new color
					imagefill($imageBG, 0, 0, $rgb);	
				}else {// for PNG images	
					if($config['img_keep_aspect_ratio']) {
                        // calculate ratio for first scaling
    					$ratio = ($imageSourceWidth > $imageSourceHeight) ? $img_w / $imageSourceWidth : $img_h / $imageSourceHeight;
    					// calculate new image size
    					$imageSourceNWidth = $imageSourceWidth * $ratio;
    					$imageSourceNHeight = $imageSourceHeight * $ratio;
    					// calculate ratio for second scaling
    					if($img_w > $img_h){					
    						if($imageSourceNHeight > $img_h){
    							$ratio2 = $img_h / $imageSourceNHeight;
    							$imageSourceNHeight *= $ratio2;
    							$imageSourceNWidth *= $ratio2;
    						}
    					}else{
    						if($imageSourceNWidth > $img_w){
    							$ratio2 = $img_w / $imageSourceNWidth;
    							$imageSourceNHeight *= $ratio2;
    							$imageSourceNWidth *= $ratio2;
    						}
    					}
    					
    					$img_w = $imageSourceNWidth;
    					$img_h = $imageSourceNHeight;
                    }
                    $imageBG = imagecreatetruecolor($img_w, $img_h);
					// enable transparent background 
					if($config['img_bg'] == 'transparent'){
						// create transparent color
						$rgb = imagecolorallocatealpha($imageBG, 0, 0, 0, 127);
					}else {// create normal color
						$bg = $config['img_bg'];
						// translate hex to RGB
						$hex_color = strtolower(trim($bg,'#;&Hh'));
			  			$bg = array_map('hexdec',explode('.',wordwrap($hex_color, ceil(strlen($hex_color)/3),'.',1)));
						// creating color
						$rgb = imagecolorallocate($imageBG, $bg[0], $bg[1], $bg[2]);
					}
					// filling the canvas
					imagefill($imageBG, 0, 0, $rgb);
					// enabling transparent settings for better quality
					imagealphablending($imageBG, false);
					imagesavealpha($imageBG, true);
				}
				// when stretching is disabled		
				if(!$config['img_stretch'] || $config['img_keep_aspect_ratio']){
					if($config['img_keep_aspect_ratio']) {
					   $base_x = 0;
					   $base_y = 0;
					   $imageSourceNWidth = $img_w;
					   $imageSourceNHeight = $img_h;
					} else {
                        // calculate ratio for first scaling
    					$ratio = ($imageSourceWidth > $imageSourceHeight) ? $img_w/$imageSourceWidth : $img_h/$imageSourceHeight;
    					// calculate new image size
    					$imageSourceNWidth = $imageSourceWidth * $ratio;
    					$imageSourceNHeight = $imageSourceHeight * $ratio;
    					// calculate ratio for second scaling
    					if($img_w > $img_h){					
    						if($imageSourceNHeight > $img_h){
    							$ratio2 = $img_h / $imageSourceNHeight;
    							$imageSourceNHeight *= $ratio2;
    							$imageSourceNWidth *= $ratio2;
    						}
    					}else{
    						if($imageSourceNWidth > $img_w){
    							$ratio2 = $img_w / $imageSourceNWidth;
    							$imageSourceNHeight *= $ratio2;
    							$imageSourceNWidth *= $ratio2;
    						}
    					}
    					// setting position of putting thumbnail on canvas
    					$base_x = floor(($img_w - $imageSourceNWidth) / 2);
    					$base_y = floor(($img_h - $imageSourceNHeight) / 2);
					}
				}else{ // when stretching is disabled
					$imageSourceNWidth = $img_w;
					$imageSourceNHeight = $img_h;
					$base_x = 0;
					$base_y = 0;
				}
				
				// copy image	
				imagecopyresampled($imageBG, $imageSource, $base_x, $base_y, 0, 0, $imageSourceNWidth, $imageSourceNHeight, $imageSourceWidth, $imageSourceHeight);
				// save image depends from MIME type	
				if($imageData['mime'] == 'image/jpeg' || $imageData['mime'] == 'image/pjpeg' || $imageData['mime'] == 'image/jpg') imagejpeg($imageBG,$cache_dir.$filename, $config['img_quality']);
				elseif($imageData['mime'] == 'image/gif') imagegif($imageBG, $cache_dir.$filename); 
				else imagepng($imageBG, $cache_dir.$filename);
				return TRUE;
			}else{
				return FALSE;
			}	
		}
	}	
}

/* eof */