<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        settings.php
 * @location    /components/com_contushdvideosahre/controller/settings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :  player settings Administrator Controller
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControllersettings extends JController {

    function display() {
        $viewName = JRequest::getVar('view', 'settings');
        $viewLayout = JRequest::getVar('layout', 'settings');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('settings')) {
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
        $model = & $this->getModel('settings');
        $model->saveplayersettings('save');
        $this->setRedirect('index.php?layout=settings&option=' . JRequest::getVar('option'), 'Player Settings Saved!');
    }
}

?>
