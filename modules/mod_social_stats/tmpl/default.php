<div class="mod-social-stats">
	<h3><?= $params->get('display_text') ?></h3>
	<ul class="social-stats">
	<? if ($stats->facebook_page_stats) : ?>
		<li>
			<p>
				<a href="<?= $stats->facebook_page_stats->link ?>">
					<img src="http://www.statictvazteca.com/plantillas/maquetacion/footer2011/images/facebook.png" alt="Facebook" />
				</a>
				<strong><?= $stats->facebook_page_stats->fan_count ?></strong>
			</p>
			<p>Fans</p>
		</li>
	<? endif ?>
	<? if ($stats->twitter_stats) : ?>
		<li>
			<p>
				<a href="http://twitter.com/<?= $stats->twitter_stats->screen_name ?>">
					<img src="http://www.statictvazteca.com/plantillas/maquetacion/footer2011/images/twitter.png" alt="Twitter" />
				</a>
				<strong><?= $stats->twitter_stats->followers_count ?></strong>
			</p>
			<p>Seguidores</p>
		</li>
	<? endif ?>
	<? if ($params->get('show_rss')) : ?>
		<li>
			<p>
				<a href="<?= JURI::base() ?>?format=feed&type=rss">
					<img src="http://www.statictvazteca.com/plantillas/maquetacion/footer2011/images/rss.png" alt="RSS" />
				</a>
				<strong>RSS</strong>
			</p>
			<p>Suscr&iacute;bete</p>
		</li>
	<? endif ?>
	</ul>
</div>