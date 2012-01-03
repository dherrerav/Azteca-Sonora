<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        memberdetails.php
 * @location    /components/com_contushdvideosahre/views/memberdetail/tmpl/memberdetails.php
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
$videolist1 = $this->memberdetails;
?>
<?php $document = & JFactory::getDocument();
$document->addStyleSheet('components/com_contushdvideoshare/css/cc.css'); ?>
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

<!-- Page layout started -->

<form action="index.php?option=com_contushdvideoshare&layout=memberdetails" method="post" name="adminForm" enctype="multipart/form-data">
    Filter:
    <input type="text" name="search" id="search" value="<?php if (isset($videolist1['lists']['search']))
    echo $videolist1['lists']['search']; ?>"  onchange="document.adminForm.submit();" />
    <button onClick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
    <button onClick="document.getElementById('search').value='';"><?php echo JText::_('Reset'); ?></button>
    <table class="adminlist">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="2%"> <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->memberdetails['memberdetails']); ?>);" /> </th>
                <th width="2%" style="color:#3366CC">  <?php echo JHTML::_('grid.sort', 'ID', 'id', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th width="10%" style="color:#3366CC"> <?php echo JHTML::_('grid.sort', 'First Name', 'name', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th width="10%" style="color:#3366CC"> <?php echo JHTML::_('grid.sort', 'User Name', 'username', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th width="10%">Email </th>
                <th width="10%" style="color:#3366CC"> <?php echo JHTML::_('grid.sort', 'Joined Date ', 'registerDate', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?> </th>
                <th width="5%" align="center">Upload</th>
                <th width="2%" align="center">Active</th>
            </tr>
        </thead>
                <?php
                    jimport('joomla.filter.output');
                    $j = $this->memberdetails['limitstart'];
                    $n = count($this->memberdetails['memberdetails']);
                    $option = 'com_contushdvideoshare';
                    for ($i = 0; $i < $n; $i++) {
                        $row = $this->memberdetails['memberdetails'][$i];
                        $upload = $this->memberdetails['allowupld'][$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JRoute::_('index.php?option=' . $option . '&task=editmember&cid[]=' . $row->id);
                        if ($upload->allowupload == 1) {
                            $aimg = '<img src="components/com_contushdvideoshare/images/tick.png" />';
                        } else {
                            $aimg = '<img src="components/com_contushdvideoshare/images/publish_x.png" />';
                        }
                        $published = $row->block;
                        if ($published == 0) {
                            $fimg = '<img src="components/com_contushdvideoshare/images/tick.png" />';
                        } else {
                            $fimg = '<img src="components/com_contushdvideoshare/images/publish_x.png" />';
                        }
                    ?>
        <tr class="<?php echo "row" . ($i % 2); ?>">
            <td align="center">  <?php echo $i + 1; ?> </td>
            <td align="center"> <?php echo $checked; ?> </td>
            <td> <?php echo $row->id; ?> </td>
            <td> <?php echo $row->name; ?> </td>
            <td> <?php echo $row->username; ?> </td>
            <td> <?php echo $row->email; ?> </td>
            <td> <?php echo JHTML::Date($row->registerDate); ?> </td>
            <td align="center"> <?php echo $aimg; ?> </td>
            <td align="center"> <?php echo $fimg; ?> </td>
        </tr>
        <?php
            }
        ?>
        <tfoot>
            <td colspan="15"><?php echo $this->memberdetails['pageNav']->getListFooter(); ?></td>
        </tfoot>
    </table>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->memberdetails['lists']['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->memberdetails['lists']['order_Dir']; ?>" />
    <input type="hidden" name="submitted" value="true" id="submitted"/>
</form>

