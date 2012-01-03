<?php

/**
 * @package             Joomla Admin Mobile
 * @copyright (C) 2009-2011 by Covert Apps - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC' ) or die('Restricted access' );

?>

<table>
        <tr>
                <td width="48px"><img src="<?php print JURI::root(); ?>administrator/components/com_joomlaadminmobile/images/icon-48-joomlaadminmobile.png" width="48px"></td>
                <td><h2>Joomla Admin Mobile!</h2></td>
        </tr>
</table>
<h3>Installing...</h3>

<?php

jimport('joomla.installer.helper');
$installer = new JInstaller();

$packagesDir = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomlaadminmobile'.DS.'packages';

$packageNames = array(
	array("banners", "JAM - Banners", "plg_joomlaadminmobile_banners_v1.0.1.zip"),
	array("userstatistics", "JAM - User Statistics", "plg_joomlaadminmobile_userstatistics_v1.0.0.zip"),
);

$jVersion = new JVersion;
$version = $jVersion->getShortVersion();
$isJoomla15 = (substr($version, 0, 3) == '1.5');
if($isJoomla15)
{
	$adminImagesPath = "administrator/images/";
}
else
{
	$adminImagesPath = "administrator/templates/bluestork/images/admin/";
}

$successIcon = JURI::root().$adminImagesPath."tick.png";
$errorIcon = JURI::root().$adminImagesPath."publish_x.png";

$dbo = JFactory::getDBO();
foreach($packageNames as $packageData)
{
	$packageElement = $packageData[0];
	$packageName = $packageData[1];
	$packageFilename = $packageData[2];

	$package = JInstallerHelper::unpack($packagesDir.DS.$packageFilename);
	if($installer->install($package['dir']))
	{
		// Cleanup the tmp folder
		JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);

		// Enable the plugin
		if($isJoomla15)
		{
                	$query = "UPDATE #__plugins SET published = 1 WHERE folder = 'joomlaadminmobile' AND element = ".$dbo->quote($packageElement);
		}
		else
		{
                	$query = "UPDATE #__extensions SET enabled = 1 WHERE type = 'plugin' AND folder = 'joomlaadminmobile' AND element = ".$dbo->quote($packageElement);
		}
                $dbo->setQuery($query);
		$dbo->query();

?>
		<table bgcolor="#E0FFE0" width ="100%">
			<tr style="height:30px">
				<td width="50px"><img src="<?php print $successIcon; ?>" height="20px" width="20px"></td>
				<td><font size="2"><b>"<?php print $packageName; ?>" Plugin successfully installed.</b></font></td>
			</tr>
		</table>
<?php
	}
	else
	{
?>
		<table bgcolor="#FFD0D0" width ="100%">
			<tr style="height:30px">
				<td width="50px"><img src="<?php print $errorIcon; ?>" height="20px" width="20px"></td>
				<td><font size="2"><b>ERROR: Could not install the "<?php print $packageName; ?>" Plugin. Please install manually.</b></font></td>
			</tr>
		</table>
<?php
	}
}

?>

<p></p>
<p>You are now ready to connect to your site using the Joomla! Admin Mobile component.</p>
<p>For more information, view the JAM component <a target="_blank" href="<?php print JURI::root(); ?>administrator/index.php?option=com_joomlaadminmobile">here</a></p>

