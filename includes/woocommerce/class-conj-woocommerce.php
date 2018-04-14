<?php
/**
 * Conj Lite WooCommerce Class
 *
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MyPreview_Conj_Lite_WooCommerce' ) ) :

	/**
	 * The Conj Lite WooCommerce Integration class
	 */
	class MyPreview_Conj_Lite_WooCommerce {

		/**
		 * Setup class.
		 */
		public function __construct() {

			add_action( 'after_setup_theme',        				array( $this, 'setup' ),       						11 );
			add_action( 'wp_enqueue_scripts',       				array( $this, 'enqueue' ),       					10 );
			add_filter( 'body_class', 								array( $this, 'woocommerce_body_class' ),   	 10, 1 );
			add_filter( 'woocommerce_cross_sells_columns', 			array( $this, 'cross_sells_cols' ),    		 	 10, 1 );
			add_filter( 'woocommerce_cross_sells_total', 			array( $this, 'cross_sells_total' ),    		 10, 1 );
			add_filter( 'woocommerce_upsell_display_args', 			array( $this, 'upsell_products_args' ),    		 10, 1 );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ),    	 10, 1 );
			add_filter( 'woocommerce_product_thumbnails_columns', 	array( $this, 'thumbnail_columns' ),       		 10, 1 );
			add_filter( 'woocommerce_breadcrumb_defaults',          array( $this, 'change_breadcrumb_delimiter' ),   10, 1 );
			add_filter( 'woocommerce_get_price_html',          		array( $this, 'custom_price_html' ),  	        100, 2 );
			add_filter( 'woocommerce_get_price_suffix',          	array( $this, 'add_suffix_to_price' ),  	     99, 4 );
			/**
			 * Disable the default WooCommerce stylesheet.
			 * 
			 * @see https://docs.woocommerce.com/document/disable-the-default-stylesheet/
			 */
			add_filter( 'woocommerce_enqueue_styles', 					  		'__return_empty_array'  );
			
			add_filter( 'woocommerce_product_description_heading', 				'__return_false' 		);
			add_filter( 'woocommerce_product_additional_information_heading', 	'__return_false' 		);

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
				add_filter( 'loop_shop_columns', 					array( $this, 'products_per_column' ),     		10, 1 );
				add_filter( 'loop_shop_per_page', 					array( $this, 'products_per_page' ),       		 10, 1 );
			}

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.5', '<' ) ) {
				add_action( 'wp_footer', 							array( $this, 'star_rating_script' ),       	10 );
			}
			
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 *
		 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
		 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
		 * @return void
		 */
		public function setup() {

			// Declare WooCommerce support.
			add_theme_support( 'woocommerce', apply_filters( 'mypreview_conj_lite_woocommerce_args', array(
				'single_image_width'    => 670,
				'thumbnail_image_width' => 318,
				'product_grid'          => array(
					'default_rows'    => 2,
			        'min_rows'        => 2,
			        'default_columns' => 2,
			        'min_columns'     => 2,
			        'max_columns'     => 4
				)
			) ) );

			// Enable the gallery in the theme
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
		 */
		public function enqueue() {

			wp_enqueue_style( 'mypreview-conj-woocommerce-styles', get_theme_file_uri( 'woocommerce.css' ), '', MYPREVIEW_CONJ_LITE_THEME_VERSION );

			$font_path   = WC()->plugin_url() . '/assets/fonts/';
			$inline_font = '@font-face {
					font-family: "star";
					src: url("' . $font_path . 'star.eot");
					src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
						url("' . $font_path . 'star.woff") format("woff"),
						url("' . $font_path . 'star.ttf") format("truetype"),
						url("' . $font_path . 'star.svg#star") format("svg");
					font-weight: normal;
					font-style: normal;
				}';

			wp_add_inline_style( 'mypreview-conj-woocommerce-styles', $inline_font );

		}

		/**
		 * Add 'woocommerce-running' class to the body tag.
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-running' class
		 */
		public function woocommerce_body_class( $classes ) {
			
			$classes[] = 'woocommerce-running';

			return $classes;

		}

		/**
		 * Cross sells products columns.
		 *
		 * @param  	integer $columns number of cross-sells columns.
		 * @return  integer $columns number of cross-sells columns.
		 */
		public function cross_sells_cols( $columns ) {

			$columns = apply_filters( 'mypreview_conj_lite_wc_cross_sells_cols', 1 );

			// Display 1 column only if the sidebar is NOT shown on the view.
			if ( mypreview_conj_lite_is_fluid_template()) {
				$columns = apply_filters( 'mypreview_conj_lite_wc_cross_sells_cols', 2 );
			}

			return intval( $columns );

		}

		/**
		 * Cross sells products max limit.
		 *
		 * @param  	integer $number number of cross-sells to display on cart page.
		 * @return  integer $number number of cross-sells to display on cart page.
		 */
		public function cross_sells_total( $number ) {

			$number = apply_filters( 'mypreview_conj_lite_wc_cross_sells_total', 2 );

			// Display 1 column only if the sidebar is NOT shown on the view.
			if ( mypreview_conj_lite_is_fluid_template() ) {
				$number = apply_filters( 'mypreview_conj_lite_wc_cross_sells_total', 4 );
			}

			return intval( $number );

		}

		/**
		 * Upsell products args.
		 *
		 * @param  	array $args up-sell products args.
		 * @return  array $args up-sell products args.
		 */
		public function upsell_products_args( $args ) {

			$posts_per_page = 3;
			$columns = 3;

			// Display 4 products in 4 columns only if the sidebar is NOT shown on the view.
			if ( ( is_singular( 'product' ) && mypreview_conj_lite_is_fluid_template() ) || ! is_active_sidebar( 'sidebar-1' ) ) {
				$posts_per_page = 4;
				$columns = 4;
			}

			$args = apply_filters( 'mypreview_conj_lite_wc_upsell_products_args', array(
				'posts_per_page' => intval( $posts_per_page ),
				'columns'        => intval( $columns )
			) );

			return $args;

		}

		/**
		 * Related products args.
		 *
		 * @param  	array $args related products args.
		 * @return  array $args related products args.
		 */
		public function related_products_args( $args ) {

			$posts_per_page = 3;
			$columns = 3;

			// Display 4 products in 4 columns only if the sidebar is NOT shown on the view.
			if ( ( is_singular( 'product' ) && mypreview_conj_lite_is_fluid_template() ) || ! is_active_sidebar( 'sidebar-1' ) ) {
				$posts_per_page = 4;
				$columns = 4;
			}

			$args = apply_filters( 'mypreview_conj_lite_wc_related_products_args', array(
				'posts_per_page' => intval( $posts_per_page ),
				'columns'        => intval( $columns )
			) );

			return $args;

		}

		/**
		 * Product gallery thumbnail columns.
		 *
		 * @return integer number of columns.
		 */
		public function thumbnail_columns( $columns ) {

			$columns = 4;

			if ( ( is_singular( 'product' ) && mypreview_conj_lite_is_fluid_template() ) || ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 5;
			}

			return intval( apply_filters( 'mypreview_conj_lite_wc_product_thumbnail_columns', intval( $columns ) ) );

		}

		/**
		 * Products per page.
		 *
		 * @param  integer $number number of products.
		 * @return integer number of products.
		 */
		public function products_per_page( $number ) {

			// Default number of products if < WooCommerce 3.3.
			$number = 12;

			return intval( apply_filters( 'mypreview_conj_lite_wc_products_per_page', $number ) );

		}

		/**
		 * Remove the breadcrumb delimiter.
		 * 
		 * @param  array $defaults 	The breadcrumb defaults.
		 * @return array           	The breadcrumb defaults.
		 */
		public function change_breadcrumb_delimiter( $defaults ) {

			$defaults['delimiter'] = '<span class="breadcrumb-separator"> / </span>';
			return $defaults;

		}

		/**
		 * Adds prefix and suffix wrapper HTML tag to WooCommerce prices.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_admin/
		 * @uses   	is_admin();
		 * @param  	object 		$product 	The product object.
		 * @param  	string 		$price 		to calculate, left blank to just use get_price()
		 * @return 	html           		
		 */
		public function custom_price_html( $price, $product ) {

			// Skip appending this to the administrative interface of WooCommerce pages.
			if ( ! is_admin() ) {
				$price = '<div class="conj-wc-price__wrapper">' . $price;
				$price.= '</div>';
			}

			return $price;
			
		}

		/**
		 * Adds a translatable suffix to WooCommerce prices.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/is_admin/
		 * @uses   	is_admin();
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
				$html.= sprintf( __( '%1$sPrice%2$s', 'conj-lite' ), '<span class="price-label">', '</span>' );
			}
			
    		return $html;

		}

		/**
		 * Products per page.
		 *
		 * @param  integer $columns number of products
		 * @return integer columns of products
		 */
		public static function products_per_column( $columns ) {

			$columns = 3;

			if ( function_exists( 'wc_get_default_products_per_row' ) ) {
				$columns = wc_get_default_products_per_row();
			}

			return absint( apply_filters( 'mypreview_conj_lite_wc_products_per_column', $columns ) );

		}

		/**
		 * Star rating backwards compatibility script (WooCommerce <2.5).
		 *
		 * @since 1.6.0
		 */
		public function star_rating_script() {

			if ( is_product() ) {
			?>
			<script type="text/javascript">
				var starsEl = document.querySelector( '#respond p.stars' );
				if ( starsEl ) {
					starsEl.addEventListener( 'click', function( event ) {
						if ( event.target.tagName === 'A' ) {
							starsEl.classList.add( 'selected' );
						}
					} );
				}
			</script>
			<?php
			}
		}

	}

endif;

return new MyPreview_Conj_Lite_WooCommerce();