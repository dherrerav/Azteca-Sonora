jQuery(function($) {
	var title_holder = $('.mod_videoplayer .video-player .content .title h3 a');
	var description_holder = $('.mod_videoplayer .video-player .content .description');
	var sections = $('.mod_videoplayer .video-sections ul.sections li.section, .mod_videoplayer .video-sections ul.sections li.section .title h2 a');
	var current_category = null;
	sections.each(function() {
		$(this).click(function(e) {
			sections.each(function() {
				$(this).removeClass('active');
			});
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
		var link = anchor.data('link');
		var description = anchor.parent().parent().parent().find('.description:first').html().trim();
		var preview = anchor.parent().parent().parent().find('.image img').data('preview');
		current_category = anchor.data('category');
		setTitle(title, link);
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
			player.attr({id: new_id}).css({background: 'url(' . siteurl + new_preview + ') no-repeat top left'});
			if (!autoplay) {
				player.css('background-image', 'url(' + new_preview + ')');
				play_button = $('<img />');
				play_button.attr({src: siteurl + 'modules/mod_videoplayer/images/play_large.png', alt: 'Play', width: 83, height: 83})
						   .css({'margin-top': (player.height() -83) / 2, 'margin-left': (player.width() - 83) / 2})
						   .appendTo(player);
			}
			flowplayer(new_id, siteurl + 'modules/mod_videoplayer/swf/flowplayer.swf', {
				key: '#$4a11216191dd06befb1',
				simulateiDevice: true,
				autoplay: autoplay,
				plugins: {
					pseudo: {
						url: siteurl + 'modules/mod_videoplayer/swf/flowplayer.pseudostreaming.swf'
					},
					gatracker: {
						url: siteurl + 'modules/mod_videoplayer/swf/flowplayer.analytics.swf',
						labels: {
							start: 'Inicio',
							play: 'Reproducir',
							pause: 'Pausar',
							resume: 'Resumir',
							seek: 'Buscar',
							stop: 'Detener',
							finish: 'Final',
							mute: 'Mute',
							unmute: 'Unmute',
							fullscreen: 'Pantalla completa',
							fullscreenexit: 'Salir de pantalla completa'
						},
						events: {
							all: true
						},
						trackingMode: 'AS3',
						accountId: ga_id
					}
				},
				clip: {
					provider: 'pseudo',
					url: new_video,
					autoPlay: autoplay,
					eventCategory: current_category + ' - ' + title_holder.text()
				},
				onFinish: function() {
					this.unload();
				}
			}).ipad();
		}
	}
});
