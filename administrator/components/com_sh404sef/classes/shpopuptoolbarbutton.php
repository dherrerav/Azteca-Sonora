<?php
/**
 * @version		$Id: shpopuptoolbarbutton.php 1840 2011-03-02 19:33:24Z silianacom-svn $
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a popup window button
 *
 * @package 	Joomla.Framework
 * @subpackage		HTML
 * @since		1.5
 */
class JButtonShpopuptoolbarbutton extends JButton
{
  /**
   * Button type
   *
   * @access	protected
   * @var		string
   */
  var $_name = 'Popup';

  function render( &$definition )
  {
    /*
     * Initialize some variables
     */
    $html = '';
    $id   = call_user_func_array(array(&$this, 'fetchId'), array($definition));
    $action = call_user_func_array(array(&$this, 'fetchButton'), $definition);

    // Build id attribute
    if ($id) {
      $id = "id=\"$id\"";
    }

    // Build the HTML Button
    $html .= "<li class=\"button\" $id>\n";
    $html .= $action;
    $html .= "</li>\n";

    return $html;
  }

  function fetchButton( $type='Popup', $name = '', $url = '#', $text = '', $msg='', $task = '', $list = true, $hideMenu = false , $popupOptions = array() )
  {

    // merge with default options
    $defaultOptions = array( 'class' => 'modal', 'size' => array('x' => 640, 'y' => 500));
    $options = array_merge( $defaultOptions, $popupOptions);

    $text	= JText::_($text);
    $class	= $this->fetchIconClass($name);
    $doTask = $this->_getCommand($msg, $name, $task, $list, $hideMenu);
    $id = $this->fetchId($name);

    $modalOptionsString = Sh404sefHelperHtml::makeSqueezeboxOptions( $options);
    $rel = ' {handler: \'iframe\'' . (empty($modalOptionsString) ? '' : ', ' . $modalOptionsString) . '}';

    $html	= "<a id=\"a-$id\" class=\"{$options['class']}\" href='$url' onclick=\"$doTask\" rel=\"$rel\">\n";
    $html .= "<span class=\"$class\" title=\"$text\">\n";
    $html .= "</span>\n";
    $html	.= "$text\n";
    $html	.= "</a>\n";

    return $html;
  }

  /**
   * Get the button id
   *
   * Redefined from JButton class
   *
   * @access		public
   * @param		string	$name	Button name
   * @return		string	Button CSS Id
   * @since		1.5
   */
  function fetchId($name)
  {
    // bug in joomla
    if (is_array($name)) {
      $name = $name[1];
    }
    return $this->_parent->getName().'-'."popup-$name";
  }

  /**
   * Get the JavaScript command for the button
   *
   * @access	private
   * @param	object	$definition	Button definition
   * @return	string	JavaScript command string
   * @since	1.5
   */
  function _getCommand($msg, $name, $task, $list, $hide)
  {
    $todo  = JString::strtolower(JText::_( $name ));
    $message = JText::sprintf( 'Please make a selection from the list to', $todo );
    $message = addslashes($message);

    if ($hide) {
      if ($list) {
        $cmd = "javascript:shStopEvent( event);if(document.adminForm.boxchecked.value==0){alert('$message');}else{shHideMainMenu();shProcessToolbarClick(this.id, '$name');}";
      } else {
        $cmd = "javascript:shStopEvent( event);shHideMainMenu();shProcessToolbarClick( this.id, '$name');";
      }
    } else {
      if ($list) {
        $cmd = "javascript:shStopEvent( event);if(document.adminForm.boxchecked.value==0){alert('$message');}else{if(confirm('$msg')){shProcessToolbarClick(this.id, '$name');}}";
      } else {
        $cmd = "javascript:shStopEvent( event);if(confirm('$msg')){shProcessToolbarClick( this.id, '$name');}";
      }
    }

    return $cmd;
  }
}
