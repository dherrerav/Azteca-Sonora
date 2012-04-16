<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
class UpdateController extends JController{
	function __construct($config = array()){
		parent::__construct($config);
		$this->registerDefaultTask('update');
	}
	function install(){
		$newConfig = new stdClass();
		$newConfig->installcomplete = 1;
		$config = acymailing_config();
		$config->save($newConfig);
		$updateHelper = acymailing_get('helper.update');
		$updateHelper->initList();
		$updateHelper->installTemplates();
		$updateHelper->installNotifications();
		$updateHelper->installMenu();
		$updateHelper->installExtensions();
		$updateHelper->installBounceRules();
		acymailing_setTitle('AcyMailing','acymailing','dashboard');
		$this->_iframe(ACYMAILING_UPDATEURL.'install');
	}
	function update(){
		$config = acymailing_config();
		if(!acymailing_isAllowed($config->get('acl_config_manage','all'))){
			acymailing_display(JText::_('ACY_NOTALLOWED'),'error');
			return false;
		}
		acymailing_setTitle(JText::_('UPDATE_ABOUT'),'acyupdate','update');
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Link', 'back', JText::_('ACY_CLOSE'), acymailing_completeLink('dashboard') );
		return $this->_iframe(ACYMAILING_UPDATEURL.'update');
	}
	function _iframe($url){
		$config = acymailing_config();
		$url .= '&version='.$config->get('version').'&level='.$config->get('level').'&component=acymailing';
?>
				<div id="acymailing_div">
						<iframe allowtransparency="true" scrolling="auto" height="455px" frameborder="0" width="100%" name="acymailing_frame" id="acymailing_frame" src="<?php echo $url; ?>">
						</iframe>
				</div>
<?php
	}
}