<?php
/**
 * @copyright	Copyright (C) 2009-2011 Pixel Praise LLC. All rights reserved.
 * @license		All derivate Joomla! code is GNU/GPL, all images and are bound by the Pixel Praise Proprietary License.
 */

// no direct access
defined('_JEXEC') or die;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="apple-touch-icon" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/images/apple-touch-icon.png">
<meta name="apple-touch-fullscreen" content="YES">
<meta name="viewport" content="width = 320" />
<!-- iPhone specific style -->
<style type="text/css" media="only screen and (max-device-width: 480px)">
	@import url( <?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/template.css );
</style>
</head>
<body class="contentpane">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</body>
</html>
