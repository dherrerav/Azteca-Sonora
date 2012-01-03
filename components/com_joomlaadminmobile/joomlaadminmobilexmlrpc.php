<?php

/**
 * @package             Joomla Admin Mobile
 * @copyright (C) 2009-2011 by Covert Apps - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

define('XMLRPC_ERR_LOGIN_FAILED', 1);
define('XMLRPC_ERR_CHECKOUT_FAILED', 2);
define('XMLRPC_ERR_CHECKIN_FAILED', 3);
define('XMLRPC_ERR_CHECK_FAILED', 4);
define('XMLRPC_ERR_STORE_FAILED', 5);
define('XMLRPC_ERR_INVALID_XML_FAILED', 6);
define('XMLRPC_ERR_UNEXPECTED_ERROR', 7);
define('XMLRPC_ERR_DATABASE_ERROR', 8);
define('XMLRPC_ERR_INVALID_FILE_TYPE', 9);
define('XMLRPC_ERR_REBUILD_PATH_FAILED', 10);
define('XMLRPC_ERR_NO_ACCESS', 11);
define('XMLRPC_ERR_ONBEFORECONTENTSAVE_FAILED', 12);
define('XMLRPC_ERR_DELETE_FAILED', 13);
define('XMLRPC_ERR_CONFIGURATION_FAILED', 14);
define('SERVICE_NAME', 'joomlaadminmobile');
define('SERVICES_CLASS_NAME', 'JoomlaAdminMobileServices');
define('KEY_FUNCTION', 'function');
define('KEY_DOCSTRING', 'docstring');
define('KEY_SIGNATURE', 'signature');
define('JAM_COMPONENT_NAME', 'com_joomlaadminmobile');

jimport('joomla.utilities.simplexml');
jimport('joomla.user.helper');

if ( !function_exists( 'property_exists' ) ) { # required for PHP < 5.1 compatibility
    function property_exists( $class, $property ) {
        if ( is_object( $class ) ) {
            $vars = get_object_vars( $class );
        } else {
            $vars = get_class_vars( $class );
        }
        return array_key_exists( $property, $vars );
    }
}

class JoomlaAdminMobileXmlRpc
{
	function JoomlaAdminMobileXmlRpc(&$subject, $config)
	{
		$this->loadLanguage('', JPATH_ADMINISTRATOR);
	}

	function onGetWebServices()
	{
		global $xmlrpcString, $xmlrpcBase64, $xmlrpcArray;

		// Initialize variables
		$services = array();

		// You have to define any function you want available to the user here.
		// The first parameter in the signature is the return value.
		$services[SERVICE_NAME.'.getVersion'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getVersion',
			KEY_DOCSTRING => 'Returns the version number for the component.',
			KEY_SIGNATURE => array(array($xmlrpcString))
			);
		$services[SERVICE_NAME.'.getVersionWithLogin'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getVersionWithLogin',
			KEY_DOCSTRING => 'Returns the version number for the component.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getArticles'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getArticles',
			KEY_DOCSTRING => 'Returns a list of articles.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getArticlesLimited'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getArticlesLimited',
			KEY_DOCSTRING => 'Returns a list of articles.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkoutArticle'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkoutArticle',
			KEY_DOCSTRING => 'Checks out the article with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkinArticle'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkinArticle',
			KEY_DOCSTRING => 'Checks in and updates the article with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getUsers'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getUsers',
			KEY_DOCSTRING => 'Returns a list of users.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getUsersLimited'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getUsersLimited',
			KEY_DOCSTRING => 'Returns a list of users.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getUser'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getUser',
			KEY_DOCSTRING => 'Returns a user with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.updateUser'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::updateUser',
			KEY_DOCSTRING => 'Updates the user with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getSections'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getSections',
			KEY_DOCSTRING => 'Returns a list of sections.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getSectionsLimited'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getSectionsLimited',
			KEY_DOCSTRING => 'Returns a list of sections.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkoutSection'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkoutSection',
			KEY_DOCSTRING => 'Checks out the section with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkinSection'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkinSection',
			KEY_DOCSTRING => 'Checks in and updates the section with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.deleteSection'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::deleteSection',
			KEY_DOCSTRING => 'Deletes the section with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getCategories'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getCategories',
			KEY_DOCSTRING => 'Returns a list of categories.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getCategoriesLimited'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getCategoriesLimited',
			KEY_DOCSTRING => 'Returns a list of categories.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getCategoriesInSection'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getCategoriesInSection',
			KEY_DOCSTRING => 'Returns a list of categories from the specified section id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getCategoriesTree'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getCategoriesTree',
			KEY_DOCSTRING => 'Returns a list of categories and related tree information.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkoutCategory'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkoutCategory',
			KEY_DOCSTRING => 'Checks out the category with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkinCategory'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkinCategory',
			KEY_DOCSTRING => 'Checks in and updates the category with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.deleteCategory'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::deleteCategory',
			KEY_DOCSTRING => 'Deletes the category with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getMenuTypes'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getMenuTypes',
			KEY_DOCSTRING => 'Returns a list of menu types.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getMenuTypesLimited'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getMenuTypesLimited',
			KEY_DOCSTRING => 'Returns a list of menu types.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getMenuType'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getMenuType',
			KEY_DOCSTRING => 'Returns a menu type with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.updateMenuType'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::updateMenuType',
			KEY_DOCSTRING => 'Updates the menu type with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.deleteMenuType'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::deleteMenuType',
			KEY_DOCSTRING => 'Deletes the menu type with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
			
		$services[SERVICE_NAME.'.getMenus'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getMenus',
			KEY_DOCSTRING => 'Returns a list of menu items.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getMenusLimited'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getMenusLimited',
			KEY_DOCSTRING => 'Returns a list of menu items.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkoutMenu'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkoutMenu',
			KEY_DOCSTRING => 'Checks out the menu with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.checkinMenu'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::checkinMenu',
			KEY_DOCSTRING => 'Checks in and updates the menu with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.deleteMenu'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::deleteMenu',
			KEY_DOCSTRING => 'Delete the menu with the given id.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getUserPrivileges'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getUserPrivileges',
			KEY_DOCSTRING => 'Returns the user access level along with privilege levels for different activities.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.uploadImage'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::uploadImage',
			KEY_DOCSTRING => 'Uploads an image to the images/stories/j-admin-mobile directory.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcBase64))
			);

		$services[SERVICE_NAME.'.getAccessLevels'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getAccessLevels',
			KEY_DOCSTRING => 'Returns the access levels defined in the Joomla! site.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.getUserGroups'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getUserGroups',
			KEY_DOCSTRING => 'Returns the user groups defined in the Joomla! site.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.accessCheck'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::accessCheck',
			KEY_DOCSTRING => 'Check if the user has access to perform the given action on the given asset.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getGlobalConfiguration'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getGlobalConfiguration',
			KEY_DOCSTRING => 'Get the available joomlaadminmobile plugins.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.updateGlobalConfiguration'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::updateGlobalConfiguration',
			KEY_DOCSTRING => 'Get the available joomlaadminmobile plugins.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString))
			);

		$services[SERVICE_NAME.'.getAvailablePlugins'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::getAvailablePlugins',
			KEY_DOCSTRING => 'Get the available joomlaadminmobile plugins.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString))
			);
		$services[SERVICE_NAME.'.callPluginMethod'] = array(
			KEY_FUNCTION => SERVICES_CLASS_NAME.'::callPluginMethod',
			KEY_DOCSTRING => 'Calls the given method on the given class and returns the data.',
			KEY_SIGNATURE => array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcArray))
			);

		return $services;
	}
}

class JoomlaAdminMobileHelper
{
	function getComponentParameter($name, $default = "")
	{
		static $params = null;

		if($params == null)
		{
			// load component params info
			$params =& JComponentHelper::getParams(JAM_COMPONENT_NAME);
		}

		return $params->get($name, $default);
	}

	function loginUserError($code)
	{
		if($code == -2)
		{
			return "User does not have permission to access JAM component";
		}
		else
		{
			return "Login Failed - Invalid username or password";
		}
	}

	function loginUser($username, $password)
	{
		$userId = -1;

		$credentials = array('username' => $username, 'password' => $password);
		$options = array('silent' => true);

		$app = JFactory::getApplication();

		// Save our guest session so we can destroy it.
		$session = JFactory::getSession();
		$guestSessionId = $session->getId();

		// Login will create a new session
		$successfulLogin = $app->login($credentials, $options);

		// Destroy guest session row.  Login forks the session and we will end up with a bunch of guest rows if we don't.
                jimport('joomla.database.table');
                $storage = & JTable::getInstance('session');
                $storage->delete($guestSessionId);

		/*
		// We used to do it this way.  Switching for better non-1.5 support.
		// We need the user to be stored in the session.  This initially started when non-1.5 didn't store the created_user_id for categories.

		// Get the global JAuthentication object
		jimport('joomla.user.authentication');
		$auth = & JAuthentication::getInstance();
		$response = $auth->authenticate($credentials, $options);

		if($response->status === JAUTHENTICATE_STATUS_SUCCESS)
		*/
		if($successfulLogin)
		{
			$userId = JUserHelper::getUserId($username);
			$user = JUser::getInstance($userId);

			$minusergroup = JoomlaAdminMobileHelper::getComponentParameter('minusergroup', 25);

			if(JoomlaAdminMobileHelper::isJoomla15() && property_exists($user, "gid"))
			{
				// Joomla! 1.5
				if($user->gid < $minusergroup)
				{
					$userId = -2;
				}
			}
			else if(!$user->authorise('core.admin') && !JAccess::check($userId, 'core.manage', JAM_COMPONENT_NAME))
			{
				// Joomla16, we are not a Super Admin and we do not have access to the component
				// Joomla! 1.6
				$userId = -2;
			}
		}

		return $userId;
	}

	function logoutUser()
	{
		$app = JFactory::getApplication();
		$app->logout();
	}

	function arrayToXmlRpcStruct($object)
	{
		global $xmlrpcString, $xmlrpcStruct;

		$structValuesArray = array();
		foreach($object AS $property => $value)
		{
			if(is_string($value)) {
				$structValuesArray[$property] = new xmlrpcval($value, $xmlrpcString);
			}
		}
		return new xmlrpcval($structValuesArray, $xmlrpcStruct);
	}

	function buildXmlrpcResponse($username, $password, $query, $multipleRows, $checkoutTable = null, $checkoutId = null, $includeCount = false)
	{
		global $xmlrpcString, $xmlrpcStruct, $xmlrpcArray;

		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		if($checkoutTable != null && $checkoutId != null)
		{
			$item = &JTable::getInstance($checkoutTable);

			if($item->load($checkoutId))
			{
				if($item->isCheckedOut($userId)) {
					JoomlaAdminMobileHelper::logoutUser();
					return new xmlrpcresp(0, XMLRPC_ERR_CHECKOUT_FAILED, JText::_("Checkout Failed"));
				}

				$item->checkout($userId);
			}
		}

		$db = &JFactory::getDBO();
		$db->setQuery($query);
		$objectList = $db->loadObjectList();

		if($db->getErrorNum() && JoomlaAdminMobileHelper::getComponentParameter("debug"))
		{
			JoomlaAdminMobileHelper::respondAndDie($db->getErrorMsg());
		}

		$structArray = array();
		if($objectList)
		{
			foreach($objectList AS $object)
			{
				array_push($structArray, JoomlaAdminMobileHelper::arrayToXmlRpcStruct($object));
			}
		}

		if($multipleRows)
		{
			if($includeCount)
			{
				// /U makes the query un-greedy.  Without it, we had a user reporting issues.
				$query = preg_replace("/SELECT .* FROM/iU", "SELECT COUNT(*) FROM", $query, 1);

				$db->setQuery($query);
				$count = $db->loadResult();

				$structValuesArray = array();
				$structValuesArray["COUNT"] = new xmlrpcval($count, $xmlrpcString);
				$structValuesArray["RESULTS"] = new xmlrpcresp(new xmlrpcval($structArray, $xmlrpcArray));
				$response = new xmlrpcresp(new xmlrpcval($structValuesArray, $xmlrpcStruct));
			}
			else
			{
				$response = new xmlrpcresp(new xmlrpcval($structArray, $xmlrpcArray));
			}
		}
		else if(count($structArray) == 0)
		{
			$response = new xmlrpcresp(new xmlrpcval(array(), $xmlrpcStruct));
		}
		else
		{
			$response = new xmlrpcresp($structArray[0]);
		}

		JoomlaAdminMobileHelper::logoutUser();
		return $response;
	}

	function buildXmlrpcDeleteResponse($username, $password, $query)
	{
		global $xmlrpcString, $xmlrpcStruct;

		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		$db = &JFactory::getDBO();		

		// Changed from execute to setQuery/query.  They removed execute post 1.5.x
		$db->setQuery($query);
		$db->query($query);

		if($db->getErrorNum())
		{
			JoomlaAdminMobileHelper::logoutUser();
			return new xmlrpcresp(0, XMLRPC_ERR_DELETE_FAILED, JText::_("Delete Failed"));
		}

		$structValuesArray = array();
		$structValuesArray["success"] = new xmlrpcval("1", $xmlrpcString);

		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcval($structValuesArray, $xmlrpcStruct);
	}

	function update($username, $password, $table, $xml)
	{
		return JoomlaAdminMobileHelper::checkin($username, $password, $table, $xml, false);
	}

	function updateFrontPage($id, $frontpageFeaturedSet)
	{
		$db = &JFactory::getDBO();

		// Taken from /administrator/components/com_content/controller.php

		/*
		* We need to update frontpage status for the article.
		*
		* First we include the frontpage table and instantiate an instance of it.
		*/
		if(JoomlaAdminMobileHelper::isJoomla15())
		{
			require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_frontpage'.DS.'tables'.DS.'frontpage.php');
			$fp = new TableFrontPage($db);
		}
		else
		{
			// cJAM 2.1.1
			require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_content'.DS.'tables'.DS.'featured.php');
			$fp = new ContentTableFeatured($db);
		}

		// Is the article viewable on the frontpage?
		if ($frontpageFeaturedSet)
		{
			// Is the item already viewable on the frontpage?
			if (!$fp->load($id))
			{
				// Insert the new entry
				$query = 'INSERT INTO #__content_frontpage' .
				' VALUES ( '. (int) $id .', 1 )';
				$db->setQuery($query);
				if (!$db->query())
				{
					return false;
				}
				$fp->ordering = 1;
			}
		}
		else
		{
			// Delete the item from frontpage if it exists
			if (!$fp->delete($id)) {
				return false;
			}
			$fp->ordering = 0;
		}
		$fp->reorder();
	}

	function checkin($username, $password, $table, $xml, $checkin = true)
	{
		global $xmlrpcString, $xmlrpcStruct;

		$success = false;
		$fieldValues = array();

		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		$item = &JTable::getInstance($table);

		// Get id and other fields from the XML
		$xmlParser = new JSimpleXML;
		if(JoomlaAdminMobileHelper::getComponentParameter("replace_escaped_chars", 0)) { $xml = joomlaadminmobile_replace_escaped_chars($xml); }
		if($xmlParser->loadString($xml))
		{
			$struct = $xmlParser->document;
			if($struct->name() != "struct")
			{
				$struct = $struct->getElementByPath("//struct");
			}

			foreach($struct->children() as $member)
			{
				$name = $member->name[0]->data();
				$value = $member->value[0]->string[0]->data();

				$fieldValues[$name] = $value;
			}

			if(key_exists('id', $fieldValues))
			{
				$id = $fieldValues['id'];

				$isNew = !$id;

				// If id is 0 or nothing, we will try to create a new item.
				if($isNew || $item->load($id))
				{
					if(!$isNew && $checkin && $item->isCheckedOut($userId)) {
						JoomlaAdminMobileHelper::logoutUser();
						return new xmlrpcresp(0, XMLRPC_ERR_CHECKIN_FAILED, JText::_("Checkin Failed"));
					}

					// Update the rest of the fields from the XML
					foreach($fieldValues as $fieldName => $fieldValue)
					{
						if(property_exists($item, $fieldName))
						{
							if ($fieldName == "password") # user password field
							{
								$salt = JUserHelper::genRandomPassword(32);
								$crypt = JUserHelper::getCryptedPassword($fieldValue, $salt);
								$item->password = $crypt.':'.$salt;
							}
				                        else if($fieldName == "modified") #update the modified date
				                        {
								//Separate into 2 lines for PHP 4.4 error
								$date = JFactory::getDate();
                                				$item->modified = $date->toMySql();
                            				}	
   							else
								$item->$fieldName = $fieldValue;
						}
					}

					// If we have a created_by field and it's not set, set it to the user that logged into the xmlrpc.
					if(property_exists($item, "created_by") && !$item->created_by)
					{
						$item->created_by = $userId;
					}

					// If id=0, it's a new item. Set the created at date
					if(property_exists($item, "created") && !$item->created)
					{
						$item->created = gmdate('Y-m-d H:i:s');
					}

					// If this is a section, make sure it's scope is set to content.
					if($table == "section")
					{
						$item->scope = "content";
					}

					if($table == "user")
					{
						$user = JUser::getInstance($userId);

						// Make sure the current user can create users
						if($isNew && !JoomlaAdminMobileHelper::checkUserAccess($user, "createuser", "create_users_gid"))
						{
							JoomlaAdminMobileHelper::logoutUser();
							return new xmlrpcresp(0, XMLRPC_ERR_NO_ACCESS, JText::_("You do not have access to create users."));
						}

						// Make sure the current user can set a user to the given level
						$pass = true;
						if(!JoomlaAdminMobileHelper::isJoomla15())
						{
							$groups = JAccess::getGroupsByUser($userId, true);
							// If gid is 0, we aren't setting the user group.  This is version 2.0.0 where 1.6 can't set groups.
							if($item->gid != 0 && !in_array($item->gid, $groups))
							{
								$pass = false;
							}
						}
						else
						{
							$currentUserGid = $user->gid;

							if($currentUserGid < $item->gid)
							{
								$pass = false;
							}
						}

						if(!$pass)
						{
							JoomlaAdminMobileHelper::logoutUser();
							return new xmlrpcresp(0, XMLRPC_ERR_NO_ACCESS, JText::_("You do not have access to update this user to the given level."));
						}

						// Make sure the user that is being modified is not above the user doing the updating.
						$pass = true;
						if(!$new)
						{
							$modifiedUser = JUser::getInstance($item->id);

							if($user->gid < $modifiedUser->gid)
							{
								$pass = false;
							}
						}

						if(!$pass)
						{
							JoomlaAdminMobileHelper::logoutUser();
							return new xmlrpcresp(0, XMLRPC_ERR_NO_ACCESS, JText::_("You do not have access to update this user because they are in a higher group than you."));
						}
					}

					$isJoomla16Category = ($table == "category" && !JoomlaAdminMobileHelper::isJoomla15());
					if($isJoomla16Category)
					{
						// Taken from /administrator/components/com_categories/models/category.php
						$item->setLocation($item->parent_id, 'last-child');
						$item->extension = 'com_content';
					}

					if(!$item->check())
					{
						JoomlaAdminMobileHelper::logoutUser();
						return new xmlrpcresp(0, XMLRPC_ERR_CHECK_FAILED, JText::_("Input Check Failed").": (".implode(", ", $item->getErrors()).")");
					}
	
					if($table == "content")
					{
						//Trigger OnBeforeContentSave
						$dispatcher = &JDispatcher::getInstance();
						if(!JoomlaAdminMobileHelper::isJoomla15())
						{
							$result = $dispatcher->trigger("onContentBeforeSave", array("com_content.article", &$item, $isNew));

							// Default language to all
							if($item->language == '')
							{
								$item->language = "*";
							}
						}
						else
						{
							$result = $dispatcher->trigger("onBeforeContentSave", array(&$item, $isNew));
						}
						if(in_array(false, $result, true)) {
							JoomlaAdminMobileHelper::logoutUser();
							return new xmlrpcresp(0, XMLRPC_ERR_ONBEFORECONTENTSAVE_FAILED, JText::_("onBeforeContentSave Failed"));
						}
					}

					if(!$item->store())
					{
						JoomlaAdminMobileHelper::logoutUser();
						return new xmlrpcresp(0, XMLRPC_ERR_STORE_FAILED, JText::_("Store Failed"));
					}
	
					if($table == "content")
					{
						//Trigger OnAfterContentSave
						$dispatcher = &JDispatcher::getInstance();
						if(!JoomlaAdminMobileHelper::isJoomla15())
						{
							$dispatcher->trigger("onContentAfterSave", array("com_content.article", &$item, $isNew));
						}
						else
						{
							$dispatcher->trigger("onAfterContentSave", array(&$item, $isNew));
						}
					}

					if(!$isNew && $checkin && !$item->checkin())
					{
						JoomlaAdminMobileHelper::logoutUser();
						return new xmlrpcresp(0, XMLRPC_ERR_CHECKIN_FAILED, JText::_("Checkin Failed"));
					}
	
					// If we have a frontpage field, this is the content table and we need to update the frontpage table.
					// cJAM 2.1.1
					if(key_exists('frontpage', $fieldValues) || key_exists('featured', $fieldValues))
					{
						if(JoomlaAdminMobileHelper::isJoomla15())
						{
							$frontpageFeaturedSet = $fieldValues['frontpage'];
						}
						else
						{
							$frontpageFeaturedSet = $fieldValues['featured'];
						}
						$id = $item->id;
						JoomlaAdminMobileHelper::updateFrontPage($id, $frontpageFeaturedSet);
					}

					if($isJoomla16Category)
					{
						// Taken from /administrator/components/com_categories/models/category.php

				                // Rebuild the path for the category:
				                if (!$item->rebuildPath($item->id)) {
							JoomlaAdminMobileHelper::logoutUser();
							return new xmlrpcresp(0, XMLRPC_ERR_REBUILD_PATH_FAILED, JText::_("Rebuild Path Failed"));
				                }

				                // Rebuild the paths of the category's children:
				                if (!$item->rebuild($item->id, $item->lft, $item->level, $item->path)) {
							JoomlaAdminMobileHelper::logoutUser();
							return new xmlrpcresp(0, XMLRPC_ERR_REBUILD_PATH_FAILED, JText::_("Rebuild Path Failed"));
				                }
					}

					$success = true;
				}
			}
		}
		else
		{
			JoomlaAdminMobileHelper::logoutUser();
			return new xmlrpcresp(0, XMLRPC_ERR_INVALID_XML_FAILED, JText::_("XML is corrupt and could not be loaded"));
		}

		$structValuesArray = array();
		$structValuesArray["success"] = new xmlrpcval("1", $xmlrpcString);

		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcval($structValuesArray, $xmlrpcStruct);
	}

	function respondAndDie($message)
	{
			$response = new xmlrpcresp(0, XMLRPC_ERR_UNEXPECTED_ERROR, $message);
			print $response->serialize();
			die;
	}

	function getJoomlaVersion()
	{
		$version = new JVersion;
		return $version->getShortVersion();
	}

	function isJoomla15()
	{
		return (substr(JoomlaAdminMobileHelper::getJoomlaVersion(), 0, 3) == '1.5');
	}

	function getJamJavascriptInclude()
	{
		$script = 
			"<script language=\"javascript\">\n".
			"var jamCallPluginMethodParamValues = new Array();\n".
			"function jamCallPluginMethod(className, methodName, displayName, dataType, paramValues) {\n".
			"	command = 'jam://' + className + '/' + methodName + '/' + displayName + '/' + dataType;\n".
			"	var i = 0;\n".
			"	for(key in paramValues) {\n".
			"		jamCallPluginMethodParamValues[i] = paramValues[key].toString();\n". // We do toString because Android wants strings
			"		command += '/jamCallPluginMethodParamValues[' + i + ']';\n".
			"		i++;\n".
			"	}\n".
			"	window.location = command;\n".
			"}\n".
			"</script>\n\n";

		return $script;
	}

	function checkUserAccess($user, $permissionName, $parameterName)
	{
		$pass = true;

		if(JoomlaAdminMobileHelper::isJoomla15())
		{
			$currentUserGid = $user->gid;
			$parameterGid = JoomlaAdminMobileHelper::getComponentParameter($parameterName, 0);

			if($currentUserGid < $parameterGid || $parameterGid == 0)
			{
				$pass = false;
			}
		}
		else if(!JAccess::check($user->id, $permissionName, JAM_COMPONENT_NAME))
		{
			$pass = false;
		}

		return $pass;
	}
}

