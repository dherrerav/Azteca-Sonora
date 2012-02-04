<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


class Modelcontushdvideosharelanguagexml extends JModel
{
	/**
	 * Gets the greeting
	 * 
	 * @return string The greeting to be displayed to the user
	 */
        function getlanguage()
        {

//          $db =& JFactory::getDBO();
//          $query = "select * from #__hdflv_language where published='1' and home=1";//and id=2";
//            $db->setQuery( $query );
//            $rows = $db->loadObjectList();
//            return $rows;
        }
}