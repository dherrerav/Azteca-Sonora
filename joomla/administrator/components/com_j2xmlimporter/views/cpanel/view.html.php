<?php
/**
 * models/cpanel/view.html.php
 *
 * @package		J2XMLImporter
 * @subpackage	com_j2xmlimporter
 * @version		1.6.0
 * @since		File available since Release 1.5.3
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XMLImporter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

jimport('joomla.application.component.view');
jimport('joomla.html.pane');

class J2XMLImporterViewCpanel extends JView
{
	function display($tpl = null)
	{
		$pane 	=& JPane::getInstance('sliders');

		$this->assignRef('pane', $pane);
		$this->assignRef('info', $this->get('Info'));
		
		$params = &JComponentHelper::getParams('com_j2xmlimporter');
		$this->assignRef('params', $params);
		
		$this->addToolbar();
		parent::display($tpl);
	}

	function _quickiconButton( $link, $image, $text, $path=null, $target='', $onclick='' ) {
		$app = JFactory::getApplication('administrator');
		if( $target != '' ) {
	 		$target = 'target="' .$target. '"';
	 	}
	 	if( $onclick != '' ) {
	 		$onclick = 'onclick="' .$onclick. '"';
	 	}
	 	if( $path === null || $path === '' ) {
			$template = $app->getTemplate();
	 		$path = '/templates/'. $template .'/images/header/';
	 	}

	 	$lang = & JFactory::getLanguage();
		?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $link; ?>" <?php echo $target;?>  <?php echo $onclick;?>>
					<?php echo JHTML::_('image.administrator', $image, $path, NULL, NULL, $text ); ?>
					<span><?php echo $text; ?></span>
				</a>
			</div>
		</div>
		<?php 
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/j2xmlimporter.php';
		$canDo	= J2XMLImporterHelper::getActions();
		
		$toolbar =& JToolBar::getInstance('toolbar');
		$toolbar->addButtonPath(JPATH_COMPONENT.DS.'buttons');
		$toolbar->loadButtonType('Import', true);
		$toolbar->loadButtonType('Help2', true);
		
		$doc =& JFactory::getDocument();
		$icon_48_j2xml = " .icon-48-j2xml {background:url(components/com_j2xmlimporter/assets/images/header/icon-48-j2xmlimporter.png) no-repeat; }"; 
		$doc->addStyleDeclaration($icon_48_j2xml);
		$icon_32_import = " .icon-32-j2xml-import {background:url(components/com_j2xmlimporter/assets/images/toolbar/icon-32-import.png) no-repeat; }"; 
		$doc->addStyleDeclaration($icon_32_import);
		
		JToolBarHelper::title(JText::_('COM_J2XMLIMPORTER_TOOLBAR_J2XML'), 'j2xml.png');
		if ($canDo->get('core.create') || ($canDo->get('core.edit'))) {
			$toolbar->appendButton('Import', 'j2xml-import', 'COM_J2XMLIMPORTER_BUTTON_IMPORT', 'cpanel.import');
			JToolBarHelper::divider();
		}	
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_j2xmlimporter');
			JToolBarHelper::divider();
		}		
		$toolbar->appendButton('Help2', 'Help', 'COM_J2XMLIMPORTER_BUTTON_HELP', 'screen.j2xml');		
	}
}
?>