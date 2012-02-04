<?php
/**
 * @version     2.3, Creation Date : March-24-2011
 * @name        view.php
 * @location    /components/com_contushdvideosahre/views/settings/view.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Player settings view page
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewcontrolpanel extends JView {

    function display() {
       
        if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == '') {
            
           // JToolBarHelper::title('Player Settings' . ': [<small>Edit</small>]');
           // JToolBarHelper::save('save', 'save');
            $model = $this->getModel();
            $controlpaneldetails = $model->controlpaneldetails();
           $this->assignRef('controlpaneldetails', $controlpaneldetails);
            parent::display();
        }
    }
}
?>
