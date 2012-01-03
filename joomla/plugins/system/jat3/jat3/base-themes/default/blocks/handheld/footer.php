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
	<div class="ja-navhelper clearfix">
		<div class="ja-breadcrums clearfix">
			<strong>You are here:</strong> <jdoc:include type="module" name="breadcrumbs" /> 
		</div>
		<div class="ja-links clearfix">
			<?php $this->showBlock('usertools/layout-switcher') ?>
			<a href="<?php echo $this->getCurrentURL();?>#Top" title="Back to Top"><strong>Top</strong></a>
		</div>
	</div>

	<div class="ja-copyright">
		<jdoc:include type="modules" name="footer" />
	</div>