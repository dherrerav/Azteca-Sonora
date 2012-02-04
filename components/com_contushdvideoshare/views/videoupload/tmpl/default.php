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
//check login or not
//include($baseurl."components/com_contushdvideoshare/language/danish.php");
$user = & JFactory::getUser();
$session = & JFactory::getSession();
$editing = '';
$baseurl = JURI::base();
if ($user->get('id') == '')
{
    if(version_compare(JVERSION,'1.6.0','ge'))
      {
	$url = $baseurl . "index.php?option=com_users&view=login";
	header("Location: $url");
      }else {
        $url = $baseurl . "index.php?option=com_user&view=login";
	header("Location: $url");
      }
}
if (JRequest::getVar('type', '', 'get', 'string') == 'edit') {
    $videoedit1 = $this->videodetails;
    if (isset($videoedit1[0]))
        $videoedit = $videoedit1[0];
    if (isset($videoedit->filepath))
        $editing = $videoedit->filepath;
}
?>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<?php
if (JRequest::getVar('url', '', 'post', 'string'))
 {
    $video = new videourl();
    $vurl = JRequest::getVar('url', '', 'post', 'string');
    $video->getVideoType($vurl);
    $description = $video->catchData($vurl);
    $imgurl = $video->imgURL($vurl);
}
?>
<?php

$app = & JFactory::getApplication();
if ($app->getTemplate() != 'hulutheme')
{
	echo '<link rel="stylesheet" href="' . JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';

	if ($user->get('id') != '')
	{
		     if(version_compare(JVERSION,'1.6.0','ge'))
                        {
                       ?>
                    <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="javascript: submitform();"><?php echo _HDVS_LOGOUT; ?></a></div>
            <?php }else { ?>
                <div class="toprightmenu"><a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo _HDVS_MY_CHANNEL; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo _HDVS_MY_PLAYLIST; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo _HDVS_CHANNEL_SETTINGS; ?></a> | <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo _HDVS_LOGOUT; ?></a></div>
           <?php  }?>



		<?php } else
		{if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><div class="toprightmenu"><a href="index.php?option=com_users&view=registration"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_users&view=login"  alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></div>
           <?php }  else {      ?>
                    <div class="toprightmenu"><a href="index.php?option=com_user&view=register"><?php ECHO _HDVS_REGISTER; ?></a> | <a  href="index.php?option=com_user&view=login" alt="login"> <?php ECHO _HDVS_LOGIN; ?></a></div>
        <?php
                }
			?>

			<?php
		}
}


?>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/upload_script.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/membervalidator.js"></script>
<div class="player clearfix">
    <input type="hidden" name="editmode" id="editmode" value="<?php echo $editing; ?>" />
    <div id="clsdetail">
        <div class="lodinpad">
            <h1 class="uploadtitle">
<?php
            if (JRequest::getVar('type', '', 'get', 'string') != 'edit')
                echo _HDVS_VIDEO_UPLOAD;
            else
                echo _HDVS_EDIT_VIDEO;
