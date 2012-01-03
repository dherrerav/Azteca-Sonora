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

function addItems(source, target){
    var ids = new Array();
    var i = 0;
    while(source.selectedIndex >= 0){
        var option = document.createElement('option');
        option.value = source.options[source.selectedIndex].value;
        option.text = source.options[source.selectedIndex].text;
        ids[i++] = source.options[source.selectedIndex].value;
        target.add(option, null);
        source.remove(source.selectedIndex);
    }
    return ids;
}

function load(){
    var sSections = document.getElementById('sSections');
    var tSections = document.getElementById('tSections');
    var sec_cats_ids = document.getElementById('sec_cat_ids');
    var sec_cats = sec_cats_ids.split('^');

    var sections = sec_cats[0].substr(1,sec_cats[0].length - 1).split(',');
    var categories = sec_cats[1].substr(1,sec_cats[1].length - 1).split(',');
    var cats, option, i, j, k;
    
    sectionsTree = buildTree(sourceArray);
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
            sSections.add(option, null);
        }
    }
    for(i=0; i<sections.length; i++){
        for(j=0; j<sectionsTree.length; j++){
            if(sections[i] == sectionsTree[j].getId()){
                option = document.createElement('option');
                option.value = sectionsTree[j].getId();
                option.text = sectionsTree[j].getTitle();
                tSections.add(option, null);
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
                    tCategories.add(option, null);
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
    var result = addItems(sourceObj, targetObj);
    switch (type) {
        case 1: //Sections
            var sectionIdsObj = document.getElementById('section_ids');
            sectionIdsObj.value = updateValues(action, sectionIdsObj.value, result);
            break;
        case 2: //Categories
            var categoryIdsObj = document.getElementById('category_ids');
            categoryIdsObj.value = updateValues(action, categoryIdsObj.value, result);
            break;
        default:
            break;
    }

}

function updateValues(action, value, arrValues){
    if(value == null || value.length < 1){
        value = ',';
    }
    if(action == 'A'){
        for(var i=0; i<arrValues.length; i++){
            value = value + arrValues[i] + ',';
        }
        return value;
    }else if(action == 'R'){
        for(var i=0; i<arrValues.length; i++){
            value.replace(','+arrValues[i]+',',',');
        }
        if(value.length < 2){
            value = ',';
        }
        return value;
    }else{
        return ',';
    }
}

function populateCategories(source, target){
    sSections = document.getElementById(source);
    sCategories = document.getElementById(target);
    sCategories.innerHTML = '';
    while(sSections.selectedIndex >= 0){
        var sectionId = sSections.options[sSections.selectedIndex].value;
        for(var i = 0; i<sectionsTree.length; i++){
            if(sectionsTree[i].getId() == sectionId){
                for(var j=0; j<sectionsTree.getCategories().length; j++){
                    var option = document.createElement('option');
                    option.value = sectionsTree.getCategories()[j].getId();
                    option.text = sectionsTree.getCategories()[j].getTitle();
                    sCategories.add(option, null);
                }
                break;
            }
        }
    }
}