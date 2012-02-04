<?php
/*
 * "ContusHDVideoShare Component" - Version 2.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$rs_showads = $this->showads;
?>

<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<?php
$basepath = explode('administrator', JURI::base());
$path = $basepath[0] . "administrator/components/com_contushdvideoshare/images/uploads/";
$path1 = $basepath[0] . "components/com_contushdvideoshare/videos/"
?>
    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th width="1%">
                    <input type="checkbox" name="toggle"
                           value="" onClick="checkAll(<?php echo
    count($rs_showads); ?>);" />
                </th>
                <th width="5%">
<?php echo JHTML::_('grid.sort', 'Ads name', 'adsname', @$lists['order_Dir'], @$lists['order']); ?>

                </th>
                <th width="2%">
<?php echo JText::_('Default'); ?>
                </th>
                <th width="5%">
                    Ads video path
                </th>
                <th width="5%">
                    Published
                </th>
                <th width="5%">
<?php echo JHTML::_('grid.sort', 'Id', 'Id', @$lists['order_Dir'], @$lists['order']); ?>
                </th>
                <th width="5%">
                    Ad Visits
                </th>
                <th width="5%">
                    Impression Hits
                </th>
<!--<th width="5%">
Preroll video path
</th> -->
            </tr>
        </thead>
<?php
    $k = 0;
    jimport('joomla.filter.output');
//        $j=$limitstart;
    $n = count($rs_showads);
//$i=0;
    if ($n >= 1) {
        for ($i = 0; $i < $n; $i++) {
            $rsplay = $rs_showads[$i];
            $checked = JHTML::_('grid.id', $i, $rsplay->id);
            $published = JHTML::_('grid.published', $rsplay, $i);
            $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=ads&task=editads&cid[]=' . $rsplay->id);
?>
            <tr class="<?php echo "row$k"; ?>">
                <td align="center">
        <?php echo $i + 1; ?>
                </td>
                <td align="center">
<?php echo $checked; ?>
                </td>

                <td align="center">
                    <a href="<?php echo $link; ?>">
<?php echo $rsplay->adsname; ?>
                </a>
            </td>
            <td align="center">
                    <?php if ($rsplay->home == 1) : ?>
                    <img src="templates/khepri/images/menu/icon-16-default.png" alt="<?php echo JText::_('Default'); ?>" />
<?php else : ?>
                        &nbsp;
                <?php endif; ?>
                        </td>
                        <td align="center">
<?php echo $rsplay->postvideopath; ?>
                        </td>
                        <td align="center">
<?php echo $published; ?>
                        </td>
                        <td align="center">
<?php echo $rsplay->id; ?>
                        </td>
                        <td align="center">
<?php echo $rsplay->clickcounts; ?>
                        </td>
                        <td align="center">
<?php echo $rsplay->impressioncounts; ?>
                        </td>

                    </tr>
<?php
//$i++;
                        }
                    }
?>
                    <tfoot>
                    <td colspan="13"><?php //$rs_showads['pageNav']->getListFooter() ;?></td>
                    </tfoot>

                </table>
            <!--<input type="hidden" name="id" value="<?php ?>"/>-->
<!--                <input type="hidden" name="option" value="<?php echo $option; ?>"/>-->
                <input type="hidden" name="filter_order" value="<?php echo @$lists['order']; ?>" />
                <input type="hidden" name="filter_order_Dir" value="<?php echo @$lists['order_Dir']; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>


