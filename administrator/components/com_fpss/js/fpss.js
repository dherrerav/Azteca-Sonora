/**
 * @version		$Id: fpss.js 658 2011-08-23 14:08:13Z lefteris.kavadas $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

var $FPSS = jQuery.noConflict();

$FPSS(document).ready(function(){

	// Uniform.js for slide and category forms
	if($FPSS('.slideForm').length || $FPSS('.categoryForm').length){
		$FPSS("select, input, button, textarea").uniform();
	}

	// Common functions
	$FPSS('#jToggler').click(function(){
		if($FPSS(this).attr('checked')){
			$FPSS('input[id^=cb]').attr('checked', 'checked');
			$FPSS('input[name=boxchecked]').val('1')
		} else {
			$FPSS('input[id^=cb]').removeAttr('checked');
			$FPSS('input[name=boxchecked]').val('0')
		}
	});
	$FPSS('#fpssSubmitButton').click(function(){
		this.form.submit();
	});
	$FPSS('#fpssResetButton').click(function(event){
		event.preventDefault();
		$FPSS('.fpssAdminTableFilters input').val('');
		$FPSS('.fpssAdminTableFilters option').removeAttr('selected');
		this.form.submit();
	});
	$FPSS('.fpssAdminTableFilters select').change(function(){
		this.form.submit();
	});
	$FPSS('#fpssModuleFilters select').change(function(){
		var fpssModuleForm = $FPSS('#fpssModuleForm');
		$FPSS('#fpssModuleFilters').addClass('fpssModuleFiltersLoading');
		$FPSS.ajax({
			type: fpssModuleForm.attr('method'),
			url: fpssModuleForm.attr('action'),
			dataType: 'json',
			data: fpssModuleForm.serialize(),
			success: function(response){
				$FPSS('#fpssModuleFilters').removeClass('fpssModuleFiltersLoading');
				FPSSChart.series[0].setData(response.data, false);
				FPSSChart.xAxis[0].setCategories(response.categories, false);
				FPSSChart.redraw();
			}
		});
	});

	ordering = $FPSS('input[name=filter_order]').val();
	orderingDir = $FPSS('input[name=filter_order_Dir]').val();
	var view = $FPSS('input[name=view]').val();

	// View specific functions
	switch(view){
		case 'slide':
			$FPSS('.fpssDatePicker').datepicker({dateFormat: 'yy-mm-dd'});
			$FPSS('.fpssTabs').tabs();
			var categoryValue = $FPSS('#catid').val();
			$FPSS('input[name=catid]').val(categoryValue);
			setActive();
			fillNotes();
			if($FPSS('#referenceType').val()!='custom') {
				$FPSS('#referenceType').prev().html(linkNote);
			}
			$FPSS('#source-custom').click(function(event){
				event.preventDefault();
				$FPSS('html, body').stop().animate({
					scrollTop: $FPSS('#reference').offset().top
				}, 500);
				$FPSS('#reference').removeAttr('disabled').val('').focus();
				$FPSS('#referenceType').val('custom');
				$FPSS('#referenceID').val('');
				$FPSS('#cpanel .icon a').removeClass('active');
				$FPSS('#source-custom').addClass('active');
				$FPSS('#referenceType').prev().html('');
			});

			$FPSS('#imageFile').change(function(){
				$FPSS('#imagePreview').attr('src', 'components/com_fpss/images/loading.gif');
				resizeElement($FPSS('#imagePreview'),100,100);

				$FPSS('#imageForm').find('input[type=text]').val('');
				$FPSS('#imageForm').submit();
			});

			$FPSS('#thumbFile').change(function(){
				$FPSS('#thumbPreview').attr('src', 'components/com_fpss/images/loading.gif');
				resizeElement($FPSS('#thumbPreview'),100,100);

				$FPSS('#thumbForm').find('input[type=text]').val('');
				$FPSS('#thumbForm').submit();
			});

			$FPSS('.targetFrame').load(function(){
				response = window.frames[$FPSS(this).attr('name')].document.body.innerHTML;
				if(response==''){
					return;
				}
				result = $FPSS.parseJSON(response);
				if(result.error!=''){
					alert(result.error);
					resizeElement($FPSS('#'+result.type+'Preview'), 100, 100);
					$FPSS('#'+result.type+'Preview').attr('src', 'components/com_fpss/images/placeholder.png');
					$FPSS('#'+result.type).val('');
					return;
				}
				if(result.dummy) {
					$FPSS('input[name=dummy]').each(function() {
						$FPSS(this).val(result.dummy);
					});
				}
				$FPSS('#'+result.type+'Preview').attr('src', result.preview);
				resizeElement($FPSS('#'+result.type+'Preview'), result.width, result.height);
				$FPSS('#'+result.type).val(result.value);
			});

			/*
			$FPSS('#thumbFormTarget').addEvent('load', function(){
				response = window.frames['thumbFormTarget'].document.body.innerHTML;
				if(response!=""){
					$FPSS('#thumbPreview').attr('src', response);
					$FPSS('#thumb').attr('value', response);
				}
			});
			*/

			$FPSS('#browseServerForImage').click(function(event){
				event.preventDefault();
				SqueezeBox.initialize();
				SqueezeBox.fromElement(this, {
					handler: 'iframe',
					size: {x: 580, y: 400},
					url: 'index.php?option=com_fpss&view=filebrowser&tmpl=component&elementID='+$FPSS('#existingImage').attr('id')
				});
			});
			
			$FPSS('#browseServerForThumb').click(function(event){
				event.preventDefault();
				SqueezeBox.initialize();
				SqueezeBox.fromElement(this, {
					handler: 'iframe',
					size: {x: 550, y: 400},
					url: 'index.php?option=com_fpss&view=filebrowser&tmpl=component&elementID='+$FPSS('#existingThumb').attr('id')
				});
			});

			$FPSS('#resetThumbButton').click(function(event){
				event.preventDefault();
				resetThumb();
			});
			$FPSS('#catid').change(function(){
				$FPSS('input[name=catid]').val($FPSS(this).val());
				dimensionsIndex = $FPSS('#catid option').index($FPSS('#catid option:selected'));
				$FPSS('#currentDimensions').fadeOut(400, function(){
					$FPSS('#mainImageWidth').html(categoriesDimensions[dimensionsIndex][0]);
					$FPSS('#thumbImageWidth').html(categoriesDimensions[dimensionsIndex][1]);
					$FPSS('#previewImageWidth').html(categoriesDimensions[dimensionsIndex][2]);
				});
				$FPSS('#currentDimensions').fadeIn(400);
			});
			$FPSS('a[href=#fpssSlideMainTab]').click(function(){
				$FPSS('#imagesContainer').css('display', 'block');
			});
			$FPSS('a[href=#fpssSlideAdvancedTab]').click(function(){
				$FPSS('#imagesContainer').css('display', 'none');
			});
			$FPSS('input.no-label').focus(function(){
				if($FPSS(this).val() == $FPSS(this).attr('title')) {
					$FPSS(this).val('');
				}
			});
			$FPSS('input.no-label').blur(function(){
				if($FPSS(this).val() == '') {
					$FPSS(this).val($FPSS(this).attr('title'));
				}
			});
			$FPSS('#fpssResetHitsButton').click(function(){
				$FPSS('input[name=task]').val('resetHits');
				this.form.submit();
			});
			$FPSS('#useOriginal').click(function(){
				if($FPSS(this).attr('checked')) {
					$FPSS('#useOriginalValue').val('1');
				} else {
					$FPSS('#useOriginalValue').val('0');
				}
			});
		break;

		case 'category':
			//$FPSS('.fpssTabs').tabs();
			$FPSS('input.no-label').focus(function(){
				if($FPSS(this).val() == $FPSS(this).attr('title')) {
					$FPSS(this).val('');
				}
			});
			$FPSS('input.no-label').blur(function(){
				if($FPSS(this).val() == '') {
					$FPSS(this).val($FPSS(this).attr('title'));
				}
			});
		break;

		case 'categories':
			if(ordering=='category.ordering') {
				makeSortable('order', 'saveorder');
			}
		break;
		case 'slides':
			if(ordering=='slide.featured_ordering' && $FPSS('#featured').val()=='1') {
				makeSortable('featuredOrder', 'featuredsaveorder');
			}
			if(ordering=='slide.ordering' && $FPSS('#catid').val()!='0') {
				makeSortable('order', 'saveorder');
			}
		break;
	}

});