?>
            </h1>
            <span class="floatright" style="padding-top: 10px;">
                <input type="button"  value="<?php echo _HDVS_BACK_TO_MY_VIDEOS; ?>" class="button cursor_pointer"  onclick="window.open('index.php?option=com_contushdvideoshare&view=myvideos','_self');"  />
            </span><div class="clear"></div>
            <div class="underline" style="margin-bottom:10px;"></div>
            <div class="allform"  >
                <li class="changeli"><div class="form-label floatleft"><label><?php echo _HDVS_VIDEO_TYPE; ?>:</label></div>
                    <div class="radiobtn" ><input type="radio" class="butnmargin" name="filetype" id="filetype2" value="0"
                <?php
                if (isset($videoedit->filepath) && $videoedit->filepath == 'Youtube')
                {
                    echo 'checked="checked"';
                } ?> checked ="checked" onclick="filetypeshow(this);" />&nbsp;&nbsp;<?php echo _HDVS_URL; ?> / <?php echo _HDVS_YOUTUBE;?> / <?php echo _HDVS_VIMEO;?></div>
                    <div class="radiobtn" >
                    <input type="radio"  class="butnmargin" name="filetype" id="filetype1" value="1" <?php
                      if (isset($videoedit->filepath) && $videoedit->filepath == 'File') {
                          echo 'checked="checked"';
                      }
                ?> onclick="filetypeshow(this);"/>&nbsp;&nbsp;<?php echo _HDVS_UPLOAD; ?></div>
                       </li>
            </div>
            <br/>
            <div name="typeff" id="typeff" >
                <div class="allform" >
                    <br/>
                    <table  class="table_upload">
                        <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"><td class="form-label"><?php echo _HDVS_UPLOAD_VIDEO; ?></td>
                            <td>
                                <div id="f11-upload-form" >
                                    <form name="ffmpeg" method="post" enctype="multipart/form-data" >
                                        <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                        <input  type="button cursor_pointer" name="uploadBtn" value="<?php echo _HDVS_UPLOAD_VIDEO; ?>" disabled="disabled" class="button" onclick="return addQueue(this.form.name,this.form.myfile.value);" /><span class="star">*</span>
                                        <input type="hidden" name="mode" value="video" />
                                    </form>
                                </div>
                                <div id="f11-upload-progress" >
                                    <div class="floatleft"><img id="f11-upload-image" src="components/com_contushdvideoshare/images/empty.gif'" alt="Uploading"   class="clsempty"/>
                                        <label  class="postroll"  id="f11-upload-filename">PostRoll.flv</label></div>
                                    <div class="floatright"> <span id="f11-upload-cancel">
                                            <a  class="clscnl" href="javascript:cancelUpload('normalvideoform');" name="submitcancel"><?php echo _HDVS_CANCEL; ?></a>
                                        </span>
                                        <label id="f11-upload-status"  class="clsupl"><?php echo _HDVS_UPLOADING; ?></label>
                                        <span id="f11-upload-message" class="clsupl_fail" >
                                            <b><?php echo _HDVS_UPLOAD_FAILED; ?>:</b> <?php echo _HDVS_USER_CANCELLED_THE_UPLOAD; ?>
                                        </span></div>
                                </div>
                            </td></tr>
                    </table>
                </div>
            </div>
            <div name="typefile" id="typefile" >
                <div class="allform">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"><td class="form-label"><?php echo _HDVS_UPLOAD_VIDEO; ?></td>
                            <td>
                                <div id="f1-upload-form" >
                                    <form name="normalvideoform" method="post" enctype="multipart/form-data" >
                                        <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                        <input  class="button cursor_pointer" type="button" name="uploadBtn" value="<?php echo _HDVS_UPLOAD; ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" /><span class="star">*</span>
                                              <label id="lbl_normal"><?php
                                                  if (isset($videoedit->filepath))
                                                  {
                                                      if ($videoedit->filepath == 'File')
                                                          echo $videoedit->videourl;
                                                  }
?></label>
                                              <input type="hidden" name="mode" value="video" />
                                          </form>
                                      </div>
                                      <div id="f1-upload-progress" >
                                          <div class="floatleft"><img id="f1-upload-image" src="components/com_contushdvideoshare/images/empty.gif'" alt="Uploading"  class="clsempty" />
                                              <label class="postroll"  id="f1-upload-filename">PostRoll.flv</label></div>
                                          <div class="floatright"> <span id="f1-upload-cancel">
                                                  <a class="clscnl" href="javascript:cancelUpload('normalvideoform');" name="submitcancel"><?php echo _HDVS_CANCEL; ?></a>
                                              </span>
                                              <label id="f1-upload-status" class="clsupl"><?php echo _HDVS_UPLOADING; ?></label>
                                              <span id="f1-upload-message" class="clsupl_fail">
                                                  <b><?php echo _HDVS_UPLOAD_FAILED; ?>:</b> <?php echo _HDVS_USER_CANCELLED_THE_UPLOAD; ?>
                                              </span></div>
                                      </div>
                                  </td></tr>
                              <tr id="ffmpeg_disable_new2" name="ffmpeg_disable_new1"> <td class="form-label"><?php echo _HDVS_UPLOAD_HD_VIDEO; ?></td>
                                  <td>
                                      <div id="f2-upload-form" >
                                          <form name="hdvideoform" method="post" enctype="multipart/form-data" >
                                              <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                              <input  class="button cursor_pointer" type="button" name="uploadBtn" value="<?php echo _HDVS_UPLOAD; ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" />
                                              <label id="lbl_normal"><?php
                                                  if (isset($videoedit->filepath))
                                                  {
                                                      if ($videoedit->filepath == 'File')
                                                          echo $videoedit->hdurl;
                                                  }
