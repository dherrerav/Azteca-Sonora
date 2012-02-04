<?php
/**
 * @version  $Id: adslayout.php 1.5,  03-Feb-2011 $$
 * @package	Joomla
 * @subpackage	hdflvplayer
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Edited       Gopinath.A
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$rs_roll = $this->adslist;
$uploadscript = JURI::base() . "components/com_contushdvideoshare/upload_script.js";
// Add Description Advaced Editor
/* $editor = & JFactory::getEditor();
  $params = array('smilies' => '1',
  'style' => '1',
  'layer' => '1',
  'table' => '1',
  'paste' => '1',
  'searchreplace' => '1',
  'media' => '0',
  'hr' => '0',
  'directionality' => '0',
  'fullscreen' => '0',
  'xhtmlxtras' => '0',
  'visualchars' => '0',
  'nonbreaking' => '0',
  'blockquote' => '0',
  'template' => '0',
  'advimage' => '0',
  'advlink' => '0',
  'fonts' => '1',
  'colors' => '1'
  ); */
?>
<style>
   fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button {float:none;}
</style>
<script src="<?php echo $uploadscript; ?>" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
   <?php if(version_compare(JVERSION,'1.6.0','ge'))
                    { ?>Joomla.submitbutton = function(pressbutton) {<?php } else { ?>
                        function submitbutton(pressbutton) {<?php } ?>
        if (pressbutton == "saveads" || pressbutton=="applyads")
        {
            var bol_file1=(document.getElementById('filepath01').checked);

            if (document.getElementById('adsname').value == "")
            {
                alert( "<?php echo JText::_('You must provide a Ad name', true); ?>" )
                return;
            }

            if ((document.getElementById('typeofadd').value=="prepost"))
            {
                if(bol_file1==true)
                {
                    document.getElementById('fileoption').value="File"
                    if(uploadqueue.length!="")
                    {
                        alert("<?php echo JText::_('Upload in Progress', true); ?>");
                        return;
                    }

                    if(document.getElementById('id').value=="")
                    {
                        if(document.getElementById('normalvideoform-value').value=="") //&& (document.getElementById('selectadd01').value=="File"))
                        {
                            alert("<?php echo JText::_('You must Upload a file', true); ?>");
                            return;
                        }
                    }

                }

                if(bol_file1==false)
                {

                    document.getElementById('fileoption').value="Url"
                    if(document.getElementById('posturl').value=="")
                    {
                        alert( "<?php echo JText::_('You must provide a Video Url', true); ?>" )
                        return;
                    }
                    if(document.getElementById('posturl').value!="")
                    {
                        document.getElementById('posturl-value').value=document.getElementById('posturl').value;
                    }
                }
            }
            submitform( pressbutton );
            return;
        }
        submitform( pressbutton );
        return;

    }
</script>
<fieldset class="adminform">
    <legend>Select Add Settings</legend>
    <table class="admintable">
        <tr><td class="key" width="200px;">Select Settings</td>
            <td>
                <input type="radio" name="selectadd" id="selectadd01" value="prepost" onclick="checkadd('prepost');" <?php
if ($rs_roll['rs_ads']->typeofadd == "prepost" || $rs_roll['rs_ads']->typeofadd == '') {
    echo 'checked';
}
?> />Pre/Post Roll Add
                <input type="radio" name="selectadd" id="selectadd02" value="mid" onclick="checkadd('mid');" <?php
                       if ($rs_roll['rs_ads']->typeofadd == "mid") {
                           echo 'checked';
                       }
?>/>Mid Roll Add
            </td>
        </tr>
    </table>
</fieldset>
<!-- editing -->
<?php
                       $var1 = "";
                       if (isset($rs_roll['rs_ads']->typeofadd) && $rs_roll['rs_ads']->typeofadd == "mid")
                       {
                           $var1 = 'style="display: none;"';
                       }
?>
                       <fieldset class="adminform" id="videodet" <?php echo $var1; ?>>
                           <legend>Video Details</legend>
                           <table class="admintable">
                               <tr><td class="key" width="200px;">File Path</td>
                                   <td>
                        <input type="radio" name="filepath" id="filepath01" <?php
                       if ($rs_roll['rs_ads']->filepath == "File" || $rs_roll['rs_ads']->filepath == '')
                       {
                           echo 'checked="checked" ';
                       }
                 ?> value="File" onclick="fileads('File');"  />File
                <input type="radio" name="filepath" id="filepath02"<?php
                       if ($rs_roll['rs_ads']->filepath == "Url")
                       {
                           echo 'checked="checked" ';
                       }
                ?>value="Url" onclick="fileads('Url');"/>Url
            </td>
        </tr>
        <tr id="postrollnf" name="postrollnf"><td class="key">Upload Preroll/Post Roll</td>
            <td>
                <div id="f1-upload-form" >
                    <form name="normalvideoform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php echo $rs_roll['rs_ads']->postvideopath; ?></label>
                        <input type="hidden" name="mode" value="video" />
                    </form>
                </div>
                <div id="f1-upload-progress" style="display:none">
                    <img id="f1-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                    <label style="position:absolute;padding-top:3px;padding-left:4px;font-size:14px;font-weight:bold;"  id="f1-upload-filename">PostRoll.flv</label>
                    <span id="f1-upload-cancel">
                        <a style="float:right;padding-right:10px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
                    </span>
                    <label id="f1-upload-status" style="float:right;padding-right:40px;padding-left:20px;margin-left:500px;">Uploading</label>
                    <span id="f1-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                        <b>Upload Failed:</b> User Cancelled the upload
                    </span>

                </div>
                <div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
            </td>
        </tr>
        <tr id="postrollurl">
            <td class="key">
                Preroll/Postroll Url
            </td>
            <td>
                <input type="text" name="posturl"  id="posturl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->postvideopath; ?>"/></td>
        </tr>
    </table>
</fieldset>
<form action="index.php?option=com_contushdvideoshare&layout=ads" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset class="adminForm">
        <legend>Ads </legend>
        <table class="admintable">
        <!--            <tr><td class="key">Ad Name</td><td> <?php //echo $editor->display('adsname', $rs_roll['rs_ads']->adsname, '40', '15', '40', '15',false,$params );      ?> -->
            <tr><td class="key">Ad Title</td><td><input type="text" name="adsname"  id="adsname" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->adsname; ?>" /></td></tr>
            <!--  <tr><td class="key">Ad Description</td><td> <?php //echo $editor->display('adsdesc', $rs_roll['rs_ads']->adsdesc, '40', '15', '40', '15', false, $params);    ?></td></tr> -->
            <!-- <tr><td class="key">Description</td><td><input type="text" name="adsdesc"  id="adsdesc" style="width:300px" maxlength="250" value="<?php //echo $rs_roll['rs_ads']->adsdesc;      ?>" /></td></tr> -->
            <td class="key">Ad Description</td>
            <td>
                <textarea rows="5" cols="40" name="adsdesc" id="adsdesc"><?php echo trim($rs_roll['rs_ads']->adsdesc); ?></textarea>
            </td>
            <tr><td class="key">Target URL </td><td><input type="text" name="targeturl"  id="targeturl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->targeturl; ?>" /></td></tr>
            <tr><td class="key">Click Hits URL </td><td><input type="text" name="clickurl"  id="clickurl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->clickurl; ?>" /></td></tr>
            <tr><td class="key">Impression Hits URL </td><td><input type="text" name="impressionurl"  id="impressionurl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->impressionurl; ?>" /></td></tr>
            <tr><td class="key">Published</td><td>No<input type="radio" name="published" value=0 />Yes<input type="radio" name="published"  value=1  checked="checked" /></td>
            </tr>
        </table>
    </fieldset>
    <input type="hidden" name="id" id="id" value="<?php echo $rs_roll['rs_ads']->id; ?>" />
<!--    <input type="hidden" name="option" value="<?php echo $option; ?>"/>-->
    <input type="hidden" name="typeofadd" id="typeofadd" value="prepost" />
    <input type="hidden" name="task" value="addads" />
    <input type="hidden" name="boxchecked" value="1">
    <input type="hidden" name="submitted" value="true" id="submitted">
    <input type="hidden" name="fileoption" id="fileoption" value="<?php echo $rs_roll['rs_ads']->filepath; ?>" />
    <input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="" />
    <input type="hidden" name="posturl-value" id="posturl-value" value="" />
</form>
<script type="text/javascript" src="<?php echo JURI::base().'components/com_contushdvideoshare/js/adslayout.js';?>"></script>
<script  type="text/javascript">
 function checkadd(recadd)
    {
        if(recadd=="prepost")
        {
            addsetenable();
            document.getElementById('typeofadd').value='prepost';
        }
        if(recadd=="mid")
        {
            addsetdisable();
            document.getElementById('typeofadd').value='mid';
        }

    }
     function addsetenable()
    {
        document.getElementById('videodet').style.display='';
    }
    function addsetdisable()
    {

        document.getElementById('videodet').style.display='none';
    }
</script>
