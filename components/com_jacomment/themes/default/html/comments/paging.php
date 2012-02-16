<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php global $option;//print_r($this->pagination);exit;?>
<div class="jac-display-limit">
	<?php if($this->pagination->total>0){?>
		<label for="list"><?php echo JText::_("DISPLAY")?> # </label>
		<?php echo $this->getListLimit($this->lists['limitstart'], $this->lists['limit'], $this->lists['order']); ?>
	<?php }?>
</div>
<div class="jac-page-links" id="jav-page-links-comment">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>