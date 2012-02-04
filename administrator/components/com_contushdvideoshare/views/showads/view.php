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

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the backend of the details Component edit task
 *
 * @package    HelloWorld
 */
class contushdvideoshareViewshowads extends JView {

    function showads() {
        JToolBarHelper::title(JText::_('Ads'), 'generic.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::addNew('addads', 'New Ad');
        JToolBarHelper::editList('editads', 'Edit');
        JToolBarHelper::deleteList('', 'removeads');
        $model = $this->getModel();
        $showads = $model->showadsmodel();
        $this->assignRef('showads', $showads);
        parent::display();
    }

}
?>   
