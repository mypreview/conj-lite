<?php
/**
 * Conj Lite functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * Do not add any custom code here.
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 *
 * @see 		https://codex.wordpress.org/Theme_Development
 * @see 		https://codex.wordpress.org/Plugin_API
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.6
 */

// Assign the "Conj Lite" info to constants.
$conj_theme = wp_get_theme( 'conj-lite' );

define( 'MYPREVIEW_CONJ_LITE_THEME_NAME', $conj_theme->get( 'Name' ) );
define( 'MYPREVIEW_CONJ_LITE_THEME_URI', 'https://www.mypreview.one/conj.html' );
define( 'MYPREVIEW_CONJ_LITE_THEME_AUTHOR', $conj_theme->get( 'Author' ) );
define( 'MYPREVIEW_CONJ_LITE_THEME_VERSION', $conj_theme->get( 'Version' ) );
define( 'MYPREVIEW_CONJ_LITE_THEME_SUPPORT_URI', 'https://support.mypreview.one' );
define( 'MYPREVIEW_CONJ_LITE_THEME_DOC_URI', 'https://mypreview.github.io/Conj' );

// Conj Lite only works in WordPress 4.8 or later.
if ( version_compare( $GLOBALS['wp_version'], '4.8', '<' ) ) {
	require get_parent_theme_file_path( 'includes/back-compat.php' );
	return;
} // End If Statement

/**
 * Initialize all the things.
 * Functions and definitions
 */
$conj = ( object )array(
	'version' 				=> 		MYPREVIEW_CONJ_LITE_THEME_VERSION,
	'main' 					=> 		require get_parent_theme_file_path( '/includes/class-conj.php' ),
	'customizer' 			=> 		require get_parent_theme_file_path( '/includes/customizer/class-conj-customizer.php' ),
);

require get_parent_theme_file_path( '/includes/conj-functions.php' );
require get_parent_theme_file_path( '/includes/conj-template-hooks.php' );
require get_parent_theme_file_path( '/includes/conj-template-functions.php' );

/**
 * Query whether "WooCommerce" is activated or NOT.
 *
 * @see 	https://docs.woocommerce.com/document/query-whether-woocommerce-is-activated/
 */
if ( class_exists( 'WooCommerce' ) ) {
	
	$conj->woocommerce = require get_parent_theme_file_path( '/includes/woocommerce/class-conj-woocommerce.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/conj-woocommerce-template-hooks.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/conj-woocommerce-template-functions.php' );

} // End If Statement