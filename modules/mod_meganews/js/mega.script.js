/* ++++++++++++++++++++  Document Mega Script ++++++++++++++++++++++  */
function equalHeightTop () {
	var elements = document.getElements('.blog-news-i');
	var maxHeight = 0;
	/* Get max height */
	elements.each(function(item, index){
		var height = parseInt(item.getStyle('height'));
		if(height > maxHeight){ maxHeight = height; }
	});
	elements.setStyle('height', maxHeight+'px');
}
window.addEvent ('load', function() {
	equalHeightTop ();
});