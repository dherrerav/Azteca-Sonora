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
<?php if (($jamenu = $this->loadMenu())) $jamenu->genMenu (); ?>
<!-- jdoc:include type="menu" level="0" / -->
<?php if ($this->hasSubmenu() && ($jamenu = $this->loadMenu())) : ?>
<div id="ja-subnav" class="clearfix">
<?php $jamenu->genMenu (1); ?>
<!-- jdoc:include type="menu" level="1" / -->
</div>
<?php endif;?>

<ul class="no-display">
    <li><a href="<?php echo $this->getCurrentURL();?>#ja-content" title="<?php echo JText::_("SKIP_TO_CONTENT");?>"><?php echo JText::_("SKIP_TO_CONTENT");?></a></li>
</ul>
