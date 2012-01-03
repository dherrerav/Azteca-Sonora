<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        showadslayout.php
 * @location    /components/com_contushdvideosahre/views/showads/tmpl/showadslayout.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/*
 * Description : showing added new ads, updated ads in admin panel
 *               columns : Adsname, Default, Ads video path, Published, ID, Click Hits, Impression Hits
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$rs_showads = $this->showads;
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
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<?php
$basepath = explode('administrator', JURI::base());
$path = $basepath[0] . "administrator/components/com_contushdvideoshare/images/uploads/";
$path1 = $basepath[0] . "components/com_contushdvideoshare/videos/"
?>
    <tr>
        <td align="left" width="100%">
            Filter:
            <input type="text" name="search" id="search" value="<?php if (isset($videolist1['lists']['search']))
        echo $videolist1['lists']['search']; ?>"  onchange="document.adminForm.submit();" />
            <button onClick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
            <button onClick="document.getElementById('search').value='';"><?php echo JText::_('Reset'); ?></button>
        </td>
    </tr>
    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th width="1%"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rs_showads['rs_showads']); ?>);" /> </th>
                <th width="5%"> <?php echo JHTML::_('grid.sort', 'adsname', 'adsname', @$rs_showads['lists']['order_Dir'], @$rs_showads['lists']['order']); ?> </th>
                <th width="5%"> Ads video path </th>
                <th width="5%"> Published </th>
                <th width="5%"> <?php echo JHTML::_('grid.sort', 'Id', 'Id', @$rs_showads['lists']['order_Dir'], @$rs_showads['lists']['order']); ?> </th>
                <th width="5%"> Click Hits </th>
                <th width="5%"> Impression Hits </th>
            </tr>
        </thead>
        <?php
            $k = 0;
            jimport('joomla.filter.output');
            $n = count($rs_showads['rs_showads']);
            if ($n >= 1) {
                for ($i = 0; $i < $n; $i++) {
                $rsplay = $rs_showads['rs_showads'][$i];
                $checked = JHTML::_('grid.id', $i, $rsplay->id);
                $published = JHTML::_('grid.published', $rsplay, $i);
                $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=ads&task=editads&cid[]=' . $rsplay->id);
        ?>
            <tr class="<?php echo "row$k"; ?>">
                <td align="center"> <?php echo $i + 1; ?> </td>
                <td align="center"> <?php echo $checked; ?> </td>
                <td align="center"> <a href="<?php echo $link; ?>"> <?php echo $rsplay->adsname; ?> </a> </td>
                <td align="center"> <?php if ($rsplay->typeofadd == 'prepost') echo $rsplay->postvideopath; else ?> &nbsp;  </td>
                <td align="center"> <?php echo $published; ?> </td>
                <td align="center"> <?php echo $rsplay->id; ?> </td>
                <td align="center"> <?php echo $rsplay->clickcounts; ?> </td>
                <td align="center"> <?php echo $rsplay->impressioncounts; ?> </td>
            </tr>
        <?php
                }
             }
        ?>
             <tr>
                   <td colspan="16"><?php echo $rs_showads['pageNav']->getListFooter(); ?></td>
            </tr>
        </table>
    <input type="hidden" name="filter_order" value="<?php echo $rs_showads['lists']['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $rs_showads['lists']['order_Dir']; ?>" />
    <input type="hidden" name="filter_adsname" value="<?php echo $rs_showads['lists']['filter_adsname']; ?>" />
    <input type="hidden" name="task" value="ads" />
    <input type="hidden" name="boxchecked" value="0">
    <?php echo JHTML::_('form.token'); ?>
</form>