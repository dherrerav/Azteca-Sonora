<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        category.php
 * @location    /components/com_contushdvideosahre/controller/category.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   Category Administrator Controller
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControllercategory extends JController {

    function display() {
        $viewName = JRequest::getVar('view', 'category');
        $viewLayout = JRequest::getVar('layout', 'category');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('category')) {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    function edit() {
        $this->display();
    }

    function save() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('category');
        $model->savecategary($detail);
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'), 'categary Saved!');
    }

    function add() {
        $this->display();
    }

    function remove() {
        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array'); //Reads cid as an array
        if ($arrayIDs[0] === null) { //Make sure the cid parameter was in the request
            JError::raiseError(500, 'cid parameter missing from the request');
        }
        $model = & $this->getModel('category');
        $model->deletecategary($arrayIDs);
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'), 'Deleted...');
    }

    function cancel() {
        $this->setRedirect('index.php?layout=category&option=' . JRequest::getVar('option'), 'Cancelled...');
    }

    function publish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('category');
        $model->pubcategary($detail);
    }

    function unpublish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('category');
        $model->pubcategary($detail);
    }

    function apply() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('category');
        $model->savecategary($detail);
        $link = 'index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]=' . $detail['id'];
        $this->setRedirect($link, 'Category Saved!');
    }
}

?>
