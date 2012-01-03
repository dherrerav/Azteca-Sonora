<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/sortorder/view.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    HTML View class for the backend of the details Component edit task
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewsortorder extends JView {

    function categorysortorder() {
        $model = $this->getModel();
        $sortorder = $model->categorysortordermodel();
    }

    function videosortorder() {
        $model = $this->getModel();
        $sortorder = $model->videosortordermodel();
    }
}
?>   
