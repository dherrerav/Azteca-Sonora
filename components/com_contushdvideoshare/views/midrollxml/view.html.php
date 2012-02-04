<?php

/**
 * @version  $Id: view.php 2.3,  03-Feb-2011 $$
 * @package	Joomla
 * @subpackage	hdflvplayer
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Edited       Gopinath.A
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

//importing Default Component Model
jimport('joomla.application.component.view');

/*
 * Description : getads()
 *  This Function Call To UserDefined Ads Function
 */

class contushdvideoshareViewmidrollxml extends JView {

    function display() {
        $model = & $this->getModel();
        $detail = $model->getads();
        print_r($detail);
        exit();
    }

}
?>   
