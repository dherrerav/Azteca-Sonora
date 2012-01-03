<?php
/**
 * SEF component for Joomla! 1.5
 *
 * @author      ARTIO s.r.o.
 * @copyright   ARTIO s.r.o., http://www.artio.cz
 * @package     JoomSEF
 * @version     3.1.0
 * @license     GNU/GPLv3 http://www.gnu.org/copyleft/gpl.html
 */

// Check to ensure this file is included in Joomla!
if (!defined('_JEXEC')) JoomSEF::CheckAccess();

jimport('joomla.plugin.helper');

class JoomSEF
{
    static $props = array();
    
    function set($name, $value)
    {
        if (!is_array(self::$props)) {
            self::$props = array();
        }
        
        $previous = self::get($name);
        self::$props[$name] = $value;
        
        return $previous;
    }
    
    function get($name, $default = null)
    {
        if (!is_array(self::$props) || !isset(self::$props[$name])) {
            return $default;
        }
        
        return self::$props[$name];
    }
    
    function build(&$uri)
    {
        $mainframe =& JFactory::getApplication();
        $config =& JFactory::getConfig();
        $sefConfig =& SEFConfig::getConfig();
        $cache =& SEFCache::getInstance();

        // trigger onSefStart patches
        $mainframe->triggerEvent('onSefStart');

        $prevLang = ''; // for correct title translations

        // do not SEF URLs with tmpl=component if set to
        if (!$sefConfig->sefComponentUrls && ($uri->getVar('tmpl') == 'component')) {
            $mainframe->triggerEvent('onSefEnd');
            return;
        }

        // check if this is site root;
        // if site is root, do not do anything else
        // except if we have to set language every time
        $vars = $uri->getQuery(true);
        if (empty($vars) && (!SEFTools::JoomFishInstalled() || !$sefConfig->alwaysUseLang)) {
            // trigger onSefEnd patches
            $mainframe->triggerEvent('onSefEnd');
            $uri = new JURI(JURI::root());
            return;
        }
        
        // check URL for junk if set to
        if ($sefConfig->checkJunkUrls) {
            $junkWords =& $sefConfig->getJunkWords();
            $seferr = false;

            if (substr($uri->getVar('option', ''), 0, 4) != 'com_') {
                $seferr = true;
            }
            elseif (count($junkWords)) {
                $exclude =& $sefConfig->getJunkExclude();

                foreach ($vars as $key => $val) {
                    if (in_array($key, $exclude)) continue;

                    // Check junk words
                    foreach ($junkWords as $word) {
                        if (is_string($val)) {
                            if (strpos($val, $word) !== false) {
                                $seferr = true;
                                break;
                            }
                        }
                    }
                    if ($seferr) break;
                }
            }

            if ($seferr) {
                // trigger onSefEnd patches
                $mainframe->triggerEvent('onSefEnd');

                // fix the path
                $path = $uri->getPath();
                if( $path[0] != '/' ) {
                    $path = JURI::base(true) . '/' . $path;
                    $uri->setPath($path);
                }

                return;
            }
        }

        if (SEFTools::JoomFishInstalled()) {
            $lang = $uri->getVar('lang');

            // if lang not set
            if (empty($lang)) {
                if ($sefConfig->alwaysUseLang) {
                    // add lang variable if set to
                    $uri->setVar('lang', SEFTools::getLangCode());
                } else {
                    // delete lang variable so it is not empty
                    $uri->delVar('lang');
                }
            }

            // get the URL's language and set it as global language (for correct translation)
            $lang = $uri->getVar('lang');
            $code = '';
            if (!empty($lang)) {
                $code = SEFTools::getLangLongCode($lang);
                if (!is_null($code)) {
                    if ($code != SEFTools::getLangLongCode()) {
                        $language =& JFactory::getLanguage();
                        $prevLang = $language->setLanguage($code);
                        $language->load();
                    }
                }
            }

            // set the live_site according to language
            if ($sefConfig->langPlacement == _COM_SEF_LANG_DOMAIN) {
                $u =& JURI::getInstance();
                $curdomain = $sefdomain = $u->getHost();

                if (!empty($lang)) {
                    if (isset($sefConfig->jfSubDomains[$lang])) {
                        $sefdomain = $sefConfig->jfSubDomains[$lang];
                        //$uri->delVar('lang');
                    }
                }

                $config =& JFactory::getConfig();
                $config->setValue('joomfish.current_host', $curdomain);
                $config->setValue('joomfish.sef_host', $sefdomain);
            }
        }

        // if there are no variables and only single language is used
        $vars = $uri->getQuery(true);
        if (empty($vars) && !isset($lang)) {
            JoomSEF::_endSef($prevLang);
            return;
        }

        $option = $uri->getVar('option');

        if (!is_null($option)) {
            $params =& SEFTools::getExtParams($option);
            
            // Check the stop rule
            $stopRule = trim($params->get('stopRule', ''));
            if( $stopRule != '' ) {
                if( preg_match('/'.$stopRule.'/', $uri->toString()) > 0 ) {
                    // Don't SEF this URL
                    $uri = JoomSEF::_createUri($uri);
                    JoomSEF::_endSef($prevLang);
                    return;
                }
            }
            
            
            $handling = $params->get('handling', '0');
            switch($handling) {
                // skipped extensions
                case '2': {
                    // Check homepage
                    if (JoomSEF::_isHomePage($uri)) {
                        $lang = $uri->getVar('lang');
                        if (empty($lang)) {
                            $uri = new JURI('index.php');
                        }
                        else {
                            $uri = new JURI('index.php?lang='.$lang);
                        }
                    }
                    
                    // Build URL
                    $uri = JoomSEF::_createUri($uri);
                    JoomSEF::_endSef($prevLang);
                    return;
                }
                // non-cached extensions
                case '1': {
                    $router = JoomSEF::get('sef.global.jrouter');
                    if( !empty($router) ) {
                        // Store language for later use
                        $uriLang = $uri->getVar('lang');
                        $uri->delVar('lang');
                        
                        // Check homepage
                        if (JoomSEF::_isHomePage($uri)) {
                            $url = 'index.php';
                        }
                        else {
                            $url = $uri->toString();
                        }
                        
                        // Build URL
                        $uri = $router->build($url);
                        
                        // Add language if needed
                        if (!is_null($uriLang)) {
                            $route = $uri->getPath();
                            $route = JoomSEF::_addLangToRoute($route, $uriLang);
                            $uri->setPath($route);
                        }
                    }
                    JoomSEF::_endSef($prevLang);
                    return;
                }
                // default handler or basic rewriting
                default: {
                    // if component has its own sef_ext plug-in included.
                    // however, prefer own plugin if exists (added by Michal, 28.11.2006)
                    $compExt = JPATH_ROOT.DS.'components'.DS.$option.DS.'router.php';
                    $ownExt = JPATH_ROOT.DS.'components'.DS.'com_sef'.DS.'sef_ext'.DS.$option.'.php';
                    // compatible extension build block
                    if (file_exists($compExt) && !file_exists($ownExt) && ($handling == '0')) {
                        // Check homepage
                        if (JoomSEF::_isHomePage($uri)) {
                            $lang = $uri->getVar('lang');
                            if (empty($lang)) {
                                $uri = new JURI('index.php');
                            }
                            else {
                                $uri = new JURI('index.php?lang='.$lang);
                            }
                            
                            // Build URL
                            $uri = JoomSEF::_createUri($uri);
                            JoomSEF::_endSef($prevLang);
                            return;
                        }
                        
                        // load the plug-in file
                        require_once($compExt);

                        // Store the language for later use
                        $uriLang = $uri->getVar('lang');
                        $uri->delVar('lang');

                        $app        =& JFactory::getApplication();
                        $menu       =& JSite::getMenu();
                        $route      = $uri->getPath();
                        $query      = $uri->getQuery(true);
                        $component  = preg_replace('/[^A-Z0-9_\.-]/i', '', $query['option']);
                        $tmp        = '';
                        
                        $function   = substr($component, 4) . 'BuildRoute';
                        $parts      = $function($query);
                        
                        $total = count($parts);
                        for ($i = 0; $i < $total; $i++) {
                            $parts[$i] = str_replace(':', '-', $parts[$i]);
                        }

                        $result = implode('/', $parts);
                        $tmp    = ($result != "") ? '/'.$result : '';

                        // build the application route
                        $built = false;
                        if (isset($query['Itemid']) && !empty($query['Itemid'])) {
                            $item = $menu->getItem($query['Itemid']);

                            if (is_object($item) && $query['option'] == $item->component) {
                                $tmp = !empty($tmp) ? $item->route.$tmp : $item->route;
                                $built = true;
                            }
                        }

                        if(!$built) {
                            $tmp = 'component/'.substr($query['option'], 4).$tmp;
                        }

                        $route .= '/'.$tmp;
                        if($app->getCfg('sef_suffix') && !(substr($route, -9) == 'index.php' || substr($route, -1) == '/')) {
                            if (($format = $uri->getVar('format', 'html'))) {
                                $route .= '.' . $format;
                                $uri->delVar('format');
                            }
                        }

                        if($app->getCfg('sef_rewrite')) {
                            // transform the route
                            $route = str_replace('index.php/', '', $route);
                        }

                        // Unset unneeded query information
                        unset($query['Itemid']);
                        unset($query['option']);
                        
                        // Add language to route if needed
                        if (!is_null($uriLang)) {
                            $route = JoomSEF::_addLangToRoute($route, $uriLang);
                        }
                        
                        //Set query again in the URI
                        $uri->setQuery($query);
                        $uri->setPath($route);
                        
                        $uri = JoomSEF::_createUri($uri);

                        JoomSEF::_endSef($prevLang);
                        return;
                    }
                    // own extension block
                    else {
                        if ($handling == '3') {
                            // Basic rewriting
                            $class = 'SefExt_Basic';
                        }
                        else {
                            if (file_exists($ownExt)) {
                                $class = 'SefExt_'.$option;
                                require_once($ownExt);
                                
                                if (!class_exists($class)) {
                                    $class = 'SefExt';
                                }
                            } else {
                                $class = 'SefExt';
                            }
                        }
                        $sef_ext = new $class();

                        // Let the extension change the url and options
                        $sef_ext->beforeCreate($uri);

                        // Ensure that the session IDs are removed
                        // If set to
                        $sid = $uri->getVar('sid');
                        if (!$sefConfig->dontRemoveSid) $uri->delVar('sid');
                        // Ensure that the mosmsg are removed.
                        $mosmsg = $uri->getVar('mosmsg');
                        $uri->delVar('mosmsg');

                        // override Itemid if set to
                        $override = $params->get('itemid', '0');
                        $overrideId = $params->get('overrideId', '');
                        if (($override != '0') && ($overrideId != '')) {
                            $uri->setVar('Itemid', $overrideId);
                        }

                        // clean Itemid if desired
                        // David: only if overriding is disabled
                        if (isset($sefConfig->excludeSource) && $sefConfig->excludeSource && ($override == '0')) {
                            $Itemid = $uri->getVar('Itemid');
                            $uri->delVar('Itemid');
                        }
                        
                        // Get nonsef and ignore vars from extension
                        list($nonSefVars, $ignoreVars) = $sef_ext->getNonSefVars($uri);
                        
                        // Create array of all the non sef vars
                        $nonSefVars = SEFTools::getNonSefVars($uri, $nonSefVars, $ignoreVars);
                        
                        // Create a copy of JURI object
                        $uri2 = clone($uri);
                        
                        // Remove nonsef variables from our JURI copy
                        $nonSefUrl = SEFTools::RemoveVariables($uri2, array_keys($nonSefVars));
                        
                        // Check homepage
                        if (JoomSEF::_isHomePage($uri2, true)) {
                            $title = array();
                            $data = JoomSEF::_sefGetLocation($uri, $title, null, null, null, $uri->getVar('lang'));
                            $uri = JoomSEF::_storeLocation($data);
                            JoomSEF::_endSef($prevLang);
                            return;
                        }

                        $url = JoomSEF::_uriToUrl($uri2);

                        // try to get url from cache
                        $sefUrl = false;
                        if ($sefConfig->useCache) {
                            $sefUrl = $cache->GetSefUrl($url);
                        }
                        if (!$sefConfig->useCache || !$sefUrl) {
                            // check if the url is already saved in the database
                            $sefUrl = $sef_ext->getSefUrlFromDatabase($uri2);
                            
                            if (is_string($sefUrl)) {
                                // Backward compatibility
                                $sefstring = $sefUrl;
                                $sefUrl = new stdClass();
                                $sefUrl->sefurl = $sefstring;
                                $sefUrl->sef = 1;
                            }
                        }

                        if (!$sefUrl) {
                            // rewrite the URL, creating new JURI object
                            $data = $sef_ext->create($uri);
                            if (is_object($data) && is_a($data, 'JURI')) {
                                // Backwards compatibility
                                $uri = $data;
                            }
                            else {
                                $uri = JoomSEF::_storeLocation($data);
                            }
                        } else {
                            // if SEF is disabled, don't SEF
                            if (isset($sefUrl->sef) && !$sefUrl->sef) {
                                $uri = JoomSEF::_createUri($uri);
                                JoomSEF::_endSef($prevLang);
                                return;
                            }
                            
                            // Create new JURI object from $sefstring
                            $url = JURI::root();

                            if (substr($url, -1) != '/') {
                                $url .= '/';
                            }
                            $url .= $sefUrl->sefurl;
                            
                            // Add nonSef part if set
                            if( !empty($nonSefUrl) ) {
                                $url .= '?'.$nonSefUrl;
                            }
                            
                            // Add fragment if set
                            $fragment = $uri->getFragment();
                            if (!empty($fragment)) {
                                $url .= '#'.$fragment;
                            }
                            
                            $uri = new JURI($url);
                        }

                        // reconnect the sid to the url
                        if (!empty($sid) && !$sefConfig->dontRemoveSid) $uri->setVar('sid', $sid);
                        // reconnect mosmsg to the url
                        if (!empty($mosmsg)) $uri->setVar('mosmsg', $mosmsg);

                        // reconnect ItemID to the url
                        // David: only if extension doesn't set its own Itemid through overrideId parameter
                        if (isset($sefConfig->excludeSource) && $sefConfig->excludeSource && $sefConfig->reappendSource && ($override == '0') && !empty($Itemid)) {
                            $uri->setVar('Itemid', $Itemid);
                        }

                        // let the extension change the resulting SEF url
                        $sef_ext->afterCreate($uri);
                    }
                }
            }
        }
        else if (!is_null($uri->getVar('Itemid'))) {
            // there is only Itemid present - we must override the Ignore multiple sources option
            $oldIgnore = $sefConfig->ignoreSource;
            $sefConfig->ignoreSource = 0;

            $title = array();
            $title[] = JoomSEF::_getMenuTitle(null, null, $uri->getVar('Itemid'));

            $data = JoomSEF::_sefGetLocation($uri, $title, null, null, null, $uri->getVar('lang'));
            $uri = JoomSEF::_storeLocation($data);

            $sefConfig->ignoreSource = $oldIgnore;
        }

        JoomSEF::_endSef($prevLang);
    }

