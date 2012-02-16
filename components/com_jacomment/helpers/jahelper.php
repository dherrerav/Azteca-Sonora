<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * Enter description here...
 *
 */
$GLOBALS ['jacconfig'] = array ();
// Component Helper
jimport ( 'joomla.application.component.helper' );

$GLOBALS ['JACVERSION'] = '1.0.7';
$GLOBALS ['JACPRODUCTKEY'] = 'JACOMMENT';

class JACommentHelpers {
	/**
	 * Enter description here...
	 * giapnd add
	 * @return unknown
	 */
	function isPostBack() {
		if (JRequest::getVar ( 'task' ) == 'add')
			return FALSE;
		return count ( $_POST );
	}
	/**
	 * giapnd add
	 */
	function generatDate($timestamp, $mid = 0, $format = "d/M/Y H:i:s") {
		if (intval ( $timestamp ) == 0) {
			return "<span class=\"small\"> " . JText::_ ( 'not available' ) . "</span>";
		}
		$cal = explode ( " ", date ( $format, $timestamp ) );
		if ($mid != 0) {
			if ($cal [0] == date ( "d/M/Y" )) {
				return JText::_ ( "Today" );
			} else {
				return $cal [0];
			}
		} else {
			return $cal [0] . " " . JText::_ ( 'at' ) . " " . $cal [1];
		}
	}
	/**
	 * giapnd add
	 * return path template current
	 */
	function checkFileTemplate($file, $type = 'css', $folder = '') {
		$client = & JApplicationHelper::getClientInfo ( JRequest::getVar ( 'client', '0', '', 'int' ) );
		$tBaseDir = $client->path . DS . 'templates';
		$template = JACommentHelpers::templateDefaulte ();
		$fileName = '';
		if ($template) {
			$tBaseDir .= DS . $template->name;
			$fileName = $tBaseDir . DS . $type . DS;
			if ($folder)
				$fileName .= $folder . DS . 'tmpl';
			$fileName .= DS . $file;
			if (! JFile::exists ( $fileName ))
				return FALSE;
		}
		return $fileName;
	}
	function templateDefaulte() {
		$client = & JApplicationHelper::getClientInfo ( JRequest::getVar ( 'client', '0', '', 'int' ) );
		$tBaseDir = $client->path . DS . 'templates';
		//get template xml file info
		$rows = array ();
		$rows = JACommentHelpers::parseXMLTemplateFiles ( $tBaseDir );
		$template = '';
		for($i = 0; $i < count ( $rows ); $i ++) {
			if (JACommentHelpers::isTemplateDefault ( $rows [$i]->directory, $client->id ))
				$template = $rows [$i];
		}
		return $template;
	}
	
	function getFontOfCaptcha() {
		global $jacconfig;
		$app = JFactory::getApplication();
		$fileName = "captcha/font.ttf";
		if (isset ( $jacconfig ) && isset ( $jacconfig ["layout"] )) {
			$templateJaName = $jacconfig ["layout"]->get ( "theme", "default" );
		} else {
			$templateJaName = "default";
		}
		
		$session = &JFactory::getSession ();
		if (JRequest::getVar ( "jacomment_theme", '' )) {
			jimport ( 'joomla.filesystem.folder' );
			$themeURL = JRequest::getVar ( "jacomment_theme" );
			if (JFolder::exists ( 'components/com_jacomment/themes/' . $themeURL ) || (JFolder::exists ( 'templates/' . $app->getTemplate () . '/html/com_jacomment/themes/' . $themeURL ))) {
				$templateJaName = $themeURL;
			}
			$session->set ( 'jacomment_theme', $templateJaName );
		} else {
			if ($session->get ( 'jacomment_theme', null )) {
				$templateJaName = $session->get ( 'jacomment_theme', $templateJaName );
			}
		}
		
		$templateDirectory = JPATH_BASE . DS . 'templates' . DS . $app->getTemplate () . DS . 'html' . DS . "com_jacomment" . DS . "themes" . DS . $templateJaName . DS . "html";
		if (file_exists ( $templateDirectory . DS . $fileName )) {
			return $templateDirectory . DS . $fileName;
		} else {
			if (file_exists ( 'components/com_jacomment/themes/' . $templateJaName . '/html/' . $fileName )) {
				return 'components/com_jacomment/themes/' . $templateJaName . '/html/' . $fileName;
			} else {
				return 'components/com_jacomment/themes/default/html/' . $fileName;
			}
		}
	}
	
	function jacLoadImge($fileName, $theme) {
		$app = JFactory::getApplication();
		$fileTemplate = JPATH_BASE . DS . 'templates' . DS . $app->getTemplate () . DS . 'html' . DS . "com_jacomment" . DS . "themes" . DS . $theme . DS . "images" . DS . $fileName;
		$linkFile = "";
		if (file_exists ( $fileTemplate )) {
			$linkFile = JURI::base () . 'templates/' . $app->getTemplate () . '/html/com_jacomment/themes/' . $theme . '/images/'.$fileName;
		} else {
			if (file_exists ( JPATH_BASE . DS . 'components/com_jacomment/themes/' . $theme . '/images/'.$fileName )) {
				$linkFile = JURI::base () . 'components/com_jacomment/themes/' . $theme . '/images/'.$fileName;
			} else {
				$linkFile = JURI::base () . 'components/com_jacomment/themes/default/images/'.$fileName;
			}
		}
		return $linkFile;
	}
	
	function jaLoadBlock($fileName , $themePass='') {
		global $jacconfig;
		$app = JFactory::getApplication();
		if (isset ( $jacconfig ) && isset ( $jacconfig ["layout"] )) {
			$templateJaName = $jacconfig ["layout"]->get ( "theme", "default" );
		} else {
			$templateJaName = "default";
		}
		
		$session = &JFactory::getSession ();
		if (JRequest::getVar ( "jacomment_theme", '' )) {
			jimport ( 'joomla.filesystem.folder' );
			$themeURL = JRequest::getVar ( "jacomment_theme" );
			if (JFolder::exists ( 'components/com_jacomment/themes/' . $themeURL ) || (JFolder::exists ( 'templates/' . $app->getTemplate () . '/html/com_jacomment/themes/' . $themeURL ))) {
				$templateJaName = $themeURL;
			}
			$session->set ( 'jacomment_theme', $templateJaName );
		} else {
			if ($session->get ( 'jacomment_theme', null )) {
				$templateJaName = $session->get ( 'jacomment_theme', $templateJaName );
			}
		}
		if($themePass != '')
			$templateJaName = $themePass;
		$templateDirectory = JPATH_BASE . DS . 'templates' . DS . $app->getTemplate () . DS . 'html' . DS . "com_jacomment" . DS . "themes" . DS . $templateJaName . DS . "html";
		if (file_exists ( $templateDirectory . DS . $fileName )) {
			return $templateDirectory . DS . $fileName;
		} else {
			if (file_exists ( 'components/com_jacomment/themes/' . $templateJaName . '/html/' . $fileName )) {
				return 'components/com_jacomment/themes/' . $templateJaName . '/html/' . $fileName;
			} else {
				return 'components/com_jacomment/themes/default/html/' . $fileName;
			}
		}
	}
	
	function parseXMLTemplateFiles($templateBaseDir) {
		// Read the template folder to find templates
		jimport ( 'joomla.filesystem.folder' );
		$templateDirs = JFolder::folders ( $templateBaseDir );
		
		$rows = array ();
		
		// Check that the directory contains an xml file
		foreach ( $templateDirs as $templateDir ) {
			if (! $data = JACommentHelpers::parseXMLTemplateFile ( $templateBaseDir, $templateDir )) {
				continue;
			} else {
				$rows [] = $data;
			}
		}
		
		return $rows;
	}
	
	function getRealLengthOfComment($comment) {
		$tags = array ('/\[LARGE\]/isUs', '/\[\/LARGE\]/iUs', '/\[MEDIUM\]/isUs', '/\[\/MEDIUM\]/iUs', '/\[HR\]/iUs', '/\[B\]/isUs', '/\[\/B\]/iUs', '/\[I\]/isUs', '/\[\/I\]/iUs', '/\[U]/isUs', '/\[\/U\]/iUs', '/\[S\]/isUs', '/\[\/S\]/iUs', '/\[\*\]/isUs', '/\[\/\*\]/iUs', '/\[\#\]/isUs', '/\[\/\#\]/iUs', '/\[SUB\]/isUs', '/\[\/SUB\]/iUs', '/\[SUP\]/isUs', '/\[\/SUP\]/iUs', '/\[QUOTE]/isUs', '/\[\/QUOTE\]/iUs', '/\[LINK=(.*)\]/isUs', '/\[\/LINK\]/iUs', '/\[IMG\]/isUs', '/\[\/IMG\]/iUs', '/\[YOUTUBE\]/isUs', '/\[\/YOUTUBE\]/iUs' );
		$comment = preg_replace ( $tags, '', $comment );
		return strlen ( trim ( $comment ) );
	}
	
	function removeEmptyBBCode($comment) {
		$tags = array ('/\[LARGE\]\s*\[\/LARGE\]/iUs', '/\[MEDIUM\]\s*\[\/MEDIUM\]/iUs', '/\[B\]\s*\[\/B\]/iUs', '/\[I\]\s*\[\/I\]/iUs', '/\[U]\s*\[\/U\]/iUs', '/\[S\]\s*\[\/S\]/iUs', '/\[\*\]\s*\[\/\*\]/iUs', '/\[\#\]\s*\[\/\#\]/iUs', '/\[SUB\]\s*\[\/SUB\]/iUs', '/\[SUP\]\s*\[\/SUP\]/iUs', '/\[QUOTE]\s*\[\/QUOTE\]/iUs', '/\[LINK\]\s*\[\/LINK\]/iUs', '/\[IMG\]\s*\[\/IMG\]/iUs', '/\[YOUTUBE\]\s*\[\/YOUTUBE\]/iUs' );
		while ( 1 ) {
			$comment = preg_replace ( $tags, '', $comment );
			
			for($i = 0; $i < count ( $tags ); $i ++) {
				preg_match ( $tags [$i], $comment, $matched );
				if ($matched) {
					break;
				}
			}
			
			if ($i == count ( $tags )) {
				break;
			}
		}
		return $comment;
	}
	
