<?php
/**
 *
 * @version   $Id: db.php 1991 2011-05-31 07:07:03Z silianacom-svn $
 * @copyright Copyright (C) 2010 Yannick Gaultier. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * Sh404sefClassShdb is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Helper class to use extended Joomla! default database class: Sh404sefClassShdb
 *
 */

// Security check to ensure this file is being included by a parent file.
defined( '_JEXEC' ) or die;

class Sh404sefHelperDb {

  const STRING = 1;
  const INTEGER = 2;

  private static $_selected = 'default';
  private static $_instances = array();

  /**
   * Returns an instance of database connnection
   * creating it if needed
   *
   * @param string $name optional name of database instance to use
   * @return database object of integer, non-zero error code
   */
  public static function &getInstance( $name = '') {

    $name = empty( $name) ? self::$_selected : $name;

    if (empty(self::$_instances[$name])) {
      // db has not been set yet, get default

      // get application db instance
      $db = & JFactory::getDBO();

      // decorates db instance with our simplified access methods
      self::$_instances[$name] = new Sh404sefClassShdb( $db);

    }

    return self::$_instances[$name];
  }

  /**
   *
   * Set up and store a database instance to use
   *
   * @param string $name reference name for the instance
   * @param object $db Joomla database object
   * @throws CliExceptionDefault
   */
  public static function setDb( $name, & $db) {

    if(empty( $name)) {
      throw new Sh404sefExceptionDefault( 'Trying to set database object with no valid name');
    }
    self::$_instances[$name] = new Sh404sefClassShdb( $db);
  }

  /**
   *
   * Set the currently selected database instance, will be used
   * for subsequent operations of this helper class, until
   * another one is selected
   *
   * @param string $name name of database instance to select
   * @throws CliExceptionDefault
   */
  public static function selectDb( $name = 'default') {

    if(empty( $name) || empty(self::$_instances[$name])) {
      throw new Sh404sefExceptionDefault( 'Trying to select a database that has not been set: ' . $name);
    }

    self::$_selected = $name;
  }

  /**
   * Prepare, set and execute a select query, returning a single result
   *
   * usage:
   *
   * $result = Sh404sefHelperDb::selectResult( '#__sh404sef_alias', 'alias', array( 'nonsef' => 'index.php?option=com_content&view=article&id=12'));
   * will select the 'alias' column where nonsef column is index.php?option=com_content&view=article&id=12
   * Alternate where condition syntax:
   * $result = Sh404sefHelperDb::selectResult( '#__sh404sef_alias', 'alias', 'amount > 0 and amount < ?', array( '100'));
   * If where condition is a string, it will be used literally, with question marks replaced by parameters as
   * passed in the next method param. These params are escaped, but the base where condition is not
   *
   * @param String $table The table name
   * @param Array  $aColList array of strings of columns to be fetched
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @param Array $orderBy, a list of columns to order the results
   * @param Integer $offset, first line of result set to select
   * @param Integer $lines, max number of lines to select
   * @return mixed single value read from db
   * @throw none (underlying database layer does throw errors)
   */
  public static function selectResult( $table, $aColList = array( '*'), $mWhere = '', $aWhereData = array(), $orderBy = array(), $offset = 0, $lines = 0) {

    $result = self::_setSelectQuery( $table, $aColList, $mWhere, $aWhereData, $orderBy, $offset, $lines)->eLoadResult();

    return $result;
  }

  /**
   * Prepare, set and execute a select query, returning a single associative array
   *
   * usage:
   *
   * $result = Sh404sefHelperDb::selectAssoc( '#__sh404sef_alias', array('alias', 'id'), array( 'nonsef' => 'index.php?option=com_content&view=article&id=12'));
   * will return an array with 2 keys, alias and id, where nonsef column is index.php?option=com_content&view=article&id=12
   *
   * $result = Sh404sefHelperDb::selectAssoc( '#__sh404sef_alias', array('alias', 'id'), 'amount > 0 and amount < ?', array( '100'));
   * If where condition is a string, it will be used literally, with question marks replaced by parameters as
   * passed in the next method param. These params are escaped, but the base where condition is not
   *
   * @param String $table The table name
   * @param Array  $aColList array of strings of columns to be fetched
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @param Array $orderBy, a list of columns to order the results
   * @param Integer $offset, first line of result set to select
   * @param Integer $lines, max number of lines to select
   * @return mixed single value read from db
   * @throw none (underlying database layer does throw errors)
   */
  public static function selectAssoc( $table, $aColList = array( '*'), $mWhere = '', $aWhereData = array(), $orderBy = array(), $offset = 0, $lines = 0) {

    $result = self::_setSelectQuery( $table, $aColList, $mWhere, $aWhereData, $orderBy, $offset, $lines)->eLoadAssoc();

    return $result;
  }

