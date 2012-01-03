<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/memberdetails/view.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Member details view page
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class contushdvideoshareViewmemberdetails extends JView {

    function display() {
        JToolBarHelper::title('Memberdetails', 'generic.png');
        JToolBarHelper::custom($task = 'allowupload', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable User upload', $listSelect = true);
        JToolBarHelper::custom($task = 'unallowupload', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable User upload', $listSelect = true);
        JToolBarHelper::publish('publish', 'Active');
        JToolBarHelper::unpublish('unpublish', 'Deactive');
        $model = $this->getModel('memberdetails');
        $memberdetails = $model->getmemberdetails();
        $this->assignRef('memberdetails', $memberdetails);
        parent::display();
    }

}

?>
