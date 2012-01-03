<?php
/**
 * @version		$Id: packer.php 201 2011-05-08 16:27:15Z happy_noodle_boy $
 * @package   JCE
 * @copyright Copyright © 2009-2011 Ryan Demmer. All rights reserved.
 * @copyright Copyright © 2005 - 2007 Open Source Matters. All rights reserved.
 * @license   GNU/GPL 2 or later
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('RESTRICTED');

class WFPacker extends JObject 
{
	var $files = array();

	var $type = 'javascript';

	var $start = '';

	var $end = '';

	/**
	 * Constructor activating the default information of the class
	 *
	 * @access	protected
	 */
	function __construct($config = array())
	{
		$this->setProperties($config);
	}

	function setFiles($files = array())
	{
		$this->files = $files;
	}

	function getFiles()
	{
		return $this->files;
	}

	function setContentStart($start ='')
	{
		$this->start = $start;
	}

	function getContentStart()
	{
		return $this->start;
	}

	function setContentEnd($end ='')
	{
		$this->end = $end;
	}

	function getContentEnd()
	{
		return $this->end;
	}

	function setType($type)
	{
		$this->type = $type;
	}

	function getType()
	{
		return $this->type;
	}

	function pack($minify = true, $gzip = true)
	{
		$type = $this->getType();

		// Headers
		if ($type == 'javascript') {
			header("Content-type: application/x-javascript; charset: UTF-8");
		}
		
		if ($type == 'css') {
			header("Content-type: text/css; charset: UTF-8");
		}
		
		header("Vary: Accept-Encoding");
		
		// expires after 7 days
		$expires = 60 * 60 * 24 * 7;
		
		header("Cache-Control: maxage=".$expires);

		// Handle proxies
		header("Expires: " . gmdate ("D, d M Y H:i:s", time() + $expires) . " GMT");

		$files = $this->getFiles();

		// Check if it supports gzip
		if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
			$encodings = explode(',', strtolower(preg_replace("/\s+/", "", $_SERVER['HTTP_ACCEPT_ENCODING'])));
		}
		
		if((in_array('gzip', $encodings) || in_array('x-gzip', $encodings) || isset($_SERVER['---------------'])) && function_exists('ob_gzhandler') && !ini_get('zlib.output_compression')) {
			$enc = in_array('x-gzip', $encodings) ? "x-gzip" : "gzip";
		} else {
			// flag $gzip false regardless of parameter
			$gzip = false;
		}

		$content = $this->getContentStart();

		foreach($files as $file) {
			$content .= $this->getText($file);
		}

		$content .= $this->getContentEnd();

		// Generate GZIP'd content
		if($gzip) {
			// pack javascript
			if($minify) {
				if($this->getType() == 'javascript') {
					require_once (dirname(__FILE__) . DS . 'jsmin.php');

					$content = trim(JSMin::minify($content));
				}

				if($this->getType() == 'css') {
					$content = $this->cssMin($content);
				}
			}

			header("Content-Encoding: " . $enc);
			$data = gzencode($content, 9, FORCE_GZIP);

			// Stream to client
			die($data);
		} else {
			if($minify) {
				if($type == 'javascript') {
					require_once (dirname(__FILE__) . DS . 'jsmin.php');

					$content = trim(JSMin::minify($content));
				}

				if($type == 'css') {
					$content = $this->cssMin($content);
				}
			}
			// Stream uncompressed content
			die($content);
		}
	}
	
	/**
	 * Simple CSS Minifier
	 * @param $data Data string to minify
	 */
	function cssmin($data)
	{
		$data = str_replace('\r\n', '\n', $data);

		$data = preg_replace('#\s+#', ' ', $data);
		$data = preg_replace('#/\*.*?\*/#s', '', $data);
		$data = preg_replace('#\s?([:\{\};,])\s?#', '$1', $data);

		$data = str_replace(';}', '}', $data);

		return  trim($data);
	}

	/**
	 * Import CSS from a file
	 * @param file File path where data comes from
	 * @param $data Data from file
	 */
	function importCss($data)
	{
		if(preg_match_all('#@import url\([\'"]?([^\'"\)]+)[\'"]?\);#i', $data, $matches)) {

			$data = '';

			foreach($matches[1] as $match) {
				$data .= $this->getText(realpath($this->get('_cssbase') . DS . $match));
			}

			return $data;
		}

		return '';
	}

	function getText($file)
	{
		if($file && is_file($file)) {

			if($text = file_get_contents($file)) {
				// process css files
				if($this->getType() == 'css') {

					if(strpos($text, '@import') !== false) {
						// store the base path of the current file
						$this->set('_cssbase', dirname($file));

						// process import rules
						$text = $this->importCss($text) . preg_replace('#@import url\([\'"]?([^\'"\)]+)[\'"]?\);#i', '', $text);
					}

					// store the base path of the current file
					$this->set('_imgbase', dirname($file));

					// process urls
					$text = preg_replace_callback('#url\s?\([\'"]?([^\'"\))]+)[\'"]?\)#', array('WFPacker', 'processPaths'), $text);
				}

				return $text;
			}
		}

		return '';
	}

	function processPaths($data)
	{
		$path = str_replace(JPATH_SITE, '', realpath($this->get('_imgbase') . DS . $data[1]));

		if($path) {
			return "url('" . JURI::root(true) . str_replace(DS, '/', $path) . "')";
		}

		return "url('" . $data[1] . "')";
	}

}
?>