class JoomlaAdminMobileServices
{
	function getVersion()
	{
		global $xmlrpcString, $xmlrpcStruct;
		$version = "";

		$xmlParser = new JSimpleXML;
		if($xmlParser->loadFile(JPATH_ADMINISTRATOR.DS."components".DS.JAM_COMPONENT_NAME.DS."joomlaadminmobile.xml"))
		{
			if(is_object($xmlParser->document))
			{
				$versionElement =& $xmlParser->document->version[0];
				if ($versionElement != null)
					$version = $versionElement->_data;
			}
		}

		$structValuesArray = array();
		$structValuesArray["version"] = new xmlrpcval($version, $xmlrpcString);
		$structValuesArray["joomla_version"] = new xmlrpcval(JoomlaAdminMobileHelper::getJoomlaVersion(), $xmlrpcString);
		// This is temporary until JAM 2.0.2 is out
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$structValuesArray["joomla_version"] = new xmlrpcval("1.6", $xmlrpcString);
		}
		return new xmlrpcval($structValuesArray, $xmlrpcStruct);
	}

	function getVersionWithLogin($username, $password) {
		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {	
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		JoomlaAdminMobileHelper::logoutUser();
		return JoomlaAdminMobileServices::getVersion();
	}

	function createLimitedQuery($query, $start, $limit, $where, $order)
	{
		if($where != "")
		{
			$query .= " WHERE ".$where;
		}

		if($order != "")
		{
			$query .= " ORDER BY ".$order." ";
		}

		if($start != "" && $limit != "")
		{
			$query .= " LIMIT ".$start.", ".$limit." ";
		}

		return $query;
	}

	// Articles
	function getArticles($username, $password)
	{
		return JoomlaAdminMobileServices::getArticlesLimited($username, $password, "", "", "", "");
	}

	function getArticlesLimited($username, $password, $start, $limit, $where, $order)
	{
		if($order == "")
		{
			$order = "#__content.sectionid, #__content.catid, #__content.ordering";
		}

		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$query = JoomlaAdminMobileServices::createLimitedQuery(
				"SELECT #__content.id, ".
				"	#__content.title, ".
				"	LEFT(#__content.introtext,100) introtext, ".
				"	#__content.created, ".
				"	#__content.access, ".
				"	#__content.state, ".
				"	#__categories.title category_title, ".
				"	#__users.name created_by_name ".
				"FROM #__content ".
				"LEFT JOIN #__categories ".
				"	ON #__categories.id = #__content.catid ".
				"LEFT JOIN #__users ".
				"	ON #__users.id = #__content.created_by ",
				$start, $limit, $where, $order);
		}
		else
		{
			$query = JoomlaAdminMobileServices::createLimitedQuery(
				"SELECT #__content.id, ".
				"	#__content.title, ".
				"	LEFT(#__content.introtext,100) introtext, ".
				"	#__content.created, ".
				"	#__content.access, ".
				"	#__content.state, ".
				"	#__sections.title section_title, ".
				"	#__categories.title category_title, ".
				"	#__users.name created_by_name ".
			"FROM #__content ".
				"LEFT JOIN #__sections ".
				"	ON #__sections.id = #__content.sectionid ".
				"LEFT JOIN #__categories ".
				"	ON #__categories.id = #__content.catid ".
				"LEFT JOIN #__users ".
				"	ON #__users.id = #__content.created_by ",
				$start, $limit, $where, $order);
		}

		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, true, null, null, $limit != "");
	}

	function checkoutArticle($username, $password, $id)
	{
		$db = &JFactory::getDBO();

		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$query =
				"SELECT #__content.id, ".
				"	#__content.title, ".
				"	#__content.alias, ".
				"	#__content.introtext, ".
				"	#__content.fulltext, ".
				"	#__content.state, ".
				"	#__content.ordering, ".
				"	#__content.created, ".
				"	#__content.modified, ".
				"	#__content.publish_up, ".
				"	#__content.publish_down, ".
				"	#__content.access, ".
				"	#__content.sectionid, ".
				"	#__content.catid, ".
				"	#__content.hits, ".
				"	#__content.featured, ".
				"	#__content.language, ".
				"	#__users.name created_by_name, ".
				"	CASE WHEN #__content_frontpage.content_id IS NULL THEN 0 ELSE 1 END frontpage ". // cJAM 2.1.1
				"FROM #__content ".
				"LEFT JOIN #__users ".
				"	ON #__users.id = #__content.created_by ".
				"LEFT OUTER JOIN #__content_frontpage ".
				"	ON #__content_frontpage.content_id = #__content.id ".
				"WHERE #__content.id = ".$db->quote($id);
		}
		else
		{
			$query =
				"SELECT #__content.id, ".
				"	#__content.title, ".
				"	#__content.alias, ".
				"	#__content.introtext, ".
				"	#__content.fulltext, ".
				"	#__content.state, ".
				"	#__content.ordering, ".
				"	#__content.created, ".
				"	#__content.modified, ".
				"	#__content.publish_up, ".
				"	#__content.publish_down, ".
				"	#__content.access, ".
				"	#__content.sectionid, ".
				"	#__content.catid, ".
				"	#__content.hits, ".
				"	#__content.version, ".
				"	#__users.name created_by_name, ".
				"	CASE WHEN #__content_frontpage.content_id IS NULL THEN 0 ELSE 1 END frontpage ".
				"FROM #__content ".
				"LEFT JOIN #__users ".
				"	ON #__users.id = #__content.created_by ".
				"LEFT OUTER JOIN #__content_frontpage ".
				"	ON #__content_frontpage.content_id = #__content.id ".
				"WHERE #__content.id = ".$db->quote($id);
		}

		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, false, "content", $id);
	}

	function checkinArticle($username, $password, $inputXml)
	{
		return JoomlaAdminMobileHelper::checkin($username, $password,
			"content",
			$inputXml);
	}

	// Users
	function getUsers($username, $password)
	{
		return JoomlaAdminMobileServices::getUsersLimited($username, $password, "", "", "", "");
	}

	function getUsersLimited($username, $password, $start, $limit, $where, $order)
 	{
		if($order == "")
		{
			$order = "#__users.id";
		}
		$query = JoomlaAdminMobileServices::createLimitedQuery(
			"SELECT #__users.id, ".
			"	#__users.name, ".
			"	#__users.username, ".
			"	#__users.block, ".
			"	#__users.usertype, ".
			"	#__users.email, ".
			"	#__users.lastvisitDate ".
			"FROM #__users ",
			$start, $limit, $where, $order);
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, true, null, null, $limit != "");
 	}

	function getUser($username, $password, $id)
 	{
		$db = &JFactory::getDBO();
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$query = "SELECT #__users.id, ".
				"	#__users.name, ".
				"	#__users.username, ".
				"	#__users.block, ".
				"	#__users.email, ".
				"	#__users.sendEmail, ".
				"	#__users.lastvisitDate, ".
				"	#__users.registerDate ".
				"FROM #__users ".
				"WHERE #__users.id = ".$db->quote($id);

/*
			$query = "SELECT #__user_usergroup_map.group_id "
				"FROM #__user_usergroup_map ".
				"WHERE #__user_usergroup_map.user_id = ".$db->quote($id);
*/
		}
		else
		{
			$query = "SELECT #__users.id, ".
				"	#__users.name, ".
				"	#__users.username, ".
				"	#__users.block, ".
				"	#__users.usertype, ".
				"	#__users.gid, ".
				"	#__users.email, ".
				"	#__users.sendEmail, ".
				"	#__users.lastvisitDate, ".
				"	#__users.registerDate ".
				"FROM #__users ".
				"WHERE #__users.id = ".$db->quote($id);
		}
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, false);
 	}

	function updateUser($username, $password, $inputXml)
	{
		return JoomlaAdminMobileHelper::update($username, $password,
			"user",
			$inputXml);
	}

	// Sections
	function getSections($username, $password)
	{
		return JoomlaAdminMobileServices::getSectionsLimited($username, $password, "", "", "", "");
	}

	function getSectionsLimited($username, $password, $start, $limit, $where, $order)
	{
		$newWhere = "scope='content'";
		if($where != "")
		{
			$newWhere = $newWhere." AND ";
		}
		$where = $newWhere.$where;
		if($order == "")
		{
			$order = "#__sections.ordering";
		}
		$query = JoomlaAdminMobileServices::createLimitedQuery(
			"SELECT #__sections.id, ".
				"#__sections.title, ".
				"#__sections.alias, ".
				"#__sections.description, ".
				"#__sections.published, ".
				"#__sections.ordering, ".
				"#__sections.access, ".
				"IFNULL(#__content_active.active_count, 0) activeArticleCount, ".
				"IFNULL(#__content_trash.trash_count, 0) trashArticleCount, ".
				"IFNULL(#__categories_active.active_count, 0) activeCategoriesCount ".
			"FROM #__sections ".
				"LEFT OUTER JOIN ( ".
					"SELECT #__categories.id, #__categories.section, ".
							"COUNT(*) active_count ".
						"FROM #__categories ".
								"GROUP BY #__categories.section) #__categories_active ".
					"ON #__categories_active.section = #__sections.id ".
				"LEFT OUTER JOIN ( ".
					"SELECT #__content.sectionid, ".
							"COUNT(*) active_count ".
						"FROM #__content ".
							"WHERE #__content.state <> -2 ".
								"GROUP BY #__content.sectionid) #__content_active ".
					"ON #__content_active.sectionid = #__sections.id ".
				"LEFT OUTER JOIN ( ".
					"SELECT #__content.sectionid, ".
							"COUNT(*) trash_count ".
						"FROM #__content ".
							"WHERE #__content.state = -2 ".
								"GROUP BY #__content.sectionid) #__content_trash ".
					"ON #__content_trash.sectionid = #__sections.id ",
			$start, $limit, $where, $order);
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, true, null, null, $limit != "");
	}
	
	function deleteSection($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcDeleteResponse($username, $password,
			"DELETE FROM #__sections ".
			"WHERE #__sections.id = ".$db->quote($id));
	}

	function checkoutSection($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password,
			"SELECT #__sections.id, ".
			"	#__sections.title, ".
			"	#__sections.alias, ".
			"	#__sections.description, ".
			"	#__sections.ordering, ".
			"	#__sections.published, ".
			"	#__sections.access, ".
			"	IFNULL(#__content_active.active_count, 0) activeArticleCount, ".
			"	IFNULL(#__content_trash.trash_count, 0) trashArticleCount, ".
			"	IFNULL(#__categories_active.active_count, 0) activeCategoriesCount ".
			"FROM #__sections ".
				"LEFT OUTER JOIN ( ".
					"SELECT #__categories.id, #__categories.section, ".
							"COUNT(*) active_count ".
						"FROM #__categories ".
								"GROUP BY #__categories.section) #__categories_active ".
					"ON #__categories_active.section = #__sections.id ".
				"LEFT OUTER JOIN ( ".
					"SELECT #__content.sectionid, ".
							"COUNT(*) active_count ".
						"FROM #__content ".
							"WHERE #__content.state <> -2 ".
								"GROUP BY #__content.sectionid) #__content_active ".
					"ON #__content_active.sectionid = #__sections.id ".
				"LEFT OUTER JOIN ( ".
					"SELECT #__content.sectionid, ".
							"COUNT(*) trash_count ".
						"FROM #__content ".
							"WHERE #__content.state = -2 ".
								"GROUP BY #__content.sectionid) #__content_trash ".
					"ON #__content_trash.sectionid = #__sections.id ".
			"WHERE #__sections.id = ".$db->quote($id), false);
	}

	function checkinSection($username, $password, $inputXml)
	{
		return JoomlaAdminMobileHelper::checkin($username, $password,
			"section",
			$inputXml);
	}

	// Categories
	function getCategories($username, $password)
	{
		return JoomlaAdminMobileServices::getCategoriesLimited($username, $password, "", "", "", "");
	}

	function getCategoriesLimited($username, $password, $start, $limit, $where, $order)
	{
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$newWhere = "#__categories.extension = 'com_content'";
			if($where != "")
			{
				$newWhere = $newWhere." AND ";
			}
			$where = $newWhere.$where;
			$query = JoomlaAdminMobileServices::createLimitedQuery(
				"SELECT #__categories.id, ".
					"#__categories.title, ".
					"#__categories.description, ".
					"#__categories.published, ".
					"#__categories.path, ".
					"#__categories.access, ".
					"IFNULL(#__content_active.active_count, 0) active, ".
					"IFNULL(#__content_trash.trash_count, 0) trash ".
				"FROM #__categories ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) active_count ".
							"FROM #__content ".
								"WHERE #__content.state <> -2 ".
									"GROUP BY #__content.catid) #__content_active ".
						"ON #__content_active.catid = #__categories.id ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) trash_count ".
						"FROM #__content ".
							"WHERE #__content.state = -2 ".
							"GROUP BY #__content.catid) #__content_trash ".
					"ON #__content_trash.catid = #__categories.id ",
			$start, $limit, $where, $order);
		}
		else
		{
			$newWhere = "section > 0";
			if($where != "")
			{
				$newWhere = $newWhere." AND ";
			}
			$where = $newWhere.$where;

			if($order == "")
			{
				$order = "#__categories.ordering";
			}

			$query = JoomlaAdminMobileServices::createLimitedQuery(
				"SELECT #__categories.id, ".
					"#__categories.title, ".
					"#__sections.title sectionTitle, ".
					"#__categories.description, ".
					"#__categories.published, ".
					"#__categories.ordering, ".
					"#__categories.section, ".
					"#__categories.access, ".
					"IFNULL(#__content_active.active_count, 0) active, ".
					"IFNULL(#__content_trash.trash_count, 0) trash ".
				"FROM #__categories ".
					"INNER JOIN #__sections ON #__sections.id=#__categories.section ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) active_count ".
							"FROM #__content ".
								"WHERE #__content.state <> -2 ".
									"GROUP BY #__content.catid) #__content_active ".
						"ON #__content_active.catid = #__categories.id ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) trash_count ".
						"FROM #__content ".
							"WHERE #__content.state = -2 ".
							"GROUP BY #__content.catid) #__content_trash ".
					"ON #__content_trash.catid = #__categories.id ",
			$start, $limit, $where, $order);
		}
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, true, null, null, $limit != "");
	}

	function getCategoriesInSection($username, $password, $sectionid)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password,
			"SELECT #__categories.id, ".
				"#__categories.title, ".
				"#__categories.published, ".
				"#__categories.ordering, ".
				"#__categories.access ".
			"FROM #__categories ".
				"INNER JOIN #__sections ON #__sections.id=#__categories.section ".
			"WHERE #__sections.id = ".$db->quote($sectionid).
			" ORDER BY #__categories.ordering", true);
	}

	function getCategoriesTree($username, $password)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password,
			"SELECT #__categories.id, ".
				"#__categories.title, ".
				"#__categories.parent_id ".
			"FROM #__categories ".
			"WHERE #__categories.extension = 'com_content' ".
			"ORDER BY #__categories.lft", true);
	}

	function deleteCategory($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcDeleteResponse($username, $password,
			"DELETE FROM #__categories ".
			"WHERE #__categories.id = ".$db->quote($id));
	}
	
	function checkoutCategory($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$query = "SELECT #__categories.id, ".
				"	#__categories.title, ".
				"	#__categories.alias, ".
				"	#__categories.description, ".
				"	#__categories.published, ".
				"	#__categories.access, ".
				"	#__categories.parent_id, ".
				"	IFNULL(#__content_active.active_count, 0) active, ".
				"	IFNULL(#__content_trash.trash_count, 0) trash ".
				"FROM #__categories ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) active_count ".
							"FROM #__content ".
								"WHERE #__content.state <> -2 ".
									"GROUP BY #__content.catid) #__content_active ".
						"ON #__content_active.catid = #__categories.id ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) trash_count ".
							"FROM #__content ".
								"WHERE #__content.state = -2 ".
								"GROUP BY #__content.catid) #__content_trash ".
						"ON #__content_trash.catid = #__categories.id ".
				"WHERE #__categories.id = ".$db->quote($id);
		}
		else
		{
			$query = "SELECT #__categories.id, ".
				"	#__categories.title, ".
				"	#__categories.alias, ".
				"	#__categories.section, ".
				"	#__categories.description, ".
				"	#__categories.published, ".
				"	#__categories.ordering, ".
				"	#__categories.access, ".
				"	IFNULL(#__content_active.active_count, 0) active, ".
				"	IFNULL(#__content_trash.trash_count, 0) trash ".
				"FROM #__categories ".
					"INNER JOIN #__sections ON #__sections.id=#__categories.section ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) active_count ".
							"FROM #__content ".
								"WHERE #__content.state <> -2 ".
									"GROUP BY #__content.catid) #__content_active ".
						"ON #__content_active.catid = #__categories.id ".
					"LEFT OUTER JOIN ( ".
						"SELECT #__content.catid, ".
								"COUNT(*) trash_count ".
							"FROM #__content ".
								"WHERE #__content.state = -2 ".
								"GROUP BY #__content.catid) #__content_trash ".
						"ON #__content_trash.catid = #__categories.id ".
				"WHERE #__categories.id = ".$db->quote($id);
		}
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, false);

	}

	function checkinCategory($username, $password, $inputXml)
	{
		return JoomlaAdminMobileHelper::checkin($username, $password,
			"category",
			$inputXml);
	}

	// Menu Types
	function getMenuTypes($username, $password)
	{
		return JoomlaAdminMobileServices::getMenuTypesLimited($username, $password, "", "", "", "");
	}

	function getMenuTypesLimited($username, $password, $start, $limit, $where, $order)
	{
		if($order == "")
		{
			$order = "#__menu_types.id";
		}
		$query = JoomlaAdminMobileServices::createLimitedQuery(
			"SELECT #__menu_types.id, ".
			"	#__menu_types.menutype, ".
			"	#__menu_types.title, ".
			"	#__menu_types.description ".
			"FROM #__menu_types", 
			$start, $limit, $where, $order);
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, true, null, null, $limit != "");
	}

	function getMenuType($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password,
			"SELECT #__menu_types.id, ".
			"	#__menu_types.menutype, ".
			"	#__menu_types.title, ".
			"	#__menu_types.description, ".
			"	IFNULL(#__menu_active.item_count, 0) menuItemsCount ".
			"FROM #__menu_types ".
				"LEFT OUTER JOIN ( ".
					"SELECT #__menu.id, #__menu.menutype, ".
						"COUNT(*) item_count ".
						"FROM #__menu ".
						"GROUP BY #__menu.menutype) ".
					"#__menu_active ".
					"ON #__menu_active.menutype = #__menu_types.menutype ".
			"WHERE #__menu_types.id = ".$db->quote($id), false);
	}

	function updateMenuType($username, $password, $inputXml)
	{
		return JoomlaAdminMobileHelper::update($username, $password,
			(!JoomlaAdminMobileHelper::isJoomla15() ? "menutype" : "menutypes"),
			$inputXml);
	}
	
	function deleteMenuType($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcDeleteResponse($username, $password,
			"DELETE FROM #__menu_types ".
			"WHERE #__menu_types.id = ".$db->quote($id));
	}

	// Menus
	function menuReplace($query)
	{
		return str_replace("#__menu.name", "#__menu.title", $query);
	}

	function getMenus($username, $password)
	{
		return JoomlaAdminMobileServices::getMenusLimited($username, $password, "", "", "", "#__menu.menutype, #__menu.ordering");
	}

	function getMenusLimited($username, $password, $start, $limit, $where, $order)
	{
		if($order == "")
		{
			$order = "#__menu.menutype, #__menu.ordering";
		}

		$query = JoomlaAdminMobileServices::createLimitedQuery(
			"SELECT #__menu.id, ".
			"	#__menu.menutype, ".
			"	#__menu.name, ".
			"	#__menu.type, ".
			"	#__menu.access, ".
			" #__menu.published ".											
			"FROM #__menu ",
			$start, $limit, $where, $order);
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$query = JoomlaAdminMobileServices::menuReplace($query);
		}
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, true, null, null, $limit != "");
	}

	function checkoutMenu($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		$query = "SELECT #__menu.id, ".
			"	#__menu.menutype, ".
			"	#__menu.name, ".
			"	#__menu.alias, ".
			"	#__menu.link, ".
			"	#__menu.published, ".
			"	#__menu.access, ".
			"	#__menu.browserNav, ".
			"	#__menu.ordering ".
			"FROM #__menu ".
			"WHERE #__menu.id = ".$db->quote($id);
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$query = JoomlaAdminMobileServices::menuReplace($query);
		}
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, false);
	}
	
	function deleteMenu($username, $password, $id)
	{
		$db = &JFactory::getDBO();
		return JoomlaAdminMobileHelper::buildXmlrpcDeleteResponse($username, $password,
			"DELETE FROM #__menu ".
			"WHERE #__menu.id = ".$db->quote($id));
	}

	function checkinMenu($username, $password, $inputXml)
	{
		return JoomlaAdminMobileHelper::checkin($username, $password,
			"menu",
			$inputXml);
	}

	// Used for 1.5 and JAM < 2.0.0
	function getUserPrivileges($username, $password)
	{
		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		global $xmlrpcString, $xmlrpcStruct;
		$user = JUser::getInstance($userId);

		$response = array();
		$response['currentUserGid'] = new xmlrpcval($user->gid, $xmlrpcString);
		$response['createUserGid'] = new xmlrpcval(JoomlaAdminMobileHelper::getComponentParameter('create_users_gid', 0), $xmlrpcString);

		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcresp(new xmlrpcval($response, $xmlrpcStruct));
	}

	function uploadImage($username, $password, $filename, $filecontents)
	{
		global $xmlrpcString, $xmlrpcStruct;
		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		// Make sure we only allow jpg and png files to be uploaded.
		$extension = strtolower(substr($filename, -4));
		if($extension != ".jpg" && $extension != ".png")
		{
			JoomlaAdminMobileHelper::logoutUser();
			return new xmlrpcresp(0, XMLRPC_ERR_INVALID_FILE_TYPE, JText::_("Invalid File Type"));
		}

		jimport('joomla.filesystem.file');
		$imagePath = JPATH_SITE.DS.'images'.DS.'stories'.DS.'j-admin-mobile';
		$return = JFile::write($imagePath.DS.$filename, $filecontents);

		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcresp(new xmlrpcval($return, $xmlrpcString));
	}

	function getAccessLevels($username, $password)
	{
		$db = &JFactory::getDBO();
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password,
				"SELECT #__viewlevels.id, ".
				"	#__viewlevels.title ".
				"FROM #__viewlevels ".
				"ORDER BY #__viewlevels.ordering", true);
		}
		else
		{
			return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password,
				"SELECT #__groups.id, ".
				"	#__groups.name title ".
				"FROM #__groups", true);
		}
	}

	function getUserGroups($username, $password)
	{
		$db = &JFactory::getDBO();
		if(!JoomlaAdminMobileHelper::isJoomla15())
		{
			$query = "SELECT #__usergroups.id, ".
				"	#__usergroups.parent_id, ".
				"	#__usergroups.title ".
				"FROM #__usergroups ".
				"ORDER BY #__usergroups.lft";
		}
		else
		{
			$query = "SELECT #__core_acl_aro_groups.id, ".
				"	#__core_acl_aro_groups.parent_id, ".
				"	#__core_acl_aro_groups.name title ".
				"FROM #__core_acl_aro_groups ".
				"WHERE #__core_acl_aro_groups.name not in ('ROOT', 'USERS', 'Public Frontend', 'Public Backend') ".
				"ORDER BY #__core_acl_aro_groups.lft";
		}
		return JoomlaAdminMobileHelper::buildXmlrpcResponse($username, $password, $query, true);
	}

	function accessCheck($username, $password, $action, $asset)
	{
		global $xmlrpcString, $xmlrpcStruct;

		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		$accessCheck = JAccess::check($userId, $action, $asset);

		$response = array();
		$response['accessCheck'] = new xmlrpcval($accessCheck, $xmlrpcString);

		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcresp(new xmlrpcval($response, $xmlrpcStruct));
	}

	function getGlobalConfiguration($username, $password)
	{
		global $xmlrpcStruct;

		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		$user = JUser::getInstance($userId);
		if(!JoomlaAdminMobileHelper::checkUserAccess($user, "globalconfiguration", "global_configuration_gid")) {
			JoomlaAdminMobileHelper::logoutUser();
			return new xmlrpcresp(0, XMLRPC_ERR_NO_ACCESS, JText::_("You do not have access to global configuration."));
		}

		$config = new JConfig();
		$response = JoomlaAdminMobileHelper::arrayToXmlRpcStruct($config);
	
		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcresp($response);
	}

        function updateGlobalConfiguration($username, $password, $inputXml)
        {
                global $xmlrpcString, $xmlrpcStruct;

                if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
                        return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
                }

		$user = JUser::getInstance($userId);
		if(!JoomlaAdminMobileHelper::checkUserAccess($user, "globalconfiguration", "global_configuration_gid")) {
			JoomlaAdminMobileHelper::logoutUser();
			return new xmlrpcresp(0, XMLRPC_ERR_NO_ACCESS, JText::_("You do not have access to global configuration."));
		}

		// Load up XML and get field name/value pairs
		$fieldValues = array();
                $xmlParser = new JSimpleXML;
		if(JoomlaAdminMobileHelper::getComponentParameter("replace_escaped_chars", 0)) { $inputXml = joomlaadminmobile_replace_escaped_chars($inputXml); }
                if($xmlParser->loadString($inputXml))
                {
                        $struct = $xmlParser->document;
                        if($struct->name() != "struct")
                        {
                                $struct = $struct->getElementByPath("//struct");
                        }

                        foreach($struct->children() as $member)
                        {
                                $name = $member->name[0]->data();
                                $value = $member->value[0]->string[0]->data();

                                $fieldValues[$name] = $value;
                        }

			$updateKeys = array(
				"offline",
				"offline_message",
				"sitename",
				"MetaDesc",
				"MetaKeys",
				"debug",
				"debug_lang",
			);

			// 1.5.x .../administrator/components/com_config/controllers/application.php
			// 1.7.x .../administrator/components/com_config/models/application.php

			// Set FTP credentials, if given
			jimport('joomla.client.helper');
			JClientHelper::setCredentialsFromRequest('ftp');
			$ftp = JClientHelper::getCredentials('ftp');

			// handling of special characters
			if(array_key_exists("sitename", $fieldValues)) $fieldValues["sitename"] = htmlspecialchars($fieldValues["sitename"], ENT_COMPAT, 'UTF-8');
			if(array_key_exists("MetaDesc", $fieldValues)) $fieldValues["MetaDesc"] = htmlspecialchars($fieldValues["MetaDesc"], ENT_COMPAT, 'UTF-8');
			if(array_key_exists("MetaKeys", $fieldValues)) $fieldValues["MetaKeys"] = htmlspecialchars($fieldValues["MetaKeys"], ENT_COMPAT, 'UTF-8');

			// handling of quotes (double and single) and amp characters
			// htmlspecialchars not used to preserve ability to insert other html characters
			if(array_key_exists("offline_message", $fieldValues)) 
			{
				$offline_message = $fieldValues["offline_message"];
				$offline_message = JFilterOutput::ampReplace( $offline_message );
				$offline_message = str_replace( '"', '&quot;', $offline_message );
				$offline_message = str_replace( "'", '&#039;', $offline_message );
				$fieldValues["offline_message"] = $offline_message;
			}

			// Get the path of the configuration file
			$fname = JPATH_CONFIGURATION.DS.'configuration.php';

			// Update the credentials with the new settings
			$prev = new JConfig();
			$prev = JArrayHelper::fromObject($prev);

			// Merge the new data in. We do this to preserve values that were not in the form.
			$data = array_merge($prev, $fieldValues);

			// Create the new configuration object.
			$config = new JRegistry('config');
			$config->loadArray($data);

			// Try to make configuration.php writeable
			jimport('joomla.filesystem.path');
			if (!$ftp['enabled'] && JPath::isOwner($fname) && !JPath::setPermissions($fname, '0644')) {
				JoomlaAdminMobileHelper::logoutUser();
				return new xmlrpcresp(0, XMLRPC_ERR_CONFIGURATION_FAILED, JText::_("Could not make configuration.php writable"));
			}

			// Get the config registry in PHP class format and write it to configuation.php
			jimport('joomla.filesystem.file');
			if(JoomlaAdminMobileHelper::isJoomla15())
			{
				$configString = $config->toString('PHP', 'config', array('class' => 'JConfig'));
			}
			else
			{
				$configString = $config->toString('PHP', array('class' => 'JConfig', 'closingtag' => false));
			}
			if (!JFile::write($fname, $configString)) {
				JoomlaAdminMobileHelper::logoutUser();
				return new xmlrpcresp(0, XMLRPC_ERR_CONFIGURATION_FAILED, JText::_("Could not save configuration.php file"));
			}

			// Try to make configuration.php unwriteable
			if (!$ftp['enabled'] && JPath::isOwner($fname) && !JPath::setPermissions($fname, '0444')) {
				JoomlaAdminMobileHelper::logoutUser();
				return new xmlrpcresp(0, XMLRPC_ERR_CONFIGURATION_FAILED, JText::_("Could not make configuration.php unwritable"));
			}

			// Return success
			$structValuesArray = array();
			$structValuesArray["success"] = new xmlrpcval("1", $xmlrpcString);

			JoomlaAdminMobileHelper::logoutUser();
	                return new xmlrpcval($structValuesArray, $xmlrpcStruct);
		}
		else
		{
			JoomlaAdminMobileHelper::logoutUser();
			return new xmlrpcresp(0, XMLRPC_ERR_INVALID_XML_FAILED, JText::_("XML is corrupt and could not be loaded"));
		}
        }


	function trigger($event)
	{
		$dispatcher = &JDispatcher::getInstance();
		JPluginHelper::importPlugin('joomlaadminmobile');
		return $dispatcher->trigger($event);
	}

	function getAvailablePlugins($username, $password)
	{
		global $xmlrpcArray;

		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		$plugins = JoomlaAdminMobileServices::trigger("onGetAvailablePlugins");

		$structArray = array();
		foreach($plugins as $plugin)
		{
			array_push($structArray, JoomlaAdminMobileHelper::arrayToXmlRpcStruct($plugin));
		}
	
		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcresp(new xmlrpcval($structArray, $xmlrpcArray));
	}

	function callPluginMethod($username, $password, $className, $methodName, $paramValues)
	{
		global $xmlrpcString, $xmlrpcStruct;

		if(($userId = JoomlaAdminMobileHelper::loginUser($username, $password)) <= 0) {
			return new xmlrpcresp(0, XMLRPC_ERR_LOGIN_FAILED, JText::_(JoomlaAdminMobileHelper::loginUserError($userId)));
		}

		JPluginHelper::importPlugin('joomlaadminmobile');
		$class = $className;
		if(method_exists($className, "getInstance")) {
			$class = call_user_func(array($className, "getInstance"));
		}
		$data = call_user_func_array(array($class, $methodName), $paramValues);

		$response = array();
		$response['data'] = new xmlrpcval($data, $xmlrpcString);

		JoomlaAdminMobileHelper::logoutUser();
		return new xmlrpcresp(new xmlrpcval($response, $xmlrpcStruct));
	}
}

