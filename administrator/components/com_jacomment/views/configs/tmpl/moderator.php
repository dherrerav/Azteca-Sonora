<?php  
defined('_JEXEC') or die('Retricted Access');
$app = JFactory::getApplication();
JHTML::_('behavior.tooltip');
$items=$this->items; 

$page=$this->pageNav; 

$lists=$this->lists;

$ordering = ($lists['filter_order'] == 'f.ordering');
?>
<script type="text/javascript">
Joomla.submitbutton = function(pressbutton){
	var form = document.adminForm;	
	if(pressbutton=='add')    
		jaCreatForm("editmoderator&group=moderator",0,500,350,0,0,'<?php echo JText::_("ADD_USER");?>',0,'<?php echo JText::_('ADD');?>');
	else{
		form.task.value=pressbutton;
		form.submit();
	}			
}
</script>
<div class="col100">

<div class="clr"></div>

 <form action="index.php" method="post" name="adminForm"> 

 	<input type="hidden" name="option" value="com_jacomment" /> 

 	<input type="hidden" name="task" value="" /> 

 	<input type="hidden" name="boxchecked" value="0" /> 

 	<input type="hidden" name="view" value="configs" /> 
 	
 	<input type="hidden" name="group" value="moderator" /> 
 	
 	<input type="hidden" name="type" value="<?php echo $lists['type']?>" /> 

 	<input type="hidden" name="filter_order" value="<?php echo $lists['filter_order']; ?>" /> 

 	<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['filter_order_Dir']; ?>" /> 

	<fieldset class="adminform TopFieldset">
		<?php echo $this->getTabs();?>
	</fieldset>	
	<br/>
	
	<div id="Moderator">
		<div class="box">
			<h2><?php echo JText::_('MODERATOR');?></h2>	
			<div class="box_content">

				<div style="text-align: right;">
					<a id='jac_help' href="index.php" onclick="hiddenNote('moderator','<?php echo JText::_('TEXT_HELP')?>','<?php echo JText::_('CLOSE_TEXT')?>');return false;"><?php echo JText::_('TEXT_HELP')?></a>
				</div>		
				<?php 
					$note = JText::_("ADMIN_MODERATOR_SETTINGS_NOTE" );
					JACommentHelpers::displayNote($note,'moderator');
				?>
				<table class="adminlist" id="user_added">
					<thead>
						<tr> 
							<th width="10" align="left">
								#
							</th> 
			
							<th width="2%">
								<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $items );?>);" />
							</th> 
							
							<th class="">
								<?php echo JHTML::_('grid.sort',   "Username", 'u.username', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
							</th> 
							<th class="">
								<?php echo JHTML::_('grid.sort',   "User Group", 'u.usertype', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
							</th>
							<th class="">
								<?php echo JHTML::_('grid.sort',   "Email", 'u.email', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
							</th> 
					
							<th class="">
								<?php echo JHTML::_('grid.sort',   "ID", 'u.id', @$lists['filter_order_Dir'], @$lists['filter_order'] ); ?>
							</th> 
			
						</tr>
					</thead> 
			
					<tfoot>
					<tr>
						<td colspan="10">
							<?php echo $page->getListFooter(); ?>
						</td>
					</tr>
					</tfoot> 
			
					<?php
					$k = 0;
					$count=count($items);
					if( $count>0 ) {
					for ($i=0;$i<$count; $i++) {
						$item	= $items[$i];
						$item->checked_out=1;
						$checked 	= JHTML::_('grid.checkedout',   $item, $i );
						JFilterOutput::objectHtmlSafe($item);
						$title=JText::_('EDIT_PERMISSION')." ID: ".$item->id;					
						?> 
			
					<tr class="<?php echo "row$k"; ?>"> 
			
							<td align="center">
								<?php echo $page->getRowOffset( $i ); ?>
							</td>
							<td>
								<?php echo $checked; ?>
							</td> 
							<td>
								<?php echo $item->username;?>
							</td>
							<td>
								<?php if($item->usertype)echo $item->usertype; else echo JText::_("REGISTERED");?>
							</td>
							<td align="left">
								<?php echo $item->email;?>
							</td> 				
							<td align="center">
								<?php echo $item->id;?>
							</td> 
			
						</tr> 
			
					<?php }?> 
			
				<?php }?> 
										
				</table>

				<?php echo JHTML::_( 'form.token' ); ?> 
			</div>
		</div>
	</div>
	</form>
</div>
