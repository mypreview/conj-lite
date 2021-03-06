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
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
// Assign the "Conj Lite" info to constants.
$conj_lite_theme = wp_get_theme( 'conj-lite' );

define( 'CONJ_LITE_THEME_NAME', $conj_lite_theme->get( 'Name' ) );
define( 'CONJ_LITE_THEME_URI', $conj_lite_theme->get( 'ThemeURI' ) );
define( 'CONJ_LITE_THEME_AUTHOR', $conj_lite_theme->get( 'Author' ) );
define( 'CONJ_LITE_THEME_AUTHOR_URI', $conj_lite_theme->get( 'AuthorURI' ) );
define( 'CONJ_LITE_THEME_VERSION', $conj_lite_theme->get( 'Version' ) );
define( 'CONJ_LITE_THEME_DEMO_API', 'https://api.mypreview.one/demo-uploads/conj/sites' );

// Back compat functionality
require get_parent_theme_file_path( '/includes/back-compat.php' );

/**
 * Initialize all the things.
 * Functions and definitions
 */
$conj_lite = ( object )array(
	'version' => CONJ_LITE_THEME_NAME,
	'main' => require get_parent_theme_file_path( '/includes/class-conj-lite.php' ),
	'customizer' => require get_parent_theme_file_path( '/includes/customizer/class-conj-lite-customizer.php' ),
	'customizer_styles'	=> require get_parent_theme_file_path( '/includes/customizer/class-conj-lite-customizer-styles.php' )
);

require get_parent_theme_file_path( '/includes/conj-lite-functions.php' );
require get_parent_theme_file_path( '/includes/conj-lite-template-hooks.php' );
require get_parent_theme_file_path( '/includes/conj-lite-template-functions.php' );

/**
 * Query whether "WooCommerce" is activated or NOT.
 *
 * @see 	https://docs.woocommerce.com/document/query-whether-woocommerce-is-activated/
 */
if ( conj_lite_is_woocommerce_activated() ) {
	$conj_lite->woocommerce = require get_parent_theme_file_path( '/includes/woocommerce/class-conj-lite-woocommerce.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/conj-lite-woocommerce-template-hooks.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/conj-lite-woocommerce-template-functions.php' );
} // End If Statement

/**
 * Whether the current request is for an administrative interface page
 * 
 * @see 	https://developer.wordpress.org/reference/functions/is_admin/
 * @see 	https://developer.wordpress.org/reference/functions/current_user_can/
 * @see 	https://github.com/TGMPA/TGM-Plugin-Activation
 */
if ( is_admin() && current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) {
	$conj_lite->admin = require get_parent_theme_file_path( '/includes/nux/class-conj-lite-nux-admin.php' );
	require get_parent_theme_file_path( '/includes/nux/tgmpa/class-tgm-plugin-activation.php' );
	require get_parent_theme_file_path( '/includes/nux/tgmpa/class-conj-lite-nux-tgmpa-register.php' );

	/**
	 * Query whether "One click demo import" is activated or NOT.
	 *
	 * @see 	https://github.com/proteusthemes/one-click-demo-import
	 * @see 	https://developer.wordpress.org/reference/functions/current_user_can/
	 */
	if ( class_exists( 'OCDI_Plugin' ) ) {
		$conj_lite->demo_import = require get_parent_theme_file_path( '/includes/nux/ocdi/class-conj-lite-nux-ocdi.php' );
	} // End If Statement
} // End If Statement

/**
 * Note: Do not add any custom code here!
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 */