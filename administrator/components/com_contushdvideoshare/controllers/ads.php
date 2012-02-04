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
class contushdvideoshareControllerads extends JController {

    function display()
    {
        $view = & $this->getView('showads');
        if ($model = & $this->getModel('showads'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('showadslayout');
        $view->showads();
    }

    function addads()
    {
        $view = & $this->getView('ads');
        // Get/Create the model
        if ($model = & $this->getModel('addads'))
        {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->setLayout('adslayout');
        $view->ads();
    }
    function editads()
    {
        $view = & $this->getView('ads');
        // Get/Create the model
        if ($model = & $this->getModel('editads'))
        {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->setLayout('adslayout');
        $view->editads();
    }
    function saveads()
    {
        // Get/Create the model
        if ($model = & $this->getModel('showads')) {
        //Push the model into the view (as default)
        //Second parameter indicates that it is the default model for the view
        $model->saveads(JRequest::getVar('task'));
        }
    }
    function applyads()
    {
        // Get/Create the model
        if ($model = & $this->getModel('showads'))
         {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $model->saveads(JRequest::getVar('task'));
        }
    }

    function removeads()
    {
        if ($model = & $this->getModel('editads'))
        {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $model->removeads();
        }
    }

    function CANCEL6()
    {
        $view = & $this->getView('showads');
        // Get/Create the model
        if ($model = & $this->getModel('showads'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('showadslayout');
        $view->showads();
    }
     function publish() {
        $adshow = JRequest::get('POST');
        $model = & $this->getModel('showads');
        $model->pubads($adshow);
    }

    function unpublish() {
        $adshow = JRequest::get('POST');
        $model = & $this->getModel('showads');
        $model->pubads($adshow);
    }
}