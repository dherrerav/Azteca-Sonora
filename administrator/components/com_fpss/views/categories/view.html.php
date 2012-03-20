<?php
/**
 * @version		$Id: view.html.php 613 2011-08-01 21:22:26Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSViewCategories extends JView {

	function display($tpl = null) {
		JHTML::_('behavior.tooltip');
		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$limit = $mainframe->getUserStateFromRequest("{$option}.{$view}.limit", 'limit', 20, 'int');
		$limitstart = $mainframe->getUserStateFromRequest("{$option}.{$view}.limitstart", 'limitstart', 0, 'int');
		$ordering = $mainframe->getUserStateFromRequest("{$option}.{$view}.ordering", 'filter_order', 'category.id', 'cmd');
		$orderingDir = $mainframe->getUserStateFromRequest("{$option}.{$view}.orderingDir", 'filter_order_Dir', 'DESC', 'word');
		$published = $mainframe->getUserStateFromRequest("{$option}.{$view}.published", 'published', -1, 'int');
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
		$model->setState('search', $search);
		$model->setState('language', $language);
		$categories = $model->getData();
		foreach($categories as $category){
			JFilterOutput::objectHTMLSafe( $category );
		}
		$this->assignRef('rows', $categories);

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
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$languages = JHTML::_('contentlanguage.existing', true, true);
			array_unshift($languages, JHTML::_('select.option', '', JText::_('FPSS_SELECT_LANGUAGE')));			
			$filters['language'] = JHTML::_('select.genericlist', $languages, 'language', '', 'value', 'text', $language);
		}
		$this->assignRef('filters',$filters);
		
		if($ordering == 'category.ordering') {
			$orderingFlag = true;
		}
		else {
			$orderingFlag = false;
		}
		$this->assignRef('orderingFlag',$orderingFlag);
		$title = JText::_('FPSS_CATEGORIES');
		$this->assignRef('title', $title);
		JToolBarHelper::title( $title, 'fpss-logo.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::addNew();
		JToolBarHelper::editList();
		JToolBarHelper::deleteList('FPSS_ARE_YOU_SURE_THAT_YOU_WANT_TO_DELETE_THESE_CATEGORIES_ASSIGNED_SLIDES_TO_THESE_CATEGORIES_WILL_BE_DELETED_TOO_THIS_ACTION_CANNOT_BE_UNDONE');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_fpss', '300','500', 'FPSS_OPTIONS');
		JSubMenuHelper::addEntry ( JText::_('FPSS_SLIDES'), 'index.php?option=com_fpss&view=slides' );
		JSubMenuHelper::addEntry ( JText::_('FPSS_CATEGORIES'), 'index.php?option=com_fpss&view=categories', true );
		JSubMenuHelper::addEntry ( JText::_('FPSS_INFORMATION'), 'index.php?option=com_fpss&view=info' );
		parent::display($tpl);

	}


}
