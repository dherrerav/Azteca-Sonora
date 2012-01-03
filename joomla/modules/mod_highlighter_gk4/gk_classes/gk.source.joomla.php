<?php

/**
* News class
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');


class NH_GK4_Joomla_Source {	
// Method to get sources of articles
	function getSources($config) {
		//
		$db = JFactory::getDBO();
		// if source type is section / sections
		$source = false;
		$where1 = '';
		$where2 = '';
		//
		if($config['data_source'] == 'com_categories'){
			$source = $config['com_categories'];
			$where1 = ' c.id = ';
			$where2 = ' OR c.id = ';
		}else{
			$source = strpos($config['com_articles'],',') !== false ? explode(',', $config['com_articles']) : $config['com_articles'];
			$where1 = ' content.id = ';
			$where2 = ' OR content.id = ';	
		}
		//	
		$where = ''; // initialize WHERE condition
		// generating WHERE condition
		for($i = 0;$i < count($source);$i++){
			if(count($source) == 1) $where .= ($i == 0) ? $where1.$source[0] : $where2.$source[0];
			else $where .= ($i == 0) ? $where1.$source[$i] : $where2.$source[$i];		
		}
		//
		$query_name = '

			SELECT DISTINCT 

				c.id AS CID

			FROM 

				#__categories AS c

			LEFT JOIN 

				#__content AS content 

				ON 

				c.id = content.catid 	

			WHERE 

				( '.$where.' ) 

				AND 

				c.extension = '.$db->quote('com_content').'

				AND 

				c.published = 1

            ';	

		// Executing SQL Query

		$db->setQuery($query_name);

		//

		return $db->loadObjectList();

	}

	

	// Method to get articles in standard mode 

	function getArticles($categories, $config, $amount) {	

		$sql_where = '';

		//

		if($categories) {		

			$j = 0;

			// getting categories ItemIDs

			foreach ($categories as $item) {

				//$sql_where .= ($j != 0) ? ' OR content.catid = '.$item->ID : ' content.catid = '.$item->ID;

			    $sql_where .= ($j != 0) ? ' OR content.catid = '.$item->CID : ' content.catid = '.$item->CID;

                $j++;

			}	

		}

		// Arrays for content

		$content_id = array();

		$content_iid = array();

		$content_cid = array();

		$content_title = array();

		$content_text = array();

		$content_sid = array();

		$news_amount = 0;

        // check access control

		$access_con = ' AND content.access IN ('. implode(',', JFactory::getUser()->authorisedLevels()) .') ';

		// Initializing standard Joomla classes and SQL necessary variables

		$db =& JFactory::getDBO();

		$user =& JFactory::getUser();

		$aid = $user->get('aid', 0);

		$contentConfig = &JComponentHelper::getParams( 'com_content' );

		$noauth	= $contentConfig->get('show_noauth');

		$date =& JFactory::getDate("now", $config['time_offset']);

		$now  = $date->toMySQL();

		$nullDate = $db->getNullDate();

		// Overwrite SQL query when user set IDs manually

		if($config['data_source'] == 'com_articles' && $config['com_articles'] != ''){
			// initializing variables
			$sql_where = '';
			$ids = explode(',', $config['com_articles']);
			//
			for($i = 0; $i < count($ids); $i++ ){	
				// linking string with content IDs
				$sql_where .= ($i != 0) ? ' OR content.id = '.$ids[$i] : ' content.id = '.$ids[$i];
			}
		}
		// language filters
		$lang_filter = '';
		if (JFactory::getApplication()->getLanguageFilter()) {
			$lang_filter = ' AND content.language in ('.$db->quote(JFactory::getLanguage()->getTag()).','.$db->quote('*').') ';
		}
		// if some data are available

		if(count($categories) > 0){

			// when showing only frontpage articles is disabled

			$frontpage_con = ($config['only_frontpage'] == 0) ? (($config['news_frontpage'] == 0) ? ' AND frontpage.content_id IS NULL ' : '' ) : (($config['news_frontpage'] == 0) ? ' AND frontpage.content_id = 10 ' : ' AND frontpage.content_id IS NOT NULL ' );

			$since_con = '';

			if($config['news_since'] !== '') $since_con = ' AND content.created >= ' . $db->Quote($config['news_since']);

			// Ordering string

			$order_options = '';

			// When sort value is random

			if($config['news_sort_value'] == 'random') {

				$order_options = ' RAND() '; 

			}else{ // when sort value is different than random

				if($config['news_sort_value'] != 'fordering') $order_options = ' content.'.$config['news_sort_value'].' '.$config['news_sort_order'].' ';

				else $order_options = ' frontpage.ordering '.$config['news_sort_order'].' ';

			}	

			// creating SQL query

            $query_news = '

			SELECT DISTINCT

				categories.title AS cat, 

				'.($config['use_title_alias'] ? 'content.alias' : 'content.title').' AS title, 

				content.introtext AS text, 

				content.id AS IID,

				CASE WHEN CHAR_LENGTH(content.alias) 

					THEN CONCAT_WS(":", content.id, content.alias) 

						ELSE content.id END as ID, 

				CASE WHEN CHAR_LENGTH(categories.alias) 

					THEN CONCAT_WS(":", categories.id, categories.alias) 

						ELSE categories.id END as CID 					

			FROM 

				#__content AS content 

				LEFT JOIN 

					#__categories AS categories 

					ON categories.id = content.catid 

				LEFT JOIN 

					#__users AS users 

					ON users.id = content.created_by

				LEFT JOIN 

					#__content_frontpage AS frontpage 

					ON content.id = frontpage.content_id  			

			WHERE 

				content.state = 1

                    '. $access_con .' 

	 					AND categories.published = 1  

			 		AND ( content.publish_up = '.$db->Quote($nullDate).' OR content.publish_up <= '.$db->Quote($now).' )

					AND ( content.publish_down = '.$db->Quote($nullDate).' OR content.publish_down >= '.$db->Quote($now).' )

				AND ( '.$sql_where.' ) 
				'.$lang_filter.'
				'.$frontpage_con.' 
				

			ORDER BY 

				'.$order_options.'

			LIMIT

				'.($config['startposition']).','.($amount + (int)$config['startposition']).';

			';

			// run SQL query

			$db->setQuery($query_news);

			// when exist some results

			if($news = $db->loadObjectList()) {

				// generating tables of news data

				foreach($news as $item) {						

					$content_id[] = $item->ID; // news IDs

					$content_iid[] = $item->IID; // news IDs

					$content_cid[] = $item->CID; // news CIDs

					$content_title[] = $item->title; // news titles

					$content_text[] = $item->text; // news text

					$news_amount++;	// news amount

				}

			}

		}

		// Returning data in hash table

		return array(

			"ID" => $content_id,

			"IID" => $content_iid,

			"CID" => $content_cid,

			"title" => $content_title,

			"text" => $content_text,

			"SID" => $content_sid,

			"news_amount" => $news_amount

		);

	}

}

