<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        sortorder.php
 * @location    /components/com_contushdvideosahre/controller/sortorder.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :  details Component Administrator Controller
 */

//NO direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class contushdvideoshareControllersortorder extends JController {

    // Get & Create the model
    function display() {
        $view = & $this->getView('sortorder');
        if ($model = & $this->getModel('sortorder')) {
            $view->setModel($model, true);
        }
        $view->setLayout('sortorderlayout');
        $task = JRequest::getVar('task', 'get', '', 'string');
        if ($task == 'videos')
            $view->videosortorder();
        else
            $view->categorysortorder();
    }
}

?>
