<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date : December 16 2010
*/
 // no direct access
defined('_JEXEC') or die('Restricted access');
$editVideo = $this->editvideo;
$editor =& JFactory::getEditor();
$k = 0;
$uploadscript = JURI::base().'components/com_contushdvideoshare/upload_script.js';
$usergroups = $editVideo['user_groups'];
$user = &JFactory::getUser();
//echo $access = $user->get('gid',0); die;

?>

<style>fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button {float:none;}
form {float:left;}
</style>
<script src="<?php echo $uploadscript; ?>" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
 <?php if(version_compare(JVERSION,'1.6.0','ge'))
        { ?>
            Joomla.submitbutton = function(pressbutton){ <?php }else  { ?>
    function submitbutton(pressbutton) {<?php
    } ?>


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
                alert( "<?php echo JText::_( 'You must provide a Title', true ); ?>" )
                return;
            }

            if (document.getElementById('playlistid').value == 0)
            {
                alert( "<?php echo JText::_( 'You must select a category', true ); ?>" )
                return;
            }


            {
                if(bol_file1==true)
                {
                    document.getElementById('fileoption').value='File';
                    if(uploadqueue.length!="")
                    {
                        alert("<?php echo JText::_('Upload in Progress',true);?>");
                        return;
                    }
                       if(document.getElementById('id').value=="")
                       {
                        if(document.getElementById('normalvideoform-value').value=="" && document.getElementById('hdvideoform-value').value=="")
                        {
                        alert("<?php echo JText::_('You must Upload a file',true);?>");
                        return;
                        }
                        }

                }


                if(bol_file2==true)
                {
                    if(document.getElementById('videourl').value=="")
                    {
                        alert( "<?php  echo JText::_( 'You must provide a Video Url', true ); ?>" )
                        return;
                    }
                    else
                     {
                        var theurl=document.getElementById("videourl").value;

                         var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}|http:\/\//
                         if (!tomatch.test(theurl))
                         {
                             for(i=0;i<length_stream;i++)
                            {
                                if(stream_opt[i].checked==true)
                                {
                                    if(stream_opt[i].value!='rtmp')
                                    {
                                       alert( "<?php echo JText::_( 'Please Enter Valid  url', true ); ?>" )
                                       document.getElementById("videourl").focus();
                                        return false;
                                    }
                                }
                           }

                         }

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
                        alert( "<?php echo JText::_( 'You must provide a Video file', true ); ?>" )
                        return;
                    }
                    else
                     {
                        var theurl=document.getElementById("videourl").value;

                         var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/
                         if (tomatch.test(theurl))
                         {
                                   document.getElementById('fileoption').value='Youtube';
                                    if(document.getElementById('videourl').value!="")
                                    document.getElementById('videourl-value').value=document.getElementById('videourl').value;
                         }
                         else
                         {
                               alert( "<?php echo JText::_( 'Please Enter Valid youtube or vimeo url', true ); ?>" )
                             document.getElementById("videourl").focus();
                             return false;
                         }
                    }
                }

                if(bol_file3==true)
                {
                document.getElementById('fileoption').value='FFmpeg';
                    if(uploadqueue.length!="")
                    {
                        alert("<?php echo JText::_('Upload in Progress',true);?>");
                        return;
                    }
                }

            }
            submitform( pressbutton );
            return;
        }

        else
        {

            submitform( pressbutton );
            return;
        }
    }

</script>
<fieldset class="adminform">
    <legend>Video </legend>
    <table class="adminlist">
