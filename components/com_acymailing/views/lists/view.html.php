<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
class listsViewLists extends JView
{
	function display($tpl = null)
	{
		$function = $this->getLayout();
		if(method_exists($this,$function)) $this->$function();
		parent::display($tpl);
	}
	function listing(){
		global $Itemid;
		$app =& JFactory::getApplication();
		$config=acymailing_config();
		$menus	= &JSite::getMenu();
		$menu	= $menus->getActive();
		if(empty($menu) AND !empty($Itemid)){
			$menus->setActive($Itemid);
			$menu	= $menus->getItem($Itemid);
		}
		if (is_object( $menu )) {
			jimport('joomla.html.parameter');
			$menuparams = new JParameter( $menu->params );
			if(!empty($menuparams)){
				$this->assignRef('listsintrotext',$menuparams->get('listsintrotext'));
				$this->assignRef('listsfinaltext',$menuparams->get('listsfinaltext'));
			}
			$document	=& JFactory::getDocument();
			if ($menuparams->get('menu-meta_description')) $document->setDescription($menuparams->get('menu-meta_description'));
			if ($menuparams->get('menu-meta_keywords')) $document->setMetadata('keywords',$menuparams->get('menu-meta_keywords'));
			if ($menuparams->get('robots')) $document->setMetadata('robots',$menuparams->get('robots'));
			if ($menuparams->get('page_title')) $document->setTitle($menuparams->get('page_title'));
		}
		$pathway	=& $app->getPathway();
		$pathway->addItem(JText::_('MAILING_LISTS'));
		$document	=& JFactory::getDocument();
		$link	= '&format=feed&limitstart=';
		if($config->get('acyrss_format') == 'rss'  || $config->get('acyrss_format') == 'both'){
			$attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
			$document->addHeadLink(JRoute::_($link.'&type=rss'), 'alternate', 'rel', $attribs);
		}
		if($config->get('acyrss_format') == 'atom' || $config->get('acyrss_format') == 'both'){
			$attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
			$document->addHeadLink(JRoute::_($link.'&type=atom'), 'alternate', 'rel', $attribs);
		}
		$listsClass = acymailing_get('class.list');
		$allLists = $listsClass->getLists();
		if(acymailing_level(1)){
			$allLists = $listsClass->onlyCurrentLanguage($allLists);
		}
		$myItem = empty($Itemid) ? '' : '&Itemid='.$Itemid;
		$this->assignRef('rows',$allLists);
		$this->assignRef('item',$myItem);
	}
}