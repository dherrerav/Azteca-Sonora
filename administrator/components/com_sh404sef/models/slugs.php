<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: slugs.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelSlugs {

  private static $_instance = null;
  private static $_articles = array();
  private static $_categories = array();

  /**
   * Singleton method
   *
   * @param string $extension extension name, with com_ - ie com_content
   * @return object instance of Sh404sefModelCategories
   */
  public static function getInstance() {

    if(is_null( self::$_instance)) {
      self::$_instance = new Sh404sefModelSlugs();
    }

    return self::$_instance;
  }


  public function getArticle( $id) {

    // sanitize input
    $id = intval($id);
    if(empty( $id)) {
      throw new Sh404sefExceptionDefault('Invalid article id passed to ' . __METHOD__ . ' in ' . __CLASS__, 500);
    }

    // already cached ?
    if(empty( self::$_articles[$id])) {
      // read details about the article
      $article = Sh404sefHelperDb::selectObject('#__content', array( 'id','title', 'alias', 'catid', 'language'), array('id' => $id));

      // if not found, that's bad
      if(empty( $article)) {
        throw new Sh404sefExceptionDefault('Non existing article id ('.$id.') passed to ' . __METHOD__ . ' in ' . __CLASS__, 500);
      }

      // store our cached record
      self::$_articles[$id][$article->language] = $article;
    }

    return self::$_articles[$id];
  }

  public function getArticleSlug( $id, $useAlias, $insertId, $insertIdCatList, $requestedLanguage = '*', $separator = '') {

    $rawArticle = $this->getArticle( $id);

    // select language
    $language = $requestedLanguage;
    if(empty($rawArticle[$language])) {
      $language = '*';
    }

    // must insert id ?
    $insertId = $this->_shouldInsertArticleId($insertId, $insertIdCatList, $rawArticle[$language]->catid);

    // build slug now
    $slug = '';
    if($insertId) {
      $separator = empty($separator) ? Sh404sefFactory::getConfig()->replacement : $separator;
      $slug = $id . $separator;
    }
    $slug .= $useAlias ? $rawArticle[$language]->alias : $rawArticle[$language]->title;

    return $slug;
  }

  protected function _shouldInsertArticleId( $insertId, $insertIdCatList, $catId) {

    if(empty( $insertId) || empty( $insertIdCatList) || empty( $catId)) {
      return false;
    }

    // we should insert id if article category is listed in the parameter
    $shouldInsert = in_array( $catId, $insertIdCatList);

    return $shouldInsert;
  }

  /**
   *
   * Get an object describing a category, for the
   * purpose of sh404SEF usage, for a Joomla! category
   *
   * @param string $extension extension for which category is searched
   * @param integer $id id of requested category
   * @throws Sh404sefExceptionDefault if invalid id
   */
  public function getCategory( $extension, $id) {

    // sanitize input
    $extension = strtolower( $extension);
    if(empty( $extension) || substr( $extension, 0, 4) !== 'com_') {
      throw new Sh404sefExceptionDefault('Invalid extension ('.$extension.') passed to ' . __METHOD__ . ' in ' . __CLASS__, 500);
    }
    $id = intval($id);
    if(empty( $id)) {
      throw new Sh404sefExceptionDefault('Invalid category id passed to ' . __METHOD__ . ' in ' . __CLASS__, 500);
    }

    // check if cached, create if not
    if(empty(self::$_categories[$extension]) || empty(self::$_categories[$extension][$id])){

      // get the Joomla! built category node
      jimport('joomla.application.categories');
      $options = array( 'access' => false, 'published' => 0);
      $categories = JCategories::getInstance( str_replace('com_', '', $extension), $options);

      // and ask for the category Joomla! object
      $node = $categories->get( $id);

      // no data? error
      if(empty( $node)) {
        throw new Sh404sefExceptionDefault('Non existing category id ('.$id.') passed to ' . __METHOD__ . ' in ' . __CLASS__, 500);
      }

      // we have an object, build our record
      $cat = new StdClass();
      $cat->id = $node->id;
      $cat->extension = $node->extension;
      $cat->title = $node->title;
      $cat->alias = $node->alias;
      $cat->language = $node->language;
      $cat->params = $node->params;
      $cat->metadesc = $node->metadesc;
      $cat->metakey = $node->metakey;
      $cat->metadata = $node->metadata;
      $cat->pathArray = $this->_buildCategoryRawNodePathArray( $node);

      self::$_categories[$extension][$id][$node->language] = $cat;
    }

    // do we now have the category? if not, throw Exception
    if(empty(self::$_categories[$extension]) || empty(self::$_categories[$extension][$id])) {
      throw new Sh404sefExceptionDefault('Non existing category id ('.$id.') passed to ' . __METHOD__ . ' in ' . __CLASS__, 500);
    }

    return self::$_categories[$extension][$id];

  }

  public function getCategoryPathArray( $extension, $id, $whichCat, $useAlias, $insertId, $requestedLanguage = '*', $separator = '') {

    // get full category data
    $rawCat = $this->getCategory( $extension, $id);

    // select language
    $language = $requestedLanguage;
    if(empty($rawCat[$language])) {
      $language = '*';
    }

    // break reference
    if(!empty($rawCat[$language])) {
      $copyCat = clone($rawCat[$language]);
    } else {
      throw new Sh404sefExceptionDefault('Language ('.$requestedLanguage.') not found in categories list, ' . __METHOD__ . ' in ' . __CLASS__, 500);
    }

    // only keep appropriate parts, according to request
    switch ($whichCat) {
      case shSEFConfig::CAT_ALL_NESTED_CAT:
        $pathArray = $copyCat->pathArray;
        break;
      case shSEFConfig::CAT_NONE:
        $pathArray = array();
        break;
      case shSEFConfig::CAT_FIRST:
        $pathArray = array(array_shift($copyCat->pathArray));
        break;
      case shSEFConfig::CAT_LAST:
        $pathArray = array(array_pop( $copyCat->pathArray));
        break;
      case shSEFConfig::CAT_2_FIRST:
        $pathArray = $copyCat->pathArray;
        while (count($pathArray) > 2) {
          array_pop( $pathArray);
        }
        break;
      case shSEFConfig::CAT_2_LAST:
        $pathArray = $copyCat->pathArray;
        while (count($pathArray) > 2) {
          array_shift( $pathArray);
        }
        break;
      default:
        throw new Sh404sefExceptionDefault('Invalid configuration option ('.print_r($id).') passed to ' . __METHOD__ . ' in ' . __CLASS__, 500);;
        break;
    }
    // build slug, according to request
    foreach( $pathArray as $key => $value) {
      $pathArray[$key]->slug = $useAlias ? $pathArray[$key]->alias : $pathArray[$key]->title;
      if($insertId) {
        $separator = empty($separator) ? Sh404sefFactory::getConfig()->replacement : $separator;
        $pathArray[$key]->slug = $pathArray[$key]->id . $separator . $pathArray[$key]->slug;
      }
    }

    // return formatted Path
    return empty($pathArray) ? array() : $pathArray;
  }

  public function getCategorySlugArray( $extension, $id, $whichCat, $useAlias, $insertId, $uncategorizedPath = '', $requestedLanguage = '*', $separator = '') {

    // special case for the "uncategorised" category
    $unCat = Sh404sefHelperCategories::getUncategorizedCat( $extension);
    if( !empty( $unCat) && $id == $unCat->id) {
      $slugArray = empty( $uncategorizedPath) ? array() : array( $uncategorizedPath);
      return $slugArray;
    }

    // regular category, build the path to the cat
    $separator = empty($separator) ? Sh404sefFactory::getConfig()->replacement : $separator;
    $pathArray = $this->getCategoryPathArray( $extension, $id, $whichCat, $useAlias, $insertId, $requestedLanguage, $separator);

    $slugArray = array();
    foreach( $pathArray as $catObject) {
      $slugArray[] = $catObject->slug;
    }

    return $slugArray;
  }

  /**
   *
   * Build an array holding the various path items
   * for a given category, as descrobed by a JCategoryNode object
   * complying with general SEF url generation parameters
   *
   * @param JCategoryNode object $node the category node
   */
  private function _buildCategoryRawNodePathArray( $node) {

    // holds result
    $pathArray = array();

    // iterate over node parent cats
    $safer = 0;
    do {
      $tmp = new stdClass();
      $tmp->id = $node->id;
      $tmp->title = $node->title;
      $tmp->alias = $node->alias;
      $tmp->slug = '';
      $pathArray[] = $tmp;
      $node = $node->getParent();
      $isRoot = empty( $node) || $node->id == 'root';
      $safer++;
    } while (!$isRoot && $safer < 20);

    // get first things first
    $pathArray = array_reverse($pathArray);

    // process rules for building the category url path


    // return final array
    return $pathArray;
  }

}