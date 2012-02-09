<?php

defined('_JEXEC') or die;
jimport('joomla.application.component.view');
class MediaViewVideo extends JView {
	function display($tpl = null) {
		$config = JComponentHelper::getParams('com_media');
		$application =& JFactory::getApplication();
		$lang =& JFactory::getLanguage();
		$append = '';
		JHtml::_('behavior.framework', true);
		JHtml::_('script', 'media/popup-videomanager.js', true, true);
		JHtml::_('stylesheet', 'media/popup-imagemanager.css', array(), true);
		if ($lang->isRTL()) {
			JHtml::_('stylesheet', 'media/popup-imagemanager_rtl.css', array(), true);
		}
		if ($config->get('enable_flash', 1)) {
			$fileTypes = 'mp4,flv';
			$types = explode(',', $fileTypes);
			$displayTypes = '';
			$filterTypes = '';
			$firstType = true;
			foreach ($types as $type) {
				if (!$firstType) {
					$displayTypes .= ', ';
					$filterTypes .= '; ';
				} else {
					$firstType = false;
				}
				$displayTypes .= '*.' . $type;
				$filterTypes .= '*.' . $type;
			}
			$typeString = '{ \''.JText::_('COM_MEDIA_FILES','true').' ('.$displayTypes.')\': \''.$filterTypes.'\' }';

			JHtml::_('behavior.uploader', 'upload-flash',
				array(
					'onBeforeStart' => 'function(){ Uploader.setOptions({url: document.id(\'uploadForm\').action + \'&folder=\' + document.id(\'imageForm\').folderlist.value}); }',
					'onComplete' 	=> 'function(){ window.frames[\'imageframe\'].location.href = window.frames[\'imageframe\'].location.href; }',
					'targetURL' 	=> '\\document.id(\'uploadForm\').action',
					'typeFilter' 	=> $typeString,
					'fileSizeMax'	=> (int) ($config->get('upload_maxsize',0) * 1024 * 1024),
				)
			);
		}
		/*
		 * Display form for FTP credentials?
		 * Don't set them here, as there are other functions called before this one if there is any file write operation
		 */
		jimport('joomla.client.helper');
		$ftp = !JClientHelper::hasCredentials('ftp');

		$this->assignRef('session',	JFactory::getSession());
		$this->assignRef('config',		$config);
		$this->assignRef('state',		$this->get('state'));
		$this->assignRef('folderList',	$this->get('folderList'));
		$this->assign('require_ftp', $ftp);

		parent::display($tpl);
	}
}