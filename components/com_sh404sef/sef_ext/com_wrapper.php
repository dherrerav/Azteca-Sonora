<?php
/**
 * sh404SEF support for com_wrapper component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_wrapper.php 2050 2011-06-30 13:52:38Z silianacom-svn $
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


  shRemoveFromGETVarsList('option');
  shRemoveFromGETVarsList('view');
  if (!empty($lang))
    shRemoveFromGETVarsList('lang'); 
  if (isset($Itemid))   
  shRemoveFromGETVarsList('Itemid');
  $shTemp = getMenuTitle($option, null, $Itemid, null, $shLangName );
  if (!empty($shTemp) && ($shTemp != '/')) $title[] = $shTemp; // V 1.2.4.t
	
// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------
  
?>
