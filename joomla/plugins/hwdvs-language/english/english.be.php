<?php
/**
 *    @version [ Nightly Build ]
 *    @package hwdVideoShare
 *    @copyright (C) 2007 - 2009 Highwood Design
 *    @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 ***
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ***
 *    New Language Definitions are located at bottom of file
 *    DEFINITIONS HAVE FORM
 *    ---------------------
 *    DEFINE("_HWDVIDS_NAV_VIDEOS","Videos"); // Videos
 *           \___________________/  \_____/      \____/
 *            |                 |    |    \_____  \   \_____________________
 *            | PHP LANGUAGE    |    | LANGUAGE \__ \    COPY OF ORIGINAL   |
 *            | DEFINTIONS      |    | TRANSLATION |  \  ENGLISH DEFINITION |
 *            |_________________|    |_____________|    \___________________|
 ***
 *    TRANSLATOR CREDITS CAN GO HERE::
 *    ORIGINAL ENGLISH FILE BY HIGHWOOD DESIGN
 **/
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//Current Version

DEFINE("_HWDVIDS_TOOLBARTITLE","hwdVideoShare");
DEFINE("_HWDVIDS_HOME_01","Welcome to hwdVideoShare");

//Backend Section Headers

DEFINE("_HWDVIDS_SECTIONHEAD_VIDEOS","Videos");
DEFINE("_HWDVIDS_SECTIONHEAD_CATS","Categories");
DEFINE("_HWDVIDS_SECTIONHEAD_GROUPS","Groups");
DEFINE("_HWDVIDS_SECTIONHEAD_APPROVALS","Waiting Approvals");
DEFINE("_HWDVIDS_SECTIONHEAD_FLAGGED","Reported Media");
DEFINE("_HWDVIDS_SECTIONHEAD_COMMENTS","Comments");
DEFINE("_HWDVIDS_SECTIONHEAD_SS","Server Settings");
DEFINE("_HWDVIDS_SECTIONHEAD_GS","General Settings");
DEFINE("_HWDVIDS_SECTIONHEAD_BCUP","Backup Data");
DEFINE("_HWDVIDS_SECTIONHEAD_RSTR","Restore Data");
DEFINE("_HWDVIDS_SECTIONHEAD_PLUGIN","Plugin Management");
DEFINE("_HWDVIDS_SECTIONHEAD_CONVERTOR","Video Converter");
DEFINE("_HWDVIDS_SECTIONHEAD_HOME","Homepage");
DEFINE("_HWDVIDS_SECTIONHEAD_IMPORT","Import Data");
DEFINE("_HWDVIDS_SECTIONHEAD_CLUP","Maintenance");

//Backend Filter Text

DEFINE("_HWDVIDS_SEARCHV","Search Videos");
DEFINE("_HWDVIDS_SEARCHC","Search Categories");
DEFINE("_HWDVIDS_SEARCHG","Search Groups");
DEFINE("_HWDVIDS_RPP","Results Per Page");

//Backend Alert Text

DEFINE("_HWDVIDS_ALERT_ADMIN_VIDPUB"," video(s) published");
DEFINE("_HWDVIDS_ALERT_ADMIN_VIDUNPUB"," video(s) unpublished");
DEFINE("_HWDVIDS_ALERT_ADMIN_VIDFEAT"," video(s) featured");
DEFINE("_HWDVIDS_ALERT_ADMIN_VIDUNFEAT"," video(s) unfeatured");
DEFINE("_HWDVIDS_ALERT_ADMIN_VIDDEL"," video(s) deleted");
DEFINE("_HWDVIDS_ALERT_ADMIN_VIDAPP"," video(s) approved and published");
DEFINE("_HWDVIDS_ALERT_ADMIN_GPUB"," groups(s) published");
DEFINE("_HWDVIDS_ALERT_ADMIN_GUNPUB"," groups(s) unpublished");
DEFINE("_HWDVIDS_ALERT_ADMIN_GFEAT"," groups(s) featured");
DEFINE("_HWDVIDS_ALERT_ADMIN_GUNFEAT"," groups(s) unfeatured");
DEFINE("_HWDVIDS_ALERT_ADMIN_GDEL"," groups(s) deleted");
DEFINE("_HWDVIDS_ALERT_ADMIN_CATPUB"," categories(s) published");
DEFINE("_HWDVIDS_ALERT_ADMIN_CATUNPUB"," categories(s) unpublished");
DEFINE("_HWDVIDS_ALERT_ADMIN_CATDEL"," categories(s) deleted");
DEFINE("_HWDVIDS_ALERT_ADMIN_COMPUB"," comments(s) published");
DEFINE("_HWDVIDS_ALERT_ADMIN_COMUNPUB"," comments(s) unpublished");
DEFINE("_HWDVIDS_ALERT_ADMIN_FLAGMDEL"," reported media deleted");
DEFINE("_HWDVIDS_ALERT_ADMIN_FLAGMREAD"," reported media ignored");
DEFINE("_HWDVIDS_ALERT_ADMIN_PERMDELSUC","Successfully deleted old video files");
DEFINE("_HWDVIDS_ALERT_CATSAVED","Category Saved");
DEFINE("_HWDVIDS_ALERT_GRPSAVED","Group Saved");
DEFINE("_HWDVIDS_ALERT_VIDSAVED","Video Saved");
DEFINE("_HWDVIDS_ALERT_ADMIN_GCONFUNWRT","Your General Settings file is unwritable! You must make this file writeable before you can access this page or save new settings: <div style='text-indent: 30px;'>".JPATH_SITE  ."/administrator/components/com_hwdvideoshare/config.hwdvideoshare.php</div>");
DEFINE("_HWDVIDS_ALERT_ADMIN_SCONFUNWRT","Your Server Settings file is unwritable! You must make this file writeable before you can access this page or save new settings: <div style='text-indent: 30px;'>".JPATH_SITE  ."/administrator/components/com_hwdvideoshare/serverconfig.hwdvideoshare.php</div>");
DEFINE("_HWDVIDS_ALERT_ACMETH1","Method 1 [Direct Background Execution]");
DEFINE("_HWDVIDS_ALERT_ACMETH2","Method 2 [WGet Background Execution]");
DEFINE("_HWDVIDS_ALERT_ACMETH3","Method 3 [WGet Background Execution]");
DEFINE("_HWDVIDS_ALERT_ERRFTP","There has been some kind of error whilst processing the FTP video information. Please try again later.");
DEFINE("_HWDVIDS_ALERT_SUCFTP","Success! Your video information has been added. Don't forget to upload your video file.");
DEFINE("_HWDVIDS_ALERT_BE_QFCQFT","This video is waiting to be converted or have a thumbnail image taken. More information will be displayed once this process is complete.");
DEFINE("_HWDVIDS_ALERT_BE_VIDDEL","This video has been deleted. You can permanently remove it by using the Maintenance tools.");
DEFINE("_HWDVIDS_ALERT_VURLWRONG","The Video URL you entered is not valid, please complete the form again. No information has been saved.");
DEFINE("_HWDVIDS_ALERT_TURLWRONG","The Thumbnail URL you entered is not valid, please complete the form again. No information has been saved.");
DEFINE("_HWDVIDS_ALERT_NOREMURL","Please enter the URL of the video file");
DEFINE("_HWDVIDS_ALERT_NOREMTHUMB","Please enter the URL of the video thumbnail");
DEFINE("_HWDVIDS_ALERT_AC_YES","This method does work on your server.");
DEFINE("_HWDVIDS_ALERT_AC_NO","This method does not work on your server.");
DEFINE("_HWDVIDS_ALERT_MISSINGINFO","You did not fill out all the fields, please complete the form again. No information has been saved.");
DEFINE("_HWDVIDS_ALERT_SUCRESETFCONV","Successfully reset failed conversions!");
DEFINE("_HWDVIDS_ALERT_ADMIN_SETNOTSAVED","Your settings could not be saved!");
DEFINE("_HWDVIDS_ALERT_MISSINGVIDFILE","*** This file is missing! ***");
DEFINE("_HWDVIDS_ALERT_CATCONTAINSVIDS","This category contains videos. You need to delete all these videos before you can delete the category.");
DEFINE("_HWDVIDS_ALERT_ADMIN_SETSAVED","Your settings have been saved");
DEFINE("_HWDVIDS_ALERT_PARENTNOTSELF","You can not set the parent category as itself.");
DEFINE("_HWDVIDS_ALERT_MANCHMOD","You need to make this directory writable:");
DEFINE("_HWDVIDS_ALERT_MANMKDIR","You need to manually create this directory:");

