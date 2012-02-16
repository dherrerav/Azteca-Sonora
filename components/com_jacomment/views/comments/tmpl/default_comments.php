<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$ischild = 0;
if(@isset($this->ischild)){
	$ischild = $this->ischild;	
}
require (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'config.php');
require $helper->jaLoadBlock("comments/items.php");
?>