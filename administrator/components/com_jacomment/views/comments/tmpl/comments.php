<?php 
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/

if (isset($_COOKIE['jac-status-comment'])) {	
	$arrayJaCommentCokie 	= explode("-", $_COOKIE['jac-status-comment']); 	
}
$session = &JFactory::getSession();
$jaActiveComments = $session->get("jaActiveComments");
$app = JFactory::getApplication();
?>
	<?php if($items){?>
		<div class="comments-top">		
			<div class="comments-top-left"><label for="checkAll<?php echo $currentTypeID;?>"><input type="checkbox" name="toggle" id="checkAll<?php echo $currentTypeID;?>" value="" onclick="checkAllComment(<?php echo $this->count_items;?>,this.checked);" /> <?php echo JText::_("SELECT_ALL_COMMENTS");?></label></div>
			<div class="comments-top-middle"><a href="javascript:performExpandOrCollapse('<?php echo $currentTypeID;?>')" id="expandOrCollapse<?php echo $currentTypeID;?>" title="<?php echo JText::_("EXPAND_OR_COLLAPSE_ALL_COMMENTS");?>">[+] <?php echo JText::_('EXPAND_ALL_COMMENTS'); ?></a></div>
			<div class="comments-top-right">
				<?php 
					$sortType = 'DESC';
					if(isset($this->sortType)){
						$sortType = $this->sortType;
					}				
				?>
				<?php if($sortType == 'DESC'){?>
					<span style="display: none;" class="jac_span_sort_by_oldest" id="jac_span_sort_comment">
						<?php echo JText::_("SORT_BY_RECENT"); ?>					
					</span>
					<a href="javascript:sortComment('ASC','<?php echo JText::_("SORT_BY_OLDEST"); ?>','<?php echo JText::_("SORT_BY_RECENT"); ?>')" class="jac_sort_by_oldest" id="jac_sort_comment">
						<?php echo JText::_("SORT_BY_RECENT"); ?>					
					</a>				
				<?php }else{?>
					<span style="display: none;" class="jac_span_sort_by_recent" id="jac_span_sort_comment">
						<?php echo JText::_("SORT_BY_OLDEST"); ?>					
					</span>
					<a href="javascript:sortComment('DESC','<?php echo JText::_("SORT_BY_OLDEST"); ?>','<?php echo JText::_("SORT_BY_RECENT"); ?>')" class="jac_sort_by_recent" id="jac_sort_comment">
						<?php echo JText::_("SORT_BY_OLDEST"); ?>
					</a>				
				<?php }?>
			</div>		
		</div>		
	
		<table width="100%" border="0" class="tbl tbl_comment" cellpadding="0" cellspacing="0">					
				<?php $k = 0;$inum = 0;$maxLevel = 0;//print_r($items);?>
				<?php foreach($items as $item): ?> 
					<?php   
						$inum ++;
						if ($inum>$this->lists['limitstart']){	        								
							//JFilterOutput::objectHtmlSafe($item->treename);
							$item->checked_out = 0;
							$checked 	= JHTML::_('grid.checkedout', $item, $k );
							$textTypeOfComment	= $this->getTextTypeOfComment ( $item->type );
							$treename = "";
							if(isset($item->treename)){
								$treename = $item->treename;
							}															
							$userInfo = JFactory::getUser($item->userid);
							
							
							if($userInfo->id == 0){																 
								$strUser  = $item->name. "(".$item->email.")";
								$userName = $item->name; 
								$strEmail = $item->email;
	                            
	                            if($item->website && stristr($item->website, 'http://') === FALSE) {
	                                $strWebsite = 'http://'.$item->website;
	                            }else{
	                                $strWebsite = $item->website;
	                            }	
							}else{																																											
								$strUser = $userInfo->name. "(".$userInfo->email.")";
								$userName = $item->name;
								$strEmail = $userInfo->email;
	                            
	                            $strWebsite = '';
							}
							//$avatar = $helper->getAvatar($userInfo->id);
							//if(is_array($avatar))	$avatar = $avatar[0];
							$userLink = "";
							$tmpAvatar = $helper->getAvatar($userInfo->id);
							if(!is_array($tmpAvatar[0])){				
							   $avatar = $tmpAvatar;
							   if(is_array($avatar)) $avatar = $avatar[0];
							}else{
							   $avatar = $tmpAvatar[0][0];
							   if(is_array($avatar)) $avatar = $avatar[0];
							   $userLink = $tmpAvatar[0][1];
							   $userLink = JURI::root().$userLink;
							}
	
	                        // ++ add by congtq 14/12/2009
	                        $rpx_avatar = '';
	                        $icon = '';
	                        
							if(isset($item->usertype) && $item->usertype){									                        		                          
	                            $paramsUser = new JRegistry;
		        				$paramsUser->loadJSON($userInfo->params);	 	                            
	                            if(is_object($paramsUser)){   
	                            	
	                                if($paramsUser->get("providerName")=='Twitter' || $paramsUser->get("providerName")=='Facebook'){
	                                    if(array_key_exists('photo', $paramsUser)){
	                                        $rpx_avatar = $paramsUser->get("photo");
	                                        $icon = '<img class="img-icon" height="16" width="16" alt="'.$paramsUser->get("providerName").'" src="'.JURI::root().'components/com_jacomment/asset/images/'.strtolower($paramsUser->get("providerName")).'.ico" />';
	                                    }
	                                    $strUser = $paramsUser->get("displayName");        
	                                    $strWebsite = $paramsUser->get("url");
	                                    
	                                }else if($paramsUser->get("providerName")=='Yahoo!'){	                                	                               		                               
	                                    $icon = '<img class="img-icon" height="16" width="16" alt="'.$paramsUser->get("providerName").'" src="'.JURI::root().'components/com_jacomment/asset/images/'.strtolower($paramsUser->get("providerName")).'.gif" />';	                                    
	                                }                    
	                            }
	                        }	                        	                        	                        
	                        // -- add by congtq 14/12/2009
	                        
							// ++ added by congtq 04/12/2009
	                        if($rpx_avatar){
	                            $avatar = $rpx_avatar;   
	                        }
							$item->comment = html_entity_decode($helper->replaceBBCodeToHTML($item->comment));								                       	                       
					?>				
							<tr id="rowOfComment<?php echo $currentTypeID; ?>-<?php echo $item->id;?>" <?php if($jaActiveComments && in_array($item->id,$jaActiveComments)) echo 'class="activeComment"';?>>							
								<td valign="top" class="jac-row-checked">																	
									<?php if($treename != ""){?>
											<div class="jac-sub-tree"><?php echo "....".$treename;?></div>
									<?php }?>					
									<?php echo $checked;?>																										
								</td>
								<td valign=top>	
									<div class="jac-change-type" id="jac-change-type-<?php echo $item->id;?>">
										<?php //get type of parent type of this item
											$parentType = 1;
											if($item->parentid != 0){												
												for ($i = $inum;$i >0; $i--){																										
													if(isset($items[$i]->id) && $items[$i]->id == $item->parentid){														
														$parentType = $items[$i]->type;
														break;
													}	
												}
											}
										?>														
										<?php											
											echo $helper->builFormChangeType($item->id, $item->type, $currentTypeID, $userName, $parentType);
										?>																	
									</div>																						
								</td>
								<?php //BEGIN - Show avatar and info of user?>
								<td valign=top>		
									<div class="jac-user-info">																																																							
										<div class="jac-avatar">
											<?php if($strWebsite){ ?><a href="<?php echo $strWebsite;?>">
												<img alt="" src="<?php echo $avatar;?>" width="32" height="32" /></a>
											<?php }else if($userLink){?>
												<a href="<?php echo $userLink;?>" target="_blank">
												<img alt="" src="<?php echo $avatar;?>" width="32" height="32" /></a>	
											<?php }else{?>
												<img alt="" src="<?php echo $avatar;?>" width="32" height="32" />
											<?php }?>
											<?php if($icon != ''){ echo $icon; }?>
										</div>
										<div class="jac-user-name">
											<?php if($strWebsite){ ?><a href="<?php echo $strWebsite;?>"><?php }?>										
												<span class="jac-user-name"><?php echo $userName; ?></span><br/>												
												<span class="date"><?php echo date("d/m/Y g:i A", strtotime($item->date));?></span>										
											<?php if($strWebsite){ ?></a><?php }?>
											<a href="mailto:<?php echo $strEmail;?>" title="<?php echo $strEmail;?>"><?php echo JText::_("SEND_MAIL");?></a>								
										</div>																							
									</div>																																																																																																									 
								</td>
								<?php //END - Show avatar and info of user?>
								<td>
									<?php 									
										$statusdisplay = 0;
										if(isset($arrayJaCommentCokie)){
											if(in_array($item->id, $arrayJaCommentCokie)){
												$statusdisplay = 1;	
											}	
										}
									?>									
									<?php if(isset($item->contenttitle) && $item->contenttitle != ""){
										$uri = JFactory::getURI();										
										$url =  $uri->root();										
									?>
										<i><?php echo JText::_('CONTENT_TITLE')?>:</i> <a class="article-title" title="" href="<?php echo $url.$item->referer;?>"><?php echo $item->contenttitle;?></a>	
									<?php }?>
									<div id="collapseComment<?php echo $currentTypeID;?>-<?php echo $item->id;?>" class="collapseComment" ondblclick="actionInComment('<?php echo $item->id;?>','<?php echo $currentTypeID;?>')" onmouseover="showActionComment('<?php echo $item->id;?>','<?php echo $currentTypeID;?>')" onmouseout="disableActionComment('<?php echo $item->id;?>','<?php echo $currentTypeID;?>')"<?php if($statusdisplay != 0){?>style="display: none;"<?php }?>>																																																					
										<div class="collapse-content-comment">																																							
											<div class="collapse-text-comment">												
												<div id="commentCollapse<?php echo $currentTypeID."_".$item->id;?>"><?php echo $this->sumaryComment ( html_entity_decode($helper->showComment($item->comment, false)) );?></div>																				
											</div>																																								
										</div>								
										<span id="actionCollapseComment<?php echo $currentTypeID."-".$item->id;?>" class="actionCollapseComment"></span>																			
									</div>
									<div id="expandComment<?php echo $currentTypeID;?>-<?php echo $item->id;?>" class="expandComment" <?php if($statusdisplay != 1){?>style="display: none;"<?php }?>>
										<div ondblclick="actionInComment('<?php echo $item->id;?>','<?php echo $currentTypeID;?>')" onmouseover="showActionComment('<?php echo $item->id;?>','<?php echo $currentTypeID;?>')" onmouseout="disableActionComment('<?php echo $item->id;?>',<?php echo $currentTypeID;?>)">																				 
											<div class="expand-content-comment" style="clear: both">
												<div class="span-content-comment" id="commentExpand<?php echo $currentTypeID."_".$item->id;?>"><?php echo html_entity_decode($helper->showComment($item->comment));?></div>
											</div>										
											<?php 													
												$target_path =  JPATH_ROOT.DS."images".DS."stories".DS."ja_comment".DS.$item->id;							
												$listFiles =  "";
												if(is_dir($target_path))
													$listFiles = JFolder::files($target_path);											
											?>		
												<div class="jac-expand-middle">							
													<span id="actionExpandComment<?php echo $currentTypeID."-".$item->id;?>" class="actionExpandComment"></span>	
													<div id="jac-attach-file-<?php echo $currentTypeID?>-<?php echo $item->id;?>" class="list-attach-file" style="clear: both;">													
														<?php if($listFiles){?>
															<div>
																<span>
																	<?php echo JText::_("LIST_ATTACH_FILE"); ?>
																</span>																	
															</div>
														<?php }?>
														<div id="jac-list-attach-file-<?php echo $currentTypeID?>-<?php echo $item->id;?>" style="float: left;">						
															<?php 
																if($listFiles){																																				
																	foreach ($listFiles as $listFile){		
																		$type = substr(strtolower(trim($listFile)), -3, 3);																																																							
																		$linkOfFile = "../index.php?tmpl=component&amp;option=com_jacomment&amp;view=comments&amp;task=downloadfile&id=".$item->id."&amp;filename=".$listFile;																
																		if($type == "jpg" || $type == "gif" || $type == "png" || $type == "bmp"){
																			$linkOfFile = JURI::root()."images/stories/ja_comment/".$item->id."/".$listFile;
																			echo "<img src='". $linkOfFile ."' alt='". $listFile ."'/> <br /><br />";	
																		}else{
																			echo "<img src='". JURI::root() ."/components/com_jacomment/themes/default/images/". $type .".gif' alt='". $listFile ."'/> <a href='". JRoute::_($linkOfFile) ."' title='". JText::_("DOWNLOAD_FILE") ."'>". $listFile ."</a><br /><br />";	
																		}
																	}
																}																
															?>
														</div>					
													</div>
												</div>														
										</div>
										
										<div style="clear: both;" id="jac-edit-comment-<?php echo $currentTypeID?>-<?php echo $item->id?>"></div>
										<!-- ++ add 30/11/2009 form edit -->																																																																																																															
										<div>
										<!-- ++ add 30/10/2009 form reply -->
										<div style="clear: both;" id="jac-reply-comment-<?php echo $currentTypeID;?>-<?php echo $item->id;?>" class="jac-reply-comment">
											<ul><li id="jac-result-reply-comment-<?php echo $currentTypeID;?>-<?php echo $item->id;?>"></li></ul>
										</div>																																																				
										<!-- add 30/10/2009 form reply -->
																										
										<div class="fotter-comment">   
											<div class="fotter-comment-left">
												<?php echo JText::_('THIS_COMMENT_IS'); ?>: <span class="type-of-comment-<?php echo $textTypeOfComment;?>" title="<?php echo $textTypeOfComment; ?>" id="type-of-comment-<?php echo $item->id;?>"><?php echo $textTypeOfComment;?></span>
											</div>
											
											<div class="fotter-comment-right" id="fotter-comment-right-<?php echo $currentTypeID;?>-<?php echo $item->id;?>">
												<?php 
													//if comment is UnApproved
													if($item->type == 0){																						
												?>
														<input type="button" class="input_button bt_approved" title="<?php echo JText::_("APPROVE");?>" value="<?php echo JText::_("APPROVE");?>" onclick="changeTypeOfComment(1,'<?php echo $item->id;?>','<?php echo $item->type;?>','<?php echo $currentTypeID;?>')" />													
														<input type="button" class="input_button bt_mark_spam" title="<?php echo JText::_("MARK_SPAM");?>" value="<?php echo JText::_("MARK_SPAM");?>" onclick="changeTypeOfComment(2,'<?php echo $item->id;?>','<?php echo $item->type;?>','<?php echo $currentTypeID;?>')" />																											
												<?php 		
													}
													//if Comment is approved
													elseif ($item->type == 1){
												?>														
														<input type="button" class="input_button bt_unapproved" title="<?php echo JText::_("UNAPPROVE");?>" value="<?php echo JText::_("UNAPPROVE");?>" onclick="changeTypeOfComment(0,'<?php echo $item->id;?>','<?php echo $item->type;?>','<?php echo $currentTypeID;?>')" />
														<input type="button" class="input_button bt_mark_spam" title="<?php echo JText::_("MARK_SPAM");?>" value="<?php echo JText::_("MARK_SPAM");?>" onclick="changeTypeOfComment(2,'<?php echo $item->id;?>','<?php echo $item->type;?>','<?php echo $currentTypeID;?>')" />															
												<?php 		
													}
													//if comment is Spam
													else{
												?>
														<input type="button" class="input_button bt_approved" title="<?php echo JText::_("APPROVE");?>" value="<?php echo JText::_("APPROVE");?>" onclick="changeTypeOfComment(1,'<?php echo $item->id;?>','<?php echo $item->type;?>','<?php echo $currentTypeID;?>')" />
														<input type="button" class="input_button bt_unapproved" title="<?php echo JText::_("UNAPPROVE");?>" value="<?php echo JText::_("UNAPPROVE");?>" onclick="changeTypeOfComment(0,'<?php echo $item->id;?>','<?php echo $item->type;?>','<?php echo $currentTypeID;?>')" />																													
												<?php		
													}
												?>																												
														<?php if($item->type == "1"){?>
															<input type="button" class="input_button bt_reply" title="<?php echo JText::_("REPLY");?>" value="<?php echo JText::_("REPLY");?>" onclick="replyComment('<?php echo $currentTypeID;?>', '<?php echo $item->id;?>', '<?php echo $userName;?>');" />
														<?php }?>
														<input type="button" class="input_button bt_edit" title="<?php echo JText::_("EDIT");?>" value="<?php echo JText::_("EDIT");?>" onclick="editComment('<?php echo $item->id;?>','<?php echo $currentTypeID; ?>')" />
														<input type="button" class="input_button bt_delete" title="<?php echo JText::_("DELETE");?>" value="<?php echo JText::_("DELETE");?>" onclick="deleteComment('<?php echo $item->id;?>','<?php echo $currentTypeID; ?>','<?php echo $item->type;?>')" />
											</div>											
										</div>															
									</div>
									<input type="hidden" name="hidStatus<?php echo $currentTypeID;?>-<?php echo $item->id;?>" id="hidStatus<?php echo $currentTypeID;?>-<?php echo $item->id;?>" value="<?php echo $statusdisplay;?>" />																										
								</div>						
							</div>
							<div style="clear: both"></div>
				<?php
					
					if(isset($item->level) && ($item->level > $maxLevel))
						$maxLevel = $item->level;
					if (($k+1)==$this->count_items)
					break; 
					$k++; 
				?>
				<?php }?>
			<?php endforeach; ?>
				</td>
			</tr>
			<?php 
				$pecelCheck = 7;				
				if($maxLevel > 7){					
					$maxLevel = $maxLevel - 7;										
					$pecelCheck = 8 + intval($maxLevel/4);	
				}
			?>
			<col width="<?php echo $pecelCheck."%";?>"></col><col width="2%"></col><col width="21%"></col><col></col>
		</table>
		
		<input type="hidden" name="hidAllStatus<?php echo $currentTypeID;?>" id="hidAllStatus<?php echo $currentTypeID;?>" value="0" />	
		<input type="hidden" name="option" value="com_jacomment" /> 
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="limitstart<?php echo $currentTypeID;?>" value="<?php echo $this->lists['limitstart'];?>" id="limitstart<?php echo $currentTypeID;?>" /> 
		<input type="hidden" name="boxchecked" id="boxchecked<?php echo $currentTypeID;?>" value="0" />
		<input type="hidden" name="view" value="comments" /> 	
		<!-- LOAD PAGING -->
		<div id="jav-pagination-<?php echo $currentTypeID;?>" class="jav-pagination clearfix"> 		    			    			
			<?php echo $this->getPaging($currentTypeID);?>	    			
		</div>
		<!-- //LOAD PAGING -->
		<div id="jac-explain-checkbox-color">
			<div class="jac-expain" id="jac-expain-1">
				<label class="comment-check status-1"><?php echo JText::_("APPROVED");?></label>
			</div>
			<div class="jac-expain" id="jac-expain-0">
				<label class="comment-check status-0"><?php echo JText::_("UNAPPROVED");?></label>
			</div>
			<div class="jac-expain" id="jac-expain-2">
				<label class="comment-check status-2"><?php echo JText::_("SPAM");?></label>
			</div>
		</div>
	<?php }?>