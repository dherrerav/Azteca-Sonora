<?php
/**
 * @version		$Id: mod_quickicon.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

require JModuleHelper::getLayoutPath('mod_quickicon', $params->get('layout', 'default'));