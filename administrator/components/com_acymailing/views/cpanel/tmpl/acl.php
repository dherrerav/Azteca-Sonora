<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="page-acl">
<br style="font-size:1px;" />
	<table class="admintable" cellspacing="1">
		<?php
		$acltable = acymailing_get('type.acltable');
		$aclcats['subscriber'] = array('view','manage','delete','export','import');
		$aclcats['lists'] = array('manage','delete','filter');
		$aclcats['newsletters'] = array('manage','delete','send','schedule');
		$aclcats['autonewsletters'] = array('manage','delete');
		$aclcats['campaign'] = array('manage','delete');
		$aclcats['tags'] = array('view');
		$aclcats['templates'] = array('view','manage','delete');
		$aclcats['queue'] = array('manage','delete','process');
		$aclcats['statistics'] = array('manage','delete');
		$aclcats['cpanel'] = array('manage');
		$aclcats['configuration'] = array('manage');
		foreach($aclcats as $category => $actions){ ?>
		<tr>
			<td width="185" class="key" valign="top">
				<?php $trans = JText::_('ACY_'.strtoupper($category));
				if($trans == 'ACY_'.strtoupper($category)) $trans = JText::_(strtoupper($category));
				echo $trans;
				?>
			</td>
			<td>
				<?php echo $acltable->display($category,$actions)?>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>