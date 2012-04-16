<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
class plgAcymailingContentplugin extends JPlugin
{
	function plgAcymailingContentplugin(&$subject, $config){
		parent::__construct($subject, $config);
		if(!isset($this->params)){
			$plugin =& JPluginHelper::getPlugin('acymailing', 'contentplugin');
			$this->params = new JParameter( $plugin->params );
		}
		$this->paramsContent =& JComponentHelper::getParams('com_content');
		JPluginHelper::importPlugin('content');
		$this->dispatcherContent =& JDispatcher::getInstance();
		$excludedHandlers = array('plgContentEmailCloak','pluginImageShow');
		$excludedNames = array('system' => array('SEOGenerator','SEOSimple'), 'content' => array('webeecomment','highslide','smartresizer','phocagallery'));
		$excludedType = array_keys($excludedNames);
		if(version_compare(JVERSION,'1.6.0','<')){
			foreach ($this->dispatcherContent->_observers as $id => $observer){
				if (is_array($observer) AND in_array($observer['handler'],$excludedHandlers)){
					$this->dispatcherContent->_observers[$id]['event'] = '';
				}elseif(is_object($observer)){
					if(in_array($observer->_type,$excludedType) AND in_array($observer->_name,$excludedNames[$observer->_type])){
						$this->dispatcherContent->_observers[$id] = null;
					}
				}
			}
		}
		if(!class_exists('JSite')) include_once(ACYMAILING_ROOT.'includes'.DS.'application.php');
		}
	function acymailing_replaceusertags(&$email,&$user,$send = true){
		$art = new stdClass();
		$art->title = $email->subject;
		$art->introtext = $email->body;
		$art->fulltext = $email->body;
		$art->attribs = '';
		$art->state=1;
		$art->created_by=@$email->userid;
		$art->images = '';
		$art->id = 0;
		$art->section = 0;
		$art->catid = 0;
		$currentSession =  & JFactory::getSession() ;
		if($currentSession->get('acyonpreparecontent',false)){
			$db =& JFactory::getDBO();
			if(version_compare(JVERSION,'1.6.0','>=')){
				$db->setQuery("UPDATE #__extensions SET `enabled` = 0 WHERE `folder` = 'acymailing' AND `element` = 'contentplugin' LIMIT 1");
			}else{
				$db->setQuery("UPDATE #__plugins SET `published` = 0 WHERE `folder` = 'acymailing' AND `element` = 'contentplugin' LIMIT 1");
			}
			$db->query();
			$currentSession->set('acyonpreparecontent',false);
			return;
		}
		$context = 'com_acymailing';
		$currentSession->set('acyonpreparecontent',true);
		if(!empty($email->body)){
			$art->text = $email->body;
			if(version_compare(JVERSION,'1.6.0','<')){
				$resultsPlugin = $this->dispatcherContent->trigger('onPrepareContent', array (&$art, &$this->paramsContent, 0 ));
			}else{
				if($send) $art->text .= '{emailcloak=off}';
				$resultsPlugin = $this->dispatcherContent->trigger('onContentPrepare', array ($context,&$art, &$this->paramsContent, 0 ));
				if($send) $art->text = str_replace('{emailcloak=off}','',$art->text);
			}
			$email->body = $art->text;
		}
		if(!empty($email->altbody)){
			$art->text = $email->altbody;
			if(version_compare(JVERSION,'1.6.0','<')){
				$resultsPlugin = $this->dispatcherContent->trigger('onPrepareContent', array (&$art, &$this->paramsContent, 0 ));
			}else{
				if($send) $art->text .= '{emailcloak=off}';
				$resultsPlugin = $this->dispatcherContent->trigger('onContentPrepare', array ($context,&$art, &$this->paramsContent, 0 ));
				if($send) $art->text = str_replace('{emailcloak=off}','',$art->text);
			}
			$email->altbody = $art->text;
		}
		$currentSession->set('acyonpreparecontent',false);
	}
}//endclass