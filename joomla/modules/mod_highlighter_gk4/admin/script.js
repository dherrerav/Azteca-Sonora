window.addEvent("domready",function(){
	getUpdates();
	DynamicColorPicker.auto(".color-field");
	// fix for the accordion
	document.id('MOD_HIGHLIGHT_GK4_BASIC_SETTINGS-options').addEvent('click', function(){
		if(document.id('MOD_HIGHLIGHT_GK4_BASIC_SETTINGS-options').hasClass('pane-toggler')) {
			(function(){ $$('.pane-slider').setStyle('height', 'auto'); }).delay(750);
		}
	});
	//
	var selector = document.id('jform_params_data_source');
	//
	document.id('jform_params_com_categories').getParent().setStyle('display', (selector.value == 'com_categories') ? 'block' : 'none');
	document.id('jform_params_com_articles').getParent().setStyle('display', (selector.value == 'com_articles') ? 'block' : 'none');
	document.id('jform_params_xmlfile').getParent().setStyle('display', (selector.value == 'xmlfile') ? 'block' : 'none');
	// 
	selector.addEvent('change', function() {
		document.id('jform_params_com_categories').getParent().setStyle('display', (selector.value == 'com_categories') ? 'block' : 'none');
		document.id('jform_params_com_articles').getParent().setStyle('display', (selector.value == 'com_articles') ? 'block' : 'none');
		document.id('jform_params_xmlfile').getParent().setStyle('display', (selector.value == 'xmlfile') ? 'block' : 'none');
	});
	
	selector.addEvent('blur', function() {
		document.id('jform_params_com_categories').getParent().setStyle('display', (selector.value == 'com_categories') ? 'block' : 'none');
		document.id('jform_params_com_articles').getParent().setStyle('display', (selector.value == 'com_articles') ? 'block' : 'none');
		document.id('jform_params_xmlfile').getParent().setStyle('display', (selector.value == 'xmlfile') ? 'block' : 'none');	
	});
	// limits
	document.id('jform_params_title_limit_type').inject(document.id('jform_params_title_limit_type').getParent().getNext(), 'bottom');
	document.id('jform_params_title_limit').getParent().getPrevious().dispose();
	document.id('jform_params_desc_limit_type').inject(document.id('jform_params_desc_limit_type').getParent().getNext(), 'bottom');
	document.id('jform_params_desc_limit').getParent().getPrevious().dispose();
	// other form operations
	$$('.input-pixels').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">px</span>"});
	$$('.input-percents').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">%</span>"});
	$$('.input-minutes').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">minutes</span>"});
	$$('.input-ms').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">ms</span>"});
	// switchers
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
	// demo link
	new Element('a', { 'href' : 'http://mootools.net/demos/?demo=Transitions', 'target' : '_blank',  'id' : 'gkDemoLink', 'html' : 'Demo'  }).inject(document.id('jform_params_animation_fun'), 'after');
	// help link
	var link = new Element('a', { 'class' : 'gkHelpLink', 'href' : 'http://tools.gavick.com/highlighter.html', 'target' : '_blank' })
	link.inject($$('div.panel')[$$('div.panel').length-1].getElement('h3'), 'bottom');
	link.addEvent('click', function(e) { e.stopPropagation(); });
});
// function to generate the updates list
function getUpdates() {
	document.id('jform_params_module_updates-lbl').destroy(); // remove unnecesary label
	var update_url = 'http://www.gavick.com/updates.raw?task=json&tmpl=component&query=product&product=mod_highlighter_gk4_j16';
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