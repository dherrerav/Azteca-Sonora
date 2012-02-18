<?php
/**
 * @version		$Id: helper.php 294 2012-01-05 00:47:00Z dextercowley $
 * @package		mod_fj_related_plus
 * @copyright	Copyright (C) 2008 Mark Dexter. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modFJRelatedPlusHelper
{
	/**
	 * The keywords from the Main Article
	 *
	 * @access public
	 * @var string array
	 */
	static $mainArticleKeywords = null;
	static $mainArticleAlias = null;
	static $mainArticleAuthor = null;
	static $mainArticleCategory = null;

	public static function getList($params)
	{
		$includeMenuTypes = $params->get('fj_menu_item_types', 'article');
		// only do this if this is an article or if we are showing this module for any menu item type
		if (modFJRelatedPlusHelper::isArticle() || ($includeMenuTypes == 'any')) //only show for article pages
		{
			$db	= JFactory::getDBO();
			$user = JFactory::getUser();
			$userGroups = implode(',', $user->getAuthorisedViewLevels());

			$showDate = $params->get('showDate', 'none');
			$showLimit = intval($params->get('count', 5));
			$minimumMatches = intval($params->get('minimumMatches', 1));
			$showCount = $params->def('showMatchCount', 0);
			$showMatchList = $params->def('showMatchList', 0);
			$orderBy = $params->get('ordering', 'alpha');
			$random = ($orderBy == 'random') ? ' rand() as random, ' : '';

			// process categories either as comma-delimited list or as array
			// (for backward compatibility)
			$catid = (is_array($params->get('catid'))) ?
				implode(',', $params->get('catid') ) : trim($params->get('catid'));

			$matchAuthor = trim($params->get('matchAuthor', 0));
			$matchAuthorCondition = '';
			$matchAuthorAlias = trim($params->get('matchAuthorAlias', 0));
			$matchAuthorAliasCondition = '';
			$matchCategory = $params->get('fjmatchCategory');
			$matchCategoryCondition = '';

			$showTooltip = $params->get('show_tooltip', 1);
			$tooltipLimit = (int) $params->get('max_chars', 250);

			$ignoreKeywords = $params->get('ignore_keywords', '');
			$ignoreAllKeywords = $params->get('ignore_all_keywords', 0);

			$includeCategories = (is_array($params->get('fj_include_categories')))
				? implode(',', $params->get('fj_include_categories')) : $params->get('fj_include_categories');
			$includeAuthors	= (is_array($params->get('fj_include_authors')))
				? implode(',', $params->get('fj_include_authors')) : $params->get('fj_include_authors');
			// put quotes around
			$includeAliases	= (is_array($params->get('fj_include_alias')))
				? implode(',', array_map(array('modFJRelatedPlusHelper', 'dbQuote'), $params->get('fj_include_alias')))
				: modFJRelatedPlusHelper::dbQuote($params->get('fj_include_alias'));
			$includeCategoriesCondition = '';
			$includeAuthorCondition = '';
			$includeAliasCondition = '';

			$nullDate = $db->getNullDate();

			$date = JFactory::getDate();
			$now  = $date->toMySQL();

			$related			= array();
			$matching_keywords 	= array();
			$metakey = '';
			$temp				= JRequest::getString('id');
			$temp				= explode(':', $temp);
			$id					= $temp[0];

			if (modFJRelatedPlusHelper::isArticle()) {
				// select the meta keywords and author info from the item
				$query = 'SELECT a.metakey, a.catid, a.created_by, a.created_by_alias,' .
					' cc.title as category_title, u.name as author ' .
					' FROM #__content AS a' .
					' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
					' LEFT JOIN #__users AS u ON u.id = a.created_by' .
					' WHERE a.id = '.(int) $id;
				$db->setQuery($query);
				$mainArticle = $db->loadObject();
			}
			else {
				// create an empty article object
				$articleArray = array('created_by_alias' =>'', 'author' =>'',
					'category_title' => '', 'metakey' => '', 'catid' => '',
					'created_by' => '');
				$mainArticle = JArrayHelper::toObject($articleArray);
			}
			modFJRelatedPlusHelper::$mainArticleAlias = $mainArticle->created_by_alias;
			modFJRelatedPlusHelper::$mainArticleAuthor = $mainArticle->author;
			modFJRelatedPlusHelper::$mainArticleCategory = $mainArticle->category_title;
			$metakey = trim($mainArticle->metakey);

			if (($metakey) || 	// do the query if there are keywords
				($matchAuthor) || // or if the author match is on
				// or if the alias match is on and an alias
				(($matchAuthorAlias) && ($mainArticle->created_by_alias)) ||
				($matchCategory) ||	// or if the match category parameter is yes
				($includeCategories > ' ') || // or other categories
				($includeAuthors > ' ') || // or other authors
				($includeAliases > ' ')) // or other author aliases
			{
				// explode the meta keys on a comma
				$rawKeys = explode(',', $metakey);

				// get array of keywords to ignore
				$ignoreKeywordArray = array();
				if ($ignoreKeywords) {
					$ignoreKeywordArray =
					modFJRelatedPlusHelper::cleanKeywordList($ignoreKeywords);
				}

				// put only good keys in $keys array
				// good = non-blank and not in ignore list
				$keys = array();
				foreach ($rawKeys as $key) {
					$key = trim($key);
					if (($key) && !(in_array(JString::strtoupper($key), $ignoreKeywordArray))) {
						$keys[] = $key;
					}
				}
				modFJRelatedPlusHelper::$mainArticleKeywords = $keys;
				$likes = array ();

				// create likes array for query -- only if we are not ignoring all keywords
				// if we are ignoring all keywords, $likes is empty
				if (!$ignoreAllKeywords) {
					foreach ($keys as $key) {
						$likes[] = ',' . $db->getEscaped($key) . ','; // surround with commas so first and last items have surrounding commas
					}
				}

				if ((count($likes)) || //the current article has keywords or we are matching on author
				($matchAuthor) || // or we are matching on author
				(($matchAuthorAlias) && ($mainArticle->created_by_alias)) || // or author alias
				($matchCategory) || // or category
				($includeCategories > ' ') || // or other categories
				($includeAuthors > ' ') || // or other authors
				($includeAliases > ' ')) // or other author aliases
				{
					// get the ordering for the query
					if ($showDate == 'modify') {
						$dateSelected = 'a.modified as date, ';
						$dateOrderby = 'a.modified';
					} elseif ($showDate == 'published') {
						$dateSelected = 'a.publish_up as date, ';
						$dateOrderby = 'a.publish_up';
					} else {
						$dateSelected = 'a.created as date, ';
						$dateOrderby = 'a.created';
					}
					switch ($orderBy)
					{
						case 'alpha' :
							$sqlSort = 'ORDER BY a.title';
							break;

						case 'rdate' :
							$sqlSort = 'ORDER BY '. $dateOrderby . ' desc, a.title';
							break;

						case 'date' :
							$sqlSort = 'ORDER BY '. $dateOrderby . ', a.title';
							break;

						case 'bestmatch' : // note that for bestmatch order, sort must be done after the sql query is run
							$sqlSort = '';
							break;

						case 'article_order' :
							$sqlSort = 'ORDER BY cc.lft, a.ordering, a.title' ;
							break;

						case 'random' :
							$sqlSort = 'ORDER BY random';
							break;

						default:
							$sqlSort = 'ORDER BY a.title';
					}
					if ($likes) {
						$keywordSelection = ' CONCAT(",", REPLACE(a.metakey,", ",","),",") LIKE "%'.
						implode('%" OR CONCAT(",", REPLACE(a.metakey,", ",","),",") LIKE "%', $likes).'%"';
					}
					else { // in this case we are only going to match on author or alias or category,
						// so we put a harmless false selection here
						$keywordSelection = ' 1 = 2 '; // just as a placeholder (so our AND's and OR's still work)
					}

					if ($catid > ' ' and ($mainArticle->catid > ' ')) {
						$ids = str_replace('C', $mainArticle->catid, JString::strtoupper($catid));
						$ids = explode( ',', $ids);
						JArrayHelper::toInteger( $ids );
						$catCondition = ' AND a.catid IN (' . implode(',', $ids ) . ')';
					}

					if ($matchAuthor) {
						$matchAuthorCondition = ' OR a.created_by = ' . $db->Quote($mainArticle->created_by) . ' ';
					}

					if (($matchAuthorAlias) && ($mainArticle->created_by_alias)) {
						$matchAuthorAliasCondition = ' OR UPPER(a.created_by_alias) = '
							. $db->Quote(JString::strtoupper($mainArticle->created_by_alias)) . ' ';
					}

					if ($matchCategory) {
						$matchCategoryCondition = ' OR a.catid = ' . $db->Quote($mainArticle->catid) . ' ';
					}

					if ($includeCategories > ' ') {
						$includeCategoriesCondition = ' OR a.catid in ('. $includeCategories . ') ';
					}
					if ($includeAuthors > ' ') {
						$includeAuthorCondition = ' OR a.created_by in ('. $includeAuthors . ') ';
					}
					if ($includeAliases > ' ') {
						$includeAliasCondition = ' OR a.created_by_alias in ('. $includeAliases . ') ';
					}

					// select other items based on the metakey field 'like' the keys found
					$query = 'SELECT a.id, a.title, a.introtext, ' .
					$dateSelected .
					 		' a.catid, cc.access AS cat_access,' .
							' a.created_by, a.created_by_alias, u.name AS author, ' .
							' cc.published AS cat_state, ' .
							' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
							' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,'.
							' cc.title as category_title, a.introtext as introtext_raw, a.fulltext, ' .
							$random .
					// add new columns to query for counting keyword matches
							' a.metakey, "0" as match_count, "" as match_list ' .
							' FROM #__content AS a' .
							' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' .
							' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
							' LEFT JOIN #__users AS u ON u.id = a.created_by' .
							' WHERE a.id != '.(int) $id .
							' AND a.state = 1' .
							' AND a.access IN (' . $userGroups . ')' .
							' AND cc.access IN (' . $userGroups . ')' .
							' AND cc.published = 1 ' .
							' AND ( ' .
					$keywordSelection .
					($matchAuthor ? $matchAuthorCondition : '' ) . // author match part of OR clause
					($matchAuthorAlias ? $matchAuthorAliasCondition : '') . // author alias part of OR clause
					($matchCategory ? $matchCategoryCondition : '') . // match category part of OR clause
					(($includeCategories > ' ') ? $includeCategoriesCondition : ''). // include articles from these categories
					(($includeAuthors > ' ') ? $includeAuthorCondition : ''). // include articles from these authors
					(($includeAliases > ' ') ? $includeAliasCondition : ''). // include articles from these author aliases
					' )' .
							' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )' .
							' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' ) ' .
					((($catid > ' ') && ($mainArticle->catid > ' ')) ? $catCondition : '') .  // add category selection, if any
					$sqlSort; // sort the query

					// if not sorting by best match or using the minimum matches
					// we can limit the sql query to the count parameter
					if (($orderBy != 'bestmatch') && ($minimumMatches <= 1))
					{
						$db->setQuery($query, 0, $showLimit);
					}
					else
					{
						$db->setQuery($query); // can't use $showLimit until we sort by bestmatch
					}
					$temp = $db->loadObjectList();

					if (count($temp)) // we have at least one related article
					{
						// count the number of keyword matches (skip if not required based on parameter settings)
						if (($showMatchList) || ($showCount) || ($orderBy == 'bestmatch') ||
							($orderBy == 'keyword_article') || ($minimumMatches > 1))
						{
							foreach ($temp as $row) // loop through each related article
							{
								$rowkeywords = explode(',', trim($row->metakey)); // create array of current article's keyword phrases
								foreach ($rowkeywords as $keyword ) // loop through each keyword phrase of this related article
								{
									foreach ($keys as $nextkey) // loop through each keyword phrase of the main article
									{
										if ((trim($keyword)) // only test if there is at least one keyword
										&& (JString::strtoupper(trim($keyword)) == JString::strtoupper(trim($nextkey)))) // test key match (ignore case)
										{
											$row->match_count++; // if match, increment counter
											$matching_keywords[] = trim($keyword); // if match, add this phrase to list of matches
										}
									}
								}
								// add author or alias to count and list, if applicable
								if (($matchAuthorAlias) && // check parameter
								(trim($mainArticle->created_by_alias)) && // check that there is an alias
								(JString::strtoupper(trim($row->created_by_alias)) == JString::strtoupper(trim($mainArticle->created_by_alias)))) // check match
								{
									$row->match_count++;
									$matching_keywords[] = trim($row->created_by_alias);
								}
								else if (($matchAuthor) && ($row->created_by == $mainArticle->created_by)) // otherwise, check authors
								{
									$row->match_count++;
									$matching_keywords[] = trim($row->author);
								}
								if (($matchCategory) && ($mainArticle->catid == $row->catid)) {
									$row->match_count++;
									$matching_keywords[] = ($row->catid == 0) ? JText::_('Uncategorised') : trim($row->category_title);
								}

								if (($includeCategories > ' ')
								&& (in_array($row->catid, explode(',', $includeCategories)))
								&& !(($row->catid == $mainArticle->catid) && ($matchCategory))) {
									$row->match_count++;
									$matching_keywords[] = ($row->catid == 0) ? JText::_('Uncategorised') : trim($row->category_title);
								}
								if (($includeAliases)
								&& (in_array($db->Quote($row->created_by_alias), explode(',', $includeAliases)))
								&& !(($row->created_by_alias == $mainArticle->created_by_alias) && ($matchAuthorAlias))) {
									$row->match_count++;
									$matching_keywords[] = $row->created_by_alias;
								}
								else if (($includeAuthors)
								&& (in_array($row->created_by, explode(',', $includeAuthors)))
								&& !(($row->created_by == $mainArticle->created_by) && ($matchAuthor))) {
									$row->match_count++;
									$matching_keywords[] = $row->author;
								}

								$row->match_list = $matching_keywords; // save all of the matches for the current row
								$matching_keywords = array(); // reset the array for the next row
							}
						}

						if ($orderBy == 'bestmatch') // need to sort now that we have the count of keyword matches
						{
							usort($temp, array('modFJRelatedPlusHelper', 'reverseSort'));
						}

						$ii = 1;
						foreach ($temp as $row)
						{
							if (($row->match_count >= $minimumMatches || $minimumMatches <= 1))
							{
								$row->route = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug));
								// add processing for intro text tooltip
								if ($showTooltip) {
									// limit introtext to length if parameter set & it is needed
									$strippedText = strip_tags($row->introtext);
									$row->introtext = modFJRelatedPlusHelper::fixSefImages($row->introtext);
									if (($tooltipLimit > 0) && (strlen($strippedText) > $tooltipLimit)) {
										$row->introtext =
										htmlspecialchars(
										modFJRelatedPlusHelper::getPreview($row->introtext, $tooltipLimit)) . ' ...';
									}
									else {
										$row->introtext = htmlspecialchars($row->introtext);
									}
								}
								$related[] = $row;

								// need to check this in case we are using bestmatch sort or minimum matches
								// Increment only if we added this to the array
								if ($ii++ >= $showLimit) { break; }
							}
						}
					}
					unset ($temp);
				}
			}

			return $related;
		}
	}

	function reverseSort ($row1, $row2) // comp
	{
		if ($row1->match_count == $row2->match_count) // sort by title within match_count (if same # matches)
		{
			$result = strcmp ($row1->title, $row2->title);
		}
		else
		{
			$result = - strcmp ($row1->match_count, $row2->match_count); // otherwise, sort by reverse match_count
		}
		return $result;
	}

	/**
	 * This function returns the text up to the last space in the string.
	 * This is used to always break the introtext at a space (to avoid breaking in
	 * the middle of a special character, for example.
	 * @param $rawText
	 * @return string
	 */
	function getUpToLastSpace($rawText)
	{
		$throwAway = strrchr($rawText, ' ');
		$endPosition = strlen($rawText) - strlen($throwAway);
		return substr($rawText, 0, $endPosition);
	}

	/**
	 * Function to extract first n chars of text, ignoring HTML tags.
	 * Text is broken at last space before max chars in stripped text
	 * @param $rawText full text with tags
	 * @param $maxLength max length
	 * @return unknown_type
	 */
	function getPreview($rawText, $maxLength) {
		$strippedText = substr(strip_tags($rawText), 0, $maxLength);
		$strippedText = modFJRelatedPlusHelper::getUpToLastSpace($strippedText);
		$j = 0; // counter in $rawText
		// find the position in $rawText corresponding to the end of $strippedText
		for ($i = 0; $i < strlen($strippedText); $i++) {
			// skip chars in $rawText that were stripped
			while (substr($strippedText,$i,1) != substr($rawText, $j,1)) {
				$j++;
			}
			$j++; // we found the next match. now increment to keep in synch with $i
		}
		return (substr($rawText, 0, $j)); // return up to this char
	}

	/**
	 * Function to clean up ignore_keywords parameter to remove extra spaces
	 * and illegal characters. Also converts to upper case to allow for
	 * case-insensitive comparisons.
	 * @param $rawList - one or more keywords with possible bad characters
	 * returns array() of clean keywords
	 *
	 */
	function cleanKeywordList($rawList) {
		$bad_characters = array("\n", "\r", "\"", "<", ">"); // array of characters to remove
		$after_clean = JString::str_ireplace($bad_characters, "", $rawList); // remove bad characters
		$keys = explode(',', $after_clean); // create array using commas as delimiter
		$clean_keys = array();
		foreach($keys as $key) {
			if(trim($key)) {  // ignore blank keywords
				$clean_keys[] = JString::strtoupper( trim($key) );
			}
		}
		return $clean_keys; // return array of clean, upper-case keyword phrases
	}

	/**
	 * Function to test whether we are in an article view.
	 *
	 * returns boolean True if current view is an article
	 */
	function isArticle() {
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$id	= JRequest::getInt('id');
		// return True if this is an article
		return ($option == 'com_content' && $view == 'article' && $id);
	}

	/**
	 * Function to fix SEF images in tooltip -- add base to image URL
	 * @param $buffer -- intro text to fix
	 * @return $fixedText -- with image tags fixed for SEF
	 */
	function fixSefImages ($buffer) {
		$config =& JFactory::getConfig();
		$sef = $config->getValue('config.sef');
		if ($sef) // process if SEF option enabled
		{
			$base   = JURI::base(true).'/';
			$protocols = '[a-zA-Z0-9]+:'; //To check for all unknown protocals (a protocol must contain at least one alpahnumeric fillowed by :
			$regex     = '#(src|href)="(?!/|'.$protocols.'|\#|\')([^"]*)"#m';
			$buffer    = preg_replace($regex, "$1=\"$base\$2\"", $buffer);
		}
		return $buffer;
	}

	function dbQuote($string) {
		if ($string) {
			$db =& JFactory::getDBO();
			$string = $db->Quote($string);
		}
		return $string;
	}
}
