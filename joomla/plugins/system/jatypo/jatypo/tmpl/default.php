<?php
	$file = dirname(dirname (__FILE__)).DS.'typo'.DS.'index.html';		
	//$html = $this->loadTemplate ($tmpl);
	$html = file_get_contents ($file);
	if (preg_match ('/<body[^>]*>(.*)<\/body>/s', $html, $matches)) $html = $matches[1];
	
	$base_url = JURI::base();
	global $mainframe;		
	if($mainframe->isAdmin()) {
		$base_url = dirname ($base_url);
	}
	$jatypo = JRequest::getCmd ('jatypo');
	$typocss = $base_url.'/plugins/system/jatypo/typo/typo.css';
?>

<div id="jatypo-wrap">
<?php echo $html?>
<?php if (!$jatypo) : ?>
<a href="<?php echo "$base_url?jatypo=1"?>" rel="{handler: 'iframe', size: {x: 800, y: 600}}" class="modal"><span><?php echo JText::_('View All')?></span></a>
<?php endif ?>
</div>	

<?php if (!$jatypo) : ?>
<script type="text/javascript">
window.addEvent ('load', function () {
	new JATypo ({'typocss':'<?php echo $typocss ?>'});
});
</script>
<?php endif ?>