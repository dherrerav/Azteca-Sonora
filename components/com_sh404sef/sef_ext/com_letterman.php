<?php
/**
 * sh404SEF support for com_letterman component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_letterman.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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
$shLangIso = shLoadPluginLanguage( 'com_letterman', $shLangIso, 'COM_SH404SEF_LETTERMAN');
// ------------------  load language file - adjust as needed ----------------------------------------
  
shRemoveFromGETVarsList('option');
if (!empty($lang))
  shRemoveFromGETVarsList('lang');  
if (!empty($sefConfig->shLMDefaultItemid)) {
  shAddToGETVarsList('Itemid', $sefConfig->shLMDefaultItemid); // V 1.2.4.q
    // we add then remove value to GET Vars, sounds weird, but Itemid value has been added to
    // non sef string in the process
  shRemoveFromGETVarsList('Itemid');
}   
if (!empty($Itemid))
  shRemoveFromGETVarsList('Itemid');
     
  $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LETTERMAN'];
  $task = isset($task) ? @$task : null;
  switch ($task) {
      case 'confirm':
         $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LM_CONFIRM'];
	 shRemoveFromGETVarsList('task');
      break;
      case 'subscribe' :
        $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LM_SUBSCRIBE'];
	 shRemoveFromGETVarsList('task');
      break;
      case 'unsubscribe':
         $title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_LM_UNSUBSCRIBE'];
	 shRemoveFromGETVarsList('task');
      break;
  }

// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------
     
?>
