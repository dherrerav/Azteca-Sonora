<?php 
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die('Restricted access');
//print_r($this->googlead);
$rs_edit = $this->googlead;
$editor =& JFactory::getEditor();
?>
<style>
    fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button{float:none;}
</style>
<form action="index.php?option=com_contushdvideoshare&layout=googlead" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset class="adminform">
        <legend>Google AdSense</legend>
        <table class="admintable">
            <tr><td class="key"> Enter the Code:</td><td colspan="3"><textarea rows="10" cols="60" name="code"  id="name" ><?php echo $rs_edit->code;?></textarea></td><td> <label> Default size 468 x 60 </label></td></tr>
            <tr><td class="key" style="float:none;">Option</td><td><input type="radio" name="showoption" value="0" checked />Always Show<input type="radio" name="showoption"  value=1  <?php if($rs_edit->showoption == '1') echo 'checked'; ?> />Close After:<input type="text" name="closeadd" value=<?php echo $rs_edit->closeadd; ?> />&nbsp;Sec</td></tr>
            <tr><td class="key">Reopen</td><td><input type="checkbox" name="reopenadd" value="0"  <?php if($rs_edit->reopenadd == '0') echo 'checked'; ?> />&nbsp;&nbsp;Re-open After:<input type="text" name="ropen" value=<?php echo $rs_edit->ropen; ?> />&nbsp;Sec</td></tr>
            <tr><td class="key">Published</td><td><input type="radio" name="publish" value="0" checked="checked" />No<input type="radio" name="publish"   value=1  <?php if($rs_edit->publish == '1') echo 'checked'; ?> />Yes</td></tr>

        </table>
    </fieldset>

    <input type="hidden" name="id" value="<?php echo $rs_edit->id; ?>" />
<!--    <input type="hidden" name="option" value="<?php echo $option; ?>"/>-->
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>