<?php
    $streamerOptionNone = '';
    $streamerOptionLighthttpd = '';
    $streamerOptionRtmp = '';
    $filePath = '';
    $filePathUrl = '';
    $filePathYoutube = '';
    $filePathFfmpeg = '';
    if($editVideo['rs_editupload']->streameroption == 'None' ||$editVideo['rs_editupload']->streameroption == '')
        {
          $streamerOptionNone = 'checked="checked" ';

        }
     if($editVideo['rs_editupload']->streameroption == 'lighttpd')
        {
          $streamerOptionLighthttpd = 'checked="checked" ';

        }
     if($editVideo['rs_editupload']->streameroption=="rtmp")
        {

         $streamerOptionRtmp = 'checked="checked" ';

        }
      if($editVideo['rs_editupload']->filepath == 'File' ||$editVideo['rs_editupload']->filepath == '')
       {
          $filePath = 'checked="checked" ';

       }
      if($editVideo['rs_editupload']->filepath == 'Url')
       {
          $filePathUrl = 'checked="checked" ';

       }
     if($editVideo['rs_editupload']->filepath == 'Youtube')
       {
         $filePathYoutube = 'checked="checked" ';

       }
      if($editVideo['rs_editupload']->filepath == 'FFmpeg')
       {
          $filePathFfmpeg = 'checked="checked" ';

       }
