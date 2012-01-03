<?php

/*
 * "ContusHDVideoShare Component" - Version 1.2
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: June 15 2010
 */
// no direct access

defined('_JEXEC') or die('Restricted access');
jimport('joomla.access.access');
jimport('joomla.application.component.view');

/**
 * HTML View class for the backend of the details Component edit task
 *
 * @package    HelloWorld
 */
class contushdvideoshareViewshowvideos extends JView {

    function showvideos() {
        JToolBarHelper::title(JText::_('Upload Videos'), 'generic.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::custom($task = 'featured', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable Featured', $listSelect = true);
        JToolBarHelper::custom($task = 'unfeatured', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable Featured', $listSelect = true);

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
        $uid = JRequest::getVar('userid', '', 'get', 'int');
        $usertype = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? JRequest::getVar('actype', '', 'get', 'string') : 0;


        if (($usertype) && ($ugp->group_name == "Super Users")) {
            JToolBarHelper::deleteList('', 'Removevideos');
            JToolBarHelper::addNew('addvideos', 'New Video');
        }
        if ($ugp->group_name == "Super Users") {
            JToolBarHelper::editList('editvideos', 'Edit');
            JToolBarHelper::deleteList('', 'Removevideos');
        }
        if ((($ugp->group_name == "Administrator") || ($ugp->group_name == "Manager")) && ($usertype)) {
            JToolBarHelper::addNew('addvideos', 'New Video');
        }
// check admin rights
        $model = $this->getModel();
        $showvideos = $model->showvideosmodel();
        $this->assignRef('videolist', $showvideos);
        if (JRequest::getVar('page') == 'comment') {
            JToolBarHelper::title('Commetn' . ': [<small>Edit</small>]');
            JToolBarHelper::cancel();
            $model = $this->getModel('showvideos');
            $comment = $model->getcomment();
            $this->assignRef('comment', $comment);
            parent::display();
        } else {
            parent::display();
        }
    }

}
?>   
