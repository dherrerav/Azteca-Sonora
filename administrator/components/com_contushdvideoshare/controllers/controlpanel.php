<?php

/**
 * @version     2.3, Creation Date : March-24-2011
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

class contushdvideoshareControllercontrolpanel extends JController {

    function display() {
        $viewName = JRequest::getVar('view', 'controlpanel');
        $viewLayout = JRequest::getVar('layout', 'controlpanel');
        $view = & $this->getView($viewName);
        if ($model = & $this->getModel('controlpanel')) {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

   
}

?>
