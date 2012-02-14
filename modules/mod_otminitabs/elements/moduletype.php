<?php
/**===========================================================================================
# mod_otminitabs        OT Mini Tabs module for Joomla 1.7
#=============================================================================================
# author                OmegaTheme.com
# copyright             Copyright (C) 2011 OmegaTheme.com. All rights reserved.
# @license              http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website               http://omegatheme.com
# Technical support     Forum - http://omegatheme.com/forum/
#=============================================================================================*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.html.parameter');

class JFormFieldModuleType extends JFormField
{
    protected $type = 'ModuleType'; //the form field type
    
    protected function getInput()
    {
    // Initialize variables.
        $html = array();
        $attr = '';
        
        $db =& JFactory::getDBO();
        
        $currentModId = JRequest::getVar('id');
        $queryparams = "SELECT `params` FROM `#__modules` WHERE `id` = $currentModId";
        $db->setQuery($queryparams);
        $data = $db->loadResult();
        $params = new JParameter($data);
        
        $options = array();
        
        $querymodtype = "SELECT DISTINCT `module` FROM `#__modules` WHERE `published` = 1 AND `client_id` = 0 AND `id` <> {$currentModId} ORDER BY `module`";
        $db->setQuery($querymodtype);
        $db->getQuery();
        $options = $db->loadObjectList();
        
        $temp_opt = array();
        if (count($options)){
            foreach ($options as $idx => $option){
                $tmp = JHtml::_('select.option', (string) $option->module, JText::alt(trim((string) $option->module), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text', false);
                $temp_opt[] = $tmp;
            }
        }
        array_unshift ( $temp_opt, JHTML::_('select.option', '', JText::_('MOD_OT_MINI_TABS_SELECT_MODULE_TYPE'), 'value', 'text', false));
        // Initialize some field attributes.
        $attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
        
        $attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
        $attr .= $this->multiple ? ' multiple="multiple"' : '';
        
        // Create a regular list.
        $html[] = JHtml::_('select.genericlist', $temp_opt, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
        return implode($html);
    }
}
