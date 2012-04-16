<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
class StatsViewStats extends JView
{
	var $searchFields = array('b.subject','a.mailid');
	var $selectFields = array('b.subject','b.type','a.*');
	var $searchHistory = array('b.subject','c.email','c.name');
	var $historyFields = array('a.*','b.subject','c.email','c.name');
	var $detailSearchFields = array('b.subject','a.mailid','c.name','c.email','a.subid');
	var $detailSelectFields = array('b.subject','c.name','c.email','b.type','a.*');
	function display($tpl = null)
	{
		$function = $this->getLayout();
		if(method_exists($this,$function)) $this->$function();
		parent::display($tpl);
	}
	function forward(){
		$this->unsubscribed();
		$this->setLayout('unsubscribed');
	}
	function unsubscribed(){
		$app =& JFactory::getApplication();
		$paramBase = ACYMAILING_COMPONENT.'.'.$this->getName().$this->getLayout();
		$pageInfo->filter->order->value = $app->getUserStateFromRequest( $paramBase.".filter_order", 'filter_order',	'a.date','cmd' );
		$pageInfo->filter->order->dir	= $app->getUserStateFromRequest( $paramBase.".filter_order_Dir", 'filter_order_Dir',	'desc',	'word' );
		$pageInfo->search = $app->getUserStateFromRequest( $paramBase.".search", 'search', '', 'string' );
		$pageInfo->search = JString::strtolower( $pageInfo->search );
		$selectedMail = $app->getUserStateFromRequest( $paramBase."filter_mail",'filter_mail',0,'int');
		$pageInfo->limit->value = $app->getUserStateFromRequest( $paramBase.'.list_limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$pageInfo->limit->start = $app->getUserStateFromRequest( $paramBase.'.limitstart', 'limitstart', 0, 'int' );
		$db	=& JFactory::getDBO();
		$filters = array();
		$filters[] = "a.action = ".$db->Quote($this->getLayout());
		if(!empty($pageInfo->search)){
			$searchVal = '\'%'.$db->getEscaped($pageInfo->search).'%\'';
			$filters[] = implode(" LIKE $searchVal OR ",$this->searchHistory)." LIKE $searchVal";
		}
		if(!empty($selectedMail)){
			$filters[] = 'a.mailid = '.$selectedMail;
		}
		$query = 'SELECT '.implode(' , ',$this->historyFields).' FROM '.acymailing_table('history').' as a';
		$query .= ' JOIN '.acymailing_table('mail').' as b on a.mailid = b.mailid';
		$query .= ' JOIN '.acymailing_table('subscriber').' as c on a.subid = c.subid';
		$query .= ' WHERE ('.implode(') AND (',$filters).')';
		if(!empty($pageInfo->filter->order->value)) $query .= ' ORDER BY '.$pageInfo->filter->order->value.' '.$pageInfo->filter->order->dir;
		if(empty($pageInfo->limit->value)) $pageInfo->limit->value = 100;
		$db->setQuery($query,$pageInfo->limit->start,$pageInfo->limit->value);
		$rows = $db->loadObjectList();
		$queryCount = 'SELECT COUNT(*) FROM #__acymailing_history as a';
		if(!empty($pageInfo->search)){
			$queryCount .= ' JOIN '.acymailing_table('mail').' as b on a.mailid = b.mailid';
			$queryCount .= ' JOIN '.acymailing_table('subscriber').' as c on a.subid = c.subid';
		}
		$queryCount .= ' WHERE ('.implode(') AND (',$filters).')';
		$db->setQuery($queryCount);
		$pageInfo->elements->total = $db->loadResult();
		if(!empty($pageInfo->search)){
			$rows = acymailing_search($pageInfo->search,$rows);
		}
		$pageInfo->elements->page = count($rows);
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $pageInfo->elements->total, $pageInfo->limit->start, $pageInfo->limit->value );
		$query = 'SELECT DISTINCT b.subject, a.mailid FROM '.acymailing_table('history').' as a';
		$query .= ' JOIN '.acymailing_table('mail').' as b on a.mailid = b.mailid WHERE a.action = '.$db->Quote($this->getLayout()).' ORDER BY a.mailid DESC';
		$db->setQuery($query);
		$emails = $db->loadObjectList();
		$newsletters = array();
		$newsletters[] = JHTML::_('select.option', '0', JText::_('ALL_EMAILS') );
		foreach($emails as $oneMail){
			$newsletters[] = JHTML::_('select.option', $oneMail->mailid, $oneMail->subject );
		}
		$filterMail = JHTML::_('select.genericlist',   $newsletters,'filter_mail', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', (int) $selectedMail );
		$this->assignRef('filterMail',$filterMail);
		$this->assignRef('rows',$rows);
		$this->assignRef('pageInfo',$pageInfo);
		$this->assignRef('pagination',$pagination);
	}
	function detaillisting(){
		$app =& JFactory::getApplication();
		$doc =& JFactory::getDocument();
		$doc->addStyleSheet( ACYMAILING_CSS.'frontendedition.css' );
		$pageInfo = null;
		$config = acymailing_config();
		$paramBase = ACYMAILING_COMPONENT.'.'.$this->getName().$this->getLayout();
		$pageInfo->filter->order->value = $app->getUserStateFromRequest( $paramBase.".filter_order", 'filter_order',	'a.senddate','cmd' );
		$pageInfo->filter->order->dir	= $app->getUserStateFromRequest( $paramBase.".filter_order_Dir", 'filter_order_Dir',	'desc',	'word' );
		$pageInfo->search = $app->getUserStateFromRequest( $paramBase.".search", 'search', '', 'string' );
		$pageInfo->search = JString::strtolower( $pageInfo->search );
		$selectedMail = $app->getUserStateFromRequest( $paramBase."filter_mail",'filter_mail',0,'int');
		$selectedStatus = $app->getUserStateFromRequest( $paramBase."filter_status",'filter_status',0,'string');
		$pageInfo->limit->value = $app->getUserStateFromRequest( $paramBase.'.list_limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$pageInfo->limit->start = $app->getUserStateFromRequest( $paramBase.'.limitstart', 'limitstart', 0, 'int' );
		$database	=& JFactory::getDBO();
		$filters = array();
		if(!empty($pageInfo->search)){
			$searchVal = '\'%'.$database->getEscaped($pageInfo->search).'%\'';
			$filters[] = implode(" LIKE $searchVal OR ",$this->detailSearchFields)." LIKE $searchVal";
		}
		if(!empty($selectedMail)) $filters[] = 'a.mailid = '.$selectedMail;
		if(!empty($selectedStatus)){
			if($selectedStatus == 'bounce') $filters[] = 'a.bounce > 0';
			elseif($selectedStatus == 'open') $filters[] = 'a.open > 0';
			elseif($selectedStatus == 'notopen') $filters[] = 'a.open < 1';
			elseif($selectedStatus == 'failed') $filters[] = 'a.fail > 0';
		}
		$query = 'SELECT '.implode(' , ',$this->detailSelectFields);
		$query .= ' FROM '.acymailing_table('userstats').' as a';
		$query .= ' JOIN '.acymailing_table('mail').' as b on a.mailid = b.mailid';
		$query .= ' JOIN '.acymailing_table('subscriber').' as c on a.subid = c.subid';
		if(!empty($filters)) $query .= ' WHERE ('.implode(') AND (',$filters).')';
		if(!empty($pageInfo->filter->order->value)) $query .= ' ORDER BY '.$pageInfo->filter->order->value.' '.$pageInfo->filter->order->dir;
		if(empty($pageInfo->limit->value)) $pageInfo->limit->value = 100;
		$database->setQuery($query,$pageInfo->limit->start,$pageInfo->limit->value);
		$rows = $database->loadObjectList();
		$queryCount = 'SELECT COUNT(a.subid) FROM #__acymailing_userstats as a';
		if(!empty($pageInfo->search)){
			$queryCount .= ' JOIN '.acymailing_table('mail').' as b on a.mailid = b.mailid';
			$queryCount .= ' JOIN '.acymailing_table('subscriber').' as c on a.subid = c.subid';
		}
		if(!empty($filters)) $queryCount .= ' WHERE ('.implode(') AND (',$filters).')';
		$database->setQuery($queryCount);
		$pageInfo->elements->total = $database->loadResult();
		if(!empty($pageInfo->search)){
			$rows = acymailing_search($pageInfo->search,$rows);
		}
		$pageInfo->elements->page = count($rows);
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $pageInfo->elements->total, $pageInfo->limit->start, $pageInfo->limit->value );
		$toggleClass = acymailing_get('helper.toggle');
		$maildetailstatstype =  acymailing_get('type.detailstatsmail');
		$deliverstatus =  acymailing_get('type.deliverstatus');
		$filtersType = null;
		if(JRequest::getString('tmpl') == 'component'){
			$filtersType->mail = '<input type="hidden" value="'.$selectedMail.'" name="filter_mail" />';
			$mailClass= acymailing_get('class.mail');
			$this->assignRef('mailing',$mailClass->get($selectedMail));
		}else{
			$filtersType->mail = $maildetailstatstype->display('filter_mail',$selectedMail);
		}
		$filtersType->status = $deliverstatus->display('filter_status',$selectedStatus);
		if($app->isAdmin()){
			acymailing_setTitle(JText::_('DETAILED_STATISTICS'),'stats','stats&task=detaillisting');
			$bar = & JToolBar::getInstance('toolbar');
			$bar->appendButton( 'Link', 'back', JText::_('GLOBAL_STATISTICS'), acymailing_completeLink('stats') );
			if(acymailing_isAllowed($config->get('acl_subscriber_export','all'))){
				JToolBarHelper::spacer();
				JToolBarHelper::custom('export', 'acyexport', '',JText::_('ACY_EXPORT'), false);
			}
			JToolBarHelper::divider();
			$bar->appendButton( 'Pophelp','stats-detaillisting');
		}
		$this->assignRef('filters',$filtersType);
		$this->assignRef('toggleClass',$toggleClass);
		$this->assignRef('rows',$rows);
		$this->assignRef('pageInfo',$pageInfo);
		$this->assignRef('pagination',$pagination);
	}
	function listing(){
		$app =& JFactory::getApplication();
		$pageInfo = null;
		$config = acymailing_config();
		JHTML::_('behavior.modal','a.modal');
		$paramBase = ACYMAILING_COMPONENT.'.'.$this->getName().$this->getLayout();
		$pageInfo->filter->order->value = $app->getUserStateFromRequest( $paramBase.".filter_order", 'filter_order',	'a.senddate','cmd' );
		$pageInfo->filter->order->dir	= $app->getUserStateFromRequest( $paramBase.".filter_order_Dir", 'filter_order_Dir',	'desc',	'word' );
		$pageInfo->search = $app->getUserStateFromRequest( $paramBase.".search", 'search', '', 'string' );
		$pageInfo->search = JString::strtolower( $pageInfo->search );
		$pageInfo->limit->value = $app->getUserStateFromRequest( $paramBase.'.list_limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$pageInfo->limit->start = $app->getUserStateFromRequest( $paramBase.'.limitstart', 'limitstart', 0, 'int' );
		$database	=& JFactory::getDBO();
		$filters = array();
		if(!empty($pageInfo->search)){
			$searchVal = '\'%'.$database->getEscaped($pageInfo->search,true).'%\'';
			$filters[] = implode(" LIKE $searchVal OR ",$this->searchFields)." LIKE $searchVal";
		}
		$query = 'SELECT '.implode(' , ',$this->selectFields);
		$query .= ' FROM '.acymailing_table('stats').' as a';
		$query .= ' JOIN '.acymailing_table('mail').' as b on a.mailid = b.mailid';
		if(!empty($filters)) $query .= ' WHERE ('.implode(') AND (',$filters).')';
		if(!empty($pageInfo->filter->order->value)){
			$query .= ' ORDER BY '.$pageInfo->filter->order->value.' '.$pageInfo->filter->order->dir;
		}
		$database->setQuery($query,$pageInfo->limit->start,$pageInfo->limit->value);
		$rows = $database->loadObjectList();
		$queryCount = 'SELECT COUNT(a.mailid) FROM '.acymailing_table('stats').' as a';
		if(!empty($pageInfo->search)){
			$queryCount .= ' JOIN '.acymailing_table('mail').' as b on a.mailid = b.mailid';
 		}
 		if(!empty($filters)) $queryCount .= ' WHERE ('.implode(') AND (',$filters).')';
		$database->setQuery($queryCount);
		$pageInfo->elements->total = $database->loadResult();
		if(!empty($pageInfo->search)){
			$rows = acymailing_search($pageInfo->search,$rows);
		}
		$pageInfo->elements->page = count($rows);
		jimport('joomla.html.pagination');
		$pagination = new JPagination( $pageInfo->elements->total, $pageInfo->limit->start, $pageInfo->limit->value );
		acymailing_setTitle(JText::_('GLOBAL_STATISTICS'),'stats','stats');
		$bar = & JToolBar::getInstance('toolbar');
		if(acymailing_level(1)) $bar->appendButton( 'Link', 'stats', JText::_('CHARTS'), acymailing_completeLink('diagram') );
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		if(acymailing_isAllowed($config->get('acl_statistics_delete','all'))) JToolBarHelper::deleteList(JText::_('ACY_VALIDDELETEITEMS'));
		JToolBarHelper::divider();
		$bar->appendButton( 'Pophelp','stats-listing');
		if(acymailing_isAllowed($config->get('acl_cpanel_manage','all'))) $bar->appendButton( 'Link', 'acymailing', JText::_('ACY_CPANEL'), acymailing_completeLink('dashboard') );
		$this->assignRef('rows',$rows);
		$this->assignRef('pageInfo',$pageInfo);
		$this->assignRef('pagination',$pagination);
	}
}