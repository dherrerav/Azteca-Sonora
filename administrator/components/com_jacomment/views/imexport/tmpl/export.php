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
$option	= JRequest::getCmd('option');
JHTML::_('behavior.tooltip');
?>
<script language="javascript">
function export2(){
	num = document.getElementById("num").value;
    window.location.href = "index.php?tmpl=component&option=<?php echo $option;?>&view=imexport&group=export&task=export&num="+num+"&no_html=1";
}
</script>
<form action="index.php" method="post" name="adminForm">
<div class="col100">
	<fieldset class="adminform TopFieldset">
		<?php echo $this->getTabs();?>
	</fieldset>
	<br />
	<div id="OtherComment">
		<div class="box">
			<h2><?php echo JText::_('EXPORT')?></h2>	
			<div class="box_content">
				<ul class="ja-list-checkboxs">
					<li class="row-1 ja-section-title">
						<b><?php echo JText::_("EXPORT_FOR_BACKUP");?></b>
					</li>
					<li class="row-0">
						<label>    
							<span class="editlinktip hasTip" title="<?php echo JText::_('MAX_RECORDS' );?>::<?php echo JText::_('EMPTY_FOR_ALL' ); ?>">
							<?php echo JText::_("MAX_RECORDS");?>
							</span>
							<input type="text" size="6" id="num" value="" />
							<input type="button" class="btn_add export" name="export" value="<?php echo JText::_('EXPORT');?>" onclick="javascript: export2();" />
						</label>
					</li>                                                                                                               
				</ul>
			</div>
		</div>
	</div>					
				
</div>
</form>