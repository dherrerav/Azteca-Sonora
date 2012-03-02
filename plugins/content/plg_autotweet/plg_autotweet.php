<?php
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';
require_once 'Zend/Oauth/Token/Access.php';
require_once 'Zend/Service/Twitter.php';
require_once 'Zend/Service/ShortUrl/TinyUrlCom.php';

jimport('joomla.event.plugin');

class plgContnetPlg_AutoTweet extends JPlugin {
	
	protected $_plugin;
	protected $_params;
	
	public function truncate($text, $length = 0, $end = '...') {
		if ($length == 0 || strlen($text) <= $length) return $text;
		$length = $length - strlen($end);
		$text = substr($text, 0, $length);
		return $text . $end;
	}
	
	public function shorten($url, $login, $apiKey, $format = 'txt') {
		$connectUrl = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $apiKey . '&uri=' . urlencode($url) . '&format=' . $format;
		return $this->curl_get_result($connectUrl);
	}
	
	public function expand($url, $login, $apiKey, $format = 'txt') {
		$connectUrl = 'http://api.bit.ly/v3/expand?login=' . $login . '&apiKey=' . $apiKey . '&shortUrl=' . encode($url) . '&format=' . $format;
		return $this->curl_get_result($connectUrl);
	}

	public function curl_get_result($url, $timeout = 5) {
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, $url);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handler, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($handler);
		curl_close($handler);
		return $data;
	}
}