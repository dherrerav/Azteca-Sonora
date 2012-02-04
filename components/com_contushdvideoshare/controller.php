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
jimport('joomla.application.component.controller');

class contushdvideoshareController extends JController {

    function display() {
        $db = & JFactory::getDBO();
        $query = "select language_settings,user_login from #__hdflv_site_settings where published=1";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        define('USER_LOGIN', $rows[0]->user_login);
        require_once("components/com_contushdvideoshare/language/" . $rows[0]->language_settings);
        $viewName = JRequest::getVar('view');
        if ($viewName != "languagexml" && $viewName != "configxml" && $viewName != "playxml") 
         {
   ?>
<!--            <script src="<?php //echo JURI::base(); ?>components/com_contushdvideoshare/js/tool_tip.js"></script>-->
            <link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_contushdvideoshare/css/tool_tip.css" type="text/css" />
<?php
        }
        $this->getdisplay($viewName);
        if ($viewName == "" || $viewName == "index")
            $this->getdisplay('player');
    }

    function getdisplay($viewName="index") {
        $document = & JFactory::getDocument();
        $viewType = $document->getType();
        $view = & $this->getmodView($viewName, $viewType);
//        echo $viewName;
        $model = & $this->getModel($viewName, 'Modelcontushdvideoshare');
//

        if (!JError::isError($model)) {

            $view->setModel($model, true);
        }
     
        $view->display();
        
    }

    function &getmodView($name = '', $type = '', $prefix = '', $config = array()) {
        static $views;
        if (empty($prefix))
        {
            $prefix = $this->getName() . 'View';
        }
        if (empty($views[$name]))
         {
            if(version_compare(JVERSION,'1.6.0','ge'))
        {
            if ($view = & $this->createView($name, $prefix, $type, $config))
            {
                $views[$name] = & $view;
            }
            else
            {
                header("Location:index.php?option=com_contushdvideoshare&view=player&itemid=0");
            }
        }
         else
          {
                if ($view = & $this->_createView($name, $prefix, $type, $config))
            {
                $views[$name] = & $view;
            }
            else
            {
                header("Location:index.php?option=com_contushdvideoshare&view=player&itemid=0");
            }
           }
        }

        return $views[$name];
    }

    function adsxml()
    {
        $view = & $this->getView('adsxml');
        if ($model = & $this->getModel('adsxml'))
        {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->display();
    }
// viewed Ad's for player
    function impressionclicks()
    {
        $view = & $this->getView('impressionclicks');
        if ($model = & $this->getModel('impressionclicks'))
        {
            $view->setModel($model, true);
        }
        $view->display();
    }

    function videourl()
    {
        $view = & $this->getView('videourl');
        if ($model = & $this->getModel('videourl'))
         {
            //Push the model into the view (as default)
            //Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->getvideourl();
    }
}
?>

