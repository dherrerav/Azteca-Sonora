{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $full}{include file='header.tpl'}{/if}

<div class="standard">
  <h2>{$title}</h2>
  <div class="padding">
    <img src="{$icon}" border="0" style="vertical-align:middle;" />&nbsp;&nbsp;{$message}<br /><br />
    {$backlink}
  </div>
</div>

{if $showconnectionbox}
<div class="standard">
  <h2>{$smarty.const._HWDVIDS_LB_GC}</h2>
  <div class="padding">

  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td valign="top">
        <div class="introduction">
          <ul id="featurelist">
            <li>{$smarty.const._HWDVIDS_LB_1}</li>
            <li>{$smarty.const._HWDVIDS_LB_2}</li>
            <li>{$smarty.const._HWDVIDS_LB_3}</li>
            <li>{$smarty.const._HWDVIDS_LB_4}</li>
          </ul>
          <div class="joinbutton">
            <a id="joinButton" href="{$url_register}" title="{$smarty.const._HWDVIDS_LB_JOIN}">{$smarty.const._HWDVIDS_LB_JOIN}</a>
          </div>
        </div>
      </td>
      <td width="200">
        <div class="loginform">
{if $j16}
<form action="{$JURL}/index.php" method="post" id="login-form" >
	<fieldset class="userdata">
	<p id="form-login-username">
		<label for="modlgn-username">{$smarty.const._HWDVIDS_LB_U}</label>
		<input id="modlgn-username" type="text" name="username" class="inputbox"  size="18" />
	</p>
	<p id="form-login-password">
		<label for="modlgn-passwd">{$smarty.const._HWDVIDS_LB_P}</label>
		<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18"  />
	</p>
	<p id="form-login-remember">
		<label for="modlgn-remember">{$smarty.const._HWDVIDS_LB_RM}</label>
		<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
	</p>
	<input type="submit" name="Submit" class="button" value="{$smarty.const._HWDVIDS_LB_L}" />
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="{$session_return}" />
	{$session_token}
	</fieldset>
	<ul>
		<li>
			<a href="{$url_reset}">
			{$smarty.const._HWDVIDS_LB_FP}</a>
		</li>
		<li>
			<a href="{$url_remind}">
			{$smarty.const._HWDVIDS_LB_FU}</a>
		</li>
	</ul>
</form>
{else}
          <form action="{$loginUrl}" method="post" name="login" id="form-login" >
      
            <label>
              {$smarty.const._HWDVIDS_LB_U}<br />
              <input type="text" class="inputbox" name="username" id="username" />
            </label>
      
            <label>
              {$smarty.const._HWDVIDS_LB_P}<br />
              <input type="password" class="inputbox" name="passwd" id="password" />
            </label>
            
            <br />
      
            <label for="remember">
              <input type="checkbox" alt="{$smarty.const._HWDVIDS_LB_RM}" value="yes" id="remember" name="remember"/>
              {$smarty.const._HWDVIDS_LB_RM}
            </label>
      
            <div style="text-align: left; padding: 10px 0 5px;">
              <input type="submit" value="{$smarty.const._HWDVIDS_LB_L}" name="submit" id="submit" class="button" />
            </div>
    
            <a href="{$url_reset}" class="login-forgot-password">
              <span>{$smarty.const._HWDVIDS_LB_FP}</span>
            </a>
            <br />
            <a href="{$url_remind}" class="login-forgot-username">
              <span>{$smarty.const._HWDVIDS_LB_FU}</span>
            </a>

	    <input type="hidden" name="return" value="{$session_return}" />
	    {$session_token}

          </form>
{/if}
        </div>
      </td>
    </tr>
  </table>

  </div>
</div>

{/if}

{if $full}{include file='footer.tpl'}{/if}
