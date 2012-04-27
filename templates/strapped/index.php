<?php

defined('_JEXEC') or die;
define('DEBUG', false);
// detecting device browser
JLoader::register("TemplateHelper", dirname(__FILE__).'/php/template-helper.php');
$user_agent = TemplateHelper::getBrowserAgent();
$browser_classes = TemplateHelper::custom_browser_info();
$custom_logo = TemplateHelper::custom_logo();
$site_home = TemplateHelper::detect_home();
$document = JFactory::getDocument();
$app = JFactory::getApplication();

// Column widths
$leftcolgrid 	= $this->params->get('columnWidth', 4);
$rightcolgrid	= $this->params->get('columnWidth', 4);

// custom body font
$body_font = $this->params->get('bodyFont', '');
$body_font_class = $body_font ? 'b_'.strtolower($body_font) : '';

// custom heading font
$heading_font = $this->params->get('headingFont', '');
$heading_font_class = $heading_font ? 'h_'.strtolower($heading_font) : '';

// detecting active variables
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
$layout = JRequest::getCmd('layout', '');
$task = JRequest::getCmd('task', '');
$itemid = JRequest::getCmd('Itemid', '');

// detecting page title
$mydoc =& JFactory::getDocument();
$page_title = $mydoc->getTitle();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<!-- Le styles -->
<meta name="viewport" content="width=device-width, maximum-scale=1">
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/docs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/prettify.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap-extended.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/joomla.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap-responsive.css" type="text/css" media="screen" />

<!-- Le touch icons -->
<link rel="apple-touch-icon" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/icons/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/icons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/iconsapple-touch-icon-114x114.png">
<jdoc:include type="head" />
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


<?php
if ($this->countModules('left') == 0):?>
<?php $leftcolgrid  = "0";?>
<?php endif; ?>
<?php
if ($this->countModules('right') == 0):?>
<?php $rightcolgrid  = "0";?>
<?php endif; ?>
<?php if ($this->params->get('template-width') == 1):?>
<?php $template_width = "-fluid" ;?>
<?php else :?>
<?php $template_width = "" ;?>
<?php endif; ?>

<?php
// This loads styles specific the the supported extensions for this template. It will only load the CSS file for the extension when you are on the page that uses it.
$custom_css = '';
if( $this->params->get('bodyColor') ) :
$custom_css = '
body {
	background-color:#' . $this->params->get('bodyColor') . ';
	}
