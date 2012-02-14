<?php
/**
 * ------------------------------------------------------------------------
 * JA T3 System Plugin for Joomla 2.5
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die;
?>
<?php if (($jamenu = $this->loadMenu('handheld'))) $jamenu->genMenu (); ?>

<?php if($this->countModules('search')) : ?>
<div id="ja-search">
    <jdoc:include type="modules" name="search" />
</div>
<?php endif; ?>