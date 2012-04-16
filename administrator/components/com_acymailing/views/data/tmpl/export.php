<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="acy_content" >
<div id="iframedoc"></div>
<?php if(JRequest::getString('tmpl') == 'component'){
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet( ACYMAILING_CSS.'frontendedition.css' );
	?>
	<fieldset>
	<div class="header icon-48-acyexport" style="float: left;"><?php echo JText::_('ACY_EXPORT'); ?></div>
	<div class="toolbar" id="toolbar" style="float: right;">
	<a onclick="javascript:submitbutton('doexport')" href="#" ><span class="icon-32-acyexport" title="<?php echo JText::_('ACY_EXPORT',true); ?>"></span><?php echo JText::_('ACY_EXPORT'); ?></a>
	</div>
	</fieldset>
<?php } ?>
<form action="index.php?option=<?php echo ACYMAILING_COMPONENT ?>" method="post" name="adminForm" id="adminForm" >
	<table width="100%">
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<fieldset class="adminform">
					<legend><?php echo JText::_( 'FIELD_EXPORT' ); ?></legend>
						<table class="adminlist" cellpadding="1">
						<?php
						$k = 0;
						foreach( $this->fields as $fieldName => $fieldType){?>
							<tr class="<?php echo "row$k"; ?>">
								<td>
									<?php echo $fieldName ?>
								</td>
								<td align="center">
									<?php echo JHTML::_('select.booleanlist', "exportdata[".$fieldName."]",'',in_array($fieldName,$this->selectedfields) ? 1 : 0); ?>
								</td>
							</tr>
							<?php
							$k = 1-$k;
						}?>
							<tr>
								<td>
									<?php echo JText::_('EXPORT_FORMAT'); ?>
								</td>
								<td align="center">
									<?php echo $this->charset->display('exportformat',$this->config->get('export_format','UTF-8')); ?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo JText::_('ACY_SEPARATOR'); ?>
								</td>
								<td align="center">
									<input type="radio" name="exportseparator" value=";" id="semicolon" <?php if($this->config->get('export_separator',';') == ';') echo 'checked="checked"'; ?> /><label for="semicolon">;</label>
									<input type="radio" name="exportseparator" value="," id="comma" <?php if($this->config->get('export_separator',';') == ',') echo 'checked="checked"'; ?>/><label for="comma">,</label>
								</td>
							</tr>
						</table>
					</fieldset>
					<?php if(empty($this->users)){ ?>
					<fieldset>
					<legend><?php echo JText::_( 'ACY_FILTERS' ); ?></legend>
						<table class="adminlist" cellpadding="1">
							<tr class="row0">
								<td>
									<?php echo JText::_('EXPORT_SUB_LIST'); ?>
								</td>
								<td align="center">
									<?php echo JHTML::_('select.booleanlist', "exportfilter[subscribed]",'onchange="if(this.value == 1){document.getElementById(\'exportlists\').style.display = \'block\'; }else{document.getElementById(\'exportlists\').style.display = \'none\'; }"',1,JText::_('Yes'),JText::_('No').' : '.JText::_('ALL_USERS')); ?>
								</td>
							</tr>
							<tr class="row1">
								<td>
									<?php echo JText::_('EXPORT_CONFIRMED'); ?>
								</td>
								<td align="center">
									<?php echo JHTML::_('select.booleanlist', "exportfilter[confirmed]",'',0,JText::_('Yes'),JText::_('No').' : '.JText::_('ALL_USERS')); ?>
								</td>
							</tr>
							<tr class="row0">
								<td>
									<?php echo JText::_('EXPORT_REGISTERED'); ?>
								</td>
								<td align="center">
									<?php echo JHTML::_('select.booleanlist', "exportfilter[registered]",'',0,JText::_('Yes'),JText::_('No').' : '.JText::_('ALL_USERS')); ?>
								</td>
							</tr>
						</table>
					</fieldset>
					<?php } ?>
				</td>
				<td valign="top">
					<fieldset class="adminform" id="exportlists">
					<?php if(empty($this->users)){ ?>
						<legend><?php echo JText::_( 'LISTS' ); ?></legend>
						<table class="adminlist" cellpadding="1">
						<?php
						$k = 0;
						foreach( $this->lists as $row){?>
							<tr class="<?php echo "row$k"; ?>">
								<td>
									<?php echo '<div class="roundsubscrib rounddisp" style="background-color:'.$row->color.'"></div>';
									$text = '<b>'.JText::_('ACY_ID').' : </b>'.$row->listid.'<br/>'.$row->description;
									echo acymailing_tooltip($text, $row->name, 'tooltip.png', $row->name);
									?>
								</td>
								<td align="center">
									<?php echo JHTML::_('select.booleanlist', "exportlists[".$row->listid."]",'',1); ?>
								</td>
							</tr>
							<?php
							$k = 1-$k;
						}?>
						</table>
						<?php }else{ ?>
						<legend><?php echo JText::_( 'USERS' ); ?></legend>
						<table class="adminlist" cellpadding="1">
						<?php
						$k = 0;
						foreach( $this->users as $row){?>
							<tr class="<?php echo "row$k"; ?>">
								<td><?php echo $row->name; ?></td>
								<td><?php echo $row->email; ?></td>
							</tr>
						<?php $k = 1-$k;}
						if(count($this->users) >= 10){?>
						<tr class="<?php echo "row$k"; ?>">
							<td>...</td><td>...</td>
						</tr>
						<?php } ?>
						</table>
						<?php } ?>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="option" value="<?php echo ACYMAILING_COMPONENT; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="ctrl" value="<?php echo JRequest::getCmd('ctrl'); ?>" />
	<input type="hidden" name="sessionvalues" value="<?php echo empty($this->users) ? 0 : JRequest::getInt('sessionvalues'); ?>" />
	<input type="hidden" name="sessionquery" value="<?php echo empty($this->users) ? 0 : JRequest::getInt('sessionquery'); ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>