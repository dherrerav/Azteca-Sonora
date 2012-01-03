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
     * @param string $option  the $video_id output containing video paramters
     * @param int    $flv_width  the video width
     * @param int    $flv_height  the video height
     * @return       $code   the third party embed code
     */
    function remotePrepareVideo($row, $flv_width=null, $flv_height=null, $autostart=null)
	{
		global $show_video_ad, $pre_url, $post_url, $smartyvs, $task, $pre_url, $post_url;
		$c = hwd_vs_Config::get_instance();

		$code=null;

		if (substr($row->video_id, 0, 6) == 'embed|') {

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.view.php')) {

				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.view.php');
				$code = embedPrepareVideo($row, $flv_width, $flv_height, $autostart);
				return $code;

			} else {

				$code = _HWDVIDS_INFO_NOPLUGIN." "._HWDVIDS_WMIP_01."Embedder"._HWDVIDS_WMIP_02;
				return $code;

			}

		} else {

			$data = @explode(",", $row->video_id);
			$truepath = remotePrepareFlvURL($row->video_id);

			$thumb_url = hwd_vs_tools::generatePlayerThumbnail($row);

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

			if ($c->loadswfobject == "on") {
				$code.= $player->prepareplayer($truepath, $flv_width, $flv_height, rand(100, 999), "youtube", null, $thumb_url, $autostart, $row->id);
			} else {
				$code.= $player->prepareEmbeddedPlayer($truepath, $flv_width, $flv_height, rand(100, 999), "youtube", null, $thumb_url, $autostart, $row->id);
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
	function remotePrepareThumb($option, $vid, $Itemid, $k, $width=null, $height=null, $class=null, $tooltip_data=null)
	{
		if (!isset($width)) {
			$width = $c->thumbwidth;
		}
		if (!isset($height)) {
			$height = $width*$c->tar_fb;
		}

		$code = "<img src=\"".remotePrepareThumbURL($option, $vid)."\" border=\"0\" width=\"".$width."\" height=\"".$height."\" title=\"".$tooltip_data[1]." :: ".$tooltip_data[2]."\" class=\"".$class."\" />";
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
	function remotePrepareThumbURL($option, $vid)
	{
		$code = '';

		if (substr($option, 0, 6) == 'embed|') {

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.view.php')) {

				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.view.php');
				$code = embedPrepareThumbURL($option, $vid);

			}

		} else {

			$data = explode(",", $option);
			$thumbnail = @$data[1];

			if (!$thumbnail) {
				$code = URL_HWDVS_IMAGES.'default_thumb.jpg';
			} else {
				$code = $thumbnail;
			}

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
	function remotePrepareVideoURL($option)
	{
		$code = '';

		if (substr($option, 0, 6) == 'embed|') {

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.view.php')) {

				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.view.php');
				$code = embedPrepareVideoURL($option);

			}

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
	function remotePrepareVideoEmbed($video_id, $vid, $Itemid, $row=null)
	{
		$data = @explode(",", $video_id);
		$truepath = $data[0];
		$thumb_url = hwd_vs_tools::generatePlayerThumbnail($row);
		$player = new hwd_vs_videoplayer();
		$code = $player->prepareEmbedCode($truepath, null, null, null, "remote", null, $thumb_url, 0, $vid);
		return $code;
	}
    /**
     * Prepares the real flv url
     *
     * @param string $option  the $video_id output containing video paramters
     * @param int    $vid  the video database id
     * @param int    $Itemid  the joomla menu id
     * @return       $code   the full third party thumbnail image tag
     */
	function remotePrepareFlvURL($option)
	{
		$code = '';

		if (substr($option, 0, 6) == 'embed|')
		{
			return;
		}
		else
		{
			if (@explode(",", $option))
			{
				$data = explode(",", $option);
				$videocode = $data[0];
				return $videocode;
			}
			else
			{
				return;
			}
		}
		return $code;
	}
?>