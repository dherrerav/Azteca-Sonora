<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/modules/mod_HDVideoShareCategories/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare categories
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');
?>


<span class="module_menu <?php echo $class;?> ">

    <ul class="menu">
        <?php
        $db = & JFactory::getDBO();
        if (count($result) > 0) {
            foreach ($result as $row) {

                $oriname = $row->category;      //category name changed here for seo url purpose
                $newrname = explode(' ', $oriname);
                $link = implode('-', $newrname);
                $link1 = explode('&', $link);
                $category = implode('and', $link1);

                $query1 = "select * from #__hdflv_category where parent_id in ('" . $row->id . "') and published=1";
                $db->setQuery($query1);
                $result1 = $db->loadObjectList();
        ?>
                <li class="item27">
                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=" . $row->id); ?>"> <span><?php echo $row->category; ?></span></a>
            <?php
                if (count($result1) > 0) {
                    echo "<ul> ";
                    foreach ($result1 as $rows) {

                        $oriname = $rows->category;      //category name changed here for seo url purpose
                        $newrname = explode(' ', $oriname);
                        $link = implode('-', $newrname);
                        $link1 = explode('&', $link);
                        $category = implode('and', $link1);
            ?>
            <?php echo" <li class=''>"; ?> <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=" . $rows->id); ?>"> <span><?php echo $rows->category; ?></span></a><?php echo '</li>'; ?>
            <?php
                    }
                    echo "</ul>";
                }
            ?>
            </li>
        <?php
            }
        } else {
            echo "No Category";
        }
        ?>

    </ul>
</span>









