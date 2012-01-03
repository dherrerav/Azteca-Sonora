<?php
/**
 * @version		$Id: sliders.php 21007 2011-03-22 13:23:21Z infograf768 $
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Utility class for Sliders elements
 *
 * @static
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @since		1.6
 */
abstract class JHtmlSliders
{

	/**
	 * Creates a panes and loads the javascript behavior for it.
	 *
	 * @param	string	The pane identifier.
	 * @param	array	An array of options.
	 * @return	string
	 * @since	1.6
	 */
	public static function start($group = 'sliders', $params = array())
	{
		self::_loadBehavior($group,$params);
		return '<div id="'.$group.'" class="pane-sliders"><div style="display:none;"><div>';
	}

	/**
	 * Close the current pane.
	 *
	 * @return	string
	 * @since	1.6
	 */
	public static function end()
	{
		return '</div></div></div>';
	}

	/**
	 * Begins the display of a new panel.
	 *
	 * @param	string	Text to display.
	 * @param	string	Identifier of the panel.
	 * @return	string
	 * @since	1.6
	 */
	public static function panel($text, $id)
	{
		return '</div></div><div class="panel"><h3 class="pane-toggler title" id="'.$id.'"><a href="javascript:void(0);"><span>'.$text.'</span></a></h3><div class="pane-slider content">';
	}

	/**
	 * Load the JavaScript behavior.
	 *
	 * @param	string	The pane identifier.
	 * @param	array	Array of options.
	 * @return	void
	 * @since	1.6
	 */
	protected static function _loadBehavior($group, $params = array())
	{
		static $loaded=array();
		if (!array_key_exists($group,$loaded))
		{
			$loaded[$group] = true;
			// Include mootools framework.
			JHtml::_('behavior.framework', true);

			$document = JFactory::getDocument();

			$display = (isset($params['startOffset']) && isset($params['startTransition'])  && $params['startTransition']) ? (int)$params['startOffset'] : null;
			$show = (isset($params['startOffset']) && !(isset($params['startTransition']) && $params['startTransition'])) ? (int)$params['startOffset'] : null;
			$options = '{';
			$opt['onActive']		= "function(toggler, i) {toggler.addClass('pane-toggler-down');toggler.removeClass('pane-toggler');i.addClass('pane-down');i.removeClass('pane-hide');Cookie.write('jpanesliders_".$group."',$$('div#".$group.".pane-sliders > .panel > h3').indexOf(toggler));}";
			$opt['onBackground']	= "function(toggler, i) {toggler.addClass('pane-toggler');toggler.removeClass('pane-toggler-down');i.addClass('pane-hide');i.removeClass('pane-down');if($$('div#".$group.".pane-sliders > .panel > h3').length==$$('div#".$group.".pane-sliders > .panel > h3.pane-toggler').length) Cookie.write('jpanesliders_".$group."',-1);}";
			$opt['duration']		= (isset($params['duration'])) ? (int)$params['duration'] : 300;
			$opt['display']			= (isset($params['useCookie']) && $params['useCookie']) ? JRequest::getInt('jpanesliders_' . $group, $display, 'cookie') : $display ;
			$opt['show']			= (isset($params['useCookie']) && $params['useCookie']) ? JRequest::getInt('jpanesliders_' . $group, $show, 'cookie') : $show ;
			$opt['opacity']			= (isset($params['opacityTransition']) && ($params['opacityTransition'])) ? 'true' : 'false' ;
			$opt['alwaysHide']		= (isset($params['allowAllClose']) && (!$params['allowAllClose'])) ? 'false' : 'true';
			foreach ($opt as $k => $v)
			{
				if ($v) {
					$options .= $k.': '.$v.',';
				}
			}
			if (substr($options, -1) == ',') {
				$options = substr($options, 0, -1);
			}
			$options .= '}';

			$js = "window.addEvent('domready', function(){ new Fx.Accordion($$('div#".$group.".pane-sliders > .panel > h3.pane-toggler'), $$('div#".$group.".pane-sliders > .panel > div.pane-slider'), ".$options."); });";

			$document->addScriptDeclaration($js);
		}
	}
}
