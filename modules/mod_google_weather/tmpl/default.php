<div class="weather-module">
	<form action="index.php" class="weather-form" method="post" id="weather-form-1">
		<div class="text">
			<div class="instructions">
				<p>Doble click para cambiar de ciudad.</p>
			</div>
			<h3 class="weather-city-title editable"><?= $weather->forecast_information->city['data'] ?></h3>
			<a class="weather-temp"><?= $current->temp_c['data'] ?> &deg;C</a>
			<a class="weather-temp"><?= $current->temp_f['data'] ?> &deg;F</a>
			<div class="loading"></div>
		</div>
		<div class="image">
			<img class="icon" src="http://www.google.com<?= $current->icon['data'] ?>" alt="<?= $current->condition['data'] ?>" title="<?= $current->condition['data'] ?>" />
		</div>
	</form>
</div>
<script type="text/javascript">
$(function() {

	$('.loading').hide();

	$('.editable').bind('dblclick', switchInput);
	
	$('.weather-form').submit(function(e) {
		e.preventDefault();
	});
	
	$('.instructions').hide();
	
	$('.weather-city-title').hover(function() {
		$('.instructions').show();
	}, function() {
		$('.instructions').hide();
	});
	
	function switchInput() {
		$(this).unbind('dblclick');
		$('.instructions').hide();
		text = $(this).html();
		form = $('<form class="city-form" />');
		input = $('<input type="text" class="weather-edit" value="' + text + '" />');
		input.blur(function() {
			$(this).parent().bind('dblclick', switchInput);
			$(this).parent().html(input.val());
		});
		form.html(input);
		form.submit(function(e) {
			e.preventDefault();
			$('.loading').show();
			var location = $(this).children('.weather-edit').val();
			$(this).parent().live('dblclick', switchInput);
			$(this).parent().html(location);
			getWeather(location);
		});
		$(this).html(form);
		input.select();
	}
	
	function getWeather(location) {
		console.debug(location);
		$.post('/modules/mod_google_weather/mod_google_weather.php', {
				location: location
			},
			function(response) {
				$('.weather-module').replaceWith(response);
			}
		);
	}
	
});
</script>