<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.access.access');
jimport( 'joomla.application.component.view');

/**
     * HTML View class for the backend of the details Component edit task
     *
     * @package    HelloWorld
     */

class contushdvideoshareViewadminvideos extends JView
{
	function adminvideos()
	{
            
            if(JRequest::getVar('userid','','get','int') && JRequest::getVar('userid','','get','int') == 62)
            {
                JToolBarHelper::title( JText::_( 'Admin Videos' ),'generic.png' );
            }
         else
           {
                JToolBarHelper::title( JText::_( 'Member Videos' ),'generic.png' );
           }
        JToolBarHelper::save('savevideos','Save');
        JToolBarHelper::apply('applyvideos','Apply');
        JToolBarHelper::cancel('CANCEL7','Cancel');
        $model = $this->getModel();
        $videoslist = $model->addvideosmodel();
		$this->assignRef('editvideo', $videoslist);
		parent::display();
	}
    function editvideos()
	{
  if(JRequest::getVar('userid','','get','int') && JRequest::getVar('userid','','get','int') == 62)
            {
        JToolBarHelper::title( JText::_( 'Admin Videos' ),'generic.png' );
            }
    else {
        JToolBarHelper::title( JText::_( 'Member Videos' ),'generic.png' );
        }
        JToolBarHelper::save('savevideos','Save');
        JToolBarHelper::apply('applyvideos','Apply');
        JToolBarHelper::cancel('CANCEL7','Cancel');
        $model = $this->getModel();		
        $editvideoslist = $model->editvideosmodel();		
		$this->assignRef('editvideo', $editvideoslist);
	    parent::display();
	}
     

}
?>   
