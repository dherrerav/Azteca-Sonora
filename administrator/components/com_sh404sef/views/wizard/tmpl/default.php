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
<div class="sh404sef-popup" id="sh404sef-popup">



  <div id="content-box">
    <div class="border">
      <div id="toolbar-box">
        <div class="t">
          <div class="t">
            <div class="t"></div>
          </div>
        </div>
        <div class="m">
          <div class="sh404sef-toolbar-title icon-48-sh404sef">
            <?php 
              if (!empty( $this->stepTitle)) {
                echo $this->escape( $this->stepTitle); 
              }
              ?>
          </div>

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

<?php 

// if only redirecting, stop here
if (!empty( $this->redirectTo)) {
  return;  
}

?>
<div id="element-box">
  <div class="t">
    <div class="t">
      <div class="t"></div>
    </div>
  </div>
  <div class="m">

<form action="index.php"
  <?php if (!empty( $this->setFormEncType)) {
        echo ' enctype="' . $this->setFormEncType . '" '; 
        }
  ?>method="post" name="adminForm" id="adminForm">

  <div id="editcell">
  <?php 
  
    if (!empty( $this->mainText)) {
      echo $this->mainText;
    }
   
  ?>    
    
  <input type="hidden" name="c" value="<?php echo $this->actionController; ?>" />
  <input type="hidden" name="option" value="com_sh404sef" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="tmpl" value="component" />
  <input type="hidden" name="optype" value="<?php echo $this->opType; ?>" />
  <input type="hidden" name="opsubject" value="<?php echo $this->opSubject; ?>" />
    <?php 
    // optional elements to pass to the action controller if action is confirmed
      foreach( $this->buttonsList as $button) {
        echo '  <input type="hidden" name="'. $button.'" value="' . intval( $this->$button) . '" />' . "\n";
      } 
    
    // option hidden text as provided by the calling controller
    if (!empty( $this->hiddenText)) {
      echo $this->hiddenText;
    }
    ?>
    
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

<?php 
$toolbar = $this->toolbar->render();

// hard to decide if there is any button in that toolbar !
if (strpos( $toolbar, '</a>') !== false) :

?>
<br />

  <div id="content-box">
    <div class="border">
      <div id="toolbar-box">
        <div class="t">
          <div class="t">
            <div class="t"></div>
          </div>
        </div>
        <div class="m">
          <?php echo $toolbar; ?>
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
<?php endif; ?>
</div>

<?php 
if (!empty( $this->continue)) {
        $js = '
        <script type="text/javascript">
      window.location = "' . $this->continue . '"
    </script>
    ';
        echo $js;
      }
?>
