<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once 'Zend/Loader.php';
require_once dirname(__FILE__) . DS . 'helper.php';

Zend_Loader::loadClass('Zend_Http_Client');
Zend_Loader::loadClass('Zend_Controller_Request_Http');

$request = new Zend_Controller_Request_Http();
$location = null;
if (isset($params)) {
	$location = $params->get('location');
}
if (isset($_COOKIE['weather_location'])) {
	$location = $_COOKIE['weather_location'];
}
if ($request->isPost()) {
	$location = $request->getPost('location');
}

$weather = modGoogleWeatherHelper::getWeather($location);
if ($weather) {
	if (!$request->isPost()) {
		$document =& JFactory::getDocument();
		$document->addStyleSheet(JURI::base() . 'modules/' . $module->module . '/css/' . $module->module . '.css');
	}
	$info = $weather->forecast_information;
	$current = $weather->current_conditions;
	$forecast = $weather->forecast_conditions;
	require dirname(__FILE__) . DS . 'tmpl/default.php';
}