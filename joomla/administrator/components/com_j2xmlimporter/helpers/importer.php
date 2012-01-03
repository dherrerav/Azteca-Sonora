<?php
/**
 * @version		1.6.0.52 helpers/importer.php
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @since		1.6.0
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010-2011 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XMLImporter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_weblinks'.DS.'tables'.DS.'weblink.php');
//jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class j2xmlImporter
{
	private static $messages = array(
		'articleok' => 'COM_J2XMLIMPORTER_MSG_ARTICLE_IMPORTED',
		'articlenotok' => 'COM_J2XMLIMPORTER_MSG_ARTICLE_NOT_IMPORTED',	
		'userok' => 'COM_J2XMLIMPORTER_MSG_USER_IMPORTED',
		'usernotok' => 'COM_J2XMLIMPORTER_MSG_USER_NOT_IMPORTED',
		'sectionok' => 'COM_J2XMLIMPORTER_MSG_SECTION_IMPORTED',
		'sectionnotok' => 'COM_J2XMLIMPORTER_MSG_SECTION_NOT_IMPORTED',
		'categoryok' => 'COM_J2XMLIMPORTER_MSG_CATEGORY_IMPORTED',
		'categorynotok' => 'COM_J2XMLIMPORTER_MSG_CATEGORY_NOT_IMPORTED',
		'folderok' => 'COM_J2XMLIMPORTER_MSG_FOLDER_WAS_SUCCESSFULLY_CREATED',
		'foldernotok' => 'COM_J2XMLIMPORTER_MSG_ERROR_CREATING_FOLDER',
		'imageok' => 'COM_J2XMLIMPORTER_MSG_IMAGE_IMPORTED',
		'imagenotok' => 'COM_J2XMLIMPORTER_MSG_IMAGE_NOT_IMPORTED',						
		'weblinkok' => 'COM_J2XMLIMPORTER_MSG_WEBLINK_IMPORTED',
		'weblinknotok' => 'COM_J2XMLIMPORTER_MSG_WEBLINK_NOT_IMPORTED',						
		'weblinkcatnotok' => 'COM_J2XMLIMPORTER_MSG_WEBLINKCAT_NOT_PRESENT',						
		);				
	
	private static $codes = array(
		'articleok' => 0,
		'articlenotok' => 1,
		'userok' => 2,
		'usernotok' => 3,
		'sectionok' => 4,
		'sectionnotok' => 5,
		'categoryok' => 6,
		'categorynotok' => 7,
		'folderok' => 8,
		'foldernotok' => 9,
		'imageok' => 10,
		'imagenotok' => 11,
		'weblinkok' => 12,
		'weblinknotok' => 13,
		'weblinkcatnotok' => 14,
		'description' => 15,
	);	
		
	static function import($xml, $filever, $xmlrpc = false)
	{
		$msg = array();
		$db =& JFactory::getDBO();
		$nullDate = $db->getNullDate();
		$user = JFactory::getUser();
		$user_id = $user->get('id');
		$now =& JFactory::getDate()->toFormat("%Y-%m-%d-%H-%M-%S");
		$params =& JComponentHelper::getParams('com_j2xmlimporter');

		$import_content = $params->get('import_content', '2');
		$import_users = $params->get('import_users', '1');
		$import_categories = $params->get('import_categories', '1');
		$import_images = $params->get('import_images', '1');
		$import_weblinks = $params->get('import_weblinks', '1');
		
		$keep_access = $params->get('keep_access', '0');
		$keep_state = $params->get('keep_state', '2');
		$keep_author = $params->get('keep_author', '1');
		$keep_category = $params->get('keep_category', '1');
		$keep_attribs = $params->get('keep_attribs', '1');
		$keep_metadata = $params->get('keep_metadata', '1');
		$keep_frontpage = $params->get('keep_frontpage', '1');
		$keep_rating = $params->get('keep_rating', '1');
		
		$sections_id = array();
		$sections_id['com_weblinks'] = 'com_weblinks';
		
		$sections_title = array();
		$sections_title['com_weblinks'] = 'com_weblinks';
		
		$users_id = array();
		$users_id['admin'] = 42;
		$users_id[0] = 0;
		
		if ($import_users)
		{
			foreach($xml->xpath("user") as $record)
			{
				$data = array();
				foreach($record->children() as $key => $value)
					$data[trim($key)] = trim($value);
				$alias = $data['username'];
				$query = 'SELECT id, name'
					. ' FROM #__users'
					. ' WHERE username = '. $db->Quote($alias);
					;
				$db->setQuery($query);
				$user = $db->loadObject();
				if (!$user || ($import_users == 2))
				{
					$table =& JTable::getInstance('user');
					if ($import_users == 2)
					{
						$data['id'] = $user->id;
						$table->load($data['id']);
					}
					else
					{
						$data['id'] = null;
					}
					
					// Add the groups to the user data.
					if ($data['usertype'] == 'Super Administrator')
						$data['usertype'] = 'Super Users';
					$db->setQuery(
						'SELECT id, title' .
						' FROM #__usergroups' .
						' WHERE title = '.$db->Quote($data['usertype'])
						);
					$data['groups'] = $db->loadAssocList('title','id');					
					
					if (!$keep_attribs)
						$data['attribs'] = null;
					else
					{
						$attribs = new JRegistry;
						$attribs->loadString($data['params'], 'INI');
						$attribs->set('timezone', '');
						$data['params'] = $attribs->toString();
					}
					
					if ($table->save($data))
					{
						$users_id[$alias] = $table->id;
						$users_title[$alias] = $table->name;
						self::trace(true, $table->name, 'user', $msg, $xmlrpc);
					}
					else
					{
						self::trace(false, $data['name'], 'user', $msg, $xmlrpc);
						self::trace(false, $table->getError(), 'description', $msg, $xmlrpc);
					}
				}
				elseif ($user)
				{
					$users_id[$alias] = $user->id;
					$users_title[$alias] = $user->name;
				}
			}
		}

		if ($import_categories)
		{
			// import sections
			foreach($xml->xpath("section") as $record)
			{
				$data = array();
				foreach($record->children() as $key => $value)
					$data[trim($key)] = trim($value);
				$alias = $data['alias'];
				if ($filever >= 1506)
					$data['title'] = htmlspecialchars_decode($data['title']);				
				$data['description'] = htmlspecialchars_decode($data['description']);
				
				$query = 'SELECT id, title'
					. ' FROM #__categories'
					. ' WHERE extension = '. $db->Quote('com_content')
					. ' AND parent_id = 1' 
					. ' AND level = 1' 
					. ' AND alias = '. $db->Quote($alias)
					;
				$db->setQuery($query);
				$section = $db->loadObject();
				if (!$section || ($import_categories == 2))
				{
					$data['parent_id'] = 1;
					$data['checked_out'] = 0;
					$data['checked_out_time'] = $nullDate;
					
					$data['language'] = '*';

					$table =& JTable::getInstance('category');
					if (!$section) // new section
					{
						$data['id'] = null;
						if ($keep_access > 0)
							$data['access'] = $keep_access;
						else
							// J!1.6 keep the original access level (Access 1.6 = Access 1.5 +1)
							$data['access']++;
						if ($keep_state < 2)
							// Force the state
							$data['published'] = $keep_state;
						//else // keep the original state
						
						// J!1.6 set author, the section 1.5 has no author
						$data['created'] = $now;
						$data['created_by'] = $user_id; 
						$data['created_by_alias'] = null; 				
						$data['modified'] = $nullDate; 
						$data['modified_by'] = null; 
						$data['version'] = 1; 
						
						if (!$keep_attribs)
							$data['params'] = '{"category_layout":"","image":""}';
						else
						{
							$attribs = new JRegistry;
							$attribs->loadString($data['params'], 'INI');
							$data['params'] = $attribs->toString();
						} 

						$table->extension = 'com_content';
						$table->setLocation(1, 'last-child');
					}
					else // section already exists
					{
						$data['id'] = $section->id;
						$table->load($data['id']);
						
						if ($keep_access > 0)
							// don't modify the access level
							$data['access'] = null;
						else
							// keep the original access level (Access 1.6 = Access 1.5 +1)
							$data['access']++;
						
						if ($keep_state != 0)  
							// don't modify the state
							$data['published'] = null;
						//else keep the original state		

						if (!$keep_attribs)
							$data['params'] = null;
						else
						{
							$attribs = new JRegistry;
							$attribs->loadString($data['params'], 'INI');
							$data['params'] = $attribs->toString();
						} 
						
						if (!$keep_author) 
						{
							$data['created'] = null;
							$data['created_by'] = null; 
							$data['created_by_alias'] = null; 				
							$data['modified'] = $now; 
							$data['modified_by'] = $user_id; 
							$data['version'] = $table->version + 1; 
						}	
						else // save default values
						{
							$data['created'] = $now;
							$data['created_by'] = $user_id; 
							$data['created_by_alias'] = null; 				
							$data['modified'] = $nullDate; 
							$data['modified_by'] = null; 
							$data['version'] = 1; 
						}
					}
										
					if ($table->save($data))
					{
						// Rebuild the tree path.
						$table->rebuildPath();
												
						$sections_id[$alias] = $table->id;
						$sections_title[$alias] = $table->title;
						self::trace(true, $table->title, 'section', $msg, $xmlrpc);
					}
					else
					{
						self::trace(false, $data['title'], 'section', $msg, $xmlrpc);
						self::trace(false, $table->getError(), 'description', $msg, $xmlrpc);
					}
				}
				elseif ($section)
				{
					$sections_id[$alias] = $section->id;
					$sections_title[$alias] = $section->title;
				}
			}

			// import com_content categories
			foreach($xml->xpath("category[substring(sectionid,1,4)!='com_']") as $record)
			{
				$data = array();
				foreach($record->children() as $key => $value)
					$data[trim($key)] = trim($value);
				$alias = $data['alias'];
				if ($filever >= 1506)
					$data['title'] = htmlspecialchars_decode($data['title']);				
				$data['description'] = htmlspecialchars_decode($data['description']);
				$section_alias = $data['sectionid'];
				
				if (isset($sections_id[$section_alias]))
				{
					$section_id = $sections_id[$section_alias];
				}
				else
				{	
					$query = 'SELECT id'
						. ' FROM #__categories'
						. ' WHERE alias = '. $db->Quote($section_alias)
						. ' AND level = 1'
						. ' AND parent_id = 1'
						;
					$db->setQuery($query);
					$section_id = (int)$db->loadResult();
					$sections_id[$section_alias] = $section_id;
				}
				if (!$section_id)
				{
					self::trace(false, $section_alias.'/'.$data['title'], 'category', $msg, $xmlrpc);
					break;
				}
				
				$data['section'] = $section_id;
				$section_title = $sections_title[$section_alias];
				$query = 'SELECT id, title'
					. ' FROM #__categories'
					. ' WHERE extension = '. $db->Quote('com_content')
					. ' AND parent_id = '. $section_id
					. ' AND level = 2' 
					. ' AND alias = '. $db->Quote($alias);
					;
				$db->setQuery($query);
				$category = $db->loadObject();
				if (!$category || ($import_categories == 2))
				{
					$data['language'] = '*';
					
					$data['checked_out'] = 0;
					$data['checked_out_time'] = $nullDate;
					$table =& JTable::getInstance('category');

					if (!$category) // new category
					{
						$data['id'] = null;
						if ($keep_access > 0)
							$data['access'] = $keep_access;
						else
							// J!1.6 keep the original access level (Access 1.6 = Access 1.5 +1)
							$data['access']++;
						if ($keep_state < 2)
							// Force the state
							$data['published'] = $keep_state;
						//else keep the original state
						
						if (!$keep_attribs)
							$data['params'] = '{"category_layout":"","image":""}';
						else
						{
							$attribs = new JRegistry;
							$attribs->loadString($data['params'], 'INI');
							$data['params'] = $attribs->toString();
						} 
							
						// set author, the category 1.5 has no author
						$data['created'] = $now;
						$data['created_by'] = $user_id; 
						$data['created_by_alias'] = null; 				
						$data['modified'] = $nullDate; 
						$data['modified_by'] = null; 
						$data['version'] = 1; 
					
						$table->extension = 'com_content';
						$table->setLocation($data['section'], 'last-child');
					}
					else // category already exists
					{
						$data['id'] = $category->id;
						$table->load($data['id']);
						
						if ($keep_access > 0)
							// don't modify the access level
							$data['access'] = null;
						else
							// keep the original access level (Access 1.6 = Access 1.5 +1)
							$data['access']++;
						
						if ($keep_state != 0)  
							// don't modify the state
							$data['published'] = null;
						//else keep the original state		

						if (!$keep_attribs)
							$data['params'] = null;
						else
						{
							$attribs = new JRegistry;
							$attribs->loadString($data['params'], 'INI');
							$data['params'] = $attribs->toString();
						} 
							
						if (!$keep_author) 
						{
							$data['created'] = null;
							$data['created_by'] = null; 
							$data['created_by_alias'] = null; 				
							$data['modified'] = $now; 
							$data['modified_by'] = $user_id; 
							$data['version'] = $table->version + 1; 
						}	
						else // save default values
						{
							$data['created'] = $now;
							$data['created_by'] = $user_id; 
							$data['created_by_alias'] = null; 				
							$data['modified'] = $nullDate; 
							$data['modified_by'] = null; 
							$data['version'] = 1; 
						}
					}
					$data['parent_id'] = $data['section'];

					if ($table->save($data))
					{
						// Rebuild the tree path.
						$table->rebuildPath();

						$categories_id[$section_alias.'/'.$alias] = $table->id;
						$categories_title[$section_alias.'/'.$alias] = $table->title;
						self::trace(true, $section_title.'/'.$table->title, 'category', $msg, $xmlrpc);
					}
					else
					{
						self::trace(false, $section_title.'/'.$data['title'], 'category', $msg, $xmlrpc);
					}
				}
				elseif ($category)
				{
					$categories_id[$section_alias.'/'.$alias] = $category->id;
					$categories_title[$section_alias.'/'.$alias] = $category->title;
				}
			}

			if ($import_weblinks)
			{
				// import weblink categories
				foreach($xml->xpath("category[sectionid='com_weblinks']") as $record)
				{
					$data = array();
					foreach($record->children() as $key => $value)
						$data[trim($key)] = trim($value);
					$alias = $data['alias'];
					$data['description'] = htmlspecialchars_decode($data['description']);

					$query = 'SELECT id, title'
						. ' FROM #__categories'
						. ' WHERE extension = '. $db->Quote('com_weblinks')
						. ' AND parent_id = 1' 
						. ' AND level = 1' 
						. ' AND alias = '. $db->Quote($alias)
						;
					$db->setQuery($query);
					$category = $db->loadObject();
					if (!$category || ($import_categories == 2))
					{
						$table =& JTable::getInstance('category');
						if (!$category) // new category
						{
							$data['id'] = null;
							if ($keep_access > 0)
								$data['access'] = $keep_access;
							else
								// J!1.6 keep the original access level (Access 1.6 = Access 1.5 +1)
								$data['access']++;
							if ($keep_state < 2)
								// Force the state
								$data['published'] = $keep_state;
							// else //keep the original state
								
							$data['language'] = '*';
							$data['created'] = $now;
							$data['created_by'] = $user_id; 
							$data['created_by_alias'] = null; 				
							$data['modified'] = $nullDate; 
							$data['modified_by'] = null; 
							$data['version'] = 1; 
							
							if (!$keep_attribs)
								$data['params'] = '{"category_layout":"","image":""}';
							else
							{
								$attribs = new JRegistry;
								$attribs->loadString($data['params'], 'INI');
								$data['params'] = $attribs->toString();
							} 
	
							$table->extension = 'com_weblinks';
							$table->setLocation(1, 'last-child');
						}
						else // category already exists
						{
							$data['id'] = $category->id;
							$table->load($data['id']);
							
							if ($keep_access > 0)
								// don't modify the access level
								$data['access'] = null;
							else
								// keep the original access level (Access 1.6 = Access 1.5 +1)
								$data['access']++;
							
							if ($keep_state != 0)  
								// don't modify the state
								$data['published'] = null;
							//else keep the original state		
	
							if (!$keep_attribs)
								$data['params'] = null;
							else
							{
								$attribs = new JRegistry;
								$attribs->loadString($data['params'], 'INI');
								$data['params'] = $attribs->toString();
							} 
							
							if (!$keep_author) 
							{
								$data['created'] = null;
								$data['created_by'] = null; 
								$data['created_by_alias'] = null; 				
								$data['modified'] = $now; 
								$data['modified_by'] = $user_id; 
								$data['version'] = $table->version + 1; 
							}	
							else // save default values
							{
								$data['created'] = $now;
								$data['created_by'] = $user_id; 
								$data['created_by_alias'] = null; 				
								$data['modified'] = $nullDate; 
								$data['modified_by'] = null; 
								$data['version'] = 1; 
							}
						}
						if ($table->save($data))
						{
							// Rebuild the tree path.
							$table->rebuildPath();

							$categories_id['com_weblinks/'.$alias] = $table->id;
							$categories_title['com_weblinks/'.$alias] = $table->title;
							
							self::trace(true, $table->title, 'category', $msg, $xmlrpc);
						}
						else
						{
							self::trace(false, $data['title'], 'weblinkcat', $msg, $xmlrpc);
							self::trace(false, $table->getError(), 'description', $msg, $xmlrpc);
						}
					}
					elseif ($category)
					{
						$categories_id[$alias] = $category->id;
						$categories_title[$alias] = $category->title;
					}
				}
			}
		}
		
		if ($keep_frontpage)
		{
			$query = 'SELECT max(ordering)'
				. ' FROM #__content_frontpage'
				;
			$db->setQuery($query);
			$frontpage = (int)$db->loadResult();				
		}
		
		foreach($xml->xpath("content") as $record)
		{
			$attributes = $record->attributes();
			$data = array();
			foreach($record->children() as $key => $value)
				$data[trim($key)] = trim($value);
			$alias = $data['alias'];
			if ($filever >= 1506)
				$data['title'] = htmlspecialchars_decode($data['title']);				
			$data['introtext'] = htmlspecialchars_decode($data['introtext']);
			$data['fulltext'] = htmlspecialchars_decode($data['fulltext']);
			
			$query = 'SELECT id, title'
				. ' FROM #__content'
				. ' WHERE alias = '. $db->Quote($alias)
				;
			$db->setQuery($query);
			$content = $db->loadObject();
					
			if (!$content || $import_content)			
			{ 
				$data['checked_out'] = 0;
				$data['checked_out_time'] = $nullDate;

				$data['language'] = '*';
				
				$table =& JTable::getInstance('content');
				
				if (!$content)
				{ // new article
					$data['id'] = null;
					if ($keep_access > 0)
						$data['access'] = $keep_access;
					else
						// J!1.6 keep the original access level (Access 1.6 = Access 1.5 +1)
						$data['access']++;
					if ($keep_state < 2)
						// Force the state
						$data['state'] = $keep_state;
					else if ($data['state'] == -1) // J!1.5 archived = -1
						$data['state'] = 2;  	// J!1.6 archived = 2
					
					if (!$keep_attribs)
						$data['attribs'] = '{"category_layout":"","image":""}';
					else
					{
						$attribs = new JRegistry;
						$attribs->loadString($data['attribs'], 'INI');
						$data['attribs'] = $attribs->toString();
					} 
					
					if (!$keep_metadata)
					{
						$data['metadata'] = '{"author":"","robots":""}';
						$data['metakey'] = '';
						$data['metadesc'] = '';
					}
					else
					{
						$metadata = new JRegistry;
						$metadata->loadString($data['metadata'], 'INI');
						$data['metadata'] = $metadata->toString();
					} 
				}
				else // article already exists
				{
					$data['id'] = $content->id;
					$table->load($data['id']);

					if ($keep_access > 0)
						// don't modify the access level
						$data['access'] = null;
					else
						// keep the original access level (Access 1.6 = Access 1.5 +1)
						$data['access']++;
					
					if ($keep_state != 0)  
						// don't modify the state
						$data['state'] = null;
					//else keep the original state		

					if (!$keep_attribs)
						$data['attribs'] = null;
					else
					{
						$attribs = new JRegistry;
						$attribs->loadString($data['attribs'], 'INI');
						$data['attribs'] = $attribs->toString();
					} 
					
					if (!$keep_metadata)
					{
						$data['metadata'] = null;
						$data['metakey'] = null;
						$data['metadesc'] = null;
					}
					else
					{
						$metadata = new JRegistry;
						$metadata->loadString($data['metadata'], 'INI');
						$data['metadata'] = $metadata->toString();
					} 
				}
			
				// keep category
				if ($keep_category)
				{
					// keep category
					if (!isset($data['sectionid']) && !isset($data['catid']))
					{
						// uncategorised
						$data['catid'] = 2;
					}
					else if ($attributes->mapkeystotext == 'false')
					{
						// use section and category id
					}	
					else if (isset($categories_id[$data['sectionid'].'/'.$data['catid']]))
					{
						// category already loaded
						$data['catid'] = $categories_id[$data['sectionid'].'/'.$data['catid']];
						$data['sectionid'] = $sections_id[$data['sectionid']];
					}
					else if (isset($sections_id[$data['sectionid']]))
					{
						// section already loaded, load category
						$data['sectionid'] = $sections_id[$data['sectionid']];
						
						$query = 'SELECT id'
							. ' FROM #__categories'
							. ' WHERE alias = '. $db->Quote($data['catid'])
							. ' AND parent_id = '. $data['sectionid']
							. ' AND level = 2'
							;
							
						$db->setQuery($query);
						$categories_id[$data['catid']] = (int)$db->loadResult();
						$data['catid'] = $categories_id[$data['catid']];
					}
					else
					{
						// load section and category
						$query = 'SELECT id'
							. ' FROM #__categories'
							. ' WHERE alias = '. $db->Quote($data['sectionid'])
							. ' AND level = 1'
							. ' AND parent_id = 1'
							;
						$db->setQuery($query);
						$section_id = (int)$db->loadResult();
		
						if ($section_id > 0)
						{
							$sections_id[$data['sectionid']] = $section_id;
							$data['sectionid'] = $section_id;
							$query = 'SELECT id'
								. ' FROM #__categories'
								. ' WHERE alias = '. $db->Quote($data['catid'])
								. ' AND parent_id = '. $section_id
								. ' AND level = 2'
								;
							$db->setQuery($query);
							$category_id = (int)$db->loadResult();
							if ($category_id > 0)
							{
								$categories_id[$data['catid']] = $category_id;
								$data['catid'] = $category_id;
							}
							else
								$data['catid'] = 2;
						}
						else
							$data['catid'] = 2;
					}
				} 
				else if ($content)
				{
					// don't keep category and article already exists
					$data['sectionid'] = null; 
					$data['catid'] =null; 				
				}
				else
				{
					// don't keep category & article is new & Joomla!1.6
					// set uncategorised
					$data['catid'] = 2;
				}
							
				if ($keep_author)
				{
					if (isset($users_id[$data['created_by']]))
						$data['created_by'] = $users_id[$data['created_by']];
					else
					{
						$query = 'SELECT id'
							. ' FROM #__users'
							. ' WHERE username = '. $db->Quote($data['created_by'])
							;
						$db->setQuery($query);
						$userid = (int)$db->loadResult();
						if ($userid > 0)
						{
							$users_id[$data['created_by']] = $userid;
							$data['created_by'] = $userid;
						}
						else
							$data['created_by'] = $user_id;
					}
					if (isset($users_id[$data['modified_by']]))
						$data['modified_by'] = $users_id[$data['modified_by']];
					else
					{
						$query = 'SELECT id'
							. ' FROM #__users'
							. ' WHERE username = '. $db->Quote($data['modified_by'])
							;
						$db->setQuery($query);
						$userid = (int)$db->loadResult();
						if ($userid > 0)
						{
							$users_id[$data['modified_by']] = $userid;
							$data['modified_by'] = $user;
						}
						else
							$data['modified_by'] = $user_id;
					}
				}
				else if ($content)
				{
					$data['created'] = null;
					$data['created_by'] = null; 
					$data['created_by_alias'] = null; 				
					$data['modified'] = null; 
					$data['modified_by'] = null; 
					$data['version'] = null; 
				}
				else
				{
					$data['created'] = $now;
					$data['created_by'] = $user_id; 
					$data['created_by_alias'] = null; 				
					$data['modified'] = $nullDate; 
					$data['modified_by'] = null; 
					$data['version'] = 1; 
				}

				if (!$keep_frontpage)
					$data['featured'] = null;
				else if ($data['frontpage'] >= 1)
					$data['featured'] = 1;
				else
					$data['featured'] = 0;
					
				if ($table->save($data))
				{
					if ($keep_frontpage)
					{
						if ($data['featured'] == 0)
							$query = "DELETE FROM #__content_frontpage WHERE content_id = ".$table->id;
						else
						{
							$frontpage++;
							$query = 
								  ' INSERT IGNORE INTO `#__content_frontpage`'
								. ' SET content_id = '.$table->id.','
								. '     ordering = '.$frontpage;
						}
						$db->setQuery($query);
						$db->query();
					}

					if ($keep_rating)
					{
						if (isset($data['rating_count']))
							if ($data['rating_count'] > 0)
							{
								$rating = new stdClass();
								$rating->content_id = $table->id;
								$rating->rating_count = $data['rating_count'];
								$rating->rating_sum = $data['rating_sum'];
								$rating->lastip = $_SERVER['REMOTE_ADDR'];
								if (!$db->insertObject('#__content_rating', $rating))
									$db->updateObject('#__content_rating', $rating, 'content_id');
							}
							else
							{
								$query = "DELETE FROM `#__content_rating` WHERE `content_id`=".$table->id;
								$db->setQuery($query);
								$db->query();
							}
					}
					self::trace(true, $table->title, 'article', $msg, $xmlrpc);
				}
				else
				{
					self::trace(false, $data['title'], 'article', $msg, $xmlrpc);
					self::trace(false, $table->getError(), 'description', $msg, $xmlrpc);
				}
			}
		}

		if ($import_images)
		{
			foreach($xml->img as $image)
			{ 
				$src = JPATH_SITE.DS.str_replace('/', DS, $image['src']); 
				$data = $image;
				if (!file_exists($src) || ($import_images == 2))
				{
					// many thx to Stefanos Tzigiannis
					$folder = dirname($src);
					if (!JFolder::exists($folder)) {
						if (JFolder::create($folder))
							self::trace(true, $folder, 'folder', $msg, $xmlrpc);
						else
						{
							self::trace(false, $folder, 'folder', $msg, $xmlrpc);
							break;
						}
					}
 					if (JFile::write($src, base64_decode($data)))
					    self::trace(true, $image['src'], 'image', $msg, $xmlrpc);
					else
						self::trace(false, $image['src'], 'image', $msg, $xmlrpc);
				}
			}
		} 

		/*
		 * Import Weblinks
		 */
		foreach($xml->xpath("weblink") as $record)
		{
			$attributes = $record->attributes();
			$data = array();
			foreach($record->children() as $key => $value)
				$data[trim($key)] = trim($value);
			$alias = $data['alias'];
			if ($filever >= 1506)
				$data['title'] = htmlspecialchars_decode($data['title']);				
			$data['description'] = htmlspecialchars_decode($data['description']);
			
			$query = 'SELECT id, title'
				. ' FROM #__weblinks'
				. ' WHERE alias = '. $db->Quote($alias)
				;
			$db->setQuery($query);
			$weblink = $db->loadObject();
					
			if (!$weblink || $import_weblinks)			
			{ 
				$data['checked_out'] = 0;
				$data['checked_out_time'] = $nullDate;

				$table =& JTable::getInstance('weblink', 'WeblinksTable');
				
				if (!$weblink)
				{ // new weblink
					$data['id'] = null;

					$data['language'] = '*';										
					$data['created'] = $now;
					$data['created_by'] = $user_id;
					$data['created_by_alias'] = '';
					$data['modified'] = $nullDate;
					$data['modified_by'] = 0;
					$data['metakey'] = '';
					$data['metadesc'] = '';
					$data['metadata'] = '';
					$data['featured'] = 0;
					$data['xreference'] = '';
					$data['publish_up'] = $nullDate;
					$data['publish_down'] = $nullDate;
										
					if ($keep_state < 2)
						// Force the state
						$data['state'] = $keep_state;
					else //keep the original state
						$data['state'] = $data['published'];
						
					if (!$keep_attribs)
						$data['attribs'] = '{"target":"","width":"","height":"","count_clicks":""}';
				}
				else // weblink already exists
				{
					$data['id'] = $weblink->id;
					$table->load($data['id']);

					if ($keep_state == 2)
						// keep the original state  
						$data['state'] = $data['published'];
					else 		
						// don't modify the state
						$data['state'] = null;
						
					if (!$keep_attribs)
						$data['params'] = null;
					else 
					{
						$attribs = new JRegistry;
						$attribs->loadString($data['attribs'], 'INI');
						$data['attribs'] = $attribs->toString();
					}
				}
			
				if ($attributes->mapkeystotext == 'false')
				{
					// use section and category id
				}	
				else if (isset($categories_id['com_weblinks/'.$data['catid']]))
				{
					// category already loaded
					$data['catid'] = $categories_id['com_weblinks/'.$data['catid']];
				}
				else
				{
					// load category
					$query = 'SELECT id'
						. ' FROM #__categories'
						. ' WHERE alias = '. $db->Quote($data['catid'])
						. ' AND section = '. $db->Quote('com_weblinks')
						. ' AND level = 1'
						;
					$db->setQuery($query);
					$category_id = (int)$db->loadResult();
					if ($category_id > 0)
					{
						$categories_id['com_weblinks/'.$data['catid']] = $category_id;
						$data['catid'] = $category_id;
					}
					else
					{
						self::trace(false, $data['title'], 'weblinkcat', $msg, $xmlrpc);
						continue;
					}
				}
							
				$table->bind($data);
				if ($table->store())
					self::trace(true, $table->title, 'weblink', $msg, $xmlrpc);
				else
				{
					self::trace(false, $data['title'], 'weblink', $msg, $xmlrpc);
					self::trace(false, $table->getError(), 'description', $msg, $xmlrpc);
				}
			}
		}
		if ($xmlrpc === true)
			return new xmlrpcval($msg, "array");
	}	

	private static function trace($ok, $title, $type, &$msg, $xmlrpc = false)
	{
		$app =& JFactory::getApplication();

		if ($xmlrpc === true)
		{
			if ($type == 'description')
				$msg[] = new xmlrpcval(
					array(
						"code" => new xmlrpcval(self::$codes[$type], 'int'),
						"string" => new xmlrpcval($title, 'string')
					), "struct"
			  	);
			else
				$msg[] = new xmlrpcval(
					array(
						"code" => new xmlrpcval(self::$codes[$type.($ok?'ok':'notok')], 'int'),
						"string" => new xmlrpcval($title, 'string')
					), "struct"
			  	);
		}
		else
		{
			if ($type == 'description')
				$app->enqueueMessage(
					$title,($ok)?'message':'notice'
					);
			else
				$app->enqueueMessage(
					JText::sprintf(self::$messages[$type.($ok?'ok':'notok')], $title), 
					($ok)?'message':'notice'
					);
		}
	}
}
?>
