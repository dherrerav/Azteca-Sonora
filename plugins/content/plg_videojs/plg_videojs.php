<?php
defined('_JEXEC') or die;
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
require_once JPATH_SITE . '/plugins/system/jat3/jat3/core/libs/Browser.php';
jimport('joomla.event.plugin');

Zend_Loader::loadClass('Zend_Gdata_YouTube');

class plgContentPlg_VideoJS extends JPLugin {
	public $browser = null;
	public $plugin = null;
	public $params = null;
	public $youtubeCode = '/{youtube}(.*?){\/youtube}/';
	public $videoCode = '/{video}(.*?){\/video}/';
	public $formats = array(
		'mp4' => 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"',
		'webm' => 'video/webm; codecs="vp8, vorbis"',
		'ogv' => 'video/ogg; codecs="theora, vorbis"',
		'flv' => 'video/x-flv',
		'youtube' => 'video/youtube',
	);
	public $codecs = array(
	);
	public $view = null;
	public $layout = null;
	public $youtube = null;
	public $blogLeadingWidth = 636;
	public $blogLeadingHeight = 333;
	public $blogIntroWidth = 300;
	public $blogIntroHeight = 157;
	public $articleWidth = 636;
	public $articleHeight = 333;
	public $videoMatches = array();
	public $youtubeMatches = array();
	public $skin = '';
	public function plgContentPlg_VideoJS(&$subject) {
		parent::__construct($subject);
		$this->browser = new Browser();
		$this->plugin = JPluginHelper::getPlugin('content', 'plg_videojs');
		$this->params = new JParameter($this->plugin->params);
		$this->youtube = new Zend_Gdata_YouTube();
		$this->view = JRequest::getVar('view');
		$this->layout = JRequest::getVar('layout');
		$this->blogLeadingWidth = $this->params->get('blog_leading_width', 636);
		$this->blogLeadingHeight = $this->params->get('blog_leading_height', 333);
		$this->blogIntroWidth = $this->params->get('blog_intro_width', 300);
		$this->blogIntroHeight = $this->params->get('blog_intro_height', 157);
		$this->articleWidth = $this->params->get('article_width', 636);
		$this->articleHeight = $this->params->get('article_height', 333);
		$this->skin = $this->params->get('skin', 'default');
	}
	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart) {
		$catids = $this->params->get('catids');
		if (is_array($catids) && count($catids) == 1) {
			if (empty($catids[0])) {
				$catids = '';
			}
		}
		$process = false;
		if (!is_array($catids) && $article->catid == $catids) {
			$process = true;
		} else if (is_array($catids) && in_array($article->catid, $catids)) {
			$process = true;
		} else if (is_array($catids) && empty($catids)) {
			$process = true;
		} else if (empty($catids)) {
			$process = true;
		}
		if (!$process) return;
		if (($this->view === 'article' || $this->view === 'category') || $this->layout !== 'blog') {
			$document =& JFactory::getDocument();
			$scripts = array_keys($document->_scripts);
			$scriptFound = false;
			for ($i = 0; $i < count($scripts); $i++) {
				if (stripos($scripts[$i], 'flowplayer.min.js') !== false) {
					$scriptFound = true;
				}
			}
			if (!$scriptFound) {
				$document->addScript(JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/js/flowplayer/flowplayer.min.js');
			}
			$styleSheets = array_keys($document->_styleSheets);
			$styleSheetFound = false;
			for ($i = 0; $i < count($styleSheets); $i++) {
				if (stripos($styleSheets[$i], 'flowplayer-' . $this->skin . '.css') !== false) {
					$styleSheetFound = true;
				}
			}
			if (!$styleSheetFound) {
				$document->addStyleSheet(JURI::base() . 'plugins/' . $this->plugin->type . '/' . $this->plugin->name . '/css/skins/flowplayer-' . $this->skin . '.css');
			}
			if (preg_match($this->videoCode, $article->introtext, $this->videoMatches)) {
				$video = $this->videoMatches[1];
			}
			if (preg_match($this->youtubeCode, $article->introtext, $this->youtubeMatches)) {
				$video = $this->youtubeMatches[1];
			}
			$article->slug = $article->id . ':' . $article->alias;
			$article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
			if ($this->view === 'article') {
				$this->_processArticleVideos($video, $article);
			} else if ($this->view == 'category' || $this->layout == 'blog') {
				$this->_processCategoryVideo($video, $article);
			}
		}
		$this->_removeCode($article);
	}
	protected function _processCategoryVideo($source, &$article) {
		$source = (string)$source;
		$video = new stdClass();
		$video->id = 'video_' . $article->id;
		static $item = 0;
		$tempParams = $this->_loadContentParams();
		$leading = false;
		if ($item < $tempParams->get('num_leading_articles', 0)) {
			$video->width = $this->blogLeadingWidth;
			$video->height = $this->blogLeadingHeight;
			$leading = true;
		} else if ($item < $tempParams->get('num_leading_articles', 0) + $tempParams->get('num_intro_articles', 0)) {
			$video->width = $this->blogIntroWidth;
			$video->height = $this->blogIntroHeight;
			$leading = false;
		}
		if (strpos($source, '.')) {
			$extension = strtolower(substr(strrchr($source, '.'), 1));
			$video->source = $source;
			$video->mp4 = substr($source, 0, strpos($source, '.')) . '.mp4';
			$video->flv = substr($source, 0, strpos($source, '.')) . '.flv';
			$video->image = $this->_getVideoImages($source, $video->width, $video->height);
		} else {
			$extension = 'youtube';
			$entry = $this->youtube->getVideoEntry($source);
			$images = $entry->getVideoThumbnails();
			$video->source = $entry->getVideoWatchPageUrl();
			$video->image = $leading ? $images[0]['url'] : $images[1]['url'];
		}
		$video->format = $this->formats[$extension];
		$layout = $this->_getLayoutPath($this->plugin, ($leading ? 'leading' : 'intro'));
		if ($layout) {
			ob_start();
			require $layout;
			$contents = ob_get_clean();
			$article->introtext = $contents . $article->introtext;
		}
		$item++;
	}
	protected function _loadContentParams() {
		static $params = null;
		if (!$params) {
			$application =& JFactory::getApplication();
			$params = clone $application->getParams('com_content');
			$params->def('num_leading_articles', 1);
			$params->def('num_intro_articles', 4);
		}
		return $params;
	}
	protected function _processArticleVideos($source, &$article) {
		$video = new stdClass();
		$video->id = 'video-' . $article->id;
		$video->width = $this->params->get('article_width');
		$video->height = $this->params->get('article_height');
		if (strpos($source, '.')) {
			$extension = strtolower(substr(strrchr($source, '.'), 1));
			$video->source = $source;
			$video->mp4 = substr($source, 0, strpos($source, '.')) . '.mp4';
			$video->flv = substr($source, 0, strpos($source, '.')) . '.flv';
			$video->image = $this->_getVideoImages($source, $video->width, $video->height);
		} else {
			$extension = 'youtube';
			$entry = $this->youtube->getVideoEntry($source);
			$images = $entry->getVideoThumbnails();
			$video->source = $entry->getVideoWatchPageUrl();
			$video->image = $leading ? $images[0]['url'] : $images[1]['url'];
		}
		$video->format = $this->formats[$extension];
		$layout = $this->_getLayoutPath($this->plugin, 'article');
		if ($layout) {
			ob_start();
			require $layout;
			$contents = ob_get_clean();
			$article->introtext = $contents . $article->introtext;
		}
	}
	protected function _getVideoImages($source, $width, $height) {
		$image = strtolower(substr($source, 0, strpos($source, '.'))) . '_' . $width . 'x' . $height . '.jpg';
		if (!file_exists($image)) {
			$command = 'ffmpeg -i ' . JPATH_SITE . DS . $source . ' -vframes 1  -s ' . $width . 'x' . $height . ' ' . JPATH_SITE . DS . $image . ' 2>&1';
			shell_exec($command);
		}
		return $image;
	}
	protected function _removeCode(&$article) {
		if ($this->videoMatches[0]) $article->introtext = str_replace($this->videoMatches[0], '', $article->introtext);
		if ($this->youtubeMatches[0]) $article->introtext = str_replace($this->youtubeMatches[0], '', $article->introtext);
	}
	protected function _getLayoutPath($plugin, $layout = 'default') {
		$application =& JFactory::getApplication();
		$templatePath = JPATH_SITE . DS . 'template' . DS . $application->getTemplate() . DS . 'html' . DS . $plugin->name . DS . $layout . '.php';
		$pluginPath = JPATH_SITE . DS . 'plugins' . DS . $plugin->type . DS . $plugin->name . DS . 'tmpl' . DS . $layout . '.php';
		if (file_exists($templatePath)) {
			return $templatePath;
		} else if (file_exists($pluginPath)) {
			return $pluginPath;
		}
		return '';
	}
	public function isIpad() {
		return $this->browser->getPlatform() === Browser::PLATFORM_IPAD;
	}
}