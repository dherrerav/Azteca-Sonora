<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        email.php
 * @location    /components/com_contushdvideosahre/hdflvplayer/email.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :    email validation page
 */
$to = $_POST['to'];
$from = $_POST['from'];
$url = $_POST['url'];
$subject = "You have received a video!";
$headers = "From: " . "<" . $_POST['from'] . ">\r\n";
$headers .= "Reply-To: " . $_POST['from'] . "\r\n";
$headers .= "Return-path: " . $_POST['from'];
$message = $_POST['note'] . "\n\n";
$message .= "Video URL: " . $url;
if (mail($to, $subject, $message, $headers)) {
    echo "output=sent";
} else {
    echo "output=error";
}
?>