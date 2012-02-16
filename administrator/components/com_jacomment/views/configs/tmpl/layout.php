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

$selected = 'selected="selected"';
$checked = 'checked="checked"';

// Read the themes folder to find themes
jimport('joomla.filesystem.folder');   

$app = JFactory::getApplication();
$helper = new JACommentHelpers ( );
$template = $helper->getTemplate(0);

$themeFolders = JPATH_SITE.'/components/com_jacomment/themes/';
$themes = JFolder::folders($themeFolders);
if(is_dir(JPATH_SITE.DS.'templates'.DS.JACommentHelpers::getTemplate(0).DS.'html'.DS."com_jacomment".DS."themes")){	
	$overideThemes = JFolder::folders(JPATH_SITE.DS.'templates'.DS.JACommentHelpers::getTemplate(0).DS.'html'.DS."com_jacomment".DS."themes");
	if(is_array($overideThemes))
		$themes = array_unique(array_merge_recursive($themes, $overideThemes));
}
$smileyFolders = JPATH_SITE.'/components/com_jacomment/asset/images/smileys/';
$smileys = JFolder::folders($smileyFolders);

// ++  custom_css

jimport('joomla.filesystem.file');

$file = JPATH_SITE.DS.'templates'.DS.$template.DS.'css'.DS.'ja.comment.custom.css';

$custom_css = '';
if(JFile::exists($file)){
    $custom_css = JFile::read($file);
} 

JHTML::_('script', 'jquery.event.drag-1.5.min.js',JURI::root().'administrator/components/com_jacomment/asset/js/');   
?> 

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery.each( ["avatar","addthis","addtoany","polldaddy","smileys","tweetmeme","comment_form","sorting_options"], function(i, n){        
        jQuery("#enable_" + n).click(function () {            
            if(jQuery("#enable_" + n).is(':checked')){
                jQuery("#ja-block-" + n).show("");    
            }else{
                jQuery("#ja-block-" + n).hide("");    
            }
        });
    });
    jQuery(".layoutmenu").click(function() {             
    	if(jQuery(this).attr("id") == "plugins"){    		          	  	
        	jQuery("#page-layout").hide();
        	jQuery("#page-plugins").show();
        	
        	jQuery("#plugins").addClass("active");
        	jQuery("#layout").removeClass("active");
    	}else{    		    		
    		jQuery("#page-layout").show();
        	jQuery("#page-plugins").hide();
        	
        	jQuery("#layout").addClass("active");
        	jQuery("#plugins").removeClass("active");
    	}
    });
    //
    <?php foreach($themes as $theme){ ?>
        jQuery("#<?php echo $theme;?>").click(function () { 
            jQuery("#edit_<?php echo $theme;?>").show("");    
            jQuery(".theme").not("#edit_<?php echo $theme;?>").hide("");    
        });
    <?php } ?>
    //
    jQuery("input").click(function() {
        show_bar_preview('<?php echo JText::_('PREVIEW')?>', '<?php echo JText::_('CANCEL')?>');
    });
});

function edit_theme(theme){
    jaCreatForm("editcss&group=layout&theme="+theme,0,700,460,0,0,'<?php echo JText::_("CUSTOM_CSS");?>'+theme,0,'<?php echo JText::_('SAVE');?>');
}  
 
</script>
<form action="index.php" method="post" name="adminForm">

