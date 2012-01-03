{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{include file='header.tpl'}

<div class="standard">
  <h2>{$smarty.const._HWDVIDS_TITLE_UPLOADSUCCESS}</h2>
  <div class="padding">
    <p>{$smarty.const._HWDVIDS_INFO_SUCUPLD} <a href="{$videolink}"><b><i>{$uploadname}</i></b></a></p>
    <p>{$waitmessage}</p>
    <p><a href="{$url_upld_another}">{$smarty.const._HWDVIDS_INFO_UPLDANOTHER}</a></p>
    <p><b>{$failures}</b></p>
  </div>
</div>

{if $showEditForm}
{include file='video_edit_form.tpl'}
{/if}

{include file='footer.tpl'}



