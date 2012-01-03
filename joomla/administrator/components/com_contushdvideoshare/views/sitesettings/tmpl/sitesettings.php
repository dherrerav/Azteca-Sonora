<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        sitesettings.php
 * @location    /components/com_contushdvideosahre/views/sitesettings/tmpl/sitesettings.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/*
 * Description : administrator - site settings layout 
 *               
 */

// no direct access

defined('_JEXEC') or die('Restricted access');
?>

<?php
$Commentname = array("None", "Deafult", "Jom Comment", "JComment");
?>


<?php
$editsitesettings = $showsitesettings = $this->sitesettings;
?>
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

<form action="index.php?option=com_contushdvideoshare&layout=sitesettings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="width-60 fltlft">
        <fieldset class="adminform" id="videodet" <?php echo $var1; ?>>
            <legend>Details</legend>
            <table class="adminlist">
                <thead>
                    <tr>
                        <th>
                            Settings
                        </th>
                        <th colspan="4">
                            Value
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="5">&#160; </td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td  width="300px;">Commenting system:</td>
                        <td colspan="4">
                            <select name="comment"> 
                                <option value="0" <?php if ($editsitesettings->comment == 0) echo "selected=selected"; ?>>None</option>
                                <option value="1" <?php if ($editsitesettings->comment == 1) echo "selected=selected"; ?>>Default</option>
                                <?php if ($this->jomcomment == 1) { $jomselected = ""; if ($editsitesettings->comment == 2) { $jomselected = "selected=selected"; } echo "<option value='2'" . $jomselected . " >Jom Comment</option>"; } else echo "<option value='1'" . $jomselected . " >Jom Comment</option>"; if ($this->jcomment == 1) { $jomselected = ""; if ($editsitesettings->comment == 3) { $jcselected = "selected=selected"; } echo "<option value='3'" . $jcselected . " >JComment</option>"; } else echo "<option value='1'" . $jcselected . " >JComment</option>"; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="background-color:#D5E9EE; color:#333333;text-align: right;"> ** If you want to have Jom Comment or JComment as your commenting system for videos, please install them and activate it from here. </td>
                    </tr>
                    <tr>
                        <td class="key">Language Settings</td>
                        <td colspan="4">
                            <select name="language_settings">
                                <?php
                                $selectedlan = "";
                                $myabsoluteurl = getcwd();
                                $myabsoluteurl = str_replace('administrator', '', $myabsoluteurl);
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
                        <td width="200px;">Row : <input name="featurrow" id="featurrow" maxlength="100" value="<?php echo $editsitesettings->featurrow; ?>"> </td>
                        <td colspan="3">Column : <input name="featurcol" id="featurcol" maxlength="100" value="<?php echo $editsitesettings->featurcol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Recent Videos:</td>
                        <td>Row : <input name="recentrow" id="recentrow" maxlength="100" value="<?php echo $editsitesettings->recentrow; ?>"> </td>
                        <td colspan="3">Column : <input name="recentcol" id="recentcol" maxlength="100" value="<?php echo $editsitesettings->recentcol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Popular Videos:</td>
                        <td>Row : <input name="popularrow" id="popularrow" maxlength="100" value="<?php echo $editsitesettings->popularrow; ?>"> </td>
                        <td colspan="3">Column : <input name="popularcol" id="popularycol" maxlength="100" value="<?php echo $editsitesettings->popularcol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Category View:</td>
                        <td>Row : <input name="categoryrow" id="categoryrow" maxlength="100" value="<?php echo $editsitesettings->categoryrow; ?>"> </td>
                        <td colspan="3">Column : <input name="categorycol" id="categorycol" maxlength="100" value="<?php echo $editsitesettings->categorycol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Search View:</td>
                        <td>Row : <input name="searchrow" id="searchrow" maxlength="100" value="<?php echo $editsitesettings->searchrow; ?>"> </td>
                        <td colspan="3">Column : <input name="searchcol" id="searchcol" maxlength="100" value="<?php echo $editsitesettings->searchcol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Related Videos:</td>
                        <td>Row : <input name="relatedrow" id="relatedrow" maxlength="100" value="<?php echo $editsitesettings->relatedrow; ?>"> </td>
                        <td colspan="3">Column : <input name="relatedcol" id="relatedcol" maxlength="100" value="<?php echo $editsitesettings->relatedcol; ?>"> </td>
                    </tr>

                    <tr>
                        <td>My Videos:</td>
                        <td>Row : <input name="myvideorow" id="myvideorow" maxlength="100" value="<?php echo $editsitesettings->myvideorow; ?>"> </td>
                        <td colspan="3">Column : <input name="myvideocol" id="myvideocol" maxlength="100" value="<?php echo $editsitesettings->myvideocol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Member Page View:</td>
                        <td>Row : <input name="memberpagerow" id="memberpagerow" maxlength="100" value="<?php echo $editsitesettings->memberpagerow; ?>"> </td>
                        <td colspan="3">Column : <input name="memberpagecol" id="memberpagecol" maxlength="100" value="<?php echo $editsitesettings->memberpagecol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Side Popular Videos:</td>
                        <td>Row  : <input name="sidepopularvideorow" id="sidepopularvideorow" maxlength="100" value="<?php echo $editsitesettings->sidepopularvideorow; ?>"> </td>
                        <td  colspan="3">Column : <input name="sidepopularvideocol" id="sidepopularvideocol" maxlength="100" value="<?php echo $editsitesettings->sidepopularvideocol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Side Featured Videos:</td>
                        <td>Row  : <input name="sidefeaturedvideorow" id="sidefeaturedvideorow" maxlength="100" value="<?php echo $editsitesettings->sidefeaturedvideorow; ?>"> </td>
                        <td colspan="3">Column : <input name="sidefeaturedvideocol" id="sidefeaturedvideocol" maxlength="100" value="<?php echo $editsitesettings->sidefeaturedvideocol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Side Related Videos:</td>
                        <td>Row  : <input name="siderelatedvideorow" id="siderelatedvideorow" maxlength="100" value="<?php echo $editsitesettings->siderelatedvideorow; ?>"> </td>
                        <td colspan="3">Column : <input name="siderelatedvideocol" id="siderelatedvideocol" maxlength="100" value="<?php echo $editsitesettings->siderelatedvideocol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Side Recent Videos:</td>
                        <td>Row  : <input name="siderecentvideorow" id="siderecentvideorow" maxlength="100" value="<?php echo $editsitesettings->siderecentvideorow; ?>"> </td>
                        <td colspan="3">Column : <input name="siderecentvideocol" id="siderecentvideocol" maxlength="100" value="<?php echo $editsitesettings->siderecentvideocol; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Home Page Popular Videos:</td>
                        <td>
                            <input type="radio" style="float:none;" name="homepopularvideo" <?php if ($editsitesettings->homepopularvideo == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                            <input type="radio" style="float:none;" name="homepopularvideo" <?php if ($editsitesettings->homepopularvideo == 0) { echo 'checked="checked" '; } ?>value="0" />Disable
                        </td>
                        <td>Row : <input name="homepopularvideorow" id="homepopularvideorow" maxlength="100" value="<?php echo $editsitesettings->homepopularvideorow; ?>"> </td>
                         <td>Column : <input name="homepopularvideocol" id="homepopularvideocol" maxlength="100" value="<?php echo $editsitesettings->homepopularvideocol; ?>"> </td>
                         <td>Order :
                             <select name="homepopularvideoorder">
                                 <option value="1" <?php if ($editsitesettings->homepopularvideoorder == 1) echo "selected=selected"; ?>>1</option>
                                 <option value="2" <?php if ($editsitesettings->homepopularvideoorder == 2) echo "selected=selected"; ?>>2</option>
                                 <option value="3" <?php if ($editsitesettings->homepopularvideoorder == 3) echo "selected=selected"; ?>>3</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Home Page Featured Videos:</td>
                        <td>
                            <input type="radio" style="float:none;"name="homefeaturedvideo" <?php if ($editsitesettings->homefeaturedvideo == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                            <input type="radio" style="float:none;" name="homefeaturedvideo" <?php if ($editsitesettings->homefeaturedvideo == 0) { echo 'checked="checked" '; } ?>value="0" />Disable
                         </td>
                         <td>Row : <input name="homefeaturedvideorow" id="homefeaturedvideorow" maxlength="100" value="<?php echo $editsitesettings->homefeaturedvideorow; ?>"> </td>
                         <td>Column : <input name="homefeaturedvideocol" id="homefeaturedvideocol" maxlength="100" value="<?php echo $editsitesettings->homefeaturedvideocol; ?>"> </td>
                         <td>Order :
                             <select name="homefeaturedvideoorder">
                                    <option value="1" <?php if ($editsitesettings->homefeaturedvideoorder == 1) echo "selected=selected"; ?>>1</option>
                                    <option value="2" <?php if ($editsitesettings->homefeaturedvideoorder == 2) echo "selected=selected"; ?>>2</option>
                                    <option value="3" <?php if ($editsitesettings->homefeaturedvideoorder == 3) echo "selected=selected"; ?>>3</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Home Page Recent Videos:</td>
                        <td>
                            <input type="radio" style="float:none;" name="homerecentvideo" <?php if ($editsitesettings->homerecentvideo == 1) { echo 'checked="checked" '; } ?> value="1" />Enable
                            <input type="radio" style="float:none;" name="homerecentvideo" <?php if ($editsitesettings->homerecentvideo == 0) { echo 'checked="checked" '; } ?>value="0" />Disable
                        </td>
                             <td>Row : <input name="homerecentvideorow" id="homerecentvideorow" maxlength="100" value="<?php echo $editsitesettings->homerecentvideorow; ?>"> </td>
                             <td>Column : <input name="homerecentvideocol" id="homerecentvideocol" maxlength="100" value="<?php echo $editsitesettings->homerecentvideocol; ?>"> </td>
                        <td>Order :
                            <select name="homerecentvideoorder">
                                <option value="1" <?php if ($editsitesettings->homerecentvideoorder == 1) echo "selected=selected"; ?>>1</option>
                                <option value="2" <?php if ($editsitesettings->homerecentvideoorder == 2) echo "selected=selected"; ?>>2</option>
                                <option value="3" <?php if ($editsitesettings->homerecentvideoorder == 3) echo "selected=selected"; ?>>3</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Video Upload Option to Members:</td>
                        <td> <input type="radio" style="float:none;" name="allowupload"  id="allowupload"  <?php if ($editsitesettings->allowupload == '1' || $editsitesettings->allowupload == '') { echo 'checked="checked" '; } ?>  value="1" />Yes </td>
                        <td colspan="3"> <input type="radio" style="float:none;" name="allowupload"  id="allowupload" <?php if ($editsitesettings->allowupload == '0') { echo 'checked="checked" '; } ?>  value="0" />No </td>
                    </tr>
                    <tr>
                        <td>Members Login/Register:</td>
                        <td> <input type="radio" style="float:none;" name="user_login"  id="allowupload"  <?php if ($editsitesettings->user_login == '1') { echo 'checked="checked" '; } ?>  value="1" />Yes </td>
                        <td colspan="3"> <input type="radio" style="float:none;" name="user_login"  id="allowupload" <?php if ($editsitesettings->user_login == '0') { echo 'checked="checked" '; } ?>  value="0" />No </td>
                    </tr>
                    <tr>
                         <td>Display Ratings </td>
                         <td> <input type="radio" style="float:none;" name="ratingscontrol"  id="ratingscontrol"  <?php if ($editsitesettings->ratingscontrol == '1') { echo 'checked="checked" '; } ?>  value="1" />Yes </td>
                         <td colspan="3"> <input type="radio" style="float:none;" name="ratingscontrol"  id="ratingscontrol" <?php if ($editsitesettings->ratingscontrol == '0') { echo 'checked="checked" '; } ?>  value="0" />No </td>
                     </tr>
                     <tr>
                         <td>Display Views Count </td>
                         <td> <input type="radio" style="float:none;" name="viewedconrtol"  id="viewedconrtol"  <?php if ($editsitesettings->viewedconrtol == '1') { echo 'checked="checked" '; } ?>  value="1" />Yes </td>
                         <td colspan="3"> <input type="radio" style="float:none;" name="viewedconrtol"  id="viewedconrtol" <?php if ($editsitesettings->viewedconrtol == '0') { echo 'checked="checked" '; } ?>  value="0" />No </td>
                     </tr>
                     <tr>
                         <td>Display Tags</td>
                         <td> <input type="radio" style="float:none;" name="tagconrtol"  id="tagconrtol"  <?php if ($editsitesettings->tagconrtol == '1') { echo 'checked="checked" '; } ?>  value="1" />Yes </td>
                         <td colspan="3"> <input type="radio" style="float:none;" name="tagconrtol"  id="tagconrtol" <?php if ($editsitesettings->tagconrtol == '0') { echo 'checked="checked" '; } ?>  value="0" />No  </td>
                     </tr>
                     <tr>
                         <td>Allow member video active</td>
                         <td> <input type="radio" style="float:none;" name="activeconrtol"  id="activeconrtol"  <?php if ($editsitesettings->activeconrtol == '1') { echo 'checked="checked" '; } ?>  value="1" />Yes </td>
                         <td colspan="3"> <input type="radio" style="float:none;" name="activeconrtol"  id="activeconrtol" <?php if ($editsitesettings->activeconrtol == '0') { echo 'checked="checked" '; } ?>  value="0" />No  </td>
                     </tr>
                 </table>
             </fieldset>
         </div>
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