?>
        <tr>
            <td>Streamer option</td>
            <td>

                <input type="radio" name="streameroption[]" id="streameroption1" <?php echo $streamerOptionNone; ?> value="None"  checked="checked" onclick="streamer1('None');" />None
                <input type="radio" name="streameroption[]" id="streameroption2" <?php echo $streamerOptionLighthttpd; ?>value="lighttpd"  onclick="streamer1('lighttpd');" />lighttpd
                <input type="radio" name="streameroption[]" id="streameroption3" <?php echo $streamerOptionRtmp; ?> value="rtmp"  onclick="streamer1('rtmp');" />rtmp
            </td>
        </tr>

        <tr id="stream1" name="stream1"><td>Streamer Path</td>
            <td>
                <input type="text" name="streamname"  id="streamname" style="width:300px" maxlength="250" value="<?php echo $editVideo['rs_editupload']->streamerpath ;?>" />
            </td>
        </tr>
        <tr><td width="200px;">File Path</td>
            <td>
                <input type="radio" name="filepath" id="filepath1" <?php echo $filePath; ?> value="File" onclick="fileedit('File');"  />File
                <input type="radio" name="filepath" id="filepath2"<?php echo $filePathUrl; ?>value="Url" onclick="fileedit('Url');"/>Url
                <input type="radio" name="filepath" id="filepath4"<?php echo $filePathYoutube; ?>value="Youtube" onclick="fileedit('Youtube');"/>You Tube / Vimeo
                <input type="radio" name="filepath" id="filepath3"<?php echo $filePathFfmpeg; ?>value="FFmpeg" onclick="fileedit('FFmpeg');"/>FFmpeg
        </td></tr>

        <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"><td>Upload Video</td>
            <td>
                <div id="f1-upload-form" >
                    <form name="normalvideoform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label id="lbl_normal"><?php echo $editVideo['rs_editupload']->videourl;?></label>

                        <input type="hidden" name="mode" value="video" />
                    </form>
                </div>
                <div id="f1-upload-progress" style="display:none">
                    <label style="position: absolute;padding-top: 1px;width: auto;font-size: 14px;font-weight: bold;margin: 0;"  id="f1-upload-filename">PostRoll.flv</label>
                    <img style="float:none;padding: 0;margin: 0;" id="f1-upload-image" src='components/com_contushdvideoshare/images/empty.gif' alt="Uploading" />
                    <span id="f1-upload-cancel">
                        <a style="float:right;padding-right:10px;padding-top: 5px;padding-left: 5px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
                    </span>
                    <label id="f1-upload-status" style="float:right;width: auto;">Uploading</label>
                    <span id="f1-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                        <b>Upload Failed:</b> User Cancelled the upload
                    </span>
                </div>
        </td></tr>
        <tr id="ffmpeg_disable_new2" name="ffmpeg_disable_new2"> <td>Upload HD Video(optional)</td>
            <td>
                <div id="f2-upload-form" >
                    <form name="hdvideoform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload HD Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php echo $editVideo['rs_editupload']->hdurl;?></label>
                        <input type="hidden" name="mode" value="video" />
                    </form>
                </div>
                <div id="f2-upload-progress" style="display:none">
                    <label style="position: absolute;padding-top: 1px;width: auto;font-size: 14px;font-weight: bold;margin: 0;"  id="f2-upload-filename">PostRoll.flv</label>
                    <img style="float:none;padding: 0;margin: 0;" id="f2-upload-image" src='components/com_contushdvideoshare/images/empty.gif' alt="Uploading" />
                    <span id="f2-upload-cancel">
                        <a style="float:right;padding-right:10px;padding-top: 5px;padding-left: 5px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
                    </span>
                    <label id="f2-upload-status" style="float:right;width: auto;">Uploading</label>
                    <span id="f2-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                        <b>Upload Failed:</b> User Cancelled the upload
                    </span>
                </div>
        </td></tr>
        <tr id="ffmpeg_disable_new3" name="ffmpeg_disable_new3"><td>Upload Thumb Image</td><td>
                <div id="f3-upload-form" >
                    <form name="thumbimageform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile"  onchange="enableUpload(this.form.name);"/>
                        <input type="button" name="uploadBtn" value="Upload Thumb Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php echo $editVideo['rs_editupload']->thumburl;?></label>
                        <input type="hidden" name="mode" value="image" />
                    </form>
                </div>
                <div id="f3-upload-progress" style="display:none">
                    <label style="position: absolute;padding-top: 1px;width: auto;font-size: 14px;font-weight: bold;margin: 0;"  id="f3-upload-filename">PostRoll.flv</label>
                    <img style="float:none;padding: 0;margin: 0;" id="f3-upload-image" src="components/com_contushdvideoshare/images/empty.gif" alt="Uploading" />
                    <span id="f3-upload-cancel">
                        <a style="float:right;padding-right:10px;padding-top: 5px;padding-left: 5px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
                    </span>
                    <label id="f3-upload-status" style="float:right;width: auto;">Uploading</label>
                    <span id="f3-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                        <b>Upload Failed:</b> User Cancelled the upload
                    </span>
                </div>
        </td></tr>

        <tr id="ffmpeg_disable_new4" name="ffmpeg_disable_new4"><td>Upload Preview Image(optional)</td><td>
                <div id="f4-upload-form" >
                    <form name="previewimageform" method="post" enctype="multipart/form-data" >

                        <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload Preview Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php echo $editVideo['rs_editupload']->previewurl;?></label>
                        <input type="hidden" name="mode" value="image" />
                    </form>
                </div>
                <div id="f4-upload-progress" style="display:none">
                    <label style="position: absolute;padding-top: 1px;width: auto;font-size: 14px;font-weight: bold;margin: 0;"  id="f4-upload-filename">PostRoll.flv</label>
                    <img style="float:none;padding: 0;margin: 0;" id="f4-upload-image" src='components/com_contushdvideoshare/images/empty.gif' alt="Uploading" />
                    <span id="f4-upload-cancel">
                        <a style="float:right;padding-right:10px;padding-top: 5px;padding-left: 5px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
                    </span>
                    <label id="f4-upload-status" style="float:right;width: auto;">Uploading</label>
                    <span id="f4-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                        <b>Upload Failed:</b> User Cancelled the upload
                    </span>
                </div>
                <div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
        </td></tr>
        <tr id="ffmpeg_disable_new5" name="ffmpeg_disable_edit5" style="width:200px;">
            <td>Video Url</td>
            <td><input type="text" name="videourl"  id="videourl" size="100" maxlength="250" value="<?php echo $editVideo['rs_editupload']->videourl;?>"/>
            </td>
        </tr>
        <tr id="ffmpeg_disable_new6" name="ffmpeg_disable_edit6"><td>Thumb Url</td>
            <td><input type="text" name="thumburl"  id="thumburl" size="100" maxlength="250" value="<?php echo $editVideo['rs_editupload']->thumburl;?>"/>
        </td></tr>
        <tr id="ffmpeg_disable_new7" name="ffmpeg_disable_edit7"><td>Preview Url</td>
            <td><input type="text" name="previewurl"  id="previewurl" size="100" maxlength="250" value="<?php echo $editVideo['rs_editupload']->previewurl;?>"/>
        </td></tr>
        <tr id="ffmpeg_disable_new8" name="ffmpeg_disable_edit8"><td>Hd Url</td>
            <td><input type="text" name="hdurl"  id="hdurl" size="100" maxlength="250" value="<?php echo $editVideo['rs_editupload']->hdurl;?>"/>
        </td></tr>
        <tr id="fvideos" name="fvideos"> <td>Upload Video</td>
            <td>
                <div id="f5-upload-form" >
                    <form name="ffmpegform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php echo $editVideo['rs_editupload']->videourl;?></label>
                        <input type="hidden" name="mode" value="video_ffmpeg" />
                    </form>
                </div>
                <div id="f5-upload-progress" style="display:none">
                    <img id="f5-upload-image" src='components/com_contushdvideoshare/images/empty.gif' alt="Uploading" />
                    <label style="position:absolute;padding-top:3px;font-size:14px;font-weight:bold;"  id="f5-upload-filename">PostRoll.flv</label>
                    <span id="f5-upload-cancel">
                        <a style="float:right;padding-right:10px;padding-top: 5px;padding-left: 5px;" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>

                    </span>
                    <label id="f5-upload-status" style="float:right;width: auto;">Uploading</label>
                    <span id="f5-upload-message" style="float:right;font-size:12px;background:#FFAFAE;padding:5px 150px 5px 10px;">
                        <b>Upload Failed:</b> User Cancelled the upload
                    </span>
                </div>
        </td></tr>
    </table>
