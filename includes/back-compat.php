<?php
/**
 * Back compat functionality
 * Inspired by Twenty Sixteen `back-compat.php`
 *
 * Prevents Conj from running on WordPress versions prior to 5.0 or PHP versions prior to 7.0,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 5.0 and PHP version 7.0.
 *
 * @link 		https://github.com/WordPress/twentysixteen
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} // End If Statement

// Minimum required versions.
define( 'CONJ_LITE_PHP_VERSION', '7.0.0' );
define( 'CONJ_LITE_WORDPRESS_VERSION', '5.0.0' );

// Do not allow the theme to be active if the PHP version is not met.
if ( version_compare( PHP_VERSION, CONJ_LITE_PHP_VERSION, '<' ) ) {
	add_action( 'admin_notices', 'conj_lite_back_compat_php_admin_notice' );
	add_filter( 'conj_lite_back_compat_status', '__return_false', -1 );
} // End If Statement

// Do not allow the theme to be active if the WordPress version is not met.
if ( version_compare( $GLOBALS['wp_version'], CONJ_LITE_WORDPRESS_VERSION, '<' ) ) {
	add_action( 'admin_notices', 'conj_lite_back_compat_wordpress_admin_notice' );
	add_filter( 'conj_lite_back_compat_status', '__return_false', -1 );
} // End If Statement

/**
 * Output a notice that the minimum PHP version is not met.
 *
 * @return void
 */
function conj_lite_back_compat_php_admin_notice() {
	printf( '<div class="notice notice-warning"><p>%s</p></div>', wp_kses_post( conj_lite_get_php_notice_text() ) ); // WPCS: XSS okay.
}

/**
 * PHP upgrade notice text.
 *
 * @return string
 */
function conj_lite_get_php_notice_text() {
	/* translators: 1: Anchor open tag, 2: Anchor close tag, 3: Required PHP version number, 4: Running PHP version number, 5: Anchor open tag, 6: Anchor close tag. */
	$notice_text = sprintf( esc_html__( '%1$sConj Lite - eCommerce WordPress Theme%2$s requires at least PHP version %3$s. You are running version %4$s. Please %5$supgrade%6$s and try again.', 'conj-lite' ), '<a href="' . esc_url( CONJ_LITE_THEME_URI ) . '" target="_blank">', '</a>', esc_html( CONJ_LITE_PHP_VERSION ), esc_html( PHP_VERSION ), '<a href="https://wordpress.org/support/update-php/" target="_blank" rel="noopener noreferrer nofollow">', '</a>' );

	return apply_filters( 'conj_lite_php_notice_text', $notice_text );
}

/**
 * Output a notice that the minimum WordPress version is not met.
 *
 * @return void
 */
function conj_lite_back_compat_wordpress_admin_notice() {
	printf( '<div class="notice notice-warning"><p>%s</p></div>', wp_kses_post( conj_lite_get_wordpress_notice_text() ) ); // WPCS: XSS okay.
}

/**
 * WordPress upgrade notice text.
 *
 * @return string
 */
function conj_lite_get_wordpress_notice_text() {
	/* translators: 1: Anchor open tag, 2: Anchor close tag, 3: Required WordPress version number, 4: Running WordPress version number. */
	$notice_text = sprintf( esc_html__( '%1$sConj Lite - eCommerce WordPress Theme%2$s requires at least WordPress version %3$s. You are running version %4$s. Please upgrade and try again.', 'conj-lite' ), '<a href="' . esc_url( CONJ_LITE_THEME_URI ) . '" target="_blank" rel="noopener noreferrer nofollow">', '</a>', esc_html( CONJ_LITE_WORDPRESS_VERSION ), $GLOBALS['wp_version'] );

	return apply_filters( 'conj_lite_wordpress_notice_text', $notice_text );
}

/**
 * Determine whether the minimum requirements are met or not?
 *
 * @return bool
 */
function conj_lite_back_compat_status() {
	return apply_filters( 'conj_lite_back_compat_status', TRUE );
}