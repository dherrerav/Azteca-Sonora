<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.view');
class MediaViewVideoList extends JView {
	function display($tpl = null) {
		JResponse::allowCache(false);
		$app = JFactory::getApplication();

		$lang	= JFactory::getLanguage();

		JHtml::_('stylesheet','media/popup-imagelist.css', array(), true);
		if ($lang->isRTL()) :
			JHtml::_('stylesheet','media/popup-imagelist_rtl.css', array(), true);
		endif;

		$document = JFactory::getDocument();
		$document->addScriptDeclaration("var ImageManager = window.parent.ImageManager;");

		$videos = $this->get('videos');
		$folders = $this->get('folders');
		$state = $this->get('state');

		$this->assign('baseURL', COM_MEDIA_BASEURL);
		$this->assignRef('videos', $videos);
		$this->assignRef('folders', $folders);
		$this->assignRef('state', $state);

		parent::display($tpl);
	}


	function setFolder($index = 0)
	{
		if (isset($this->folders[$index])) {
			$this->_tmp_folder = &$this->folders[$index];
		} else {
			$this->_tmp_folder = new JObject;
		}
	}

	function setVideo($index = 0)
	{
		if (isset($this->videos[$index])) {
			$this->_tmp_vid = &$this->videos[$index];
		} else {
			$this->_tmp_vid = new JObject;
		}
	}
}