</fieldset>
<form action='index.php?option=com_contushdvideoshare&layout=adminvideos<?php echo (JRequest::getVar('userid','','get','int' ) == 62) ? "&userid=".JRequest::getVar( 'userid','','get','int' ) : ''; ?>' method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset class="adminform">
        <legend>Video Info</legend>
        <table  class="adminlist" width="100%">

            <tr><td width="17%">Title</td><td width="83%"><input type="text" name="title"  id="title" style="width:300px" maxlength="250" value="<?php echo htmlentities($editVideo['rs_editupload']->title); ?>" /></td></tr>
            <tr><td>Description</td><td><textarea name="description" id="description" style="width:300px" maxlength="250" ><?php echo $editVideo['rs_editupload']->description; ?></textarea></td></tr>
            <tr><td>Tags</td><td><input type="text" name="tags"  id="tags" style="width:300px;float:left;" maxlength="250" value="0"  /><?php echo $editVideo['rs_editupload']->tags; ?><label>Seperate tags by space</label></td></tr>
<!--            <tr><td>Tags</td><td><input type="text" name="midrollads"  id="tags" style="width:300px" maxlength="250" value="0" /></td></tr>-->
            <tr id="target"><td>Target Url (Note:Not supported for vimeo)</td><td><input type="text" name="targeturl"  id="targeturl" style="width:300px" maxlength="250" value="<?php echo $editVideo['rs_editupload']->targeturl; ?>" /></td></tr>
                <script language="JavaScript">
                var user = new Array(<?php echo count($editVideo['rs_play']);?>);
