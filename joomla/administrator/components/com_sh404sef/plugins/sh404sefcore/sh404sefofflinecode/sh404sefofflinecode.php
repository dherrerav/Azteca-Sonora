<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sh404sefofflinecode.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$mainframe = JFactory::getApplication();
$mainframe->registerEvent( 'onAfterRoute', 'plgSh404sefofflinecode' );

/**
 * Output a correct response code when site is offline
 * to let know search engines that site data
 * should not be discarded or discounted
 */
function plgSh404sefofflinecode() {

  $mainframe = JFactory::getApplication();

  // are we in the backend, or not offline ?
  if ($mainframe->isAdmin() || !$mainframe->getCfg('offline')) {
    return;
  }

  // get plugin params
  $plugin =& JPluginHelper::getPlugin('sh404sefcore', 'sh404sefofflinecode');
  $pluginParams = new JRegistry;
  $pluginParams->loadString($plugin->params);

  $disallowAdminAccess = $pluginParams->get( 'disallowAdminAccess', 0);

  if (!$disallowAdminAccess) {
    // admins are allowed, lets check if current user
    // is an admin, or if user is trying to log in
    $user=& JFactory::getUser();
    $option = JRequest::getCmd( 'option');
    $task = JRequest::getCmd( 'task');
    if ($option == 'com_users' && $task == 'user.login') {
      // Check for request forgeries
      JRequest::checkToken() or jexit( 'Invalid Token' );
      $loggingIn = true;
    } else {
      $loggingIn = false;
    }

    // if already logged inadmin, or admin logging in, let it go
    if ($user->authorize('core.manage', 'com_sh404sef') || $loggingIn) {
      return;
    }
  }

  // need to render offline screen
  if ($disallowAdminAccess) {
    // admins not allowed, use our own
    // simplified template. Most likely being hacked so
    // close doors as much as possible
    $template = '';
    $file = 'sh404sef_offline_template.php';
    $directory = JPATH_ROOT . DS . 'plugins' . DS . 'sh404sefcore';
  } else {
    // admin can access, use Joomla! offline template,
    // that includes a login form
    $template = $mainframe->getTemplate();
    $file = 'offline.php';
    $directory = JPATH_THEMES;
  }

  $params = array(
          'template'  => $template,
          'file'    => $file,
          'directory' => $directory
  );

  $document =& JFactory::getDocument();
  $data = $document->render( $mainframe->getCfg('caching'), $params);

  // header : service unavailable
  JResponse::setHeader('HTTP/1.0 503', true);

  // give it some time
  $retryAfter = $pluginParams->get( 'retry_after_delay', 7400);

  // set header
  Jresponse::setheader('Retry-After', gmdate( 'D, d M Y H:i:s', time() + $retryAfter ) . ' GMT');

  // echo document
  JResponse::setBody( $data);
  echo JResponse::toString( $mainframe->getCfg('gzip'));

  // and terminate
  $mainframe->close();

}

