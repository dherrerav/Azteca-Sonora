<?php
/**
 * sh404SEF support for JomSocial component.
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: com_community.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 *
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & Sh404sefFactory::getConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin($lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// do something about that Itemid thing
if (!preg_match( '/Itemid=[0-9]+/i', $string)) { // if no Itemid in non-sef URL
  if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
    $string .= '&Itemid='.$shCurrentItemid;  // append current Itemid
    $Itemid = $shCurrentItemid;
    shAddToGETVarsList('Itemid', $Itemid);
  }
  if ($sefConfig->shInsertTitleIfNoItemid) {
    $title[] = $sefConfig->shDefaultMenuItemName ?
    $sefConfig->shDefaultMenuItemName : getMenuTitle($option, null, $shCurrentItemid );
  }
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$shCurrentItemid
  : '';
} else {  // if Itemid in non-sef URL
  $shItemidString = $sefConfig->shAlwaysInsertItemid ?
  COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX.$sefConfig->replacement.$Itemid
  : '';
}

// load JS language strings. If we are creating urls on the
// fly, after an automatic redirection, they may not be loaded yet
$lang =& JFactory::getLanguage();
$lang->load('com_community');

// real start
$Itemid = isset($Itemid) ? $Itemid : null;
$limit = isset($limit) ? $limit : null;
$limitstart = isset($limitstart) ? $limitstart : null;

if(!function_exists('shGetJSVersion')) {
  function shGetJSVersion()	{
    static $version		= null;

    if( is_null( $version ) )	{
      $parser		=& JFactory::getXMLParser('Simple');

      // Load the local XML file first to get the local version
      $xml = JPATH_ROOT . DS . 'administrator' . DS. 'components' .DS. 'com_community' .DS. 'community.xml';
       
      $parser->loadFile( $xml );
      $document	=& $parser->document;

      $element		=& $document->getElementByPath( 'version' );
      $version		= $element->data();
    }
    return $version;
  }
}

if(!function_exists('shGetJSText')) {
  function shGetJSText($id)	{

    static $prefix = null;
    if(is_null($prefix)) {
      $version = shGetJSVersion();
      $prefix = version_compare( shGetJSVersion(), '2.2.0') == -1 ? 'CC ' : 'COM_COMMUNITY_';
    }

    // id translation pre-2.2 to 2.2
    if($prefix !== 'CC ') {
      switch ($id) {
        case 'GROUP':
          $id = 'SINGULAR_GROUP';
          break;
        case 'SEARCH':
          $id = 'GROUPS_SEARCH';
          break;
        case 'MY GROUPS TITLE':
          $id = 'GROUPS_MY_GROUPS';
          break;
        case 'CREATE NEW GROUP TITLE':
          $id = 'GROUPS_CREATE_NEW_GROUP';
          break;
        case 'CREATE NEW EVENT':
          $id = 'EVENTS_CREATE_TITLE';
          break;
        case 'JOIN GROUP TITLE':
          $id = 'GROUPS_JOIN';
          break;
        case 'LEAVE GROUP TITLE':
          $id = 'GROUPS_LEAVE';
          break;
        case 'SHOW ALL BULLETINS':
          $id = 'GROUPS_BULLETIN_VIEW_ALL';
          break;
        case 'ADD BULLETIN':
          $id = 'GROUPS_BULLETIN_CREATE';
          break;
        case 'SHOW ALL DISCUSSIONS':
          $id = 'GROUPS_VIEW_ALL_DISCUSSIONS';
          break;
        case 'ADD DISCUSSION':
          $id = 'GROUPS_DISCUSSION_CREATE';
          break;
        case 'EDIT AVATAR':
          $id = 'PROFILE_AVATAR_EDIT';
          break;
        case 'EDIT GROUP AVATAR':
          $id = 'GROUPS_AVATAR_EDIT';
          break;
        case 'EDIT EVENT AVATAR':
          $id = 'EVENTS_EDIT_AVATAR';
          break;
        case 'EDIT':
          $id = 'GROUPS_EDIT';
          break;
        case 'EDIT PROFILE':
          $id = 'PROFILE_EDIT';
          break;
        case 'EDIT EVENT DETAILS':
          $id = 'EVENTS_EDIT';
          break;
        case 'MY PHOTOS TITLE':
          $id = 'PHOTOS_MY_PHOTOS_TITLE';
          break;
        case 'ADD ALBUM':
          $id = 'PHOTOS_CREATE_PHOTO_ALBUM';
          break;
        case 'UPLOAD PHOTOS':
          $id = 'PHOTOS_UPLOAD_PHOTOS';
          break;
        case 'MY VIDEOS':
          $id = 'VIDEOS_MY';
          break;
        case 'REMOVE':
          return 'remove';
          break;
        case 'SENT':
          $id = 'INBOX_SENT';
          break;
        case 'WRITE':
          $id = 'INBOX_WRITE';
          break;
        case 'REQUEST SENT':
          $id = 'FRIENDS_REQUEST_SENT';
          break;
        case 'PENDING APPROVAL':
          $id = 'FRIENDS_PENDING_APPROVAL';
          break;
        case 'MY EVENTS':
          $id = 'EVENTS_MINE';
          break;
        case 'INVITE':
          $id = 'INVITE_INVITED';
          break;
        case 'BROWSE APPS':
          $id = 'APPS_BROWSE';
          break;
        case 'LINK VIDEO':
          $id = 'VIDEOS_LINK';
          break;
        case 'GET AVATAR':
          return'GET AVATAR';
          break;
        case 'REGISTERED SUCCESSFULLY':
          $id = 'USER_REGISTERED';
          break;
        case 'EDIT PRIVACY':
          $id = 'PROFILE_PRIVACY_EDIT';
          break;  
        case 'GROUP MEMBERS':
        case 'MEMBERS':
          $id = 'GROUPS_MEMBERS';
          break;
        case 'APPLICATIONS':
          return 'app';
          break;
        case 'PROFILE':
          $id = 'GO_TO_PROFILE';
          break;
      }
    }

    // finally get text
    $text = JText::_( $prefix . str_replace( ' ', '_', $id));

    return $text;
  }
}

if (!function_exists( 'shGetJSUsernameSlug')) {
  function shGetJSUsernameSlug( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();

    $slug = '';

    if (empty($id)) {
      return $slug;
    }

    $database =& JFactory::getDBO();
    $query = 'SELECT id, username, name FROM #__users WHERE id ='. $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    // just in case
    if (empty($result)) {
      return 'user' . $sefConfig->replacement . $id;
    }

    // what prefix ?
    $prefix = $sefConfig->shJSInsertUserId ? $id : '';

    // what should be use as name ?
    $name = $sefConfig->shJSInsertUserFullName ? $result->name : '';
    if (empty( $name)) {
      $name = $sefConfig->shJSInsertUsername ? $result->username : '';
    }
    if (!empty($name)) {
      $slug = (empty($prefix) ? '' : $prefix . $sefConfig->replacement) . $name;
    }

    // if we added the user name or full name to sef url
    // remove it from query string
    if (!empty($name) && ($sefConfig->shJSInsertUsername || $sefConfig->shJSInsertUserFullName)) {
      shRemoveFromGETVarsList('userid');
    }

    return $slug;
  }
}

if(!function_exists( 'shGetJSGroupCategoryTitle')) {
  function shGetJSGroupCategoryTitle( $id, $option, $shLangName) {

    static $cats = null;

    $sefConfig = & Sh404sefFactory::getConfig();
    if (is_null( $cats)) {
      $database =& JFactory::getDBO();
      $query = 'SELECT id, name FROM #__community_groups_category';
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $cats = $database->loadObjectList( 'id', false);
      } else {
        $cats = $database->loadObjectList( 'id');
      }
    }
    $slug = empty( $cats[$id]) ? '' : $cats[$id]->name;
    $prefix = empty( $slug) || $sefConfig->shJSInsertGroupCategoryId ? $id : '';
    $slug = $prefix . (empty($slug) ? '' : $sefConfig->replacement)  . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSEventsCategoryTitle')) {
  function shGetJSEventsCategoryTitle( $id, $option, $shLangName) {

    static $cats = null;

    $sefConfig = & Sh404sefFactory::getConfig();
    if (is_null( $cats)) {
      $database =& JFactory::getDBO();
      $query = 'SELECT id, name FROM #__community_events_category';
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $cats = $database->loadObjectList( 'id', false);
      } else {
        $cats = $database->loadObjectList( 'id');
      }
    }
    $slug = empty( $cats[$id]) ? '' : $cats[$id]->name;
    $prefix = empty( $slug) || $sefConfig->shJSInsertGroupCategoryId ? $id : '';
    $slug = $prefix . (empty($slug) ? '' : $sefConfig->replacement)  . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSGroupTitleArray')) {
  function shGetJSGroupTitleArray( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, name, categoryid FROM #__community_groups WHERE id = ' . $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->name) || $sefConfig->shJSInsertGroupId ? $id : '';
    $groupName =  !is_object( $result) || empty( $result->name) ? '' : $result->name;
    $groupName = $prefix . (empty( $groupName) ? '' : $sefConfig->replacement) . $groupName;

    // optionnally insert group category
    if($sefConfig->shJSInsertGroupCategory) {
      $title = array( shGetJSGroupCategoryTitle( $result->categoryid, $option, $shLangName), $groupName);
    } else {
      $title = array( $groupName);
    }

    return $title;
  }
}

if (!function_exists( 'shGetJSGroupBulletinTitle')) {
  function shGetJSGroupBulletinTitle( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();

    $database =& JFactory::getDBO();
    $query = 'SELECT id, title FROM #__community_groups_bulletins WHERE id = ' . $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->title) || $sefConfig->shJSInsertGroupBulletinId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->title) ? '' : $result->title;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSGroupDiscussionTitle')) {
  function shGetJSGroupDiscussionTitle( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, title FROM #__community_groups_discuss WHERE id = ' . $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->title) || $sefConfig->shJSInsertDiscussionId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->title) ? '' : $result->title;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSMessageTitle')) {
  function shGetJSMessageTitle( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();

    $database =& JFactory::getDBO();
    $query = 'SELECT id, subject FROM #__community_msg WHERE id =' . $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->subject) || $sefConfig->shJSInsertMessageId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->subject) ? '' : $result->subject;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSPhotoAlbumDetails')) {
  function shGetJSPhotoAlbumDetails( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, name FROM #__community_photos_albums WHERE id =' . $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $prefix = !is_object( $result) || empty( $result->name) || $sefConfig->shJSInsertPhotoAlbumId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->name) ? '' : $result->name;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSPhotoTitle')) {
  function shGetJSPhotoTitle( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, caption FROM #__community_photos WHERE id = ' . $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }
     
    // this photo name
    $prefix = !is_object( $result) || empty( $result->caption) || $sefConfig->shJSInsertPhotoId ? $id : '';
    $slug =  !is_object( $result) || empty( $result->caption) ? '' : $result->caption;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if(!function_exists( 'shGetJSVideoCategoryTitle')) {
  function shGetJSVideoCategoryTitle( $id, $option, $shLangName) {

    static $cats = null;
    $sefConfig = & Sh404sefFactory::getConfig();

    if (is_null($cats)) {
      $database =& JFactory::getDBO();
      $query = 'SELECT id, name FROM #__community_videos_category';
      $database->setQuery( $query);
      if (!shTranslateUrl($option, $shLangName)) {
        $cats = $database->loadObjectList( 'id', false);
      } else {
        $cats = $database->loadObjectList( 'id');
      }
    }

    $prefix = empty( $cats[$id]) || $sefConfig->shJSInsertVideoCatId ? $id : '';
    $slug =  empty( $cats[$id]) ? '' : $cats[$id]->name;
    $slug = $prefix . (empty( $slug) ? '' : $sefConfig->replacement) . $slug;

    return $slug;
  }
}

if (!function_exists( 'shGetJSVideoTitle')) {
  function shGetJSVideoTitle( $id, $option, $shLangName) {
    $sefConfig = & Sh404sefFactory::getConfig();
     
    $database =& JFactory::getDBO();
    $query = 'SELECT id, title, category_id FROM #__community_videos WHERE id = ' . $database->Quote($id);
    $database->setQuery( $query);
    if (!shTranslateUrl($option, $shLangName)) {
      $result = $database->loadObject(false);
    } else {
      $result = $database->loadObject();
    }

    $videoName = ($sefConfig->shJSInsertVideoId ? $id . $sefConfig->replacement : '') . $result->title;
     
    // optionnally insert video category
    if($sefConfig->shJSInsertVideoCat) {
      $title = array( shGetJSVideoCategoryTitle( $result->category_id, $option, $shLangName), $videoName);
    } else {
      $title = array( $videoName);
    }

    return $title;

  }
}

if (!function_exists( 'shMustInsertJSName')) {
  function shMustInsertJSName($shJSName, $userid,$view) {
    $sefConfig = & Sh404sefFactory::getConfig();

    // nothing to insert
    if (empty( $shJSName)) {
      return false;
    }

    if(!$sefConfig->shJSInsertJSName) {
      // if set to not insert, return false
      // except if we are on user profile, and short urls to profile is on
      $insert = $sefConfig->shJSShortURLToUserProfile && $view == 'profile' && !empty($userid)
      // and poor configuration made that we don't insert username or user full name
      // in such case, we should still insert the name
      && !$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName;

      // or we are on user profile, and short url is off but user has set
      // to not insert user name or user full name
      if (!$insert && !$sefConfig->shJSShortURLToUserProfile && !$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName) {
        $insert = true;
      }
      return $insert;
    }

    // params say to insert name. we should do it, unless on
    // user profile page, and we are set to have short urls to profile
    $insert = !($sefConfig->shJSShortURLToUserProfile && $view == 'profile' && !empty($userid));

    // however if set to not insert either username or fullname, there will be a problem as
    // user id is passed a query string. In such case, revert the decision and still insert
    if (!$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName) {
      $insert = true;
    }

    return $insert;
  }
}

// main vars
$view = isset($view) ? $view : null;
$task = isset($task) ? $task : null;
$userid = isset($userid) ? $userid : null;

// insert component name from menu
$shJSName = shGetComponentPrefix($option);
$shJSName = empty($shJSName) ?  getMenuTitle($option, null, $Itemid, null, $shLangName ) : $shJSName;
$shJSName = (empty($shJSName) || $shJSName == '/') ? 'JS':$shJSName;

// do this only if not set to create direct links to user profile like mysite.com/john
if (shMustInsertJSName($shJSName, $userid,$view)) {
  $title[] = $shJSName;
  // if direct url to user profile, prevent adding suffix ('.html')
  if (($sefConfig->shJSShortURLToUserProfile ||
  (!$sefConfig->shJSShortURLToUserProfile && !$sefConfig->shJSInsertUsername && !$sefConfig->shJSInsertUserFullName))
  && $view == 'profile' && !empty($userid)) {
    $title[] = '/';
  }
}

// build url first based on view, but make use of other vars ($task,..) as needed
switch($view){
  case 'frontpage':
    if (empty( $task) && empty( $userid) && empty( $title)) {
      $title[] = $shJSName;
    }
    break;
  case 'profile':
    if(!empty( $userid)) {
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
      $title[] = '/';
    }
    } else if (empty($task)) {
      $title[] = shGetJSText('PROFILE');
      $title[] = '/';
    }
    break;
  case 'groups':
    if (empty($task) || $task == 'display') {
      $title[] = shGetJSText('GROUP');
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
      if (!empty($topicid)) {
        $title[] = shGetJSGroupDiscussionTitle( $topicid, $option, $shLangName);
      }
    } else if (!empty($categoryid)) {
      $title[] = shGetJSGroupCategoryTitle( $categoryid, $option, $shLangName);
    } else if (!empty($topicid)) {
      $title[] = shGetJSGroupDiscussionTitle( $topicid, $option, $shLangName);
    }else if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'photos':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    }
    if (empty($task) || $task=='search' || $task == 'display' || $task == 'app' || $task == 'album') {
      $title[] = shGetJSText('PHOTOS');
    }
    if(!empty( $albumid) && $sefConfig->shJSInsertPhotoAlbum) {
      $title[] = shGetJSPhotoAlbumDetails( $albumid, $option, $shLangName);
    }
    if(!empty($photoid)) {
      $title[] = shGetJSPhotoTitle( $photoid, $option, $shLangName);
    }
    if(empty($task) && empty( $albumid) && empty($photoid)) {
      $title[] = '/';
    }
    break;
  case 'videos':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    }
    if (empty( $task) || $task=='search' || $task == 'display' || $task == 'app') {
      $title[] = shGetJSText('VIDEOS');
    }
    if(!empty($catid)) {
      $title[] = shGetJSVideoCategoryTitle( $catid, $option, $shLangName);
    } else if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'search':
    if ($task != 'browse' && $task != 'advancesearch') {
      $title[] = shGetJSText('SEARCH');
    }
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'inbox':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = shGetJSText('INBOX');
    break;
  case 'register':
    $title[] = shGetJSText('REGISTER');
    break;
  case 'friends':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = shGetJSText('FRIENDS');
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'apps':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = shGetJSText('APPLICATIONS');
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  case 'events':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if (empty($task) || $task=='uploadavatar' || $task=='myinvites' || $task == 'expiredevents' || $task== 'search' || $task == 'display') {
      $title[] = shGetJSText('EVENTS');
    }

    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    }

    if (!empty( $categoryid)) {
      $slug = shGetJSEventsCategoryTitle($categoryid, $option, $shLangName);
      if(!empty($slug)) {
        $title[] = $slug;
      }
    }
    if(empty($task)) {
      $title[] = '/';
    }
    break;
  default:
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    if(!empty($groupid)) {
      $title = array_merge($title, shGetJSGroupTitleArray( $groupid, $option, $shLangName));
    }
    $title[] = $view;
}

// add more details based on $task
switch($task){

  // groups
  case 'mygroups':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = shGetJSText('MY GROUPS TITLE');
    $title[] = '/';
    break;
  case 'create':
    switch ($view) {
      case 'groups':
        $title[] = shGetJSText('CREATE NEW GROUP TITLE');
        break;
      case 'events':
        $title[] = shGetJSText('CREATE NEW EVENT');
        break;
      default:
        $title[] = $task;
        break;
    }
    break;
  case 'joingroup':
    $title[] = shGetJSText('JOIN GROUP TITLE');
    break;
  case 'leavegroup':
    $title[] = shGetJSText('LEAVE GROUP TITLE');
    break;
  case 'viewgroup':
    break;
  case 'created':
    $title[] = $task;
    break;
  case 'invitefriends':
    $title[] = shGetJSText('INVITE FRIENDS');
    break;
  case 'viewmembers':
    $title[] = shGetJSText('GROUP MEMBERS');
    $title[] = '/';
    break;
  case 'viewbulletin':
    if(!empty($bulletinid)) {
      $title[] = shGetJSGroupBulletinTitle( $bulletinid, $option, $shLangName);
    }
    break;
  case 'viewbulletins':
    $title[] = shGetJSText('SHOW ALL BULLETINS');
    break;
  case 'addnews':
    $title[] = shGetJSText('ADD BULLETIN');
    break;
  case 'viewdiscussion':
    if(!empty($topicid) && empty($task)) {
      $title[] = shGetJSGroupDiscussionTitle( $topicid, $option, $shLangName);
    }
    break;
  case 'viewdiscussions':
    $title[] = shGetJSText('SHOW ALL DISCUSSIONS');
    $title[] = '/';
    break;
  case 'adddiscussion':
    $title[] = shGetJSText('ADD DISCUSSION');
    break;
  case 'uploadAvatar':
    switch ($view) {
      case 'profile':
        $title[] = shGetJSText('EDIT AVATAR');
        break;
      default:
        $title[] = $task;
        break;
    }
    break;
  case 'uploadavatar':
    switch ($view) {
      case 'groups':
        $title[] = shGetJSText('EDIT GROUP AVATAR');
        break;
      case 'profile':
        $title[] = shGetJSText('EDIT AVATAR');
        break;
      case 'events':
        $title[] = shGetJSText('EDIT EVENT AVATAR');
        break;
      default:
        $title[] = $task;
        break;
    }
    break;
  case 'avatar':
    $title[] = shGetJSText('AVATAR');
    break;
  case 'edit':
    switch ($view) {
      case 'groups':
        $title[] = shGetJSText('EDIT');
        break;
      case 'profile':
        $title[] = shGetJSText('EDIT PROFILE');
        break;
      case 'events':
        $title[] = shGetJSText('EDIT EVENT DETAILS');
        break;
      default:
        $title[] = $task;
        break;

    }
    break;
  case 'editDetails':
    $title[] = shGetJSText('EDIT DETAILS');
    break;
  case 'privacy':
    $title[] = shGetJSText('EDIT PRIVACY');
    break;

    // photos
  case 'myphotos':
    $title[] = shGetJSText('MY PHOTOS TITLE');
    $title[] = '/';
    break;
  case 'newalbum':
    $title[] = shGetJSText('ADD ALBUM');
    break;
  case 'uploader':
    $title[] = shGetJSText('UPLOAD PHOTOS');
    break;
  case 'album':
    break;
  case 'editAlbum':
    $title[] = shGetJSText('EDIT');
    break;
  case 'photo':
    $title[] = shGetJSText('PHOTOS');
    break;
  case 'jsonupload':
    $dosef = false;
    break;

    // videos
  case 'myvideos':
    $title[] = shGetJSText('MY VIDEOS');
    $title[] = '/';
    break;
  case 'removevideo':
    $title[] = shGetJSText('REMOVE');
    break;
  case 'video':
    if(!empty($videoid)) {
      $title = array_merge( $title, shGetJSVideoTitle( $videoid, $option, $shLangName));
    }
    break;

    // messages
  case 'read':
    if(!empty($msgid)) {
      $title[] = shGetJSMessageTitle( $msgid, $option, $shLangName);
    }
    break;
  case 'sent':
    $title[] = shGetJSText('SENT');
    break;
  case 'write':
    $title[] = shGetJSText('WRITE');
    break;

    // applications
  case 'app':
    $title[] = shGetJSText('APPLICATIONS');
    break;
  case 'invite':
    $title[] = shGetJSText('INVITE FRIENDS');
    break;
  case 'sent':
    $title[] = shGetJSText('REQUEST SENT');
    break;
  case 'pending':
    $title[] = shGetJSText('PENDING APPROVAL');
    break;
  case 'remove':
    $slug = shGetJSUsernameSlug($userid, $option, $shLangName);
    if(!empty($slug)) {
      $title[] = $slug;
    }
    $title[] = shGetJSText('REMOVE');
    break;
  case 'field':
    $title[] = shGetJSText('FIELD');
    break;

    // events
  case 'myevents':
    $title[] = shGetJSText('MY EVENTS');
    $title[] = '/';
    break;
  case 'myinvites':
    $title[] = shGetJSText('INVITE');
    break;
  case 'expiredevents':
    $title[] = $task;
    break;
  case 'viewevent':
    $title[] = $task;
    break;

    // searching
  case 'advancesearch':
    $title[] = shGetJSText('CUSTOM SEARCH');
    $title[] = '/';
    break;
  case 'browse':
    if ($view == 'search') {
      $title[] = shGetJSText('MEMBERS');
      $title[] = '/';
    } else {
      $title[] = shGetJSText('BROWSE APPS');
      $title[] = '/';
    }
    break;
  case 'search':
    $title[] = shGetJSText('SEARCH');
    break;

    // others
  case 'removepicture':
    $title[] = shGetJSText('REMOVE PROFILE PICTURE');
    break;
  case 'link':
    $title[] = shGetJSText('LINK VIDEO');
    break;
  case 'registerProfile':
    $title[] = shGetJSText('PROFILE');
    break;
  case 'registerAvatar':
    $title[] = shGetJSText('GET AVATAR');
    break;
  case 'registerSucess':
    $title[] = shGetJSText('REGISTERED SUCCESSFULLY');
    break;
  default:
    if( !empty( $task)) {
      $title[] = $task;
    }
}

if(!empty($app)) {
  $title[] = $app;
  shRemoveFromGETVarsList( 'app');
}

shRemoveFromGETVarsList('view');
shRemoveFromGETVarsList('task');
shRemoveFromGETVarsList('msgid');
shRemoveFromGETVarsList('categoryid');
shRemoveFromGETVarsList('bulletinid');
shRemoveFromGETVarsList('topicid');
if($task != 'editAlbum') {
  shRemoveFromGETVarsList('albumid');
}
shRemoveFromGETVarsList('photoid');
shRemoveFromGETVarsList('groupid');
shRemoveFromGETVarsList('catid');
shRemoveFromGETVarsList('videoid');
shRemoveFromGETVarsList('fid');

shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
if(!empty($Itemid)) {
  shRemoveFromGETVarsList('Itemid');
}
if(!empty($limit)) {
  shRemoveFromGETVarsList('limit');
}
if(isset($limitstart)) {
  shRemoveFromGETVarsList('limitstart');
}

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
  $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
  (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
  (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