<?php
for ($i=0; $i<count($editVideo['rs_play']); $i++)
{
    $playlistnames=$editVideo['rs_play'][$i];
    ?>
        user[<?php echo $i;?>]= new Array(2);
        user[<?php echo $i;?>][1]= "<?php echo $playlistnames->id; ?>";
        user[<?php echo $i;?>][0]= "<?php echo $playlistnames->category; ?>";
    <?php
}
?>
            </script>
            <tr><td>Display Category</td>
                <td>
                    <input type="radio" name="displayplaylist"  id="displayplaylist1"  <?php echo 'checked="checked" ';?> value="1" />All
                    <input type="radio" name="displayplaylist"  id="displayplaylist2" value="2"   />Most Recently Added(Up to 25 Playlist Names)
                </td>
            </tr>
            <tr><td class="key">Sort by Category</td><td>
            <input type="radio" name="playliststart" id="playliststart1" value="AF"  <?php echo 'checked'; ?> onchange="select_alphabet('AF')" />&nbsp;&nbsp;A-F
            <input type="radio" name="playliststart" id='playliststart2' value="GL"  <?php echo 'checked'; ?> onchange="select_alphabet('GL')" />&nbsp;&nbsp;G-L
            <input type="radio" name="playliststart" id='playliststart3' value="MR"  <?php echo 'checked'; ?> onchange="select_alphabet('MR')" />&nbsp;&nbsp;M-R
            <input type="radio" name="playliststart" id='playliststart4' value="SV"  <?php echo 'checked'; ?> onchange="select_alphabet('SV')" />&nbsp;&nbsp;S-V
            <input type="radio" name="playliststart" id='playliststart5' value="WZ"  <?php echo 'checked'; ?> onchange="select_alphabet('WZ')" />&nbsp;&nbsp;W-Z
</td>
</tr>
            <tr><td class="key">Category</td><td>
                    <select name="playlistid" id="playlistid" >
                        <option value="0" id="0">None</option>
                        <?php
                        $count=count( $editVideo['rs_play'] );
                        if ($count>=1)
                        {
                            for ($i=0; $i < $count; $i++)
                            {
                                $row_play = &$editVideo['rs_play'][$i];
                                ?>
                                <option value="<?php echo $row_play->id ;?>" id="<?php echo $row_play->id ;?>"><?php echo $row_play->category?></option>
                        <?php
                           }
                        }

                ?>
                    </select>
                    <?php
                    if($editVideo['rs_editupload']->playlistid)
                    {

                        echo '<script>document.getElementById("'.$editVideo['rs_editupload']->playlistid.'").selected="selected"</script>';
                    }
                        $selected = '';
                    ?>
            </td></tr>
            <tr>
                <td>Order</td>
                <td><input type="text" name="ordering"  id="ordering" style="width:50px" maxlength="250" value="<?php echo $editVideo['rs_editupload']->ordering ;?>"/></td>
            </tr>
             <tr>
                <td>User Acess Level (Note:Not supported for vimeo) :</td>
                <td>
                    <select name="useraccess"  >
                     <?php for($i=0;$i<count($usergroups);$i++)

                     { $selected = '';
                         if($editVideo['rs_editupload']->useraccess)
                         {
                             if($editVideo['rs_editupload']->useraccess == $usergroups[$i]->id)
                            {
                             $selected ='selected="selected"';
                            }

                         }
                       echo '<option value='.$usergroups[$i]->id.' '.$selected.' >'.$usergroups[$i]->title.'</option>';
                     }
                     ?>
                    </select>

                </td>
            </tr>
            <tr id="postroll-ad"><td>Postroll ads (Note:Not supported for vimeo)</td>
                <?php
                $postRollEnable = '';
                $postRollDisable = '';
                if($editVideo['rs_editupload']->postrollads == '1')
                  {
                    $postRollEnable = "inside ".'checked="checked" ';
                  }
                  if($editVideo['rs_editupload']->postrollads == '0' || $editVideo['rs_editupload']->postrollads == '')
                  {
                      $postRollDisable = 'checked="checked" ';
                 }
                ?>
                <td>
                    <input type="radio" name="postrollads"  id="postrollads"  <?php echo $postRollEnable;?> value="1"  onclick="postroll('1');"/>Enable
                    <input type="radio" name="postrollads"  id="postrollads" <?php echo $postRollDisable; ?> value="0" onclick="postroll('0');"/>Disable
            </td></tr>
             <tr id="postroll"><td class="key">Postroll Name (Note:Not supported for vimeo)</td><td>
                    <select name="postrollid" id="postrollid" >