?></label>
                                              <input type="hidden" name="mode" value="video" />
                                          </form>
                                      </div>
                                      <div id="f2-upload-progress" >
                                          <div class="floatleft"><img id="f2-upload-image" src="images/empty.gif'" alt="Uploading"  class="clsempty" />
                                              <label class="postroll"  id="f2-upload-filename">PostRoll.flv</label></div>
                                          <div class="floatright"><span id="f2-upload-cancel">
                                                  <a class="clscnl" href="javascript:cancelUpload('hdvideoform');" name="submitcancel"><?php echo _HDVS_CANCEL; ?></a>

                                              </span>
                                              <label id="f2-upload-status" class="clsupl"><?php echo _HDVS_UPLOADING; ?></label>
                                              <span id="f2-upload-message" class="clsupl_fail">
                                                  <b><?php echo _HDVS_UPLOAD_FAILED; ?>:</b> <?php echo _HDVS_USER_CANCELLED_THE_UPLOAD; ?>
                                              </span></div>
                                      </div>
                                  </td></tr>
                              <tr id="ffmpeg_disable_new3" name="ffmpeg_disable_new1"><td class="form-label"><?php echo _HDVS_UPLOAD_THUMB_IMAGE; ?></td><td>
                                      <div id="f3-upload-form" >
                                          <form name="thumbimageform" method="post" enctype="multipart/form-data" >
                                              <input type="file" name="myfile"  onchange="enableUpload(this.form.name);" />
                                              <input class="button cursor_pointer" type="button" name="uploadBtn" value="<?php echo _HDVS_UPLOAD; ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" /><span class="star">*</span>
                                              <label id="lbl_normal"><?php
                                                  if (isset($videoedit->filepath))
                                                   {
                                                      if ($videoedit->filepath == 'File')
                                                          echo $videoedit->thumburl;
                                                  }
?></label>
                                              <input type="hidden" name="mode" value="image" />
                                          </form>
                                      </div>
                                      <div id="f3-upload-progress" >
                                          <div class="floatleft"><img id="f3-upload-image" src="images/empty.gif' " alt="Uploading" class="clsempty" />
                                              <label class="postroll"  id="f3-upload-filename">PostRoll.flv</label></div>
                                          <div class="floatright"> <span id="f3-upload-cancel">
                                                  <a class="clscnl" href="javascript:cancelUpload('thumbimageform');" name="submitcancel"><?php echo _HDVS_CANCEL; ?></a>
                                              </span>
                                              <label id="f3-upload-status" class="clsupl"><?php echo _HDVS_UPLOADING; ?></label>
                                              <span id="f3-upload-message" class="clsupl_fail">
                                                  <b><?php echo _HDVS_UPLOAD_FAILED; ?>:</b> <?php echo _HDVS_USER_CANCELLED_THE_UPLOAD; ?>
                                              </span></div>
                                      </div>
                                  </td></tr>
                              <tr id="ffmpeg_disable_new4" name="ffmpeg_disable_new1">
                                  <td class="form-label"><?php echo _HDVS_UPLOAD_PREVIEW_IMAGE; ?></td><td>
                                      <div id="f4-upload-form" >
                                          <form name="previewimageform" method="post" enctype="multipart/form-data" >
                                              <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                              <input  class="button cursor_pointer" type="button" name="uploadBtn" value="<?php echo _HDVS_UPLOAD; ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" />
                                              <label id="lbl_normal"><?php
                                                  if (isset($videoedit->filepath))
                                                  {
                                                      if ($videoedit->filepath == 'File')
                                                          echo $videoedit->previewurl;
                                                  }
