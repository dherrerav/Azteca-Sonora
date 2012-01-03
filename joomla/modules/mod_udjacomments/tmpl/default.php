<?php
/**
 * @author Andy Sharman
 * @copyright Andy Sharman (www.udjamaflip.com)
 * @link http://www.udjamaflip.com
 * @license GNU/GPL V2+
 * @version 1.0rc1
 * @package mod_udjacomments
**/ 

// no direct access
defined('_JEXEC') or die;
?>

<noscript>
	<h4 class="noscriptError"><?php echo JText::_('MOD_UDJACOMMENTS_NOJS_ERROR')?></h4>
</noscript>

<div id="udjaCommentsWrapper">
<?php

if ($helper->getFormPosition() == 'top')
{
	if ($displayForm) { require JModuleHelper::getLayoutPath('mod_udjacomments', 'default_form'); }
	require JModuleHelper::getLayoutPath('mod_udjacomments', 'default_list');
	require JModuleHelper::getLayoutPath('mod_udjacomments', 'default_pagination');
}
else
{
	require JModuleHelper::getLayoutPath('mod_udjacomments', 'default_list');
	require JModuleHelper::getLayoutPath('mod_udjacomments', 'default_pagination');
	if ($displayForm) { require JModuleHelper::getLayoutPath('mod_udjacomments', 'default_form'); }
}

if ($params->get('display_backlink'))
{
	echo '<p class="backlink"><a href="http://www.udjamaflip.com/" title="Udja Comments by Andy Sharman\'s Udjamaflip.com"><small>Udja Comments by Andy Sharman</small></a></p>';
}

?>
</div>