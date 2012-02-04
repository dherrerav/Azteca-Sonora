<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class Modelcontushdvideosharegooglead extends JModel
{
	/**
	 * Gets the greeting
	 * 
	 * @return string The greeting to be displayed to the user
	 */
	function getgooglead()
	{
            global $db;
            $db =& JFactory::getDBO();
            $query1 = "select * from #__hdflv_googlead where publish='1' and id='1'";
            $db->setQuery( $query1 );
            $fields = $db->loadObjectList();
            echo html_entity_decode(stripcslashes($fields[0]->code));
            exit();
	}
}