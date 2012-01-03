{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<form name="videoedit" action="{$form_save_video}" method="post" onsubmit="return chkform()" enctype="multipart/form-data">

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_EDITVID}</h2>
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td width="150">{$smarty.const._HWDVIDS_TITLE} <font class="required">*</font></td>
      <td><input name="title" value="{$title}" class="inputbox" size="20" maxlength="500" style="width: 200px;" /></td>
      <td rowspan="2" valign="top"><div class="edit-videopreview">{$thumbnail}</div></td>
    </tr>
    <tr>
      <td valign="top">{$smarty.const._HWDVIDS_DESC} <font class="required">*</font></td>
      <td valign="top">
      	{if $print_wysiwyg}
      		{$description}      	      	
      	{else}
      		<textarea rows="4" cols="20" name="description" class="inputbox" style="width: 200px;">{$description}</textarea></td>
    	{/if}
      </td>
    </tr>
    <tr>
      <td>{$smarty.const._HWDVIDS_CATEGORY} <font class="required">*</font></td>
      <td colspan="2">{$categoryselect}</td>
    </tr>
    <tr>
      <td>{$smarty.const._HWDVIDS_TAGS} <font class="required">*</font></td>
      <td colspan="2">{$smarty.const._HWDVIDS_INFO_TAGS}</td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2"><input name="tags" value="{$tags}" class="inputbox" size="20" maxlength="1000" style="width: 200px;" /></td>
    </tr>
    <tr>
      <td colspan="3"><font class="required">*</font> {$smarty.const._HWDVIDS_INFO_REQUIREDFIELDS}</td>
    </tr>
  </table>
</div>

{include file='video_edit_newthumb.tpl'}

{if $print_sharingoptions}
  {include file='sharingoptions.tpl'}
{/if}

<div class="standard">
  <table width="100%" cellpadding="0" cellspacing="4" border="0"><tr><td width="150"></td><td><input type="submit" name="send" class="inputbox" value="{$smarty.const._HWDVIDS_BUTTON_UPDT}" />&#160;<input type="button" class="inputbox" value="{$smarty.const._HWDVIDS_BUTTON_CANX}" onClick="javascript:window.location.href='{$link_home_hwd_vs}';" /></td></tr></table>
</div>

<input type="hidden" name="referrer" value="{$referrer}" />
<input type="hidden" name="id" value="{$rowid}" />
<input type="hidden" name="owner" value="{$rowuid}" />
</form>





