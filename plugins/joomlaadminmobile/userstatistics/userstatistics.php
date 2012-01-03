<?php

/**
 * @package             Joomla Admin Mobile - User Statistics
 * @copyright (C) 2009-2011 by Covert Apps - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class  plgJoomlaAdminMobileUserStatistics extends JPlugin
{
	function plgJoomlaAdminMobileUserStatistics(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onGetAvailablePlugins()
	{
		return array(
			"display_name" => "User Stats",
			"description" => "Displays user and session information.",
			"class_name" => get_class(),
			"method_name" => "getUserStatistics",
			"data_type" => "html",
		);
	}

	function getUserStatistics()
	{
		$db = &JFactory::getDBO();

		// Total Users
		$query = "SELECT COUNT(*) FROM #__users ";
		$db->setQuery($query);
		$rows = $db->loadRowList();

		$totalUsers = $rows[0][0];
		$data = JoomlaAdminMobileHelper::getJamJavascriptInclude();
		$data .= "<hr />";
		$data .= "<b><center>User Info</center></b>\n";
		$data .= "<hr />";
		$data .= "<b>Total Users:</b> ".$totalUsers."<br />\n";

		// Last 5 Registered Users
		$query = "SELECT id, name, usertype FROM #__users order by registerDate DESC LIMIT 5";
		$db->setQuery($query);
		$rows = $db->loadRowList();

		$data .= "<b>Last 5 Registered Users:</b><br />\n";
		$data .= "<table border=\"1\">\n";
		$data .= "<tr><th>Name</th><th>Group</th></tr>\n";
		foreach($rows as $row)
				{
					$data .= "<tr>";
					$data .= "<td><a href=\"#\" onclick=\"javascript:jamCallPluginMethod('plgJoomlaAdminMobileUserStatistics', 'getUser', 'User ".$row[0]."', 'html', [ ".$row[0]." ]); return false;\">".$row[1]."</a></td>";
					$data .= "<td>".$row[2]."</td>";
					$data .= "</tr>\n";
				}
		$data .= "</table>\n";
		$data .= "<br>\n";

		// Last 5 User Logins
		$query = "SELECT id, name, usertype FROM #__users order by lastvisitDate DESC LIMIT 5";
		$db->setQuery($query);
		$rows = $db->loadRowList();

		$data .= "<b>Last 5 User Logins:</b><br />\n";
		$data .= "<table border=\"1\">\n";
		$data .= "<tr><th>Name</th><th>Group</th></tr>\n";
		foreach($rows as $row)
				{
					$data .= "<tr>";
					$data .= "<td><a href=\"#\" onclick=\"javascript:jamCallPluginMethod('plgJoomlaAdminMobileUserStatistics', 'getUser', 'User ".$row[0]."', 'html', [ ".$row[0]." ]); return false;\">".$row[1]."</a></td>";
					$data .= "<td>".$row[2]."</td>";
					$data .= "</tr>\n";
				}
		$data .= "</table>\n";
		$data .= "<br>\n";

		// User Session Info
		$query = "SELECT guest, COUNT(*) FROM #__session GROUP BY guest";
		$db->setQuery($query);
		$rows = $db->loadRowList();

		$guestCount = 0;
		$nonGuestCount = 0;
		foreach($rows as $row)
		{
			if($row[0] == 0)
			{
				$nonGuestCount = $row[1];
			}
			else if($row[0] == 1)
			{
				$guestCount = $row[1];
			}
		}

		$data .= "<hr />\n";
		$data .= "<b><center>User Sessions Info</center></b>\n";
		$data .= "<hr />";
		$data .= "<b>Guest Sessions:</b> ".$guestCount."<br />\n";
		$data .= "<b>Registered Sessions:</b> ".$nonGuestCount."<br />\n";

		// Non-guest Active Sessions
		$query = "SELECT session_id, username, usertype, time FROM #__session where guest = 0";
		$db->setQuery($query);
		$rows = $db->loadRowList();
		$data .= "<table border=\"1\">\n";
		$data .= "<tr><th>Username</th><th>Group</th></tr>\n";
		$now = time();
		foreach($rows as $row)
			{
				$data .= "<tr>";
				$data .= "<td><a href=\"#\" onclick=\"javascript:jamCallPluginMethod('plgJoomlaAdminMobileUserStatistics', 'getSessionDetail', 'Session ".$row[0]."', 'html', [ '".$row[0]."' ]); return false;\">".$row[1]."</a></td>";
				$data .= "<td>".$row[2]."</td>";
				$data .= "</tr>\n";
			}
		$data .= "</table>\n";

		return $data;
	}

	function getUser($id)
	{
		$db = &JFactory::getDBO();

		// Pull User Details
		$query = "SELECT name, username, email, usertype, registerDate, lastvisitDate FROM #__users where id =".$db->quote($id);
		$db->setQuery($query);
		$rows = $db->loadRow();

		$data = JoomlaAdminMobileHelper::getJamJavascriptInclude();
		$data .= "<b>User Details:</b><br />\n";
		$data .= "<hr />\n";
		$data .= "<b>Name:</b>  ".$rows[0]."<br />\n";
		$data .= "<b>Username:</b>  ".$rows[1]."<br />\n";
		$data .= "<b>Email:</b>  ".$rows[2]."<br />\n";
		$data .= "<b>Usertype:</b>  ".$rows[3]."<br />\n";
		$data .= "<b>Register Date:</b>  ".$rows[4]."<br />\n";
		$data .= "<b>Last Visit Date:</b>  ".$rows[5]."<br /><br />\n";

		return $data;
	}

	function getSessionDetail($sessionId)
	{
		$db = &JFactory::getDBO();

		// Pull Session Details
		$query = "SELECT session_id, userid, username, time, guest, usertype, data FROM #__session where session_id =".$db->quote($sessionId);
		$db->setQuery($query);
		$rows = $db->loadRow();

		$data = JoomlaAdminMobileHelper::getJamJavascriptInclude();
		$data .= "<b>Session Details:</b><br />\n";
		$data .= "<hr />\n";

		if (is_null($rows[2]))
		{
			$data .= "The selected session is no longer active. <br />\n";
			$data .= "<br />\n";
			$data .= "It is also possible that the selected session is the JAM! component session which logs in and out \n";
			$data .= "while commuicating with the Joomla server.  This is not an actual user session.<br /><br />\n";
		}
		else
		{
			$data .= "<b>Session Id:</b>  ".$sessionId."<br />\n";
			$data .= "<b>User Id:</b>  ".$rows[1]."<br />\n";
			$data .= "<b>Username:</b>  ".$rows[2]."<br />\n";
			$now = time();
			$data .= "<b>Time:</b>  ".round(($now - $rows[3])/3600.0, 3)." hour ago.<br />\n";
			$data .= "<b>Guest Indicator:</b>  ".$rows[4]."<br />\n";
			$data .= "<b>Usertype:</b>  ".$rows[5]."<br /><br />\n";
			//$data .= "<b>Data:</b>  ".$rows[6]."<br /><br />\n";
		}

		return $data;
	}
}
