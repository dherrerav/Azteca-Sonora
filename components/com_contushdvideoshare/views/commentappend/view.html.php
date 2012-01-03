<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.html.php
 * @location    /components/com_contushdvideosahre/views/commentappend/view.html.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :   GetModel & GetCategory
 */
//No direct Access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewcommentappend extends JView {

    function display() {
        $model = $this->getModel();
        $getcomments = $model->getcomment();
        $this->assignRef('commenttitle', $getcomments[0]);      // Assigning the reference for the results
        $this->assignRef('commenttitle1', $getcomments[1]);     // Assigning the reference for the results
        $this->assignRef('playersettings', $getcomments[2]);    // Assigning the reference for the results
        $commentsview = $model->ratting();
        $this->assignRef('commentview', $commentsview);
        parent::display();
    }

}
?>   
