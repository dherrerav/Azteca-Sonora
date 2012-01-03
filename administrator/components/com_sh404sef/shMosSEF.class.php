<?php
/**
 * SEO extension for Joomla! 1.6
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2009-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shMosSEF.class.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


class shMosSEF extends JTable  // updated to remove legacy mode
{

  /**
   * Error string
   *
   * @var   string
   * @access  protected
   */
  var $_error = '';

  /**
   * Error number
   *
   * @var   int
   * @access  protected
   */
  var $_errorNum = 0;

  /** @var int */
  var $id   = null;
  /** @var int */
  var $cpt  = null;
  /** @var int */
  var $rank = null;
  /** @var string */
  var $oldurl = null;
  /** @var string */
  var $newurl = null;
  /** @var tinyint */
  /** @var date */
  var $dateadd  = null;



  /**
   * Constructor
   */
  function __construct( &$db)
  {
    parent::__construct( '#__sh404sef_urls', 'id', $db );
  }

  function shMosSEF( &$_db ) {
    parent::__construct( '#__sh404sef_urls', 'id', $_db );
  }

  function check() {
    //initialize
    $this->_error = null;
    $this->oldurl = JString::trim($this->oldurl);
    $this->newurl = JString::trim($this->newurl);
    // check for valid URLs
    if (($this->oldurl == '')||($this->newurl == '')){
      $this->_error .= JTExt::_('COM_SH404SEF_EMPTYURL');
      return false;
    }
    if( JString::substr( $this->oldurl, 0, 1) == '/') {
      $this->_error .= JText::_('COM_SH404SEF_NOLEADSLASH');
    }
    if( JString::substr( $this->newurl, 0, 9) != 'index.php') {
      $this->_error .= JText::_('COM_SH404SEF_BADURL');
    }
    // V 1.2.4.t remove this check. We check for pre-existing non-sef instead of SEF
    if (is_null($this->_error)) {
      // check for existing URLS
      $this->_db->setQuery( "SELECT id,oldurl FROM #__sh404sef_urls WHERE `newurl` LIKE ".$this->_db->Quote($this->newurl));
      $xid = $this->_db->loadObject();
      // V 1.3.1 don't raise error if both newurl and old url are same. It means we may have changed alias list
      if ($xid && $xid->id != intval( $this->id )) {
        $this->_error = JText::_('COM_SH404SEF_URLEXIST');
        return false;
      }
      $identical = $xid->id == intval( $this->id ) && $xid->oldurl == $this->oldurl;
      return $identical ? 'identical' : true;
    }else{
      return false;
    }
  }

  /**
   * Legacy Method, use {@link JObject::getError()}  instead
   * @deprecated As of 1.5
   */
  function getError($i = null, $toString = true )
  {
    return $this->_error;
  }

  /**
   * Legacy Method, use {@link JObject::getError()}  instead
   * @deprecated As of 1.5
   */
  function getErrorNum()
  {
    return $this->_errorNum;
  }

}

