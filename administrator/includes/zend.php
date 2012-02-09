<?php
defined('_JEXEC') or die;
set_include_path(implode(PATH_SEPARATOR, array(
	JPATH_BASE . '/../libraries/',
	get_include_path()
)));
require_once 'Zend/Loader.php';
