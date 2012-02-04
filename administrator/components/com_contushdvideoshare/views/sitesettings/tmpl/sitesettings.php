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
?>

<?php
$Commentname = array("None", "Deafult", "Jom Comment", "JComment");
?>


<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$editsitesettings = $showsitesettings = $this->sitesettings;
//$this->settings;
//echo $rs_showsettings[0]->buffer;
?>
<style>
    fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button{float: none;}
</style>
<form action="index.php?option=com_contushdvideoshare&layout=sitesettings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset class="adminform">
        <legend>Details</legend>
        <table class="adminlist">
            <tr>
                <td  width="300px;">Commenting system:</td>
                <td colspan="4">
                    <select name="comment">
                        <option value="0" <?php if ($editsitesettings->comment == 0)
    echo "selected=selected"; ?>>None</option>
                        <option value="2" <?php if ($editsitesettings->comment == 2)
                            echo "selected=selected"; ?>>Default</option>
                        <option value="1" <?php if ($editsitesettings->comment == 1)
                            echo "selected=selected"; ?>>FaceBookComment</option>
                        <?php
                        $jomselected = "";
                        if ($this->jomcomment == 1) {
                            
                            if ($editsitesettings->comment == 3) {
                                $jomselected = "selected=selected";
                            }
                            echo "<option value='3'" . $jomselected . " >Jom Comment</option>";
                        }
                        else
                            echo "<option value='3'" . $jomselected . " >Jom Comment</option>";
                        $jcselected = "";
                        if ($this->jcomment == 1) {
                            
                            if ($editsitesettings->comment == 4) {
                                $jcselected = "selected=selected";
                            }
                            echo "<option value='4'" . $jcselected . " >JComment</option>";
                        }
                        else
                            echo "<option value='4'" . $jcselected . " >JComment</option>";
                        ?>
                    </select>
                    If you want to have Jom Comment or JComment as your commenting system for videos, please install them and activate it from here.
                </td>

            </tr>
<tr>
                <td class="key">Facebook API:</td>
                <td colspan="4">
                    <input name="facebookapi" id="facebookapi" maxlength="100" value="<?php $editsitesettings->facebookapi=isset($editsitesettings->facebookapi)?$editsitesettings->facebookapi:''; echo $editsitesettings->facebookapi; ?>">
                </td>
            </tr>
            <tr>
                <td class="key">Language Settings</td>
                <td colspan="4">
                    <select name="language_settings">

                        <?php
                        $selectedlan = "";
                        $myabsoluteurl = getcwd();
                        $myabsoluteurl = str_replace('administrator', '', $myabsoluteurl);

