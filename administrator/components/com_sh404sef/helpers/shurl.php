<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shurl.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperShurl {

  public static function updateShurls() {

    $pageInfo = & Sh404sefFactory::getPageInfo();
    $sefConfig = & Sh404sefFactory::getConfig();
    $pageInfo->shURL = '';

    if ($sefConfig->enablePageId && !$sefConfig->stopCreatingShurls) {

      try {
        jimport( 'joomla.utilities.string');
        $nonSefUrl = JString::ltrim( $pageInfo->shCurrentPageNonSef, '/');
        $nonSefUrl = shSortURL( $nonSefUrl);

        // remove tracking vars (Google Analytics)
        $nonSefUrl = Sh404sefHelperGeneral::stripTrackingVarsFromNonSef( $nonSefUrl);

        // try to get the current shURL, if any
        $shURL = Sh404sefHelperDb::selectResult( '#__sh404sef_pageids', array('pageid'), array( 'newurl' => $nonSefUrl));

        // if none, we may have to create one
        if(empty( $shURL)) {
          $shURL = self::_createShurl( $nonSefUrl);
        }

        // insert in head and header, if not empty
        if(!empty( $shURL)) {
          $fullShURL = JString::ltrim( $pageInfo->getDefaultLiveSite(), '/') . '/' . $shURL;
          $document = &JFactory::getDocument();
          if($sefConfig->insertShortlinkTag) {
            $document->addHeadLink( $fullShURL, 'shortlink');
            // also add header, especially for HEAD requests
            JResponse::setHeader( 'Link', '<' . $fullShURL . '>; rel=shortlink', true );
          }
          if($sefConfig->insertRevCanTag) {
            $document->addHeadLink( $fullShURL, 'canonical', 'rev', array('type' => 'text/html'));
          }
          if($sefConfig->insertAltShorterTag) {
            $document->addHeadLink( $fullShURL, 'alternate shorter');
          }
          // store for reuse
          $pageInfo->shURL = $shURL;
        }

      } catch (Sh404sefExceptionDefault $e) {
      }
    }
  }

  protected static function _createShurl( $nonSefUrl) {

    if( empty( $nonSefUrl)) {
      return '';
    }

    // only create a shURL if current page returns a 200
    $headers = JResponse::getHeaders();

    // check if we have a status
    foreach( $headers as $header) {
      if(strtolower( $header['name']) == 'status' && $header['value'] != 200) {
        // error or redirection, don't shurl that
        return '';
      }
    }

    // check various conditions, to avoid overloading ourselves with shURL
    // not on homepage
    if( shIsAnyHomepage( $nonSefUrl)) {
      return '';
    }
    // not for format = raw, format = pdf or printing
    $format = shGetURLVar( $nonSefUrl, 'format');
    if( in_array( strtolower( $format), array( 'raw', 'pdf'))) {
      return '';
    }
    $print = shGetURLVar( $nonSefUrl, 'print');
    if($print == 1) {
      return '';
    }
    // not if tmpl not empty or not index
    $tmpl = shGetURLVar( $nonSefUrl, 'tmpl');
    if(!empty($tmpl) && $tmpl != 'index') {
      return '';
    }
     
    // force global setting
    shMustCreatePageId( 'set', true);

    // get a model and create shURL
    $model = & JModel::getInstance( 'Pageids', 'Sh404sefModel');
    $shURL = $model->createPageId( '', $nonSefUrl);

    return $shURL;

  }

}