<?php
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';
require_once JPATH_SITE . '/libraries/simple_html_dom.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

class modBreakingNewsHelper {
	public function getArticles(&$params) {
		$db =& JFactory::getDbo();
		$application =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$scripts = array_keys($document->_scripts);
		$styleSheets = array_keys($document->_styleSheets);
		$scriptsFound = false;
		$styleSheetsFound = false;
		for ($i = 0; $i < count($scripts); $i++) {
			if (stripos($scripts[$i], 'mod_breaking_news.js') !== false) {
				$scriptsFound = true;
			}
		}
		for ($i = 0; $i < count($styleSheets); $i++) {
			if (stripos($styleSheets[$i], 'mod_breaking_news.css') !== false) {
				$styleSheetsFound = true;
			}
		}
		if (!$scriptsFound) {
			$document->addScript(JURI::base() . 'modules/mod_breaking_news/js/mod_breaking_news.js');
		}
		if (!$styleSheetsFound) {
			$document->addStyleSheet(JURI::base() . 'modules/mod_breaking_news/css/mod_breaking_news.css');
		}
		$applicationParams = $application->getParams();
		$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		$model->setState('params', $applicationParams);
		$catids = $params->get('catids');
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		if ($catids) {
			if ($params->get('show_child_category_articles', 0) && (int) $params->get('levels', 0) > 0) {
				// Get an instance of the generic categories model
				$categories = JModel::getInstance('Categories', 'ContentModel', array('ignore_request' => true));
				$categories->setState('params', $applicationParams);
				$levels = $params->get('levels', 1) ? $params->get('levels', 1) : 9999;
				$categories->setState('filter.get_children', $levels);
				$categories->setState('filter.published', 1);
				$categories->setState('filter.access', $access);
				$additional_catids = array();
				foreach($catids as $catid) {
					$categories->setState('filter.parentId', $catid);
					$recursive = true;
					$items = $categories->getItems($recursive);
		
					if ($items) {
						foreach($items as $category) {
							$condition = (($category->level - $categories->getParent()->level) <= $levels);
							if ($condition) {
								$additional_catids[] = $category->id;
							}
		
						}
					}
				}
				$catids = array_unique(array_merge($catids, $additional_catids));
			}
		}
		$model->setState('filter.category_id', $catids);
		$model->setState('filter.access', $access);
		// Filter by language
		$model->setState('filter.language',$application->getLanguageFilter());
		// Ordering
		$model->setState('list.ordering', $params->get('article_ordering', 'a.ordering'));
		$model->setState('list.direction', $params->get('article_ordering_direction', 'ASC'));
		$model->setState('list.start', 0);
		$count = array_sum(explode(',', trim($params->get('articles_per_column'))));
		$model->setState('list.limit', $count);
		// New Parameters
		$model->setState('filter.featured', $params->get('show_front', 'show'));
		$model->setState('filter.published', 1);
		$date_filtering = $params->get('date_filtering', 'off');
		if ($date_filtering !== 'off') {
			$model->setState('filter.date_filtering', $date_filtering);
			$model->setState('filter.date_field', $params->get('date_field', 'a.created'));
			$model->setState('filter.start_date_range', $params->get('start_date_range', '1000-01-01 00:00:00'));
			$model->setState('filter.end_date_range', $params->get('end_date_range', '9999-12-31 23:59:59'));
			$model->setState('filter.relative_date', $params->get('relative_date', 30));
		}
		// Display options
		$show_date = $params->get('show_date', 0);
		$show_date_field = $params->get('show_date_field', 'created');
		$show_date_format = $params->get('show_date_format', 'Y-m-d H:i:s');
		$show_category = $params->get('show_category', 0);
		$show_hits = $params->get('show_hits', 0);
		$show_author = $params->get('show_author', 0);
		$show_images = $params->get('show_images', 1);
		$show_introtext = $params->get('show_introtext', 0);
		$truncate_introtext = $params->get('truncate_introtext', 0);
		$introtext_limit = $params->get('introtext_limit', 100);
		$articles = $model->getItems();
		$html = new simple_html_dom();
		foreach ($articles as &$article) {
			$html->load($article->introtext);
			$article->slug = $article->id . ':' . $article->alias;
			$article->catslug = $article->catid ? $article->catid . ':' . $article->category_alias : $article->catid;
			if ($access || in_array($article->access, $authorised)) {
				$article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug));
			} else {
				$menu = $application->getMenu();
				$menuItems = $menu->getItems('link', 'index.php?option=com_users&view=login');
				if (isset($menuItems[0])) {
					$itemId = $menuItems[0]->id;
				} else if (JRequest::getInt('Itemid') > 0) {
					$itemId = JRequest::getInt('Itemid');
				}
				$article->link = JRequest::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
			}
			$article->date = '';
			if ($show_date) {
				$article->date = JHtml::_('date', $article->$show_date_field, $show_date_format);
			}
			if ($article->catid) {
				$article->categoryLink = JRoute::_(ContentHelperRoute::getCategoryRoute($article->catid));
				$article->cateogryTitle = $show_category ? '<a href="' . $article->categoryLink . '">' . $article->category_title . '</a>' : '';
			} else {
				$article->categoryTitle = $show_category ? $article->category_title : '';
			}
			if ($show_images) {
				$article->image = null;
				if (preg_match('/{video}(.*?){\/video}/', $article->introtext, $matches)) {
					$source = $matches[0];
					$width = $params->get('image_width');
					$height = $params->get('image_height');
					$article->image = new stdClass();
					$title = str_replace(array('"', '\''), '&quote;', $article->title);
					$article->image->title = $title;
					$article->image->src = self::_getVideoImage($source, $width, $height);
					$article->image->alt = $title;
				} else {
					$images = $html->find('img');
					if (count($images) > 0) {
						$image = $images[0];
						$article->image = new stdClass();
						$article->image->title = $image->title;
						$article->image->src = $image->src;
						$article->image->alt = $image->alt;
					}
				}
			}
			if ($show_introtext) {
				$article->introtext = JHtml::_('content.prepare', $article->introtext, '', 'mod_breaking_news.content');
				//$article->introtext = self::_cleanIntrotext($article->introtext);
			}
			$article->introtext = self::_removeCodes($article->introtext);
			if ($show_introtext) {
				if ($truncate_introtext && $introtext_limit > 0) {
					$article->introtext = self::truncate($article->introtext, $introtext_limit);					
				}
			} else {
				$article->introtext = '';
			}
			$article->related = null;
			if ($params->get('show_related')) {
				$pattern = '/{' . $params->get('related_keyword') . '(.*?)}/';
				if (preg_match('/{' . $params->get('related_keyword') . ' off}/', $article->fulltext)) {
					// Do not include related articles
				} else if (preg_match($pattern, $article->fulltext, $relatedMatch)) {
					$article->fulltext = preg_replace($pattern, '', $article->fulltext);
					$pattern = '/ids=("[^"]*")/';
					$tag = $relatedMatch[1];
					if (preg_match($pattern, $tag, $ids)) {
						$ids = explode(',', trim(str_replace('"', '', $ids[1])));
						$model->setState('filter.category_id', null);
						$model->setState('filter.featured', 'show');
						$model->setState('filter.date_filtering', 'off');
						$model->setState('filter.article_id', $ids);
						$article->related = $model->getItems();
						foreach ($article->related as &$related) {
							$related->link = JRoute::_(ContentHelperRoute::getArticleRoute($related->id . ':' . $related->alias, $related->catid));
						}
					}
				} else {
					$nullDate = $db->getNullDate();
					$date =& JFactory::getDate();
					$now = $date->toMySQL();
					$query = $db->getQuery(true);
					$query->select('metakey');
					$query->from('#__content');
					$query->where('id = ' . (int)$article->id);
					$db->setQuery($query);
					$metakey = $db->loadResult();
					if ($metakey) {
						$keywords = explode(',', $metakey);
						$likes = array();
						foreach ($keywords as $keyword) {
							$keyword = trim($keyword);
							if ($keyword) {
								$likes[] = $db->escape($keyword);
							}
						}
						if (count($likes)) {
							$query->clear();
							$query->select('a.id');
							$query->select('a.title');
							$query->select('DATE_FORMAT(a.created, "%Y-%m-%d") as created');
							$query->select('a.catid');
							$query->select('cc.access AS cat_access');
							$query->select('cc.published AS cat_state');
							
							//sqlsrv changes
							$case_when = ' CASE WHEN ';
							$case_when .= $query->charLength('a.alias');
							$case_when .= ' THEN ';
							$a_id = $query->castAsChar('a.id');
							$case_when .= $query->concatenate(array($a_id, 'a.alias'), ':');
							$case_when .= ' ELSE ';
							$case_when .= $a_id.' END as slug';
							$query->select($case_when);
							
							$case_when = ' CASE WHEN ';
							$case_when .= $query->charLength('cc.alias');
							$case_when .= ' THEN ';
							$c_id = $query->castAsChar('cc.id');
							$case_when .= $query->concatenate(array($c_id, 'cc.alias'), ':');
							$case_when .= ' ELSE ';
							$case_when .= $c_id.' END as catslug';
							$query->select($case_when);
							$query->from('#__content AS a');
							$query->leftJoin('#__content_frontpage AS f ON f.content_id = a.id');
							$query->leftJoin('#__categories AS cc ON cc.id = a.catid');
							$query->where('a.id != ' . (int) $article->id);
							$query->where('a.state = 1');
							$query->where('a.access IN (' . implode(',', $authorised) . ')');
							$concat_string = $query->concatenate(array('","', ' REPLACE(a.metakey, ", ", ",")', ' ","'));
							$query->where('('.$concat_string.' LIKE "%'.implode('%" OR '.$concat_string.' LIKE "%', $likes).'%")'); //remove single space after commas in keywords)
							$query->where('(a.publish_up = '.$db->quote($nullDate).' OR a.publish_up <= '.$db->quote($now).')');
							$query->where('(a.publish_down = '.$db->quote($nullDate).' OR a.publish_down >= '.$db->quote($now).')');
							
							// Filter by language
							if ($application->getLanguageFilter()) {
								$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
							}
							$query->order('a.publish_up DESC');
							$db->setQuery($query, 0, (int)$params->get('related_limit'));
							$qstring = $db->getQuery();
							$article->related = $db->loadObjectList();
							foreach ($article->related as &$related) {
								$related->link = JRoute::_(ContentHelperRoute::getArticleRoute($related->slug, $related->catid));
							}
						}
					}
				}
			}
		}
		return $articles;
	}
	private static function _getVideoImage($filename, $width, $height) {
		$filename = preg_replace(array('/{video}/', '/{\/video}/'), '', $filename);
		$image = 'images' . DS . 'previews' . DS . substr($filename, 0, strpos($filename, '.')) . '_' . $width . 'x' . $height . '.jpg';
		$path = JPATH_SITE . DS . dirname($image);
		if (file_exists($filename) && !file_exists($image)) {
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$width -= $width % 2;
			$height -= $height % 2;
			$command = 'ffmpeg -i ' . JPATH_SITE . DS . $filename . ' -vframes 1 -s ' . $width . 'x' . $height . ' ' . JPATH_SITE . DS . $image .  ' 2>&1';
			shell_exec($command);
		}
		return $image;
	}
	private static function _removeCodes($text) {
		// Remove video code
		$text = preg_replace('/{video}(.*?){\/video}/', '', $text);
		// Remove images
		$text = preg_replace('/<img[^\>]*>/', '', $text);
		// Remove <p>
		$text = preg_replace('/<p[^\>]*>/', '', $text);
		return $text;
	}
	private static function _cleanIntrotext($introtext) {
		$introtext = str_replace('</p>', '', $introtext);
		$introtext = strip_tags($introtext, '<a><em><strong>');
		$introtext = trim($introtext);
		return $introtext;
	}
	/**
	* This is a better truncate implementation than what we
	* currently have available in the library. In particular,
	* on index.php/Banners/Banners/site-map.html JHtml's truncate
	* method would only return "Article...". This implementation
	* was taken directly from the Stack Overflow thread referenced
	* below. It was then modified to return a string rather than
	* print out the output and made to use the relevant JString
	* methods.
	*
	* @link http://stackoverflow.com/questions/1193500/php-truncate-html-ignoring-tags
	* @param mixed $html
	* @param mixed $maxLength
	*/
	public static function truncate($html, $maxLength = 0)
	{
		$printedLength = 0;
		$position = 0;
		$tags = array();

		$output = '';

		if (empty($html)) {
			return $output;
		}

		while ($printedLength < $maxLength && preg_match('{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}', $html, $match, PREG_OFFSET_CAPTURE, $position))
		{
			list($tag, $tagPosition) = $match[0];

			// Print text leading up to the tag.
			$str = JString::substr($html, $position, $tagPosition - $position);
			if ($printedLength + JString::strlen($str) > $maxLength) {
				$output .= JString::substr($str, 0, $maxLength - $printedLength);
				$printedLength = $maxLength;
				break;
			}

			$output .= $str;
			$lastCharacterIsOpenBracket = (JString::substr($output, -1, 1) === '<');

			if ($lastCharacterIsOpenBracket) {
				$output = JString::substr($output, 0, JString::strlen($output) - 1);
			}

			$printedLength += JString::strlen($str);

			if ($tag[0] == '&') {
				// Handle the entity.
				$output .= $tag;
				$printedLength++;
			}
			else {
				// Handle the tag.
				$tagName = $match[1][0];

				if ($tag[1] == '/') {
					// This is a closing tag.
					$openingTag = array_pop($tags);

					$output .= $tag;
				}
				elseif ($tag[JString::strlen($tag) - 2] == '/') {
					// Self-closing tag.
					$output .= $tag;
				}
				else {
					// Opening tag.
					$output .= $tag;
					$tags[] = $tagName;
				}
			}

			// Continue after the tag.
			if ($lastCharacterIsOpenBracket) {
				$position = ($tagPosition - 1) + JString::strlen($tag);
			}
			else {
				$position = $tagPosition + JString::strlen($tag);
			}

		}

		// Print any remaining text.
		if ($printedLength < $maxLength && $position < JString::strlen($html)) {
			$output .= JString::substr($html, $position, $maxLength - $printedLength);
		}

		// Close any open tags.
		while (!empty($tags))
		{
			$output .= sprintf('</%s>', array_pop($tags));
		}

		$length = JString::strlen($output);
		$lastChar = JString::substr($output, ($length - 1), 1);
		$characterNumber = ord($lastChar);

		if ($characterNumber === 194) {
			$output = JString::substr($output, 0, JString::strlen($output) - 1);
		}

		$output = JString::rtrim($output);

		return $output.'&hellip;';
	}
}