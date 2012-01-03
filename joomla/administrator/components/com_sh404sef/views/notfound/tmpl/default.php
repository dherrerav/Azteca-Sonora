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
 
  <div id="content-box">
    <div class="border">
      <div id="toolbar-box">
        <div class="t">
          <div class="t">
            <div class="t"></div>
          </div>
        </div>
        <div class="m">
          <div class="mainurl"><?php echo '<small>' . $this->mainTitle . '</small> ' . $this->escape( $this->url->get('oldurl')); ?></div>
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

  <?php if(!empty( $this->alertMsg)) : ?>
    <div class="sh404sef-red-center"><?php echo $this->escape( $this->alertMsg); ?></div>
  <?php endif; ?>
  
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
  
<form method="post" action="index.php" name="adminForm" id="adminForm">

<?php echo $this->loadTemplate( 'filters')?>

<div id="editcell">
    <table class="adminlist">
      <thead>
        <tr>
          <th class="title" width="3%">
            <?php echo JText::_( 'NUM' ); ?>
          </th>
          <th width="2%">
            <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $this->itemCount; ?>);" />
          </th>
          <th class="title" width="5%" >
            <?php 
              if($this->options->filter_similar_urls == 0) {
                echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_HITS'), 'cpt', $this->options->filter_order_Dir, $this->options->filter_order);
              } else {
                echo JText::_( 'COM_SH404SEF_HITS');
              } 
            ?>
          </th>
          <th class="title" width="5%">
            <?php echo JText::_( 'COM_SH404SEF_PAGE_ID'); ?>
          </th>
          <th class="title" style="text-align: left;" width="67%" >
            <?php
            if($this->options->filter_similar_urls == 0) { 
              echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_SEF_URL'), 'oldurl', $this->options->filter_order_Dir, $this->options->filter_order);
            } else {
              echo JText::_( 'COM_SH404SEF_SEF_URL');
            }
            ?>
          </th>
          <th class="title" width="5%">
            <?php echo JText::_( 'COM_SH404SEF_IS_CUSTOM'); ?>
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">
            <?php echo $this->pagination->getListFooter(); ?>
          </td>
        </tr>
      </tfoot>
      <tbody>
        <?php
        $k = 0;
        if( $this->itemCount > 0 ) {
          for ($i=0; $i < $this->itemCount; $i++) {
            
            $url = &$this->items[$i]; 
            $checked = JHtml::_( 'grid.id', $i, $url->id); 
            $custom = !empty($url->newurl) && $url->dateadd != '0000-00-00' ? '<img src="components/com_sh404sef/assets/images/icon-16-user.png" border="0" alt="Custom" />' : '&nbsp;';
            $alt  = JText::sprintf('COM_SH404SEF_NOT_FOUND_REDIRECT_TO', $this->escape( $this->url->get('oldurl')), $this->escape($url->oldurl));
            $oldUrl = '
              <a href="javascript:void(0);" onclick="return shListItemAjaxTask(\'cb'. $i .'\',\'selectnfredirect\', {}, 1)" title="'. $alt .'">'.$this->escape($url->oldurl).'</a>'; 
        ?>
        <tr class="<?php echo "row$k"; ?>">
          <td align="center" >
            <?php echo $this->pagination->getRowOffset( $i ); ?>
          </td>
          <td align="center">
            <?php echo $checked; ?>
          </td>
          <td align="center">
            <?php echo empty($url->cpt) ? '&nbsp;' : $this->escape( $url->cpt); ?>
          </td>
          <td align="center">
            <?php 
              echo empty( $url->pageid) ? '' : $this->escape($url->pageid);
            ?>
          </td>

          <td>
            <?php echo $oldUrl; ?>
          </td>

          <td align="center">
            <?php echo $custom;?>
          </td>
        </tr>
        <?php
        $k = 1 - $k;
      }
    } else {
      ?>
        <tr>
          <td align="center" colspan="6">
            <?php echo JText::_( 'COM_SH404SEF_NO_URL' ); ?>
          </td>
        </tr>
        <?php
      }
      ?>
      </tbody>
    </table>
    <input type="hidden" name="c" value="notfound" />
    <input type="hidden" name="view" value="notfound" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="format" value="html" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->options->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->options->filter_order_Dir; ?>" />
    <input type="hidden" name="tmpl" value="component" />
    <input type="hidden" name="notfound_url_id" value="<?php echo $this->url->id; ?>" />
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