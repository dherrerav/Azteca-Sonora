<?php
		$option	= JRequest::getCmd('option');
		$group = JRequest::getVar ( 'group', '' );
		
		$tabs = '<div class="submenu-box">
						<div class="submenu-pad">
							<ul id="submenu" class="configuration">
								<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=general"';
		if ($group == 'emailtemplates' || $group == '') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';
		$tabs .= JText::_( 'Email Templates' ) . '</a></li>';
								
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=configs&amp;group=comments"';
		if ($group == 'languages') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';		
		$tabs .= JText::_( 'Languages' ) . '</a></li>';
		
		
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=customizes&amp;group=layout"';
		if ($group == 'layout') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';				
		$tabs .= JText::_( 'Layout' ) . '</a></li>';		
		
		$tabs .= '<li><a href="index.php?option=' . $option . '&amp;view=customizes&amp;group=css"';
		if ($group == 'css') {
			$tabs .= ' class="active" ';
		}
		$tabs .= '>';		
		$tabs .= JText::_( 'CSS' ) . '</a></li>';	
				
		$tabs .= '				</ul>
							<div class="clr"></div>
						</div>
					</div>
					<div class="clr"></div>';		
		echo $tabs;
	
?>