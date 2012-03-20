<?php
/**
 * @version		$Id: view.html.php 657 2011-08-23 12:37:33Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSViewSlides extends JView {

	function display($tpl = null) {
		JHTML::_('behavior.tooltip');
		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$limit = $mainframe->getUserStateFromRequest("{$option}.{$view}.limit", 'limit', 20, 'int');
		$limitstart = $mainframe->getUserStateFromRequest("{$option}.{$view}.limitstart", 'limitstart', 0, 'int');
		$ordering = $mainframe->getUserStateFromRequest("{$option}.{$view}.ordering", 'filter_order', 'slide.id', 'cmd');
		$orderingDir = $mainframe->getUserStateFromRequest("{$option}.{$view}.orderingDir", 'filter_order_Dir', 'DESC', 'word');
		$published = $mainframe->getUserStateFromRequest("{$option}.{$view}.published", 'published', -1, 'int');
		$featured = $mainframe->getUserStateFromRequest("{$option}.{$view}.featured", 'featured', -1, 'int');
		$catid = $mainframe->getUserStateFromRequest("{$option}.{$view}.catid", 'catid', 0, 'int');
		$author = $mainframe->getUserStateFromRequest("{$option}.{$view}.author", 'author', 0, 'int');
		$language = $mainframe->getUserStateFromRequest("{$option}.{$view}.language", 'language', '', 'string');
		$search = $mainframe->getUserStateFromRequest("{$option}.{$view}.search", 'search', '', 'string');
		$search = JString::strtolower($search);

		$params = & JComponentHelper::getParams('com_fpss');
		$this->assignRef('params', $params);

		$model = & $this->getModel();
		$model->setState('limit', $limit);
		$model->setState('limitstart', $limitstart);
		$model->setState('ordering', $ordering);
		$model->setState('orderingDir', $orderingDir);
		$model->setState('published', $published);
		$model->setState('catid', $catid);
		$model->setState('access', -1);
		$model->setState('featured', $featured);
		$model->setState('author', $author);
		$model->setState('categoryPublished', -1);
		$model->setState('language', $language);
		$model->setState('search', $search);

		$slides = $model->getData();
		$slideModel = &JModel::getInstance('slide', 'FPSSModel');
		foreach ($slides as $slide){
			$slideModel->getSlideImages($slide);
			JFilterOutput::objectHTMLSafe($slide);
			if(version_compare( JVERSION, '1.6.0', 'ge' )) {
				$dateFormat = JText::_('FPSS_J16_DATE_FORMAT');
			}
			else {
				$dateFormat = JText::_('FPSS_DATE_FORMAT');
			}
			$slide->created = JHTML::_('date', $slide->created , $dateFormat);
			if((int)$slide->modified){
				$slide->modified = JHTML::_('date', $slide->modified , $dateFormat);
			}
			else {
				$slide->modified = JText::_('FPSS_NEVER');
			}
			
			switch($slide->referenceType) {
				default:
				case 'custom':
					$slide->reference = JText::_('FPSS_COM_SOURCE_CUSTOM_URL');
					break;
				case 'com_content':
					$slide->reference = JText::_('FPSS_COM_SOURCE_JOOMLA_ARTICLE');
					break;
				case 'com_menus':
					$slide->reference = JText::_('FPSS_COM_SOURCE_JOOMLA_MENU_ITEM');
					break;
				case 'com_k2':
					$slide->reference = JText::_('FPSS_COM_SOURCE_K2_ITEM');
					break;
				case 'com_virtuemart':
					$slide->reference = JText::_('FPSS_COM_SOURCE_VIRTUEMART_PRODUCT');
					break;
				case 'com_redshop':
					$slide->reference = JText::_('FPSS_COM_SOURCE_REDSHOP_PRODUCT');
					break;				
				case 'com_tienda':
					$slide->reference = JText::_('FPSS_COM_SOURCE_TIENDA_PRODUCT');
					break;				
			}
			
		}
		$this->assignRef('rows', $slides);

		$total=$model->getTotal();
		$pagination = new JPagination($total, $limitstart, $limit);
		$this->assignRef('pagination',$pagination);

		$filters = array();
		$filters['search'] = $search;
		$filters['ordering'] = $ordering;
		$filters['orderingDir'] = $orderingDir;
		$options = array();
		$options[] = JHTML::_('select.option', -1, JText::_('FPSS_SELECT_PUBLISHING_STATE'));
		$options[] = JHTML::_('select.option', 1, JText::_('FPSS_PUBLISHED'));
		$options[] = JHTML::_('select.option', 0, JText::_('FPSS_UNPUBLISHED'));
		$filters['published'] = JHTML::_('select.genericlist', $options, 'published', '', 'value', 'text', $published);
		$options = array();
		$options[] = JHTML::_('select.option', -1, JText::_('FPSS_SELECT_FEATURED_STATE'));
		$options[] = JHTML::_('select.option', 1, JText::_('FPSS_FEATURED'));
		$options[] = JHTML::_('select.option', 0, JText::_('FPSS_NOT_FEATURED'));
		$filters['featured'] = JHTML::_('select.genericlist', $options, 'featured', '', 'value', 'text', $featured);
		$this->loadHelper('html');
		$filters['category'] = FPSSHelperHTML::getCategoryFilter('catid', $catid);
		$filters['author'] = FPSSHelperHTML::getAuthorFilter('author', $author);
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$languages = JHTML::_('contentlanguage.existing', true, true);
			array_unshift($languages, JHTML::_('select.option', '', JText::_('FPSS_SELECT_LANGUAGE')));
			$filters['language'] = JHTML::_('select.genericlist', $languages, 'language', '', 'value', 'text', $language);
		}
		$this->assignRef('filters',$filters);

		if($ordering == 'slide.ordering' && $catid) {
			$orderingFlag = true;
		}
		else {
			$orderingFlag = false;
		}
		$this->assignRef('orderingFlag', $orderingFlag);

		if($ordering == 'slide.featured_ordering' && $featured == 1) {
			$featuredOrderingFlag = true;
		}
		else {
			$featuredOrderingFlag = false;
		}
		$this->assignRef('featuredOrderingFlag', $featuredOrderingFlag);

		$template = $mainframe->getTemplate();
		$this->assignRef('template', $template);

		$document = & JFactory::getDocument();
		$document->addScript(JURI::base(true).'/components/com_fpss/js/slimbox2.js');
		$title = JText::_('FPSS_SLIDES');
		$this->assignRef('title', $title);
		JToolBarHelper::title($title, 'fpss-logo.png' );
		JToolBarHelper::customX( 'featured', 'default.png', 'default_f2.png', 'FPSS_TOGGLE_FEATURED_STATE' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::addNew();
		JToolBarHelper::editList();
		JToolBarHelper::deleteList('FPSS_ARE_YOU_SURE_THAT_YOU_WANT_TO_DELETE_THESE_SLIDES_THIS_ACTION_CANNOT_BE_UNDONE');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_fpss', '300','500', 'FPSS_OPTIONS');
		JSubMenuHelper::addEntry ( JText::_('FPSS_SLIDES'), 'index.php?option=com_fpss&view=slides', true );
		JSubMenuHelper::addEntry ( JText::_('FPSS_CATEGORIES'), 'index.php?option=com_fpss&view=categories' );
		JSubMenuHelper::addEntry ( JText::_('FPSS_INFORMATION'), 'index.php?option=com_fpss&view=info' );
		parent::display($tpl);

	}

}
