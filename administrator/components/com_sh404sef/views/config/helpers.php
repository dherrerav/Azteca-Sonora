<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: helpers.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefViewHelperConfig {

  public function shTextParamHTML( $x, $pTitle, $pToolTip, $pName, $pValue, $pSize, $pLength, $w1 = '200', $w2 = '150', $type= 'text' ) {
    $output  = '<tr' . ( ( $x % 2 ) ? '' : ' class="row1"' ) . '>' . "\n"
    . '<td width="' . $w1 . '">' . $pTitle . '</td>' . "\n"
    . '<td width="' . $w2 . '"><input type="'.$type.'" name="' . $pName . '" id="' . $pName . '" value="' . $pValue .'"'
    . ' size="' . $pSize . '" maxlength="' . $pLength . '" /></td>' . "\n"
    . '<td>' . ( ( $pToolTip || $pTitle ) ? JHTML::_('tooltip', $pToolTip, $pTitle ) : '&nbsp;' ) . '</td>' . "\n"
    . '</tr>' . "\n"
    ;
    echo $output;
  }

  public function shTextHTML( $x, $pTitle, $pToolTip, $pValue, $w1 = '200', $w2 = '150', $attrBegin = '', $attrEnd = '' ) {
    $output  = '<tr' . ( ( $x % 2 ) ? '' : ' class="row1"' ) . '>' . "\n"
    . '<td width="' . $w1 . '">' . $pTitle . '</td>' . "\n"
    . '<td width="' . $w2 . '"><b>' . $attrBegin . htmlspecialchars($pValue, ENT_COMPAT, 'UTF-8') . $attrEnd . '</b>'
    . '</td>' . "\n"
    . '<td>' . ( ( $pToolTip || $pTitle ) ? JHTML::_('tooltip', $pToolTip, $pTitle ) : '&nbsp;' ) . '</td>' . "\n"
    . '</tr>' . "\n"
    ;
    echo $output;
  }

  /**
   * building a yes/no field
   *
   * @param int $x
   * @param string $pTitle
   * @param string $pToolTip
   * @param string $pName
   * @param int $w1
   * @param int $w2
   *
   * @return string
   * @since 2008.02.25 (mic): $w1, $w2, check for tooltip text
   */
  public function shYesNoParamHTML( $x, $pTitle, $pToolTip, $pName, $w1 = '200', $w2 = '150' ) {
    $output  = '<tr'. ( ( $x % 2 ) ? '' : ' class="row1"' ).">\n"
    . '<td width="' . $w1 . '">' . $pTitle . '</td>' . "\n"
    . '<td width="' . $w2 . '">' . $pName . '</td>' . "\n"
    . '<td>' . ( ( $pToolTip || $pTitle ) ? JHTML::_('tooltip', $pToolTip, $pTitle ) : '&nbsp;' ) . '</td>' . "\n"
    . '</tr>' . "\n"
    ;
    echo $output;
  }

  public function shMessageHTML( $message) {
    $ret = '<dl id="system-message">'
    . '<dt class="message">Message</dt>'
    . '<dd class="message message fade">'
    . '<ul>'
    . '<li>'
    . $message
    . '</li></ul></dd></dl>';
    return $ret;
  }

}