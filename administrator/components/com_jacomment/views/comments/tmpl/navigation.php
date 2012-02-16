<?php
	defined('_JEXEC') or die('Restricted access');
	$option	= JRequest::getCmd('option');
?>
<ul class="javtabs-title">
    <li class="jav-mainbox_99 first loaded active" id="jav-typeid_99">    
        <a class="jav-mainbox-99" id="tab-comment_99" title="<?php echo JText::_("SHOW_ALL"); ?>" href="index.php?option=<?php echo $option;?>&amp;view=comments&amp;curenttypeid=99&amp;layout=comments&amp;tmpl=component&amp;keyword=<?php echo $keyword;?>&amp;reported=<?php echo $reported;?>&amp;optionsearch=<?php echo $this->searchComponent; ?>&amp;sourcesearch=<?php echo $this->searchSource; ?>">
            <?php echo JText::_( 'All' ); ?>&nbsp;(<span id='number-of-tab-99'><?php echo $totalAll; ?></span>)
        </a>
    </li>
    <li class="jav-mainbox_0" id="jav-typeid_0">				
		<a class="jav-mainbox-0" id="tab-comment-0" title="<?php echo JText::_("SHOW_UNAPPROVE"); ?>" href="index.php?option=<?php echo $option;?>&amp;view=comments&amp;curenttypeid=0&amp;layout=comments&amp;tmpl=component&amp;keyword=<?php echo $keyword;?>&amp;reported=<?php echo $reported;?>&amp;optionsearch=<?php echo $this->searchComponent; ?>&amp;sourcesearch=<?php echo $this->searchSource; ?>">
			<?php echo JText::_( 'Unapproved' );?>&nbsp;(<span id='number-of-tab-0'><?php echo $totalUnApproved; ?></span>)
		</a>
	</li>						
	<li class="jav-mainbox_1" id="jav-typeid_1">
		<a class="jav-mainbox-1" id="tab-comment-1" title="<?php echo JText::_("SHOW_APPROVED"); ?>" href="index.php?option=<?php echo $option;?>&amp;view=comments&amp;curenttypeid=1&amp;layout=comments&amp;tmpl=component&amp;keyword=<?php echo $keyword;?>&amp;reported=<?php echo $reported;?>&amp;optionsearch=<?php echo $this->searchComponent; ?>&amp;sourcesearch=<?php echo $this->searchSource; ?>">	
			<?php echo JText::_( 'Approved' ); ?>&nbsp;(<span id='number-of-tab-1'><?php echo $totalApproved;?></span>)
		</a>
	</li>
	<li class="jav-mainbox_2 last" id="jav-typeid_2">				
		<a  class="jav-mainbox-2" id="tab-comment-2" title="<?php echo JText::_("SHOW_SPAM"); ?>" href="index.php?option=<?php echo $option;?>&amp;view=comments&amp;curenttypeid=2&amp;layout=comments&amp;tmpl=component&amp;keyword=<?php echo $keyword;?>&amp;reported=<?php echo $reported;?>&amp;optionsearch=<?php echo $this->searchComponent; ?>&amp;sourcesearch=<?php echo $this->searchSource; ?>">
			<?php echo JText::_( 'Spam' ); ?>&nbsp;(<span id='number-of-tab-2'><?php echo $totalSpam; ?></span>)
		</a>
	</li>
</ul>