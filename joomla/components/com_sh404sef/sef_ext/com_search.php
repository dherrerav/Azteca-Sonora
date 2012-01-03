<?php
/**
 * sh404SEF support for com_search component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_search.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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
$shLangIso = shLoadPluginLanguage( 'com_search', $shLangIso, 'COM_SH404SEF_SEARCH');
// ------------------  load language file - adjust as needed ----------------------------------------                                           


  shRemoveFromGETVarsList('option');
  shRemoveFromGETVarsList('lang');
  shRemoveFromGETVarsList('Itemid');
  shRemoveFromGETVarsList('task');
  shRemoveFromGETVarsList('limit');
  shRemoveFromGETVarsList('view');
  if (isset($limitstart))  // V 1.2.4.r
    shRemoveFromGETVarsList('limitstart'); // limitstart can be zero
    
  //$title[] = getMenuTitle($option, (isset($task) ? @$task : null));
	$title[] = $sh_LANG[$shLangIso]['COM_SH404SEF_SEARCH'];
	$ordering = isset($ordering) ? @$ordering : null;
  switch ($ordering) {
    case 'newest'   : 
      $title[] =  $sh_LANG[$shLangIso]['_SEARCH_NEWEST'];
      shRemoveFromGETVarsList('ordering');
    break;  
	  case 'oldest' : 
    $title[] = $sh_LANG[$shLangIso]['_SEARCH_OLDEST'];
      shRemoveFromGETVarsList('ordering');
    break;
	  case 'popular' : 
      $title[] = $sh_LANG[$shLangIso]['_SEARCH_POPULAR'];
      shRemoveFromGETVarsList('ordering');
    break;  
	  case 'alpha': 
    $title[] = $sh_LANG[$shLangIso]['_SEARCH_ALPHABETICAL'];
      shRemoveFromGETVarsList('ordering');
    break; 
	  case 'category':
      $title[] = $sh_LANG[$shLangIso]['_SEARCH_CATEGORY'];
      shRemoveFromGETVarsList('ordering'); 
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
