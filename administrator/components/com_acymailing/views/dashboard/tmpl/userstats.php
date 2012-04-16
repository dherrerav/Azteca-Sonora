<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<script language="JavaScript" type="text/javascript">
     function statsusers(){
		var dataTable = new google.visualization.DataTable();
		dataTable.addRows(<?php echo count($this->statsusers); ?>);
		dataTable.addColumn('string');
		dataTable.addColumn('number','<?php echo JText::_('USERS',true); ?>');
		<?php
		$i = count($this->statsusers)-1;
		foreach($this->statsusers as $oneResult){
			echo "dataTable.setValue($i, 0, '".addslashes(acymailing_getDate(acymailing_getTime($oneResult->subday),JText::_('DATE_FORMAT_LC3')))."'); ";
			echo "dataTable.setValue($i, 1, ".intval(@$oneResult->total)."); ";
			if($i-- == 0) break;
		}
        ?>
        var vis = new google.visualization.ColumnChart(document.getElementById('statsusers'));
        var options = {
        	width:document.documentElement.clientWidth/2,
          height: 300,
          legend:'none'
        };
        vis.draw(dataTable, options);
	}
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(statsusers);
</script>
<div id="statsusers" style="text-align:center;margin-bottom:20px"></div>