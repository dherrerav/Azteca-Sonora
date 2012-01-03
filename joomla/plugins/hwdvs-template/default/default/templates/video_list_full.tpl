{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

<div class="box">
	{if $hwdvsTemplateOverride.show_thumbnail eq 1}
		<div class="listThumbnail" {if $hwdvsTemplateOverride.wrapText eq 1}style="float:left;"{/if}>
			{$data->thumbnail}
		</div>
		{if $hwdvsTemplateOverride.wrapText eq 0}<div style="clear:both;height:3px;"></div>{/if}
	{/if}
	{if $hwdvsTemplateOverride.show_avatar eq 1}
		<div style="float:right;">{$data->avatar}</div>
	{/if}
	<div>
		{if $hwdvsTemplateOverride.show_title eq 1}
			<div><strong>{$data->title}</strong> {$data->editvideo} {$data->deletevideo} {$data->publishvideo} {$data->approvevideo}</div>
		{/if}
		{if $hwdvsTemplateOverride.show_views eq 1}
			<div style="font-style:italic;font-size:90%;">{$data->views} {$smarty.const._HWDVIDS_INFO_VIEWS}</div>
		{/if}
		{if $hwdvsTemplateOverride.show_category eq 1}
			<div>{$smarty.const._HWDVIDS_INFO_CATEGORY}: {$data->category}</div>
		{/if}		
		{if $hwdvsTemplateOverride.show_rating eq 1 and $data->showrating}
			<div>{$data->rating}</div>
		{/if}			
		{if $hwdvsTemplateOverride.show_uploader eq 1}
			<div>{$data->uploader}</div>
		{/if}		
		{if $hwdvsTemplateOverride.show_description eq 1}
			<div>{$data->description}</div>
		{/if}
		{if $hwdvsTemplateOverride.show_tags eq 1}
			<div>{$data->tags}</div>
		{/if}
		{if $hwdvsTemplateOverride.show_duration eq 1}
			<div>{$data->duration}</div>
		{/if}
		{if $hwdvsTemplateOverride.show_upload_date eq 1}
			<div>{$data->upload_date}</div>
		{/if}
		{if $hwdvsTemplateOverride.show_comments eq 1}
			<div>{$data->comments} {$smarty.const._HWDVIDS_COMMENTS}</div>
		{/if}
		{if $hwdvsTemplateOverride.show_timesince eq 1}
			<div>{$data->timesince}</div>
		{/if}		
	</div>
	<div style="clear:both;"></div>
</div>
