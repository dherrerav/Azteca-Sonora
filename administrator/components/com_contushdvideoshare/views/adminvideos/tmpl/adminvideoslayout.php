<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        adminvideoslayout.php
 * @location    /components/com_contushdvideosahre/views/adminvideos/tmpl/adminvideoslayout.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Admin Uploaded Videos displaying layout
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$editvideo = $this->editvideo;
$editor = & JFactory::getEditor();
$k = 0;
$uploadscript = JURI::base() . "components/com_contushdvideoshare/upload_script.js";
?>

<script src="<?php echo $uploadscript; ?>" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
    Joomla.submitbutton = function(pressbutton) {
        var form = document.adminForm;
        if (pressbutton == 'CANCEL7')
        {
            submitform( pressbutton );
            return;
        }
        if (pressbutton == 'addvideoupload')
        {
            submitform( pressbutton );
            return;
        }

        // do field validation

        if (pressbutton == "savevideos" || pressbutton=="applyvideos")
        {
            var bol_file1=(document.getElementById('filepath1').checked);
            var bol_file2=(document.getElementById('filepath2').checked);
            var bol_file3=(document.getElementById('filepath3').checked);
            var bol_file4=(document.getElementById('filepath4').checked);
            var streamer_name='';


            var stream_opt=document.getElementsByName('streameroption[]');
            var length_stream=stream_opt.length;
            for(i=0;i<length_stream;i++)
            {
                if(stream_opt[i].checked==true)
                {
                    document.getElementById('streameroption-value').value=stream_opt[i].value;
                    if(stream_opt[i].value=='rtmp')
                    {
                        streamer_name=document.getElementById('streamname').value;
                        document.getElementById('streamerpath-value').value=streamer_name;
                    }
                }
            }
           if (document.getElementById('title').value == "")
            {
                alert( "<?php echo JText::_('You must provide a Title', true); ?>" )
                return;
            }
            {
                if(bol_file1==true)
                {
                    document.getElementById('fileoption').value='File';
                    if(uploadqueue.length!="")
                    {
                        alert("<?php echo JText::_('Upload in Progress', true); ?>");
                        return;
                    }
                    if(document.getElementById('id').value=="")
                    {
                        if(document.getElementById('normalvideoform-value').value=="" && document.getElementById('hdvideoform-value').value=="")
                        {
                            alert("<?php echo JText::_('You must Upload a file', true); ?>");
                            return;
                        }
                    }
                    
                }


                if(bol_file2==true)
                {
                    if(document.getElementById('videourl').value=="")
                    {
                        alert( "<?php echo JText::_('You must provide a Video Url', true); ?>" )
                        return;
                    }
                    document.getElementById('fileoption').value='Url';
                    if(document.getElementById('videourl').value!="")
                        document.getElementById('videourl-value').value=document.getElementById('videourl').value;
                    if(document.getElementById('thumburl').value!="")
                        document.getElementById('thumburl-value').value=document.getElementById('thumburl').value;
                    if(document.getElementById('previewurl').value!="")
                        document.getElementById('previewurl-value').value=document.getElementById('previewurl').value;
                    if(document.getElementById('hdurl').value!="")
                        document.getElementById('hdurl-value').value=document.getElementById('hdurl').value;

                }
                if(bol_file4==true)
                {
                    if(document.getElementById('videourl').value=="")
                    {
                        alert( "<?php echo JText::_('You must provide a Video file', true); ?>" )
                        return;
                    }
                    document.getElementById('fileoption').value='Youtube';
                    if(document.getElementById('videourl').value!="")
                        document.getElementById('videourl-value').value=document.getElementById('videourl').value;
                }

                if(bol_file3==true)
                {
                    document.getElementById('fileoption').value='FFmpeg';
                    if(uploadqueue.length!="")
                    {
                        alert("<?php echo JText::_('Upload in Progress', true); ?>");
                        return;
                    }
                }

            }
            submitform( pressbutton );
            return;
        }
        //  }
        else
        {

            submitform( pressbutton );
            return;
        }
    }
</script>
<script language="javascript">
    document.getElementById('toolbar-box').style.marginTop=120+"px";
