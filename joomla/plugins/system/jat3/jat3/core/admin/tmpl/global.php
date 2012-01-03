<?php

	defined('_JEXEC') or die;
	
	
	
	foreach ($fieldSets as $name => $fieldSet) :?>		
		<fieldset class="panelform">
			<table width="100%" cellspacing="1" class="paramlist admintable">
				<tbody>
					
					<?php foreach ($configform->getFieldset($name) as $field) : ?>
						<tr>
							<?php if($field->label!=''){?>
							<td width="40%" class="paramlist_key">
								<?php echo $field->label; ?>
							</td>
							<?php }?>
							<td class="paramlist_value" <?php if($field->label==''){?> colspan="2" <?php }?>>
								<?php echo $field->input; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					
				</tbody>
			</table>
		</fieldset>
	<?php endforeach;  ?>