<!--                        <option value="0" id="50">Default Ads</option>-->
                        <?php

                        $count=count( $editVideo['rs_ads'] );

                        if ($count>=1)
                        {
                            for ($i=0; $i < $count; $i++)
                            {
                                $row_Ads = &$editVideo['rs_ads'][$i];
                                ?>
                        <option value="<?php echo $row_Ads->id ;?>" id="5<?php echo $row_Ads->id ;?>" name="<?php echo $row_Ads->id ;?>" ><?php echo $row_Ads->adsname ;?></option>
                        <?php
                           }
                      }
                ?>
                    </select>
                    <?php
                    $prerolladsEnable = '';
                    $prerolladsDisable = '';
                    if($editVideo['rs_editupload']->postrollid)
                    {

                        echo '<script>document.getElementById("5'.$editVideo['rs_editupload']->postrollid.'").selected="selected"</script>';
                    }
                    if($editVideo['rs_editupload']->prerollads == '1')
                     {
                        $prerolladsEnable = 'checked="checked" ';

                     }
                    if($editVideo['rs_editupload']->prerollads == '0' || $editVideo['rs_editupload']->prerollads == '')
                     {
                        $prerolladsDisable = 'checked="checked" ';
                     }

                    ?>
            </td></tr>
            <tr id="preroll-ad"><td>Preroll ads (Note:Not supported for vimeo)</td>
                <td>
                    <input type="radio" name="prerollads"  id="prerollads"  <?php echo $prerolladsEnable; ?>  value="1"  onclick="preroll('1');"/>Enable
                    <input type="radio" name="prerollads"  id="prerollads" <?php echo $prerolladsDisable; ?> value="0"  onclick="preroll('0');"/>Disable
            </td></tr>
            <tr id="preroll"><td class="key">Preroll Name (Note:Not supported for vimeo)</td><td>
                    <select name="prerollid" id="prerollid" >
