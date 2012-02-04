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

class contushdvideoshareViewgooglead extends JView {

    function display() {

        JToolBarHelper::title('Google AdSense' . ': [<small>Edit</small>]');
        JToolBarHelper::save();
  //    JToolBarHelper::apply();
        $model = $this->getModel();
        $googlead = $model->getgooglead();
        $this->assignRef('googlead', $googlead);
        parent::display();
    }

}

?>
