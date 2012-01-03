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
 */
class hwd_vs_tp_YoutubeCom
{
    /**
     * Extracts the appropriate third party video code used to generate
     * the player and thumbnail images
     */
	function YoutubeComProcessCode($raw_code)
	{
		$code = hwd_vs_tp_YoutubeCom::YoutubeComGetCode($raw_code);
		if (!empty($code))
		{
			$thumbnail = hwd_vs_tp_YoutubeCom::YoutubeComGetThumbnail($code);
			$ext_v_code[0] = true;
			$ext_v_code[1] = $code;
			$ext_v_code[2] = $thumbnail;
		}
		else
		{
			$ext_v_code[0] = false;
			$ext_v_code[1] = "";
			$ext_v_code[2] = "";
		}
		return $ext_v_code;
	}
    /**
     * Extracts the appropriate third party video code used to generate
     * the player and thumbnail images
     */
	function YoutubeComGetCode($raw_code)
	{
		$pos_u = strpos($raw_code, "v=");

		if ($pos_u === false)
		{
			return null;
		}
		else if ($pos_u)
		{
			$pos_u_start = $pos_u + 2;

			$pos_u_end = strpos($raw_code, "&", $pos_u_start);
			if ($pos_u_end === false)
			{
				$pos_u_end = strpos($raw_code, "#", $pos_u_start);
				if ($pos_u_end === false)
				{
					$code = substr($raw_code, $pos_u_start);
					$code = strip_tags($code);
					$code = preg_replace("/[^a-zA-Z0-9s_-]/", "", $code);
				}
				else if ($pos_u_end)
				{
					$length = $pos_u_end - $pos_u_start;
					$code = substr($raw_code, $pos_u_start, $length);
					$code = strip_tags($code);
					$code = preg_replace("/[^a-zA-Z0-9s_-]/", "", $code);
				}
			}
			else if ($pos_u_end)
			{
				$length = $pos_u_end - $pos_u_start;
				$code = substr($raw_code, $pos_u_start, $length);
				$code = strip_tags($code);
				$code = preg_replace("/[^a-zA-Z0-9s_-]/", "", $code);
			}
		}
		return $code;
	}
    /**
     * Extracts the appropriate third party video code used to generate
     * the player and thumbnail images
     */
	function YoutubeComGetThumbnail($code)
	{
		$thumbnail = "http://img.youtube.com/vi/".$code."/default.jpg";
		$thumbnail = trim(strip_tags($thumbnail));
		return $thumbnail;
	}
    /**
     * Extracts the title of the third party video
     */
	function YoutubeComProcessTitle($raw_code, $processed_code=null)
	{
		$c = hwd_vs_Config::get_instance();

		if (empty($processed_code))
		{
			$code = hwd_vs_tp_YoutubeCom::YoutubeComGetCode($raw_code);
		}
		else
		{
			$code = $processed_code;
		}

		if ( $code[0] == '-')
		{
			$watchvideourl = "http://www.youtube.com/watch?v=".$code;
			$feeddata = false;
		}
		else
		{
			$watchvideourl = "http://gdata.youtube.com/feeds/api/videos/".$code;
			$feeddata = true;
		}
		$watchvideourl = hwd_vs_tools::get_final_url( $watchvideourl );

		$ext_v_title    = array();
		$ext_v_title[0] = "";
		$ext_v_title[1] = "";

		if (function_exists('curl_init'))
		{
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$watchvideourl);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);