//Admin Email Notification Text

DEFINE("_HWDVIDS_MAIL_SUBJECT1","New video upload on ");
DEFINE("_HWDVIDS_MAIL_SUBJECT2","New group created on ");
DEFINE("_HWDVIDS_MAIL_SUBJECT3","New comment created on ");
DEFINE("_HWDVIDS_MAIL_SUBJECT4","Media has been reported on ");
DEFINE("_HWDVIDS_MAIL_BODY0","There has been a new video upload on ");
DEFINE("_HWDVIDS_MAIL_BODY1","The video is called ");
DEFINE("_HWDVIDS_MAIL_BODY2","If you need to approve this video please log into your administration section.");
DEFINE("_HWDVIDS_MAIL_BODY3","There has been a new group created on ");
DEFINE("_HWDVIDS_MAIL_BODY4","The group is called ");
DEFINE("_HWDVIDS_MAIL_BODY5","If you need to manually publish this group please log into your administration section.");
DEFINE("_HWDVIDS_MAIL_BODY6","There has been a new comment written on ");
DEFINE("_HWDVIDS_MAIL_BODY7","Comment: ");
DEFINE("_HWDVIDS_MAIL_BODY8","If you need to manually publish this comment please log into your administration section.");
DEFINE("_HWDVIDS_MAIL_BODY9","Somebody has reported media as inappropriate on ");
DEFINE("_HWDVIDS_MAIL_BODY10","To watch the video please visit the following page:");
DEFINE("_HWDVIDS_MAIL_BODY11","If you need to edit or delete the media please log into your administration section.");
DEFINE("_HWDVIDS_MAIL_BODY12","To view the group please visit the following page:");

// Toolbar

DEFINE("_HWDVIDS_TOOLBAR_HOME","Homepage");
DEFINE("_HWDVIDS_TOOLBAR_FEATURE","Feature");
DEFINE("_HWDVIDS_TOOLBAR_UNFEATURE","Unfeature");
DEFINE("_HWDVIDS_TOOLBAR_EDIT","Edit");
DEFINE("_HWDVIDS_TOOLBAR_DELETE","Delete");
DEFINE("_HWDVIDS_TOOLBAR_REMOVE","Remove");
DEFINE("_HWDVIDS_TOOLBAR_PUBLISH","Publish");
DEFINE("_HWDVIDS_TOOLBAR_UNPUBLISH","Unpublish");
DEFINE("_HWDVIDS_TOOLBAR_APPROVE","Approve");
DEFINE("_HWDVIDS_TOOLBAR_BKUP","Send Now");
DEFINE("_HWDVIDS_TOOLBAR_RUN","Run Tools");
DEFINE("_HWDVIDS_TOOLBAR_RESTOREDEFAULTS","Restore Defaults");

//Backend Selects

