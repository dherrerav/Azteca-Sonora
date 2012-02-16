<div id="jacom-mainwrap">
	<div id="jacom-mainnav">
		<div class="inner">
			<div class="ja-showhide">
				<a id="menu_open" href="javascript:;" onclick="JATreeMenu.openall();" title="Open all" class=""><?php echo JText::_('OPEN_ALL'); ?></a>
				<a id="menu_close" href="javascript:;" onclick="JATreeMenu.closeall();" title="Close all" class=""><?php echo JText::_('CLOSE_ALL'); ?></a>
			</div>
				<?php JAMenu::_menu();?>
			<script type="text/javascript">
				JATreeMenu.initmenu();
			</script>	
		</div>
	</div>
	
	<div id="jacom-maincontent">
		<?php JView::display($tpl); ?>
	</div>
	
	<div id="jacom-footer">
		<?php include (dirname(__file__).DS.'footer.php'); ?>
	</div>
</div>