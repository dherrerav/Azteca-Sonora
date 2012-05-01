<?php
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';
require_once JPATH_SITE . '/plugins/system/jat3/jat3/core/libs/Browser.php';

jimport('joomla.application.component.model');

Zend_Loader::loadClass('Zend_Date');

JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

class modMobileVideosHelper {

	private static $_videoCode = '/{video}(.*?){\/video}/';

	private static $_browser;

	public static function getArticles(&$params) {
		$application =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		self::$_browser = new Browser();
		$styleSheets = array_keys($document->_styleSheets);
		$styleSheetFound = false;
		for ($i = 0; $i < count($styleSheets); $i++) {
			if (stripos($styleSheets[$i], 'mod_mobile_videos.css') !== false) {
				$styleSheetFound = true;
			}
		}
		if (!$styleSheetFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_mobile_videos/css/mod_mobile_videos.css');
		}
		$applicationParams = $application->getParams();
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$model->setState('params', $applicationParams);
		$catids = $params->get('catids');
		if ($catids) {
			if ($params->get('show_child_category_articles', 0) && (int) $params->get('levels', 0) > 0) {
				// Get an instance of the generic categories model
				$categories = JModel::getInstance('Categories', 'ContentModel', array('ignore_request' => true));
				$categories->setState('params', $appParams);
				$levels = $params->get('levels', 1) ? $params->get('levels', 1) : 9999;
				$categories->setState('filter.get_children', $levels);
				$categories->setState('filter.published', 1);
				$categories->setState('filter.access', $access);
				$additional_catids = array();
				foreach($catids as $catid)
				{
					$categories->setState('filter.parentId', $catid);
					$recursive = true;
					$items = $categories->getItems($recursive);

					if ($items)
					{
						foreach($items as $category)
						{
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
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$articles = array();
		$model->setState('filter.access', $access);
		// Filter by language
		$model->setState('filter.language',$application->getLanguageFilter());
		$ordering = $params->get('ordering', 'a.publish_up');
		$ordering_direction = $params->get('ordering_direction', 'DESC');
		// Limit featured
		$model->setState('filter.featured', 'show');
		$model->setState('filter.published', 1);
		$model->setState('list.limit', $params->get('limit'));
		$model->setState('list.start', $params->get('start'));
		$model->setState('list.ordering', 'a.publish_up');
		$model->setState('list.direction', 'DESC');
		$model->setState('list.filter', 'a.introtext');
		$model->setState('filter.keyword', '{video}');
		$model->setState('filter.category_id', $catids);
		$articles = $model->getItems();
		foreach ($articles as &$article) {
			preg_match(self::$_videoCode, $article->introtext, $matches);
			$source = $matches[1];
			$article->slug = $article->id . ':' . $article->alias;
			if ($access || in_array($article->access, $authorised)) {
				$article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
			} else {
				$article->link = JRoute::_('index.php?option=com_user&view=login');
			}
			$article->introtext = self::_cleanText($article->introtext);
			$article->date = new Zend_Date($article->publish_up);
			$article->image = self::_getImage($source, $params->get('image_width', 100), $params->get('image_height', 67));
		}
		return $articles;
	}

	private static function _cleanText($text) {
		return preg_replace(self::$_videoCode, '', strip_tags($text));
	}

	public static function _getImage($source, $width = 100, $height = 67) {
		$image = 'images' . DS . 'previews' . DS . substr($source, 0, strpos($source, '.')) . '_' . $width . 'x' . $height . '.jpg';
		$path = JPATH_SITE . DS . dirname($image);
		if (file_exists($source) && !file_exists($image)) {
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$width -= $width % 2;
			$height -= $height % 2;
			$command = 'ffmpeg -i "' . JPATH_SITE . DS . $source . '" -vframes 1 -s ' . $width . 'x' . $height . ' "' . JPATH_SITE . DS . $image . '" 2>&1';
			try {
				shell_exec($command);
			} catch (Exception $e) {
				var_dump($e);
			}
		}
		return $image;
	}
}