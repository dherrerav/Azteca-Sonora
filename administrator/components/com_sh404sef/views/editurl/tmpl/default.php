<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
<div id="sh404sef-popup" class="sh404sef-popup">
  <div id="content-box">
    <div class="border">
        <div id="toolbar-box">
        <div class="t">
        <div class="t">
          <div class="t"></div>
        </div>
      </div>
      <div class="m">
        <?php echo $this->toolbar->render(); ?>
        <?php echo $this->toolbarTitle; ?>
        <div class="clr"></div>
      </div>
      <div class="b">
        <div class="b">
          <div class="b"></div>
        </div>
      </div>
      </div>
      <div class="clr"></div>
    <div class="clr"></div>
  <div class="clr"></div>
</div>
</div>
<div class="clr"></div>
  <dl id="system-message">
  <dt class="error"></dt>
  <dd class="error message fade">
    <div id="sh-error-box">
  <?php if (!empty( $this->errors)) : ?>
      <div id="error-box-content">
        <ul>
        <?php 
          foreach ($this->errors as $error) : 
            echo '<li>' . $error . '</li>';
          endforeach;
        ?>    
        </ul>
      </div>  
    <?php endif; ?>
    </div>
  </dd>
  </dl>

  <dl id="system-message">
  <dt class="message"></dt>
  <dd class="message message fade">
  <div id="sh-message-box">
  <?php if (!empty( $this->message)) : ?>
    <ul>
      <li><div id="message-box-content"><?php if (!empty( $this->message)) echo $this->message; ?></div></li>
    </ul>
    <?php endif; ?>
    </div>
  </dd>
  </dl>

<div id="element-box">
  <div class="t">
    <div class="t">
      <div class="t"></div>
    </div>
  </div>
  <div class="m">

<form action="index.php" method="post" name="adminForm" id="adminForm">

  <div id="editcell">
  <?php 

    jimport( 'joomla.html.pane');
    $options= array( 'startOffset' => $this->startOffset);
    $pane =& JPane::getInstance('Tabs', $options);
    echo $pane->startPane('sh404SEFEditurl');
    
    // don't display url edit panel for home page, as user can't change the url
    if (!$this->home) {
      echo $pane->startPanel( JText::_('COM_SH404SEF_EDIT_URL'), 'editurl' );
      echo $this->loadTemplate('url');
      echo $pane->endPanel();
    }
    
    echo $pane->startPanel( JText::_('COM_SH404SEF_EDIT_META'), 'seo' );
    echo $this->loadTemplate('seo');
    echo $pane->endPanel();
    
    
    echo $pane->startPanel( JText::_('COM_SH404SEF_ALIASES'), 'aliases' );
    echo $this->loadTemplate('aliases');
    echo $pane->endPanel();
    
    echo $pane->endPane();
    
    // if automatic url, some items are not editable, we pass them as hidden fields
    if (!$this->canEditNewUrl) : ?>
    <input type="hidden" name="newurl" value="<?php echo $this->escape( $this->url->get('newurl')); ?>" />
  <?php endif; 
  
    // if can edit the newurl, then the old is fixed (404 pages for instances)
    $oldUrl = $this->url->get('oldurl');
    if ($this->canEditNewUrl && !empty ($oldUrl)) : ?>
    <input type="hidden" name="oldurl" value="<?php echo $this->escape( $this->url->get('oldurl')); ?>" />
  <?php endif; ?>
  
  
    <input type="hidden" name="id" value="<?php echo $this->url->get('id'); ?>" />
    
    <input type="hidden" name="c" value="editurl" />
    <input type="hidden" name="view" value="editurl" />
    <input type="hidden" name="format" value="raw" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="shajax" value="1" />
    <input type="hidden" name="tmpl" value="component" />
    <input type="hidden" name="previousSefUrl" value="<?php echo $this->escape( $this->url->get('oldurl')); ?>" />
    <input type="hidden" name="previousNonSefUrl" value="<?php echo $this->escape( $this->url->get('newurl')); ?>" />
    <input type="hidden" name="meta_id" value="<?php echo $this->meta->id; ?>" />
    <?php if ($this->home || $this->noUrlEditing) : ?>
      <input type="hidden" name="oldurl" value="<?php echo $this->escape( $this->url->get('oldurl')); ?>" />
      <input type="hidden" name="newurl" value="<?php echo $this->escape( $this->url->get('newurl')); ?>" />
      <input type="hidden" name="pageid" value="" />
    <?php endif; ?>
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