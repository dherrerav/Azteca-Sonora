<?php
Zend_Loader::loadClass('Zend_Date');
$date = new Zend_Date();
$weekday = $date->toString(Zend_Date::WEEKDAY);
$day = $date->toString(Zend_Date::DAY_SHORT);
$month = $date->toString(Zend_Date::MONTH_NAME);
$year = $date->toString(Zend_Date::YEAR);
$today = sprintf('%s %s de %s de %s', ucfirst($weekday), $day, $month, $year);
?>
<div class="content-carousel">
	<div class="header">
		<div class="date">
			<p><?= $today ?></p>
		</div>
	</div>
	<div class="content-carousel-control prev"></div>
	<div class="content-carousel-inner">
		<ul class="articles" style="width: <?= (count($articles) * $width) ?>px;">
			<? foreach ($articles as $article) : ?>
			<li class="article" style="width: <?= $width ?>px;">
				<div class="article-image">
					<a href="<?= $article->link ?>" title="<?= str_replace('"', '&quote;', $article->title) ?>">
						<span class="play"></span>
						<img src="<?= $article->image ?>" alt="<?= $article->title ?>" title="<?= $article->title ?>" />
					</a>
				</div>
				<div class="article-title">
					<a href="<?= $article->link ?>" title="<?= str_replace('"', '&quote;', $article->title) ?>"><?= $article->title ?></a>
				</div>
			</li>
			<? endforeach ?>
		</ul>
	</div>
	<div class="content-carousel-control next"></div>
</div>
