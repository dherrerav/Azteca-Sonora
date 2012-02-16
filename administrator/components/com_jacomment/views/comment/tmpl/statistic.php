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
 // Check to ensure this file is included in Joomla! 

 defined('_JEXEC') or die( 'Restricted access' ); 
 ?>

<fieldset class="adminform TopFieldset">
	<?php echo $this->menu();?>
</fieldset>
<br/>
<form name="adminForm" action="index.php" method="post" enctype="multipart/form-data">
	<div id="Statistic">
		<div class="box">
			<h2><?php echo JText::_('STATISTIC' ); ?></h2>	
			<div class="box_content">
				<table class='adminlist'>
					<tr>
						<td class="key" width="200"><?php echo JTEXT::_('Total new comments: ');?></td>
						<td><?php echo $this->total_new;?></td>    
					</tr>
					<tr>
						<td class="key"><?php echo JTEXT::_('Comments made today: ');?></td>
						<td><?php echo $this->total_today;?></td>    
					</tr>
					<tr>
						<td class="key"><?php echo JTEXT::_('Total comments last 30 days: ');?></td>
						<td><?php echo $this->total_30day;?></td>    
					</tr>
					<tr>
						<td class="key"><?php echo JTEXT::_('Total comments: ');?></td>
						<td><?php echo $this->total;?></td>    
					</tr>
				</table>
			</div>
		</div>
	</div>
</form>
