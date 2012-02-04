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
 * googlead Component Administrator Controller
 */
class contushdvideoshareControllergooglead extends JController {

    function display()
    {

        $viewName = JRequest::getVar('view', 'googlead');
        $viewLayout = JRequest::getVar('layout', 'googlead');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('googlead'))
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
        $model = & $this->getModel('googlead');
        $model->savegooglead($detail);
        $this->setRedirect('index.php?layout=googlead&option=' . JRequest::getVar('option'), 'Google Ad Saved!');
    }

    function publish()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('googlead');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=googlead&option=' . JRequest::getVar('option'));
    }

    function unpublish()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('googlead');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=googlead&option=' . JRequest::getVar('option'));
    }

    function apply()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('googlead');
        $model->savegooglead($detail);
        $link = 'index.php?option=com_contushdvideoshare&layout=googlead&task=edit&cid[]=' . $detail['id'];
        $this->setRedirect($link, 'Google Ad Apply!');
    }
}
?>
