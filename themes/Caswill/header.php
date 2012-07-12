<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title(''); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/jbase.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
		<script type="text/javascript">
			document.documentElement.className = "js";
		</script>
		<?php wp_head(); ?>
		<script type="text/javascript">		
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-33347231-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</head>
	<body>
		<div id="wrapper">
			<div class="jbasewrap">