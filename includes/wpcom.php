<?php
/**
 * WordPress.com-specific functions and definitions
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

/**
 * Adds support for wp.com-specific `conj-lite` theme functions.
 *
 * @uses 	add_theme_support()
 * @return  void
 */
function conj_lite_wpcom_setup() {

	global $themecolors;

	// Set theme colors for third party services.
	if ( ! isset( $themecolors ) ) {
		// Whitelist wpcom specific variable intended to be overruled.
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
		$themecolors = array(
			'bg' => '',
			'border' => '',
			'text' => '',
			'link' => '',
			'url' => ''
		);
	} // End If Statement

	/* Add WP.com print styles */
	add_theme_support( 'print-styles' );

}
add_action( 'after_setup_theme',   'conj_lite_wpcom_setup',   10 );