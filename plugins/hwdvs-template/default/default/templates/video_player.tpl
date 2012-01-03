{* 
//////
//    @version [ Nightly Build ]
//    @package hwdVideoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

{if $playerAlign eq 'N'}
    {include file='video_player_n.tpl'}
{elseif $playerAlign eq 'R'}
    {include file='video_player_r.tpl'}
{elseif $playerAlign eq 'C'}
    {include file='video_player_c.tpl'}
{else}
    {include file='video_player_l.tpl'}
{/if}
