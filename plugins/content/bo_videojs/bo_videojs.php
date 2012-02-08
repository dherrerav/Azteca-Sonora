<?php
/**
* @Copyright Copyright (C) 2010 Alfred Bösch
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgContentBo_VideoJS extends JPlugin {
	
	public function onContentPrepare($context, &$article, &$params, $limitstart) {
		
		$app = JFactory::getApplication();
		
	  	$pluginParams = $this->params;
	
		if (!isset($GLOBALS['plg_bo_videojs'])) {
			$GLOBALS['plg_bo_videojs'] = 1;
		}
	
		$hits = preg_match_all('#{bo_videojs\s*(.*?)}#s', $article->text, $matches);
		
		if (!empty($hits)) {
			$document =& JFactory::getDocument();
			
			// Check if videojs script is loaded
			$scripts = array_keys($document->_scripts);
			$foundVideoJSScripts = false;
			for ($i = 0; $i<count($scripts); $i++) {
				if (stripos($scripts[$i], 'video.js') !== false) {
					$foundVideoJSScripts = true;
				}
			}
			if (!$foundVideoJSScripts) {
				$document->addScript(JURI::base().'plugins/content/bo_videojs/videojs/video.js');
			}
			
			for ($i=$GLOBALS['plg_bo_videojs']; $i<$GLOBALS['plg_bo_videojs']+$hits; $i++) {
				$document->addScriptDeclaration('VideoJS.DOMReady(function(){
					var plg_player_'.$i.' = VideoJS.setup("plg_bo_videojs_'.$i.'", {
						autoplay:				'.$pluginParams->get('autoplay', 'false').',
						preload:				'.$pluginParams->get('preload', 'true').',
						useBuiltInControls:		'.$pluginParams->get('useBuiltInControls', 'false').',
						controlsBelow: 			'.$pluginParams->get('controlsBelow', 'false').',
						controlsAtStart:		'.$pluginParams->get('controlsAtStart', 'false').',
						controlsHiding: 		'.$pluginParams->get('controlsHiding', 'true').',
						defaultVolume: 			'.$pluginParams->get('defaultVolume', '0.85').',
						playerFallbackOrder:	['.$pluginParams->get('playerFallbackOrder', '"html5", "flash", "links"').'],
						flashPlayerVersion: 	'.$pluginParams->get('flashPlayerVersion', '9').'
					});
			    });');

				for ($j=0; $j<$hits; $j++) {
					$videoParams = $matches[1][$j];
					$videoParamsList = $this->contentBoVideoJS_getParams($videoParams, $pluginParams);
					$html = $this->contentBoVideoJS_createHTML($i+$j, $pluginParams, $videoParamsList);
					$pattern = str_replace('[', '\[', $matches[0][$j]);
					$pattern = str_replace(']', '\]', $pattern);
					$pattern = str_replace('/', '\/', $pattern);
			    	$article->text = preg_replace('/'.$pattern.'/', $html, $article->text, 1);
				}

			}
			
			// Count instances
			$GLOBALS['plg_bo_videojs'] += $hits;

			// Check if videojs stylesheets are loaded
			$styleSheets = array_keys($document->_styleSheets);
			
			$foundVideoJSStyles = false;
			for ($i = 0; $i<count($styleSheets); $i++) {
				if (stripos($styleSheets[$i], 'video-js.css') !== false) {
					$foundVideoJSStyles = true;
				}
			}
			if (!$foundVideoJSStyles) {
				$document->addStyleSheet(JURI::base().'plugins/content/bo_videojs/videojs/video-js.css');
			}
			
			if ($pluginParams->get('skin') != 'default') {
				$document->addStyleSheet(JURI::base().'plugins/content/bo_videojs/videojs/skins/'.$pluginParams->get('skin').'.css');
			}
		} else {
			return false;
		}

		return true;
		
	}
	
	protected function contentBoVideoJS_getParams($videoParams, $pluginParams) {

		$videoParamsList['width'] 				= $pluginParams->get('width');
		$videoParamsList['height'] 				= $pluginParams->get('height');
		$videoParamsList['autoplay']			= $pluginParams->get('autoplay');
		$videoParamsList['preload']				= $pluginParams->get('preload');
		$videoParamsList['loop']				= $pluginParams->get('loop');
		$videoParamsList['video_mp4']			= $pluginParams->get('video_mp4');
		$videoParamsList['video_webm']			= $pluginParams->get('video_webm');
		$videoParamsList['video_ogg'] 			= $pluginParams->get('video_ogg');
		$videoParamsList['image'] 				= $pluginParams->get('image');
		$videoParamsList['image_visibility'] 	= $pluginParams->get('image_visibility');
		$videoParamsList['flash'] 				= $pluginParams->get('flash');

		$items = explode(' ', $videoParams);

		foreach ($items as $item) {
			if ($item != '') {
				$item	= explode('=', $item);
				$name 	= $item[0];
				$value	= strtr($item[1], array('['=>'', ']'=>''));
				$videoParamsList[$name] = $value;
			}
		}

		return $videoParamsList;
	}
	
	protected function contentBoVideoJS_createHTML($id, &$pluginParams, &$videoParamsList) {

		$width 				= $videoParamsList['width'];
		$height 			= $videoParamsList['height'];
		$autoplay			= $videoParamsList['autoplay'];
		$preload			= $videoParamsList['preload'];
		$loop				= $videoParamsList['loop'];
		$video_mp4			= $videoParamsList['video_mp4'];
		$video_webm			= $videoParamsList['video_webm'];
		$video_ogg			= $videoParamsList['video_ogg'];
		$flash				= $videoParamsList['flash'];
		$image 				= $videoParamsList['image'];
		$image_visibility	= $videoParamsList['image_visibility'];
		$skin				= '';
		$wmode				= $pluginParams->get('wmode', 'default');
		$uri_flash			= '';
		$uri_image			= '';

		// Add URI for local flash video
		if (stripos($flash, 'http://') === false) {
			$uri_flash = JURI::base();		
		}

		// Add URI for local flash image
		if (stripos($image, 'http://') === false) {
			$uri_image = JURI::base();		
		}

		if ($pluginParams->get('skin', 'default') != 'default') {
			$skin 	= ' '.$pluginParams->get('skin').'-css';
		}

		// Preload works for both HTML and Flash
		if ($preload == "true" || $preload == "1") {
			$preload_html 	= ' preload="auto"';
			$preload_flash	= '"autoBuffering":true';
		} else {
			$preload_html 	= ' preload="none"';
			$preload_flash	= '"autoBuffering":false';
		}

		// Autoplay works for both HTML and Flash
		if ($autoplay == "true" || $autoplay == "1") {
			$autoplay_html 	= ' autoplay="autoplay"';
			$autoplay_flash	= '"autoPlay":true';
		} else {
			$autoplay_html 	= '';
			$autoplay_flash	= '"autoPlay":false';
		}

		// Actually loop works only for HTML
		if ($loop == "true" || $loop == "1") {
			$loop_html		= ' loop="loop"';
		} else {
			$loop_html 		= '';
		}
		
		// Poster image
		if ($image_visibility == "true" || $image_visibility == "1") {
			$poster_html = ' poster="'.$image;
		} else {
			$poster_html = '';
		}

		// HTML output
		$html = '<div class="video-js-box'.$skin.'">
			<video id="plg_bo_videojs_'.$id.'" class="video-js" width="'.$width.'" height="'.$height.'" controls="controls"'.$autoplay_html.$preload_html.$loop_html.$poster_html.'">';

		if ($video_mp4 != "0") {
			$html .= '<source src="'.$video_mp4.'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />';
		}

		if ($video_webm != "0") {
			$html .= '<source src="'.$video_webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';
		}

		if ($video_ogg != "0") {
			$html .= '<source src="'.$video_ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';
		}

		if ($flash != "0") {
			$html .= '<object id="plg_flash_fallback_'.$id.'" class="vjs-flash-fallback" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
	        		<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />';
			if ($wmode != 'default') {
				$html .= '<param name="wmode" value="'.$wmode.'"';			
			}

	 		$html .= '<param name="allowfullscreen" value="true" />
	        		<param name="flashvars" value=\'config={"playlist":["'.$uri_image.$image.'", {"url": "'.$uri_flash.$flash.'",'.$autoplay_flash.','.$preload_flash.'}]}\' />';
	
			if ($image_visibility == "true" || $image_visibility == "1") {
				$html .= '<img src="'.$image.'" width="'.$width.'" height="'.$height.'" alt="Poster Image" title="No video playback capabilities." />';
			}

	      	$html .= '</object>';
		}

		$html .= '</video>
				<p class="vjs-no-video"><strong>Download Video: </strong>';

		if ($video_mp4 != "0") {
			$html .= '<a href="'.$video_mp4.'">MP4</a>, ';
		}

		if ($video_webm != "0") {
			$html .= '<a href="'.$video_webm.'">WebM</a>, ';
		}

		if ($video_ogg != "0") {
			$html .= '<a href="'.$video_ogg.'">Ogg</a><br>';
		}

		$html .= '<a href="http://videojs.com">HTML5 Video Player</a> by VideoJS
				</p>
	  		</div>';

		return $html;

	}
	
}