/* --- Helpers --- */

// If we are in Joomla! 1.5 define the functions for validation
if (typeof(Joomla) === 'undefined') {
	var Joomla = {};
	Joomla.submitbutton = function(pressbutton){
		submitform(pressbutton);
	}
	function submitbutton(pressbutton) {
		Joomla.submitbutton(pressbutton);
	}
}

function j16SelectArticle(id, title, object) {
	$FPSS('#reference').val(title).attr('disabled', 'disabled');
	$FPSS('#referenceType').val('com_content');
	$FPSS('#referenceID').val(id);
	$FPSS('#cpanel .icon a').removeClass('active');
	$FPSS('#source-com_content').addClass('active');
	populateSlide('com_content', id);
	closeModal();
}
function jSelectArticle(id, title, object){
	$FPSS('#reference').val(title).attr('disabled', 'disabled');
	$FPSS('#referenceType').val('com_content');
	$FPSS('#referenceID').val(id);
	$FPSS('#cpanel .icon a').removeClass('active');
	$FPSS('#source-com_content').addClass('active');
	populateSlide('com_content', id);
	closeModal();
}
function jSelectMenu(id, title){
	$FPSS('#reference').val(title).attr('disabled', 'disabled');
	$FPSS('#referenceType').val('com_menus');
	$FPSS('#referenceID').val(id);
	$FPSS('#cpanel .icon a').removeClass('active');
	$FPSS('#source-com_menus').addClass('active');
	populateSlide('com_menus', id);
	closeModal();
}
function jSelectItem(id, title, object){
	$FPSS('#reference').val(title).attr('disabled', 'disabled');
	$FPSS('#referenceType').val('com_k2');
	$FPSS('#referenceID').val(id);
	$FPSS('#cpanel .icon a').removeClass('active');
	$FPSS('#source-com_k2').addClass('active');
	populateSlide('com_k2', id);
	closeModal();
}
function jSelectVMProduct(id, title){
	$FPSS('#reference').val(title).attr('disabled', 'disabled');
	$FPSS('#referenceType').val('com_virtuemart');
	$FPSS('#referenceID').val(id);
	$FPSS('#cpanel .icon a').removeClass('active');
	$FPSS('#source-com_virtuemart').addClass('active');
	populateSlide('com_virtuemart', id);
	closeModal();
}
function jSelectTiendaProduct(id, title){
	$FPSS('#reference').val(title).attr('disabled', 'disabled');
	$FPSS('#referenceType').val('com_tienda');
	$FPSS('#referenceID').val(id);
	$FPSS('#cpanel .icon a').removeClass('active');
	$FPSS('#source-com_tienda').addClass('active');
	populateSlide('com_tienda', id);
	closeModal();
}
function jSelectProduct(id, title, object){
	$FPSS('#reference').val(title).attr('disabled', 'disabled');
	$FPSS('#referenceType').val('com_redshop');
	$FPSS('#referenceID').val(id);
	$FPSS('#cpanel .icon a').removeClass('active');
	$FPSS('#source-com_redshop').addClass('active');
	populateSlide('com_redshop', id);
	closeModal();
}
function jSelectUser(id, name){
	$FPSS('#fpssAuthor').html(name);
	$FPSS('input[name=created_by]').val(id);
	closeModal();
}
function jSelectUser_FPSS_created_by(id, name){
	jSelectUser(id, name);
}

