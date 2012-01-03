<?php

defined('_JEXEC') or die;

class APHelper {
	
	public static function setParams($document) {
		if (JRequest::getVar('taptheme.style')) :
			$style = JRequest::getVar('taptheme.style');
			$document->set('params', self::getTemplateParams($style));
		endif;
	}
	
	private static function getTemplateParams($id) {
		$app = JFactory::getApplication();
		$cache = JFactory::getCache('com_templates', '');
		if ($app->get('_language_filter')) {
			$tag = JFactory::getLanguage()->getTag();
		}
		else {
			$tag ='';
		}
		if (!$templates = $cache->get('templates0'.$tag)) {
			// Load styles
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id, home, template, params');
			$query->from('#__template_styles');
			$query->where('client_id = 0');

			$db->setQuery($query);
			$templates = $db->loadObjectList('id');
			foreach($templates as &$template) {
				$registry = new JRegistry;
				$registry->loadJSON($template->params);
				$template->params = $registry;

				// Create home element
				if ($template->home == '1' && !isset($templates[0]) || $app->get('_language_filter') && $template->home == $tag) {
					$templates[0] = clone $template;
				}
			}
			$cache->store($templates, 'templates0'.$tag);
		}

		$template = $templates[$id];
		
		return $template->params;
	}
	
}