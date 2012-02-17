<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<?php if($enableSortingOptions && $this->totalAll >0) { ?>
<div id="jac-sort">
	<?php echo JText::_("SORT_BY");?>:&nbsp;
	<a href="javascript:sortComment('date',this)"  <?php if($defaultSort == "date"){ if($defaultSortType == "ASC"){ echo 'class="jac-sort-by-active-asc"';echo ' title="' . JText::_("LATEST_COMMENT_ON_TOP").'"';}else{echo 'class="jac-sort-by-active-desc"';echo ' title="'.JText::_("LATEST_COMMENT_IN_BOTTOM").'"';}}else{echo 'class="jac-sort-by"';echo ' title="'. JText::_("LATEST_COMMENT_ON_TOP").'"';}?> id="jac-sort-by-date"><?php echo JText::_("DATE");?></a>&nbsp;
	<a href="javascript:sortComment('voted',this)" <?php if($defaultSort == "voted"){ if($defaultSortType == "ASC"){ echo 'class="jac-sort-by-active-asc"';echo ' title="' . JText::_("MOST_RATED_ON_TOP").'"';}else{echo 'class="jac-sort-by-active-desc"';echo ' title="' . JText::_("MOST_RATED_IN_BOTTOM").'"';}}else{echo 'class="jac-sort-by"';echo ' title="'. JText::_("MOST_RATED_ON_TOP").'"';}?> id="jac-sort-by-voted"><?php echo JText::_("RATING");?></a>&nbsp;						
</div>
<?php }?>
<?php if($defaultSort){?>
	<input type="hidden" value="<?php echo $defaultSort;?>" id="orderby" name="orderby" />			
<?php }?>