<?php
/**
 * @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
 * */
defined('_JEXEC') or die('Restricted access');
?>
<?php
if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add') {
 ?>

    <form action='index.php?option=com_contushdvideoshare&layout=category' method="POST" name="adminForm" id="adminForm" >
        <fieldset class="adminform">
            <legend>Category</legend>
            <table class="admintable">
                <tr>
                    <td class="key">Parent Category</td>
                    <td>
                        <select  id="parent_id" name="parent_id" >
                            <option id="-1" value="-1">Main</option>
                        <?php
                          
                        foreach ($this->categorylist as $val)
                         {
                            $selected = '';
                             if ($this->categary->parent_id == $val->id)
                             {
                                $selected = 'selected="selected"';
                             }
                            ?>
                            <option id="<?php echo $val->id; ?>" value="<?php echo $val->id; ?>" <?php echo $selected; ?> ><?php echo $val->category; ?></option>
<?php                    } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">Category Name</td>
                <td><input type="text" name="category" id="category" size="32" maxlength="250" value="<?php echo $this->categary->category; ?>" /></td>
            </tr>
            <tr>
                <td class="key">Order</td>
                <td><input type="text" name="ordering" id="ordering" size="10" maxlength="30" value="<?php echo $this->categary->ordering; ?>" /></td>
            </tr>
            <tr>
                <td class="key">Published</td>
                <?php
                            $categoryChecked = 'checked';
                            $categoryListchecked = '';
                            if ($this->categary->published == '1')
                             {
                                $categoryChecked = 'checked';
                                $categoryListchecked = '';
                             }
                             else if ($this->categary->published == '1')
                              {
                                $categoryChecked = '';
                                $categoryListchecked = 'checked';
                             }
                ?>
                <td><input type="radio" name="published" id="published" value="1" <?php echo $categoryChecked; ?> style="float: none;"/>Yes&nbsp;&nbsp;
                    <input type="radio" name="published" id="published" value="0" <?php echo $categoryListchecked; ?> style="float: none;"/>No
                            </td>
                        </tr>

                    </table>
                </fieldset>
                <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>"/>
                <input type="hidden" name="id" value="<?php echo $this->categary->id; ?>"/>
                <input type="hidden" name="task" value=""/>
            </form>
<?php
                    } 
                    else
                     {
                            $category = $this->category;
                            $lists = $this->category['lists'];
?>
                            <form action='index.php?option=com_contushdvideoshare&layout=category' method="POST" name="adminForm">
                                <table class="adminlist">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($category['category']); ?>)" /></th>
                                            <th>Category</th>
                                            <th>
<?php echo JHTML::_('grid.sort', 'Ordering Position', 'ordering', @$lists['order_Dir'], @$lists['order']); ?> </th>
                                            <th>Published</th>
                                            <th width="10">ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
                            $k = 0;
                            $i = 0;
                            foreach ($category['category'] as $row)
                             {
                                $published = JHTML::_('grid.published', $row, $i);
                                $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]=' . $row->id);
                                $checked = JHTML::_('grid.id', $i, $row->id);
?>
                                <tr class="<?php echo "row$k"; ?>">
                                    <td align="center" style="width:50px;"><?php echo $i + 1; ?></td>
                                    <td><?php echo $checked; ?></td>
                                    <td><a href="<?php echo $link; ?>"><?php echo $row->category; ?></a></td>
                                    <td align="center" style="width:20px;"><?php echo $row->ordering; ?></td>
                                    <td align="center" style="width:70px;"><?php echo $published; ?></td>
                                    <td align="center" style="width:90px;"><?php echo $row->id; ?></td>
                                </tr>
<?php
                                $k = 1 - $k;
                                $i++;
                                foreach ($category['categorylist'] as $categoryDetail)
                                    {

                                    if ($row->id == $categoryDetail->parent_id)
                                       {

                                           $published = JHTML::_('grid.published', $categoryDetail, $i);
                                           $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]=' . $categoryDetail->id);
                                           $checked = JHTML::_('grid.id', $i, $categoryDetail->id);
?>
                                            <tr class="<?php echo "row$k"; ?>">
                                            <td align="center" style="width:50px;"><?php echo $i + 1; ?></td>
                                            <td><?php echo $checked; ?></td>
                                            <td><a href="<?php echo $link; ?>"><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;|__' . $categoryDetail->category; ?></a></td>
                                            <td align="center" style="width:20px;"><?php echo $categoryDetail->ordering; ?></td>
                                            <td align="center" style="width:70px;"><?php echo $published; ?></td>
                                            <td align="center" style="width:90px;"><?php echo $categoryDetail->id; ?></td>
                                        </tr>
<?php
                                        $k = 1 - $k;
                                        $i++;
                                    }
                                }
                            }
?>
                            <tr>
                                <td colspan="6">
<?php echo $this->category['pageNav']->getListFooter(); ?>
                                </td></tr>
                        </tbody>
                    </table>
<!--                    <input type="hidden" name="option" value="<?php echo $option; ?>" />-->
            <input type="hidden" name="filter_order" value="<?php echo @$lists['order']; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo @$lists['order_Dir']; ?>" />
            <input type="hidden" name="task" value=""/>
            <input type="hidden" name="boxchecked" value="0"/>
            <input type="hidden" name="hidemainmenu" value="0"/>
            <input type="hidden" name="parent_id" value="-1"/>

        </form>
<?php } ?>
<script language="JavaScript" type="text/javascript">
   <?php if(version_compare(JVERSION,'1.6.0','ge'))
                    { ?>Joomla.submitbutton = function(pressbutton) {<?php } else { ?>
                        function submitbutton(pressbutton) {<?php } ?>
        if (pressbutton == "save")
        {


            if (document.getElementById('category').value == "")
            {
                alert( "<?php echo JText::_('You must provide a category name', true); ?>" )
                return;
            }

            submitform( pressbutton );
            return;
        }
        submitform( pressbutton );
        return;

    }
</script>