<?php
// no direct access
defined('_JEXEC') or die;

class modFlowplayerHelper
{

	protected static $_video_name;

	protected static $_width = 425;

	protected static $_height = 300;

	protected static $_stylesheets_path;

	protected static $_javascripts_path;

	protected static $_flash_path;

	public function getVideo($params)
	{
		$this->_video_name = $params->get('video_name');
		$this->_width = intval($params->get('width', 425));
		$this->_height = intval($params->get('height', 300));
		$this->_stylesheets_path = JURI::base() . '/modules/mod_flowplayer/stylesheets/';
		$this->_javascripts_path = JURI::base() . '/modules/mod_flowplayer/javascripts/';
		$this->_flash_path = JURI::base() . '/modules/mod_flowplayer/flash/';

		$document = JFactory::getDocument();

		$document->addScript($this->_javascripts_path . 'jquery.min.js');
		$document->addScript($this->_javascripts_path . 'jquery.tools.min.js');
		$document->addScript($this->_javascripts_path . 'flowplayer-3.2.6.min.js');
		$document->addScript($this->_javascripts_path . 'flowplayer.playlist-3.0.8.min.js');
		$document->addScript($this->_javascripts_path . 'flowplayer.ipad-3.2.2.min.js');

		$ad_id = rand(1, 2);
		$output .= '<div class="video-container" style="margin: 0 auto; width: ' . $this->_width . 'px; height: ' . $this->_height . 'px;">' . PHP_EOL;
		$output .= '<a ' . PHP_EOL;
		$output .= 'href="' . JURI::base() . '/images/videos/' . $this->_video_name . '.flv" ' . PHP_EOL;
		$output .= 'style="display: block; width:' . $this->_width . 'px; height: ' . $this->_height . 'px;"' . PHP_EOL;
		$output .= 'class="player">' . PHP_EOL;
		$output .= '<img src="' . JURI::base() . '/images/videos/thumbs/' . $this->_video_name . '.jpg" />' . PHP_EOL;
		$output .= '</a>' . PHP_EOL;
		$output .= '</div>' . PHP_EOL;
		$output .= '<script type="text/javascript">' . PHP_EOL;
		$output .= '
		flowplayer("a.player", "' . JURI::base() . '/modules/mod_flowplayer/flash/flowplayer-3.2.7.swf", {
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
		});' . PHP_EOL;
		$output .= '</script>' . PHP_EOL;

		return $output;
	}
}