/*
function jInsertEditorText(response, elementID){
	tmp = new Element('div');
	tmp.setHTML(response);
	src = tmp.getChildren().getProperty('src');
	//Start - Added because IE cannot reset input type="file" with javascript
	$FPSS(elementID).parent().parent().reset();
	//End

	$FPSS(elementID).attr('value', src);
	$FPSS(elementID).parent().getElement('img.preview').attr('src', 'components/com_fpss/images/loading.gif');
	resizeElement($FPSS(elementID).parent().getElement('img.preview'),100,100);
	//$FPSS(elementID).parent().getElement('input.file').attr('value', '');
	$FPSS(elementID).parent().parent().submit();
}
*/

function resizeElement(element, width, height){
	if(width>500){
		var ratio = width/height;
		width = 600;
		height = 600/ratio;
	}

	element.animate(
		{width: width.toInt(),height: height.toInt()},
		600,
		function(){fillNotes();}
	);
}

function fillNotes(){
	$FPSS('img.preview').each(function(){

		if($FPSS(this).attr('id')=='imagePreview'){
			log = $FPSS('#imageLog');
		} else {
			log = $FPSS('#thumbLog');
		}
		log.empty();
		var clone = $FPSS(this).clone().removeAttr('id').removeAttr('style').appendTo($FPSS('#imageStore'));
		if(clone.width().toInt()>=600){
			log.html(sizeNote+'<b>'+clone.width()+'x'+clone.height()+'</b>');
		}
		clone.remove();
	});
}

