<?php
/**
 * @version		$Id: view.html.php 659 2011-08-23 14:33:07Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSViewSlide extends JView {

	function display($tpl = null) {

		$mainframe = &JFactory::getApplication();
		JHTML::_('behavior.keepalive');
		$params = &JComponentHelper::getParams('com_fpss');
		$db = &JFactory::getDBO();
		$document = &JFactory::getDocument();
		$config = JFactory::getConfig();
		JRequest::setVar( 'hidemainmenu', 1 );
		$model = &JModel::getInstance('slide', 'FPSSModel');
		$model->setState('id', JRequest::getInt('id'));
		$slide = $model->getData();
		$model->getSlideImages($slide);
		$slide->reference = '';
		if(!$slide->id){
			$slide->title = JText::_('FPSS_TITLE');
			$slide->tagline = JText::_('FPSS_TAGLINE');
			$slide->published = 1;
			$date = &JFactory::getDate();
			$slide->publish_up = $date->toMySQL();
			$slide->publish_down = $db->getNullDate();
			$slide->referenceType = 'custom';
			$slide->reference = JText::_('FPSS_URL');
		}
		if($slide->referenceType=='custom' && !empty($slide->custom)){
			$slide->reference = $slide->custom;
		}
		
		$lists = array();
		
		// Convert dates to local offset
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$dateFormat = JText::_('FPSS_J16_CALENDAR_DATE_FORMAT');
		}
		else {
			$dateFormat = JText::_('FPSS_CALENDAR_DATE_FORMAT');
		}
		$slide->publish_up = JHTML::_('date', $slide->publish_up, $dateFormat);
		if($slide->publish_down == $db->getNullDate()) {
			$slide->publish_down = '';
		}
		else {
			$slide->publish_down = JHTML::_('date', $slide->publish_down, $dateFormat);
		}
		
		// Set up calendar regional settings
		$document->addScriptDeclaration("
			\$FPSS.datepicker.setDefaults( {
				closeText: 'Done',
				prevText: 'Prev',
				nextText: 'Next',
				currentText: 'Today',
				monthNames: ['January','February','March','April','May','June',
				'July','August','September','October','November','December'],
				monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
				'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
				dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
				dayNamesMin: ['Su','Mo','Tu','We','Th','Fr','Sa'],
				weekHeader: 'Wk',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''});
		");
		
		// Joomla! 1.6 language
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$languages = JHTML::_('contentlanguage.existing', true, true);
			$lists['language'] = JHTML::_('select.genericlist', $languages, 'language', '', 'value', 'text', $slide->language);
		}
		
		JFilterOutput::objectHTMLSafe( $slide, ENT_QUOTES, array('text', 'params'));
		$this->assignRef('row',$slide);

		$lists['published'] = JHTML::_('select.booleanlist', 'published', '', $slide->published);
		$lists['featured'] = JHTML::_('select.booleanlist', 'featured', '', $slide->featured);

		$model = &JModel::getInstance('categories', 'FPSSModel');
		$model->setState('published', -1);
		$model->setState('ordering', 'category.name');
		$model->setState('orderingDir', 'ASC');
		$categories = $model->getData();
        if(empty($categories)){
            $mainframe->redirect('index.php?option=com_fpss&view=category', JText::_('FPSS_YOU_HAVE_TO_CREATE_A_CATEGORY_FIRST'), 'notice');
        }
		$lists['category'] = JHTML::_('select.genericlist', $categories, 'catid', '', 'id', 'name', $slide->catid);
		jimport('joomla.html.parameter');
		$activeCategoryParameters = new JParameter($categories[0]->params);
		$js = 'var categoriesDimensions = new Array();';
		foreach($categories as $key => $category) {
			$categoryParameters = new JParameter($category->params);
			$js .= 'categoriesDimensions['.$key.'] = new Array('.$categoryParameters->get('imageWidth', 400).', '.$categoryParameters->get('thumbWidth', 100).', '.$categoryParameters->get('previewWidth', 600).');';
			if($category->id == $slide->catid) {
				$activeCategoryParameters = $categoryParameters;
			}
		}
		$document->addScriptDeclaration($js);
		$lists['mainImageWidth'] = $activeCategoryParameters->get('imageWidth', 400);
		$lists['thumbImageWidth'] = $activeCategoryParameters->get('thumbWidth', 100);
		$lists['previewImageWidth'] = $activeCategoryParameters->get('previewWidth', 600);

		$lists['access'] = JHTML::_('list.accesslevel', $slide);
		$lists['access'] = JString::str_ireplace('size="3"', '', $lists['access']);
		
		if($params->get('wysiwyg')){
			if(JPluginHelper::isEnabled('editors', 'tinymce')){
				$wysiwyg = & JFactory::getEditor('tinymce');
				$lists['wysiwyg'] = $wysiwyg->display('text', $slide->text, '100%', '300', '40', '5', array('pagebreak', 'readmore', 'image'));
				$js = 'var wysiwyg = true;';
			}
			else {
				$mainframe->enqueueMessage(JText::_('FPSS_WYSIWYG_HAS_BEEN_DISABLED_BECAUSE_THE_TINYMCE_EDITOR_PLUGIN_IS_DISABLED_PLEASE_ENABLE_THE_TINYMCE_EDITOR_PLUGIN_TO_USE_THIS_FEATURE'), 'notice');
				$params->set('wysiwyg', 0);
				$js = 'var wysiwyg = false;';
			}
		}
		else {
			$js = 'var wysiwyg = false;';
		}
		$js.= ' var sizeNote = "'.JText::_('FPSS_NOTE').': '.JText::_('FPSS_THE_IMAGE_HAS_BEEN_SCALED_DOWN_TO_FIT_YOUR_BROWSER_SCREEN_ACTUAL_IMAGE_SIZE').' '.'";';
		$js.= ' var linkNote = "'.JText::_('FPSS_NOTE').': '.JText::_('FPSS_THIS_SLIDE_LINKS_TO_A_THIRD_PARTY_EXTENSION').':'.'";';
		$document->addScriptDeclaration($js);


		
		if($slide->id){
		    $lists['created'] = JHTML::_('date', $slide->created, JText::_('DATE_FORMAT_LC2'));
		}
		else {
		    $lists['created'] = JText::_('FPSS_NEW_SLIDE');
		}
		
		if($slide->modified==$db->getNullDate() || !$slide->id){
		    $lists['modified'] = JText::_('FPSS_NEVER');
		}
		else {
		    $lists['modified'] = JHTML::_('date', $slide->modified, JText::_('DATE_FORMAT_LC2'));
		}
		
		$author = &JFactory::getUser($slide->created_by);
		$lists['created_by'] = $author->name;
		if($slide->modified_by){
		    $moderator = &JFactory::getUser($slide->modified_by);
		    $lists['modified_by'] = $moderator->name;
		}
		else {
		    $lists['modified_by'] = JText::_('FPSS_NONE');
		}
		$this->assignRef('lists', $lists);

		if(version_compare( JVERSION, '1.6.0', 'ge' )){
			jimport('joomla.form.form');
			$form = JForm::getInstance('fpssSlideForm', JPATH_COMPONENT.DS.'models'.DS.'slide.xml');
			$values = array('params'=>json_decode($slide->params));
			$form->bind($values);
			$slide->useOriginal = isset($values['params']->useOriginal)? $values['params']->useOriginal : '0';
		}
		else {
			$form = new JParameter('', JPATH_COMPONENT.DS.'models'.DS.'slide.xml');
			$form->loadINI($slide->params);
			$slide->useOriginal = $form->get('useOriginal');
		}
		$this->assignRef('form', $form);
		
		$this->loadHelper('extension');

		if(version_compare( JVERSION, '1.6.0', 'ge' )){
			$articlesModalLink = "index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=j16SelectArticle";
		}
		else {
			$articlesModalLink = "index.php?option=com_content&amp;task=element&amp;tmpl=component";
		}
		$this->assignRef('articlesModalLink', $articlesModalLink);

		JHTML::_('behavior.modal');
		$this->assignRef('params', $params);
		$title = ($slide->id)? JText::_('FPSS_EDIT_SLIDE'):JText::_('FPSS_ADD_SLIDE');
		$this->assignRef('title', $title);
        JToolBarHelper::title($title, 'fpss-logo.png');		
        JToolBarHelper::save();
		JToolBarHelper::save('saveAndNew', 'FPSS_SAVE_AND_NEW');
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
		parent::display($tpl);

	}


}
