<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.html.php
 * @location    /components/com_contushdvideosahre/views/player/view.html.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   Get Model & Getads
 */

//No direct Access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewplayer extends JView {

    function display() {
        $model = & $this->getModel();
        $detail = $model->showhdplayer();
        $this->assignRef('detail', $detail);
        $commentsview = $model->ratting();
        $this->assignRef('commentview', $commentsview);
        $comments = $model->displaycomments(); // calling the function in models comment.php
        $this->assignRef('commenttitle', $comments[0]); // Assigning the reference for the results
        $this->assignRef('commenttitle1', $comments[1]); // Assigning the reference for the results
        $homepagebottom = $model->gethomepagebottom(); //calling the function in models homepagebottom.php
        $this->assignRef('rs_playlist1', $homepagebottom); // assigning the reference for the results
        $homepagebottomsettings = $model->gethomepagebottomsettings(); //calling the function in models homepagebottom.php
        $this->assignRef('homepagebottomsettings', $homepagebottomsettings); // assigning the reference for the results
        parent::display();
    }
}
?>   
