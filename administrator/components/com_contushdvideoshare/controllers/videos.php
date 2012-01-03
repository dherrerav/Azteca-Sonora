<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        videos.php
 * @location    /components/com_contushdvideosahre/controller/videos.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :  videos Component Administrator Controller
 */

//NO direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControllervideos extends JController {

    function display() {

        $viewName = JRequest::getVar('view', 'videos');
        $viewLayout = JRequest::getVar('layout', 'videos');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('videos')) {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    function remove() {

        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array'); //Reads cid as an array
        if ($arrayIDs === null) { //Make sure the cid parameter was in the request
            JError::raiseError(500, 'cid parameter missing from the request');
        }
        $model = & $this->getModel('videos');
        $model->deletevideo($arrayIDs);
        $this->setRedirect('index.php?layout=videos&option=' . JRequest::getVar('option'), 'Deleted...');
    }

    function publish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('videos');
        $model->pubvideo($detail);
        $this->setRedirect('index.php?layout=videos&option=' . JRequest::getVar('option'));
    }

    function unpublish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('videos');
        $model->pubvideo($detail);
        $this->setRedirect('index.php?layout=videos&option=' . JRequest::getVar('option'));
    }

    function featured() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('videos');
        $model->featuredvideo($detail);
        $this->setRedirect('index.php?layout=videos&option=' . JRequest::getVar('option'));
    }

    function unfeatured() {
        $this->featured();
    }

    function cancel() {
        $this->setRedirect('index.php?layout=videos&option=' . JRequest::getVar('option'));
    }

    function comment() {
        $this->display();
    }

}

?>
