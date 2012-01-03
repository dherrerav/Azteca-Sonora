<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        hdvideoshareuninstall.php
 * @location    /components/com_contushdvideosahre/hdvideoshareuninstall.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Uninstallation file
 */

//No direct access
defined('_JEXEC') or die('Restricted access');
error_reporting(0);
// Imports
jimport('joomla.installer.installer');
$db = &JFactory::getDBO();
$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_category_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_category` TO `#__hdflv_category_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_comments_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_comments` TO `#__hdflv_comments_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_player_settings_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_player_settings` TO `#__hdflv_player_settings_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_upload_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_upload` TO `#__hdflv_upload_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_video_category_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_video_category` TO `#__hdflv_video_category_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_googlead_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_googlead` TO `#__hdflv_googlead_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_ads_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_ads` TO `#__hdflv_ads_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_user_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_user` TO `#__hdflv_user_backup`");
$db->query();

$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareCategories' LIMIT 1");
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}

$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareFeatured' LIMIT 1");
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}

$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoSharePopular' LIMIT 1");
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}

$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRecent' LIMIT 1");
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}

$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRelated' LIMIT 1");
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}

$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareSearch' LIMIT 1");
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}
?>
<br>
<br>
<h2 align="center">CONTUS HDVideo Share UnInstallation Status</h2>
<table class="adminlist">
    <thead>
        <tr>
            <th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
            <th><?php echo JText::_('Status'); ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    <tbody>
        <tr class="row0">
            <td class="key" colspan="2"><?php echo JText::_('HDVideShare - Component'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed components
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT id FROM #__hdflv_player_settings LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>
        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Categories - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                     //check installed modules
                     $db = &JFactory::getDBO();
                     $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareCategories' LIMIT 1");
                     $id = $db->loadResult();
                     if (!$id) {
                     echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                     } else {
                     echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                     }
                ?>
            </td>
        </tr>
        <tr class="row2">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Featured - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                    //check installed modules
                    $db = &JFactory::getDBO();
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareFeatured' LIMIT 1");
                    $id = $db->loadResult();
                    if (!$id) {
                        echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                    }
                ?>
            </td>
        </tr>

        <tr class="row3">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Popular - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
            <?php
                //check installed modules
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoSharePopular' LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
            ?>
            </td>
        </tr>
        <tr class="row4">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Recent - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
            <?php
                //check installed modules
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRecent' LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
            ?>
            </td>
        </tr>

        <tr class="row5">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Related - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
            <?php
                //check installed modules
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRelated' LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
            ?>
            </td>
        </tr>

        <tr class="row6">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Search - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
            <?php
                //check installed modules
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareSearch' LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
            ?>
            </td>
        </tr>
    </tbody>
</table>