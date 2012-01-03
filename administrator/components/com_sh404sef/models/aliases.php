<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: aliases.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelAliases extends Sh404sefClassBaselistModel {

  protected $_context = 'sh404sef.aliases';
  protected $_defaultTable = 'aliases';


  /**
   * Save a list of aliases as entered by user in backend to the database
   *
   * @param string $aliasList data from an html textarea field
   * @param string $nonSefUrl the non sef url to which aliases are attached
   *
   * @return boolean true on success
   */
  public function saveFromInput( $aliasList, $nonSefUrl) {

    // split aliases from raw input data into an array
    $aliasList = explode("\n", $aliasList);

    // delete them all. We should do a transaction, but not worth it
    $query = 'DELETE from #__sh404sef_aliases where newurl = '. $this->_db->Quote( $nonSefUrl);
    $this->_db->setQuery($query);
    $this->_db->query();

    // Write new aliases.
    if (!empty( $aliasList[0])) {
      $baseQuery = 'INSERT INTO #__sh404sef_aliases (newurl, alias, type) VALUES __shValue__;';
      $endOfLine = array("\r\n", "\n", "\r");
      foreach($aliasList as $alias) {
        // remove end of line chars
        $alias = str_replace($endOfLine, '', $alias);

        // if something left, try insert it into DB
        if (!empty($alias)) {

          // first check value is not invalid
          // either the alias already exists
          // or same SEF url already exists
          try {
            $count = Sh404sefHelperDb::count( '#__sh404sef_aliases', 'id', 'oldurl = ? and newurl <> ?', array($alias, ''));

          if (empty( $count)) {
              $count = Sh404sefHelperDb::count( '#__sh404sef_aliases', '*', array('alias' => $alias));
            }
          } catch (Sh404sefExceptionDefault $e) {
            $count = 0;
          }

          // if ok, insert into db
          if (empty($count)) {
            $value =  '('
            . $this->_db->Quote( $nonSefUrl) . ', '
            . $this->_db->Quote( $alias)
            . ', '
            . $this->_db->Quote( Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS)
            . ')';
            $query = str_replace('__shValue__', $value, $baseQuery);
            $this->_db->setQuery( $query);
            $this->_db->query();
            // check errors
            $error = $this->_db->getErrorNum();
            if (!empty( $error)) {
              $this->setError( 'Internal database error # ' . $query);
            }
          } else {
            // alias already exists either as an alias or a SEF url
            $this->setError( JText::sprintf( 'COM_SH404SEF_ALIAS_ALREADY_EXISTS', $alias));
          }
        }
      }
    }

    // return true if no error
    $error = $this->getError();
    return empty( $error);

  }

  /**
   * Read data from model and turns it into
   * a string suitable for display in a text area field
   *
   * @param array $options key/value pairs to restrict data selection
   */
  public function getDisplayableList( $options) {

    // get raw data
    $rawList = $this->getList( $options, $returnZeroElement = false, $forcedLimitstart = null, $forcedLimit = 5000);

    // make a simple string suitable for editing in a text area input field
    $displayableList = '';
    if (!empty( $rawList)) {
      foreach ($rawList as $alias) {
        $displayableList .= shUrlSafeDisplay( $alias->alias) . "\n";
      }
    }

    return $displayableList;
  }

  /**
   * Purge urls from database (and cache)
   * either all automatic, or according to current
   * sef url list page select options as stored in
   * in session
   * @param unknown_type $type
   */
  public function purge( $type = 'auto') {

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
    $this->_db->setQuery( $deleteQuery);
    $this->_db->query();

    // reset limit and limitstart variables, to avoid
    // issue when displaying again results
    $this->_setState( 'limitstart', 0);
    $this->_setState( 'limit', 0);
    
    // set error
    $error = $this->_db->getErrorNum();
    if (!empty($error)) {
      $this->setError( 'Internal database error # ' . $error);
    }

  }

  public function getAliasesCount( $which = 'auto') {

    switch (strtolower( $which)) {

      // we want to read all automatic urls (include duplicates)
      case 'auto':
        try {
          $numberOfUrls = Sh404sefHelperDb::count( $this->_getTableName(), '*', array('type' => Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS));
        } catch( Sh404sefExceptionDefault $e) {
          $numberofUrls = 0;
        }
        break;

        // we want to read urls as per current selection input fields
        // ie : component, language, custom, ...
      case 'selected':
        $numberOfUrls = $this->getTotal();
        break;

      default:
        $numberOfUrls = 0;
        break;
    }

    return intval( $numberOfUrls);
  }

  /**
   * Finds the sef url record to which an
   * alias record, identified by its id,
   * elongs to
   *
   * @param integer $aliasId
   */
  public function getUrlByAliasId( $aliasId) {

    $aliasId = empty( $aliasId) ? 0 : intval( $aliasId);
    $query  = 'select r.* from ' . $this->_db->nameQuote( '#__sh404sef_urls') . ' as r'
    . ' left join ' . $this->_db->nameQuote( '#__sh404sef_aliases') . ' as a'
    . ' on a.' . $this->_db->nameQuote( 'newurl') . ' = r.' . $this->_db->nameQuote( 'newurl')
    . ' where a.' . $this->_db->nameQuote( 'id') . ' = ' . $this->_db->Quote( $aliasId)
    . ' order by ' . $this->_db->nameQuote( 'rank');
    $this->_db->setQuery( $query);
    $url = $this->_db->loadObject();

    // set error
    $error = $this->_db->getErrorNum();
    if (!empty($error)) {
      $this->setError( 'Internal database error # ' . $error);
    }

    return $url;

  }

  /**
   * Gets alist of current filters and sort options which have
   * been applied when building up the data
   * @override
   * @return object the list ov values as object properties
   */
  public function getDisplayOptions() {

    $options = parent::getDisplayOptions();

    // get additional options vs base class

    // component used in url
    $options->filter_component = $this->_getState( 'filter_component');
    // show all/only one language
    $options->filter_language = $this->_getState( 'filter_language');

    // return cached instance
    return $options;
  }

  protected function _buildListSelect( $options) {

    // array to hold select clause parts
    $select = array();

    // get options
    $select[] = ' select a.*, r.oldurl';

    // add from  clause
    $select[] = 'from ' . $this->_getTableName() . ' as a';
     
    // aggregate clauses
    $select    = ( count( $select ) ? implode( ' ', $select ) : '' );

    return $select;
  }

  protected function _buildListWhere( $options) {

    // array to hold where clause parts
    $where = array();

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // only aliases, no pageid
    $where[] = 'a.type = ' . $this->_db->Quote( Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS);

    // are we reading aliases for one specific url ?
    $newurl = $this->_getOption( 'newurl', $options);
    if (!empty( $newurl)) {
      $where[] = 'a.newurl = ' . $this->_db->Quote( $newurl);
    } else {
      // we read them all, except possibly the home page aliases
      $includeHomeData = $this->_getOption( 'includeHomeData', $options);
      if (empty( $includeHomeData)) {
        $where[] = 'a.newurl != ' . $this->_db->Quote( sh404SEF_HOMEPAGE_CODE);
      }
    }

    // add search all urls term if any
    if ( !empty($filters->search_all) ) {  // V 1.2.4.q added search URL feature
      jimport( 'joomla.utilities.string');
      $searchTerm = $this->_cleanForQuery( JString::strtolower($filters->search_all));
      $where[] = " (LOWER(a.alias)  LIKE '%" . $searchTerm  . "%' OR "
      . "LOWER(r.newurl)  LIKE '%" . $searchTerm  . "%')";
    }

    // components check
    if (!empty( $filters->filter_component)) {
      $where[] = "LOWER(a.newurl)  LIKE '%option=" . $this->_cleanForQuery( $filters->filter_component ) . "%'";
    }

    // language check
    if (!empty( $filters->filter_language)) {
      $where[] = "LOWER(a.newurl)  LIKE '%lang=" . $this->_cleanForQuery( $filters->filter_language ) . "%'";
    }

    // aggregate clauses
    $where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

    return $where;
  }

  protected function _buildListJoin( $options) {

    // array to hold join clause parts
    $join = array();

    // read also the sef url
    $join[] = 'left join ' . $this->_db->nameQuote( '#__sh404sef_urls') . ' as r';
    $join[] = 'on r.' . $this->_db->nameQuote( 'newurl') . ' = a.' . $this->_db->nameQuote( 'newurl');

    // aggregate clauses
    $join = ( count( $join ) ? ' ' . implode( ' ', $join ) : '' );

    return $join;

  }

  protected function _buildListOrderBy( $options) {

    // get set of filters applied to the current view
    $filters = $this->getDisplayOptions();

    // build query fragment
    $orderBy  = ' order by ' .  $filters->filter_order;
    $orderBy .=  ' ' . $filters->filter_order_Dir;

    return $orderBy;
  }
  
  protected function _getTableName() {

    return '#__sh404sef_aliases';

  }

  /**
   * Provides context data definition, to be used by context handler
   * Should be overriden by descendant
   */
  protected function _getContextDataDef() {

    $contextData = parent::_getContextDataDef();

    // define context data to be retrieved. Cannot be done at class level,
    // as some default values are dynamic
    $addedContextData = array(

    // redefined default sort order
    array( 'name' => 'filter_order', 'html_name' => 'filter_order', 'default' => 'alias', 'type' => 'string')

    // component used in url
    , array( 'name' => 'filter_component', 'html_name' => 'filter_component', 'default' => '', 'type' => 'string')
    // show all/only one language
    , array( 'name' => 'filter_language', 'html_name' => 'filter_language', 'default' => '', 'type' => 'string')

    );

    return array_merge( $contextData, $addedContextData);
  }


  /**
   * Delete all automatically generated url records
   * from database and cache
   */
  private function _getPurgeQueryAuto() {

    // delete from database
    $query = 'delete from ' . $this->_db->nameQuote( $this->_getTableName())
    . ' where type = ' . $this->_db->Quote( Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS);

    return $query;
  }

  private function _getPurgeQuerySelected() {

    // a 2 steps process : first collect those urls id we need
    // in accordance with select drop-down lists
    // then combine it with a delete query
    $options = null;
    $query = $this->_buildListQuery($options);

    // collect only the ids
    $queryIds = 'select t.id from (' . $query . ') as t';

    // start delete query
    $deleteQuery = 'delete from ' . $this->_db->nameQuote( $this->_getTableName())
    . ' where id = any (' . $queryIds . ')';

    return $deleteQuery;
  }

}