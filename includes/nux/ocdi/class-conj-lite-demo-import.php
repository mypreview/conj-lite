<?php
/**
 * Conj lite demo import Class
 *
 * @uses 		One Click Demo Import
 * @link 		https://wordpress.org/plugins/one-click-demo-import/
 * @author  	Mahdi Yazdani
 * @package 	conj-lite
 * @since 	    1.1.0
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

			add_action( 'pt-ocdi/import_files',     				  		array( $this, 'import_files' ),              	10 );
			add_action( 'pt-ocdi/after_import',     				  		array( $this, 'after_import_setup' ),        	10 );
			add_action( 'pt-ocdi/plugin_intro_text',     				  	array( $this, 'intro_text' ),        		 	10 );
			add_action( 'pt-ocdi/plugin_page_setup',     				  	array( $this, 'plugin_page_setup' ),         	10 );
			add_action( 'pt-ocdi/confirmation_dialog_options',     			array( $this, 'confirmation_dialog_options' ),  10 );
			add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import',  '__return_false'					  			   );
			add_filter( 'pt-ocdi/disable_pt_branding', 						'__return_true' 								   );

		}

		/**
		 * Locate bundled demo data files and import upon request.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/get_parent_theme_file_path/
		 * @see 	https://developer.wordpress.org/reference/functions/get_template_directory_uri/
		 * @access  public
		 * @return  array
		 */
		public function import_files() {

			/* translators: 1: Open small tag, 2: Close small tag. */
			$import_notice_intro = sprintf( esc_html__( '%1$sThe following plugins are used within the selected demo and you may want to install a few or all of them depending on which feature you may want to have on your site.%2$s', 'conj-lite' ), '<small>', '</small>' );
			/* translators: 1: Open list and anchor tag, 2: Open small tag, 3: Close anchor and list tag. */
			$woocommerce_plugin_info = sprintf( esc_html__( '%1$sWooCommerce%2$s(Required)%3$s', 'conj-lite' ), '<li><a href="https://wordpress.org/plugins/woocommerce" target="_blank" rel="noopener noreferrer nofollow">', '</a><small class="alignright">', '</small></li>' );
			/* translators: 1: Open list and anchor tag, 2: Open small tag, 3: Close anchor and list tag. */
			$jetpack_plugin_info = sprintf( esc_html__( '%1$sJetpack by WordPress.com%2$s(Recommended)%3$s', 'conj-lite' ), '<li><a href="https://wordpress.org/plugins/jetpack" target="_blank" rel="noopener noreferrer nofollow">', '</a><small class="alignright">', '</small></li>' );
			$import_notice_intro_list_wrapper = '<ol>';
			$import_notice_intro_list_wrapper_close	= '</ol>';

			$import_notice = array();
			$import_notice[] = $import_notice_intro;
			$import_notice[] = $import_notice_intro_list_wrapper;
			$import_notice[] = $woocommerce_plugin_info;
			$import_notice[] = $jetpack_plugin_info;
			$import_notice[] = $import_notice_intro_list_wrapper_close;
			$import_notice = implode( '', $import_notice );

			$import = array(
		        array(
		            'import_file_name' => 'Default',
		            'import_file_url' => 'https://api.mypreview.one/conj-lite/demo-data/content-default.xml',
		            'import_widget_file_url' => 'https://api.mypreview.one/conj-lite/demo-data/widgets-default.wie',
		            'import_customizer_file_url' => 'https://api.mypreview.one/conj-lite/demo-data/customizer-default.dat',
		            'import_preview_image_url' => 'https://i.gyazo.com/900735d152a3a492fd8d355e4c5f8408.jpg',
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
		 * @see 	https://developer.wordpress.org/reference/functions/get_theme_mod/
		 * @see 	https://developer.wordpress.org/reference/functions/update_post_meta/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_upload_dir/
		 * @access  public
		 * @return  void
		 */
		public function after_import_setup( $selected_import ) {

			$primary = get_term_by( 'name', 'Primary Menu', 'nav_menu' );

			set_theme_mod( 'nav_menu_locations', array( 
					'primary' => $primary->term_id
				) 
			);

			// Assign front page and posts page.
		    $front_page_obj = (object) get_page_by_title( 'WELCOME TO CONJ LITE' );
		    $blog_page_obj = (object) get_page_by_title( 'Blog' );

		    ( ! empty( $front_page_obj ) )  ?  update_option( 'show_on_front', 	'page' )  :  NULL;
		    ( ! empty( $front_page_obj ) ) 	?  update_option( 'page_on_front', 	intval( $front_page_obj->ID ) )  :  NULL;
		    ( ! empty( $blog_page_obj ) )  ?  update_option( 'page_for_posts', intval( $blog_page_obj->ID ) )  :  NULL;

		    // Query whether "WooCommerce" is activated or NOT.
		    if ( class_exists( 'WooCommerce' ) ) {

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
		    	( ! empty( $terms_page_obj ) )  ?  update_option( 'woocommerce_terms_page_id', intval( $terms_page_obj->ID ) )  :  NULL;

		    } // End If Statement

		    wp_cache_flush();

		}

		/**
		 * Appends an extra content to the plugin intro text.
		 *
		 * @access  public
		 * @param 	string 	$default_text 	Plugin intro text.
		 * @return  string
		 */
		public function intro_text( $default_text ) {
			
			/* translators: 1: Open div tag, 2: Close div tag. */
			$default_text = sprintf( esc_html__( '%1$sKeep in mind that it is NOT recommended to take next step forward if you have existing content in your WordPress installation, as it will add numerous posts, pages, products, categories, media and more to your site.%2$s', 'conj-lite' ), '<div class="notice notice-info"><p>', '</p></div>' );

			return $default_text;

		}

		/**
		 * Modifies demo import menu location, title and page URL.
		 *
		 * @access  public
		 * @param 	array 	$default_settings 	Plugin page menu args.
		 * @return  array
		 */
		public function plugin_page_setup( $default_settings ) {

			$default_settings['parent_slug'] = 'tools.php';
		    $default_settings['capability'] = 'import';
		    $default_settings['menu_slug'] = 'conj-lite-one-click-demo-import';
		    $default_settings['menu_title'] = esc_html__( 'CONJ Lite Demo Import' , 'conj-lite' );

		    return $default_settings;

		}

		/**
		 * Modifies options for the jQuery modal window which is used for the popup confirmation.
		 *
		 * @access  public
		 * @param 	array 	$default_settings 	jQuery modal args.
		 * @return  array
		 */
		public function confirmation_dialog_options( $default_settings ) {

			$default_settings =	 array_merge( $default_settings, array(
		        'width' => 400,
		        'dialogClass' => 'wp-dialog conj-lite-demo-import__dialog',
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