  /**
   * Prepare, set and execute a select query, returning a an array of associative arrays
   *
   * usage:
   *
   * $result = Sh404sefHelperDb::selectAssoc( '#__sh404sef_alias', array('alias', 'id'), array( 'nonsef' => 'index.php?option=com_content&view=article&id=12'));
   * will return an array of arrays with 2 keys, alias and id, where nonsef column is index.php?option=com_content&view=article&id=12
   *
   * $result = Sh404sefHelperDb::selectAssoc( '#__sh404sef_alias', array('alias', 'id'), 'amount > 0 and amount < ?', array( '100'));
   * If where condition is a string, it will be used literally, with question marks replaced by parameters as
   * passed in the next method param. These params are escaped, but the base where condition is not
   *
   * @param String $table The table name
   * @param Array  $aColList array of strings of columns to be fetched
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @param Array $orderBy, a list of columns to order the results
   * @param Integer $offset, first line of result set to select
   * @param Integer $lines, max number of lines to select
   * @return mixed single value read from db
   * @throw none (underlying database layer does throw errors)
   */
  public static function selectAssocList( $table, $aColList = array( '*'), $mWhere = '', $aWhereData = array(), $orderBy = array(), $offset = 0, $lines = 0, $key = '') {

    $result = self::_setSelectQuery( $table, $aColList, $mWhere, $aWhereData, $orderBy, $offset, $lines)->eLoadAssocList( $key);

    return $result;
  }

  /**
   * Prepare, set and execute a select query, returning a single object
   *
   * @param String $table The table name
   * @param Array  $aColList array of strings of columns to be fetched
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @param Array $orderBy, a list of columns to order the results
   * @param Integer $offset, first line of result set to select
   * @param Integer $lines, max number of lines to select
   * @return mixed single value read from db
   * @throw none (underlying database layer does throw errors)
   */
  public static function selectObject( $table, $aColList = array( '*'), $mWhere = '', $aWhereData = array(), $orderBy = array(), $offset = 0, $lines = 0) {

    $result = self::_setSelectQuery( $table, $aColList, $mWhere, $aWhereData, $orderBy, $offset, $lines)->eLoadObject();

    return $result;

  }

  /**
   * Prepare, set and execute a select query, returning a an object list
   *
   * @param String $table The table name
   * @param Array  $aColList array of strings of columns to be fetched
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @param Array $orderBy, a list of columns to order the results
   * @param Integer $offset, first line of result set to select
   * @param Integer $lines, max number of lines to select
   * @param string $key a column name to index the returned array with
   * @return mixed single value read from db
   * @throw none (underlying database layer does throw errors)
   */
  public static function selectObjectList( $table, $aColList = array( '*'), $mWhere = '', $aWhereData = array(), $orderBy = array(), $offset = 0, $lines = 0, $key='') {

    $result = self::_setSelectQuery( $table, $aColList, $mWhere, $aWhereData, $orderBy, $offset, $lines)->eLoadObjectList( $key);

    return $result;
  }

  /**
   * Prepare, set and execute a count query
   *
   * @param String $table The table name
   * @param String $column optional column to be counted (defaults to *)
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @return object the db object
   */
  public static function count( $table, $column = '*', $mWhere = '', $aWhereData = array()) {

    $db = & self::getInstance();

    $count = $db->setCountQuery( $table, $column, $mWhere, $aWhereData)->eLoadResult();

    return empty( $count) ? 0 : $count;
  }

  /**
   * Prepare, set and execute a delete query
   *
   * @param String $table The table name
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @return object the db object
   */
  public static function delete( $table, $mWhere = '', $aWhereData = array()) {

    $db = & self::getInstance();

    $db->setDeleteQuery( $table, $mWhere, $aWhereData)->eQuery();

    return $db;
  }

  /**
   * Prepare, set and execute a delete query based on a
   * list of column value
   *
   * @param String $table The table name
   * @param String $mwhereColumn name of column to compare to list of values
   * @param Array $aWhereData List of column values that should be deleted
   * @param Integer if self::INTEGER, list will be 'intvaled', else quoted
   * @return object the db object
   */
  public static function deleteIn( $table, $mwhereColumn, $aWhereData, $type = self::STRING) {

    if (empty($mwhereColumn) || empty( $aWhereData)) {
      return;
    }

    // build a list of ids to read
    $wheres = $type == self::INTEGER ? self::arrayToIntvalList( $aWhereData) : self::arrayToQuotedList( $aWhereData);

    // perform deletion
    $db = & self::getInstance();
    return self::delete( $table, $db->nameQuote( $mwhereColumn) . ' in (' . $wheres . ')');
  }

  /**
   * Prepare, set and execute and insert query
   *
   * @param String $table The table name
   * @param Array  $aData array of values pairs ( ie 'columnName' => 'columnValue')
   */
  public static function insert( $table, $aData) {

    $db = & self::getInstance();

    $db->setInsertQuery( $table, $aData)->eQuery();

    return $db;

  }