DEFINE("_HWDVIDS_SELECT_PUBLIC","Public Access");
DEFINE("_HWDVIDS_SELECT_REG","Registered Users Only");
DEFINE("_HWDVIDS_SELECT_ALLOWCOMMS","Allow Comments");
DEFINE("_HWDVIDS_SELECT_DONTALLOWCOMMS","Don't Allow Comments");
DEFINE("_HWDVIDS_SELECT_ALLOWEMB","Allow Embedding");
DEFINE("_HWDVIDS_SELECT_DONTALLOWEMB","Don't Allow Embedding");
DEFINE("_HWDVIDS_SELECT_ALLOWRATE","Allow Ratings");
DEFINE("_HWDVIDS_SELECT_DONTALLOWRATE","Don't Allow Ratings");
DEFINE("_HWDVIDS_SELECT_REQUIREAPP","Require Approval");
DEFINE("_HWDVIDS_SELECT_DONTREQUIREAPP","Don't Require Approval");
DEFINE("_HWDVIDS_SELECT_ORDERING","Ordering");
DEFINE("_HWDVIDS_SELECT_UPLDDATE","Upload Date");
DEFINE("_HWDVIDS_SELECT_NAME","Name");
DEFINE("_HWDVIDS_SELECT_HITS","Hits");
DEFINE("_HWDVIDS_SELECT_RATING","Rating");
DEFINE("_HWDVIDS_SELECT_RANDOM","Random");
DEFINE("_HWDVIDS_SELECT_NOVIDS","Number of Videos");
DEFINE("_HWDVIDS_SELECT_NOSUBS","Number of Subcategories");
DEFINE("_HWDVIDS_SELECT_NOPAR","No Parent");
DEFINE("_HWDVIDS_SELECT_EVERYONE","Everybody");
DEFINE("_HWDVIDS_SELECT_ALLREGUSER","All Registered Users");

//Tab Titles

DEFINE("_HWDVIDS_TAB_SETUP","Setup");
DEFINE("_HWDVIDS_TAB_UPLDS","Uploads");
DEFINE("_HWDVIDS_TAB_APVLS","Approvals");
DEFINE("_HWDVIDS_TAB_CONVNS","Conversions");
DEFINE("_HWDVIDS_TAB_NOTFY","Notify");
DEFINE("_HWDVIDS_TAB_INTGTN","Integrations");
DEFINE("_HWDVIDS_TAB_ACCESS","Access");
DEFINE("_HWDVIDS_TAB_BASIC","Basic");
DEFINE("_HWDVIDS_TAB_SHARING","Sharing");
DEFINE("_HWDVIDS_TAB_FTP","FTP Upload");
DEFINE("_HWDVIDS_TAB_REMOTE","Remote");
DEFINE("_HWDVIDS_TAB_SQL","SQL Import");
DEFINE("_HWDVIDS_TAB_CSV","CSV Import");
DEFINE("_HWDVIDS_TAB_PHPM","PHPMotion");
DEFINE("_HWDVIDS_TAB_VCLIP","vClip");
DEFINE("_HWDVIDS_TAB_ALLVIDS","All Videos");
DEFINE("_HWDVIDS_TAB_FEATV","Featured");
DEFINE("_HWDVIDS_TAB_STATS","Statistics");
DEFINE("_HWDVIDS_TAB_INFO","Info");
DEFINE("_HWDVIDS_TAB_TP","Third Party");
DEFINE("_HWDVIDS_TAB_SHARES","Sharing");
DEFINE("_HWDVIDS_TAB_SETTS","Settings");
DEFINE("_HWDVIDS_TAB_XML","XML Playlists");
DEFINE("_HWDVIDS_TAB_SEYRET","Seyret");
DEFINE("_HWDVIDS_TAB_ACHT","ACHTube");
DEFINE("_HWDVIDS_TAB_TPV","Third Party Videos");
DEFINE("_HWDVIDS_TAB_VIDEO","Videos");
DEFINE("_HWDVIDS_TAB_GROUPS","Groups");
DEFINE("_HWDVIDS_TAB_SCAN","Scan");
DEFINE("_HWDVIDS_TAB_RTMP","RTMP");
DEFINE("_HWDVIDS_TAB_PERMISSIONS","Permissions");

//Information Page

DEFINE("_HWDVIDS_HOME_02","hwdVideoShare is an open source video sharing php script, that is a native component for the Joomla CMS.");
DEFINE("_HWDVIDS_HOME_03","It has been designed for use in social networking video sharing websites to enable the sharing of video media between users. It has similar functionality to other popular video sharing websites like <a href=\"http://www.youtube.com\" target=\"_blank\">You Tube</a>.");
DEFINE("_HWDVIDS_HOME_04","This is an Alpha release of hwdVideoShare. There are still issues with this software that Highwood Design is trying to overcome.");
DEFINE("_HWDVIDS_HOME_05","This program is distributed with the hope to be useful but WITHOUT ANY WARRANTY!");
DEFINE("_HWDVIDS_HOME_06","How Does hwdVideoShare Work?");
DEFINE("_HWDVIDS_HOME_07","hwdVideoShare Schematic Diagram");
DEFINE("_HWDVIDS_HOME_08","Requirements");
DEFINE("_HWDVIDS_HOME_09","or");
DEFINE("_HWDVIDS_HOME_10","(Joomla 1.5 requires Legacy Support)");
DEFINE("_HWDVIDS_HOME_11","Converting Videos After Upload [queuedforconversion]");
DEFINE("_HWDVIDS_HOME_12","If a video is added by uploading a video file to your server it will need to be converted by software on your server before it appears on your website. You can check the status of uploaded videos by clicking on the <b>Video</b> menu in the administration section of hwdVideoShare.");
DEFINE("_HWDVIDS_HOME_13","You can setup hwdVideoShare so it will sent new video files directly to the converter immediately after the upload is finished. Go to the <b>General Settings</b> menu option and then click on the <b>Conversions</b> tab.");
DEFINE("_HWDVIDS_HOME_14","If new videos are not being converted you can use the manual converter in the hwdVideoShare. This will give much more information about why videos are not being converted.");
DEFINE("_HWDVIDS_HOME_15","The converter script should not be interrupted whilst it is being executed.");
DEFINE("_HWDVIDS_HOME_16","For <a href=\"http://joomla.highwooddesign.co.uk\" target=\"_blank\">documentation</a> on debugging this conversion process please see the Highwood Design website.");
DEFINE("_HWDVIDS_HOME_17","If you do not have the required software installed on your server then the video conversions will fail.");
DEFINE("_HWDVIDS_HOME_18","You can disable the use of the conversion software in hwdVideoShare however, hwdVideoShare will only run with limited features.");
DEFINE("_HWDVIDS_HOME_19","Videos that are added from third party websites (Such as YouTube) do not need to be converted and will appear immediately on your website. If you plan on only hwdVideoShare to only share videos from external website like YouTube then you do not need any of the required software for hwdVideoShare to function correctly.");
DEFINE("_HWDVIDS_HOME_20","Creating Thumbnail Images [queuedforthumbnail]");
DEFINE("_HWDVIDS_HOME_21","You can setup hwdVideoShare to not reconvert FLV files when they are uploaded. To do this go to the <b>General Settings</b> menu option and then click on the <b>Conversions</b> tab.");
DEFINE("_HWDVIDS_HOME_22","If you choose to not reconvert FLV files then any new FLV uploads will be marked as \"queuedforthumbnail\". When the conversion script runs the FLV file will be copied directly into the upload directory, but not reconverted. A thumbnail image of the video will be created and the conversion will be marked as complete.");
DEFINE("_HWDVIDS_HOME_23","Third Party Videos");
DEFINE("_HWDVIDS_HOME_24","Instead of uploading video files to your server your users can also add videos from third party video websites like YouTube and GoogleVideo.");
DEFINE("_HWDVIDS_HOME_25","Adding videos from third party video websites means that you <b>do not</b> need MENCODER or FFMPEG on your server.");
DEFINE("_HWDVIDS_HOME_26","Acknowledgements");
DEFINE("_HWDVIDS_HOME_27","Highwood Design would like to acknowledge the following excellent projects:");
DEFINE("_HWDVIDS_HOME_28","Developer");
DEFINE("_HWDVIDS_HOME_29","Released under the");
DEFINE("_HWDVIDS_HOME_30","Documentation &#38; Support");
DEFINE("_HWDVIDS_HOME_31","You can browse a number of free documentation articles on the <a href=\"http://hwdmediashare.co.uk\" target=\"_blank\">Highwood Design</a> website. These articles cover the basics of setting up hwdVideoShare.");
DEFINE("_HWDVIDS_HOME_32","You can also visit the Highwood Design discussion forums where you might find the answer to any questions or can start new discussions about new problems or issues.");
DEFINE("_HWDVIDS_HOME_33","We encourage you to <a href=\"http://hwdmediashare.co.uk\" target=\"_blank\">subscribe</a> to the Highwood Design website for access to all the documentation, forums, modules, community builder plugins and mambots.");
DEFINE("_HWDVIDS_HOME_34","It only <b>costs a few pounds to subscribe</b> for the year and will help us release new and better extensions.");

