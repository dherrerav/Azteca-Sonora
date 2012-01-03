<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/adminvideos/view.php
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

class contushdvideoshareViewadminvideos extends JView {

    function adminvideos() {
        // check admin rights
        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.title AS group_name')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $ugp->group_name;
        if (JRequest::getVar('userid', '', 'get', 'int') && JRequest::getVar('userid', '', 'get', 'int') == 42) {
            JToolBarHelper::title(JText::_('Admin Videos'), 'generic.png');
        } else {
            JToolBarHelper::title(JText::_('Member Videos'), 'generic.png');
        }
        JToolBarHelper::save('savevideos', 'Save');
        JToolBarHelper::apply('applyvideos', 'Apply');
        JToolBarHelper::cancel('CANCEL7', 'Cancel');
        $model = $this->getModel();
        $videoslist = $model->addvideosmodel();
        $this->assignRef('editvideo', $videoslist);
        parent::display();
    }

    function editvideos() {
        if (JRequest::getVar('userid', '', 'get', 'int') && JRequest::getVar('userid', '', 'get', 'int') == 42) {
            JToolBarHelper::title(JText::_('Admin Videos'), 'generic.png');
        } else {
            JToolBarHelper::title(JText::_('Member Videos'), 'generic.png');
        }
        JToolBarHelper::save('savevideos', 'Save');
        JToolBarHelper::apply('applyvideos', 'Apply');
        JToolBarHelper::cancel('CANCEL7', 'Cancel');
        $model = $this->getModel();
        $editvideoslist = $model->editvideosmodel();
        $this->assignRef('editvideo', $editvideoslist);
        parent::display();
    }

}
?>   
