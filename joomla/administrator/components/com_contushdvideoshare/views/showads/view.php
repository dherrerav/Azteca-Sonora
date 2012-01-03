<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/showads/view.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    HTML View class for the backend of the details Component edit task
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewshowads extends JView {

    function showads() {
        JToolBarHelper::title(JText::_('Ads'), 'generic.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::addNew('addads', 'New Ads');
        JToolBarHelper::editList('editads', 'Edit');
        JToolBarHelper::deleteList('', 'removeads');
        $model = $this->getModel();
        $showads = $model->showadsmodel();
        $this->assignRef('showads', $showads);
        parent::display();
    }
}
?>   
