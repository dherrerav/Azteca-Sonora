<?php
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

Zend_Loader::loadClass('Zend_Date');

class modMobileNewsHelper {

	public static function getArticles(&$params) {
		$db =& JFactory::getDbo();
		$application =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$styleSheets = array_keys($document->_styleSheets);
		$styleSheetsFound = false;
		for ($i = 0; $i < count($styleSheets); $i++) {
			if (stripos($styleSheets[$i], 'mod_breaking_news.css') !== false) {
				$styleSheetsFound = true;
			}
		}
		if (!$styleSheetsFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_mobile_news/css/mod_mobile_news.css');
		}
		$applicationParams = $application->getParams();
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$model->setState('list.select', 'a.title, a.introtext, a.fulltext, a.attribs, a.created, a.id, a.alias, a.catid, a.publish_up');
		$model->setState('params', $applicationParams);
		$catids = $params->get('catids');
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		if ($catids) {
			if ($params->get('show_child_category_articles', 0) && (int) $params->get('levels', 0) > 0) {
				// Get an instance of the generic categories model
				$categories = JModel::getInstance('Categories', 'ContentModel', array('ignore_request' => true));
				$categories->setState('params', $applicationParams);
				$levels = $params->get('levels', 1) ? $params->get('levels', 1) : 9999;
				$categories->setState('filter.get_children', $levels);
				$categories->setState('filter.published', 1);
				$categories->setState('filter.access', $access);
				$additional_catids = array();
				foreach($catids as $catid) {
					$categories->setState('filter.parentId', $catid);
					$recursive = true;
					$items = $categories->getItems($recursive);
		
					if ($items) {
						foreach($items as $category) {
							$condition = (($category->level - $categories->getParent()->level) <= $levels);
							if ($condition) {
								$additional_catids[] = $category->id;
							}
		
						}
					}
				}
				$catids = array_unique(array_merge($catids, $additional_catids));
			}
		}
		$model->setState('filter.category_id', $catids);
		$model->setState('filter.access', $access);
		// Filter by language
		$model->setState('filter.language',$application->getLanguageFilter());
		// Ordering
		$model->setState('list.ordering', $params->get('ordering', 'a.ordering'));
		$model->setState('list.direction', $params->get('ordering_direction', 'ASC'));
		$model->setState('list.start', $params->get('start', 0));
		$model->setState('list.limit', $params->get('limit', 5));
		// New Parameters
		$model->setState('filter.featured', $params->get('show_front', 'show'));
		$model->setState('filter.published', 1);
		$articles = $model->getItems();
		foreach ($articles as &$article) {
			$article->slug = $article->id . ':' . $article->alias;
			$article->catslug = $article->catid ? $article->catid . ':' . $article->category_alias : $article->catid;
			if ($access || in_array($article->access, $authorised)) {
				$article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug));
			} else {
				$menu = $application->getMenu();
				$menuItems = $menu->getItems('link', 'index.php?option=com_users&view=login');
				if (isset($menuItems[0])) {
					$itemId = $menuItems[0]->id;
				} else if (JRequest::getInt('Itemid') > 0) {
					$itemId = JRequest::getInt('Itemid');
				}
				$article->link = JRequest::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
			}
			if ($article->catid) {
				$article->categoryLink = JRoute::_(ContentHelperRoute::getCategoryRoute($article->catid));
				$article->cateogryTitle = '<a href="' . $article->categoryLink . '">' . $article->category_title . '</a>';
			} else {
				$article->categoryTitle = $show_category ? $article->category_title : '';
			}
			$article->date = new Zend_Date($article->publish_up);
			$article->introtext = preg_replace('/{video}(.*?){\/video}/', '', $article->introtext);
			$article->introtext = strip_tags($article->introtext, '<p><img>');
		}
		return $articles;
	}
}