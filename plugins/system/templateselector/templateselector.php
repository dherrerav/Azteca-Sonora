<?php
/**
 * 			plg System Template Selector
 * @version	 	1.2.1
 * @package		Template Selector
 * @copyright		Copyright (C) 2007 - 2011 Joomler!.net. All rights reserved.
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

jimport( 'joomla.plugin.plugin' );

class  plgSystemTemplateSelector extends JPlugin
{

	function plgSystemTemplateSelector(& $subject, $config)
	{
		parent::__construct($subject, $config);

	}

	function onAfterInitialise()
	{
		$app = JFactory::getApplication();

		if($app->isAdmin()){
			return;
		}

		$template_style_id = $app->getUserStateFromRequest('templateSelector', 'templatedirectory', '', 'int');
		if($template_style_id < 1){
			$template_style_id = JRequest::getVar('jTemplateSelector', '', 'cookie', 'int');
			if($template_style_id < 1){
				return;
			}
		}

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('template, params');
		$query->from('`#__template_styles`');
		$query->where('`client_id` = 0 AND `id`= '. (int)$template_style_id);
		$query->order('`id` ASC');
		$db->setQuery( $query );
		$row = $db->loadObject();
		if(!$row){
			return;
		}

		if(empty($row->template)){
			return;
		}

		class_exists('modTemplateSelector') or require(JPATH_SITE.DS.'modules'.DS.'mod_templateselector'.DS.'helper.php');
		$current = modTemplateSelector::getCurrentTemplate();

		if($current != $template_style_id && file_exists(JPATH_THEMES. DS. $row->template)){
			$app->setTemplate($row->template);
			$app->getTemplate(true)->params = new JRegistry($row->params);
		}
	}



}