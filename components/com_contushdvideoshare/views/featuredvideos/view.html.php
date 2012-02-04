<?php
/*
* "ContusHDVideoShare Component" - Version 2.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
class contushdvideoshareViewfeaturedvideos extends JView
{
function display()
	{
            $model = $this->getModel();
            $featuredvideos = $model->getfeaturedvideos(); // calling the function in models featuredvideos.php
            $this->assignRef('featuredvideos', $featuredvideos); // assigning the reference for the results
            $featurevideosrowcol = $model->getfeaturevideorowcol();
            $this->assignRef('featurevideosrowcol', $featurevideosrowcol);
            parent::display();
	}
}
?>