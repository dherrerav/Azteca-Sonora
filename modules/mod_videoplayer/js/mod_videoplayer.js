jQuery(function($) {
	var title_holder = $('.mod_videoplayer .video-player .content .title h3 a');
	var description_holder = $('.mod_videoplayer .video-player .content .description');
	var sections = $('.mod_videoplayer .video-sections ul.sections li.section, .mod_videoplayer .video-sections ul.sections li.section .title h2 a');
	var current_section = null;
	sections.each(function() {
		$(this).removeClass('active');
		$(this).click(function(e) {
			$(this).addClass('active');
			e.preventDefault();
			var videos = $(this).find('ul.section-videos li.video').clone(true, true);
			if (!videos) {
				videos = $(this).parent().parent().parent().parent().find('li.video').clone(true, true);
			}
			loadPlaylist(videos);
		});
	});
	sections.first().addClass('active');
	var first_playlist = sections.first().find('ul.section-videos li.video').clone(true, true);
	loadPlaylist(first_playlist);
	function loadPlaylist(new_playlist) {
		if (new_playlist.length > 0) {
			$('.mod_videoplayer .video-playlist .playlist').html(new_playlist);
			var first_anchor = new_playlist.find('.title h2 a').first();
			prepareVideo(first_anchor, false);
			$('.mod_videoplayer .video-playlist .title h2 a').click(function(e) {
				e.preventDefault();
				prepareVideo($(this), true);
			});
			$('.mod_videoplayer .video-playlist .video').click(function(e) {
				e.preventDefault();
				var anchor = $(this).find('a').first();
				prepareVideo(anchor, true);
			});
			$('.video-playlist .scrollbar').scrollbar({
				handleHeight: 26
			});
			$('.video-sections .scrollbar').scrollbar({
				handleHeight: 26
			});
		}
	}
	function prepareVideo(anchor, play) {
		var id = anchor.attr('id');
		var video = anchor.attr('href');
		var title = anchor.text().trim();
		var description = anchor.parent().parent().parent().find('.description:first').html().trim();
		var preview = anchor.parent().parent().parent().find('.image img').data('preview');
		setTitle(title);
		setDescription(description);
		setVideo(id, video, preview, play);
	}
	function setTitle(new_title, new_link) {
		title_holder.text(new_title);
		title_holder.attr({
			href: new_link,
			title: new_title
		});
	}
	function setDescription(new_description) {
		description_holder.html(new_description);
	}
	function setVideo(new_id, new_video, new_preview, autoplay) {
		if (new_video != 'undefined') {
			new_id = 'play-' + new_id;
			var player = $('.mod_videoplayer .video-player .video');
			player.attr({id: new_id, href: new_video});
			if (!autoplay) {
				player.css('background-image', 'url(' + new_preview + ')');
				play_button = $('<img />');
				play_button.attr({src: siteurl + 'modules/mod_videoplayer/images/play_large.png', alt: 'Play', width: 83, height: 83})
						   .css({'margin-top': (player.height() -83) / 2, 'margin-left': (player.width() - 83) / 2})
						   .appendTo(player);
			}
			flowplayer(new_id, siteurl + 'modules/mod_videoplayer/swf/flowplayer.swf', {
				clip: {
					url: siteurl + new_video,
					autoPlay: autoplay
				}
			});
		}
	}
});