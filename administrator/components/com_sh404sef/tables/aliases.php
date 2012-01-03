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

jimport( 'joomla.database.table');


class Sh404sefTableAliases extends JTable {

  /**
   * Current row id
   *
   * @var   integer
   * @access  public
   */
  public $id = 0;

  /**
   * Non-sef url associated with the alias
   *
   * @var   string
   * @access  public
   */
  public $newurl = '';

  /**
   * Alias to the non-sef url associated with the alias
   *
   * @var   string
   * @access  public
   */
  public $alias = '';


  /**
   * Type of alias
   *
   * Can be
   *   Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS (=0) for a regular alias
   *   Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID (=1) for an auto created pageid
   *
   * @var   integer
   * @access  public
   */
  public $type = Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS;

  /**
   * Object constructor
   *
   * @access public
   * @param object $db JDatabase object
   */
  public function __construct( &$db ) {

    parent::__construct( '#__sh404sef_aliases', 'id', $db);
  }

  /**
   * Pre-save checks
   */
  public function check() {

    // condition : we can't have 2 records with same alias. So if user
    // wants to save a record with a pre-existing alias, this has to be
    // for the same non-sef url found in the existing record, or else
    // that's an error
    // if existing,
    if (!empty( $this->id) ) {
      return true;
    }

    // if new record, check there is no record with same pageid
    // but not same non-sef
    $db = &$this->getDBO();
    $query = 'select count(*) from ' . $db->nameQuote( '#__sh404sef_aliases')
    . ' where ' . $db->nameQuote( 'alias') . '=' . $db->Quote( $this->alias)
    . ' and ' . $db->nameQuote( 'newurl') . '<>' . $db->Quote( $this->newurl);

    $db->setQuery( $query);
    $count = $db->loadResult();

    if (!empty( $count)) {
      throw new Sh404sefExceptionDefault( 'Cannot save alias : this alias already exists in the database.') ;
    }

    return empty( $count);

  }

}