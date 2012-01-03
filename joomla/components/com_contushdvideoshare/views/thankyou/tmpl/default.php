<?php
/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/com_contushdvideosahre/views/thankyou/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Thank You Message showing area..
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');
JHTML::_('stylesheet', JURI::base() . "components/com_hdvideoshare/css/stylesheet.css", array(), true);
?>
<div class="player clearfix">
    <div id="clsdetail">
        <div class="lodinpad">
            <br/><br/><br/><br/><br/> <div align="center" class="thank" >Thank You, Your Registration is Completed successfully
                <br />
                <input type="button"  value="Login" class="button" onclick="window.open('index.php?option=com_users&view=login','_self')" />
            </div>

        </div>
    </div>
</div>