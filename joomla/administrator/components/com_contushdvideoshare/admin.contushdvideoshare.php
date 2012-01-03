<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        admin.contushdvideosahre.php
 * @location    /components/com_contushdvideosahre/admin.contushdvideoshare.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    admin common controller page
 */

$currentDirectory = (dirname(__FILE__) . DS . '..' . DS . '..' . DS . '..' . DS . 'components' . DS . 'com_contushdvideoshare' . DS . 'videos');
$file = (dirname(__FILE__)) . DS . 'index.html';
$defimg = (dirname(__FILE__)) . DS . 'images' . DS . 'default_thumb.jpg';
$newdefimg = $currentDirectory . DS . 'default_thumb.jpg';
$newfile = $currentDirectory . DS . 'index.html';
if (!is_dir($currentDirectory)) {
    if (!mkdir($currentDirectory, 0777))
        echo 'failed to create folder';
    if (!copy($file, $newfile)) {
        echo "failed to copy $file...\n";
    }
    if (!copy($defimg, $newdefimg)) {
        echo "failed to copy $file...\n";
    }
}

defined('_JEXEC') or die('Restricted access');
// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
define('VPATH1', realpath(dirname(__FILE__) . '../../../../components/com_contushdvideoshare/videos'));
define('VPATH2', realpath(dirname(__FILE__) . '/../../../components/com_contushdvideoshare/videos'));
define('FVPATH', realpath(dirname(__FILE__)));
$controllerName = JRequest::getCmd('layout', 'videos');

if ($controllerName == 'category') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category', true);
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');
} elseif ($controllerName == 'memberdetails') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails', true);
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');
} elseif ($controllerName == 'adminvideos' && JRequest::getCmd('actype', '', 'get', 'string') != 'adminvideos') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos', true);
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');
} elseif ($controllerName == 'adminvideos' && JRequest::getCmd('actype', '', 'get', 'string') == 'adminvideos') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos', true);
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');
} elseif ($controllerName == 'sitesettings') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings', true);
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');
} elseif ($controllerName == 'settings') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings', true);
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');
} elseif ($controllerName == 'googlead') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead', true);
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');
} elseif ($controllerName == 'ads') {
    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
    JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&actype=adminvideos');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
    JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
    JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads', true);
}



switch ($controllerName) {
    default:
        $controllerName = 'settings';
    // allow fall through
    case 'category':
    case 'settings':
    case 'memberdetails':
    case 'adminvideos':
    case 'adminvideos&userid=42':
    case 'ads':
    case 'sortorder':
    case 'sitesettings':
    case 'googlead':
        // Temporary interceptor
        $task = JRequest::getCmd('task');
        require_once( JPATH_COMPONENT . DS . 'controllers' . DS . $controllerName . '.php' );
        $controllerName = 'contushdvideoshareController' . $controllerName;
        // Create the controller
        $controller = new $controllerName();
        // Perform the Request task
        $controller->execute(JRequest::getVar('task'));
        // Redirect if set by the controller
        $controller->redirect();
        break;
}
