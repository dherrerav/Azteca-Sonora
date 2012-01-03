<? $this->genBlockBegin ($block); ?>
<? if ($this->countModules('news-highlighter')) : ?>
<div class="news-highlight">
  <jdoc:include type="modules" name="news-highlighter" style="JAXhtml" />
</div>
<? endif; ?>
<? if ($this->countModules('news-slideshow')) : ?>
<div class="news-slideshow">
  <jdoc:include type="modules" name="news-slideshow" style="JAXhtml" />
</div>
<? endif; ?>
<? $this->genBlockEnd($block); ?>