<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        settings.php
 * @location    /components/com_contushdvideosahre/models/settings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Settings Administrator Models
 */

//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class contushdvideoshareModelsettings extends JModel {

    function getsetting() {
        $db = & JFactory::getDBO();
        $query = "SELECT * FROM #__hdflv_player_settings";
        $db->setQuery($query);
        $rs_editsettings = $db->loadObjectList();
        if (count($rs_editsettings)) {
            $id = $rs_editsettings[0]->id;
        }
        return $rs_editsettings;
    }

    function playersettingsmodel() {
        $db = & JFactory::getDBO();
        $query = "SELECT * FROM #__hdflv_player_settings";
        $db->setQuery($query);
        $total = $db->loadResult();
        if (count($total)) {
            return($this->showplayersettings());
        }
    }

    function showplayersettings() {
        $db = & JFactory::getDBO();
        $query = "SELECT * FROM #__hdflv_player_settings order by id asc limit 1";
        $db->setQuery($query);
        $rs_showsettings = $db->loadObjectList();
        if (count($rs_showsettings) >= 1) {
            return $rs_showsettings;
        }
    }

    function saveplayersettings($task) {
        $option = 'com_contushdvideoshare';
        $db = & JFactory::getDBO();
        $rs_savesettings = & JTable::getInstance('settings', 'Table');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $id = $cid[0];
        $rs_savesettings->load($id);
        if (!$rs_savesettings->bind(JRequest::get('post'))) {
            echo "<script> alert('" . $rs_savesettings->getError() . "');window.history.go(-1); </script>\n";
            exit();
        }
        if (!$rs_savesettings->store()) {
            echo "<script> alert('" . $rs_savesettings->getError() . "'); window.history.go(-1); </script>\n";
            exit();
        }
        // Validation for logopath
        $this->fn_imagevalidation_settings($_FILES['logopath']['name'], $task, $option, $id);
        if ($_FILES['logopath']['name'] != "") {
            $vpath = JPATH_SITE . DS . 'components' . DS . 'com_contushdvideoshare' . DS . 'videos' . DS;
            $vpath = str_replace('"', '', $vpath);
            $logo_name = $_FILES['logopath']['name'];
            $target_path_logo = $vpath . $_FILES['logopath']['name'];
            // To store images to a directory called localhost/components/com_contushdvideoshare/videos
            move_uploaded_file($_FILES['logopath']['tmp_name'], $target_path_logo);
            $query = "update #__hdflv_player_settings set logopath='$logo_name'";
            $db->setQuery($query);
            $db->query();
        }
        switch ($task) {
            case 'apply':
                $msg = 'Changes Saved';
                $link = 'index.php?option=' . $option . '&task=edit&layout=settings&cid[]=' . $rs_savesettings->id;
                break;
            case 'save':
            default:
                $msg = 'Saved';
                $link = 'index.php?option=' . $option . '&layout=settings';
                break;
        }

        // page redirect
        $app = & JFactory::getApplication();
        $app->redirect($link, 'Player Settings Saved!');
    }

    function fn_imagevalidation_settings(&$logoname, &$task, &$option, &$id) {
        $option = 'com_contushdvideoshare';
        global $mainframe;
        // Get file extension
        $exts = $this->findexts($logoname);
        // To make sure exts is exists
        if ($exts) {
            if (($exts != "png") && ($exts != "gif") && ($exts != "jpeg") && ($exts != "jpg")) { // To check file type
                JError::raiseWarning('SOME_ERROR_CODE', JText::_('File Extensions:Allowed Extensions for image file is .jpg,.jpeg,.png'));
                switch ($task) {
                    case 'apply':
                        $msg = 'Changes Saved';
                        $link = 'index.php?option=' . $option . '&task=edit&layout=playersettings&cid[]=' . $rs_savesettings->id;
                        break;
                    case 'save':
                    default:
                        $msg = 'Saved';
                        $link = 'index.php?option=' . $option . '&layout=playersettings';
                        break;
                }
                $app = & JFactory::getApplication();
                $app->redirect($link, 'Saved');
                exit();
            }
        }
    }

    function findexts($filename) {
        $filename = strtolower($filename);
        $exts = split("[/\\.]", $filename);
        $n = count($exts) - 1;
        $exts = $exts[$n];
        return $exts;
    }

}

?>