	function isTemplateDefault($template, $clientId) {
		$db = & JFactory::getDBO ();
		
		// Get the current default template
		$query = ' SELECT template ' . ' FROM #__templates_menu ' . ' WHERE client_id = ' . ( int ) $clientId . ' AND menuid = 0 ';
		$db->setQuery ( $query );
		$defaultemplate = $db->loadResult ();
		
		return $defaultemplate == $template ? 1 : 0;
	}
	function parseXMLTemplateFile($templateBaseDir, $templateDir) {
		// Check of the xml file exists
		if (! is_file ( $templateBaseDir . DS . $templateDir . DS . 'templateDetails.xml' )) {
			return false;
		}
		
		$xml = JApplicationHelper::parseXMLInstallFile ( $templateBaseDir . DS . $templateDir . DS . 'templateDetails.xml' );
		
		if ($xml ['type'] != 'template') {
			return false;
		}
		
		$data = new StdClass ( );
		$data->directory = $templateDir;
		
		foreach ( $xml as $key => $value ) {
			$data->$key = $value;
		}
		
		$data->checked_out = 0;
		$data->mosname = JString::strtolower ( str_replace ( ' ', '_', $data->name ) );
		
		return $data;
	}
	function temp_export($item) {
		$content = '## ************** ' . JText::_ ( 'Begin email template' ) . ': ' . $item ['name'] . ' ****************##' . "\r\n\r\n";
		
		$content .= '[Email_Template name="' . $item ['name'] . '"';
		
		$content .= ' published="' . $item ['published'] . '" group="' . ( int ) $item ['group'] . '" language="' . $item ['language'] . '"]' . "\r\n";
		
		$content .= '[title]' . "\r\n";
		$content .= $item ['title'] . "\r\n";
		
		$content .= '[subject]' . "\r\n";
		$content .= $item ['subject'] . "\r\n";
		
		$content .= '[content]' . "\r\n";
		$content .= $item ['content'] . "\r\n";
		
		$content .= '[EmailFromName]' . "\r\n";
		$content .= $item ['email_from_name'] . "\r\n";
		
		$content .= '[EmailFromAddress]' . "\r\n";
		$content .= $item ['email_from_address'] . "\r\n";
		$content .= '[/Email_Template]' . "\r\n\r\n";
		$content .= '## ************** ' . JText::_ ( 'End email template' ) . ': ' . $item ['name'] . ' ****************##' . "\r\n\r\n\r\n\r\n\r\n\r\n";
		
		return $content;
	}
	function getGroupUser($where = '', $name = '', $attr = '', $selected = '', $default = 0) {
		$db = JFactory::getDBO ();
		$query = 'SELECT a.id as value,a.title as text
				  FROM `#__usergroups` AS a
				  LEFT OUTER JOIN `#__usergroups` AS c2 ON a.lft > c2.lft AND a.rgt < c2.rgt
				  LEFT JOIN `#__user_usergroup_map` AS map ON map.group_id = a.id
				  GROUP BY a.id
				  ORDER BY a.lft asc ' . $where;
		$db->setQuery ( $query );
		$types = $db->loadObjectList ();		
		if ($default) {
			if($types){
				$types = array_merge ( array (JHTML::_ ( 'select.option', '0', JText::_ ( 'SELECT_GROUP' ), 'value', 'text' ) ), $types );
			}else{
				$types = array (JHTML::_ ( 'select.option', '0', JText::_ ( 'SELECT_GROUP' ), 'value', 'text' ));
			}
		}
		
		$lists = JHTML::_ ( 'select.genericlist', $types, $name, $attr, 'value', 'text', $selected );
		
		return $lists;
	}
	function displayNote($message, $type) {
		?>
<div id="jac-system-message"><?php
		echo $message;
		?></div>
<script>
		jQuery(document).ready( function($) {
			var coo = getCookie('hidden_message_<?php
		echo $type?>');
			if(coo==1)
				$('#jac-system-message').attr('style','display:none');
			else
				$('#jac_help').html('<?php
		echo JText::_ ( 'CLOSE_TEXT' )?>');
		});	
		</script>
<?php
	}
	/**
	 * end giapnd add
	 */
	/**
	 * Enter description here...
	 *
	 */
	function get_config_system() {
		global $jacconfig;
		$app = JFactory::getApplication();
		
		if (defined ( 'COMPOENT_JACOMMENT_CONFIG' ))
			return;
		
		$setup = new stdClass ( );
		$db = JFactory::getDBO ();
		$setup = new stdClass ( );
		$q = 'SELECT * FROM #__jacomment_configs';
		$db->setQuery ( $q );
		$rows = $db->loadObjectList ();
		if ($rows) {
			foreach ( $rows as $row ) {
				$jacconfig [$row->group] = new JRegistry;
				$jacconfig [$row->group]->loadJSON($row->data); 
			}
		}
		define ( 'COMPOENT_JACOMMENT_CONFIG', true );
	}
	
	function setCommentUrl($url) {
		global $jacconfig;
		$webUrl = JURI::root () . "index.php?";
		$jacconfig ["commenturl"] = $webUrl . $url;
	}
	
	/* Enter description here...
	 *
	 * @param unknown_type $timeStamp
	 * @param unknown_type $mid
	 * @return unknown
	 */
	function generatTimeStamp($timeStamp, $mid = 0) {
		$ago = 0;
		if ($mid == 0) {
			$cal = (time () - $timeStamp);
		} else {
			$cal = ($timeStamp - time ());
			if ($cal < 0) {
				$cal = 0 - $cal;
				$ago = 1;
			}
		}
		$d = floor ( $cal / 24 / 60 / 60 );
		$h = floor ( ($cal / 60 / 60 - $d * 24) );
		$m = floor ( ($cal / 60 - $d * 24 * 60 - $h * 60) );
		
		if ($mid == 0) {
			if ($d < 3) {
				$str = "<span class=\"small\">" . ($h + $d * 24) ." ". JText::_ ( 'hours ago' ) ."</span>";
			} 
elseif ($d < 120) {
				$str = "<span class=\"class_2dayago\"> " . $d . " " . JText::_ ( 'days' ) . " " . JText::_ ( 'ago' ) . "</span>";
			} else {
				$str = "<span class=\"time_show\"> " . $m . " " . JText::_ ( 'months' ) . " " . JText::_ ( 'ago' ) . "</span>";
			}
			return $str;
		} else {
			if ($d == 0) {
				$str = "<span class=\"class_today\">" . JText::_ ( 'Today' ) . "</span>";
			} else {
				if ($ago == 1) {
					if ($d == 1) {
						$str = "<span class=\"class_yesterday\">" . JText::_ ( 'Yesterday' ) . "<span class=\"small\"> +" . $h . "h</span>";
					
					} else {
						//$str = generatDate($timeStamp,1);
						$str = "<span class=\"time_show\">" . $d . " " . "d," . $h . "h " . JText::_ ( 'ago' ) . ".</span>";
					}
				} else {
					if ($d == 1) {
						$str = "<span class=\"class_tomorrow\">" . JText::_ ( 'Tomorrow' ) . "</span>";
					} else {
						//$str = generatDate($timeStamp,1);
						$str = "<span class=\"time_show\">" . $d . " " . "d," . $h . "h.</span>";
					}
				}
			}
			return $str;
		}
	}
	
	function check_access(&$artileText='') {
		global $jacconfig;
		$sourceArticle = $artileText;				
		// Check to see if the user has access to view the full article				
		if(JACommentHelpers::isSpecialUser()){
			return true;
		}
		
		$app = JFactory::getApplication();
		$access = isset ( $jacconfig ['general'] ) ? $jacconfig ['general']->get ( 'access', 0 ) : 0;
		
		$user = & JFactory::getUser ();
		$levAccess = $user->getAuthorisedViewLevels();
		
		if(in_array($access, $levAccess)){
			return true;
		}else{			
			$artileText .= '<div class="jac-offline">';
			if (JPluginHelper::isEnabled ( 'system', 'janrain' )) {				
				$artileText .= '<div id="jac-login-form" style="margin:20px auto;padding:20px;width:400px;">';
				$artileText .= '<h4>' . $jacconfig ['general']->get ( 'display_message' ) . '</h4>';
				$artileText .= '{janrain}';
				$artileText .= '</div>';
			} else {				
				$module = JModuleHelper::getModule ( 'mod_login', 'Login Form' );				
				if ($module && $module->id) {
					$artileText .= '<div id="jac-login-form">';
					$artileText .= '<h4>' . $jacconfig ['general']->get ( 'display_message' ) . '</h4>';
					$artileText .= JModuleHelper::renderModule ( $module );
					$artileText .= '</div>';
				}else{
					$artileText .= '<div>';
					$artileText .= '<h4>' . $jacconfig ['general']->get ( 'display_message', JText::_ ( 'This site is down for maintenance. Please check back again soon.' ) ) . '</h4>';
					$artileText .= '</div>';					
				}
			}
			$artileText .= '</div>';
			if($sourceArticle == "") echo $artileText;
			return false;
		}		
	}
	
	function check_permissions() {
		global $jacconfig;
		$app = JFactory::getApplication();
		$permissions = isset ( $jacconfig ['permissions'] ) ? $jacconfig ['permissions']->get ( 'view', 'all' ) : 'all';
		
		if ($permissions == "all")
			return true;
		
		$user = & JFactory::getUser ();
		
		if (! $user->guest) {
			return true;
		} else {
			JRequest::setVar ( "option", "com_jacomment" );
			echo '<div id="jac-wrapper"><div id="jac-login-form" style="margin:0px auto;width:400px;">';
			echo JText::_ ( "PLEASE_LOGIN_TO_VIEW_COMMENT" );
			echo '<input type="button" name="btlLogin" value="' . JText::_ ( "Login now" ) . '" onclick="open_login(\'' . JText::_ ( "Login Now" ) . '\')" />';
			echo '</div></div>';
			return false;
		}
	}
	
	function isSpecialUser($userID = 0, $action = '') {
		if ($userID == 0) {
			if ($action) {
				return false;
			}
			$user = & JFactory::getUser ();
		} else {
			$user = & JFactory::getUser ( $userID );
		}				
		
		$result	= new JObject;

		$actions = array(
			'core.admin', 'core.manage'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, 'com_users'));
		}
		if($result->get("core.admin") == 1 || $result->get("core.manage") == 1){
			return true;
		}
		
		return false;
	}
	
	function parse_JSON_new($objects){
		if (! $objects)
			return;
		if(function_exists("json_decode")){			
			$html = json_encode($objects);
		}else{				
			require_once (JPATH_COMPONENT.DS . "/helpers/JSON.php");
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			$result = $json->decode($result);							
		}					
		return $html;
	}
	
	function parse_JSON($objects) {
		if (! $objects)
			return;
		$db = JFactory::getDBO ();
		
		$html = '';
		$item_tem = array ();
		foreach ( $objects as $i => $row ) {
			$tem = array ();
			$item_tem [$i] = '{';
			foreach ( $row as $k => $value ) {
				//$value = $db->Quote($value);
				$tem [$i] [] = "'$k' : " . $db->Quote ( $value ) . "";
			}
			$item_tem [$i] .= implode ( ',', $tem [$i] );
			$item_tem [$i] .= '}';
		}
		
		if ($item_tem)
			$html = implode ( ',', $item_tem );
		
		return $html;
	}
	function parseProperty($type = 'html', $id = 0, $value = '', $reload = 0) {
		$object = new stdClass ( );
		$object->type = $type;
		$object->id = $id;
		$object->value = $value;
		if ($reload)
			$object->reload = $reload;
		return $object;
	}
	function parsePropertyPublish($type = 'html', $id = 0, $publish = 0, $number = 0, $function = 'publish', $title = 'Publish', $un = 'Unpublish') {
		$object = new stdClass ( );
		$object->type = $type;
		$object->id = $id;
		if (! $publish) {
			$html = '<a  href="jacascript:void(0);" onclick="return listItemTask(\'cb' . $number . '\',\'' . $function . '\')" title=\'' . $title . '\'><img id="i5" border="0" src="images/publish_x.png" alt="Publish"/></a>';
		} else {
			$function = 'un' . $function;
			$html = '<a  href="jacascript:void(0);" onclick="return listItemTask(\'cb' . $number . '\',\'' . $function . '\')" title=\'' . $un . '\'><img id="i5" border="0" src="images/tick.png" alt="Unpublish"/></a>';
		}
		
		$object->value = $html;
		return $object;
	}
	
