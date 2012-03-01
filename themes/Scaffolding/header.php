<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 */
			global $page, $paged;
		
			wp_title( '|', true, 'right' );
		
			// Add the blog name.
			bloginfo( 'name' );
		
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
		
			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
		?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/jbase.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" />
		<style type="text/css">
			/* using image replacement instead of img tag for header image */
			.imgreplace a {
				text-indent: -9999px;
				overflow: hidden;
				display: block;
				background-repeat: no-repeat;
			}
			
			h1.imgreplace a {
				background-image: url(<?php header_image(); ?>);
				width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
				height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
			}
		</style>
		<?php wp_head(); ?>
	</head>
	<body>
		<div id="wrapper">
			<div class="jbasewrap">
				<h1 class="imgreplace grid6col left"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<?php wp_nav_menu( array(
					'theme_location' => 'main_menu', 
					'container_id' => 'main_menu',
					'container_class' => 'grid6col right',
					'menu_class' => 'noBullets ' 
					)
				); ?>
				<div class="grid6col right margintop alignright">
				Right float widget area
				</div>
				<br class="clearboth" />
				