<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );     
?>
	
	<li class="jac-bbcode-bold-text">
		<a href="#" title="<?php echo JText::_("BOLD_TEXT"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'B');"><?php echo JText::_("B");?></a>	
	</li>
	<li class="jac-bbcode-italic-text">
		<a href="#" title="<?php echo JText::_("ITALIC_TEXT"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'I');"><?php echo JText::_("I");?></a>	
	</li>
	<li class="jac-bbcode-underline-text">
		<a href="#" title="<?php echo JText::_("UNDERLINE_TEXT"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'U');"><?php echo JText::_("U");?></a>	
	</li>
	<li class="jac-bbcode-line-through-text">
		<a href="#" title="<?php echo JText::_("LINE_THROUGH_TEXT"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'S');"><?php echo JText::_("S");?></a>	
	</li>
	<li class="jac-bbcode-bullet-list-text">
		<a href="#" title="<?php echo JText::_("UNORDERED_TEXT"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'UL');"><?php echo JText::_("UL");?></a>	
	</li>		
	<li class="jac-bbcode-quotation">
		<a href="#" title="<?php echo JText::_("QUOTATION"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'QUOTE');"><?php echo JText::_("QUOTE");?></a>	
	</li>
	<li class="jac-bbcode-link">
		<a href="#" title="<?php echo JText::_("LINK_AND_EMAIL_TEXT"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'LINK');"><?php echo JText::_("LINK");?></a>	
	</li>
		<li class="jac-bbcode-image">
		<a href="#" title="<?php echo JText::_("IMAGE"); ?>" onclick="return DCODE.doClick ('<?php echo $textAreaID;?>', 'IMG');"><?php echo JText::_("IMG");?></a>	
	</li>
