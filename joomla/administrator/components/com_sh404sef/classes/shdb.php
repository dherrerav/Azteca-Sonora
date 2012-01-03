<?php
/**
 *
 * @version   $Id: shdb.php 1995 2011-05-31 11:28:59Z silianacom-svn $
 * @copyright Copyright (C) 2010 Yannick Gaultier. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * Sh404sefClassShdb is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Class adding a few method to Joomla! default database class
 *
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die;

class Sh404sefClassShdb  extends Sh404sefClassShabstractdecorator {


  /**
   * Prepare and set a query against the db object
   *
   * @param String $table The table name
   * @param Array $aData An array of field to be inserted in the db ('columnName' => 'columnValue')
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  public function setInsertUpdateQuery( $table, $aData, $mWhere = '', $aWhereData = array()){

    if ($this->isRecord( $table, $mWhere, $aWhereData)) {
      // update it
      $this->setUpdateQuery( $table, $aData, $mWhere, $aWhereData);
    } else {
      // or insert it
      $this->setInsertQuery( $table, $aData);
    }

    return $this;
  }

  /**
   * Prepare and set a SELECT query against the db
   *
   * @param String $table The table name
   * @param Array  $aColList array of strings of columns to be fetched
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   * @param Array $orderBy, a list of columns to order the results
   * @param Integer $offset, first line of result set to select
   * @param Integer $lines, max number of lines to select
   */
  public function setSelectQuery( $table, $aColList = array( '*'), $mWhere = '', $aWhereData = array(), $orderBy = array(), $offset = 0, $lines = 0) {

    // sanitize
    $aColList = empty( $aColList) ? array('*') : $aColList;
    $aColList = is_string( $aColList) ? array( $aColList) : $aColList;

    // which columns to fetch ?
    $quotedColList = array();
    foreach( $aColList as $columnName) {
      $quotedColList[] = $columnName == '*' ? '*' : $this->nameQuote( $columnName);
    }
    $columns  = implode( ', ', $quotedColList);

    // where to look for
    $where = $this->_buildWhereClause( $mWhere, $aWhereData);

    // order by clause
    $orderByClause = $this->_buildOrderByClause( $orderBy);

    // lines limit clause
    $limitClause = $this->_buildLimitClause( $offset, $lines);

    // set up the query
    $this->setQuery( 'SELECT ' . $columns . ' FROM ' . $table . $where . $orderByClause . $limitClause . ';');

    return $this;
  } // end of setSelectQuery

  /**
   * Prepare and set a select/count query against the db
   *
   * @param String $table The table name
   * @param String $column an optional column to be counter
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  public function setCountQuery( $table, $column = '*', $mWhere = '', $aWhereData = array()) {

    // sanitize
    $column = empty( $column) || $column == '*' ? '*' : $this->nameQuote( $column);

    // where to look for
    $where = $this->_buildWhereClause( $mWhere, $aWhereData);

    // set up the query
    $this->setQuery( 'SELECT count(' . $column . ') FROM ' . $table . $where . ';');

    return $this;
  } // end of setSelectQuery


  /**
   * Prepare and set an UPDATE query against the db
   *
   * @param String $table The table name
   * @param Array  $aData array of values pairs ( ie 'columnName' => 'columnValue')
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  public function setUpdateQuery( $table, $aData, $mWhere = '', $aWhereData = array()) {

    // which columns to set ?
    $set  = '';
    if (!empty( $aData)) {
      foreach( $aData as $columnName => $columnValue) {
        $set .= ', ' . $this->nameQuote( $columnName). '=' . $this->_prepareData( $columnValue);
      }
      // remove leading ', '
      $set = substr( $set, 2);
    }

    // check result
    if (empty( $set)) {
      return false;
    }

    // where to look for
    $where = $this->_buildWhereClause( $mWhere, $aWhereData);

    // set up the query
    $this->setQuery( 'UPDATE ' . $this->nameQuote($table) . ' SET ' . $set . $where . ';');

    return $this;
  }

  /**
   * Prepare and set an INSERT query against the db
   *
   * @param String $table The table name
   * @param Array  $aData array of values pairs ( ie 'columnName' => 'columnValue')
   */
  public function setInsertQuery( $table, $aData) {

    // which columns to set ?
    $columns  = '';
    $values= '';
    if (!empty( $aData)) {
      foreach( $aData as $columnName => $columnValue) {
        $columns .= ', ' . $this->nameQuote( $columnName);
        $values .= ', ' . $this->_prepareData( $columnValue);
      }
      // remove leading ', '
      $columns = substr( $columns, 2);
      $values = substr( $values, 2);
    }

    // set up the query
    $this->setQuery( 'INSERT INTO ' . $this->nameQuote($table) . ' (' . $columns . ') VALUES (' . $values . ');');

    return $this;
  }

  /**
   * Prepare and set a DELETE query against the db
   *
   * @param String $table The table name
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  public function setDeleteQuery( $table, $mWhere = '', $aWhereData = array()) {

    // where to look for
    $where = $this->_buildWhereClause( $mWhere, $aWhereData);

    // set up the query
    $this->setQuery( 'DELETE FROM ' . $this->nameQuote($table) . $where . ';');

    return $this;
  }

  /**
   * Returns true if a record exists matching 'where' condition
   *
   * @param String $table, the table to look into
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  public function isRecord( $table, $mWhere = '', $aWhereData = array()) {

    // where to look for
    $where = $this->_buildWhereClause( $mWhere, $aWhereData);

    if (empty( $where)) {
      return false;
    }

    // set up the query and load result
    $this->setQuery( 'SELECT count(*) FROM ' . $this->nameQuote( $table) . $where . ';');
    $result = $this->eLoadResult();

    return !empty( $result);

  }

  /**
   * Returns true if a record exists with a given Id
   *
   * @param String $table, the table to look into
   * @param Integer $id, the id to look for
   * @param String $idName, default to 'id', the columns to look into, if not 'id'
   */
  public function isRecordById( $table, $id, $idName = 'id'){

    $id = (int) $id;

    if (empty( $id)) {
      return false;
    }

    // get db and look up record
    $this->setSelectQuery( $table, array( $idName), array( $id));
    $result = $this->eLoadResult();

    return !empty( $result);
  }

  /**
   * Wrapper around J! method, which
   * throws exceptions
   */
  public function eLoadResult() {

    $result = $this->loadResult();

    $error = $this->getErrorNum();

    if(!empty( $error)) {
      throw new Sh404sefExceptionDefault( $this->getErrorMsg(), $error);
    }

    return $result;
  }

  /**
   * Wrapper around J! method, which
   * throws exceptions
   */
  public function eLoadResultArray( $numinarray = 0) {

    $array = $this->loadResultArray( $numinarray);

    $error = $this->getErrorNum();

    if(!empty( $error)) {
      throw new Sh404sefExceptionDefault( $this->getErrorMsg(), $error);
    }

    return $array;
  }

  /**
   * Wrapper around J! method, which
   * throws exceptions
   */
  public function eLoadAssoc() {

    $result = $this->loadAssoc();

    $error = $this->getErrorNum();

    if(!empty( $error)) {
      throw new Exception( $this->getErrorMsg(), $error);
    }

    return $result;
  }

  /**
   * Wrapper around J! method, which
   * throws exceptions
   */
  public function eLoadAssocList( $key='' ) {

    $result = $this->loadAssocList( $key);

    $error = $this->getErrorNum();

    if(!empty( $error)) {
      throw new Exception( $this->getErrorMsg(), $error);
    }

    return $result;

  }

  /**
   * Wrapper around J! method, which
   * throws exceptions
   */
  public function eLoadObject( $className = 'stdClass') {

    $object = $this->loadObject( $className);

    $error = $this->getErrorNum();

    if(!empty( $error)) {
      throw new Sh404sefExceptionDefault( $this->getErrorMsg(), $error);
    }

    return $object;
  }

  /**
   * Wrapper around J! method, which
   * throws exceptions
   */
  public function eLoadObjectList( $key='', $className = 'stdClass') {

    $objectList = $this->loadObjectList( $key, $className);

    $error = $this->getErrorNum();

    if(!empty( $error)) {
      throw new Sh404sefExceptionDefault( $this->getErrorMsg(), $error);
    }

    return $objectList;
  }

  /**
   * Wrapper around J! method, which
   * throws exceptions
   */
  public function eQuery() {

    $status = $this->query();

    $error = empty( $status) ? $this->getErrorNum() : '';

    if(!empty( $error)) {
      $msg = $this->getErrorMsg();
      $msg = empty( $msg) ? 'Unknown database error, probably not connected' : $msg;
      throw new Sh404sefExceptionDefault( $msg, $error);
    }

    return $this;
  }

  /**
   *
   * Prepare a query, quoting or name quoting some
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
   * will return
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
  public function quoteQuery( $query, $nameQuoted = array(), $quoted = array(), $namePlaceHolder = '??', $dataPlaceHolder = '?') {

    $newQuery = '';

    // name quoting
    if(!empty( $nameQuoted)) {
      // find placeholders
      $sqlBits = explode( $namePlaceHolder, $query);
      $i = 0;
      // replace each place holder by the matching value
      foreach( $nameQuoted as $data) {
        $newQuery .= $sqlBits[$i];
        $newQuery .= $this->nameQuote( $data);
        $i += 1;
      }
      if (isset( $sqlBits[$i])) {
        $newQuery .= $sqlBits[$i];
      }
    }

    if(strpos( $newQuery, $namePlaceHolder) !== false) {
      throw new Sh404sefExceptionDefault( 'Invalid db query sent to queryQuote helper: ' . $query . '. Maybe missing some data.');
    }

    // name quoting
    if(!empty( $quoted)) {
      // find placeholders
      $sqlBits = explode( $dataPlaceHolder, $newQuery);
      $newQuery = '';
      $i = 0;
      // replace each place holder by the matching value
      foreach( $quoted as $data) {
        $newQuery .= $sqlBits[$i];
        $newQuery .= $this->_prepareData( $data);
        $i += 1;
      }
      if (isset( $sqlBits[$i])) {
        $newQuery .= $sqlBits[$i];
      }
    }

    return $newQuery;
  }

  /**
   * Prepare data to be inserted in an sql statement
   *
   * @param mixed $data
   */
  protected function _prepareData( $data) {

    // from Ron Baldwin <ron.baldwin#sourceprose.com>
    // Only quote string types
    $type = gettype( $data);
    if ($type == 'string') {
      $ret = $this->Quote( $data);
    } else if ($type == 'double') {
      $ret = str_replace( ',', '.', $data); // locales fix so 1.1 does not get converted to 1,1
    } else if ($type == 'boolean') {
      $ret = $data ? '1' : '0';
    } else if ($type == 'object') {
      if (method_exists( $data, '__toString')) {
        $ret = $this->Quote( $data->__toString());
      } else {
        $ret = $this->Quote((string) $data);
      }
    } else if ($data === null) {
      $ret = 'NULL';
    } else {
      $ret = $data;
    }

    return $ret;
  }

  /**
   * Build a where clause
   *
   * @param String $mWhere Conditions. Taken as a litteral where clause ( WHERE `amount` > 100 ).
   * @param Array $mWhere ( ie 'columnName' => 'columnValue') : a where clause is created like so : WHERE `columnName` = 'columnValue'. columnValue is escaped before being used
   * @param Array $aWhereData Used only if $aWhere is a string. In such case, '?' place holders will be replaced by this array values, escaped
   */
  protected function _buildWhereClause( $mWhere = '', $aWhereData = array()) {

    // where clause
    if (is_string( $mWhere)) {
      // litteral clause, find ? place holders
      if (!is_array( $aWhereData)) $aWhereData = array( $aWhereData);
      $holderCount = substr_count( $mWhere, '?');
      if ($holderCount = 0 || $holderCount != count ( $aWhereData)) {
        // there is no ? place holders, or their number does not match the data array passed
        throw new Sh404sefExceptionDefault( 'Internal error: trying to build invalid db query where clause [ '. serialize( $mWhere). ' ] [ ' . serialize( $aWhereData) . ' ]', 500);
      } else {
        // we have ? placeholders and their number equals that of data passed
        $where = '';

        // find placeholders
        $sqlBits = explode( '?', $mWhere);
        $i = 0;
        // replace each place holder by the matching value
        foreach( $aWhereData as $data) {
          $where .= $sqlBits[$i];
          $where .= $this->_prepareData( $data);
          $i += 1;
        }
        if (isset( $sqlBits[$i])) {
          $where .= $sqlBits[$i];
        }
      }
    } elseif (is_array( $mWhere)) {
      // an array of columns/values, we must turn into a where clause
      $where = '';
      foreach( $mWhere as $columns => $value) {
        $where .= ' AND '. $this->nameQuote( $columns) . '=' . $this->_prepareData( $value);
      }
      // remove initial AND
      $where = substr( $where, 5);
    } else {
      $where = '';
    }

    return empty( $where) ? '' : ' WHERE ' . $where;
  }

  /**
   * Builds an ORDER BY sql statement
   *
   * @param Array $orderBy, a series of column names to order by
   */
  protected function _buildOrderByClause( $orderBy) {

    if (empty( $orderBy)) {
      return '';
    }

    $clause = '';
    foreach( $orderBy as $order) {
      $clause .= ', '. $this->nameQuote( (string) $order);
    }

    // add prefix, and trim first ,
    $clause = ' ORDER BY ' . substr( $clause, 2);

    return $clause;
  }

  /**
   * Builds a LIMIT sql statement
   *
   * @param Integer $offset, the line in result set to start with
   * @param Integer $lines, the max number of lines in result set to return
   */
  protected function _buildLimitClause( $offset, $lines) {

    if (empty( $offset) && empty( $lines)) {
      return '';
    }

    $clause = ' LIMIT ';
    if (!empty( $offset)) {
      $clause .= $this->_prepareData( $offset);
    }
    if (!empty( $lines)) {
      $clause .= (empty( $offset) ? '' : ', ') . $this->_prepareData( $lines);
    }

    return $clause;
  }



}