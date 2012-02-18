<?php
defined('_JEXEC') or die;
require_once JPATH_SITE . '/components/com_content/helpers/route.php';
jimport('joomla.application.component.model');
JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');
abstract class modVideoPlayerHelper {
	private static $_videoCode = '/{video}(.*?){\/video}/';
	public static function getVideos(&$params) {
		$application =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$styleSheets = array_keys($document->_styleSheets);
		$scripts = array_keys($document->_scripts);
		$flowplayerFound = false;
		$videoPlayerJsFound = false;
		$videoPlayerCssFound = false;
		$videoPlayerSkinFound = false;
		$scrollbarJsFound = false;
		$scrollbarCssFound = false;
		for ($i = 0; $i < count($scripts); $i++) {
			if (stripos($scripts[$i], 'flowplayer.min.js') !== false) {
				$flowplayerFound = true;
			}
			if (stripos($scripts[$i], 'mod_videoplayer.js') !== false) {
				$videoPlayerJsFound = true;
			}
			if (stripos($scripts[$i], 'jquery.scroll.min.js') !== false) {
				$scrollbarJsFound = true;
			}
		}
		for ($i = 0; $i < count($styleSheets); $i++) {
			if (stripos($styleSheets[$i], 'mod_videoplayer.css') !== false) {
				$videoPlayerCssFound = true;
			}
			if (stripos($styleSheets[$i], $params->get('skin') . '.css') !== false) {
				$videoPlayerSkinFound = true;
			}
			if (stripos($styleSheets[$i], 'scrollbar.css') !== false) {
				$scrollbarCssFound = true;
			}
		}
		if (!$flowplayerFound) {
			$document->addScript(JURI::base() . 'modules/mod_videoplayer/js/flowplayer.min.js');
		}
		if (!$videoPlayerJsFound) {
			$document->addScript(JURI::base() . 'modules/mod_videoplayer/js/mod_videoplayer.js');
		}
		if (!$scrollbarJsFound) {
			$document->addScript(JURI::base() . 'modules/mod_videoplayer/js/jquery.scroll.min.js');
		}
		if (!$videoPlayerCssFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_videoplayer/css/mod_videoplayer.css');
		}
		if (!$videoPlayerSkinFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_videoplayer/css/skins/' . $params->get('skin')  . '.css');
		}
		if (!$scrollbarCssFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_videoplayer/css/scrollbar.css');
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
		$model->setState('filter.featured', $params->get('show_front', 'show'));
		$model->setState('list.ordering', $ordering);
		foreach ($catids as $catid) {
			$model->setState('filter.category_id', $catid);
			$i = 1;
			foreach ($model->getItems() as $article) {
				if (preg_match('/{video}(.*?){\/video}/', $article->introtext, $matches)) {
					$source = $matches[1];
					$video = new stdClass();
					$video->id = 'video_' . $article->id;
					$video->title = $article->title;
					$slug = $article->id . ':' . $article->alias;
					if ($access || in_array($article->access, $authorised)) {
						$video->link = JRoute::_(ContentHelperRoute::getArticleRoute($slug, $article->catid));
					} else {
						$video->link = JRoute::_('index.php?option=com_user&view=login');
					}
					$video->description = preg_replace('/<img[^>]*>/', '', self::_removeCode($article->introtext));
					$date =& JFactory::getDate($article->publish_up);
					$video->date = $date->toFormat('%Y-%m-%d');
					$video->time = $date->toFormat('%H:%M:%S');
					$extension = strtolower(substr(strrchr($source, '.'), 1));
					$video->source = $source;
					$video->mp4 = str_replace('/' . $extension . '/', '/mp4/', substr($source, 0, strpos($source, '.'))) . '.mp4';
					$video->flv = str_replace('/' . $extension . '/', '/flv/', substr($source, 0, strpos($source, '.'))) . '.flv';
					$video->m4v = str_replace('/' . $extension . '/', '/m4v/', substr($source, 0, strpos($source, '.'))) . '.m4v';
					$video->image = self::_getVideoImage($source, (int)$params->get('image_width'), (int)$params->get('image_height'));
					$video->preview = self::_getVideoImage($source, (int)$params->get('player_width'), (int)$params->get('player_height'));
					$video->category = $article->category_title;
					$video->parent = $article->parent_title;
					if (empty($articles[$article->category_alias])) {
						$category = new stdClass();
						$category->title = $article->category_title;
						$category->id = (int)$article->catid;
						$category->link = JRoute::_(ContentHelperRoute::getCategoryRoute($article->catid));
						$articles[$article->category_alias]['category'] = $category;
					}
					$articles[$article->category_alias]['videos'][] = $video;
					$i++;
				}
				if ($params->get('count') == $i) break;
			}
		}
		//var_dump($articles);
		return $articles;
		/*
		$application =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$app	= JFactory::getApplication();
		$document =& JFactory::getDocument();
		$db		= JFactory::getDbo();

		// Get an instance of the generic articles model
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$appParams = JFactory::getApplication()->getParams();
		$model->setState('params', $appParams);
		$offset = $params->get('offset');
		if ((int)$params->get('count_articles') < (int)$params->get('count_thumbs')) {
			$params->set('count_thumbs', (int)$params->get('count_articles'));
		}
		$count = (int)$params->get('count_articles') + (int)$params->get('count_links');
		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', $count);
		$model->setState('filter.published', 1);
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
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
		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());

		// Set ordering
		$ordering = $params->get('ordering', 'a.publish_up');
		$ordering_direction = $params->get('ordering_direction', 'DESC');
		// Limit featured
		$model->setState('filter.featured', $params->get('show_front', 'show'));
		$model->setState('list.ordering', $ordering);
		if (trim($ordering) == 'rand()') {
			$model->setState('list.direction', '');
		} else {
			$model->setState('list.direction', $ordering_direction);
		}
		$model->setState('filter.results', '{video}');
		//	Retrieve Content
		$articles = $model->getItems();
		var_dump($model->setState('filter.results'));
		
		/*
		$offset = $params->get('offset');
		if ((int)$params->get('count_articles') < (int)$params->get('count_thumbs')) {
			$params->set('count_thumbs', (int)$params->get('count_articles'));
		}
		$count = (int)$params->get('count_articles') + (int)$params->get('count_links');
		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', $count);
		$model->setState('filter.published', 1);
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		$catids = $params->get('catids');
		// Category filter

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

			$model->setState('filter.category_id', $catids);
		}

		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());

		// Set ordering
		$ordering = $params->get('ordering', 'a.publish_up');
		$ordering_direction = $params->get('ordering_direction', 'DESC');
		// Limit featured
		$model->setState('filter.featured', $params->get('show_front', 'show'));
		$model->setState('list.ordering', $ordering);
		if (trim($ordering) == 'rand()') {
			$model->setState('list.direction', '');
		} else {
			$model->setState('list.direction', $ordering_direction);
		}
		//	Retrieve Content
		$articles = $model->getItems();
		$styleSheets = array_keys($document->_styleSheets);
		$scripts = array_keys($document->_scripts);
		$flowplayerFound = false;
		$videoPlayerJsFound = false;
		$videoPlayerCssFound = false;
		$videoPlayerSkinFound = false;
		$scrollbarJsFound = false;
		$scrollbarCssFound = false;
		for ($i = 0; $i < count($scripts); $i++) {
			if (stripos($scripts[$i], 'flowplayer.min.js') !== false) {
				$flowplayerFound = true;
			}
			if (stripos($scripts[$i], 'mod_videoplayer.js') !== false) {
				$videoPlayerJsFound = true;
			}
			if (stripos($scripts[$i], 'jquery.scroll.min.js') !== false) {
				$scrollbarJsFound = true;
			}
		}
		for ($i = 0; $i < count($styleSheets); $i++) {
			if (stripos($styleSheets[$i], 'mod_videoplayer.css') !== false) {
				$videoPlayerCssFound = true;
			}
			if (stripos($styleSheets[$i], $params->get('skin') . '.css') !== false) {
				$videoPlayerSkinFound = true;
			}
			if (stripos($styleSheets[$i], 'scrollbar.css') !== false) {
				$scrollbarCssFound = true;
			}
		}
		if (!$flowplayerFound) {
			$document->addScript(JURI::base() . 'modules/mod_videoplayer/js/flowplayer.min.js');
		}
		if (!$videoPlayerJsFound) {
			$document->addScript(JURI::base() . 'modules/mod_videoplayer/js/mod_videoplayer.js');
		}
		if (!$scrollbarJsFound) {
			$document->addScript(JURI::base() . 'modules/mod_videoplayer/js/jquery.scroll.min.js');
		}
		if (!$videoPlayerCssFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_videoplayer/css/mod_videoplayer.css');
		}
		if (!$videoPlayerSkinFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_videoplayer/css/skins/' . $params->get('skin')  . '.css');
		}
		if (!$scrollbarCssFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_videoplayer/css/scrollbar.css');
		}
		$categories = array();
		foreach ($articles as $article) {
			if (!preg_match(self::$_videoCode, $article->introtext . $article->fulltext, $match)) continue;
			$source = $match[1];
			$video = new stdClass();
			$video->id = 'video_' . $article->id;
			$video->title = $article->title;
			$slug = $article->id . ':' . $article->alias;
			if ($access || in_array($article->access, $authorised)) {
				$video->link = JRoute::_(ContentHelperRoute::getArticleRoute($slug, $article->catid));
			} else {
				$video->link = JRoute::_('index.php?option=com_user&view=login');
			}
			$video->description = preg_replace('/<img[^>]*>/', '', self::_removeCode($article->introtext));
			$date =& JFactory::getDate($article->publish_up);
			$video->date = $date->toFormat('%Y-%m-%d');
			$video->time = $date->toFormat('%H:%M:%S');
			if (strpos($source, '.')) {
				$extension = strtolower(substr(strrchr($source, '.'), 1));
				$video->source = $source;
				$video->mp4 = substr($source, 0, strpos($source, '.')) . '.mp4';
				$video->flv = substr($source, 0, strpos($source, '.')) . '.flv';
				$video->image = self::_getVideoImage($source, (int)$params->get('image_width'), (int)$params->get('image_height'));
				$video->preview = self::_getVideoImage($source, (int)$params->get('player_width'), (int)$params->get('player_height'));
			} else {
				// TODO: Implement youtube video.
			}
			if (empty($categories[$article->catid])) {
				$category = new stdClass();
				$category->title = $article->category_title;
				$category->id = (int)$article->catid;
				$category->link = JRoute::_(ContentHelperRoute::getCategoryRoute($article->catid));
				$categories[$article->catid]['category'] = $category;
			}
			$categories[$article->catid]['videos'][] = $video;
			//$videos[] = $video;
		}
		return $categories;
		*/
		return array();
	}
	private static function _removeCode($text) {
		return preg_replace(self::$_videoCode, '', $text);
	}
	private static function _getVideoImage($source, $width, $height) {
		$image = substr($source, 0, strpos($source, '.')) . '_' . $width . 'x' . $height . '.jpg';
		if (!file_exists($image)) {
			$width -= $width % 2;
			$height -= $height % 2;
			$command = 'ffmpeg -i ' . JPATH_SITE . DS . $source . ' -vframes 1 -s ' . $width . 'x' . $height . ' ' . JPATH_SITE . DS . $image . ' 2>&1';
			shell_exec($command);
		}
		return $image;
	}
}