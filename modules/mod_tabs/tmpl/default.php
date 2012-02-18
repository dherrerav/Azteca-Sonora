<div class="tabs">
	<ul class="tabs-navigation">
		<? foreach ($tabs as $tab) : ?>
		<li class="tab">
			<?= $tab[1] ?>
		</li>
		<? endforeach ?>
	</ul>
	<? foreach ($tabs as $tab) : ?>
	<div class="tab-container">
		<div class="tab-content">
			<?= $tab ?>
		</div>
	</div>
	<? endforeach ?>
</div>