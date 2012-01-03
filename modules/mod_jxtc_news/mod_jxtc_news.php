<?php
/*
	JoomlaXTC News Module
	
	version 1.1.1
	
	Copyright (C) 2008,2009,2010,2011  Monev Software LLC.	All Rights Reserved.
	
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
	See COPYRIGHT.php for more information.
	See LICENSE.php for more information.
	
	Monev Software LLC
	www.joomlaxtc.com
*/

defined('_JEXEC') or die('Restricted access');
require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
$contentconfig = &JComponentHelper::getParams( 'com_content' );

$db		=& JFactory::getDBO();
$user		=& JFactory::getUser();
$userId		= $user->get('id');
$count		= $params->get('count', 5);
$catid		= $params->get('catid');
$secid		= trim( $params->get('secid') );
$columns	= trim( $params->get('columns',3) );
$html			= trim( $params->get('html','{intro}') );
$maxintro	= trim( $params->get('maxintro'),'' );
$show_front	= $params->get('show_front', 1);
$aid		= $user->get('aid', 0);

$contentConfig = &JComponentHelper::getParams( 'com_content' );
$access		= !$contentConfig->get('show_noauth');

$nullDate	= $db->getNullDate();

$date =& JFactory::getDate();
$now = $date->toMySQL();

$where		= 'a.state = 1'
	. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
	. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
	;

// User Filter
switch ($params->get( 'user_id' ))
{
	case 'by_me':
		$where .= ' AND (created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
		break;
	case 'not_me':
		$where .= ' AND (created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
		break;
}

// Ordering
switch ($params->get( 'ordering' )) {
	case 'm_dsc':
		$ordering		= 'a.modified DESC, a.created DESC';
		break;
	case 'c_hits':
		$ordering		= 'a.hits DESC';
		$mostreadtime	= $params->get('days', 1);
		$where			.= ' AND a.created >= DATE_SUB(CURRENT_DATE, INTERVAL ' . $mostreadtime . ' DAY)';
	case 'c_dsc':
	default:
		$ordering		= 'a.created DESC';
		break;
}

if ($catid) {
    if(is_array($catid)){
        if($catid[0] != 0)
            $catCondition = ' AND cc.id in ('.join(',',$catid).')';
    }
    else{
        $catCondition = ' AND (cc.id = '.$catid.')';
    }
}

// Content Items only
$query = 'SELECT a.*, ' .
	' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
	' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
	' FROM #__content AS a' .
	($show_front == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
	' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
	' WHERE '. $where;
        if($access){
            $groups	= implode(',', $user->getAuthorisedViewLevels());
            $query .= ' AND a.access IN ('.$groups.')';
        }
	$query .= ($catid ? $catCondition : '').
	($show_front == '0' ? ' AND f.content_id IS NULL ' : '').
	' AND cc.published = 1' .
	' ORDER BY '. $ordering;
$db->setQuery($query, 0, $count);
$rows = $db->loadObjectList();

$cell_width = intval(100 / $columns);
echo '<div class="latestnews'.$params->get('moduleclass_sfx').'">';
$c=1;
if (count($rows) > 0) {
	$i=0;
	foreach ( $rows as $row ) {
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug));
		$ini=strpos(strtolower($row->introtext),'<img');
		if ($ini === false) $img = '';
		else {
			$ini = strpos($row->introtext,'src="',$ini)+5;
			$fin = strpos($row->introtext,'"',$ini);
			$img = substr($row->introtext,$ini,$fin-$ini);
			$fin = strpos($row->introtext,'>',$fin);
		}
		$intro=strip_tags($row->introtext);
		if (!empty($maxintro)) $intro = trim(substr($intro,0,$maxintro)).'...';	
		$hold = $html;
		$hold = str_replace( '{link}', $link, $hold );
		$hold = str_replace( '{title}', htmlspecialchars($row->title), $hold );
		$hold = str_replace( '{intro}', $row->introtext, $hold );
		$hold = str_replace( '{introtext}', $intro, $hold );
		$hold = str_replace( '{introimage}', $img, $hold );
		if ($columns <= $i) {
			$hold = '<a href="' . $link . '" title="' . htmlspecialchars($row->title) . '"><h3>' . $row->title . '</h3></a>';
		}
		echo '<div style="float:left;width:'.$cell_width.'%"><div class="jxtcnews'.$params->get('moduleclass_sfx').'">'.$hold.'</div></div>';
		$i++;
		if ($c++ >= $columns) {
			echo '<div style="clear: both;"></div>';
			$c=1;
		}
	}
}
if ($c>1) echo '<div style="clear: both;"></div>';
echo '</div>';
?>
<div style="display:none"><a href="http://www.joomlaxtc.com">JoomlaXTC News - Copyright Monev Software LLC</a></div>