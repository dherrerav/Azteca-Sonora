<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
//if load editor for edit comment
$prefix = "";
$contentComment = "";
$textAreaID		= "newcomment";
$itemID	= '';
$allowUploadSubscription 	= 1;
if(isset($this->item)){
	$prefix = "edit";
	$maxLength = $this->maxLength;
	$contentComment = substr($this->item->comment, 0, $maxLength);
	$textAreaID	= "newcommentedit";
	$itemID	= $this->item->id;	
		
	$userInfo   = JFactory::getUser($this->item->userid);
	$curentUser = JFactory::getUser();	
		
	if($userInfo->id != $curentUser->id){
		$allowUploadSubscription = 0;		
	}		
	
	if($this->isAttachImage){
		$target_path =  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$this->id;
		$listFiles = "";
		if(is_dir($target_path))
			$listFiles   =  JFolder::files($target_path);	
	}		
}
?>	          	    
<!-- BEGIN - Add jacSmileys- Add youTube - check spelling -->
	<?php if($enableSmileys || $enableAfterTheDeadline || $enableBbcode || $enableYoutube ||$isAttachImage){?>
       <div class="plugin_embed form-actions clearfix">
       	<ul class="jac-wrapper-actions">			        								    
    	    <?php if($enableSmileys){
    	    		echo "<li class='form-act-smiley'>";    	    			
    	    			require_once $helper->jaLoadBlock("comments/smiley.php");
    	    		echo "</li>";
    	    	}
    	    ?>			    	    
    	    <?php if($enableAfterTheDeadline){?>
		    	<li class='form-act-spell'><a id="checkLink<?php echo $prefix;?>" href="javascript:jac_check_atd('<?php echo $prefix;?>')" title="<?php echo JText::_("CHECK_SPELLING"); ?>"></a></li>			         
		    <?php } ?>
			    	    	            
		    <?php if($enableYoutube){ ?>
		    	<li class="form-act-utube">			        
	                <a href="javascript:open_youtube('<?php echo $itemID;?>');" class="plugin" title="<?php echo JText::_("EMBED_VIDEO");?>"><span><?php echo JText::_("EMBED_VIDEO");?></span></a>
	            </li>
		    <?php } ?>
					    
		    <?php if($isAttachImage && ($allowUploadSubscription || $listFiles)){?>
		    	<li class="form-act-attach">						    				    		
		    		<a href="javascript:openAttachFile('<?php echo $itemID;?>');" class="plugin" title="<?php echo JText::_("ATTACH_FILE");?>"><span><?php echo JText::_("ATTACH_FILE");?></span></a>							    		
		    	</li>
		    <?php }?>
					    			    				    				    							    
			<!--  BEGIN - BBCODE -->				
		    <?php if($enableBbcode){		    		
		    		//echo "<li class='form-act-bbcode'>";
		    			require_once $helper->jaLoadBlock("comments/bbcode.php");
		    		//echo "</li>";
		   	}?>
		    <!--  END - BBCODE -->		    
		</ul>	 		
	</div>
	<?php }?> 
<!-- END - Add jacSmileys- Add youTube - check spelling -->
<!-- BEGIN - Text area  -->    
	<div id="jac-container-textarea<?php echo $prefix; ?>" class="form-comment clearfix">		
		<?php //if you want set text of name in field comment, 
			  //you must set class jac-inner-text for texare and add same text in hidden's id jac_hid_text_comment
			  //and copy this code in textare:
			  //if($prefix == ""){echo JText::_("TEXT_COMMENT");}else{echo $contentComment;}
		?>															  
		<textarea <?php if($isEnableAutoexpanding){?>style="overflow-y: hidden;"<?php }?> onblur="checkWordLength(this.value,'<?php echo $textAreaID;?>', 'jaCountText<?php echo $prefix;?>')" class="field textarea jac-new-comment jac-expand-field" rows="12" cols="80" tabindex="1" id="newcomment<?php echo $prefix; ?>" name="newcomment"><?php echo $contentComment;?></textarea>
		<?php if($enableBbcode){?>
			<script type="text/javascript">
				DCODE.setTags (["LARGE", "MEDIUM", "HR", "B", "I", "U", "S", "UL", "OL", "SUB", "SUP", "QUOTE", "LINK", "IMG", "YOUTUBE", "HELP"]);
				DCODE.activate ("<?php echo $textAreaID;?>");
			</script>
		<?php }?>	              	            
		<?php if($isEnableAutoexpanding){?>	 
			<script type="text/javascript">											     
				jQuery(document).ready( function($) {jQuery('textarea#newcomment<?php echo $prefix; ?>').autoResize({onResize : function() {$(this).css({opacity:0.8});},animateCallback : function() {$(this).css({opacity:1});},animateDuration : 300,extraSpace : 40,limit:300});});				
			</script>		    
		<?php }?>				
	</div>		           	    
	<?php if($prefix == ""){?><input type="hidden" id="jac_hid_text_comment" value="<?php echo JText::_("TEXT_COMMENT");?>"/><?php }?>     					
<!-- END - Text area  -->									        