function populateSlide(type, id){
	url = 'index.php?option=com_fpss&view=slide&task=populate&type='+type+'&id='+id;
	$FPSS.ajax({
		url: url,
		type: 'get',
		dataType: 'json',
		success: function(result){
			$FPSS('#title').val(result.title);
			if(wysiwyg){
				tinyMCE.editors.text.setContent('');
				jInsertEditorText(result.text, 'text');
			} else {
				$FPSS('#text').val(result.text);
			}
			if(result.image){
				$FPSS('#existingImage').val(result.image);

				resizeElement($FPSS('#imagePreview'), 100, 100);
				$FPSS('#imagePreview').attr('src', 'components/com_fpss/images/loading.gif');

				$FPSS('#imageForm').submit();
				resetThumb();
			}
		}
	});
	$FPSS('#referenceType').prev().html(linkNote);

}

function resetThumb(){
	$FPSS('#thumb').val('');
	$FPSS('#thumbForm').get(0).reset();
	$FPSS('#existingThumb').val('');
	$FPSS('#thumbPreview').attr('src', 'components/com_fpss/images/placeholder.png');
	resizeElement($FPSS('#thumbPreview'),300,180);
}

function setActive(){
	type = $FPSS('#referenceType').val();
	id = $FPSS('#referenceID').val();
	if(type=='custom'){
		$FPSS('#reference').removeAttr('disabled');
		$FPSS('#source-custom').addClass('active');
		return;
	}
	$FPSS.ajax({
		url:'index.php?option=com_fpss&view=slide&task=getLiveTitle&type='+type+'&id='+id,
		type: 'get',
		success: function(response){
			$FPSS('#source-'+type).addClass('active');
			$FPSS('#reference').val(response);
		}
	});
}

function makeSortable(fieldName, task) {
	if(orderingDir == 'asc') {
		var maxOrderingValue = $FPSS('input[name="'+fieldName+'[]"]:last').val();
	} else {
		var maxOrderingValue = $FPSS('input[name="'+fieldName+'[]"]:first').val();
	}

	$FPSS('.fpssSortable').sortable({
		handle: '.handle',
		placeholder: 'ui-state-highlight',
		start: function(event, ui) {
			$FPSS('input[id^=cb]').attr('checked', 'checked');
		},
		update: function(event, ui) {
			var localMaxOrderingValue = maxOrderingValue;
			$FPSS('input[name="'+fieldName+'[]"]').each(function(index){
				if(orderingDir == 'asc') {
					$FPSS(this).val(index+1);
				} else {
					$FPSS(this).val(localMaxOrderingValue);
					localMaxOrderingValue--;
				}
				$FPSS(this).parent().parent().removeAttr('class');
				$FPSS(this).parent().parent().addClass('row'+((index+1)%2));
			});
			$FPSS('input[name=task]').val(task);
			$FPSS('.fpssSortable').sortable('disable');
			$FPSS.ajax({
				   type: 'POST',
				   url: 'index.php',
				   data: $FPSS('form').serialize()+'&format=raw',
				   complete: function(response) {
						$FPSS('input[id^=cb]').removeAttr('checked');
						$FPSS('.fpssSortable').sortable('enable');
					}
			});
		}
	});
}

function closeModal(){
	if(typeof(SqueezeBox.close=='function')){
		SqueezeBox.close();
	} else {
		$FPSS('#sbox-window').get(0).close();
	}
}
	
/* Stats */
function loadFPSSChart(container, data, title, yAxisTitle, categories) {
	FPSSChart = new Highcharts.Chart({
		chart: {
			renderTo: container,
			defaultSeriesType: 'bar',
			borderWidth: 0,
			borderColor: '',
			backgroundColor: '',
			marginLeft: 120,
			style: {
				fontFamily: 'Arial,Helvetica,sans-serif'
			}
		},
		title: {
			text: title,
			style: {
				fontFamily: 'Arial,Helvetica,sans-serif',
				fontWeight: 'bold',
				fontSize: '24px'
			},
			y: 30
		},
		xAxis: {
			categories: categories
		},
		yAxis: {
			title: {
				text: yAxisTitle,
				style: {
					color: '#555555',
					fontSize: '14px'
				}
			},
			allowDecimals: false
		},
		legend: {
			enabled: false
		},
		tooltip: {
			formatter: function() {
				return this.x + ':' + '<b>' + this.y + '</b>';
			}
		},
		credits: {
			enabled: false
		},
		series: [{
			data: data
		}]
	});
}
