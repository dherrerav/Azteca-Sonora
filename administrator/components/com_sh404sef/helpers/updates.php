<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: updates.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperUpdates {

  private static $_endPoint = 'http://versions.siliana.com';

  private static $_product = 'sh404sef';
  private static $_updateFile = 'sh404sef_updates.xml';
  private static $_config = 'sh404sef_config.xml';
  private static $_devConfig = 'sh404sef_config_dev.xml';

  // store whether doing a forced update. Reason to store it
  // is to keep _doCheck() method w/o any parameters
  // as this would otherwise prevent caching from operating
  // normally
  private static $_forced = array();

  /**
   * Obtain update information, as stored in cache
   * by checkForUpdates
   *
   */
  public function getUpdatesInfos( $forced = false) {

    // store whether doing a forced check for updates
    self::$_forced['updates'] = $forced;

    // get cache object
    $cache = & JFactory::getCache( 'sh404sef_updates');
    $cache->setLifetime( 86400); // cache result for 24 hours
    $cache->setCaching(1); // force caching on

    // empty cache if we are going to look for updates
    if($forced) {
      // clean our cache
      $cache->clean( 'sh404sef_updates');
    }

    $response = $cache->call( array( 'Sh404sefHelperUpdates', '_doCheck'));

    // find out whether we should update
    $response = Sh404sefHelperUpdates::_updateRequired( $response);

    // return response, either dummy or from cache
    return $response;

  }

  /**
   * Obtain remote configuration info
   *
   */
  public static function getRemoteConfig( $forced = false) {

    // store whether doing a forced check for updates
    self::$_forced['rconfig'] = $forced;

    // get cache object
    $cache = & JFactory::getCache( 'sh404sef_rconfig');
    $cache->setLifetime( 3600); // cache result for an hour
    $cache->setCaching(1); // force caching on

    // empty cache if we are going to look for updates
    if($forced) {
      // clean our cache
      $cache->clean( 'sh404sef_rconfig');
    }

    $response = $cache->call( array( 'Sh404sefHelperUpdates', '_doRemoteConfig'));

    // return response, either dummy or from cache
    return $response;

  }

  public function _doCheck() {

    // if not set to auto check and not forced to do so
    // when user click on "check updates" button
    // we don't actually try to get updates info
    $sefConfig = & Sh404sefFactory::getConfig();

    // prepare a default response object
    $response = new stdClass();
    $response->status = true;
    $response->statusMessage = JText::_('COM_SH404SEF_CLICK_TO_CHECK_UPDATES');
    $response->current = 0;
    $response->note = '';
    $response->changelogLink = '';
    $response->minVersionToUpgrade = 0;
    $response->maxVersionToUpgrade = 0;
    $response->shouldUpdate = false;
    $response->excludes = array();

    // check if allowed to auto check, w/o user clicking on button
    if (!$sefConfig->autoCheckNewVersion && empty(self::$_forced['updates'])) {
      return $response;
    }

    // get an http client
    require_once JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_sh404sef' . DS . 'lib' . DS . 'Zend' . DS . 'Http' . DS . 'Client.php';
    $hClient = new Sh_Zend_Http_Client;
    $hClient->setConfig( array (
    'maxredirects' => 0,
    'timeout' => 10));

    // find where to call ...
    $remoteConfig = Sh404sefHelperUpdates::getRemoteConfig( $forced = false);
    // hardcoded default update server
    $defaultServers = array( array( 'url' => self::$_endPoint . '/' . self::$_updateFile));
    // try to read from remote, central, configuration file
    $remoteServers = empty($remoteConfig->config['updateservers']) ? array() : $remoteConfig->config['updateservers'];
    // merge default and remote
    $servers = array_merge( $remoteServers, $defaultServers);
    // check for urls in both defaults and remote
    $serverList = array();
    foreach( $servers as $server) {
      $serverList[] = $server['url'];
    }
    $serverList = array_unique( $serverList);
    // now iterate over server list, until we find one that responds
    foreach( $serverList as $server) {
      
      $response->status = true;

      // actually place a call to find about available updates
      try {
        $hClient->setUri( $server);
      } catch (Exception $e){
        //  move to next update server in list
        $response->status = false;
        continue;
      }

      // request file content
      $adapters = array( 'Sh_Zend_Http_Client_Adapter_Curl', 'Sh_Zend_Http_Client_Adapter_Socket');
      $rawResponse = null;

      foreach( $adapters as $adapter) {
        try {
          $hClient->setAdapter( $adapter);
          $rawResponse = $hClient->request();
          break;
        } catch (Exception $e) {  // need that to be Exception, so as to catche Sh_Zend_Exceptions.. as well
          // we failed, let's try another method
        }
      }

      // (un)set flag if we have a response
      if (empty( $rawResponse)) {
        $response->status = false;
        $msg = 'unknown code';
        $response->statusMessage = JText::sprintf('COM_SH404SEF_COULD_NOT_CHECK_FOR_NEW_VERSION', $msg);
      } else if (!is_object( $rawResponse) || $rawResponse->isError()) {
        $response->status = false;
        $msg = method_exists( $rawResponse, 'getStatus') ? $rawResponse->getStatus() : 'unknown code';
        $response->statusMessage = JText::sprintf('COM_SH404SEF_COULD_NOT_CHECK_FOR_NEW_VERSION', $msg);
      } else {
        // communication was fine, check the file type
        $type = $rawResponse->getHeader('Content-type');
        if( strtolower( $type) != 'text/xml' && strtolower( $type) != 'application/xml') {
          $response->status = false;
          $response->statusMessage = JText::sprintf('COM_SH404SEF_COULD_NOT_CHECK_FOR_NEW_VERSION', $rawResponse->getStatus());
        }
      }

      // if there was a valid response, break out of
      // loop over available update servers
      if($response->status) {
        break;
      }
    }

    // if we were not able to contact any update server
    // return this
    if(!$response->status) {
      return $response;
    }

    // get an xml object and parse the response
    $xml = & JFactory::getXMLparser( 'Simple');
    $xml->loadString( $rawResponse->getBody());

    // into our response object
    // first version of version check used an xml file that could only hold one
    // version data set. So we only iterate over the "update" group if it exists
    if(empty( $xml->document->update)) {
      $response = self::_readUpdateInformation( $xml->document, $response);
    } else {

      foreach( $xml->document->update as $updateRecord) {
        $product = $updateRecord->product[0]->data();

        // only use if this update record is for us
        if($product == self::$_product) {

          $response = self::_readUpdateInformation( $updateRecord, $response);

          // find if user should update
          $response = Sh404sefHelperUpdates::_updateRequired( $response);

          // if found an update, break out
          if( $response->shouldUpdate) {
            break;
          }
        }
      }
    }

    // check if this is a valid information file
    return $response;
  }

  protected function _readUpdateInformation( $updateRecord, $response) {

    $response->current = $updateRecord->current[0]->data();
    $response->note = $updateRecord->note[0]->data();
    $response->changelogLink = $updateRecord->changelogLink[0]->data();
    $response->downloadLink = $updateRecord->downloadLink[0]->data();
    $response->minVersionToUpgrade = $updateRecord->minVersionToUpgrade[0]->data();
    $response->maxVersionToUpgrade = $updateRecord->maxVersionToUpgrade[0]->data();
    $rawExcludes = $updateRecord->exclude;
    $response->excludes = array();
    if (!empty( $rawExcludes)) {
      foreach( $rawExcludes as $exclude) {
        $response->excludes[] = $exclude->data();
      }
    }

    return $response;
  }

  public function _doRemoteConfig() {

    // if not set to auto check and not forced to do so
    // when user click on "check updates" button
    // we don't actually try to get updates info
    $sefConfig = & Sh404sefFactory::getConfig();

    // prepare a default response object
    $response = new stdClass();
    $response->status = true;
    $response->config = array();

    // check if allowed to read central configuration file
    if (!$sefConfig->canReadRemoteConfig) {
      return $response;
    }

    // get an http client
    require_once JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_sh404sef' . DS . 'lib' . DS . 'Zend' . DS . 'Http' . DS . 'Client.php';
    $hClient = new Sh_Zend_Http_Client;

    // request file content
    $adapters = array( 'Sh_Zend_Http_Client_Adapter_Curl', 'Sh_Zend_Http_Client_Adapter_Socket');
    $rawResponse = null;

    foreach( $adapters as $adapter) {
      try {
        // set params
        //$hClient->setUri( self::$_endPoint . '/' . self::$_devConfig);
        $hClient->setUri( self::$_endPoint . '/' . self::$_config);
        $hClient->setConfig( array (
          'maxredirects' => 0,
          'timeout' => 10));
        $hClient->setAdapter( $adapter);
        $rawResponse = $hClient->request();
        break;
      } catch (Exception $e) {  // need that to be Exception, so as to catch Sh_Zend_Exceptions.. as well
        // we failed, let's try another method
      }
    }

    // return if error
    if (empty( $rawResponse)) {
      $response->status = false;
      return $response;
    }
    if (!is_object( $rawResponse) || $rawResponse->isError()) {
      $response->status = false;
      return $response;
    }

    // check the file
    $type = $rawResponse->getHeader('Content-type');
    if( strtolower( $type) != 'text/xml' && strtolower( $type) != 'application/xml') {
      $response->status = false;
      return $response;

    }
    // should be OK then
    $response->status = true;

    // get an xml object and parse the response
    $rawConfig = simplexml_load_string( $rawResponse->getBody());

    // into our response object
    $response->config = array();
    if (!empty( $rawConfig)) {
      foreach( $rawConfig->config as $configName => $configElement) {
        foreach($configElement as $configKey => $values) {
          if(is_string( $values)) {
            $response->config[$configKey] = $values;
          } else {
            $counter = 0;
            foreach( $values as $arrayName => $arrayValues) {
              $children = $arrayValues->children();
              $count = count( $children);
              if ($count > 0) {
                foreach( $arrayValues as $key => $value) {
                  $response->config[$configKey][$counter][$key] = (string)$value;
                }
              } else {
                $response->config[$configKey][] = (string)$arrayValues;
              }
              $counter++;
            }
          }
        }
      }
    }

    // check if this is a valid information file
    return $response;
  }


  /**
   * Use response object from request to update info server
   * to find if an update is required
   *
   * @param object $response
   */
  private function _updateRequired( $response) {

    // get configuration
    $sefConfig = & Sh404sefFactory::getConfig();

    // compare versions
    $thisVersion = $sefConfig->version == '@ant_version_number@' ? '3.0.0.987654' : $sefConfig->version;
    $response->shouldUpdate = version_compare( $thisVersion, $response->current) == -1;
    $response->shouldUpdate = $response->shouldUpdate && version_compare( $thisVersion, $response->minVersionToUpgrade) == 1;
    $response->shouldUpdate = $response->shouldUpdate && (empty($response->maxVersionToUpgrade) || version_compare( $thisVersion, $response->maxVersionToUpgrade) == -1);
    if ($response->shouldUpdate) {
      // check specific versions exclusion list
      $response->shouldUpdate = $response->shouldUpdate && !in_array( $thisVersion, $response->excludes);
    }

    // build status message based on result of should update calculation
    $response->statusMessage = $response->shouldUpdate ? JText::sprintf('COM_SH404SEF_NEW_VERSION_AVAILABLE') : (JText::sprintf('COM_SH404SEF_YOU_ARE_UP_TO_DATE'));

    // return whatever we found
    return $response;

  }
}