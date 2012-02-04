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

jimport('joomla.application.component.controller');

/**
 * details Component Administrator Controller
 */
class contushdvideoshareControllersortorder extends JController
{

    function display() { 


        $view = & $this->getView('sortorder');

        // Get/Create the model
        if ($model = & $this->getModel('sortorder')) {
            $view->setModel($model, true);
        }

        $view->setLayout('sortorderlayout');
        $task= JRequest::getVar( 'task', 'get' , '', 'string' );
		if($task=='videos')
        $view->videosortorder(); 
		else
		$view->categorysortorder();
		
    }
}


?>