</script>
<div  style="position:absolute;top:100px;left:20px;width:97%">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <div style="float:left;width:20%;padding-top:8px;"><img src="components/com_contushdvideoshare/assets/customization_contushdvideoshare.png" alt="" /></div><div style=" padding: 20px 0pt 0pt 50px; float: left; width: 50%;font-size:12px;font-family:Arial, Helvetica, sans-serif;line-height:18px;color:#333333;">
            Do you know that HDVideo Share not just develops Extensions but also provides professional web design and custom development services. We would be glad to help you to design and customize the extension to your business needs.
        </div><div style="float:right;padding:8px 0 0 50px;;text-decoration:underline;color:#0B55C4;"><div><img src="components/com_contushdvideoshare/assets/logo.png" alt="" /></div><div> <div style="padding: 8px 0pt 0pt 10px;float:left;"> <a href="http://www.hdvideoshare.net" target="_blank">Launch hdvideoshare.net</a></div><div style="padding: 8px 0pt 0pt 10px;float:left;"><a href="http://www.hdvideoshare.net/shop/index.php?main_page=contact_us" target="_blank">Contact us</a></div></div></div>
        <div class="clr"></div>
    </div>
    <div class="b">
        <div class="b">
            <div class="b"></div>
        </div>
    </div>
</div>

