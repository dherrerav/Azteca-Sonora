<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
JPluginHelper::importPlugin('acymailing');
$dispatcher = &JDispatcher::getInstance();
$typesFilters = array();
$outputFilters = implode('',$dispatcher->trigger('onAcyDisplayFilters',array(&$typesFilters,'mail')));
if(empty($typesFilters)) return;
$js = "var numFilters = 0;
		function addAcyFilter(){
			var newdiv = document.createElement('div');
			newdiv.id = 'filter'+numFilters;
			newdiv.className = 'plugarea';
			newdiv.innerHTML = '';
			if(numFilters > 0) newdiv.innerHTML += '".JText::_('FILTER_AND')."';
			newdiv.innerHTML += document.getElementById('filters_original').innerHTML.replace(/__num__/g, numFilters);
			if(document.getElementById('allfilters')){
				document.getElementById('allfilters').appendChild(newdiv); updateFilter(numFilters); numFilters++;
			}
		}
		function countresults(num){ return; }
		function updateFilter(filterNum){
				currentFilterType =window.document.getElementById('filtertype'+filterNum).value;
				if(!currentFilterType){
					window.document.getElementById('filterarea_'+filterNum).innerHTML = '';
					document.getElementById('countresult_'+filterNum).innerHTML = '';
					return;
				}
				filterArea = 'filter__num__'+currentFilterType;
				window.document.getElementById('filterarea_'+filterNum).innerHTML = window.document.getElementById(filterArea).innerHTML.replace(/__num__/g,filterNum);
			}";
$doc =& JFactory::getDocument();
$doc->addScriptDeclaration($js);
$js = '';
$datatype = "filter";
$jsFunction = "addAcyFilter";
if(!empty($this->mail->$datatype)){
	foreach($this->mail->{$datatype}['type'] as $num => $oneType){
		if(empty($oneType)) continue;
		$js .= "while(!document.getElementById('".$datatype."type$num')){".$jsFunction."();}
				document.getElementById('".$datatype."type$num').value= '$oneType';
				update".ucfirst($datatype)."($num);";
		if(empty($this->mail->{$datatype}[$num][$oneType])) continue;
		foreach($this->mail->{$datatype}[$num][$oneType] as $key => $value){
			$js .= "document.adminForm.elements['".$datatype."[$num][$oneType][$key]'].value = '".addslashes(str_replace(array("\n","\r"),' ',$value))."';";
			$js .= "if(document.adminForm.elements['".$datatype."[$num][$oneType][$key]'].type && document.adminForm.elements['".$datatype."[$num][$oneType][$key]'].type == 'checkbox'){ document.adminForm.elements['".$datatype."[$num][$oneType][$key]'].checked = 'checked'; }";
		}
		if($datatype == 'filter') $js.= " countresults($num);";
	}
}
$doc->addScriptDeclaration( "window.addEvent('domready', function(){ $js });" );
$typevaluesFilters = array();
$typevaluesFilters[] = JHTML::_('select.option', '',JText::_('FILTER_SELECT'));
foreach($typesFilters as $oneType => $oneName){
	$typevaluesFilters[] = JHTML::_('select.option', $oneType,$oneName);
}
?>
<br/>
<div class="acy_filter_mail">
<input type="hidden" name="data[mail][filter]" value="" />
<div style="display:none">
	<div id="filters_original">
		<?php echo JHTML::_('select.genericlist',   $typevaluesFilters, "filter[type][__num__]", 'class="inputbox" size="1" onchange="updateFilter(__num__);countresults(__num__);"', 'value', 'text','filtertype__num__');?>
		<span id="countresult___num__"></span>
		<div class="acyfilterarea" id="filterarea___num__"></div>
	</div>
	<?php echo $outputFilters; ?>
</div>
<?php echo JText::_('RECEIVER_LISTS').' '.JText::_('RECEIVER_FILTER'); ?>
<fieldset class="adminform" >
<legend><?php echo JText::_( 'ACY_FILTERS' ); ?></legend>
<div id="allfilters"></div>
<button onclick="addAcyFilter();return false;"><?php echo JText::_('ADD_FILTER'); ?></button>
</fieldset>
</div>