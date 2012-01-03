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
  <?php if (!empty( $this->helpMessage)) echo $this->helpMessage; ?>
  <?php if (!empty( $this->message)) : ?>
    <ul>
      <li><div id="message-box-content"><?php if (!empty( $this->message)) echo $this->message; ?></div></li>
    </ul>
    <?php endif; ?>
    </div>
  </dd>
  </dl>

<form method="post" action="index.php" name="adminForm" id="adminForm" >

<?php echo $this->loadTemplate( 'filters')?>

<div id="editcell">
    <table class="adminlist">
      <thead>
        <tr>
          <th class="title" width="3%">
            <?php echo JText::_( 'NUM' ); ?>
          </th>

          <th class="title" width="5%" >
            <?php echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_HITS'), 'cpt', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>
          
          <th class="title" width="2%">
            <?php echo JText::_( 'COM_SH404SEF_IS_CUSTOM'); ?>
          </th>
          
          <th class="title" width="40%" style="text-align: left;" >
            <?php echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_URL'), 'oldurl', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>
          
          <th class="title" width="25%" >
            <?php echo JText::_( 'COM_SH404SEF_META_TITLE'); ?>
          </th>
          
          <th class="title" width="25%" >
            <?php echo JText::_( 'COM_SH404SEF_META_DESC'); ?>
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
              $nonSefUrl = empty($url->newurl) ? ( empty($url->nonsefurl) ? '' : $url->nonsefurl) : $url->newurl;
              $custom = !empty($url->newurl) && $url->dateadd != '0000-00-00' ? '<img src="components/com_sh404sef/assets/images/icon-16-locked.png" border="0" alt="Custom" title="'
                .JText::_('COM_SH404SEF_CUSTOM_URL_LINK_TITLE') .'"/>' : '&nbsp;'; 
        ?>    
            
        <tr class="<?php echo "row$k"; ?>">
        
          <td align="center" width="3%">
            <?php echo $this->pagination->getRowOffset( $i ); ?>
          </td>
          
          <td align="center" width="5%">
            <?php echo empty($url->cpt) ? '&nbsp;' : $this->escape( $url->cpt); ?>
          </td>
          
          <td align="center" width="2%">
            <?php echo $custom;?>
          </td>
          

          <td width="30%">
            <?php 
              echo '<input type="hidden" name="metaid['.$url->id.']" value="'.(empty($url->metaid) ? 0 : $url->metaid).'" />';
              echo '<input type="hidden" name="newurls['.$url->id.']" value="'.(empty($nonSefUrl) ? '' : $this->escape( $nonSefUrl)).'" />';
              // link to full meta edit
              $anchor = empty($url->oldurl) ? '(-)' : $this->escape( $url->oldurl);
              $anchor .= '<br/><i>(' . $this->escape( $nonSefUrl) . ')</i>';
              
              $linkData = array( 'c' => 'editalias', 'task' => 'edit', 'view' => 'editurl', 'startOffset' => '1','cid[]' => $url->id, 'tmpl' => 'component');
              $metaData = array( 'title' => JText::_('COM_SH404SEF_MODIFY_META_TITLE') . ' ' .$url->oldurl, 'class' => 'modalediturl', 'anchor' => $anchor);
              $modalOptions = array( 'size' => array('x' =>700, 'y' => 500));
              echo Sh404sefHelperHtml::makeLink( $this, $linkData, $metaData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
               
              // small preview icon
              $link = JURI::root() . (empty($url->oldurl) ? $nonSefUrl : $url->oldurl);
              echo '&nbsp;<a href="' . $link . '" target="_blank" title="' . JText::_('COM_SH404SEF_PREVIEW') . ' ' . $this->escape($link) . '">';
              echo '<img src=\'components/com_sh404sef/assets/images/external-black.png\' border=\'0\' alt=\''.JText::_('COM_SH404SEF_PREVIEW').'\' />';
              echo '</a>';
            ?>
          </td>
          
          <td width="30%">
            
            <textarea class="text_area" name="metatitle[<?php echo $url->id; ?>]" cols="40" rows="5"><?php echo $this->escape( $url->metatitle); ?></textarea>
            
          </td>

          <td width="30%">
          
            <textarea class="text_area" name="metadesc[<?php echo $url->id; ?>]" cols="40" rows="5"><?php echo $this->escape( $url->metadesc); ?></textarea>
            
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
    <input type="hidden" name="c" value="metas" />
    <input type="hidden" name="view" value="metas" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->options->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->options->filter_order_Dir; ?>" />
    <input type="hidden" name="contentcs" value="<?php echo $this->contentcs; ?>" />
    <input type="hidden" name="format" value="html" />
    <input type="hidden" name="shajax" value="0" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </div>  
</form>



