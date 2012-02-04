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
jimport('joomla.access.access');
jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

/**
 * HTML View class for the backend of the details Component edit task
 *
 * @package    HelloWorld
 */
class contushdvideoshareViewshowvideos extends JView {

    function showvideos() {

        $user = & JFactory::getUser();
        if(JRequest::getVar('userid', '', 'get'))
        {
        JToolBarHelper::title(JText::_('Admin Videos'), 'generic.png');
        }
        else
        {
            JToolBarHelper::title(JText::_('Member Videos'), 'generic.png');
        }
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::custom($task = 'featured', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable Featured', $listSelect = true);
        JToolBarHelper::custom($task = 'unfeatured', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable Featured', $listSelect = true);
        $userId = (JRequest::getVar('userid', '', 'get', 'int')) ? JRequest::getVar('userid', '', 'get', 'int') : 0;
        
        // Joomla! 1.6 code here
        if(version_compare(JVERSION,'1.6.0','ge'))
        {
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.id AS group_id')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $ugp->group_id;
        $uid = JRequest::getVar('userid', '', 'get', 'int');
        $usertype = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? JRequest::getVar('actype', '', 'get', 'string') : 0;


        if ($ugp->group_id == "8") {
            JToolBarHelper::deleteList('', 'Removevideos');
                        JToolBarHelper::editList('editvideos', 'Edit');
            //JToolBarHelper::deleteList('', 'Removevideos');
        }
        if ((($ugp->group_id == "7") || ($ugp->group_id == "8") || ($ugp->group_id == "6")) && ($userId == 62)) {
            JToolBarHelper::addNew('addvideos', 'New Video');
        }
        }
        // Joomla! 1.5 code here
        else
        {
        if (($user->gid == "25") && ($userId == 62) || ($userId == 0)) {
            JToolBarHelper::deleteList('', 'Removevideos');
            JToolBarHelper::editList('editvideos', 'Edit');
            if ((($user->gid == "25") || ($user->gid == "23")) && ($userId == 62)) {
                JToolBarHelper::addNew('addvideos', 'New Video');
            }
        }
        }
        
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
