<?php
/**
 *
 * @version   $Id: pageinfo.php 2046 2011-06-30 08:13:26Z silianacom-svn $
 * @copyright Copyright (C) 2010 Yannick Gaultier. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * Sh404sefClassShdb is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Class adding a few method to Joomla! default database class
 *
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die;

/**
 * Maintain data and handle requests about current
 * page. Accessed through factory:
 *
 * $liveSite = Sh404sefFactory::getPageInfo()->getDefaultLiveSite();
 *
 *
 * @author yannick
 *
 */
class Sh404sefClassPageinfo  {

  const LIVE_SITE_SECURE_IGNORE = 0;
  const LIVE_SITE_SECURE_YES = 1;
  const LIVE_SITE_SECURE_NO = -1;

  const LIVE_SITE_NOT_MOBILE = 0;
  const LIVE_SITE_MOBILE = 1;

  public $shURL = '';
  public $shCurrentPageNonSef = '';
  public $shCurrentPageURL = '';
  public $baseUrl = '';
  public $shMosConfig_locale = '';
  public $shMosConfig_shortcode = '';
  public $allLangHomeLink = '';
  public $homeLink = '';
  public $homeLinks = array();
  public $isMobileRequest = self::LIVE_SITE_NOT_MOBILE;

  // store our router instance
  public $router = null;

  // this will be filled up upon startup by system plugin
  // code with the current detected base site url for the request
  // ie: it can be secure, unsecure, for one language or another
  protected $_defaultLiveSite = '';

  public function setDefaultLiveSite( $url) {
    $this->_defaultLiveSite = $url;
  }

  public function getDefaultLiveSite() {
    return $this->_defaultLiveSite;
  }

  public function getDefaultFrontLiveSite() {
    return str_replace( '/administrator', '', $this->_defaultLiveSite);
  }

  public function loadHomepages() {

    $app = JFactory::getApplication();
    if($app->isAdmin()) {
      return;
    }

    // store default links in each language
    $defaultLanguage = shGetDefaultLang();
    jimport( 'joomla.language.helper');
    $languages	= JLanguageHelper::getLanguages();
    $menu = JFactory::getApplication()->getMenu();
    foreach( $languages as $language) {
      $menuItem = $menu->getDefault($language->lang_code);
      if(!empty($menuItem)) {
        $this->homeLinks[$language->lang_code] = $this->_prepareLink($menuItem, $languages);
      }
    }

    // save default link
    $this->homeLink = $this->homeLinks[$defaultLanguage];

    // find about the "All" languages home link
    $menuItem = $menu->getDefault( '*');
    if(!empty( $menuItem)) {
      $this->allLangHomeLink = $this->_prepareLink($menuItem, $languages);
    }
  }

  protected function _prepareLink( $menuItem, $languages) {

    $link = shSetURLVar( $menuItem->link, 'Itemid', $menuItem->id);
    $linkLang = shGetURLLang( $link);
    if(empty( $linkLang)) {
      // if no language in link, use current, except if 'All', in which case use actual default
      $itemLanguage = $menuItem->language == '*' ? shGetDefaultLanguageSef() : shGetIsoCodeFromName($menuItem->language);
      $link = shSetUrlVar( $link, 'lang', $itemLanguage);
    }

    return $link;
  }

}