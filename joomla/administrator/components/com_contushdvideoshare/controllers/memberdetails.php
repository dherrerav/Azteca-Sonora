<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        memberdetails.php
 * @location    /components/com_contushdvideosahre/controller/memberdetails.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :  Member Details Administrator Controller
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControllermemberdetails extends JController {

    function display() {
        $viewName = JRequest::getVar('view', 'memberdetails');
        $viewLayout = JRequest::getVar('layout', 'memberdetails');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('memberdetails')) {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    function publish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
    }

    function unpublish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
    }

    function allowupload() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');

        $model->pubupload($detail);
        $this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
    }

    function unallowupload() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');
        $model->pubupload($detail);
        $this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
    }
}

?>
