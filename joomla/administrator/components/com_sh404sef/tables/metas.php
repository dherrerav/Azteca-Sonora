<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: metas.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.database.table');


class Sh404sefTableMetas extends JTable {

  /**
   * Current row id
   *
   * @var   integer
   * @access  public
   */
  public $id = 0;

  /**
   * Non-sef url associated with the meta data
   *
   * @var   string
   * @access  public
   */
  public $newurl = '';

  /**
   * Description meta
   *
   * @var   string
   * @access  public
   */
  public $metadesc = '';

  /**
   * Keywords meta
   *
   * @var   string
   * @access  public
   */
  public $metakey = '';

  /**
   * Title page meta
   *
   * @var   string
   * @access  public
   */
  public $metatitle = '';

  /**
   * Language meta
   *
   * @var   string
   * @access  public
   */
  public $metalang = '';

  /**
   * Robots meta
   *
   * @var   string
   * @access  public
   */
  public $metarobots = '';

  /**
   * Object constructor
   *
   * @access public
   * @param object $db JDatabase object
   */
  public function __construct( &$db ) {

    parent::__construct( '#__sh404sef_metas', 'id', $db);
  }

  public function check() {

    //initialize
    $this->newurl = JString::trim($this->newurl);
    $this->metadesc = JString::trim($this->metadesc);
    $this->metakey = JString::trim($this->metakey);
    $this->metatitle = JString::trim($this->metatitle);
    $this->metalang = JString::trim($this->metalang);
    $this->metarobots = JString::trim($this->metarobots);

    if ($this->newurl == '/'){
      $this->newurl = sh404SEF_HOMEPAGE_CODE;
    }

    // check for valid URLs
    if ($this->newurl == ''){
      $this->setError( COM_SH404SEF_EMPTYURL);
      return false;
    }

    if( substr( $this->newurl, 0, 9) != 'index.php') {
      $this->setError( COM_SH404SEF_BADURL);
      return false;
    }

    return true;
  }

  /**
   * Inserts a new row if id is zero or updates an existing row in the database table
   *
   * Overloaded to check for empty metas data. We don't want to store totally
   * empty values in the table. This may happen if user has cleared all fields
   * to remove existing metas, or if the url only was customized for instance
   *
   * @access public
   * @param boolean If false, null object variables are not updated
   * @return null|string null if successful otherwise returns and error message
   */
  function store( $updateNulls=false ) {

    // find if record is empty (other than id of record)
    $sum = '';
    foreach ($this->getProperties() as $k => $v) {
      if ($k != $this->_tbl_key && $k != 'newurl') {
        $sum .= $v;
      }
    }

    $k = $this->_tbl_key;
    // trying to save a new empty record, quit but return true so no error
    if (empty($sum) && empty( $this->$k)) {
      return true;
    }

    // trying to save an empty record, but record already exists.
    // we want to delete the record instead of overwriting it
    if (empty($sum)) {
      $this->delete();
      $error = $this->getError();
      return empty( $error);
    }

    return parent::store( $updateNulls);

  }

}