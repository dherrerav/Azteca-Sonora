<?php

/**
* Default template
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

$news_amount = $this->content['news_amount'];

if($this->config['links_position'] != 'bottom' && $this->config['news_short_pages'] > 0 && count($news_list_tab) > 0 && $this->config['news_full_pages'] > 0){
	$links_width = $this->config['links_width'];
	$arts_width = 100 - $this->config['links_width'];
}else{
	$links_width = 100;
	$arts_width = 100;
}

?>

<?php if($news_amount > 0) : ?>
	<div class="nspMain<?php if($this->config['autoanim'] == TRUE) echo ' autoanim'; ?><?php if($this->config['hover_anim'] == TRUE) echo ' hover'; ?> nspFs<?php echo $this->config['module_font_size']; ?>" id="nsp-<?php echo $this->config['module_id']; ?>" style="width:<?php echo $this->config['module_width']; ?>%;">
		
		<?php if(($this->config['news_column'] * $this->config['news_rows']) > 0) : ?>
			
			<div class="nspArts<?php echo ' '.$this->config['links_position']; ?>" style="width:<?php echo $arts_width; ?>%;">
			
				<?php if(
						count($news_html_tab) > ($this->config['news_column'] * $this->config['news_rows']) && 
						$this->config['news_full_pages'] > 1 &&
						$this->config['top_interface_style'] != 'none'
						) : ?>
				<div class="nspTopInterface">
					<div>
						<?php if(
									$this->config['top_interface_style'] == 'pagination' || 
									$this->config['top_interface_style'] == 'arrows_with_pagination'
								) : ?>
						<ul class="nspPagination">
							<?php for($i = 0; $i < ceil(count($news_html_tab) / ($this->config['news_column'] * $this->config['news_rows'])); $i++) : ?>
							<li><?php echo $i+1; ?></li>
							<?php endfor; ?>
						</ul>
						<?php endif; ?>
						
						<?php if(
									$this->config['top_interface_style'] == 'arrows' || 
									$this->config['top_interface_style'] == 'arrows_with_pagination' ||
									$this->config['top_interface_style'] == 'arrows_with_counter'
								) : ?>
						<span class="nspPrev"><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_PREV'); ?></span>
						<span class="nspNext"><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_NEXT'); ?></span>
						<?php endif; ?>
						
						<?php if(
									$this->config['top_interface_style'] == 'counter' || 
									$this->config['top_interface_style'] == 'arrows_with_counter'
								) : ?>
						<span class="nspCounter"><strong><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_PAGE'); ?></strong><span></span></span>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			
				<?php for($i = 0; $i < count($news_html_tab); $i++) : ?>
					<?php 
						$class = ''; 
						$style = '';
						if($i >= ($this->config['news_column'] * $this->config['news_rows'])) $class .= ' unvisible';
						if(($i+1) % ($this->config['news_column']) == 1) $style .= 'clear:both;';
					?>
					<div class="nspArt<?php echo $class; ?>" style="width:<?php echo 100 / $this->config['news_column']; ?>%;<?php echo $style; ?>"><div style="padding:<?php echo $this->config['art_padding']; ?>"><?php echo $news_html_tab[$i];?></div></div>
				<?php endfor; ?>	
			</div>
		<?php endif; ?>
		
		<?php if($this->config['news_short_pages'] > 0 && count($news_list_tab) > 0 ) : ?>
		<div class="nspLinksWrap<?php echo ' '.$this->config['links_position']; ?>" style="width:<?php echo $links_width-0.1; ?>%;">
			<div class="nspLinks" style="margin:<?php echo $this->config["links_margin"]; ?>;">
				<?php if(count($news_list_tab) > 0) : ?>
				<ul class="nspList">
					<?php for($j = 0; $j < count($news_list_tab); $j++) : ?>
					<?php echo $news_list_tab[$j]; ?>
					<?php endfor; ?>
				</ul>
				<?php endif; ?>		
				
				<?php if(
						count(($news_list_tab) > $this->config['links_amount']) && 
						$this->config['news_short_pages'] > 1 &&
					 	ceil(floor(count($news_list_tab) / $this->config['links_amount']) / $this->config['links_columns_amount']) >= 1 &&
						$this->config['bottom_interface_style'] != 'none'
						) : ?>
				<div class="nspBotInterface">
					<div>
						<?php if(
									$this->config['bottom_interface_style'] == 'pagination' || 
									$this->config['bottom_interface_style'] == 'arrows_with_pagination'
								) : ?>
						<ul class="nspPagination">
							<?php for($i = 0; $i < ceil(ceil(count($news_list_tab) / $this->config['links_amount']) / $this->config['links_columns_amount']); $i++) : ?>
							<li><?php echo $i+1; ?></li>
							<?php endfor; ?>
						</ul>
						<?php endif; ?>
						
						<?php if(
									$this->config['bottom_interface_style'] == 'arrows' || 
									$this->config['bottom_interface_style'] == 'arrows_with_pagination' ||
									$this->config['bottom_interface_style'] == 'arrows_with_counter'
								) : ?>
						<span class="nspPrev"><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_PREV'); ?></span>
						<span class="nspNext"><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_NEXT'); ?></span>
						<?php endif; ?>
						
						<?php if(
									$this->config['bottom_interface_style'] == 'counter' || 
									$this->config['bottom_interface_style'] == 'arrows_with_counter'
								) : ?>
						<span class="nspCounter"><strong><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_PAGE'); ?></strong><span></span></span>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>	
			</div>
		</div>
		<?php endif; ?>
	</div>
<?php else : ?>
	<p><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_ERROR'); ?></p>
<?php endif; ?>