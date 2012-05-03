<?php
defined('_JEXEC') or die;
jimport('joomla.event.plugin');
jimport('joomla.html.parameter');

require_once JPATH_SITE . '/plugins/system/jat3/jat3/core/libs/Browser.php';
require_once JPATH_SITE . '/libraries/simple_html_dom.php';
require_once JPATH_SITE . '/components/com_content/helpers/route.php';

class plgContentPlg_DynamicThumbnails extends JPlugin {
	protected $_plugin = null;
	protected $_pluginParams = null;
	protected $_pluginCode = '/{dynamicthumbnails(.*?)}/';
	protected $_videoCode = '/{video}(.*?){\/video}/';
	protected $_youtubeCode = '/{youtube}(.*?){\/youtube}/';
	protected $_disableCode = '/{dynamicthumbnails(\s*)off}/';
	protected $_videoFormats = array(
		'mp4' => 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"',
		'webm' => 'video/webm; codecs="vp8, vorbis"',
		'ogv' => 'video/ogg; codecs="theora, vorbis"',
		'm4v' => 'video/x-m4v',
		'flv' => 'video/x-flv',
		'youtube' => 'video/youtube',
	);
	protected $_flowplayerPlugins = array(
		'pseudostreaming' => 'flowplayer.pseudostreaming.swf',
		'analytics' => 'flowplayer.analytics.swf',
		'youtube' => 'flowplayer.youtube.swf',
	);
	public $browser = null;

	public $_template = null;

