<?php if ($this->isIE() && ($this->getParam('direction')=='rtl' || $this->direction == 'rtl')) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php } ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">

<head>
	<?php //gen head base on theme info
	$this->showBlock ('head');
	?>
</head>

<body id="bd" class="<?php echo $this->getBodyClass();?> contentpane">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</body>

</html>