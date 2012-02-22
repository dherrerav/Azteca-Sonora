<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_JEXEC') or die('Restricted access');

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

require_once JPATH_SITE . '/libraries/simple_html_dom.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

abstract class modTheMostHelper {

	public static function getArticles(&$params) {
		
		$app			= JFactory::getApplication();
		$db				= JFactory::getDbo();

		// Get an instance of the generic articles model
		/**
		 * @var ContentModelArticles $model
		 */
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$appParams = JFactory::getApplication()->getParams();
		
		$contentToShow = $params->get('content_to_show');
		
		$model->setState('params', $appParams);

		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $params->get('count', 5));

		$model->setState('filter.published', 1);

		//$model->setState('list.select', 'a.id, a.title, a.alias, a.introtext, a.catid');
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		// Category filter
		$model->setState('filter.category_id', $params->get('catid', array()));

		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());
		
		// Set ordering
		switch ($contentToShow) {
			case 'most_read';
				$model->setState('list.ordering', 'a.hits');
				$model->setState('list.direction', 'DESC');
				$model->setState('filter.nDays', 1);
				break;
			case 'featured':
				$ordering = 'a.publish_up';
				$model->setState('filter.featured', 1);
				switch ($params->get('show_featured'))
				{
					case '1':
						$model->setState('filter.featured', 'only');
						break;
					case '0':
						$model->setState('filter.featured', 'hide');
						break;
					default:
						$model->setState('filter.featured', 'show');
						break;
				}
			default:
				$ordering = $params->get('ordering', 'a.publish_up');
		}
		
		$model->setState('list.ordering', $ordering);
		if (trim($ordering) == 'rand()') {
			$model->setState('list.direction', '');
		} else {
			$model->setState('list.direction', 'DESC');
		}

		$items = $model->getItems();
		
		foreach ($items as $item) {
			$item->slug = $item->id . ':' . $item->alias;
			$item->catslug = $item->catid . ':' . $item->category_alias;
			if ($access || in_array($item->access, $authorised)) {
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}
			$item->introtext = JHtml::_('content.prepare', $item->introtext);
			
			$item->image = null;
			if ($params->get('image')) {
				$html = new simple_html_dom();
				$html->load($item->introtext);
				$images = $html->find('img');
				if (count($images) > 0) {
					$image = $images[0];
					$item->image = new stdClass();
					$item->image->image = $image;
					$item->image->src = $image->src;
					$item->image->title = $image->title;
					$item->image->alt = $image->alt;
					$item->image->width = 'width="' . $params->get('width', 195) . '"';
					$item->image->height = 'height="' . $params->get('height', 144) . '"';
				}
				
			} else {
				$item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
			}

			$results = $app->triggerEvent('onContentAfterDisplay', array('com_content.article', &$item, &$params, 1));
			$item->afterDisplayTitle = trim(implode('\n', $results));

			$results = $app->triggerEvent('onContentBeforeDisplay', array('com_content.article', &$item, &$params, 1));
			$item->beforeDisplayContent = trim(implode('\n', $results));
		}

		return $items;
	}
}