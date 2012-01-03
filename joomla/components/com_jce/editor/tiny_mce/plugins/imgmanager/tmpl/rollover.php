<?php
/**
* @version		$Id: rollover.php 55 2011-02-13 16:16:19Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
        <fieldset>
        <legend><input type="checkbox" id="rollover_check" class="checkbox" onclick="ImageManagerDialog.setRolloverImage();" /><label for="rollover_check" class="hastip" title="<?php echo WFText::_('WF_LABEL_ROLLOVER_ENABLE_DESC');?>"><?php echo WFText::_('WF_LABEL_ENABLE');?></label></legend>
        <table border="0" cellpadding="2">
                <tr>
                    <td><label for="onmouseoversrc" class="hastip" title="<?php echo WFText::_('WF_LABEL_MOUSEOVER_DESC');?>"><?php echo WFText::_('WF_LABEL_MOUSEOVER');?></label></td>
                    <td><input id="onmouseoversrc" type="text" value="" disabled="disabled" /></td>
                </tr>
                <tr>
                    <td><label for="onmouseoutsrc" class="hastip" title="<?php echo WFText::_('WF_LABEL_MOUSEOUT_DESC');?>"><?php echo WFText::_('WF_LABEL_MOUSEOUT');?></label></td>
                    <td><input id="onmouseoutsrc" type="text" value="" disabled="disabled" /></td>
                </tr>
        </table>
        </fieldset>