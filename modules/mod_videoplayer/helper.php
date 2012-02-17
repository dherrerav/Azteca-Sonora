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
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$applicationParams = $application->getParams();
		$model->setState('params', $applicationParams);
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int)$params->get('count', 20));
		$model->setState('filter.published', 1);
		$model->setState('list.select', 'a.id, a.title, a.alias, a.catid, a.introtext, a.fulltext, a.created, a.created_by, a.created_by_alias, a.publish_up, a.attribs');
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
		$model->setState('filter.category_id', $params->get('catid', array()));
		$model->setState('filter.language', $application->getLanguageFilter());
		$ordering = $params->get('ordering', 'a.publish_up');
		$model->setState('list.ordering', $ordering);
		if (trim($ordering) === 'rand()') {
			$model->setState('list.direction', '');
		} else {
			$model->setState('list.direction', $params->get('ordering_direction'));
		}
		$articles = $model->getItems();
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
			var_dump($command);
			shell_exec($command);
		}
		return $image;
	}
}