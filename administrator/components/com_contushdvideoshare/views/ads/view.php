<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/ads/view.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   HTML View class for the backend of the details Component edit task
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewads extends JView {

    function ads() {
        JToolBarHelper::title(JText::_('Ads'), 'generic.png');
        JToolBarHelper::save('saveads', 'Save');
        JToolBarHelper::apply('applyads', 'Apply');
        JToolBarHelper::cancel('CANCEL6', 'Cancel');
        $model = $this->getModel();
        $adslist = $model->addadsmodel();
        $this->assignRef('adslist', $adslist);
        parent::display();
    }

    function editads() {
        JToolBarHelper::title(JText::_('Ads'), 'generic.png');
        JToolBarHelper::save('saveads', 'Save');
        JToolBarHelper::apply('applyads', 'Apply');
        JToolBarHelper::cancel('CANCEL6', 'Cancel');
        $model = $this->getModel();
        $editlist = $model->editadsmodel();
        $this->assignRef('adslist', $editlist);
        parent::display();
    }
}
?>   
