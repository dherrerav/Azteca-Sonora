<?php
/**
* @version		$Id: config.php 53 2011-02-09 10:29:43Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
class WFArticlePluginConfig {
	public function getConfig( &$settings ){
		$wf = WFEditor::getInstance();
		
		$settings['article_hide_xtd_btns'] = $wf->getParam('article.hide_xtd_btns', 0, 0);
	}
}
?>