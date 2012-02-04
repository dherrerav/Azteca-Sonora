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

jimport( 'joomla.application.component.view');

/**
     * HTML View class for the backend of the details Component edit task
     *
     * @package    HelloWorld
     */

class contushdvideoshareViewcommentappend extends JView
{

	function display()
	{
            $model = $this->getModel();
            $getcomments = $model->getcomment();
            $this->assignRef('commenttitle', $getcomments[0]); // Assigning the reference for the results
            $this->assignRef('commenttitle1', $getcomments[1]); // Assigning the reference for the results
            $this->assignRef('playersettings', $getcomments[2]); // Assigning the reference for the results
            $commentsview = $model->ratting();
            $this->assignRef('commentview', $commentsview);
            parent::display();
	}

}
?>   
