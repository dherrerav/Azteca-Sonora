<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/googlead/view.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    google ad view page
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewgooglead extends JView {

    function display() {
        JToolBarHelper::title('Google AdSence' . ': [<small>Edit</small>]');
        JToolBarHelper::save('save', 'save');
        $model = $this->getModel();
        $googlead = $model->getgooglead();
        $this->assignRef('googlead', $googlead);
        parent::display();
    }
}

?>
