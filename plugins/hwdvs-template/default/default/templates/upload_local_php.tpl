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
  <h2>{$smarty.const._HWDVIDS_TITLE_UPLOAD2}</h2>
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td>
        <div><b>{$smarty.const._HWDVIDS_INFO_LIMUPLD} {$maximum_upload}MB</b></div>
        <div>{$smarty.const._HWDVIDS_INFO_ALLUPLD} {$allowed_formats}</div>
        <br />
        {literal}
        <script type="text/javascript">
        extArray = new Array({/literal}{$allowedft}{literal});
        function LimitAttach(form, file) {
            allowSubmit = false;
            if (!file) return;
            while (file.indexOf("\\") != -1)
            file = file.slice(file.indexOf("\\") + 1);
            ext = file.slice(file.lastIndexOf(".")).toLowerCase();
            for (var ii = 0; ii < extArray.length; ii++) {
              if (extArray[ii] == ext) { allowSubmit = true; break; }
            }
            if (allowSubmit) return true;
            else
            alert("Please only upload files that end in types:  "
            + (extArray.join("  ")) + "\n\nPlease select a new "
            + "file to upload and submit again.");
            return false;
        }
        function checkform()
        {
            document.getElementById('basicindicator').style.visibility="visible";
            document.getElementById('basicindicator').style.border="1px solid #fff";
            document.getElementById('basicindicator').style.padding="5px";
            document.getElementById('basicindicator').style.margin="5px 0 5px 0";
            document.getElementById('basicindicator').innerHTML = "{/literal}{$smarty.const._HWDVIDS_INFO_PROCESSINGWAIT}{literal}";
            document.getElementById('uploadButton').disabled=true;
        }
    </script>
        {/literal}
	<!-- Start Upload Form -->
	<form name="form_upload" method="post" enctype="multipart/form-data" action="{$PHPFORMURL}" style="margin: 0px; padding: 0px;" onsubmit="return checkform()">
	  {$PHPHIDDENINPUTS}		
	  <input type="file" name="upfile_0" size="40" value="" />
	  <div id="basicindicator"></div>
	  <noscript><br /><input type="submit" name="no_script_submit" id="uploadButton" value="Upload" /></noscript>
	  <br />
	  <script language="javascript" type="text/javascript">
	    <!--
	      document.writeln('<input type="submit" name="no_script_submit" id="uploadButton" onclick="return LimitAttach(this.form, this.form.upfile_0.value)" class="inputbox" value="{$smarty.const._HWDVIDS_BUTTON_UPLOAD}">');
	    //-->
	  </script>
	</form>		
	<!-- End Upload Form -->
      </td>
    </tr>
  </table>
</div>

{include file='footer.tpl'}



