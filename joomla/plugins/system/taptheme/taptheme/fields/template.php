<?php

// no direct access
defined('_JEXEC') or die;
class JFormFieldTemplate extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'template';

	/**
	 * Method to get the field input markup.
	 *
	 * TODO: Add access check.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput() {

		JLoader::register('TemplatesHelper', JPATH_ADMINISTRATOR.'/components/com_templates/helpers/templates.php');
    
		$template_path = JPATH_SITE.'/templates';
		$templates = JFolder::folders($template_path);
		
		$options = array();
		$options[] = JHTML::_('select.option', '', JText::_('DEFAULT'));
		for($i=0; $i<count($templates); $i++) :
			$template = $templates[$i];
			if ($template == 'system')
				continue;
				
			$t = TemplatesHelper::parseXMLTemplateFile(JPATH_SITE, $template);
			if ($t !== false) :
				$options[] = JHTML::_('select.option', $template, $t->name);
			endif;
		endfor;

	//	return JHTML::_('select.genericlist',  $options, $this->name, 'class="inputbox"', 'value', 'text', $this->value );
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('template, id, title');
		$query->from('#__template_styles');
		$query->where('client_id = 0');
		$db->setQuery($query);
		$templates = $db->loadObjectList();
		
		$options = array();
		$options[] = JHTML::_('select.option', '', JText::_('DEFAULT'));
		foreach($templates as $t) :
			$options[] = JHTML::_('select.option', $t->id.'::'.$t->template, $t->title);
		endforeach;

		return JHTML::_('select.genericlist',  $options, $this->name, 'class="inputbox"', 'value', 'text', $this->value );
		
	}
	
}
