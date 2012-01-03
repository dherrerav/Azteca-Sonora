<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: config.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefModelConfig extends Sh404sefClassBaseeditmodel {

  protected $_context = 'sh404sef.config';

  protected $_defaultTable = '';

  /**
   * Layout value
   *
   * @var string
   */
  protected $_layout = 'default';


  /**
   * Save configuration to disk
   * from POST data or input array of data
   *
   * When config will be saved to db, most of the code in this
   * model will be removed and basemodel should handle everything
   *
   * @param array $dataArray an array holding data to save. If empty, $_POST is used
   * @return integer id of created or updated record
   */
  public function save( $dataArray = null) {

    // get current configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    // call the appropriate method for each
    // configuration settings set
    $methodName = '_save' . ucfirst( $this->_layout);

    if (is_callable( array($this, $methodName))) {
      $status = true;
      $this->$methodName();
    } else {
      $status = false;
      $this->setError( 'Internal error : method not defined : _save' . ucfirst( $params['layout']));
    }

    if ($status && !empty($_POST)) {
      foreach($_POST as $key => $value) {
        $sefConfig->set($key, $value);
        $this->_advancedConfig($key, $value);
      }
    }

    // ask config class to save itself
    $status = $status && $sefConfig->saveConfig();

    // store any error
    if(!$status) {
      $this->setError( JText::_('COM_SH404SEF_ERR_CONFIGURATION_NOT_SAVED'));

    }

    return $status;
  }

  /**
   * Prepare saving of basic configuration options set
   */
  private function _saveDefault() {

    // get current configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    //clear config arrays, unless POST is empty, meaning this is first attempt to save config
    if (!empty($_POST)) {
      $sefConfig->skip = array();
      $sefConfig->nocache = array();
      $sefConfig->notTranslateURLList = array();
      $sefConfig->notInsertIsoCodeList = array();
      $sefConfig->shDoNotOverrideOwnSef = array();
      $sefConfig->useJoomsefRouter = array();
      $sefConfig->useAcesefRouter = array();
      $sefConfig->shLangTranslateList = array();
      $sefConfig->shLangInsertCodeList = array();
      $sefConfig->compEnablePageId = array();
      $sefConfig->defaultComponentStringList = array();
      $sefConfig->analyticsExcludeIP = array();
      $sefConfig->useJoomlaRouter = array();
    }
    if (empty($_POST['debugToLogFile'])) {
      $sefConfig->debugStartedAt = 0;
    } else {
      $sefConfig->debugStartedAt = empty($sefConfig->debugStartedAt) ? time() : $sefConfig->debugStartedAt;
    }

  }

  /**
   * Prepare saving of analytics configuration options set
   */
  private function _saveAnalytics() {

    // get current configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    //clear config arrays, unless POST is empty, meaning this is first attempt to save config
    if (!empty($_POST)) {
      $sefConfig->analyticsExcludeIP = array();

      // handle password
      $password = JRequest::getString( 'analyticsPassword', '********');

      // clear authorization cache if credentials have changed
      // if left as '********', we keep the old one
      if($password == '********' ) {
        JRequest::setVar( 'analyticsPassword', $sefConfig->analyticsPassword, 'POST');
      }

    }


  }

  /**
   * Prepare saving of  extensions configuration options set
   */
  private function _saveExt() {

  }

  /**
   * Prepare saving of  S.E.O. and meta configuration options set
   */
  private function _saveSeo() {

    // get plugins details
    $plugin = &JPluginHelper::getPlugin( 'system', 'shmobile');
    $params = new JParameter( $plugin->params);

    // get current values
    $defaultEnabled = $params->get('mobile_switch_enabled');
    $defaultTemplate = $params->get('mobile_template');

    // save mobile template switcher params, stored in system plugin
    $mobile_switch_enabled = JRequest::getBool( 'mobile_switch_enabled', $defaultEnabled);
    $mobile_template = JRequest::getCmd( 'mobile_template', $defaultTemplate);

    // set params
    $params->set('mobile_switch_enabled', $mobile_switch_enabled);
    $params->set('mobile_template', $mobile_template);
    $textParams = $params->toString();

    try {
      Sh404sefHelperDb::update( '#__extensions', array('params' => $textParams), array( 'element' => 'shmobile', 'folder' => 'system', 'type' => 'plugin'));
    } catch (Sh404sefExceptionDefault $e) {

    }

  }

  /**
   * Prepare saving of  security configuration options set
   */
  private function _saveSec() {

    // get current configuration object
    $sefConfig = & Sh404sefFactory::getConfig();

    //set skip and nocache arrays, unless POST is empty, meaning this is first attempt to save config
    if (!empty($_POST)) {
      $sefConfig->shSecOnlyNumVars = array();
      $sefConfig->shSecAlphaNumVars = array();
      $sefConfig->shSecNoProtocolVars = array();
      $sefConfig->ipWhiteList = array();
      $sefConfig->ipBlackList = array();
      $sefConfig->uAgentWhiteList = array();
      $sefConfig->uAgentBlackList = array();
    }

  }

  /**
   * Prepare saving of  Error documents configuration options set
   */
  private function _saveErrordocs() {

    // update 404 error page
    $quoteGPC = get_magic_quotes_gpc();
    $shIntroText = empty($_POST) ? '' : ($quoteGPC? stripslashes($_POST['introtext']) : $_POST['introtext']);
    try {
      // is there already a 404 page article?
      $id = Sh404sefHelperDb::selectResult('#__content', 'id', array( 'title' => '__404__'));

      if (!empty($id)) {
        // yes, update it
        Sh404sefHelperDb::update('#__content', array('introtext' => $shIntroText, 'modified' => date("Y-m-d H:i:s")), array( 'id' => $id));
      }else{
        $catid = Sh404sefHelperDb::selectResult( '#__categories', array('id'), 'parent_id > 0 and extension = ? and path = ? and level = ?', array( 'com_content', 'uncategorised', 1));
        if(empty($catid)) {
          $this->setError( JText::_('COM_SH404SEF_CANNOT_SAVE_404_NO_UNCAT'));
          return;
        }
        $contentTable = JTable::getInstance( 'content');
        $content = array( 'title' => '__404__', 'alias' => '__404__', 'title_alias' => '__404__', 'introtext' => $shIntroText, 'state' => 1
        , 'catid' => $catid, 'attribs' => '{"menu_image":"-1","show_title":"0","show_section":"0","show_category":"0","show_vote":"0","show_author":"0","show_create_date":"0","show_modify_date":"0","show_pdf_icon":"0","show_print_icon":"0","show_email_icon":"0","pageclass_sfx":""');

        $saved = $contentTable->save( $content);
        if(!$saved) {
          $this->setError( $contentTable->getError());
        }

      }
    } catch (Sh404sefExceptionDefault $e) {
      $this->setError( $e->getMEssage());
    }
    // prevent from being added later on to $sefConfig
    unset($_POST['introtext']);
  }

  /**
   * Prepare saving of quick control panel
   */
  private function _saveQcontrol() {

  }

  /**
   * Handle processing of some special parts of configuration
   * will be removed when moving to DB backed config
   *
   * @param string $key
   * @param string $value
   */
  private function _advancedConfig($key,$value){

    $sefConfig = & Sh404sefFactory::getConfig();
    if ((strpos($key,"com_")) !== false) {
      // V 1.2.4.m
      $key = str_replace('com_','',$key);
      $param = explode('___',$key);
      switch ($param[1]) {
        case 'manageURL' :
          switch ($value) {
            case 1 :
              array_push($sefConfig->nocache,$param[0]);
              break;
            case 2 :
              array_push($sefConfig->skip,$param[0]);
              break;
            case 3 :
              array_push($sefConfig->useJoomlaRouter,$param[0]);
              break;
          }
          break;
        case 'translateURL':
          if ($value == 1)
          array_push($sefConfig->notTranslateURLList,$param[0]);
          break;
        case 'insertIsoCode':
          if ($value == 1)
          array_push($sefConfig->notInsertIsoCodeList,$param[0]);
          break;
        case 'shDoNotOverrideOwnSef':

          switch( $value) {
            case Sh404sefClassBaseextplugin::TYPE_JOOMLA_ROUTER:
              array_push($sefConfig->shDoNotOverrideOwnSef,$param[0]);
              break;
            case Sh404sefClassBaseextplugin::TYPE_JOOMSEF_ROUTER:
              array_push($sefConfig->useJoomsefRouter,$param[0]);
              break;
            case Sh404sefClassBaseextplugin::TYPE_ACESEF_ROUTER:
              array_push($sefConfig->useAcesefRouter,$param[0]);
              break;

          }
          break;
        case 'compEnablePageId':
          if ($value == 1)
          array_push($sefConfig->compEnablePageId,$param[0]);
          break;
        case 'defaultComponentString':
          $cleanedUpValue = empty($value) ? '': titleToLocation($value);
          $cleanedUpValue = JString::trim( $cleanedUpValue, $sefConfig->friendlytrim);
          $sefConfig->defaultComponentStringList[$param[0]] = $cleanedUpValue;
          break;
      }
    } else {

      switch ($key){
        case 'shSecOnlyNumVars':
          $this->_shSetArrayParam($value, $sefConfig->shSecOnlyNumVars);
          break;
        case 'shSecAlphaNumVars':
          $this->_shSetArrayParam($value, $sefConfig->shSecAlphaNumVars);
          break;
        case 'shSecNoProtocolVars':
          $this->_shSetArrayParam($value, $sefConfig->shSecNoProtocolVars);
          break;
        case 'analyticsExcludeIP':
          $this->_shSetArrayParam($value, $sefConfig->analyticsExcludeIP);
          break;
      }

      if (preg_match('/languages_([a-zA-Z]{2}-[a-zA-Z]{2})_translateURL/U', $key, $matches)) {
        $sefConfig->shLangTranslateList[$matches[1]] = $value;
      }
      if (preg_match('/languages_([a-zA-Z]{2}-[a-zA-Z]{2})_insertCode/U', $key, $matches)) {
        $sefConfig->shLangInsertCodeList[$matches[1]] = $value;
      }
      if (preg_match('/languages_([a-zA-Z]{2}-[a-zA-Z]{2})_pageText/U', $key, $matches)) {
        $sefConfig->pageTexts[$matches[1]] = $value;
      }
    }
  }

  private function _shSetArrayParam($value, &$param) {
    if (!empty($value)) {
      $param = explode("\n", $value);
      foreach ($param as $k=>$v) {
        $param[$k] = JString::trim($v);
      }
    } else
    $param = array();
    if (!empty($param))
    $param = array_filter($param);
  }

}