	function JomSocial_addActivityStream($actor, $title, $cid, $action = 'add') {
		global $jacconfig;
		
		if (JACommentHelpers::checkComponent ( 'com_community' ) && (! isset ( $jacconfig ['layout'] ) || $jacconfig ['layout']->get ( 'enable_activity_stream', 0 ))) {
			require_once (JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php');
			require_once (JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'activities.php');
			
			include_once (JPATH_ROOT . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'userpoints.php');
			
			$act = new stdClass ( );
			$act->cmd = 'com_jacomment.comment.' . $action;
			
			$userPointModel = CFactory::getModel ( 'Userpoints' );
			// Test command, with userpoint command. If is unpublished do not proceed into adding to activity stream.
			$point = $userPointModel->getPointData ( $act->cmd );
			$points = 0;
			if ($point && ! $point->published) {
				$points = 1;
			} elseif ($point)
				$points = $point->points;
			
			$act->actor = $actor;
			$act->target = $actor; // no target
			$act->title = JText::_ ( $title );
			$act->content = JText::_ ( 'This is the body' );
			$act->app = 'com_jacomment.comment';
			$act->cid = $cid;
			$act->points = $points;
			CFactory::load ( 'libraries', 'activities' );
			CActivityStream::add ( $act );
			
			/* Add points for user */
			CuserPoints::assignPoint ( $act->cmd, $actor );
		}
	}
	
	function message($iserror = 1, $messages) {
		if ($iserror) {
			$content = '<dd class="error message fade">
						<ul id="jac-error">';
			foreach ( $messages as $message ) {
				$content .= '<li>' . $message . '</li>';
			}
			$content .= '			</ul>
					</dd>';
		} else {
			$content = '<dt class="message">Message</dt>
						<dd class="message message fade">
						<ul>';
			if ($messages && is_array ( $messages )) {
				foreach ( $messages as $message ) {
					$content .= '<li>' . $message . '</li>';
				}
			} else {
				$content .= '<li>' . $messages . '</li>';
			}
			$content .= '			</ul>
					</dd>';
		}
		return $content;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $template
	 * @return unknown
	 */
	function getEmailTemplate($temp_name) {
		
		$db = JFactory::getDBO ();
		
		$client = & JApplicationHelper::getClientInfo ( 0 );
		$params = JComponentHelper::getParams ( 'com_languages' );
		$language = $params->get ( $client->name, 'en-GB' );
		
		$query = "SELECT * FROM #__jacomment_email_templates WHERE name='$temp_name' and language='$language' and  published=1";
		$db->setQuery ( $query );
		$template = $db->loadObject ();
		
		if (! $template && $language != 'en-GB') {
			$query = "SELECT * FROM #__jacomment_email_templates WHERE name='$temp_name' and language='en-GB' and  published=1";
			$db->setQuery ( $query );
			$template = $db->loadObject ();
		}
		//		else{
		//            $template->subject = '';
		//            $template->content = '';
		//        }
		

		return $template;
	}
	function getFilterConfig() {
		global $jacconfig;
		$config = new JConfig ( );
		$filters ['{CONFIG_ROOT_URL}'] = $app->getCfg ( 'live_site' );
		$filters ['{CONFIG_SITE_TITLE}'] = $app->getCfg ( 'live_site' );
		$filters ['{ADMIN_EMAIL}'] = $jacconfig ['general']->get ( 'fromemail', $config->mailfrom );
		$filters ['{SITE_CONTACT_EMAIL}'] = $jacconfig ['general']->get ( 'fromemail', $config->mailfrom );
		return $filters;
	}
	function getLink($link, $title = '') {
		if (! strpos ( 'http://', $link )) {
			$link = substr ( $link, 1, strlen ( $link ) );
			$link = JURI::root () . $link;
		}
		if ($title != '')
			$link = "<a href='$link'>$title</a>";
		return $link;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $to
	 * @param unknown_type $nameto
	 * @param unknown_type $subject
	 * @param unknown_type $content
	 * @param unknown_type $filters
	 * @param unknown_type $from
	 * @param unknown_type $fromname
	 * @param unknown_type $attachment
	 * @param unknown_type $header
	 * @return unknown
	 */
	function sendmail($to, $nameto, $subject, $content, $filters = "", $from = '', $fromname = '', $attachment = array(), $header = true) {
		global $jacconfig;
		
		if ($header) {
			$header = $this->getEmailTemplate ( "mailheader" );
			$footer = $this->getEmailTemplate ( "mailfooter" );
			if ($header)
				$content = $header->content . "\n" . $content . "\n\n";
			if ($footer) {
				$content .= $footer->content;
			}
		}
		
		if (is_array ( $filters )) {
			foreach ( $filters as $key => $value ) {
				$subject = str_replace ( $key, $value, $subject );
				$content = str_replace ( $key, $value, $content );
			}
		}
		
		$content = html_entity_decode(stripslashes ( $content ));
		$subject = html_entity_decode(stripslashes ( $subject ));
		//get admin email	
		$config = new JConfig ( );
		
		if (! $from)
			$from = $jacconfig ['general']->get ( 'fromemail', $config->mailfrom );
		if (! $fromname)
			$fromname = $jacconfig ['general']->get ( 'fromname', $config->fromname );
		$sendmail = $jacconfig ['general']->get ( 'mail_view_only', 0 );
		$mail = null;
		//only view email
		//echo mail			
		if ($sendmail == 1) {
			//echo mail
			if (is_array ( $to ))
				$to = implode ( ', ', $to );
			echo JText::_ ( "SENDER" ) . ' ' . $fromname . ' (' . $from . ")" . "<br>";
			echo JText::_ ( "SEND TO" ) . ' ' . $nameto . ' (' . $to . ")" . "<br>";
			echo JText::_ ( "SUBJECT" ) . ' ' . $subject . "<br />";
			echo JText::_ ( 'CONTENT' ) . ' ' . str_replace ( "\n", "<br/>", $content ) . "<br />-----------------------------<br />";
			return true;
		} else {
			//send email			
			$mail = JFactory::getMailer ();
			$mail->setSender ( array ($from, $fromname ) );
			$mail->addRecipient ( $to );
			$mail->setSubject ( $subject );
			$mail->setBody ( str_replace ( "\n", "<br/>", $content ) );
			
			if ($jacconfig ['general']->get ( 'sendmode', 1 ))
				$mail->IsHTML ( true );
			else
				$mail->IsHTML ( false );
			
			if ($jacconfig ['general']->get ( 'ccemail' ) != "")
				$mail->addCc ( explode ( ',', $jacconfig ['general']->get ( 'ccemail' ) ) );
			
			if ($attachment)
				$mail->addAttachment ( $attachment );
			return;		
			$sent = $mail->Send ();
						
			if (JError::isError($sent)) {
				//$this->setError($sent->getError());
				return false;
			}elseif (empty($sent)) {
				//$this->setError(JText::_('COM_USERS_MAIL_THE_MAIL_COULD_NOT_BE_SENT'));
				return false;
			}else{
				return true;
			}			
		}
		return false;
	}
	
	function sendMailWhenNewCommentApproved($commentID, $wherejatotalcomment = '', $type = '', $post = '') {
		$app = JFactory::getApplication();
		$app->isAdmin ();
		$url = $app->isAdmin () ? JURI::root () : JURI::base ();
		if ($type == "addNew") {
			if ($wherejatotalcomment) {
				//get all comment is chooise subcription is 2 								
				$itemSendMails = $this->getItemsSendMail ( $wherejatotalcomment . " AND c.subscription_type = 2 AND c.id <>" . $commentID );
			}
			
			if ($itemSendMails) {
				$mail = $this->getEmailTemplate ( "Jacommentnotifying_comment_creator_if_there_is_a_new_comment_on_the_issue" );
				$filters = array ();
				
				$userEmail = "";
				$userName = "";
				foreach ( $itemSendMails as $itemSendMail ) {
					$userEmail = $itemSendMail->email;
					$userName = $itemSendMail->name;
					
					$filters ['{USERS_USERNAME}'] = $userName;
					$filters ['{ITEM_DETAILS}'] = $post ['comment'];
					$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
					$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
					$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
					
					$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
				}
			}
		} //type is reply comment
		else {
			$parentArray = array ();
			$this->getParentCommentID ( $commentID, $parentArray );
			//get all comment is chooise subcription is 2
			if ($wherejatotalcomment) {
				$itemSendMails = $this->getItemsSendMail ( $wherejatotalcomment . " AND c.id <>" . $commentID );
			}
			if ($itemSendMails) {
				$mail = $this->getEmailTemplate ( "Jacommentnotifying_comment_creator_if_there_is_a_new_comment_on_the_issue" );
				$mailReply = $this->getEmailTemplate ( "Jacommentnotifying_comment_creator_if_there_is_a_new_reply_to_his_comment" );
				$filters = array ();
				
				$userEmail = "";
				$userName = "";
				foreach ( $itemSendMails as $itemSendMail ) {
					//check in parent array
					if (isset ( $parentArray [$itemSendMail->id] )) {
						if ($parentArray [$itemSendMail->id] ['subscription_type'] == 1) {
							$userEmail = $itemSendMail->email;
							$userName = $itemSendMail->name;
							
							$filters ['{USERS_USERNAME}'] = $userName;
							$filters ['{ITEM_DETAILS}'] = $post ['comment'];
							$filters ['{REPLY_OWNER}'] = $post ['name'];
							$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
							$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
							$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
							
							$this->sendmail ( $userEmail, $userName, $mailReply->subject, $mailReply->content, $filters );
						} else {
							if ($itemSendMail->subscription_type == 2) {
								//echo "OK -".$itemSendMail->id." --". $itemSendMail->email. "++".$itemSendMail->subscription_type."*****\n";
								$userEmail = $itemSendMail->email;
								$userName = $itemSendMail->name;
								
								$filters ['{USERS_USERNAME}'] = $userName;
								$filters ['{ITEM_DETAILS}'] = $post ['comment'];
								$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
								$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
								$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
								
								$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
							}
						}
					} else {
						if ($itemSendMail->subscription_type == 2) {
							//echo "OK -".$itemSendMail->id." --". $itemSendMail->email. "++".$itemSendMail->subscription_type."*****\n";
							$userEmail = $itemSendMail->email;
							$userName = $itemSendMail->name;
							
							$filters ['{USERS_USERNAME}'] = $userName;
							$filters ['{ITEM_DETAILS}'] = $post ['comment'];
							$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
							$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
							$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
							
							$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
						}
					}
				}
			}
		
		}
	
	}
	
	function replaceSpecialString($text) {
		$text = str_replace ( "<br />", "\n", $text );
		$text = preg_replace ( '#<img[^\>]+/>#isU', '$1', $text );
		$text = preg_replace ( '#(?<!S)<a.*?>(.*?)</a>#isU', '$1$2$3', $text );
		$text = preg_replace ( '#<object.*?>(.*?)</object>#isU', '$1', $text );
		$text = preg_replace ( '#<code.*?>(.*?)</code>#isU', '$1', $text );
		$text = preg_replace ( '#<embed.*?>(.*?)</embed>#isU', '$1', $text );
		return $text;
	}
	
	function replaceURLWithHTMLLinks($text) {
		global $jacconfig;
		$text = " " . $text;
		if ($jacconfig ["spamfilters"]->get ( "is_nofollow" )) {
			$text = preg_replace ( '/(?<!S)((http(s?):\/\/)|(www.))+([a-zA-Z0-9\/*+-_?&;:%=.,#]+)/', '<a href="http$3://$4$5" target="_blank" rel="nofollow">$4$5</a>', $text );
			$text = preg_replace ( '/(?<!S)([a-zA-Z0-9_.\-]+\@[a-zA-Z][a-zA-Z0-9_.\-]+[a-zA-Z]{2,6})/', '<a href="mailto://$1" rel="nofollow">$1</a>', $text );
		} else {
			$text = preg_replace ( '/(?<!S)((http(s?):\/\/)|(www.))+([a-zA-Z0-9\/*+-_?&;:%=.,#]+)/', '<a href="http$3://$4$5" target="_blank">$4$5</a>', $text );
			$text = preg_replace ( '/(?<!S)([a-zA-Z0-9_.\-]+\@[a-zA-Z][a-zA-Z0-9_.\-]+[a-zA-Z]{2,6})/', '<a href="mailto://$1">$1</a>', $text );
		}
		return $text;
	}
	
	function replaceBBCodeToHTML($text, $isEnebaleBBcode='', $is_nofollow='') {
		global $jacconfig;
		if($isEnebaleBBcode == ''){
			$isEnebaleBBcode = $jacconfig ["layout"]->get ( "enable_bbcode", 0 );
		}
		if ($isEnebaleBBcode) {
			require_once (JPATH_ROOT . "/components/com_jacomment/libs/dcode.php");
			if (class_exists ( 'DCODE' )) {
				$myDcode = new DCODE ( );
				//  (this is the full set)
				$myDcode->setTags ( "LARGE", "MEDIUM", "HR", "B", "I", "U", "S", "UL", "OL", "SUB", "SUP", "QUOTE", "LINK", "IMG" );
				if($is_nofollow == ''){
					$is_nofollow = $jacconfig ["spamfilters"]->get ( "is_nofollow" );
				}
				$text = $myDcode->parse ( $text,  $is_nofollow);
			}
		} else {
			$text = str_replace ( "\n", "<br />", trim ( $text ) );
		}
		return $text;
	}
	
	function sendMailWhenChangeType($userName, $userEmail, $content, $url = "", $type, $action = '') {
		global $jacconfig;
		$config = new JConfig ( );
		$app = JFactory::getApplication();		
		$tmpUrl = $app->isAdmin () ? JURI::root () : JURI::base ();		
		$url = $tmpUrl . $url;
		if ($action) {
			if ($action == "removeSpam") {
				$mail = $this->getEmailTemplate ( "Jacommentnotifying_those_whose_comment_is_removed_as_spam_by_admin" );
				if (! $mail)
					return;
				$filters = array ();
				$filters ['{USERS_USERNAME}'] = $userName;
				$filters ['{ITEM_DETAILS}'] = $content;
				$filters ['{MOD_REASONS}'] = JText::_ ( "AFTER CONSIDERATION TEXT" );
				$filters ['{SITE_ADMIN}'] = JText::_ ( "Administrator" );
				$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{ITEM_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
			}
			//send mail for admin
			if ($action == "reportspam") {
				$mail = $this->getEmailTemplate ( "Jacommentnotifying_admin_of_a_spam_report_on_a_comment" );
				if (! $mail)
					return;
				$userEmail = $jacconfig ['general']->get ( "notify_admin_email", $config->mailfrom );
				$userName = JText::_ ( "Administrator" );
				
				$filters = array ();
				$filters ['{USERS_USERNAME}'] = $userName;
				$filters ['{ITEM_DETAILS}'] = $content;
				$currentUserInfo = JFactory::getUser ();
				if ($currentUserInfo->guest) {
					$filters ['{SPAM_REPORTER}'] = JText::_ ( "Guest" );
				} else {
					$filters ['{SPAM_REPORTER}'] = $currentUserInfo->name;
				}
				
				$filters ['{SITE_ADMIN}'] = JText::_ ( "Administrator" );
				$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{ITEM_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
			}
		} else {
			if ($type == 1) {
				$mail = $this->getEmailTemplate ( "Jacommentnotifying_those_whose_comment_has_been_approved" );
				if (! $mail)
					return;
				$filters = array ();
				$filters ['{USERS_USERNAME}'] = $userName;
				$filters ['{ITEM_DETAILS}'] = $content;
				$filters ['{SITE_ADMIN}'] = JText::_ ( "Administrator" );
				$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{ITEM_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
			} else if ($type == 2) {
				$mail = $this->getEmailTemplate ( "Jacommentnotifying_those_whose_comment_is_reported_as_spam" );
				if (! $mail)
					return;
				$filters = array ();
				$filters ['{USERS_USERNAME}'] = $userName;
				$filters ['{ITEM_DETAILS}'] = $content;
				$filters ['{SPAM_REPORTER}'] = JText::_ ( "Administrator" );
				$filters ['{SITE_ADMIN}'] = JText::_ ( "Administrator" );
				$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{ITEM_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
			} else {
				$mail = $this->getEmailTemplate ( "Jacommentnotifying_those_whose_comment_has_been_unapproved" );
				if (! $mail)
					return;
				$currentUserInfo = JFactory::getUser ();
				$filters = array ();
				$filters ['{USERS_USERNAME}'] = $userName;
				$filters ['{ITEM_DETAILS}'] = $content;
				$filters ['{SITE_ADMIN}'] = $currentUserInfo->name;
				$filters ['{UNAPPROVE_REASONS}'] = JText::_ ( "Your comment is required to review" );
				$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{ITEM_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
				$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
			}
		}
		$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
	}
	
	function sendMailWhenDelete($userName, $userEmail, $content, $url = "", $userDelete) {
		global $jacconfig;
		$app = JFactory::getApplication();
		$tmpUrl = $app->isAdmin () ? JURI::root () : JURI::base ();		
		$url = $tmpUrl . $url;
		
		if ($jacconfig ["general"]->get ( "is_enabled_email", 0 ) && $mail = $this->getEmailTemplate ( "Jacommentnotifying_those_whose_comment_has_been_deleted" )) {
			//$mail = $this->getEmailTemplate ( "Jacommentnotifying_those_whose_comment_has_been_deleted" );
			
			$filters = array ();
			$filters ['{USERS_USERNAME}'] = $userName;
			$filters ['{SITE_ADMIN}'] = $userDelete;
			$filters ['{ITEM_DETAILS}'] = $content;
			$filters ['{USERS_CURRENTUSER}'] = $userDelete;
			$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
			$filters ['{ITEM_LINK}'] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
			$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
			$filters ['{MOD_REASONS}'] = JText::_ ( "because your comment has invalid contents" );
			
			$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
		}
	}
	
	function getParentCommentID($commentID, &$arrayParent) {
		$db = JFactory::getDBO ();
		$sql = "SELECT `parentid` FROM #__jacomment_items as c WHERE id = $commentID";
		$db->setQuery ( $sql );
		$child = $db->loadObjectList ();
		$parentID = $child [0]->parentid;
		if ($parentID != 0) {
			$sql = "SELECT `subscription_type`,`name`, `email` FROM #__jacomment_items as c WHERE id = $parentID";
			$db->setQuery ( $sql );
			$parent = $db->loadObjectList ();
			$arrayParent [$parentID] = array ("subscription_type" => $parent [0]->subscription_type, "name" => $parent [0]->name, "email" => $parent [0]->email );
			$this->getParentCommentID ( $parentID, $arrayParent );
		}
	}
	
	function getItemsSendMail($wherejatotalcomment) {
		$db = JFactory::getDBO ();
		
		$order = ' c.id';
		$fields = "c.id, c.name, c.email, c.subscription_type, c.date, c.parentid";
		
		$sql = "SELECT $fields " . "\n FROM #__jacomment_items as c INNER JOIN (SELECT MAX(id) AS id FROM #__jacomment_items GROUP BY email) ids ON c.id = ids.id WHERE 1=1 $wherejatotalcomment" . "\n ORDER BY $order";
		$db->setQuery ( $sql );
		return $db->loadObjectList ();
	}
	
	function sendAddNewMail($commentID, $wherejatotalcomment = '', $type = '', $post = '') {
		global $jacconfig;
		$app = JFactory::getApplication();
		$config = new JConfig ( );
		$url = JURI::root();		
		$post ["comment"] = $this->replaceBBCodeToHTML ( $post ["comment"] );
		//is_enabled_email		
		if ($jacconfig ["general"]->get ( "is_enabled_email", 0 )) {
			//send email admin
			

			if ($jacconfig ['general']->get ( "is_notify_admin", 1 ) && $mail = $this->getEmailTemplate ( "Jacommentnotifying_admin_on_a_new_comment_posted" )) {				
				
				$userEmail = $jacconfig ['general']->get ( "notify_admin_email", $config->mailfrom );
				$userName = JText::_ ( "Administrator" );
				//$userName  = $itemSendMail->name;							
				$filters ['{USERS_USERNAME}'] = $userName;
				$filters ['{ITEM_DETAILS}'] = $post ['comment'];
				$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
				$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
				
				$filters ['{ITEM_CREATE_BY}'] = $post ['name'];
				$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
				$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
			}
			
			//send email user post												
			if ($jacconfig ['general']->get ( "is_notify_author" )) {
				//dont need admin approved				
				if ($post ["type"] == 1) {
					$mail = $this->getEmailTemplate ( "Jacommentconfirmation_sent_to_new_comment_creator_dont_need_admin_approved" );
					if (! $mail)
						return;
					$userEmail = $post ['email'];
					$userName = $post ['name'];
					
					$filters ['{USERS_USERNAME}'] = $userName;
					$filters ['{ITEM_DETAILS}'] = $post ['comment'];
					$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
					$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
					
					$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
					$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
				} 

				else {
					$mail = $this->getEmailTemplate ( "Jacommentconfirmation_sent_to_new_comment_creator_need_admin_approved" );
					if (! $mail)
						return;
					$userEmail = $post ['email'];
					$userName = $post ['name'];
					
					$filters ['{USERS_USERNAME}'] = $userName;
					$filters ['{ITEM_DETAILS}'] = $post ['comment'];
					$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
					$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
					
					$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
					$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
				}
			}
			
			if ($post ["type"] == 1) {
				if ($type == "addNew") {
					if ($wherejatotalcomment) {
						//get all comment is chooise subcription is 2 								
						$itemSendMails = $this->getItemsSendMail ( $wherejatotalcomment . " AND c.subscription_type = 2 AND c.id <>" . $commentID );
					}
					
					if ($itemSendMails) {
						$mail = $this->getEmailTemplate ( "Jacommentnotifying_comment_creator_if_there_is_a_new_comment_on_the_issue" );
						if (! $mail)
							return;
						$filters = array ();
						
						$userEmail = "";
						$userName = "";
						foreach ( $itemSendMails as $itemSendMail ) {
							$userEmail = $itemSendMail->email;
							$userName = $itemSendMail->name;
							
							$filters ['{USERS_USERNAME}'] = $userName;
							$filters ['{ITEM_DETAILS}'] = $post ['comment'];
							$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
							$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
							$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
							
							$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
						}
					}
				} //type is reply comment
				else {
					$parentArray = array ();
					$this->getParentCommentID ( $commentID, $parentArray );
					//get all comment is chooise subcription is 2
					if ($wherejatotalcomment) {
						$itemSendMails = $this->getItemsSendMail ( $wherejatotalcomment . " AND c.id <>" . $commentID );
					}
					if ($itemSendMails) {
						$mail = $this->getEmailTemplate ( "Jacommentnotifying_comment_creator_if_there_is_a_new_comment_on_the_issue" );
						$mailReply = $this->getEmailTemplate ( "Jacommentnotifying_comment_creator_if_there_is_a_new_reply_to_his_comment" );
						$filters = array ();
						
						$userEmail = "";
						$userName = "";
						foreach ( $itemSendMails as $itemSendMail ) {
							//check in parent array
							if (isset ( $parentArray [$itemSendMail->id] )) {
								if ($parentArray [$itemSendMail->id] ['subscription_type'] == 1 && $mailReply) {
									$userEmail = $itemSendMail->email;
									$userName = $itemSendMail->name;
									
									$filters ['{USERS_USERNAME}'] = $userName;
									$filters ['{ITEM_DETAILS}'] = $post ['comment'];
									$filters ['{REPLY_OWNER}'] = $post ['name'];
									$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
									$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
									$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
									
									$this->sendmail ( $userEmail, $userName, $mailReply->subject, $mailReply->content, $filters );
								} else {
									if ($itemSendMail->subscription_type == 2 && $mail) {
										//echo "OK -".$itemSendMail->id." --". $itemSendMail->email. "++".$itemSendMail->subscription_type."*****\n";
										$userEmail = $itemSendMail->email;
										$userName = $itemSendMail->name;
										
										$filters ['{USERS_USERNAME}'] = $userName;
										$filters ['{ITEM_DETAILS}'] = $post ['comment'];
										$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
										$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
										$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
										
										$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
									}
								}
							} else {
								if ($itemSendMail->subscription_type == 2 && $mail) {
									//echo "OK -".$itemSendMail->id." --". $itemSendMail->email. "++".$itemSendMail->subscription_type."*****\n";
									$userEmail = $itemSendMail->email;
									$userName = $itemSendMail->name;
									
									$filters ['{USERS_USERNAME}'] = $userName;
									$filters ['{ITEM_DETAILS}'] = $post ['comment'];
									$filters ['{ITEM_TITLE_WITH_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
									$filters ['{ITEM_LINK}'] = '<a href="' . $url . $post ['referer'] . '" target="_blank">' . $url . $post ['referer'] . '</a>';
									$filters ['{CONFIG.SITE_TITLE}'] = $app->getCfg ( 'sitename' );
									
									$this->sendmail ( $userEmail, $userName, $mail->subject, $mail->content, $filters );
								}
							}
						}
					}
				}
			}
		}
	}
	
	/**
	 * This function validate one email address.
	 * $email           Email to validate.
	 * return   1 if this email is valid, 0 otherwise.
	 */
	function validate_email($email) {
		// Create the syntactical validation regular expression
		$regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
		
		// Presume that the email is invalid
		$valid = 0;
		
		// Validate the syntax
		if (eregi ( $regexp, $email )) {
			$valid = 1;
		} else {
			$valid = 0;
		}
		
		return $valid;
	
	}
	
	function checkPermissionAdmin() {
		global $jacconfig;
		$user = JFactory::getUser ();
		$permissions = isset ( $jacconfig ['permissions'] ) ? $jacconfig ['permissions'] : null;
		
		if (isset ( $jacconfig ['permissions'] )) {
			$permissions = $jacconfig ['permissions']->get ( 'permissions' );
			$permissions = explode ( ',', $permissions ); //print_r($permissions);exit;
			if (in_array ( $user->id, $permissions ) && $user->id)
				return true;
			else
				return false;
		} else {
			
			if (in_array ( $user->usertype, array ('Manager', 'Administrator', 'Super Administrator' ) )) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $URL
	 * @param unknown_type $req
	 * @return unknown
	 */
	function curl_getdata($URL, $req) {
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_URL, $URL );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $ch, CURLOPT_POST, TRUE );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $req );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		
		return $result;
	
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $host
	 * @param unknown_type $path
	 * @param unknown_type $req
	 * @return unknown
	 */
	function socket_getdata($host, $path, $req) {
		$header = "POST $path HTTP/1.0\r\n";
		$header .= "Host: " . $host . "\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "User-Agent:      Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
		$header .= "Content-Length: " . strlen ( $req ) . "\r\n\r\n";
		$header .= $req;
		$fp = @fsockopen ( $host, 80, $errno, $errstr, 60 );
		if (! $fp)
			return;
		@fwrite ( $fp, $header );
		$data = '';
		$i = 0;
		do {
			$header .= @fread ( $fp, 1 );
		} while ( ! preg_match ( '/\\r\\n\\r\\n$/', $header ) );
		
		while ( ! @feof ( $fp ) ) {
			$data .= @fgets ( $fp, 128 );
		}
		fclose ( $fp );
		return $data;
	}
	
	function get_Version_Link() {
		$link = array ();
		
		$link ['current_version'] ['info'] = 'http://wiki.joomlart.com/wiki/JA_Comment/Overview';
		$link ['current_version'] ['upgrade'] = 'http://www.joomlart.com/forums/downloads.php?do=cat&id=163';
		
		return $link;
	}
	
	function get_license_type() {
		global $jacconfig;
		
		if ($jacconfig ['license']->get ( 'type' ) == md5 ( 'professional' )) {
			return 'Professional';
		} elseif ($jacconfig ['license']->get ( 'type' ) == md5 ( 'standard' )) {
			return 'Standard';
		} else
			return 'Trial';
	}
	
	function populateDB($sqlfile, &$db, &$error) {
		$change_md_sqls = JACommentHelpers::splitSql ( $sqlfile );
		foreach ( $change_md_sqls as $query ) {
			$query = trim ( $query );
			if ($query != '') {
				$db->setQuery ( $query );
				if (! $db->query ()) {
					$error [] = " Not run " . $query;
				}
			}
		}
		return $error;
	}
	
	function splitSql($sqlfile) {
		$sql = file_get_contents ( $sqlfile );
		$sql = trim ( $sql );
		$sql = preg_replace ( "/\n\#[^\n]*/", '', "\n" . $sql );
		$buffer = array ();
		$ret = array ();
		$in_string = false;
		
		for($i = 0; $i < strlen ( $sql ) - 1; $i ++) {
			if ($sql [$i] == ";" && ! $in_string) {
				$ret [] = substr ( $sql, 0, $i );
				$sql = substr ( $sql, $i + 1 );
				$i = 0;
			}
			
			if ($in_string && ($sql [$i] == $in_string) && $buffer [1] != "\\") {
				$in_string = false;
			} elseif (! $in_string && ($sql [$i] == '"' || $sql [$i] == "'") && (! isset ( $buffer [0] ) || $buffer [0] != "\\")) {
				$in_string = $sql [$i];
			}
			if (isset ( $buffer [1] )) {
				$buffer [0] = $buffer [1];
			}
			$buffer [1] = $sql [$i];
		}
		
		if (! empty ( $sql )) {
			$ret [] = $sql;
		}
		return ($ret);
	}
	function Install_Db() {
		global $JACVERSION;
		
		$version_list = array ();
		$db = JFactory::getDBO ();
		
		$q = "SELECT data FROM #__jacomment_configs";
		$db->setQuery ( $q );
		$data = $db->loadResult ();
		
		if (! $data) {
			$path = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jacomment' . DS . 'installer' . DS . 'sql' . DS . 'install.configData.sql';
			
			$error = null;
			if (file_exists ( $path )) {
				JACommentHelpers::populateDB ( $path, $db, $error );
				if ($error) {
					$error = implode ( "<br/>", $error );
					return JError::raiseError ( 1, $error );
				}
			} else {
				JError::raiseWarning ( 1, JText::_ ( 'SQL FILE NOT FOUND ERROR' ) . '<br /><br />' );
			
			}
		}
	}
	
	// ++ added by congtq 28/10/2009
	function getCss($theme = '', $isFilePath = false) {
		$app = JFactory::getApplication();
		
		$cssUrl = ($isFilePath ? JPATH_SITE : JURI::root ()) . 'templates/' . $app->getTemplate () . '/html/com_jacomment/' . $theme . '/css/style.css';
		
		$cssPath = JPATH_SITE . DS . 'templates' . DS . $app->getTemplate () . DS . '/html/com_jacomment/' . DS . $theme . DS . 'css' . DS . 'style.css';
		if (! is_file ( $cssPath )) {
			$cssUrl = ($isFilePath ? JPATH_SITE : JURI::root ()) . 'components/com_jacomment/views/themes/' . $theme . '/css/style.css';
		}
		
		return $cssUrl;
	}
	
	function getTemplate($client_id = 0) {
		static $template;
		if (! isset ( $template )) {
			// Load the template name from the database
			$db = & JFactory::getDBO ();
			$query = 'SELECT template' . ' FROM #__template_styles' . ' WHERE client_id = ' . $client_id . '' . ' AND home = 1';
			$db->setQuery ( $query );			
			$template = $db->loadResult ();						
			$template = JFilterInput::clean ( $template, 'cmd' );
		}
		
		return $template;
	}
	
	function getListTreeStatus($type, $parentType) {
		$treeTypes = array ();
		switch ($type) {
			case 0 :
				if ($parentType == 1) {
					$treeTypes [1] = JText::_ ( "Approve" );
					$treeTypes [2] = JText::_ ( "Mark Spam" );
				}
				break;
			case 2 :
				if ($parentType == 1) {
					$treeTypes [0] = JText::_ ( "Unapprove" );
					$treeTypes [1] = JText::_ ( "Approve" );
				}
				break;
			default :
				$treeTypes [0] = JText::_ ( "Unapprove" );
				$treeTypes [2] = JText::_ ( "Mark Spam" );
		}
		return $treeTypes;
	}
	
	function builtTreeStatus($type, $itemid, $currentTabID = 0, $userName = 0, $parentType) {
		$treeTypes = array ();
		$treeTypes = $this->getListTreeStatus ( $type, $parentType );
		$output = '';
		
		$output = '<ul>';
		
		foreach ( $treeTypes as $key => $value ) {
			if ($key == 1) {
				$output .= '<li>
							<a onclick="changeTypeOfComment(' . $key . ',' . $itemid . ',' . $type . ',' . $currentTabID . ');return false;" href="#" class="approve">' . $value . '</a>																																         
					    </li>';
			} else if ($key == 2) {
				$output .= '<li>
							<a onclick="changeTypeOfComment(' . $key . ',' . $itemid . ',' . $type . ',' . $currentTabID . ');return false;" href="#" class="mark-spam">' . $value . '</a>																																         
					    </li>';
			} else {
				$output .= '<li>
							<a onclick="changeTypeOfComment(' . $key . ',' . $itemid . ',' . $type . ',' . $currentTabID . ');return false;" href="#" class="unapprove">' . $value . '</a>																																         
					    </li>';
			}
		
		}
		
		if ($userName) {
			if ($type == 1)
				$output .= '<li>
								<a href="javascript:replyComment(' . $currentTabID . ',' . $itemid . ',\'' . $userName . '\')" class="reply" title="' . JText::_ ( "Reply comment" ) . '">' . JText::_ ( " Reply " ) . '</a>																								
							</li>';
			
			$output .= '<li>
							<a href="javascript:editComment(' . $itemid . ',' . $currentTabID . ')" class="edit" title="' . JText::_ ( "Edit comment" ) . '">' . JText::_ ( " Edit " ) . '</a>																								
						</li>';
			
			$output .= '<li>
							<a href="javascript:deleteComment(' . $itemid . ',' . $currentTabID . ',' . $type . ')" class="delete" title="' . JText::_ ( "Delete comment" ) . '">' . JText::_ ( "Delete" ) . '</a>																								
						</li>';
		} else {
			if ($type == 1)
				$output .= '<li>
								<a href="javascript:replyComment(' . $itemid . ',\'' . JText::_ ( "Posting" ) . '\',\'' . JText::_ ( "Reply" ) . '\')" class="repply" title="' . JText::_ ( "Reply comment" ) . '">' . JText::_ ( " Reply " ) . '</a>																								
							</li>';
			
			$output .= '<li>
							<a href="javascript:editComment(' . $itemid . ',\'' . JText::_ ( "Reply" ) . '\')" class="edit" title="' . JText::_ ( "Edit comment" ) . '">' . JText::_ ( " Edit " ) . '</a>																								
						</li>';
			$output .= '<li>
							<a href="javascript:deleteComment(' . $itemid . ')" class="delete" title="' . JText::_ ( "Delete comment" ) . '">' . JText::_ ( "Delete" ) . '</a>																								
						</li>';
		}
		$output .= '</ul>';
		return $output;
	}
	
	function builFormChangeType($itemID, $itemType, $currentTabID = 0, $userName = 0, $parentType) {
		$output = '<span class="jac-status-title-' . $itemType . '">							
					<a onclick="jac_show_all_status(\'' . $itemID . '\', \'' . $itemType . '\'); return false;" href="#" class="jav-tag inline-edit">&nbsp;&nbsp;&nbsp;&nbsp;</a>							
				   </span>
				   <div class="statuses layer" style="display: none;">' . $this->builtTreeStatus ( $itemType, $itemID, $currentTabID, $userName, $parentType ) . '</div>';
		return $output;
	}
	
	// ++ added by congtq 28/10/2009
	

	function checkYoutubeAfterParse($url) {
		if (! preg_match ( '/.*youtube.*(v=|\/v\/)([^&\/]*).*/i', $url )) {
			return false;
		}
		return true;
	}
	// ++ added by congtq 26/11/2009 
	function checkYoutubeLink($url) {
		//http://www.youtube.com/watch?v=KwA-0_dG1H8
		//http://www.youtube.com/watch?v=KwA-0_dG1H8
		//echo $url;
		if (! preg_match ( '/(\?|&)v=([0-9a-z_-]+)(&|$)/si', $url )) {
			return false;
		}
		//	    if (!preg_match('/.*youtube.*(v=|\/v\/)([^&\/]*).*/i', $url)) {	    				
		//	    	return false;
		//		}			
		//        if(stristr($url, 'youtube.com') === FALSE) {
		//            return false;    
		//        }
		return true;
	}
	
	function repairYoutubeLink($url) {
		if (stristr ( $url, 'watch' ) === FALSE) {
			return $url;
		} else {
			//http://www.youtube.com/watch?v=KwA-0_dG1H8
			if (strpos ( $url, "watch_popup" ) === false) {
				$arr = explode ( "watch?v=", $url );
			} //http://www.youtube.com/watch_popup?v=HPmbVBfPc94
			else {
				$arr = explode ( "watch_popup?v=", $url );
			}
			if (stristr ( $url, '&' ) === FALSE) {
				$code = $arr [1];
			} else {
				$arr2 = explode ( "&", $arr [1] );
				$code = $arr2 [0];
			}
			return 'http://www.youtube.com/v/' . $code;
		}
	}
	
	function showYoutube($str, $showYoutube = true) {
		global $jacconfig;
		
		if ($this->checkYoutubeAfterParse ( $str )) {
			$pattern = "/\[youtube (.*?) youtube\]/";
			preg_match_all ( $pattern, $str, $matches );
			
			$arr0 = $matches [0];
			$arr1 = '';
			foreach ( $matches [1] as $v ) {
				if ($showYoutube) {
					//                	$arr1[] ='<p><object width="480" height="295" wmode="opaque">
					//                                <param name="movie" value="'.$this->repairYoutubeLink($v).'"></param>
					//                                <param name="allowFullScreen" value="true"></param>
					//                                <param name="allowscriptaccess" value="always"></param>
					//                                <embed src="'.$this->repairYoutubeLink($v).'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="295" wmode="opaque">
					//                                </embed>
					//                                </object></p>';
					$arr1 [] = '<p><object type="application/x-shockwave-flash" width="480" height="295"
                                data="' . $this->repairYoutubeLink ( $v ) . '">
                                <param name="movie" value="' . $this->repairYoutubeLink ( $v ) . '" />
                                <param name="wmode" value="transparent" />
                                </object></p>';
				
				} else {
					if ($jacconfig && $jacconfig ["spamfilters"]->get ( "is_nofollow" )) {
						$arr1 [] = '<a target="_blank" href="' . $this->repairYoutubeLink ( $v ) . '" rel="nofollow">' . $this->repairYoutubeLink ( $v ) . '</a>';
					} else {
						$arr1 [] = '<a target="_blank" href="' . $this->repairYoutubeLink ( $v ) . '">' . $this->repairYoutubeLink ( $v ) . '</a>';
					}
				}
			}
			
			$obj = str_replace ( $arr0, $arr1, $str );
			return $obj;
		} else {
			return $str;
		}
	
	}
	// -- added by congtq 26/11/2009 
	

	// ++ added by congtq 01/12/2009
	function showSmiley($str, $isShowSmiley='') {
		global $jacconfig;
		if($isShowSmiley == ''){
			$isShowSmiley = $jacconfig ["layout"]->get ( "enable_smileys", 0 );
		}
		if ($isShowSmiley) {
			$array = array (':)' => '0px 0px', ':D' => '-12px 0px', 'xD' => '-24px 0px', ';)' => '-36px 0px', ':p' => '-48px 0px', '^_^' => '0px -12px', ':$' => '-12px -12px', 'B)' => '-24px -12px', ':*' => '-36px -12px', '(3' => '-48px -12px', ':S' => '0px -24px', ':|' => '-12px -24px', '=/' => '-24px -24px', ':x' => '-36px -24px', 'o.0' => '-48px -24px', ':o' => '0px -36px', ':(' => '-12px -36px', ':@' => '-24px -36px', ":'(" => '-36px -36px' );
			
			$key = array_keys ( $array );
			
			foreach ( $array as $k => $v ) {
				$span [] = '<span class="smiley"><span style="background-position: ' . $v . ';"><span>' . $k . '</span></span></span>';
			
			}
			$str = str_replace ( $key, $span, $str );
		}
		return $str;
	}
	
	function showComment($str, $showYoutube = true, $isShowSmiley='') {
		$comment = $this->showYoutube ( $this->showSmiley ( $str , $isShowSmiley), $showYoutube );
		return $comment;
	}
	
	function get_Authinfo($data, $iscurl) {
		if ($iscurl) {
			$curl = curl_init ();
			curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info/?token=' . $data ['token'] . '&apiKey=' . $data ['apiKey'] . '&format=json' );
			curl_setopt ( $curl, CURLOPT_POST, true );
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
			curl_setopt ( $curl, CURLOPT_HEADER, false );
			curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false );
			$result = curl_exec ( $curl );
			curl_close ( $curl );
		} else {
			$result = file_get_contents ( "https://rpxnow.com/api/v2/auth_info/?token=" . $data ['token'] . "&apiKey=" . $data ['apiKey'] . "&format=json" );
		}
		if(function_exists("json_decode")){			
			$result = json_decode($result, true);
		}else{				
			require_once (JPATH_ROOT . "/components/com_jacomment/libs/JSON.php");
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			$result = $json->decode($result);							
		}
		return $result;
	}
	
	function showOtherField($jq, &$k, &$object) {
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#other_field';
		$object [$k]->type = 'html';
		$object [$k]->content = $jq;
		$k ++;
	}
	// -- added by congtq 01/12/2009 
	

	// ++ added by congtq 04/12/2009 
	function ja_serialize($str) {
		return base64_encode ( serialize ( $str ) );
	}
	function ja_unserialize($str) {
		return @unserialize ( base64_decode ( $str ) );
	}
	
	// -- added by congtq 04/12/2009 
	

	function displayInform($error, &$k, &$object, $timeDelay = 0) {
		if ($timeDelay)
			$message = '<script type="text/javascript" id="script_error">jacdisplaymessage("' . $timeDelay . '");</script>';
		else
			$message = '<script type="text/javascript" id="script_error">jacdisplaymessage();</script>';
		$object [$k] = new stdClass ( );
		$object [$k]->id = '#jac-msg-succesfull';
		$object [$k]->type = 'html';
		$object [$k]->content = $error . $message;
		$k ++;
	}
	
	function getAvatar($userID = 0, $ismodule = 0, $avatarSize = 0, $typeAvatar = '') {
		global $jacconfig;
		$app = JFactory::getApplication();
		
		if (!$ismodule && isset ( $jacconfig ['layout'] ) && ! $jacconfig ['layout']->get ( 'enable_avatar' )) {
			return $avatar;
		}
		
		$avatar = '';
		$src = JURI::root () . 'components/com_jacomment/asset/images/avatar-large.png';
		if(!$avatarSize){
			$avatarSize = $jacconfig ['layout']->get ( 'avatar_size', 1 );			
			
			if ($avatarSize == 1) {
				$size = "height:18px; width:18px;";
			} else if ($avatarSize == 2) {
				$size = "height:24px; width:24px;";
			} else if ($avatarSize == 3) {
				$size = "height:40px; width:40px;";
			}
		}else{
			$size = "height:{$avatarSize}px; width:{$avatarSize}px;";
		}
		
		if (! $userID)
			return array ($src, $size );
		
		$user = JFactory::getUser ( $userID );
		$params = new JRegistry;
        $params->loadJSON($user->params);
		
		if ($params->get ( 'providerName', '' ) == 'Twitter' || $params->get ( 'providerName', '' ) == 'Facebook') {
			if ($params->get ( 'photo' )) {
				$avatar = $params->get ( 'photo', '' );
			}
		}
		
		if(!$typeAvatar){
			if(isset($jacconfig ['layout']))
				$typeAvatar = $jacconfig ['layout']->get ( 'type_avatar' );
		}
		if (! $avatar) {
			switch ($typeAvatar) {
				case 1 :
					if (JACommentHelpers::checkComponent ( 'com_comprofiler' ))
						$avatar = JACommentHelpers::getAvatarCB ( $userID );
					break;
				case 2 :
					if (JACommentHelpers::checkComponent ( 'com_kunena' ))
						$avatar = JACommentHelpers::getAvatarKunena ( $userID );
					else if(JACommentHelpers::checkComponent ( 'com_fireboard' ))	
						$avatar = JACommentHelpers::getAvatarFireboard ( $userID );												
					break;
				case 4 :
					if (JACommentHelpers::checkComponent ( 'com_community' ))
						$avatar = JACommentHelpers::getAvatarJomSocial ( $userID );
					break;
				case 3 :					
						$avatar = JACommentHelpers::getAvatarGravatar ( $user->email, $avatarSize, $src, $ismodule, $avatarSize);									
					break;
			}
		}
		if (! $avatar)
			$avatar = $src;
		
		return $avatar = array ($avatar, $size );
	}
	
	function checkComponent($component) {
		$db = JFactory::getDBO ();
		$query = " SELECT Count(*) FROM #__components as c WHERE c.option ='$component' ";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function getAvatarKunena($userID){
		if (file_exists ( JPATH_SITE.DS."components".DS."com_kunena".DS."lib".DS."kunena.user.class.php" )) {
			require_once (JPATH_SITE.DS."components".DS."com_kunena".DS."lib".DS."kunena.user.class.php");
			$app =& JFactory::getApplication();
			$document =& JFactory::getDocument();
			$fbConfig =& CKunenaConfig::getInstance();
			//print_r($fbConfig);die();			
		
		
			if ($fbConfig->avatar_src == 'fb') {
				//get avatar image from database			
				$db = & JFactory::getDBO ();
				
				$sql = "SELECT `avatar` FROM #__fb_users WHERE `userid`='{$userID}'";
				
				$db->setQuery ( $sql );
				//die($db->getQuery ());
				$imgPath = $db->loadResult ();
				
				if ($imgPath) {
					$fireboardAvatar = '';
					if (@! is_null ( $fbConfig->version ) && @isset ( $fbConfig->version ) && @$fbConfig->version == '1.0.1') {
						$fireboardAvatar = 'components/com_kunena/' . $imgPath;
					} else {
						$fireboardAvatar = 'images/fbfiles/avatars/' . $imgPath;
					}
					
					//check exist image of user				
					if (file_exists ( JPATH_SITE .DS . $fireboardAvatar )) {
						return JURI::root () . $fireboardAvatar;
					} else {
						// Return false if Image file doesn't exist.
						return false;
					}
				} else {
					// user don't use avatar.
					return false;
				}
			}
		}
		return false;
	}
	
	
	function getAvatarFireboard($userID) {
		$fireConfig = JPATH_SITE . '/administrator/components/com_fireboard/fireboard_config.php';
		
		//Version is 1.0.5
		if (! file_exists ( $fireConfig )) {
			$fireConfig = JPATH_SITE . '/components/com_fireboard/sources/fb_config.class.php';
			if (file_exists ( $fireConfig )) {
				require_once ($fireConfig);
				global $fbConfig;
				
				$fireConfig = new fb_config ( );
				$fireConfig->load ();
			}
		}
		
		//check 
		if (! is_object ( $fireConfig ) && ! file_exists ( $fireConfig )) {
			return false;
		}
		
		//Version < 1.0.5
		if (! is_object ( $fireConfig )) {
			require ($fireConfig);
			$fireArray = new stdclass ( );
			global $fbConfig;
			$fireArray->avatar_src = $fbConfig ['avatar_src'];
			$fireArray->version = $fbConfig ['version'];
			$fireConfig = $fireArray;
		}
		
		if ($fireConfig->avatar_src == 'fb') {
			//get avatar image from database			
			$db = & JFactory::getDBO ();
			
			$sql = "SELECT `avatar` FROM #__fb_users WHERE `userid`='{$userID}'";
			
			$db->setQuery ( $sql );
			
			$imgPath = $db->loadResult ();
			
			if ($imgPath) {
				$fireboardAvatar = '';
				if (@! is_null ( $fireConfig->version ) && @isset ( $fireConfig->version ) && @$fireConfig->version == '1.0.1') {
					$fireboardAvatar = 'components/com_fireboard/avatars/' . $imgPath;
				} else {
					$fireboardAvatar = 'images/fbfiles/avatars/' . $imgPath;
				}
				
				//check exist image of user
				if (file_exists ( JPATH_SITE .DS. $fireboardAvatar )) {
					return JURI::root () . $fireboardAvatar;
				} else {
					// Return false if Image file doesn't exist.
					return false;
				}
			} else {
				// user don't use avatar.
				return false;
			}
		}
		return false;
	}
	
	function getAvatarGravatar($email, $avatarSize, $defaultAvatar, $ismodule, $avatarSize) {
		$imgSource = false;
		if($ismodule){
			$imgSource = 'http://www.gravatar.com/avatar.php?gravatar_id=' . md5 ( $email ) . '&amp;default=' . urlencode ( $defaultAvatar ) . '&amp;size='.$avatarSize;
		}else{
			switch ($avatarSize) {
				case 1 :
					$imgSource = 'http://www.gravatar.com/avatar.php?gravatar_id=' . md5 ( $email ) . '&amp;default=' . urlencode ( $defaultAvatar ) . '&amp;size=18';
					break;
				case 2 :
					$imgSource = 'http://www.gravatar.com/avatar.php?gravatar_id=' . md5 ( $email ) . '&amp;default=' . urlencode ( $defaultAvatar ) . '&amp;size=26';
					break;
				default :
					$imgSource = 'http://www.gravatar.com/avatar.php?gravatar_id=' . md5 ( $email ) . '&amp;default=' . urlencode ( $defaultAvatar ) . '&amp;size=42';
			}	
		}
		
		return $imgSource;
	}
	
	function getAvatarCB($userID) {
		// Load the template name from the database
		$db = & JFactory::getDBO ();
		
		$sql = "SELECT `avatar` FROM #__comprofiler WHERE `user_id`='{$userID}' AND `avatarapproved`='1'";
		
		$db->setQuery ( $sql );
		$imgName = $db->loadResult ();
		if ($imgName) {
			if (file_exists ( JPATH_SITE . '/components/com_comprofiler/images/' . $imgName )) {
				$imgPath = JURI::root () . 'components/com_comprofiler/images/' . $imgName;
				return $imgPath;
			} else if (file_exists ( JPATH_SITE . '/images/comprofiler/' . $imgName )) {
				$imgPath = JURI::root () . 'images/comprofiler/' . $imgName;
				return $imgPath;
			} else
				return false;
		} else
			return false;
	}
	
	function getAvatarJomSocial($userID) {
		$jspath = JPATH_ROOT . DS . 'components' . DS . 'com_community';
		include_once ($jspath . DS . 'libraries' . DS . 'core.php');
		include_once ($jspath . DS . 'helpers' . DS . 'url.php');
		
		// Get CUser object
		$user = & CFactory::getUser ( $userID );
		$avatar = array();
		$avatarUrl = $user->getThumbAvatar ();
		$avatarUrl = str_replace ( "/administrator/", "/", $avatarUrl );
		$avatar[] = $avatarUrl;
		$avatar[] = cUserLink($userID);
		
		return $avatar;
	}
	
	function getSizeUploadFile($action = '') {
		global $jacconfig;
		$maxSizeServer = ( int ) $this->checkUploadSize ();
		$maxSize = $jacconfig ["comments"]->get ( "max_size_attach_file", $maxSizeServer );
		$maxSizeAttach = min ( $maxSize, $maxSizeServer );
		if ($action) {
			return min ( $maxSize, $maxSizeServer ) * 1000000;
		} else {
			return min ( $maxSize, $maxSizeServer ) . "M";
		}
	}
	
	function checkUploadSize() {
		if (! $filesize = ini_get ( 'upload_max_filesize' )) {
			$filesize = "5M";
		}
		
		if ($postsize = ini_get ( 'post_max_size' )) {
			return min ( $filesize, $postsize );
		} else {
			return $filesize;
		}
	}
}

//--------------------------------------------------------------BEGIN - license -------------------------------------------
class JACommentLicense {
	//var $host = 'www4.joomlart.com';	
	//var $path = "/joomlart/member/jaeclicense.php";
	var $host = 'www.joomlart.com';
	//var $host = 'www2.dev.joomlart.com';
	var $path = "/member/jaeclicense.php";
	
	function verify_license($email = '', $payment_id='') {
		$app = JFactory::getApplication();
		$post = JRequest::get ( 'request', JREQUEST_ALLOWHTML );
		if($email == '')
			$email = isset ( $post ['email'] ) ? trim ( $post ['email'] ) : '';
		if($payment_id == '')
			$payment_id = isset ( $post ['payment_id'] ) ? trim ( $post ['payment_id'] ) : '';
		
		$domain = $_SERVER ['HTTP_HOST'];
		$base = $app->getSiteUrl ();
		
		if (! $email || ! $domain || ! $payment_id) {
			JError::raiseWarning ( 1, 'Please check your input data' );
			return;
		}
		
		if (strtolower ( substr ( $domain, 0, 3 ) ) == 'www') {
			$domain = substr ( $domain, strpos ( $domain, '.' ) + 1 );
		}
		
		$req = 'domain=' . $domain;
		$req .= '&email=' . rawurlencode ( $email );
		$req .= '&payment_id=' . rawurlencode ( $payment_id );
		$req .= '&action=verify_license';
		
		$URL = "http://{$this->host}{$this->path}";
		//die($URL."?".$req);
		if (! function_exists ( 'curl_version' )) {
			if (! ini_get ( 'allow_url_fopen' )) {
				JError::raiseWarning ( 1, JText::_ ( 'BUT YOUR SERVER DOES NOT CURRENTLY SUPPORT OPEN METHOD' ) . '.' );
				return;
			} else {				
				$result = $this->socket_getdata ( $req , $this->path, $this->host);
			}
		} else {					
			$result = $this->curl_getdata ( $URL, $req );
		}
		
		if (! $result) { //Not connected to server			
			JError::raiseWarning ( 1, JText::_ ( 'YOUR LICENSE KEY COULD NOT BE VERIFIED' . '. <a href="http://joomlart.com"> ' . JText::_ ( 'Or contact JoomlArt for further assistance' ) . '.</a>' ) );
			//$app->redirect ( 'index.php?option=com_jacomment' );
		} else {
			if(function_exists("json_decode")){			
				$result = json_decode($result, true);
			}else{				
				require_once (JPATH_ROOT . "/components/com_jacomment/libs/JSON.php");
				$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
				$result = $json->decode($result);										
			}
			$statusMes = $result["status"];			
			//die($statusMes);
			switch ($statusMes) {
				case'invalid_domain':
					{
						$this->updateFail ();
						JError::raiseWarning ( 1, JText::_ ( 'YOUR DOMAIN IS NOT ACCEPTED' ) . ' <a href="http://joomlart.com">JoomlArt</a> ' . JText::_ ( 'for further assistance' ) );
						return;
					}
					break;
				
				case 'expired':
					{
						$this->updateFail ();
						JError::raiseWarning ( 1, JText::_ ( 'Your license has expired. Therefore the system will be disabled. Please contact' ) . ' <a href="http://joomlart.com">JoomlArt</a> ' . JText::_ ( 'for further assistance' ) );
						return;
					}
					break;
				
				case 'invalid_payment_id':
					{
						$this->updateFail ();
						JError::raiseWarning ( 1, JText::_ ( 'Your payment is not corrected for this product. Please contact' ) . ' <a href="http://joomlart.com">JoomlArt</a> ' . JText::_ ( 'for further assistance' ) );
						return;
					}
					break;
				
				case 'payment_not_completed':
					{
						$this->updateFail ();
						JError::raiseWarning ( 1, JText::_ ( 'Your payment is not completed. Please contact' ) . ' <a href="http://joomlart.com">JoomlArt</a> ' . JText::_ ( 'for further assistance' ) );
						return;
					}
					break;
				
				case 'disabled_domain':
					{
						$this->updateFail ();
						JError::raiseWarning ( 1, JText::_ ( 'Your domain is disabled.' ) );
						return;
					}
					break;
				
				case 'limited_domain':
					{
						$this->updateFail ();
						JError::raiseWarning ( 1, JText::_ ( 'Limited domain.' ) );
						return;
					}
					break;
				
				case 'invalid_member':
					{
						$this->updateFail ();
						JError::raiseWarning ( 1, JText::_ ( 'Your payment is not corrected for this member. Please contact' ) . ' <a href="http://joomlart.com">JoomlArt</a> ' . JText::_ ( 'for further assistance' ) );
						return;
					}
					break;
				
				case 'successful':
					{						
						$this->updateSuccess ( $payment_id, $email , $result["product_type"]);
						$app->redirect ( 'index.php?option=com_jacomment&view=comment&layout=licenseandsupport' );
					}
					break;
				case 'error':
				default :
					{
						JError::raiseWarning ( 1, JText::_ ( 'Have an error when processing. Please try again!' ) );
						return;
					}
					break;
			}
		}
	}
	
	function updateFail() {
		$db = &JFactory::getDBO ();
		$query = "SELECT data FROM #__jacomment_configs WHERE `group`='license'";
		$db->setQuery ( $query );
		$data = $db->loadResult ();
		if (! $data) {
			$query = "INSERT INTO  #__jacomment_configs (`group`, data) VALUES ('license', 'verify_is_passed=0')";
		} else {
			$data = explode ( "\n", $data );
			$str = "";
			foreach ( $data as $item ) {
				if (strpos ( $item, "verify_is_passed" !== false )) {
					$item = "verify_is_passed=0";
				}
				$str = $item . "\n";
			}
			$db = &JFactory::getDBO ();
			$query = "UPDATE  #__jacomment_configs SET data = '" . $str . "' WHERE  group = 'license'";
			$db->setQuery ( $query );
			$db->query ();
		}
		$_SESSION ['JACOMMENT_VERIFY_PASSED'] = 0;
	}
	
	function updateSuccess($payment_id, $email, $type) {
		$db = &JFactory::getDBO ();
		$create_date = date ( 'Y-m-d H:i:s' );
		$last_verify = date ( 'Y-m-d H:i:s' );
		
		$query = "SELECT data FROM #__jacomment_configs WHERE `group`='license'";
		$db->setQuery ( $query );
		$data = $db->loadObjectList ();
		$str = "payment_id=" . $payment_id . "\nemail=" . $email . "\ncreate_date=" . $create_date . "\nlast_verify=" . $last_verify . "\nverify_is_passed=1";
	
		if (! $data) {
			
			$query = "INSERT INTO  #__jacomment_configs (`group`, data) VALUES ('license', '" . $str . "')";
			
			$db->setQuery ( $query );
			$db->query ();
		} else {
			
			$db = &JFactory::getDBO ();
			$query = "UPDATE  #__jacomment_configs SET data = '" . $str . "' WHERE `group` = 'license'";
			$db->setQuery ( $query );
			$db->query ();
		}
		
		$_SESSION ['JATOOLBAR_VERIFY_PASSED'] = 1;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $URL
	 * @param unknown_type $req
	 * @return unknown
	 */
	function curl_getdata($URL, $req) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_URL, $URL );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $ch, CURLOPT_POST, TRUE );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $req );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		
		return $result;
	
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $host
	 * @param unknown_type $path
	 * @param unknown_type $req
	 * @return unknown
	 */
	function socket_getdata($host, $path, $req) {
		$header = "POST $path HTTP/1.0\r\n";
		$header .= "Host: " . $host . "\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "User-Agent:      Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
		$header .= "Content-Length: " . strlen ( $req ) . "\r\n\r\n";
		$header .= $req;
		$fp = @fsockopen ( $host, 80, $errno, $errstr, 60 );
		if (! $fp)
			return;
		@fwrite ( $fp, $header );
		$data = '';
		$i = 0;
		do {
			$header .= @fread ( $fp, 1 );
		} while ( ! preg_match ( '/\\r\\n\\r\\n$/', $header ) );
		
		while ( ! @feof ( $fp ) ) {
			$data .= @fgets ( $fp, 128 );
		}
		fclose ( $fp );
		return $data;
	}
}
//--------------------------------------------------------------END - license -------------------------------------------


if (! class_exists ( 'JACSmartTrim' )) {
	class JACSmartTrim {
		/*
      $hiddenClasses: Class that have property display: none or invisible.
    */
		function mb_trim($strin, $pos = 0, $len = 10000, $hiddenClasses = '', $encoding = 'utf-8') {
			mb_internal_encoding ( $encoding );
			$strout = trim ( $strin );
			
			$pattern = '/(<[^>]*>)/';
			$arr = preg_split ( $pattern, $strout, - 1, PREG_SPLIT_DELIM_CAPTURE );
			$left = $pos;
			$length = $len;
			$strout = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				$arr [$i] = trim ( $arr [$i] );
				if ($arr [$i] == '')
					continue;
				if ($i % 2 == 0) {
					if ($left > 0) {
						$t = $arr [$i];
						$arr [$i] = mb_substr ( $t, $left );
						$left -= (mb_strlen ( $t ) - mb_strlen ( $arr [$i] ));
					}
					
					if ($left <= 0) {
						if ($length > 0) {
							$t = $arr [$i];
							$arr [$i] = mb_substr ( $t, 0, $length );
							$length -= mb_strlen ( $arr [$i] );
							if ($length <= 0) {
								$arr [$i] .= '...';
							}
						
						} else {
							$arr [$i] = '';
						}
					}
				} else {
					if (JACSmartTrim::isHiddenTag ( $arr [$i], $hiddenClasses )) {
						if ($endTag = JACSmartTrim::getCloseTag ( $arr, $i )) {
							while ( $i < $endTag )
								$strout .= $arr [$i ++] . "\n";
						}
					}
				}
				$strout .= $arr [$i] . "\n";
			}
			//echo $strout;  
			return JACSmartTrim::toString ( $arr, $len );
		}
		
		function trim($strin, $pos = 0, $len = 10000, $hiddenClasses = '') {
			$strout = trim ( $strin );
			
			$pattern = '/(<[^>]*>)/';
			$arr = preg_split ( $pattern, $strout, - 1, PREG_SPLIT_DELIM_CAPTURE );
			$left = $pos;
			$length = $len;
			$strout = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				$arr [$i] = trim ( $arr [$i] );
				if ($arr [$i] == '')
					continue;
				if ($i % 2 == 0) {
					if ($left > 0) {
						$t = $arr [$i];
						$arr [$i] = substr ( $t, $left );
						$left -= (strlen ( $t ) - strlen ( $arr [$i] ));
					}
					
					if ($left <= 0) {
						if ($length > 0) {
							$t = $arr [$i];
							$arr [$i] = substr ( $t, 0, $length );
							$length -= strlen ( $arr [$i] );
							if ($length <= 0) {
								$arr [$i] .= '...';
							}
						
						} else {
							$arr [$i] = '';
						}
					}
				} else {
					if (JACSmartTrim::isHiddenTag ( $arr [$i], $hiddenClasses )) {
						if ($endTag = JACSmartTrim::getCloseTag ( $arr, $i )) {
							while ( $i < $endTag )
								$strout .= $arr [$i ++] . "\n";
						}
					}
				}
				$strout .= $arr [$i] . "\n";
			}
			//echo $strout;  
			return JACSmartTrim::toString ( $arr, $len );
		}
		
		function isHiddenTag($tag, $hiddenClasses = '') {
			//By pass full tag like img
			if (substr ( $tag, - 2 ) == '/>')
				return false;
			if (in_array ( JACSmartTrim::getTag ( $tag ), array ('script', 'style' ) ))
				return true;
			if (preg_match ( '/display\s*:\s*none/', $tag ))
				return true;
			if ($hiddenClasses && preg_match ( '/class\s*=[\s"\']*(' . $hiddenClasses . ')[\s"\']*/', $tag ))
				return true;
		}
		
		function getCloseTag($arr, $openidx) {
			$tag = trim ( $arr [$openidx] );
			if (! $openTag = JACSmartTrim::getTag ( $tag ))
				return 0;
			
			$endTag = "</$openTag>";
			$endidx = $openidx + 1;
			$i = 1;
			while ( $endidx < count ( $arr ) ) {
				if (trim ( $arr [$endidx] ) == $endTag)
					$i --;
				if (JACSmartTrim::getTag ( $arr [$endidx] ) == $openTag)
					$i ++;
				if ($i == 0)
					return $endidx;
				$endidx ++;
			}
			return 0;
		}
		
		function getTag($tag) {
			if (preg_match ( '/\A<([^\/>]*)\/>\Z/', trim ( $tag ), $matches ))
				return ''; //full tag
			if (preg_match ( '/\A<([^ \/>]*)([^>]*)>\Z/', trim ( $tag ), $matches )) {
				//echo "[".strtolower($matches[1])."]";
				return strtolower ( $matches [1] );
			}
			//if (preg_match ('/<([^ \/>]*)([^\/>]*)>/', trim($tag), $matches)) return strtolower($matches[1]);
			return '';
		}
		
		function toString($arr, $len) {
			$i = 0;
			$stack = new JACStack ( );
			$length = 0;
			while ( $i < count ( $arr ) ) {
				$tag = trim ( $arr [$i ++] );
				if ($tag == '')
					continue;
				if (JACSmartTrim::isCloseTag ( $tag )) {
					if ($ltag = $stack->getLast ()) {
						if ('</' . JACSmartTrim::getTag ( $ltag ) . '>' == $tag)
							$stack->pop ();
						else
							$stack->push ( $tag );
					}
				} else if (JACSmartTrim::isOpenTag ( $tag )) {
					$stack->push ( $tag );
				} else if (JACSmartTrim::isFullTag ( $tag )) {
					//echo "[TAG: $tag, $length, $len]\n";
					if ($length < $len)
						$stack->push ( $tag );
				} else {
					$length += strlen ( $tag );
					$stack->push ( $tag );
				}
			}
			
			return $stack->toString ();
		}
		
		function isOpenTag($tag) {
			if (preg_match ( '/\A<([^\/>]+)\/>\Z/', trim ( $tag ), $matches ))
				return false; //full tag
			if (preg_match ( '/\A<([^ \/>]+)([^>]*)>\Z/', trim ( $tag ), $matches ))
				return true;
			return false;
		}
		
		function isFullTag($tag) {
			//echo "[Check full: $tag]\n";
			if (preg_match ( '/\A<([^\/>]*)\/>\Z/', trim ( $tag ), $matches ))
				return true; //full tag
			return false;
		}
		
		function isCloseTag($tag) {
			if (preg_match ( '/<\/(.*)>/', $tag ))
				return true;
			return false;
		}
	}
}

if (! class_exists ( 'JACStack' )) {
	class JACStack {
		var $_arr = null;
		function JACStack() {
			$this->_arr = array ();
		}
		
		function push($item) {
			$this->_arr [count ( $this->_arr )] = $item;
		}
		function pop() {
			if (! $c = count ( $this->_arr ))
				return null;
			$ret = $this->_arr [$c - 1];
			unset ( $this->_arr [$c - 1] );
			return $ret;
		}
		function getLast() {
			if (! $c = count ( $this->_arr ))
				return null;
			return $this->_arr [$c - 1];
		}
		function toString() {
			$output = '';
			foreach ( $this->_arr as $item ) {
				$output .= $item . "\n";
			}
			return $output;
		}
	}
}

if (! class_exists ( 'extractor' )) {
	class extractor {
		var $cookiefile;
		var $timeout;
		var $error;
		var $hdr;
		var $status;
		var $proxyaddr;
		var $proxyport;
		var $proxyuser;
		var $proxypass;
		
		function extractor($cookies = false, $timeout = 5, $sesscookiefile = "") {
			$this->timeout = $timeout;
			if ($cookies) {
				if ($mycookiefile) {
					$this->cookiefile = "cookies/" . $sesscookiefile;
					if (! is_file ( $this->cookiefile )) {
						$fp = fopen ( $this->cookiefile, "w" );
						fclose ( $fp );
					}
				} else {
					$this->cookiefile = tempnam ( "tmp", "EXT" );
				}
			}
			
			$this->cleanupOldCookies ();
		}
		
		function getdata($url, $post = array(), $referer = "", $setcookie = false, $usecookie = false, $useragent = "", $alternate_post_format = false) {
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_HEADER, true );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
			
			if ($proxyport && $proxyaddr)
				curl_setopt ( $ch, CURLOPT_PROXY, trim ( $proxyaddr ) . ":" . trim ( $proxyport ) );
			if ($proxyuser && $proxypass)
				curl_setopt ( $ch, CURLOPT_PROXYUSERPWD, trim ( $proxyuser ) . ":" . trim ( $proxypass ) );
			
			if ($setcookie)
				curl_setopt ( $ch, CURLOPT_COOKIEJAR, $this->cookiefile );
			if ($usecookie)
				curl_setopt ( $ch, CURLOPT_COOKIEFILE, $this->cookiefile );
			if ($this->timeout)
				curl_setopt ( $ch, CURLOPT_TIMEOUT, $this->timeout );
			
			if ($referer)
				curl_setopt ( $ch, CURLOPT_REFERER, trim ( $referer ) );
			else
				curl_setopt ( $ch, CURLOPT_REFERER, trim ( $url ) );
			
			if (trim ( $useragent ))
				curl_setopt ( $ch, CURLOPT_USERAGENT, $useragent );
			else
				curl_setopt ( $ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0;Windows NT 5.1)" );
			
			if (substr_count ( $url, "https://" )) {
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			}
			
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $ch, CURLOPT_URL, $url );
			
			if (count ( $post )) {
				curl_setopt ( $ch, CURLOPT_POST, true );
				
				if ($alternate_post_format) {
					foreach ( $post as $key => $val ) {
						$str .= "$key=" . urlencode ( $val ) . "&";
					}
					$str = substr ( $str, 0, - 1 );
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, $str );
				} else {
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
				}
			}
			
			$data = curl_exec ( $ch );
			$err = curl_error ( $ch );
			curl_close ( $ch );
			unset ( $ch );
			
			$theData = preg_split ( "/(\r\n){2,2}/", $data, 2 );
			$showData = $theData [1];
			
			$this->error = $err;
			$this->hdr = $theData [0];
			$this->parseHeader ( $theData [0] );
			
			return $showData;
		}
		
		function parseHeader($theHeader) {
			$theArray = preg_split ( "/(\r\n)+/", $theHeader );
			foreach ( $theArray as $theHeaderString ) {
				$theHeaderStringArray = preg_split ( "/\s*:\s*/", $theHeaderString, 2 );
				if (preg_match ( '/^HTTP/', $theHeaderStringArray [0] )) {
					$this->status = $theHeaderStringArray [0];
				}
			}
		}
		
		//--- this doesnt really belong here , but mostly when this class is used , i use this function as well , so i have placed it here
		function search($start, $end, $string, $borders = true) {
			$reg = "!" . preg_quote ( $start ) . "(.*?)" . preg_quote ( $end ) . "!is";
			preg_match_all ( $reg, $string, $matches );
			
			if ($borders)
				return $matches [0];
			else
				return $matches [1];
		}
		
		function cleanupOldCookies() {
			$delbefore = 86400; ///-- delete cookies older than 1 day
			$tmpdir = "cookies";
			
			if ($dir = @opendir ( $tmpdir )) {
				while ( ($file = readdir ( $dir )) !== false ) {
					if ($file != "." && $file != "..") {
						$stat = stat ( $tmpdir . "/" . $file );
						if ($stat [atime] < (mktime () - $delbefore)) {
							unlink ( $tmpdir . "/" . $file );
						}
					}
				}
				closedir ( $dir );
			
			}
		}
	}
}
?>