?></label>
                                              <input type="hidden" name="mode" value="image" />
                                          </form>
                                      </div>
                                      <div id="f4-upload-progress" >
                                          <div class="floatleft"><img id="f4-upload-image" src="/images/empty.gif'" alt="Uploading" class="clsempty" />
                                              <label class="postroll"  id="f4-upload-filename">PostRoll.flv</label></div>
                                          <div class="floatright"><span id="f4-upload-cancel">
                                                  <a class="clscnl" href="javascript:cancelUpload('previewimageform');" name="submitcancel"><?php echo _HDVS_CANCEL; ?></a>
                                              </span>
                                              <label id="f4-upload-status" class="clsupl"><?php echo _HDVS_UPLOADING; ?></label>
                                                                              <span id="f4-upload-message" class="clsupl_fail">
                                                                                  <b><?php echo _HDVS_UPLOAD_FAILED; ?>:</b> <?php echo _HDVS_USER_CANCELLED_THE_UPLOAD; ?>
                                                                              </span></div>
                                        </div>
                                                                      <div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#"  ></iframe></div>
                                                                  </td></tr>
                                                          </table>
                                                      </div>
                                                  </div>
<?php
                                                  if (JRequest::getVar('type', '', 'get', 'string') == 'edit')
                                                      $javascript = ''; else
                                                      $javascript = 'onsubmit="return videoupload();"';
?>
                              <form name="upload1111" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload'); ?>" method="post" enctype="multipart/form-data" <?php echo $javascript ?> >
                              <div name="typeurl" id="typeurl">
                                  <br/>
                                  <div  class="uplcolor" align="center"><?php
                                                  if (($this->upload))
                                                  {
                                                      echo $this->upload . '<br/><br/>';
                                                  }
?></div>
                    <div class="allform">
                        <ul>
                            <li class="changeli">
                                <div class="form-label floatleft"><label><?php echo _HDVS_UPLOAD_URL;?>:</label></div>
                                <div class="form-input floatleft"><input type="text" name="Youtubeurl" value="<?php
                                                  if (isset($videoedit->filepath)

                                                      )if ($videoedit->filepath == 'Youtube')
                                                          echo $videoedit->videourl ?>" class="text" size="20" id="Youtubeurl" onchange="bindvideo();"  /><span class="star">*</span>&nbsp;&nbsp </div>
                                                          <div class="clear"></div>
                                                          <div class="form-label floatleft"><label><?php echo _HDVS_UPLOAD_HDURL;?>:</label></div>
                                                          <div class="form-input floatleft"><input type="text" name="hdurl" value="<?php
                                                  if (isset($videoedit->filepath)

                                                      )if ($videoedit->filepath == 'Youtube')
                                                          echo $videoedit->hdurl ?>" class="text" size="20" id="hdurl" onchange="bindvideo();"  /> </div>
                                                  </li>
                                              </ul>
                                          </div>
                                          <div class="clear"></div>
                                          <div class="allform">
                                              <ul>
                                                  <li class="changeli">
                                                      <div class="form-label floatleft"><label><?php echo _HDVS_UPLOAD_IMAGEURL;?>:</label></div>
<?php
                                                          if (isset($videoedit->thumburl))
                                                          {
                                                              preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', $videoedit->thumburl, $imgresult);
                                                          }
?>
                                                      <div class="form-input floatleft"><?php echo _HDVS_UPLOAD_IMAGEURL;?><input type="radio" name="imagepath" id="imagepath" value="1" <?php
                                                          if (isset($imgresult[0]))
                                                          {
                                                              echo "checked='checked'";
                                                          }
?>                                                     onclick="changeimageurltype(this);">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo _HDVS_IMAGE_UPLOAD;?><input type="radio" name="imagepath" id="imagepath" value="0" <?php
                                                          if (!isset($imgresult[0]))
                                                          {
                                                              echo "checked='checked'";
                                                          } ?>  onclick="changeimageurltype(this);"> <div class="clear"></div>
                                                          <div id="imageurltype"></div>