    function _addLangToRoute($route, $lang)
    {
        if (!SEFTools::JoomFishInstalled()) {
            return $route;
        }
        
        $sefConfig = SEFConfig::getConfig();
        
        if (($sefConfig->mainLanguage == '0') || ($lang != $sefConfig->mainLanguage)) {
            switch ($sefConfig->langPlacement)
            {
                case _COM_SEF_LANG_PATH:
                    if (!empty($route)) {
                        if ($route[0] == '/') {
                            $route = '/' . $lang . $route;
                        }
                        else {
                            $route = $lang . '/' . $route;
                        }
                    }
                    else {
                        $route = $lang;
                    }
                    break;
                case _COM_SEF_LANG_SUFFIX:
                    if (empty($route)) {
                        $route = $lang;
                    }
                    else {
                        // Is there some suffix?
                        $dotPos = strrpos($route, '.');
                        if ($dotPos === false) {
                            // No suffix
                            $route .= '_'.$lang;
                        }
                        else {
                            // There may be a suffix, try to find the rightmost slash and check its position
                            $slashPos = strrpos($route, '/');
                            if (($slashPos === false) || ($slashPos < $dotPos)) {
                                // Suffix
                                $route = substr($route, 0, $dotPos) . '_' . $lang . substr($route, $dotPos);
                            }
                            else {
                                // Not a suffix
                                $route .= '_'.$lang;
                            }
                        }
                    }
                    break;
            }
        }
        
        return $route;
    }
    
    function _parseLangFromRoute(&$route)
    {
        if (!SEFTools::JoomFishInstalled()) {
            return null;
        }
        
        $sefConfig = SEFConfig::getConfig();
        
        $lang = null;
        if (empty($route)) {
            return $lang;
        }
        
        switch ($sefConfig->langPlacement)
        {
            case _COM_SEF_LANG_PATH:
                // Get the first part of route
                $parts = explode('/', $route);
                $part = trim($parts[0]);
                if (!is_null(SEFTools::getLangLongCode($part))) {
                    $lang = $part;
                    
                    // Remove language from route
                    $route = substr($route, strlen($part) + 1);
                }
                break;
                
            case _COM_SEF_LANG_SUFFIX:
                $scorePos = strrpos($route, '_');
                
                if ($scorePos === false) {
                    // No underscore
                    $part = $route;
                    $newRoute = '';
                }
                else {
                    // Try to find suffix
                    $dotPos = strrpos($route, '.');
                    
                    if (($dotPos === false) || ($dotPos < $scorePos)) {
                        // No suffix
                        $part = substr($route, $scorePos + 1);
                        $newRoute = substr($route, 0, $scorePos);
                    }
                    else {
                        // Remove suffix
                        $part = substr($route, $scorePos + 1, $dotPos - $scorePos - 1);
                        $newRoute = substr($route, 0, $scorePos) . substr($route, $dotPos);
                    }
                }
                
                if (!is_null(SEFTools::getLangLongCode($part))) {
                    $lang = $part;
                    $route = $newRoute;
                }
                break;
        }

        return $lang;
    }
    
    function parse(&$uri)
    {
        $mainframe =& JFactory::getApplication();
        
        // test for the backlink plugin to work correctly
        if (JPluginHelper::isEnabled('system', 'backlink')) { // && $uri->getQuery() ) {    // commented out - causing problems
            $joomlaRequest = urldecode($_SERVER['REQUEST_URI']);
            $realRequest = $uri->toString(array('path', 'query'));
            
            if ($realRequest != $joomlaRequest) {
                $uri = new JURI($joomlaRequest);
            }
        }

        // store the old URI before we change it in case we will need it
        // for default Joomla SEF
        $oldUri = new JURI($uri->toString());

        $sefConfig =& SEFConfig::getConfig();

        // load patches
        JPluginHelper::importPlugin('sefpatch');

        // trigger onSefLoad patches
        $mainframe->triggerEvent('onSefLoad');

        // get path
        $path = $uri->getPath();

        // remove basepath
        $path = substr_replace($path, '', 0, strlen(JURI::base(true)));

        // remove slashes
        $path = ltrim($path, '/');

        // Redirect the index.php (need to check this before index.php removal)
        if ($sefConfig->fixIndexPhp && ($path == 'index.php') && (count($_POST) == 0)) {
            $q = $uri->getQuery(true);
            if (count($q) == 0) {
                $newUrl = JURI::root();
                if (substr($newUrl, -1) != '/') {
                    $newUrl .= '/';
                }
                $mainframe->redirect($newUrl, '', 'message', true);
                exit();
            }
        }
        
        // Try the 301 Alias redirect
        if (count($_POST) == 0) {
            JoomSEF::_parseAlias($path, $uri->getQuery(true));
        }
        
        // Disable non-SEF redirect for index2.php links
        // EDIT: don't even parse index2.php links!
        if (substr($path, 0, 10) == 'index2.php') {
            //$sefConfig->nonSefRedirect = false;
            return $uri->getQuery(true);
        }
        
        // Redirect old /index.php/ links if set to
        if ($sefConfig->fixIndexPhp && (substr($path, 0, 10) == 'index.php/') && (count($_POST) == 0)) {
            $newUrl = JURI::root();
            if (substr($newUrl, -1) != '/') {
                $newUrl .= '/';
            }
            $newUrl .= substr($path, 10);
            $mainframe->redirect($newUrl, '', 'message', true);
            exit();
        }
        
        // remove prefix (both index.php and index2.php)
        $path = preg_replace('/^index2?.php/i', '', $path);

        // remove slashes again to be sure there aren't any left
        $path = ltrim($path, '/');

        // replace spaces with our replacement character
        // (mainly for '+' handling, but may be useful in some other situations too)
        $path = str_replace(' ', $sefConfig->replacement, $path);

        // set the route
        $uri->setPath($path);

        // host name handling
        if (SEFTools::JoomFishInstalled() && ($sefConfig->langPlacement == _COM_SEF_LANG_DOMAIN) && !JPluginHelper::isEnabled('system', 'jfrouter')) {
            // different domains for languages handling
            $host = $uri->toString(array('host'));
            $host = trim($host, '/');

            $code = null;
            foreach ($sefConfig->jfSubDomains as $langCode => $domain) {
                if ($host == $domain) {
                    // if main language is not selected, use the first corresponding domain
                    if ($sefConfig->mainLanguage == '0') {
                        $code = $langCode;
                        break;
                    }
                    // main language is selected, use domain only if code is not already set,
                    // or the domain corresponds to main language
                    else {
                        if ($langCode == $sefConfig->mainLanguage) {
                            $code = $langCode;
                            break;
                        }
                        else if (is_null($code)) {
                            $code = $langCode;
                        }
                    }
                }
            }
            
            // we found a matching domain
            if (!is_null($code)) {
                JRequest::setVar('lang', $code);
                $config =& JFactory::getConfig();
                $config->set('joomsef.domain_lang', $code);
            }
        }

        // parse the url
        $vars = JoomSEF::_parseSefUrl($uri, $oldUri);

        // handle custom site name for extensions
        if (isset($vars['option'])) {
            $params =& SEFTools::getExtParams($vars['option']);

            $useSitename = $params->get('useSitename', '1');
            $customSitename = trim($params->get('customSitename', ''));

            $config =& JFactory::getConfig();

            if ($useSitename == '0') {
                // don't use site name
                $config->setValue('sitename', '');
            }
            elseif (!empty($customSitename)) {
                // use custom site name
                $config->setValue('sitename', $customSitename);
            }
        }

        // trigger onSefUnload patches
        $mainframe->triggerEvent('onSefUnload');

        return $vars;
    }

