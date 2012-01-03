<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        subcategory.php
 * @location    /components/com_contushdvideosahre/controller/subcategory.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
*/

/**
 * Description :  Channel front end Subcategory Component Administrator Controller
 */

//NO direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class contushdvideoshareControllersubcategory extends JController {

    //Function to display the subcategory list
    function display() {

        $viewName = JRequest::getVar('view', 'subcategory');
        $viewLayout = JRequest::getVar('layout', 'subcategory');
        //$viewLayout='listLayout';
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('subcategory')) {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

     // Function to edit a particular subcategory
    function edit() {
        $view = & $this->getView('subcategory');
        if ($model = & $this->getModel('subcategory')) {
            $view->setModel($model, true);
        }
        $view->setLayout('subcategoryform');
        $view->display();
    }

    // Function to save a subcategory
    function save() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->savesubcategory($detail);
        $this->setRedirect('index.php?layout=subcategory&option=' . JRequest::getVar('option'), 'Subcategory Saved!');
    }

    // Function to add a subcategory
    function add() {
        $view = & $this->getView('subcategory');
        if ($model = & $this->getModel('subcategory')) {
            $view->setModel($model, true);
        }
        $view->setLayout('subcategoryform');
        $view->display();
    }

     // Function to delete a subcategory
    function remove() {
        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array'); //Reads cid as an array
        if ($arrayIDs === null) { //Make sure the cid parameter was in the request
            JError::raiseError(500, 'cid parameter missing from the request');
        }
        $model = & $this->getModel('subcategory');
        $model->deletesubcategory($arrayIDs);
        $this->setRedirect('index.php?layout=subcategory&option=' . JRequest::getVar('option'), 'Deleted...');
    }

    // Function to cancel some operation
    function cancel() {
        $this->setRedirect('index.php?layout=subcategory&option=' . JRequest::getVar('option'), 'Cancelled...');
    }

    // Function to publish a subcategory
    function publish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->pubsubcategory($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=subcategory');
    }

    // Function to unpublish a subcategory
    function unpublish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->pubsubcategory($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=subcategory');
    }

    // Function to store and stay on the same page till we click on save button[Apply]
    function apply() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('subcategory');
        $model->savesubcategory($detail);
        $link = 'index.php?option=com_contushdvideoshare&layout=subcategory&task=edit&cid[]=' . $detail['subcategory_id'];
        $this->setRedirect($link, 'Subcategory Saved!');
    }

}

?>
