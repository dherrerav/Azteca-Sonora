<?php
/*
# ------------------------------------------------------------------------
# JA T3 System plugin for Joomla 1.6
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
# Author: J.O.O.M Solutions Co., Ltd
# Websites: http://www.joomlart.com - http://www.joomlancers.com
# ------------------------------------------------------------------------
*/
?>
<?php
//detect view on mobile - show switch to mobile tools
$layout_switcher = $this->loadBlock('usertools/layout-switcher');
if ($layout_switcher) {
	$layout_switcher = '<li class="layout-switcher">'.$layout_switcher.'</li>';
}
?>
<div class="ja-breadcrums">
	<jdoc:include type="module" name="breadcrumbs" />
</div>

<ul class="ja-links">
	<?php echo $layout_switcher ?>
	<li class="top"><a href="<?php echo $this->getCurrentURL();?>#Top" title="<?php echo JText::_("BACK_TO_TOP") ?>"><?php echo JText::_('TOP') ?></a></li>
</ul>

<ul class="no-display">
	<li><a href="<?php echo $this->getCurrentURL();?>#ja-content" title="<?php echo JText::_("SKIP_TO_CONTENT");?>"><?php echo JText::_("SKIP_TO_CONTENT");?></a></li>
</ul>