<?php
                                                          if (isset($imgresult[0]))
                                                           {
                                                       ?>
                                                              <script type="text/javascript">
                                                                  document.getElementById('imageurltype').innerHTML='<input type="text" name="thumburl" value="<?php if (isset($videoedit->thumburl)

                                                                  )echo $videoedit->thumburl; ?>" class="text" size="20" id="thumburl"/>';
                                                              </script>
<?php
                                                          }
                                                          else {
?>
                                    <script type="text/javascript">
                                        document.getElementById('imageurltype').innerHTML='<input type="file" name="thumburl" id="thumburl" onchange="fileformate_check(this);"/><lable><?php if (isset($videoedit->thumburl)
                                                                         )echo $videoedit->thumburl; ?></lable>';

                                    </script>
<?php }
?>
                                                             </div>
                                                         </li>
                                                     </ul>
                                                 </div>
                                                 <div class="clear"></div>
                                             </div>
                                             <div class="allform">
                                                 <ul>
                                                     <li class="changeli" >
                                                         <div class="form-label floatleft"><label><?php echo _HDVS_TITLE; ?> :</label></div>
                                                             <div class="form-input floatleft"><input type="text" name="title" value="<?php if (isset($videoedit->title)

                                                                     )echo $videoedit->title; ?>" class="text" size="20" id="title"/><span class="star">*</span></div>
                                                         </li>
                                                         <li class="changeli">
                                                             <br />
                                                             <div class="form-label floatleft"><label><?php echo _HDVS_DESCRIPTION; ?> :</label></div>
                            <div class="form-input floatleft"><textarea name="description" style="width:288px;" id="description"><?php
                                                                 if (isset($videoedit->description)) {
                                                                     echo $videoedit->description;
                                                                 } ?></textarea></div>
                                                         </li>
                                                            <li class="changeli">
                            <br>
                            <div class="form-label floatleft"><label>Tags :</label></div>
                            <div class="form-input floatleft"><textarea name="tags1" style="width:288px;" id="tags1">
