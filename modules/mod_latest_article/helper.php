<?php
defined('_JEXEC') or die;
require_once JPATH_SITE . '/components/com_content/helpers/route.php';
require_once JPATH_SITE . '/libraries/simple_html_dom.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

class modLatestArticleHelper {

	public function getArticles(&$params) {
		$application =& JFactory::getApplication();
		$applicationParams = $application->getParams();
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$model->setState('params', $applicationParams);
		$catids = $params->get('catids');
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
		$model->setState('list.select', 'a.title, a.introtext, a.fulltext, a.attribs, a.created, a.id, a.alias, a.catid');
		$model->setState('list.limit', $params->get('count', 1));
		$model->setState('list.ordering', 'a.created');
		$model->setState('list.direction', 'DESC');
		$model->setState('filter.published', 1);
		$articles = $model->getItems();
		$html = new simple_html_dom();
		foreach ($articles as &$article) {
			$text = $params->get('text_to_show') !== 'both' ? $article->{$params->get('text_to_show')} : $article->introtext . $article->fulltext;
			$html->load($text);
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
			if ((boolean)$params->get('show_image')) {
				$article->image = null;
				if (preg_match('/{video}(.*?){\/video}/', $text, $matches)) {
					$source = $matches[0];
					$width = $params->get('width');
					$height = $params->get('height');
					$article->image = new stdClass();
					$title = str_replace(array('"', '\''), '&quote;', $article->title);
					$article->image->title = $title;
					$article->image->src = self::_getVideoImage($source, $width, $height);
					$article->image->alt = $title;
				} else {
					$images = $html->find('img');
					if (count($images) > 0) {
						$image = $images[0];
						$article->image = new stdClass();
						$article->image->title = $image->title;
						$article->image->src = $image->src;
						$article->image->alt = $image->alt;
					}
				}
			}
			$article->text = self::_removeCodes($text);
		}
		return $articles;
	}

	private static function _getVideoImage($filename, $width, $height) {
		$filename = preg_replace(array('/{video}/', '/{\/video}/'), '', $filename);
		$image = 'images' . DS . 'previews' . DS . substr($filename, 0, strpos($filename, '.')) . '_' . $width . 'x' . $height . '.jpg';
		$path = JPATH_SITE . DS . dirname($image);
		if (file_exists($filename) && !file_exists($image)) {
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$width -= $width % 2;
			$height -= $height % 2;
			$command = 'ffmpeg -i "' . JPATH_SITE . DS . $filename . '" -vframes 1 -s ' . $width . 'x' . $height . ' "' . JPATH_SITE . DS . $image .  '" 2>&1';
			shell_exec($command);
		}
		return $image;
	}

	private static function _removeCodes($text) {
		// Remove video code
		$text = preg_replace('/{video}(.*?){\/video}/', '', $text);
		// Remove images
		$text = preg_replace('/<img[^\>]*>/', '', $text);
		// Remove <p>
		$text = preg_replace('/<p[^\>]*>/', '', $text);
		return $text;
	}
}