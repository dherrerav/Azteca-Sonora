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
$source = $this->source;
$items 	= 0;
if(isset($this->items))
	$items 	= $this->items;
	
if(isset($this->allComponents))
	$allComponents 	= $this->allComponents;

$desComponent 	= JRequest::getVar("desComponent");
$sourComponent  = JRequest::getVar("sourComponent"); 
?>
<script language="javascript">
var selectedLink  = 0;
var numberComment = 0;
function checkAll(number, status){  	
	for(i =0; i<number; i++){
		if($("chkParent-" + i).style.display != "none"){
			$("chkParent-" + i).checked = status;
			for(j =0; j < $("chkParent-" + i).value; j++){
				$("chksub-" + i + "-" + j).checked = status;		
			}		
		}
	}
}

function checkAllParent(numberParent, parentID ,numberChildren, status){
	for(i=0; i<numberChildren; i++){
		$("chksub-" + parentID + "-" + i).checked = status;
	}	
		
	if(status == true){
		for(i=0; i<numberParent; i++){
			if($("chkParent-" + i).checked == false){
				break;	
			}
		}
		if(i == numberParent){
			$("chkAll").checked = true;		
		}			
	}else{
		$("chkAll").checked = false;	
	}	
}

function checkAllSub(numberParent, parentID, numberOfChildren, status){
	if(status == true){		
		for(i=0; i<numberOfChildren; i++){
			if($("chksub-" + parentID + "-" + i ).checked == false){
				break;	
			}
		}
		if(i == numberOfChildren){
			$("chkParent-" + parentID).checked = true;
			for(i=0; i<numberParent; i++){
				if($("chkParent-" + i).checked == false){
					break;	
				}
			}
			if(i == numberParent){
				$("chkAll").checked = true;		
			}		
		}			
	}else{
		$("chkParent-" + parentID).checked = false;
		$("chkAll").checked = false;	
	}			
}

function expandComment(id){
	$("trExpanLink-" +id).style.display = "table-row";
	$("a-collapse-" +id).style.display = "block";
	$("a-expand-" +id).style.display = "none";		
}

function collapseComment(id){
	$("trExpanLink-" +id).style.display = "none";
	$("a-expand-" +id).style.display = "block";
	$("a-collapse-" +id).style.display = "none";
}

function isChecked(checked){
	arrayCheckBox = $('adminForm').getElements('input[name^=cid]');
	if(checked == true){			
		for(i=0; i< arrayCheckBox.length; i++){
			if(arrayCheckBox[i].checked == false){
				break;			
			}	
		}
		if(i < arrayCheckBox.length){
			$("chkAll").checked = false;
		}else{
			$("chkAll").checked = true;
		}		
	}else{
		$("chkAll").checked = false;		
	}	
}

function selectArticle(selectedlinks, numberOfComment){		
	selectedLink = selectedlinks;	
	numberComment = numberOfComment; 	
	jaCreatForm('open_content',selectedlinks,600,400,0,0,'<?php echo JText::_("SELECT_AN_ARTICLE");?>',0,'<?php echo JText::_("SUBMIT");?>',0);		
}

function selectItemk2(selectedlinks, numberOfComment){		
	selectedLink = selectedlinks;	
	numberComment = numberOfComment; 
	jaCreatForm('open_k2',selectedlinks,700,400,0,0,'<?php echo JText::_("SELECT_AN_ARTICLE");?>',0,'<?php echo JText::_("SUBMIT");?>',0);		
}



function jSelectArticle_jform_request_id(id, title, object) {
	url = "index.php?option=com_jacomment&view=imexport&tmpl=component&task=getComponent&id=" +id;
	jQuery.ajax({
		   type: "POST",
		   url: url,			   
		   success: function(msg){				
				setValue(id, title, msg);	  	 
		   }
	});			
}

function jSelectItem(id, title, object){
	url = "index.php?option=com_jacomment&view=imexport&tmpl=component&desoption=com_k2&task=getComponent&id=" +id;
	jQuery.ajax({
		   type: "POST",
		   url: url,			   
		   success: function(msg){				
				setValue(id, title, msg);	  	 
		   }
	});		
}

