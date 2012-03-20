<?php
/**
 * @version		$Id: view.html.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSViewExtension extends JView {

	function com_menus($tpl = null) {

		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$task = JRequest::getCmd('task');
		$limit = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limit", 'limit', 20, 'int');
		$limitstart = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limitstart", 'limitstart', 0, 'int');
		$ordering = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.ordering", 'filter_order', 'ordering', 'cmd');
		$orderingDir = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.orderingDir", 'filter_order_Dir', 'ASC', 'word');
		$published = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.published", 'published', -1, 'int');
		$menuType = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.menuType", 'menuType', '', 'cmd');
		$search = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.search", 'search', '', 'string');
		$search = JString::strtolower($search);

		$model = & $this->getModel('menus');
		$model->setState('limit', $limit);
		$model->setState('limitstart', $limitstart);
		$model->setState('ordering', $ordering);
		$model->setState('orderingDir', $orderingDir);
		$model->setState('published', $published);
		$model->setState('menuType', $menuType);
		$model->setState('search', $search);
		$data = $model->getData();
		$menuItems = $data->rows;
		$this->assignRef('rows', $menuItems);

		$total = $data->total;
		$pagination = new JPagination($total, $limitstart, $limit);
		$this->assignRef('pagination',$pagination);

		$filters = array();
		$filters['search'] = $search;
		$filters['ordering'] = $ordering;
		$filters['orderingDir'] = $orderingDir;
		$options = array();
		$options[] = JHTML::_('select.option', -1, JText::_('FPSS_ANY'));
		$options[] = JHTML::_('select.option', 1, JText::_('FPSS_PUBLISHED'));
		$options[] = JHTML::_('select.option', 0, JText::_('FPSS_UNPUBLISHED'));
		$filters['published'] = JHTML::_('select.genericlist', $options, 'published', 'onchange="this.form.submit();"', 'value', 'text', $published);
		$menuTypes = $model->getMenuTypes();
		$option = new JObject();
		$option->value = '';
		$option->text = JText::_('FPSS_ANY');
		array_unshift($menuTypes, $option);
		$filters['menuType'] = JHTML::_('select.genericlist', $menuTypes, 'menuType', 'onchange="this.form.submit();"', 'value', 'text', $menuType);
		$this->assignRef('filters',$filters);
		$this->setLayout('menus');
		parent::display($tpl);

	}

	function com_virtuemart($tpl = null) {

		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$task = JRequest::getCmd('task');
		$limit = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limit", 'limit', 20, 'int');
		$limitstart = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limitstart", 'limitstart', 0, 'int');
		$ordering = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.ordering", 'filter_order', 'product_id', 'cmd');
		$orderingDir = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.orderingDir", 'filter_order_Dir', 'DESC', 'word');
		$published = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.published", 'published', '', 'cmd');
		$catid = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.catid", 'catid', 0, 'int');
		$search = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.search", 'search', '', 'string');
		$search = JString::strtolower($search);

		$model = & $this->getModel();
		$model->setState('limit', $limit);
		$model->setState('limitstart', $limitstart);
		$model->setState('ordering', $ordering);
		$model->setState('orderingDir', $orderingDir);
		$model->setState('published', $published);
		$model->setState('catid', $catid);
		$model->setState('search', $search);
		$products = $model->getData();
		$this->assignRef('rows', $products);

		$total=$model->getTotal();
		$pagination = new JPagination($total, $limitstart, $limit);
		$this->assignRef('pagination',$pagination);

		$filters = array();
		$filters['search'] = $search;
		$filters['ordering'] = $ordering;
		$filters['orderingDir'] = $orderingDir;
		$options = array();
		$options[] = JHTML::_('select.option', '', JText::_('FPSS_ANY'));
		$options[] = JHTML::_('select.option', 'Y', JText::_('FPSS_PUBLISHED'));
		$options[] = JHTML::_('select.option', 'N', JText::_('FPSS_UNPUBLISHED'));
		$filters['published'] = JHTML::_('select.genericlist', $options, 'published', 'onchange="this.form.submit();"', 'value', 'text', $published);
		$filters['category'] =  $model->getCategories();
		$this->assignRef('filters',$filters);
		$this->setLayout('virtuemart');
		parent::display($tpl);

	}


	function com_tienda($tpl = null) {
		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$task = JRequest::getCmd('task');
		$limit = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limit", 'limit', 20, 'int');
		$limitstart = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limitstart", 'limitstart', 0, 'int');
		$ordering = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.ordering", 'filter_order', 'product_id', 'cmd');
		$orderingDir = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.orderingDir", 'filter_order_Dir', 'DESC', 'word');
		$published = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.published", 'published', '', 'cmd');
		$catid = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.catid", 'catid', '', 'cmd');
		$search = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.search", 'search', '', 'string');
		$search = JString::strtolower($search);
		$sku = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.sku", 'sku', '', 'string');
		$sku = JString::strtolower($sku);

		JLoader::register('Tienda', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'defines.php');
		JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'models');

		$model = & JModel::getInstance('Products', 'TiendaModel');
		$model->setState('limitstart', $limitstart);
		$model->setState('limit', $limit);
		$model->setState('order', $ordering);
		$model->setState('direction', $orderingDir);
		if($published != "") {
			$model->setState('filter_enabled', $published);
		}
		if($catid) {
			$model->setState('filter_category', $catid);
		}
		if($search) {
			$model->setState('filter_name', $search);
		}
		if($sku) {
			$model->setState('filter_sku', $sku);
		}
		$products = $model->getList();
		Tienda::load('TiendaHelperBase', 'helpers._base');
		$productHelper = &TiendaHelperBase::getInstance('Product');
		$categoryHelper = &TiendaHelperBase::getInstance('Category');
		foreach($products as $product){
			$product->categories = array();
			$categories = $productHelper->getCategories($product->product_id);
			foreach($categories as $category){
				$product->categories[] = $categoryHelper->getPathName($category);
			}
		}
		$this->assignRef('rows', $products);

		$total=$model->getTotal();
		$pagination = new JPagination($total, $limitstart, $limit);
		$this->assignRef('pagination',$pagination);

		$filters = array();
		$filters['search'] = $search;
		$filters['sku'] = $sku;
		$filters['ordering'] = $ordering;
		$filters['orderingDir'] = $orderingDir;
		$options = array();
		$options[] = JHTML::_('select.option', '', JText::_('FPSS_ANY'));
		$options[] = JHTML::_('select.option', 1, JText::_('FPSS_PUBLISHED'));
		$options[] = JHTML::_('select.option', 0, JText::_('FPSS_UNPUBLISHED'));
		Tienda::load( 'TiendaSelect', 'library.select' );
		$filters['published'] = JHTML::_('select.genericlist', $options, 'published', 'onchange="this.form.submit();"', 'value', 'text', $published);
		$filters['category'] =  TiendaSelect::category( $catid, 'catid', 'onchange="this.form.submit();"', 'catid', true );
		$this->assignRef('filters',$filters);
		$this->setLayout('tienda');
		parent::display($tpl);

	}

	function com_users($tpl = null) {
		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$task = JRequest::getCmd('task');
		$limit = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limit", 'limit', 20, 'int');
		$limitstart = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.limitstart", 'limitstart', 0, 'int');
		$ordering = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.ordering", 'filter_order', 'a.id', 'cmd');
		$orderingDir = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.orderingDir", 'filter_order_Dir', 'DESC', 'word');
		$group = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.group", 'group', 0, 'int');
		$search = $mainframe->getUserStateFromRequest("{$option}.{$view}.{$task}.search", 'search', '', 'string');
		$search = JString::strtolower($search);
		$model = & $this->getModel();
		$model->setState('limit', $limit);
		$model->setState('limitstart', $limitstart);
		$model->setState('ordering', $ordering);
		$model->setState('orderingDir', $orderingDir);
		$model->setState('group', $group);
		$model->setState('search', $search);
		$users = $model->getData();
		$this->assignRef('rows', $users);
		$total = $model->getTotal();
		$pagination = new JPagination($total, $limitstart, $limit);
		$this->assignRef('pagination',$pagination);
		$filters = array();
		$filters['search'] = $search;
		$filters['ordering'] = $ordering;
		$filters['orderingDir'] = $orderingDir;
		$userGroups = $model->getUserGroups();
		$options[] = JHTML::_('select.option', '0', JText::_('FPSS_SELECT_GROUP'));
		foreach($userGroups as $userGroup) {
			$options[] = JHTML::_('select.option', $userGroup->value, JText::_($userGroup->text));
		}
		$filters['group'] = JHTML::_('select.genericlist', $options, 'group', '', 'value', 'text', $group);
		$this->assignRef('filters', $filters);
		$this->setLayout('users');
		parent::display($tpl);
	}
}