//Button Text

DEFINE("_HWDVIDS_BUTTON_PERMDELVIDS","Delete Permanently");
DEFINE("_HWDVIDS_BUTTON_PERMDELBKUP","Delete Backup File");
DEFINE("_HWDVIDS_BUTTON_PERMRESBKUP","Restore File");
DEFINE("_HWDVIDS_BUTTON_SAVE","Save");
DEFINE("_HWDVIDS_BUTTON_UPDT","Update");
DEFINE("_HWDVIDS_BUTTON_CANX","Cancel");
DEFINE("_HWDVIDS_BUTTON_RESETFCONV","RESET FAILED CONVERSIONS");
DEFINE("_HWDVIDS_BUTTON_FINSET","Finish Setup");
DEFINE("_HWDVIDS_BUTTON_SENDBKUP","Backup Now");
DEFINE("_HWDVIDS_BUTTON_UPLOAD","Upload");
DEFINE("_HWDVIDS_BUTTON_IMPORT","Import Now");
DEFINE("_HWDVIDS_BUTTON_UNDOIMPORT","Undo Import Now");

//Backend Server Settings

DEFINE("_HWDVIDS_PATHFFMPEG","Path to FFMPEG");
DEFINE("_HWDVIDS_SETT_PATHFFMPEG_DESC","The full server path to FFMPEG");
DEFINE("_HWDVIDS_PATHFLVTOOL2","Path to FLVTOOL2");
DEFINE("_HWDVIDS_SETT_PATHFLVTOOL2_DESC","The full server path to FLVTOOL2");
DEFINE("_HWDVIDS_PATHMENCODER","Path to MENCODER");
DEFINE("_HWDVIDS_SETT_PATHMENCODER_DESC","The full server path to MENCODER");
DEFINE("_HWDVIDS_PATHPHP","Path to PHP");
DEFINE("_HWDVIDS_SETT_PATHPHP_DESC","The full server path to PHP");
DEFINE("_HWDVIDS_PATHWGET","Path to WGET");
DEFINE("_HWDVIDS_SETT_PATHWGET_DESC","The full server path to WGET");
DEFINE("_HWDVIDS_PATHQTFS","Path to QT-FASTSTART");
DEFINE("_HWDVIDS_SETT_PATHQTFS_DESC","The full server path to QT-FASTSTART");

//Export

DEFINE("_HWDVIDS_EXPORT_TOEMAIL","To Email Address");
DEFINE("_HWDVIDS_EXPORT_TOEMAIL_TT","Email address to send the backup file to. Leave empty to send to the system default email address.");
DEFINE("_HWDVIDS_EXPORT_SUBJECT","Subject");
DEFINE("_HWDVIDS_EXPORT_SUBJECT_TT","Subject of the backup email.");
DEFINE("_HWDVIDS_EXPORT_SUBJECT_DEFAULT","hwdVideoShare SQL Backup");
DEFINE("_HWDVIDS_EXPORT_BODY","Body");
DEFINE("_HWDVIDS_EXPORT_BODY_TT","Body of the backup email.");
DEFINE("_HWDVIDS_EXPORT_BODY_DEFAULT","hwdVideoShare backup completed successfully at ");
DEFINE("_HWDVIDS_EXPORT_SUCCESS","Success! The backup email has been sent.");
DEFINE("_HWDVIDS_EXPORT_DELETE0","Not deleting backup file");
DEFINE("_HWDVIDS_EXPORT_DELETE1","Deleting backup file");
DEFINE("_HWDVIDS_EXPORT_TITLE","Export SQL Backup to Email");

//Import