<?php
                                                                 if (isset($videoedit->tags)) {
                                                                     echo $videoedit->tags;
                                                                 } ?>
                                </textarea></div>
                            <label>Seperate tags by space</label>
                        </li>
                                                         <li class="changeli">
                                                             <br />
                                                             <div class="form-label floatleft"><label><?php echo _HDVS_SELECT_CATEGORY; ?> :</label></div>
                                  <div class="catclass floatleft" align="left" id="selcat">
                                    <?php $n = count($this->videocategory);
                                                                 foreach ($this->videocategory as $cat) { ?>
                                          <a class="cursor_pointer" title="<?php echo $cat->category; ?>" onclick="catselect('<?php echo $cat->category; ?>');"><?php echo $cat->category . ","; ?></a>
                                     <?php } ?>
                                                                         </div>
                                                                     </li>
                                                                     <li class="changeli clearfix"><br/>
                                                                         <div class="form-label floatleft"><label><?php echo _HDVS_CATEGORY; ?> :</label></div>
                                                                         <div class=" floatleft form-inputnew"><input type="text"  readonly name="tagname" value="<?php
                                                                 if (isset($videoedit->category))
                                                                 {
                                                                     echo $videoedit->category;
                                                                 }
                                    ?>" class="text" size="20" id="tagname" /><span class="star">*</span><input type="button" value="<?php echo _HDVS_RESET_CATEGORY; ?>" class="button" onclick="resetcategory();" ></div>
                                                                     </li>
                                                                     <li class="changeli">
                                                                         <div class="form-label floatleft"><label><?php echo _HDVS_TYPE; ?> :</label></div>
                                                                      <div class="radiobtn floatleft" ><input type="radio" class="butnmargin" name="type" value=0  <?php
                                                                 if (isset($videoedit->type) && $videoedit->type == '0')
                                                                 {
                                                                     echo 'checked="checked"';
                                                                 }
                                    ?> checked="checked"  />&nbsp;&nbsp;<?php echo _HDVS_PUBLIC; ?></div>
                                                                      <div class="radiobtn " ><input type="radio" class="butnmargin" name="type" value=1 <?php
                                                                 if (isset($videoedit->type) && $videoedit->type == '1')
                                                                 {
                                                                     echo 'checked="checked"';
                                                                 } ?>  />&nbsp;&nbsp;<?php echo _HDVS_PRIVATE; ?></div>

                                                                  </li>
                                                              </ul>
                                                              <br/><br/><?php
                                                                 if (JRequest::getVar('type', '', 'get', 'string') == 'edit')
                                                                 {
                                                                     $editbutton = _HDVS_UPDATE;
                                                                 }
                                                                 else
                                                                 {
                                                                     $editbutton = _HDVS_UPLOAD;
                                                                 }
                    ?>
                                                                          <div ><input  type="submit" name="uploadbtn" value="<?php echo $editbutton; ?>" class="button cursor_pointer" />
                                                                              <input type="button" onclick="window.open('<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=myvideos'); ?>','_self');"  value="<?php echo _HDVS_CANCEL; ?>" class="button cursor_pointer" />
                                                                          </div>
                                                                      </div>
                                                                      <br/><br/>
                                                                      <input type="hidden" id="videouploadformurl" name="videouploadformurl" value="<?php echo JURI::base(); ?>" />
                                                                      <input type="hidden" name="videourl" value="1" class="text" size="20" id="videourl" />
                                                                      <input type="hidden" name="thump" value="<?php if (isset($imgurl)
                                                                     )echo $imgurl; ?>">
                                                                      <input type="hidden" name="flv" value="<?php if (JRequest::getVar('url', '', 'post', 'string')
                                                                     )echo JRequest::getVar('url', '', 'post', 'string'); ?>">
                                                                      <input type="hidden" name="hd" value="">
                                                                      <input type="hidden" name="hq" value="">
                                                                      <input type="hidden" name="ffmpeg" id="ffmpeg" value="">
                                                                      <input type="hidden" name="normalvideoformval" id="normalvideoformval" value="">
                                                                      <input type="hidden" name="hdvideoformval"  id="hdvideoformval" value="">
                                                                      <input type="hidden" name="thumbimageformval" id="thumbimageformval" value="">
                                                                      <input type="hidden" name="previewimageformval" id="previewimageformval" value="<?php if (isset($imgurl)
                                                                     )echo $imgurl; ?>">
                                                                      <input type="hidden" name="seltype" id="seltype" value="0">
                                                                      <input type="hidden" name="videotype" id="videotype" value="<?php echo JRequest::getVar('type', '', 'get', 'string'); ?>">
                                                                      <input type="hidden" name="videoid" id="videoid" value="<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>">
                                                                  </form>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                                                          <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php
                                                                 if (JRequest::getVar('memberidvalue', '', 'post', 'int')) {
                                                                     echo JRequest::getVar('memberidvalue', '', 'post', 'int');
                                                                 };
                    ?>" />
                                                      </form>
                                                      <script type="text/javascript">

                                                          function resetcategory()
                                                          {
                                                              document.getElementById('tagname').value='';
                                                          }
                                                          function catselect(categ)
                                                          {
                                                              var r=document.getElementById('selcat').value=categ;
                                                              if(document.getElementById('tagname').value=='')
                                                              {
                                                                  document.getElementById('tagname').value=r;
                                                              }
                                                              else
                                                              {

                                                                  document.getElementById('tagname').value=  r;
                                                              }
                                                          }

                                                          //change upload link page when i select option btn
                                                          function filetypeshow(obj)
                                                          {
                                                              if(obj.value==0 || obj==0)
                                                              {
                                                                  document.getElementById("typefile").style.display="none";
                                                                  document.getElementById("typeff").style.display="none";
                                                                  document.getElementById("typeurl").style.display="block";
                                                                  document.getElementById('seltype').value=0;
                                                                  document.getElementById("ffmpeg").style.display="none";
                                                                  document.getElementById("normalvideoformval").style.display="none";

                                                              }
                                                              if(obj.value==1 || obj==1)
                                                              {
                                                                  document.getElementById("typefile").style.display="block";
                                                                  document.getElementById("typeurl").style.display="none";
                                                                  document.getElementById("typeff").style.display="none";

                                                                  //document.getElementById("imagepath").style.display="none";

                                                                  document.getElementById('seltype').value=1;
                                                                  document.getElementById("ffmpeg").style.display="none";
                                                                  document.getElementById("normalvideoformval").style.display="block";

                                                              }
                                                              if(obj.value==2 || obj==2)
                                                              {
                                                                  document.getElementById("typefile").style.display="none";
                                                                  document.getElementById("typeurl").style.display="none";
                                                                  document.getElementById("typeff").style.display="block";
                                                                  document.getElementById("ffmpeg").style.display="block";
                                                                  document.getElementById('seltype').value=2;
                                                                  document.getElementById("normalvideoformval").style.display="none";

                                                              }

                                                          }
                                                          document.getElementById("ffmpeg").style.display="none";

                                                          document.getElementById("typeff").style.display="none";


                                                          function bindvideo()
                                                          {
                                                              if(document.getElementById('Youtubeurl').value!='')
                                                              {
                                                                  document.getElementById('videourl').value=0;
                                                              }
                                                          }


                                                          function assignurl(str)
                                                          {
                                                              if(str=="")
                                                                  return false;
                                                              //    match_exp = new RegExp('regex = /http\:\/\/www\.youtube\.com\/watch\?v=(\w{11})/');
                                                              var match_exp = /http\:\/\/www\.youtube\.com\/watch\?v=[^&]+/;

                                                              if(str.match(match_exp)==null){

                                                                  var metacafe=/http:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//;

                                                                  if(str.match(metacafe)!=null)
                                                                  {
                                                                      document.upload1111.url1.value=document.getElementById('url').value;
                                                                      document.getElementById('generate').style.display="block";
                                                                      return false;

                                                                  }
                                                                  else
                                                                  {
                                                                      alert("Enter Video URL");
                                                                      document.getElementById('url').focus();
                                                                      document.upload1111.url.value="1";
                                                                      return false;
                                                                  }


                                                              }
                                                              else
                                                              {
                                                                  document.getElementById('generate').style.display="block";
                                                                  document.upload1111.flv.value=document.getElementById('url').value;
                                                                  document.upload1111.url1.value="1";
                                                                  return false;
                                                              }

                                                          }


                                                          function changeimageurltype(urltype)
                                                          {


                                                              if(urltype.value==1)
                                                              {
                                                                  document.getElementById('imageurltype').innerHTML='<input type="text" name="thumburl" value="<?php if (isset($videoedit->thumburl)

                                                                     )echo $videoedit->thumburl; ?>" class="text" size="20" id="thumburl"/>';
                                                              }
                                                              else
                                                              {
                                                                  document.getElementById('imageurltype').innerHTML='<input type="file" name="thumburl" value="<?php if (isset($videoedit->thumburl)

                                                                     )echo $videoedit->thumburl; ?>" class="text" size="20" id="thumburl"/>';
                                                              }
                                                          }
                                                          function membervalue(memid)
                                                          {
                                                              document.getElementById('memberidvalue').value=memid;
                                                              document.memberidform.submit();
                                                          }

                                                          function fileformate_check(thumburl)
                                                          {


                                                              //var athumburl=thumb.value;
                                                              //alert(o.value);
                                                              if((thumburl.value.length > 0))
                                                              {

                                                                  if(thumburl.value.substring(thumburl.value.length-3) == 'gif' || thumburl.value.substring(thumburl.value.length-3) == 'jpg' || thumburl.value.substring(thumburl.value.length-3) == 'png')
                                                                  {}
                                                                  else {
                                                                      alert("Invalid file formate select only jpg/gif/png");
                                                                  }
                                                              }
                                                          }

                                                      </script>
                                                      <script type="text/javascript">
<?php
                                                           if (isset($videoedit->filepath) && $videoedit->filepath == 'Youtube')
                                                              {
                                                              ?>
                                                              filetypeshow("0");
<?php
                                                              }
                                                              elseif (isset($videoedit->filepath) && $videoedit->filepath == 'File')
                                                               {

                                                           ?>
                                                              filetypeshow("1");
<?php
                                                                 }
?>
</script>