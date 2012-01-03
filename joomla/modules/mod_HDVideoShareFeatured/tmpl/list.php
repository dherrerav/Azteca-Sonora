<?php
defined('_JEXEC') or die('Restricted access');

$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
JHTML::_('stylesheet', JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css', array(), true);
JHTML::_('stylesheet', JURI::base() . 'components/com_contushdvideoshare/css/tool_tip.css', array(), true);

setlocale(LC_ALL, 'es_MX');

if ($result) {
?>
<div class="featured-videos-container">
<h3 class="featured-videos">
    <span class="date"><?= date('j \d\e F \d\e Y') ?></span>
</h3>
<a href="javascript:void(0);" class="prev"></a>
<div id="featured-videos" class="featured-videos">
<ul>
<?
	foreach ($result as $row) {
?>
<?php
	$orititle = $row->title;
	$newtitle = explode(' ', $orititle);
    $displaytitle = implode('-', $newtitle);
?>
	<li>
		<?
		if ($row->filepath == "File" || $row->filepath == "FFmpeg")
            $src_path = JURI::base() . "components/com_contushdvideoshare/videos/" . $row->thumburl;
        if ($row->filepath == "Url" || $row->filepath == "Youtube")
            $src_path = $row->thumburl;
		?>
        <div class="show-image-container">
		<a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $row->id . "&catid=" . $row->catid); ?>">
			<img src="<?= $src_path ?>" width="107" height="67" />
            <span class="play-icon"></span>
		</a>
        </div>
        <div class="show-title-container">
            <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $row->id . "&catid=" . $row->catid); ?>" class="show-title-gray info_hover"><?= $row->title ?></a>
        </div>
	</li>
<?
	}
?>
</ul>
</div>
<a href="javascript:void(0);" class="next"></a>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('#featured-videos').jCarouselLite({
        btnNext: '.next',
        btnPrev: '.prev',
        visible: 4,
        circular: true
    });
});
</script>
<?php $t = count($result); if ($t > 1) { ?><div class="clear"></div> <div align="right" class="morevideos"><a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=featuredvideos"); ?>"><?php echo _HDVS_MORE_VIDEOS; ?></a></div><?php } ?>
<?
}