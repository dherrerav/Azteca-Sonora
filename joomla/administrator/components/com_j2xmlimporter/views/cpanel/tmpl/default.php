<?php
/**
 * models/cpanel/tmpl/default.php
 *
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @version		1.6.0
 * @since		File available since Release v1.5.3
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XMLImporter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');
JHTML::_('behavior.tooltip');
jimport('joomla.language.language');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'version.php');

?>
<table width='100%'>
    <tr>
        <td width='55%' class='adminform' valign='top'>
		<div id='cpanel'>
<?php 
		$link = 'index.php?option=com_content';
		$this->_quickiconButton($link, 'icon-48-article.png', JText::_('COM_J2XMLIMPORTER_TOOLBAR_ARTICLE_MANAGER'));
?>
		</div>
        <div class='clr'></div>
        </td>
		<td valign='top' width='45%' style='padding: 7px 0 0 5px'>
			<?php
			echo $this->pane->startPane('pane');
			
			$title = JText::_('Welcome_to_J2XMLImporter');
			echo $this->pane->startPanel($title, 'welcome');
			?>
			<table class='adminlist'>
			<tr>
				<td colspan='2'>
					<p><?php echo JText::_('COM_J2XMLIMPORTER_DESCRIPTION')?></p>
				</td>
				<td rowspan='4' style="text-align:center">
					<a href='http://www.eshiol.it/j2xml.html'>
					<img src='components/com_j2xmlimporter/assets/images/j2xmlimporter.png' width='110' height='110' alt='J2XMLImporter' title='J2XMLImporter' align='middle' border='0'>
					</a>
				</td>
			</tr>
			<tr>
				<td width='25%'>
					<?php echo JText::_('Installed_Version'); ?>
				</td>
				<td width='45%'>
					<?php  echo j2xmlVersion::getLongVersion(); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('Copyright'); ?>
				</td>
				<td>
					<a href='http://www.eshiol.it' target='_blank'>&copy; 2010-2011 Helios Ciancio <img src='components/com_j2xmlimporter/assets/images/eshiol.png' alt='eshiol.it' title='eshiol.it' border='0'></a>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('License'); ?>
				</td>
				<td>
					<a href='http://www.gnu.org/licenses/gpl-3.0.html' target='_blank'>GNU GPL v3</a>
				</td>
			</tr>
			</table>
			<?php
			echo $this->pane->endPanel();

			$title = JText::_('Support_us');
			echo $this->pane->startPanel($title, 'supportus');
			?>
			<table class='adminlist'>
			<tr>
				<td>
					<p><?php echo JText::_('COM_J2XMLIMPORTER_MSG_DONATION1'); ?></p>
					<div style="text-align: center;">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_donations">
							<input type="hidden" name="business" value="info@eshiol.it">
							<input type="hidden" name="lc" value="en_US">
							<input type="hidden" name="item_name" value="eshiol.it">
							<input type="hidden" name="currency_code" value="EUR">
							<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
							<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal secure payments.">
							<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div>
					<p><?php echo JText::_('COM_J2XMLIMPORTER_MSG_DONATION2'); ?></p>
				</td>
			</tr>
			</table>
			<?php 
			echo $this->pane->endPanel();
			
			echo $this->pane->endPane();
			?>
		</td>
    </tr>
</table>
<form action="index.php" method="post" name="adminForm">
	<input type="hidden" name="option" value="com_j2xmlimporter" />
	<input type="hidden" name="c" value="website" />
	<input type="hidden" name="view" value="cpanel" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>
