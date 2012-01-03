<?php

/**
* Gavick Class - Joomla! news class
* @package Joomla!
* @Copyright (C) 2009 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0.1 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class GK_JoomlaNews
{	
	
	/**
	 *
	 * Method to get sources of articles 
	 *
	 **/
	
	function getSources($config, $news_type)
	{	
		//
		global $mainframe;
		//
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$noauth	= $contentConfig->get('show_noauth');
		// if source type is section / sections
		$source = false;
		$where1 = '';
		$where2 = '';
		//
		if($config['category'] == 0 && $config['categoriess'] == '' && $config['IDs'] == '')
		{
			$source = $config['section'];
			$where1 = ' c.section = ';
			$where2 = ' OR c.section = ';
		}
		elseif($config['category'] != 0  && $config['categoriess'] == '' && $config['IDs'] == '')
		{
			$source = $config['category'];
			$where1 = ' c.id = ';
			$where2 = ' OR c.id = ';
		}
		elseif($config['categoriess'] == '' && $config['IDs'] == '')
		{
			$source = $config['sections'];
			$where1 = ' c.section = ';
			$where2 = ' OR c.section = ';
		}
		elseif($config['categoriess'] != '' && $config['IDs'] == '')
		{
			$source = $config['categoriess'];
			$where1 = ' c.id = ';
			$where2 = ' OR c.id = ';		
		}
		else
		{
			$source = $config['IDs'];
			$where1 = ' content.id = ';
			$where2 = ' OR content.id = ';	
		}
		//	
		$content_tab = explode(',', $source);
		$where = ''; // initialize WHERE condition
		// generating WHERE condition
		for($i = 0;$i < count($content_tab);$i++)
		{
			//
			$where .= ($i == 0) ? $where1.$content_tab[$i] : $where2.$content_tab[$i];		
		}
		//
		$query_name = '
			SELECT DISTINCT 
				c.id AS ID, 
				c.section AS SID, 
				c.title AS name, 
				m.id AS MID 
			FROM 
				#__categories AS c
			LEFT JOIN 
				#__menu AS m 
				ON 
				c.id = m.componentid 
			LEFT JOIN 
				'.(($news_type == 0) ? '#__content' : '#__weblinks').' AS content 
				ON 
				c.id = content.catid 	
			WHERE 
				( '.$where.' ) 
				AND 
				c.published = 1'.((!$noauth && $config['unauthorized'] == 0) ? ' 
				AND 
				c.access <= ' .(int) $aid : '').';
		';	
		// Executing SQL Query
		$db->setQuery($query_name);
		//
		return $db->loadObjectList();
	}
	
	/**
	 *
	 * Method to get articles in standard mode 
	 *
	 **/
	
	function getNewsStandardMode($categories, $sql_where, $config, $amount)
	{	
		// mainframe
		global $mainframe;
		// Arrays for content
		$content_id = array();
		$content_iid = array();
		$content_cid = array();
		$content_title = array();
		$content_text = array();
		$content_images = array();
		$content_date = array();
		$content_date_publish = array();
		$content_author = array();
		$content_catname = array();
		$content_sid = array();
		$news_amount = 0;
		// Initializing standard Joomla classes and SQL necessary variables
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$noauth	= $contentConfig->get('show_noauth');
		$date =& JFactory::getDate();
		$now  = $date->toMySQL();
		$nullDate = $db->getNullDate();
		// Overwrite SQL query when user set IDs manually
		if($config['IDs'] != '')
		{
			// initializing variables
			$sql_where = '';
			$ids = explode(',', $config['IDs']);
			//
			for($i = 0; $i < count($ids); $i++ )
			{	
				// linking string with content IDs
				$sql_where .= ($i != 0) ? ' OR content.id = '.$ids[$i] : ' content.id = '.$ids[$i];
			}
		}
		// if some data are available
		if(count($categories) > 0)
		{
			// when showing only frontpage articles is disabled
			if($config['only_frontpage'] == 0)
			{
				$frontpage_con = ($config['news_frontpage'] == 0) ? ' AND frontpage.content_id IS NULL ' : '';
			}
			else // when showing only frontpage articles is enabled
			{
				$frontpage_con = ' AND frontpage.content_id IS NOT NULL ';
			}
			// Ordering string
			$order_options = '';
			// When sort value is random
			if($config['news_sort_value'] == 'random')
			{
				$order_options = ' RAND() '; 
			}
			else // when sort value is different than random
			{
				if($config['news_sort_value'] != 'fordering') $order_options = ' content.'.$config['news_sort_value'].' '.$config['news_sort_order'].' ';
				else $order_options = ' frontpage.ordering '.$config['news_sort_order'].' ';
			}
			// creating SQL query
			$query_news = '
			SELECT DISTINCT
				cats.title AS cat, 
				'.((($config['username'] != 2) ? 'users.'.(($config['username'] == 1) ? 'username':'name') : 'content.created_by_alias')) .' AS author,
				cats.section AS SID, 
				content.title AS title, 
				content.introtext AS text, 
				content.created AS date, 
				content.publish_up AS date_publish,
			    content.images AS images, 
				content.id as IID,
				CASE WHEN CHAR_LENGTH(content.alias) 
					THEN CONCAT_WS(":", content.id, content.alias) 
						ELSE content.id END as ID, 
				CASE WHEN CHAR_LENGTH(cats.alias) 
					THEN CONCAT_WS(":", cats.id, cats.alias) 
						ELSE cats.id END as CID 					
			FROM 
				#__content AS content 
				LEFT JOIN 
					#__categories AS categories 
					ON categories.id = content.catid 
				
				LEFT JOIN 
					#__sections AS sections 
					ON sections.id = content.sectionid 
				LEFT JOIN 
					#__menu AS menu 
					ON menu.componentid = content.id
				LEFT JOIN 
					#__users AS users 
					ON users.id = content.created_by
				LEFT JOIN 
					#__content_frontpage AS frontpage 
					ON content.id = frontpage.content_id  			
				LEFT JOIN 
					#__categories AS cats 
					ON content.catid = cats.id 	
			WHERE 
				content.state = 1'.((!$noauth && $config['unauthorized'] == 0) ? ' 
					AND categories.access <= ' .(int) $aid . ' 
					AND content.access <= '.(int) $aid : '').' 
				 	AND categories.published = 1  
				AND ( content.publish_up = '.$db->Quote($nullDate).' 
					OR content.publish_up <= '.$db->Quote($now).' ) 
					AND ( content.publish_down = '.$db->Quote($nullDate).' 
					OR content.publish_down >= '.$db->Quote($now).' ) 
				AND ( '.$sql_where.' ) 
				'.$frontpage_con.' 
			ORDER BY 
				'.$order_options.'
			LIMIT
				'.$config['startposition'].','.($amount + (int)$config['startposition']).';
			';
			// run SQL query
			$db->setQuery($query_news);
			// when exist some results
			if($news = $db->loadObjectList())
			{
				// generating tables of news data
				foreach($news as $item)
				{
					$content_id[] = $item->ID; // news IDs
					$content_iid[] = $item->IID; // news IDs
					$content_cid[] = $item->CID; // news CIDs
					$content_title[] = $item->title; // news titles
					$content_text[] = $item->text; // news text
					$content_images[] = $item->images; // news images	
					$content_date[] = $item->date; // news dates
					$content_date_publish[] = $item->date_publish; // news dates
					$content_author[] = $item->author; // news author
					$content_catname[] = $item->cat; // news category name
					$content_sid[] = $item->SID; // news category section ID
					$news_amount++;	// news amount
				}
			}
		}
		//
		// Returning data in hash table
		//
		return array(
			"ID" => $content_id,
			"IID" => $content_iid,
			"CID" => $content_cid,
			"title" => $content_title,
			"text" => $content_text,
			"images" => $content_images,
			"date" => $content_date,
			"date_publish" => $content_date_publish,
			"author" => $content_author,
			"catname" => $content_catname,
			"SID" => $content_sid,
			"news_amount" => $news_amount
		);
	}

	/**
	 *
	 * Method to get article images from Photoslide 
	 *
	 **/

	function getImages($config, $plugin_name)
	{
		global $mainframe;
		//
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		// 
		if($config['plugin_support'] == 1)
		{
			//
			$query_image = '
			SELECT 
				s.`file` AS filename,
				s.`article` AS artID		
			FROM 
				#__gk2_photoslide_slides AS s
			LEFT JOIN
				#__gk2_photoslide_groups AS g
				ON
				s.group_id = g.id
			WHERE 
			 	s.access <= '.(int) $aid.' 
				AND 
				s.published = 1  
				AND
				g.plugin = "'.$plugin_name.'" 
			;';
			//
			$db->setQuery($query_image);
			//
			$images_tab = array();
			//
			if($images = $db->loadObjectList())
			{	
				foreach($images as $image)
				{
					$images_tab[$image->artID] = $image->filename;	
				}	
			}
			//
			return $images_tab;
		}		
	}

	/**
	 *
	 * Method to get articles in category mode 
	 *
	 **/

	function getNewsCategoryMode($categories, $sql_where, $config, $amount)
	{	
		// mainframe
		global $mainframe;
		// Initializing standard Joomla classes and SQL necessary variables
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$noauth	= $contentConfig->get('show_noauth');
		$date =& JFactory::getDate();
		$now  = $date->toMySQL();
		$nullDate = $db->getNullDate();
		// Arrays for content
		$content_id = array();
		$content_iid = array();
		$content_cid = array();
		$content_title = array();
		$content_text = array();
		$content_images = array();
		$content_date = array();
		$content_author = array();
		$content_catname = array();
		$content_sid = array();
		$news_amount = array();
		//
		for($n = 0; $n < count($categories); $n++)
		{
			// Arrays for content
			$content_id[$n] = array();
			$content_iid[$n] = array();
			$content_cid[$n] = array();
			$content_title[$n] = array();
			$content_text[$n] = array();
			$content_images[$n] = array();
			$content_date[$n] = array();
			$content_author[$n] = array();
			$content_catname[$n] = array();
			$content_sid[$n] = array();
			$news_amount[$n] = 0;
			// if some data are available
			if(count($categories) > 0)
			{
				// when showing only frontpage articles is disabled
				if($config['only_frontpage'] == 0)
				{
					$frontpage_con = ($config['news_frontpage'] == 0) ? ' AND frontpage.content_id IS NULL ' : '';
				}
				else // when showing only frontpage articles is enabled
				{
					$frontpage_con = ' AND frontpage.content_id IS NOT NULL ';
				}
				// Ordering string
				$order_options = '';
				// When sort value is random
				if($config['news_sort_value'] == 'random')
				{
					$order_options = ' RAND() '; 
				}
				else // when sort value is different than random
				{
					if($config['news_sort_value'] != 'fordering') $order_options = ' content.'.$config['news_sort_value'].' '.$config['news_sort_order'].' ';
					else $order_options = ' frontpage.ordering '.$config['news_sort_order'].' ';
				}
				// creating SQL query
				$query_news = '
				SELECT DISTINCT
					cats.title AS cat, 
					'.((($config['username'] != 2) ? 'users.'.(($config['username'] == 1) ? 'username':'name') : 'content.created_by_alias')) .' AS author,
					cats.section AS SID, 
					content.title AS title, 
					content.introtext AS text, 
					content.created AS date, 
				    content.images AS images, 
					content.id as IID,
					CASE WHEN CHAR_LENGTH(content.alias) 
						THEN CONCAT_WS(":", content.id, content.alias) 
							ELSE content.id END as ID, 
					CASE WHEN CHAR_LENGTH(cats.alias) 
						THEN CONCAT_WS(":", cats.id, cats.alias) 
							ELSE cats.id END as CID 					
				FROM 
					#__content AS content 
					LEFT JOIN 
						#__categories AS categories 
						ON categories.id = content.catid 
					
					LEFT JOIN 
						#__sections AS sections 
						ON sections.id = content.sectionid 
					LEFT JOIN 
						#__menu AS menu 
						ON menu.componentid = content.id
					LEFT JOIN 
						#__users AS users 
						ON users.id = content.created_by
					LEFT JOIN 
						#__content_frontpage AS frontpage 
						ON content.id = frontpage.content_id  			
					LEFT JOIN 
						#__categories AS cats 
						ON content.catid = cats.id 	
				WHERE 
					content.state = 1'.((!$noauth && $config['unauthorized'] == 0) ? ' 
						AND categories.access <= ' .(int) $aid . ' 
						AND content.access <= '.(int) $aid : '').' 
					 	AND categories.published = 1  
					AND ( content.publish_up = '.$db->Quote($nullDate).' 
						OR content.publish_up <= '.$db->Quote($now).' ) 
						AND ( content.publish_down = '.$db->Quote($nullDate).' 
						OR content.publish_down >= '.$db->Quote($now).' ) 
					AND content.catid = '.$sql_where[$n].'  
					'.$frontpage_con.' 
				ORDER BY 
					'.$order_options.'
				LIMIT
					'.$config['startposition'].','.($amount + (int)$config['startposition']).';
				';
				// run SQL query
				$db->setQuery($query_news);
				// when exist some results
				if($news = $db->loadObjectList())
				{
					// generating tables of news data
					foreach($news as $item)
					{
						$content_id[$n][] = $item->ID; // news IDs
						$content_iid[$n][] = $item->IID; // news IDs
						$content_cid[$n][] = $item->CID; // news CIDs
						$content_title[$n][] = $item->title; // news titles
						$content_text[$n][] = $item->text; // news text
						$content_images[$n][] = $item->images; // news images	
						$content_date[$n][] = $item->date; // news dates
						$content_author[$n][] = $item->author; // news author
						$content_catname[$n][] = $item->cat; // news category name
						$content_sid[$n][] = $item->SID; // news category section ID
						$news_amount[$n]++;	// news amount
					}
				}
			}
		}
		//
		// Returning data in hash table
		//
		return array(
			"ID" => $content_id,
			"IID" => $content_iid,
			"CID" => $content_cid,
			"title" => $content_title,
			"text" => $content_text,
			"images" => $content_images,
			"date" => $content_date,
			"author" => $content_author,
			"catname" => $content_catname,
			"SID" => $content_sid,
			"news_amount" => $news_amount
		);
	}
	
	/**
	
	**/
	
	function getWeblinks($categories, $sql_where, $config, $news_amount)
	{
		// mainframe
		global $mainframe;
		// creating instances of base Joomla classes and base variables for SQL query
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$noauth	= $contentConfig->get('show_noauth');
		$date =& JFactory::getDate();
		$now  = $date->toMySQL();
		$nullDate = $db->getNullDate();	
		// if some datas are avalabile
		if(count($categories) > 0)
		{
			// setting time variable as now
			//
			$order_options = '';
			//
			if($config['news_sort_value'] == 'random') $order_options = ' RAND() '; 
			else //
			{
				if($config['news_sort_value'] == 'created') $config['news_sort_value'] = 'date';
				if($config['news_sort_value'] != 'fordering') $config['order_options'] = ' content.'.$config['news_sort_value'].' '.$config['news_sort_order'].' ';
				else $order_options = ' frontpage.ordering '.$config['news_sort_order'].' ';
			}
			//
			$query_news = '
			SELECT DISTINCT
				cats.title AS cat,  
				cats.id AS CID,
				cats.section AS SID, 
				content.title AS title, 
				content.description AS text, 
				content.date AS date, 
 				content.url AS URL				
			FROM 
				#__weblinks AS content 
				LEFT JOIN 
					#__categories AS categories 
					ON categories.id = content.catid 	
				LEFT JOIN 
					#__categories AS cats 
					ON content.catid = cats.id 	
			WHERE 
				categories.published = 1  	
				AND ( '.$sql_where.' ) 
			ORDER BY 
				'.$order_options.'
			LIMIT
				'.$startposition.','.($news_amount + $config['startposition']).';
			';
			//
			$db->setQuery($query_news);
			//
			if($news = $db->loadObjectList())
			{
				$na = 0;
				$content_cid = array();
				$content_title = array();
				$content_text = array();
				$content_date = array();
				$content_catname = array();
				$content_url = array();
				// generating tables of news data
				foreach($news as $item)
				{
					$content_cid[] = $item->CID; // news CIDs
					$content_title[] = $item->title; // news titles
					$content_text[] = $item->text; // news text
					$content_date[] = $item->date; // news dates
					$content_catname[] = $item->cat; // news category name
					$content_url[] = $item->URL; // link url
					$na++;	
				}
				// returning hash table with datas
				return array(
					"CID" => $content_cid,
					"title" => $content_title,
					"text" => $content_text,
					"date" => $content_date,
					"catname" => $content_catname,
					"url" => $content_url,
					"na" => $na
				);
			}
			// when any categories don't exists - return FALSE
			return FALSE;
		}	
	}	
}

/**/
/**/
/**/