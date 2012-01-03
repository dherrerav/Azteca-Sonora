<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Sh_Zend_Http
 * @subpackage Client_Exception
 * @version    $Id: Exception.php 1757 2011-01-30 15:53:15Z silianacom-svn $
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

defined('_JEXEC') or die('Restricted access');

/**
 * @see Sh_Zend_Http_Exception
 */
require_once sh404SEF_ADMIN_ABS_PATH . 'lib/Zend/Http/Exception.php';

/**
 * @category   Zend
 * @package    Sh_Zend_Http
 * @subpackage Client
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Sh_Zend_Http_Client_Exception extends Sh_Zend_Http_Exception
{}
