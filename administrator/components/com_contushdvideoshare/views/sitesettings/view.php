<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class contushdvideoshareViewsitesettings extends JView
{
    function display()
    {
        if(JRequest::getVar('task')=='edit' || JRequest::getVar('task')=='' )
        {
            JToolBarHelper::title('Site Settings'.': [<small>Edit</small>]');
            JToolBarHelper::save();
            $model = $this->getModel();
            $id=1;
            $setting = $model->getsitesetting($id);
            $this->assignRef('sitesettings', $setting[0]);
            $this->assignRef('jomcomment', $setting[1]);
            $this->assignRef('jcomment', $setting[2]);
            parent::display();
        }
    }
}
?>
