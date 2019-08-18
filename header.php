<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
<?php
wp_body_open();

/**
 * Functions hooked into conj_lite_before_site action
 *
 * @hooked 	conj_lite_handheld_navigation 		- 10
 */
 do_action( 'conj_lite_before_site' ); ?>

<div id="conj-lite-site-wrapper">
	<div id="page" class="hfeed site c-offcanvas-content-wrap">
		<header id="masthead" class="site-header" role="banner">
			<div class="col-full">
				<?php
				/**
				 * Functions hooked into conj_lite_header action
				 *
				 * @hooked conj_lite_skip_links             - 0
				 * @hooked conj_lite_site_branding          - 10
				 * @hooked conj_lite_wc_search_field        - 20
				 * @hooked conj_lite_wc_header_cart         - 30
				 * @hooked conj_lite_primary_navigation     - 40
				 */
				do_action( 'conj_lite_header' ); ?>
			</div>
		</header><!-- #masthead -->
		<div id="content" class="site-content" tabindex="-1">
			<div class="col-full">
				<?php
				/**
				 * Functions hooked into conj_lite_header action
				 *
				 * @hooked 	conj_lite_site_container_wrapper		 - 5
				 * @hooked 	woocommerce_breadcrumb 					 - 10
				 * @hooked 	conj_lite_wc_shop_messages 				 - 15
				 */
				do_action( 'conj_lite_site_content_top' ); ?>