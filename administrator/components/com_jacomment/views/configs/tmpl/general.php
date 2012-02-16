<?php  
defined('_JEXEC') or die('Retricted Access');

JHTML::_('behavior.tooltip');
?> 
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery.each( ["comment_offline", "notify_admin", "enabled_email"], function(i, n){
        jQuery("#is_" + n).click(function () {
            if(jQuery("#is_" + n).is(':checked')){
                jQuery("#ja-block-" + n).show("");    
            }else{
                jQuery("#ja-block-" + n).hide("");    
            }
        });
    });
});
</script>
<form action="index.php" method="post" name="adminForm">

<div class="col100">
	<fieldset class="adminform TopFieldset">
        <?php echo $this->getTabs();?>
    </fieldset>
    <br/>
    <div id="GeneralSettings">
		<div class="box">
			<h2><?php echo JText::_('GENERAL_SETTINGS' ); ?></h2>	
			<div class="box_content">
				<ul class="ja-list-checkboxs">
					<li class="row-0">
						<label for="is_comment_offline">    
							<?php $is_comment_offline = $this->params->get('is_comment_offline', 0);?>                    
							<input type="checkbox" <?php if($is_comment_offline) echo 'checked="checked"' ?> value="1" name="general[is_comment_offline]" id="is_comment_offline" />        
							<span class="editlinktip hasTip" title="<?php echo JText::_('COMPONENT_OFFLINE' );?>::<?php echo JText::_('COMPONENT_OFFLINE_DESC' ); ?>">
								<?php echo JText::_("COMPONENT_OFFLINE");?>
							</span>
							
						</label>
						
						<div id="ja-block-comment_offline"<?php if(!$is_comment_offline){?>style="display:none"<?php } ?>>
							<div class="child clearfix" id='box_offline_message'>                    
								<div class="editlinktip hasTip" title="<?php echo JText::_('OFFLINE_MESSAGE' );?>::<?php echo JText::_('OFFLINE_MESSAGE_DESC' ); ?>">
									<?php echo JText::_("OFFLINE_MESSAGE")?>: 
								</div>
								<textarea id="display_message" name="general[display_message]" rows="3" cols="50"><?php echo  $this->params->get('display_message');?></textarea>
							</div>
						
							<div class="child clearfix" id='box_offline_access' >
								<div class="editlinktip hasTip" title="<?php echo JText::_('ACCESS_LEVEL' );?>::<?php echo JText::_('ACCESS_LEVEL_DESC' ); ?>">
									<?php echo JText::_("ACCESS_LEVEL")?>:
								</div>
								<?php                            
									$item=new stdClass();
									$item->access=$this->params->get('access')?$this->params->get('access'):0;
									$access         = JHTML::_('list.accesslevel', $item, 'general[access]');    
									echo $access;                
								?>    
							</div>                
							<?php 
							/*<div class="child clearfix" id='box_offline_access' >
								<?php $is_use_ja_login_form = $this->params->get('is_use_ja_login_form', 1);?>            
								<input type="checkbox" <?php if($is_use_ja_login_form)echo 'checked="checked"' ?> value="1" name="general[is_use_ja_login_form]" id="is_use_ja_login_form"/>        
								<span class="editlinktip hasTip" title="<?php echo JText::_('USE_JA_LOGIN_FORM' );?>::<?php echo JText::_('USE_JA_LOGIN_FORM' ); ?>">
									<?php echo JText::_("USE_JA_LOGIN_FORM");?>
								</span>                    
							</div>*/
							?>
						</div>
					</li>                        										
					
					<li class="row-1">
						<h4><?php echo JText::_('NOTIFICATIONS')?></h4>
					</li>
					
					<li class="row-0">
						<div class="is_notify_admin">
							<label for="is_notify_admin">    
								<?php $isnotifyadmin = $this->params->get('is_notify_admin', 0);?>                
								<input type="checkbox" <?php if($isnotifyadmin) echo 'checked="checked"' ?> value="1" name="general[is_notify_admin]" id="is_notify_admin" />        
								<span class="editlinktip hasTip" title="<?php echo JText::_('NOTIFY_ADMIN_ON_NEW_POST' );?>::<?php echo JText::_('NOTIFY_ADMIN_ON_NEW_POST_DESC' ); ?>">
									<?php echo JText::_("NOTIFY_ADMIN_ON_NEW_POST");?>
								</span>
								
							</label>
						</div>
						<div id="ja-block-notify_admin"<?php if(!$isnotifyadmin){?>style="display:none"<?php } ?>>
							<div class="child clearfix" id='div_display_message'>                    
								<div class="editlinktip hasTip" title="<?php echo JText::_('NOTIFICATION_EMAIL' );?>::<?php echo JText::_('NOTIFICATION_EMAIL_DESC' );?>">
									<?php echo JText::_("NOTIFICATION_EMAIL")?>: 
								</div>
								<?php 
									//get admin email	
									$config = new JConfig();									
								?>                            
								<input type="text" id="notify_admin_email" name="general[notify_admin_email]" value="<?php echo $this->params->get('notify_admin_email', $config->mailfrom);?>" size="50" class="input"/>
							</div>
						</div> 
						<div class="is_notify_author">
							<label for="is_notify_author">    
								<?php $is_notify_author = $this->params->get('is_notify_author', 0);?>            
								<input type="checkbox" <?php if($is_notify_author)echo 'checked="checked"' ?> value="1" name="general[is_notify_author]" id="is_notify_author"/>        
								<span class="editlinktip hasTip" title="<?php echo JText::_('NOTIFY_AUTHOR_ON_NEW_POST' );?>::<?php echo JText::_('NOTIFY_AUTHOR_ON_NEW_POST_DESC' ); ?>">
									<?php echo JText::_("NOTIFY_AUTHOR_ON_NEW_POST");?>
								</span>                    
							</label>
						</div>                        
					</li>        
					
					<li class="row-1">
						<h4><?php echo JText::_('EMAIL_SETTINGS')?></h4>
					</li>
						
					<li class="row-0 last_row">
						<label for="is_enabled_email">
							<?php $isenabledemail = $this->params->get('is_enabled_email', 0);?>
							<input type="checkbox" <?php if($isenabledemail)echo 'checked="checked"' ?> value="1" name="general[is_enabled_email]" id="is_enabled_email" />        
							<span class="editlinktip hasTip" title="<?php echo JText::_('DISABLE_OR_ENABLE_EMAIL_FUNCTION');?>::<?php echo JText::_('EMAIL_SENDING');?>">
								<?php echo JText::_("ENABLE_SEND_EMAIL");?>
							</span>                        
						</label>
						<div id="ja-block-enabled_email"<?php if(!$isenabledemail){?>style="display:none"<?php } ?>>
							<div id="ja-email-settings">
								<div class="child clearfix">
									<div class="editlinktip hasTip" title="<?php echo JText::_('PRINT_FOR_DEBUG' );?>::<?php echo JText::_('WILL_BE_PRINTED_AT_THE_BOTTOM'); ?>">
										<label style="font-weight: normal;"><input type="checkbox" value="1" name="general[mail_view_only]" id="mail_view_only" <?php if($this->params->get('mail_view_only', 0))echo 'checked="checked"' ?> /> <?php echo JText::_('VIEW_EMAIL_ONLY' ); ?></label>
									</div>
								</div>
								<br />
								<div class="child clearfix">
									<div class="editlinktip hasTip" title="<?php echo JText::_('NAME_OF_EMAIL_SENDER' );?>::<?php echo JText::_('FROM_NAME_DESC'); ?>">
										<?php echo JText::_('FROM_NAME')?>:
									</div>    
									<input type="text" name="general[fromname]" value="<?php echo $this->params->get('fromname', $config->fromname);?>" id="fromname"  size="50">
								</div>
								<div class="child clearfix">
									<div class="editlinktip hasTip" title="<?php echo JText::_('SENDER_EMAIL_ADDRESS' );?>::<?php echo JText::_('FROM_EMAIL_DESC'); ?>">
										<?php echo JText::_('FROM_EMAIL')?>:
									</div>        
									<input type="text" name="general[fromemail]" value="<?php echo $this->params->get('fromemail', $config->mailfrom);?>" id="fromemail"  size="50">
								</div>
								<div class="child clearfix">
									<div class="editlinktip hasTip" title="<?php echo JText::_('ADD_CC_EMAIL' );?>::<?php echo JText::_('ADD_CC_EMAIL_DESC'); ?>">
										<?php echo JText::_('ADD_CC_EMAIL')?>:
									</div>        
									<input type="text" name="general[ccemail]" value="<?php echo $this->params->get('ccemail');?>" id="ccemail"  size="50">
								</div>        
							</div>
						</div> 
					</li>
				</ul>        
			</div>
		</div>        
    </div>      

    <!--<fieldset>
        <legend><?php echo JText::_('CATEGORY' ); ?></legend>        
        <table class="admintable" width="100%">
        <tbody>    
            <tr>
                <td class="key">
                </td>
                <td class="key">
                    <?php                                
                    echo JHTML::_('select.genericlist', $this->lists['categories'], 'category[]', 'multiple class="inputbox"', 'value', 'text', explode(", ", $this->params->get('category')));
                    ?>
                </td>
                <td></td>
            </tr>    
        </tbody>
        </table>
    </fieldset>
    -->
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_jacomment" />
<input type="hidden" name="view" value="configs" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="group" value="<?php echo $this->group; ?>" />
<input type="hidden" name="cid" value="<?php echo $this->cid; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>    
</form>