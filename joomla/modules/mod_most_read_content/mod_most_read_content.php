<?php
defined('_JEXEC') or die('Restricted access');

//Get parameters 
//Adds an individual styling
$moduleclass_sfx = $params->get('moduleclass_sfx'); 
//Show or hide header
$showheader = $params->get('showheader'); 
//Show or hide leaderboard
$showleaderboard = $params->get('showleaderboard'); 
//Number of items to be displayed in the result
$count = $params->get('count'); 
//Show or hide administrator articles
$adminarticles = $params->get('adminarticles'); 
//Show or hide frontpage articles
$frontpagearticles = $params->get('frontpagearticles'); 
//Show or hide section
$section = $params->get('section'); 
//Show or hide category
$category = $params->get('category'); 
//Show or hide author name
$author = $params->get('author'); 
//Show or hide hits
$hits = $params->get('hits'); 
//Sort items by
$sortorder = $params->get('sortorder'); 
//Show Name or Username
$username = $params->get('username'); 

// include the helper file
require_once dirname(__FILE__).DS.'helper.php';

// get the items to display from the helper
$items = modMostReadContentHelper::getItems($params);
 
// include the template for display
require JModuleHelper::getLayoutPath('mod_most_read_content', $params->get('layout', 'default'));