DEFINE("_HWDVIDS_IMPT_SQL_TITLE","Import Videos from SQL Backup File");
DEFINE("_HWDVIDS_IMPT_SQL_DESC","This feature should only be used to upload and import the SQL Export backup files created by this program. Do not attempt to upload any other media.");
DEFINE("_HWDVIDS_IMPT_SQL_WARN","Exercise extreme caution when using this feature! hwdVideoShare will dump any data you upload into your SQL database, overwriting any existing data. It is still relatively new to hwdVideoShare. Ensure you backup your entire database before using it for the first time.");
DEFINE("_HWDVIDS_IMPT_REMOTE_TITLE","Add Videos from a Remote Location");
DEFINE("_HWDVIDS_IMPT_REMOTE_DESC","Use this tool to add videos from an external source. The location can be on any server as long as the file is publicly accessible. Please note you can only add videos supported by the Adobe Flash Player (FLV, MP4, SWF).");
DEFINE("_HWDVIDS_IMPT_REMOTE_WARN","Only use this tool to import <b>static videos</b>. Adding a video from a Third Party video website such as YouTube or Vimeo will not work, please use the Third Party tab to add these videos.");
DEFINE("_HWDVIDS_IMPT_FTP_TITLE","Add Videos by FTP");
DEFINE("_HWDVIDS_IMPT_FTP_DESC","Use this tool to manually add videos by FTP one at a time. You can upload your large video file and then add the information about the video using the form below. Please note you can only add videos supported by the Adobe Flash Player (FLV, MP4, SWF). You can download <a href=\"http://www.download.com/\" target=\"_blank\">free software</a> for Windows that can convert videos into the FLV video format. Please follow the instructions carefully.");
DEFINE("_HWDVIDS_IMPT_FTP_DESC1","Rename your video file to ");
DEFINE("_HWDVIDS_IMPT_FTP_DESC2","Use FTP to upload the video file to your server");
DEFINE("_HWDVIDS_IMPT_FTP_DESC3","Upload the video file to this directory on your server:<br /><b>".JPATH_SITE."/hwdvideos/uploads/</b>");
DEFINE("_HWDVIDS_IMPT_FTP_DESC4","Fill in the form below with information about the video and click Save");
DEFINE("_HWDVIDS_IMPT_CSV_TITLE","Import Videos from CSV File");
DEFINE("_HWDVIDS_IMPT_CSV_DESC","This feature should only be used to batch import video imformation into the database using CSV data. Videos can then be copied (by FTP) to the video directory.");
DEFINE("_HWDVIDS_IMPT_CSV_WARN","Exercise extreme caution when using this feature! hwdVideoShare will dump any data you upload into your SQL database, overwriting any existing data. It is still relatively new to hwdVideoShare. Ensure you backup your entire database before using it for the first time.");
DEFINE("_HWDVIDS_IMPT_MT","Media Type");
DEFINE("_HWDVIDS_IMPT_CSV_DL","Delimiter");
DEFINE("_HWDVIDS_IMPT_CSV_ME","Maximum Allowed Errors");
DEFINE("_HWDVIDS_IMPT_SEYRET_TITLE","Import Videos from Seyret");
DEFINE("_HWDVIDS_IMPT_SEYRET_DESC","This feature can be used to import videos from Seyret.");
DEFINE("_HWDVIDS_IMPT_SEYRET_WARN"," Seyret is not installed on this Joomla website. You can not import any videos from Seyret.");
DEFINE("_HWDVIDS_IMPT_TP_TITLE","Import Videos from Third Party Video Websites");
DEFINE("_HWDVIDS_IMPT_TP_DESC","This feature should be used to import videos from Third Party video websites. You must have a plugin installed for the websites you want to add videos from.");
DEFINE("_HWDVIDS_IMPT_RTMP_TITLE","Add RTMP Streams from Media Servers");
DEFINE("_HWDVIDS_IMPT_RTMP_DESC","FLV and MP4 video can be streamed with RTMP Servers.");
DEFINE("_HWDVIDS_IMPT_RTMP_WARN","Only use this tool to import <b>RTMP Streams</b>.");


//Information

DEFINE("_HWDVIDS_INFO_CONFIRMBACKDEL","Are you sure you want to delete the selected video(s)?");
DEFINE("_HWDVIDS_INFO_CONFIRMBACKCDEL","Are you sure you want to delete the selected category(s)?");
DEFINE("_HWDVIDS_INFO_CONFIRMBACKGDEL","Are you sure you want to delete the selected group(s)?");
DEFINE("_HWDVIDS_INFO_CONFIRMBACKPDEL","Are you sure you want to uninstall the selected plugin(s)?");
DEFINE("_HWDVIDS_INFO_NOTDEVELOPED","This feature will become available in the next release");
DEFINE("_HWDVIDS_INFO_PERMDEL1","When you delete videos the files will remain on your server until you permanently delete them using this tool.");
DEFINE("_HWDVIDS_INFO_PERMDEL2","There are currently ");
DEFINE("_HWDVIDS_INFO_PERMDEL3"," video files that can be permanently deleted.");
DEFINE("_HWDVIDS_INFO_PERMDEL4","Please confirm you wish to permanently delete your unused video files.");
DEFINE("_HWDVIDS_INFO_PERMDEL5","There are no video files to delete!");
DEFINE("_HWDVIDS_INFO_CLUP1","Check for errors in your database tables and fix them.");
DEFINE("_HWDVIDS_INFO_CLUP2","This feature will be available in the first stable release next year.");
DEFINE("_HWDVIDS_INFO_CONFIRMRESBKUP","WARNING!!! This will delete your current database information and replace it with the backup data. Please make sure you have read all the documentation on this before proceeding. Do you want to proceed?");
DEFINE("_HWDVIDS_INFO_QFCON","Videos Queued For Video Conversion");
DEFINE("_HWDVIDS_INFO_QFTUM","Videos Queued For Thumbnail Creation");
DEFINE("_HWDVIDS_INFO_QFSWF","Videos Queued For SWF Processing");
DEFINE("_HWDVIDS_INFO_QFMP4","Videos Queued For MP4 Processing");
DEFINE("_HWDVIDS_INFO_QFTRG","Videos Queued For Thumbnail Re-Generation");
DEFINE("_HWDVIDS_INFO_QFDRC","Videos Queued For Duration Re-Calculation");
DEFINE("_HWDVIDS_INFO_QFING","Videos Currently Being Converted");
DEFINE("_HWDVIDS_INFO_CONFIGF1","The configuration file is");
DEFINE("_HWDVIDS_INFO_CONFIGF2","writable");
DEFINE("_HWDVIDS_INFO_CONFIGF3","not writable");
DEFINE("_HWDVIDS_INFO_NOPLUGIN","Sorry! This video can no longer be played on this website.");
DEFINE("_HWDVIDS_INFO_CHOOSECAT","Choose a category");
DEFINE("_HWDVIDS_INFO_NOCATS","There are no available categories");
DEFINE("_HWDVIDS_INFO_TPDRFAIL","The video's duration could not be found");
DEFINE("_HWDVIDS_INFO_ENABLEJAVA","Please enable Java Script in your browser or use a different browser to view this video. You might also need to <a href=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\" target=\"_blank\">update your flash player</a>.");
DEFINE("_HWDVIDS_INFO_ANYCAT","Search all categories");
DEFINE("_HWDVIDS_INFO_TPPROCESSFAIL","The video code you entered could be processed! Your video has not been added.<br /><br />");
DEFINE("_HWDVIDS_INFO_TPTITLEFAIL","The video's title could not be found");
DEFINE("_HWDVIDS_INFO_TPDESCFAIL","The video's description could not be found.");
DEFINE("_HWDVIDS_INFO_TPKWFAIL","The video's keywords could not be found");
DEFINE("_HWDVIDS_INFO_TAGS","Tags are keywords used to explain your videos and should be comma separated. (holiday, beach, Spain, etc)");
DEFINE("_HWDVIDS_INFO_REQUIREDFIELDS","indicates required field");

