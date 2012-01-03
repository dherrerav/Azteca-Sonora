<?php
/**
 *
 * @version   $Id: shabstractdecorator.php 1414 2010-05-23 21:04:41Z silianacom-svn $
 * @copyright Copyright (C) 2010 Yannick Gaultier. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * shDecorator is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Class implementing the decorator design pattern
 *
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class Sh404sefClassShabstractdecorator {

  protected $_decorated;
  protected $_decoratedClass;
  protected $_decoratedIsDecorator;

  public function __construct( $decoratedObject) {

    $this->_decorated = $decoratedObject;
    $this->_decoratedClass = get_class( $decoratedObject);
    $this->_decoratedIsDecorator = is_subclass_of( $this->_decoratedClass, __CLASS__);
  }

  public function __call( $method, $arguments) {

  // only call call_user_func_array if the decorated object method exists
  // or if the decorated object is itself a decorator. If the object is NOT
  // a decorator, then $this->_decorated->$method will not exist (otherwise
  // the first part of the OR test would have succeeded). This will cause php
  // to fire a warning "call_user_func_arra() invalid call back".
  // Instead, in such a case, we will simply fire an exception
  // if the decorated object is itself a decorator, then there is no problem
  // as it will have a __call() method, and call_user_func_array will be happy with
  // that, not firing any warning
    if ( method_exists( $this->_decorated, $method) || $this->_decoratedIsDecorator) {
      return call_user_func_array( array($this->_decorated, $method), $arguments);
    } else {
      throw new Sh404sefExceptionDefault( 'Method ' . $method . ' not defined');
    }
  }

  public function __set( $property, $value) {

    $this->_decorated->$property = $value;
  }

  public function __get( $property) {

    if (property_exists( $this->_decorated, $property) || $this->_decoratedIsDecorator) {
      return $this->_decorated->$property;
    } else {
      throw new Sh404sefExceptionDefault ('Trying to get non-existent property for class ' . $this->_decoratedClass);
    }
  }

  public function __isset( $property) {

    return isset($this->_decorated->$property);
  }

  public function __unset( $property) {

    if (isset( $this->_decorated->$property) || $this->_decoratedIsDecorator) {
      unset( $this->_decorated->$property);
    }
  }


}