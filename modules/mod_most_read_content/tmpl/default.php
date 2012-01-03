<?php 

// no direct access
defined('_JEXEC') or die('Restricted access');
if ( $items ) {
?>
<table border="0" cellpadding="5" cellspacing="0" width="100%">
<?php if ( $showheader ) { ?>
  <tr>
    <?php if ( $showleaderboard ) { ?>
		<td class="sectiontableheader<?php echo $moduleclass_sfx; ?>" width="3%"><div align="center">#</div></th>
		<?php } ?>
    <td class="sectiontableheader<?php echo $moduleclass_sfx; ?>"><div align="left"><?php echo JText::_('LABEL_TITLE'); ?></div></th>
    <?php if ( $section ) { ?>
    <td class="sectiontableheader<?php echo $moduleclass_sfx; ?>" width="15%"><div align="left"><?php echo JText::_('LABEL_SECTION'); ?></div></th>
    <?php } ?>
    
    <?php if ( $category ) { ?>
    <td class="sectiontableheader<?php echo $moduleclass_sfx; ?>" width="15%"><div align="left"><?php echo JText::_('LABEL_CATEGORY'); ?></div></th>
    <?php } ?>
    
    <?php if ( $author ) { ?>
    <td class="sectiontableheader<?php echo $moduleclass_sfx; ?>" width="15%"><div align="left"><?php echo JText::_('LABEL_AUTHOR'); ?></div></th>
    <?php } ?>

    <?php if ( $hits ) { ?>
    <td class="sectiontableheader<?php echo $moduleclass_sfx; ?>" width="6%"><div align="left"><?php echo JText::_('LABEL_HITS'); ?></div></th>
    <?php } ?>
  </tr>
<?php } ?>
<?php
	$i = 1;
    $k = 0;
	foreach ($items as $item) { ?>
	<tr>
		<?php if ( $showleaderboard ) { ?>
		<td class="sectiontableentry<?php echo $k; ?>"><div align="center"><?php echo $i; ?></div></td>
		<?php } ?>
		<td align="left">
			<a href="<?php echo $item->href; ?>">
				<?php echo $item->title; ?>
			</a>
		</td>
		<?php if ( $section ) { ?>
		<td align="left">
			<?php echo $item->section; ?>
		</td>
		<?php } ?>
		<?php if ( $category ) { ?>
		<td align="left">
			<?php echo $item->category; ?>
		</td>
		<?php } ?>
		<?php if ( $author ) { ?>
		<td align="left">
			<?php echo $item->author; ?>
		</td>
		<?php } ?>
		<?php if ( $hits ) { ?>
		<td align="left">
			<?php echo $item->hits; ?>
		</td>
		<?php } ?>
	</tr>
<?php
		$i++;
        $k = 1 - $k;
 	 }
?>
</table>
<?php
} 
?>