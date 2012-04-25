<?php
ini_set('include_path', '.:/usr/share/php:' . dirname(__FILE__) . '/libraries/Zend');
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Date');
$date = dateDifference('now', '2012-04-26 11:00:00');
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
  		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  		<title>Azteca Sonora</title>
  		<meta name="description" content="" />
  		<meta name="viewport" content="width=device-width" />
  		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
  		<link rel="stylesheet" type="text/css" href="css/styles.css">
  		<link rel="shortcut icon" type="image/x-icon" href="templates/ja_t3_blank/local/themes/tvazteca-default/images/favicon.ico" />
  		<script src="js/modernizr.min.js"></script>
  	</head>
  	<body>
  		<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  		<div role="main" id="page">
			<header>
				<div class="container">
					<h3 id="logo">
						<a href="/" title="Azteca Sonora"><span>Azteca Sonora</span></a>
					</h3>
				</div>
			</header>
			<section id="content">
				<div class="container">
					<div class="heading">
						<h1>Azteca Sonora se renueva para ti...</h1>
						<h2>Faltan</h2>
					</div>
					<div class="contentpane">
						<div id="countdown">
						</div>
						<div class="desc">
							<div>D&iacute;as</div>
							<div>Horas</div>
							<div>Minutos</div>
							<div>Segundos</div>
						</div>
					</div>
				</div>
			</section>
			<footer id="footer">
				<div class="container">
				</div>
			</footer>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script>
		var launch_date = '<?= $date ?>';
		</script>
		<script type="text/javascript" src="js/jquery.countdown.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/script.js"></script>
		<script>
		var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
		(function(d, t) {
			var g = d.createElement(t),
				s = d.getElementsByTagName(t)[0];
			g.src = ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g, s)
		}(document,'script'));
		</script>
	</body>
</html>
