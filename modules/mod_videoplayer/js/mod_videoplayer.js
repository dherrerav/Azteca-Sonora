$(function() {
	var title = $('.mod_videoplayer .video-player .content .title h3 a');
	var description = $('.mod_videoplayer .video-player .content .description');
	var first_id = $('.mod_videoplayer .video-playlist .title h2 a:first').attr('id');
	var first_video = $('.mod_videoplayer .video-playlist .title h2 a:first').attr('href');
	var first_title = $('.mod_videoplayer .video-playlist .title h2 a:first').text();
	var first_description = $('.mod_videoplayer .video-playlist .description:first').html();
	setTitle(first_title);
	setDescription(first_description);
	setVideo(first_id, first_video, false);
	$('.mod_videoplayer .video-playlist .title h2 a').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		var video = $(this).attr('href');
		var title = $(this).text();
		var description = $(this).parent().parent().parent().find('.description:first').html();
		setTitle(title);
		setDescription(description);
		setVideo(id, video, true);
	});
	function setTitle(new_title) {
		title.text(new_title);
	}
	function setDescription(new_description) {
		description.html(new_description);
	}
	function setVideo(new_id, new_video, autoplay) {
		if (new_video != 'undefined') {
			new_id = 'play-' + new_id;
			$('.mod_videoplayer .video-player .video').attr('id', new_id);
			flowplayer(new_id, siteurl + 'modules/mod_videoplayer/swf/flowplayer.swf', {
				clip: {
					url: siteurl + new_video,
					autoPlay: autoplay
				}
			});
		}
	}
});