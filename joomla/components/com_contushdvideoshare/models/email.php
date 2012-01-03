<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        email.php
 * @location    /components/com_contushdvideosahre/models/email.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :'validating email'
 */
// No Direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class Modelcontushdvideoshareemail extends JModel {

    function getemail() {


        $to = JRequest::getVar('to', '', 'post', 'string');
        $from = JRequest::getVar('from', '', 'post', 'string');
        $url = JRequest::getVar('url', '', 'post', 'string');
        $subject = "You have received a video!";
        $headers = "From: " . "<" . JRequest::getVar('from', '', 'post', 'string') . ">\r\n";
        $headers1 .= "Reply-To: " . JRequest::getVar('from', '', 'post', 'string') . "\r\n";
        $headers .= "Return-path: " . JRequest::getVar('from', '', 'post', 'string');
        $message = JRequest::getVar('note', '', 'post', 'string') . "\n\n";
        $message .= "Video URL: " . $url;
        if (mail($to, $subject, $message, $headers)) {
            echo "output=sent";
            $headers = "From: " . "<" . JRequest::getVar('to', '', 'post', 'string') . ">\r\n";
            $message = "Thank You ";
            mail($from, $subject, $message, $headers);
        } else {
            echo "output=error";
        }
        exit();
    }

}