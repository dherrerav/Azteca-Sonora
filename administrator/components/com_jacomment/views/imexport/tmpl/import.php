<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
  
defined('_JEXEC') or die('Retricted Access');

JHTML::_('behavior.tooltip');
JHTML::_('behavior.switcher');
$group 	= $this->group;
$source = $this->source;
?>
<script language="javascript">
function import2(source, type){  
	frm = document.adminForm;    
    frm.source.value = source;
    frm.type.value = type;
    frm.action = "index.php?option=com_jacomment&view=imexport&group=import";
    frm.submit();
} 

function disableErrorImport(id, status){
	$(id).style.display = status;
}

function showFitterLink(action){
	if(action == "show"){
		$("import-disqus-show").style.display = "none";
		$("import-disqus-hidden").style.display = "block";
		$("fitterLink").style.display = "block";
		$("site_url").name = "site_url";	
		$("site_url").value = "";
	}else{
		$("import-disqus-show").style.display = "block";
		$("import-disqus-hidden").style.display = "none";
		$("fitterLink").style.display = "none";
		$("site_url").name = "";
		$("site_url").value = "";	
	}		
}
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform TopFieldset">
		<?php echo $this->getTabs();?>
	</fieldset>
	<br />
	
	<div id="ServiceComments">
		<div class="box">
			<h2><?php echo JText::_('XML_COMMENTS')?></h2>	
			<div class="box_content">
				<ul class="ja-list-checkboxs">
					<li class="row-0 pd10">
						<div class="tab_list">
							<ul id="ja-tabs">
								<li><a id="intensedebate" <?php if($source == "" || $source == "intensedebate"){?> class="active" <?php }?>><?php echo JText::_('INTENSE_DEBATE')?></a></li>
								<li><a id="disqus" <?php if($source == "disqus"){?> class="active" <?php }?>><?php echo JText::_('DISQUS_COMMENT')?></a></li>								
								<li><a id="jacomment" <?php if($source == "jacomment"){?> class="active" <?php }?>><?php echo JText::_('JACOMMENT')?></a></li>
							</ul>
							<div class="clr"></div>
							<div id="ja-tabs-content">                        
								<div id="page-intensedebate" class="tab">
									<p><?php echo JText::_('SELECT_INTENSE_DEBATE_XML_FILE');?></p>
									<p style="display: block;" id="intensedebate_import">
										<input type="file" name="intensedebate" />
										<input type="button" name="intensedebate_import" class="btn_add import" value="<?php echo JText::_('IMPORT')?>" onclick="javascript:import2('intensedebate', 'xml');"  />
									</p>
								</div>
								<div id="page-disqus" class="tab">
									<p><?php echo JText::_('SELECT_DISQUS_XML_FILE');?></p>									
									<p style="display: block;" id="disqus_import">
										<input type="file" name="disqus" id="select-file-disqus" onchange='disableErrorImport("err-select-disqus","none")'/>										
										<input type="submit" name="disqus_import" class="btn_add import" value="<?php echo JText::_('IMPORT')?>" onclick="return showListCommentFromDisqus('disqus', 'xml');"/>
										<p style="color: red;display: none;" id="err-select-disqus"><?php echo JText::_("YOU_MUST_SELECT_DISQUS_XML_FILE");?></p>																												
										<a href="javascript:showFitterLink('show');" id="import-disqus-show" style="font-weight: bold;" title="<?php echo JText::_("IMPORT_OPTIONS");?>"><?php echo JText::_("SHOW_IMPORT_OPTIONS");?></a>
										<a href="javascript:showFitterLink('hidden');" id="import-disqus-hidden" style="font-weight: bold;display: none;" title="<?php echo JText::_("IMPORT_OPTIONS");?>"><?php echo JText::_("HIDE_IMPORT_OPTIONS");?></a>
										<br/>																						
										<div id="fitterLink">													
											<input type="text" name="site_url" value="" id="site_url"/>
											<p><?php echo JText::_("INPUT_URL_OF_DISQUS_ARTICLE_TO_IMPORT_COMMENTS");?></p>
											<select class="inputbox" name="sourComponent" >
												<?php 
													$listOfComs = $this->getListComponent();													
													foreach ($listOfComs as $list){
														echo '<option value="'.$list.'">'.$list.'</option>';	
													}
												?>																																			
											</select>
											<p><?php echo JText::_("SELECT_SOURCE_COMPONENT");?></p>
											<select class="inputbox" name="desComponent" >
												<?php 
													$listOfComs = $this->getListComponent();													
													foreach ($listOfComs as $list){
														echo '<option value="'.$list.'">'.$list.'</option>';	
													}
												?>																																			
											</select>
											<p><?php echo JText::_("SELECT_DESTINATION_COMPONENT");?></p>											
										</div>   
									</p>
									<div id="list-items-disqus"></div>
								</div>								
								<div id="page-jacomment" class="tab">
									<p><?php echo JText::_('SELECT_JACOMMENT_XML_FILE');?></p>
									<p style="display: block;" id="jacomment_import">
										<input type="file" name="jacomment" />
										<input type="button" name="jacomment_import" class="btn_add import" value="<?php echo JText::_('IMPORT')?>" onclick="javascript:import2('jacomment', 'xml');" />
									</p>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<br />			
	<div id="OtherComment">
		<div class="box">
			<h2><?php echo JText::_('OTHER_COMMENT_COMPONENTS')?></h2>	
			<div class="box_content">
				<ul class="ja-list-checkboxs">
					<li class="row-0 pd10">
						<div class="tab_list">
							<ul id="ja-tabs-other">
								<?php 
								$found = 0;
								$OtherCommentSystem['status'] = false;
								foreach($this->OtherCommentSystems as $OtherCommentSystem) {
									if($OtherCommentSystem['status']) {
										$found++;
								?>
								<li><a id="<?php echo $OtherCommentSystem['code'];?>" <?php if($found==1){?>class="active"<?php } ?>><?php echo $OtherCommentSystem['name'];?></a></li>
								<?php } 
								}
								?>
							</ul>
							<div class="clr"></div>
							<div id="ja-tabs-content-other">                        
								<?php 
								$found_c = 0;
								$OtherCommentSystem['status'] = false;
								foreach($this->OtherCommentSystems as $OtherCommentSystem) {
									if($OtherCommentSystem['status']) {
										$found_c++;
								?>
								<div id="page-<?php echo $OtherCommentSystem['code'];?>" class="tab">
									<p>
										<?php echo JText::_('IMPORT_FROM'). $OtherCommentSystem['name'];?><br />
										<?php echo JText::_('COMMENTS_QUANTITY'). $OtherCommentSystem['total'];?>                    
									</p>
									<p style="display: block;" id="<?php echo $OtherCommentSystem['code'];?>">
										<input type="button" class="btn_add import" name="<?php echo $OtherCommentSystem['code'];?>" value="<?php echo JText::_('IMPORT')?>" onclick="javascript:import2('<?php echo $OtherCommentSystem['code'];?>', '');" <?php if($OtherCommentSystem['total']==0) echo "disabled";?>  />
									</p>
								</div>
								<?php } 
								}
								?>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>                   
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_jacomment" />
<input type="hidden" name="view" value="imexport" />
<input type="hidden" name="task" value="import" />
<input type="hidden" name="group" value="<?php echo $this->group; ?>" />
<input type="hidden" name="cid" value="<?php echo $this->cid; ?>" />
<input type="hidden" name="source" value="" />
<input type="hidden" name="type" value="" />
<?php echo JHTML::_( 'form.token' ); ?>	
</form>
<script>
window.addEvent('domready', function(){
    toggler = $('ja-tabs');
    element = $('ja-tabs-content');
    if(element) {
        document.switcher = new JSwitcher(toggler, element);
    }
     
    toggler2 = $('ja-tabs-other');
    element2 = $('ja-tabs-content-other');
    if(element2) {
        document.switcher = new JSwitcher(toggler2, element2);
    }
});
</script>