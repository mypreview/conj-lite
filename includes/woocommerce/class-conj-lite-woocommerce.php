<?php
/**
 * Conj Lite WooCommerce Class
 *
 * @requires 	WooCommerce
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview, @gookalani)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Conj_Lite_WooCommerce' ) ) :

	/**
	 * The Conj Lite WooCommerce integration class
	 */
	final class Conj_Lite_WooCommerce {

		/**
		 * Setup class.
		 *
		 * @access 	public
		 * @return 	void
		 */
		public function __construct() {

			add_action( 'after_setup_theme',        					array( $this, 'setup' ),       						11 );
			add_action( 'wp_enqueue_scripts',       					array( $this, 'enqueue' ),       					10 );
			add_action( 'enqueue_block_editor_assets',       			array( $this, 'enqueue_editor_assets' ),     	   	10 );
			add_filter( 'conj_lite_body_classes', 						array( $this, 'body_classes' ),   	 			 10, 1 );
			add_filter( 'woocommerce_cross_sells_columns', 				array( $this, 'cross_sells_cols' ),    		 	 10, 1 );
			add_filter( 'woocommerce_cross_sells_total', 				array( $this, 'cross_sells_total' ),    		 10, 1 );
			add_filter( 'woocommerce_upsell_display_args', 				array( $this, 'upsell_products_args' ),    		 10, 1 );
			add_filter( 'woocommerce_output_related_products_args', 	array( $this, 'related_products_args' ),    	 10, 1 );
			add_filter( 'woocommerce_product_thumbnails_columns', 		array( $this, 'thumbnail_columns' ),       		 10, 1 );
			add_filter( 'woocommerce_breadcrumb_defaults',          	array( $this, 'change_breadcrumb_delimiter' ),   10, 1 );
			add_filter( 'woocommerce_get_price_html',          			array( $this, 'custom_price_html' ),  	        100, 2 );
			add_filter( 'woocommerce_get_price_suffix',          		array( $this, 'add_suffix_to_price' ),  	     99, 4 );
			add_filter( 'woocommerce_pagination_args',          		array( $this, 'pagination_args' ),  	     	 10, 1 );
			add_filter( 'woocommerce_single_product_carousel_options',  array( $this, 'flexslider_args' ),  	     	 10, 1 );

			/**
			 * Disable default WooCommerce stylesheet.
			 * @see 	https://docs.woocommerce.com/document/disable-the-default-stylesheet/
			 */
			add_filter( 'woocommerce_enqueue_styles', 					  		'__return_empty_array'  					   );
			
			add_filter( 'woocommerce_product_description_heading', 				'__return_false' 							   );
			add_filter( 'woocommerce_product_additional_information_heading', 	'__return_false' 							   );

			
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/add_theme_support/
		 * @link 	https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
		 * @link 	https://docs.woocommerce.com/document/woocommerce-theme-developer-handbook/#section-7
		 * @link 	https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
		 * @access 	public
		 * @return 	void
		 */
		public function setup() {

			// Declare WooCommerce support.
			add_theme_support( 'woocommerce', apply_filters( 'conj_lite_woocommerce_theme_support_args', array(
				'single_image_width' => 670,
				'thumbnail_image_width' => 418,
				'product_blocks' => array( 
					'default_columns' => 2,
					'min_columns' => 1,
					'max_columns' => 4
				),
				'product_grid' => array(
					'default_rows' => 2,
					'default_columns' => 2,
		        	'min_rows' => 1,
		        	'min_columns' => 1,
		        	'max_columns' => 4
			) ) ) );

			// Enable the gallery in the theme
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @access 	public
		 * @return 	void
		 */
		public function enqueue() {

			wp_enqueue_style( 'conj-lite-woocommerce-styles', get_theme_file_uri( 'woocommerce.css' ), array( 'conj-lite-styles' ), CONJ_LITE_THEME_VERSION );
			wp_style_add_data( 'conj-woocommerce-styles', 'rtl', 'replace' );

		}

		/**
		 * Enqueue block editor scripts and styles to extend Gutenberg editor.
		 *
		 * @see 	https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#add-the-stylesheet
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_add_inline_style/
		 * @access 	public
		 * @return 	void
		 */
		public function enqueue_editor_assets() {

			wp_enqueue_style( 'conj-lite-block-editor-woocommerce-styles', get_theme_file_uri( '/assets/admin/css/style-editor-woocommerce.css' ), array( 'wp-edit-blocks', 'conj-lite-block-editor-styles' ), CONJ_LITE_THEME_VERSION, 'all' );
			wp_style_add_data( 'conj-lite-block-editor-woocommerce-styles', 'rtl', 'replace' );

			// Retrieving Customizer theme mod values
			$general_background_color = sanitize_hex_color_no_hash( get_background_color() );
			$general_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_text_color', '#6B6F81' ) );
			$general_text_color_light = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_text_color, 30 ) );
			$general_text_color_lighter = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_text_color, 50 ) );
			$general_link_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_link_color', '#666EE8' ) );
			$general_heading_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_heading_color', '#464855' ) );
			$general_button_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_button_text_color', '#FFFFFF' ) );
			$general_button_background_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_button_background_color', '#666EE8' ) );

			// Append the following CSS styles to the Gutenberg style tag.
			$inline_css = "
				.wc-block-products-grid .wc-product-preview .wc-product-preview__title {
					color: {$general_heading_color};
				}
				.wc-block-products-grid .wc-product-preview .wc-product-preview__add-to-cart:after,
				.wc-block-products-grid .wc-product-preview del,
				.wc-block-products-grid .wc-product-preview .woocommerce-Price-amount {
					color: {$general_link_color};
				}
				.wc-block-products-grid .wc-product-preview .price-label {
					color: {$general_text_color_lighter};
				}
			";

			wp_add_inline_style( 'conj-lite-block-editor-woocommerce-styles', wp_strip_all_tags( $inline_css ) );

		}

		/**
		 * Append 'woocommerce-running' class (+ a few more) to the body tag.
		 *
		 * @access 	public
		 * @param  	array 	$classes 	CSS classes applied to the body tag.
		 * @return 	array 	$classes 	Modified to include 'woocommerce-running' class
		 */
		public function body_classes( $classes ) {
			
			$classes[] = 'woocommerce-running';

			// Add class if WooCommerce ajax is disabled.
			if ( 'yes' !== get_option( 'woocommerce_enable_ajax_add_to_cart' ) ) {
				$classes[]	= 'no-wc-ajax';
			} // End If Statement

			return $classes;

		}

		/**
		 * Cross sells products columns.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
		 * @uses 	conj_lite_is_fluid_template()
		 * @access 	public
		 * @param  	integer 	$columns 	number of cross-sells columns.
		 * @return  integer 	$columns 	number of cross-sells columns.
		 */
		public function cross_sells_cols( $columns ) {

			$columns = (int) apply_filters( 'conj_lite_wc_cross_sells_cols', 1 );

			// Display 1 column only if the sidebar is NOT shown on the view.
			if ( conj_lite_is_fluid_template() || ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = apply_filters( 'conj_lite_wc_cross_sells_cols', 2 );
			} // End If Statement

			return intval( $columns );

		}

		/**
		 * Cross sells products max limit.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
		 * @uses 	conj_lite_is_fluid_template()
		 * @access 	public
		 * @param  	integer 	$number 	number of cross-sells to display on cart page.
		 * @return  integer 	$number 	number of cross-sells to display on cart page.
		 */
		public function cross_sells_total( $number ) {

			$number = (int) apply_filters( 'conj_lite_wc_cross_sells_total', 2 );

			// Display 1 column only if the sidebar is NOT shown on the view.
			if ( conj_lite_is_fluid_template() || ! is_active_sidebar( 'sidebar-1' ) ) {
				$number = apply_filters( 'conj_lite_wc_cross_sells_total', 4 );
			} // End If Statement

			return intval( $number );

		}

		/**
		 * Upsell products args.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
		 * @uses 	conj_lite_is_fluid_template()
		 * @access 	public
		 * @param  	array 	$args 	up-sell products args.
		 * @return  array 	$args 	up-sell products args.
		 */
		public function upsell_products_args( $args ) {

			$columns = 3;
			$posts_per_page = 3;

			// Display 4 products in 4 columns only if the sidebar is NOT shown on the view.
			if ( conj_lite_is_fluid_template() || ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 4;
				$posts_per_page = 4;
			} // End If Statement

			$args = apply_filters( 'conj_lite_wc_upsell_products_args', array(
				'columns' => intval( $columns ),
				'posts_per_page' => intval( $posts_per_page )
			) );

			return $args;

		}

		/**
		 * Related products args.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
		 * @uses 	conj_lite_is_fluid_template()
		 * @access 	public
		 * @param  	array 	$args 	related products args.
		 * @return  array 	$args 	related products args.
		 */
		public function related_products_args( $args ) {

			$columns = 3;
			$posts_per_page = 3;

			// Display 4 products in 4 columns only if the sidebar is NOT shown on the view.
			if ( conj_lite_is_fluid_template() || ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 4;
				$posts_per_page = 4;
			} // End If Statement

			$args = apply_filters( 'conj_lite_wc_related_products_args', array(
				'columns' => intval( $columns ),
				'posts_per_page' => intval( $posts_per_page )
			) );

			return $args;

		}

		/**
		 * Product gallery thumbnail columns.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
		 * @see 	https://developer.wordpress.org/reference/functions/is_singular/
		 * @uses 	conj_lite_is_fluid_template()
		 * @access 	public
		 * @return 	integer 	number of columns.
		 */
		public function thumbnail_columns( $columns ) {

			$columns = 4;

			if ( ( is_singular( 'product' ) && conj_lite_is_fluid_template() ) || ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 5;
			} // End If Statement

			return intval( apply_filters( 'conj_lite_wc_product_thumbnail_columns', intval( $columns ) ) );

		}

		/**
		 * Remove the breadcrumb delimiter.
		 *
		 * @access 	public
		 * @param  	array 	$defaults 	The breadcrumb defaults.
		 * @return 	array           	The breadcrumb defaults.
		 */
		public function change_breadcrumb_delimiter( $defaults ) {

			$defaults['delimiter'] = '<span class="breadcrumb-separator"> / </span>';
			return $defaults;

		}

		/**
		 * Adds prefix and suffix wrapper HTML tag to WooCommerce prices.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_admin/
		 * @access 	public
		 * @param  	object 		$product 	The product object.
		 * @param  	string 		$price 		to calculate, left blank to just use get_price()
		 * @return 	html           		
		 */
		public function custom_price_html( $price, $product ) {

			// Skip appending this to the administrative interface of WooCommerce pages.
			if ( ! is_admin() ) {
				$price = sprintf( '<span class="price__wrapper">%s', $price );
				$price.= '</span>';
			} // End If Statement

			return $price;
			
		}

		/**
		 * Adds a translatable suffix to WooCommerce prices.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_admin/
		 * @access 	public
		 * @param  	string 		$html 		The content that will append to the price tags.
		 * @param  	object 		$product 	The product object.
		 * @param  	string 		$price 		to calculate, left blank to just use get_price()
		 * @param  	integer 	$qty   		passed on to get_price_including_tax() or get_price_excluding_tax()
		 * @return 	html           		
		 */
		public function add_suffix_to_price( $html, $product, $price, $qty ) {

			// Skip appending this to the administrative interface of WooCommerce pages.
			if ( ! is_admin() ) {
				/* translators: 1: Span open tag, 2: Span close tag. */
				$html.= sprintf( esc_html__( '%1$sPrice%2$s', 'conj-lite' ), '<span class="price-label">', '</span>' );
			} // End If Statement
			
    		return $html;

		}

		/**
		 * Modifies pagination for catalog pages.
		 *
		 * @access 	public
		 * @param 	array 	$args 	The current pagination arguments.
		 * @return 	array
		 */
		public function pagination_args( $args ) {

			$args['end_size'] = 1;
			$args['mid_size'] = 2;
			$args['show_all'] = FALSE;
			$args['prev_text'] = apply_filters( 'conj_lite_wc_pagination_prev_text', '<i class="feather-chevron-left"></i>' );
			$args['next_text'] = apply_filters( 'conj_lite_wc_pagination_next_text', '<i class="feather-chevron-right"></i>' );

			return $args;

		}

		/**
		 * Modifies flexslider args.
		 *
		 * @access 	public
		 * @param 	array 	$args 	The current flexslider arguments.
		 * @return 	array
		 */
		public function flexslider_args( $args ) {

			$args['smoothHeight'] = FALSE;
			$args['directionNav'] = TRUE;
			$args['useCSS'] = is_rtl();

			return $args;

		}

	}

endif;

return new Conj_Lite_WooCommerce();