function setValue(id, title, msg){	
	jaFormHideIFrame();	
	
	firstElement = msg.indexOf("---");
	component    = msg.substring(0, firstElement);
	articleLink  = msg.substring(firstElement + 3);			
	$("contentoption-"+selectedLink).innerHTML = component;
	$("title-" +selectedLink).value 	= title;
	$("span-title-" +selectedLink).innerHTML = title;

	$("chkParent-" +selectedLink).disabled = false;
	$("chkParent-" +selectedLink).checked = true;
	
	$("a-title-" +selectedLink).href = "../" + articleLink;

	arraychkParents = $('adminForm').getElements('input[name^=chkParent]');
	
	for(i=0; i< arraychkParents.length; i++){
		if(arraychkParents[i].checked == false){
			break;	
		}			
	}

	if(i == arraychkParents.length){
		$("chkAll").disabled = false;
		$("chkAll").checked = true;
	}	
	
	for(i=0; i< numberComment; i++){
		$("contentid-" +selectedLink + "-" +i).value = id;
		$("contentoption-"+selectedLink + "-" +i).value = component;
		$("title-" +selectedLink + "-" +i).value 	= title;
		$("referer-"+selectedLink + "-" +i).value 	= articleLink;
		
		$("chksub-" +selectedLink + "-" +i).disabled = false;	
		$("chksub-" +selectedLink + "-" +i).checked = true;		
	} 
}
</script>
<?php if($items){?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">	
	<div id="ServiceComments">
		<div class="box">
			<h2>
				<?php echo JText::_('IMPORT_COMMENTS_FROM_DISQUS')?>								
			</h2>
				
			<div class="box_content">
				<ul class="ja-list-checkboxs">
					<li class="row-0 pd10">
							<div class="clr"></div>
							<div id="ja-tabs-content">                        								
								<div id="page-disqus">
									<div class="comments-top">
										<div style="float: left;">
											<?php echo JText::_("SOURCE_COMPONENT")." <b>".$sourComponent."</b>";?>											
										</div>																		
										<div style="float: left;margin-left: 20px;">											
											<?php echo " ".JText::_("DESTINATION_COMPONENT")." <b>".$desComponent."</b>";?>
										</div>																			
										<div style="float: right;">											
											<input type="submit" name="btlSubmit" value="<?php echo JText::_("IMPORT_NOW");?>"/>
										</div>
										<div style="float: right;">											
											<label title="<?php echo JText::_("DELETE_ALL_CURRENT_DISQUS_COMMENTS");?>"><input type="checkbox" value="1" name="deleteDisqusComment"/> <?php echo JText::_("DELETE_ALL_CURRENT_DISQUS_COMMENTS");?></label>
										</div>																	
									</div>
									<?php ?>	
									<table width="100%" border="0" class="tbl tbl_comment" cellpadding="0" cellspacing="0">										
										<tr>
											<td width="4%"><input type="checkbox" name="toggle" value="" id="chkAll" checked="checked" onclick="checkAll(<?php echo count($items); ?>, this.checked);"/></td>
											<td><b><?php echo JText::_("COMMENTS");?></b></td>
											<td width="16%" align="center"><b><?php echo JText::_("DESTINATION_COMPONENT");?></b></td>
											<td width="19%" align="center"><b><?php echo JText::_("TITLE");?></b></td>
											<td width="10%" align="center"><b><?php echo JText::_("SELECT_ARTICLE");?></b></td>
										</tr>
										<?php 
											$i = 0;
											$contentid 		= 0;
											$option    		= "";
											$countComment	= 0;
											$articleLink 	= "";
											$isCheckAll 	= 1;											
											if($desComponent == "com_k2"){	
												include_once JPATH_SITE.DS."components".DS."com_k2".DS."helpers".DS."route.php";
												//die(JPATH_SITE.DS."components".DS."com_k2".DS."helpers".DS."route.php");
											}else if($desComponent == "com_content"){       																															
												require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
												//$route 			= new ContentHelperRoute();
											}
//											/index.php?option=com_k2&view=items&task=element&tmpl=component&object=id											
										?>
										<?php foreach ($items as $key => $value){?>
										<?php 																																														
											$result = $this->getComponentFromAriticle($key);																																																																																				 
											if($result){																																																																							
												$component = $desComponent;
												$title = $result->title;
												$contentid 	= $result->id;										
												//get link of comblog's item
												switch ($desComponent){																								
													case "com_k2":
														//Read more link
														$link = K2HelperRoute::getItemRoute($result->id.':'.urlencode($result->alias),$result->catID.':'.urlencode($result->categoryalias));
														$articleLink=urldecode(JRoute::_($link));														
														break;
													default:
														if(isset($result->name) && $result->name == "MyBlog"){
															$component = "com_myblog";
															
															if(isset($result->title)){
																$title = $result->title;
															}else{
																$title = "";
															}			
															$contentid 	= $result->id;										
															//get link of comblog's item
															$articleLink 	= $this->getMyBlogLink($result->id);																
														}else{
															$component = "com_content";
															if(isset($result->title)){
																$title = $result->title;
															}else{
																$title = "";
															}
															$contentid 	= $result->id; 
															$articleLink= JRoute::_(ContentHelperRoute::getArticleRoute($result->id.":".$result->title,$result->catID.":".$result->catTitle));		
														}																																										
												}
													
																																								
											}
											//not found article
											else{													
												$contentid 		= 0;
												$component 		= "com_content";
												$title	   		= "";
												$articleLink 	= "#";
											}
											if($component == "")
												$isCheckAll =0;
										?>										
										<tr>
											<td><input type="checkbox" id="chkParent-<?php echo $i?>" name="chkParent" value="<?php echo count($value);?>" <?php if($component!=""){?>checked="checked"<?php }else{?> disabled="disabled" <?php }?> onclick="checkAllParent('<?php echo count($items);?>','<?php echo $i;?>', '<?php echo count($value);?>', this.checked)"/></td>
											<td>												
												<?php echo "<a href='". $key ."' target='_blank'>".$key."</a>"."<br />";?>												
												<a style="color: black;font-weight: bold;" id="a-expand-<?php echo $i?>" href="javascript:expandComment('<?php echo $i;?>')">
													<?php echo JText::_("SHOW").JText::_("COMMENT")." (".count($value).")";?>
												</a>
												<a style="color: black;font-weight: bold;display: none;" id="a-collapse-<?php echo $i?>" href="javascript:collapseComment('<?php echo $i;?>')">
													<?php echo JText::_("HIDDEN").JText::_("COMMENT")." (".count($value).")";?>													
												</a>												
											</td>
											<td align="center">	
												<span id="contentoption-<?php echo $i;?>"><?php echo $component;?></span>
											</td>																									
											<td>												
												<?php if($articleLink == "#"){?>
													<a target="_blank" id="a-title-<?php echo $i;?>" href="#"><span id="span-title-<?php echo $i;?>"><?php echo $title;?></span></a>	
												<?php }else{?>
													<a target="_blank" id="a-title-<?php echo $i;?>" href="<?php echo "../".$articleLink;?>"><span id="span-title-<?php echo $i;?>"><?php echo $title;?></span></a>
												<?php }?>												
																								
												<input type="hidden" name="titleComment" id="title-<?php echo $i;?>" value="<?php echo $title;?>"/>																								
											</td>
											<td align="center">												
												<?php if($desComponent == "com_k2"){?>													
													<input type="button" name="btlSelect" value="<?php echo JText::_("SELECT_ITEM_K2");?>" onclick="selectItemk2('<?php echo $i?>', '<?php echo count($value)?>');"/>
												<?php }else{?>		
													<input type="button" name="btlSelect" value="<?php echo JText::_("SELECT");?>" onclick="selectArticle('<?php echo $i?>', '<?php echo count($value)?>');"/>
												<?php }?>
											</td>
										</tr>
										<?php $k = 0;?>
										<tr id="trExpanLink-<?php echo $i;?>" style="display: none;">
											<td></td>
											<td colspan="4">																								
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<?php foreach ($value as $item){?>												
													<tr id="tbl-row-of-comment-<?php echo $i?>-<?php echo $k;?>">
														<td style="border: none;"><?php echo $k +1;?></td>
														<td style="border: none;"><input type="checkbox" value="<?php echo $countComment;?>" name="chkComment[]" id="chksub-<?php echo $i;?>-<?php echo $k;?>" <?php if($component!=""){?>checked="checked"<?php }else{?> disabled="disabled" <?php }?> onclick="checkAllSub('<?php echo count($items);?>' , '<?php echo $i;?>', '<?php echo count($value);?>', this.checked)"/></td>
														<td width="90%" style="border: none;">
															<?php echo $item["message"]?>
															<input type="hidden" id="contentoption-<?php echo $i;?>-<?php echo $k;?>" name="contentoption[]" value="<?php echo $component?>"/>
															<input type="hidden" id="contentid-<?php echo $i;?>-<?php echo $k;?>" name="contentid[]" value="<?php echo $contentid?>"/>
															<input type="hidden" id="title-<?php echo $i;?>-<?php echo $k;?>" name="title[]" value="<?php echo $title?>"/>															
															<input type="hidden" id="referer-<?php echo $i;?>-<?php echo $k;?>" name="referer[]" value="<?php echo $articleLink;?>"/>
															<input type="hidden" name="comment[]" value="<?php echo $item["message"];?>"/>
															<input type="hidden" name="name[]" value="<?php echo $item["name"];?>"/>
															<input type="hidden" name="email[]" value="<?php echo $item["email"];?>"/>
															<input type="hidden" name="website[]" value="<?php echo $item["url"];?>"/>
															<input type="hidden" name="date[]" value="<?php echo $item["date"];?>"/>
															<input type="hidden" name="ip_address[]" value="<?php echo $item["ip_address"];?>"/>
															<input type="hidden" name="voted[]" value="<?php echo $item["points"];?>"/>																																																																																	
														</td>														
													</tr>
													<?php if($k < (count($value)-1)){?>
														<tr><td colspan="3" height="1" style="margin: 0;padding: 0;border-bottom: 0;"></td></tr>
													<?php }?>
													<?php $k++;?>
													<?php $countComment++;?>
												<?php }//end for 2?>
												</table>												
											</td>
										</tr>																			
										<?php $i++;?>
										<?php }//end for 1?>
										<?php if($isCheckAll == 0){?>
											<script language="javascript">
												$("chkAll").checked  = false;
												$("chkAll").disabled = true;
											</script>
										<?php }?>																																							
									</table>
									<div class="comments-top">																																
										<div style="float: right;"><input type="submit" name="btlSubmit" value="<?php echo JText::_("IMPORT_NOW");?>"/></div>
									</div>		
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
<input type="hidden" name="task" value="saveImportComment" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>	
</form>
<?php }?>