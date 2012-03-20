<?php
/**
 * @version		$Id: default.php 616 2011-08-01 22:53:18Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div id="filebrowserContainer">
<div class="addressBar">
<img alt="<?php echo JText::_('FPSS_UP'); ?>" src="components/com_fpss/images/upButton.gif" id="folderUpButton"/> <input id="addressPath" type="text" disabled="disabled" name="path" value=""/>
</div>
<iframe name="filebrowser" id="filebrowser" width="550" height="400" src="index.php?option=com_media&amp;view=imagesList&amp;tmpl=component"></iframe>
</div>