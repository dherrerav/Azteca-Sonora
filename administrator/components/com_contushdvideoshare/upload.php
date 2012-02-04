<?php
/**
 * @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
 **/
session_start();
session_regenerate_id();

$target_path = "";
$error = "";
$errorcode = 12;
$errormsg[0] = "<b>Upload Success:</b> File Uploaded Successfully";
$errormsg[1] = "<b>Upload Cancelled:</b> Cancelled by user";
$errormsg[2] = "<b>Upload Failed:</b> Invalid File type specified";
$errormsg[3] = "<b>Upload Failed:</b> Your File Exceeds Server Limit size";
$errormsg[4] = "<b>Upload Failed:</b> Unknown Error Occured";
$errormsg[5] = "<b>Upload Failed:</b> The uploaded file exceeds the upload_max_filesize directive in php.ini";
$errormsg[6] = "<b>Upload Failed:</b> The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
$errormsg[7] = "<b>Upload Failed:</b> The uploaded file was only partially uploaded";
$errormsg[8] = "<b>Upload Failed:</b> No file was uploaded";
$errormsg[9] = "<b>Upload Failed:</b> Missing a temporary folder";
$errormsg[10] = "<b>Upload Failed:</b> Failed to write file to disk";
$errormsg[11] = "<b>Upload Failed:</b> File upload stopped by extension";
$errormsg[12] = "<b>Upload Failed:</b> Unknown upload error.";
$errormsg[13] = "<b>Upload Failed:</b> Please check post_max_size in php.ini settings";

$clientupload_val="false";

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

if (isset($_GET['processing'])) {
    $pro = $_GET['processing'];
}

if (isset($_GET['clientupload'])) {
    $clientupload_val = $_GET['clientupload'];
}







if (isset($_POST['mode'])) {
    $exttype = $_POST['mode'];
    if ($exttype == 'video')
        $allowedExtensions = array("mp3","MP3","flv", "FLV", "mp4", "MP4" , "m4v", "M4V", "M4A", "m4a", "MOV", "mov", "mp4v", "Mp4v", "F4V", "f4v");
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
                    doupload($file,$clientupload_val);
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

function doupload($file,$clientupload_val) {
    global $errorcode;
    global $target_path;
    $destination_path="images/uploads/";
    if($clientupload_val=="true") {
        $destination=realpath(dirname(__FILE__).'/../../../components/com_contushdvideoshare/videos/');
        $destination_path=str_replace('\\', '/', $destination)."/";

    }
    $target_path = $destination_path . session_id() . "." . end(explode(".", $file['name']));
    if(@move_uploaded_file($file['tmp_name'], $target_path)) {
        $errorcode = 0;
    }
    else {
        $errorcode = 4;
    }
    sleep(1);
}

?>
<script language="javascript" type="text/javascript">
    window.top.window.updateQueue(<?php echo $errorcode;
?>,"<?php echo $errormsg[$errorcode]; ?>","<?php echo $target_path; ?>");
</script>

