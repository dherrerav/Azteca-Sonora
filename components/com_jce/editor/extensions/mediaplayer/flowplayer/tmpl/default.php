<?php 
defined( '_WF_EXT' ) or die( 'Restricted access' );
$vars = array(
	'accelerated'			=> false,
	'autoPlay' 				=> true,
	'autoBuffering' 		=> false,
	'bufferLength' 			=> 3,
	'baseUrl'				=> '',
	'connectionProvider'	=> '',
	'cuepointMultiplier'	=> 1000,
	'controls'				=> '',
	'cuepoints'				=> '',
	'duration'				=> 0,
	'extension'				=> '',
	'fadeInSpeed'			=> 1000,
	'fadeOutSpeed'			=> 1000,
	'image'					=> false,
	'linkUrl'				=> '',
	'linkWindow'			=> '_self',
	'live'					=> false,
	'metaData'				=> '',
	'scaling'				=> 'scale',
	'start'					=> 0
);

?>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="flowplayer_autoPlay" checked="checked" /></td>
					<td><label for="flowplayer_autoPlay"><?php echo WFText::_('autoPlay');?></label></td>
				</tr>
			</table>
		</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="flowplayer_accelerated" /></td>
					<td><label for="flowplayer_accelerated"><?php echo WFText::_('accelerated');?></label></td>
				</tr>
			</table>
		</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="flowplayer_autoBuffering" /></td>
					<td><label for="flowplayer_autoBuffering"><?php echo WFText::_('autoBuffering');?></label></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	    <td>
	    	<label for="flowplayer_bufferLength"><?php echo WFText::_('buffer');?></label>
			<input type="text" size="3" id="flowplayer_bufferLength" value="" />
		</td>
	    <td>
	    	<label for="flowplayer_cuepointMultiplier"><?php echo WFText::_('cuepointMultiplier');?></label>
			<input type="text" size="5" id="flowplayer_cuepointMultiplier" value="" />
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	    <td colspan="2">
	    	<label for="flowplayer_connectionProvider"><?php echo WFText::_('connectionProvider');?></label>
			<input type="text" id="flowplayer_connectionProvider" value="" />
		</td>
	</tr>
	<tr>
	    <td>
	    	<label for="flowplayer_cuepointMultiplier"><?php echo WFText::_('cuepointMultiplier');?></label>
			<input type="text" id="flowplayer_cuepointMultiplier" value="" />
		</td>
	</tr>
	<tr>
	    <td colspan="3">
	    	<label for="flowplayer_baseUrl"><?php echo WFText::_('baseUrl');?></label>
			<input type="text" id="flowplayer_baseUrl" value="" />
		</td>
	</tr>
</table>