<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        adminvideos.php
 * @location    /components/com_contushdvideosahre/controller/adminvideos.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Admin Videos Administrator Controller
 *                  View  : Push the model into the view (as default)
 *                  Model : Second parameter indicates that it is the default model for the view
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControlleradminvideos extends JController {

    function display() {
        $view = & $this->getView('showvideos');
        if ($model = & $this->getModel('showvideos')) {
            $view->setModel($model, true);
        }
        $view->setLayout('showvideoslayout');
        $view->showvideos();
    }

    function addvideos() {
        $view = & $this->getView('adminvideos');
        if ($model = & $this->getModel('addvideos')) {
            $view->setModel($model, true);
        }
        $view->setLayout('adminvideoslayout');
        $view->adminvideos();
    }

    function editvideos() {
        $view = & $this->getView('adminvideos');
        if ($model = & $this->getModel('editvideos')) {
            $view->setModel($model, true);
        }
        $view->setLayout('adminvideoslayout');
        $view->editvideos();
    }

    function savevideos() {
        if ($model = & $this->getModel('showvideos')) {
            $model->savevideos(JRequest::getVar('task'));
        }
    }

    function applyvideos() {
        if ($model = & $this->getModel('showvideos')) {
            $model->savevideos(JRequest::getVar('task'));
        }
    }

    function removevideos() {
        if ($model = & $this->getModel('editvideos')) {
            $model->removevideos();
        }
    }

    function CANCEL7() {
        $view = & $this->getView('showvideos');
        if ($model = & $this->getModel('showvideos')) {
            $view->setModel($model, true);
        }
        $view->setLayout('showvideoslayout');
        $view->showvideos();
    }

    function featured() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('showvideos');
        $model->featuredvideo($detail);
        $this->setRedirect('index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&actype=' . JRequest::getVar('actype'));
    }

    function unfeatured() {
        $this->featured();
    }

    function publish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('showvideos');
        $model->pubvideo($detail);
        $this->setRedirect('index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&actype=' . JRequest::getVar('actype'));
    }

    function unpublish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('showvideos');
        $model->pubvideo($detail);
        $this->setRedirect('index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&actype=' . JRequest::getVar('actype'));
    }

}