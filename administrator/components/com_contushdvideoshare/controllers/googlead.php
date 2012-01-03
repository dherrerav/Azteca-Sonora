<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        googlead.php
 * @location    /components/com_contushdvideosahre/controller/googlead.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   Google Ad Administrator Controller
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControllergooglead extends JController {

    function display() {
        $viewName = JRequest::getVar('view', 'googlead');
        $viewLayout = JRequest::getVar('layout', 'googlead');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('googlead')) {
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
        $model = & $this->getModel('googlead');
        $model->savegooglead($detail);
        $this->setRedirect('index.php?layout=googlead&option=' . JRequest::getVar('option'), 'Google Ad Saved!');
    }

    function publish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('googlead');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=googlead&option=' . JRequest::getVar('option'));
    }

    function unpublish() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('googlead');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=googlead&option=' . JRequest::getVar('option'));
    }

    function apply() {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('googlead');
        $model->savegooglead($detail);
        $link = 'index.php?option=com_contushdvideoshare&layout=googlead&task=edit&cid[]=' . $detail['id'];
        $this->setRedirect($link, 'Google Ad Apply!');
    }
}

?>
