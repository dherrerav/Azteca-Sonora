<?php
/**
 # mod_meganews - Mega News Module for Joomla! 1.6
 # author 		OmegaTheme.com
 # copyright 	Copyright(C) 2011 - OmegaTheme.com. All Rights Reserved.
 # @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Website: 	http://omegatheme.com
 # Technical support: Forum - http://omegatheme.com/forum/
**/
/**------------------------------------------------------------------------
 * file: default.php 1.6.0 00001, April 2011 12:00:00Z OmegaTheme $
 * package:	 Mega News Module
 *------------------------------------------------------------------------*/
//No direct access!
defined('_JEXEC') or die;  ?>

<div class="mega_news">
	<div class="mega_news_i">
		<?php $i = 1 ; ?>
		<?php foreach($list_all as $list) : ?>
			<?php  $index = 0 ; ?>
			<div class="blog-news col-<?php echo $params->get('column') . '-' . $i++ ?>" style="width:<?php echo number_format(98/$params->get('column'), 1); ?>%;">
				<div class="blog-news-i">
					<?php foreach ($list as $index=>$item) :  ?>
						<?php if ($index === 0) { ?>
							<!-- Show title and link of Category -->
							<?php if($params->get('show_category_title')) : ?>
								<?php if($params->get('enable_category_link')) { ?>
									<h1 class="cat_title"><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)) ; ?>"><?php echo $item->category_title ;?></a></h1>
								<?php } else { ?>
									<h1 class="cat_title"><?php echo $item->category_title ;?></h1>
								<?php } ?>
							<?php endif ; ?>
							<!-- End -->
							<div class="first-item">
								<!-- Show Titles -->
								<div class="mega_head_title">
									<a href="<?php echo $item->link; ?>" class="head_title"><?php echo $item->title; ?></a>	
							   </div>
								<!-- Show thumbnails -->
								<?php if($params->get('showthumbnails_head_item') == 1){?>
									<div class="meganews_thumbs"  style="width:<?php echo $params->get('thumbwidth')?>px; height:<?php echo $params->get('thumbheight')?>px;">
										<div class="meganews_thumbs_i"  style="width:<?php echo $params->get('thumbwidth')?>px; height:<?php echo $params->get('thumbheight')?>px;">
											 <?php 	if($params->get('enablelinkthumb') == 1) {?>
													<a href="<?php echo $item->link; ?>"><?php echo $item->thumbnails ; ?></a>
											<?php } else { ?>	
													<?php echo $item->thumbnails ; ?>
											 <?php }?>
										</div>
									</div>
								<?php } else { ?>
									<?php echo ''; ?>
								<?php } ?>
								<!-- End -->
							   <!-- Show Content -->
								<div class="mega_content">	<?php echo $item->content; ?></div>
								<!-- Show Readmore of Head item -->
								 <?php if($params->get('readmore_head_item') == 1) {?>
								<div class="meganews_readmore"><a href="<?php echo $item->link; ?>" class="mega_readm"><?php echo JText::_('READMORE') ?></a></div>
								<?php }else {?>
									<?php echo ''; ?>
								<?php } ?>
								<!-- End -->
							</div>
						<?php } ?>
					<?php endforeach; ?>
					<ul class="meganews-more-item">
						<?php foreach ($list as $index=>$item) :  ?>
							<?php if ($index != 0) { ?>
								<li class="<?php echo 'item-' . $index++ ; ?>"><a href="<?php echo $item->link; ?>" class="title"><?php echo $item->title; ?></a></li>
							<?php } ?>
						<?php endforeach; ?>
					</ul>
					<?php if ($i > $params->get('column')) $i = 1 ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>