			if (!empty($buffer))
			{
				if ($feeddata)
				{
					preg_match('/<title(.*?)>(.*?)<\/title>/', $buffer, $match);

					if (!empty($match[2]))
					{
						$ext_v_title[0] = 1;
						$ext_v_title[1] = $match[2];
						$ext_v_title[1] = strip_tags($ext_v_title[1]);
						$ext_v_title[1] = trim($ext_v_title[1]);
						$ext_v_title[1] = hwdEncoding::XMLEntities($ext_v_title[1]);
						$ext_v_title[1] = hwdEncoding::charset_decode_utf_8($ext_v_title[1]);
						$ext_v_title[1] = addslashes($ext_v_title[1]);
						$ext_v_title[1] = hwd_vs_tools::truncateText($ext_v_title[1], 500);
					}
				}
				else
				{
					$fcontents = stristr($buffer, '<title>');
					$rest = substr($fcontents, 7);
					$extra = stristr($fcontents, '</title>');
					$titlelen = strlen($rest) - strlen($extra);
					$gettitle = trim(substr($rest, 0, $titlelen));
					$gettitle = substr($gettitle, 14);

					if (!empty($gettitle))
					{
						$ext_v_title[0] = 1;
						$ext_v_title[1] = $gettitle;
						$ext_v_title[1] = strip_tags($ext_v_title[1]);
						$ext_v_title[1] = trim($ext_v_title[1]);
						$ext_v_title[1] = hwdEncoding::XMLEntities($ext_v_title[1]);
						$ext_v_title[1] = hwdEncoding::charset_decode_utf_8($ext_v_title[1]);
						$ext_v_title[1] = addslashes($ext_v_title[1]);
						$ext_v_title[1] = hwd_vs_tools::truncateText($ext_v_title[1], 500);
					}
				}
			}
		}

		if ($ext_v_title[0] == '1')
		{
			if ($ext_v_title[1] == '')
			{
				$ext_v_title[1] = _HWDVIDS_UNKNOWN;
			}
		}
		else
		{
			$ext_v_title[0] = 0;
			$ext_v_title[1] = _HWDVIDS_UNKNOWN;
		}
		return $ext_v_title;
	}
    /**
     * Extracts the description of the third party video
     */
	function YoutubeComProcessDescription($raw_code, $processed_code=null)
	{
		$c = hwd_vs_Config::get_instance();

		if (empty($processed_code))
		{
			$code = hwd_vs_tp_YoutubeCom::YoutubeComGetCode($raw_code);
		}
		else
		{
			$code = $processed_code;
		}

		if ( $code[0] == '-' )
		{
			$watchvideourl = "http://www.youtube.com/watch?v=".$code;
			$feeddata = false;
		}
		else
		{
			$watchvideourl = "http://gdata.youtube.com/feeds/api/videos/".$code;
			$feeddata = true;
		}
		$watchvideourl = hwd_vs_tools::get_final_url( $watchvideourl );

		$ext_v_descr    = array();
		$ext_v_descr[0] = "";
		$ext_v_descr[1] = "";

		if (function_exists('curl_init'))
		{
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$watchvideourl);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);

			if (!empty($buffer))
			{
				if ($feeddata)
				{
					preg_match('/<media\:description ?.* <\/media\:description>/isx',$buffer,$match);
					if (!empty($match[0]))
					{
						$ext_v_descr[0] = 1;
						$ext_v_descr[1] = $match[0];
						$ext_v_descr[1] = str_replace("<media:description type='plain'>", "", $ext_v_descr[1]);
						$ext_v_descr[1] = str_replace("</media:description>", "", $ext_v_descr[1]);
						$ext_v_descr[1] = strip_tags($ext_v_descr[1]);
						$ext_v_descr[1] = trim($ext_v_descr[1]);
						$ext_v_descr[1] = hwdEncoding::XMLEntities($ext_v_descr[1]);
						$ext_v_descr[1] = hwdEncoding::charset_decode_utf_8($ext_v_descr[1]);
						$ext_v_descr[1] = addslashes($ext_v_descr[1]);
						$ext_v_descr[1] = hwd_vs_tools::truncateText($ext_v_descr[1], 5000);
					}
				}
				else
				{
					preg_match('/<meta name="description" content="([^"]+)/', $buffer, $match);
					if (!empty($match[1]))
					{
						$ext_v_descr[0] = 1;
						$ext_v_descr[1] = $match[1];
						$ext_v_descr[1] = strip_tags($ext_v_descr[1]);
						$ext_v_descr[1] = trim($ext_v_descr[1]);
						$ext_v_descr[1] = hwdEncoding::XMLEntities($ext_v_descr[1]);
						$ext_v_descr[1] = hwdEncoding::charset_decode_utf_8($ext_v_descr[1]);
						$ext_v_descr[1] = addslashes($ext_v_descr[1]);
						$ext_v_descr[1] = hwd_vs_tools::truncateText($ext_v_descr[1], 5000);
					}
				}
			}
		}

		if ($ext_v_descr[0] == '1')
		{
			if ($ext_v_descr[1] == '')
			{
				$ext_v_descr[1] = _HWDVIDS_UNKNOWN;
			}
		}
		else
		{
			$ext_v_descr[0] = 0;
			$ext_v_descr[1] = _HWDVIDS_UNKNOWN;
		}
		return $ext_v_descr;
	}
    /**
     * Extracts the keywords of the third party video
     */
	function YoutubeComProcessKeywords($raw_code, $processed_code=null)
	{
		$c = hwd_vs_Config::get_instance();

		if (empty($processed_code))
		{
			$code = hwd_vs_tp_YoutubeCom::YoutubeComGetCode($raw_code);
		}
		else
		{
			$code = $processed_code;
		}

		$watchvideourl = "http://www.youtube.com/watch?v=".$code;
		$watchvideourl = hwd_vs_tools::get_final_url( $watchvideourl );

		$ext_v_keywo    = array();
		$ext_v_keywo[0] = "";
		$ext_v_keywo[1] = "";

		if (function_exists('curl_init'))
		{
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$watchvideourl);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);

			if (!empty($buffer))
			{
				preg_match('/<meta name="keywords" content="([^"]+)/',$buffer, $match);
				if (!empty($match[1]))
				{
					$ext_v_keywo[0] = 1;
					$ext_v_keywo[1] = $match[1];
					$ext_v_keywo[1] = strip_tags($ext_v_keywo[1]);
					$ext_v_keywo[1] = trim($ext_v_keywo[1]);
					$ext_v_keywo[1] = hwdEncoding::XMLEntities($ext_v_keywo[1]);
					$ext_v_keywo[1] = hwdEncoding::charset_decode_utf_8($ext_v_keywo[1]);
					$ext_v_keywo[1] = addslashes($ext_v_keywo[1]);
					$ext_v_keywo[1] = hwd_vs_tools::truncateText($ext_v_keywo[1], 1000);
				}
			}
		}
		if ($ext_v_keywo[0] == '1')
		{
			if ($ext_v_keywo[1] == '')
			{
				$ext_v_keywo[1] = _HWDVIDS_UNKNOWN;
			}
		}
		else
		{
			$ext_v_keywo[0] = 0;
			$ext_v_keywo[1] = _HWDVIDS_UNKNOWN;
		}
		return $ext_v_keywo;
	}
    /**
     * Extracts the duration of the third party video
     */
	function YoutubeComProcessDuration($raw_code, $processed_code=null)
	{
		$c = hwd_vs_Config::get_instance();

		if (empty($processed_code))
		{
			$code = hwd_vs_tp_YoutubeCom::YoutubeComGetCode($raw_code);
		}
		else
		{
			$code = $processed_code;
		}

		if ( $code[0] == '-' )
		{
			$ext_v_durat[0] = 0;
			$ext_v_durat[1] = "0:00:00";
			return $ext_v_durat;
		}
		else
		{
			$watchvideourl = "http://gdata.youtube.com/feeds/base/videos?q=".$code;
		}
		$watchvideourl = hwd_vs_tools::get_final_url( $watchvideourl );

		$ext_v_durat    = array();
		$ext_v_durat[0] = "";
		$ext_v_durat[1] = "";

		if (function_exists('curl_init'))
		{
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$watchvideourl);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);

			$buffer = trim($buffer);

			if (!empty($buffer))
			{
				preg_match_all('/&gt;(.*?)&lt;/', $buffer, $match);
				if (!empty($match[1][37]))
				{
					$ext_v_durat[0] = 1;
					$ext_v_durat[1] = $match[1][37];
					$ext_v_durat[1] = preg_replace("/[^0-9:]/", "", $ext_v_durat[1]);
				}
			}
			else
			{
				$watchvideourl = "http://www.youtube.com/watch?v=".$code;

				$curl_handle=curl_init();
				curl_setopt($curl_handle,CURLOPT_URL,$watchvideourl);
				curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,15);
				curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
				$buffer = curl_exec($curl_handle);
				curl_close($curl_handle);

				$buffer = trim($buffer);

				if (!empty($buffer))
				{
					preg_match('/&length_seconds=(.*?)&/', $buffer, $match);
					if (!empty($match[1]))
					{
						$ext_v_durat[0] = 1;
						$ext_v_durat[1] = hwd_vs_tools::sec2hms($match[1]);
						$ext_v_durat[1] = preg_replace("/[^0-9:]/", "", $ext_v_durat[1]);
					}
				}
			}
		}
		if ($ext_v_durat[0] == '1')
		{
			if ($ext_v_durat[1] == '')
			{
				$ext_v_durat[1] = "0:00:00";
			}
		}
		else
		{
			$ext_v_durat[0] = 0;
			$ext_v_durat[1] = "0:00:00";
		}
		return $ext_v_durat;
	}
}
?>