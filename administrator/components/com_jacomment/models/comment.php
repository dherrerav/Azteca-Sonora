<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
jimport ( 'joomla.application.component.model' );

/**
 * @package Joomla
 * @subpackage javoice
 */
class JACommentModelComment extends JModel {
	
	function getKey() {
		global $jacconfig;
		$sql = "select data from #__jacomment_configs where `group`='key'";
		$db = JFactory::getDBO ();
		$db->setQuery ( $sql );
		$key = $db->loadResult ();
		return $key;
	}
	function getLatestVersion() {
		global $JACVERSION;
		if (isset ( $_SESSION ['latest_version'] ))
			$latest_version = $_SESSION ['latest_version'];
		else {
			global $JACPRODUCTKEY;
			
			$req = 'type=product_name';
			$req .= '&key=com_jacomment';
			$req .= '&j=16';
			//$req .= '&current_version=' . $JACPRODUCTKEY;
			$host = 'www.joomlart.com';
			$path = '/forums/getlatestversion.php';
			$URL = "http://$host$path";			
			$latest_version = '';
			if (! function_exists ( 'curl_version' )) {
				if (stristr ( ini_get ( 'disable_functions' ), "fsockopen" )) {
					return;
				} else {			
					$latest_version = JACommentHelpers::socket_getdata ( $host, $path, $req );
				}
			} else {				
				$latest_version = JACommentHelpers::curl_getdata ( $URL, $req );							
			}
		}
		//$_SESSION ['latest_version'] = $latest_version;
		
		return $latest_version;
	}

}
?>