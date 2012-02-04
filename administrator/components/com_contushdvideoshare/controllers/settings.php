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

class contushdvideoshareControllersettings extends JController {

    function display()
    {

        $viewName = JRequest::getVar('view', 'settings');
        $viewLayout = JRequest::getVar('layout', 'settings');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('settings'))
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
        $model = & $this->getModel('settings');
        $model->saveplayersettings('save');
        $this->setRedirect('index.php?layout=settings&option=' . JRequest::getVar('option'), 'Settings Saved!');
    }
    function apply()
    {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('settings');
        $model->saveplayersettings('apply');
    }

    function cancel()
    {
        $this->setRedirect('index.php?layout=settings&option=' . JRequest::getVar('option'), 'Cancelled...');
    }

}

?>
