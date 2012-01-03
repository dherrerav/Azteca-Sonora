<?php
/**
* $Id: config.php 83 2011-02-21 10:49:26Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
class WFSpellcheckerPluginConfig {
	public function getConfig( &$settings ){

		$wf = WFEditor::getInstance();
		
		$settings['spellchecker_languages'] = '+' . $wf->getParam('spellchecker.languages', 'English=en', '' );
		$settings['spellchecker_engine'] 	= $wf->getParam('spellchecker.engine', 'googlespell', 'googlespell' );
		$settings['spellchecker_rpc_url'] 	= JURI::base(true).'/index.php?option=com_jce&view=editor&layout=plugin&plugin=spellchecker&cid=' . $settings['component_id'];
	}
}
?>