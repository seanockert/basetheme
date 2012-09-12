<!doctype html>
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js " lang="en"><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">

	<title><?php wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?></title>

	<meta name="viewport" content="width=device-width">
	<?php if ( file_exists(TEMPLATEPATH .'/favicon.ico') ) : ?>
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico">
	<?php endif; ?><?php if ( file_exists(TEMPLATEPATH .'/apple-touch-icon.png') ) : ?>
	<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/apple-touch-icon.png">
	<?php endif; ?>

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/normalize.min.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/skeleton.css">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>">

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/responsive.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/buttons.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/fancybox.css">
	
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/general_foundicons.css">
	
	<!--[if lt IE 8]><link rel="stylesheet" href="fonts/general_foundicons_ie7.css"><![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>	
	
		<!--[if lt IE 9]>
			<script src="<?php bloginfo('template_url'); ?>/js/html5shiv.js"></script>
		<![endif]-->
	<?php wp_head(); ?>
</head>

<body>
	<header id="header" role="banner">
		<div class="container">
			<div class="sixteen columns">
				<?php if (is_home() || is_front_page()) : ?>
					<h1 id="logo"><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
				<?php else : ?>
					<div id="logo"><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
				<?php endif; ?>

				<a class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">Menu</a>
				<nav id="nav-collapse" >
					<?php wp_nav_menu( array( 'container_class' => '', 'theme_location' => 'primary' ) ); ?>
				</nav>

				<?php get_search_form(); ?>
			</div>
		</div>
	</header>

	<div class="container">
		<div id="main" class="eleven columns">