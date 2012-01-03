<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        settings.php
 * @location    /components/com_contushdvideosahre/views/settings/tmpl/settings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Admin Member details layout
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$rs_editsettings = $rs_showsettings = $this->playersettings;
?>

<script language="javascript">
    document.getElementById('toolbar-box').style.marginTop=120+"px";
</script>

        <!-- Page Top videoshare information  -->

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
<?php
if (count($rs_editsettings) > 0) {
    $editor = & JFactory::getEditor();
?>
    <form action="index.php?option=com_contushdvideoshare&layout=settings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
        <div class="width-60 fltlft">
            <fieldset class="adminform">
                <legend>HDFLV Player Settings</legend>
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
                            <td> Buffer Time </td>
                            <td> <input type="text" name="buffer" value="<?php echo $rs_editsettings[0]->buffer; ?>" />  secs </td>

                    </tr>
                    <tr>
                        <td style="background-color:#D5E9EE; color:#333333; text-align: right;" colspan="2"> ** Recommended value is 3 secs </td>
                    </tr>
                    <tr>
                        <td> Width </td>
                        <td> <input type="text" name="width" value="<?php echo $rs_editsettings[0]->width; ?>" />  px </td>
                    </tr>
                    <tr>
                        <td> Height </td>
                        <td> <input type="text" name="height"  value="<?php echo $rs_editsettings[0]->height; ?>" /> px </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#D5E9EE; color:#333333;text-align: right;"> ** Width of the video can be 300px with all the controls enabled.  If you would like to have smaller than 300px then you have to disable couple of controls like Timer, Zoom.. </td>
                    </tr>
                    <tr>
                        <td> Normal Screen Scale </td>
                        <td>
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
                    </tr>
                    <tr>
                        <td> Full Screen Scale </td>
                        <td>
                            <select  name="fullscreenscale">
                                <option value="0" id="10" name=0>Aspect Ratio</option>
                                <option value="1" id="11" name=1>Original Size</option>
                                <option value="2" id="12" name=2>Fit to Screen</option>
                            </select>
                            <?php
                                if ($rs_editsettings[0]->fullscreenscale) {
                                    echo '<script>document.getElementById("1' . $rs_editsettings[0]->fullscreenscale . '").selected="selected" </script>';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Autoplay </td>
                        <td>
                            <input type="radio"  style="float:none;" name="autoplay" <?php if ($rs_editsettings[0]->autoplay == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                            <input type="radio" style="float:none;" name="autoplay" <?php if ($rs_editsettings[0]->autoplay == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Volume </td>
                        <td> <input type="text" name="volume" value="<?php echo $rs_editsettings[0]->volume; ?>"     /> % </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#D5E9EE; color:#333333;text-align: right;"> ** Recommended value is 50 </td>
                    </tr>
                    <tr>
                        <td> FFMpeg Binary Path </td>
                        <td> <input style="width:150px;" type="text" name="ffmpegpath" value="<?php echo $rs_editsettings[0]->ffmpegpath; ?>" /> </td>
                    </tr>
                    <tr>
                        <td> Playlist Autoplay </td>
                        <td> <input type="radio" style="float:none;" name="playlist_autoplay" <?php if ($rs_editsettings[0]->playlist_autoplay == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;" name="playlist_autoplay" <?php if ($rs_editsettings[0]->playlist_autoplay == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Playlist Open </td>
                        <td> <input type="radio" style="float:none;" name="playlist_open" <?php if ($rs_editsettings[0]->playlist_open == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;" name="playlist_open" <?php if ($rs_editsettings[0]->playlist_open == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Vast </td>
                        <td> <input type="radio" style="float:none;" name="vast" <?php if ($rs_editsettings[0]->vast == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                            <input type="radio" style="float:none;" name="vast" <?php if ($rs_editsettings[0]->vast == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Vast Partner Id </td>
                        <td> <input type="text" name="vast_pid" value="" /> </td>
                    </tr>
                    <tr>
                        <td> Hide Youtube Logo </td>
                        <td> <input type="radio" name="scaletologo"  id="scaletologo1" style="float:none;" <?php if ($rs_editsettings[0]->scaletologo == '1') { echo 'checked="checked" '; } ?> checked="checked" value="1" />True
                             <input type="radio" name="scaletologo"  id="scaletologo2" <?php if ($rs_editsettings[0]->scaletologo == '0') { echo 'checked="checked" '; } ?> style="float:none;" value="0"/>False
                        </td>
                   </tr>
                    <tr>
                        <td> Logo Alpha </td>
                        <td> <input type="text" name="logoalpha"  value="<?php echo $rs_editsettings[0]->logoalpha; ?>"      /> % </td>
                    </tr>
                    <tr>
                        <td style="background-color:#D5E9EE; color:#333333;text-align: right;" colspan="2"> ** Edit the value to have transparancy depth of logo </td>
                    </tr>
                    <tr>
                        <td> Skin Auto Hide </td>
                        <td> <input type="radio" style="float:none;" name="skin_autohide" <?php if ($rs_editsettings[0]->skin_autohide == 1) { echo 'checked="checked" '; } ?> value="1" /> Enable
                             <input type="radio" style="float:none;" name="skin_autohide" <?php if ($rs_editsettings[0]->skin_autohide == 0) { echo 'checked="checked" '; } ?>value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Stage Color </td>
                        <td> # <input type="text" name="stagecolor"  value="<?php echo $rs_editsettings[0]->stagecolor; ?>"    /> </td>
                    </tr>
                    <tr>
                        <td> Skin </td>
                        <td>
                            <select name="skin">
                                <option value="skin_black.swf" id="skin_black.swf">skin_black.swf</option>
                                <option value="skin_Overlay.swf" id="skin_Overlay.swf">skin_Overlay.swf</option>
                                <option value="skin_white.swf" id="skin_white.swf">skin_white.swf</option>
                                <option value="skin_fancyblack.swf" id="skin_fancyblack.swf">skin_fancyblack.swf</option>
                                <option value="skin_sleekblack.swf" id="skin_sleekblack.swf">skin_sleekblack.swf</option>
                            </select>
                            <?php
                            if ($rs_editsettings[0]->skin) {
                                echo '<script>document.getElementById("' . $rs_editsettings[0]->skin . '").selected="selected"</script>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Full Screen </td>
                        <td> 
                            <input type="radio"  style="float:none;" name="fullscreen" <?php if ($rs_editsettings[0]->fullscreen == 1) { echo 'checked="checked" '; } ?>value="1" />Enable
                            <input type="radio" style="float:none;" name="fullscreen" <?php if ($rs_editsettings[0]->fullscreen == 0) { echo 'checked="checked" '; } ?>value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Zoom </td>
                        <td> <input type="radio" style="float:none;" name="zoom" <?php if ($rs_editsettings[0]->zoom == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                            <input type="radio" style="float:none;" name="zoom" <?php if ($rs_editsettings[0]->zoom == 0) { echo 'checked="checked" '; } ?>value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Upload Max File Size </td>
                        <td>
                            <select name="uploadmaxsize">
                                <option value="50" id="50">50 MB</option>
                                <option value="100" id="100">100 MB</option>
                            </select>
                            <?php
                                if ($rs_editsettings[0]->uploadmaxsize) {
                                echo '<script>document.getElementById("' . $rs_editsettings[0]->uploadmaxsize . '").selected="selected"</script>';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#D5E9EE; color:#333333;text-align: right;" colspan="2"> ** Recommended value is 50 </td>
                    </tr>
                    <tr>
                        <td> Timer </td>
                        <td> <input type="radio" style="float:none;"  name="timer" <?php if ($rs_editsettings[0]->timer == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;"  name="timer" <?php if ($rs_editsettings[0]->timer == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                   <tr>
                        <td> Share URL </td>
                        <td> <input type="radio" style="float:none;"  name="shareurl" <?php if ($rs_editsettings[0]->shareurl == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;" name="shareurl" <?php if ($rs_editsettings[0]->shareurl == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> HD Default </td>
                        <td> <input type="radio" style="float:none;" name="hddefault" <?php if ($rs_editsettings[0]->hddefault == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;" name="hddefault" <?php if ($rs_editsettings[0]->hddefault == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Related Videos </td>
                        <td>
                            <select name="related_videos">
                                <option value="1" id="1">Enable Both</option>
                                <option value="2" id="2">Disable</option>
                                <option value="3" id="3">Within Player</option>
                                <option value="4" id="4">Outside Player</option>
                            </select>
                            <?php
                                if ($rs_editsettings[0]->related_videos) {
                                echo '<script>document.getElementById("' . $rs_editsettings[0]->related_videos . '").selected="selected"</script>';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Postroll Ads </td>
                        <td> <input type="radio" style="float:none;" name="postrollads" <?php if ($rs_editsettings[0]->postrollads == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;" name="postrollads" <?php if ($rs_editsettings[0]->postrollads == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Preroll Ads </td>
                        <td> <input type="radio" style="float:none;" name="prerollads" <?php if ($rs_editsettings[0]->prerollads == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;" name="prerollads" <?php if ($rs_editsettings[0]->prerollads == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
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
                        <td> <div id="show"> Enter Google Analytics ID </div> </td>
                        <td> <div id="show1"> <input name="googleanalyticsID" id="googleanalyticsID" maxlength="100"  value="<?php echo $rs_editsettings[0]->googleanalyticsID; ?>"></div> </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>

    <div class="width-40 fltlft">
        <fieldset class="adminform">
            <legend>Mid Roll Ads Settings</legend>
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
                        <td class="key">Mid roll ads</td>
                        <td> <input type="radio" style="float:none;"  name="midrollads" <?php if ($rs_editsettings[0]->midrollads == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;"  name="midrollads" <?php if ($rs_editsettings[0]->midrollads == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Begin </td>
                        <td> <input type="text" name="midbegin" value="<?php echo $rs_editsettings[0]->midbegin; ?>"  /> </td>
                    </tr>
                    <tr>
                        <td> Ad Rotate</td>
                        <td> <input type="radio" style="float:none;"  name="midadrotate" <?php if ($rs_editsettings[0]->midadrotate == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;"  name="midadrotate" <?php if ($rs_editsettings[0]->midadrotate == 0) { echo 'checked="checked" '; } ?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Mid Roll Ads Random </td>
                        <td> <input type="radio" style="float:none;"  name="midrandom" <?php if ($rs_editsettings[0]->midrandom == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                             <input type="radio" style="float:none;" name="midrandom" <?php if ($rs_editsettings[0]->midrandom == 0) { echo 'checked="checked" '; }?> value="0" />Disable
                        </td>
                    </tr>
                    <tr>
                        <td> Ad Interval </td>
                        <td> <input type="text" name="midinterval" value="<?php echo $rs_editsettings[0]->midinterval; ?>"   /> </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>

    <div class="width-40 fltlft">
        <fieldset class="adminform">
            <legend>Logo Settings</legend>
            <table class="adminlist">
                <thead>
                    <tr>
                        <th> Settings </th>
                        <th> Value </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2">&#160;</td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td class="key">Licence Key</td>
                        <td> <input type="text" name="licensekey" id="licensekey" size="60" maxlength="200"  value="<?php echo $rs_editsettings[0]->licensekey; ?>"     />
                                <?php if ($rs_editsettings[0]->licensekey == '') { ?>
                                    <a href="http://hdvideoshare.net/shop/index.php?main_page=product_info&cPath=7&products_id=7" target="_blank"><img  src="components/com_contushdvideoshare/images/buynow.gif" width="77" height="23" /></a>
                                <?php
                                    }
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Logo </td>
                        <td> 
                            <div id="var_logo">
                                <input name="logopath" id="logopath" maxlength="100" readonly="readonly" value="<?php echo $rs_editsettings[0]->logopath; ?>">
                                <input type="button" name="change1" value="Change" maxlength="100" onclick="getValue11()">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#D5E9EE; color:#333333; text-align: right;" colspan="2"> ** Allowed Extensions :jpg/jpeg,gif ,png </td>
                    </tr>
                    <tr>
                        <td> Logo url </td>
                        <td> <input style="width:150px;" type="text" name="logourl" value="<?php echo $rs_editsettings[0]->logourl; ?>" /> </td>
                    </tr>
                    <tr>
                        <td> Logo Position</td>
                        <td>
                            <select name="logoalign">
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
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#D5E9EE; color:#333333;text-align: right;"> ** Disabled in Demo Version </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>
    <input type="hidden" name="id" value="<?php echo $rs_editsettings[0]->id; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="submitted" value="true" id="submitted">
    <?php echo JHTML::_('form.token'); ?>
</form>
    <?php
    } // If condn
    ?>

<script language="javascript" >

function getValue11()
{
    var var_logo;
    var_logo='<input type="file" name="logopath" id="logopath" maxlength="100"  value="" />';
    document.getElementById('var_logo').innerHTML=var_logo;
}

</script>

<style type="text/css">
#show
{
    DISPLAY: none;
}

#show1
{
    DISPLAY: none;
}

</style>

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

<?php
if ($rs_editsettings[0]->googleana_visible == 1) {
echo '<script type="text/javascript">';
echo 'document.getElementById("show").style.display = "block";';
echo ' document.getElementById("show1").style.display = "block";';
echo '</script>';
}
?>