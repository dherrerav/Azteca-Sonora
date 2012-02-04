<?php

/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

/**
 * category Component Administrator Controller
 */
class contushdvideoshareControlleradminvideos extends JController {

    function display() {
        $view = & $this->getView('showvideos');
// Get/Create the model
        if ($model = & $this->getModel('showvideos')) {
            $view->setModel($model, true);
        }
        $view->setLayout('showvideoslayout');
        $view->showvideos();
    }

    function addvideos() {
        $view = & $this->getView('adminvideos');
        if ($model = & $this->getModel('addvideos'))
        {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->setLayout('adminvideoslayout');
        $view->adminvideos();
    }

    function editvideos()
    {
        $view = & $this->getView('adminvideos');
        // Get/Create the model
        if ($model = & $this->getModel('editvideos'))
         {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
         }
        $view->setLayout('adminvideoslayout');
        $view->editvideos();
    }

    function savevideos()
    {
        // Get/Create the model
        if ($model = & $this->getModel('showvideos'))
         {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $model->savevideos(JRequest::getVar('task'));
         }
    }

    function applyvideos()
    {
        // Get/Create the model
        if ($model = & $this->getModel('showvideos'))
         {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $model->savevideos(JRequest::getVar('task'));
         }
    }

    function removevideos()
    {
        if ($model = & $this->getModel('editvideos'))
         {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $model->removevideos();
        }
    }

    function CANCEL7()
    {
        $view = & $this->getView('showvideos');
        // Get/Create the model
        if ($model = & $this->getModel('showvideos'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('showvideoslayout');
        $view->showvideos();
    }

    function featured()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('showvideos');
        $model->featuredvideo($detail);
        $this->setRedirect('index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&userid=' . JRequest::getVar('userid'));
    }

    function unfeatured()
    {
        $this->featured();
    }

    function publish()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('showvideos');
        $model->pubvideo($detail);
        $this->setRedirect('index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&userid=' . JRequest::getVar('userid'));
    }

    function unpublish()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('showvideos');
        $model->pubvideo($detail);
        $this->setRedirect('index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&userid=' . JRequest::getVar('userid'));
    }

}