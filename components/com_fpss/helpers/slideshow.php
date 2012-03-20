<?php
/**
 * @version		$Id: controller.php 307 2011-06-17 15:50:47Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_fpss'.DS.'models');

class FPSSHelperSlideshow {

	function render($params, $context = 'component', $moduleID = 0){
		$mainframe = &JFactory::getApplication();
		// Load the module language
		$language = &JFactory::getLanguage();
		$language->load('mod_fpss');
		// Load head data
		FPSSHelperSlideshow::loadHeadData($params, $context, $moduleID);
		// Get the slides
		if($context == 'module' && $params->get('fpssCache') && $mainframe->getCfg('caching')){
			jimport('joomla.html.parameter');
			$cache = &JFactory::getCache('mod_fpss');
			$cache->setLifeTime($params->get('cache_time', 900));
			$slides = $cache->call(array('FPSSHelperSlideshow', 'getSlides'), $params);
		}
		else {
			$slides = FPSSHelperSlideshow::getSlides($params);
		}

		return $slides;
	}

	function getSlides($params) {

		$user = &JFactory::getUser();
		$date = &JFactory::getDate();
		$now = $date->toMySQL();
		$language = &JFactory::getLanguage();

		switch($params->get('ordering', 'reverseId')){

			case 'order':
				$ordering = 'ordering';
				$orderingDir = 'ASC';
				break;

			case 'featuredOrder':
				$ordering = 'featured_ordering';
				$orderingDir = 'ASC';
				break;

			case 'reverseId':
				$ordering = 'id';
				$orderingDir = 'DESC';
				break;

			case 'id':
				$ordering = 'id';
				$orderingDir = 'ASC';
				break;

			case 'title':
				$ordering = 'title';
				$orderingDir = 'ASC';
				break;

			case 'reverseTitle':
				$ordering = 'title';
				$orderingDir = 'DESC';
				break;

			case 'hits':
				$ordering = 'hits';
				$orderingDir = 'DESC';
				break;

			case 'random':
				$ordering = 'RAND()';
				$orderingDir = '';
				break;
		}
		$model = &JModel::getInstance('slides', 'FPSSModel');
		$model->setState('limit', (int)$params->get('limit', 0));
		$model->setState('limitstart', 0);
		$model->setState('ordering', $ordering);
		$model->setState('orderingDir', $orderingDir);
		$model->setState('published', 1);
		$model->setState('featured', $params->get('featured', -1));
		$model->setState('catid', $params->get('catid'));
		$model->setState('access', (version_compare( JVERSION, '1.6.0', 'ge' ))? $user->authorisedLevels(): $user->get('aid'));
		$model->setState('featured', $params->get('featured', -1));
		$model->setState('categoryPublished', 1);
		$model->setState('language', $language->getTag());
		$model->setState('publish_up', $now);
		$model->setState('publish_down', $now);
		$slides = $model->getData();
		$model = &JModel::getInstance('slide', 'FPSSModel');
		if(count($slides)){
			jimport('joomla.html.parameter');
			for ($i = 0; $i < sizeof($slides); $i++) {
				$model->getSlideImages($slides[$i]);
				$categoryParams = new JParameter($slides[$i]->categoryParams);
				$slideParams = new JParameter($slides[$i]->params);
				$contextParams = new JParameter($params->toString());
				$categoryParams->merge($slideParams);
				$categoryParams->merge($contextParams);
				$slides[$i]->params = $categoryParams;
				$slides[$i] = FPSSHelperSlideshow::prepareSlide($slides[$i], $params);
				$slides[$i]->counter = $i+1;
				if($slides[$i]->counter<10) $slides[$i]->counter = "0".$slides[$i]->counter;
				if(!$slides[$i]->params->get('title') && !$slides[$i]->params->get('category') && !$slides[$i]->params->get('text') && !$slides[$i]->params->get('tagline') && !$slides[$i]->params->get('readmore')) {
					$slides[$i]->content = false;
				}
				else {
					$slides[$i]->content = true;
				}
			}
		}
		return $slides;
	}


	function prepareSlide($slide, $params){

		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$aid = $user->get('aid');
		$jnow = &JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();
		$type = $slide->referenceType;
		$id = $slide->referenceID;
		$componentParams = &JComponentHelper::getParams('com_fpss');
		$slide->category = false;

		switch($type){

			case 'com_content':
				if(version_compare( JVERSION, '1.6.0', 'ge' )) {
					$query = "SELECT article.title, article.introtext, article.catid, article.alias, category.title AS categoryName, category.alias AS categoryAlias
					FROM #__content AS article
					INNER JOIN #__categories AS category ON article.catid = category.id
					WHERE article.id = {$id}
					AND article.state = 1
					AND article.access IN(".implode(',', $user->authorisedLevels()).")
					AND ( article.publish_up = ".$db->Quote($nullDate)." OR article.publish_up <= ".$db->Quote($now)." )
					AND ( article.publish_down = ".$db->Quote($nullDate)." OR article.publish_down >= ".$db->Quote($now)." )
					AND category.published = 1
					AND category.access IN(".implode(',', $user->authorisedLevels()).")";
				}
				else {
					$query = "SELECT article.title, article.introtext, article.catid, article.alias, category.title AS categoryName, category.alias AS categoryAlias
					FROM #__content AS article
					INNER JOIN #__categories AS category ON article.catid = category.id
					INNER JOIN #__sections AS section ON article.sectionid = section.id
					WHERE article.id = {$id}
					AND article.state = 1
					AND article.access <= {$aid}
					AND ( article.publish_up = ".$db->Quote($nullDate)." OR article.publish_up <= ".$db->Quote($now)." )
					AND ( article.publish_down = ".$db->Quote($nullDate)." OR article.publish_down >= ".$db->Quote($now)." )
					AND section.published = 1
					AND section.access <= {$aid}
					AND category.published = 1
					AND category.access <= {$aid}";
				}

				$db->setQuery($query);
				$row = $db->loadObject();
				if(!is_null($row)){
					if($slide->params->get('liveData')){
						$slide->title = $row->title;
						$slide->text = $row->introtext;
					}
					$slide->category = $row->categoryName;
					$slide->referenceAlias = $row->alias;
					$slide->referenceCategoryID = $row->catid;
					$slide->referenceCategoryAlias = $row->categoryAlias;
					$slide->referenceSectionID = $row->categoryAlias;
				}
				break;

			case 'com_menus':
				$slide->category = '';
				if($slide->params->get('liveData')){
					$menu = &JSite::getMenu();
					$menuItem = $menu->getItem($slide->referenceID);
					if($menuItem) $slide->title = (version_compare( JVERSION, '1.6.0', 'ge' )) ? $menuItem->title : $menuItem->name;
				}
				break;

			case 'com_k2':
				$query = "SELECT item.title, item.introtext, item.catid, item.alias, category.name AS categoryName, category.alias AS categoryAlias
				FROM #__k2_items AS item
				INNER JOIN #__k2_categories AS category ON item.catid = category.id
				WHERE item.id = {$id}
				AND item.published = 1";
				if(version_compare( JVERSION, '1.6.0', 'ge' )){
					$query .= " AND item.access IN(".implode(',', $user->authorisedLevels()).") ";
				}
				else {
					$query .= " AND item.access <= {$aid} ";
				}
				$query .= "AND item.trash = 0
				AND category.published = 1";
				if(version_compare( JVERSION, '1.6.0', 'ge' )){
					$query .= " AND category.access IN(".implode(',', $user->authorisedLevels()).") ";
				}
				else {
					$query .= " AND category.access <= {$aid} ";
				}
				$query .= "AND category.trash = 0";
				$db->setQuery($query);
				$row = $db->loadObject();
				if(!is_null($row)){
					if($slide->params->get('liveData')){
						$slide->title = $row->title;
						$slide->text = $row->introtext;
					}
					$slide->category = $row->categoryName;
					$slide->referenceAlias = $row->alias;
					$slide->referenceCategoryID = $row->catid;
					$slide->referenceCategoryAlias = $row->categoryAlias;
					$slide->referenceSectionID = $row->categoryAlias;
				}
				break;

			case 'com_virtuemart':
				if( JFile::exists(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' )) {
					require_once( JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' );
					$vmDb = new ps_DB;
					$query = "SELECT product.product_name, product.product_desc, category.category_id, category.category_name AS categoryName
					FROM #__{vm}_product AS product
					INNER JOIN #__{vm}_product_category_xref AS xref ON product.product_id = xref.product_id
					INNER JOIN #__{vm}_category AS category ON xref.category_id = category.category_id
					WHERE product.product_id={$id}
					AND product.product_publish = 'Y'
					AND category.category_publish = 'Y'";
					$vmDb->setQuery($query);
					$row = $vmDb->loadObject($row);

				}
				else {
					$query = "SELECT product.product_name, product.product_desc, category.category_id, category.category_name AS categoryName
					FROM #__vm_product AS product
					INNER JOIN #__vm_product_category_xref AS xref ON product.product_id = xref.product_id
					INNER JOIN #__vm_category AS category ON xref.category_id = category.category_id
					WHERE product.product_id={$id}
					AND product.published = 1
					AND category.published = 1";
					$db->setQuery($query);
					$row = $db->loadObject();
				}

				if(!is_null($row)){
					if($slide->params->get('liveData')){
						$slide->title = $row->product_name;
						$slide->text = $row->product_desc;
					}
					$slide->category = $row->categoryName;
					$slide->referenceCategoryID = $row->category_id;
				}
				break;

			case 'com_redshop':

				$query = "SELECT p.*, c.category_id, c.category_name ,c.category_back_full_image,c.category_full_image , m.manufacturer_name,pcx.ordering FROM #__redshop_product AS p
            	LEFT JOIN #__redshop_product_category_xref AS pcx ON pcx.product_id = p.product_id
            	LEFT JOIN #__redshop_manufacturer AS m ON m.manufacturer_id = p.manufacturer_id
            	LEFT JOIN #__redshop_category AS c ON c.category_id = pcx.category_id
            	WHERE p.product_id = {$id}";
				$db->setQuery($query, 0, 1);
				$row = $db->loadObject();
				if(!is_null($row)){
					if($slide->params->get('liveData')){
						$slide->title = $row->product_name;
						$slide->text = $row->product_s_desc;
					}
					$slide->category = $row->category_name;
					$slide->referenceCategoryID = $row->category_id;
				}
				break;

			case 'com_tienda':
				JLoader::register('Tienda', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'defines.php');
				Tienda::load('TiendaHelperBase', 'helpers._base');
				$categoryHelper = &TiendaHelperBase::getInstance('Category');
				$productHelper = &TiendaHelperBase::getInstance('Product');
				$row = $productHelper->load($id);
				if(!is_null($row)){
					if($slide->params->get('liveData')){
						$slide->title = $row->product_name;
						$slide->text = $row->product_description_short;
					}
					$row->categories = array();
					$categories = $productHelper->getCategories($row->product_id);
					foreach($categories as $category){
						$row->categories[] = $categoryHelper->getPathName($category);
					}
					if(count($row->categories)){
						$slide->category = $row->categories[0];
						$slide->referenceCategoryID = $categories[0];
					}

				}
				break;

			case 'custom':
				$slide->category = '';
				break;

		}
		
		// Slide title used in title/alt attributes
		$slide->altTitle = htmlentities($slide->title, ENT_QUOTES, 'UTF-8');

		// Get the author
		$author = &JFactory::getUser($slide->created_by);
		$slide->author = $author->name;


		// Check if the original image should be used instead of the resized one
		if($slide->params->get('useOriginal')) {
			$slide->mainImage = $slide->srcImage;
		}

		JFilterOutput::objectHTMLSafe($slide->title);
		
		if($params->get('disableLinks')){
			$slide->link = "javascript:void(0)";
		}
		else {
			$link = FPSSHelperSlideshow::getSlideLink($slide);
			if($componentParams->get('stats')){
				$link = JString::str_ireplace('&amp;', '&', $link);
				$link = base64_encode($link);
				$slide->link = JRoute::_('index.php?option=com_fpss&task=track&id='.$slide->id.'&url='.$link);
			}
			else {
				$slide->link = $link;
			}
		}

		if($slide->params->get('target')=='_blank'){
			$slide->target = ' target="_blank"';
		}
		else{
			$slide->target = '';
		}

		if($params->get('enableSenchaSrc')) {
			$slide->mainImage = 'http://src.sencha.io/'.$params->get('width').'/'.JURI::root().'media/com_fpss/cache/'.$slide->id.'_'.md5('Image'.$slide->id).'_m.jpg';
		}

		if($slide->params->get('wordLimit')){
			$slide->text = FPSSHelperSlideshow::wordLimiter($slide->text, (int)$slide->params->get('wordLimit'));
		}

		return $slide;

	}

	function getSlideLink($slide){

		jimport('joomla.filesystem.file');
		$type = $slide->referenceType;
		$link = '#';

		switch($type){

			case 'com_content':
				if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php')){
					JLoader::register('ContentHelperRoute', JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
					$link = JRoute::_(ContentHelperRoute::getArticleRoute($slide->referenceID.':'.$slide->referenceAlias, $slide->referenceCategoryID.':'.$slide->referenceCategoryAlias, $slide->referenceSectionID));
				}
				else {
					$link = JRoute::_('index.php?option=com_content&view=article&id='.$slide->referenceID.'&catid='.$slide->referenceCategoryID);
				}
				break;

			case 'com_menus':
				$menu = &JSite::getMenu();
				$menuItem = $menu->getItem($slide->referenceID);
				if(!is_null($menuItem))
				if($menuItem->type=='url'){
					$link = JRoute::_($menuItem->link);
				} else {
					$link = JRoute::_($menuItem->link.'&Itemid='.$menuItem->id);
				}
				break;

			case 'com_k2':
				if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php')){
					JLoader::register('K2HelperRoute', JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
					$link = JRoute::_(K2HelperRoute::getItemRoute($slide->referenceID.':'.urlencode($slide->referenceAlias),$slide->referenceCategoryID.':'.urlencode($slide->referenceCategoryAlias)));
				}
				else {
					$link = JRoute::_('index.php?option=com_k2&view=item&id='.$slide->referenceID);
				}
				break;

			case 'com_virtuemart':

				if( JFile::exists(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' )) {
					require_once( JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' );
					require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_product.php';
					global $sess, $mm_action_url;
					$ps_product = new ps_product;
					$flypage = $ps_product->get_flypage($slide->referenceID);
					$url = '?page=shop.product_details&flypage='.$flypage.'&product_id='.$slide->referenceID.'&category_id='.$slide->referenceCategoryID.'&option=com_virtuemart';
					$link = $sess->url($mm_action_url . "index.php" . $url);
				}
				else {
					$link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&product_id='.$slide->referenceID.'&category_id='.$slide->referenceCategoryID);
				}

				break;

			case 'com_redshop':
				JLoader::register('redhelper', JPATH_SITE.DS.'components'.DS.'com_redshop'.DS.'helpers'.DS.'helper.php');
				$redhelper = new redhelper();
				$Itemid = $redhelper->getItemid($slide->referenceID);
				$link = JRoute::_ ('index.php?option=com_redshop&view=product&pid='.$slide->referenceID.'&cid='.$slide->referenceCategoryID.'&Itemid='.$Itemid );
				break;

			case 'com_tienda':
				JLoader::register('Tienda', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'defines.php');
				$link = JRoute::_(Tienda::getClass('TiendaHelperRoute', 'helpers.route')->product($slide->referenceID, $slide->referenceCategoryID));
				break;

			case 'custom':
				$link = $slide->custom;
				break;
		}

		return $link;

	}

	function wordLimiter($str, $limit = 100, $end_char = '&#8230;') {
		if (trim($str) == '') return $str;
		preg_match('/\s*(?:\S*\s*){'. (int) $limit .'}/', $str, $matches);
		if (strlen($matches[0]) == strlen($str)) $end_char = '';
		return rtrim(strip_tags($matches[0])).$end_char;
	}

	function setCrd(){
		return base64_decode("PGRpdiBzdHlsZT0iZGlzcGxheTpub25lOyI+RnJvbnRwYWdlIFNsaWRlc2hvdyB8IENvcHlyaWdodCAmY29weTsgMjAwNi0yMDExIEpvb21sYVdvcmtzIEx0ZC48L2Rpdj4=");
	}

	function loadHeadData(&$params, $context = 'component', $moduleID = 0){

		$document = &JFactory::getDocument();

		if(version_compare(JVERSION,'1.6.0','ge')) {
			JHtml::_('behavior.framework');
		} else {
			JHTML::_('behavior.mootools');
		}

		// JS
		$jQueryHandling = $params->get('jQueryHandling','1.6remote');
		if($jQueryHandling && strpos($jQueryHandling,'remote')==true){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.str_replace('remote','',$jQueryHandling).'/jquery.min.js');
		} elseif($jQueryHandling && strpos($jQueryHandling,'remote')==false) {
			$document->addScript(JURI::root(true).'/modules/mod_fpss/includes/jquery/jquery-'.$jQueryHandling.'.min.js');
		}
		$document->addScript(JURI::root(true).'/modules/mod_fpss/includes/js/jquery.fpss.js');

		// HTML
		jimport('joomla.filesystem.file');
		$mainframe = &JFactory::getApplication();
		if(JFile::exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'mod_fpss'.DS.$params->get('template').DS.'default.php')) {
			$cssPath = JURI::root(true).'/templates/'.$mainframe->getTemplate().'/html/mod_fpss/'.$params->get('template').'/css/';
			$cssFilePath = JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'mod_fpss'.DS.$params->get('template').DS.'css';
		} else {
			$cssPath = JURI::root(true).'/modules/mod_fpss/tmpl/'.$params->get('template').'/css/';
			$cssFilePath = JPATH_SITE.DS.'modules'.DS.'mod_fpss'.DS.'tmpl'.DS.$params->get('template').DS.'css';
		}

		// CSS
		if($params->get('fpssCssInclusionMethod')) {
			ob_start();
			$fpssTemplateIncluded = true;
			$width = (int)$params->get('width', 500);
			$height = (int)$params->get('height', 308);
			$sidebarWidth = (int)$params->get('sidebarWidth', 200);
	    $thumbnailViewportWidth = (int)$params->get('thumbnailViewportWidth', 100);
	    $thumbnailViewportHeight = (int)$params->get('thumbnailViewportHeight', 50);
	    $timer = (int)$params->get('timer', 1);
			include($cssFilePath.DS.'template.css.php');
			$css = ob_get_contents();
			ob_end_clean();

			$css = "\n".str_replace('url(../images/','url('.JURI::root(true).'/modules/mod_fpss/tmpl/'.$params->get('template').'/images/',$css)."\n";
			$document->addStyleDeclaration($css);
		} else {
			$document->addStyleSheet($cssPath.'template.css.php?width='.$params->get('width', 500).'&height='.$params->get('height', 308).'&sidebarWidth='.$params->get('sidebarWidth', 200).'&timer='.(int)$params->get('timer', 1).'&thumbnailViewportWidth='.$params->get('thumbnailViewportWidth', 100).'&thumbnailViewportHeight='.$params->get('thumbnailViewportHeight', 50).'&mid='.$moduleID);
		}

		// JS
		$js = "
		/* Frontpage Slideshow v3.0.1 */
		jQuery(document).ready(function(){
			\$FPSS('#fpssContainer".$moduleID."').fpss( {
				autoStart: ".(int)$params->get('autoStart', 1).",
				transitionTime: ".$params->get('transitionTime', 1000).",
				interval: ".$params->get('interval', 6000).",
				timer: ".(int)$params->get('timer', 1).",
				effect: '".$params->get('effect', 'crossfade')."',
				event: '".$params->get('event', 'click')."',
				textEffect: ".(int)$params->get('textEffect', 1).",
				lavalamp: ".(int)$params->get('lavalamp', 1).",
				playLabel: '".JText::_('FPSS_PLAY', true)."',
				pauseLabel: '".JText::_('FPSS_PAUSE', true)."'
			});
		});
		";
		$document->addScriptDeclaration($js);
	}

}