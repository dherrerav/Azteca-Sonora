<?php 
/**
 * @version		$Id: default.php 13 2009-07-07 22:23:18Z dextercowley $
 * @package		mod_fj_related_plus
 * @copyright	Copyright (C) 2008 Mark Dexter. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
$showDate = $params->def('showDate', 'none') != 'none';
$showCount = $params->def('showMatchCount', 0);
$showMatchList = $params->def('showMatchList', 0);
$dateFormat = $params->def('date_format', JText::_('DATE_FORMAT_LC4'));
$showTooltip = $params->get('show_tooltip', '1');
$titleLinkable = $params->get('fj_title_linkable'); ?>

<?php if ($subtitle) : ?> 
	<p class="relateditems<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php echo $subtitle; ?></p><br />
<?php endif; ?> 
<?php if (count($list)) : ?>
	<ul class="relateditems<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php foreach ($list as $item) : ?>
		<li>
		<?php if (($showTooltip) && ($titleLinkable)) : ?>
			<a href="<?php echo $item->route; ?>" class="fj_relatedplus<?php echo $params->get('moduleclass_sfx'); ?>">
			<span class="hasTip" title="<?php echo htmlspecialchars($item->title);?>::<?php echo $item->introtext; ?>">
			<?php echo $item->title; 
			if ($showDate) echo ' - ' . JHTML::_('date', $item->date, $dateFormat);
			if ($showCount) {
				echo ($item->match_count == 1) ? ' (1 '. JText::_('match') . ')' : 
					' (' . $item->match_count . ' ' . JText::_('matches') . ')';
			} ?>
			</span></a>	
		<?php endif; ?>
		<?php if (!($showTooltip) && ($titleLinkable)) :?>
			<a href="<?php echo $item->route; ?>" class="fj_relatedplus<?php echo $params->get('moduleclass_sfx'); ?>">
		 	<?php echo $item->title; 
			if ($showDate) echo ' - ' . JHTML::_('date', $item->date, $dateFormat);
			if ($showCount) {
				echo ($item->match_count == 1) ? ' (1 '. JText::_('match') . ')' : 
					' (' . $item->match_count . ' ' . JText::_('matches') . ')';
			} ?>
			</a>
		<?php endif; ?>

		<?php if (($showTooltip) && !($titleLinkable)) : ?>
			<span class="fj_relatedplus<?php echo $params->get('moduleclass_sfx'); ?>">
			<span class="hasTip" title="<?php echo htmlspecialchars($item->title);?>::<?php echo $item->introtext; ?>">
			<?php echo $item->title; 
			if ($showDate) echo ' - ' . JHTML::_('date', $item->date, $dateFormat);
			if ($showCount) {
				echo ($item->match_count == 1) ? ' (1 '. JText::_('match') . ')' : 
					' (' . $item->match_count . ' ' . JText::_('matches') . ')';
			} ?>
			</span></span>	
		<?php endif; ?>	

		<?php if (!($showTooltip) && !($titleLinkable)) : ?>
			<span class="fj_relatedplus<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php echo $item->title; 
			if ($showDate) echo ' - ' . JHTML::_('date', $item->date, $dateFormat);
			if ($showCount) {
				echo ($item->match_count == 1) ? ' (1 '. JText::_('match') . ')' : 
					' (' . $item->match_count . ' ' . JText::_('matches') . ')';
			} ?>
			</span>	
		<?php endif; ?>	

		<?php if($showMatchList) : ?>
			<ul>
			<?php $temp_list = $item->match_list;
				natcasesort($temp_list);
				foreach ($temp_list as $this_keyword) : ?>
					<li> <?php echo $this_keyword; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>