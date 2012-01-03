<?php

/**
 * @version     1.3, Creation Date : March-24-2011
 * @name        view.html.php
 * @location    /components/com_contushdvideosahre/views/relatedvideos/view.html.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

/**
 * Description :   Get Model & getrelatedvideos, getrelatedvideorowcol
 */

//No direct Access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class contushdvideoshareViewrelatedvideos extends JView {
    function display() {
        $model = $this->getModel();
        $relatedvideos = $model->getrelatedvideos();
        $this->assignRef('relatedvideos', $relatedvideos);
        $relatedvideosrowcol = $model->getrelatedvideosrowcol();
        $this->assignRef('relatedvideosrowcol', $relatedvideosrowcol);
        parent::display();
    }

}

?>