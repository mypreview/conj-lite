<?php
/**
 * Back compat functionality
 * Inspired by Twenty Sixteen `back-compat.php`
 *
 * Prevents Conj Lite from running on WordPress versions prior to 4.8,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.8.
 *
 * @link 		https://github.com/WordPress/twentysixteen
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.0
 */

/**
 * Prevent switching to Conj Lite on old versions of WordPress.
 * Switches to the default theme.
 */
if ( ! function_exists( 'mypreview_conj_lite_switch_theme' ) ):
	function mypreview_conj_lite_switch_theme() {

		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
		unset( $_GET['activated'] );
		add_action( 'admin_notices', 'mypreview_conj_lite_upgrade_notice', 10 );

	}
endif;
add_action( 'after_switch_theme', 'mypreview_conj_lite_switch_theme', 10 );
/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Conj Lite on WordPress versions prior to 4.8.
 * @global string $wp_version WordPress version.
 */
if ( ! function_exists( 'mypreview_conj_lite_upgrade_notice' ) ):
	function mypreview_conj_lite_upgrade_notice() {

		/* translators: %s: Version number, i.e. 4.8. */
		$message = sprintf( esc_html_e( 'Conj Lite requires at least WordPress version 4.8. You are running version %s. Please upgrade and try again.', 'conj-lite' ) , $GLOBALS['wp_version']);
		printf( '<div class="error"><p>%s</p></div>', $message );

	}
endif;
/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.8.
 * @global string $wp_version WordPress version.
 */
if ( ! function_exists( 'mypreview_conj_lite_customize' ) ):
	function mypreview_conj_lite_customize() {

		/* translators: %s: Version number, i.e. 4.8. */
		wp_die( sprintf( esc_html_e( 'Conj Lite requires at least WordPress version 4.8. You are running version %s. Please upgrade and try again.', 'conj-lite' ) , $GLOBALS['wp_version'] ) , '', array(
			'back_link' => TRUE
		) );

	}
endif;
add_action( 'load-customize.php', 'mypreview_conj_lite_customize', 10 );
/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.8.
 * @global string $wp_version WordPress version.
 */
if ( ! function_exists( 'mypreview_conj_lite_preview' ) ):
	function mypreview_conj_lite_preview() {

		if ( isset( $_GET['preview'] ) ):
			/* translators: %s: Version number, i.e. 4.8. */
			wp_die( sprintf( esc_html_e( 'Conj Lite requires at least WordPress version 4.8. You are running version %s. Please upgrade and try again.', 'conj-lite' ) , $GLOBALS['wp_version'] ) );
		endif;

	}
endif;
add_action( 'template_redirect', 'mypreview_conj_lite_preview', 10 );