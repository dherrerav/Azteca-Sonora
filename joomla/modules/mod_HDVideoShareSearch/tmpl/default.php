<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/modules/mod_HDVideoShareSearch/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare Search
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');
?>

<span class="module_menu <?php echo $class;?> ">
    <div align="center">
        <link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />
        <script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/upload_script.js"></script>
        <script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/membervalidator.js"></script>
        <form name="hsearch" id="hsearch" method="post" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=hdvideosharesearch'); ?>"  enctype="multipart/form-data"  >
            <input type="text" value="" name="searchtxtbox" id="searchtxtbox" class="clstextfield"  onkeypress="validateenterkey(event,'hsearch');" stye="color:#000000; "/>
            <input type="submit" name="search_btn" id="search_btn" class="button" value="<?php echo _HDVS_SEARCH; ?>" />
            <input type="hidden" name="searchval" id="searchval" value="<?php if (isset($_POST['searchtxtbox'])) { echo $_POST['searchtxtbox']; } else { echo $_POST['searchval']; }; ?>" />
        </form>
        <br/>
    </div>
</span>