//Details

DEFINE("_HWDVIDS_DETAILS_VIDSTATUS_Y","Approved");
DEFINE("_HWDVIDS_DETAILS_VIDSTATUS_QFC","Queued For Video Conversion");
DEFINE("_HWDVIDS_DETAILS_VIDSTATUS_QFT","Queued For Thumbnail Creation");
DEFINE("_HWDVIDS_DETAILS_VIDSTATUS_QFSWF","Queued For SWF Processing");
DEFINE("_HWDVIDS_DETAILS_VIDSTATUS_QFMP4","Queued For MP4 Processing");
DEFINE("_HWDVIDS_DETAILS_VIDSTATUS_P","Pending Approval");
DEFINE("_HWDVIDS_DETAILS_VIDSTATUS_D","Deleted");
DEFINE("_HWDVIDS_DETAILS_SOTS","Stored on this server");
DEFINE("_HWDVIDS_DETAILS_TIMES","times");
DEFINE("_HWDVIDS_DETAILS_REMSER","On a remote server");
DEFINE("_HWDVIDS_DETAILS_VIEWVID","View Video");

//Title

DEFINE("_HWDVIDS_TITLE_DELETEOLDVIDS","Permanently Delete Video Files");
DEFINE("_HWDVIDS_TITLE_CLUPBDTABLES","Cleanup Database Tables");
DEFINE("_HWDVIDS_TITLE_EDITVID","Edit Video Details");
DEFINE("_HWDVIDS_TITLE_FINSET","Finish hwdVideoShare Setup");
DEFINE("_HWDVIDS_TITLE_HWDVCONVERTOR","Video Converter");
DEFINE("_HWDVIDS_TITLE_SS","Server Settings");

//General Dedicated Backend