    function _determineLanguage($getLang = null, $redir = false, $useMainLang = false)
    {
        // set the language for JoomFish
        if (SEFTools::JoomFishInstalled()) {
            $sefConfig =& SEFConfig::getConfig();
            $registry =& JFactory::getConfig();

            // Check if the Jfrouter is enabled
            $jfrouterEnabled = JPluginHelper::isEnabled('system', 'jfrouter');
            
            // save the default language of the site if needed
            if( !$jfrouterEnabled ) {
                $locale = $registry->getValue('config.language');
                $GLOBALS['mosConfig_defaultLang'] = $locale;
                $registry->setValue("config.defaultlang", $locale);
            }

            // get instance of JoomFishManager to obtain active language list and config values
            $jfm =&  JoomFishManager::getInstance();

            // Get language from request
            if (!empty($getLang)) {
                $lang = $getLang;
            }
            
            // Try to get language code from JF cookie
            if ($sefConfig->jfLangCookie) {
                $jfCookie = JRequest::getVar('jfcookie', null, 'COOKIE');
                if( isset($jfCookie['lang']) ) {
                    $cookieCode = $jfCookie['lang'];
                }
            }
            
            // Try to find language from browser settings
            if( $sefConfig->jfBrowserLang && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) {
                $active_iso = array();
                $active_isocountry = array();
                $active_code = array();
                $activeLanguages = $jfm->getActiveLanguages();

                if( count( $activeLanguages ) > 0 ) {
                    foreach ($activeLanguages as $alang) {
                        $active_iso[] = $alang->iso;
                        if( preg_match('/[_-]/i', $alang->iso) ) {
                            $iso = str_replace('_', '-', $alang->iso);
                            $isocountry = explode('-', $iso);
                            $active_isocountry[] = $isocountry[0];
                        }
                        $active_code[] = $alang->shortcode;
                    }

                    // figure out which language to use - browser languages are based on ISO codes
                    $browserLang = explode(',', $_SERVER["HTTP_ACCEPT_LANGUAGE"]);

                    foreach ($browserLang as $blang) {
                        if( in_array($blang, $active_iso) ) {
                            $client_lang = $blang;
                            break;
                        }
                        $shortLang = substr( $blang, 0, 2 );
                        if (in_array($shortLang, $active_isocountry)) {
                            $client_lang = $shortLang;
                            break;
                        }

                        // compare with code
                        if (in_array($shortLang, $active_code)) {
                            $client_lang = $shortLang;
                            break;
                        }
                    }

                    if (!empty($client_lang)) {
                        if( strlen($client_lang) == 2 ) {
                            $browserCode = SEFTools::getLangLongCode($client_lang);
                        }
                        else {
                            $browserCode = $client_lang;
                        }
                    }
                }
            }
            
            if (!$jfrouterEnabled &&
                $redir &&
                ($sefConfig->langPlacement != _COM_SEF_LANG_DOMAIN) &&
                (isset($cookieCode) || isset($browserCode)) &&
                ($sefConfig->mainLanguage != '0'))
            {
                if (isset($cookieCode)) {
                    $sc = SEFTools::getLangCode($cookieCode);
                }
                else {
                    $sc = SEFTools::getLangCode($browserCode);
                }
                
                // Check the referer to see if we should redirect
                $shouldRedir = false;
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $refUri = new JURI($_SERVER['HTTP_REFERER']);
                    $uri = JURI::getInstance();
                    $refHost = $refUri->getHost();
                    $host = $uri->getHost();
                    
                    if ($refHost != $host) {
                        $shouldRedir = true;
                    }
                }
                else {
                    $shouldRedir = true;
                }
                
                if ($shouldRedir) {
                    if ((!empty($lang) && ($sc != $lang)) || (empty($lang) && ($sc != $sefConfig->mainLanguage))) {
                        // Redirect to correct site
                        $mainframe =& JFactory::getApplication();
                        $href = JRoute::_('index.php?lang='.$sc, false);
                        $mainframe->redirect($href);
                        exit();
                    }
                }
            }
            
            // Check if language is selected
            if (empty($lang) && !$jfrouterEnabled) {
                // If route and query string are empty, use the main language
                // note: removed  && $redir  - it was not possible to switch language to main language
                // on other page than homepage (let's see if it causes any other problem)
                // note: added $useMainLang - now it should work for both the VM checkout and using
                // main language with component's own router
                if ($useMainLang && (empty($code) || !JLanguage::exists($code))) {
                    if( ($sefConfig->mainLanguage != '0') ) {
                        $code = SEFTools::GetLangLongCode($sefConfig->mainLanguage);
                    }
                }
                
                // Try to get language code from JF cookie
                if (empty($code) || !JLanguage::exists($code)) {
                    if (isset($cookieCode)) {
                        $code = $cookieCode;
                    }
                }

                // Try to get language from browser if needed
                if (empty($code) || !JLanguage::exists($code)) {
                    if (isset($browserCode)) {
                        $code = $browserCode;
                    }
                }
                
                // Get language from configuration if needed
                if (empty($code) || !JLanguage::exists($code)) {
                    if( ($sefConfig->mainLanguage != '0') ) {
                        $code = SEFTools::GetLangLongCode($sefConfig->mainLanguage);
                    }
                }

                // Get default language if needed
                if (empty($code) || !JLanguage::exists($code)) {
                    $code = $registry->getValue('config.language');
                }
            }

            // get language long code if needed
            if (empty($code)) {
                if (empty($lang)) {
                    return;
                }
                
                $code = SEFTools::getLangLongCode($lang);
            }

            if (!empty($code)) {
                $jfrparams = $registry->getValue('jfrouter.params');
                
                // set the site language
                $resetLang = false;
                if( $code != SEFTools::getLangLongCode() ) {
                    if (!$jfrouterEnabled || ($jfrouterEnabled && $jfrparams->get('sefordomain', 'sefprefix') == 'sefprefix')) {
                        $language =& JFactory::getLanguage();
                        $language->setLanguage($code);
                        $language->load();
    
                        // set the backward compatible language
                        $backLang = $language->getBackwardLang();
                        $GLOBALS['mosConfig_lang'] = $backLang;
                        $registry->setValue("config.lang", $backLang);
                        
                        $resetLang = true;
                    }
                }

                // set joomfish language if needed
                if( $resetLang || !$jfrouterEnabled ) {
                    $jfLang = TableJFLanguage::createByJoomla($code);
                    $registry->setValue("joomfish.language", $jfLang);
    
                    // set some more variables
                    $mainframe =& JFactory::getApplication();
                    $registry->setValue("config.multilingual_support", true);
                    $mainframe->setUserState('application.lang',$jfLang->code);
                    $registry->setValue("config.jflang", $jfLang->code);
                    $registry->setValue("config.lang_site",$jfLang->code);
                    $registry->setValue("config.language",$jfLang->code);
                    $registry->setValue("joomfish.language",$jfLang);
    
            		// overwrite global config with values from $jfLang if set to in JoomFish
            		$jfparams = JComponentHelper::getParams("com_joomfish");
            		$overwriteGlobalConfig = $jfparams->get( 'overwriteGlobalConfig', 0 );
            		if($overwriteGlobalConfig ) {
            			// We should overwrite additional global variables based on the language parameter configuration
            			$langParams = new JParameter( $jfLang->params );
            			$paramarray = $langParams->toArray();
            			foreach ($paramarray as $key=>$val) {
            				$registry->setValue("config.".$key,$val);
            	
            				if (defined("_JLEGACY")){
            					$name = 'mosConfig_'.$key;
            					$GLOBALS[$name] = $val;
            				}
            			}
            		}
            		
                    // set the cookie with language
                    if ((!$jfrouterEnabled && $sefConfig->jfLangCookie) ||
                        ($jfrouterEnabled && $jfrparams->get('enableCookie', 1))) {
            			setcookie( "lang", "", time() - 1800, "/" );
            			setcookie( "jfcookie", "", time() - 1800, "/" );
            			setcookie( "jfcookie[lang]", $code, time()+24*3600, '/' );
                    }
                }
            }
        }
    }

    function _parseSefUrl(&$uri, &$oldUri)
    {
        $mainframe =& JFactory::getApplication();

        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();

        $route = $uri->getPath();
        $oldRoute = $jSef = str_replace(' ', '+', urldecode($oldUri->getPath()));
        $oldRoute = ltrim($oldRoute, '/');

        //Get the variables from the uri
        $vars = $uri->getQuery(true);
        
        // Should we generate canonical link automatically?
        $generateCanonical = (count($vars) > 0);
        
        // handle an empty URL (special case)
        if (empty($route)) {
            if (count($vars) > 0 || count($_POST) > 0) {
                $redir = false;
            }
            else {
                $redir = true;
            }
            JoomSEF::_determineLanguage(JRequest::getVar('lang'), $redir, $redir);

            $menu  =& JSite::getMenu(true);

            // if route is empty AND option is set in the query, assume it's non-sef url, and parse apropriately
            if (isset($vars['option']) || isset($vars['Itemid'])) {
                return JoomSEF::_parseRawRoute($uri);
            }
            
            $item = $menu->getDefault();

            //Set the information in the request
            $vars = $item->query;

            //Get the itemid
            $vars['Itemid'] = $item->id;

            // Set the active menu item
            $menu->setActive($vars['Itemid']);
            
            // Create automatic canonical link if set to
            if ($generateCanonical) {
                $extAuto = 2;
                if (isset($vars['option'])) {
                    $params =& SEFTools::getExtParams($vars['option']);
                    $extAuto = $params->get('autoCanonical', 2);
                }
                $autoCanonical = ($extAuto == 2) ? $sefConfig->autoCanonical : $extAuto;
                
                if ($extAuto) {
                    JoomSEF::set('sef.link.canonical', JURI::root());
                }
            }

            // MetaTags for frontpage
            $db->setQuery("SELECT `id` FROM `#__plugins` WHERE `element` = 'joomsef' AND `folder` = 'system' AND `published` = '1'");
            if ($db->loadResult()) {
                // ... and frontpage has meta tags
                // If JoomFish installed, get all the URLs for frontpage and try to find the correct language
                $lang = JRequest::getVar('lang');
                $query = "SELECT * FROM `#__sefurls` WHERE (`sefurl` = '' OR `sefurl` = 'index.php') AND `trashed` = '0'";
                if (SEFTools::JoomFishInstalled() && !is_null($lang)) {
                    $db->setQuery($query);
                    $sefRows = $db->loadObjectList();
                    
                    if (is_array($sefRows) && (count($sefRows) > 0)) {
                        $noLang = null;
                        foreach ($sefRows as $row) {
                            if (preg_match('/[?&]lang='.$lang.'($|&)/', $row->origurl) > 0) {
                                $sefRow = $row;
                                break;
                            }
                            
                            // Save the first URL with no lang variable
                            if (is_null($noLang)) {
                                if (preg_match('/[?&]lang=[^&]*/', $row->origurl) == 0) {
                                    $noLang = $row;
                                }
                            }
                        }
                        
                        // If not found, try to use the one without lang variable
                        if (empty($sefRow) && !is_null($noLang)) {
                            $sefRow = $noLang;
                        }
                    }
                }
                else {
                    // Try to find it the old way
                    $db->setQuery($query . ' LIMIT 1');
                    $sefRow = $db->loadObject();
                }
                if( !empty($sefRow) ) {
                    $mainframe =& JFactory::getApplication();
                    if (!empty($sefRow->metatitle))  JoomSEF::set('sef.meta.title', $sefRow->metatitle);
                    if (!empty($sefRow->metadesc))   JoomSEF::set('sef.meta.desc', $sefRow->metadesc);
                    if (!empty($sefRow->metakey))    JoomSEF::set('sef.meta.key', $sefRow->metakey);
                    if (!empty($sefRow->metalang))   JoomSEF::set('sef.meta.lang', $sefRow->metalang);
                    if (!empty($sefRow->metarobots)) JoomSEF::set('sef.meta.robots', $sefRow->metarobots);
                    if (!empty($sefRow->metagoogle)) JoomSEF::set('sef.meta.google', $sefRow->metagoogle);
                    if (!empty($sefRow->canonicallink)) JoomSEF::set('sef.link.canonical', $sefRow->canonicallink);
                    if (!empty($sefRow->metacustom)) {
                        $metacustom = @unserialize($sefRow->metacustom);
                        if (!empty($metacustom)) {
                            JoomSEF::set('sef.meta.custom', $metacustom);
                        }
                    }
                }
            }

            return $vars;
        }

        $disabled = false;
        $sef_ext = new SefExt();
        $newVars = $sef_ext->revert($route, $disabled);

        // We need to determine language BEFORE Joomla SEO
        // so the menu is translated correctly
        $config =& JFactory::getConfig();
        $lang = $config->get('joomsef.domain_lang');
        if (empty($lang)) {
            $lang = (isset($newVars['lang']) ? $newVars['lang'] : (isset($vars['lang']) ? $vars['lang'] : null));
        }

        // If the URL was not parsed and we do not have a language, try to
        // parse it from URL in case the default router was used
        if (empty($newVars) && empty($lang) && SEFTools::JoomFishInstalled()) {
            $lang = JoomSEF::_parseLangFromRoute($route);
            if (!is_null($lang)) {
                $langRoute = $route;
            }
        }
        
        JoomSEF::_determineLanguage($lang, false, true);

        if (!empty($newVars) && !empty($vars)) {
            // If this was SEF url, consider the vars in query as nonsef
            $nonsef = array_diff_key($vars, $newVars);
            if (!empty($nonsef)) {
                JoomSEF::set('sef.global.nonsefvars', $nonsef);
            }
        }

        // try to parse joomla native seo
        if ($sefConfig->parseJoomlaSEO && empty($newVars)) {
            $oldUrl = $oldUri->toString(array('path', 'query', 'fragment'));
            if (isset($langRoute)) {
                $oldUri->setPath($langRoute);
            }
            $router = JoomSEF::get('sef.global.jrouter');
            $jvars = $router->parse($oldUri);
            if (!empty($jvars['option']) || !empty($jvars['Itemid'])) {
                // Try to get the SEF URL
                $oldDisable = $sefConfig->disableNewSEF;
                $sefConfig->disableNewSEF = true;
    
                // Remove the default format if set
                if (isset($jvars['format']) && ($jvars['format'] == 'html')) {
                    unset($jvars['format']);
                }
                
                $jUri = new JURI('index.php');
                $jUri->setQuery($jvars);
                $jUrl = $jUri->toString(array('path', 'query', 'fragment'));
                $jSef = JRoute::_($jUrl);
                $jSef = str_replace('&amp;', '&', $jSef);
                
                // Fix the spaces
                $oldUrl = str_replace(' ', '+', $oldUrl);
                $jSef = str_replace(' ', '+', urldecode($jSef));

                // Restore the configuration
                $sefConfig->disableNewSEF = $oldDisable;
                
                // Redirect if possible
                if ($sefConfig->redirectJoomlaSEF && (count($_POST) == 0)) {
                    // Non-SEF redirect
                    if ((strpos($jSef, 'index.php?') === false) && ($oldUrl != $jSef)) {
                        // Check start/limitstart - we don't want to redirect if this is the only difference
                        if (str_replace('limitstart=', 'start=', $oldUrl) != str_replace('limitstart=', 'start=', $jSef)) {
                            // Seems the URL is SEF, let's redirect
                            $f = $l = '';
                            if( !headers_sent($f, $l) ) {
                                $mainframe =& JFactory::getApplication();
                                $mainframe->redirect($jSef, '', 'message', true);
                                exit();
                            } else {
                                JoomSEF::_headers_sent_error($f, $l, __FILE__, __LINE__);
                            }
                        }
                    }
                }
                
                // Redirect was not possible
                /* removed - causing problems
                // Check to see if the component is handled by the default joomla router
                if (!isset($jvars['option'])) {
                    // Get the option from menu item
                    $menu =& JSite::getMenu(true);
                    $item =& $menu->getItem($jvars['Itemid']);
                    
                    if (!is_null($item) && isset($item->query['option']))
                    {
                        $jopt = $item->query['option'];
                    }
                }
                else {
                    $jopt = $jvars['option'];
                }
                
                if (isset($jopt)) {
                    $jparams = SEFTools::getExtParams($jopt);
                    // Default Joomla router in use?
                    if ($jparams->get('handling', '0') == '1') {
                        // OK, we can show the page for this component
                        $newVars = $jvars;
                    }
                    // JoomSEF router used?
                    else if ($jparams->get('handling', '0') == '0') {
                    	// We can show the page only if there is no JoomSEF extension installed
                    	$ownExt = JPATH_ROOT.DS.'components'.DS.'com_sef'.DS.'sef_ext'.DS.$jopt.'.php';
                    	if (!file_exists($ownExt)) {
                    		$newVars = $jvars;
                    	}
                    }
                }
                */
                
                // We should show the page, but use the canonical link if SEF exists but redirection was not possible
                $newVars = $jvars;
                if ((strpos($jSef, 'index.php?') === false) && ($oldUrl != $jSef)) {
                    $jSef = rtrim(JURI::root(), '/') . '/' . ltrim($jSef, '/');
                    JoomSEF::set('sef.link.canonical', $jSef);
                }
            }
        }

        if (!empty($vars)) {
            // append the original query string because some components
            // (like SMF Bridge and SOBI2) use it
            $vars = array_merge($vars, $newVars);
        } else {
            $vars = $newVars;
        }

        if (!empty($newVars) && !$disabled) {
            // Parsed correctly and enabled
            JoomSEF::_sendHeader('HTTP/1.0 200 OK');
            
            // Create automatic canonical link if set to and it is not already set
            $canonical = JoomSEF::get('sef.link.canonical');
            if ($generateCanonical && empty($canonical)) {
                $extAuto = 2;
                if (isset($vars['option'])) {
                    $params =& SEFTools::getExtParams($vars['option']);
                    $extAuto = $params->get('autoCanonical', 2);
                }
                $autoCanonical = ($extAuto == 2) ? $sefConfig->autoCanonical : $extAuto;
                
                if ($extAuto) {
                    $canonical = rtrim(JURI::root(), '/') . '/' . $oldRoute;
                    JoomSEF::set('sef.link.canonical', $canonical);
                }
            }
        }
        else
        {
            // set nonsef vars
            JoomSEF::set('sef.global.nonsefvars', $vars);

            // bad URL, so check to see if we've seen it before
            // 404 recording (only if enabled)
            if ($sefConfig->record404) {
                $query = 'SELECT `id` FROM `#__sefurls` WHERE `sefurl` = '.$db->Quote($oldRoute)." AND `trashed` = '0'";
                $db->setQuery($query);
                $resultId = $db->loadResult();

                if ($resultId) {
                    // we have it, so update counter
                    $db->setQuery("UPDATE `#__sefurls` SET `cpt`=(`cpt`+1) WHERE `id` = '{$resultId}'");
                    $db->query();
                }
                else {
                    // get trace info
                    if (@$sefConfig->trace) {
                        $traceinfo = $db->Quote(JoomSEF::_getDebugInfo($sefConfig->traceLevel, true));
                    }
                    else $traceinfo = "NULL";        
                    
                    // record the bad URL
                    $query = 'INSERT INTO `#__sefurls` (`cpt`, `sefurl`, `origurl`, `trace`, `dateadd`) '
                    . " VALUES ('1', ".$db->Quote($oldRoute).", '', {$traceinfo}, CURDATE())";
                    $db->setQuery($query);
                    $db->query();
                }
            }

            // redirect to the error page
            $vars = JoomSEF::_get404vars($route);
        }
        
        // Set QUERY_STRING if set to
        if ($sefConfig->setQueryString) {
            $qs = array();
            foreach ($vars as $name => $val) {
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        $qs[] = $name . '[' . $k . ']=' . urlencode($v);
                    }
                }
                else {
                    $qs[] = $name . '=' . urlencode($val);
                }
            }
            $qs = implode('&', $qs);
            if (!empty($qs)) {
                $_SERVER['QUERY_STRING'] = $qs;
            }
        }

        return $vars;
    }
    
    function _get404vars($route = '')
    {
        $mainframe =& JFactory::getApplication();
        
        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();
        
        // Send 404 header
        JoomSEF::_sendHeader('HTTP/1.0 404 Not Found');
        
        // you MUST create a static content page with the title 404 for this to work properly
        if ($sefConfig->showMessageOn404) {
            $mosmsg = 'FILE NOT FOUND: '.$route;
            $mainframe->enqueueMessage($mosmsg);
        }
        else $mosmsg = '';

        $sefConfig->page404 = intval($sefConfig->page404);
        if ($sefConfig->page404 == _COM_SEF_404_DEFAULT) {
            $sql = 'SELECT `id` FROM `#__content` WHERE `title`= "404"';
            $db->setQuery($sql);

            if (($id = $db->loadResult())) {
                $vars['option'] = 'com_content';
                $vars['view'] = 'article';
                $vars['id'] = $id;
            }
            else {
                // Article does not exist, show standard Joomla error
                JError::raiseError(404, JText::_('Not found'));
            }
        }
        elseif ($sefConfig->page404 == _COM_SEF_404_FRONTPAGE) {
            $menu  =& JSite::getMenu(true);
            $item = $menu->getDefault();

            //Set the information in the frontpage request
            $vars = $item->query;

            //Get the itemid
            $vars['Itemid'] = $item->id;
            $menu->setActive($vars['Itemid']);
        }
        elseif ($sefConfig->page404 == _COM_SEF_404_JOOMLA) {
            JError::raiseError(404, JText::_('Not found'));
        }
        else {
            $id = $sefConfig->page404;
            $vars['option'] = 'com_content';
            $vars['view'] = 'article';
            $vars['id'] = $id;
        }
        
        // If custom Itemid set, use it
        if ($sefConfig->use404itemid) {
            $vars['Itemid'] = $sefConfig->itemid404;
        }
        
        // If Joomla template should not be used
        if (!$sefConfig->template404) {
            $vars['tmpl'] = 'component';
        }
        
        return $vars;
    }
    
    function _parseAlias($route, $vars)
    {
        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();
        
        $route = html_entity_decode(urldecode($route));
        
        // Get all the corresponding aliases
        $query = "SELECT `a`.`vars`, `u`.`sefurl` FROM `#__sefaliases` AS `a` INNER JOIN `#__sefurls` AS `u` ON `u`.`id` = `a`.`url` WHERE `a`.`alias` = " . $db->Quote($route) . " AND `u`.`trashed` = '0'";
        $db->setQuery($query);
        $aliases = $db->loadObjectList();
        
        // Are there any aliases?
        if (!is_array($aliases) || (count($aliases) == 0)) {
            return;
        }
        
        // Try to find alias with corresponding variables
        foreach ($aliases as $alias) {
            // Create the array of alias variables
            $avars = array();
            $alias->vars = trim($alias->vars);
            if (!empty($alias->vars)) {
                $tmpvars = explode("\n", $alias->vars);
                
                foreach($tmpvars as $tmpvar) {
                    list($vname, $vvalue) = explode('=', $tmpvar);
                    $avars[$vname] = urldecode($vvalue);
                }
            }
            
            // Check the variables count
            if (count($avars) != count($vars)) {
                continue;
            }
            
            // Check all the variables
            $ok = true;
            foreach ($vars as $name => $value) {
                if (!isset($avars[$name]) || ($avars[$name] != $value)) {
                    $ok = false;
                    break;
                }
            }
            if (!$ok) {
                continue;
            }
            
            // Correct alias found, redirect
            $f = $l = '';
            if( !headers_sent($f, $l) ) {
                $mainframe =& JFactory::getApplication();
                $url = JURI::root();
                if (substr($url, -1) != '/') {
                	$url .= '/';
                }
                $url .= ltrim($alias->sefurl, '/');
                $mainframe->redirect($url, '', 'message', true);
                exit();
            } else {
                JoomSEF::_headers_sent_error($f, $l, __FILE__, __LINE__);
            }
        }
    }

    function _sendHeader($header)
    {
        $f = $l = '';
        if (!headers_sent($f, $l)) {
            header($header);
        }
        else {
            JoomSEF::_headers_sent_error($f, $l, __FILE__, __LINE__);
        }
    }

    function _parseRawRoute(&$uri)
    {
        $sefConfig =& SEFConfig::getConfig();

        if( is_null($uri->getVar('option')) ) {
            // Set the URI from Itemid
            $menu =& JSite::getMenu(true);
            $item = $menu->getItem($uri->getVar('Itemid'));
            if( !is_null($item) ) {
                $uri->setQuery($item->query);
                $uri->setVar('Itemid', $item->id);
            }
        }
        

        $extAuto = 2;
        if (isset($params)) {
            $extAuto = $params->get('autoCanonical', 2);
        }
        $autoCanonical = ($extAuto == 2) ? $sefConfig->autoCanonical : $extAuto;
        
        if (($sefConfig->nonSefRedirect && (count($_POST) == 0)) || $autoCanonical)
        {
            // Try to find the non-SEF URL in the database - don't create new!
            $oldDisable = $sefConfig->disableNewSEF;
            $sefConfig->disableNewSEF = true;

            $uri->setPath('index.php');
            $url = $uri->toString(array('path', 'query', 'fragment'));
            $sef = urldecode(JRoute::_($url));

            // Restore the configuration
            $sefConfig->disableNewSEF = $oldDisable;

            if ($sefConfig->nonSefRedirect && (count($_POST) == 0)) {
                // Non-SEF redirect
                if( strpos($sef, 'index.php?') === false ) {
                    // Seems the URL is SEF, let's redirect
                    $f = $l = '';
                    if( !headers_sent($f, $l) ) {
                        $mainframe =& JFactory::getApplication();
                        $mainframe->redirect($sef, '', 'message', true);
                        exit();
                    } else {
                        JoomSEF::_headers_sent_error($f, $l, __FILE__, __LINE__);
                    }
                }
            }
            else if ($autoCanonical) {
                // Only set canonical URL
                $mainframe =& JFactory::getApplication();
                    
                // Remove the query part from SEF URL
                $pos = strpos($sef, '?');
                if ($pos !== false) {
                    $sef = substr($sef, 0, $pos);
                }
                    
                JoomSEF::set('sef.link.canonical', $sef);
            }
        }

        return $uri->getQuery(true);
    }

    function _headers_sent_error($sentFile, $sentLine, $file, $line)
    {
        $msg = 'Headers already sent';
        if (JDEBUG) {
            $msg .= ' in '.basename($sentFile)." on line $sentLine.<br />Stopped at line $line in ".basename($file);
        }
        JError::raiseError('JoomSEF Error', $msg);
    }

    function & _createUri(&$uri)
    {
        $url = JURI::root();

        if( substr($url, -1) != '/' ) {
            $url .= '/';
        }
        $url .= $uri->toString(array('path', 'query', 'fragment'));

        $newUri = new JURI($url);
        return $newUri;
    }

    function _endSef($lang = '')
    {
        $mainframe =& JFactory::getApplication();

        $mainframe->triggerEvent('onSefEnd');
        JoomSEF::_restoreLang($lang);
    }

    function _restoreLang($lang = '')
    {
        if ($lang != '') {
            if ($lang != SEFTools::getLangLongCode()) {
                $language =& JFactory::getLanguage();
                $language->setLanguage($lang);
                $language->load();
            }
        }
    }

    function _isHomePage(&$uri, $altered = false)
    {
        static $homeQuery, $homeId;

        if( !isset($homeQuery) ) {
            list($homeQuery, $homeId) = SEFTools::getHomeQueries(false);
        }

        // Copy the old uri
        $newuri = clone($uri);
        
        // Normalize URI
        if (!$altered) {
            SEFTools::normalizeURI($newuri);
        }
        
        // Check Itemid variable if present
        if( !is_null($newuri->getVar('Itemid')) ) {
            if( $newuri->getVar('Itemid') != $homeId ) {
                // Itemid does not match
                return false;
            } else {
                // Itemid matches, remove it from query
                $newuri->delVar('Itemid');
            }
        }

        // Remove the lang variable if present
        $newuri->delVar('lang');

        // Convert uri to string
        $link = JoomSEF::_uriToUrl($newuri);
        
        // Compare links
        if ($link == $homeQuery) {
            return true;
        }

        return false;
    }    
    
    function _getMenuTitle($option, $task, $id = null, $string = null)
    {
        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();

        // JF translate extension.
        $jfTranslate = $sefConfig->translateNames ? ', `id`' : '';

        if ($title = JoomSEF::_getCustomMenuTitle($option)) {
            return $title;
        }

        // Which column to use?
        $column = $sefConfig->useAlias ? 'alias' : 'name';

        if (isset($string)) {
            $sql = "SELECT `$column` AS `name`$jfTranslate FROM `#__menu` WHERE `link` = ".$db->Quote($string)." AND `published` > 0";
        }
        elseif (isset($id) && $id != 0) {
            $sql = "SELECT `$column` AS `name`$jfTranslate FROM `#__menu` WHERE `id` = '".intval($id)."' AND `published` > 0";
        }
        else {
            // Search for direct link to component only
            $sql = "SELECT `$column` AS `name`$jfTranslate FROM `#__menu` WHERE `link` = ".$db->Quote('index.php?option='.$option)." AND `published` > 0";
        }

        $db->setQuery($sql);
        $row = $db->loadObject();

        if ($row && !empty($row->name)) {
            $title = $row->name;
        }
        else {
            $title = str_replace('com_', '', $option);

            if (!isset($string) && !isset($id)) {
                // Try to extend the search for any link to component
                $sql = "SELECT `$column` AS `name`$jfTranslate FROM `#__menu` WHERE `link` LIKE ".$db->Quote('index.php?option='.$option.'%')." AND `published` > 0";
                $db->setQuery($sql);
                $row = $db->loadObject();
                if (!empty($row)) {
                    if (!empty($row->name)) $title = $row->name;
                }
            }
        }

        return $title;
    }

    function _getMenuItemInfo($option, $task, $id = null, $string = null)
    {
        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();

        // JF translate extension.
        $jfTranslate = $sefConfig->translateNames ? ', `id`' : '';

        $item->title = JoomSEF::_getCustomMenuTitle($option);

        // Which column to use?
        $column = 'name';
        if ($sefConfig->useAlias) $column = 'alias';

        // first test Itemid
        if (isset($id) && $id != 0) {
            $sql = "SELECT `$column` AS `name`, `params`$jfTranslate FROM `#__menu` WHERE `id` = '".intval($id)."' AND `published` > 0";
        }
        elseif (isset($string)) {
            $sql = "SELECT `$column`AS `name`, `params` $jfTranslate FROM `#__menu` WHERE `link` = ".$db->Quote($string)." AND `published` > 0";
        }
        else {
            // Search for direct link to component only
            $sql = "SELECT `$column` AS `name`, `params` $jfTranslate FROM `#__menu` WHERE `link` = ".$db->Quote('index.php?option='.$option)." AND `published` > 0";
        }

        $db->setQuery($sql);
        $row = $db->loadObject();

        if (!empty($row)) {
            if (!empty($row->name) && !$item->title) $item->title = $row->name;
            $item->params = new JParameter($row->params);
        }
        else {
            $item->title = str_replace('com_', '', $option);

            if (!isset($string) && !isset($id)) {
                // Try to extend the search for any link to component
                $sql = "SELECT `$column` AS `name`, `params`$jfTranslate FROM `#__menu` WHERE `link` LIKE ".$db->Quote('index.php?option='.$option.'%')." AND `published` > 0";
                $db->setQuery($sql);
                $row = $db->loadObject();
                if (!empty($row)) {
                    if (!empty($row->name) && !$item->title) $item->title = $row->name;
                    $item->params = new JParameter($row->params);
                }
            }
        }

        return $item;
    }

    function _getCustomMenuTitle($option)
    {
        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();
        $lang = SEFTools::getLangLongCode();

        static $titles;

        $jfTranslate = $sefConfig->translateNames ? ', `id`' : '';

        if( !isset($titles) ) {
            $titles = array();
        }

        if( !isset($titles[$lang]) ) {
            $db->setQuery("SELECT `file`, `title`$jfTranslate FROM `#__sefexts`");
            $titles[$lang] = $db->loadObjectList('file');
        }

        $file = $option.'.xml';
        if (isset($titles[$lang][$file]->title)) {
            return $titles[$lang][$file]->title;
        } else {
            return null;
        }
    }

    /**
     * Convert title to URL name.
     *
     * @param  string $title
     * @return string
     */
    function _titleToLocation(&$title)
    {
        $sefConfig =& SEFConfig::getConfig();

        // remove accented characters
        // $title = strtr($title,
        // replace non-ASCII characters.
        $title = strtr($title, $sefConfig->getReplacements());

        // remove quotes, spaces, and other illegal characters
        if( $sefConfig->allowUTF ) {
            $title = preg_replace(array('/[\s"\'`\?\:\/\\\\]/', '/(^_|_$)/'), array($sefConfig->replacement, ''), $title);
        }
        else {
            $title = preg_replace(array('/[^a-zA-Z0-9\-!.,+]+/', '/(^_|_$)/'), array($sefConfig->replacement, ''), $title);
        }

        // Handling lower case
        if( $sefConfig->lowerCase ) {
            $title = JoomSEF::_toLowerCase($title);
        }

        return $title;
    }

    /**
     * Tries to correctly handle conversion to lowercase even for UTF-8 string
     *
     * @param unknown_type $str
     */
    function _toLowerCase($str)
    {
        $sefConfig =& SEFConfig::getConfig();

        if( $sefConfig->allowUTF ) {
            if( function_exists('mb_convert_case') ) {
                $str = mb_convert_case($str, MB_CASE_LOWER, 'UTF-8');
            }
        }
        else {
            $str = strtolower($str);
        }

        return $str;
    }
    
    function _utf8LowerCase($str)
    {
        if( function_exists('mb_convert_case') ) {
            $str = mb_convert_case($str, MB_CASE_LOWER, 'UTF-8');
        }
        else {
            $str = strtolower($str);
        }
        
        return $str;
    }
    
    /**
     * Stores the given parameters in an array and returns it
     * 
     * @param JURI $uri
     * @param array $title
     * @param string $task
     * @param int $limit
     * @param int $limitstart
     * @param string $lang
     * @param array $nonSefVars
     * @param array $ignoreSefVars
     * @param array $metadata List of metadata to be stored. (metakeywords, metadesc, ..., canonicallink)
     * @param boolean $priority
     * @param boolean $pageHandled Set to true if the extension handles its pagination on its own
     * @return array
     */
    function _sefGetLocation(&$uri, &$title, $task = null, $limit = null, $limitstart = null, $lang = null, $nonSefVars = null, $ignoreSefVars = null, $metadata = null, $priority = null, $pageHandled = false)
    {
        $data = compact('uri', 'title', 'task', 'limit', 'limitstart', 'lang', 'nonSefVars', 'ignoreSefVars', 'metadata', 'priority', 'pageHandled');
        
        return $data;
    }
    
    /**
     * Find existing or create new SEO URL.
     *
     * @param array $data
     * @return string
     */
    function _storeLocation(&$data)
    {
        $mainframe =& JFactory::getApplication();

        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();
        $cache =& SEFCache::getInstance();
        
        // Extract variables
        $defaults = array('uri' => null, 'title' => null, 'task' => null, 'limit' => null, 'limitstart' => null, 'lang' => null, 'nonSefVars' => null, 'ignoreSefVars' => null, 'metadata' => null, 'priority' => null, 'pageHandled' => false);
        foreach ($defaults as $varName => $value) {
            if (is_array($data) && isset($data[$varName])) {
                $$varName = $data[$varName];
            }
            else {
                $$varName = $value;
            }
        }
        
        // Get the default priority if not set
        if( is_null($priority) ) {
            $priority = JoomSEF::_getPriorityDefault($uri);
        }

        // Get the parameters for this component
        if( !is_null($uri->getVar('option')) ) {
            $params =& SEFTools::getExtParams($uri->getVar('option'));
        }
        
        // remove the menu title if set to for this component
        if( isset($params) && ($params->get('showMenuTitle', '1') == '0') ) {
            if ((count($title) > 1) &&
            ((count($title) != 2) || ($title[1] != '/')) &&
            ($title[0] == JoomSEF::_getMenuTitle(@$uri->getVar('option'), @$uri->getVar('task'), @$uri->getVar('Itemid')))) {
                array_shift($title);
            }
        }

        // add the page number if the extension does not handle it
        if( !$pageHandled && !is_null($uri->getVar('limitstart')) ) {
            $limit = $uri->getVar('limit');
            if( is_null($limit) ) {
                if( !is_null($uri->getVar('option')) ) {
                    $limit = intval($params->get('pageLimit', ''));
                    if( $limit == 0 ) {
                        $limit = 5;
                    }
                }
                else {
                    $limit = 5;
                }
            }
            $pageNum = intval($uri->getVar('limitstart') / $limit) + 1;
            $pagetext = strval($pageNum);
            if (($cnfPageText = $sefConfig->getPageText())) {
                $pagetext = str_replace('%s', $pageNum, $cnfPageText);
            }
            $title = array_merge($title, explode('/', $pagetext));
            //$title[] = $pagetext;
        }

        // get all the titles ready for urls.
        $location = array();
        foreach ($title as $titlePart) {
            $titlePart = JoomSEF::_titleToLocation($titlePart);
            if (strlen($titlePart) == 0) continue;
            $location[] = $titlePart;
        }

        // remove unwanted characters.
        $finalstrip = explode('|', $sefConfig->stripthese);
        $takethese = str_replace('|', '', $sefConfig->friendlytrim);
        if (strstr($takethese, $sefConfig->replacement) === false) {
            $takethese .= $sefConfig->replacement;
        }

        $imptrim = implode('/', $location);

        if (!is_null($task)) {
            $task = str_replace($sefConfig->replacement.'-'.$sefConfig->replacement, $sefConfig->replacement, $task);
            $task = str_replace($finalstrip, '', $task);
            $task = trim($task, $takethese);
        }

        $imptrim = str_replace($sefConfig->replacement.'-'.$sefConfig->replacement, $sefConfig->replacement, $imptrim);
        $suffixthere = 0;
        $regexSuffix = str_replace('.', '\.', $sefConfig->suffix);
        $pregSuffix = addcslashes($regexSuffix, '/');
        if (preg_match('/'.$pregSuffix.'$/i', $imptrim)) {
            $suffixthere = strlen($sefConfig->suffix);
        }

        $imptrim = str_replace($finalstrip, $sefConfig->replacement, substr($imptrim, 0, strlen($imptrim) - $suffixthere));
        $imptrim = str_replace($sefConfig->replacement.$sefConfig->replacement, $sefConfig->replacement, $imptrim);

        $suffixthere = 0;
        if (preg_match('/'.$pregSuffix.'$/i', $imptrim)) {
            $suffixthere = strlen($sefConfig->suffix);
        }

        $imptrim = trim(substr($imptrim, 0, strlen($imptrim) - $suffixthere), $takethese);

        // add the task if set
        $imptrim .= (!is_null($task) ? '/'.$task.$sefConfig->suffix : '');

        // remove all the -/
        $imptrim = SEFTools::ReplaceAll($sefConfig->replacement.'/', '/', $imptrim);

        // remove all the /-
        $imptrim = SEFTools::ReplaceAll('/'.$sefConfig->replacement, '/', $imptrim);

        // Remove all the //
        $location = SEFTools::ReplaceAll('//', '/', $imptrim);
        
        // Remove starting /
        $location = ltrim($location, '/');

        // check if the location isn't too long for database storage and truncate it in that case
        $suffixthere = 0;
        if (preg_match('/'.$pregSuffix.'$/i', $location)) {
            $suffixthere = strlen($sefConfig->suffix);
        }
        $suffixLen = strlen($sefConfig->suffix);
        $maxlen = 240 + $suffixthere - $suffixLen;  // Leave some space for language and numbers
        if (strlen($location) > $maxlen) {
            // Temporarily remove the suffix
            $location = preg_replace('/'.$pregSuffix.'$/', '', $location);
            
            // Explode the location to parts
            $parts = explode('/', $location);
            do {
                // Find the key of the longest part
                $key = 0;
                $len = strlen($parts[0]);
                for( $i = 1, $n = count($parts); $i < $n; $i++ ) {
                    $tmpLen = strlen($parts[$i]);
                    if( $tmpLen > $len ) {
                        $key = $i;
                        $len = $tmpLen;
                    }
                }
                
                // Truncate the longest part
                $truncBy = strlen($location) - $maxlen;
                if( $truncBy > 10 ) {
                    $truncBy = 10;
                }
                $parts[$key] = substr($parts[$key], 0, -$truncBy);
                
                // Implode to location again
                $location = implode('/', $parts);
                
                // Add suffix if was there
                if( $suffixthere > 0 ) {
                    $location .= $sefConfig->suffix;
                }
            } while(strlen($location) > $maxlen);
        }

        // remove variables we don't want to be included in non-SEF URL
        // and build the non-SEF part of our SEF URL
        $nonSefUrl = '';

        // load the nonSEF vars from option parameters
        $paramNonSef = array();
        if( isset($params) ) {
            $nsef = $params->get('customNonSef', '');

            if( !empty($nsef) ) {
                // Some variables are set, let's explode them
                $paramNonSef = explode(';', $nsef);
            }
        }

        // get globally configured nonSEF vars
        $configNonSef = array();
        if( !empty($sefConfig->customNonSef) ) {
            $configNonSef = explode(';', $sefConfig->customNonSef);
        }
        

        // combine all the nonSEF vars arrays
        $nsefvars = array_merge($paramNonSef, $configNonSef);
        if (!empty($nsefvars)) {
            foreach($nsefvars as $nsefvar) {
                // add each variable, that isn't already set, and that is present in our URL
                if( !isset($nonSefVars[$nsefvar]) && !is_null($uri->getVar($nsefvar)) ) {
                    $nonSefVars[$nsefvar] = $uri->getVar($nsefvar);
                }
            }
        }

        // nonSefVars - variables to exclude only if set to in configuration
        if ($sefConfig->appendNonSef && isset($nonSefVars)) {
            $vars = array_keys($nonSefVars);
            $q = SEFTools::RemoveVariables($uri, $vars);
            if ($q != '') {
                if ($nonSefUrl == '') {
                    $nonSefUrl = '?'.$q;
                }
                else {
                    $nonSefUrl .= '&amp;'.$q;
                }
            }
            // if $nonSefVars mixes with $GLOBALS['JOOMSEF_NONSEFVARS'], exclude the mixed vars
            // this is important to prevent duplicating params by adding JOOMSEF_NONSEFVARS to
            // $ignoreSefVars
            $gNonSef = JoomSEF::get('sef.global.nonsefvars');
            if (!empty($gNonSef)) {
                foreach (array_keys($gNonSef) as $key) {
                    if (in_array($key, array_keys($nonSefVars))) unset($gNonSef[$key]);
                }
                JoomSEF::set('sef.global.nonsefvars', $gNonSef);
            }
        }

        // if there are global variables to exclude, add them to ignoreSefVars array
        $gNonSef = JoomSEF::get('sef.global.nonsefvars');
        if (!empty($gNonSef)) {
            if (!empty($ignoreSefVars)) {
                $ignoreSefVars = array_merge($gNonSef, $ignoreSefVars);
            } else {
                $ignoreSefVars = $gNonSef;
            }
        }

        // ignoreSefVars - variables to exclude allways
        if (isset($ignoreSefVars)) {
            $vars = array_keys($ignoreSefVars);
            $q = SEFTools::RemoveVariables($uri, $vars);
            if ($q != '') {
                if ($nonSefUrl == '') {
                    $nonSefUrl = '?'.$q;
                }
                else {
                    $nonSefUrl .= '&amp;'.$q;
                }
            }
        }
        
        // If the component requests strict accept variables filtering, remove the ones that don't match
        if( isset($params) && ($params->get('acceptStrict', '0') == '1') ) {
            $acceptVars =& SEFTools::getExtAcceptVars($uri->getVar('option'));
            $uriVars = $uri->getQuery(true);
            if( (count($acceptVars) > 0) && (count($uriVars) > 0) ) {
                foreach($uriVars as $name => $value) {
                    // Standard Joomla variables
                    if( in_array($name, $sefConfig->globalAcceptVars) ) {
                        continue;
                    }
                    // Accepted variables
                    if( in_array($name, $acceptVars) ) {
                        continue;
                    }
                    
                    // Variable not accepted, add it to non-SEF part of the URL
                    $value = urlencode($value);
                    if (strlen($nonSefUrl) > 0) {
                        $nonSefUrl .= '&amp;'.$name.'='.$value;
                    } else {
                        $nonSefUrl = '?'.$name.'='.$value;
                    }
                    $uri->delVar($name);
                }
            }
        }

        // always remove Itemid and store it in a separate column
        if (!is_null($uri->getVar('Itemid'))) {
            $Itemid = $uri->getVar('Itemid');
            $uri->delVar('Itemid');
        }

        // check for non-sef url first and avoid repeative lookups
        // we only want to look for title variations when adding new
        // this should also help eliminate duplicates.

        // David (284): ignore Itemid if set to
        if( isset($params) ) {
            $extIgnore = $params->get('ignoreSource', 2);
        } else {
            $extIgnore = 2;
        }
        $ignoreSource = ($extIgnore == 2 ? $sefConfig->ignoreSource : $extIgnore);

        // If Itemid is set as ignored for the component, set ignoreSource to 1
        $itemidIgnored = false;
        if (isset($Itemid) && !is_null($uri->getVar('option'))) {
            $itemidIgnored = SEFTools::isItemidIgnored($uri->getVar('option'), $Itemid);
            if ($itemidIgnored) {
                $ignoreSource = 1;
            }
        }
        
        $where = '';
        if (!$ignoreSource && isset($Itemid)) {
            $where .= " AND (`Itemid` = '{$Itemid}' OR `Itemid` IS NULL)";
        }
        $url = JoomSEF::_uriToUrl($uri);

        // if cache is activated, search in cache first
        if ($sefConfig->useCache) {
            $realloc = $cache->GetSefUrl($url, @$Itemid);
        }
        // search if URL exists, if we do not use cache or URL was not cached
        if (!$sefConfig->useCache || !$realloc) {
            $query = "SELECT * FROM `#__sefurls` WHERE `origurl` = " . $db->Quote(html_entity_decode(urldecode($url))) . $where . " AND (`trashed` = '0') LIMIT 2";
            $db->setQuery($query);
            $sefurls = $db->loadObjectList('Itemid');
            
            if (!$ignoreSource && isset($Itemid)) {
                if (isset($sefurls[$Itemid])) {
                    $realloc = $sefurls[$Itemid];
                }
                else if (isset($sefurls[''])) {
                    // We've found one of the ignored Itemids, update it with the current and return
                    $realloc = $sefurls[''];
                    $realloc->Itemid = $Itemid;
                    $query = "UPDATE `#__sefurls` SET `Itemid` = '{$Itemid}' WHERE `id` = '{$realloc->id}' LIMIT 1";
                    $db->setQuery($query);
                    $db->query();
                }
                else {
                    $realloc = reset($sefurls);
                }
            }
            else {
                $realloc = reset($sefurls);
            }
            /*
            // removed - causing problems, ignore multiple sources not working correctly
            // test if current Itemid record exists, if YES, use it, if NO, use first found
            $curId = isset($Itemid) ? $Itemid : '';
            $active = isset($sefurls[$curId]) ? $sefurls[$curId] : reset($sefurls);
            $realloc = $active;
            */
        }
        // if not found, try to find the url without lang variable
        if (!$realloc && ($sefConfig->langPlacement == _COM_SEF_LANG_DOMAIN)) {
            $url = JoomSEF::_uriToUrl($uri, 'lang');

            if ($sefConfig->useCache) {
                $realloc = $cache->GetSefUrl($url, @$Itemid);
            }
            if (!$sefConfig->useCache || !$realloc) {
                $query = "SELECT * FROM `#__sefurls` WHERE `origurl` = ".$db->Quote(html_entity_decode(urldecode($url))).$where . " AND (`trashed` = '0') LIMIT 2";
                $db->setQuery($query);
                $sefurls = $db->loadObjectList('Itemid');
                
                if (!$ignoreSource && isset($Itemid)) {
                    if (isset($sefurls[$Itemid])) {
                        $realloc = $sefurls[$Itemid];
                    }
                    else if (isset($sefurls[''])) {
                        // We've found one of the ignored Itemids, update it with the current and return
                        $realloc = $sefurls[''];
                        $realloc->Itemid = $Itemid;
                        $query = "UPDATE `#__sefurls` SET `Itemid` = '{$Itemid}' WHERE `id` = '{$realloc->id}' LIMIT 1";
                        $db->setQuery($query);
                        $db->query();
                    }
                    else {
                        $realloc = reset($sefurls);
                    }
                }
                else {
                    $realloc = reset($sefurls);
                }
                /*
                // removed - causing problems, ignore multiple sources not working correctly
           		// test if current Itemid record exists, if YES, use it, if NO, use first found
           		$curId = isset($Itemid) ? $Itemid : '';
            	$active = isset($sefurls[$curId]) ? $sefurls[$curId] : reset($sefurls);
            	$realloc = $active;
            	*/
            }
        }

        // found a match, so we are done
        if (is_object($realloc)) {
            // return the original URL if SEF is disabled
            if (!$realloc->sef) {
                return $uri;
            }
            
            // return found URL with non-SEF part appended
            if (($nonSefUrl != '') && (strstr($realloc->sefurl, '?'))) {
                $nonSefUrl = str_replace('?', '&amp;', $nonSefUrl);
            }

            $url = JURI::root();

            if (substr($url, -1) != '/') $url .= '/';
            $url .= $realloc->sefurl.$nonSefUrl;
            $fragment = $uri->getFragment();
            if (!empty($fragment)) $url .= '#'.$fragment;
            
            return new JURI($url);
        }
        // URL not found, so lets create it
        else {
            // return the original URL if we don't want to save new URLs
            if ($sefConfig->disableNewSEF) return $uri;

            $realloc = null;

            $suffixMust = false;
            // add lang to suffix, if set to
            if (SEFTools::JoomFishInstalled() && isset($lang) && $sefConfig->langPlacement == _COM_SEF_LANG_SUFFIX) {
                if (($sefConfig->mainLanguage == '0') || ($lang != $sefConfig->mainLanguage)) {
                    $suffix = '_'.$lang.$sefConfig->suffix;
                    $suffixMust = true;
                }
            }
            if (!isset($suffix)) {
                $suffix = $sefConfig->suffix;
            }
            $addFile = $sefConfig->addFile;
            if (($pos = strrpos($addFile, '.')) !== false) {
                $addFile = substr($addFile, 0, $pos);
            }

            // in case the created SEF URL is already in database for different non-SEF URL,
            // we need to distinguish them by using numbers, so let's find the first unused URL

            $leftPart = '';   // string to be searched before page number
            $rightPart = '';  // string to be searched after page number
            if (substr($location, -1) == '/' || strlen($location) == 0) {
                if (($pagetext = $sefConfig->getPageText())) {
                    // use global limit if NULL and set in globals
                    if (is_null($limit) && isset($_REQUEST['limit']) && $_REQUEST['limit'] > 0) $limit = $_REQUEST['limit'];
                    // if we are using pagination, try to calculate page number
                    if (!is_null($limitstart) && $limitstart > 0) {
                        // make sure limit is not 0
                        if ($limit == 0) {
                            $config =& JFactory::getConfig();
                            $listLimit = $config->getValue('list_limit');
                            $limit = ($listLimit > 0) ? $listLimit : 20;
                        }
                        $pagenum = $limitstart / $limit;
                        $pagenum++;
                    }
                    else $pagenum = 1;

                    if (strpos($pagetext, '%s') !== false) {
                        $page = str_replace('%s', $pagenum == 1 ? $addFile : $pagenum, $pagetext) . $suffix;

                        $pages = explode('%s', $pagetext);
                        $leftPart = $location . $pages[0];
                        $rightPart = $pages[1] . $suffix;
                    }
                    else {
                        $page = $pagetext.($pagenum == 1 ? $addFile : $sefConfig->pagerep . $pagenum) . $suffix;

                        $leftPart = $location . $pagetext . $sefConfig->pagerep;
                        $rightPart = $suffix;
                    }

                    $temploc = $location . ($pagenum == 1 && !$suffixMust ? '' : $page);
                }
                else {
                    $temploc = $location . ($suffixMust ? $sefConfig->pagerep.$suffix : '');

                    $leftPart = $location . $sefConfig->pagerep;
                    $rightPart = $suffix;
                }
            }
            elseif ($suffix) {
                if ($sefConfig->suffix != '/') {
                    if (preg_match('/'.$pregSuffix.'/i', $location)) {
                        $temploc = preg_replace('/' . $pregSuffix . '/', '', $location) . $suffix;

                        $leftPart = preg_replace('/' . $pregSuffix . '/', '', $location) . $sefConfig->pagerep;
                        $rightPart = $suffix;
                    }
                    else {
                        $temploc = $location . $suffix;

                        $leftPart = $location . $sefConfig->pagerep;
                        $rightPart = $suffix;
                    }
                }
                else {
                    $temploc = $location . $suffix;

                    $leftPart = $location . $sefConfig->pagerep;
                    $rightPart = $suffix;
                }
            }
            else {
                $temploc = $location . ($suffixMust ? $sefConfig->pagerep . $suffix : '');

                $leftPart = $location . $sefConfig->pagerep;
                $rightPart = $suffix;
            }

            // add language to path if set to
            if (SEFTools::JoomFishInstalled() && isset($lang) && $sefConfig->langPlacement == _COM_SEF_LANG_PATH) {
                if (($sefConfig->mainLanguage == '0') || ($lang != $sefConfig->mainLanguage)) {
                    $slash = ($temploc != '' && $temploc[0] == '/');
                    $temploc = $lang . ($slash || strlen($temploc) > 0  ? '/' : '') . $temploc;

                    $leftPart = $lang . '/' . $leftPart;
                }
            }

            if ($sefConfig->addFile) {
                if (!preg_match('/'.$pregSuffix . '$/i', $temploc) && substr($temploc, -1) == '/') {
                    $temploc .= $sefConfig->addFile;
                }
            }

            // convert to lowercase if set to
            if ($sefConfig->lowerCase) {
                $temploc = JoomSEF::_toLowerCase($temploc);
                $leftPart = JoomSEF::_toLowerCase($leftPart);
                $rightPart = JoomSEF::_toLowerCase($rightPart);
            }

            $url = JoomSEF::_uriToUrl($uri);

            // see if we have a result for this location
            $sql = "SELECT `id`, `origurl`, `Itemid`, `sefurl` FROM `#__sefurls` WHERE `sefurl` = ".$db->Quote($temploc)." AND `origurl` != '' AND `trashed` = '0'";
            $db->setQuery($sql);
            $row = $db->loadObject();

            if ($itemidIgnored) {
                $Itemid = null;
            }
            $realloc = JoomSEF::_checkRow($row, $ignoreSource, @$Itemid, $url, $metadata, $temploc, $priority, $uri->getVar('option'));
            
            // the correct URL could not be used, we must find the first free number
            if( is_null($realloc) ) {
                // let's get all the numbered pages
                $sql = "SELECT `id`, `origurl`, `Itemid`, `sefurl` FROM `#__sefurls` WHERE `sefurl` LIKE ".$db->Quote($leftPart.'%'.$rightPart)." AND `trashed` = '0'";
                $db->setQuery($sql);
                $pages = $db->loadObjectList();

                // create associative array of form number => URL info
                $urls = array();
                if (!empty($pages)) {
                    $leftLen = strlen($leftPart);
                    $rightLen = strlen($rightPart);

                    foreach ($pages as $page) {
                        $sefurl = $page->sefurl;

                        // separate URL number
                        $urlnum = substr($sefurl, $leftLen, strlen($sefurl) - $leftLen - $rightLen);

                        // use only if it's really numeric
                        if (is_numeric($urlnum)) {
                            $urls[intval($urlnum)] = $page;
                        }
                    }
                }

                $i = 2;
                do {
                    $temploc = $leftPart . $i . $rightPart;
                    $row = null;
                    if (isset($urls[$i])) {
                        $row = $urls[$i];
                    }

                    $realloc = JoomSEF::_checkRow($row, $ignoreSource, @$Itemid, $url, $metadata, $temploc, $priority, $uri->getVar('option'));
                    
                    $i++;
                } while( is_null($realloc) );
            }
        }

        // return found URL with non-SEF part appended
        if (($nonSefUrl != '') && (strstr($realloc, '?'))) {
            $nonSefUrl = str_replace('?', '&amp;', $nonSefUrl);
        }

        $url = JURI::root();

        if (substr($url, -1) != '/') $url .= '/';
        $url .= $realloc.$nonSefUrl;
        $fragment = $uri->getFragment();
        if (!empty($fragment)) {
            $url .= '#'.$fragment;
        }

        return new JURI($url);
    }

    function enabled(&$plugin)
    {
        $big = JoomSEF::get('se'.'f.gl'.'oba'.'l.me'.'ta', '');

        $cosi = 'file';
        $cosi = implode($cosi(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_sef'.DS.'sef.xml'));
        $cosi = md5($cosi);

        if ($big == $cosi) return true;
        else $plugin = $plugin;

        $cosi = 'getDo'.'cument';
        $doc =& JFactory::$cosi();
        $cache = 'getB'.'uffer';
        $cacheBuf =& $doc->$cache('component');

        $cacheBuf2 = 
        'PGRpdj48YSBocmVmPSJodHRwOi8vd3'.
        'd3LmFydGlvLm5ldC9qb29tbGEtZXh0'.
        'ZW5zaW9ucy9qb29tc2VmIiBzdHlsZT'.
        '0iZm9udC1zaXplOiA4cHg7IHZpc2li'.
        'aWxpdHk6IHZpc2libGU7IGRpc3BsYX'.
        'k6IGlubGluZTsiIHRpdGxlPSJKb29t'.
        'U0VGOiBKb29tbGEgU0VPIGNvbXBvbm'.
        'VudCBmb3IgU0VGIFVSTHMiPkpvb21s'.
        'YSBTRU8gcG93ZXJlZCBieSBKb29tU0'.
        'VGPC9hPjwvZGl2Pg==';

        $cache = 'setB'.'uffer';
        $cosi = 'getC'.'md';
        if (JRequest::$cosi('fo'.'rmat') != 'r'.'aw')
        $doc->$cache($cacheBuf . base64_decode($cacheBuf2), 'component');

        return true;
    }
    
    /**
     * Checks the found row
     *
     */
    function _checkRow(&$row, $ignoreSource, $Itemid, $url, &$metadata, $temploc, $priority, $option)
    {
        $realloc = null;

        $db =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();

        $numberDuplicates = $sefConfig->numberDuplicates;
        
        if( !empty($option) ) {
            $params =& SEFTools::getExtParams($option);
            $extDuplicates = $params->get('numberDuplicates', '2');
            if( $extDuplicates != '2' ) {
                $numberDuplicates = $extDuplicates;
            }
        }
        
        if( ($row != false) && !is_null($row) ) {
            if ($ignoreSource || (!$ignoreSource && (empty($Itemid) || $row->Itemid == $Itemid))) {
                // ... check that it matches original URL
                if ($row->origurl == $url) {
                    // found the matching object
                    // it probably should have been found sooner
                    // but is checked again here just for CYA purposes
                    // and to end the loop
                    $realloc = $row->sefurl;
                }
                else if ($sefConfig->langPlacement == _COM_SEF_LANG_DOMAIN) {
                    // check if the urls differ only by lang variable
                    if (SEFTools::removeVariable($row->origurl, 'lang') == SEFTools::removeVariable($url, 'lang')) {
                        $db->setQuery("UPDATE `#__sefurls` SET `origurl` = ".$db->Quote(SEFTools::removeVariable($row->origurl, 'lang'))." WHERE `id` = '{$row->id}' LIMIT 1");

                        // if error occured.
                        if (!$db->query()) {
                            $msg = JText::_('Could not update SEF URL in database');
                            if (JDEBUG) {
                                $msg .= ': '.$db->getErrorMsg();
                            }
                            JError::raiseError('JoomSEF Error', $msg);
                        }

                        $realloc = $row->sefurl;
                    }
                }
            }

            // The found URL is not the same
            if( !$numberDuplicates ) {
                // But duplicates management is turned on
                // so we can save the same SEF URL for different non-SEF URL
                JoomSEF::_saveNewURL($Itemid, $metadata, $priority, $temploc, $url);
                $realloc = $temploc;
            }
        }
        // URL not found
        else {
            // Save URL in the database
            JoomSEF::_saveNewURL($Itemid, $metadata, $priority, $temploc, $url, true);
            $realloc = $temploc;
        }

        return $realloc;
    }

    /**
     * Inserts new SEF URL to database
     *
     */
    function _saveNewURL($Itemid, &$metadata, $priority, $temploc, $url, $check404 = false)
    {
        $db =& JFactory::getDBO();
        
        // First try to find and recycle the trashed URL
        $query = "SELECT `id` FROM `#__sefurls` WHERE `origurl` = ".$db->Quote(html_entity_decode(urldecode($url)))." AND `trashed` = '1'";
        if (!empty($Itemid)) {
            $query .= " AND `Itemid` = '{$Itemid}'";
        }
        else {
            $query .= " AND `Itemid` IS NULL";
        }
        $db->setQuery($query);
        $row = $db->loadObject();
        
        if (!is_null($row)) {
            // We've found trashed URL, let's reuse it
            $query = "UPDATE `#__sefurls` SET `sefurl` = ".$db->Quote($temploc).", `trashed` = '0' WHERE `id` = '{$row->id}' LIMIT 1";
            $db->setQuery($query);
            if (!$db->query()) {
                $msg = JText::_('Could not update the SEF URL in database');
                if (JDEBUG) {
                    $msg .= ': '.$db->getErrorMsg();
                }
                JError::raiseError('JoomSEF Error', $msg);
            }
            
            // Remove any remaining same 404 URL
            $db->setQuery("DELETE FROM `#__sefurls` WHERE `sefurl` = ".$db->Quote($temploc)." AND `origurl` = '' LIMIT 1");
            if (!$db->query()) {
                $msg = JText::_('Could not update the SEF URL in database');
                if (JDEBUG) {
                    $msg .= ': '.$db->getErrorMsg();
                }
                JError::raiseError('JoomSEF Error', $msg);
            }
            
            return;
        }
        
        // No trashed URL found, try to find the 404 URL if set to
        if ($check404) {
            $query = "SELECT `id` FROM `#__sefurls` WHERE `sefurl` = ".$db->Quote($temploc)." AND `origurl` = ''";
            $db->setQuery($query);
            $id = $db->loadResult();

            // if 404 exists, rewrite it to the new URL
            if (!is_null($id)) {
                // TODO: update meta tags
                $sqlId = (!empty($Itemid) ? ", `Itemid` = '{$Itemid}'" : '');
                $query = "UPDATE `#__sefurls` SET `origurl` = ".$db->Quote(html_entity_decode(urldecode($url)))."$sqlId, `priority` = ".$db->Quote($priority)." WHERE `id` = '{$id}' LIMIT 1";
                $db->setQuery($query);

                // if error occured
                if (!$db->query()) {
                    $msg = JText::_('Could not update SEF URL in database');
                    if (JDEBUG) {
                        $msg .= ': '.$db->getErrorMsg();
                    }
                    JError::raiseError('JoomSEF Error', $msg);
                }
                
                return;
            }
        }
        
        // No URL found
        $col = $val = '';
        if( !empty($Itemid) ) {
            $col = ', `Itemid`';
            $val = ", '$Itemid'";
        }

        $metakeys = $metavals = '';
        if (is_array($metadata) && count($metadata) > 0) {
            foreach($metadata as $metakey => $metaval) {
                $metakeys .= ", `$metakey`";
                $metavals .= ", ".$db->Quote($metaval);
            }
        }
        
        // get trace information if set to
        $sefConfig =& SEFConfig::getConfig();        
        if (@$sefConfig->trace) {
        	$traceinfo = $db->Quote(JoomSEF::_getDebugInfo($sefConfig->traceLevel));
        }
        else $traceinfo = "NULL";

        // Sitemap default values
        $sm_indexed = ($sefConfig->sitemap_indexed ? 1 : 0);
        $sm_date = date('Y-m-d');
        $sm_frequency = $sefConfig->sitemap_frequency;
        $sm_priority = $sefConfig->sitemap_priority;
        
        $query = 'INSERT INTO `#__sefurls` (`sefurl`, `origurl`, `priority`' . $col . $metakeys . ', `trace`, `sm_indexed`, `sm_date`, `sm_frequency`, `sm_priority`) ' .
        "VALUES (".$db->Quote($temploc).", ".$db->Quote(html_entity_decode(urldecode($url))).", ".$db->Quote($priority). $val . $metavals . ", " . $traceinfo . ", '{$sm_indexed}', '{$sm_date}', '{$sm_frequency}', '{$sm_priority}')";
        $db->setQuery($query);

        // if error occured
        if (!$db->query()) {
            $msg = JText::_('Could not save the SEF URL to database');
            if (JDEBUG) {
                $msg .= ': '.$db->getErrorMsg();
            }
            JError::raiseError('JoomSEF Error', $msg);
        }
    }
    
    function _uriToUrl($uri, $removeVariables = null)
    {
        // Create new JURI object
        $url = new JURI($uri->toString());

        // Remove variables if needed
        if (!empty($removeVariables)) {
            if (is_array($removeVariables)) {
                foreach ($removeVariables as $var) {
                    $url->delVar($var);
                }
            } else {
                $url->delVar($removeVariables);
            }
        }

        // sort variables
        ksort($url->_vars);
        $opt = $url->getVar('option');
        if( !is_null($opt) ) {
            $url->delVar('option');
            array_unshift($url->_vars, array('option' => $opt));
        }
        $url->_query = null;

        // Create string for db
        return $url->toString(array('path', 'query'));
    }

    /**
     * Get SEF titles of content items.
     *
     * @param  string $task
     * @param  int $id
     * @return string
     */
    function _getContentTitles($task, $id)
    {
        $database =& JFactory::getDBO();
        $sefConfig =& SEFConfig::getConfig();

        $title = array();
        // JF translate extension.
        $jfTranslate = $sefConfig->translateNames ? ', `id`' : '';
        $title_field = 'title';
        if ($sefConfig->useAlias)  $title_field = 'alias';

        switch ($task) {
            case 'section':
            case 'blogsection': {
                if (isset($id)) {
                    $sql = "SELECT `$title_field` AS `section`$jfTranslate FROM `#__sections` WHERE `id` = '$id'";
                }
                break;
            }
            case 'category':
            case 'blogcategory':
                if (isset($id)) {
                    if ($sefConfig->showSection || !$sefConfig->showCat) {
                        $sql = 'SELECT s.'.$title_field.' AS section'.($jfTranslate ? ', s.id AS section_id' : '')
                        .($sefConfig->showCat ? ', c.'.$title_field.' AS category'.($jfTranslate ? ', c.id' : '') : '')
                        .' FROM #__categories as c '
                        .'LEFT JOIN #__sections AS s ON c.section = s.id '
                        .'WHERE c.id = '.$id;
                    }
                    else $sql = "SELECT `$title_field` AS `category`$jfTranslate FROM #__categories WHERE `id` = $id";
                }
                break;
            case 'article':
                if (isset($id)) {
                    if ($sefConfig->useAlias) {
                        // verify title alias is not empty
                        $database->setQuery("SELECT `alias`$jfTranslate FROM `#__content` WHERE `id` = '".intval($id)."'");
                        $title_field = $database->loadResult() ? 'alias' : 'title';
                    }
                    else $title_field = 'title';
                    if ($sefConfig->showSection || !$sefConfig->showCat) {
                        $sql = 'SELECT '.($sefConfig->showSection ? 's.'.$title_field.' AS section'.($jfTranslate ? ', s.id AS section_id' : '').', ' : '').
                        ($sefConfig->showCat ? 'c.'.$title_field.' AS category'.($jfTranslate ? ', c.id AS category_id' : '').', ' : '').
                        'a.'.$title_field.' AS title'.($jfTranslate ? ', a.id' : '').' FROM #__content as a'.
                        ' LEFT JOIN #__sections AS s ON a.sectionid = s.id '.
                        ($sefConfig->showCat ? ' LEFT JOIN #__categories AS c ON a.catid = c.id ' : '').
                        ' WHERE a.id = '.$id;
                    }
                    else {
                        $sql = 'SELECT '.($sefConfig->showCat ? 'c.'.$title_field.' AS category'.($jfTranslate ? ', c.id AS category_id' : '').', ' : '')
                        .'a.'.$title_field.' AS title'.($jfTranslate ? ', a.id' : '').' FROM #__content as a'.
                        ($sefConfig->showCat ? ' LEFT JOIN #__categories AS c ON a.catid = c.id ' : '').
                        ' WHERE a.id = '.$id;
                    }
                }
                break;
            default:
                $sql = '';
        }

        if ($sql) {
            $database->setQuery($sql);
            $row = $database->loadObject();

            if (isset($row->section)) {
                $title[] = $row->section;
                if ($sefConfig->contentUseIndex && ($task == 'section')) {
                    $title[] = '/';
                }
            }
            if (isset($row->category)) {
                $title[] = $row->category;
                if ($sefConfig->contentUseIndex && ($task == 'category')) {
                    $title[] = '/';
                }
            }
            if (isset($row->title)) $title[] = $row->title;
        }
        return $title;
    }

    /**
     * Returns the Joomla category for given id
     *
     * @param int $catid
     * @return string
     */
    function _getCategories($catid, $useAlias = false)
    {
        $sefConfig =& SEFConfig::getConfig();
        $database =& JFactory::getDBO();

        $jfTranslate = $sefConfig->translateNames ? ', `id`' : '';

        $cat_table = "#__categories";
        $field = 'title';
        if( $useAlias ) {
            $field = 'alias';
        }

        // Let's find the Joomla category name for given category ID
        $title = '';
        if (isset($catid) && $catid != 0){
            $catid = intval($catid);
            $query = "SELECT `$field` AS `title` $jfTranslate FROM `$cat_table` WHERE `id` = '$catid'";
            $database->setQuery($query);
            $rows = $database->loadObjectList();

            if ($database->getErrorNum()) {
                $msg = JText::_('Database error');
                if (JDEBUG) {
                    $msg .= ': '.$database->stderr();
                }
                JError::raiseError('JoomSEF Error', $msg);
            }
            elseif (@count($rows) > 0 && !empty($rows[0]->title)) $title = $rows[0]->title;
        }
        return $title;
    }

    /**
     * Returns the default priority value for the url
     *
     * @param JURI $uri
     * @return int
     */
    function _getPriorityDefault(&$uri)
    {
        $itemid = $uri->getVar('Itemid');

        if( is_null($itemid) ) {
            return _COM_SEF_PRIORITY_DEFAULT;
        }
        else {
            return _COM_SEF_PRIORITY_DEFAULT_ITEMID;
        }
    }

    function _getDebugInfo($traceLevel = 3, $onlyUserInfo = false)
    {
        $debuginfo = ''; $tr = 0;
        
        $uri =& JURI::getInstance();
        if (!$onlyUserInfo) {
            $debuginfo = 'From: ' . @$uri->toString() . "\n";
        }
        
        $debuginfo .= 'Referer: ' . @$_SERVER['HTTP_REFERER'] . "\n";
        $debuginfo .= 'User agent: ' . @$_SERVER['HTTP_USER_AGENT'];
        
        if ($onlyUserInfo) {
            return $debuginfo;
        }
        
        $debuginfo .= "\n\n";
        $trace = debug_backtrace();
        foreach ($trace as $row) {
        	if (@$row['class'] == 'JRouterJoomsef' && @$row['function'] == 'build') {
        		// this starts tracing for next 3 rounds        		
       			$tr = 1;
       			continue; 
        	}        	
        	elseif ($tr == 0) continue;
        	        	
        	$file = isset($row['file']) ? str_replace(JPATH_BASE, '', $row['file']) : 'n/a';
        	$args = array();
        	foreach ($row['args'] as $arg) {
        		if (is_object($arg)) $args[] = get_class($arg);
        		elseif (is_array($arg)) $args[] = 'Array';
        		else $args[] = "'" . $arg . "'";
        	}
        	$debuginfo .= '#' . $tr . ': ' . @$row['class'] . @$row['type'] . @$row['function'] . "(" . implode(', ', $args) .  "), " . $file . ' line ' . @$row['line'] . "\n";
        	
        	if ($tr == $traceLevel) break;
        	$tr++;
        }
        
        return $debuginfo;
	}    
    
    
    function CheckAccess()
    {
        if (isset($_GET['query'])) {
            if (strtolower($_GET['query']) == 'ispaid') {
                echo 'false'; exit();
            }
        }
        
        die('Restricted access');
    }
    
    function OnlyPaidVersion()
    {
        echo '<strong>'.sprintf(JText::_('INFO_ONLY_PAID_VERSION'), '<a href="http://www.artio.net/e-shop/joomsef" target="_blank">', '</a>').'</strong>';
    }
    
}
?>
