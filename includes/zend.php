<?php
defined('_JEXEC') or die;
set_include_path(implode(PATH_SEPARATOR, array(
	JPATH_BASE . '/libraries/',
	get_include_path()
)));
require_once 'Zend/Loader.php';

Zend_Loader::loadClass('Zend_Locale');
Zend_Loader::loadClass('Zend_Registry');
Zend_Registry::set('Zend_Locale', new Zend_Locale('es_MX'));