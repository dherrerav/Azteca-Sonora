<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (JPATH_SITE.DS.'components'.DS.'com_jacomment'.DS.'helpers'.DS.'config.php');
?>
<?php 
$ischild = 1;
//parent id
require_once $helper->jaLoadBlock("comments/items.php");
?>
															