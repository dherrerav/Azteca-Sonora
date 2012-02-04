<?php
/**
 * @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
 * */
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');

$function	= JRequest::getCmd('function', 'jSelectArticle');
if(version_compare(JVERSION,'1.7.0','ge')) {
	$version='1.7';
} elseif(version_compare(JVERSION,'1.6.0','ge')) {
	$version='1.6';
} else {
	$version='1.5';
}
?>
<?php
if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add') {
 ?>
    <form action=<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=category&layout=categorylist&tmpl=component&function='.$function);?> method="POST" name="adminForm" id="adminForm" >
        <fieldset class="adminform">
            <legend>Category</legend>
            <table class="admintable">
                <tr>
                    <td class="key">Parent Category</td>
            </tr>
            <tr>
                <td class="key">Category</td>
                <td>
					<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $val->id; ?>', '<?php echo $this->escape(addslashes($this->categary->category)); ?>', '<?php echo $this->escape($val->id); ?>');">
						<?php echo $this->escape($this->categary->category); ?></a>
				</td>
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
                            <td><input type="radio" name="published" id="published" value="1" <?php echo $categoryChecked; ?> />Yes&nbsp;&nbsp;<input type="radio" name="published" id="published" value="0" <?php echo $categoryListchecked; ?> />No </td>
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
<?php if($version !='1.5'){ 
	$linkPath =JRoute::_('index.php?option=com_contushdvideoshare&view=category&layout=categorylist&tmpl=component&function='.$function);
}else{
	$linkPath='index.php?option=com_contushdvideoshare&view=category&layout=categorylist&amp;tmpl=component&amp;object=id';
}
 ?>
                            <form action=<?php echo $linkPath;?> method="POST" name="adminForm">
                                <table class="adminlist">
									<thead>
                                        <tr>

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
                                $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=categorylist');
                                $checked = JHTML::_('grid.id', $i, $row->id);
?>
                                <tr class="<?php echo "row$k"; ?>">
                                <td>
                                <?php if($version !='1.5'){?>
                                    
												<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $row->id; ?>', '<?php echo $this->escape(addslashes($row->category)); ?>', '<?php echo $this->escape($row->id); ?>');">
													<?php echo $this->escape($row->category); ?></a>
									
									<?php }else{?>
										<a style="cursor: pointer;" onclick="window.parent.jSelectArticle('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->category); ?>', '<?php echo JRequest::getVar('object'); ?>');">
										<?php echo $row->category; ?></a>
									<?php }?>
									</td>
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
                                           $link = JRoute::_('index.php?option=com_contushdvideoshare&layout=categorylist');
                                           $checked = JHTML::_('grid.id', $i, $categoryDetail->id);
?>
                                            <tr class="<?php echo "row$k"; ?>">
                                            <td>
												<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $categoryDetail->id; ?>', '<?php echo $this->escape(addslashes($categoryDetail->category)); ?>', '<?php echo $this->escape($categoryDetail->id); ?>');">
													<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;|__' . $categoryDetail->category; ?></a>
											</td>
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