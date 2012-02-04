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
jimport('joomla.application.component.controller');

/**
 * Channel front end Subcategory Component Administrator Controller
 */
class contushdvideoshareControllersubcategory extends JController {

    function display()
    { //Function to display the subcategory list
        $viewName = JRequest::getVar('view', 'subcategory');
        $viewLayout = JRequest::getVar('layout', 'subcategory');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('subcategory'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    function edit()
    { // Function to edit a particular subcategory
        $view = & $this->getView('subcategory');
        if ($model = & $this->getModel('subcategory'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('subcategoryform');
        $view->display();
    }

    function save()
    { // Function to save a subcategory
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->savesubcategory($detail);
        $this->setRedirect('index.php?layout=subcategory&option=' . JRequest::getVar('option'), 'Subcategory Saved!');
    }

    function add()
    { // Function to add a subcategory
        $view = & $this->getView('subcategory');
        if ($model = & $this->getModel('subcategory'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('subcategoryform');
        $view->display();
    }

    function remove()
    { // Function to delete a subcategory
        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array'); //Reads cid as an array
        if ($arrayIDs === null)
        { //Make sure the cid parameter was in the request
            JError::raiseError(500, 'cid parameter missing from the request');
        }
        $model = & $this->getModel('subcategory');
        $model->deletesubcategory($arrayIDs);
        $this->setRedirect('index.php?layout=subcategory&option=' . JRequest::getVar('option'), 'Deleted...');
    }

    function cancel()
    { // Function to cancel some operation
        $this->setRedirect('index.php?layout=subcategory&option=' . JRequest::getVar('option'), 'Cancelled...');
    }

    function publish()
    { // Function to publish a subcategory
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->pubsubcategory($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=subcategory');
    }

    function unpublish()
    { // Function to unpublish a subcategory
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->pubsubcategory($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=subcategory');
    }

    function apply()
    { // Function to store and stay on the same page till we click on save button[Apply]
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->savesubcategory($detail);
        $link = 'index.php?option=com_contushdvideoshare&layout=subcategory&task=edit&cid[]=' . $detail['subcategory_id'];
        $this->setRedirect($link, 'Subcategory Saved!');
    }
}
?>
