<?php
/**
 * SEF module for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: sef_ext.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');


global $_SEF_SPACE, $lowercase;
class sef_component
{

  function revert (&$url_array, $pos)
  {
    global $_SEF_SPACE;

    $QUERY_STRING = '';
    $url_array = array_filter($url_array); // V x : traling slash can cause empty array element
    $url_array = array_values( $url_array);

    if (!empty( $url_array[1]) && strcspn ($url_array[1], ',') == strlen($url_array[1])) {
      // This is a nocache url
      $x = 0;
      $c = count($url_array);
      while ($x < $c) {
        if (isset($url_array[$x]) && $url_array[$x] != '' && isset($url_array[$x + 1]) && $url_array[$x + 1] != '') {
          $QUERY_STRING .= '&'.$url_array[$x].'='.$url_array[$x + 1];
        }
        $x += 2;
      }
    }
    else {
      //This is a default mambo SEF url for a component
      foreach($url_array as $value) {
        $temp = explode(",", $value);
        if (isset($temp[0]) && $temp[0] != '' && isset($temp[1]) && $temp[1]!="") {
          $QUERY_STRING .= "&$temp[0]=$temp[1]";
        }
      }
    }

    //return str_replace("&option","option",$QUERY_STRING);
    return JString::ltrim($QUERY_STRING, '&');
  }
}

class sef_content
{

  function revert (&$url_array, $pos)
  { // V 1.2.4.l  // updated based on includes/sef.php.
    $url_array = array_filter($url_array); // V x : traling slash can cause empty array element
    $url_array = array_values( $url_array);
    $uri 				= explode('content/', $_SERVER['REQUEST_URI']);
    $option 			= 'com_content';
    $pos 				= array_search ('content', $url_array);

    // language hook for content
    $lang = '';
    foreach($url_array as $key=>$value) {
      if ( !JString::strcasecmp(JString::substr($value,0,5),'lang,') ) {
        $temp = explode(',', $value);
        if (isset($temp[0]) && $temp[0] != '' && isset($temp[1]) && $temp[1] != '') {
          $lang 				= $temp[1];
        }
        unset($url_array[$key]);
      }
    }

    if (isset($url_array[$pos+8]) && $url_array[$pos+8] != '' && in_array('category', $url_array) && ( strpos( $url_array[$pos+5], 'order,' ) !== false ) && ( strpos( $url_array[$pos+6], 'filter,' ) !== false ) ) {
      // $option/$task/$sectionid/$id/$Itemid/$order/$filter/$limit/$limitstart
      $task 					= $url_array[$pos+1];
      $sectionid				= $url_array[$pos+2];
      $id 					= $url_array[$pos+3];
      $Itemid 				= $url_array[$pos+4];
      $order 					= str_replace( 'order,', '', $url_array[$pos+5] );
      $filter					= str_replace( 'filter,', '', $url_array[$pos+6] );
      $limit 					= $url_array[$pos+7];
      $limitstart 			= $url_array[$pos+8];

      $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&order=$order&filter=$filter&limit=$limit&limitstart=$limitstart";
    } else if (isset($url_array[$pos+7]) && $url_array[$pos+7] != '' && $url_array[$pos+5] > 1000 && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) ) ) {
      // $option/$task/$id/$limit/$limitstart/year/month/module
      $task 					= $url_array[$pos+1];
      $id						= $url_array[$pos+2];
      $limit 					= $url_array[$pos+3];
      $limitstart 			= $url_array[$pos+4];
      $year 					= $url_array[$pos+5];
      $month 					= $url_array[$pos+6];
      $module					= $url_array[$pos+7];

      $QUERY_STRING = "option=com_content&task=$task&id=$id&limit=$limit&limitstart=$limitstart&year=$year&month=$month&module=$module";
    } else if (isset($url_array[$pos+7]) && $url_array[$pos+7] != '' && $url_array[$pos+6] > 1000 && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) ) ) {
      // $option/$task/$id/$Itemid/$limit/$limitstart/year/month
      $task 					= $url_array[$pos+1];
      $id						= $url_array[$pos+2];
      $Itemid 				= $url_array[$pos+3];
      $limit 					= $url_array[$pos+4];
      $limitstart 			= $url_array[$pos+5];
      $year 					= $url_array[$pos+6];
      $month 					= $url_array[$pos+7];

      $QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart&year=$year&month=$month";
    } else if (isset($url_array[$pos+7]) && $url_array[$pos+7] != '' && in_array('category', $url_array) && ( strpos( $url_array[$pos+5], 'order,' ) !== false )) {
      // $option/$task/$sectionid/$id/$Itemid/$order/$limit/$limitstart
      $task 					= $url_array[$pos+1];
      $sectionid				= $url_array[$pos+2];
      $id 					= $url_array[$pos+3];
      $Itemid 				= $url_array[$pos+4];
      $order 					= str_replace( 'order,', '', $url_array[$pos+5] );
      $limit 					= $url_array[$pos+6];
      $limitstart 			= $url_array[$pos+7];

      $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&order=$order&limit=$limit&limitstart=$limitstart";
    } else if (isset($url_array[$pos+6]) && $url_array[$pos+6] != '') {
      // $option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
      $task 					= $url_array[$pos+1];
      $sectionid				= $url_array[$pos+2];
      $id 					= $url_array[$pos+3];
      $Itemid 				= $url_array[$pos+4];
      $limit 					= $url_array[$pos+5];
      $limitstart 			= $url_array[$pos+6];

      $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";
    } else if (isset($url_array[$pos+5]) && $url_array[$pos+5] != '') {
      // $option/$task/$id/$Itemid/$limit/$limitstart
      $task 					= $url_array[$pos+1];
      $id 					= $url_array[$pos+2];
      $Itemid 				= $url_array[$pos+3];
      $limit 					= $url_array[$pos+4];
      $limitstart 			= $url_array[$pos+5];

      $QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";
    } else if (isset($url_array[$pos+4]) && $url_array[$pos+4] != '' && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) )) {
      // $option/$task/$year/$month/$module
      $task 					= $url_array[$pos+1];
      $year 					= $url_array[$pos+2];
      $month 					= $url_array[$pos+3];
      $module 				= $url_array[$pos+4];

      $QUERY_STRING = "option=com_content&task=$task&year=$year&month=$month&module=$module";
    } else if (!(isset($url_array[$pos+5]) && $url_array[$pos+5] != '') && isset($url_array[$pos+4]) && $url_array[$pos+4] != '') {
      // $option/$task/$sectionid/$id/$Itemid
      $task 					= $url_array[$pos+1];
      $sectionid 				= $url_array[$pos+2];
      $id 					= $url_array[$pos+3];
      $Itemid 				= $url_array[$pos+4];

      $QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid";
    } else if (!(isset($url_array[$pos+4]) && $url_array[$pos+4] != '') && (isset($url_array[$pos+3]) && $url_array[$pos+3] != '')) {
      // $option/$task/$id/$Itemid
      $task 					= $url_array[$pos+1];
      $id 					= $url_array[$pos+2];
      $Itemid 				= $url_array[$pos+3];

      $QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid";
    } else if (!(isset($url_array[$pos+3]) && $url_array[$pos+3] != '') && (isset($url_array[$pos+2]) && $url_array[$pos+2] != '')) {
      // $option/$task/$id
      $task 					= $url_array[$pos+1];
      $id 					= $url_array[$pos+2];

      $QUERY_STRING = "option=com_content&task=$task&id=$id";
    } else if (!(isset($url_array[$pos+2]) && $url_array[$pos+2] != '') && (isset($url_array[$pos+1]) && $url_array[$pos+1] != '')) {
      // $option/$task
      $task = $url_array[$pos+1];
      $QUERY_STRING = 'option=com_content&task='. $task;
    }

    if ($lang!='') {
      $QUERY_STRING .= '&amp;lang='. $lang;
    }

    return 	$QUERY_STRING;
  }

}

class sef_404 {

  public function create($string, &$vars, &$shAppendString, $shLanguage, $shSaveString = '', &$originalUri) {

    // get our config objects
    $pageInfo = Sh404sefFactory::getPageInfo();
    $sefConfig = Sh404sefFactory::getConfig();
    // get DB // backward compat, some plugins rely on having this object available in scope
    $database = JFactory::getDBO();

    _log('Entering sef404 create function with '. $string);

    // extract request vars to have them readily available
    _log( 'Extracting $vars:', $vars);
    extract($vars);

    // maybe one of them interfere with the variable holding our result?
    if (isset($title)) {  // V 1.2.4.r : protect against components using 'title' as GET vars
      $sh404SEF_title = $title;  // means that $sh404SEF_title has to be used in plugins or extensions
    }
    $title = array();  // V 1.2.4.r

    // use custom method to find about correct plugin to use
    // can be overwritten by a user plugin
    $extPlugin = & Sh404sefFactory::getExtensionPlugin( $option);

    // which plugin file are we supposed to use?
    $extPluginPath = $extPlugin->getSefPluginPath( $vars);
    $pluginType = $extPlugin->getPluginType();

    // various ways to handle various SEF url plugins
    switch ($pluginType) {
      // use Joomla router.php file in extension dir
      case Sh404sefClassBaseextplugin::TYPE_JOOMLA_ROUTER:
        // Load the plug-in file.
        _log('Loading component own router.php file');
        $functionName = ucfirst( str_replace( 'com_', '', $option)) . 'BuildRoute';
        if (!function_exists( $functionName)) {
          include(JPATH_ROOT.DS.'components'.DS.$option.DS.'router.php');
        }
        $originalVars = empty( $originalUri) ? $vars : $originalUri->getQuery( $asArray = true);
        $title = $functionName( $originalVars);
        $title = $pageInfo->router->encodeSegments( $title);
        // manage GET var lists ourselves, as Joomla router.php does not do it
        if (!empty($vars)) {
          // there are some unused GET vars, we must transfer them to our mechanism, so
          // that they are eventually appended to the sef url
          foreach( $vars as $k => $v) {
            switch ($k) {
              case 'option':
              case 'Itemid':
                shRemoveFromGETVarsList( $k);
                break;
              default:
                // if variable has not been used in sef url, add it to list of variables to be
                // appended to the url as query string elements
                if (array_key_exists( $k, $originalVars)) {
                  shAddToGETVarsList( $k, $v);
                } else {
                  shRemoveFromGETVarsList( $k);
                }
                break;
            }
          }
        }
        // special case for search component, as router.php encode the search word in the url
        // we can't do that, as we are storing each url in the db
        if (( isset($originalVars['option']) && $originalVars['option'] == 'com_search')
        && !empty($vars['searchword'])) {
          // router.php has encoded that in the url, we need to undo
          $title = array();
          $originalVars['searchword'] = $vars['searchword'];
          shAddToGETVarsList( 'searchword', $vars['searchword']);
          if (!empty($vars['view'])) {
            $vars['view'] = $vars['view'];
            shAddToGETVarsList( 'view', $vars['view']);
          }

        }

        // handle menu items, having only a single Itemid in the url
        // (router.php will return an empty array in that case, even if we have restored
        // the full non-sef url, as we already did)
        /*
         * Build the application route
         */
        $tmp = '';
        if (empty($title) && isset($vars['Itemid']) && !empty($vars['Itemid'])) {
          $menu = & JFactory::getApplication()->getMenu();
          $item = $menu->getItem($vars['Itemid']);

          if (is_object($item) && $vars['option'] == $item->component) {
            $title[] = $item->route;
          }
        }

        if(empty($title)) {
          $title[] = substr($vars['option'], 4);
        }

        // add user defined prefix
        $prefix = shGetComponentPrefix( $option);
        if (!empty( $prefix)) {
          array_unshift( $title, $prefix);
        }

        // now process the resulting title string
        $string = shFinalizePlugin( $string, $title, $shAppendString, '',
        (isset($limit) ? $limit : null), (isset($limitstart) ? $limitstart : null),
        (isset($shLangName) ? $shLangName : null), (isset($showall) ? $showall : null));
        break;

        // use sh404sef plugins, either in ext. dir or in sh404sef dir
      case Sh404sefClassBaseextplugin::TYPE_SH404SEF_ROUTER:
        _log('Loading sh404SEF plugin in ' . $extPluginPath);
        include $extPluginPath;
        break;

        // Joomsef plugins
      case Sh404sefClassBaseextplugin::TYPE_JOOMSEF_ROUTER:
        Sh404sefHelperExtplugins::loadJoomsefCompatLibs();
        include_once $extPluginPath;
        $className = 'SefExt_' . $option;
        $plugin = new $className;
        if(!shIsHomepage($string)) {
          // make sure the plugin does not try to calculate pagination
          $params = & SEFTools::GetExtParams('com_content');
          $params->set('pagination', '1');
          // ask plugin to build url
          $plugin->beforeCreate( $originalUri);
          $result = $plugin->create( $originalUri);
          $title = empty( $result['title']) ? array() : $result['title'];
          $plugin->afterCreate( $originalUri);
          // make sure we have a url
          if (empty($title) && isset($vars['Itemid']) && !empty($vars['Itemid'])) {
            $menu = & JFactory::getApplication()->getMenu();
            $item = $menu->getItem($vars['Itemid']);

            if (is_object($item) && $vars['option'] == $item->component) {
              $title[] = $item->route;
            }
          }
          $prefix = shGetComponentPrefix( $option);
          if (!empty( $prefix)) {
            array_unshift( $title, $prefix);
          }
          if(empty( $title) && !shIsHomepage($string)) {
            $title[] = substr($vars['option'], 4);
          }
          list($usedVars, $ignore) = $plugin->getNonSefVars( $result);
          if(!empty( $ignore)) {
            $usedVars = array_merge( $usedVars, $ignore);
          }
        } else {
          $string = '';
          $title[] = '/';
          $usedVars = array();
        }
        // post process result to adjust to our workflow

        if(!empty( $vars)) {
          foreach( $vars as $key => $value) {
            if(!array_key_exists( $key, $usedVars)) {
              shRemoveFromGETVarsList( $key);
            }
          }
        }

        // finalize url
        $string = shFinalizePlugin( $string, $title, $shAppendString = '', $shItemidString = '',
        (isset($limit) ? $limit : null), (isset($limitstart) ? $limitstart : null),
        (isset($shLangName) ? $shLangName : null), (isset($showall) ? $showall : null));
        break;

        // Acesef plugins
      case Sh404sefClassBaseextplugin::TYPE_ACESEF_ROUTER:
        Sh404sefHelperExtplugins::loadAcesefCompatLibs();
        include_once $extPluginPath;
        $className = 'AceSEF_' . $option;
        $plugin = new $className;
        $plugin->AcesefConfig = AcesefFactory::getConfig();  // some plugins appear to not call the constructor parent, and so AcesefConfig is not set
        $tmp = & JPluginHelper::getPlugin( 'sh404sefextacesef', $option);
        $params = new JRegistry();
        $params->loadString( $tmp->params);
        $plugin->setParams( $params);
        $segments = array();
        $do_sef = true;
        $metadata = array();
        $item_limitstart = 0;
        $plugin->beforeBuild( $originalUri);
        $originalVars = empty( $originalUri) ? $vars : $originalUri->getQuery( $asArray = true);
        $plugin->build( $originalVars, $title, $do_sef, $metadata, $item_limitstart );
        $plugin->afterBuild( $originalUri);
        $prefix = shGetComponentPrefix( $option);
        if (empty($title) && isset($vars['Itemid']) && !empty($vars['Itemid'])) {
          $menu = & JFactory::getApplication()->getMenu();
          $item = $menu->getItem($vars['Itemid']);

          if (is_object($item) && $vars['option'] == $item->component) {
            $title[] = $item->route;
          }
        }
        if (!empty( $prefix)) {
          array_unshift( $title, $prefix);
        }
        if(empty( $title) && !shIsHomepage($string)) {
          $title[] = substr($vars['option'], 4);
        }

        // acesef plugin don't remove used vars from our GET var manager
        // we'll do it now. Vars used are those not present anymore in
        // $originalVars
        // they will be reappended to the SEF url by shFinalizePlugin
        $usedVars = array_diff( $vars, $originalVars);
        if(!empty( $usedVars)) {
          foreach( $usedVars as $key => $value) {
            shRemoveFromGETVarsList( $key);
          }
        }
        // remove Itemid and option, as these are not unset by plugin
        shRemoveFromGETVarsList('Itemid');
        shRemoveFromGETVarsList('option');
        // finalize url
        $string = shFinalizePlugin( $string, $title, $shAppendString = '', $shItemidString = '',
        (isset($limit) ? $limit : null), (isset($limitstart) ? $limitstart : null),
        (isset($shLangName) ? $shLangName : null), (isset($showall) ? $showall : null));

        break;

      default:
        _log('Falling back to sefGetLocation');
        if (empty($sefConfig->defaultComponentStringList[str_replace('com_', '', $option)])) {
          $title[] = getMenuTitle($option, (isset($task) ? $task : null), null, null, $shLanguage );
        } else {
          $title[] = $sefConfig->defaultComponentStringList[str_replace('com_', '', $option)];
        }
        if ($title[0] != '/')  {
          $title[] = '/';  // V 1.2.4.q getMenuTitle can now return '/'
        }
        if (count($title) > 0) {
          // V 1.2.4.q use $shLanguage insted of $lang  (lang name rather than lang code)
          $string = sef_404::sefGetLocation($string, $title, (isset($task) ? $task : null), (isset($limit) ? $limit : null), (isset($limitstart) ? $limitstart : null), (isset($shLanguage) ? $shLanguage : null));
        }
        break;
    }

    return $string;
  }

  function revert(&$url_array, $pos) {

    die( 'voluntary die in ' . __METHOD__ . ' of class ' . __CLASS__);

    $shPageInfo = & Sh404sefFactory::getPageInfo();  // get page details gathered by system plugin
    $sefConfig = & Sh404sefFactory::getConfig();

    // get DB
    $database =& JFactory::getDBO();

    $QUERY_STRING ='';
    $req = implode('/',$url_array);
    if ($req != '/') $req = JString::ltrim($req, '/'); // V x
    $req = str_replace("//","/",$req);
    _log('sef404 reverting URL : '.$req);

    // read from db
    $sql="SELECT oldurl, newurl FROM #__sh404sef_urls WHERE oldurl = ".$database->Quote($req)." ORDER BY rank ASC LIMIT 1"; // V 1.2.4.q

    $database->setQuery($sql);
    $row = $database->loadObject();

    if ($row) {
      // use the cached url
      $string = $row->newurl;
      // check for urls using wrong letter case, 301 redirect to correct url case
      $shPageInfo = & Sh404sefFactory::getPageInfo();
      if (empty($shPageInfo->autoRedirectsDisabled) && $sefConfig->redirectToCorrectCaseUrl) {
        // if initial query exactly matches oldurl found in db, then case is correct
        // else we redirect to the url found in db, but we also need to append query string to it !
        if ($req != $row->oldurl) {
          // can only be different from case
          // what is the url we should redirect to ?
          $targetUrl = str_replace($req, $row->oldurl, $shPageInfo->shSaveRequestURI);
          $targetUrl = $shPageInfo->URI->protocol.'://'.$shPageInfo->URI->host.(empty($shPageInfo->URI->port) ? '' : ':'.$shPageInfo->URI->port)
          .$targetUrl.(empty($shPageInfo->URI->anchor) ? '':'#'.$shPageInfo->URI->anchor);
          // perform redirect
          _log( 'Redirecting to correct url case : from ' . $req . ' to ' . $targetUrl);
          shRedirect( $targetUrl);
        }
      }

      // keep going if we did not redirect to correct case
      _log('sef404 reverting URL : found : '.$row->newurl);
      // update the count
      $database->setQuery("UPDATE #__sh404sef_urls SET cpt=(cpt+1) WHERE `newurl` = ".$database->Quote($row->newurl)
      ." AND `oldurl` = ".$database->Quote($row->oldurl));  // V 1.2.4.q
      $database->query();

      // now we must merge query string from request and POST data with that found in db
      // as there might be common variables. For instance, limit=5 in the DB
      // but limit=10 as been pass as POST DATA from a drop-down list item
      $otherVars = empty($shPageInfo->URI->querystring) ? array() : $shPageInfo->URI->querystring;
      $postVars = JRequest::get( 'post');
      $otherVars = array_merge( $otherVars, $postVars);
      if( !empty( $otherVars)) {
        foreach( $otherVars as $key => $value) {
          // if var exists in the incoming url, override it with querystring or post var value
          if ( shGetURLVar( $string, $key, null) !== null) {
            // if we change the value of limit, we must reset limitstart, or we may end up
            // with weird page number
            if ($key == 'limit') {
              $limit = shGetURLVar( $string, 'limit', null);
              if (!is_null($limit) && $value != $limit){
                // we are changing limit value : is there a limitstart ?
                $limitstart = shGetURLVar( $string, 'limitstart', null);
                if (!is_null($limitstart)) {
                  // calculate a new limitstart
                  $limitstart = empty( $limit) ? 0 : floor( $limitstart / $limit) - 1;
                  $limitstart = $limitstart < 0 ? 0 : $limitstart;
                  // and set it
                  $string = shSetURLVar( $string, 'limitstart', $limitstart, $canBeEmpty = true);
                  // kill any remaining limitstart value
                  if (array_key_exists( 'limitstart', $otherVars)) {
                    unset( $otherVars['limitstart']);
                  }
                }
              }
            }
            // now apply new value for the key
            $string = shSetURLVar($string, $key,$value);
          }
        }
      }
      $string = str_replace( '&amp;', '&', $string );
      $QUERY_STRING= str_replace('index.php?','',$string);
      // so weird : because of how Joomla choose to not include $limit in urls, I must remove &limit=xx from the restored url
      // I do have to store it in db however, otherwise same sef will be associated with same non-sef, and then
      // Joomla content views will be screwed up also as they guess $limit and reset JRequest('limit');
      if (!empty( $QUERY_STRING)) {
        $QUERY_STRING = '&' . $QUERY_STRING;
        $option = shGetURLVar($QUERY_STRING, 'option');
        $layout = shGetURLVar( $QUERY_STRING, 'layout');
        if (empty( $layout)) {
          $layout = 'default';
        }
        $view = shGetURLVar( $QUERY_STRING, 'view');
        if ($option == 'com_content' && $layout != 'blog' &&  ($view == 'category' || $view == 'section')) {
          $limit = shGetURLVar($QUERY_STRING, 'limit');
          //$QUERY_STRING = shCleanUpVar( $QUERY_STRING, 'limit');
          // but we need to keep it, because of a bug in Joomla, which I could not trace
          // whereby the user state limit value in com_content.default.limit is that of the blog instead of that of the current view
          $mainframe = JFactory::getApplication();
          $mainframe->setUserState( 'com_content.sh.' . $view . '.' . $layout . '.limit', $limit);
          //_log( 'Removing limit from reverted url, to : ' . $QUERY_STRING);
        }
        $QUERY_STRING = JString::ltrim( $QUERY_STRING, '&');
      }
    }
    return $QUERY_STRING;
  }

  public static function getContentTitles($view,$id, $layout, $Itemid=0, $shLang = null, $sefConfig = null)  {

    // if config is not injected, get default one
    if (is_null( $sefConfig)) {
      $sefConfig = & Sh404sefFactory::getConfig();
    }
    $title = self::getContentSlugsArray( $view, $id, $layout, $Itemid, $shLang, $sefConfig);
    return $title;
  }

  public static function getContentSlugsArray( $view, $id, $layout, $Itemid = 0, $shLang = null, $sefConfig = null)  {

    $slugsArray = array();

    // if config is not injected, get default one
    if (is_null( $sefConfig)) {
      $sefConfig = & Sh404sefFactory::getConfig();
    }
    $id = empty( $id) ? 0 : intval($id);

    // TODO: this will not work when we have Joomfish (probably). With JF, default should be
    // $shLang = empty($shLang) ? $shPageInfo->shMosConfig_locale : $shLang; ??
    $requestedLanguage = empty( $shLang) ? '*' : $shLang;

    try {
      $slugsModel = Sh404sefModelSlugs::getInstance();
      $menuItemTitle = getMenuTitle( null, $view, (isset($Itemid) ? $Itemid : null), '',  $shLang);
      $uncategorizedPath = $sefConfig->slugForUncategorizedContent == shSEFConfig::COM_SH404SEF_UNCATEGORIZED_EMPTY ? '' : $menuItemTitle;
      switch ($view) {
        case 'category':
          if (empty($layout) || $layout != 'blog') {
            if ($sefConfig->shInsertContentTableName) {
              $prefix = empty($sefConfig->shContentTableName) ? $menuItemTitle : $sefConfig->shContentTableName;
              if (!empty($prefix)) {
                $prefixArray[] = $prefix;
              }
            }
            if (!empty($id)) { // we have a category id
              $slugsArray = $slugsModel->getCategorySlugArray( 'com_content', $id, $sefConfig->includeContentCatCategories, $sefConfig->useCatAlias, $insertId = false, $menuItemTitle, $requestedLanguage);
            } else {  // no category id, use menu item title
              if (!$sefConfig->shInsertContentTableName || empty($sefConfig->shContentTableName)) {
                if (!empty($menuItemTitle)) {
                  $slugsArray[] = $menuItemTitle;
                }
              }
            }
          } else {  // blog category
            if ($sefConfig->shInsertContentBlogName) {
              $prefix = empty($sefConfig->shContentBlogName) ? $menuItemTitle : $sefConfig->shContentBlogName;
              if (!empty($prefix)) {
                $prefixArray[] = $prefix;
              }
            }
            if (!empty($id)) {
              $slugsArray = $slugsModel->getCategorySlugArray( 'com_content', $id, $sefConfig->includeContentCatCategories, $sefConfig->useCatAlias, $insertId = false, $menuItemTitle, $requestedLanguage);
            } else { // this should not happen, probably a malformed url
              if (!$sefConfig->shInsertContentBlogName || empty($sefConfig->shContentBlogName)) {
                if (!empty($menuItemTitle)) {
                  $slugsArray[] = $menuItemTitle;
                }
              }
            }
          }
          if(!empty( $prefixArray)) {
            $slugsArray = array_merge( $prefixArray, $slugsArray);
          }
          $slugsArray[] = '/';
          break;
        case 'categories':
          // now get category(ies) path
          if (!empty($id)) {
            $slugsArray = $slugsModel->getCategorySlugArray( 'com_content', $id, $sefConfig->includeContentCatCategories, $sefConfig->useCatAlias, $insertId = false, $menuItemTitle, $requestedLanguage);
            // insert a suffix to distinguish from normal category listing
            if(!empty( $sefConfig->contentCategoriesSuffix)) {
              $slugsArray[] = $sefConfig->contentCategoriesSuffix;
            }
            // end with a directory sign
            $slugsArray[] = '/';
          } else {
            if (!empty($menuItemTitle)) {
              $slugsArray[] = $menuItemTitle;
            }
          }
          break;
        case 'featured' :
          if(!empty( $menuItemTitle)) {
            $slugsArray[] = $menuItemTitle;
          }
          break;
        case 'article':
          $article = $slugsModel->getArticle( $id);
          $language = $requestedLanguage;
          if(empty($article[$requestedLanguage])) {
            $language = '*';
          }
          // get category(ies)
          $slugsArray = $slugsModel->getCategorySlugArray( 'com_content', $article[$language]->catid, $sefConfig->includeContentCat, $sefConfig->useCatAlias, $insertId = false, $uncategorizedPath, $requestedLanguage);
          // get article slug, optionnally including article id inurl
          $insertIdCatList = $sefConfig->ContentTitleInsertArticleId ? $sefConfig->shInsertContentArticleIdCatList : array();
          $articleSlug = $slugsModel->getArticleSlug( $id, $sefConfig->UseAlias, $sefConfig->ContentTitleInsertArticleId, $insertIdCatList, $requestedLanguage);
          $slugsArray[] = $articleSlug;
          break;
        default :
          break;
      }

    } catch ( Sh404sefExceptionDefault $e) {
       
    }

    return $slugsArray;
  }

  /**
   *
   * @param  string $url
   * @param  array $title
   * @param  string $task
   * @param  int $limit
   * @param  int $limitstart
   * @return sefurl
   */
  function sefGetLocation($url, &$title, $task = null, $limit = null, $limitstart = null, $langParam = null, $showall = null) {


    $shPageInfo = & Sh404sefFactory::getPageInfo();
    $sefConfig = & Sh404sefFactory::getConfig();

    // get DB
    $database =& JFactory::getDBO();

    $lang = empty($langParam) ? $shPageInfo->shMosConfig_locale : $langParam;

    // shumisha : try to avoid duplicate content when using Joomfish by always adding &lang=xx to url (stored in DB).
    // warning : must add &lang=xx only if it does not exists already, which happens for the joomfish language selection modules or search results
    if (!strpos($url,'lang=')) {
      $shSepString = (substr($url, -9) == 'index.php' ? '?':'&');
      $url.= $shSepString.'lang='.shGetIsoCodeFromName($lang);
    }
    // shumisha end of fix
    //shorten the url for storage and for consistancy
    $url = str_replace( '&amp;', '&', $url );

    // V 1.2.4.q detect multipage homepage
    $shMultiPageHomePageFlag = shIsHomepage($url);

    // get all the titles ready for urls
    $location = array();
    foreach($title as $titlestring) {      // V 1.2.4.t removed array_filter as it prevents '0' values in URL
      $location[] = titleToLocation(urldecode($titlestring));
    }
    $location = implode("/", $location); // V 1.2.4.t
    // V 1.2.4.t remove duplicate /
    $location = preg_replace('/\/{2,}/', '/', $location);
    $location = JString::substr( $location, 0, sh404SEF_MAX_SEF_URL_LENGTH); // trim to max length V 1.2.4.t
    // shumisha protect against querying for empty location
    if (empty($location))  // V 1.2.4.t
    if ((!shIsMultilingual() || (shIsMultilingual() && shIsDefaultlang($lang))) && !$sefConfig->addFile
    && !$shMultiPageHomePageFlag) // V 1.2.4.q : need to go further and add pagination
    return ''; // if location is empty, and no Joomfish, or Joomfish but this is default language, then there is nothing to add to url before querying DB
    // shumisha end of change
    //check for non-sef url first and avoid repeative lookups
    //we only want to look for title variations when adding new
    //this should also help eliminate duplicates.
    // shumisha 2003-03-13 added URL Caching
    $realloc = '';
    $urlType = Sh404sefHelperCache::getSefUrlFromCache($url, $realloc);
    if ($urlType == sh404SEF_URLTYPE_NONE || $urlType == sh404SEF_URLTYPE_404) {  // V 1.2.4.t
      // shumisha end of addition
      $realloc = false;
      if ($urlType == sh404SEF_URLTYPE_NONE) {
        $query = "SELECT oldurl from #__sh404sef_urls WHERE newurl = ".$database->Quote($url);
        $database->setQuery($query);
        //if ($realloc = $database->loadResult()) {
        if ($shTemp = $database->loadObject())
        $realloc = $shTemp->oldurl;
      }
      if ($realloc) {
        // found a match, so we aredone
        //Dat betekent dus, dat de functie create(), slecht gekozen is
        // shumisha : removed this die() that I do not understand!
        //die('regel292 in sef_ext.php');
        // shumisha end of removal
      }
      else {
        // this is new, so we need to insert the new title.
        //Hier worden eindelijk de nieuwe links gemaakt
        $iteration = 1;
        $realloc = false;
        $prev_temploc = '';

        do {
          // temploc is $location, unless we're on a second or greater iteration,
          // then its $location.$iteration
          if (!empty($location))
          $shSeparator = (JString::substr($location, -1) == '/') ? '':'/';
          else $shSeparator = '';

          $temploc = shAddPaginationInfo( $limit, $limitstart, $showall, $iteration, $url, $location, $shSeparator); // v 1.2.4.t
          // V 1.2.4.t
          if ($shMultiPageHomePageFlag && ('/'.$temploc == $location)    // if homepage
          && ( !shIsMultilingual()       // and no Joomfish
          || ( shIsMultilingual()       // or Joomfish
          && shIsDefaultLang($lang))) ) {  // but this is default language
            // this is start page of multipage homepage, return home or forced home
            if (!empty($sefConfig->shForcedHomePage))  // V 1.2.4.t
            return str_replace( $shPageInfo->getDefaultLiveSite().'/', '',$sefConfig->shForcedHomePage);
            else
            return '';
          }

          // V 1.2.4.k here we need to check for other-than-default-language homepage
          // remove lang
          $v1 = shCleanUpLang( $url); // V 1.2.4.t
          $v2 = shCleanUpLang( $shPageInfo->homeLink); // V 1.24.t
          if ($v1 == $v2 || $v1 == 'index.php') {  // check if this is homepage

            if (shIsMultilingual() && !shIsDefaultLang($lang))   // V 1.2.4.m : insert language code based on param
            $temploc = shGetIsoCodeFromName($lang).'/';
            else $temploc = '';  // if homepage in not-default-language, then add language code even if param says opposite
            // as we otherwise would not be able to switch language on the frontpage
          } else

          $option = shGetURLVar($url, 'option', '');
          if (shInsertIsoCodeInUrl($option, $lang)) {  // V 1.2.4.m : insert language code based on param
            // V 1.2.4.q : pass URL lang info, as may not be current lang
            $temploc = shGetIsoCodeFromName($lang).'/'.$temploc;   // V 1.2.4.q  must be forced lang, not default
          }

          if ($temploc != '') {
            // see if we have a result for this location
            // V 1.2.4.r without mod_rewrite
            $temploc = shAdjustToRewriteMode($temploc);
            $sql =  "SELECT id, newurl, rank, dateadd FROM #__sh404sef_urls WHERE oldurl = ".$database->Quote($temploc)
            ." ORDER BY rank ASC"; // V 1.2.4.q
            $database->setQuery($sql);
            if ($iteration > 9999) {
              //var_dump($sql);
              JError::raiseError(500, 'Too many pages :'.$temploc.'##' );
            }
            $dburl = null; // V 1.2.4.t initialize $dburl to avoid notices error if cache disabled
            $dbUrlId = null; // V 1.2.4.t
            $urlType = sh404SEF_URLTYPE_NONE;
            // shumisha 2007-03-13 added URL caching, check for various URL for same content
            if ($sefConfig->shUseURLCache)
            $urlType = Sh404sefHelperCache::getNonSefUrlFromCache($temploc, $dburl);
            $newMaxRank = 0;
            $shDuplicate = false;
            if ($sefConfig->shRecordDuplicates || $urlType == sh404SEF_URLTYPE_NONE) {  // V 1.2.4.s
              $dbUrlList = $database->loadObjectList();
              if (count($dbUrlList) > 0) {
                $dburl = $dbUrlList[0]->newurl;
                $dbUrlId = $dbUrlList[0]->id;
                if (empty($dburl)) {  // V 1.2.4.t url was found in DB, but was a 404
                  $urlType = sh404SEF_URLTYPE_404;
                } else {
                  $newMaxRank = $dbUrlList[count($dbUrlList)-1]->rank+1;
                  $urlType = $dbUrlList[0]->dateadd == '0000-00-00' ?
                  sh404SEF_URLTYPE_AUTO : sh404SEF_URLTYPE_CUSTOM;
                }
              }
            }
            if ($urlType != sh404SEF_URLTYPE_NONE && $urlType != sh404SEF_URLTYPE_404) {
              if ($dburl == $url) {
                // found the matching object
                // it probably should have been found sooner
                // but is checked again here just for CYA purposes
                // and to end the loop
                $realloc = $temploc;
              } else $shDuplicate = true;
              // else, didn't find it, increment and try again
              // shumisha added this to close the loop if working on frontpage
              // as domain.tld/index.php?lang=xx and domain.tld/index.php?option=com_frontpage&Itemid=1&lang=xx both must end up in domain.tld/xx/ (if xx is not default language of course - in that case, they must endup in domain.tld)
              // this is true also if Joomfish is not installed and there is no language information in the url
              // V 1.2.4.q  this is a duplicate so we must indert it with incremented rank;
              if ($shDuplicate && $sefConfig->shRecordDuplicates) {
                shAddSefUrlToDBAndCache( $url, $temploc, ($shDuplicate?$newMaxRank:0), $urlType);
              }
              $realloc = $temploc; // to close the loop
              // shumisha end of addition
            } else {
              //title not found, chechk 404
              $dbUrlId = empty( $dbUrlId) ? 0 : intval($dbUrlId);
              if ($sefConfig->shLog404Errors) { // V 1.2.4.m
                if ($urlType == sh404SEF_URLTYPE_404 && !empty($dbUrlId)) {  // we already have seen that it is a 404
                  $id = $dbUrlId; // V 1.2.4.t
                } elseif ($urlType == sh404SEF_URLTYPE_404) {
                  $query = "SELECT `id` FROM #__sh404sef_urls WHERE `oldurl` = " . $database->Quote($temploc) . " AND `newurl` = ''";
                  $database->setQuery($query);
                  $id = $database->loadResult();
                } else $id = null;
              } else $id = null;  // V 1.2.4.m if we are not logging 404 errors, then no need to check for
              // previous hit of this page.
              if (!empty($id)) {
                // V 1.2.4.q : need to update dateadd to 0, as otherwise this redir will be seen as a custom redir
                // this makes all such 404 errors 'disappear' from the 404 log, but no other solution
                $query = "UPDATE #__sh404sef_urls SET `newurl` = ".
                $database->Quote($url).",`dateadd` = '0000-00-00' WHERE `id` = '$id'";
                $database->setQuery($query);
                if (!$database->query()) {
                  _log( 'error adding new sef url to db:' . $database->getErrorMsg());
                  //var_dump($query);
                } else {
                  Sh404sefHelperCache::addSefUrlToCache( $url, $temploc, sh404SEF_URLTYPE_AUTO); // v 1.2.4.t
                }
              } else {
                /* put it in the database */
                shAddSefUrlToDBAndCache( $url, $temploc, 0, sh404SEF_URLTYPE_AUTO);
              }
              $realloc = $temploc;
            }
          }
          $prev_temploc = $temploc;
          $iteration++;
          // shumisha allow loop exit if $temploc = '' (homepage)
          //} while (!$realloc);
        } while ((!$realloc) && ($temploc != ''));
      }
    } // shumisha : enf of check if URL is in cache
    return $realloc;
  }

  function getcategories($catid, $shLang = null, $section = '') {

    $shPageInfo = & Sh404sefFactory::getPageInfo();
    $sefConfig = & Sh404sefFactory::getConfig();

    $catid = empty( $catid) ? 0 : intval( $catid);
    // get DB
    $database =& JFactory::getDBO();
    $title = ''; // V 1.2.4.q
    $shLang = empty($shLang) ? $shPageInfo->shMosConfig_locale : $shLang;
    if (isset($catid) && $catid != 0){
      $query = 'SELECT title'.(shTranslateURL('com_content', $shLang)?',id':'')
      .' FROM #__categories WHERE id = "'.$catid.'"'
      . (empty( $section) ? '' : ' AND section = \'' . $section . '\'');
      $database->setQuery($query);
      $rows = $database->loadObjectList( );
      if ($database->getErrorNum()) {
        die( $database->stderr());
      }elseif( @count( $rows ) > 0 ){
        if( !empty( $rows[0]->title ) ){
          $title = $rows[0]->title;
        }
      }
    }
    return $title;
  }
}
