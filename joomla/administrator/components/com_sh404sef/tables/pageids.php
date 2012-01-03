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

jimport( 'joomla.database.table');


class Sh404sefTablePageids extends JTable {

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
   * pageId to the non-sef url associated with the alias
   *
   * @var   string
   * @access  public
   */
  public $pageid = '';


  /**
   * Type of alias : deprecated : aliases and pageids are stored in separate DB tables
   *
   * Can be
   *   Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS (=0) for a regular alias
   *   Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID (=1) for an auto created pageid
   *
   * @var   integer
   * @access  public
   */
  public $type = Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_PAGEID;

  /**
   * Object constructor
   *
   * @access public
   * @param object $db JDatabase object
   */
  public function __construct( &$db ) {

    parent::__construct( '#__sh404sef_pageids', 'id', $db);
  }

  function check() {

    // if existing,
    if (!empty( $this->id) ) {
      return true;
    }

    if (empty( $this->pageid) || empty( $this->newurl)) {
      return false;
    }

    // if new record, check there is no record with same pageid
    // or non-sef
    $db = &$this->getDBO();
    $query = 'select count(*) from ' . $db->nameQuote( '#__sh404sef_pageids')
    . ' where ' . $db->nameQuote( 'pageid') . '=' . $db->Quote( $this->pageid)
    . ' or ' . $db->nameQuote( 'newurl') . '=' . $db->Quote( $this->newurl);

    $db->setQuery( $query);
    $count = $db->loadResult();

    return empty( $count);
  }
}