';
endif;
// Custom gradient for header area
if(($this->params->get('headerColorTop') || $this->params->get('headerColorBottom'))) :
$header_top = $this->params->get('headerColorTop');
$header_bottom = $this->params->get('headerColorBottom');
$custom_css .= '
#header {
	background-color: #' . $this->params->get('headerColorTop') . ';
	background-image: -moz-linear-gradient(top, #' . $header_top . ', #' . $header_bottom . ');
	background-image: -ms-linear-gradient(top, #'  . $header_top . ', #' . $header_bottom . ');
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#' . $header_top . '), to(' . $header_bottom . '));
	background-image: -webkit-linear-gradient(top, #' . $header_top . ', #' . $header_bottom . ');
	background-image: -o-linear-gradient(top, #' . $header_top . ', #' . $header_bottom . ');
	background-image: linear-gradient(top, #' . $header_top . ', #' . $header_bottom . ');
	background-repeat: repeat-x;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#' . $header_top . '", endColorstr="#' . $header_bottom . '", GradientType=0);
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  	-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
	}';
endif;


// Custom gradient for above area
if(($this->params->get('aboveColorTop') || $this->params->get('aboveColorBottom'))) :
$above_top = $this->params->get('aboveColorTop');
$above_bottom = $this->params->get('aboveColorBottom');
$custom_css .= '
#above {
	background-color: #' . $this->params->get('aboveColorTop') . ';
	background-image: -moz-linear-gradient(top, #' . $above_top . ', #' . $above_bottom . ');
	background-image: -ms-linear-gradient(top, #'  . $above_top . ', #' . $above_bottom . ');
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#' . $above_top . '), to(' . $above_bottom . '));
	background-image: -webkit-linear-gradient(top, #' . $above_top . ', #' . $above_bottom . ');
	background-image: -o-linear-gradient(top, #' . $above_top . ', #' . $above_bottom . ');
	background-image: linear-gradient(top, #' . $above_top . ', #' . $above_bottom . ');
	background-repeat: repeat-x;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#' . $above_top . '", endColorstr="#' . $above_bottom . '", GradientType=0);
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  	-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
	}';
endif;


// Check to see if anything is in $custom_css and display CSS in header if there is anything in it
if( $custom_css ) :
$document->addStyleDeclaration($custom_css);
endif;
?>

</head>
<body class="<?php echo $option . " " . $view . " " . $layout . " " . $task . " item-" . $itemid;?> <?php if($site_home){ echo "home";}?> <?php echo $body_font_class.' '.$heading_font_class.' '.$browser_classes;?>" data-spy="scroll" data-target=".subnav" data-offset="50" data-redering="true">
<!-- Navbar
    ================================================== -->
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container<?php echo $template_width; ?>"> 
			<?php echo $custom_logo; ?>
			<?php if($this->countModules('top-nav')) : ?>
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
			</a> 
			<?php endif; ?>
			
			<?php if($this->countModules('top-nav')) : ?>
			<div class="nav-collapse">
				<jdoc:include type="modules" name="top-nav" style="none" />
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php if(($this->countModules('header') || $this->countModules('sub-nav'))) : ?>
<!-- Masthead
================================================== -->
<div id="header">
	<div class="container<?php echo $template_width; ?>">
	<header class="jumbotron <?php if($site_home) : ?>mast<?php else : ?>sub<?php endif ; ?>head">
			<?php if($this->countModules('header')) : ?>
			<jdoc:include type="modules" name="header" style="none" />	
			<?php endif; ?>
			<?php if($this->countModules('sub-nav')) : ?>
			<div class="subnav">
				<jdoc:include type="modules" name="sub-nav" style="none" />	
			</div>
			<?php endif; ?>
	</header>
	</div>
</div>
<?php endif; ?>

<?php if($this->countModules('above')) : ?>
<!-- Above Module Position
================================================== -->	
<div id="above">
	<div class="container<?php echo $template_width; ?>">
		<div class="row<?php echo $template_width; ?>">
			<jdoc:include type="modules" name="above" style="xhtml" />	
		</div>
	</div>
</div>
<?php endif; ?>
<div class="container<?php echo $template_width; ?>">
	<!-- Content
	================================================== -->
	<div id="content">
		<jdoc:include type="message" />
		
		<?php if($this->countModules('breadcrumbs')) : ?>
		<div id="breadcrumbs" class="row<?php echo $template_width; ?>">
			<jdoc:include type="modules" name="breadcrumbs" style="xhtml" />
		</div>
		<?php endif; ?>
		<?php if($this->countModules('top')) : ?>
		<!-- Top Module Position -->	
		<div id="top" class="row<?php echo $template_width; ?>">
			<jdoc:include type="modules" name="top" style="xhtml" />	
		</div>
		<hr />
		<?php endif; ?>
		<div id="main" class="row<?php echo $template_width; ?>">
			<!-- Left -->
			<?php if($this->countModules('left')) : ?>
			<div id="sidebar" class="span<?php echo $leftcolgrid;?>">
				<jdoc:include type="modules" name="left" style="xhtml" />
			</div>
			<?php endif; ?>
			<!-- Component -->
			<div id="content" class="span<?php echo (12-$leftcolgrid-$rightcolgrid);?>">
				<?php if($this->countModules('above-content')) : ?>
				<!-- Above Content Module Position -->	
				<div id="above-content">
					<jdoc:include type="modules" name="above-content" style="xhtml" />	
				</div>
				<hr />
				<?php endif; ?>
				<jdoc:include type="component" />
				<?php if($this->countModules('below-content')) : ?>
				<!-- Below Content Module Position -->	
				<hr />
				<div id="below-content">
					<jdoc:include type="modules" name="below-content" style="xhtml" />	
				</div>
				<?php endif; ?>
			</div>
			<!-- Right -->
			<?php if($this->countModules('right')) : ?>
			<div id="sidebar-2" class="span<?php echo $rightcolgrid;?>">
				<jdoc:include type="modules" name="right" style="xhtml" />
			</div>
			<?php endif; ?>
		</div>
		<?php if($this->countModules('bottom')) : ?>
		<!-- Bottom Module Position -->	
		<hr />
		<div id="bottom" class="row<?php echo $template_width; ?>">
			<jdoc:include type="modules" name="bottom" style="xhtml" />	
		</div>
		<?php endif; ?>
	</div>
	<?php if($this->countModules('below')) : ?>
	<!-- Below Module Position
	================================================== -->	
	<hr />
	<div id="below" class="row<?php echo $template_width; ?>">
		<jdoc:include type="modules" name="below" style="xhtml" />	
	</div>
	<?php endif; ?>
	<!-- Footer
	================================================== -->
	<footer class="footer">
		<p class="pull-right"><a href="#">Back to top</a></p>
		<jdoc:include type="modules" name="footer" style="none" />	
	</footer>
	<jdoc:include type="modules" name="debug" />
</div><!-- /container -->
<!-- Le javascript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.js"></script> 
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js"></script> 
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/application.js"></script> 
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/prettify.js"></script> 
<script type="text/javascript">
        jQuery.noConflict();
</script>
<? if (DEBUG) : ?>
<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
<? endif ?>
</body>
</html>