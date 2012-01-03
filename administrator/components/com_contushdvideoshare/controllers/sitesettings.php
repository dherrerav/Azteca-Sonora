<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        sitesettings.php
 * @location    /components/com_contushdvideosahre/controller/sitesettings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description : site setting Administrator Controller
 */

//NO direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
class contushdvideoshareControllersitesettings extends JController {

    function display() {
        $viewName = JRequest::getVar('view', 'sitesettings');
        $viewLayout = JRequest::getVar('layout', 'sitesettings');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('sitesettings')) {
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
        $model = & $this->getModel('sitesettings');
        $model->savesitesettings($detail);
        $this->setRedirect('index.php?layout=sitesettings&option=' . JRequest::getVar('option'), 'Site Settings Saved!');
    }
}

?>
