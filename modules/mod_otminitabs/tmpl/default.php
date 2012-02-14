<?php
/**===========================================================================================
# mod_otminitabs        OT Mini Tabs module for Joomla 1.7
#=============================================================================================
# author                OmegaTheme.com
# copyright             Copyright (C) 2011 OmegaTheme.com. All rights reserved.
# @license              http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website               http://omegatheme.com
# Technical support     Forum - http://omegatheme.com/forum/
#=============================================================================================*/

/**------------------------------------------------------------------------
* file:           tmpl/default.php 1.7.0 00001, Mar 2011 12:00:00Z OmegaTheme:Linh $
* package:        OT Mini Tabs module
* description:    default layout file
*------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');

if (!function_exists('randomkeys')) {
    function randomkeys($length) {
        $pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $key = '';
        for($i = 0; $i < $length; $i++)    {
            $key .= $pattern{rand(0,strlen($pattern)-1)};
        }
        return $key;
    }
}
$rid = $params->get('unique_id');
if ($rid == ''){
    $rid = randomkeys(16);
}
$style = "
    #ot_{$rid} .tab_selector {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
    
    #ot_{$rid} .tab_selector li {
        display: block;
        float: left;
        margin: 0;
        padding: 0;
        cursor: pointer;
    }
    
    #ot_{$rid} .tab_selector li span {
        padding: 2px 6px;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        line-height: 24px;
    }
    
    #ot_{$rid} .ot-title {
        margin: 0 0 5px;
        line-height: 22px;
    }
    
    /* for prevent default joomla template css */
    #ot_{$rid} .tab_panel ul.menu {
        list-style-type: none;
        padding: 0;
    }
    #ot_{$rid} .tab_panel ul.menu a {
        background-position: 5px 50%;
    }";

$doc->addStyleDeclaration($style);
$doc->addStyleSheet(JURI::root().'modules/mod_otminitabs/css/mod_otminitabs_default.css');
?>
<div class="ot-wrapper" id="ot_<?php echo $rid; ?>">
    <div class="tab_selector_wrapper">
        <ul class="tab_selector">
            <?php
            // tab title
            foreach ($list_of_tabs as $tab) {
                echo '<li class="tab"><span>'.$tab[1].'</span></li>';
            }
            ?>
        </ul>
    </div>
    <div class="tab_panel_wrapper">
    <?php
        // tab content
        foreach ($list_of_tabs as $tab)
        {
            if($tab[0] == 'cat'){
                echo '<div class="tab_panel" style="visibility: hidden; opacity: 0; display: none;">'.
                        $tab[2].
                     '</div>';
            }
            else if($tab[0] == 'mod'){
                echo '<div class="tab_panel" style="visibility: hidden; opacity: 0; display: none;">'.
                        JModuleHelper::renderModule($tab[2]).
                     '</div>';
            }
        }
    ?>
    </div>
    <div class="ot-mini-tabs"><?php echo JText::_('ABOUT_OTMINITABS'); ?></div>
</div>

<script type="text/javascript" charset="utf-8">
window.addEvent('domready',function() {
    var first_tab = document.id("ot_<?php echo $rid; ?>").getElement(".tab");
    if (first_tab != null) first_tab.addClass("open_tab");
    var tab_panel_arr = document.id("ot_<?php echo $rid; ?>").getElements(".tab_panel");
    if (tab_panel_arr != null && tab_panel_arr.length > 0) tab_panel_arr.fade('out',{duration:1000}).removeClass("current_tab").setStyle("display", "none");
    var first_tab_panel = document.id("ot_<?php echo $rid; ?>").getElement(".tab_panel");
    if (first_tab_panel != null) first_tab_panel.fade('in',{duration:2000}).addClass("current_tab").setStyle("display", "block");
    
    document.id("ot_<?php echo $rid; ?>").getElement(".tab_selector").getElements("li.tab").each(function(tab, index){
        var newIdx = index;
        tab.addEvent("click", function(){
            var tab_panel_arr = document.id("ot_<?php echo $rid; ?>").getElements(".tab_panel");
            if (tab_panel_arr != null && tab_panel_arr.length > 0)
            {
                tab_panel_arr.filter(function(item, index){
                    return item.hasClass("current_tab");
                }).fade('out',{duration:1000}).removeClass("current_tab").setStyle("display", "none");
                
                tab_panel_arr[newIdx].setStyle("display", "block").fade('in',{duration:2000}).addClass("current_tab");
            }
            document.id("ot_<?php echo $rid; ?>").getElements(".tab").removeClass("open_tab");
            this.addClass("open_tab");
        });
    });
});
</script>
