<?php
/**
 * @package      JCE Media Manager - JCE Media Player
 * @copyright 	Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license 		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see licence.txt
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined( '_WF_EXT' ) or die( 'RESTRICTED' );
?>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<td>
			<input type="checkbox" id="youtube_embed" />
			<label for="youtube_embed" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_EMBED_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_EMBED')?></label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" id="youtube_related" checked="checked" />
			<label for="youtube_related" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_RELATED_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_RELATED')?></label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" id="youtube_https" />
			<label for="youtube_https" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_HTTPS_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_HTTPS')?></label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" id="youtube_privacy" />
			<label for="youtube_privacy" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_PRIVACY_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_PRIVACY')?></label>
		</td>
	</tr>

	<tr>
		<td>
			<input type="checkbox" id="youtube_autoplay" />
			<label for="youtube_autoplay" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_AUTOPLAY_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_AUTOPLAY')?></label>
		</td>
	</tr>
	<tr>
		<td>
			<label for="youtube_autohide" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_AUTOHIDE_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_AUTOHIDE')?></label>
			<select id="youtube_autohide">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2" selected="selected">2</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" id="youtube_loop" />
			<label for="youtube_loop" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_LOOP_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_LOOP')?></label>
		</td>
	</tr>
	<tr>
		<td>
			<label for="youtube_playlist" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_PLAYLIST_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_PLAYLIST')?></label>
			<input type="text" id="youtube_playlist" size="50" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="youtube_start" title="<?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_START_DESC')?>" class="tooltip"><?php echo WFText::_('WF_AGGREGATOR_YOUTUBE_START')?></label>
			<input type="text" id="youtube_start" size="10" pattern="[0-9]+" />
		</td>
	</tr>
</table>