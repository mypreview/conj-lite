<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package 	mypreview-conj
 */
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/**
 * Functions hooked into mypreview_conj_lite_before_site action
 *
 * @hooked 	mypreview_conj_lite_handheld_navigation 					  - 10
 */
 do_action( 'mypreview_conj_lite_before_site' ); ?>

<div id="page" class="hfeed site c-offcanvas-content-wrap">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'conj-lite' ); ?></a>
	<header id="masthead" class="site-header jarallax" role="banner" data-jarallax data-speed="1">
		<div class="col-full">
		
		<?php
		/**
		 * Functions hooked into mypreview_conj_lite_header action
		 *
		 * @hooked mypreview_conj_lite_skip_links                        - 0
		 * @hooked mypreview_conj_lite_site_branding                    - 30
		 * @hooked mypreview_conj_lite_wc_search_field                  - 40
		 * @hooked mypreview_conj_lite_wc_header_cart                   - 50
		 * @hooked mypreview_conj_lite_primary_navigation               - 60
		 * @hooked mypreview_conj_lite_header_image					   - 99
		 */
		do_action( 'mypreview_conj_lite_header' ); ?>

		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content" tabindex="-1">

		<?php
		/**
		 * Functions hooked into mypreview_conj_lite_header action
		 *
		 * @hooked 	mypreview_conj_lite_site_container_wrapper			- 5
		 * @hooked 	woocommerce_breadcrumb 							- 10
		 */
		do_action( 'mypreview_conj_lite_site_content_top' ); ?>