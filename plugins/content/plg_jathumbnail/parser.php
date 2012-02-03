<?php
/*
# ------------------------------------------------------------------------
# JA Thumbnail plugin for Joomla 1.6.x
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/

if (!class_exists('ReplaceCallbackParser')) {
	define ('_OPEN_TAG', 1);
	define ('_CLOSE_TAG', 2);
	define ('_FULL_TAG', 3);
	class ReplaceCallbackParser {
		var $_source = '';
		var $_tagname = '';
		var $_open = '{';
		var $_close = '}';
		var $_callback = '';
		function ReplaceCallbackParser($tagName, $tagAttr='{', $tagClose='}') {
			$this->_tagname = $tagName;
			$this->_open = $tagAttr;
			$this->_close = $tagClose;
		}
		
		function parse ($strinput, $callback) {
			$this->_source = $strinput;
			$this->_callback = $callback;
			//Build delimiter
			$regex = "/(".$this->_open . "[\/]?".$this->_tagname."[^}]*".$this->_close.")/";
			$arr = preg_split($regex, $this->_source, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
			
			$empty = true;
			$matches = array();
			$tagAttr = '';
			$isOpened = false;
			$tagContent = '';
			$stroutput = array();
			foreach ($arr as $item) {
		    	$tagtype = $this->parseTag($item);
		    	if ($tagtype == _OPEN_TAG) {
		    		if ($isOpened) {
		    			$stroutput[] = $this->callBack ($tagAttr, $tagContent);
		    			$isOpened = false;
		    		}
		    		$tagAttr = substr($item, strlen($this->_open)+strlen($this->_tagname),strlen($item)-strlen($this->_tagname)-strlen($this->_close)-strlen($this->_open));
		    		$tagContent = '';
		    		$isOpened = true;
		    		
		    		continue;
		    	}
		    	if ($tagtype == _FULL_TAG) {
		    		if ($isOpened) {
		    			$stroutput[] = $this->callBack ($tagAttr, $tagContent);
		    			$isOpened = false;
		    		}
		    		$tagAttr = substr($item, strlen($this->_open)+strlen($this->_tagname),strlen($item)-strlen($this->_close)-strlen($this->_tagname)-strlen($this->_open)-1);
		    		$tagContent = '';
		    		$stroutput[] = $this->callBack ($tagAttr, $tagContent);
		    		continue;
		    	}
		    	if ($tagtype == _CLOSE_TAG) {
		  			$stroutput[] = $this->callBack ($tagAttr, $tagContent);
		  			$isOpened = false;
		    		continue;
		    	}
		    	
		  		if ($isOpened) {
		  			$tagContent .= $item;
		  		} else {
		  			$stroutput[] = $item;
		  		}	  		
		    }
			if ($isOpened) {
				$stroutput[]= $this->callBack ($tagAttr, $tagContent);
				$isOpened = false;
			}
			
			return $stroutput;
		}
		
		function parseTag ($tag) {
			$arr = preg_split ('/'.$this->_tagname.'/', $tag, 2);
			if (count($arr) < 2) return 0;
	//print_r ($arr);		
			if ($arr[0] == $this->_open) {
				if (substr($arr[1], - (strlen ($this->_close)+1)) == '/'.$this->_close) return _FULL_TAG;
				else return _OPEN_TAG;
			}
			if ($arr[0] == $this->_open.'/') return _CLOSE_TAG;
			return 0;
		}
		
		function callBack ($tagAttr, $tagContent) {
			if (is_array($this->_callback) && count($this->_callback) >= 2) {
				$callbackobj = $this->_callback[0];
				$callbackmethod = $this->_callback[1]; 
				return $callbackobj->$callbackmethod($tagAttr, $tagContent);
			} else {
				if (function_exists($this->_callback)) {
					$callback = $this->_callback;
					return $callback($tagAttr, $tagContent);
				}
			}
		}	
	}
}
?>
