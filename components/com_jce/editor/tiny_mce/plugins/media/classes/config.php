<?php
/**
 * @version		$Id: config.php 69 2011-02-20 13:51:53Z happy_noodle_boy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class WFMediaPluginConfig
{
	public function getConfig(&$settings)
	{
		$wf 	= WFEditor::getInstance();
		$model 	= JModel::getInstance('editor', 'WFModel');
		
		if ($wf->getParam('media.iframes', 0)) {
			$model->removeKeys($settings['invalid_elements'], array('iframe'));
		}
		
		if ($wf->getParam('media.audio', 1)) {
			$model->removeKeys($settings['invalid_elements'], array('audio', 'source'));
		}
		
		if ($wf->getParam('media.video', 1)) {
			$model->removeKeys($settings['invalid_elements'], array('video', 'source'));
		}
		
		if ($wf->getParam('media.embed', 1)) {
			$model->removeKeys($settings['invalid_elements'], array('embed'));
		}
		
		if ($wf->getParam('media.object', 1)) {
			$model->removeKeys($settings['invalid_elements'], array('object', 'param'));
		}

		$settings['media_strict'] = $wf->getParam('media.strict', 1, 1);
	}
}
?>