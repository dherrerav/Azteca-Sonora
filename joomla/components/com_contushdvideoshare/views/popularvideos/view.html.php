<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.html.php
 * @location    /components/com_contushdvideosahre/views/popularvideos/view.html.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/**
 * Description :   Get Model & getpopularvideos, getpopularvideorowcol
 */
//No direct Access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewpopularvideos extends JView {

    function display() {
        $model = $this->getModel();
        $popularvideos = $model->getpopularvideos();
        $this->assignRef('popularvideos', $popularvideos);
        $popularvideosrowcol = $model->getpopularvideorowcol();
        $this->assignRef('popularvideosrowcol', $popularvideosrowcol);
        parent::display();
    }

}

?>