  /**
   * Prepare, set and execute an update query
   *
   * @param String $table The table name
   * @param Array  $aData array of values pairs ( ie 'columnName' => 'columnValue')
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  public static function update( $table, $aData, $mWhere = '', $aWhereData = array()) {

    $db = & self::getInstance();

    $db->setUpdateQuery( $table, $aData, $mWhere, $aWhereData)->eQuery();

    return $db;

  }

  /**
   * Prepare, set and execute an update query on a list
   * of items
   *
   * @param String $table The table name
   * @param Array  $aData array of values pairs ( ie 'columnName' => 'columnValue')
   * @param String $mwhereColumn name of column to compare to list of values
   * @param Array $aWhereData List of column values that should be updated
   * @param Integer if self::INTEGER, list will be 'intvaled', else quoted
   */
  public static function updateIn( $table, $aData, $mwhereColumn, $aWhereData, $type = self::STRING) {

    if (empty($mwhereColumn) || empty( $aWhereData)) {
      return;
    }

    // build a list of ids to read
    $wheres = $type == self::INTEGER ? self::arrayToIntvalList( $aWhereData) : self::arrayToQuotedList( $aWhereData);

    // perform deletion
    $db = & self::getInstance();
    return self::update( $table, $aData, $db->nameQuote( $mwhereColumn) . ' in (' . $wheres . ')');
  }

  /**
   * Prepare, set and execute an insert or update query
   *
   * @param String $table The table name
   * @param Array $aData An array of field to be inserted in the db ('columnName' => 'columnValue')
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  public static function insertUpdate( $table, $aData, $mWhere = '', $aWhereData = array()){

    $db = & self::getInstance();

    $db->setInsertUpdateQuery( $table, $aData, $mWhere, $aWhereData)->eQuery();

    return $db;

  }

  /**
   * Prepare, set and execute a custom database query
   *
   * @param String $query A litteral sql query
   */
  public static function query( $query){

    $db = & self::getInstance();
    $db->setQuery( $query);
    $db->eQuery();

    return $db;

  }

  /**
   *
   * Runs a query, after quoting or name quoting some
   * of its constituents
   * ?? will be replaced with name quoted data from the $nameQuoted parameter
   * ? will be replaced with quoted data from the $quoted parameter
   *
   * Example:
   *   $query = 'select ?? from ?? where ?? <> ?'
   *   with
   *     $nameQuoted = array( 'id', '#__table', 'counter')
   *     $quoted = array( 'test')
   *
   * will result in running
   *
   *   select `id` from `#__table` where `counter` <> 'test'
   *
   *
   * @param string $query
   * @param array $nameQuoted
   * @param array $quoted
   * @param string $namePlaceHolder
   * @param string $dataPlaceHolder
   */
  public static function queryQuote( $query, $nameQuoted = array(), $quoted = array(), $namePlaceHolder = '??', $dataPlaceHolder = '?') {

    // get a db
    $db = & self::getInstance();

    // save query for error message
    $newQuery = $db->quoteQuery( $query, $nameQuoted, $quoted);

    return self::query( $newQuery);
  }

  /**
   *
   * Asks db to name quote a string
   *
   * @param string $string
   */
  public static function nameQuote( $string) {

    $db = & self::getInstance();

    return $db->nameQuote( $string);
  }

  /**
   *
   * Asks DB to quote a string
   * @param string $string
   */
  public static function quote( $string) {

    $db = & self::getInstance();

    return $db->Quote( $string);
  }

  /**
   * Quote an array of value and turn it into a list
   * of separated, quoted elements
   *
   * @param array $data
   * @param string $glue
   * @return string
   */
  public static function arrayToQuotedList( $data, $glue = ',') {

    $list = '';
    if(empty( $data) || !is_array( $data)) {
      return $list;
    }

    $db = & self::getInstance();
    $values = array();
    foreach( $data as $value) {
      $values[] = $db->Quote( $value);
    }

    $list = implode( $glue, $values);

    return $list;
  }

  /**
   * Intval an array of value and turn it into a list
   * of separated, quoted elements
   *
   * @param array $data
   * @param string $glue
   * @return string
   */
  public static function arrayToIntvalList( $data, $glue = ',') {

    $list = '';
    if(empty( $data) || !is_array( $data)) {
      return $list;
    }

    $values = array();
    foreach( $data as $value) {
      $values[] = (int) $value;
    }

    $list = implode( $glue, $values);

    return $list;
  }

  protected static function _setSelectQuery( $table, $aColList = array( '*'), $mWhere = '', $aWhereData = array(), $orderBy = array(), $offset = 0, $lines = 0) {

    $db = & self::getInstance();

    $db->setSelectQuery( $table, $aColList, $mWhere, $aWhereData, $orderBy, $offset, $lines);

    return $db;
  }
}

