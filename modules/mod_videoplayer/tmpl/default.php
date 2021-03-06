
<div class="mod_videoplayer" id="video-player-<?= $module->id ?>">
	<div class="video-player-inner">
		<div class="module-title">
		</div>
		<? if ($params->get('show_sections')) : ?>
		<div class="video-sections">
			<h3>Secciones</h3>
			<span></span>
			<div class="scrollbar">
				<ul class="sections">
					<? foreach ($categories as $item) : ?>
					<?
					$category = $item['category'];
					$videos = $item['videos'];
					?>
					<li class="section">
						<h2>
							<a href="<?= $category->link ?>" title="<?= $category->title ?>"><?= $category->title ?></a>
						</h2>
						<ul class="section-videos" id="section-<?= $category->id ?>-videos">
							<? foreach ($videos as $video) : ?>
							<li class="video">
								<strong>
									<? if ($video->parent) : ?>
									<?= $video->parent ?> / 
									<? endif ?>
									<?= $video->category ?>
								</strong>
								<div class="image">
									<img src="<?= $video->image ?>" width="<?= $params->get('image_width') ?>" height="<?= $params->get('image_height') ?>" alt="<?= str_replace('"', '&quote;', $video->title) ?>" data-preview="<?= $video->preview ?>" />
								</div>
								<div class="date">
									<?= $video->date ?>&nbsp;
								</div>
								<div class="duration">
									<?= $video->time ?>
								</div>
								<div class="title">
									<h2>
										<a id="<?= $video->id ?>" href="<?= $video->source ?>" data-category="<?= str_replace(array('"', '\''), '&quote;', $category->title) ?>" data-link="<?= $video->link ?>" title="<?= $video->title ?>"><?= $video->title ?></a>
									</h2>
								</div>
								<div class="description" style="display: none;">
									<?= $video->description ?>
								</div>
							</li>
							<? endforeach ?>
						</ul>
					</li>
					<? endforeach ?>
					<? if ($count < 11) : ?>
					<? for ($i = 0; $i < (11 - $count); $i++) : ?>
					<li class="section">
					</li>
					<? endfor ?>
					<? endif ?>
				</ul>
			</div>
		</div>
		<? endif ?>
		<div class="video-playlist">
			<h3>Videos</h3>
			<span></span>
			<div class="scrollbar">
				<ul class="playlist">
				</ul>
			</div>
		</div>
		<div class="video-player">
			<div class="video" style="width: <?= $params->get('player_width') ?>px; height: <?= $params->get('player_height') ?>px;">
			</div>
			<div class="content">
				<? if ($params->get('show_title')) : ?>
				<div class="title">
					<span></span>
					<h3>
						<a></a>
					</h3>
				</div>
				<? endif ?>
				<? if ($params->get('show_description')) : ?>
				<div class="description">
				</div>
				<? endif ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var ga_id = "UA-29389882-1";
</script>