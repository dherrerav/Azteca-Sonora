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
class hwd_vs_tp_remote
{
    /**
     * Extracts the appropriate third party video code used to generate
     * the player and thumbnail images
     */
	function remoteProcessCode($raw_code)
	{
		$code = hwd_vs_tp_remote::remoteGetCode($raw_code);
		if (!empty($code))
		{
			$thumbnail = hwd_vs_tp_remote::remoteGetThumbnail($code);
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
	function remoteGetCode($raw_code)
	{
		if (hwd_vs_tools::is_valid_url($raw_code))
		{
			if ($parseUrl = parse_url($raw_code))
			{
				$parsedUrl = @$parseUrl['scheme'].'://'.@$parseUrl['host'].@$parseUrl['path'];
				if (!empty($parseUrl['query']))
				{
					$parsedUrl.= '?'.$parseUrl['query'];
				}

				$filegrab = @file_get_contents($parsedUrl, null, null, null, 150);

				if (function_exists('stripos'))
				{
					$filecheck1 = @stripos($filegrab, "flv");
					$filecheck2 = @stripos($filegrab, "mp4");
				}
				else
				{
					$filecheck1 = @strpos($filegrab, "flv");
					$filecheck2 = @strpos($filegrab, "mp4");
				}

				if (isset($parsedUrl) && !empty($parsedUrl) && ($filecheck1 !== false || $filecheck2 !== false))
				{
					return $parsedUrl;
				}
				else
				{
					if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php'))
					{
						require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php');
						$embedder = new hwd_vs_tp_embed();
						$code = $embedder->embedProcessURL($parsedUrl);
						return $code;
					}
				}
			}
		}
		else
		{
			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php'))
			{
				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php');
				$embedder = new hwd_vs_tp_embed();
				$code = $embedder->embedProcessURL($raw_code);
				return $code;
			}
		}
		return null;
	}
    /**
     * Extracts the appropriate third party video code used to generate
     * the player and thumbnail images
     */
	function remoteGetThumbnail($code)
	{
		$data = explode("|", $code);
		$url = $data[1];

		if ($parseUrl = parse_url($url))
		{
			$parsedUrl = @$parseUrl['scheme'].'://'.@$parseUrl['host'].@$parseUrl['path'];
			if (!empty($parseUrl['query']))
			{
				$parsedUrl.= '?'.$parseUrl['query'];
			}

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php'))
			{
				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php');
				$embedder = new hwd_vs_tp_embed();
				$code = $embedder->embedGetThumbnail($parsedUrl);
				return $code;
			}
		}
		return null;
	}
    /**
     * Extracts the title of the third party video
     */
	function remoteProcessTitle($url, $processed_code=null)
	{
		if ($parseUrl = parse_url($url))
		{
			$parsedUrl = @$parseUrl['scheme'].'://'.@$parseUrl['host'].@$parseUrl['path'];
			if (!empty($parseUrl['query']))
			{
				$parsedUrl.= '?'.$parseUrl['query'];
			}

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php'))
			{
				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php');
				$embedder = new hwd_vs_tp_embed();
				$code = $embedder->embedProcessTitle($parsedUrl);
			}
		}

		if (!empty($code))
		{
			$ext_video[0] = 1;
			$ext_video[1] = $code;
		}
		else
		{
			$ext_video[0] = 0;
			$ext_video[1] = _HWDVIDS_UNKNOWN;
		}
		return $ext_video;
	}
    /**
     * Extracts the description of the third party video
     */
	function remoteProcessDescription($url, $processed_code=null)
	{
		if ($parseUrl = parse_url($url))
		{
			$parsedUrl = @$parseUrl['scheme'].'://'.@$parseUrl['host'].@$parseUrl['path'];
			if (!empty($parseUrl['query']))
			{
				$parsedUrl.= '?'.$parseUrl['query'];
			}

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php'))
			{
				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php');
				$embedder = new hwd_vs_tp_embed();
				$code = $embedder->embedProcessDescription($parsedUrl);
			}
		}

		if (!empty($code))
		{
			$ext_video[0] = 1;
			$ext_video[1] = $code;
		}
		else
		{
			$ext_video[0] = 0;
			$ext_video[1] = _HWDVIDS_UNKNOWN;
		}
		return $ext_video;
	}
    /**
     * Extracts the keywords of the third party video
     */
	function remoteProcessKeywords($url, $processed_code=null)
	{
		if ($parseUrl = parse_url($url))
		{
			$parsedUrl = @$parseUrl['scheme'].'://'.@$parseUrl['host'].@$parseUrl['path'];
			if (!empty($parseUrl['query']))
			{
				$parsedUrl.= '?'.$parseUrl['query'];
			}

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php'))
			{
				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php');
				$embedder = new hwd_vs_tp_embed();
				$code = $embedder->embedProcessDescription($parsedUrl);
			}
		}

		if (!empty($code))
		{
			$ext_video[0] = 1;
			$ext_video[1] = $code;
		}
		else
		{
			$ext_video[0] = 0;
			$ext_video[1] = _HWDVIDS_UNKNOWN;
		}
		return $ext_video;
	}
    /**
     * Extracts the duration of the third party video
     */
	function remoteProcessDuration($url, $processed_code=null)
	{
		if ($parseUrl = parse_url($url))
		{
			$parsedUrl = @$parseUrl['scheme'].'://'.@$parseUrl['host'].@$parseUrl['path'];
			if (!empty($parseUrl['query']))
			{
				$parsedUrl.= '?'.$parseUrl['query'];
			}

			if (file_exists(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php'))
			{
				require_once(JPATH_SITE.DS.'plugins'.DS.'hwdvs-thirdparty'.DS.'embed.php');
				$embedder = new hwd_vs_tp_embed();
				$code = $embedder->embedProcessDuration($parsedUrl);
			}
		}

		if (!empty($code))
		{
			$ext_video[0] = 1;
			$ext_video[1] = $code;
		}
		else
		{
			$ext_video[0] = 0;
			$ext_video[1] = _HWDVIDS_UNKNOWN;
		}
		return $ext_video;
	}
}
?>