DEFINE("_HWDVIDS_MAIN_RN","Run Now");
DEFINE("_HWDVIDS_MAIN_DRN","Don't Run Now");
DEFINE("_HWDVIDS_MAIN_RIR","Run if Required");
DEFINE("_HWDVIDS_MAIN_LR","Last Run:");
DEFINE("_HWDVIDS_MAIN_FDE","Fix SQL Database Errors");
DEFINE("_HWDVIDS_MAIN_RDS","Recount SQL Database Statistics");
DEFINE("_HWDVIDS_MAIN_AAL","Archive Access Logs");
DEFINE("_HWDVIDS_INS_SAMP_CATS","Install & publish sample categories");
DEFINE("_HWDVIDS_INS_YT","Install & publish YouTube plugin");
DEFINE("_HWDVIDS_INS_GV","Install & publish GoogleVideo plugin");
DEFINE("_HWDVIDS_JW_LIC","hwdVideoShare has an integrated <b><i>Video Player Plugin</i></b> system. This system enables you to install popular third party video players and use them with this software. It gives you the power of the world's most powerful open source media players within your hwdVideoShare video gallery. You can use the <a href='http://www.jeroenwijering.com/?item=JW_FLV_Player' target='_blank'>JW FLV Media Player</a> with hwdVideoShare, but JW FLV Media Player Version 4 has a <a href='http://creativecommons.org/licenses/by-nc-sa/3.0/' target='_blank'>noncommercial license</a>.");
DEFINE("_HWDVIDS_JW_AGREE","I agree to the JW FLV Media Player noncommercial license");
DEFINE("_HWDVIDS_JW_DECLINE","I don't agree to the JW FLV Media Player noncommercial license");
DEFINE("_HWDVIDS_JW_EXISTING","I own a JW FLV Media Player commercial license");
DEFINE("_HWDVIDS_JW_SKIP","I don't want to install the JW FLV Media Player");
DEFINE("_HWDVIDS_REGENTHUMB","Re-Generate Local Video Thumbnails");
DEFINE("_HWDVIDS_RECALDUR","Re-Calculate Video Durations");
DEFINE("_HWDVIDS_RUNCON","You must now run the converter, otherwise your videos will not appear on your website.");
DEFINE("_HWDVIDS_M_LOG_RUN","Maintenance [Archive Access Logs] has already been performed in the past 24 hours. It probably does not need to be run again.");
DEFINE("_HWDVIDS_M_FIX_RUN","Maintenance [Fix SQL Database Errors] has already been performed in the past 24 hours. It probably does not need to be run again.");
DEFINE("_HWDVIDS_M_COUNT_RUN","Maintenance [Recount SQL Database Statistics] has already been performed in the past 24 hours. It probably does not need to be run again.");
DEFINE("_HWDVIDS_CTC","Clear Template Cache");
DEFINE("_HWDVIDS_CPC","Clear Playlist Cache");
DEFINE("_HWDVIDS_RGP","Re-Generate Playlists");
DEFINE("_HWDVIDS_CVST","Converter Statistics");
DEFINE("_HWDVIDS_STCV","Start Converter");
DEFINE("_HWDVIDS_CHANGEUSER","Change User");
DEFINE("_HWDVIDS_FLOC","File Location");
DEFINE("_HWDVIDS_FURL","File URL");
DEFINE("_HWDVIDS_FNAME","Filename");
DEFINE("_HWDVIDS_NQFILE","Normal Quality File");
DEFINE("_HWDVIDS_HQFILE","High Quality File");
DEFINE("_HWDVIDS_VREMURL","Remote Video URL");
DEFINE("_HWDVIDS_RTMPURL","RTMP Stream URL");
DEFINE("_HWDVIDS_IMGREMURL","Thumbnail Image URL");
DEFINE("_HWDVIDS_REP_DELETEVID","Delete Video");
DEFINE("_HWDVIDS_REP_INGOREV","Disregard Report (Keep Video)");
DEFINE("_HWDVIDS_REP_INGOREG","Disregard Report (Keep Group)");
DEFINE("_HWDVIDS_REP_USER","Reported By");
DEFINE("_HWDVIDS_REP_STATUS","Report Status");
DEFINE("_HWDVIDS_REP_DATE","Date Reported");
DEFINE("_HWDVIDS_TT_01B","If videos are in the status of &#34;converting&#34; for over 1 hour then something is probably broken. Videos will not reset their own status and will remain in the status &#34;converting&#34; forever. If you want to reset the videos to re-attempt the conversion please click on this button.");
DEFINE("_HWDVIDS_TT_01H","Reset Failed Conversions");
DEFINE("_HWDVIDS_CONVERSIONSTARTED","The conversion process has started<br />Please wait...");
DEFINE("_HWDVIDS_CONVERSIONSTART","&laquo; Click here to start video conversions &raquo;");
DEFINE("_HWDVIDS_INCLUDECHILD","Include Child groups?");
DEFINE("_HWDVIDS_YES","Yes");
DEFINE("_HWDVIDS_NO","No");
DEFINE("_HWDVIDS_CATEGORYDET","Category Details");
DEFINE("_HWDVIDS_OTHERDET","Other Details");
DEFINE("_HWDVIDS_GROUPDET","Group Details");
DEFINE("_HWDVIDS_DOCS","Documentation");
DEFINE("_HWDVIDS_UNKNOWN","Unknown");
DEFINE("_HWDVIDS_TITLE","Title");
DEFINE("_HWDVIDS_LENGTH","Duration");
DEFINE("_HWDVIDS_RATING","Rating");
DEFINE("_HWDVIDS_DATEUPLD","Date Uploaded");
DEFINE("_HWDVIDS_APPROVED","Approved");
DEFINE("_HWDVIDS_FEATURED","Featured");
DEFINE("_HWDVIDS_PUB","Published");
DEFINE("_HWDVIDS_DATECREATED","Date Created");
DEFINE("_HWDVIDS_GRPMEMS","Group Members");
DEFINE("_HWDVIDS_GRPVIDS","Group Videos");
DEFINE("_HWDVIDS_VAPPROVEPUB","Approve & Publish Video");
DEFINE("_HWDVIDS_CPARENT","Category Parent");
DEFINE("_HWDVIDS_CVACCESS","Category View Access");
DEFINE("_HWDVIDS_CUACCESS","Category Upload Access");
DEFINE("_HWDVIDS_CVVISIBLE","Make blocked categories invisible?");
DEFINE("_HWDVIDS_ADMIN","Administrator");
DEFINE("_HWDVIDS_REORDER","Re-order");
DEFINE("_HWDVIDS_VIEWS","Views");
DEFINE("_HWDVIDS_ACCESS","Access");
DEFINE("_HWDVIDS_ORDER","Ordering");
DEFINE("_HWDVIDS_MARKVASREAD","Disregard Report (Keep Video)");
DEFINE("_HWDVIDS_MARKGASREAD","Disregard Report (Keep Group)");
DEFINE("_HWDVIDS_WMIP_01","The website administrator needs to install the ");
DEFINE("_HWDVIDS_WMIP_02"," plugin.");
DEFINE("_HWDVIDS_CATEGORY","Category");
DEFINE("_HWDVIDS_TAGS","Tags");
DEFINE("_HWDVIDS_DESC","Description");
DEFINE("_HWDVIDS_THUMBPOS","Thumbnail Position");
DEFINE("_HWDVIDS_UPLOADER","Uploader");
DEFINE("_HWDVIDS_ACOMMENTS","Allow Comments");
DEFINE("_HWDVIDS_AEMBEDDING","Allow Embedding");
DEFINE("_HWDVIDS_ARATINGS","Allow Rating");
DEFINE("_HWDVIDS_FAVOURED","Favoured");
DEFINE("_HWDVIDS_LINKS_BACK","&laquo; Back");
DEFINE("_HWDVIDS_TEXT_NONE","None");
DEFINE("_HWDVIDS_TITLE_UPLDFAIL","Upload Failed");
DEFINE("_HWDVIDS_ALERT_NOTITLE","Please enter a video title");
DEFINE("_HWDVIDS_ALERT_NODESC","Please enter a video description");
DEFINE("_HWDVIDS_ALERT_NOCAT","Please choose a video category");
DEFINE("_HWDVIDS_ALERT_NOTAG","Please enter some video tags");
DEFINE("_HWDVIDS_ALERT_NOURL","Please enter a video URL");
DEFINE("_HWDVIDS_PHPUPLD_ERR00","The file could not be uploaded. The data in the form probably exceeds the post_max_size directive in php.ini. ");
DEFINE("_HWDVIDS_PHPUPLD_ERR01","The file is bigger than the PHP installation allows. The uploaded file exceeds the upload_max_filesize directive in php.ini.");
DEFINE("_HWDVIDS_PHPUPLD_ERR02","The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.");
DEFINE("_HWDVIDS_PHPUPLD_ERR03","The uploaded file was only partially uploaded. ");
DEFINE("_HWDVIDS_PHPUPLD_ERR04","No file was uploaded. ");
DEFINE("_HWDVIDS_PHPUPLD_ERR05","Unknown Error");
DEFINE("_HWDVIDS_PHPUPLD_ERR06","Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.");
DEFINE("_HWDVIDS_PHPUPLD_ERR07","Failed to write file to disk.");
DEFINE("_HWDVIDS_PHPUPLD_ERR08","File upload stopped by extension.");
DEFINE("_HWDVIDS_UPLD_FORMERR01","We did not find a video title. Please go back and complete the form.");
DEFINE("_HWDVIDS_UPLD_FORMERR02","We did not find a video description. Please go back and complete the form.");
DEFINE("_HWDVIDS_UPLD_FORMERR03","We did not find a video category. Please go back and complete the form.");
DEFINE("_HWDVIDS_UPLD_FORMERR04","We did not find any video tags. Please go back and complete the form.");
DEFINE("_HWDVIDS_UPLD_FORMERR05","We did not find a video privacy setting. Please go back and complete the form.");
DEFINE("_HWDVIDS_UPLD_FORMERR06","We did not find a video comments option. Please go back and complete the form.");
DEFINE("_HWDVIDS_UPLD_FORMERR07","We did not find a video embedding option. Please go back and complete the form.");
DEFINE("_HWDVIDS_UPLD_FORMERR08","We did not find a video rating option. Please go back and complete the form.");
DEFINE("_HWDVIDS_ERROR_UPLDERR01","Your video upload failed. This could be for one of the following reasons:<ul><li>The uploaded file is too big, and exceeds the <b>upload_max_filesize</b> directive in php.ini.</li><li>The uploaded file went missing after the upload.</li><li>The file already exists on the server.</li></ul>");
DEFINE("_HWDVIDS_ERROR_UPLDERR02","The upload can not be processed because the file is too big. The size has been restricted by the website team to");
DEFINE("_HWDVIDS_ERROR_UPLDERR03","The upload can not be processed because it contains illegal characters.");
DEFINE("_HWDVIDS_ERROR_UPLDERR04","The upload can not be processed because you are not allowed to upload files in this format. It must be a valid filetype.");
DEFINE("_HWDVIDS_ERROR_UPLDERR05","The upload can not be processed because the file already exists on our server. Please try again later.");
DEFINE("_HWDVIDS_ERROR_UPLDERR06","The upload can not be processed because the file could not be saved to the server.");
DEFINE("_HWDVIDS_ERROR_UPLDERR07","The form was not complete. You need to complete all required sections.");
DEFINE("_HWDVIDS_ERROR_UPLDERR08","The upload failed. ERROR CODE 001.");
DEFINE("_HWDVIDS_ERROR_UPLDERR09","The upload failed. ERROR CODE 002.");
DEFINE("_HWDVIDS_ERROR_UPLDERR10","The upload failed. ERROR CODE 003.");
DEFINE("_HWDVIDS_ERROR_UPLDERR11","Your video could not be added. It is not from a supported website.");
DEFINE("_HWDVIDS_INFO_SUPPTPW","Videos from the following websites can be added.");
DEFINE("_HWDVIDS_BACKLINK","Back");
DEFINE("_HWDVIDS_ALERT_DUPLICATE","This video can not be added because it has already been added to the gallery.");
DEFINE("_HWDVIDS_RECENT","");
DEFINE("_HWDVIDS_VIDEOS","");
DEFINE("_HWDVIDS_SUBCATS","");
DEFINE("_HWDVIDS_TITLE_MOREBYUSR","");
DEFINE("_HWDVIDS_RELATED","");
DEFINE("_HWDVIDS_MORECATVIDS","");
DEFINE("_HWDVIDS_ALERT_ERRREM","There has been some kind of error whilst processing the remote video information. Please try again later.");
DEFINE("_HWDVIDS_ALERT_SUCREM","Success! Your remote video information has been added..");
DEFINE("_HWDVIDS_CCOB","Custom Category Order");
DEFINE("_HWDVIDS_GLOBAL","Global");
DEFINE("_HWDVIDS_SEARCHBAR","Search...");
DEFINE("_HWDVIDS_JS_AS1","has uploaded");
DEFINE("_HWDVIDS_JS_AS2","a new");
DEFINE("_HWDVIDS_JS_AS3","video");
DEFINE("_HWDVIDS_JS_AS4","videos");
DEFINE("_HWDVIDS_JS_AS5","new");
DEFINE("_HWDVIDS_NOTITLE","You did not enter a title");
DEFINE("_HWDVIDS_MVTD","Most Viewed Today");
DEFINE("_HWDVIDS_MVTW","Most Viewed This Week");
DEFINE("_HWDVIDS_MVTM","Most Viewed This Month");
DEFINE("_HWDVIDS_MVAT","Most Viewed");
DEFINE("_HWDVIDS_MFTD","Most Favoured Today");
DEFINE("_HWDVIDS_MFTW","Most Favoured This Week");
DEFINE("_HWDVIDS_MFTM","Most Favoured This Month");
DEFINE("_HWDVIDS_MFAT","Most Favoured");
DEFINE("_HWDVIDS_MPTD","Most Popular Today");
DEFINE("_HWDVIDS_MPTW","Most Popular This Week");
DEFINE("_HWDVIDS_MPTM","Most Popular This Month");
DEFINE("_HWDVIDS_MPAT","Most Popular");
DEFINE("_HWDVIDS_SELECT_ME","Only Me");
DEFINE("_HWDVIDS_SELECT_PASSWORD","Password Protected");
DEFINE("_HWDVIDS_SELECT_JACG","Access Group");
DEFINE("_HWDVIDS_SELECT_JACL","Access Level");
DEFINE("_HWDVIDS_PASSWORD","Password");
DEFINE("_HWDVIDS_INFO_GUEST","Guest");

