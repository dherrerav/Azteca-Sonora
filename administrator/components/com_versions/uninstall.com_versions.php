
<?php
/**
 * "Simple Content Versioning" - http://www.fatica.net
 *
 * @version         $Id:$
 * @copyright       Copyright 2008, Michael Fatica
 * @license         GNU/GPLV2.0
 * @link            http://www.fatica.net
 * @package         Simple Content Versioning
 * @revision        $Revision$
 * @lastmodified    $id$
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

function com_uninstall(){
	
	$mainframe = JFactory::getApplication();
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	
	$path = JPATH_ADMINISTRATOR .DS. 'components'  .DS. 'com_versions';
	
	if( !JFolder::delete( $path ) ){
		$mainframe->enqueueMessage( JText::_('Unable to remove component directory!') );
	}
	
	//language/en-GB/en-GB.plg_content_version.ini
	
	/*$path = JPATH_ROOT .DS. 'language' .DS. 'en-GB'  .DS. 'en-GB.plg_editors-xtd_versioning.ini';
	
	if( !JFolder::delete( $path ) ){
		$mainframe->enqueueMessage( JText::_('Unable to remove!' . $path) );
	}*/	
	
}