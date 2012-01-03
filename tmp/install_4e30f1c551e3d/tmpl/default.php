<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" src="<?= JRUI::base() . ?>/jcarousellite_1.0.1.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var url = 'http://twitter.com/status/user_timeline/<?= $params->get('account') ?>.json?count=<?= $params->get('count') ?>&callback=?';
	$.getJSON(url, function(data) {
		$.each(data, function(i, item) {
			$('#tweets').append('<li>' + item.text.linkify() + '&nbsp;<span class="created_at">(' + relative_time(item.created_at) + ')</span></li>');
		})
	}).success(function() {
		$('#tweets-container').jCarouselLite({
			auto:			2000,
			speed:			1000,
			visible:		1
		});
	});
	
	String.prototype.linkify = function() {
		return this.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+/, function(m) {
			return m.link(m);
			}
		);
	};
	
	function relative_time(time_value) {
		var values = time_value.split(" ");
		time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
		var parsed_date = Date.parse(time_value);
		var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
		var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
		delta = delta + (relative_to.getTimezoneOffset() * 60);
		var r = '';
		if (delta < 60) {
			r = 'hace un minuto';
		} else if (delta < 120) {
			r = 'hace un par de minutos';
		} else if (delta < (45*60)) {
			r = 'hace ' + (parseInt(delta / 60)).toString() + ' minutos';
		} else if (delta < (90*60)) {
			r = 'hace una hora';
		} else if (delta < (24*60*60)) {
			r = 'hace ' + (parseInt(delta / 3600)).toString() + ' horas';
		} else if (delta < (48*60*60)) {
			r = 'hace un día';
		} else {
			r = 'hace ' + (parseInt(delta / 86400)).toString() + ' días';
		}
		return r;
	}
	function twitter_callback() {
		return true;
	}
});
</script>
<div id="tweets-container">
	<ul id="tweets">
	</ul>
</div>