<div class="width-60 fltlft">
    <fieldset class="adminform">
        <legend>Video</legend>
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
                    <td colspan="2">&#160;
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>Streamer option</td>
                    <td>
                        <input type="radio" style="float:none;"  name="streameroption[]" id="streameroption1"  <?php if ($editvideo['rs_editupload']->streameroption == "None" || $editvideo['rs_editupload']->streameroption == '') { echo 'checked="checked" ';}?> value="None"  checked="checked" onclick="streamer1('None');" />None
                        <input type="radio" style="float:none;" name="streameroption[]" id="streameroption2" <?php if ($editvideo['rs_editupload']->streameroption == "lighttpd") { echo 'checked="checked" '; } ?>value="lighttpd"  onclick="streamer1('lighttpd');" />lighttpd
                        <input type="radio" style="float:none;" name="streameroption[]" id="streameroption3" <?php if ($editvideo['rs_editupload']->streameroption == "rtmp") { echo 'checked="checked" '; } ?> value="rtmp"  onclick="streamer1('rtmp');" />rtmp
                    </td>
                </tr>
                <tr id="stream1" name="stream1">
                    <td>Streamer Path</td>
                    <td>
                        <input type="text" name="streamname"  style="float:none;" id="streamname" style="width:300px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->streamerpath; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="200px;">File Path</td>
                    <td>
                        <input type="radio" name="filepath" style="float:none;" id="filepath1" <?php if ($editvideo['rs_editupload']->filepath == "File" || $editvideo['rs_editupload']->filepath == '') { echo 'checked="checked" '; } ?> value="File" onclick="fileedit('File');"  />File
                        <input type="radio" name="filepath" style="float:none;" id="filepath2"<?php if ($editvideo['rs_editupload']->filepath == "Url") { echo 'checked="checked" '; } ?>value="Url" onclick="fileedit('Url');"/>Url
                        <input type="radio" name="filepath" style="float:none;" id="filepath4"<?php if ($editvideo['rs_editupload']->filepath == "Youtube") { echo 'checked="checked" '; } ?>value="Youtube" onclick="fileedit('Youtube');"/>You Tube / Blip /Meta cafe /Google
                        <input type="radio" name="filepath" style="float:none;" id="filepath3"<?php if ($editvideo['rs_editupload']->filepath == "FFmpeg") { echo 'checked="checked" '; }?>value="FFmpeg" onclick="fileedit('FFmpeg');"/>FFmpeg
                    </td>
                </tr>

                <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1">
                    <td>Upload Video</td>
                    <td>
                        <div id="f1-upload-form" >
                            <form name="normalvideoform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label id="lbl_normal"><?php echo $editvideo['rs_editupload']->videourl; ?></label>

                                <input type="hidden" name="mode" value="video" />
                            </form>
                        </div>
                        <div id="f1-upload-progress" style="display:none">
                            <img id="f1-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                            <label style="position:absolute;padding-top:3px;padding-left:24px;font-size:14px;font-weight:bold;"  id="f1-upload-filename">PostRoll.flv</label>
                            <span id="f1-upload-cancel">
                                <a style="float:right;padding-right:10px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
                            </span>
                            <label id="f1-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
                            <span id="f1-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                                <b>Upload Failed:</b> User Cancelled the upload </span>

                        </div>
                    </td>
                </tr>

                <tr id="ffmpeg_disable_new2" name="ffmpeg_disable_new2">
                    <td>Upload HD Video(optional)</td>
                    <td>
                        <div id="f2-upload-form" >
                            <form name="hdvideoform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php echo $editvideo['rs_editupload']->hdurl; ?></label>
                                <input type="hidden" name="mode" value="video" />
                            </form>
                        </div>
                        <div id="f2-upload-progress" style="display:none">
                            <img id="f2-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                            <label style="position:absolute;padding-top:3px;padding-left:24px;font-size:14px;font-weight:bold;"  id="f2-upload-filename">PostRoll.flv</label>
                            <span id="f2-upload-cancel">
                                <a style="float:right;padding-right:10px;" href="javascript:cancelUpload('hdvideoform');" name="submitcancel">Cancel</a>
                            </span>
                            <label id="f2-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
                            <span id="f2-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                                <b>Upload Failed:</b> User Cancelled the upload
                            </span>
                        </div>
                    </td>
                </tr>
                <tr id="ffmpeg_disable_new3" name="ffmpeg_disable_new3">
                    <td>Upload Thumb Image</td><td>
                        <div id="f3-upload-form" >
                            <form name="thumbimageform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile"  onchange="enableUpload(this.form.name);"/>
                                <input type="button" name="uploadBtn" value="Upload Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php echo $editvideo['rs_editupload']->thumburl; ?></label>
                                <input type="hidden" name="mode" value="image" />
                            </form>
                        </div>
                        <div id="f3-upload-progress" style="display:none">
                            <img id="f3-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                            <label style="position:absolute;padding-top:3px;padding-left:24px;font-size:14px;font-weight:bold;"  id="f3-upload-filename">PostRoll.flv</label>
                            <span id="f3-upload-cancel">
                                <a style="float:right;padding-right:10px;" href="javascript:cancelUpload('thumbimageform');" name="submitcancel">Cancel</a>
                            </span>
                            <label id="f3-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
                            <span id="f3-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                                <b>Upload Failed:</b> User Cancelled the upload
                            </span>

                        </div>

                    </td></tr>

                <tr id="ffmpeg_disable_new4" name="ffmpeg_disable_new4">
                    <td>Upload Preview Image(optional)</td>
                    <td>
                        <div id="f4-upload-form" >
                            <form name="previewimageform" method="post" enctype="multipart/form-data" >

                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php echo $editvideo['rs_editupload']->previewurl; ?></label>
                                <input type="hidden" name="mode" value="image" />
                            </form>
                        </div>
                        <div id="f4-upload-progress" style="display:none">
                            <img id="f4-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                            <label style="position:absolute;padding-top:3px;padding-left:24px;font-size:14px;font-weight:bold;"  id="f4-upload-filename">PostRoll.flv</label>
                            <span id="f4-upload-cancel">
                                <a style="float:right;padding-right:10px;" href="javascript:cancelUpload('previewimageform');" name="submitcancel">Cancel</a>
                            </span>
                            <label id="f4-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
                            <span id="f4-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                                <b>Upload Failed:</b> User Cancelled the upload
                            </span>

                        </div>
                        <div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
                    </td>
                </tr>
                <tr id="ffmpeg_disable_new5" name="ffmpeg_disable_edit5" style="width:200px;">
                    <td>Video Url</td>
                    <td><input type="text" name="videourl"  id="videourl" size="100" maxlength="250" value="<?php echo $editvideo['rs_editupload']->videourl; ?>"/>
                    </td>
                </tr>
                <tr id="ffmpeg_disable_new6" name="ffmpeg_disable_edit6">
                    <td>Thumb Url</td>
                    <td><input type="text" name="thumburl"  id="thumburl" size="100" maxlength="250" value="<?php echo $editvideo['rs_editupload']->thumburl; ?>"/> </td>
                </tr>
                <tr id="ffmpeg_disable_new7" name="ffmpeg_disable_edit7"><td>Preview Url</td>
                    <td><input type="text" name="previewurl"  id="previewurl" size="100" maxlength="250" value="<?php echo $editvideo['rs_editupload']->previewurl; ?>"/> </td>
                </tr>
                <tr id="ffmpeg_disable_new8" name="ffmpeg_disable_edit8"><td>Hd Url</td>
                    <td><input type="text" name="hdurl"  id="hdurl" size="100" maxlength="250" value="<?php echo $editvideo['rs_editupload']->hdurl; ?>"/> </td>
                </tr>
                <tr id="fvideos" name="fvideos">
                    <td>Upload Video</td>
                    <td>
                        <div id="f5-upload-form" >
                            <form name="ffmpegform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php echo $editvideo['rs_editupload']->videourl; ?></label>
                                <input type="hidden" name="mode" value="video_ffmpeg" />
                            </form>
                        </div>
                        <div id="f5-upload-progress" style="display:none">
                            <img id="f5-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                            <label style="position:absolute;padding-top:3px;padding-left:24px;font-size:14px;font-weight:bold;"  id="f5-upload-filename">PostRoll.flv</label>
                            <span id="f5-upload-cancel">
                                <a style="float:right;padding-right:10px;" href="javascript:cancelUpload('ffmpegvideoform');" name="submitcancel">Cancel</a>
                            </span>
                            <label id="f5-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
                            <span id="f5-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                                <b>Upload Failed:</b> User Cancelled the upload
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>
<form action="index.php?option=com_contushdvideoshare&layout=adminvideos<?php echo (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? "&actype=" . JRequest::getVar('actype', '', 'get', 'string') : ""; ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="width-40 fltlft">
        <fieldset class="adminform">
            <legend>Ads Settings</legend>
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
                        <td colspan="2">&#160;</td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr><td>Postroll ads</td>
                        <td>
                            <input type="radio" name="postrollads"   style="float:none;" id="postrollads"  <?php if ($editvideo['rs_editupload']->postrollads == '1') { echo "inside "; { echo 'checked="checked" '; } }?> value="1"  onclick="postroll('1');"/>Enable
                            <input type="radio" name="postrollads"   style="float:none;" id="postrollads" <?php if ($editvideo['rs_editupload']->postrollads == '0' || $editvideo['rs_editupload']->postrollads == '') { echo 'checked="checked" '; } ?> value="0" onclick="postroll('0');"/>Disable
                        </td>
                    </tr>
                    <tr id="postroll">
                        <td class="key">Postroll Name</td>
                        <td>
                            <select name="postrollid" id="postrollid" >
                                <option value="0" id="50">Default Ads</option>
                                <?php
                                    $n = count($editvideo['rs_ads']);
                                    if ($n >= 1) {
                                    for ($i = 0; $i < $n; $i++) {
                                        $row_ads = &$editvideo['rs_ads'][$i];
                                ?>
                                    <option value="<?php echo $row_ads->id; ?>" id="5<?php echo $row_ads->id; ?>" name="<?php echo $row_ads->id; ?>" ><?php echo $row_ads->adsname; ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                            <?php
                            if ($editvideo['rs_editupload']->postrollid) {
                                echo '<script>document.getElementById("5' . $editvideo['rs_editupload']->postrollid . '").selected="selected"</script>';
                            }
                            ?>
                            </td>
                    </tr>
                    <tr>
                        <td>Preroll ads</td>
                        <td>
                            <input type="radio" name="prerollads"   style="float:none;" id="prerollads"  <?php
                            if ($editvideo['rs_editupload']->prerollads == '1') { echo 'checked="checked" '; } ?>  value="1"  onclick="preroll('1');"/>Enable
                            <input type="radio" name="prerollads"   style="float:none;" id="prerollads" <?php if ($editvideo['rs_editupload']->prerollads == '0' || $editvideo['rs_editupload']->prerollads == '') { echo 'checked="checked" '; } ?> value="0"  onclick="preroll('0');"/>Disable
                        </td>
                    </tr>
                    <tr id="preroll">
                        <td class="key">Preroll Name</td>
                        <td>
                            <select name="prerollid" id="prerollid" >
                                <option value="0" id="60">Default Ads</option>
                            <?php
                            $n = count($editvideo['rs_ads']);
                            if ($n >= 1) {
                                for ($v = 0; $v < $n; $v++) {
                                    $row_ads = &$editvideo['rs_ads'][$v];
                             ?>
                                    <option value="<?php echo $row_ads->id; ?>" id="6<?php echo $row_ads->id; ?>" name="<?php echo $row_ads->id; ?>"><?php echo $row_ads->adsname; ?></option>
                            <?php
                                }
                            }
                            ?>
                            </select>
                            <?php
                            if ($editvideo['rs_editupload']->prerollid) {
                                echo '<script>document.getElementById("6' . $editvideo['rs_editupload']->prerollid . '").selected="selected"</script>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>MidRoll ads</td>
                        <td>
                            <input type="radio" style="float:none;"  name="midrollads"  id="midrollads"  <?php if ($editvideo['rs_editupload']->midrollads == '1') { echo 'checked="checked" '; } ?>  value="1"/>Enable
                            <input type="radio"  style="float:none;"  name="midrollads"  id="midrollads" <?php if ($editvideo['rs_editupload']->midrollads == '0' || $editvideo['rs_editupload']->midrollads == '') { echo 'checked="checked" '; } ?> value="0"  />Disable
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>

    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend>Video Info</legend>
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
                        <td width="17%">Title</td>
                        <td width="83%">
                            <input type="text" name="title"  id="title" style="width:300px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->title; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key">Description </td>
                        <td>
                            <textarea rows="4" cols="40" style="width:auto;" name="description" id="description"><?php echo trim($editvideo['rs_editupload']->description); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Video Tags</td>
                        <td> <input type="text" name="tags"  id="tags" style="width:300px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->tags; ?>" /> </td>
                    </tr>
                    <tr>
                        <td>Target Url</td>
                        <td><input type="text" name="targeturl"  id="targeturl" style="width:300px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->targeturl; ?>" /></td>
                    </tr>
                <script language="JavaScript">
                    var user = new Array(<?php echo count($editvideo['rs_play']); ?>);
                    <?php
                        for ($i = 0; $i < count($editvideo['rs_play']); $i++) {
                            $playlistnames = $editvideo['rs_play'][$i];
                    ?>
                        user[<?php echo $i; ?>]= new Array(2);
                        user[<?php echo $i; ?>][1]= "<?php echo $playlistnames->id; ?>";
                        user[<?php echo $i; ?>][0]= "<?php echo $playlistnames->category; ?>";
                    <?php
                        }
                    ?>
                </script>
                <tr>
                    <td class="key">Playlist</td>
                    <td>
                        <input type="radio" name="playliststart"  style="float:none;" id="playliststart1" value="AF"  <?php echo 'checked'; ?> onchange="select_alphabet('AF')" />&nbsp;&nbsp;A-F
                        <input type="radio" name="playliststart"  style="float:none;" id='playliststart2' value="GL"  <?php echo 'checked'; ?> onchange="select_alphabet('GL')" />&nbsp;&nbsp;G-L
                        <input type="radio" name="playliststart"  style="float:none;" id='playliststart3' value="MR"  <?php echo 'checked'; ?> onchange="select_alphabet('MR')" />&nbsp;&nbsp;M-R
                        <input type="radio" name="playliststart"  style="float:none;" id='playliststart4' value="SV"  <?php echo 'checked'; ?> onchange="select_alphabet('SV')" />&nbsp;&nbsp;S-V
                        <input type="radio" name="playliststart"  style="float:none;" id='playliststart5' value="WZ"  <?php echo 'checked'; ?> onchange="select_alphabet('WZ')" />&nbsp;&nbsp;W-Z
                    </td>
                </tr>
                <tr>
                    <td class="key">Category</td>
                    <td>
                        <select name="playlistid" id="playlistid" >
                            <option value="0" id="0">None</option>
                            <?php
                            $n = count($editvideo['rs_play']);
                            if ($n >= 1) {
                                for ($i = 0; $i < $n; $i++) {
                                    $row_play = &$editvideo['rs_play'][$i];
                            ?>
                                    <option value="<?php echo $row_play->id; ?>" id="<?php echo $row_play->id; ?>"><?php echo $row_play->category ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <?php
                            if ($editvideo['rs_editupload']->playlistid) {
                                echo '<script>document.getElementById("' . $editvideo['rs_editupload']->playlistid . '").selected="selected"</script>';
                            }
                        ?>

                        </td>
                </tr>
                <tr>
                    <td>Order</td>
                    <td><input type="text" name="ordering"  id="ordering" style="width:50px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->ordering; ?>"/></td>
                </tr>

                <tr>
                    <td>Download</td>
                    <td>
                        <input type="radio" name="download"   style="float:none;" id="download"  <?php if ($editvideo['rs_editupload']->download == '1' || $editvideo['rs_editupload']->download == '') { echo 'checked="checked" '; } ?>  value="1" />Yes
                        <input type="radio" name="download"   style="float:none;" id="download" <?php if ($editvideo['rs_editupload']->download == '0') { echo 'checked="checked" '; } ?>  value="0" />No
                    </td>
                </tr>
                <?php $baseUrl = JURI::base() . "components/com_contushdvideoshare/"; ?>
                <tr>
                    <td>Published</td>
                    <td>
                        <input type="radio" name="published"  style="float:none;"  id="published"  <?php if ($editvideo['rs_editupload']->published == '1' || $editvideo['rs_editupload']->published == '') { echo 'checked="checked" '; } ?>  value="1" />Yes
                        <input type="radio" name="published"  style="float:none;"  id="published" <?php if ($editvideo['rs_editupload']->published == '0') { echo 'checked="checked" '; } ?>  value="0" />No
                    </td>
                </tr>
                </tbody>
            </table>
        </fieldset>
    </div>
    <input type="hidden" name="id" id="id" value="<?php echo $editvideo['rs_editupload']->id; ?>" />
    <input type="hidden" name="task"/>
    <!-- The below code is to check wether the particular video ,thumbimages,previewimages & hd is edited or not Starts-->
    <?php
        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.title AS group_name')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $ugp->group_name;
        if (isset($editvideo['rs_editupload']->memberid))
            $videosid = $editvideo['rs_editupload']->memberid;
        else
            $videosid= $userid;
        if (isset($editvideo['rs_editupload']->memberid))
            $videostype = $editvideo['rs_editupload']->usergroupname;
        else
            $videostype=$ugp->group_name;
    ?>
        <input type="hidden" name="newupload" id="newupload" value="1">
        <input type="hidden" name="fileoption" id="fileoption" value="<?php echo $editvideo['rs_editupload']->filepath; ?>" />
        <input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="" />
        <input type="hidden" name="hdvideoform-value" id="hdvideoform-value" value="" />
        <input type="hidden" name="thumbimageform-value" id="thumbimageform-value" value="<?php echo $editvideo['rs_editupload']->thumburl; ?>" />
        <input type="hidden" name="previewimageform-value" id="previewimageform-value" value="<?php echo $editvideo['rs_editupload']->previewurl; ?>" />
        <input type="hidden" name="ffmpegform-value" id="ffmpegform-value" value="" />
        <input type="hidden" name="midrollid" id="hid-midrollid"  value="" />
        <input type="hidden" name="videourl-value" id="videourl-value" value="" />
        <input type="hidden" name="thumburl-value" id="thumburl-value" value="" />
        <input type="hidden" name="previewurl-value" id="previewurl-value" value="" />
        <input type="hidden" name="hdurl-value" id="hdurl-value" value="" />
        <input type="hidden" name="streameroption-value" id="streameroption-value" value="<?php echo $editvideo['rs_editupload']->streameroption; ?>" />
        <input type="hidden" name="streamerpath-value" id="streamerpath-value" value="" />
        <input type="hidden" name="memberid" id="memberid" value="<?php echo $videosid; ?>" />
        <input type="hidden" name="usergroupname" id="usergroupname" value="<?php echo $videostype; ?>" />
        <input type="hidden" name="mode1" id="mode1" value="<?php echo $editvideo['rs_editupload']->filepath; ?>" />
        <input type="hidden" name="submitted" value="true" id="submitted">
<?php echo JHTML::_('form.token'); ?>
</form>
<script language="javascript" >
    document.getElementById('fileoption').value='File';
    document.getElementById('streameroption1').checked==true;
    document.getElementById('stream1').style.display='none';
    document.getElementById('postroll').style.display='none';
    document.getElementById('preroll').style.display='none';
    if(document.getElementById('prerollads').checked==1)
        preroll(1);
    else
        preroll(0) ;

    if(document.getElementById('postrollads').checked==1)
        postroll(1);
    else
        postroll(0) ;

    if(document.getElementById('mode1').value == 'Youtube')
    {
        withoutflashhide();
        urlvisible();
        document.getElementById('ffmpeg_disable_new6').style.display="none";
        document.getElementById('ffmpeg_disable_new7').style.display="none";
        document.getElementById('ffmpeg_disable_new8').style.display="none";
        document.getElementById('fvideos').style.display="none";
    }

    if(document.getElementById('mode1').value == 'File')
    {
        withoutflashvisible();
        urlhide();
        document.getElementById('fvideos').style.display="none";
    }

    if(document.getElementById('mode1').value == 'FFmpeg')
    {
        urlhide();
        document.getElementById('fvideos').style.display="";
    }
    if(document.getElementById('mode1').value == 'Url')
    {

        if(document.getElementById('streameroption-value').value=="rtmp")
           document.getElementById('stream1').style.display='';
        withoutflashhide();
        urlvisible();
        document.getElementById('fvideos').style.display="none";
    }
    if(document.getElementById('mode1').value == '')
    {
        withoutflashvisible();
        urlhide();
        document.getElementById('fvideos').style.display="none";
    }
    function urlhide()
    {
        document.getElementById('ffmpeg_disable_new5').style.display="none";
        document.getElementById('ffmpeg_disable_new6').style.display="none";
        document.getElementById('ffmpeg_disable_new7').style.display="none";
        document.getElementById('ffmpeg_disable_new8').style.display="none";
    }

    function urlvisible()
    {
        document.getElementById('ffmpeg_disable_new5').style.display="";
        document.getElementById('ffmpeg_disable_new6').style.display="";
        document.getElementById('ffmpeg_disable_new7').style.display="";
        document.getElementById('ffmpeg_disable_new8').style.display="";
    }

    function withoutflashhide()
    {
        document.getElementById('ffmpeg_disable_new1').style.display="none";
        document.getElementById('ffmpeg_disable_new2').style.display="none";
        document.getElementById('ffmpeg_disable_new3').style.display="none";
        document.getElementById('ffmpeg_disable_new4').style.display="none";
    }

    function withoutflashvisible()
    {
        document.getElementById('ffmpeg_disable_new1').style.display="";
        document.getElementById('ffmpeg_disable_new2').style.display="";
        document.getElementById('ffmpeg_disable_new3').style.display="";
        document.getElementById('ffmpeg_disable_new4').style.display="";
    }

    function fileedit(file_var)
    {
        if(file_var=='File')
        {
            withoutflashvisible();
            urlhide();
            document.getElementById('fvideos').style.display="none";
            document.getElementById('fileoption').value='File';
        }
        else if(file_var=='Url')
        {
            withoutflashhide();
            urlvisible();
            document.getElementById('fvideos').style.display="none";
            document.getElementById('fileoption').value='Url';
        }
        else if(file_var=='Youtube')
        {
            withoutflashhide();
            urlvisible();
            document.getElementById('ffmpeg_disable_new6').style.display="none";
            document.getElementById('ffmpeg_disable_new7').style.display="none";
            document.getElementById('ffmpeg_disable_new8').style.display="none";
            document.getElementById('fvideos').style.display="none";
            document.getElementById('fileoption').value='Youtube';
        }
        else if(file_var=='FFmpeg')
        {
            withoutflashhide();
            urlhide();
            document.getElementById('fvideos').style.display="";
            document.getElementById('fileoption').value='FFmpeg';
        }
    }

    function streamer1(streamername)
    {
        // alert(streamername);
        if(streamername=="None")
        {
            document.getElementById('stream1').style.display='none';
            document.getElementById("filepath1").checked=true;
            document.getElementById("filepath1").disabled=false;
            document.getElementById("filepath3").disabled=false;
            document.getElementById("filepath4").disabled=false;
            document.getElementById('fileoption').value='File';
            withoutflashvisible();
            urlhide();

        }

        if(streamername=="lighttpd")
        {
            document.getElementById('stream1').style.display='none';
            document.getElementById("filepath2").checked=true;
            document.getElementById("filepath1").disabled=true;
            document.getElementById("filepath3").disabled=true;
            document.getElementById("filepath4").disabled=true;
            document.getElementById('fileoption').value='Url';
            withoutflashhide();
            urlvisible();
        }
        else if(streamername=="rtmp")
        {
            document.getElementById('stream1').style.display='';
            document.getElementById("filepath2").checked=true;
            document.getElementById("filepath1").disabled=true;
            document.getElementById("filepath3").disabled=true;
            document.getElementById("filepath4").disabled=true;
            document.getElementById('fileoption').value='Url';
            withoutflashhide();
            urlvisible();
        }
    }


    function getValue1()
    {
        var var_up1;

        var_up1='<input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" /><input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />';
        document.getElementById('var_up1').innerHTML=var_up1;

    }
    function getValue2()
    {
        var var_up2;
        var_up2='<input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" /><input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />';
        document.getElementById('fvideos').value='1';
        document.getElementById('var_up2').innerHTML=var_up2;
    }
    function getValue3()
    {
        var var_up3;
        var_up3='<input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" /><input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />';
        document.getElementById('fthumb').value='1';
        document.getElementById('var_up3').innerHTML=var_up3;
    }
    function getValue4()
    {
        var var_up4;
        var_up4='<input type="file" name="previewurl" id="previewurl" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :.jpg,.png,.gif</label>';
        document.getElementById('fpreview').value='1';
        document.getElementById('var_up4').innerHTML=var_up4;
    }

    function getValue5()
    {
        var var_up5;
        var_up5='<input type="file" name="hdurl" id="hdurl" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :FLV,MP3, MP4, M4V, M4A, MOV, Mp4v, F4V </label>';
        document.getElementById('fhd').value='1';
        document.getElementById('var_up5').innerHTML=var_up5;
    }
    
    function postroll(postvalue)
    {
        if(postvalue==0)
            document.getElementById("postroll").style.display='none';
        if(postvalue==1)
            document.getElementById("postroll").style.display='';
    }

    function preroll(prevalue)
    {
        if(prevalue==0)
            document.getElementById("preroll").style.display='none';
        if(prevalue==1)
            document.getElementById("preroll").style.display='';
    }

    function select_alphabet(playlistbyalphabets)
    {
        var rad_val_all="";
        var rad_val_alphabet="";
        document.getElementById('playlistid').innerHTML="";
        var final_array=new Array();
        var v_array1 = ["A", "B", "C", "D", "E","F","a","b","c","d","e","f"];
        var v_array2 = ["G", "H", "I", "J", "K","L","g","h","i","j","k","l"];
        var v_array3 = ["M", "N", "O", "P", "Q","R","m","n","o","p","q","r"];
        var v_array4 = ["S", "T", "U", "V", "s","t","u","v"];
        var v_array5 = ["W", "X", "Y", "Z", "w","x","y","z"];
        for (var i=0; i < document.getElementsByName('displayplaylist').length; i++)
        {
            if (document.getElementsByName('displayplaylist')[i].checked)
            {
                rad_val_all = document.getElementsByName('displayplaylist')[i].value;
            }
        }

        for (var j=0; j < document.getElementsByName('playliststart').length; j++)
        {
            if (document.getElementsByName('playliststart')[j].checked)
            {
                rad_val_alphabet = document.getElementsByName('playliststart')[j].value;
            }
        }
        if(rad_val_all==2)
        {
            if(user.length>25)
                total_length=25;
            else
                total_length=user.length;
            final_array=user;
            final_array.sort();
        }
        else
        {
            total_length=user.length;
            final_array=user;
            final_array.sort();
        }
        
        n=0;
        for (var m=0; m < total_length; m++)
        {
            if(rad_val_alphabet=='AF')
            {
                first_letter=final_array[m][0];
                first_letter1=first_letter.charAt(0);
                if(v_array1.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++]=new Option(final_array[m][0],final_array[m][1]);
            }
            if(rad_val_alphabet=='GL')
            {
                first_letter=final_array[m][0];
                first_letter1=first_letter.charAt(0);
                if(v_array2.in_array(first_letter1))
                document.getElementById('playlistid').options[n++]=new Option(final_array[m][0],final_array[m][1]);
            }
            if(rad_val_alphabet=='MR')
            {
                first_letter=final_array[m][0];
                first_letter1=first_letter.charAt(0);
                if(v_array3.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++]=new Option(final_array[m][0],final_array[m][1]);
           }

            if(rad_val_alphabet=='SV')
            {
                first_letter=final_array[m][0];
                first_letter1=first_letter.charAt(0);
                if(v_array4.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++]=new Option(final_array[m][0],final_array[m][1]);

            }
            if(rad_val_alphabet=='WZ')
            {
                first_letter=final_array[m][0];
                first_letter1=first_letter.charAt(0);
                if(v_array5.in_array(first_letter1))
                    document.getElementById('playlistid').options[n++]=new Option(final_array[m][0],final_array[m][1]);

            }
        }
    }
    Array.prototype.in_array = function(p_val) {
        for(var i = 0, l = this.length; i < l; i++) {
            if(this[i] == p_val) {
                return true;
            }
        }
        return false;
    }
</script>