	public function plgContentPlg_DynamicThumbnails(&$subject) {
		parent::__construct($subject);
		$this->_plugin = JPluginHelper::getPlugin('content', 'plg_dynamicthumbnails');
		$this->_pluginParams = new JParameter($this->_plugin->params);
		$this->browser = new Browser();
		$this->_template = JFactory::getApplication()->getTemplate();
	}
	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart = 0) {
		if ($context != 'com_content.article') return;
		$view = JRequest::getVar('view');
		$layout = JRequest::getVar('layout');
		$article->slug = $article->id . ':' . $article->alias;
		$article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
		if (isset($article->introtext) && !empty($article->introtext)) {
			if (preg_match($this->_disableCode, $article->introtext)) {
				$article->introtext = $this->removeCode($article->introtext);
				return;
			}
			$document =& JFactory::getDocument();
			$styles = array_keys($document->_styleSheets);
			$scripts = array_keys($document->_scripts);
			$styleFound = false;
			$scriptFound = false;
			for ($i = 0; $i < count($scripts); $i++) {
				if (stripos($scripts[$i], 'flowplayer.min.js') !== false) {
					$scriptFound = true;
				}
			}
			for ($i = 0; $i < count($styles); $i++) {
				if (stripos($styles[$i], 'plg_dynamicthumbnails.css') !== false) {
					$styleFound = true;
				}
			}
			if (!$scriptFound) {
				$document->addScript(JURI::base() . 'plugins/content/plg_dynamicthumbnails/js/flowplayer.min.js');
				if ($this->browser->getPlatform() === Browser::PLATFORM_IPAD) {
					$document->addScript(JURI::base() . 'plugins/content/plg_dynamicthumbnails/js/flowplayer.ipad.min.js');
				}
			}
			if (!$styleFound) {
				$document->addStyleSheet(JURI::base() . 'plugins/content/plg_dynamicthumbnails/css/plg_dynamicthumbnails.css');
			}
			if ($view == 'article') {
				$this->processArticle($article, $params, $limitstart);
			} else if (($view == 'featured' || $layout == 'blog')) {
				$this->processBlog($article, $params, $limitstart);
			}
			$article->introtext = $this->removeCode($article->introtext);
		}
	}
	public function processArticle(&$article, &$params, $limitstart) {
		$videoOutput = null;
		$imageOutput = null;
		$imageWidth = $this->_pluginParams->get('article_image_width');
		$imageHeight = $this->_pluginParams->get('article_image_height');
		$imageOutput = $this->getResizedImages($article, $imageWidth, $imageHeight, 'article_image', ($videoOutput !== null));
		$videoWidth = $this->_pluginParams->get('article_video_width');
		$videoHeight = $this->_pluginParams->get('article_video_height');
		$videoOutput = $this->getVideos($article, $videoWidth, $videoHeight, 'article_video');
		if ($videoOutput && !$imageOutput) {
			$article->introtext = $videoOutput . $article->introtext;
		} else if ($videoOutput && $imageOutput) {
			$article->introtext = $imageOutput . $article->introtext;
			$article->fulltext = $article->fulltext . $videoOutput;
		} else if (!$videoOutput && $imageOutput) {
			$article->introtext = $imageOutput . $article->introtext;
		}
	}
	public function processBlog(&$article, &$params, $limitstart) {
		if (!$article->id) {
			return;
		}
		$catids = $this->_pluginParams->get('catids');
		if (is_array($catids) && count($catids) == 1) {
			if (empty($catids[0])) {
				$catids = '';
			}
		}
		$process = false;
		if ((!is_array($catids) && $article->catid == $catids)) {
			$process = true;
		} else if ((is_array($catids) && in_array($article->catid, $catids))) {
			$process = true;
		} else if (is_array($catids) && empty($catids)) {
			$process = true;
		} else if (empty($catids)) {
			$process = true;
		}
		if (!$process) {
			return;
		}
		static $item = 0;
		$tmpParams = $this->loadContentParams();
		if ($item < $tmpParams->get('num_leading_articles', 0)) {
			$width = $this->_pluginParams->get('blog_leading_width', 636);
			$height = $this->_pluginParams->get('blog_leading_height', 333);
			$videoOutput = $this->getVideos($article, $width, $height, 'blog_leading_video');
			$imageOutput = $this->getResizedImages($article, $width, $height, 'blog_leading_image');
		} else if ($item < $tmpParams->get('num_leading_articles', 0) + $tmpParams->get('num_intro_articles', 0)) {
			$width = $this->_pluginParams->get('blog_intro_width', 196);
			$height = $this->_pluginParams->get('blog_intro_height', 122);
			$videoOutput = $this->getVideos($article, $width, $height, 'blog_intro_video');
			$imageOutput = $this->getResizedImages($article, $width, $height, 'blog_intro_image');
		} else {
			return;
		}
		if ($videoOutput) {
			$article->introtext = $videoOutput . $article->introtext;
		} else if ($imageOutput) {
			$article->introtext = $imageOutput . $article->introtext;
		} else {
			/**
			 * @todo: Handle default image. Perhaps setting the default image in getResizedImages()
			 * 		  method would be better
			 */
		}
		$item++;
	}
	public function getResizedImages($article, $width, $height, $layout, $hasVideo = false) {
		$html = new simple_html_dom();
		$html->load($article->introtext);
		$images = $html->find('img');
		if (count($images) > 0) {
			/**
			 * @todo Resize images
			 */
			$layout = $this->getLayoutPath($this->_plugin, $layout);
			$output = '';
			if ($layout) {
				ob_start();
				require $layout;
				$output = ob_get_contents();
				ob_end_clean();
			}
			$article->introtext = preg_replace('/\<img[^\>]*>/', '', $article->introtext);
			return $output;
		}
		return '';
	}
	public function getVideos($article, $width, $height, $layout) {
		$videoOutput = '';
		if (preg_match($this->_videoCode, $article->introtext, $match)) {
			$source = $match[1];
			$extension = strtolower(substr(strrchr($source, '.'), 1));
			$format = '';
			if (isset($this->_videoFormats[$extension])) {
				$format = $this->_videoFormats[$extension];
				//$width = $this->_pluginParams->get('article_video_width');
				//$height = $this->_pluginParams->get('article_video_height');
				//exit;
				$video = new stdClass();
				$video->width = $width;
				$video->height = $height;
				$video->source = $source;
				$video->extension = $extension;
				$video->format = $format;
				$video->duration = $this->getVideoDuration(JPATH_SITE . DS . $source);
				$video->preview = $this->getVideoPreview($source, $width, $height);
				$video->id = 'video-' . $extension . '-' . $article->id;
				$videos = array(
						$extension => $video,
				);
				foreach ($this->_videoFormats as $format => $mime) {
					if ($format !== $extension) {
						$filename = str_replace($extension, $format, $source);
						if (file_exists(JPATH_SITE . DS . $filename)) {
							$ext = strtolower(substr(strrchr($filename, '.'), 1));
							$video = new stdClass();
							$video->extension = $ext;
							$video->source = $filename;
							$video->duration = $this->getVideoDuration(JPATH_SITE . DS . $filename);
							$video->width = $width;
							$video->height = $height;
							$video->format = $mime;
							$video->id = 'video-' . $ext . '-' . $article->id;
							$video->preview = $this->getVideoPreview($filename, $width, $height);
							$videos[$format] = $video;
						}
					}
				}
				$layout = $this->getLayoutPath($this->_plugin, $layout);
				if ($layout) {
					ob_start();
					require $layout;
					$videoOutput = ob_get_contents();
					ob_end_clean();
				}
			} else {
				JError::raiseError(null, 'Video format not supported.', 'The format with the extension <b>' . $extension . '</b> is not supported by the player.');
			}
			$article->introtext = preg_replace($this->_videoCode, '', $article->introtext);
		}
		return $videoOutput;
	}
	public function getVideoDuration($filename, $parts = false) {
		if (!file_exists($filename)) return null;
		$command = 'ffmpeg -i "' . $filename . '" 2>&1 |grep "Duration" |cut -d \' \' -f 4 |sed s/,//';
		$duration = shell_exec($command);
		if ($parts) {
			$parts = explode(':', $duration);
			$duration = new stdClass();
			$duration->hours = $parts[0];
			$duration->minutes = $parts[1];
			$duration->seconds = (string)round($parts[2]);
		}
		return $duration;
	}
	public function getVideoPreview($filename, $width, $height) {
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
	public function removeCode(&$text) {
		return preg_replace($this->_pluginCode, '', $text);
	}
	public function getFlowplayerPlugin($plugin) {
		return JURI::base() . 'plugins/content/plg_dynamicthumbnails/swf/' . $this->_flowplayerPlugins[$plugin];
	}
	public function getVideoPlayer() {
		return JURI::base() . 'plugins/content/plg_dynamicthumbnails/swf/flowplayer.swf';
	}
	public function loadContentParams() {
		static $params = null;
		if (!$params) {
			$application =& JFactory::getApplication();
			$params = clone $application->getParams('com_content');
			$params->def('num_leading_articles', 1);
			$params->def('num_intro_articles', 4);
		}
		return $params;
	}
	public function getLayoutPath($plugin, $layout = 'default') {
		$application =& JFactory::getApplication();
		$templatePath = JPATH_BASE . DS . 'templates' . DS . $application->getTemplate() . DS . 'html' . DS . $plugin->name . DS . $layout . '.php';
		$pluginPath = JPATH_BASE . DS . 'plugins' . DS . $plugin->type . DS . $plugin->name . DS . 'tmpl' . DS . $layout . '.php';
		if (file_exists($templatePath)) {
			return $templatePath;
		} else if (file_exists($pluginPath)) {
			return $pluginPath;
		}
		return '';
	}
}