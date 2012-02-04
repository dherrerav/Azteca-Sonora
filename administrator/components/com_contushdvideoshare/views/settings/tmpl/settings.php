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
$rs_editsettings = $rs_showsettings = $this->playersettings;
?>
<style>
    fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button {float:none;}
        table.admintable td.key {
background-color: #F6F6F6;
text-align: left;
width: auto;
color: #666;
font-weight: bold;
border-bottom: 1px solid #E9E9E9;
border-right: 1px solid #E9E9E9;
padding: 0 10px 0 0;
}
fieldset label, fieldset span.faux-label {
float: none;
clear: left;
display: block;
margin: 5px 0;
}

</style>
<?php
if (JRequest::getVar('task') == 'edit') {

    if (count($rs_editsettings) > 0) {
        $editor = & JFactory::getEditor();
?>
        <form action="index.php?option=com_contushdvideoshare&layout=settings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
            <fieldset class="adminform">
                <legend>Player Settings</legend>
                <table class="admintable">
                    <tr><td class="key" width=20%>Buffer Time</td><td > <input type="text" name="buffer" value="<?php echo $rs_editsettings[0]->buffer; ?>"     />
                            secs<label style="background-color:#D5E9EE; color:#333333;"> Recommended value is 3</label>
                        </td>
                        <td class="key" width=20%>Logo Alpha</td><td><input type="text" name="logoalpha"  value="<?php echo $rs_editsettings[0]->logoalpha; ?>"      />
                            %<label style="background-color:#D5E9EE; color:#333333;"> Edit the value to have transparancy depth of logo</label>
                        </td>
                    </tr>
                    <tr><td class="key" width=20%>Width</td><td width=400px;><input type="text" name="width" value="<?php echo $rs_editsettings[0]->width; ?>"     /> px
                            <label style="background-color:#D5E9EE; color:#333333;">Width of the video can be 300px with all the controls enabled.  If you would like to have smaller than 300px then you have to disable couple of controls like Timer, Zoom..</label>
                        </td>
                        <td class="key" >Skin Auto Hide</td><td>
                            <input type="radio" name="skin_autohide" <?php if ($rs_editsettings[0]->skin_autohide == 1) {
            echo 'checked="checked" ';
        } ?> value="1" />Enable
                            <input type="radio" name="skin_autohide" <?php if ($rs_editsettings[0]->skin_autohide == 0) {
            echo 'checked="checked" ';
        } ?>value="0" />Disable</td>

                    </tr>
                    <tr><td class="key" width=20%>Height</td><td><input type="text" name="height"  value="<?php echo $rs_editsettings[0]->height; ?>"     /> px</td>
                        <td class="key"> Stage Color</td><td>#<input type="text" name="stagecolor"  value="<?php echo $rs_editsettings[0]->stagecolor; ?>"    /></td>
                    </tr>
                    <tr><td class="key">Normal Screen Scale</td><td>
                            <select  name="normalscale">
                                <option value="0" id="20">Aspect Ratio</option>
                                <option value="1" id="21">Original Size</option>
                                <option value="2" id="22">Fit to Screen</option>


                            </select>
                    <?php
                    if ($rs_editsettings[0]->normalscale) {

                        echo '<script>document.getElementById("2' . $rs_editsettings[0]->normalscale . '").selected="selected"</script>';
                    }
                    ?>
                </td>
                <td class="key">Skin</td>
                <td><select name="skin">
                        <option value="skin_black.swf" id="skin_black.swf">skin_black.swf</option>
                        <option value="skin_white.swf" id="skin_white.swf">skin_white.swf</option>
                        <option value="skin_fancyblack.swf" id="skin_fancyblack.swf">skin_fancyblack.swf</option>
                        <option value="skin_sleekblack.swf" id="skin_sleekblack.swf">skin_sleekblack.swf</option>
                        <option value="skin_fresh_blue.swf" id="skin_fresh_blue.swf">skin_fresh_blue.swf</option>
                        <option value="skin_fresh_white.swf" id="skin_fresh_white.swf">skin_fresh_white.swf</option>
                        <option value="skin_fresh_orange.swf" id="skin_fresh_orange.swf">skin_fresh_orange.swf</option>
                    </select>

<?php
                    if ($rs_editsettings[0]->skin) {
                        echo '<script>document.getElementById("' . $rs_editsettings[0]->skin . '").selected="selected"</script>';
                    }
?>
                </td>
            </tr>
            <tr><td class="key">Full Screen Scale</td><td>
                    <select  name="fullscreenscale">
                        <option value="0" id="10" name=0>Aspect Ratio</option>
                        <option value="1" id="11" name=1>Original Size</option>
                        <option value="2" id="12" name=2>Fit to Screen</option>
                    </select>

<?php
                    if ($rs_editsettings[0]->fullscreenscale) {
                        echo '<script>document.getElementById("1' . $rs_editsettings[0]->fullscreenscale . '").selected="selected"

                                                                                                                                                                                                                                                                                        </script>';
                    }
?>
                </td>
                <td class="key">Full Screen</td><td>
                    <input type="radio" name="fullscreen" <?php if ($rs_editsettings[0]->fullscreen == 1) {
                        echo 'checked="checked" ';
                    } ?>value="1" />Enable
                    <input type="radio" name="fullscreen" <?php if ($rs_editsettings[0]->fullscreen == 0) {
                        echo 'checked="checked" ';
                    } ?>value="0" />Disable</td>

            </tr>
            <tr><td class="key">Autoplay</td><td>
                    <input type="radio" name="autoplay" <?php if ($rs_editsettings[0]->autoplay == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="autoplay" <?php if ($rs_editsettings[0]->autoplay == 0) {
                        echo 'checked="checked" ';
                    } ?> value="0" />Disable</td>
                <td class="key">Zoom</td><td>
                    <input type="radio" name="zoom" <?php if ($rs_editsettings[0]->zoom == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="zoom" <?php if ($rs_editsettings[0]->zoom == 0) {
                        echo 'checked="checked" ';
                    } ?>value="0" />Disable</td>

            </tr>
            <tr><td class="key">Volume</td><td><input type="text" name="volume" value="<?php echo $rs_editsettings[0]->volume; ?>"     />
                    %<label style="background-color:#D5E9EE; color:#333333;"> Recommended value is 50</label>
                </td>
<!--                <td class="key">Upload Max File Size</td>
                <td><select name="uploadmaxsize">
                        <option value="50" id="50">50 MB</option>
                        <option value="100" id="100">100 MB</option>
                    </select>-->

<?php
//                    if ($rs_editsettings[0]->uploadmaxsize) {
//                        echo '<script>document.getElementById("' . $rs_editsettings[0]->uploadmaxsize . '").selected="selected"</script>';
//                    }
?>
<!--                </td>--> 
            </tr>


            <tr>
                <td class="key">FFMpeg Binary Path</td>
                <td>
                    <input style="width:150px;" type="text" name="ffmpegpath" value="<?php echo $rs_editsettings[0]->ffmpegpath; ?>" />
                </td>
                <td class="key">Timer</td>
                <td>
                    <input type="radio" name="timer" <?php if ($rs_editsettings[0]->timer == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="timer" <?php if ($rs_editsettings[0]->timer == 0) {
                        echo 'checked="checked" ';
                    } ?> value="0" />Disable
                </td>
            </tr>

            <tr>

                <td class="key">
                    Share Url
                </td>
                <td>
                    <input type="radio" name="shareurl" <?php if ($rs_editsettings[0]->shareurl == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="shareurl" <?php if ($rs_editsettings[0]->shareurl == 0) {
                        echo 'checked="checked" ';
                    } ?> value="0" />Disable
                </td>
                <td class="key">
                    Playlist Autoplay
                </td>
                <td>
                    <input type="radio" name="playlist_autoplay" <?php if ($rs_editsettings[0]->playlist_autoplay == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="playlist_autoplay" <?php if ($rs_editsettings[0]->playlist_autoplay == 0) {
                        echo 'checked="checked" ';
                    } ?> value="0" />Disable
                </td>
            </tr>

            <tr>

                <td class="key">
                    HD Default
                </td>
                <td>
                    <input type="radio" name="hddefault" <?php if ($rs_editsettings[0]->hddefault == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="hddefault" <?php if ($rs_editsettings[0]->hddefault == 0) {
                        echo 'checked="checked" ';
                    } ?> value="0" />Disable
                </td>
                <td class="key">
                    Playlist Open
                </td>
                <td>
                    <input type="radio" name="playlist_open" <?php if ($rs_editsettings[0]->playlist_open == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="playlist_open" <?php if ($rs_editsettings[0]->playlist_open == 0) {
                        echo 'checked="checked" ';
                    } ?> value="0" />Disable
                </td>
            </tr>
            <tr>

                <td class="key">Related Videos</td><td>
                    <select name="related_videos">
                        <option value="1" id="1">Enable</option>
                        <option value="2" id="2">Disable</option>
<!--                        <option value="3" id="3">Within Player</option>
                        <option value="4" id="4">Outside Player</option>-->
                    </select>
<?php
                    if ($rs_editsettings[0]->related_videos) {
                        echo '<script>document.getElementById("' . $rs_editsettings[0]->related_videos . '").selected="selected"</script>';
                    }
?>


                </td>
                <td class="key">Vast</td>
                <td>
                    <input type="radio" name="vast" <?php if ($rs_editsettings[0]->vast == 1) {
                        echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="vast" <?php if ($rs_editsettings[0]->vast == 0) {
                        echo 'checked="checked" ';
                    } ?> value="0" />Disable

                </td>
            </tr>
            <tr>


                <td class="key">Vast Partner Id</td>
                <td>
                    <input type="text" name="vast_pid" value=""     />

                </td>
<!--                <td class="key">Use Youtube API</td>
                <td>
                    <input type="radio" name="Youtubeapi" <?php if ($rs_editsettings[0]->Youtubeapi == 1) {
                      //  echo 'checked="checked" ';
                    } ?> value="1" />Enable
                    <input type="radio" name="Youtubeapi" <?php if ($rs_editsettings[0]->Youtubeapi == 0) {
                       // echo 'checked="checked" ';
                    } ?> value="0" />Disable

                </td>-->

            </tr>
        </table>
    </fieldset>


    <fieldset class="adminform">
        <legend>Pre/Post-Roll Ads Settings</legend>
        <table class="admintable">
            <tr>
                <td class="key">Postroll Ads</td>
                <td>
                    <input type="radio" name="postrollads" <?php
                    if ($rs_editsettings[0]->postrollads == 1) {
                        echo 'checked="checked" ';
                    }
?> value="1" />Enable
                    <input type="radio" name="postrollads" <?php
                    if ($rs_editsettings[0]->postrollads == 0) {
                        echo 'checked="checked" ';
                    }
?> value="0" />Disable

                </td>
                <td class="key">
                    Preroll Ads
                </td>
                <td>
                    <input type="radio" name="prerollads" <?php
                    if ($rs_editsettings[0]->prerollads == 1) {
                        echo 'checked="checked" ';
                    }
?> value="1" />Enable
                    <input type="radio" name="prerollads" <?php
                    if ($rs_editsettings[0]->prerollads == 0) {
                        echo 'checked="checked" ';
                    }
?> value="0" />Disable
                </td>
            </tr>
             <tr>
                        <td> Google Analytics </td>
                        <td>
                            <input type="radio" style="float:none;" onclick="Toggle('shows')" name="googleana_visible" id="googleana_visible" <?php if ($rs_editsettings[0]->googleana_visible == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                            <input type="radio" style="float:none;" onclick="Toggle('unshow')" name="googleana_visible" id="googleana_visible" <?php if ($rs_editsettings[0]->googleana_visible == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> <div id="show" style="display:none;"> Enter Google Analytics ID </div> </td>
                        <td> <div id="show1" style="display:none;"> <input name="googleanalyticsID" id="googleanalyticsID" maxlength="100"  value="<?php echo $rs_editsettings[0]->googleanalyticsID; ?>"></div> </td>
                    </tr>
        </table>
    </fieldset>
    <fieldset class="adminform">
        <legend>Mid Roll Ads Settings</legend>
        <table class="admintable">
            <tr>
                <td class="key">
                    Mid roll ads
                </td>
                <td>
                    <input type="radio" name="midrollads" <?php
                    if ($rs_editsettings[0]->midrollads == 1) {
                        echo 'checked="checked" ';
                    }
?> value="1" />Enable
                    <input type="radio" name="midrollads" <?php
                    if ($rs_editsettings[0]->midrollads == 0) {
                        echo 'checked="checked" ';
                    }
?> value="0" />Disable
                </td>
                <td class="key">
                    Begin
                </td>
                <td>
                    <input type="text" name="midbegin" value="<?php echo $rs_editsettings[0]->midbegin; ?>"  />
                </td>


                <td class="key">
                    Ad Rotate
                </td>
                <td>
                    <input type="radio" name="midadrotate" <?php
                           if ($rs_editsettings[0]->midadrotate == 1) {
                               echo 'checked="checked" ';
                           }
?> value="1" />Enable
                    <input type="radio" name="midadrotate" <?php
                           if ($rs_editsettings[0]->midadrotate == 0) {
                               echo 'checked="checked" ';
                           }
?> value="0" />Disable
                </td>
            </tr>
            <tr>

                <td class="key">
                    Mid Roll Ads Random
                </td>
                <td>
                    <input type="radio" name="midrandom" <?php
                           if ($rs_editsettings[0]->midrandom == 1) {
                               echo 'checked="checked" ';
                           }
?> value="1" />Enable
                           <input type="radio" name="midrandom" <?php
                           if ($rs_editsettings[0]->midrandom == 0) {
                               echo 'checked="checked" ';
                           }
?> value="0" />Disable
                       </td>



                       <td class="key">
                           Add Interval
                       </td>
                       <td>
                           <input type="text" name="midinterval" value="<?php echo $rs_editsettings[0]->midinterval; ?>"   />
                       </td>
                   </tr>
                   <tr>
                   </tr>
               </table>
           </fieldset>

           <fieldset class="adminform">
               <legend>Logo Settings</legend>
               <table class="admintable">
                   <tr>
                       <td class="key">Licence Key</td>
                       <td><input type="text" name="licensekey" id="licensekey" size="60" maxlength="200"  value="<?php echo $rs_editsettings[0]->licensekey; ?>"     /></td>
                       <td>
<?php
                           if ($rs_editsettings[0]->licensekey == '') {
?>
                               <a href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share" target="_blank"><img  src="components/com_contushdvideoshare/images/buynow.gif" width="77" height="23" /></a>
<?php
                           }
?>
                       </td>
                   </tr>
                   <tr>
                       <td class="key">
                           Logo
                       </td>
                       <td >
                           <div id="var_logo">
                               <input name="logopath" id="logopath" maxlength="100" readonly="readonly" value="<?php echo $rs_editsettings[0]->logopath; ?>">
                               <input type="button" name="change1" value="Change" maxlength="100" onclick="getValue11()">
                               <label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions : jpg/jpeg, gif, png </label>
                           </div>
                       </td>

                       <td>
                       </td>
                       <td>

                       </td>
                   </tr>
                   <tr>
                       <td class="key">
                           Logo url
                       </td>
                       <td>
                           <input style="width:150px;" type="text" name="logourl" value="<?php echo $rs_editsettings[0]->logourl; ?>" />
                       </td>
                   </tr>
                   <tr>
                   </tr>
                   <tr><td class="key">Logo Position</td>
                       <td ><select name="logoalign">
                               <option value="TR" id="TR">Top Right</option>
                               <option value="TL" id="TL">Top Left</option>
                               <option value="LB" id="LB">Bottom Left</option>
                               <option value="RB" id="RB">Bottom Right</option>
                           </select>

<?php
                           if ($rs_editsettings[0]->logoalign) {
                               echo '<script>document.getElementById("' . $rs_editsettings[0]->logoalign . '").selected="selected"</script>';
                           }
?>
                           <label style="background-color:#D5E9EE; color:#333333;"> Disabled in Demo Version</label>
                       </td>



                   </tr>


                   <tr>
                       <td class="key">
                           Hide youtube logo
                       </td>

                       <td>
                           <input type="radio" name="scaletologo"  id="scaletologo1"  <?php if ($rs_editsettings[0]->scaletologo == '1') {
                               echo 'checked="checked" ';
                           } ?>  checked="checked" value="1" />True
                                   <input type="radio" name="scaletologo"  id="scaletologo2" <?php if ($rs_editsettings[0]->scaletologo == '0') {
                               echo 'checked="checked" ';
                           } ?> value="0"/>False

                               </td>
                           </tr>

                       </table>
                   </fieldset>


                   <input type="hidden" name="id" value="<?php echo $rs_editsettings[0]->id; ?>" />
<!--                   <input type="hidden" name="option" value="<?php echo $option; ?>"/>-->
                   <input type="hidden" name="task" value="" />
                   <input type="hidden" name="submitted" value="true" id="submitted">
               </form>


               <script language="javascript" >

                   function getValue11()
                   {
                       var var_logo;
                       var_logo='<input type="file" name="logopath" id="logopath" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :jpg/jpeg,gif,png </label>';
                       document.getElementById('var_logo').innerHTML=var_logo;
                   }
               </script>
                    <?php
                       } // If condn
                   } else {
 ?>


   <form action="index.php?option=com_contushdvideoshare&layout=settings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
       <fieldset class="adminform">
           <legend>Player Settings</legend>

           <table class="admintable">
                    <?php
                       if (count($rs_showsettings) >= 1) {
 ?>

                    <?php
                           for ($i = 0, $n = count($rs_showsettings); $i < $n; $i++) {
                    ?>
                       <tr><td class="key" width=20%>Buffer Time</td><td><?php echo $rs_showsettings[$i]->buffer . ' ' . "secs"; ?></td>
                           <td class="key" width=20%>Logo Alpha</td><td><?php echo $rs_showsettings[$i]->logoalpha . ' ' . "%" ?></td>
                       </tr>
                       <tr><td class="key">Width</td><td><?php echo $rs_showsettings[$i]->width . ' ' . "px"; ?>

                               </td>
                <?php
                               if ($rs_showsettings[$i]->skin_autohide == 1)
                                   $skin_autohide = "Enabled";
                               else
                                   $skin_autohide="Disabled";
                ?>
                                   <td class="key">Skin Auto Hide</td><td><?php echo $skin_autohide ?></td>
                               </tr>
                               <tr><td class="key">Height</td><td><?php echo $rs_showsettings[$i]->height . ' ' . "px"; ?></td>
                                   <td class="key">Stage Color</td><td><?php echo "#" . $rs_showsettings[$i]->stagecolor ?></td>
                               </tr>
                               <tr><td class="key">Normal Screen Scale</td>
                                   <td>
                <?php
                               if ($rs_showsettings[$i]->normalscale == 0)
                                   $val_normalscale = "Aspect Ratio";
                               else if ($rs_showsettings[$i]->normalscale == 1)
                                   $val_normalscale = "Original Size";
                               else if ($rs_showsettings[$i]->normalscale == 2)
                                   $val_normalscale = "Fit to screen";
                               echo $val_normalscale;
                ?>
                               </td>
                               <td class="key">Skin </td><td><?php echo $rs_showsettings[$i]->skin ?></td>
                           </tr>
                           <tr><td class="key">Full Screen Scale</td><td>
                <?php
                               if ($rs_showsettings[$i]->fullscreenscale == 0)
                                   $val_fullscreenscale = "Aspect Ratio";
                               else if ($rs_showsettings[$i]->fullscreenscale == 1)
                                   $val_fullscreenscale = "Original Size";
                               else if ($rs_showsettings[$i]->fullscreenscale == 2)
                                   $val_fullscreenscale = "Fit to screen";
                               echo $val_fullscreenscale;
                ?>
                               </td>
                <?php
                               if ($rs_showsettings[$i]->fullscreen == 1)
                                   $fullscreen = "Enabled";
                               else
                                   $fullscreen="Disabled";
                ?>
                               <td class="key">Full Screen</td><td><?php echo $fullscreen ?></td>
                           </tr>
                <?php
                               if ($rs_showsettings[$i]->autoplay == 1)
                                   $autoplay = "Enabled";
                               else
                                   $autoplay="Disabled";
                ?>
                           <tr><td class="key">Autoplay</td><td><?php echo $autoplay ?></td>
                    <?php
                               if ($rs_showsettings[$i]->zoom == 1)
                                   $zoom = "Enabled";
                               else
                                   $zoom="Disabled";
                    ?>
                           <td class="key">Zoom</td><td><?php echo $zoom ?></td>
                       </tr>
                       <tr><td class="key">Volume</td><td><?php echo $rs_showsettings[$i]->volume . ' ' . "%" ?></td>
                               <td class="key">Upload Max File Size</td>
                               <td><?php echo $rs_showsettings[$i]->uploadmaxsize . ' ' . "MB" ?>
                               </td>
                           </tr>
                           <tr><td class="key">FFMpeg Binary Path</td><td><?php echo $rs_showsettings[0]->ffmpegpath ?></td>
                           <td class="key">Timer</td>
                <?php
                               if ($rs_showsettings[$i]->timer == 1)
                                   $timer = "Enabled";
                               else
                                   $timer="Disabled";
                ?>
                               <td><?php echo $timer; ?></td>
                           </tr>
                           <tr>
                               <td class="key">Playlist Autoplay</td>
<?php
                               if ($rs_showsettings[$i]->playlist_autoplay == 1)
                                   $pautoplay = "Enabled";
                               else
                                   $pautoplay="Disabled";
?>
                           <td ><?php echo $pautoplay; ?></td>
                           <td class="key">HD Default</td>
<?php
                               if ($rs_showsettings[$i]->hddefault == 1)
                                   $hddefault = "Enabled";
                               else
                                   $hddefault="Disabled";
?>
                           <td>
<?php echo $hddefault; ?>
                           </td>
                       </tr>
                       <tr>
                           <td class="key">
                               Playlist Open
                           </td>
<?php
                               ($rs_showsettings[$i]->playlist_open == 1) ? $playlist_open = "Enabled" : $playlist_open = "Disabled";
?>
                               <td>
                <?php echo $playlist_open; ?>
                               </td>
                               <td class="key">Related Videos</td>
                <?php
                               if ($rs_showsettings[$i]->related_videos == 1)
                                   $related_videos = "Enabled";
                               elseif ($rs_showsettings[$i]->related_videos == 2)
                                   $related_videos = "Disabled";
                               elseif ($rs_showsettings[$i]->related_videos == 3)
                                   $related_videos = "Within Player";
                               else if ($rs_showsettings[$i]->related_videos == 4)
                                   $related_videos = "Outside Player";
                ?>
                           <td><?php echo $related_videos; ?> </td>
                       </tr>
                       <tr>
                           <td class="key">Vast</td>
                           <td>
                    <?php
                               ($rs_showsettings[$i]->vast == 1) ? $vast = "Enabled" : $vast = "Disabled";
                               echo $vast;
                    ?>

                           </td>
                           <td class="key">Vast Partner Id</td>
                           <td>
                <?php echo $rs_editsettings[0]->vast_pid; ?>
                               </td>
                           </tr>
                           <tr>
<!--                               <td class="key">Use Youtube API</td>
                               <td>
<?php
                               //($rs_showsettings[$i]->Youtubeapi == 1) ? $vast = "Enabled" : $vast = "Disabled";
                             //  echo $vast;
?>
                           </td>-->
                           <td class="key">Share url</td>
<?php
                               if ($rs_showsettings[$i]->shareurl == 1)
                                   $shareurl = "Enabled";
                               else
                                   $shareurl="Disabled";
?>
                               <td>
<?php echo $shareurl; ?>
                           </td>
                       </tr>
                   </table>
               </fieldset>
               <fieldset class="adminform">
                   <legend>Pre / Post-Roll Ad Settings</legend>
                   <table class="admintable">
                       <tr>
                           <td class="key">Postroll Ads</td>
                           <td>
<?php
                               ($rs_showsettings[$i]->postrollads == 1) ? $postads = "Enabled" : $postads = "Disabled";
                               echo $postads;
?>
                               </td>
                               <td class="key">
                                   Preroll Ads
                               </td>
<?php
                               ($rs_editsettings[0]->prerollads == 1) ? $pre = "Enabled" : $pre = "Disabled";
?>
                           <td>
<?php echo $pre; ?>
                           </td>
                       </tr>
                   </table>
               </fieldset>
               <fieldset class="adminform">
                   <legend>Mid RollAd Settings</legend>
                   <table class="admintable">
                       <tr>
                           <td class="key">
                               Mid roll ads
                           </td>
                <?php
                               ($rs_showsettings[$i]->midrollads == 1) ? $midrollads = "Enabled" : $midrollads = "Disabled";
                ?>
                               <td>
<?php echo $midrollads; ?>
                           </td>
                           <td class="key">
                               Begin
                           </td>
<?php
                               ($rs_showsettings[$i]->midbegin == 0) ? $midbegin = "0" : $midbegin = $rs_showsettings[$i]->midbegin;
?>
                           <td>
<?php echo $midbegin; ?>
                           </td>
                           <td class="key">
                               Ad Rotate
                           </td>
                    <?php
//($rs_showsettings[$i]->$midadrotate == 1) ? $midadrotate = "Enabled" : $midadrotate = "Disabled";
                               ($rs_showsettings[$i]->midadrotate == 1) ? $midadrotate = "Enabled" : $midadrotate = "Disabled";
                    ?>
                           <td>
<?php echo $midadrotate; ?>
                           </td>
                       </tr>
                       <tr>
                           <td class="key">
                               Mid Roll Ads Random
                           </td>
<?php
                               ($rs_showsettings[$i]->midrandom == 1) ? $midrandom = "Enabled" : $midrandom = "Disabled";
?>
                           <td>
<?php echo $midrandom; ?>
                           </td>
                           <td class="key">
                               Add Interval
                           </td>
<?php
                               ($rs_showsettings[$i]->midinterval == 0) ? $midinterval = "0" : $midinterval = $rs_showsettings[$i]->midinterval;
?>
                               <td>
                <?php echo $midinterval; ?>
                               </td>
                           </tr>
                       </table>
                   </fieldset>
                   <fieldset class="adminform">
                       <legend>Logo Settings</legend>
                       <table class="admintable">
                           <tr>
                               <td class="key">LicenseKey</td>
                               <td><?php echo $rs_editsettings[0]->licensekey; ?></td>
                               <td>
<?php
                               if ($rs_editsettings[0]->licensekey == '') {
?>
                                       <a href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share" target="_blank"><img  src="components/com_contushdvideoshare/images/buynow.gif" width="77" height="23" /></a>
<?php
                               }
?>
                               </td>
                               <td></td>
                           </tr>
                           <tr><td class="key">Logo </td>
                               <td width="20%"><?php echo $rs_showsettings[0]->logopath; ?></td>
                           <td></td>
                           <td>
                           </td>
                       </tr>
                       <tr>
                           <td class="key">Logo url</td>
                           <td>
    <?php echo $rs_showsettings[0]->logourl; ?>
                                           </td>
                                           <td></td>
                                           <td></td>
                                       </tr>
                                       <tr><td class="key">Logo Position</td>
<?php
                               $logoalign = "";
                               if ($rs_showsettings[$i]->logoalign == "TL")
                                   $logoalign = "Top Left";
                               if ($rs_showsettings[$i]->logoalign == "TR")
                                   $logoalign = "Top Right";
                               if ($rs_showsettings[$i]->logoalign == "LB")
                                   $logoalign = "Bottom Left";
                               if ($rs_showsettings[$i]->logoalign == "RB")
                                   $logoalign = "Bottom Right";
?>
                                               <td><?php echo $logoalign; ?>
                                               </td>
                                               <td class=""></td><td> </td>
                                           </tr>
                                           <tr>
                                               <td class="key">
                                                   Hide youtube logo
                                               </td>
<?php
                               ($rs_showsettings[0]->scaletologo == 1) ? $sthl = "True" : $sthl = "False";
?>
                                               <td>
<?php echo $sthl; ?>
                                               </td>
                                               <td></td>
                                               <td></td>
                                           </tr>
                                       </table>
                                   </fieldset>
<?php
                           }
                       }
?>
                           <input type="hidden" name="id" value=""/>
<!--                           <input type="hidden" name="option" value="<?php echo $option; ?>"/>-->
                           <input type="hidden" name="task" value=""/>
                           <input type="hidden" name="boxchecked" value="1">
                           <input type="hidden" name="submitted" value="true" id="submitted">
                       </form>
<?php } ?>
<script type="text/javascript">
function Toggle(theDiv) {

    if(theDiv=="shows")
    {
        document.getElementById("show").style.display = "block";
        document.getElementById("show1").style.display = "block";
    }
    else
    {
        document.getElementById("show").style.display = "none";
        document.getElementById("show1").style.display = "none";
    }
}
</script>