<?php
/**
 * "Simple Content Versioning" - http://www.fatica.net
 *
 * @version         $Id: versions_package.xml 423 2008-12-11 05:00:05Z Fatica $
 * @copyright       Copyright 2009, Michael Fatica
 * @license         GNU/GPLV2.0
 * @link            http://www.fatica.net
 * @package         Simple Content Versioning
 * @revision        $Revision$
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


	function com_install()
	{
	$mainframe = JFactory::getApplication();
	
	if(!(is_writeable(JPATH_ROOT.DS."tmp"))){
		 JError::raiseError('-1', JText::_('Cannot write to /tmp, installer aborting'));
	    die();
	}
	
	
	if(!(is_writeable(JPATH_ROOT.DS."plugins"))){
		 JError::raiseError('-1', JText::_('Cannot write to '.JPATH_ROOT.DS."plugins".', installer aborting'));
	 die();
	}
	
	if(!(is_writeable(JPATH_ROOT.DS."administrator".DS."components"))){
		 JError::raiseError('-1', JText::_('Cannot write to '.JPATH_ROOT.DS."administrator".DS."components".', installer aborting'));
	 die();
	}
	
	// do not allow direct linking

	

	$db  =& JFactory::getDBO();
	
	  		//create the versioning table
	  		$sql = 'CREATE TABLE IF NOT EXISTS `#__version` (
				  `id` double NOT NULL auto_increment,
				  `title` varchar(255) default NULL,
				  `alias` varchar(255) default NULL,
				  `title_alias` varchar(255) default NULL,
				  `introtext` longblob,
				  `fulltext` longblob,
				  `state` tinyint(3) default NULL,
				  `sectionid` double default NULL,
				  `mask` double default NULL,
				  `catid` double default NULL,
				  `created` datetime default NULL,
				  `created_by` double default NULL,
				  `created_by_alias` varchar(255) default NULL,
				  `modified` datetime default NULL,
				  `modified_by` double default NULL,
				  `checked_out` double default NULL,
				  `checked_out_time` datetime default NULL,
				  `publish_up` datetime default NULL,
				  `publish_down` datetime default NULL,
				  `images` blob,
				  `urls` blob,
				  `attribs` blob,
				  `version` double default NULL,
				  `parentid` double default NULL,
				  `ordering` double default NULL,
				  `metakey` blob,
				  `metadesc` blob,
				  `access` double default NULL,
				  `hits` double default NULL,
				  `metadata` blob,
				  `content_id` double default NULL,
				  `language_id` double default NULL,
				  `stage` double default NULL,
				  `autosaved` double default NULL,
				  `featured` int(11) default null,
				  `xreference` varchar(50) default NULL,
				  `language` varchar(50) default NULL,
				  `asset_id` int(11) default NULL,
				  PRIMARY KEY  (`id`),
				  KEY `idx_content_id` (`content_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8';
	  		
	  		$db->setQuery($sql);
	  		$db->query() or die("Error in $sql");
	  		
	  		/**
	  		 * used only in the enterprise workflow addon, but must exist for left-joins in com_versions
	  		 */
		$sql = 'CREATE TABLE  IF NOT EXISTS  `#__fc_workflow` (
			  `id` int(11) NOT NULL auto_increment,
			  `notes` text,
			  `version_id` int(11) default NULL,
			  `stage` int(11) default NULL,
			  `content_id` int(11) default NULL,
			  `reviewer` varchar(255) default NULL,
			  `ts` timestamp NULL default CURRENT_TIMESTAMP,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
	  		
	  		$db->setQuery($sql);
	  		$db->query() or die("Error in $sql");	  		  		
	  	
	  		
		
		//upgrade the database if needed
		$db  =& JFactory::getDBO();
			$db->setQuery( "UPDATE #__components SET `link`='option=com_versions' WHERE `option`='com_versions'");
			$row = $db->loadObject();
		
			
		//upgrade the database if needed
		$db  =& JFactory::getDBO();
			$db->setQuery( "show columns from #__version where `Field`='autosaved'");
			$row = $db->loadObject();
			
			//add the stage column
			if(@$row->Field != 'autosaved'){
				
		    $db  =& JFactory::getDBO();
		  	$db->setQuery( "ALTER TABLE #__version ADD autosaved double;");
		    $db->Query();	  	
					
			}	

		
		//upgrade the database if needed
		$db  =& JFactory::getDBO();
			$db->setQuery( "show columns from #__version where `Field`='featured'");
			$row = $db->loadObject();
			
			//add the stage column
			if(@$row->Field != 'featured'){
				
		    $db  =& JFactory::getDBO();
		  	$db->setQuery( "ALTER TABLE #__version ADD featured int(11);");
		    $db->Query();	  	
					
			}	
				 
		//upgrade the database if needed
		$db  =& JFactory::getDBO();
			$db->setQuery( "show columns from #__version where `Field`='language_id'");
			$row = $db->loadObject();
			
			//add the stage column
			if(@$row->Field != 'language_id'){
				
		    $db  =& JFactory::getDBO();
		  	$db->setQuery( "ALTER TABLE #__version ADD `language_id` double;");
		    $db->Query();	  	
					
			}	
				 
		//upgrade the database if needed
		$db  =& JFactory::getDBO();
			$db->setQuery( "show columns from #__version where `Field`='xreference'");
			$row = $db->loadObject();
			
			//add the stage column
			if(@$row->Field != 'xreference'){
				
		    $db  =& JFactory::getDBO();
		  	$db->setQuery( "ALTER TABLE #__version ADD `xreference` varchar(50);");
		    $db->Query();	  	
					
			}	

				//upgrade the database if needed
		$db  =& JFactory::getDBO();
			$db->setQuery( "show columns from #__version where `Field`='asset_id'");
			$row = $db->loadObject();
			
			//add the stage column
			if(@$row->Field != 'asset_id'){
				
		    $db  =& JFactory::getDBO();
		  	$db->setQuery( "ALTER TABLE #__version ADD `asset_id` int(11);");
		    $db->Query();	  	
					
			}	
			//upgrade the database if needed
		$db  =& JFactory::getDBO();
			$db->setQuery( "show columns from #__version where `Field`='language'");
			$row = $db->loadObject();
			
			//add the stage column
			if(@$row->Field != 'language'){
				
		    $db  =& JFactory::getDBO();
		  	$db->setQuery( "ALTER TABLE #__version ADD `language` varchar(50);");
		    $db->Query();	  	
					
			}			
	  	 		
	  			
	  	}
	  	
	  	
	  	
	/*}  */	
?>
