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

class contushdvideoshareControllersitesettings extends JController
{

    function display()
    {

        $viewName = JRequest::getVar('view', 'sitesettings');
        $viewLayout = JRequest::getVar('layout', 'sitesettings');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('sitesettings'))
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
        $model = & $this->getModel('sitesettings');
        $model->savesitesettings($detail);
        $this->setRedirect('index.php?layout=sitesettings&option=' . JRequest::getVar('option'), 'Site Settings Saved!');
    }

}

?>
