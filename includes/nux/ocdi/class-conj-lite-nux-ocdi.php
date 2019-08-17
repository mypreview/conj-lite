<?php
/**
 * Conj lite demo import Class
 *
 * @uses 		One Click Demo Import
 * @link 		https://wordpress.org/plugins/one-click-demo-import/
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Conj_Lite_NUX_Demo_Import' ) ) :

	/**
	 * The demo import Conj class
	 */
	class Conj_Lite_NUX_Demo_Import {

		/**
		 * Setup class.
		 *
		 * @access  public
		 * @return  void
		 */
		public function __construct() {

			add_action( 'pt-ocdi/import_files',     				  		  array( $this, 'import_files' ),              		   10 );
			add_action( 'pt-ocdi/after_import',     				  		  array( $this, 'after_import_setup' ),        		   10 );
			add_action( 'pt-ocdi/confirmation_dialog_options',     			  array( $this, 'confirmation_dialog_options' ),       10 );
			add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import',    '__return_false', 						     	10, 1 );
			add_filter( 'pt-ocdi/disable_pt_branding', 						  '__return_true',  								10, 1 );

		}

		/**
		 * Locate bundled demo data files and import upon request.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/delete_transient/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_kses_post/
		 * @access  public
		 * @return  array
		 */
		public function import_files() {

			global $pagenow;

			// Bring back the admin notice for premium version upgrade.
			if ( 'themes.php' === $pagenow && isset( $_GET['page'] ) && 'pt-one-click-demo-import' === $_GET['page'] ) {
				delete_transient( 'conj_lite_dismiss_upsell_flag' );
			} // End If Statement

			$import_notice = array();
			/* translators: 1: Open small tag, 2: Close small tag. */
			$import_notice[] = sprintf( esc_html_x( '%1$sThe following plugins are used within the selected demo and you may want to install a few or all of them depending on which feature you may want to have on your site.%2$s', 'demo import notice', 'conj-lite' ), '<small>', '</small>' );
			$import_notice[] = '<ol>';
			/* translators: 1: Open list and anchor tag, 2: Open small tag, 3: Close anchor and list tag. */
			$import_notice[] = sprintf( esc_html_x( '%1$sWooCommerce%2$s(Required)%3$s', 'demo import notice', 'conj-lite' ), '<li><a href="https://wordpress.org/plugins/woocommerce" target="_blank" rel="noopener noreferrer nofollow">', '</a>&nbsp;<small>', '</small></li>' );
			/* translators: 1: Open list and anchor tag, 2: Open small tag, 3: Close anchor and list tag. */
			$import_notice[] = sprintf( esc_html_x( '%1$sJetpack by WordPress.com%2$s(Recommended)%3$s', 'demo import notice', 'conj-lite' ), '<li><a href="https://wordpress.org/plugins/jetpack" target="_blank" rel="noopener noreferrer nofollow">', '</a>&nbsp;<small>', '</small></li>' );
			$import_notice[] = '</ol>';
			$import_notice = implode( '', $import_notice );

	    	$import = array(
		        array(
		            'import_file_name' => 'Default',
		            'import_file_url' => sprintf( '%s/6/content.xml', esc_url( CONJ_LITE_THEME_DEMO_API ) ),
		            'import_widget_file_url' => sprintf( '%s/6/widget.wie', esc_url( CONJ_LITE_THEME_DEMO_API ) ),
		            'import_customizer_file_url' => sprintf( '%s/6/customizer.dat', esc_url( CONJ_LITE_THEME_DEMO_API ) ),
		            'import_notice' => wp_kses_post( $import_notice ),
		            'preview_url' => esc_url( CONJ_LITE_THEME_URI ),
		        )
	    	);

	    	return $import;

		}

		/**
		 * Automatically assign “Front page”, “Posts page” and 
		 * menu locations after the importer is done.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/get_term_by/
		 * @see 	https://developer.wordpress.org/reference/functions/set_theme_mod/
		 * @see 	https://developer.wordpress.org/reference/functions/get_page_by_title/
		 * @see 	https://developer.wordpress.org/reference/functions/update_option/
		 * @access  public
		 * @return  void
		 */
		public function after_import_setup( $selected_import ) {

			$primary = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
			$handheld = get_term_by( 'name', 'Push Menu', 'nav_menu' );

			set_theme_mod( 'nav_menu_locations', array( 
				'primary' => $primary->term_id,
				'handheld' => $handheld->term_id 
			) );

			// Assign front page and posts page.
		    $front_page_obj = (object) get_page_by_title( 'WELCOME TO CONJ LITE' );
		    $blog_page_obj = (object) get_page_by_title( 'Blog' );

		    ( ! empty( $front_page_obj ) )  ?  update_option( 'show_on_front', 	'page' )  :  NULL;
		    ( ! empty( $front_page_obj ) ) 	?  update_option( 'page_on_front', 	intval( $front_page_obj->ID ) )  :  NULL;
		    ( ! empty( $blog_page_obj ) )  ?  update_option( 'page_for_posts', intval( $blog_page_obj->ID ) )  :  NULL;

		    // Query whether "WooCommerce" is activated or NOT.
		    if ( conj_lite_is_woocommerce_activated() ) {
		    	// Assign the WooCommerce pages.
		    	$shop_page_obj = (object) get_page_by_title( 'Shop' );
		    	$cart_page_obj = (object) get_page_by_title( 'Cart' );
		    	$checkout_page_obj = (object) get_page_by_title( 'Checkout' );
		    	$myaccount_page_obj = (object) get_page_by_title( 'My account' );
		    	$terms_page_obj = (object) get_page_by_title( 'Terms and Conditions' );

		    	// Set imported WooCommerce pages
		    	( ! empty( $shop_page_obj ) )  ?  update_option( 'woocommerce_shop_page_id', intval( $shop_page_obj->ID ) )  :  NULL;
		    	( ! empty( $cart_page_obj ) )  ?  update_option( 'woocommerce_cart_page_id', intval( $cart_page_obj->ID ) )  :  NULL;
		    	( ! empty( $checkout_page_obj ) )  ?  update_option( 'woocommerce_checkout_page_id', intval( $checkout_page_obj->ID ) )  :  NULL;
		    	( ! empty( $myaccount_page_obj ) )  ?  update_option( 'woocommerce_myaccount_page_id', intval( $myaccount_page_obj->ID ) )  :  NULL;
		    	( ! empty( $terms_page_obj ) )  ?  update_option( 'woocommerce_terms_page_id', 	intval( $terms_page_obj->ID ) )  :  NULL;
		    } // End If Statement

		    wp_cache_flush();

		}

		/**
		 * Modifies options for the jQuery modal window which is used for the popup confirmation.
		 *
		 * @access  public
		 * @param 	array 	  $default_settings 	jQuery modal args.
		 * @return  array
		 */
		public function confirmation_dialog_options( $default_settings ) {

			$default_settings = (array) array_merge( $default_settings, array(
		        'width' => 400,
		        'dialogClass' => 'wp-dialog conj-lite-ocdi-dialog',
		        'resizable' => FALSE,
		        'height' => 'auto',
		        'modal' => TRUE
		    ) );

			return $default_settings;

		}

	}

endif;
// End Class.

return new Conj_Lite_NUX_Demo_Import();