<?php
defined('_JEXEC') or die;
require_once JPATH_SITE.'/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');
abstract class modContentCarouselHelper {
	public static function getArticles($params) {
		$application =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$model = JModel::getInstance('Articles', 'ContentModel', array(
			'ignore_request' => true));
		$applicationParams = $application->getParams();
		$model->setState('params', $applicationParams);
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int)$params->get('count', 5));
		$model->setState('filter.published', 1);
		$model->setState('list.select', 'a.fulltext, a.id, a.title, a.alias, a.title_alias, a.introtext, a.state, a.catid, a.created, a.created_by, a.created_by_alias, a.modified, a.modified_by, a.publish_up, a.publish_down, a.attribs, a.metadata, a.metakey, a.metadesc, a.access, a.hits, a.featured, LENGTH(a.fulltext) AS readmore');
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
		$model->setState('filter.category_id', $params->get('catid', array()));
		$model->setState('filter.language', $application->getLanguageFilter());
		$ordering = $params->get('ordering', 'a.publish_up');
		$model->setState('list.ordering', $ordering);
		if (trim($ordering) == 'rand()') {
			$model->setState('list.direction', '');
		} else {
			$model->setState('list.direction', 'DESC');
		}
		$scripts = array_keys($document->_scripts);
		$scriptFound = false;
		for ($i = 0; $i < count($scripts); $i++) {
			if (stripos($scripts[$i], 'content-carousel.js') !== false) {
				$scriptFound = true;
			}
		}
		if (!$scriptFound) {
			$document->addScript(JURI::base() . 'modules/mod_content_carousel/js/content-carousel.js');
		}
		$stylesheets = array_keys($document->_styleSheets);
		$skinFound = false;
		for ($i = 0; $i < count($stylesheets); $i++) {
			if (stripos($stylesheets[$i], 'content-carousel-' . $params->get('skin') . '.css') !== false) {
				$skinFound = true;
			}
		}
		if (!$skinFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_content_carousel/css/skins/content-carousel-' . $params->get('skin') . '.css');
		}
		$articles = $model->getItems();
		foreach ($articles as &$article) {
			$article->readmore = (trim($article->fulltext) != '');
			$article->slug = $article->id . ':' . $article->alias;
			$article->catslug = $article->catid . ':' . $article->category_alias;
			if ($access || in_array($article->access, $authorised)) {
				$article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
			} else {
				$article->link = JRoute::_('index.php?option=com_user&view=login');
			}
			$article->image = self::_getImage($article);
		}
		return $articles;
	}
	protected static function _getImage(&$article) {
		$image = '';
		if (preg_match('/{video}(.*?){\/video}/', $article->introtext . $article->fulltext, $matches)) {
			$image = self::_createImage($matches[1]);
		} else {
			require_once 'simple_html_dom.php';
			$html = new simple_html_dom();
			$html->load($article->introtext . $article->fulltext);
			$images = $html->find('img');
			$article->image = $images[0]->src;
		}
		return $image;
	}
	private static function _createImage($source) {
		$width = 108;
		$height = 68;
		$image = strtolower(substr($source, 0, strpos($source, '.'))) . '_' . $width . 'x' . $height . '.jpg';
		if (!file_exists($image)) {
			$command = 'ffmpeg -i ' . JPATH_SITE . DS . $source . ' -vframes 1 -s ' . $width . 'x' . $height . ' ' . JPATH_SITE . DS . $image . ' 2>&1';
			shell_exec($command);
		}
		return $image;
	}
}