<!--                        <option value="0" id="60">Default Ads</option>-->
                        <?php
                        $count = count( $editVideo['rs_ads'] );
                        if ($count >=1)
                        {
                            for ($v=0; $v < $count; $v++)
                            {
                                $row_Ads = &$editVideo['rs_ads'][$v];
                                ?>
                        <option value="<?php echo $row_Ads->id ;?>" id="6<?php echo $row_Ads->id ;?>" name="<?php echo $row_Ads->id ;?>"><?php echo $row_Ads->adsname ;?></option>
                        <?php
                            }
                       }

                ?>
                    </select>
                    <?php
                    $downloadEnable = '';
                    $downloadDisable = '';
                    $publishedYes = '';
                    $publishedNo = '';
                    if($editVideo['rs_editupload']->prerollid)
                    {

                        echo '<script>document.getElementById("6'.$editVideo['rs_editupload']->prerollid.'").selected="selected"</script>';
                    }
                    if($editVideo['rs_editupload']->download=='1' || $editVideo['rs_editupload']->download=='')
                     {
                        $downloadEnable = 'checked="checked" ';

                     }
                    if($editVideo['rs_editupload']->download=='0')
                      {
                        $downloadDisable = 'checked="checked" ';

                      }
                    if($editVideo['rs_editupload']->published=='1' || $editVideo['rs_editupload']->published=='')
                      {
                        $publishedYes = 'checked="checked" ';
                      }
                    if($editVideo['rs_editupload']->published=='0')
                       {  $publishedNo = 'checked="checked" ';
                       }
                       $midrollcheck = $midrollcheck1 ='';
                       if ($editVideo['rs_editupload']->midrollads == '1')
                       {
                         $midrollcheck  = 'checked="checked" ';

                       }
                       if ($editVideo['rs_editupload']->midrollads == '0' || $editvideo['rs_editupload']->midrollads == '')
                             {
                           $midrollcheck1 = 'checked="checked" ';

                           }
                    ?>
            </td></tr>
             <tr>
                        <td>MidRoll ads</td>
                        <td>
                            <input type="radio" style="float:none;"  name="midrollads"  id="midrollads"  <?php echo $midrollcheck; ?>  value="1"/>Enable
                            <input type="radio"  style="float:none;"  name="midrollads"  id="midrollads" <?php echo $midrollcheck1; ?> value="0"  />Disable
                        </td>
                    </tr>
            <tr id="download"><td>Download (Note:Not supported for vimeo, youtube and streamer)</td>
                <td>
                    <input type="radio" name="download"  id="download"  <?php echo $downloadEnable; ?>  value="1" />Yes
                    <input type="radio" name="download"  id="download" <?php echo $downloadDisable; ?>  value="0" />No
                </td>
            </tr>
            <?php
            $baseUrl = JURI::base()."components/com_contushdvideoshare/"; ?>
            <tr><td>Published</td>
                <td>
                    <input type="radio" name="published"  id="published"  <?php echo $publishedYes; ?>  value="1" />Yes
                    <input type="radio" name="published"  id="published" <?php echo $publishedNo; ?>  value="0" />No
                </td>
            </tr>
        </table>
    </fieldset>
    <?php
        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        if(version_compare(JVERSION,'1.6.0','ge'))
        {
        $query = $db->getQuery(true);
        $query->select('g.id AS group_id')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);

        $ugp = $db->loadObject();
        $ugp->group_id;


        }
        else
        {
            $query ='select gid AS group_id from #__users
                where id = ' . (int) $userid;
        $db->setQuery($query);
        $ugp = $db->loadObject();
        }
         if (isset($editvideo['rs_editupload']->memberid))
            $videosid = $editvideo['rs_editupload']->memberid;
        else
            $videosid= $userid;
        if (isset($editvideo['rs_editupload']->memberid))
            $videostype = $editvideo['rs_editupload']->usergroupid;
        else
            $videostype=$ugp->group_id;
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $editVideo['rs_editupload']->id; ?>" />
    <input type="hidden" name="task" />
        <!-- The below code is to check wether the particular video ,thumbimages,previewimages & hd is edited or not Starts-->
    <input type="hidden" name="newupload" id="newupload" value="1">
    <input type="hidden" name="fileoption" id="fileoption" value="<?php echo $editVideo['rs_editupload']->filepath ; ?>" />
    <input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="" />
    <input type="hidden" name="hdvideoform-value" id="hdvideoform-value" value="" />
    <input type="hidden" name="thumbimageform-value" id="thumbimageform-value" value="<?php echo $editVideo['rs_editupload']->thumburl;?>" />
    <input type="hidden" name="previewimageform-value" id="previewimageform-value" value="<?php echo $editVideo['rs_editupload']->previewurl;?>" />
    <input type="hidden" name="ffmpegform-value" id="ffmpegform-value" value="" />
    <input type="hidden" name="videourl-value" id="videourl-value" value="" />
    <input type="hidden" name="thumburl-value" id="thumburl-value" value="" />
    <input type="hidden" name="previewurl-value" id="previewurl-value" value="" />
    <input type="hidden" name="hdurl-value" id="hdurl-value" value="" />
    <input type="hidden" name="streameroption-value" id="streameroption-value" value="<?php echo $editVideo['rs_editupload']->streameroption ;?>" />
    <input type="hidden" name="streamerpath-value" id="streamerpath-value" value="" />
    <input type="hidden" name="usergroupid" id="usergroupid" value="<?php echo $videostype ;?>" />
    <input type="hidden" name="memberid" id="memberid" value="<?php echo $videosid;?>" />
    <input type="hidden" name="mode1" id="mode1" value="<?php echo $editVideo['rs_editupload']->filepath ;?>" />
    <!-- Ends -->
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>
 <script type="text/javascript" src="<?php echo JURI::base().'components/com_contushdvideoshare/js/adminvideos.js';?>"></script>