{* 
//////
//    @version [ Nightly Build ]
//    @package hwdPhotoShare
//    @copyright (C) 2007 - 2009 Highwood Design
//    @license http://creativecommons.org/licenses/by-nc-nd/3.0/
//////
*}

    {literal}
    <script language="javaScript">
      function goto_browse(form) { 
        var index=form.select_browse.selectedIndex
        if (form.select_browse.options[index].value != "0") {
          location=form.select_browse.options[index].value;
        }
      }
      function goto_sort(form) { 
        var index=form.select_order.selectedIndex
        if (form.select_order.options[index].value != "0") {
          location=form.select_order.options[index].value;
        }
      }
    </script>
    {/literal}                  

    <form name="redirect">
        <select name="select_browse" onchange="goto_browse(this.form)" size="1">
            {if $selectUploads}<option value="{$selectUploadsUrl}" {$selectUploadsSelected}>{$selectUploadsText}</option>{/if}
            {if $selectFavourites}<option value="{$selectFavouritesUrl}" {$selectFavouritesSelected}>{$selectFavouritesText}</option>{/if}
            {if $selectViewed}<option value="{$selectViewedUrl}" {$selectViewedSelected}>{$selectViewedText}</option>{/if}
            {if $selectLiked}<option value="{$selectLikedUrl}" {$selectLikedSelected}>{$selectLikedText}</option>{/if}
            {if $selectDisliked}<option value="{$selectDislikedUrl}=" {$selectDislikedSelected}>{$selectDislikedText}</option>{/if}
            {if $selectGroups}<option value="{$selectGroupsUrl}" {$selectGroupsSelected}>{$selectGroupsText}</option>{/if}
            {if $selectPlaylists}<option value="{$selectPlaylistsUrl}" {$selectPlaylistsSelected}>{$selectPlaylistsText}</option>{/if}
            {if $selectMemberships}<option value="{$selectMembershipsUrl}" {$selectMembershipsSelected}>{$selectMembershipsText}</option>{/if}
            {if $selectSubscriptions}<option value="{$selectSubscriptionsUrl}" {$selectSubscriptionsSelected}>{$selectSubscriptionsText}</option>{/if}
       </select>
    </form>



