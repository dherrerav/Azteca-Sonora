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

class contushdvideoshareViewsettings extends JView {

    function display() {

//    echo JRequest::getVar('task');
        if (JRequest::getVar('task') == 'edit') {

            JToolBarHelper::title('Player Settings' . ': [<small>Edit</small>]');
            JToolBarHelper::save();
            JToolBarHelper::apply();
            JToolBarHelper::cancel();
            $model = $this->getModel();
            $playersettings = $model->playersettingsmodel();
            $this->assignRef('playersettings', $playersettings);
            parent::display();
        }

        if (JRequest::getVar('task') == '') {
            JToolBarHelper::title('Player Settings', 'generic.png');
            JToolBarHelper::editListX();
            $model = $this->getModel();
            $playersettings = $model->getsetting();
            $this->assignRef('playersettings', $playersettings);
            parent::display();
        }
    }

}

?>
