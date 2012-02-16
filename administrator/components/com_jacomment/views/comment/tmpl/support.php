<?php
/*
# ------------------------------------------------------------------------
# JA Comments component for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
 // Check to ensure this file is included in Joomla! 

 defined('_JEXEC') or die( 'Restricted access' ); 
 ?>
<fieldset class="adminform TopFieldset">
	<?php echo $this->menu();?>
</fieldset>
<br/>
<form name="adminForm" action="index.php" method="post" enctype="multipart/form-data">
	<div id="Documents">
		<div class="box">
			<h2><?php echo JText::_('DOCUMENTS' ); ?></h2>	
			<div class="box_content">
				<table width="100%">
					<tr>
						<td width="80%" valign="top">
							Customer support is our top priority, with a valid license, you can always get help via one of follow options:
							<ul>
								<li>Wiki &amp; Documentation (<a href="http://wiki.joomlart.com" title="Click here to go to Wiki &amp; Documentation">http://wiki.joomlart.com</a>)</li>		
								<li>JA Voice Forum (<a href="http://www.joomlart.com/forums/forumdisplay.php?f=162" title="Click here to go to JA Voice Forum">http://www.joomlart.com/forums/forumdisplay.php?f=157</a>)</li>
								<li>Send us an email to jacomment@joomlart.com (please include your email, licensed domain or license key)</li>					
							</ul>						
							We will try our best to get back to you within 24 hours (9:00AM - 5:00PM, Monday - Friday GMT +8)						
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</form>
