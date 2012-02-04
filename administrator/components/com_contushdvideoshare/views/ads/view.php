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

jimport( 'joomla.application.component.view');

/**
     * HTML View class for the backend of the details Component edit task
     *
     * @package    HelloWorld
     */

class contushdvideoshareViewads extends JView
{
	function ads()
	{
        JToolBarHelper::title( JText::_( 'Ads' ),'generic.png' );
        JToolBarHelper::save('saveads','Save');
        JToolBarHelper::apply('applyads','Apply');
        JToolBarHelper::cancel('CANCEL6','Cancel');
        $model = $this->getModel();
        $adslist = $model->addadsmodel();
		$this->assignRef('adslist', $adslist);
		parent::display();
	}
    function editads()
	{
        JToolBarHelper::title( JText::_( 'Ads' ),'generic.png' );
        JToolBarHelper::save('saveads','Save');
        JToolBarHelper::apply('applyads','Apply');
        JToolBarHelper::cancel('CANCEL6','Cancel');
        $model = $this->getModel();
        $editlist = $model->editadsmodel();
	$this->assignRef('adslist', $editlist);
	parent::display();
	}
     

}
?>   
