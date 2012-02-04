<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
session_start();
session_regenerate_id();
define( '_JEXEC', 1 );

$str= dirname(__FILE__);
if (strstr("localhost", $_SERVER['HTTP_HOST'])) {
$str = str_replace('\components\com_contushdvideoshare\views\videoupload\tmpl','',$str);
}
else
{
// To use it in Server
$str = str_replace('/components/com_contushdvideoshare/views/videoupload/tmpl','',$str);

}


define('JPATH_BASE',$str);
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

/**
 * CREATE THE APPLICATION
 *
 * NOTE :
 */
$mainframe =& JFactory::getApplication('site');
$db =& JFactory::getDBO();
          $query = "select language_settings from #__hdflv_site_settings where published=1";//and id=2";
            $db->setQuery( $query );
            $rows = $db->loadObjectList();

        include("../../../language/".$rows[0]->language_settings);
$target_path = '';
$error = "";
$errorcode = 12;
$errormsg[0] = "<b>" . _HDVS_UPLOAD_SUCCESS . ":</b> "._HDVS_FILE_UPLOAD_SUCCESSFULLY;
$errormsg[1] = "<b>"._HDVS_UPLOAD_CANCELLED.":</b> "._HDVS_CANCELLED_BY_USER;
$errormsg[2] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_INVALID_FILE_TYPE_SPECIFIED;
$errormsg[3] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_YOUR_FILE_EXCEEDS_SERVER_LIMIT_SIZE;
$errormsg[4] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_UNKNOWN_ERROR_OCCURED;
$errormsg[5] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_UPLOAD_FILE_EXCEEDS_THE_UPLOAD_MAX_FILESIZE_DIRECTIVE;
$errormsg[6] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_UPLOAD_FILE_EXCEEDS_THE_UPLOAD_MAX_FILESIZE_DIRECTIVE_THAT_WAS_SPECIFIED;
$errormsg[7] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_THE_UPLOAD_FILE_WAS_ONLY_PARTIALLY_UPLOADED;
$errormsg[8] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_NO_FILE_WAS_UPLOADED;
$errormsg[9] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_MISSING_A_TEMORARY_FOLDER;
$errormsg[10] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_FAILED_TO_WRITE_FILE_TO_DISK;
$errormsg[11] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_FILE_UPLOAD_STOPPED_BY_EXTENSION;
$errormsg[12] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_UNKNOWN_UPLOAD_ERROR;
$errormsg[13] = "<b>"._HDVS_UPLOAD_FAILED.":</b> "._HDVS_PLEASE_CHECK_PHPINI_SETTINGS;




if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

if (isset($_GET['processing'])) {
     $pro = $_GET['processing'];

}

if (isset($_POST['mode']))
    {
        $exttype = $_POST['mode'];
        if ($exttype == 'video')
       $allowedExtensions = array("flv", "FLV", "mp4", "MP4" , "m4v", "M4V", "M4A", "m4a", "MOV", "mov", "mp4v", "Mp4v", "F4V", "f4v");
        else if ($exttype == 'image')
        $allowedExtensions = array("jpg", "JPG", "png", "PNG");
        else if ($exttype == 'video_ffmpeg')
    $allowedExtensions = array("avi","AVI","dv","DV","3gp","3GP","3g2","3G2","mpeg","MPEG","wav","WAV","rm","RM","mp3","MP3","flv", "FLV", "mp4", "MP4" , "m4v", "M4V", "M4A", "m4a", "MOV", "mov", "mp4v", "Mp4v", "F4V", "f4v");


    }

//check if upload cancelled
if (!iserror()) {
    //check if stopped by post_max_size
    if (($pro == 1) && (empty($_FILES['myfile']))) {
        $errorcode = 13;
    }
    else {
        $file = $_FILES['myfile'];
        if (no_file_upload_error($file)) {

            if (isAllowedExtension($file)) {
                //check file size
                if (!filesizeexceeds($file)) {
                    doupload($file);
                }
            }
        }
    }
}

function iserror() {
    global $error;
    global $errorcode;
    if ($error == "cancel") {
        $errorcode = 1;
        return true;
    }
    else {
        return false;
    }
}

function no_file_upload_error($file) {
    global $errorcode;
    $error_code = $file['error'];
    //echo $error_code;
    //exit();
   switch ($error_code) {
        case 1:
            $errorcode = 5;
            return false;
        case 2:
            $errorcode = 6;
            return false;
        case 3:
            $errorcode = 7;
            return false;
        case 4:
            $errorcode = 8;
            return false;
        case 6:
            $errorcode = 9;
            return false;
        case 7:
            $errorcode = 10;
            return false;
        case 8:
            $errorcode = 11;
            return false;
        case 0:
            return true;
        default:
            $errorcode = 12;
            return false;
    }
}

function isAllowedExtension($file) {
    global $allowedExtensions;
    global $errorcode;
    $filename = $file['name'];
    $output =  in_array(end(explode(".", $filename)), $allowedExtensions);
    if (!$output) {
        $errorcode = 2;
        return false;
    }
    else {
        return true;
    }

}

function filesizeexceeds($file) {
    $POST_MAX_SIZE = ini_get('post_max_size');
    $filesize = $file['size'];
    $mul = substr($POST_MAX_SIZE, -1);
    $mul = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));
    if ($_SERVER['CONTENT_LENGTH'] > $mul*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
        return true;
        $errorcode = 3;
    }
    else {
        return false;
    }
}

function doupload($file) {
    global $errorcode;
    global $target_path;
    $destination_path ="../../../videos/";
    $target_path = $destination_path . session_id() . "." . end(explode(".", $file['name']));
    if(@move_uploaded_file($file['tmp_name'], $target_path)) {
        $errorcode = 0;
    }
    else {
        $errorcode = 4;
    }
    sleep(1);
}
//echo $errormsg[$errorcode];

?>
<script language="javascript" type="text/javascript">window.top.window.updateQueue(<?php echo $errorcode;
?>,"<?php echo $errormsg[$errorcode]; ?>","<?php echo $target_path; ?>");</script>

