<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: mod_sh404sef_cpicon.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_sh404sef')) {
  return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// define path to sh404SEF front and backend dirs
require_once JPATH_ROOT . DS. 'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'defines.php';

$lang = & JFactory::getLanguage();
$app = &JFactory::getApplication();
$document = &JFactory::getDocument();
$document->addStyleSheet( JURI::root().'administrator/modules/mod_sh404sef_cpicon/styles.css');

// is an update available?
$versionsInfo = Sh404sefHelperUpdates::getUpdatesInfos();
$updateText = $versionsInfo->shouldUpdate ? '<br /><font color="red">' . JText::_('COM_SH404SEF_UPDATE_REQUIRED') . '</font>' : '<br /><font color="green">' . JText::_('COM_SH404SEF_UPDATE_NOT_REQUIRED') . '</font>';
?>

<div id="modsh404_cpanel" style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">

  <div class="icon">
    <a href="index.php?option=com_sh404sef"> 
      <img src="components/com_sh404sef/assets/images/icon-48-analytics.png"
  	   title="sh404sef & Analytics" alt="sh404sef & Analytics" /> 
  	   <span>sh404sef &amp; Analytics<?php echo $updateText; ?></span> 
    </a>
  </div>

</div>