<div class="col100">
	<fieldset class="adminform TopFieldset">
        <div class="submenu-box">
            <div class="submenu-pad">
                <ul id="submenu" class="configuration">
                    <li><a id="layout" class="layoutmenu active"><?php echo JText::_('LAYOUT' ); ?></a></li>
                    <li><a id="plugins" class="layoutmenu"><?php echo JText::_('PLUGINS' ); ?></a></li>
                </ul>
                <div class="clr"></div>
            </div>
        </div>
        <div class="clr"></div>
    </fieldset>
    <br/>
    <div id="config-document">
        <div id="page-layout">
	        <div class="box">
		        <h2><?php echo JText::_('LAYOUT_SETTINGS' ); ?></h2>	
		        <ul class="ja-list-checkboxs">
			        <li class="row-1 ja-section-title">
				        <b><?php echo JText::_('CHOOSE_THEME')?></b>
			        </li>
			        <li class="row-0">
                        <?php                         
                        foreach($themes as $theme){
                            $display = 'style="display:none;"';
                            if($this->params->get('theme', 1)==$theme){
                                $display = 'style="visibility:visible"';
                            }                            
                        ?>
				        <input type="radio" value="<?php echo $theme;?>" name="layout[theme]" <?php if($this->params->get('theme', 1)==$theme) echo $checked;?> id="<?php echo $theme;?>"/>
				        <label for="<?php echo $theme;?>" class="normal" style="font-weight: normal;"><?php echo ucfirst(JText::_($theme))?></label>
                        <span class="theme" id="edit_<?php echo $theme;?>" <?php echo $display;?>> (<a href="javascript:edit_theme('<?php echo $theme;?>');">custom css</a>)</span>
                        <?php } ?>				
			        </li>			        
			        <li class="row-1 ja-section-title">
				        <b><?php echo JText::_('USER_AVATAR')?></b>
			        </li>			        
			        <li class="row-0">
				        <label for="enable_avatar">
					        <?php $EnableAvatar = $this->params->get('enable_avatar', 1);?>
					        <input type="checkbox" <?php if($EnableAvatar==1){ echo $checked; }?> value="1" name="layout[enable_avatar]" id="enable_avatar"/> 
					        <?php echo JText::_("ENABLE_AVATAR");?>
				        </label>
				        <br />
				        <div id="ja-block-avatar"<?php if(!$EnableAvatar){?>style="display:none"<?php } ?>>
				        	<?php				        		
				        		 $type_avatar = $this->params->get('type_avatar', 0);				        		 
				        	?>					       
					        <ul>					        	
					        	<select name="layout[type_avatar]" id="type_avatar" multiple="multiple" size="4">						        		
					        		<option value="0" <?php if($type_avatar == 0) echo 'selected="selected"';?> id="type_avatar_0"><?php echo JText::_('Default');?></option>
					        		<?php if(file_exists(JPATH_SITE.DS."components".DS."com_fireboard".DS."fireboard.php")){?>
					        		<option value="1" <?php if($type_avatar == 1) echo 'selected="selected"';?> id="type_avatar_1"><?php echo JText::_('Community Builder');?></option>					        		
					        		<option value="2" <?php if($type_avatar == 2) echo 'selected="selected"';?> id="type_avatar_3"><?php echo JText::_('Fireboard (Kunena)');?></option>
					        		<?php }?>
					        		<?php if(file_exists(JPATH_SITE.DS."components".DS."com_community".DS."community.php")){?>
					        		<option value="4" <?php if($type_avatar == 4) echo 'selected="selected"'; ?>><?php echo JText::_('JomSocial');?></option>
					        		<?php }?>	
					        		<option value="3" <?php if($type_avatar == 3) echo 'selected="selected"';?> id="type_avatar_4"><?php echo JText::_('Gravatar');?></option>
					        	</select>
					        	<br/>				        								        							        							        								       							      
					        </ul>
					        <!--<br>					       				      
					        <ul>		
					        	<label>
					        		<?php echo JText::_("PATH_TO_SMF_FORUM_IF_REQUIRED");?>
					        	</label>			        						        	
					        	<input type="text" style="width: 180px;" name="layout[path_to_smf_forum]" value="<?php echo $this->params->get('path_to_smf_forum', '');?>">					        	
				        		<small><?php echo JText::_('FULL_PATH_TO_YOUR_SMF_FORUM_FOLDER')?></small>						        							        							        								       							        
					        </ul>-->
					        <br />						       		       
					        <?php $avatar_size = $this->params->get('avatar_size', 1);?>					        	
						        <ul class="ja-list-avatars clearfix">
							        <li <?php if($avatar_size==1){?>class="active"<?php }?> id="ja-li-avatar-1">							        	
								        <label for="avatar_size_1" class="normal">
									        <img width="16" height="16" src="components/com_jacomment/asset/images/settings/layout/avatar-large.png"/>
									        <span>
										        <input onclick="update_avatar_size_selection(1)" <?php if($avatar_size==1) echo $checked?> type="radio" value="1" id="avatar_size_1" name="layout[avatar_size]"/> 
										        <?php echo JText::_('COMPACT')?>
									        </span>
								        </label>
								        
							        </li>
							        <li <?php if($avatar_size==2){?>class="active"<?php }?> id="ja-li-avatar-2">
								        <label for="avatar_size_2" class="normal">
									        <img width="24" height="24" src="components/com_jacomment/asset/images/settings/layout/avatar-large.png" style="margin-top: 14px;"/>
									        <span>
										        <input onclick="update_avatar_size_selection(2)" <?php if($avatar_size==2) echo $checked?> type="radio" value="2" id="avatar_size_2" name="layout[avatar_size]"/> 
										        <?php echo JText::_('NORMAL')?>
									        </span>
								        </label>
								        
							        </li>
							        <li <?php if($avatar_size==3){?>class="active"<?php }?> id="ja-li-avatar-3">
								        <label for="avatar_size_3" class="normal">
									        <img src="components/com_jacomment/asset/images/settings/layout/avatar-large.png" style="margin-top: 6px;"/>
									        <span>
										        <input onclick="update_avatar_size_selection(3)" <?php if($avatar_size==3) echo $checked?> type="radio" value="3" id="avatar_size_3" name="layout[avatar_size]"/> 
										        <?php echo JText::_('LARGE')?>
									        </span>
								        </label>								
							        </li>							        							      
						        </ul>
						         <small><?php echo JText::_('SELECT_WHICH_AVATAR_TO_DISPLAY')?></small>
				        </div>				
			        </li>			        			        			        			        
			        
			        <li class="row-1 ja-section-title">
				        <b><?php echo JText::_('COMMENT_FORM_POSITION')?></b>
			        </li>
			        <li class="row-0">			        					        
			        	<?php $form_position = $this->params->get('form_position', 1);?>
				        <label for="form_position_1" class="normal">
					        <input type="radio" id="form_position_1" <?php if($form_position==1) echo $checked;?> value="1" name="layout[form_position]"/>
					        <?php echo JText::_('TOP_OF_THREAD')?>
				        </label>
				        <label for="form_position_2" class="normal">
					        <input id="form_position_2" type="radio" <?php if($form_position==2) echo $checked;?> value="2" name="layout[form_position]"/>
					        <?php echo JText::_('BOTTOM_OF_THREAD')?> 
				        </label>
				        <p><?php echo JText::_('THE_POSITION_OF_THE_FORM_TO_ADD_A_NEW_COMMENT')?></p>				        				       
			        </li>
			        
			        <li class="row-1 ja-section-title">
				        <b><?php echo JText::_('APPEARANCE')?></b>
			        </li>									       
			        <li class="row-0">
						<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
							<col width="7%" /><col width="93%" />
							<tr>
								<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/layout/layout-screenshot-sorting.png"/></td>
								<td>
									<?php $enable_sorting_options = $this->params->get('enable_sorting_options', 1);?>
									<label for="enable_sorting_options">
										<input type="checkbox" <?php if($enable_sorting_options) echo $checked;?> value="1" name="layout[enable_sorting_options]" id="enable_sorting_options" /> 
										<?php echo JText::_('SORTING_OPTIONS')?>
									</label>
									<p class="info"><?php echo JText::_('HIDE_OR_SHOW_THE_COMMENT_SORTING_OPTIONS_ON_THE_TOP_OF_THE_COMMENT_SECTION')?></p>
									<div id="ja-block-sorting_options"<?php if(!$enable_sorting_options){?>style="display:none"<?php } ?>>										
										<ul class="list-horizontalselect">
											<?php $default_sort = $this->params->get('default_sort', 'date');?> 
											<li class="fade"><?php echo JText::_("DEFAULT_SORTING");?></li>
											<li><label for="default_sort_1"><input type="radio" <?php if($default_sort=='date') echo $checked;?> value="date" name="layout[default_sort]" id="default_sort_1"/> </label><?php echo JText::_("DATE");?></li>
											<li><label for="default_sort_2"><input type="radio" <?php if($default_sort=='voted') echo $checked;?> value="voted" name="layout[default_sort]" id="default_sort_2"/></label>						        	
											 <?php echo JText::_("RATING");?></li>						        						        
										</ul>
										<br />
										<br />
										<ul class=" clearfix">
											<li class="fade"><?php echo JText::_("DEFAULT_TYPE_SORTING");?></li>
											<li>
												<select name="layout[default_sort_type]">
													<option id="default_sort_type_ASC" <?php if($this->params->get('default_sort_type', 'ASC') == "ASC") echo 'selected="selected"';?>  value="ASC"><?php echo JText::_("ASC");?></option>
													<option id="default_sort_type_DESC" <?php if($this->params->get('default_sort_type', 'ASC') == "DESC") echo 'selected="selected"';?>  value="DESC"><?php echo JText::_("DESC");?></option>
												</select>						        
											</li>
										</ul>
									</div>							
								</td>
							</tr>
							<tr>
								<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/layout/layout-screenshot-timestamp.png"/></td>
								<td>
									<?php $enable_timestamp = $this->params->get('enable_timestamp', 1);?>
									<label for="enable_timestamp">
										<input type="checkbox" <?php if($enable_timestamp) echo $checked;?> value="1" name="layout[enable_timestamp]" id="enable_timestamp" /> 
										<?php echo JText::_('ENABLE_TIMESTAMPS')?>
									</label>
									<p class="info"><?php echo JText::_('HIDE_OR_SHOW_THE_TIME_STAMP_FOR_COMMENTS')?></p>							
								</td>
							</tr>
						</table>
					</li>			       			        
			        <li class="row-1 ja-section-title">
				        <b><?php echo JText::_('FOOTER_TEXT')?></b>
			        </li>
			        <li class="row-0">				
				        <?php echo JText::_('THE_BELOW_TEXT_WILL_BE_SHOWN')?>
				        <div class="child">
					        <textarea id="footer_text" class="textarea_border" name="layout[footer_text]" cols="60" rows="3"><?php echo $this->params->get('footer_text');?></textarea>
				        </div>						
			        </li>
                    <li class="row-1 ja-section-title">
                        <b><?php echo JText::_('CUSTOM_CSS')?></b>
                    </li>
                    <li class="row-0">                
                        <?php echo JText::_('INPUT_YOUR_CUSTOM_STYLESHEET')?>
                        <div class="child">                        	
                            <textarea wrap="off" spellcheck="false" onscroll="scrollEditor(this);" class="inputbox jac-editor-code" id="custom_css" class="textarea_border" name="layout[custom_css]" cols="80" rows="7"><?php echo $custom_css;?></textarea>
                        </div>                        
                    </li>
		        </ul>		
				        
	        </div>
        </div>
        <div id="page-plugins" style="display: none;">
	        <div class="box">
		        <h2><?php echo JText::_('LOGIN_SERVICES' ); ?></h2>
				<div class="box_content">
					<ul class="ja-list-checkboxs">
						<li class="row-1 last_row">
							<?php $enable_login_rpx = $this->params->get('enable_login_rpx', 1);?>
							<label for="enable_login_rpx">
								<img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/rpx.png" height="30"/>
								<input type="checkbox" <?php if($enable_login_rpx) echo $checked;?> value="1" name="layout[enable_login_rpx]" id="enable_login_rpx" /> <?php echo JText::_('INTEGRATE_JA_RPXNOW_PLUGIN')?>
							</label>
							<p class="info"><?php echo JText::_('ENABLE_RPX_FOR_LOGIN')?></p>            
						</li>
					</ul>
				</div>
            </div>
			<br />
	        <div class="box">
		        <h2><?php echo JText::_('PLUGIN_SETTINGS' ); ?></h2>	
				<div class="box_content">
					<ul class="ja-list-checkboxs">
						<li class="row-0">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/addthis.gif"/></td>
									<td>
										<?php $enable_addthis = $this->params->get('enable_addthis', 1);?>
										<label for="enable_addthis">
											<input type="checkbox" <?php if($enable_addthis) echo $checked;?> value="1" name="layout[enable_addthis]" id="enable_addthis" /> <?php echo JText::_('ADDTHIS')?>
										</label>
										<p class="info"><?php echo JText::_('THE_BOOKMARKING_SHARING_SERVICE')?></p>            
										<div class="ja-block-inline child" id="ja-block-addthis"<?php if(!$enable_addthis){?>style="display:none"<?php } ?>>
											<textarea id="custom_addthis" class="text" name="layout[custom_addthis]" cols="80" rows="5"><?php echo $this->params->get('custom_addthis');?></textarea>
										</div>
									</td>
								</tr>
							</table>                   
						</li>
						<li class="row-1">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/AddToAny.jpeg"/></td>
									<td>
										<?php $enable_addtoany = $this->params->get('enable_addtoany', 0);?>
										<label for="enable_addtoany">
											<input type="checkbox" <?php if($enable_addtoany) echo 'checked="checked"';?>value="1" name="layout[enable_addtoany]" id="enable_addtoany" /> <?php echo JText::_('ADDTOANY_SHARE_BUTTON')?> 
										</label>
										<p class="info"><?php echo JText::_('HELPS_READERS_SHARE_SAVE_BOOKMARK_AND_EMAIL_POSTS_USING_ANY_SERVICE_SUCH_AS_DELICIOUS_DIGG_FACEBOOK_TWITTER_AND_OVER_100_MORE_SOCIAL_BOOKMARKING_AND_SHARING_SITES')?></p>
										<div class="ja-block-inline child" id="ja-block-addtoany"<?php if(!$enable_addtoany){?>style="display:none"<?php } ?>>
											<textarea id="custom_addtoany" class="text" name="layout[custom_addtoany]" cols="80" rows="5"><?php echo $this->params->get('custom_addtoany');?></textarea>
										</div>
									</td>
								</tr>
							</table>                   
						</li>            
						<li class="row-0">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/atdbuttontr.gif"/></td>
									<td>
										<?php $enable_after_the_deadline = $this->params->get('enable_after_the_deadline', 0);?>
										<label for="enable_after_the_deadline">
											<input type="checkbox" <?php if($enable_after_the_deadline) echo 'checked="checked"';?>value="1" name="layout[enable_after_the_deadline]" id="enable_after_the_deadline" /> <?php echo JText::_('AFTER_THE_DEADLINE__SPELL_CHECK_FOR_COMMENTS')?> 
										</label>
										<p class="info"><?php echo JText::_('LET_USERS_CHECK_SPELLING_AND_GRAMMAR_BEFORE_SUBMITTING_THEIR_COMMENTS')?></p>
									</td>
								</tr>
							</table>                   
						</li>												
						<li class="row-1">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/simplysmileys.png"/></td>
									<td>
										<?php $enable_smileys = $this->params->get('enable_smileys', 0);?>
										<label for="enable_smileys">
											<input type="checkbox" <?php if($enable_smileys) echo 'checked="checked"';?>value="1" name="layout[enable_smileys]" id="enable_smileys" /> <?php echo JText::_('SMILEYS')?>
										</label>
										<p class="info"><?php echo JText::_('END_OR_DIS_BUTTON_COMEMNT')?></p>
										<div class="ja-block-inline child" id="ja-block-smileys"<?php if(!$enable_smileys){?>style="display:none"<?php } ?>>
											<ul>
												<li>                                
												<?php                         
												echo JText::_('SELECT_A_STYLE');												
												foreach($smileys as $smiley){
												?>
												<input type="radio" value="<?php echo $smiley;?>" name="layout[smiley]" <?php if($this->params->get('smiley', "default")==$smiley) echo $checked;?> id="smileys<?php echo $smiley;?>"/>
												<label for="smileys<?php echo $smiley;?>" class="normal" style="font-weight: normal;"><?php echo ucfirst(JText::_($smiley))?></label><img src="../components/com_jacomment/asset/images/smileys/<?php echo $smiley;?>/smileys_icon.png" />
												<?php } ?>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							</table>                   
						</li>
						<li class="row-0">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/tm.ico"/></td>
									<td>
										<?php $enable_tweetmeme = $this->params->get('enable_tweetmeme', 0);?>
										<label for="enable_tweetmeme">
											<input type="checkbox" <?php if($enable_tweetmeme) echo 'checked="checked"';?>value="1" name="layout[enable_tweetmeme]" id="enable_tweetmeme"/> <?php echo JText::_('TWEETMEME_RETWEET_BUTTON')?>
										</label>
										<p class="info"><?php echo JText::_('ADDS_THE_TWEETMEME_RETWEET_BUTTON_AT_THE_TOP_OF_THE_COMMENT_SECTION')?></p>
										<div class="ja-block-inline child" id="ja-block-tweetmeme"<?php if(!$enable_tweetmeme){?>style="display:none"<?php } ?>>
											<textarea id="custom_tweetmeme" class="text" name="layout[custom_tweetmeme]" cols="80" rows="5"><?php echo $this->params->get('custom_tweetmeme');?></textarea>
										</div>
									</td>
								</tr>
							</table>                   
						</li>
						<li class="row-1">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/youtube.png"/></td>
									<td>
										<?php $enable_youtube = $this->params->get('enable_youtube', 0);?>
										<label for="enable_youtube">
											<input type="checkbox" <?php if($enable_youtube) echo 'checked="checked"';?>value="1" name="layout[enable_youtube]" id="enable_youtube" /> <?php echo JText::_('YOUTUBE_EMBEDDABLE_VIDEO')?>
										</label>
										<p class="info"><?php echo JText::_('ACTIVATE_YOUTUBE_EMBEDS_AND_YOUR_READERS_WILL_BE_ABLE_TO_SHARE_THEIR_FAVORITE_YOUTUBE_VIDEOS_AND_BEEF_UP_THEIR_RESPONSES_RIGHT_IN_THE_COMMENT_SECTION')?></p>
									</td>
								</tr>
							</table>                   
						</li>
						<li class="row-0">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td><img class="screenshot" alt="Screenshot" src="components/com_jacomment/asset/images/settings/comments/bbcode.png"/></td>
									<td>
										<?php $enable_bbcode = $this->params->get('enable_bbcode', 1);?>
										<label for="enable_bbcode">
											<input type="checkbox" <?php if($enable_bbcode) echo 'checked="checked"';?>value="1" name="layout[enable_bbcode]" id="enable_bbcode" /> <?php echo JText::_('ENABLE_BBCODE')?>
										</label>										
									</td>
								</tr>
							</table>                   
						</li>  
						<li class="row-1">
							<table width="100%" cellpadding="0" cellspacing="0" class="tbl tbl_appearance">
								<col width="7%" /><col width="93%" />
								<tr>
									<td></td>
									<td>
										<?php $enable_activity_stream = $this->params->get('enable_activity_stream', 0);?>										
										<label for="enable_activity_stream">
											<input type="checkbox" <?php if(!JACommentHelpers::checkComponent('com_community')){ ?>disabled="disabled"<?php }?> <?php if($enable_activity_stream) echo $checked;?>value="1" name="layout[enable_activity_stream]" id="enable_activity_stream" /> <?php echo JText::_('JOMSOCIAL__ACTIVITY_STREAM')?>
										</label>										
										<p class="info">
											<?php echo JText::_('NEW_COMMENT_WILL_SHOW_UP_IN_ACTIVITY_STREAM')?>
											<br/>
											<?php if(!JACommentHelpers::checkComponent('com_community')){ echo JText::_("YOU_MUST_INSTALL_JOMSOCIAL_TO_USE_IT"); }?>
										</p>
										
									</td>
								</tr>
							</table>                   
						</li>           
					</ul>                
				</div>
			</div>
        </div>
    </div>		
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_jacomment" />
<input type="hidden" name="view" value="configs" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="group" value="<?php echo $this->group; ?>" />
<input type="hidden" name="cid" value="<?php echo $this->cid; ?>" />
<?php echo JHTML::_( 'form.token' ); ?> 

<script type="text/javascript">
function update_avatar_size_selection(size){
	if($('ja-li-avatar-' + size)!='undifined'){
		for(var i=1; i<=3; i++){
			$('ja-li-avatar-' + i).removeClass('active');
		}
		$('ja-li-avatar-' + size).addClass('active');
	}
}
</script>
</form>