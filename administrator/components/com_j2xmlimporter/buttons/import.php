<?php
/**
 * @version		1.6.0.54 buttons/import.php
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @since		1.5.0
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XMLImporter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

class JButtonImport extends JButton
{
	/**
	 * Button type
	 *
	 * @access	public
	 * @var		string
	 */
	var $_name = 'Import';

	function fetchButton($type='Import', $name = '', $text = '', $task = 'import', $list = true, $hideMenu = false )
	{
		$i18n_text	= JText::_($text);
		$class	= $this->fetchIconClass($name);
		$doAction = 'index.php?option=com_j2xmlimporter&amp;task='.$task;
		$doTask	= $this->_getCommand($text, $task, $hideMenu);

		$html = "";
		$html .= "<form name=\"".$text."Form\" method=\"post\" enctype=\"multipart/form-data\" action=\"$doAction\" style=\"float:left\">\n";
    	$html .= "<input type=\"file\" name=\"file_upload\">&nbsp;<br/><br/>\n";
    	$path		= JPATH_COMPONENT_ADMINISTRATOR.DS.'files';
    	if (JFolder::exists($path))
    	{
	    	$files = JFolder::files($path,'\.xml$|\.gz$',true,true);
			if (is_array($files) && (count($files) > 0))
			{
				$filenames = str_replace($path.'\\', '', $files);
				$options = array ();
				$options[] = JHTML::_('select.option', '', '- '.JText::_('Select a file').' -');
				foreach ($filenames as $file)
					$options[] = JHTML::_('select.option', $file, $file);
				$html .= JHTML::_('select.genericlist',  $options, 'local_file', 'class="inputbox"', 'value', 'text', '', 'local_file');
			}
    	}
		$html .= JHTML::_('form.token');
    	$html .= "</form>\n";
		$html .= "<a href=\"#\" onclick=\"$doTask\" class=\"toolbar\">\n";
		$html .= "<span class=\"$class\" title=\"$i18n_text\">\n";
		$html .= "</span>\n";
		$html .= "$i18n_text\n";
		$html .= "</a>\n";
		
   		return $html;
	}

	/**
	 * Get the JavaScript command for the button
	 *
	 * @access	private
	 * @param	string	$name	The task name as seen by the user
	 * @param	string	$task	The task used by the application
	 * @param	???		$list
	 * @param	boolean	$hide
	 * @return	string	JavaScript command string
	 * @since	1.5
	 */
	private function _getCommand($name, $task, $hide)
	{
		$todo		= JString::strtolower(JText::_($name));
		$message	= JText::sprintf('COM_J2XMLIMPORTER_BUTTON_PLEASE_SELECT_A_FILE_TO', $todo);
		$message	= addslashes($message);
		$hidecode	= $hide ? 'hideMainMenu();' : '';

		return "javascript:if((document.".$name."Form.file_upload.value=='') && (document.".$name."Form.local_file.value=='')){alert('$message');}else{ $hidecode document.".$name."Form.submit()}";
	}

	/**
	 * Get the name of the toolbar.
	 *
	 * @return	string
	 * @since	1.5
	 */
	private function _getToolbarName()
	{
		return $this->_parent->getName();
	}
}
?>