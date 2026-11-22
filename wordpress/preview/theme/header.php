<?php
/**
 * Site header: top line, brand and navigation.
 *
 * @package oneness-globe
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#071d42">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
<div class="topline">ONENESS GLOBE &nbsp;·&nbsp; EMPOWERED BY UNITY &nbsp;·&nbsp; VETERINARY HEALTHCARE</div>
<header class="site-header">
	<div class="container nav">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img alt="Oneness Globe official logo" width="48" height="48" src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo.webp' ); ?>">
			<div>
				<div class="brand-name">ONENESS GLOBE</div>
				<div class="brand-sub">EMPOWERED BY UNITY</div>
			</div>
		</a>
		<nav class="links" aria-label="Main navigation">
			<a href="<?php echo esc_url( home_url( '/#products' ) ); ?>">Products</a>
			<a href="<?php echo esc_url( home_url( '/#purpose' ) ); ?>">Our Purpose</a>
			<a class="nav-contact" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Get in Touch ↗</a>
		</nav>
	</div>
</header>
<main id="main">
