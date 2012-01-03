<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: editurl.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelEditurl extends Sh404sefClassBaseeditmodel {

  protected $_context = 'sh404sef.editurl';
  protected $_defaultTable = 'urls';

  protected $_url = null;

  /**
   * Create or update a record to
   * DB from POST data
   *
   * Overriden from base model
   * to also save metas and aliases
   *
   * @param array $dataArray an array holding data to save. If empty, $_POST is used
   * @return integer id of created or updated record
   */
  public function save( $dataArray = null, $type = sh404SEF_URLTYPE_CUSTOM) {

    // use parent save method to save the url itself, from default values
    $this->_data = is_null( $dataArray) ? JRequest::get('post') : $dataArray;

    // save the non-sef/sef pair data
    $savedId = $this->_saveUrl( $type);

    //now save metas
    if( !empty($savedId)) {
      $savedId =  $this->_saveMetas() ? $savedId : 0;
    }

    // now save aliases
    if( !empty($savedId)) {
      $savedId =  $this->_saveAliases() ? $savedId : 0;
    }

    // return savedId of the url, will have
    // been set to 0 if something wrong happened
    // while saving either url, meta data or aliase
    return $savedId;
  }

  /**
   * Get a list of urls from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of url id to fetch
   * @return array of objects as read from db
   */
  public function getByIds( $ids = array()) {

    $urls = array();

    if (empty($ids)) {
      return $urls;
    }

    // select element where id is in list supplied
    $query = 'select * from ' . $this->_db->nameQuote( $this->_getTableName());
    $whereIds = Sh404sefHelperDb::arrayToIntValList( $ids);

    // aggregate query
    $query .= ' where ' . $this->_db->nameQuote( 'id') . ' in (' . $whereIds . ')';

    // perform query
    $this->_db->setQuery( $query);
    $urls = $this->_db->loadObjectList();

    // return result
    return $urls;
  }

  /**
   * Save an url (not aliases or metas) passed as param
   *
   * @param $url array holding the various fields of an url
   */
  public function saveUrl( $url) {

    // use parent save method to save the url itself, from default values
    $this->_data = $url;
    $savedId = $this->_saveUrl();

    // return savedId of the url, will have
    // been set to 0 if something wrong happened
    // while saving url
    return $savedId;

  }

  /**
   * Delete a list of urls from their ids,
   * passed as params
   *
   * @param array of integer $ids the list of url id to delete
   * @return boolean true if success
   */
  public function deleteByIds( $ids = array()) {

    if (empty($ids)) {
      return false;
    }

    $status = true;

    // build a list of ids to read
    $whereIds = Sh404sefHelperDb::arrayToIntValList( $ids);

    // Need to delete urls from db, from cache
    // and also make sure the ranking is correct for duplicates
    // so we must find the first duplicate (if any) for all
    // urls to delete, and set its rank to zero.
    // First find about duplicates
    $query = 'select r2.*'
    . ' from `#__sh404sef_urls` as r1'
    . ' join `#__sh404sef_urls` as r2'
    . ' on r1.`oldurl` = r2.`oldurl`'
    . ' where r1.' . $this->_db->nameQuote( 'id') . ' in (' . $whereIds . ')';
    $query .= ' and r2.' . $this->_db->nameQuote( 'rank') . ' > 0';
    $query .= ' order by `rank`';

    // perform query
    $this->_db->setQuery( $query);
    $duplicates = $this->_db->loadObjectList();

    // now delete urls from db and cache
    $rows = $this->_getNonSefUrls( $ids);
    if (!empty( $rows)) {
      Sh404sefHelperCache::removeURLFromCache($rows);
    }

    // finally, we can simply delete from db by ids
    try {
      sh404sefHelperDb::deleteIn( '#__sh404sef_urls', 'id', $ids);
    } catch (Sh404sefExceptionDefault $e) {
      $this->setError( 'Internal database error # ' . $e->getMessage());
      $status = false;
    }

    // if successfull, set the new rank 0 duplicate
    if( empty( $error) && !empty($duplicates)) {
      // array to hold ids of urls that should be set to rank=0
      $newMainUrls = array();
      // temporary arrays, holding duplicates grouped by nonsef url
      $groupedDuplicates = array();
      // group them by old url
      foreach($duplicates as $url) {
        $groupedDuplicates[md5($url->oldurl)][] = $url;
      }

      // now collect the first url of each group, it
      // will have the lowest rank of the bunch as the initial
      // db query was ordered by rank asc
      foreach( $groupedDuplicates as $urlGroup) {
        $newMainUrls[] = $urlGroup[0]->id;
      }

      // now we just set the rank column to 0 for the
      // selected urls, so as to make them the new main urls
      // build a list of ids to read
      $whereIds = Sh404sefHelperDb::arrayToIntValList( $newMainUrls);
      $query = 'update ' . $this->_db->nameQuote( '#__sh404sef_urls')
      . ' set ' . $this->_db->nameQuote( 'rank') . ' = 0'
      . ' where ' . $this->_db->nameQuote( 'id') . ' in (' . $whereIds . ')';
      $this->_db->setQuery( $query);
      $this->_db->query();

      // check errors
      $error = $this->_db->getErrorNum();
      if ($error) {
        $this->setError( 'Internal database error # ' . $error);
        $status = false;
      }
    }

    return $status;
  }

  /**
   * Delete a list of urls from their ids,
   * passed as params
   * Also delete all duplicates
   *
   * @param array of integer $ids the list of url id to delete
   * @return boolean true if success
   */
  public function deleteByIdsWithDuplicates( $ids = array()) {

    if (empty($ids)) {
      return true;
    }

    // build a list of ids to read
    $whereIds = Sh404sefHelperDb::arrayToIntValList( $ids);

    // read urls and their duplicates
    $query = 'select r2.id'
    . ' from `#__sh404sef_urls` as r1'
    . ' join `#__sh404sef_urls` as r2'
    . ' on r1.`oldurl` = r2.`oldurl`'
    . ' where r1.' . $this->_db->nameQuote( 'id') . ' in (' . $whereIds . ')';

    // perform query
    $this->_db->setQuery( $query);
    $urlsIds = $this->_db->loadResultArray();

    // now delete urls from db and cache
    $rows = $this->_getNonSefUrls( $urlsIds);
    if (!empty( $rows)) {
      Sh404sefHelperCache::removeURLFromCache($rows);
    }

    // finally, we can simply delete from db by ids
    try {
      sh404sefHelperDb::deleteIn( '#__sh404sef_urls', 'id', $urlsIds);
    } catch (Sh404sefExceptionDefault $e) {
      $this->setError( 'Internal database error # ' . $e->getMessage());
    }

    return true;
  }

  /**
   * Save an url to the database, updating various elements
   * at the same time like ranking of duplicates
   *
   * @param integer $type force url type, used when saving a custom url
   */
  private function _saveUrl( $type = sh404SEF_URLTYPE_AUTO) {


    // check for homepage handling
    if (!empty( $this->_data['newurl'])
    && ($this->_data['newurl'] == '/' || $this->_data['newurl'] == sh404SEF_HOMEPAGE_CODE)) {
      $this->_saveHomeUrl();
      return sh404SEF_HOMEPAGE_CODE;
    }

    // check for importing urls : if importing, rank will already be set in
    // incoming data. If saving a url from the UI, rank is never set
    // as it is caculated upon saving the url
    $importing = isset( $this->_data['rank']);

    // get required tools
    jimport( 'joomla.database.table');
    $row = & JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');

    // now bind incoming data to table row
    if (!$row->bind( $this->_data)) {
      $this->setError( $row->getError());
      return 0;
    }

    // pre-save checks
    if (!$row->check()) {
      $this->setError( $row->getError());
      return 0;
    }

    // must load cache from disk, so that it can be written back later, with new url
    require_once(JPATH_ROOT.'/components/com_sh404sef/shCache.php');
    shLoadURLCache();

    // find if we are adding a custom or automatic url
    $urlType = $row->dateadd == '0000-00-00' ? sh404SEF_URLTYPE_AUTO : sh404SEF_URLTYPE_CUSTOM;

    // override with user supplied
    if (!empty( $type)) {
      $urlType = $type;
    }

    // adjust date added field if needed
    if ($urlType == sh404SEF_URLTYPE_CUSTOM) {
      $row->dateadd = date("Y-m-d");
    }

    // if custom url, and no language string, let's add default one
    if (   ($urlType == sh404SEF_URLTYPE_CUSTOM)
    && !preg_match( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', $row->newurl)) {
      $shTemp = explode( '-', shGetDefaultLang());
      $shLangTemp = $shTemp[0] ? $shTemp[0] : 'en';
      $row->newurl .= '&lang='.$shLangTemp;
    }

    // normalize the non-sef url representation, sorting query parts alphabetically
    $row->newurl = shSortUrl($row->newurl);

    // retrieve previous values of sef and non sef urls
    $previousSefUrl = JRequest::getVar( 'previousSefUrl', null, 'POST');
    $previousNonSefUrl = JRequest::getVar( 'previousNonSefUrl', null, 'POST');

    // if both were set, and nothing has changed, then nothing to do
    if (!empty($previousSefUrl) && !empty( $previousNonSefUrl)
    && $previousNonSefUrl == $row->newurl
    && $previousSefUrl == $row->oldurl) {
      // nothing changed ! must be changing meta or aliases
      $this->_url = $row;
      return $row->id;
    }

    // search DB for urls pairs with same SEF url
    $query = 'SELECT * FROM #__sh404sef_urls WHERE oldurl = ' . $this->_db->Quote( $row->oldurl) . ' ORDER BY rank ASC';
    $this->_db->setQuery($query);
    $dbUrlList = $this->_db->loadObjectList();

    // do we have urls in the db with same SEF ?
    if (count($dbUrlList) > 0) {

      // yes we do
      // get config object
      $sefConfig = Sh404sefFactory::getConfig();
      if (!$sefConfig->shRecordDuplicates) {  // we don't allow duplicates : reject this URL

        $this->setError( COM_SH404SEF_DUPLICATE_NOT_ALLOWED);

      } else {  // same SEF, but we allow duplicates

        $existingRecord = null;
        // importing meta data for instance
        foreach ($dbUrlList as $urlInDB) {  // same SEF, but is the incoming non-sef in this list of URl with same SEF ?
          if ($urlInDB->newurl == $row->newurl) {
            $existingRecord = $urlInDB;
            $this->setError( COM_SH404SEF_URLEXIST);
          }
        }

        if (empty( $existingRecord)) {  // this new non-sef does not already exists
          $shTemp = array('nonSefURL' => $row->newurl);   // which means we must update the record for the old non-sef url
          Sh404sefHelperCache::removeURLFromCache( $shTemp);  // remove the old url from cache

          // then find new rank (as we are adding a duplicate, we add it at the end of the duplicate list)
          // but only if not importing. When importing, rank is already set
          if (!$importing) {
            $row->rank = $dbUrlList[count($dbUrlList)-1]->rank+1;
          }

          // store will create a new record if id=0, or update existing if id non 0
          $row->store();

          // put custom URL in DB and cache
          Sh404sefHelperCache::addSefUrlToCache( $row->newurl, $row->oldurl, $urlType);

          // we must add the previous SEF url to the alias list, only if
          //   - not already there
          //   - this sef url does not already exists in the DB; which will happen if the url
          //     being saved was customized and also had duplicates
          // TODO this code is duplicated just a few line below, need refactoring
          if (!empty($previousSefUrl) && strpos($this->_data['shAliasList'], $previousSefUrl) === false) {
            // check if not already a valid SEF url in the DB
            $query = 'SELECT count(id) FROM #__sh404sef_urls WHERE oldurl = ' . $this->_db->Quote( $previousSefUrl);
            $this->_db->setQuery($query);
            $isThere = $this->_db->loadResult();
            if (empty( $isThere)) {
              $this->_data['shAliasList'] .= $previousSefUrl. "\n";
            }
          }

        } else {
          // there is already a record with both this sef and non sef.
          // just do nothing but return success (ie: record id).
          // Later, controller may store new aliases or metas
          // This should never happen when saving regular data as we added
          // a check for this case earlier
          // May happen when importing though
          $this->_url = $row;
          return $row->id;
        }

        // additional step : if we are here, it may be because we have modified
        // an existing url, and specifically changed it sef value to something else
        // Now it may be that this record was the one with rank = 0 in a series
        // of duplicate urls. If so, the urls which was ranked above must now become
        // the main url, having rank = 0
        // note : when importing, we don't enter this test as previousSefUrl is empty
        // TODO this code is duplicated just a few line below, need refactoring
        if (!empty( $previousSefUrl) && $previousSefUrl != $row->newurl) {
          // search for the old #2 record in duplicate list
          $query = 'SELECT id FROM #__sh404sef_urls WHERE oldurl = ' . $this->_db->Quote( $previousSefUrl) . ' ORDER BY rank ASC';
          $this->_db->setQuery($query);
          $previousRanked2 = $this->_db->loadObject();

          // there was more than one duplicate in the same series, promote #2 to top spot
          if (!empty($previousRanked2)) {
            $query = 'UPDATE #__sh404sef_urls SET rank="0" WHERE id = '. $this->_db->Quote( $previousRanked2->id);
            $this->_db->setQuery($query);
            $this->_db->query();
          }
        }

      }

    } else {   // there is no URL with same SEF URL, we are customizing an existing SEF url

      $shTemp = array('nonSefURL' => $row->newurl);
      Sh404sefHelperCache::removeURLFromCache( $shTemp);  // remove it from cache

      // simply store URL. If there is already one with same non-sef, this will raise an error in store()
      // as we don't allow creating a custom url for an already existing non-sef. User should
      // directly edit the existing non-sef/sef pair
      if (!$row->check()) {
        $this->setError( $row->getError());
        return 0;
      }

      if (!$row->store()) {
        $this->setError( $row->getError());
        return 0;
      }

      // add also to cache if saved to db
      Sh404sefHelperCache::addSefUrlToCache( $row->newurl, $row->oldurl, $urlType);

      // we must add the previous SEF url to the alias list, only if
      //   - not already there
      //   - this sef url does not already exists in the DB; which will happen if the url
      //     begin saved was customized and also had duplicates
      // note : when importing, we don't enter this test as previousSefUrl is empty
      // TODO this code is duplicated just a few line above, need refactoring
      if (!empty($previousSefUrl) && strpos($this->_data['shAliasList'], $previousSefUrl) === false) {
        // check if not already a valid SEF url in the DB
        $query = 'SELECT count(id) FROM #__sh404sef_urls WHERE oldurl = ' . $this->_db->Quote( $previousSefUrl);
        $this->_db->setQuery($query);
        $isThere = $this->_db->loadResult();
        if (empty( $isThere)) {
          $this->_data['shAliasList'] .= $previousSefUrl. "\n";
        }
      }

      // finally, also check db for urls with same sef as previous SEF if any. We need
      // to search for the first duplicate of this old sef, and set it to be
      // the new main url
      // note : when importing, we don't enter this test as previousSefUrl is empty
      // TODO this code is duplicated just a few line above, need refactoring
      if (!empty( $previousSefUrl) && $previousSefUrl != $row->newurl) {
        // search for the old #2 record in duplicate list
        $query = 'SELECT id FROM #__sh404sef_urls WHERE oldurl = ' . $this->_db->Quote( $previousSefUrl) . ' ORDER BY rank ASC';
        $this->_db->setQuery($query);
        $previousRanked2 = $this->_db->loadObject();

        // there was more than one duplicate in the same series, promote #2 to top spot
        if (!empty($previousRanked2)) {
          $query = 'UPDATE #__sh404sef_urls SET rank="0" WHERE id = '. $this->_db->Quote( $previousRanked2->id);
          $this->_db->setQuery($query);
          $this->_db->query();
        }
      }
    }

    // store saved url object
    $this->_url = $row;

    // return what should be a non-zero id
    return $this->_url->id;

  }


  private function _saveHomeUrl() {

    // get required tools
    jimport( 'joomla.database.table');
    $url = & JTable::getInstance( $this->_defaultTable, 'Sh404sefTable');

    // build a fake url record
    $url->newurl = sh404SEF_HOMEPAGE_CODE;

    // store it for future usage when saving meta and aliases
    $this->_url = $url;

  }

  private function _saveMetas() {

    // get a meta model object
    $model = & JModel::getInstance( 'metas', 'Sh404sefModel');

    // buil an array with metas input
    $metaDatas = array(
        'metatitle' => $this->_data['metatitle']
    , 'metadesc' => $this->_data['metadesc']
    , 'metakey' => $this->_data['metakey']
    , 'metarobots' => $this->_data['metarobots']
    , 'metalang' => $this->_data['metalang']
    , 'newurl' =>  is_object( $this->_url) ? $this->_url->newurl : ''
    , 'id' =>  $this->_data['meta_id']
    );

    // ask model to save the data
    $status = $model->save( $metaDatas);

    if (!$status) {
      $this->setError( $model->getError());
    }

    return $status;
  }


  /**
   * Save aliases entered by user to the db
   * overwriting existing ones
   *
   */
  private function _saveAliases() {

    // get an aliases model object
    $model = & JModel::getInstance( 'aliases', 'Sh404sefModel');

    // ask it to save the data
    $newUrl = is_object( $this->_url) ? $this->_url->newurl : '';
    $status = $model->saveFromInput( $this->_data['shAliasList'], $newUrl);

    if (!$status) {
      $this->setError( $model->getError());
    }

    return $status;

  }

  /**
   * Read urls from db and returns an array
   * of non-sef urls, as needed currently
   * by the cache class for deletion operation
   *
   * @param array of integer $ids
   */
  private function _getNonSefUrls( $ids) {

    $nonSefUrls = array();

    $rawUrls = $this->getByIds( $ids);

    if (!empty( $rawUrls)) {
      foreach( $rawUrls as $url) {
        $nonSefUrls[] = $url->newurl;
      }
    }

    return $nonSefUrls;
  }

  /**
   * Returns the default full table name on
   * which this model operates
   */
  protected function _getTableName() {

    return '#__sh404sef_urls';

  }

}