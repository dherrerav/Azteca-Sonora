<form name="JAFrom" id="JAFrom" action="index.php" method="post">
<h6><?php echo JText::_("EMBED_A_YOUTUBE_VIDEO");?></h6>
<p><?php echo JText::_("ENTER_THE_VIDEO_URL_TO_EMBED_BELOW")?>:</p>
<input type="text" id="txtYouTubeUrl" name="txtYouTubeUrl" value=""/>
<input type="hidden" name="option" value="com_jacomment" />
<input type="hidden" name="view" value="comments" />
<input type="hidden" name="layout" value="youtube" />
<input type="hidden" name="task" value="embed_youtube" />
<input type="hidden" name="tmpl" value="component" />
<input type="hidden" name="id" value="<?php echo $this->id;?>" />
</form>