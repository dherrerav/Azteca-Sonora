<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: pageids.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelPageids extends Sh404sefClassBaselistModel {

  protected $_context = 'sh404sef.pageids';
  protected $_defaultTable = 'pageids';


  // base char set for creating shurls
  protected static $_regular    = 'pk3ax9wu68d4hqrfyc';
  protected static $_alternate  = '7bzeg';
  // these words will not be accepted as shURL
  // note that
  // i, j, l, m, n, o, s, t, v and 0, 1 and 5
  // are not used either in regular or alternate
  // character set, so ass, sex, cul, pet and many more
  // need not be listed here
  protected static $_badWords = array( 'fuck');

  protected static $_mustCreate = false;

  /**
   * Returns true if current sef url being created can have a shURL
   * Can be set from within a plugin, otherwise default to false
   * Reset to false upon each creation of a new sef url in shInitializePlugin()
   *
   * @param unknown_type $action
   * @param unknown_type $value
   * @return unknown
   */
  public function mustCreatePageId( $action = 'get', $value = false) {

    if ($action == 'set') {
      self::$_mustCreate = (boolean) $value;
    }

    return self::$_mustCreate;
  }

  public function createPageId( $sefUrl, $nonSefUrl) {

    $shURL = '';

    if (!$this->_mustCreatePageid( $nonSefUrl)) {
      return $shURL;
    }

    jimport( 'joomla.utilities.string');
    $sefUrl = JString::ltrim( $sefUrl, '/');

    try {
      if( !empty( $sefUrl)) {
      // check that we don't already have a shURL for the same SEF url, even if non-sef differ
      $result = (int) Sh404sefHelperDb::count( '#__sh404sef_urls', '*', $this->_db->nameQuote('oldurl') . ' = ? and ' . $this->_db->nameQuote('newurl') . ' <> ?', array( $sefUrl, ''));
      
    if (!empty($result) && $result > 1) {
        // we already have a SEF URL, so we must already have a shURL as well
          return $shURL;
        }
    }

      // check this nonsef url does not already have a shURL
      $existingShurl = Sh404sefHelperDb::selectResult('#__sh404sef_pageids', 'pageid', array( 'newurl' => $nonSefUrl));
      // there already is a shurl for the same non-sef
      if (!empty( $existingShurl)) {
        return $existingShurl;
    }

      // if we don't already have a shURL, create the new one
      $shURL = $this->_buildPageId();
      if (!empty( $shURL)) {

      // insert in db
        Sh404sefHelperDb::insert( '#__sh404sef_pageids', array('newurl' => $nonSefUrl, 'pageid' => $shURL, 'type' => Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID, 'hits' => 0));
    }
    } catch (Sh404sefExceptionDefault $e) {
      _log( 'DB error creating pageId ' . $e->getMessage());

    }
    // don't need to add the pageid to cache, won't be needed when building up the page,
    //only when decoding incoming url
    return $shURL;
  }

  /**
   * Count pageids records
   * either all of them or the currently selected set
   * as per user filter settings in meta manager
   *
   * @param string $type either 'all' or 'selected'
   */
  public function getPageIdsCount( $type) {

    switch (strtolower( $type)) {

      // we want to read all automatic urls (include duplicates)
      case 'all':
        $numberOfPageids = 0;
        try {
          $numberOfPageids = Sh404sefHelperDb::count( $this->_getTableName(), '*');
        } catch (Sh404sefExceptionDefault $e) {
        }
        break;

        // we want to read urls as per current selection input fields
        // ie : component, language, custom, ...
      case 'selected':
        // get model and update context with current
        $model = &JModel::getInstance( 'urls', 'Sh404sefModel');

        // use current filters for default layout of metas manager
        $context = $model->setContext( $this->_context . '.' . 'default');

        // display type: simple for very large sites/slow slq servers
        $sefConfig = & Sh404sefFactory::getConfig();

        // read url data from model
        $list = &$model->getList( (object) array('layout' => 'default', 'getPageId' => true, 'simpleUrlList' => true, 'slowServer' => $sefConfig->slowServer));

        $numberOfPageids = 0;
        // just count urls with some pageids
        if (!empty($list)) {
          foreach ($list as $urlRecord) {
            if (!empty( $urlRecord->pageid)) {
              $numberOfPageids++;
            }
          }
        }
        break;

      default:
        $numberOfPageids = 0;
        break;
    }

    return intval( $numberOfPageids);
  }

  /**
   * Delete a list of pagesids from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of shURL id to delete
   */
  public function deleteByIds( $ids = array()) {

    if (empty($ids)) {
      return false;
    }

    // perform deletion
    try {
      Sh404sefHelperDb::deleteIn( $this->_getTableName(), 'id', $ids, Sh404sefHelperDb::INTEGER);
    } catch (Sh404sefExceptionDefault $e) {
      $this->setError( 'Internal database error # ' . $e->getMessage());
      return false;
    }

    return true;
  }

  /**
   * Purge shURL records from the database
   * either all of them or the currently selected set
   * as per user filter settings in meta manager
   *
   * @param string $type either 'all' or 'selected'
   */
  public function purgePageids( $type) {

    // make sure we use latest user state
    $this->_updateContextData();

    // call the appropriate sub-method to get the db query
    $methodName = '_getPurgeQuery' . ucfirst($type);
    if (is_callable( array( $this, $methodName))) {
      $deleteQuery = $this->$methodName();
    } else {
      $this->setError( 'Invalid method call _purge' . $type);
      return;
    }

    // then run the query
    if (!empty( $deleteQuery)) {
      // perform deletion
      try {
        Sh404sefHelperDb::query( $deleteQuery);
      } catch (Sh404sefExceptionDefault $e) {
        $this->setError( 'Internal database error # ' . $e->getMessage());
      }
      // reset limit and limitstart variables, to avoid
      // issue when displaying again results
      $this->_setState( 'limitstart', 0);
      $this->_setState( 'limit', 0);
    } else {
      $this->setError( JText::_('COM_SH404SEF_NORECORDS'));
    }

  }

  /**
   * Delete all automatically generated url records
   * from database and cache
   */
  private function _getPurgeQueryAll() {

    // delete from database
    $query = 'truncate ' . $this->_db->nameQuote( $this->_getTableName());

    return $query;
  }

  private function _getPurgeQuerySelected() {

    // get model and update context with current
    $model = &JModel::getInstance( 'urls', 'Sh404sefModel');

    // use current filters for default layout of shURLs manager
    $context = $model->updateContext( $this->_context . '.' . 'default');

    // read url data from model
    $list = &$model->getList( (object) array('layout' => 'default', 'getPageId' => true));

    $shURLs = array();
    // store meta data records ids for urls with some metat data
    if (!empty($list)) {
      foreach ($list as $urlRecord) {
        $shURLs[] = $this->_db->Quote($urlRecord->pageid,true);
      }
    }

    // if no urls with shURL data, return empty query
    if (empty( $shURLs)) {
      return '';
    }

    // start delete query
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName());

    // call method to build where clause in accordance to current settings and user selection
    $where = implode( ', ', $shURLs);

    // stitch where clause
    $query = $query . ' where pageid in (' . $where . ')';

    return $query;
  }


  protected function _buildListWhere( $options) {

    // array to hold where clause parts
    $where = array();

    // are we reading pageids for one specific url ?
    $newurl = $this->_getOption( 'newurl', $options);
    if (!is_null( $newurl)) {
      $where[] = 'newurl = ' . $this->_db->Quote( $newurl);
      $where[] = 'type = ' . $this->_db->Quote( Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID);
    }

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }

  protected function _buildListOrderBy( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // build query fragment
    $orderBy  = ' order by ' . $this->_db->nameQuote( 'newurl');
    $orderBy .=  ' ' . $filters->filter_order_Dir;

    return $orderBy;
  }

  protected function _getTableName() {

    return '#__sh404sef_pageids';

  }

  private function _buildPageId() {

    $shURL = '';

    $nextId = $this->_getNextDBId( '#__sh404sef_pageids');
    if ($nextId !== false) {
      $nextId = base_convert( 18+$nextId, 10, 18);
      for ($c = 0; $c < strlen($nextId); ++$c) {
        $char = base_convert($nextId{$c}, 18, 10);
        $shURL .= self::$_regular{$char};
      }
    }

    // now check if this shurl is not an existing
    // SEF or alias. If so, use the alternate char set
    // to create a new shurl, and try again.
    // using alternate char set (instead of simply increasing nextId)
    // makes sure that next time we try to create a shurl (for next URL)
    // we won't try something we've already used, making the number of attempts
    // for each shurl creation grows each time there is a collision
    try {
      $attempts = 0;
      $maxAttempts = 8;
      // don't need to check for collisions with existing shurls
      // as we use the next insert id, and code that using a unique char set
      //however, if we need to modify the shurl because it collides with
      // an existing SEF url or an alias, we will do so using the alternate
      // character set, so the new shurl don't risk collision with a regular
      // shurl but it may then collide with another, previously modified shurl
      // and so we need to check for shurl collisions when this happens
      $doneShurl = true;
      // however, need to check for collisions with regular sef urls and aliases
      $doneSef = false;
      $doneAlias = false;
      // and for bad language
      $doneClean = false;
      // prepare user set bad language/exclusion list
      $sefConfig = &Sh404sefFactory::getConfig();
      $sefConfig->shurlBlackList = JString::trim( $sefConfig->shurlBlackList);
      if(empty( $sefConfig->shurlBlackList)) {
        $blackList = array();
      } else if(strpos( $sefConfig->shurlBlackList, '|') !== false) {
        $blackList = explode('|', $sefConfig->shurlBlackList);
      } else {
        $blackList = array( $sefConfig->shurlBlackList);
      }
      $doneBlackList = false;
      do {

        // clean word check
        if(!$doneClean) {
          if( in_array( $shURL, self::$_badWords)) {
            // bad language
            $attempts++;
            // build a new shurl, by changing a character
            // with one from the alternate set
            $shURL = $this->_getModifiedShurl( $shURL);

            // invalidate shurl and alias check flag, to check again with this new shurl
            $doneShurl = false;
            $doneAlias = false;
            $doneSef = false;
            $doneBlackList = false;
          } else {
            $doneClean = true;
          }
        }

        // user word black list
        if(!$doneBlackList) {
          if( in_array( $shURL, $blackList)) {
            // bad language
            $attempts++;
            // build a new shurl, by changing a character
            // with one from the alternate set
            $shURL = $this->_getModifiedShurl( $shURL);

            // invalidate shurl and alias check flag, to check again with this new shurl
            $doneShurl = false;
            $doneAlias = false;
            $doneSef = false;
            $doneClean = false;
          } else {
            $doneBlackList = true;
          }
        }

        // regular SEF url collision check
        if(!$doneSef) {
          $isSEF = (int) Sh404sefHelperDb::count( '#__redirection', '*', $this->_db->nameQuote('oldurl') . ' = ? and ' . $this->_db->nameQuote('newurl') . ' <> ?', array( $shURL, ''));
          if( !empty( $isSEF)) {
            // there is already a SEF url like that
            $attempts++;
            // build a new shurl, by changing a character
            // with one from the alternate set
            $shURL = $this->_getModifiedShurl( $shURL);

            // invalidate shurl and alias check flag, to check again with this new shurl
            $doneShurl = false;
            $doneAlias = false;
            $doneClean = false;
            $doneBlackList = false;
          } else {
            $doneSef = true;
          }
    }

        // previous shurl check
        if(!$doneShurl) {
          $isShurl = (int) Sh404sefHelperDb::count( '#__sh404sef_pageids', '*', array( 'pageid' => $shURL, 'type' => Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID));
          if( !empty( $isShurl)) {
            // there is already a shurl like that
            $attempts++;
            // build a new shurl, by changing a character
            // with one from the alternate set
            $shURL = $this->_getModifiedShurl( $shURL);

            // invalidate regular sef and alias check flag, to check again with this new shurl
            $doneSef = false;
            $doneAlias = false;
            $doneClean = false;
            $doneBlackList = false;
          } else {
            $doneShurl = true;
          }
  }

        // alias collision check
        if(!$doneAlias) {
          $isAlias = (int) Sh404sefHelperDb::count( '#__sh404sef_aliases', '*', array( 'alias' => $shURL, 'type' => Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS));
          if( !empty( $isAlias)) {
            // there is already an alias like that
            $attempts++;
            // build a new shurl, by changing a character
            // with one from the alternate set
            $shURL = $this->_getModifiedShurl( $shURL);

            // invalidate regular sef and shurl check flag, to check again with this new shurl
            $doneSef = false;
            $doneShurl = false;
            $doneClean = false;
            $doneBlackList = false;
          } else {
            $doneAlias = true;
          }
    }

      } while ((!$doneSef || !$doneAlias || !$doneShurl || !$doneClean || !$doneBlackList) && ($attempts < $maxAttempts));

    } catch (Sh404sefExceptionDefault $e) {
    }

    return $shURL;
    }

  private function _getModifiedShurl( $shurl) {

    static $charIndex = 0;
    static $altCharIndex = 0;

    $altCharSize = strlen( self::$_alternate);

    $shurl[$charIndex] = self::$_alternate[$altCharIndex];
    $altCharIndex++;
    if($altCharIndex >= $altCharSize) {
      $altCharIndex = 0;
      $charIndex++;
  }

    return $shurl;

  }

  private function _getNextDBId( $table) {
    if (empty( $table)) {
      return false;
    }
    $this->_db = & JFactory::getDBO();
    // need to force replace prefix
    $table = $this->_db->replacePrefix(  $table);
    $query = 'show table status like \'' . $table . '\';';
    $this->_db->setQuery( $query);
    $this->_db->query();
    $status = $this->_db->loadAssoc();
    if (empty( $status) || empty( $status['Auto_increment'])) {
      return false;
    } else {
      return (int) $status['Auto_increment'];
    }
  }

  private function _mustCreatePageid( $nonSefUrl) {

    // currently disabled by sef url plugin
    if (!self::$_mustCreate) {
      return false;
    }

    // if enabled at sef url plugin level, check configuration
    $sefConfig = &Sh404sefFactory::getConfig();

    // check global flags
    if (!$sefConfig->enablePageId || $sefConfig->stopCreatingShurls) {
      return false;
    }

    // check at component level
    $option = shGetURLVar( $nonSefUrl, 'option');
    $option = str_replace( 'com_', '', $option);
    $enable = !empty( $option) && in_array( $option, $sefConfig->compEnablePageId);

    // check non sef url content black list
    $sefConfig->shurlNonSefBlackList = JString::trim( $sefConfig->shurlNonSefBlackList);
    if(empty( $sefConfig->shurlNonSefBlackList)) {
      $blackList = array();
    } else if(strpos( $sefConfig->shurlNonSefBlackList, '|') !== false) {
      $blackList = explode('|', $sefConfig->shurlNonSefBlackList);
    } else {
      $blackList = array( $sefConfig->shurlNonSefBlackList);
    }
    if(!empty( $blackList)) {
      foreach( $blackList as $bit) {
        if(!empty( $bit) && strpos( $nonSefUrl, $bit) !== false) {
          // match, don't create a shurl for this non sef url
          $enable = false;
          break;
        }
      }
    }

    return $enable;
  }

}