<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
class acyuserHelper {
	function getIP(){
		$ip = '';
		if( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) AND strlen($_SERVER['HTTP_X_FORWARDED_FOR'])>6 ){
					$ip = strip_tags($_SERVER['HTTP_X_FORWARDED_FOR']);
			}elseif( !empty($_SERVER['HTTP_CLIENT_IP']) AND strlen($_SERVER['HTTP_CLIENT_IP'])>6 ){
			 $ip = strip_tags($_SERVER['HTTP_CLIENT_IP']);
		}elseif(!empty($_SERVER['REMOTE_ADDR']) AND strlen($_SERVER['REMOTE_ADDR'])>6){
			 $ip = strip_tags($_SERVER['REMOTE_ADDR']);
			}//endif
		return strip_tags($ip);
	}
	function validEmail($email,$extended = false){
		if(empty($email) OR !is_string($email)) return false;
		if(!preg_match('/^([a-z0-9_\'&\.\-\+])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,10})+$/i',$email)) return false;
		if(!$extended) return true;
		$config = acymailing_config();
		if($config->get('email_checkpopmailclient',false)){
			if(preg_match('#^.{1,5}@(gmail|yahoo|aol|hotmail|msn|ymail)#i',$email)) return false;
		}
		if($config->get('email_checkdomain',false) AND function_exists('getmxrr')){
			$domain = substr($email,strrpos($email,'@')+1);
			$mxhosts = array();
			$checkDomain = getmxrr($domain, $mxhosts);
			if(!empty($mxhosts) && strpos($mxhosts[0],'hostnamedoesnotexist')) array_shift($mxhosts);
			if(!$checkDomain || empty($mxhosts)){
				$dns = @dns_get_record($domain, DNS_A);
				if(empty($dns)) return false;
			}
		}
		return true;
	}
}