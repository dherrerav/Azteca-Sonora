<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.html.php
 * @location    /components/com_contushdvideosahre/views/membercollection/view.html.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :   Get Model & Get Membercollection and Meberpage rows and columns
 */
//No direct Access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewmembercollection extends JView {

    function display() {
        $model = $this->getModel();
        $membercollection = $model->getmembercollection();
        $this->assignRef('membercollection', $membercollection);
        $memberpagerowcol = $model->getmemberpagerowcol();
        $this->assignRef('memberpagerowcol', $memberpagerowcol);
        parent::display();
    }

}

?>