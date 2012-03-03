<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TOOLBAR_versions {
	/**
	* Draws the menu for Editing an existing category
	*/
	function _EDIT( $edit) {
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		JArrayHelper::toInteger($cid, array(0));

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JToolBarHelper::title( JText::_( 'Workflow Configuration' ).': <small><small>[ '. $text.' ]</small></small>', 'sections.png' );
		JToolBarHelper::save('saveprefs');
		
		//function custom($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true, $x = false)
		//JToolBarHelper::custom('javascript:alert(\'test\');','test','tetst','test',false,false);
		
		$bar = & JToolBar::getInstance('toolbar');
		
		// Add a preview button
		$href = 'javascript:addRule();';
		$bar->appendButton( 'Link', 'new', 'New Rule', $href );
		
		JToolBarHelper::apply();
		if ( $edit ) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
	}
	

	/**
	* Draws the menu for Editing an existing category
	*/
	function _DEFAULT(){
		JToolBarHelper::title( JText::_( 'Version Manager' ), 'sections.png' );
		JToolBarHelper::deleteList();
	}
}