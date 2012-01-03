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


<div id="content-box">
    <div class="border">
      <div id="toolbar-box">
        <div class="t">
          <div class="t">
            <div class="t"></div>
          </div>
        </div>
        <div class="m">
          <div class="mainurl"><?php echo '<small>' . JText::_('COM_SH404SEF_NOT_FOUND_ENTER_REDIRECT_FOR') . '</small> ' . $this->escape( $this->url->get('oldurl')); ?></div>
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
      echo $this->loadTemplate('redirect');
    ?>  
    <input type="hidden" name="id" value="<?php echo $this->url->get('id'); ?>" />
    <input type="hidden" name="c" value="editnotfound" />
    <input type="hidden" name="view" value="editnotfound" />
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