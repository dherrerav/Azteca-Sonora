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
$profiles = T3Common::get_profiles ();
$currprofiles = T3Common::get_default_profile() ;
if (count ($profiles) < 2) return;
?>

<h3><?php echo JText::_('PROFILE')?></h3>

<div class="ja-box-usertools">
  <ul class="ja-usertools-profile clearfix">
  <?php foreach ($profiles as $profile) : 
	if (strtolower($profile) == 'home') continue; //ignore Home profile 
  ?>
  	<li class="profile <?php echo ($profile == $currprofiles)?'profile-active':'' ?>">
  	<input type="radio" id="user_profile_<?php echo $profile ?>" name="user_profile" value="<?php echo $profile ?>" <?php echo ($profile == $currprofiles)?'checked="checked"':'' ?> />
  	<label for="user_profile_<?php echo $profile ?>" title="<?php echo $profile ?>"><span><?php echo $profile ?></span>
  	</label></li>	
  <?php endforeach; ?>
  </ul>
</div>