//echo $myabsoluteurl;
$dir ='';
                        $image_file_path = $myabsoluteurl . "components/com_contushdvideoshare/language/";
                        $d = dir($image_file_path) or die("Wrong path: $image_file_path");
                        while (false !== ($entry = $d->read())) {

                            if ($entry != 'index.html') {
                                if ($editsitesettings->language_settings == $entry)
                                    $selectedlan = "selected=selected";
                                else
                                    $selectedlan="";


                                if ($entry != '.' && $entry != '..' && !is_dir($dir . $entry))
                                    echo "<option value='" . $entry . "' " . $selectedlan . ">" . str_replace('.php', '', $entry) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td  width="300px;">Featured Videos:</td>
                <td width="200px;">Row :
                    <input name="featurrow" id="featurrow" maxlength="100" value="<?php echo $editsitesettings->featurrow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="featurcol" id="featurcol" maxlength="100" value="<?php echo $editsitesettings->featurcol; ?>">
                </td>
            </tr>
            <tr>
                <td>Recent Videos:</td>
                <td>Row :
                    <input name="recentrow" id="recentrow" maxlength="100" value="<?php echo $editsitesettings->recentrow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="recentcol" id="recentcol" maxlength="100" value="<?php echo $editsitesettings->recentcol; ?>">
                </td>
            </tr>
            <tr>
                <td>Popular Videos:</td>
                <td>Row :
                    <input name="popularrow" id="popularrow" maxlength="100" value="<?php echo $editsitesettings->popularrow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="popularcol" id="popularycol" maxlength="100" value="<?php echo $editsitesettings->popularcol; ?>">
                </td>
            </tr>
            <tr>
                <td>Category View:</td>
                <td>Row :
                    <input name="categoryrow" id="categoryrow" maxlength="100" value="<?php echo $editsitesettings->categoryrow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="categorycol" id="categorycol" maxlength="100" value="<?php echo $editsitesettings->categorycol; ?>">
                </td>
            </tr>
            <tr>
                <td>Search View:</td>
                <td>Row :
                    <input name="searchrow" id="searchrow" maxlength="100" value="<?php echo $editsitesettings->searchrow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="searchcol" id="searchcol" maxlength="100" value="<?php echo $editsitesettings->searchcol; ?>">
                </td>
            </tr>
            <tr>
                <td>Related Videos:</td>
                <td>Row :
                    <input name="relatedrow" id="relatedrow" maxlength="100" value="<?php echo $editsitesettings->relatedrow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="relatedcol" id="relatedcol" maxlength="100" value="<?php echo $editsitesettings->relatedcol; ?>">
                </td>
            </tr>
            <tr>
                <td>My Videos:</td>
                <td>Row :
                    <input name="myvideorow" id="myvideorow" maxlength="100" value="<?php echo $editsitesettings->myvideorow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="myvideocol" id="myvideocol" maxlength="100" value="<?php echo $editsitesettings->myvideocol; ?>">
                </td>
            </tr>
            <tr>
                <td>Member Page View:</td>
                <td>Row :
                    <input name="memberpagerow" id="memberpagerow" maxlength="100" value="<?php echo $editsitesettings->memberpagerow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="memberpagecol" id="memberpagecol" maxlength="100" value="<?php echo $editsitesettings->memberpagecol; ?>">
                </td>
            </tr>
            <tr>
                <td>Side Popular Videos:</td>
                <td>Row  :
                    <input name="sidepopularvideorow" id="sidepopularvideorow" maxlength="100" value="<?php echo $editsitesettings->sidepopularvideorow; ?>">
                </td>
                <td  colspan="3">Column :
                    <input name="sidepopularvideocol" id="sidepopularvideocol" maxlength="100" value="<?php echo $editsitesettings->sidepopularvideocol; ?>">
                </td>
            </tr>
            <tr>
                <td>Side Featured Videos:</td>
                <td>Row  :
                    <input name="sidefeaturedvideorow" id="sidefeaturedvideorow" maxlength="100" value="<?php echo $editsitesettings->sidefeaturedvideorow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="sidefeaturedvideocol" id="sidefeaturedvideocol" maxlength="100" value="<?php echo $editsitesettings->sidefeaturedvideocol; ?>">
                </td>
            </tr>
            <tr>
                <td>Side Related Videos:</td>
                <td>Row  :
                    <input name="siderelatedvideorow" id="siderelatedvideorow" maxlength="100" value="<?php echo $editsitesettings->siderelatedvideorow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="siderelatedvideocol" id="siderelatedvideocol" maxlength="100" value="<?php echo $editsitesettings->siderelatedvideocol; ?>">
                </td>
            </tr>

            <tr>
                <td>Side Recent Videos:</td>
                <td>Row  :
                    <input name="siderecentvideorow" id="siderecentvideorow" maxlength="100" value="<?php echo $editsitesettings->siderecentvideorow; ?>">
                </td>
                <td colspan="3">Column :
                    <input name="siderecentvideocol" id="siderecentvideocol" maxlength="100" value="<?php echo $editsitesettings->siderecentvideocol; ?>">
                </td>
            </tr>
            <tr>
                <td>Home Page Popular Videos:</td>
                <td>
                    <input type="radio" name="homepopularvideo" <?php if ($editsitesettings->homepopularvideo == 1) {
                            echo 'checked="checked" ';
                        } ?> value="1" />Enable
                    <input type="radio" name="homepopularvideo" <?php if ($editsitesettings->homepopularvideo == 0) {
                            echo 'checked="checked" ';
                        } ?>value="0" />Disable
                </td>
                <td>Row :
                    <input name="homepopularvideorow" id="homepopularvideorow" maxlength="100" value="<?php echo $editsitesettings->homepopularvideorow; ?>">
                </td>
                <td>Column :
                    <input name="homepopularvideocol" id="homepopularvideocol" maxlength="100" value="<?php echo $editsitesettings->homepopularvideocol; ?>">
                </td>
                <td>Order :
                    <select name="homepopularvideoorder">
                        <option value="1" <?php if ($editsitesettings->homepopularvideoorder == 1)
                            echo "selected=selected"; ?>>1</option>
                        <option value="2" <?php if ($editsitesettings->homepopularvideoorder == 2)
                            echo "selected=selected"; ?>>2</option>
                        <option value="3" <?php if ($editsitesettings->homepopularvideoorder == 3)
                            echo "selected=selected"; ?>>3</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td>Home Page Featured Videos:</td>
                <td>
                    <input type="radio" name="homefeaturedvideo" <?php if ($editsitesettings->homefeaturedvideo == 1) {
                            echo 'checked="checked" ';
                        } ?> value="1" />Enable
                    <input type="radio" name="homefeaturedvideo" <?php if ($editsitesettings->homefeaturedvideo == 0) {
                            echo 'checked="checked" ';
                        } ?>value="0" />Disable
                </td>
                <td>Row :
                    <input name="homefeaturedvideorow" id="homefeaturedvideorow" maxlength="100" value="<?php echo $editsitesettings->homefeaturedvideorow; ?>">
                </td>
                <td>Column :
                    <input name="homefeaturedvideocol" id="homefeaturedvideocol" maxlength="100" value="<?php echo $editsitesettings->homefeaturedvideocol; ?>">
                </td>
                <td>Order :

                    <select name="homefeaturedvideoorder">
                        <option value="1" <?php if ($editsitesettings->homefeaturedvideoorder == 1)
                            echo "selected=selected"; ?>>1</option>
                        <option value="2" <?php if ($editsitesettings->homefeaturedvideoorder == 2)
                            echo "selected=selected"; ?>>2</option>
                        <option value="3" <?php if ($editsitesettings->homefeaturedvideoorder == 3)
                            echo "selected=selected"; ?>>3</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td>Home Page Recent Videos:</td>
                <td>
                    <input type="radio" name="homerecentvideo" <?php if ($editsitesettings->homerecentvideo == 1) {
                            echo 'checked="checked" ';
                        } ?> value="1" />Enable
                    <input type="radio" name="homerecentvideo" <?php if ($editsitesettings->homerecentvideo == 0) {
                            echo 'checked="checked" ';
                        } ?>value="0" />Disable
                </td>
                <td>Row :
                    <input name="homerecentvideorow" id="homerecentvideorow" maxlength="100" value="<?php echo $editsitesettings->homerecentvideorow; ?>">
                </td>
                <td>Column :
                    <input name="homerecentvideocol" id="homerecentvideocol" maxlength="100" value="<?php echo $editsitesettings->homerecentvideocol; ?>">
                </td>
                <td>Order :


                    <select name="homerecentvideoorder">
                        <option value="1" <?php if ($editsitesettings->homerecentvideoorder == 1)
                            echo "selected=selected"; ?>>1</option>
                        <option value="2" <?php if ($editsitesettings->homerecentvideoorder == 2)
                            echo "selected=selected"; ?>>2</option>
                        <option value="3" <?php if ($editsitesettings->homerecentvideoorder == 3)
                            echo "selected=selected"; ?>>3</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Video Upload Option to Members:</td>
                <td>
                    <input type="radio" name="allowupload"  id="allowupload"  <?php if ($editsitesettings->allowupload == '1' || $editsitesettings->allowupload == '') {
                            echo 'checked="checked" ';
                        } ?>  value="1" />Yes
                </td>
                <td colspan="3">
                    <input type="radio" name="allowupload"  id="allowupload" <?php if ($editsitesettings->allowupload == '0') {
                            echo 'checked="checked" ';
                        } ?>  value="0" />No


                </td>
            </tr>
            <tr><td>Members Login/Register:</td>
                <td>
                    <input type="radio" name="user_login"  id="allowupload"  <?php if ($editsitesettings->user_login == '1') {
                            echo 'checked="checked" ';
                        } ?>  value="1" />Yes
                </td>
                <td colspan="3">
                    <input type="radio" name="user_login"  id="allowupload" <?php if ($editsitesettings->user_login == '0') {
                            echo 'checked="checked" ';
                        } ?>  value="0" />No


                </td>
            </tr>
            <tr><td>Display Ratings </td>
                <td>
                    <input type="radio" name="ratingscontrol"  id="ratingscontrol"  <?php if ($editsitesettings->ratingscontrol == '1') {
                            echo 'checked="checked" ';
                        } ?>  value="1" />Yes
                </td>
                <td colspan="3">
                    <input type="radio" name="ratingscontrol"  id="ratingscontrol" <?php if ($editsitesettings->ratingscontrol == '0') {
                            echo 'checked="checked" ';
                        } ?>  value="0" />No
               </td>
            </tr>
            <tr><td>Display Viewed  </td>
                <td>
                    <input type="radio" name="viewedconrtol"  id="viewedconrtol"  <?php if ($editsitesettings->viewedconrtol == '1') {
                            echo 'checked="checked" ';
                        } ?>  value="1" />Yes
                </td>
                <td colspan="3">
                    <input type="radio" name="viewedconrtol"  id="viewedconrtol" <?php if ($editsitesettings->viewedconrtol == '0') {
                            echo 'checked="checked" ';
                        } ?>  value="0" />No
                </td>
            </tr>
            <tr><td>Display Social Links</td>
                <td>
                    <input type="radio" name="facebooklike"  id="facebooklike"  <?php
                        if ($editsitesettings->facebooklike == '1') {
                            echo 'checked="checked" ';
                        }
                        ?>  value="1" />Yes
                </td>
                <td colspan="3">
                    <input type="radio" name="facebooklike"  id="facebooklike" <?php
                        if ($editsitesettings->facebooklike == '0') {
                            echo 'checked="checked" ';
                        }
                        ?>  value="0" />No
                </td>
            </tr>
            <tr><td>Search Engine Friendly URLs</td>
                <td>
                    <input type="radio" name="seo_option" <?php if ($editsitesettings->seo_option == 1) {
                            echo 'checked="checked" ';
                        } ?> value="1" />Enable
                </td>
                <td colspan="3">
                    <input type="radio" name="seo_option" <?php if ($editsitesettings->seo_option == 0) {
                            echo 'checked="checked" ';
                        } ?>value="0" />Disable
                </td>
            </tr>
        </table>
    </fieldset>
    <input type="hidden" name="id" value="<?php echo $editsitesettings->id; ?>" />
       <input type="hidden" name="published" id="published" value="1"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>
<script language="javascript">
    function getValue11()
    {
        var var_logo;
        var_logo='<input type="file" name="logo" id="logo" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :jpg/jpeg,gif,png </label>';
        document.getElementById('var_logo').innerHTML=var_logo;
    }
    function getValue12()
    {
        var var_bglogo;
        var_bglogo='<input type="file" name="bg_image" id="bg_logo" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :jpg/jpeg,gif,png </label>';
        document.getElementById('var_bglogo').innerHTML=var_bglogo;
    }
</script>
