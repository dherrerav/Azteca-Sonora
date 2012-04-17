<?php
defined('_JEXEC') or die;

require_once JPATH_SITE . DS . 'libraries' . DS . 'Zend' . DS . 'Http' . DS . 'Client.php';
require_once JPATH_SITE . DS . 'libraries' . DS . 'Zend' . DS . 'Json.php';

class modSocialStatsHelper {

	const FACEBOOK_GRAPH_FQL_URL = 'https://graph.facebook.com/fql';
	const TWITTER_API_URL = 'https://api.twitter.com/1/';

	public function getStats(&$params) {
		$document =& JFactory::getDocument();
		$styleSheets = array_keys($document->_styleSheets);
		$styleSheetFound = false;
		for ($i = 0; $i < count($styleSheets); $i++) {
			if (stripos($styleSheets[$i], 'mod_social_stats.css') !== false) {
				$styleSheetFound = true;
			}
		}
		if (!$styleSheetFound) {
			$document->addStyleSheet(JURI::base() . '/modules/mod_social_stats/css/mod_social_stats.css');
		}
		$stats = new stdClass();
		$stats->facebook_page_stats = self::_getFacebookPageStats($params->get('facebook_page'));
		$stats->twitter_stats = self::_getTwitterStats($params->get('twitter_username'));
		return $stats;
	}

	protected function _getFacebookPageStats($page_id) {
		if (!$page_id || '' === $page_id) {
			return;
		}
		$url = self::FACEBOOK_GRAPH_FQL_URL;
		$query = 'SELECT name, fan_count FROM page WHERE page_id = ' . $page_id;
		$client = new Zend_Http_Client($url);
		$client->setParameterGet('q', $query);
		$response = $client->request(Zend_Http_Client::GET);
		$result = Zend_Json::decode($response->getBody(), Zend_Json::TYPE_OBJECT)->data[0];
		$client = new Zend_Http_Client('https://graph.facebook.com/' . $page_id);
		$response = $client->request(Zend_Http_Client::GET);
		$result->link = Zend_Json::decode($response->getBody(), Zend_Json::TYPE_OBJECT)->link;
		return $result;
	}

	protected function _getTwitterStats($twitter_username) {
		if (!$twitter_username || '' === $twitter_username) {
			return;
		}
		$url = self::TWITTER_API_URL . 'users/show.json';
		$client = new Zend_Http_Client($url);
		$client->setParameterGet('screen_name', $twitter_username);
		$client->setParameterGet('include_entities', 'true');
		$request = $client->request(Zend_Http_Client::GET);
		return Zend_Json::decode($request->getBody(), Zend_Json::TYPE_OBJECT);
	}
}