<?php

/**
 * @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
 * */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * category Component Administrator Controller
 */
class contushdvideoshareControllercategory extends JController {

    function display()
    {
        $viewName = JRequest::getVar('view', 'category');
        $viewLayout = JRequest::getVar('layout', 'category');

        //$viewLayout='listLayout';
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('category'))
        {
            $view->setModel($model, true);
        }
       
        $view->setLayout($viewLayout);
        $view->display();
    }

    function edit()
    {
        $this->display();
    }
    function save()
    {
        $detail = JRequest::get('POST');
        //print_r($detail);
        $model = & $this->getModel('category');
        $model->savecategary($detail);
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'), 'categary Saved!');
    }

    function add()
    {
        $this->display();
    }

    function remove()
    {
        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array'); //Reads cid as an array
        if ($arrayIDs[0] === null)
        { //Make sure the cid parameter was in the request
            JError::raiseError(500, 'cid parameter missing from the request');
        }
        $model = & $this->getModel('category');
        $model->deletecategary($arrayIDs);
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'), 'Deleted...');
    }

    function cancel()
    {
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'), 'Cancelled...');
    }

    function publish()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('category');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'));
    }

    function unpublish()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('category');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'));
    }

    function apply()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('category');
        $model->savecategary($detail);
        $link = 'index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]=' . $detail['id'];
        $this->setRedirect($link, 'Category Saved!');
    }

}
?>
