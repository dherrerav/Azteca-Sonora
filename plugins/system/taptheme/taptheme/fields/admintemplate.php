<?php

// no direct access
defined('_JEXEC') or die;
class JFormFieldAdminTemplate extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'admintemplate';

	/**
	 * Method to get the field input markup.
	 *
	 * TODO: Add access check.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput() {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('template, id, title');
		$query->from('#__template_styles');
		$query->where('client_id = 1');
		$db->setQuery($query);
		$templates = $db->loadObjectList();
		
		$options = array();
		$options[] = JHTML::_('select.option', '', JText::_('DEFAULT'));
		foreach($templates as $t) :
			$options[] = JHTML::_('select.option', $t->id, $t->title);
		endforeach;

		return JHTML::_('select.genericlist',  $options, $this->name, 'class="inputbox"', 'value', 'text', $this->value );
		
	}
	
}