<?php
defined('_JEXEC') or die('Restricted access');
$display=FALSE;
JHTML::_('behavior.tooltip'); 
$item = $this->item;

global $jacconfig;
//if($jacconfig['layout']->get('enable_smileys')==1){
//    $showSmileys = $this->showSmileys('plugin_embed_reply', ''.$this->id.'');  
//}
//if($jacconfig['layout']->get('enable_after_the_deadline')==1){
//    $this->showAfterDeadLineLink('plugin_embed');  
//}
//if($jacconfig['layout']->get('enable_youtube')==1){
//    $this->showYouTubeLink('plugin_embed');  
//}
$helper = new JACommentHelpers();

$isEnableAutoexpanding 		= $jacconfig["comments"]->get("is_enable_autoexpanding", 0);
$isEnableEmailSubscription  = $jacconfig["comments"]->get("is_enable_email_subscription", 0);
$isAttachImage 				= $jacconfig["comments"]->get("is_attach_image", 0);
$totalAttachFile			= $jacconfig['comments']->get('total_attach_file', '5');	
?>			
	<div id="jac-quick-reply" class="clearfix">			
		<span class="jac-text-reply"><?php echo JText::_("REPLY_TO").$this->replyTo;?></span>
	    <div id="plugin_embed">
        <?php 
        if($jacconfig['layout']->get('enable_smileys', 0)==1){
            echo $showSmileys = $this->showSmileys('plugin_embed', $this->id);  
        }
        ?>
        
        <?php if($jacconfig['layout']->get('enable_youtube')==1){ ?>
            <script language="javascript" type="text/javascript">
            function open_youtube(id){
                jaCreatForm('open_youtube',id,340,200,0,0,'<?php echo JText::_("EMBED_A_YOUTUBE_VIDEO");?>',0,'<?php echo JText::_("EMBED_VIDEO");?>');
            }
            </script>
            <a href="javascript:open_youtube(<?php echo $this->id;?>);" class="plugin"><img title="Add a YouTube Video" alt="YouTube" src="http://www.youtube.com/favicon.ico"/> <span style="display: none;"><?php echo JText::_("EMBED_VIDEO");?></span></a>
        <?php } ?>
        
        <?php if($jacconfig['layout']->get('enable_after_the_deadline', 0)==1){ ?>
            <a href="javascript:jac_check_atd('')"><img title="Proofread Comment After the Deadline" alt="AtD" src="http://www.polishmywriting.com/atd_jquery/images/atdbuttontr.gif"/> <span id="checkLink"><?php echo JText::_("CHECK_SPELLING"); ?></span></a>
        <?php } ?>
        <?php if($jacconfig['layout']->get('enable_bbcode', 0)==1){ echo $this->showBBCode();}?>
        </div>
		<div>		
			<div class="clearfix">								
				<textarea class = 'tinymce' rows="" cols="" id ='newcomment' name='newcomment' style="width: 100%;"></textarea>
				<?php if($isEnableAutoexpanding){?>
	            <script type="text/javascript">
		            jQuery(document).ready( function($) {					
				    	   jQuery('textarea#newcomment').autoResize({
				    		    // On resize:
				    		    onResize : function() {
				    		        $(this).css({opacity:0.8});
				    		    },
				    		    // After resize:
				    		    animateCallback : function() {
				    		        $(this).css({opacity:1});
				    		    },
				    		    // Quite slow animation:
				    		    animateDuration : 300,
				    		    // More extra space:
				    		    extraSpace : 40
				    		});
				       });
	            </script>				    
	            <?php }?>
				<?php if($jacconfig['layout']->get('enable_bbcode', 0)==1){?>
	            <script type="text/javascript">			     
			     	DCODE.setTags (["LARGE", "MEDIUM", "HR", "B", "I", "U", "S", "UL", "OL", "SUB", "SUP", "QUOTE", "LINK", "IMG", "YOUTUBE", "HELP"]);			     			     
			     	DCODE.activate ("newcomment");			     
			   	 </script>
				 <?php }?>  		
			</div>
			<br />
			<div class="err" style="color:red;" id="err_newcomment"></div>									
			<?php if($isEnableEmailSubscription){?>								
				
				<div class="jac-subscribe clearfix">
					<span class="jac-text-blow-guest"> <?php echo JText::_("SUBSCRIBE_TO"); ?></span>&nbsp;
					<?php
						$listSubscribe = array();$listSubscribe[0] = JHTML::_('select.option','0',JText::_("NONE"));$listSubscribe[1] = JHTML::_('select.option','1',JText::_('REPLIES'));$listSubscribe[2] = JHTML::_('select.option','2',JText::_('NEW_COMMENTS'));													
						echo JHTML::_('select.genericlist', $listSubscribe, 'subscription_type',null,'value','text', 0);															
					?>										
				</div>
				<br />			
			<?php }?>		
			<!-- END -  EMAIL SUBSCRIPTION -->	
										
		</div>
	</div>
<?php if($isAttachImage){	
	if(isset($_SESSION['countreply'])){
		unset($_SESSION['countreply']);	
	}
	if(isset($_SESSION['tempreply'])){
		unset($_SESSION['tempreply']);	
	}	
	   if(isset($_SESSION['nameFolderreply'])){
		unset($_SESSION['nameFolderreply']);	
	}	
?>
	<form id="formreply" name="formreply" class="wufoo" autocomplete="off" enctype="multipart/form-data" method="post" action="index.php">
		<div>
			<span class="jac-text-reply"><?php echo JText::_("ATTACHED_FILE");?></span>
		</div>
		<div>
			<input name="myfile" id="myfile" type="file" size="30"  onblur="changeBackgroundNone(this)"  onchange="startReplyUpload(1);"  class="field file" tabindex="5" onfocus="changeBackground(this)" />
			<span id="upload_process_1_reply" style="margin-top:-20px; float:right; display:none"><img src="components/com_jacomment/asset/images/loading.gif" alt=""/></span>
			<div class="small" style="font-size:10px">(<?php echo JText::_("TOTAL");?><?php echo $totalAttachFile; ?> <?php if($totalAttachFile >1){ echo JText::_("FILES_MAX_SIZE").'<B>'.$helper->getSizeUploadFile().'</B>';}else{echo JText::_("FILE_MAX_SIZE").'<B>'.$helper->getSizeUploadFile().'</B>';}?>)</div>
			<div id="result_upload_reply"></div>		
			<div class="err" style="color:red;" id="err_myfile_reply" name="err_myfile_reply"></div>
			<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>											 
		</div>	
	</form>	
<?php }//end allow attach image?>
<div style="width: 100%;" class="lst_btn clearfix">
		<div style="float: right;">
			<a href="javascript:cancelReplyComment('<?php echo $this->curentTypeID;?>')" class="btn btn_cancel"><?php echo JText::_("CANCEL");?></a>
			<input type="button" onclick="saveReplyComment('<?php echo $this->curentTypeID;?>')" name="postReplyComment" class="btn btn_save" value="<?php echo JText::_("SAVE");?>">
		</div>		
</div>