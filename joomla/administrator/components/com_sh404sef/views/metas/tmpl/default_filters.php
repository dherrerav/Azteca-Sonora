<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2011
 * @package     sh404SEF-16
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default_filters.php 2050 2011-06-30 13:52:38Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>

<table>
  <tr>
    <td align="left" nowrap="nowrap">
      <?php echo JText::_( 'Search' ); ?>:
      <input type="text" name="search_all" id="search_all" value="<?php echo $this->escape($this->options->search_all);?>" size="35" maxlength="255" class="text_area" onchange="document.adminForm.limitstart.value=0;shMetasClearFields();document.adminForm.submit();" />
      <button onclick="document.adminForm.limitstart.value=0;shMetasClearFields();this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
      <button onclick="document.adminForm.limitstart.value=0;document.getElementById('search_all').value='';shMetasClearFields();this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
    </td>

    <td width="100%">
        &nbsp;
      </td>
    <td>
      <?php echo $this->optionsSelect->components;  ?>
    </td>
    <td>
      <?php echo $this->optionsSelect->languages;  ?>
    </td>
    <td>
      <?php echo $this->optionsSelect->filter_url_type;  ?>
    </td>
    <td>
      <?php echo $this->optionsSelect->filter_title;  ?>
    </td>
    <td>
      <?php echo $this->optionsSelect->filter_desc;  ?>
    </td>
  </tr>
</table>