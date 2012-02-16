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
defined('_JEXEC') or die('Restricted access');	
JHTML::_('behavior.tooltip');
$option	= JRequest::getCmd('option');
?>

<fieldset class="adminform TopFieldset">
<div class="submenu-box">
	<div class="submenu-pad">
		<ul class="configuration" id="submenu">
			<li><a <?php if(!$this->client->id) echo "class=\"active\""?> href="index.php?option=<?php echo $option;?>&amp;view=managelang&amp;client=0"><?php echo JText::_('SITE')?></a></li>
			<li><a <?php if($this->client->id) echo "class=\"active\""?> href="index.php?option=<?php echo $option;?>&amp;view=managelang&amp;client=1"><?php echo JText::_('ADMINISTRATOR')?></a></li>
		</ul>
		<div class="clr"/>
	</div>
</div>
<div class="clr"/>
</fieldset>
<br />

<form name="adminForm" action="index.php" method="post">		
<table class="adminlist">
	<thead>
	
		<tr>
			<th width="20">
				#
			</th>			
			<th width="" class="title">
				<?php echo JText::_('LANGUAGE' ); ?>
			</th>			
			<th width="">
				<?php echo JText::_('VERSION' ); ?>
			</th>
			
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="8">
				<?php echo $this->page->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	
	<tbody>
	<?php
		$k = 0;
		for ($i=0, $n=count( $this->rows ); $i < $n; $i++) {
			$row = &$this->rows[$i];
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td width="">
					<?php echo $this->page->getRowOffset( $i ); ?>
				</td>				
				<td width="">
					<a href="index.php?option=<?php echo $option;?>&view=managelang&task=edit&layout=form&lang=<?php echo $row->language;?>&client=<?php echo $this->client->id;?>"><?php echo $row->name;?></a>
				</td>				
				<td align="center">
					<?php echo $row->version; ?>
				</td>
				
			</tr>
		<?php
		}
		?>
	</tbody>
	
</table>
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="client" value="<?php echo $this->client->id;?>" />
<input type="hidden" name="view" value="managelang" />
<input type="hidden" value="0" name="boxchecked"/>
<input type="hidden" name="task" value="edit" />
<input type="hidden" name="layout" value="form" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>