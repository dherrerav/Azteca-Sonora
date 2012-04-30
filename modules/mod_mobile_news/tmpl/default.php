<? defined('_JEXEC') or die ?>
<div class="articles<?= $moduleclass_sfx ?>">
<? foreach ($articles as $article) : ?>
	<article class="article">
		<header class="header">
			<h3 class="category">
				<a href="<?= $article->categoryLink ?>" title="<?= $article->category_title ?>">
					<?= $article->category_title ?>
				</a>
			</h3>
			<h3>
				<a href="<?= $article->link ?>" title="<?= $article->title ?>">
					<?= $article->title ?>
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
			<?= $article->introtext ?>
		</div>
		<footer class="share">
			<div class="social-tools">
			</div>
		</footer>
	</article>
<? endforeach ?>
</div>