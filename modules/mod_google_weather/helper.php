<?php

class modGoogleWeatherHelper {
	
	const API_URL = 'http://www.google.com/ig/api';
	
	public static function getWeather($location) {
		$client = new Zend_Http_Client(self::API_URL);
		$client->setParameterGet('weather', $location);
		$response = $client->request(Zend_Http_Client::GET);
		$weather = new SimpleXMLElement(utf8_encode($response->getBody()));
		setcookie('weather_location', $location);
		return $weather->weather;
	}
}
