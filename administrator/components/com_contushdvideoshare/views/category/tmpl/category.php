<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        category.php
 * @location    /components/com_contushdvideosahre/views/category/tmpl/category.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    Admin Category  layout
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<script language="javascript">
    document.getElementById('toolbar-box').style.marginTop=120+"px";
    Joomla.submitbutton = function(pressbutton) {

        if (pressbutton == "save")
        {
            var catTxt=(document.getElementById('category').value);
            if(catTxt=="")
            {
                alert("Enter the category");
                return;
            }

        }
        submitform( pressbutton );
        return;
    }
</script>

<div  style="position:absolute;top:100px;left:20px;width:97%">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <div style="float:left;width:20%;padding-top:8px;">
            <img src="components/com_contushdvideoshare/assets/customization_contushdvideoshare.png" alt="" />
        </div>
        <div style=" padding: 20px 0pt 0pt 50px; float: left; width: 50%;font-size:12px;font-family:Arial, Helvetica, sans-serif;line-height:18px;color:#333333;">
            Do you know that HDVideo Share not just develops Extensions but also provides professional web design and custom development services. We would be glad to help you to design and customize the extension to your business needs.
        </div>
        <div style="float:right;padding:8px 0 0 50px;;text-decoration:underline;color:#0B55C4;">
            <div>
                <img src="components/com_contushdvideoshare/assets/logo.png" alt="" />
            </div>
            <div>
                <div style="padding: 8px 0pt 0pt 10px;float:left;">
                    <a href="http://www.hdvideoshare.net" target="_blank">Launch hdvideoshare.net</a>
                </div>
                <div style="padding: 8px 0pt 0pt 10px;float:left;">
                    <a href="http://www.hdvideoshare.net/shop/index.php?main_page=contact_us" target="_blank">Contact us</a>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="b">
        <div class="b">
            <div class="b"></div>
        </div>
    </div>
</div>
<?php
if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add') {
?>
    <form action="" method="POST" name="adminForm" id="adminForm" >
        <div class="width-60 fltlft">
            <fieldset class="adminform" id="videodet" <?php echo $var1; ?>>
            <legend>Category</legend>
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
                        <td>Parent Category</td>
                        <td>
                            <select  id="parent_id" name="parent_id" >
                                <option id="-1" value="-1">Main</option>
                                <?php
                                    foreach ($this->categorylist as $val) { ?>
                                        <option id="<?php echo $val->id; ?>" value="<?php echo $val->id; ?>" <?php if ($this->categary->parent_id == $val->id) { echo 'selected="selected"'; } ?> ><?php echo $val->category; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td><input type="text" name="category" id="category" size="32" maxlength="250" value="<?php echo $this->categary->category; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Order</td>
                        <td><input type="text" name="ordering" id="ordering" size="10" maxlength="30" value="<?php echo $this->categary->ordering; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Published</td>
                        <?php $y = "checked"; $n = ""; if ($this->categary->published == "1") { $y = "checked"; $n = ""; } else if ($this->categary->published == "0") { $y = ""; $n = "checked"; } ?>
                        <td>
                            <input type="radio" style="float:none;" name="published" id="published" value="1" <?php echo $y; ?> />Yes&nbsp;&nbsp;
                            <input type="radio" style="float:none;" name="published" id="published" value="0" <?php echo $n; ?> />No
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>
    <input type="hidden" name="id" value="<?php echo $this->categary->id; ?>"/>
    <input type="hidden" name="task" value="category"/>
    <?php echo JHTML::_('form.token'); ?>
    </form>
    <?php
    } else {
    $category = $this->category;
    $lists = $this->category['lists'];
    ?>
        <form action="" method="POST" name="adminForm">
        <table>
            <tr>
                <td align="left" width="100%">
                    Filter:
                    <input type="text" name="search" id="search" value="<?php if (isset($lists['search'])) echo $lists['search']; ?>"  onchange="document.adminForm.submit();" />
                    <button onClick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
                    <button onClick="document.getElementById('search').value='';"><?php echo JText::_('Reset'); ?></button>
                </td>
            </tr>
        </table>
        <table class="adminlist" width="80%">
            <thead>
                <tr>
                    <th>#</th>
                    <th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($category['category']); ?>)" /></th>
                    <th width="40">    <?php echo JHTML::_('grid.sort', 'category', 'category', @$lists['order_Dir'], @$lists['order']); ?> </th>
                    <th> <?php echo JHTML::_('grid.sort', 'ordering', 'ordering', @$lists['order_Dir'], @$lists['order']); ?> </th>
                    <th>Published</th>
                    <th width="10">ID</th>
               </tr>
           </thead>
           <tbody>
                <?php
                    $k = 0;
                    $i = 0;
                    foreach ($category['category'] as $row) {
                    $published = JHTML::_('grid.published', $row, $i);
                    $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]=' . $row->id);
                    $checked = JHTML::_('grid.id', $i, $row->id);
                ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td align="center" style="width:50px; text-align: center;"><?php echo $i + 1; ?></td>
                        <td style="text-align: center;"><?php echo $checked; ?></td>
                        <td><a href="<?php echo $link; ?>"><?php echo $row->category; ?></a></td>
                        <td align="center" style="width:20px; text-align: center;"><?php echo $row->ordering; ?></td>
                        <td align="center" style="width:70px; text-align: center;"><?php echo $published; ?></td>
                        <td align="center" style="width:90px; text-align: center;"><?php echo $row->id; ?></td>
                    </tr>
                <?php
                    $k = 1 - $k;
                    $i++;
                    foreach ($category['categorylist'] as $row1) {
                        if ($row->id == $row1->parent_id) {
                            $published = JHTML::_('grid.published', $row1, $i);
                            $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]=' . $row1->id);
                            $checked = JHTML::_('grid.id', $i, $row1->id);
                ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td align="center" style="width:50px;"><?php echo $i + 1; ?></td>
                        <td align="center"><?php echo $checked; ?></td>
                        <td><a href="<?php echo $link; ?>"><?php echo $row1->category; ?></a></td>
                        <td align="center" style="width:20px;"><?php echo $row1->ordering; ?></td>
                        <td align="center" style="width:70px;"><?php echo $published; ?></td>
                        <td align="center" style="width:90px;"><?php echo $row1->id; ?></td>
                    </tr>
            <?php
            $k = 1 - $k;
            $i++;
                    }
                }
            }
            ?>
                    <tr>
                        <td colspan="6"> <?php echo $this->category['pageNav']->getListFooter(); ?></td>
                    </tr>
           </tbody>
       </table>
       <input type="hidden" name="filter_order" value="<?php echo @$lists['order']; ?>" />
       <input type="hidden" name="filter_order_Dir" value="<?php echo @$lists['order_Dir']; ?>" />
       <input type="hidden" name="task" value=""/>
       <input type="hidden" name="boxchecked" value="0"/>
       <input type="hidden" name="hidemainmenu" value="0"/>
       <input type="hidden" name="parent_id" value="-1"/>
        <?php echo JHTML::_('form.token'); ?>
    </form>
<?php } ?>