<?php
/**
 * @version		$Id: helper.php 21002 2011-03-20 16:09:29Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_languages
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.language.helper');
jimport('joomla.utilities.utility');

abstract class modLanguagesHelper
{
	public static function getList(&$params)
	{
		$lang = JFactory::getLanguage();
		$languages	= JLanguageHelper::getLanguages();
		$db			= JFactory::getDBO();
		$app		= JFactory::getApplication();
		$query		= $db->getQuery(true);

		$query->select('id');
		$query->select('language');
		$query->from($db->nameQuote('#__menu'));
		$query->where('home=1');
		$db->setQuery($query);
		$homes = $db->loadObjectList('language');

		foreach($languages as $i => &$language) {
			// Do not display language without frontend UI
			if (!JLanguage::exists($language->lang_code)) {
				unset($languages[$i]);
			}
			// Do not display language without specific home menu
			elseif (!isset($homes[$language->lang_code])) {
				unset($languages[$i]);
			}
			else {
				if ($app->getLanguageFilter()) {
					$language->active =  $language->lang_code == $lang->getTag();
					if ($app->getCfg('sef')=='1') {
						$itemid = isset($homes[$language->lang_code]) ? $homes[$language->lang_code]->id : $homes['*']->id;
						$language->link = JRoute::_('index.php?lang='.$language->sef.'&Itemid='.$itemid);
					}
					else {
						$language->link = 'index.php?lang='.$language->sef;
					}
				}
				else {
					$language->link = 'index.php';
				}
			}
		}
		return $languages;
	}
}
