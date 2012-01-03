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
     * Prepares the code to insert the third party video
     *
     * @param string $row  the $video_id output containing video paramters
     * @param int    $flv_width  the video width
     * @param int    $flv_height  the video height
     * @return       $code   the third party embed code
     */
    function youtubeComPrepareVideo($row, $flv_width=null, $flv_height=null, $autostart=null)
	{
		global $show_video_ad, $pre_url, $post_url, $smartyvs, $task, $pre_url, $post_url;
		$c = hwd_vs_Config::get_instance();

		$plugin =& JPluginHelper::getPlugin('hwdvs-thirdparty', 'youtube');
		$pluginParams = new JParameter( $plugin->params );

		$pp_playLocal     = $pluginParams->get('playLocal', '2');
		$pp_playerVersion = $pluginParams->get('playerVersion', '1');

		$code = null;

		$data = @explode(",", $row->video_id);
		$videocode = $data[0];

		if (($c->playlocal == "1" && $pp_playLocal == "2") || $pp_playLocal == "1")
		{
			if ($c->hwdvids_videoplayer_file == 'jwflv' || $c->hwdvids_videoplayer_file == 'jwflv_v5' || $c->hwdvids_videoplayer_file == 'jwflv_html5')
			{
				$truepath = "http://www.youtube.com/watch%3Fv%3D".$videocode;
			}
			else
			{
				$truepath = youtubeComPrepareFlvURL($row->video_id);
			}
		}
		else
		{
			$truepath = '';
		}

		$thumb_url = hwd_vs_tools::generatePlayerThumbnail($row);

		if (!empty($truepath) && $c->playlocal == "1")
		{
			$player = new hwd_vs_videoplayer();

			if ($show_video_ad == 1) {

				if ($c->hwdvids_videoplayer_file == "flow") {

					$flv_tracks = array();
					$flv_tracks[0] = $pre_url;
					$flv_tracks[1] = $truepath;
					$flv_tracks[2] = $post_url;

					$code.= $player->prepareEmbeddedPlayer($flv_tracks, $flv_width, $flv_height, rand(100, 999), "playlist", null, null, $autostart);
					return $code;

				} else {

					$xspf_playlist = JPATH_SITE.DS.'components'.DS.'com_hwdvideoshare'.DS.'xml'.DS.'xspf'.DS.$row->id.'.xml';
					@unlink($xspf_playlist);
					require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_hwdrevenuemanager'.DS.'redrawplaylist.class.php');
					hwd_rm_playlist::writeFile($row, $truepath, $pre_url, $post_url, $thumb_url);

					if (file_exists($xspf_playlist)) {
						$flv_url = JURI::root(true)."/components/com_hwdvideoshare/xml/xspf/".$row->id.".xml";
						$flv_path = JPATH_SITE.DS.'components'.DS.'com_hwdvideoshare'.DS.'xml'.DS.'xspf'.DS.$row->id.'.xml';

						if ($c->loadswfobject == "on" && $task !=="grabjomsocialplayer") {
							$code.= $player->prepareplayer($flv_url, $flv_width, $flv_height, rand(100, 999), "playlist", $flv_path, null, $autostart, $row->id);
						} else {
							$code.= $player->prepareEmbeddedPlayer($flv_url, $flv_width, $flv_height, rand(100, 999), "playlist", $flv_path, null, $autostart, $row->id);
						}
						return $code;
					}
				}

			}

			if ($c->loadswfobject == "on")
			{
				$code.= $player->prepareplayer($truepath, $flv_width, $flv_height, rand(100, 999), "youtube", null, $thumb_url, $autostart, $row->id);
			}
			else
			{
				$code.= $player->prepareEmbeddedPlayer($truepath, $flv_width, $flv_height, rand(100, 999), "youtube", null, $thumb_url, $autostart, $row->id);
			}

			return $code;

		} else {

			if ($flv_width==null) {
				$smartyvs->assign("player_width", $c->flvplay_width);
				$flv_width = $c->flvplay_width."px";
			} else {
				$smartyvs->assign("player_width", $flv_width);
				if (preg_match("/%/", $flv_width)) {
					$flv_width = $flv_width;
				} else {
					$flv_width = $flv_width."px";
				}
			}
			if ($flv_height==null) {
				$flv_height = intval ($flv_width*$c->var_fb);
				$flv_height = $flv_height+25;
				$flv_height = $flv_height."px";
			} else {
				if (preg_match("/%/", $flv_height)) {
					$flv_height = $flv_height;
				} else {
					$flv_height = $flv_height."px";
				}
			}

			$protocol = "http://";
			if(is_callable(array('hwd_vs_tools', 'isSSL')))
			{
				if (hwd_vs_tools::isSSL())
				{
					$protocol = "https://";
				}
			}

			if ($pp_playerVersion == 1)
			{
				$code = "<iframe title=\"YouTube video player\" class=\"youtube-player\" type=\"text/html\" width=\"".$flv_width."\" height=\"".$flv_height."\" src=\"".$protocol."www.youtube.com/embed/".$videocode."\" frameborder=\"0\"></iframe>";
				$code = "<iframe title=\"YouTube video player\" class=\"youtube-player\" type=\"text/html\" width=\"".$flv_width."\" height=\"".$flv_height."\" src=\"".$protocol."youtube.com/embed/".$videocode."?hd=1&wmode=transparent\" frameborder=\"0\"></iframe>";
			}
			else
			{
				$code = "<embed src=\"".$protocol."www.youtube.com/v/".$videocode."&rel=0&fs=1&color1=0x3a3a3a&color2=0x999999&border=0\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"".$flv_width."\" height=\"".$flv_height."\" allowfullscreen=\"true\"></embed>";
				$code = "<embed src=\"".$protocol."www.youtube.com/v/".$videocode."&rel=0&fs=1&color1=0x3a3a3a&color2=0x999999&border=0&hd=1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"".$flv_width."\" height=\"".$flv_height."\" allowfullscreen=\"true\"></embed>";
			}
			return $code;
		}
	}
    /**
     * Prepares the code to insert the third party thumbnail image
     *
     * @param string $option  the $video_id output containing video paramters
     * @param int    $vid  the video database id
     * @param int    $Itemid  the joomla menu id
     * @param int    $k  the alternating CSS integer
     * @return       $code   the full third party thumbnail image tag
     */
	function youtubeComPrepareThumb($option, $vid, $Itemid, $k, $width=null, $height=null, $class=null, $tooltip_data=null)
	{
		if (!isset($width)) {
			$width = $c->thumbwidth;
		}
		if (!isset($height)) {
			$height = $width*$c->tar_fb;
		}

		$code = "<img src=\"".youtubeComPrepareThumbURL($option, $vid)."\" border=\"0\" width=\"".$width."\" height=\"".$height."\" title=\"".$tooltip_data[1]." :: ".$tooltip_data[2]."\" class=\"".$class."\" />";
		return $code;
	}
    /**
     * Prepares the code to insert the third party thumbnail image
     *
     * @param string $option  the $video_id output containing video paramters
     * @param int    $vid  the video database id
     * @param int    $Itemid  the joomla menu id
     * @param int    $k  the alternating CSS integer
     * @return       $code   the full third party thumbnail image tag
     */
	function youtubeComPrepareThumbURL($option, $vid)
	{
		$data = explode(",", $option);
		$thumbnail = @$data[1];

		if (!$thumbnail) {
			$code = URL_HWDVS_IMAGES.'default_thumb.jpg';
		} else {
			$code = $thumbnail;
		}
		return $code;
	}
	/**
     * Prepares the third party video link
     *
     * @param string $option  the $video_id output containing video paramters
     * @param int    $vid  the video database id
     * @param int    $Itemid  the joomla menu id
     * @return       $code   the full third party thumbnail image tag
     */
	function youtubeComPrepareVideoURL($option)
	{
			if (@explode(",", $option)) {
				$data = explode(",", $option);
				$videocode = $data[0];
			} else { $videocode = "ERROR"; }

			$code = "http://www.youtube.com/watch?v=".$videocode;
			return $code;
	}
    /**
     * Prepares the third party video embed code
     *
     * @param string $option  the $video_id output containing video paramters
     * @param int    $vid  the video database id
     * @param int    $Itemid  the joomla menu id
     * @return       $code   the full third party thumbnail image tag
     */
	function youtubeComPrepareVideoEmbed($option, $vid, $Itemid)
	{
		global $mosConfig_sitename, $mosConfig_live_site;
		$c = hwd_vs_Config::get_instance();
			if (@explode(",", $option)) {
				$data = explode(",", $option);
				$videocode = $data[0];
			} else { $videocode = "ERROR"; }

			$code = null;
			if ($c->embedreturnlink == 1) {
				$code.='<div><center>';
			}
			$code.= "<object width=&#34;425&#34; height=&#34;355&#34;><param name=&#34;movie&#34; value=&#34;http://www.youtube.com/v/".$videocode."&rel=1&#34;></param><param name=&#34;wmode&#34; value=&#34;transparent&#34;></param><embed src=&#34;http://www.youtube.com/v/".$videocode."&rel=1&#34; type=&#34;application/x-shockwave-flash&#34; wmode=&#34;transparent&#34; width=&#34;425&#34; height=&#34;355&#34;></embed></object>";
			if ($c->embedreturnlink == 1) {
				$jconfig = new jconfig();
				$code.='<br /><a href=&#34;'.JURI::root().'index.php?option=com_hwdvideoshare&Itemid='.$Itemid.'&#34; title=&#34;'.$jconfig->sitename.'&#34;>'.$jconfig->sitename.'</a></center></div>';
			}

			return $code;
	}
    /**
     * Prepares the third party video embed code
     *
     * @param string $option  the $video_id output containing video paramters
     * @param int    $vid  the video database id
     * @param int    $Itemid  the joomla menu id
     * @return       $code   the full third party thumbnail image tag
     */
	function youtubeComPrepareFlvURL($option)
	{
		return false;
		global $mosConfig_sitename, $mosConfig_live_site;
		$c = hwd_vs_Config::get_instance();

		$data = explode(",", $option);

		$truepath = null;
		$truepath = downloadYT($data[0]) ;

		if (isset($truepath) && !empty($truepath)) {
			$truepath = urlencode( $truepath );
			return $truepath;
		}

		return false;

	}
    /**
     * Prepares the youtube data
     *
     * @param string $video_id
     * @return       $code
     */
	function downloadYT($video_id)
	{
		$url = "http://www.youtube.com/watch?v=".$video_id;
		$url = hwd_vs_tools::get_final_url( $url );

		if (function_exists('curl_init')) {
			// get title with CURL
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$url);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);

			if (!empty($buffer)) {

				$page = $buffer;

				//preg_match('/watch_fullscreen\?video_id=(.*?)&l=(.*?)+&t=(.*?)&/', $page, $match);
				preg_match('/"video_id": "(.*?)"/', $page, $match);
				$var_id = @$match[1];

				preg_match('/"t": "(.*?)"/', $page, $match);
				$var_t = @$match[1];

				if (empty($var_id) || empty($var_t)) {
					return false;
				}
				$url = "";
				$url .= $var_id;
				$url .= "&t=";
				$url .= $var_t;
				$url = "http://www.youtube.com/get_video?video_id=".$url;
				$truepath = hwd_vs_tools::get_final_url( $url );
				$filegrab = @file_get_contents($truepath, null, null, 0, 16);
				$filecheck = @strpos($filegrab, "mp4");
				if (isset($truepath) && !empty($truepath) && $filecheck !== false) {
					return $truepath;
				}

				return;

				$fmt          = 35;
				$truepath     = $url."&fmt=".$fmt;
				$truepath = hwd_vs_tools::get_final_url( $truepath );
				$filegrab = @file_get_contents($truepath, null, null, 0, 16);
				$filecheck = @strpos($filegrab, "mp4");
				if (isset($truepath) && !empty($truepath) && $filecheck !== false) {
					return $truepath;
				}

				$fmt          = 22;
				$truepath     = $url."&fmt=".$fmt;
				$truepath = hwd_vs_tools::get_final_url( $truepath );
				$filegrab = @file_get_contents($truepath, null, null, 0, 16);
				$filecheck = @strpos($filegrab, "mp4");
				if (isset($truepath) && !empty($truepath) && $filecheck !== false) {
					return $truepath;
				}

				$fmt          = 18;
				$truepath     = $url."&fmt=".$fmt;
				$truepath = hwd_vs_tools::get_final_url( $truepath );
				$filegrab = @file_get_contents($truepath, null, null, 0, 16);
				$filecheck = @strpos($filegrab, "mp4");
				if (isset($truepath) && !empty($truepath) && $filecheck !== false) {
					return $truepath;
				}

				return $truepath;

			}
		}
	}

?>