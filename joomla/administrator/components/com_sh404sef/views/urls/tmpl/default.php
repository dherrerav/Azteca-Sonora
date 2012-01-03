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

if ($this->slowServer) {
 echo JText::_('COM_SH404SEF_SLOW_SERVER_MODE_ON');
}

?>
<form method="post" name="adminForm" id="adminForm">

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
            <?php echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_HITS'), 'cpt', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>
          <th class="title" width="5%">
            <?php echo JText::_( 'COM_SH404SEF_PAGE_ID'); ?>
          </th>
          <th class="title" width="30%" >
            <?php echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_SEF_URL'), 'oldurl', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>
          <th class="title" width="42%" >
            <?php echo JText::_( 'COM_SH404SEF_NON_SEF_URL'); ?>
          </th>
          <th class="title" width="4%">
            <?php echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_HAS_METAS'), 'metas', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>
          <th class="title" width="4%">
            <?php echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_HAS_DUPLICATE'), 'duplicates', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>
          <th class="title" width="4%">
            <?php echo JHTML::_('grid.sort', JText::_( 'COM_SH404SEF_ALIASES'), 'aliases', $this->options->filter_order_Dir, $this->options->filter_order); ?>
          </th>
          <th class="title">
            <?php echo JText::_( 'COM_SH404SEF_IS_CUSTOM'); ?>
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="10">
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
              $custom = !empty($url->newurl) && $url->dateadd != '0000-00-00' ? '<img src="components/com_sh404sef/assets/images/icon-16-locked.png" border="0" alt="Custom" title="'
                .JText::_('COM_SH404SEF_CUSTOM_URL_LINK_TITLE') .'"/>' : '&nbsp;'; 
              $metaImg = '<img src=\'components/com_sh404sef/assets/images/icon-16-metas.png\' border=\'0\' alt=\''.JText::_('COM_SH40SEF_HAS_META_LINK_TITLE').'\' />';
        ?>    
            
        <tr class="<?php echo "row$k"; ?>">
          <td align="center" width="3%">
            <?php echo $this->pagination->getRowOffset( $i ); ?>
          </td>
          <td align="center" width="2%">
            <?php echo $checked; ?>
          </td>
          <td align="center" width="5%">
            <?php echo empty($url->cpt) ? '&nbsp;' : $this->escape( $url->cpt); ?>
          </td>
          <td width="5%">
            <?php 
              echo $this->slowServer ? '' : $this->escape($url->pageid);
            ?>
          </td>
          <td width="30%">
          <?php 
            $linkData = array( 'c' => 'editurl', 'task' => 'edit', 'cid[]' => $url->id, 'tmpl' => 'component');
            $urlData = array( 'title' => JText::_('COM_SH404SEF_MODIFY_LINK_TITLE') . ' ' .$url->oldurl, 'class' => 'modalediturl', 'anchor' => $url->oldurl);
            $modalOptions = array( 'size' => array('x' =>700, 'y' => 500));
            echo Sh404sefHelperHtml::makeLink( $this, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = ''); 
            // small preview icon
            $link = JURI::root() . $url->oldurl;
            echo '&nbsp;<a href="' . $link . '" target="_blank" title="' . JText::_('COM_SH404SEF_PREVIEW') . ' ' . $this->escape($url->oldurl) . '">';
            echo '<img src=\'components/com_sh404sef/assets/images/external-black.png\' border=\'0\' alt=\''.JText::_('COM_SH404SEF_PREVIEW').'\' />';
            echo '</a>';
            ?>
          </td>
          <td width="42%">
            <?php echo $this->escape( $url->newurl); ?>
          </td>
          <td align="center" width="5%">
            <?php 
            if (empty($url->metas)) {
              echo '&nbsp;';
            } else {
              $linkData = array( 'c' => 'editurl', 'task' => 'edit', 'cid[]' => $url->id, 'tmpl' => 'component', 'startOffset' => 1);
              $urlData = array( 'title' => JText::_('COM_SH404SEF_HAS_META_LINK_TITLE'), 'class' => 'modalediturl', 'anchor' => $metaImg);
              $modalOptions = array( 'size' => array('x' =>700, 'y' => 500));
              echo Sh404sefHelperHtml::makeLink( $this, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
            }
            ?>
          </td>
          <td align="center" width="5%">
            <?php 
            if ($this->slowServer) {
              $linkData = array( 'c' => 'duplicates', 'cid[]' => $url->id, 'tmpl' => 'component');
              $anchor = $url->rank == 0 ? '[<strong>+++</strong>]' : '++';
              $title = $url->rank == 0 ? JText::_('COM_SH404SEF_IS_A_MAIN_URL') : JText::_('COM_SH404SEF_IS_DUPLICATE');
              $urlData = array( 'title' => $title, 'class' => 'modalediturl', 'anchor' => $anchor);
              $modalOptions = array( 'size' => array('x' => '\\window.getScrollSize().x*0.9', 'y' => '\\window.getSize().y*.9'));
              echo Sh404sefHelperHtml::makeLink( $this, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
            }
            if (empty($url->duplicates)) {
              echo '&nbsp;';
            } else {
              $linkData = array( 'c' => 'duplicates', 'cid[]' => $url->id, 'tmpl' => 'component');
              $urlData = array( 'title' => JText::sprintf('COM_SH404SEF_HAS_DUPLICATES_LINK_TITLE', $url->duplicates), 'class' => 'modalediturl', 'anchor' => $url->duplicates);
              $modalOptions = array( 'size' => array('x' => '\\window.getScrollSize().x*.9', 'y' => '\\window.getSize().y*.9'));
              echo Sh404sefHelperHtml::makeLink( $this, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
            }
            ?>
          </td>
          <td align="center" width="5%">
            <?php 
              if (empty($url->aliases)) {
                echo '&nbsp;';
              } else {
                $linkData = array( 'c' => 'editurl', 'task' => 'edit', 'cid[]' => $url->id, 'tmpl' => 'component', 'startOffset' => 2);
                $urlData = array( 'title' => 'Has ' . $url->aliases . ' alias(es)', 'class' => 'modalediturl', 'anchor' => $url->aliases);
                $modalOptions = array( 'size' => array('x' =>700, 'y' => 500));
                echo Sh404sefHelperHtml::makeLink( $this, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');;
              }
            ?>  
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
          <td align="center" colspan="10">
            <?php echo JText::_( 'COM_SH404SEF_NO_URL' ); ?>
          </td>
        </tr>
        <?php
      }
      ?>
      </tbody>
    </table>
    <input type="hidden" name="c" value="urls" />
    <input type="hidden" name="view" value="urls" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->options->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->options->filter_order_Dir; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </div>  
</form>



