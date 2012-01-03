<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        ads.php
 * @location    /components/com_contushdvideosahre/controller/ads.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Ads Administrator Controller
 *                  Push the model into the view (as default)
 *                  Second parameter indicates that it is the default model for the view
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControllerads extends JController {

    
     // Get & Create the model
    function display() {
        $view = & $this->getView('showads');
        if ($model = & $this->getModel('showads')) {
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

    function addads() {
        $view = & $this->getView('ads');
        if ($model = & $this->getModel('addads')) {
            $view->setModel($model, true);
        }
        $view->setLayout('adslayout');
        $view->ads();
    }

    function editads() {

        $view = & $this->getView('ads');
        if ($model = & $this->getModel('editads')) {
            $view->setModel($model, true);
        }
        $view->setLayout('adslayout');
        $view->editads();
    }

    function saveads() {
        if ($model = & $this->getModel('showads')) {
            $model->saveads(JRequest::getVar('task'));
        }
    }

    function applyads() {
        if ($model = & $this->getModel('showads')) {
            $model->saveads(JRequest::getVar('task'));
        }
    }

    function removeads() {
        if ($model = & $this->getModel('editads')) {
            $model->removeads();
        }
    }

    function CANCEL6() {
        $view = & $this->getView('showads');
        if ($model = & $this->getModel('showads')) {
            $view->setModel($model, true);
        }
        $view->setLayout('showadslayout');
        $view->showads();
    }

}