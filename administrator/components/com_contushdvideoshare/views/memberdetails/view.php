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

jimport('joomla.application.component.view');

class contushdvideoshareViewmemberdetails extends JView {

    function display() {

        JToolBarHelper::title('Memberdetails', 'generic.png');
        JToolBarHelper::custom($task = 'allowupload', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable User upload', $listSelect = true);
        JToolBarHelper::custom($task = 'unallowupload', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable User upload', $listSelect = true);
        JToolBarHelper::publish('publish', 'Active');
        JToolBarHelper::unpublish('unpublish', 'Deactive');
//		JToolBarHelper::deleteList();
        $model = $this->getModel('memberdetails');
        $memberdetails = $model->getmemberdetails();
        $this->assignRef('memberdetails', $memberdetails);

        parent::display();
    }

}

?>
