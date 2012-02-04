<?php
/*
 * Contushdvideoshare - 2.3
 * Author        : Contus Support - http://www.contussupport.com
 * Creation Date : December 16 2010
 * File Path     : administrator/components/com_contushdvideoshare/views/memberdetail/tmpl/memberdetails.php
 * Created By    : Contus Support
 * Copyright (c) 2010 Contus Support - support@contussupport.com
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php $document = & JFactory::getDocument();
$document->addStyleSheet('components/com_contushdvideoshare/css/cc.css'); ?>
<form action='index.php?option=com_contushdvideoshare&layout=memberdetails' method="post" name="adminForm" enctype="multipart/form-data">
    <table class="adminlist">
        <thead>
            <tr>
                <?php
                $videoListId = JHTML::_('grid.sort', 'ID', 'id', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']);
                $firstName = JHTML::_('grid.sort', 'First Name', 'name', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']);
                ?>
                <th width="2%">#</th>
                <th width="4%">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->memberdetails['memberdetails']); ?>);" />
                </th>
                <th width="4%" style="color:#3366CC">
<?php echo $videoListId; ?>
                </th>
                <th width="20%" style="color:#3366CC">
<?php echo $firstName;  ?>
                </th>
                <th width="20%" style="color:#3366CC">User Name
                </th>
                <th width="20%" style="color:#3366CC">Email
                </th>
                <th width="20%" style="color:#3366CC">Joined Date
                <th width="5%" align="center" style="color:#3366CC">Allow Upload</th>
                <th width="5%" align="center" style="color:#3366CC">Status</th>
            </tr>
        </thead><?php
jimport('joomla.filter.output');
$memberDetailscount = count($this->memberdetails['memberdetails']);
$upload = $this->memberdetails['settingupload'];
$option = 'com_contushdvideoshare';
for ($i = 0; $i < $memberDetailscount; $i++)//display the member details
 {
    $memberDetail = $this->memberdetails['memberdetails'][$i];
    $published = $memberDetail->block;
    if ($published == 0)
     {
        $statusImage = '<img src="components/com_contushdvideoshare/images/tick.png" />';
     }
    else
     {
        $statusImage = '<img src="components/com_contushdvideoshare/images/publish_x.png" />';
     }

    $checked = JHTML::_('grid.id', $i, $memberDetail->id);
    $link = JRoute::_('index.php?option=' . $option . '&task=editmember&cid[]=' . $memberDetail->id);
?>

        <tr class="<?php echo 'row' . ($i % 2); ?>">
            <td align="center">
        <?php echo $i + 1; ?>
            </td>
            <td align="center">
        <?php echo $checked; ?>
            </td>
            <td>
                <?php echo $memberDetail->id; ?>
            </td>
            <td>
                <?php echo $memberDetail->name; ?>
            </td>
            <td>
<?php echo $memberDetail->username; ?>
            </td>
            <td>
<?php echo $memberDetail->email; ?>
            </td>
            <td>
<?php echo JHTML::Date($memberDetail->registerDate); ?>
            </td>
            <td align="center">
<?php
                $allowUpload = $memberDetail->allowupload;

                if ($allowUpload == null)
                    $allowUpload = $upload[0]->allowupload;

                if ($allowUpload == '1')
                {
                    $allowUploadImage = '<img src="components/com_contushdvideoshare/images/tick.png" />';
                }
                else
                {
                    $allowUploadImage = '<img src="components/com_contushdvideoshare/images/publish_x.png" />';
                }
?>
                <?php echo $allowUploadImage; ?>
            </td>
            <td align="center">
                <?php echo $statusImage; ?>
            </td>

        </tr>
                <?php
            }
                ?>
        <tfoot>
        <td colspan="15"><?php echo $this->memberdetails['pageNav']->getListFooter(); ?></td>
        </tfoot>
    </table>
    <input type="hidden" name="id" value="<?php if(isset($memberDetail->id)){echo $memberDetail->id;} ?>" />
            <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $this->memberdetails['lists']['order']; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $this->memberdetails['lists']['order_Dir']; ?>" />
    <input type="hidden" name="submitted" value="true" id="submitted"/>
</form>

