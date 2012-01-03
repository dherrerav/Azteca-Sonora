<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/com_contushdvideosahre/views/email/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : email page
 */

// No Direct access
defined('_JEXEC') or die('Restricted access');
echo $this->detail;
$link = JRoute::_('index.php?option=com_hello&view=hello&task=xml');
echo "<a href=\"" . $link . "\">Task=xml</a>";
?>
