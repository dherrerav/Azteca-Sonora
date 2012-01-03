<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        adslayout.php
 * @location    /components/com_contushdvideosahre/views/ads/tmpl/adslayout.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Admin Ads uploading  layout
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$rs_roll = $this->adslist;
JHTML::_('script', JURI::base() . "components/com_contushdvideoshare/upload_script.js", false, true);
?>
<script language="JavaScript" type="text/javascript">
    Joomla.submitbutton = function(pressbutton) {
        if (pressbutton == "saveads" || pressbutton=="applyads")
        {
            var f1_upload_filename=(document.getElementById('f1-upload-filename').textContent);
            var bol_file1=(document.getElementById('filepath01').checked);
            var bol_fileselect=(document.getElementById('selectadd01').checked);
            var filepaths1=(document.getElementById('filepaths').textContent);
            if (document.getElementById('adsname').value == "")
            {
                alert( document.getElementById('title_error').value);
                return;
            }

            if ((document.getElementById('typeofadd').value=="prepost"))
            {
                if((bol_file1==true) && (bol_fileselect==true))
                {
                    if((bol_file1==true) && (bol_fileselect==true)&& (f1_upload_filename=="PostRoll.flv") && ((filepaths1=="undefined")||(filepaths1=="")))
                    {
                        alert('You must upload a file ');
                        return;
                    }

                    document.getElementById('fileoption').value="File"
                    if(uploadqueue.length!="")
                    {
                        alert( document.getElementById('progress_error').value);
                        return;
                    }

                    if(document.getElementById('id').value=="")
                    {
                        if(document.getElementById('normalvideoform-value').value=="") //&& (document.getElementById('selectadd01').value=="File"))
                        {
                            alert( document.getElementById('upload_error').value);
                            return;
                        }
                    }
                }

                if(bol_file1==false)
                {
                    document.getElementById('fileoption').value="Url"
                    if(document.getElementById('posturl').value=="")
                    {
                        alert( document.getElementById('url_error').value);
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

<div class="width-60 fltlft">
    <fieldset class="adminform">
        <legend>Select Ad Settings</legend>
        <table class="adminlist">
            <thead>
                <tr>
                    <th>
        		Settings
                    </th>
                    <th>
        		Value
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="2">&#160; </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td class="key" width="200px;">Select Settings</td>
                    <td>  <input type="radio" style="float:none;" name="selectadd" id="selectadd01" value="prepost" onclick="checkadd('prepost');" <?php if ($rs_roll['rs_ads']->typeofadd == "prepost" || $rs_roll['rs_ads']->typeofadd == '') { echo 'checked'; } ?> />Pre/Post-Roll Ad
                          <input type="radio" style="float:none;" name="selectadd" id="selectadd02" value="mid" onclick="checkadd('mid');" <?php if ($rs_roll['rs_ads']->typeofadd == "mid") { echo 'checked'; } ?>/>Mid-Roll Ad
                    </td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>
<!-- editing -->

                    <?php
                        $var1 = "";
                        if (isset($rs_roll['rs_ads']->typeofadd) && $rs_roll['rs_ads']->typeofadd == "mid") {
                            $var1 = 'style="display: none;"';
                        }
                        ?>
    <div class="width-60 fltlft">
        <fieldset class="adminform" id="videodet" <?php echo $var1; ?>>
            <legend>Video Details</legend>
                <table class="adminlist">
                    <thead>
                         <tr>
                            <th> Settings </th>
                            <th> Value </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="2">&#160; </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td class="key" width="200px;">File Path</td>
                            <td> <input type="radio" style="float:none;" name="filepath" id="filepath01" <?php if ($rs_roll['rs_ads']->filepath == "File" || $rs_roll['rs_ads']->filepath == '') { echo 'checked="checked" '; } ?> value="File" onclick="fileads('File');"  />File
                                 <input type="radio" style="float:none;" name="filepath" id="filepath02"<?php if ($rs_roll['rs_ads']->filepath == "Url") { echo 'checked="checked" '; } ?>value="Url" onclick="fileads('Url');"/>Url
                            </td>
                        </tr>
                        <tr id="postrollnf" name="postrollnf">
                            <td class="key">Upload Preroll/Post Roll</td>
                            <td>
                                <div id="f1-upload-form" >
                                    <form name="normalvideoform" method="post" enctype="multipart/form-data" >
                                        <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                        <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                                        <label id="filepaths"><?php echo $rs_roll['rs_ads']->postvideopath; ?></label>
                                        <input type="hidden" name="mode" value="video" />
                                    </form>
                                </div>
                                <div id="f1-upload-progress" style="display:none">
                                    <img id="f1-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                                    <label style="position:absolute;padding-top:3px;padding-left:25px;font-size:14px;font-weight:bold;" id="f1-upload-filename">PostRoll.flv</label>
                                    <span id="f1-upload-cancel">
                                    <a style="float:right;padding-right:10px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
                                    </span>
                                    <label id="f1-upload-status" style="float:right;padding-right:40px;padding-left:20px;margin-left:150px;">Uploading</label>
                                    <span id="f1-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                                    <b>Upload Failed:</b> User Cancelled the upload
                                    </span>
                                </div>
                                <div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
                            </td>
                        </tr>
                        <tr id="postrollurl">
                            <td class="key"> Preroll/Postroll Url  </td>
                            <td> <input type="text" name="posturl"  id="posturl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->postvideopath; ?>"/></td>
                        </tr>
                    </tbody>
           </table>
       </fieldset>
    </div>

<form action="" method="post" name="adminForm" onsubmit="" id="adminForm" enctype="multipart/form-data">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend>Ad Details</legend>
            <table class="adminlist">
                <thead>
                    <tr>
                        <th>
                            Settings
                        </th>
                        <th>
                            Value
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2">&#160; </td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td class="key">Ad Name</td><td><input type="text" name="adsname"  id="adsname" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->adsname; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="key">Ad Description </td>
                        <td> <textarea rows="4" cols="40" style="width:auto;" name="adsdesc" id="adsdesc"><?php echo trim($rs_roll['rs_ads']->adsdesc); ?></textarea> </td>
                    </tr>
                    <tr>
                        <td class="key">Target URL </td>
                        <td><input type="text" name="targeturl"  id="targeturl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->targeturl; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="key">Click Hits URL </td>
                        <td><input type="text" name="clickurl"  id="clickurl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->clickurl; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="key">Impression Hits URL </td>
                        <td><input type="text" name="impressionurl"  id="impressionurl" style="width:300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->impressionurl; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="key">Published</td>
                        <td>
                            Yes<input type="radio" style="float:none;" name="published" value=0 />
                            No<input type="radio" name="published"  value=1  checked="checked" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>
    <input type="hidden" name="id" id="id" value="<?php echo $rs_roll['rs_ads']->id; ?>" />
    <input type="hidden" name="typeofadd" id="typeofadd" value="prepost" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="1">
    <input type="hidden" name="submitted" value="true" id="submitted">
    <input type="hidden" name="fileoption" id="fileoption" value="<?php echo $rs_roll['rs_ads']->filepath; ?>" />
    <input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="" />
    <input type="hidden" name="posturl-value" id="posturl-value" value="" />
    <!-- form validation error variables -->
    <input type="hidden" name="upload_error" id="upload_error" value="<?php echo JText::_('You must Upload a file', true); ?>" >
    <input type="hidden" name="title_error" id="title_error" value="<?php echo JText::_('You must provide a Title', true); ?>">
    <input type="hidden" name="progress_error" id="progress_error" value="<?php echo JText::_('Upload in Progress', true); ?>" >
    <input type="hidden" name="url_error" id="url_error" value="<?php echo JText::_('You must provide a Video Url', true); ?>" >
    <?php echo JHTML::_('form.token'); ?>
</form>
<script language="JavaScript" type="text/javascript">

    if((document.getElementById('fileoption').value == 'File') || (document.getElementById('fileoption').value == ''))
    {
        adsflashdisable();
    }
    if(document.getElementById('fileoption').value == 'Url')
    {
        urlenable();
    }

    function urlenable()
    {
        document.getElementById('postrollnf').style.display='none';
        document.getElementById('postrollurl').style.display='';
    }
    function adsflashdisable()
    {
        document.getElementById('postrollnf').style.display='';
        document.getElementById('postrollurl').style.display='none';
    }
    function fileads(filepath)
    {
        if(filepath=="File")
        {
            adsflashdisable();
            document.getElementById('fileoption').value='File';
        }
        if(filepath=="Url")
        {
            urlenable();
            document.getElementById('fileoption').value='Url';
        }

    }

    /* altering */


    function addsetenable()
    {
        document.getElementById('videodet').style.display='';
    }
    function addsetdisable()
    {

        document.getElementById('videodet').style.display='none';
    }

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
</script>