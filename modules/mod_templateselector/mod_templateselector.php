<?php
/**
 * 			Mod Template Selector
 * @version	 	1.1.0
 * @package		Template Selector
 * @copyright		Copyright (C) 2007 - 2011 Joomler!.net. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * @author		Joomler!.net  joomlers@gmail.com
 * @link 			http://www.joomler.net/
 */

/**
* @package		Joomla
* @copyright		Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'helper.php');
$lists = modTemplateSelector::getLists($params);

if(count($lists) < 1){
	return;
}

require(JModuleHelper::getLayoutPath('mod_templateselector'));
?>
