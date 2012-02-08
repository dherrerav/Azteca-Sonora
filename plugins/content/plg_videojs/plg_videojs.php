<?php
defined('_JEXEC') or die;
jimport('joomla.event.plugin');

Zend_Loader::loadClass('Zend_Gdata_YouTube');

class plgContentPlg_VideoJS extends JPLugin {
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
	public $blogWidth = 636;
	public $blogHeight = 333;
	public $articleWidth = 636;
	public $articleHeight = 333;
	public $videoMatches = array();
	public $youtubeMatches = array();
	public $skin = '';
	public function plgContentPlg_VideoJS(&$subject) {
		parent::__construct($subject);
		$this->plugin = JPluginHelper::getPlugin('content', 'plg_videojs');
		$this->params = new JParameter($this->plugin->params);
		$this->youtube = new Zend_Gdata_YouTube();
		$this->view = JRequest::getVar('view');
		$this->layout = JRequest::getVar('layout');
		$this->blogWidth = $this->params->get('blog_width', 636);
		$this->blogHeight = $this->params->get('blog_height', 333);
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
		if (strpos($source, '.')) {
			$extension = strtolower(substr(strrchr($source, '.'), 1));
			$video->source = $source;
			$video->mp4 = substr($source, 0, strpos($source, '.')) . '.mp4';
			$video->flv = substr($source, 0, strpos($source, '.')) . '.flv';
			$video->images = $this->_getVideoImages($source, array('width' => 636, 'height' => 333), array('width' => 120, 'height' => 90));
		} else {
			$extension = 'youtube';
			$entry = $this->youtube->getVideoEntry($source);
			$images = $entry->getVideoThumbnails();
			$video->source = $entry->getVideoWatchPageUrl();
			$video->images = array(
				'preview' => $images[0]['url'],
				'thubnanil' => $images[1]['url'],
			);
		}
		$video->format = $this->formats[$extension];
		$video->width = $this->blogWidth;
		$video->height = $this->blogHeight;
		$layout = $this->_getLayoutPath($this->plugin, 'default');
		if ($layout) {
			ob_start();
			require $layout;
			$contents = ob_get_clean();
			$article->introtext = $contents . $article->introtext;
		}
	}
	protected function _processArticleVideos($videos, &$article) {
	}
	protected function _getVideoImages($video, $previewDimensions, $thumbnailDimensions) {
		$previewWidth = $previewDimensions['width'];
		$previewHeight = $previewDimensions['height'];
		$thumbnailWidth = $thumbnailDimensions['width'];
		$thumbnailHeight = $thumbnailDimensions['height'];
		$preview = strtolower(substr($video, 0, strpos($video, '.'))) . '_' . $previewWidth . '_' . $previewHeight . '_preview.jpg';
		$thumbnail = strtolower(substr($video, 0, strpos($video, '.'))) . '_' . $thumbnailWidth . '_' . $thumbnailHeight . '_thumbnail.jpg';
		if (!file_exists($preview)) {
			$command = 'ffmpeg -i ' . JPATH_SITE . DS . $video . ' -vframes 1  -s ' . $previewWidth . 'x' . $previewHeight . ' ' . JPATH_SITE . DS . $preview . ' 2>&1';
			shell_exec($command);
		}
		if (!file_exists($thumbnail)) {
			$command = 'ffmpeg -i ' . JPATH_SITE . DS . $video . ' -vframes 1 -s ' . $thumbnailWidth . 'x' . $thumbnailHeight . ' ' . JPATH_SITE . DS . $thumbnail . ' 2>&1';
			shell_exec($command);
		}
		return array(
			'preview' => $preview,
			'thumbnail' => $thumbnail,
		);
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
}