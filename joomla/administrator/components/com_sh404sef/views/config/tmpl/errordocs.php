<?php 
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: errordocs.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');
// we'll use panes so import Joomla library and instantiate one
jimport( 'joomla.html.pane');
$pane =& JPane::getInstance('Tabs');
$editor =& JFactory::getEditor();

?>

<div class="sh404sef-popup" id="sh404sef-popup">

<!-- markup common to all config layouts -->

<?php include JPATH_ADMINISTRATOR . DS . 'components' . DS. 'com_sh404sef' . DS . 'views' . DS . 'config' . DS . 'tmpl' . DS . 'common_header.php'; ?>

<!-- start general configuration markup -->

<div id="element-box">
  <div class="t">
    <div class="t">
      <div class="t"></div>
    </div>
  </div>
<div class="m">

<form action="index.php" method="post" name="adminForm" id="adminForm">

  <div id="editcell">

  <!-- start of configuration html -->
  
  <?php 
    echo $pane->startPane('sh404SEFConf');
    echo $pane->startPanel( JText::_('COM_SH404SEF_TITLE_BASIC'), 'main' ); ?>
    
<table class="adminlist">
  
  <!-- 404 error page -->
  <?php
  $x = 0;
  $x++;
  echo Sh404sefViewHelperConfig::shYesNoParamHTML( $x,
  JText::_('COM_SH404SEF_404PAGE'),
  JText::_('COM_SH404SEF_TT_404PAGE'),
  $this->lists['page404'] );

  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_PAGE_NOT_FOUND_ITEMID'),
  JText::_('COM_SH404SEF_TT_PAGE_NOT_FOUND_ITEMID'),
        'shPageNotFoundItemid',
  $this->sefConfig->shPageNotFoundItemid, 30, 30);
  
  $x++;
  echo Sh404sefViewHelperConfig::shTextParamHTML( $x,
  JText::_('COM_SH404SEF_PAGE_NOT_FOUND_TEMPLATE'),
  JText::_('COM_SH404SEF_TT_PAGE_NOT_FOUND_TEMPLATE'),
        'error404SubTemplate',
  $this->sefConfig->error404SubTemplate, 30, 50);
  
  
  ?></table><?php
  // end of params for meta tags management  -->
  
    echo $pane->endPanel(); 
    echo $pane->startPanel( JText::_('COM_SH404SEF_DEF_404_PAGE'), 'error404page' );

  // params for Page title configuration  -->
  ?><table class="adminlist">

  <tr>
    <td ><?php
    // parameters : areaname, content, width, height, cols, rows
    echo $editor->display( 'introtext',  $this->txt404 , '450', '450', '50', '50' ) ;
    ?></td>
    <td>
        <?php echo JText::_('COM_SH404SEF_404_PAGE_EDIT_HELP'); ?>
    </td>
  </tr>
  
  </table><?php
  // end of params for content title configuration  -->
  
    echo $pane->endPanel();
    echo $pane->endPane(); 
  ?>
  
  <!-- end of configuration html -->

    <input type="hidden" name="c" value="config" />
    <input type="hidden" name="view" value="config" />
    <input type="hidden" name="layout" value="errordocs" />
    <input type="hidden" name="format" value="raw" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="shajax" value="1" />
    <input type="hidden" name="tmpl" value="component" />
    
    <?php echo JHTML::_( 'form.token' ); ?>
  </div>  
</form>

  <div class="clr"></div>
</div>
  <div class="b">
    <div class="b">
      <div class="b"></div>
    </div>
  </div>
</div>

</div>
