<? defined('_JEXEC') or die ?>
<? $host = 'http://' . rtrim(JURI::base(), '/') ?>
<div class="articles<?= $moduleclass_sfx ?>">
<? foreach ($articles as $article) : ?>
	<article class="article">
		<header class="header">
			<h3 class="title">
				<a href="<?= $article->link ?>" title="<?= $article->title ?>">
					<?= $article->title ?>
				</a>
			</h3>
			<h3 class="category">
				<a href="<?= $article->categoryLink ?>" title="<?= $article->category_title ?>">
					<?= $article->category_title ?>
				</a>
			</h3>
		</header>
		<div class="info">
			<div class="author">
				<p><?= sprintf('Por %s', $article->author) ?><br /><a href="mailto:<?= $article->author_email ?>"><?= $article->author_email ?></a></p>
			</div>
			<div class="date">
				<p><?= sprintf('%s, %s de %s de %s', ucfirst($article->date->get(Zend_Date::WEEKDAY)), $article->date->get(Zend_Date::DAY), $article->date->get(Zend_Date::MONTH), $article->date->get(Zend_Date::YEAR)) ?></p>
			</div>
		</div>
		<div class="content">
			<? if ($article->image) : ?>
			<a href="<?= $article->link ?>" title="<?= $article->title ?>">
				<img src="<?= $article->image ?>" alt="<?= $article->title ?>" />
			</a>
			<? endif ?>
			<?= $article->introtext ?>
		</div>
		<footer class="footer">
			<div class="social-tools">
				<ul class="unstyled">
					<li class="share-email">
						<a href="<?= $host . $article->link ?>">Email</a>
					</li>
					<li class="share-twitter">
						<a href="<?= $host . $article->link ?>">Twitter</a>
					</li>
					<li class="share-facebook">
						<a href="<?= $host . $article->link ?>">Facebook</a>
					</li>
					<li class="share-gplus">
						<a href="<?= $host . $article->link ?>">Google</a>
					</li>
				</ul>
			</div>
		</footer>
	</article>
<? endforeach ?>
</div>