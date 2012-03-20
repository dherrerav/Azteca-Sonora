<?php
/**
 * @version		$Id: slides.php 653 2011-08-23 11:49:04Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSModelSlides extends JModel {

	function getData() {
		$db = &$this->getDBO();
		$query = "SELECT slide.*, `group`.name AS groupname, category.name AS categoryName, category.params AS categoryParams, author.name AS authorName, moderator.name AS moderatorName
		FROM #__fpss_slides AS slide 
		JOIN #__fpss_categories AS category ON slide.catid = category.id 
		JOIN #__groups AS `group` ON `group`.id = slide.access
		LEFT JOIN #__users AS author ON author.id = slide.created_by 
		LEFT JOIN #__users AS moderator ON moderator.id = slide.modified_by";
		$conditions = array();
		if ($this->getState('published')!=-1) {
			$conditions[]= "slide.published = ".(int)$this->getState('published');
		}
		if ($this->getState('catid')) {
			$catid = $this->getState('catid');
			if(is_array($catid)) {
				JArrayHelper::toInteger($catid);
				$conditions[]= "slide.catid IN (".implode(',', $catid).")";
			}
			else {
				$conditions[]= "slide.catid = ".(int)$catid;
			}
		}
		if ($this->getState('access')!=-1) {
			$access = $this->getState('access');
			if(is_array($access)) {
				JArrayHelper::toInteger($access);
				$conditions[]= "slide.access IN (".implode(',', $access).")";
			}
			else {
				$conditions[]= "slide.access <= ".(int)$access;
			}
		}
		if ($this->getState('author')) {
			$conditions[]= "slide.created_by = ".(int)$this->getState('author');
		}
		if ($this->getState('featured')!=-1) {
			$conditions[]= "slide.featured = ".(int)$this->getState('featured');
		}
		if ($this->getState('publish_up')) {
			$conditions[]= "(slide.publish_up = ".$db->Quote($db->getNullDate())." OR slide.publish_up <= ".$db->Quote($this->getState('publish_up')).")";
		}
		if ($this->getState('publish_down')) {
			$conditions[]= "(slide.publish_down = ".$db->Quote($db->getNullDate())." OR slide.publish_down >= ".$db->Quote($this->getState('publish_down')).")";
		}
		if ($this->getState('language') && version_compare( JVERSION, '1.6.0', 'ge' )) {
			$conditions[]= "slide.language IN (".$db->Quote($this->getState('language')).",".$db->Quote('*').")";
		}
		if ($this->getState('search')) {
			$conditions[]= "LOWER(slide.title) LIKE ".$db->Quote('%'.$db->getEscaped($this->getState('search'), true).'%', false);
		}
		if ($this->getState('categoryPublished')!=-1) {
			$conditions[]= "category.published = ".(int)$this->getState('published');
		}
		if (count($conditions)) {
			$query.= " WHERE ".implode(' AND ', $conditions);
		}
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$query = JString::str_ireplace('#__groups', '#__viewlevels', $query);
			$query = JString::str_ireplace('`group`.name', '`group`.title', $query);
		}
		$query .= " ORDER BY ".$this->getState('ordering')." ".$this->getState('orderingDir');
		$db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
		$rows = $db->loadObjectList();
		return $rows;
	}

	function getTotal() {
		$db = &$this->getDBO();
		$query = "SELECT COUNT(*) FROM #__fpss_slides";
		$conditions = array();
		if ($this->getState('published')!=-1) {
			$conditions[]= "published = ".(int)$this->getState('published');
		}
		if ($this->getState('catid')) {
			$catid = $this->getState('catid');
			if(is_array($catid)) {
				JArrayHelper::toInteger($catid);
				$conditions[]= "catid IN (".implode(',', $catid).")";
			}
			else {
				$conditions[]= "catid = ".(int)$catid;
			}
		}
		if ($this->getState('author')) {
			$conditions[]= "created_by = ".(int)$this->getState('author');
		}
		if ($this->getState('featured')!=-1) {
			$conditions[]= "featured <= ".(int)$this->getState('featured');
		}
		if ($this->getState('language') && version_compare( JVERSION, '1.6.0', 'ge' )) {
			$conditions[]= "language IN (".$db->Quote($this->getState('language')).",".$db->Quote('*').")";
		}
		if ($this->getState('search')) {
			$conditions[]= "LOWER(title) LIKE ".$db->Quote('%'.$db->getEscaped($this->getState('search'), true).'%', false);
		}
		if (count($conditions)) {
			$query.= " WHERE ".implode(' AND ', $conditions);
		}
		$db->setQuery($query);
		$total = $db->loadResult();
		return $total;
	}

	function publish() {
		$row = & JTable::getInstance('slide', 'FPSS');
		$row->publish($this->getState('id'), 1);
	}

	function unpublish() {
		$row = & JTable::getInstance('slide', 'FPSS');
		$row->publish($this->getState('id'), 0);
	}

	function saveorder() {
		$id = $this->getState('id');
		$order = $this->getState('order');
		$total = count($id);
		JArrayHelper::toInteger($order, array(0));
		$row = &JTable::getInstance('slide', 'FPSS');
		for ($i = 0; $i < $total; $i++) {
			$row->load((int) $id[$i]);
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				$row->store();
			}
		}
	}

	function featuredsaveorder() {
		$id = $this->getState('id');
		$featuredOrder = $this->getState('featuredOrder');
		$total = count($id);
		JArrayHelper::toInteger($featuredOrder, array(0));
		$row = &JTable::getInstance('slide', 'FPSS');
		for ($i = 0; $i < $total; $i++) {
			$row->load((int) $id[$i]);
			if ($row->featured_ordering != $featuredOrder[$i]) {
				$row->featured_ordering = $featuredOrder[$i];
				$row->store();
			}
		}
	}
	function featured() {
		$ids = $this->getState('id');
		$row = &JTable::getInstance('slide', 'FPSS');
		foreach ($ids as $id) {
			$row->load($id);
			if ($row->featured == 1){
				$row->featured = 0;
			}
			else {
				$row->featured = 1;
				if($row->featured_ordering == 0){
					$row->featured_ordering = $row->getNextOrder('featured=1', 'featured_ordering');
				}
			}
			$row->store();
		}
	}

	function accessregistered() {
		$row = &JTable::getInstance('slide', 'FPSS');
		$id = $this->getState('id');
		$row->load($id[0]);
		$row->access = 1;
		$row->check();
		$row->store();
	}

	function accessspecial() {
		$row = &JTable::getInstance('slide', 'FPSS');
		$id = $this->getState('id');
		$row->load($id[0]);
		$row->access = 2;
		$row->check();
		$row->store();
	}

	function accesspublic() {
		$row = &JTable::getInstance('slide', 'FPSS');
		$id = $this->getState('id');
		$row->load($id[0]);
		$row->access = 0;
		$row->check();
		$row->store();
	}

	function remove() {
		$row = & JTable::getInstance('slide', 'FPSS');
		$row->delete($this->getState('id'));
	}

	function cleanUp(){
		if(!$this->getState('id')) {
			return;
		}
		if(!is_array($this->getState('id'))) {
			$IDs = (array)$this->getState('id');
		}
		else {
			$IDs = $this->getState('id');
			JArrayHelper::toInteger($IDs);
		}
		$IDs = array_filter($IDs);
		$IDs = array_unique($IDs);
		$savepath = JPATH_SITE.DS.'media'.DS.'com_fpss';
		foreach($IDs as $id) {
			$filename = $id.'_'.md5('Image'.$id);
			if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.png')) {
				JFile::delete($savepath.DS.'src'.DS.$filename.'_s.png');
			}
			if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.jpg')) {
				JFile::delete($savepath.DS.'src'.DS.$filename.'_s.jpg');
			}
			if(JFile::exists($savepath.DS.'cache'.DS.$filename.'_m.jpg')) {
				JFile::delete($savepath.DS.'cache'.DS.$filename.'_m.jpg');
			}
			if(JFile::exists($savepath.DS.'cache'.DS.$filename.'_p.jpg')) {
				JFile::delete($savepath.DS.'cache'.DS.$filename.'_p.jpg');
			}
			if(JFile::exists($savepath.DS.'cache'.DS.$filename.'_t.jpg')) {
				JFile::delete($savepath.DS.'cache'.DS.$filename.'_t.jpg');
			}
		}
		return;

	}

	function stats(){

		$db = &$this->getDBO();
		$date = &JFactory::getDate();
		$now = $date->toMySQL();

		$query = "SELECT slides.title, slides.id, COUNT(stats.slideID) AS hits FROM #__fpss_slides AS slides
        LEFT JOIN #__fpss_stats AS stats ON stats.slideID = slides.id";
		$conditions = array();
		if($this->getState('catid')) {
			$conditions[] = "slides.catid = ".(int)$this->getState('catid');
		}
		if($this->getState('timeRange')) {
			$conditions[] = "stats.time > DATE_SUB(".$db->Quote($now).",INTERVAL ".(int)$this->getState('timeRange')." DAY)";
		}
		if (count($conditions)) {
			$query.= " WHERE ".implode(' AND ', $conditions);
		}
		$query.= " GROUP BY stats.slideID";
		$db->setQuery($query, 0, $this->getState('limit'));
		$rows = $db->loadObjectList();

		$data = array();
		$chartCategories = array();
		foreach($rows as $row){
			$chartCategories[] = $row->title;
			$data[]=(int)$row->hits;
		}

		$chart = new JObject();
		$chart->set('data', $data);
		$chart->set('categories', $chartCategories);
		return $chart;

	}

	function import() {
		if(!JFolder::exists(JPATH_SITE.DS.'media'.DS.'com_fpss'.DS.'src')) {
			JFolder::create(JPATH_SITE.DS.'media'.DS.'com_fpss'.DS.'src');
		}
		if(!JFolder::exists(JPATH_SITE.DS.'media'.DS.'com_fpss'.DS.'cache')) {
			JFolder::create(JPATH_SITE.DS.'media'.DS.'com_fpss'.DS.'cache');
		}
		$manifest = JPATH_SITE.DS.'media'.DS.'com_fpss'.DS.'samples'.DS.'data.xml';
		$categoryModel = &JModel::getInstance('category', 'FPSSModel');
		$slideModel = &JModel::getInstance('slide', 'FPSSModel');
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$xml = new JXMLElement(JFile::read(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'models'.DS.'category.xml'));
			$categoryParams = new JParameter('');
			foreach ($xml->params as $paramGroup) {
				foreach ($paramGroup->param as $param) {
					if ($param->getAttribute('type') != 'spacer') {
						$categoryParams->set($param->getAttribute('name'), $param->getAttribute('default'));
					}
				}
			}
			$categoryParams = $categoryParams->toString();
			$xml = new JXMLElement(JFile::read(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'models'.DS.'slide.xml'));
			$slideParams = new JParameter('');
			foreach ($xml->params as $paramGroup) {
				foreach ($paramGroup->param as $param) {
					if ($param->getAttribute('type') != 'spacer') {
						$slideParams->set($param->getAttribute('name'), $param->getAttribute('default'));
					}
				}
			}
			$slideParams = $slideParams->toString();
			$xml = new JXMLElement(JFile::read($manifest));
		}
		else {
			$xml = new JSimpleXML;
			$xml->loadFile(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'models'.DS.'category.xml');
			$categoryParams = new JParameter('');

			foreach ($xml->document->params as $paramGroup) {
				foreach ($paramGroup->param as $param) {
					if ($param->attributes('type') != 'spacer') {
						$categoryParams->set($param->attributes('name'), $param->attributes('default'));
					}
				}
			}
			// Enforce new sample data for text overriding the live parameter
			$categoryParams->set('liveData', '0');
			$categoryParams = $categoryParams->toString();

			$xml = new JSimpleXML;
			$xml->loadFile(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'models'.DS.'slide.xml');
			$slideParams = new JParameter('');
			foreach ($xml->document->params as $paramGroup) {
				foreach ($paramGroup->param as $param) {
					if ($param->attributes('type') != 'spacer') {
						$slideParams->set($param->attributes('name'), $param->attributes('default'));
					}
				}
			}
			$slideParams = $slideParams->toString();
			$xml = new JSimpleXML();
			$xml->loadFile($manifest);
			$xml = $xml->document->category;
		}
		foreach($xml as $category) {
			$attributes = $category->attributes();
			if(version_compare( JVERSION, '1.6.0', 'ge' )) {
				$data = array();
				foreach($attributes as $key=>$value) {
					$data[$key] = $value->data();
				}
				$data['language'] = '*';
			}
			else {
				$data = $attributes;
			}
			$data['params'] = $categoryParams;
			$categoryModel->setState('data', $data);
			$categoryModel->save();
			$slides = $category->children();
			foreach($slides as $slide) {
				$attributes = $slide->attributes();
				if(version_compare( JVERSION, '1.6.0', 'ge' )) {
					$data = array();
					foreach($attributes as $key=>$value) {
						$data[$key] = $value->data();
					}
					$data['language'] = '*';
				}
				else {
					$data = $attributes;
				}
				$images = array();
				foreach($slide->children() as $child) {
					if($child->name() != 'image') {
						$data[$child->name()] = $child->data();
					}
					else {
						$images[] = $child;
					}
				}
				$data['params'] = $slideParams;
				$data['dummy'] = false;
				$data['thumb'] = true;
				$data['catid'] = $categoryModel->getState('id');
				$slideModel->setState('data', $data);
				$slideModel->save();
				foreach($images as $image) {
					$id = $slideModel->getState('id');
					$attributes = $image->attributes();
					if(version_compare( JVERSION, '1.6.0', 'ge' )) {
						$data = array();
						foreach($attributes as $key=>$value) {
							$data[$key] = $value->data();
						}
					}
					else {
						$data = $attributes;
					}
					$src = JPATH_SITE.JPath::clean($data['src']);
					$folder = ($data['type'] == 'original')? 'src' : 'cache';
					$file = $id.'_'.md5('Image'.$id);
					$file .= '_'.JString::substr($data['type'], 0, 1);
					$file .= '.'.JFile::getExt($src);
					$destination = JPATH_SITE.DS.'media'.DS.'com_fpss'.DS.$folder.DS.$file;
					JFile::copy($src, $destination);
				}
			}
		}
	}

}
