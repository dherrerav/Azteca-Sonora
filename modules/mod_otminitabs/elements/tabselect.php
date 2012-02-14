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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.html.parameter');

class JFormFieldTabSelect extends JFormField
{
    protected $type = 'TabSelect'; //the form field type
    
    protected function getInput()
    {
        // Initialize variables.
        $html = array();
        $attr = '';
        $finalHtml = '';
        
        //get saved params from database
        $db =& JFactory::getDBO();
        $currentModId = JRequest::getVar('id');
        $sql = "SELECT `params` FROM `#__modules` WHERE `id` = $currentModId";
        $db->setQuery($sql);
        $data = $db->loadResult();
        $params = new JParameter($data);
        $tabTypeSelected = $params->get('tab_type', 'mID');
        $modTypeSelected = $params->get('module_type');
        
        $tabSelected = trim($params->get('tab_selection'));
        
        $tmpSelected = array();
        
        // get categories for latter use
        $queryModId = "SELECT * FROM `#__modules` WHERE `published` = 1 AND `id` <> $currentModId AND `client_id` = 0 ORDER BY `module`";
        $db->setQuery($queryModId);
        $db->getQuery();
        $mods = $db->loadObjectList();
        
        $modIds = '';
        $modTitles = '';
        $modTypes = '';
        if ($mods && !empty($mods))
        {
            foreach ($mods as $idx => $mod)
            {
                $modIds .= $idx==0 ? '"mod_'.$mod->id.'"' : ',"mod_'.$mod->id.'"';
                $modTypes .= $idx==0 ? '"'.$mod->module.'"' : ',"'.$mod->module.'"';
                $modTitles .= $idx==0 ? '"'.$mod->title.'"' : ',"'.$mod->title.'"';
            }
        }
        unset($idx);
        
        // get categories for latter use
        $cateIds = '';
        $cateTitles = '';
        $queryCateId = "SELECT `id`, `path`, `extension`, `title`, `alias`  FROM `#__categories` WHERE `published` = 1 AND `extension` = 'com_content' ORDER BY `title`";
        $db->setQuery($queryCateId);
        $db->getQuery();
        $cates = $db->loadObjectList();
        if ($cates && !empty($cates))
        {
            foreach($cates as $idx => $cate)
            {
                $cateIds .= $idx==0 ? '"cat_'.$cate->id.'"' : ',"cat_'.$cate->id.'"';
                $cateTitles .= $idx==0 ? '"'.$cate->title.'"' : ',"'.$cate->title.'"';
            }
        }
        
        // use JHtml::categories() to generate better look select
        $cateOptions = JHtml::_('category.options', 'com_content', array(0, 1));
        
        // Initialize some field attributes.
        $attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
        
        // To avoid user's confusion, readonly="true" should imply disabled="true".
        if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {
            $attr .= ' disabled="disabled"';
        }
        
        $attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : ' size="'.count($cateOptions).'"';
        $attr .= $this->multiple ? ' multiple="multiple"' : '';
        
        $html[] ='
        <div style="clear: both; overflow: hidden;">
        <table width="96%" border="0" cellpadding="0" cellspacing="2">
            <tbody>
                <tr bgcolor="#F8F8F8">
                    <td>'.JText::_('MOD_OT_MINI_TABS_AVAILABLE_LIST').'</td>
                    <td>'.JText::_('MOD_OT_MINI_TABS_ACTION').'</td>
                    <td>'.JText::_('MOD_OT_MINI_TABS_SELECTED_LIST').'</td>
                    <td>'.JText::_('MOD_OT_MINI_TABS_SORT').'</td>
                </tr>
                <tr>
                    <td>'.
                        JHtml::_('select.genericlist', $cateOptions, 'jform_params_tab_select_available', trim($attr), 'value', 'text', $this->value, 'jform_params_tab_select_available').
                        JHtml::_('select.genericlist', $cateOptions, 'jform_params_tab_select_available_hidden', trim($attr), 'value', 'text', $this->value, 'jform_params_tab_select_available_hidden').
                    '</td>
                    <td>
                        <input class="button" type="button" value="'.JText::_('MOD_OT_MINI_TABS_ADD').'" id ="add_tab_item" name="AddTab" />
                        <br style="clear: both;" />
                        <input class="button" type="button" value="'.JText::_('MOD_OT_MINI_TABS_REMOVE').'" id ="remove_tab_item" name="RemoveTab" />
                    </td>
                    <td>'.
                        JHtml::_('select.genericlist', $tmpSelected, $this->name, trim($attr), 'value', 'text', $this->value, $this->id).
                    '</td>
                    <td>
                        <input class="button" type="button" value="'.JText::_('MOD_OT_MINI_TABS_MOVE_UP').'" id ="tab_item_up" name="TabUp" />
                        <br style="clear: both;" />
                        <input class="button" type="button" value="'.JText::_('MOD_OT_MINI_TABS_MOVE_DOWN').'" id ="tab_item_down" name="TabDown" />
                    </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
            </tbody>
        </table>
        </div>';
        
        $finalHtml .= implode($html);
        $finalHtml .= '<script type="text/javascript">
                            var modIdArr = new Array('.$modIds.');
                            var modTypeArr = new Array('.$modTypes.');
                            var modTitleArr = new Array('.$modTitles.');
                            var cateIdArr = new Array('.$cateIds.');
                            var cateTitleArr = new Array('.$cateTitles.');
                            var availableMods = new Array();
                            var tmpArrAvail = new Array();
                            var preCfgSelected = new Array('.$tabSelected.');
                        </script>';
                
        $finalHtml .= '
            <script type="text/javascript">
                window.addEvent("domready", function(){
                
                    document.id("jform_params_tab_select_available_hidden").setStyle("display", "none");
                    
                    var container_selected = document.id("jform_params_tab_select");
                    for(var i = 0; i < preCfgSelected.length; i++)
                    {
                        var match = cateIdArr.indexOf(preCfgSelected[i]);
                        if(match != -1)
                        {
                            var option = document.createElement("option");
                            option.value = preCfgSelected[i];
                            option.innerHTML = "cate | "+cateTitleArr[match];
                            container_selected.appendChild(option);
                        }
                        var match = modIdArr.indexOf(preCfgSelected[i]);
                        if(match != -1)
                        {
                            var option = document.createElement("option");
                            option.value = preCfgSelected[i];
                            option.innerHTML = "mod | "+modTitleArr[match];
                            option.set("class","mod_opt")
                            container_selected.appendChild(option);
                        }
                    }
                    var tab_type = document.id("jform_params_tab_type");
                    if (tab_type != null)
                    {
                        var selected_types = tab_type.getSelected();
                        var module_type_select = document.id("jform_params_module_type");
                        
                        if (selected_types[0].value == "cID" && module_type_select != null) {
                            module_type_select.set("disabled", true);
                            showCates();
                        }
                        else if (selected_types[0].value == "mID" && module_type_select != null){
                            module_type_select.set("disabled", false);
                            showModulesThisType(module_type_select.value);
                        }
                        
                        module_type_select.addEvent("change", function(){
                            showModulesThisType(this.value);
                        });
                                
                        tab_type.addEvent("change", function(){
                            var selected_types = this.getSelected();
                            
                            if (selected_types[0].value == "cID" && module_type_select != null) {
                                module_type_select.set("disabled", true);
                                showCates();
                            } else {
                                module_type_select.set("disabled", false);
                                showModulesThisType(module_type_select.value);
                            }
                        });
                    }
                });
                
                
                //show cac module voi dau vao la module type
                var showModulesThisType = function(type){
                    var j = 0;
                    availableMods.length = 0;
                    document.id("jform_params_tab_select_available").empty();
                    var list_selected = document.id("jform_params_tab_select").options;
                    var list_selected_id = new Array();
                    for(var j = 0; j < list_selected.length; j++)
                    {
                        list_selected_id[j] = list_selected[j].value;
                    }
                    for (var i = 0; i < modTypeArr.length; i++)
                    {
                        if (modTypeArr[i] == type)
                        {
                            // neu module chua co trong selected list thi moi hien ra
                            if (list_selected_id.indexOf(modIdArr[i]) == -1)
                            {
                                availableMods[j] = new Array(modTypeArr[i], modIdArr[i], modTitleArr[i]);
                                var option = document.createElement("option");
                                option.value = modIdArr[i];
                                option.innerHTML = modTitleArr[i];
                                option.set("class","mod_opt")
                                document.id("jform_params_tab_select_available").appendChild(option);
                            }
                        }
                        j++;
                    }
                };
                
                //showCates
                var showCates = function(){
                    var container_available = document.id("jform_params_tab_select_available");
                    var available_cates = document.id("jform_params_tab_select_available_hidden").options;
                    container_available.empty();
                    var list_selected = document.id("jform_params_tab_select").options;
                    var list_selected_id = new Array();
                    for(var j = 0; j < list_selected.length; j++)
                    {
                        list_selected_id[j] = list_selected[j].value;
                    }
                    
                    for( var i = 0; i < available_cates.length; i++)
                    {
                        if (list_selected_id.indexOf("cat_"+available_cates[i].value) == -1)
                        {
                            var option = document.createElement("option");
                            option.value = "cat_"+available_cates[i].value;
                            option.innerHTML = available_cates[i].innerHTML;
                            container_available.appendChild(option);
                        }
                    }
                };
                
                //save selected mod and cate to hidden input
                var save_list = function(){
                    var list_selected = document.id("jform_params_tab_select").options;
                    var hidden_container_selected = document.id("jform_params_tab_selection");
                    hidden_container_selected.value = "";
                    for (var i = 0; i < list_selected.length; i++)
                    {
                        if (hidden_container_selected.value == ""){
                            hidden_container_selected.value += "\""+list_selected[i].value+"\"";
                        }
                        else{
                            hidden_container_selected.value += ",\""+list_selected[i].value+"\"";
                        }
                        
                    }
                };
                
                //refreshAvailbleList
                var refreshAvailbleList = function(type){
                    (type == "mID") ? showModulesThisType(document.id("jform_params_module_type").value) : showCates();                    
                };
                
                // add button
                document.id("add_tab_item").addEvent("click", function(){
                    var container_available = document.id("jform_params_tab_select_available");
                    var container_selected = document.id("jform_params_tab_select");
                    var select_list = document.id("jform_params_tab_select_available").getSelected();
                    var tab_type = document.id("jform_params_tab_type").value;
                    for (var i = 0; i < select_list.length; i ++)
                    {
                        var option = document.createElement("option");
                        option.value = select_list[i].value;
                        option.innerHTML = ((tab_type=="mID")?"mod | ":"cate | ")+select_list[i].innerHTML;
                        
                        container_selected.appendChild(option);
                    }
                    save_list();
                    refreshAvailbleList(tab_type);
                });
                
                //remove button
                document.id("remove_tab_item").addEvent("click", function(){
                    var container = document.id("jform_params_tab_select");
                    var select_to_remove = document.id("jform_params_tab_select").getSelected();
                    var tab_type = document.id("jform_params_tab_type").value;
                    for (var i = 0; i < select_to_remove.length; i ++)
                    {
                        container.removeChild(select_to_remove[i]);
                    }
                    save_list();
                    refreshAvailbleList(tab_type);
                });
                
                //move up button
                document.id("tab_item_up").addEvent("click", function(){
                    var list_selected = document.id("jform_params_tab_select").options;
                    for( var i = 0; i < list_selected.length; i++)
                    {
                        if (i != 0 && list_selected[i].selected == true)
                        {
                            var Opt_tmp1 = new Option(list_selected[i-1].innerHTML, list_selected[i-1].value);
                            var Opt_tmp2 = new Option(list_selected[i].innerHTML, list_selected[i].value);
                            list_selected[i-1] = Opt_tmp2;
                            list_selected[i-1].selected = true;
                            list_selected[i] = Opt_tmp1;
                        }
                    }
                    save_list();
                });
                
                //move down button
                document.id("tab_item_down").addEvent("click", function(){
                    var list_selected = document.id("jform_params_tab_select").options;
                    for( var i = list_selected.length - 1; i >= 0 ; i--)
                    {
                        if (i != (list_selected.length - 1) && list_selected[i].selected == true)
                        {
                            var Opt_tmp1 = new Option(list_selected[i+1].innerHTML, list_selected[i+1].value);
                            var Opt_tmp2 = new Option(list_selected[i].innerHTML, list_selected[i].value);
                            list_selected[i+1] = Opt_tmp2;
                            list_selected[i+1].selected = true;
                            list_selected[i] = Opt_tmp1;
                        }
                    }
                    save_list();
                });
                
            </script>
        ';
        
        return $finalHtml;
    }
}
