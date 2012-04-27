<?php
/**
 * 			Mod Template Selector Helper
 * @version	 	1.2.1
 * @package		Template Selector
 * @copyright		Copyright (C) 2009 Joomler!.net. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * @author		Joomler!.net  joomlers@gmail.com
 * @link 			http://www.joomler.net/
 */

/**
* @package		Joomla
* @copyright		Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modTemplateSelector
{
	function getLists($params)
	{
		$app = JFactory::getApplication();

		if($app->isAdmin()){
			return array();
		}

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id AS value, title AS text, template');
		$query->from('`#__template_styles`');
		$query->where('`client_id` = 0');
		$query->order('`id` ASC');

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		if(count($rows) < 1){
			return array();
		}

		$lists = array();

		$listSelected = $params->get('templates', array());
		if(!is_array($listSelected)){
			$listSelected = array($listSelected);
		}

		JArrayHelper::toInteger($listSelected);
		$listSelected = array_unique($listSelected);
		if(count($listSelected) == 1 && $listSelected[0] == 0){
			$listSelected = array();
		}

		$selected = $app->getTemplate();
		$lists['current_image'] = JURI::base(true). '/templates/'. $selected. '/template_thumbnail.png';
		$options = array();
		$templates = array();
		foreach($rows as $row)  {
			if(in_array($row->value, $listSelected) || count($listSelected) < 1){
				$row->text = JText::_($row->text);
				$templates[$row->value] = $row->template;
				$options[] = $row;
			}
		}


		$selected = $app->getUserStateFromRequest('templateSelector', 'templatedirectory', 0, 'int');
		$template = $app->getTemplate();
		$lists['current_image'] = JURI::base(true). '/templates/'. $template. '/template_thumbnail.png';
		if($selected < 1){
			$selected = self::getCurrentTemplate();
		}

		$jsoptions = array();
		$jsoptions['templates'] = $templates;
		$jsoptions['base'] = JURI::base(true);
		$jsoptions['duration'] = intval($params->get('duration', 365));
		$jsoptions['selected'] = $selected;
		$jsoptions = json_encode($jsoptions);

		$base = JURI::base(true). '/templates/';
		JHtml::_('behavior.framework');
		JHtml::_('script', 'templateselector.js', 'modules/mod_templateselector/assets/');
		$javascript = "window.addEvent('domready', function(){var jTSelector = new jTemplateSelector($jsoptions);});";

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($javascript);

		$lists['list'] = JHTML::_('select.genericlist', $options, 'tmpldirectory', array(
			'id' => 'jTmplDirectories',
			'list.attr' => 'class="inputbox"',
			'list.select' => $selected)
		);

		$lists['selected'] = $selected;

		return $lists;
	}

	public static function getCurrentTemplate()
	{
		$app = JFactory::getApplication();
		$menus = $app->getMenu('site');
		$menu = $menus->getActive();
		if($menu){
			$template_style_id = (int)$menu->params->get('template_style_id');
			if($template_style_id > 0){
				return $template_style_id;
			}
		}

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('`#__template_styles`');
		$query->where('`client_id` = 0 AND `home` = 1');
		$db->setQuery( $query );
		return intval( $db->loadResult() );
	}
}
