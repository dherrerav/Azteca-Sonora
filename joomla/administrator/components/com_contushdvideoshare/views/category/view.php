<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/category/view.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Category view page
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewcategory extends JView {
    function display() {
        if (JRequest::getVar('task') == 'edit') {
            JToolBarHelper::title('Category' . ': [<small>Edit</small>]');
            JToolBarHelper::save();
            JToolBarHelper::apply();
            JToolBarHelper::cancel();
            $model = $this->getModel();
            $id = JRequest::getVar('cid');
            $categary = $model->getcategary($id[0]);
            $this->assignRef('categary', $categary[0]);
            $this->assignRef('categorylist', $categary[1]);
            parent::display();
        }
        if (JRequest::getVar('task') == 'add') { {
                JToolBarHelper::title('Category' . ': [<small>Add</small>]');
                JToolBarHelper::save();
                JToolBarHelper::cancel();
                $model = $this->getModel();
                $categary = $model->getNewcategary();
                $this->assignRef('categary', $categary[0]);
                $this->assignRef('categorylist', $categary[1]);
                parent::display();
            }
        }
        if (JRequest::getVar('task') == '') {
            JToolBarHelper::title('Category', 'generic.png');
            JToolBarHelper::publishList();
            JToolBarHelper::unpublishList();
            JToolBarHelper::deleteList();
            JToolBarHelper::editListX();
            JToolBarHelper::addNewX();
            $model = $this->getModel('category');
            $category = $model->getcategory();
            $this->assignRef('category', $category);
            parent::display();
        }
    }
}

?>
