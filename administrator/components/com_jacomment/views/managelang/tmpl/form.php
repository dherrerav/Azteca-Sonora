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
$option	= JRequest::getCmd('option');
JRequest::setVar( 'hidemainmenu', 1 );		
				
if (!is_writable($this->root)) {
	echo '<span style="color:red; font-size:14px"><b>'. JText::_('FILE_IS_UNWRITABLE').'</b></span><br/><br/>';
}

?>
<div style="position:relative; width:100%; float:left ;">
<form action="index.php" method="POST" name="adminForm" style=" width:100%;">
	<div><b><?php echo JText::_('EDIT_LANGUAGE_FILE'), ' "', $this->filename;?>"</b></div>
	<textarea wrap="off" spellcheck="false" onscroll="scrollEditor(this);" onkeydown="return catchTab(this,event)" class="inputbox jav-editor-code" id="datalang" name="datalang" rows="25" cols="110">
		<?php echo $this->data; ?>
	</textarea>			
	
	<input type="hidden" name="path_lang"  value="<?php echo $this->path_lang;?>" />
	<input type="hidden" name="task"  value="" />
	<input type="hidden" name="filename"  value="<?php echo $this->lang;?>" />
	<input type="hidden" name="client"  value="<?php echo $this->client->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="managelang" />
</form>				
</div>		