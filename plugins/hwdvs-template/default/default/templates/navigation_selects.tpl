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
    </script>
    {/literal}                  

    <form name="redirect">
        <select name="select_browse" onchange="goto_browse(this.form)" size="1">
            <option value="{$JURL}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=frontpage&sort=recent" {$recent_selected}>{$smarty.const._HWDVIDS_RECENTVIDEOS}</option>
            <option value="{$JURL}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=frontpage&sort=popular" {$popular_selected}>{$smarty.const._HWDVIDS_POPULARVIDEOS}</option>
            <option value="{$JURL}/index.php?option=com_hwdvideoshare&Itemid={$Itemid}&task=frontpage&sort=rated" {$rated_selected}>{$smarty.const._HWDVIDS_RATEDVIDEOS}</option>
        </select>
    </form>



