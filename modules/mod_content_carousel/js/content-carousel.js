$(function() {  
	//move the last list item before the first item. The purpose of this is if the user clicks previous he will be able to see the last item.  
	$('.content-carousel .content-carousel-inner ul.articles li.article:first').before($('.content-carousel .content-carousel-inner ul.articles li.article:last'));
	//when user clicks the image for sliding right  
	$('.content-carousel .content-carousel-control.next').click(function(){
		//get the width of the items ( i like making the jquery part dynamic, so if you change the width in the css you won't have o change it here too ) '
		var item_width = $('.content-carousel .content-carousel-inner ul.articles li.article').outerWidth();
		//calculate the new left indent of the unordered list
		var left_indent = parseInt($('.content-carousel .content-carousel-inner ul.articles').css('left')) - item_width;
		//make the sliding effect using jquery's anumate function '  
		$('.content-carousel .content-carousel-inner ul.articles').animate({
			'left': left_indent
		}, 500, function() {
			console.log('Next');
			//get the first list item and put it after the last list item (that's how the infinite effects is made) '  
			$('.content-carousel .content-carousel-inner ul.articles li.article:last').after($('.content-carousel .content-carousel-inner ul.articles li.article:first'));
			//and get the left indent to the default -210px  
			$('.content-carousel .content-carousel-inner ul.articles').css({
				'left': '-230px'
			});
		});
	});
	//when user clicks the image for sliding left  
	$('.content-carousel .content-carousel-control.prev').click(function(){
		var item_width = $('.content-carousel .content-carousel-inner ul.articles li.article').outerWidth();
		/* same as for sliding right except that it's current left indent + the item width (for the sliding right it's - item_width) */
		var left_indent = parseInt($('.content-carousel .content-carousel-inner ul.articles').css('left')) + item_width;
		$('.content-carousel .content-carousel-inner ul.articles').animate({
			'left': left_indent
		}, 500, function() {
			console.log('Previous');
			/* when sliding to left we are moving the last item before the first item */
			$('.content-carousel .content-carousel-inner ul.articles li.article:first').before($('.content-carousel .content-carousel-inner ul.articles li.article:last'));
			/* and again, when we make that change we are setting the left indent of our unordered list to the default -210px */
			$('.content-carousel .content-carousel-inner ul.articles').css({
				'left': '-230px'
			});  
		});
	});
});