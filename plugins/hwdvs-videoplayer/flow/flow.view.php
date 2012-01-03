<?php
/**
 *    @version [ Nightly Build ]
 *    @package hwdVideoShare
 *    @copyright (C) 2007 - 2009 Highwood Design
 *    @license Creative Commons Attribution-Non-Commercial-No Derivative Works 3.0 Unported Licence
 *    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
 */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * @package    hwdVideoShare
 * @author     Dave Horsfall <info@highwooddesign.co.uk>
 * @copyright  2008 Highwood Design
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version    1.1.4 Alpha RC3.5
 */
class hwd_vs_videoplayer {
    /**
     * Prepares the code to insert the third party video
     *
     * @param string $option  the $video_id output containing video paramters
     * @param int    $flv_width  the video width
     * @param int    $flv_height  the video height
     * @return       $code   the third party embed code
     */
    function prepareplayer($flv_url, $flv_width=427, $flv_height=340, $ui=0, $mediatype="video", $flv_path=null, $thumb_url=null, $autostart=null, $video_id=null, $rtmp=null)
	{
		$code = hwd_vs_videoplayer::prepareEmbeddedPlayer($flv_url, $flv_width, $flv_height, $ui, $mediatype, $flv_path, $thumb_url, $autostart, $video_id, $rtmp);
		return $code;
	}
    function prepareEmbeddedPlayer($flv_url, $flv_width=427, $flv_height=340, $ui=0, $mediatype="video", $flv_path=null, $thumb_url=null, $autostart=null, $video_id=null, $rtmp=null)
	{
		global $task, $smartyvs, $option, $show_longtail, $longtail_c, $show_video_ad;
		$c = hwd_vs_Config::get_instance();

		$getFlashVars = hwd_vs_videoplayer::getFlashVars($flv_url, $flv_width, $flv_height, $ui, $mediatype, $flv_path, $thumb_url, $autostart, null, $video_id, $rtmp);

		$code = null;
		$code.="<script type=\"text/javascript\" src=\"$getFlashVars->JsLocation\"></script>
				<a
					style=\"display:block;width:".$getFlashVars->playerWidth."px;height:".$getFlashVars->playerHeight."px;\"
					id=\"hwdvideo_$ui\">
				</a>
				<script type=\"text/javascript\" language=\"javascript\">\n";
				if ($c->ieoa_fix == 1)
				{
		$code.= "  window.addEvent('domready', function(){\n";
		        }
		        else
		        {
		$code.= "  function goFlash() {\n";
		        }

		$code.=	"    flowplayer(\"hwdvideo_$ui\", {src: \"$getFlashVars->playerLocation\", wmode: \"transparent\"}, {
$getFlashVars->flashVars
    });\n";

				if ($c->ieoa_fix == 1) {
		$code.= "  });\n";
		        }
		        else
		        {
		$code.= "  } goFlash();\n";
				}
		$code.="</script>";

		return $code;
	}
    function prepareEmbedCode($flv_url, $flv_width=427, $flv_height=340, $ui=0, $mediatype="video", $flv_path=null, $thumb_url=null, $autostart=null, $video_id=null, $rtmp=null)
	{
		global $task, $smartyvs, $option, $show_longtail, $longtail_c, $show_video_ad, $Itemid;
		$c = hwd_vs_Config::get_instance();

	    $playerWidth  = 427;
	    $playerHeight = intval($playerWidth*$c->var_fb);

		$getFlashVars = hwd_vs_videoplayer::getFlashVars($flv_url, $flv_width, $flv_height, $ui, $mediatype, $flv_path, $thumb_url, $autostart, null, $video_id, $rtmp);

		$getFlashVars->flashVars = htmlspecialchars($getFlashVars->flashVars);
		$getFlashVars->flashVars = str_replace("&", "&amp;", $getFlashVars->flashVars);

		$code         = null;

		if ($c->embedreturnlink == 1)
		{
			$code.="<div><center>";
		}
		$code.="<object width=&#34;".$playerWidth."&#34; height=&#34;".$playerHeight."&#34; type=&#34;application/x-shockwave-flash&#34; data=&#34;".$getFlashVars->playerLocation."&#34; id=&#34;hwdvideo_api&#34;>";
		$code.="<param name=&#34;allowFullScreen&#34; value=&#34;true&#34;></param>";
		$code.="<param name=&#34;allowscriptaccess&#34; value=&#34;always&#34;></param>";
		$code.="<param name=&#34;quality&#34; value=&#34;high&#34;></param>";
		$code.="<param name=&#34;cachebusting&#34; value=&#34;false&#34;></param>";
		$code.="<param name=&#34;wmode&#34; value=&#34;transparent&#34;></param>";
		$code.="<param name=&#34;bgcolor&#34; value=&#34;#000000&#34;></param>";
		$code.="<param name=&#34;flashvars&#34; value=&#34;config={".$getFlashVars->flashVars."}&#34;></param>";
		$code.="</object>";

		if ($c->embedreturnlink == 1)
		{
			$jconfig = new jconfig();
			$code.="<br /><a href=&#34;".JURI::root()."index.php?option=com_hwdvideoshare&Itemid=".$Itemid."&task=viewvideo&video_id=".$video_id."&#34; title=&#34;".$jconfig->sitename."&#34;>".$jconfig->sitename."</a></center></div>";
		}
		return $code;
	}
	/**
	* Compiles information to add or edit a plugin
	* @param string The current GET/POST option
	* @param integer The unique id of the record to edit
	*/
	function getMyParams($element)
	{
		$plugin =& JPluginHelper::getPlugin('hwdvs-videoplayer', $element);
		$pluginParams = new JParameter( $plugin->params );
		return $pluginParams;
	}
	/**
	* Compiles information to add or edit a plugin
	* @param string The current GET/POST option
	* @param integer The unique id of the record to edit
	*/
	function getFlashVars($flv_url, $flv_width, $flv_height, $ui, $mediatype, $flv_path, $thumb_url, $autostart, $embed=0, $video_id=null, $rtmp=null)
	{
		global $smartyvs, $option, $Itemid, $show_longtail, $longtail_c, $longtail_mediaid, $show_video_ad, $videoplayer, $j16;
		$c = hwd_vs_Config::get_instance();
		$doc = & JFactory::getDocument();

		$sendFlashVars->flashVars = null;
		$sendFlashVars->JsLocation = null;
		$sendFlashVars->playerWidth = null;
		$sendFlashVars->playerHeight = null;
		$sendFlashVars->playerLocation = null;

		$flashVars = null;
		$params = $this->getMyParams('flow');

		if (isset($flv_width) && !empty($flv_width))
		{
			$playerWidth = $flv_width;
		}
		else
		{
			$playerWidth = $c->flvplay_width;
		}

		if (isset($flv_height) && !empty($flv_height))
		{
			$playerHeight = $flv_height;
		}
		else if ($c->var_c == 1 && !empty($flv_path))
		{
			$extension = "ffmpeg";
			$extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;
			$extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;

			if(extension_loaded($extension))
			{
				$movie = new ffmpeg_movie($flv_path);
				$height = $movie->getFrameHeight();
				$width = $movie->getFrameWidth();

				$playerHeight = intval($playerWidth*($height/$width));
			}
		}

		if ($j16)
		{
			$flowDir = JURI::root()."plugins/hwdvs-videoplayer/flow/flow/";
		}
		else
		{
			$flowDir = JURI::root()."plugins/hwdvs-videoplayer/flow/";
		}

		if (!isset($playerHeight))
		{
			$playerHeight = $playerWidth*$c->var_fb;
		}

	    $playerHeight = intval($playerHeight+24);

		$smartyvs->assign("player_width", $playerWidth);
		$ui = rand(100, 999);

	    $param_accelerated 			= $params->get('accelerated', 0);
	    $param_autoBuffering 		= $params->get('autoBuffering', 1);
	    $param_autoPlay 			= $params->get('autoPlay', 0);
	    $param_repeat 				= $params->get('repeat', 0);
	    $param_bufferLength 		= $params->get('bufferLength', 3);
	    $param_linkUrl 				= $params->get('linkUrl', '');
	    $param_scaling 				= $params->get('scaling', 0);
	    $param_pseudostreaming 		= $params->get('pseudostreaming', 0);
	    $param_start 				= $params->get('start', 0);

	    $param_key 					= $params->get('key', '');
	    $param_logo 				= $params->get('logo', '');
	    $param_logo_top 			= $params->get('logo_top', '20');
	    $param_logo_right			= $params->get('logo_right', '20');
	    $param_logo_opacity 		= $params->get('logo_opacity', '0.4');
	    $param_logo_fullScreenOnly  = $params->get('logo_fullScreenOnly', 'false');
	    $param_logo_displayTime 	= $params->get('logo_displayTime', '0');
	    $param_logo_fadeSpeed 		= $params->get('logo_fadeSpeed', '0');

	    $param_backgroundColor      = $params->get('backgroundColor', '#222222');
	    $param_durationColor        = $params->get('durationColor', '#ffffff');
	    $param_volumeSliderColor    = $params->get('volumeSliderColor', '#000000');
	    $param_bufferColor          = $params->get('bufferColor', '#445566');
	    $param_buttonOverColor      = $params->get('buttonOverColor', '#728B94');
	    $param_sliderColor          = $params->get('sliderColor', '#000000');
	    $param_progressColor        = $params->get('progressColor', '#112233');
	    $param_volumeSliderGradient = $params->get('volumeSliderGradient', 'none');
	    $param_backgroundGradient   = $params->get('backgroundGradient', '[0.6,0.3,0,0,0]');
	    $param_borderRadius         = $params->get('borderRadius', '0px');
	    $param_buttonColor          = $params->get('buttonColor', '#5F747C');
	    $param_tooltipTextColor     = $params->get('tooltipTextColor', '#ffffff');
	    $param_sliderGradient       = $params->get('sliderGradient', 'none');
	    $param_timeColor            = $params->get('timeColor', '#01DAFF');
	    $param_progressGradient     = $params->get('progressGradient', 'medium');
	    $param_timeBgColor          = $params->get('timeBgColor', '#555555');
	    $param_tooltipColor         = $params->get('tooltipColor', '#5F747C');
	    $param_bufferGradient       = $params->get('bufferGradient', 'none');
	    $param_cbheight             = $params->get('height', '24');
	    $param_opacity              = $params->get('opacity', '1.0');

	    $param_captions             = $params->get('captions', '0');

	    $version_player             = $params->get('version', '0');
	    $version_pseudostreaming    = '3.2.2';
	    $version_rtmp               = '3.2.1';
	    $version_ltas               = '';
	    $version_captions           = '3.2.2';
	    $version_content            = '3.2.0';
	    $version_commercial         = $params->get('commercialVersion', '0');
	    $version_js                 = '3.2.4';

		if ($version_player == 0 || !file_exists(JPATH_SITE.DS."plugins".DS."hwdvs-videoplayer".DS."flow".DS."flowplayer-$version_player.swf"))
		{
			$version_player = '3.2.5';
		}
		if ($version_commercial == 0)
		{
			$version_commercial = $version_player;
		}

		//not a local video so don't try to pseudo-stream
		if (empty($flv_path) || !isset($flv_path))
		{
			$param_pseudostreaming = 0;
		}

		$clip_param = "";
		if ($param_accelerated == 1)
		{
			$clip_param.= ",\"accelerated\":\"true\"";
		}
		else if ($param_accelerated == 0)
		{
			$clip_param.= ",\"accelerated\":\"false\"";
		}
		if ($param_autoBuffering == 1)
		{
			$clip_param.= ",\"autoBuffering\":\"true\"";
		}
		else if ($param_autoBuffering == 0)
		{
			$clip_param.= ",\"autoBuffering\":\"false\"";
		}
		if (isset($autostart) && $autostart == "0")
		{
			$autoPlay = "false";
		}
		else if ($param_autoPlay == 1 || (isset($autostart) && $autostart == "1"))
		{
			$autoPlay = "true";
		}
		else
		{
			$autoPlay = "false";
		}
		$clip_param.= ",\"bufferLength\":\"$param_bufferLength\"";
		if (isset($param_linkUrl) && !empty($param_linkUrl))
		{
			$clip_param.= ",\"linkUrl\":\"$param_linkUrl\"";
		}
		if ($param_scaling == 0)
		{
			$clip_param.= ",\"scaling\":\"scale\"";
		}
		else if ($param_scaling == 1)
		{
			$clip_param.= ",\"scaling\":\"fit\"";
		}
		else if ($param_scaling == 2)
		{
			$clip_param.= ",\"scaling\":\"half\"";
		}
		else if ($param_scaling == 3)
		{
			$clip_param.= ",\"scaling\":\"orig\"";
		}

		if (($c->loadmootools == "on") && (strpos(JURI::base(true), "/administrator") === false))
		{
			JHTML::_('behavior.mootools');
		}

		if ($mediatype == "playlist" && !is_array($flv_url))
		{
			require_once(JPATH_SITE.DS.'components'.DS.'com_hwdvideoshare'.DS.'xml'.DS.'xmlparse.class.php');
			$parser = new HWDVS_xmlParse();
			$path = 'xspf'.DS.@basename($flv_url, ".xml");
			$parsed_list = $parser->parse($path);

			if (count($parsed_list) > 0)
			{
				$preRoll = false;
				$flv_url = '';
				for ($i=0, $n=count($parsed_list); $i < $n; $i++)
				{
					if (isset($parsed_list[$i]['location']))
					{
						$pos = strpos($parsed_list[$i]['location'], "http");
						if ($pos === false)
						{
							$vURL = 'http://'.$_SERVER['HTTP_HOST'].$parsed_list[$i]['location'];
						}
						else
						{
							$vURL = $parsed_list[$i]['location'];
						}
						$flv_url[$i] = urlencode($vURL);
					}
				}
			}
			else
			{
				$preRoll = true;
			}
		}
		else
		{
			$preRoll = true;
		}

		if ($param_pseudostreaming == 1 || $param_pseudostreaming == 2)
		{
			$streamer = true;
		}
		else
		{
			$streamer = false;
		}

		if ($streamer && $rtmp !== 1)
		{
			$provider = ", \"provider\":\"hwdvsservice\" ";

			if ($param_start > 0)
			{
				$provider.= ", \"start\":\"$param_start\" ";
			}

			$streamer_plugin = "\"hwdvsservice\":{\"url\":\"".$flowDir."flowplayer.pseudostreaming-".$version_pseudostreaming.".swf\"},";
			$clip_param = "";
		}
		else if ($rtmp == "1")
		{
			//$rtmp_file = "vod/demo.flowplayer/metacafe.flv";
			//$rtmp_streamer = "rtmp://vod01.netdna.com/play";
			//$rtmp_file = "christopherandkatrina/Christopher%20Hussey%20and%20Katrina%20Branson%20-%20Routine%20-%20Turn%20It%20On%2c%20Turn%20It%20Up%20-%20US%20Open%202006.mp4";
			//$rtmp_streamer = "rtmp://s30ivv0t2ww666.cloudfront.net/cfx/st";

			if (is_array($flv_url))
			{
				for ($i=0, $n=count($flv_url); $i < $n; $i++)
				{
					$parsed_url = parse_url($flv_url[$i]);

					$rtmp_file_temp = $parsed_url['path'];
					$rtmp_file_temp = explode(":", $rtmp_file_temp, 2);

					if (!empty($rtmp_file_temp[1]))
					{
						$rtmp_file = $rtmp_file_temp[1];

						$rtmp_streamer_temp = $rtmp_file_temp[0];
						$rtmp_streamer_temp = explode("/", $rtmp_streamer_temp);;

						$rtmp_path = implode("/", $rtmp_streamer_temp);

						$type = $rtmp_streamer_temp[count($rtmp_streamer_temp)-1];

						$rtmp_streamer = $parsed_url['scheme']."://".$parsed_url['host'].$rtmp_path;
					}
					else
					{
						$rtmp_file = null;
						$rtmp_streamer = null;
					}

					if (!empty($rtmp_file))
					{
						$flv_url[$i] = $rtmp_file;
					}
					$netConnectionUrl = $rtmp_streamer;

					$provider = ", \"provider\":\"hwdvsservice\"";
					$streamer_plugin = "\"hwdvsservice\":{\"url\":\"".$flowDir."flowplayer.rtmp-$version_rtmp.swf\",\"netConnectionUrl\":\"".$netConnectionUrl."\"},";

					//$clip_param = "";
				}
			}
			else
			{
				$parsed_url = parse_url($flv_url);

				$rtmp_file_temp = $parsed_url['path'];
				$rtmp_file_temp = explode(":", $rtmp_file_temp, 2);

				if (!empty($rtmp_file_temp[1]))
				{
					$rtmp_file = $rtmp_file_temp[1];

					$rtmp_streamer_temp = $rtmp_file_temp[0];
					$rtmp_streamer_temp = explode("/", $rtmp_streamer_temp);;

					$rtmp_path = implode("/", $rtmp_streamer_temp);

					$type = $rtmp_streamer_temp[count($rtmp_streamer_temp)-1];

					$rtmp_streamer = $parsed_url['scheme']."://".$parsed_url['host'].$rtmp_path;
				}
				else
				{
					$rtmp_file = null;
					$rtmp_streamer = null;
				}

				$flv_url = $rtmp_file;
				$netConnectionUrl = $rtmp_streamer;

				$provider = ", \"provider\":\"hwdvsservice\"";
				$streamer_plugin = "\"hwdvsservice\":{\"url\":\"".$flowDir."flowplayer.rtmp-$version_rtmp.swf\",\"netConnectionUrl\":\"".$netConnectionUrl."\"},";

				//$clip_param = "";
			}
		}
		else
		{
			$provider = "";
			$streamer_plugin = "";
		}


		if (!empty($param_key))
		{
			if (file_exists(JPATH_SITE.DS."plugins".DS."hwdvs-videoplayer".DS."flow".DS."flowplayer.commercial-$version_commercial.swf"))
			{
				$player_file = $flowDir."flowplayer.commercial-$version_commercial.swf";
			}
			else
			{
				$player_file = $flowDir."flowplayer-$version_player.swf";
			}

			$flashVars.= "\"key\":\"$param_key\",";

			if (!empty($param_logo))
			{
				$flashVars.= "\"logo\":{\"url\":\"$param_logo\",\"top\":\"$param_logo_top\",\"right\":\"$param_logo_right\",\"opacity\":\"$param_logo_opacity\",\"fullscreenOnly\":\"$param_logo_fullScreenOnly\",\"displayTime\":\"$param_logo_displayTime\",\"fadeSpeed\":\"$param_logo_fadeSpeed\"},";
			}
		}
		else
		{
			$player_file = $flowDir."flowplayer-$version_player.swf";
		}

		if ($rtmp == "1" || $streamer) {} else
		{
			$flashVars.= "\"type\":\"video\",";
		}

		$flashVars.= "\"canvas\":{\"backgroundColor\":\"transparent\"},";
		$flashVars.= "\"plugins\":{";

		if ($show_video_ad == 4)
		{
			$autoPlay = "true";
			// Sample open ad streamer setup
			$flashVars.= "\"openAdStreamer\": {

						\"url\":\"http://player.longtailvideo.com/flowplayer/ova-trial.swf\",
						\"debug\":{\"debugger\":\"firebug\",\"levels\":\"fatal, config, vast_template\"},
						\"ads\":{
							\"servers\":[
								{
								   \"type\":\"OpenX\",
								   \"apiAddress\":\"http://openx.openvideoads.org/openx/www/delivery/fc.php\",
								}
							],
							\"schedule\": [
								{
								  \"zone\":\"5\",
								  \"position\":\"pre-roll\",
								  \"applyToParts\": [1]
								}
							]
						}
					 },";
		}
		else if ($show_video_ad == 2)
		{
			$flashVars.= "\"ltas\":{\"url\":\"".$flowDir."flowplayer.ltas.swf\",\"enablejsads\":\"true\",\"debugmode\":\"true\",\"channelcode\":\"$longtail_c\"},";
		}

		if ($streamer || $rtmp == "1")
		{
			$flashVars.= $streamer_plugin;
		}

		$flashVars.= "\"controls\": {";

		if ($mediatype == "playlist" && $preRoll && !empty($flv_url[0]))
		{
			$flashVars.= "\"display\": \"none\"";
		}
		else
		{
			$flashVars.="\"backgroundColor\": \"".$param_backgroundColor."\",
						 \"durationColor\": \"".$param_durationColor."\",
						 \"volumeSliderColor\": \"".$param_volumeSliderColor."\",
						 \"bufferColor\": \"".$param_bufferColor."\",
						 \"buttonOverColor\": \"".$param_buttonOverColor."\",
						 \"sliderColor\": \"".$param_sliderColor."\",
						 \"progressColor\": \"".$param_progressColor."\",
						 \"volumeSliderGradient\": \"".$param_volumeSliderGradient."\",
						 \"backgroundGradient\": ".$param_backgroundGradient.",
						 \"borderRadius\": \"".$param_borderRadius."\",
						 \"buttonColor\": \"".$param_buttonColor."\",
						 \"tooltipTextColor\": \"".$param_tooltipTextColor."\",
						 \"sliderGradient\": \"".$param_sliderGradient."\",
						 \"timeColor\": \"".$param_timeColor."\",
						 \"progressGradient\": \"".$param_progressGradient."\",
						 \"timeBgColor\": \"".$param_timeBgColor."\",
						 \"tooltipColor\": \"".$param_tooltipColor."\",
						 \"bufferGradient\": \"".$param_bufferGradient."\",
						 \"height\": ".$param_cbheight.",
						 \"opacity\": ".$param_opacity;
		}

		if ($mediatype == "playlist" && !$preRoll)
		{
			$flashVars.= ",\"playlist\": \"true\"";
		}
			$flashVars.="}";

		$captionUrl = "";
		if ($param_captions == 1)
		{
			$flashVars.=",\"captions\":{
							   \"url\":\"".$flowDir."flowplayer.captions-$version_captions.swf\",
							   \"captionTarget\":\"content\"
						  },

					      \"content\":{
							   \"url:\''.$flowDir.'flowplayer.content-'.$version_content.'.swf\',
							   \"bottom\":\"25\",
							   \"width\":\"80%\",
							   \"height\":\"40\",
							   \"backgroundColor\":\"transparent\",
							   \"backgroundGradient\":\"low\",
							   \"borderRadius\":\"4\",
							   \"border\":\"0\",

							   \"style\": {
									\"body\": {
										\"fontSize\":\"14\",
										\"fontFamily\":\"Arial\",
										\"textAlign\":\"center\",
										\"color\":\"#000000\"
									}
								}
						  }";

			$captionUrl = ",\"captionUrl\":\"".JURI::root()."components/com_hwdvideoshare/xml/captions/$video_id.xml\"";
		}

		$flashVars.= "},";

		$data = "";

		if (!empty($thumb_url)) { $data.= "{\"url\":\"$thumb_url\",\"autoPlay\":true $provider},"; }

		if ($mediatype == "playlist")
		{
			if ($preRoll)
			{
				if (!empty($flv_url[0]))
				{
					$data.= "{\"url\":\"".$flv_url[0]."\" $provider, \"autoPlay\":$autoPlay},";
				}

				if (!empty($flv_url[1]))
				{
					if (!empty($flv_url[0]))
					{
						$autoPlay = "true";
					}

					if (empty($flv_url[2]) && $param_repeat == "1")
					{
						$data.= "{\"url\":\"".$flv_url[1]."\" $provider,\"autoPlay\":$autoPlay,\"onStart\":\"function() { this.getControls().show(); }\",\"onBeforeFinish\":\"function ()  { return false; }\"}";
					}
					else if (empty($flv_url[2]) && $param_repeat == "0")
					{
						$data.= "{\"url\":\"".$flv_url[1]."\" $provider,\"autoPlay\":$autoPlay,\"onStart\":\"function() { this.getControls().show(); }\"}";
					}
					else
					{
						$data.= "{\"url\":\"".$flv_url[1]."\" $provider,\"autoPlay\":$autoPlay,\"onStart\":\"function() { this.getControls().show(); }\"},";
					}

				}

				if (!empty($flv_url[2]))
				{
					if ($param_repeat == "1")
					{
						$data.= "{\"url\":\"".$flv_url[2]."\" $provider,\"autoPlay\":true,\"onStart\":\"function() { this.getControls().hide(); }\",\"onBeforeFinish\":\"function ()  { return false; }\"}";
					}
					else if ($param_repeat == "0")
					{
						$data.= "{\"url\":\"".$flv_url[2]."\" $provider,\"autoPlay\":true,\"onStart\":\"function() { this.getControls().hide(); }\"}";
					}
				}
			}
			else
			{
				for ($i=1, $n=count($flv_url); $i < $n; $i++)
				{
					if (!empty($flv_url[$i]))
					{
						if (empty($flv_url[$i+1]) && $param_repeat == "1")
						{
							$data.= "{\"url\":\"".$flv_url[$i]."\" $provider,\"autoPlay\":true,\"onStart\":\"function() { this.getControls().show(); }\",\"onBeforeFinish\":\"function ()  { return false; }\"}";
						}
						else if (empty($flv_url[$i+1]) && $param_repeat == "0")
						{
							$data.= "{\"url\":\"".$flv_url[$i]."\" $provider,\"autoPlay\":true,\"onStart\":\"function() { this.getControls().show(); }\"}";
						}
						else
						{
							$data.= "{\"url\":\"".$flv_url[$i]."\" $provider,\"autoPlay\":true,\"onStart\":\"function() { this.getControls().show(); }\"},";
						}
					}
				}
			}
		}
		else
		{
			if (!empty($flv_url[1]))
			{
				if ( $param_repeat == "1")
				{
					$data.= "{\"url\":\"".$flv_url."\" $clip_param $provider $captionUrl,\"autoPlay\":$autoPlay,\"onBeforeFinish\":\"function ()  { return false; }\"}";
				}
				else
				{
					$data.= "{\"url\":\"".$flv_url."\" $clip_param $provider $captionUrl,\"autoPlay\":$autoPlay}";
				}
			}
		}

		$flashVars.=" \"playlist\": [".$data."]";
		$flashVars = preg_replace('/\s*/m', '', $flashVars);

		$sendFlashVars->flashVars = $flashVars;
		$sendFlashVars->JsLocation = $flowDir."flowplayer-$version_js.min.js";
		$sendFlashVars->playerWidth = $playerWidth;
		$sendFlashVars->playerHeight = $playerHeight;
		$sendFlashVars->playerLocation = $player_file;

		$doc->setMetaData( 'og:video' , "http://www.example.com/player.swf?video_id=123456789" );
		$doc->setMetaData( 'video_height' , "200" );
		$doc->setMetaData( 'video_width' , "300" );
		$doc->setMetaData( 'video_type' , "application/x-shockwave-flash" );

		return $sendFlashVars;
	}
}
?>