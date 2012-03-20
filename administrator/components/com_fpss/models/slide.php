<?php
/**
 * @version		$Id: slide.php 534 2011-07-20 10:17:15Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class FPSSModelSlide extends JModel {

	function getData() {
		$row = &JTable::getInstance('slide', 'FPSS');
		$row->load($this->getState('id'));
		return $row;
	}

	function save() {
		$db = &$this->getDBO();
		$row = & JTable::getInstance('slide', 'FPSS');
		$config = &JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$data = $this->getState('data');
		if (!$row->bind($data)) {
			$this->setError($row->getError());
			return false;
		}
		if (!$row->check()) {
			$this->setError($row->getError());
			return false;
		}

		$date =& JFactory::getDate($row->publish_up, $tzoffset);
		$row->publish_up = $date->toMySQL();
		if (trim($row->publish_down) == JText::_('FPSS_NEVER') || trim( $row->publish_down ) == '') {
			$row->publish_down = $db->getNullDate();
		}
		else {
			$date =& JFactory::getDate($row->publish_down, $tzoffset);
			$row->publish_down = $date->toMySQL();
		}
		$now = &JFactory::getDate('now', $tzoffset);
		$user = &JFactory::getUser();
		if($row->id){
			$row->modified = $now->toMySQL();
			$row->modified_by = $user->get('id');
		}
		else {
			$row->created = $now->toMySQL();
			$row->created_by = $user->get('id');
			$row->ordering = $row->getNextOrder('catid = '.$row->catid);
			$row->featured_ordering = $row->getNextOrder('featured=1');
			$row->hits = 0;
		}

		if($row->referenceType=='custom'){
			$row->custom = $data['reference'];
		}

		if (!$row->store()) {
			$this->setError($row->getError());
			return false;
		}
		
		// Define the images path
		$savepath = JPATH_SITE.DS.'media'.DS.'com_fpss';
		
		// Define the correct filename
		$filename = $row->id.'_'.md5('Image'.$row->id);
		
		// Rename the dummy generated images
		if($data['dummy']) {
			$dummy = $data['dummy'].'_'.md5('Image'.$data['dummy']);
			if(JFile::exists($savepath.DS.'src'.DS.$dummy.'_s.png')) {
				JFile::move($savepath.DS.'src'.DS.$dummy.'_s.png', $savepath.DS.'src'.DS.$filename.'_s.png');
			}
			if(JFile::exists($savepath.DS.'src'.DS.$dummy.'_s.jpg')) {
				JFile::move($savepath.DS.'src'.DS.$dummy.'_s.jpg', $savepath.DS.'src'.DS.$filename.'_s.jpg');
			}
			if(JFile::exists($savepath.DS.'cache'.DS.$dummy.'_m.jpg')) {
				JFile::move($savepath.DS.'cache'.DS.$dummy.'_m.jpg', $savepath.DS.'cache'.DS.$filename.'_m.jpg');
			}
			if(JFile::exists($savepath.DS.'cache'.DS.$dummy.'_p.jpg')) {
				JFile::move($savepath.DS.'cache'.DS.$dummy.'_p.jpg', $savepath.DS.'cache'.DS.$filename.'_p.jpg');
			}
			if(JFile::exists($savepath.DS.'cache'.DS.$dummy.'_t.jpg')) {
				JFile::move($savepath.DS.'cache'.DS.$dummy.'_t.jpg', $savepath.DS.'cache'.DS.$filename.'_t.jpg');
			}
		}

		if(empty($data['thumb'])) {
			JLoader::register('Upload', JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'class.upload.php');
			
			if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.jpg')) {
				$src = $savepath.DS.'src'.DS.$filename.'_s.jpg';
			}
			
			if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.png')) {
				$src = $savepath.DS.'src'.DS.$filename.'_s.png';
			}
			
			$handle = new Upload($src);
			$handle->allowed = array('image/*');
			if ($handle->uploaded) {
				$category = &JTable::getInstance('category', 'FPSS');
				$category->load($row->catid);
				$params = new JParameter($category->params);			
				$handle->file_auto_rename = false;
				$handle->file_overwrite = true;
				$handle->image_convert = 'jpg';
				$handle->image_resize = true;
				$handle->image_ratio_y = true;
				$handle->file_new_name_body = $filename.'_t';
				$handle->jpeg_quality = $params->get('thumbQuality', 75);
				$handle->image_x = $params->get('thumbWidth', 100);
				$handle->Process($savepath.DS.'cache');
				$row->thumbnailImage = $handle->file_dst_name;
			}
			else {
				$this->setError($handle->error);
				return false;
			}
		}

		$this->setState('id', $row->id);
		return true;
	}

	function upload(){
		$mainframe = &JFactory::getApplication();
		JLoader::register('Upload', JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'class.upload.php');
		$data = $this->getState('data');
		$files = $this->getState('files');
		$id = (int)$data['id'];
		$dummy = $data['dummy'];
		$catid = (int)$data['catid'];
		$category = &JTable::getInstance('category', 'FPSS');
		$category->load($catid);
		$params = new JParameter($category->params);
		if(isset($files['imageFile']) && isset($data['existingImage'])){
			$type='image';
			$newFile = $files['imageFile'];
			$existingFile = $data['existingImage'];
		}
		else {
			$type='thumb';
			$newFile = $files['thumbFile'];
			$existingFile = $data['existingThumb'];
		}

		if($newFile['error'] === 0){
			$image = $newFile;
			$cleanFlag = true;
		}
		else{
			$image = JPATH_SITE.DS.JPath::clean($existingFile);
			$cleanFlag = false;
		}

		$response = new stdClass();
		$response->type = $type;
		$response->error = '';
		$response->preview = '';
		$response->value = '';
		$handle = new Upload($image);
		$handle->allowed = array('image/*');
		if(!$handle->file_is_image){
			$response->error = JText::_('FPSS_THIS_IS_NOT_AN_IMAGE_FILE', true);
			return $response;
		}
		if ($handle->uploaded) {
			
			//Set the id
			if(!$id) {
				$id = $dummy;
				if(!$id) {
					$id = uniqid();
				}
				$response->dummy = $id;
			}
			
			//Set the common settings
			$filename = $id.'_'.md5('Image'.$id);
			$savepath = JPATH_SITE.DS.'media'.DS.'com_fpss';
			
			if($type=='image'){
				
				// Because we do not know the filetype of the src image we need to clean up
				if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.jpg')) {
					JFile::delete($savepath.DS.'src'.DS.$filename.'_s.jpg');
				}
				if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.png')) {
					JFile::delete($savepath.DS.'src'.DS.$filename.'_s.png');
				}
				
				//Original image
				$handle->file_auto_rename = false;
				$handle->file_overwrite = true;
				$handle->file_new_name_body = $filename.'_s';
				if($handle->image_src_type != 'jpg' && $handle->image_src_type != 'png') {
					$handle->image_convert = 'jpg';
					$handle->jpeg_quality = 100;
				}
				$handle->Process($savepath.DS.'src');
				
				//Preview image
				$handle->file_auto_rename = false;
				$handle->file_overwrite = true;
				$handle->image_convert = 'jpg';
				$handle->image_resize = true;
				$handle->image_ratio_y = true;
				$handle->file_new_name_body = $filename.'_p';
				$handle->jpeg_quality = $params->get('previewQuality', 85);
				$handle->image_x = $params->get('previewWidth', 600);
				$handle->Process($savepath.DS.'cache');

				//Main image
				$handle->file_auto_rename = false;
				$handle->file_overwrite = true;
				$handle->image_convert = 'jpg';
				$handle->image_resize = true;
				$handle->image_ratio_y = true;
				$handle->file_new_name_body = $filename.'_m';
				$handle->jpeg_quality = $params->get('imageQuality', 80);
				$handle->image_x = $params->get('imageWidth', 400);
				$handle->Process($savepath.DS.'cache');
				$response->value = $handle->file_dst_name;
				$response->preview = JURI::root(true).'/media/com_fpss/cache/'.$response->value.'?t='.uniqid();
				$response->width = $handle->image_dst_x;
				$response->height = $handle->image_dst_y;
			}
			else {
				//Thumbnail image
				$handle->file_auto_rename = false;
				$handle->file_overwrite = true;
				$handle->image_convert = 'jpg';
				$handle->image_resize = true;
				$handle->image_ratio_y = true;
				$handle->file_new_name_body = $filename.'_t';
				$handle->jpeg_quality = $params->get('thumbQuality', 75);
				$handle->image_x = $params->get('thumbWidth', 100);
				$handle->Process($savepath.DS.'cache');
				$response->value = $handle->file_dst_name;
				$response->preview = JURI::root(true).'/media/com_fpss/cache/'.$response->value.'?t='.uniqid();
				$response->width = $handle->image_dst_x;
				$response->height = $handle->image_dst_y;
			}
			if($cleanFlag) {
				$handle->clean();
			}
		}
		else {
			$response->error = $handle->error;
		}
		return $response;
	}

	function populate(){

		$params = &JComponentHelper::getParams('com_fpss');
		$type = $this->getState('type');
		$id = $this->getState('id');
		$response = new stdClass();

		switch($type){

			case 'com_content':
				$row = &JTable::getInstance('content');
				$row->load($id);
				$response->title = $row->title;
				$response->text = $row->introtext;
				break;

			case 'com_k2':
				JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'tables');
				$row = &JTable::getInstance('K2Item', 'Table');
				$row->load($id);
				$response->title = $row->title;
				$response->text = $row->introtext;
				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_L.jpg'))
				$response->image = 'media/k2/items/cache/'.md5("Image".$row->id).'_L.jpg';
				break;

			case 'com_virtuemart':
				if(JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php')) {
					require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php';
					$db = new ps_DB;
					$query = "SELECT * FROM #__{vm}_product WHERE product_id={$id}";
					$db->setQuery($query);
					$row = $db->loadObject($row);
					if($row->product_full_image){
						$response->image = 'components/com_virtuemart/shop_image/product/'.$row->product_full_image;
					}
				}
				else {
					$db = &JFactory::getDBO();
					$query = "SELECT * FROM #__vm_product WHERE product_id={$id}";
					$db->setQuery($query);
					$row = $db->loadObject();
					$query = "SELECT media.file_url FROM #__vm_product_media_xref AS xref JOIN #__vm_media AS media ON xref.file_ids=media.file_id
					WHERE xref.product_id={$id} AND media.file_is_product_image=1 AND published=1";
					$db->setQuery($query);
					$fileUrl = $db->loadResult();
					if($fileUrl) {
						$response->image = $fileUrl;
					}

				}
				$response->title = $row->product_name;
				$response->text = $row->product_desc;
				break;

			case 'com_redshop':
				$db = &JFactory::getDBO();
				$query = "SELECT * FROM #__redshop_product WHERE product_id={$id}";
				$db->setQuery($query);
				$row = $db->loadObject();
				$response->title = $row->product_name;
				$response->text = $row->product_s_desc;
				if($row->product_full_image){
					$response->image = 'components/com_redshop/assets/images/product/'.$row->product_full_image;
				}
				break;

			case 'com_tienda':
				JLoader::register('Tienda', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'defines.php');
				Tienda::load('TiendaHelperBase', 'helpers._base');
				$productHelper = &TiendaHelperBase::getInstance('Product');
				$row = $productHelper->load($id);
				$response->title = $row->product_name;
				$response->text = $row->product_description_short;
				if($row->product_full_image) {
					$imageUrl = $row->getImageUrl();
					$siteRoot = JURI::root(true);
					$image = JString::str_ireplace($siteRoot, '', $imageUrl).$row->product_full_image;
					$response->image = $image;
				}
				break;

			case 'com_menus':
				$menu = &JMenu::getInstance('site');
				$row = &$menu->getItem($id);
				$response->title = $row->name;
				$response->text = '';
				break;

		}

		$response->text = str_replace(array("\r\n", "\r", "\n"), '', $response->text);
		//$response->text = addslashes($response->text);
		return $response;
	}

	function getLiveTitle(){

		$type = $this->getState('type');
		$id = $this->getState('id');

		switch($type){

			case 'com_content':
				$row = &JTable::getInstance('content');
				$row->load($id);
				$title = $row->title;
				break;

			case 'com_menus':
				$row = &JTable::getInstance('menu');
				$row->load($id);
				$title = (version_compare( JVERSION, '1.6.0', 'ge' ))?$row->title:$row->name;
				break;

			case 'com_k2':
				JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'tables');
				$row = &JTable::getInstance('K2Item', 'Table');
				$row->load($id);
				$title = $row->title;
				break;

			case 'com_virtuemart':
				if(JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php')) {
					require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'classes'.DS.'ps_database.php';
					$db = new ps_DB;
					$query = "SELECT * FROM #__{vm}_product WHERE product_id={$id}";
					$db->setQuery($query);
					$row = $db->loadObject($row);
				}
				else {
					$db = &JFactory::getDBO();
					$query = "SELECT * FROM #__vm_product WHERE product_id={$id}";
					$db->setQuery($query);
					$row = $db->loadObject();
				}
				$title = $row->product_name;
				break;

			case 'com_redshop':
				JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_redshop'.DS.'tables');
				$row = &JTable::getInstance('product_detail', 'Table');
				$row->load($id);
				$title = $row->product_name;
				break;

			case 'com_tienda':
				JLoader::register('Tienda', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'defines.php');
				Tienda::load('TiendaHelperBase', 'helpers._base');
				$productHelper = &TiendaHelperBase::getInstance('Product');
				$row = $productHelper->load($id);
				$title = $row->product_name;
				break;
		}

		JFilterOutput::objectHTMLSafe($title);
		return $title;
	}

	function resetHits(){
		$db = &$this->getDBO();
		$query = "UPDATE #__fpss_slides SET hits = 0 WHERE id = ".(int)$this->getState('id');
		$db->setQuery($query);
		$db->query();
	}
	
	function getSlideImages(&$slide){
		$slide->srcImage = null;
		$slide->mainImage = null;
		$slide->previewImage = null;
		$slide->thumbnailImage = null;
		$savepath = JPATH_SITE.DS.'media'.DS.'com_fpss';
		$filename = $slide->id.'_'.md5('Image'.$slide->id);
		if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.png')) {
			$slide->srcImage = JURI::root(true).'/media/com_fpss/src/'.$filename.'_s.png';
		}
		if(JFile::exists($savepath.DS.'src'.DS.$filename.'_s.jpg')) {
			$slide->srcImage = JURI::root(true).'/media/com_fpss/src/'.$filename.'_s.jpg';
		}
		if(JFile::exists($savepath.DS.'cache'.DS.$filename.'_m.jpg')) {
			$slide->mainImage = JURI::root(true).'/media/com_fpss/cache/'.$filename.'_m.jpg';
		}
		if(JFile::exists($savepath.DS.'cache'.DS.$filename.'_p.jpg')) {
			$slide->previewImage = JURI::root(true).'/media/com_fpss/cache/'.$filename.'_p.jpg';
		}
		if(JFile::exists($savepath.DS.'cache'.DS.$filename.'_t.jpg')) {
			$slide->thumbnailImage = JURI::root(true).'/media/com_fpss/cache/'.$filename.'_t.jpg';
		}
	}
}
