<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die('Restricted access');
echo $this->detail;
$link = JRoute::_( 'index.php?option=com_hello&view=hello&task=xml');
echo "<a href=\"".$link."\">Task=xml</a>";
?>
