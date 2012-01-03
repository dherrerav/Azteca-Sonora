<?php
/**
 * Joomla! 1.5 lacategories
 *
 * @version $Id: la_categories.php 2009-06-29 01:47:01 svn $
 * @author Maverick
 * @package modules
 * @subpackage mod_latest_articles.elements
 * @license GNU/GPL
 *
 * This module displays the latest articles published on the site.
 */
defined('_JEXEC') or die( 'Restricted access' );

class JElementLacategories extends JElement{
    
	var	$_name = 'lacategories';
    function fetchElement($name, $value, &$node, $control_name){

        $db = &JFactory::getDBO();

        $query = "SELECT CONCAT_WS(',',CAST(s.id as char), s.title, CAST(c.id as char), c.title)" .
            " AS line FROM #__categories c LEFT JOIN #__sections s ON c.section = s.id" .
            " WHERE c.published = 1 AND s.published = 1";
        $db->setQuery($query);
        $sec_cats = $db->loadObjectList();

        return $this->getHTML($sec_cats, $name, $value, $node, $control_name);;
    }

    function getHTML($sec_cats, $name, $value, &$node, $control_name){
        $script = "
            <table cellpadding=\"5\" cellspacing=\"0\">
                <tr>
                    <td valign=\"top\">
                        <select size=\"5\" id=\"sSections\" name=\"sSections\" multiple
                            onchange=\"javascript: populateCategories('sSections','sCategories');\"></select>
                    </td>
                    <td valign=\"top\">
                        <select size=\"5\" id=\"sCategories\" name=\"sCategories\" multiple></select>
                    </td>
                </tr>
                <tr>
                    <td valign=\"top\">
                        <input
                            type=\"button\"
                            onclick=\"javascript: doAddRemove('A', 1, 'sSections','tSections');\"
                            value=\"Add Sections\">
                    </td>
                    <td valign=\"top\">
                        <input
                            type=\"button\"
                            onclick=\"javascript: doAddRemove('A', 2, 'sCategories','tCategories');\"
                            value=\"Add Categories\">
                    </td>
                </tr>
                <tr>
                    <td valign=\"top\">
                        <select multiple size=\"5\" id=\"tSections\" name=\"tSections\" multiple></select>
                    </td>
                    <td valign=\"top\">
                        <select size=\"5\" id=\"tCategories\" name=\"tCategories\" multiple></select>
                    </td>
                </tr>
                <tr>
                    <td valign=\"top\">
                        <input
                            type=\"button\"
                            onclick=\"javascript:  doAddRemove('R', 1, 'tSections','sSections');\"
                            value=\"Remove Sections\">
                    </td>
                    <td valign=\"top\">
                        <input
                            type=\"button\"
                            onclick=\"javascript: doAddRemove('R', 2, 'tCategories','sCategories');\"
                            value=\"Remove Categories\">
                    </td>
                </tr>
            </table>
            <input type=\"hidden\" name=\"secids\" id=\"secids\" value=\"\"/>
            <input type=\"hidden\" name=\"catids\" id=\"catids\" value=\"\"/>
            <input type=\"hidden\" name='".$control_name."[".$name."]' id=\"sec_cat_ids\" value='".$value."'/>
            ";
        $script .= "\n<script type=\"text/javascript\">\n";
        $script .= "sourceArray = new Array();\n";
        $i = 0;
        foreach($sec_cats as $sec_cat){
            $script .= "sourceArray[" . $i++ . "] = '" . $sec_cat->line . "';\n";
        }
        $script .= "
            var sectionsTree = null;

            //Section tree object
            function SectionTree(){
                //variables
                this.id = null;
                this.title = null;
                this.categories = null;

                //Setters
                this.setId = setId;
                this.setTitle = setTitle;
                this.setCategories = setCategories;

                //Getters
                this.getId = getId;
                this.getTitle = getTitle;
                this.getCategories = getCategories;
            }

            function CategoryTree(){
                //variables
                this.id = null;
                this.title = null;

                //functions
                this.setId = setId;
                this.setTitle = setTitle;

                //Getters
                this.getId = getId;
                this.getTitle = getTitle;
            }

            function setId(id){
                this.id = id;
            }

            function setTitle(title){
                this.title = title;
            }

            function setCategories(categories){
                this.categories = categories;
            }

            function getId(){
                return this.id;
            }

            function getTitle(){
                return this.title;
            }

            function getCategories(){
                return this.categories;
            }

            function buildTree(sec_cats){
                sections = new Array();
                var flag;
                var category;
                var temp;
                var i,j;

                for(i=0; i< sec_cats.length; i++){
                    temp = sec_cats[i].split(',');
                    flag = false
                    for(j=0; j<sections.length; j++){
                        if(sections[j].getId() == temp[0]){
                            category = new CategoryTree();
                            category.setId(temp[2]);
                            category.setTitle(temp[3]);
                            categories = sections[j].getCategories();
                            categories[categories.length] = category;
                            sections[j].setCategories(categories);
                            flag = true;
                            break;
                        }
                    }

                    if(!flag){
                        categories = new Array();

                        category = new CategoryTree();
                        category.setId(temp[2]);
                        category.setTitle(temp[3]);
                        categories[0] = category;

                        section = new SectionTree();
                        section.setId(temp[0]);
                        section.setTitle(temp[1]);
                        section.setCategories(categories);

                        sections[sections.length] = section;
                    }
                }

                return sections;
            }

            function addItems(source, target, ignore){
                var ids = new Array();
                var i = 0;
                while(source.selectedIndex >= 0){
                    var flag = false;
                    if(!ignore){
                        for(var j=0; j<target.options.length; j++){
                            if(target.options[j].value == source.options[source.selectedIndex].value){
                                flag = true;
                            }
                        }
                    }
                    if(!flag){
                        var option = document.createElement('option');
                        option.value = source.options[source.selectedIndex].value;
                        option.text = source.options[source.selectedIndex].text;
                        ids[i++] = source.options[source.selectedIndex].value;
                        try{
                            target.add(option, null);
                        }catch(ex){
                            target.add(option);
                        }
                    }
                    source.remove(source.selectedIndex);
                }
                return ids;
            }

            function load(){
                var cats, option, i, j, k;
                var sSections = document.getElementById('sSections');
                var tSections = document.getElementById('tSections');
                var tCategories = document.getElementById('tCategories');
                var sec_cats_ids = document.getElementById('sec_cat_ids');
                var sec_cats = sec_cats_ids.value.split('^');

                var sections = ',,';
                var categories = ',,';
                try{
                    sections = sec_cats[0].substr(1,sec_cats[0].length - 2).split(',');
                    categories = sec_cats[1].substr(1,sec_cats[1].length - 2).split(',');
                }catch(err){
                }

                if(!sec_cats[0]){
                    sec_cats[0] = ',';
                }

                if(!sec_cats[1]){
                    sec_cats[1] = ',';
                }
                document.getElementById('secids').value = sec_cats[0];
                document.getElementById('catids').value = sec_cats[1];

                // First build the section tree
                sectionsTree = buildTree(sourceArray);

                // Now populate the main section list by excluding already added sections.
                for(i=0; i<sectionsTree.length; i++){
                    var flag = false;
                    for(j=0; j<sections.length; j++){
                        if(sections[j] == sectionsTree[i].getId()){
                            flag = true;
                            break;
                        }
                    }
                    if(!flag){
                        option = document.createElement('option');
                        option.value = sectionsTree[i].getId();
                        option.text = sectionsTree[i].getTitle();
                        try{
                            sSections.add(option, null);
                        }catch(ex){
                            sSections.add(option);
                        }
                    }
                }

                // Time to populate the list of sections in the selected sections list as well.
                for(i=0; i<sections.length; i++){
                    for(j=0; j<sectionsTree.length; j++){
                        if(sections[i] == sectionsTree[j].getId()){
                            option = document.createElement('option');
                            option.value = sectionsTree[j].getId();
                            option.text = sectionsTree[j].getTitle();
                            try{
                                tSections.add(option, null);
                            }catch(ex){
                                tSections.add(option);
                            }
                        }
                    }
                }
                for(i =0; i<categories.length; i++){
                    flag = false;
                    for(j=0;j<sectionsTree.length; j++){
                        cats = sectionsTree[j].getCategories();
                        for(k=0; k< cats.length; k++){
                            if(categories[i] == cats[k].getId()){
                                option = document.createElement('option');
                                option.value = cats[k].getId();
                                option.text = cats[k].getTitle();
                                try{
                                    tCategories.add(option, null);
                                }catch(ex){
                                    tCategories.add(option);
                                }
                                flag = true;
                                break;
                            }
                        }
                        if(flag){
                            break;
                        }
                    }
                }
            }

            function doAddRemove(action, type, source, target){
                var sourceObj = document.getElementById(source);
                var targetObj = document.getElementById(target);
                var sectionIdsObj = document.getElementById('secids');
                var categoryIdsObj = document.getElementById('catids');
                var sec_cat_ids = document.getElementById('sec_cat_ids');
                var ignore = false;
                if(action == 'R'){
                    ignore = true;
                }
                var result = addItems(sourceObj, targetObj, ignore);
                switch (type) {
                    case 1: //Sections
                        sectionIdsObj.value = updateValues(action, sectionIdsObj.value, result);
                        break;
                    case 2: //Categories
                        categoryIdsObj.value = updateValues(action, categoryIdsObj.value, result);
                        break;
                    default:
                        break;
                }
                sec_cat_ids.value = sectionIdsObj.value + '^' + categoryIdsObj.value;
            }

            function updateValues(action, value, arrValues){
                var tvalue = ',';
                if(typeof value=='undefined' || value == null || value.length < 1){
                    tvalue = ',';
                }else{
                    tvalue = value;
                }
                if(action == 'A'){
                    for(var i=0; i<arrValues.length; i++){
                        tvalue = tvalue + arrValues[i] + ',';
                    }
                    return tvalue;
                }else if(action == 'R'){
                    for(var i=0; i<arrValues.length; i++){
                        tvalue = tvalue.replace(','+arrValues[i]+',',',');
                    }
                    if(tvalue.length < 2){
                        tvalue = ',';
                    }
                    return tvalue;
                }else{
                    return ',';
                }
            }

            function populateCategories(source, target){
                sSections = document.getElementById(source);
                sCategories = document.getElementById(target);
                sCategories.innerHTML = '';
                var sectionId = sSections.options[sSections.selectedIndex].value;
                for(var i = 0; i<sectionsTree.length; i++){
                    if(sectionsTree[i].getId() == sectionId){
                        var categories = sectionsTree[i].getCategories();
                        for(var j=0; j<categories.length; j++){
                            var option = document.createElement('option');
                            option.value = categories[j].getId();
                            option.text = categories[j].getTitle();
                            try{
                                sCategories.add(option, null);
                            }catch(ex){
                                sCategories.add(option);
                            }
                        }
                        break;
                    }
                }
            }
            load();
            ";
        $script .= "</script>";
        return $script;
    }
}
?>