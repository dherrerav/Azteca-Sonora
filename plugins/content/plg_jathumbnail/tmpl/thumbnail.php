<?php
/*
# ------------------------------------------------------------------------
# JA Thumbnail plugin for Joomla 1.6.x
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/

$align = $this->pluginParams->get('content_mode-auto-manual-content_align', 'left');
?>
<div class="ja-thumbnailwrap thumb-<?php echo $align?>" style="width: <?php echo $width?>px;">
	<div class="ja-thumbnail clearfix">
	<?php 
	$i = 0;
	foreach ($images as $image) : 
	$i++
	?>
		<div class="thumbnail" <?php if ($i==1):?>style="position:relative;z-index:2"<?php endif;?>>
			<?php if (class_exists('plgSystemPlg_JAPopup')):?>		
			{japopup type="image" content="<?php echo $image['org_src'];?>" title="" group="group"}
			<?php endif; ?>

			<?php echo $image['new']."\n";?>

			<?php if (class_exists('plgSystemPlg_JAPopup')):?>		
			{/japopup}		
			<?php endif; ?>
		</div>
	<?php endforeach;?>
	</div>
	<?php if (count($images)>1):?>
	<ul class="nav clearfix">
		<li class="prev"><?php echo JText::_('Prev')?></li>
		<li class="counter"><?php echo JText::sprintf('<span class="item">%d</span> of <span class="total">%d</span>',1,count($images))?></li>
		<li class="next"><?php echo JText::_('Next')?></li>
	</ul>
	<?php endif;?>	
</div>

<?php if (count($images)>1):?>	
<script type="text/javascript">
var JAThumbnail = new Class({
	initialize: function(wrapper){
		this._next = wrapper.getElements('.next');
		this._prev = wrapper.getElements('.prev');
		this._counter = wrapper.getElement ('.counter .item');
		this._items = wrapper.getElements('.thumbnail');
		this._thumbbox = wrapper.getElement('.ja-thumbnail');
		this._curr = 0;
		if (!this._items || this._items.length <= 1) return;
		this._firstrun = true;
		
		this._items[this._curr].setStyle('opacity', 1);
		this._items.each(function(item,i){
			if (i != this._curr) this._items[i].setStyles({'opacity':0});
		}.bind(this));
		
		if (this._next) {
			this._next.addEvent('click', function (){
				this.firstrun();			
				var next = this._curr < this._items.length-1?this._curr+1:0;
				if (this.fx) this.fx.pause();
				this.fx = new Fx.Elements([this._items[this._curr],this._items[next],this._thumbbox]);
				var h1 = this._thumbbox.getCoordinates().height;
				var h2 = this._items[next].getCoordinates().height;
				this.fx.start ({'0':{'opacity':[0]},'1':{'opacity':[1]},'2':{'height':[h2]}});
				this._curr = next;
				this._counter.innerHTML = this._curr + 1;
			}.bind(this));
		}
		if (this._prev) {
			this._prev.addEvent('click', function (){
				this.firstrun();			
				var next = this._curr > 0?this._curr-1:this._items.length-1;
				if (this.fx) this.fx.pause();
				this.fx = new Fx.Elements([this._items[this._curr],this._items[next], this._thumbbox]);
				var h1 = this._thumbbox.getCoordinates().height;
				var h2 = this._items[next].getCoordinates().height;
				this.fx.start ({'0':{'opacity':[0]},'1':{'opacity':[1]},'2':{'height':[h2]}});
				this._curr = next;
				this._counter.innerHTML = this._curr + 1;
			}.bind(this));
		}
	},
	firstrun: function() {
		if (this._firstrun) {
			var coor = this._items[this._curr].getCoordinates();
			this._thumbbox.setStyles ({'width':coor.width, 'height': coor.height});
			this._items.setStyle ('position', 'absolute');
			this._firstrun = false;
		}
	}
});
$$('.ja-thumbnailwrap').each(function(wrapper){
	new JAThumbnail (wrapper);
});
</script>
<?php endif;?>	