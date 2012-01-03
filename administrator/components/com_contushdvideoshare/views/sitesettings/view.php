<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/sitesettings/view.php
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

class contushdvideoshareViewsitesettings extends JView {

    function display() {
        if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == '') {
            JToolBarHelper::title('Site Settings' . ': [<small>Edit</small>]');
            JToolBarHelper::save('save', 'save');
            $model = $this->getModel();
            $id = 1;
            $setting = $model->getsitesetting($id);
            $this->assignRef('sitesettings', $setting[0]);
            $this->assignRef('jomcomment', $setting[1]);
            $this->assignRef('jcomment', $setting[2]);
            parent::display();
        }
    }

}

?>
