/**
* Admin script file
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

window.addEvent("domready",function(){
	getUpdates();
	//
	var data_sources = [document.id('jform_params_com_categories'), document.id('jform_params_com_articles')];
	//
	data_sources.each(function(el,j){
		el.getParent().setStyle('display','none');
	});
	
	document.id('jform_params_'+document.id('jform_params_data_source').value).getParent().setStyle('display','');
	
	document.id('jform_params_data_source').addEvent("change", function(){
		data_sources.each(function(el,j){
			el.getParent().setStyle('display','none');
		});
	
		document.id('jform_params_'+document.id('jform_params_data_source').value).getParent().setStyle('display','');	
	});
	document.id('jform_params_data_source').addEvent("blur", function(){
		data_sources.each(function(el,j){
			el.getParent().setStyle('display','none');
		});
	
		document.id('jform_params_'+document.id('jform_params_data_source').value).getParent().setStyle('display','');
	});
	//
	if(document.id('jform_params_links_position').value == 'bottom') document.id('jform_params_links_width').getParent().setStyle('display','none');
	else document.id('jform_params_links_width').getParent().setStyle('display','');	
		
	document.id('jform_params_links_position').addEvent('change', function(){
		if(document.id('jform_params_links_position').value == 'bottom') document.id('jform_params_links_width').getParent().setStyle('display','none');
		else document.id('jform_params_links_width').getParent().setStyle('display','');	
	});

	document.id('jform_params_links_position').addEvent('blur', function(){
		if(document.id('jform_params_links_position').value == 'bottom') document.id('jform_params_links_width').getParent().setStyle('display','none');
		else document.id('jform_params_links_width').getParent().setStyle('display','');
	});
	
	var horder = document.id('jform_params_news_header_order');
	var iorder = document.id('jform_params_news_image_order');
	var torder = document.id('jform_params_news_text_order');
	var inorder = document.id('jform_params_news_info_order');
	var in2order = document.id('jform_params_news_info2_order');
	
	horder.addEvent("change", function(){
		var unexisting = [false, false, false, false, false];
		unexisting[horder.value - 1] = true;
		unexisting[iorder.value - 1] = true;
		unexisting[torder.value - 1] = true;
		unexisting[inorder.value - 1] = true;
		unexisting[in2order.value - 1] = true;
		
		var searched = 0;
		
		if(unexisting[0] == false) searched = 1;
		if(unexisting[1] == false) searched = 2;
		if(unexisting[2] == false) searched = 3;
		if(unexisting[3] == false) searched = 4;
		if(unexisting[4] == false) searched = 5;
		
		if(iorder.value == horder.value) iorder.value = searched;
		if(torder.value == horder.value) torder.value = searched;
		if(inorder.value == horder.value) inorder.value = searched;
		if(in2order.value == horder.value) in2order.value = searched;
	});

	iorder.addEvent("change", function(){
		var unexisting = [false, false, false, false, false];
		unexisting[horder.value - 1] = true;
		unexisting[iorder.value - 1] = true;
		unexisting[torder.value - 1] = true;
		unexisting[inorder.value - 1] = true;
		unexisting[in2order.value - 1] = true;
		
		var searched = 0;
		
		if(unexisting[0] == false) searched = 1;
		if(unexisting[1] == false) searched = 2;
		if(unexisting[2] == false) searched = 3;
		if(unexisting[3] == false) searched = 4;
		if(unexisting[4] == false) searched = 5;
		
		if(horder.value == iorder.value) horder.value = searched;
		if(torder.value == iorder.value) torder.value = searched;
		if(inorder.value == iorder.value) inorder.value = searched;	
		if(in2order.value == iorder.value) in2order.value = searched;		
	});
	
	torder.addEvent("change", function(){
		var unexisting = [false, false, false, false, false];
		unexisting[horder.value - 1] = true;
		unexisting[iorder.value - 1] = true;
		unexisting[torder.value - 1] = true;
		unexisting[inorder.value - 1] = true;
		unexisting[in2order.value - 1] = true;
				
		var searched = 0;
		
		if(unexisting[0] == false) searched = 1;
		if(unexisting[1] == false) searched = 2;
		if(unexisting[2] == false) searched = 3;
		if(unexisting[3] == false) searched = 4;
		if(unexisting[4] == false) searched = 5;
		
		if(horder.value == torder.value) horder.value = searched;
		if(iorder.value == torder.value) iorder.value = searched;
		if(inorder.value == torder.value) inorder.value = searched;	
		if(in2order.value == torder.value) in2order.value = searched;	
	});
	
	inorder.addEvent("change", function(){
		var unexisting = [false, false, false, false, false];
		unexisting[horder.value - 1] = true;
		unexisting[iorder.value - 1] = true;
		unexisting[torder.value - 1] = true;
		unexisting[inorder.value - 1] = true;
		unexisting[in2order.value - 1] = true;
		
		var searched = 0;
		
		if(unexisting[0] == false) searched = 1;
		if(unexisting[1] == false) searched = 2;
		if(unexisting[2] == false) searched = 3;
		if(unexisting[3] == false) searched = 4;
		if(unexisting[4] == false) searched = 5;
		
		if(horder.value == inorder.value) horder.value = searched;
		if(torder.value == inorder.value) torder.value = searched;
		if(iorder.value == inorder.value) iorder.value = searched;	
		if(in2order.value == inorder.value) in2order.value = searched;	
	});

	in2order.addEvent("change", function(){
		var unexisting = [false, false, false, false, false];
		unexisting[horder.value - 1] = true;
		unexisting[iorder.value - 1] = true;
		unexisting[torder.value - 1] = true;
		unexisting[inorder.value - 1] = true;
		unexisting[in2order.value - 1] = true;
		
		var searched = 0;
		
		if(unexisting[0] == false) searched = 1;
		if(unexisting[1] == false) searched = 2;
		if(unexisting[2] == false) searched = 3;
		if(unexisting[3] == false) searched = 4;
		if(unexisting[4] == false) searched = 5;
		
		if(horder.value == in2order.value) horder.value = searched;
		if(torder.value == in2order.value) torder.value = searched;
		if(iorder.value == in2order.value) iorder.value = searched;	
		if(inorder.value == in2order.value) inorder.value = searched;	
	});
	
	$$('.input-pixels').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">px</span>"});
	$$('.input-percents').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">%</span>"});
	$$('.input-minutes').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">minutes</span>"});
	$$('.input-ms').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">ms</span>"});
	
	$$('.text-limit').each(function(el){
		var name = el.get('id') + '_type';
		var parent = el.getParent();
		el.inject(document.id(name),'before');		
        parent.dispose();
	});
	
	$$('.float').each(function(el){
		var destination = el.getParent().getPrevious().getElement('select');
		var parent = el.getParent();
        el.inject(destination, 'after');
		parent.dispose();	
	});
	
	$$('.enabler').each(function(el){
		var destination = el.getParent().getPrevious().getElement('select');
		var parent = el.getParent();
		el.inject(destination, 'after');
		parent.dispose();	
	});
	
	$$('.gk_switch').each(function(el){
		el.setStyle('display','none');
		var style = (el.value == 1) ? 'on' : 'off';
		var switcher = new Element('div',{'class' : 'switcher-'+style});
		switcher.inject(el, 'after');
		switcher.addEvent("click", function(){
			if(el.value == 1){
				switcher.setProperty('class','switcher-off');
				el.value = 0;
			}else{
				switcher.setProperty('class','switcher-on');
				el.value = 1;
			}
		});
	});
	
	var link = new Element('a', { 'class' : 'gkHelpLink', 'href' : 'http://tools.gavick.com/newshowpro.html', 'target' : '_blank' })
	link.inject($$('div.panel')[$$('div.panel').length-1].getElement('h3'), 'bottom');
	link.addEvent('click', function(e) { e.stopPropagation(); });
});
// function to generate the updates list
function getUpdates() {
	document.id('jform_params_module_updates-lbl').destroy(); // remove unnecesary label
	var update_url = 'http://www.gavick.com/updates.raw?task=json&tmpl=component&query=product&product=mod_news_pro_gk4_j16';
	var update_div = document.id('gk_module_updates');
	update_div.innerHTML = '<div id="gk_update_div"><span id="gk_loader"></span>Loading update data from GavicPro Update service...</div>';
	
	new Asset.javascript(update_url,{
		id: "new_script",
		onload: function(){
			content = '';
			$GK_UPDATE.each(function(el){
				content += '<li><span class="gk_update_version"><strong>Version:</strong> ' + el.version + ' </span><span class="gk_update_data"><strong>Date:</strong> ' + el.date + ' </span><span class="gk_update_link"><a href="' + el.link + '" target="_blank">Download</a></span></li>';
			});
			update_div.innerHTML = '<ul class="gk_updates">' + content + '</ul>';
			if(update_div.innerHTML == '<ul class="gk_updates"></ul>') update_div.innerHTML = '<p>There is no available updates for this module</p>';	
		}
	});
}