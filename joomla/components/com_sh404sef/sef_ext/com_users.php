<?php
/**
 * sh404SEF support for com_user component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_users.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 *
 */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & Sh404sefFactory::getConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_users', $shLangIso, 'COM_SH404SEF_VIEW_DETAILS');
// ------------------  load language file - adjust as needed ----------------------------------------

// remove common URL from GET vars list, so that they don't show up as query string in the URL
shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
if (!empty($Itemid))
shRemoveFromGETVarsList('Itemid');
if (!empty($limit))
shRemoveFromGETVarsList('limit');
if (isset($limitstart))
shRemoveFromGETVarsList('limitstart'); // limitstart can be zero

$view = isset($view) ? $view : null;   // make sure $view is defined
$task = isset($task) ? $task : null;
$layout = isset($layout) ? $layout : null;

// optional first part of URL, to be set in language file
if (!empty($sh_LANG[$shLangIso]['COM_SH404SEF_REGISTRATION']))
$title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_REGISTRATION'];

$noTask = false;
switch ($task) {
  case 'register':
    $title[] =  $sh_LANG[$shLangIso]['COM_SH404SEF_REGISTER'];
    shRemoveFromGETVarsList('task');
    break;
  case 'activate':
    $title[] =  $sh_LANG[$shLangIso]['COM_SH404SEF_ACTIVATE'];
    shRemoveFromGETVarsList('task');
    break;
  case 'logout':
    $title[] =  $sh_LANG[$shLangIso]['COM_SH404SEF_LOGOUT'];
    shRemoveFromGETVarsList('task');
    break;
  default:
    $noTask = true;
    break;
}

switch ($view) {
  case 'profile' :
    if($layout == 'edit') {
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_EDIT_DETAILS'];
      shRemoveFromGETVarsList('layout');
    } else {
      $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_VIEW_DETAILS'];
    }
    shRemoveFromGETVarsList('view');
    break;
  case 'registration':
    $title[] =  $sh_LANG[$shLangIso]['COM_SH404SEF_REGISTER'];
    shRemoveFromGETVarsList('view');
    break;
  case 'reset':
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LOST_PASSWORD'];
    shRemoveFromGETVarsList('view');
    break;
  case 'remind':
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_REMIND_USER_NAME'];
    shRemoveFromGETVarsList('view');
    break;
  case 'login' :
    $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LOGIN'];
    shRemoveFromGETVarsList('view');
    break;
  default:
    if ($noTask) $dosef = false;
    break;
}

if (!empty($title))
if (!empty($sefConfig->suffix)) {
  $title[count($title)-1] .= $sefConfig->suffix;
}
else {
  $title[] = '/';
}

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

?>
