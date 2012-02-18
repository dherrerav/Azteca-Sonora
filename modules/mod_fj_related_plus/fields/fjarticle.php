<?php
/**
/**
 * @version		$Id: fjarticle.php 49 2010-12-04 01:50:52Z dextercowley $
 * @package		com_fjrelated_plus
 * @copyright	Copyright (C) 2008, 2009 Mark Dexter. Portions Copyright Open Source Matters. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html
 *
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JFormFieldFJArticle extends JField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Article';

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		$template 	= $mainframe->getTemplate();
		$fieldName	= $control_name.'['.$name.']';
		$article =& JTable::getInstance('content');
		if ($value) {
			$article->load($value);
		} else {
			$article->title = JText::_('No Intro Article');
		}

		$js = "
		function jSelectArticle(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById('sbox-window').close();
		}";
		$doc->addScriptDeclaration($js);

		$link = 'index.php?option=com_content&amp;task=element&amp;tmpl=component&amp;object='.$name;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="text" id="'.$name.'_name" value="'.htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('No Intro Article').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('Select').'</a></div></div>'."\n";
		$html .= "<div class=\"button2-left\"><div class=\"blank\"><a href=\"#\" onclick=\"document.getElementById('id_name').value='No Intro Article'; document.getElementById('id_id').value='';\">" . JText::_( 'Reset' ) ." </a></div></div>";
		$html .= "\n".'<input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.(int)$value.'" />';

		return $html;
	}
}
