$(function() {

	$('.editable').bind('dblclick', switchInput);
	
	$('.weather-form').submit(function(e) {
		e.preventDefault();
	});
	
	function switchInput() {
		$(this).unbind('dblclick');
		text = $(this).html();
		form = $('<form class="city-form" />');
		input = $('<input type="text" class="weather-edit" value="' + text + '" />');
		form.html(input);
		form.submit(function(e) {
			e.preventDefault();
			var location = $(this).children('.weather-edit').val();
			$(this).parent().bind('dblclick', switchInput);
			$(this).parent().html(location);
			getWeather(location);
		});
		$(this).html(form);
		input.select();
	}
	
	function getWeather(location) {
		console.debug(location);
		$.post('mod_google_weather.php', {
				location: location
			},
			function(response) {
				$('#weather-module-1').html(response);
			}
		);
	}
	
});