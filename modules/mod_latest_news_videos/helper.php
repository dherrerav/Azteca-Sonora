<?php
defined('_JEXEC') or die;
require_once JPATH_SITE . '/components/com_content/helpers/route.php';
jimport('joomla.application.component.model');
JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');
abstract class modLatestNewsVideosHelper {
	public static function getArticles(&$params) {
		$application =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$applicationParams = $application->getParams();
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$model->setState('params', $applicationParams);
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int)$params->get('count', 5));
		$model->setState('filter.published', 1);
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
		$model->setState('filter.category_id', $params->get('catids', array()));
		$model->setState('filter.language', $application->getLanguageFilter());
		$model->setState('list.ordering', 'a.publish_up');
		$model->setState('list.direction', 'DESC');
		$styleSheets = array_keys($document->_styleSheets);
		$styleSheetFound = false;
		for ($i = 0; $i < count($styleSheets); $i++) {
			if (stripos($styleSheets[$i], 'mod_latest_news_videos.css') !== false) {
				$styleSheetFound = true;
			}
		}
		if (!$styleSheetFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_latest_news_videos/css/mod_latest_news_videos.css');
		}
		$articles = $model->getItems();
		$i = 0;
		foreach ($articles as &$article) {
			$article->slug = $article->id . ':' . $article->alias;
			if ($access || in_array($article->access, $authorised)) {
				$article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
			} else {
				$article->link = JRoute::_('index.php?option=com_user&view=login');
			}
			if ($i == 0) {
				$article->width = 314;
				$article->height = 176;
			} else {
				$article->width = 233;
				$article->height = 131;
			}
			$article->image = '';
			if (preg_match('/{video}(.*?){\/video}/', $article->introtext, $match)) {
				$match = $match[1];
				$source = $match;
				$article->image = self::_getImage($source, $article->width, $article->height);
				$i++;
			}
			self::_removeCode($article);
		}
		return $articles;
	}
	private static function _removeCode(&$article) {
		$article->introtext = preg_replace('/{video}(.*?){\/video}/', '', $article->introtext);
	}
	private static function _getImage($source, $width, $height) {
		$image = 'images' . DS . 'previews' . DS . substr($source, 0, strpos($source, '.')) . '_' . $width . 'x' . $height . '.jpg';
		$path = JPATH_SITE . DS . dirname($image);
		if (file_exists($source) && !file_exists($image)) {
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$width -= $width % 2;
			$height -= $height % 2;
			$command = 'ffmpeg -i ' . JPATH_SITE . DS . $source . ' -vframes 1  -s ' . $width . 'x' . $height . ' ' . JPATH_SITE . DS . $image . ' 2>&1';
			shell_exec($command);
		}
		return $image;
	}
}