<?php 
/**
 * @version		$Id: default.php 201 2011-05-08 16:27:15Z happy_noodle_boy $
 * @package   	JCE
 * @copyright 	Copyright © 2009-2011 Ryan Demmer. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license   	GNU/GPL 2 or later
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('RESTRICTED');
?>
<div id="jce">
	<table style="width:100%;height:100%;" cellspacing="1" id="help-table">
		<tr>
			<td style="vertical-align:top;height:100%;width:30%"><div id="help-menu"><?php echo $this->model->renderTopics();?></div></td>
			<td style="background-color:#efefef;border:0;padding:0;width:16px;"><div id="help-handle" class="ui-icon ui-icon-triangle-2-e-w"></div></td>
			<td style="vertical-align:top;height:100%"><div id="help-frame"><iframe id="help-iframe" src="javascript:;" scrolling="auto" frameborder="0"></iframe></div></td>
		</tr>
	</table>
</div>