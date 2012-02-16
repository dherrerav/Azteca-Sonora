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

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

class JACommentViewUsers extends JView {
	/**
	 * Display the view
	 */
	function display($tmpl = null) {
		if($this->getLayout () == "login") {			
			$this->showLogin();
		}
		parent::display ( $tmpl );
	}	
    
    function showLogin(){        
        // form RPX Login
        if(JPluginHelper::isEnabled('system', 'janrain')){
            $plg = JPluginHelper::getPlugin("system","janrain");
			$plgparams = new JRegistry;
        	$plgparams->loadJSON($plg->params);
			$post_data = array('apiKey' => $plgparams->get("apikey"));
			
             if (function_exists("curl_init")) {
			      
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/plugin/lookup_rp');
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
					curl_setopt($curl, CURLOPT_HEADER, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					$raw_json = curl_exec($curl);
				
					curl_close($curl);
			  } else if(ini_get ( 'allow_url_fopen' )){
					$raw_json = file_get_contents ( "http://rpxnow.com/plugin/lookup_rp?apiKey=" . $post_data ['apiKey'] . "&&format=json" ); 			
			  } else {
			      
			        JError::raiseWarning ( 1, JText::_ ( 'BUT YOUR SERVER DOES NOT CURRENTLY SUPPORT OPEN METHOD' ).'.' );
			        return;
              }
		 
            if(!function_exists('json_decode')) {
				// very plain json_decode
				function json_decode($str, $ignore=true) {
					$str = trim($str);
					if(!preg_match('#^\{(("[\w]+":"[^"]*",?)*)\}$#i', $str, $m)) return array();
					$data = explode('","', substr($m[1], 1, -1));
					$ret = array();
					for($i=0; $i<count($data);$i++) {
						list($k,$v) = explode(':', $data[$i], 2);
						$ret[substr($k, 0, -1)] = substr($v, 1);
					}
					
					return $ret;
				}
            }
            // parse the json response into an associative array
            $json = json_decode($raw_json, true);
            $realm = $json['realm'];
            
            
            $application = $json['realm'];
			
            $token_url = urlencode($_SERVER['HTTP_REFERER']);        
            
            $this->assign ("application", $application);
            $this->assign ("token_url", $token_url);
            
            $_SESSION['ses_url'] = $_SERVER['HTTP_REFERER'];

        }               
    }
}
?>