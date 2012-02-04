<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
define('VPATH1', realpath(dirname(__FILE__).'../../../../components/com_contushdvideoshare/videos') );
define('VPATH2', realpath(dirname(__FILE__).'/../../../components/com_contushdvideoshare/videos') );
define('FVPATH', realpath(dirname(__FILE__)));
date_default_timezone_set('UTC');
$controllerName = JRequest::getCmd( 'layout','videos');


 $folder = JPATH_ROOT . DS . 'components' . DS . 'com_contushdvideoshare' . DS . 'videos';
        if(!is_dir($folder)){
    mkdir($folder);
}


if($controllerName == 'category') {
     JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
     	  JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
		  JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62');
		 JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category', true );
	JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
    JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');
           JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');


}
elseif($controllerName == 'memberdetails') {
	 JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
     
         JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails', true );
		 JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62');
		 	JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
	JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
     JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');   
      JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');

}
elseif($controllerName == 'adminvideos' && JRequest::getCmd('userid','','get','int') != 62) {
	    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos', true );
     	 JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
		 JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62');
		 JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
	JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
  JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');  
JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');

}
elseif($controllerName == 'adminvideos' && JRequest::getCmd('userid','','get','int') == 62) {
	    JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
     	 JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
		 JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62',true);
		 JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
	JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
   JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead'); 
JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');

}
elseif($controllerName == 'sitesettings') {
	JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
     	
         JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
		 JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62');
		 JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
	JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings', true );
   JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');  
JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');

}
elseif($controllerName == 'settings') {
	JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
     	
         JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
		 JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62');
		 JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
	JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings', true );
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
   JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead');   
JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');

}

elseif($controllerName == 'googlead') {
   JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
   
   JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
   JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62');
   JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
   JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
   JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead', true );   
JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads');

}

elseif($controllerName == 'ads') {
   JSubMenuHelper::addEntry(JText::_('Member Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos');
   JSubMenuHelper::addEntry(JText::_('Member Details'), 'index.php?option=com_contushdvideoshare&layout=memberdetails');
   JSubMenuHelper::addEntry(JText::_('Admin Videos'), 'index.php?option=com_contushdvideoshare&layout=adminvideos&userid=62');
    JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_contushdvideoshare&layout=category');
   JSubMenuHelper::addEntry(JText::_('Player Settings'), 'index.php?option=com_contushdvideoshare&layout=settings');
   JSubMenuHelper::addEntry(JText::_('Site Settings'), 'index.php?option=com_contushdvideoshare&layout=sitesettings');
   JSubMenuHelper::addEntry(JText::_('Google AdSense'), 'index.php?option=com_contushdvideoshare&layout=googlead' ); 
    JSubMenuHelper::addEntry(JText::_('Ads '), 'index.php?option=com_contushdvideoshare&layout=ads',true);

}



switch ($controllerName)
{
	default:
		$controllerName = 'controlpanel';
		// allow fall through

	case 'category':
		case 'categorylist':
        case 'settings':
  
            case 'memberdetails':
                case 'adminvideos':
				case 'adminvideos&userid=62':
                     case 'ads':
                    case 'sortorder':
                    case 'sitesettings':                       
                            case 'googlead':
		// Temporary interceptor
		$task = JRequest::getCmd('task');
        
	if($controllerName == 'categorylist'){
		$controllerName = 'category';
	}
  		require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );
		$controllerName = 'contushdvideoshareController'.$controllerName;

		// Create the controller
		$controller = new $controllerName();

		// Perform the Request task
		$controller->execute( JRequest::getCmd('task') );

		// Redirect if set by the controller
		$controller->redirect();
		break;


}
