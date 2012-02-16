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
?>
<script type="text/javascript">
	function gotoaction(){
		if($('action0').checked){
			$('task').value = 'duplicate';
		}
		else if($('action1').checked){
			$('task').value = 'import';
		}
		document.adminForm.submit();
	}
	function submitbutton(pressbutton){
		var form = document.adminForm;
   
	    form.task.value = pressbutton;
	    form.submit();		
	}
	function isChecked(isitchecked){
		if (isitchecked == true){
			document.adminForm.boxchecked.value++;
		}
		else {
			document.adminForm.boxchecked.value--;
			$("checkAllEmail").checked = isitchecked;
		}
	}	
</script>

<form name="adminForm" action="index.php" method="post">
	<fieldset class="adminform TopFieldset">
		<div id="comment-header-search-left">
			<?php echo JText::_('FILTER_NAME' ); ?>:
			<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" />
			<input type="button" onclick="this.form.submit();" value="<?php echo JText::_('GO' ); ?>">
			<input type="button" onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();" value="<?php echo JText::_('FILTER_RESET' ); ?>">
		</div>
		<div id="comment-header-search-right">
			<?php echo $this->languages; ?>
			<?php echo $this->lists['state']; ?>
		</div>
	</fieldset>
	<br/>
	
	<div id="EmailTemplates">
		<div class="box">
			<h2><?php echo JText::_('EMAIL_TEMPLATES');?></h2>	
			<div class="box_content">
				<table width="100%" class="adminlist tbl_email" cellpadding="0" cellspacing="0" border="0">
					<col width=" 30%"/>
					<thead>
						<tr>
							<th class="col_1">
								<?php echo JText::_('EMAIL_GROUP');?>
							</th>
							<th class="col_2 noPadding">
								<table width="100%" class="tbl_level02" cellpadding="0" cellspacing="0" border="0">
									<col width="4%" /><col /><col width="15%" />
									<tr>
										<th class="col_1">
											<input type="checkbox" name="toggle" id="checkAllEmail" value="" onclick="checkAll(<?php echo $this->counts; ?>);" />
										</th>
										<th class="col_2">
											<?php echo JText::_('EMAIL_TITLE');?>            						
										</th>
										<th class="col_3">
											<?php echo JText::_('PUBLISHED')?>            						
										</th>
									</tr>
								</table>
							</th>            		          		            		
						</tr>
					</thead>
					<tbody>
					<?php
					
					$items = $this->items;
					$en_items = $this->en_items;
					$k = 0;
					for($i = 0; $i < count($this->arr_group); $i++){
						$group = $this->arr_group[$i];
						
						?>
						<tr class="row<?php echo $i%2; ?>">
							<td class="col_1">					
								<?php echo $group; ?>
							</td>
							<td class="col_2 noPadding">
								<table width="100%" class="tbl_level02" cellpadding="0" cellspacing="0" border="0">
									<col width="4%" /><col /><col width="15%" />
									<?php if(!isset($items[$i]) && isset($en_items[$i])){?>
										<?php foreach ($en_items[$i] as $item){?>
											<tr>
												<td class="col_1">
													<input type='checkbox' name=cid[] disabled=true/>
												</td> 
												<td class="col_2">
													<?php echo $item['title']; ?> 
													<a href="<?php echo JRoute::_( 'index.php?option='. $this->lists['option'] .'&view=emailtemplates&task=duplicate&filter_lang='.$this->filter_lang.'&cid='.$item['id'] ); ?>" onclick="return confirm('<?php echo JText::_('ARE_YOU_SURE_YOU_WANT_TO_COPY_THE_TEMPLATE_FROM_THIS_DEFAULT_TEMPLATE')?>')" title="<?php echo JText::_('EMAIL_TEMPLATE_DOES_NOT_EXIST_CLICK_HERE_TO_COPY_IT_FROM_THE_DEFAULT_FILE'); ?>"><img src="<?php echo JURI::base()?>components/com_jacomment/asset/images/copy-32x32.png" alt="Copy" /></a>
												</td>
												<td class="col_3">&nbsp;</td>
											</tr>
										<?php }?>
									<?php }
									
									elseif(isset($items[$i]) && isset($en_items[$i])){?>
									
										<?php 
											$modelEmailTemplate = $this->getModel('emailtemplates'); $languages = $modelEmailTemplate->getLanguages(0);$diff = $modelEmailTemplate->diff_multi_array($en_items[$i], $items[$i], 'name');
										?>										
										<?php if($diff){?> 
											<?php foreach ($diff as $item){?>
												<tr>
													<td class="col_1">
														<input type='checkbox' name=cid[] disabled=true/>
													</td> 
													<td class="col_2">
														<?php echo $item['title']; ?>
														<a href="<?php echo JRoute::_( 'index.php?option='. $this->lists['option'] .'&view=emailtemplates&task=duplicate&filter_lang='.$this->filter_lang.'&cid='.$item['id'] ); ?>" onclick="return confirm('<?php echo JText::_('ARE_YOU_SURE_YOU_WANT_TO_COPY_THE_TEMPLATE_FROM_THIS_DEFAULT_TEMPLATE')?>')" title="<?php echo JText::_('EMAIL_TEMPLATE_DOES_NOT_EXIST_CLICK_HERE_TO_COPY_IT_FROM_THE_DEFAULT_FILE'); ?>"><img src="<?php echo JURI::base()?>components/com_jacomment/asset/images/copy-32x32.png" alt="Copy" /></a>
													</td>
													<td class="col_3">&nbsp;</td>
												</tr>
											<?php }?>	
										<?php }?>
										
										<?php foreach ($items[$i] as $item){									
											$temp = new stdClass();
											$temp->id = $item['id'];
											$temp->published = $item['published'];
											$published 	= JHTML::_('grid.published', $temp, $k );
											$temp->checked_out = 0;
											$checked 	= JHTML::_('grid.checkedout',   $temp, $k );
											?>
											<tr>
												<td class="col_1">
													<?php 
														if ($item['system']!=1)
															echo $checked; 
														else 					
															echo "<input type='checkbox' name=cid[] disabled=true/>"
													?> 
												</td> 
												<td class="col_2">
													<a href="<?php echo JRoute::_( 'index.php?option='. $this->lists['option'] .'&amp;view=emailtemplates&amp;task=edit&cid[]='.$item['id'] ); ?>">
														<?php echo $item['title']; ?>
													</a>
												</td>
												<td class="col_3">
													<?php echo $published ?>
												</td>
											</tr>
											<?php $k++;?>
										<?php }?>	
									
									<?php }
									
									elseif(isset($items[$i])){?>
										
										<?php foreach ($items[$i] as $j=>$item){
											
											$temp = new stdClass();
											$temp->id = $item['id'];
											$temp->published = $item['published'];
											$published 	= JHTML::_('grid.published', $temp, $k );
											$temp->checked_out = 0;
											$checked 	= JHTML::_('grid.checkedout',   $temp, $k );
											?>
											<tr>
												<td class="col_1">
													<?php 
														echo $checked; 
													?> 
												</td> 
												<td class="col_2">
													<a href="<?php echo JRoute::_( 'index.php?option='. $this->lists['option'] .'&view=emailtemplates&task=edit&cid[]='.$item['id'] ); ?>">
														<?php echo $item['title']; ?>
													</a>
												</td>
												<td class="col_3">
													<?php echo $published ?>
												</td>
											</tr>
											<?php $k++;?>
										<?php }?>	
									
									<?php }?>								            				
										
								</table>
							</td>                		        		            		
						</tr>
					<?php }?>
				<tbody>				
			</table>
		</div>
	</div>
</div>
	
	<input type="hidden" name="option" value="<?php echo $this->lists['option']; ?>" />
	<input type="hidden" name="view" value="emailtemplates" />
	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>	
 </form>
