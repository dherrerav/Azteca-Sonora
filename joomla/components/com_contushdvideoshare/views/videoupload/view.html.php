<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.html.php
 * @location    /components/com_contushdvideosahre/views/videoupload/view.html.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :  get model & getupload model
 */
//No direct Access

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewvideoupload extends JView {

    function display() {

        $model = $this->getModel();
        $category = $model->getupload();
        $this->assignRef('videocategory', $category[0]);
        $this->assignRef('upload', $category[1]);
        $this->assignRef('videodetails', $category[2]);
        parent::display();
    }

}

?>