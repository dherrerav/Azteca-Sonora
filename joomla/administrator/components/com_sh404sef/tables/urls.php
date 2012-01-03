<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: urls.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

jimport( 'joomla.database.table');


class Sh404sefTableUrls extends JTable {

  /**
   * Current row id
   *
   * @var   integer
   * @access  public
   */
  public $id = 0;

  /**
   * Current sef url hit counter
   *
   * @var   integer
   * @access  public
   */
  public $cpt = 0;

  /**
   * NON-sef url rank
   *
   * will be 0 for the main url, in case of duplicates
   *
   * @var   integer
   * @access  public
   */
  public $rank = 0;

  /**
   * SEF url
   *
   * @var   string
   * @access  public
   */
  public $oldurl = '';

  /**
   * Non-sef url associated with the alias
   *
   * @var   string
   * @access  public
   */
  public $newurl = '';

  /**
   * Date a custom url is added to DB
   * or a 404 page is recorded to db
   *
   * @var   string
   * @access  public
   */
  public $dateadd = '';

  /**
   * Object constructor
   *
   * @access protected
   * @param object $db JDatabase object
   */
  public function __construct( &$db ) {

    parent::__construct( '#__sh404sef_urls', 'id', $db);
  }

  public function check() {

    //initialize
    $this->oldurl = JString::trim($this->oldurl);
    $this->newurl = JString::trim($this->newurl);

    // check for valid URLs
    if (($this->oldurl == '')||($this->newurl == '')){
      $this->setError( JText::_('COM_SH404SEF_EMPTYURL'));
      return false;
    }

    if( JString::substr( $this->oldurl, 0, 1) == '/') {
      $this->setError( JText::_('COM_SH404SEF_NOLEADSLASH'));
      return false;
    }

    if( JString::substr( $this->newurl, 0, 9) != 'index.php') {
      $this->setError( JText::_('COM_SH404SEF_BADURL'));
      return false;
    }

    // check for pre-existing non-sef
    $this->_db->setQuery( 'SELECT id, oldurl FROM #__sh404sef_urls WHERE `newurl` LIKE '. $this->_db->Quote($this->newurl));
    $xid = $this->_db->loadObject();

    // raise error if we found a record with the same non-sef url
    // but don't if both newurl and old url are same. It means we may have changed alias list
    if ($xid && $xid->id != intval( $this->id )) {
      $this->setError( JText::_('COM_SH404SEF_URLEXIST'));
      return false;
    }

    return true;
  }

}
