{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

<form name="creategroup" action="{$form_add_group}" method="post" onsubmit="return chkform()">
<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_CREATEGROUP}</h2>
  <table width="100%" cellpadding="0" cellspacing="4" border="0">
    <tr>
      <td width="150">{$smarty.const._HWDVIDS_TITLE} <font class="required">*</font></td>
      <td><input name="group_name" value="" class="inputbox" size="20" maxlength="500" style="width: 200px;" /></td>
    </tr>
    <tr>
      <td valign="top">{$smarty.const._HWDVIDS_DESC} <font class="required">*</font></td>
      <td valign="top"><textarea rows="4" cols="20" name="group_description" class="inputbox" style="width: 200px;"></textarea><br /></td>
    </tr>
    <tr>
      <td colspan="2"><font class="required">*</font> {$smarty.const._HWDVIDS_INFO_REQUIREDFIELDS}</td>
    </tr>
  </table>
</div>

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_OPTIONS}</h2>
  <table width="100%" cellpadding="0" cellspacing="4" border="0">
    <tr>
      <td width="150">{$smarty.const._HWDVIDS_ACCESS}</td>
      <td>
        <select name="public_private">
          <option value="public" selected>{$smarty.const._HWDVIDS_SELECT_PUBLIC}</option>
          <option value="registered">{$smarty.const._HWDVIDS_SELECT_REG}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="150">{$smarty.const._HWDVIDS_ACOMMENTS}</td>
      <td>
        <select name="allow_comments">
          <option value="1" selected>{$smarty.const._HWDVIDS_SELECT_ALLOWCOMMS}</option>
          <option value="0">{$smarty.const._HWDVIDS_SELECT_DONTALLOWCOMMS}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="150">&nbsp;</td>
      <td><input type="checkbox" checked="yes" name="add2group" value="1" />&nbsp;{$smarty.const._HWDVIDS_INFO_AUTOA2G}</td>
    </tr>
  </table>
</div>

<div class="standard">
  <table width="100%" cellpadding="0" cellspacing="4" border="0">
    {if $print_captcha}
    <tr>
      <td width="150"></td>
      <td>{$captcha}</td>
    </tr>
    <tr>
      <td>{$smarty.const._HWDVIDS_INFO_SECURECODE} <font class="required">*</font></td>
      <td><input id="security_code" name="security_code" type="text" /></td>
    </tr>
    {/if}
    <tr>
      <td width="150"></td>
      <td><input type="submit" name="send" class="inputbox" value="{$smarty.const._HWDVIDS_BUTTON_SAVEGROUP}" /></td>
    </tr>
  </table>
</div>
<input type="hidden" name="require_approval" value="0"/>
</form>

{include file='footer.tpl'}



