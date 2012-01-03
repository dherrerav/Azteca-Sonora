<?php

/**
 * @package             Joomla Admin Mobile - Banners
 * @copyright (C) 2009-2011 by Covert Apps - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class  plgJoomlaAdminMobileBanners extends JPlugin
{
	private static $instance;
	private static $bannerTable = "#__banner";
	private static $bannerClientTable = "#__bannerclient";
	private static $bidCol = "bid";
	private static $publishCol = "showBanner";

    public static function getInstance()
    {
            if (!is_object(self::$instance)) {
                    self::$instance = new plgJoomlaAdminMobileBanners;
            }

            return self::$instance;
    }

	function plgJoomlaAdminMobileBanners(& $subject, $config)
	{
		parent::__construct($subject, $config);

		// Determine Joomla Version
		$JVer = new JVersion;
		$version = $JVer->getShortVersion();

		// Get correct Table name based on Joomla Version
		if (substr($version, 0, 3) != '1.5')
		{
			self::$bannerTable = "#__banners";
			self::$bannerClientTable = "#__banner_clients";
			self::$bidCol = "id";
			self::$publishCol = "state";
		}

		self::$instance = $this;
	}

	function onGetAvailablePlugins()
	{
		return array(
			"display_name" => "Banners",
			"description" => "Displays information about the Joomla! banners component.",
			"class_name" => get_class(),
			"method_name" => "getBanners",
			"data_type" => "html",
		);
	}

	function getBanners()
	{
		$db = &JFactory::getDBO();

		// Total Banners
		$query = "SELECT COUNT(*) FROM ".self::$bannerTable;
		$db->setQuery($query);
		$rows = $db->loadRowList();

		$totalBanners = $rows[0][0];
		$data = JoomlaAdminMobileHelper::getJamJavascriptInclude();
		$data .= "<hr />";
		$data .= "<b><center>Banner Info</center></b>\n";
		$data .= "<hr />";
		$data .= "<b>Total Banners:</b> ".$totalBanners."<br />\n";

		// Banner Details
		$query = "SELECT ".self::$bidCol.", name, impmade, clicks FROM ".self::$bannerTable." order by catid, ordering ASC";
		$db->setQuery($query);
		$rows = $db->loadRowList();

		$data .= "<table border=\"1\">\n";
		$data .= "<tr><th>Name</th><th>Impressions</th><th>Clicks</th></tr>\n";

		foreach($rows as $row)
				{
					$data .= "<tr>";
					$data .= "<td><a href=\"#\" onclick=\"javascript:jamCallPluginMethod('plgJoomlaAdminMobileBanners', 'getBanner', 'Banner ".$row[0]."', 'html', [ ".$row[0]." ]); return false;\">".$row[1]."</a></td>";
					$data .= "<td>".$row[2]."</td>";
					$data .= "<td>".$row[3]."</td>";
			$data .= "</tr>\n";
				}
		$data .= "</table>\n";
		$data .= "<br>\n";

		return $data;
	}

	function getBanner($id)
	{
		$db = &JFactory::getDBO();
		$className = get_class();

		// Pull User Details
		$query = "SELECT jb.".self::$bidCol.", jc.title, jb.name, jb.alias, jb.sticky, jb.impmade, jb.clicks, jb.clickurl, jb.".self::$publishCol." FROM ".self::$bannerTable." jb, #__categories jc WHERE jb.".self::$bidCol." =".$db->quote($id)." and jb.catid = jc.id";
		$db->setQuery($query);
		$rows = $db->loadRow();

		$data = JoomlaAdminMobileHelper::getJamJavascriptInclude();

		$data .= <<<EOT
<script language="javascript">
	function resetClicks() {
		jamCallPluginMethod('{$className}', 'resetClicks', $id, 'html', [ $id ]);
	}
</script>
EOT;
		$sticky = "Yes";
		if ( $rows[4] == '0' )
			$sticky = "No";

		$published = "Yes";
		if ( $rows[8] == '0' )
			$published = "No";

		$data .= "<b>Banner Details for ".$rows[2]."</b><br />\n";
		$data .= "<hr />\n";
		$data .= "<b>Id:</b>  ".$rows[0]."<br />\n";
		$data .= "<b>Name:</b>  ".$rows[2]."<br />\n";
		$data .= "<b>Category:</b> ".$rows[1]."<br />\n";
		$data .= "<b>Alias:</b>  ".$rows[3]."<br /><br />\n";
		$data .= "<b>Sticky:</b>  ".$sticky."<br />\n";
		$data .= "<b>Published:</b>  ".$published."<br />\n";
		$data .= "<b>Impressions:</b>  ".$rows[5]."<br />\n";
		$data .= "<b>Clicks:</b>  ".$rows[6]." <input type=\"button\" onclick=\"javascript:resetClicks(); return false;\" value=\"Reset Clicks\" /><br /><br />\n";
		$data .= "<b>Click URL: </b><a href=\"".$rows[7]."\" target=\"_blank\">".$rows[7]."</a><br />\n";

		return $data;
	}

	function resetClicks($id)
	{
		$db = &JFactory::getDBO();

		// Set Clicks to Zero
		$query = "UPDATE ".self::$bannerTable." set clicks=0 WHERE ".self::$bidCol." =".$db->quote($id);
		$db->setQuery($query);
		$db->query();

		$query = "SELECT ".self::$bidCol.", name, clicks FROM ".self::$bannerTable." WHERE ".self::$bidCol." =".$db->quote($id);
		$db->setQuery($query);
		$rows = $db->loadRow();

		//$data = JoomlaAdminMobileHelper::getJamJavascriptInclude();
		$data = "<b>Clicks reset to zero for Banner:</b><br />\n";
		$data .= "<b>Id:</b>  ".$rows[0]."<br />\n";
		$data .= "<b>Name:</b>".$rows[1]."<br />\n";
		$data .= "<b>Clicks:</b>".$rows[2]."<br />\n";

		return $data;

	}
}
