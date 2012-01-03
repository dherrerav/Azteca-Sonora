<?php

defined('_JEXEC');

jimport('joomla.plugin.plugin');

class plgContentFlowplayer
	extends JPlugin
{

	/**
	 * Video name
	 * @var string
	 */
	protected $_video_name;

	/**
	 * Video width
	 * @var integer
	 */
	protected $_width = 425;

	/**
	 * Video height
	 * @var integer
	 */
	protected $_height = 300;

	/**
	 * Example prepare content method
	 *
	 * Method is called by the view
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The content object.  Note $article->text is also available
	 * @param	object	The content params
	 * @param	int		The 'page' number
	 * @since	1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		// Simple performance check to determine whether plugin should process further
		if (strpos($article->text, 'flowplayer') === false) :
			return true;
		endif;
		// Expression to search for
		$regex				= '/{flowplayer\s+(.*?)}/i';
		$matches			= array();
		$this->_width = intval($params->get('width', $this->_width));
		$this->_height = intval($params->get('height', $this->_height));

		// Find all instances of plugin an put them in $matches
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
		//var_dump($matches);
		foreach ($matches as $match) :
			$this->_video_name = $match[1];
			// $match[0] is full pattern match, $match[1] is the position
			$output = $this->_load();
			// We should replace only first occurrance in order to allow positions with the same nam to regenerate their content
			$article->text = preg_replace("|$match[0]|", $output, $article->text, 1);
		endforeach;
	}

	/**
	 * Load the video
	 *
	 * @return string HTML output
	 */
	protected function _load()
	{
    $videoFile = JPATH_BASE . '/images/videos/' . $this->_video_name . '.flv';
    $thumbFile = JPATH_BASE . '/images/videos/thumbs/' . $this->_video_name . '.flv';
		$name = 'flowplayer-700.flv';
		$ad_id = rand(1, 2);
		$output .= '<link rel="stylesheet" type="text/css" href="' . JURI::base() . '/plugins/content/flowplayer/stylesheets/styles.css" />' . PHP_EOL;
		$output .= '<script type="text/javascript" src="' . JURI::base() . '/plugins/content/flowplayer/javascripts/jquery.min.js"></script>' . PHP_EOL;
		$output .= '<script type="text/javascript" src="' . JURI::base() . '/plugins/content/flowplayer/javascripts/jquery.tools.min.js"></script>' . PHP_EOL;
		$output .= '<script type="text/javascript" src="' . JURI::base() . '/plugins/content/flowplayer/javascripts/flowplayer-3.2.6.min.js"></script>' . PHP_EOL;
		$output .= '<script type="text/javascript" src="' . JURI::base() . '/plugins/content/flowplayer/javascripts/flowplayer.playlist-3.0.8.min.js"></script>' . PHP_EOL;
		$output .= '<script type="text/javascript" src="' . JURI::base() . '/plugins/content/flowplayer/javascripts/flowplayer.ipad-3.2.2.min.js"></script>' . PHP_EOL;
		$output .= '<div id="video-container" style="margin: 0 auto; width: ' . $this->_width . 'px; height: ' . $this->_height . 'px;">' . PHP_EOL;
		$output .= '<a ' . PHP_EOL;
		$output .= 'href="' . JURI::base() . '/images/videos/' . $this->_video_name . '.flv" ' . PHP_EOL;
		$output .= 'style="display: block; width:' . $this->_width . 'px; height: ' . $this->_height . 'px;"' . PHP_EOL;
		$output .= 'id="player">' . PHP_EOL;
		$output .= '<img src="' . JURI::base() . '/images/videos/thumbs/' . $this->_video_name . '.jpg" />' . PHP_EOL;
		$output .= '</a>' . PHP_EOL;
		$output .= '</div>' . PHP_EOL;
		$output .= '<script type="text/javascript">' . PHP_EOL;
		$output .= '
		flowplayer("player", "' . JURI::base() . '/plugins/content/flowplayer/flash/flowplayer-3.2.7.swf", {
			clip: {
				title: "Video ' . $this->_video_name . '",
				autoPlay: true,
				autoBuffering: true,
				playlist: [
					{
						title: "Advertisement",
						url: "' . JURI::base() . '/images/videos/ads/preroll' . $ad_id . '.flv",
						position: 0
					}
				]
			}
		}).ipad();' . PHP_EOL;
		$output .= '</script>' . PHP_EOL;
		return $output;
	}
  
  protected function _makeThumbnail($input, $output, $fromSecond = '01') {
    echo $output;
    $inputFilePath = JPATH_BASE . '/images/videos/' . $input . '.flv';
    $ouputFilePath = JPATH_BASE . '/images/videos/thumbs/' . $output . '.jpg';
    $outputUrl = JURI::base() . '/images/videos/thumbs/' . $output . '.jpg';
    $ffmpeg = '/usr/bin/ffmpeg';
    if (file_exists($ffmep))
      echo 'FFMPEG exists';
    else
      echo 'FFMPEG does not exist';
    if (!file_exists($inputFilePath)) :
      throw new Exception('Video file does not exist!');
    endif;
    if (file_exists($outputFilePath)) :
      // Thumbnail file already exists, so return true to stop the script.
      return true;
    endif;
    
    $command = "$ffmpeg -i $input -an -ss 00:00:$fromSecond -r 1 -vframes 1 -f mjpeg -y $output";
    
    try {
      @exec($command, $ret);
    }
    catch (Exception $ex) {
      throw $ex;
    }
    
    // Uncomment if you have permission issues    
    $command = "chmod 777 $output";
    
    try {
      @exec($command, $ret);
    }
    catch (Exception $ex) {
      throw $ex;
    }
    
    if (!file_exists($outputFilePath)) :
      throw new Exception('Couldn\'t create thumbnail file');
    endif;
    
    if (file_size($outputFilePath) === 0) :
      throw new Exception('Output file size is zero');
    endif;
    
    return $outputUrl;
  }
}