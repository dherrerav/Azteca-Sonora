<?php
/**
 * @version		$Id: category.php 489 2011-07-06 15:27:49Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSCategory extends JTable {

	var $id = null;
	var $name = null;
	var $published = null;
	var $ordering = null;
	var $language = null;
	var $params = null;

	function __construct( & $db) {
		parent::__construct('#__fpss_categories', 'id', $db);
	}

	function check() {
		if (JString::trim($this->name) == '') {
			$this->setError(JText::_('FPSS_CATEGORY_MUST_HAVE_A_NAME'));
			return false;
		}
		return true;
	}

	function bind($array, $ignore = '')	{
		if (key_exists('params', $array) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}
		return parent::bind($array, $ignore);
	}

	function delete($id){

		JArrayHelper::toInteger( $id );
		$query = "DELETE FROM #__fpss_categories WHERE id IN(".implode(',',$id).")";
		$this->_db->setQuery($query);
		if ($this->_db->query())
			return true;
		else {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

	}

	function truncate($id){

		JArrayHelper::toInteger( $id );
		$query = "DELETE FROM #__fpss_slides WHERE catid IN(".implode(',',$id).")";
		$this->_db->setQuery($query);
		if ($this->_db->query())
			return true;
		else {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

	}

}
