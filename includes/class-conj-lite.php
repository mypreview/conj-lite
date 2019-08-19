<?php
/**
 * Conj Lite Class
 *
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview, @gookalani)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Conj_Lite' ) ) :

	/**
	 * The main Conj Lite class
	 */
	final class Conj_Lite {

		/**
		 * Setup class.
		 *
		 * @access 	public
		 * @return  void
		 */
		public function __construct() {

			add_action( 'after_setup_theme',        		array( $this, 'setup' ),                           	   10 );
			add_action( 'wp_head',          				array( $this, 'javascript_detection' ),                 0 );
			add_action( 'wp_head',          				array( $this, 'pingback_header' ),                 	   10 );
			add_action( 'widgets_init',             		array( $this, 'widgets_init' ),                     	5 );
			add_action( 'wp_resource_hints',        		array( $this, 'resource_hints' ),               	10, 2 );
			add_action( 'wp_enqueue_scripts',       		array( $this, 'enqueue' ),                     	   	   10 );
			add_action( 'admin_enqueue_scripts', 			array( $this, 'admin_enqueue' ),  		   		   	   10 );
			add_action( 'enqueue_block_editor_assets',      array( $this, 'enqueue_editor_assets' ),     	   	   10 );
			add_filter( 'block_editor_settings', 			array( $this, 'custom_editor_settings' ), 	    	10, 2 );
			add_action( 'wp_enqueue_scripts',       		array( $this, 'child_scripts' ),       			   	   30 );
			add_filter( 'body_class',               		array( $this, 'body_classes' ), 					10, 1 );
			add_filter( 'excerpt_more',             		array( $this, 'custom_excerpt_more' ), 				10, 1 );
			add_filter( 'widget_tag_cloud_args',    		array( $this, 'widget_tag_cloud_args' ), 			10, 1 );
			add_action( 'edit_category',            		array( $this, 'category_transient_flusher' ), 	   	   10 );
			add_action( 'save_post',                		array( $this, 'category_transient_flusher' ), 	   	   10 );
			add_filter( 'comment_form_fields',      		array( $this, 'move_comment_field_to_bottom' ), 	10, 1 );
			add_filter( 'wp_list_categories', 				array( $this, 'cat_count_span' ), 					10, 1 );
			add_filter( 'get_archives_link', 				array( $this, 'archive_count_span' ), 				10, 1 );
			add_filter( 'the_content', 						array( $this, 'aside_to_infinity_and_beyond' ),  	 9, 1 );
			add_filter( 'get_post_gallery', 				array( $this, 'polyfill_get_post_gallery' ),  		10, 2 );

		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @access 	public
		 * @return  void
		 */
		public function setup() {

			/**
			 * Set the content width based on the theme's design and stylesheet.
			 *
			 * @see 	https://codex.wordpress.org/Content_Width
			 */
			if ( ! isset( $content_width ) ) {
				$content_width = apply_filters( 'conj_lite_content_width', 1210 ); /* pixels */
			} // End If Statement

			/*
			 * Load Localisation files.
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */
			// Loads wp-content/languages/themes/conj-it_IT.mo.
			load_theme_textdomain( 'conj-lite', trailingslashit( WP_LANG_DIR ) . 'themes/' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'conj-lite', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/conj/languages/it_IT.mo.
			load_theme_textdomain( 'conj-lite', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Enable support for site logo.
			 *
			 * @see 	https://developer.wordpress.org/themes/functionality/custom-logo/
			 */
			add_theme_support( 'custom-logo', apply_filters( 'conj_lite_custom_logo_args', array(
				'height' => 140,
				'width' => 400,
				'flex-width' => TRUE
			) ) );

			/**
			 * Set up the WordPress core custom header feature.
			 *
			 * @see 	https://developer.wordpress.org/themes/functionality/custom-headers
			 */
			add_theme_support( 'custom-header', apply_filters( 'conj_lite_custom_header_args', array(
				'default-text-color' => '6B6F81',
				'width' => 1950,
				'height' => 500,
				'flex-height' => TRUE,
				'wp-head-callback' => ''
			) ) );

			/**
			 * Set up the WordPress core custom background feature.
			 *
			 * @see 	https://codex.wordpress.org/Custom_Backgrounds
			 */
			add_theme_support( 'custom-background', apply_filters( 'conj_lite_custom_background_args', array(
				'default-color' => 'F4F5FA'
			) ) );

			/**
			 * This theme uses wp_nav_menu() in four location.
			 *
			 * @see 	https://developer.wordpress.org/reference/functions/wp_nav_menu/
			 */
			register_nav_menus( apply_filters( 'conj_lite_nav_menu_args', array(
				'primary' => __( 'Primary Menu', 'conj-lite' ),
				'handheld' => __( 'Push Menu', 'conj-lite' )
			) ) );

			/**
			* Enable support for post formats.
			*
			* @see 		https://codex.wordpress.org/Post_Formats
			*/
			add_theme_support( 'post-formats', apply_filters( 'conj_lite_post_format_args', array(
				'aside',
				'audio',
				'chat',
				'gallery',
				'image',
				'link',
				'quote',
				'status',
				'video'
			) ) );

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', apply_filters( 'conj_lite_html5_args', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets'
			) ) );

			// Declare support for title theme feature.
			add_theme_support( 'title-tag' );

			// Declare support for selective refreshing of widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );

			/*
			 * This theme styles the visual editor to resemble the theme style,
			 * specifically font, colors, and column width.
		 	 */
			add_editor_style( array( 'assets/admin/css/legacy/editor-style.css', self::google_fonts_url() ) );

			/**
			 * Add support for Gutenberg.
			 *
			 * @see 	https://wordpress.org/gutenberg/handbook/reference/theme-support/
			*/
			
			// Wide alignment
			add_theme_support( 'align-wide' );

			// Make embed blocks responsive
			add_theme_support( 'responsive-embeds' );

			// Block font sizes
			add_theme_support( 'editor-font-sizes', apply_filters( 'conj_lite_editor_font_sizes', array(
			    array(
			        'name' => _x( 'Small', 'editor font size', 'conj-lite' ),
			        'shortName' => _x( 'S', 'editor font size', 'conj-lite' ),
			        'size' => 13.6,
			        'slug' => 'small'
			    ),
			    array(
			        'name' => _x( 'Regular', 'editor font size', 'conj-lite' ),
			        'shortName' => _x( 'M', 'editor font size', 'conj-lite' ),
			        'size' => 16,
			        'slug' => 'regular'
			    ),
			    array(
			        'name' => _x( 'Large', 'editor font size', 'conj-lite' ),
			        'shortName' => _x( 'L', 'editor font size', 'conj-lite' ),
			        'size' => 21.25,
			        'slug' => 'large'
			    ),
			    array(
			        'name' => _x( 'Larger', 'editor font size', 'conj-lite' ),
			        'shortName' => _x( 'XL', 'editor font size', 'conj-lite' ),
			        'size' => 35,
			        'slug' => 'larger'
			    )
			) ) );
		
			// Block color palettes
			add_theme_support( 'editor-color-palette', apply_filters( 'conj_lite_editor_color_palette', array(
				array(
					'name' => _x( 'Black', 'editor color', 'conj-lite' ),
					'slug' => 'black',
					'color' => '#000000'
				),
				array(
					'name' => _x( 'Mako', 'editor color', 'conj-lite' ),
					'slug' => 'mako',
					'color' => '#464855'
				),
				array(
					'name' => _x( 'Storm Gray', 'editor color', 'conj-lite' ),
					'slug' => 'storm-gray',
					'color' => '#6B6F82'
				),
				array(
					'name' => _x( 'Manatee', 'editor color', 'conj-lite' ),
					'slug' => 'manatee',
					'color' => '#898EA3'
				),
				array(
					'name' => _x( 'Cadet Blue', 'editor color', 'conj-lite' ),
					'slug' => 'cadet-blue',
					'color' => '#A7ABBE'
				),
				array(
					'name' => _x( 'Martinique', 'editor color', 'conj-lite' ),
					'slug' => 'martinique',
					'color' => '#2D2E4F'
				),
				array(
					'name' => _x( 'Victoria', 'editor color', 'conj-lite' ),
					'slug' => 'victoria',
					'color' => '#414B92'
				),
				array(
					'name' => _x( 'Cornflower Blue', 'editor color', 'conj-lite' ),
					'slug' => 'cornflower-blue',
					'color' => '#666EE8'
				),
				array(
					'name' => _x( 'White Lilac', 'editor color', 'conj-lite' ),
					'slug' => 'white-lilac',
					'color' => '#F4F5FA'
				),
				array(
					'name' => _x( 'White', 'editor color', 'conj-lite' ),
					'slug' => 'white',
					'color' => '#FFFFFF'
				)
			) ) );

		}

		/**
		 * Handles JavaScript detection.
		 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
		 *
		 * @link    https://github.com/WordPress/twentyseventeen/blob/master/functions.php#L239
		 * @access 	public
		 * @return  void
		 */
		public function javascript_detection() {

			echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n"; // WPCS: XSS okay.

		}

		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles.
		 *
		 * @link 	https://github.com/WordPress/twentyseventeen/blob/master/functions.php#L247
		 * @access 	public
		 * @return  void
		 */
		public function pingback_header() {

			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
			} // End If Statement

		}

		/**
		 * Register widget area.
		 *
		 * @see 	https://codex.wordpress.org/Function_Reference/register_sidebar
		 * @return  void
		 */
		public function widgets_init() {

			$sidebar_args['sidebar'] = array(
				'id' => 'sidebar-1',
				'name' => _x( 'Sidebar', 'sidebar name', 'conj-lite' ),
				'description' => _x( 'Widgets in this area will be shown in header navigation area.', 'sidebar description', 'conj-lite' )
			);

			$rows = intval( apply_filters( 'conj_lite_footer_widget_rows', 1 ) );
			$regions = intval( apply_filters( 'conj_lite_footer_widget_columns', 4 ) );

			for ( $row = 1; $row <= $rows; $row++ ) {
				for ( $region = 1; $region <= $regions; $region++ ) {
					$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer = sprintf( 'footer_%d', $footer_n );

					if ( 1 === $rows ) {
						/* translators: 1: Decimal number. */
						$footer_region_name = sprintf( _x( 'Footer Column %1$d', 'sidebar name', 'conj-lite' ), $region );
						/* translators: 1: Decimal number. */
						$footer_region_description = sprintf( _x( 'Widgets added here will appear in column %1$d of the footer.', 'sidebar description', 'conj-lite' ), $region );
					} else {
						/* translators: 1: Decimal number, 2: Decimal number. */
						$footer_region_name = sprintf( _x( 'Footer Row %1$d - Column %2$d', 'sidebar name', 'conj-lite' ), $row, $region );
						/* translators: 1: Decimal number. */
						$footer_region_description = sprintf( _x( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'sidebar description', 'conj-lite' ), $region, $row );
					} // End If Statement

					$sidebar_args[ $footer ] = array(
						'name' => $footer_region_name,
						/* translators: 1: Decimal number. */
						'id' => sprintf( 'footer-%d', $footer_n ),
						'description' => $footer_region_description,
					);
				} // End of the loop
			} // End of the loop

			$sidebar_args = apply_filters( 'conj_lite_sidebar_args', $sidebar_args );

			foreach ( $sidebar_args as $sidebar => $args ) {
				$title_wrapper_open = NULL;
				$title_wrapper_close = NULL;

				// Add wrapper around the widget title on footer section
				if ( preg_match( '/footer-[0-9]+/', $args['id'] ) ) {
					$title_wrapper_open = '<div class="widget-title-wrapper">';
					$title_wrapper_close = '</div>';
				} // End If Statement

				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => sprintf( '%s<span class="widget-title">', $title_wrapper_open ),
					'after_title' => sprintf( '</span>%s', $title_wrapper_close )
				);
				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 *
				 * 'conj_lite_sidebar_widget_tags'
				 *
				 * 'conj_lite_footer_1_widget_tags'
				 * 'conj_lite_footer_2_widget_tags'
				 * 'conj_lite_footer_3_widget_tags'
				 * 'conj_lite_footer_4_widget_tags'
				 */
				$filter_hook = sprintf( 'conj_lite_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );
				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				} // End If Statement
			} // End of the loop

		}

		/**
		 * Add preconnect for Google Fonts.
		 *
		 * @access 	public
		 * @param  	array  	$urls            URLs to print for resource hints.
		 * @param  	array  	$relation_type   The relation type the URLs are printed.
		 * @return 	array  	$urls            URLs to print for resource hints.
		 */
		public function resource_hints( $urls, $relation_type ) {

			if ( wp_style_is( 'conj-lite-google-font', 'queue' ) && 'preconnect' === $relation_type ) {
				$urls[] = array(
					'href' => 'https://fonts.gstatic.com',
					'crossorigin'
				);
			} // End If Statement

			return $urls;

		}

		/**
		 * Register custom Google web fonts.
		 *
		 * @access 	public
		 * @return 	null|string|url
		 */
		public static function google_fonts_url() {

			$fonts_url = '';
			/*
			 * Translators: If there are characters in your language that are not
			 * supported by Montserrat, translate this to 'off'. Do not translate
			 * into your own language.
			 */
			$google_fonts_x = _x( 'google-fonts-on', 'rubik and montserrat font: on or off', 'conj-lite' );

			if ( 'off' !== $google_fonts_x ) {
				$font_families = array();
				$font_families[] = 'Rubik:100,100i,300,300i,400,400i';
				$font_families[] = 'Montserrat:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i';
				$query_args = array(
					'family' => urlencode( implode( '|', $font_families ) ),
					'subset' => urlencode( 'latin,latin-ext' )
				);
				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			} // End If Statement

			return esc_url_raw( $fonts_url );

		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
		 * @access 	public
		 * @return 	void
		 */
		public function enqueue() {

			/**
			 * Google font handle is inspired by "Twenty Seventeen" `functions.php`
			 * 
			 * @see 	https://github.com/WordPress/twentyseventeen/blob/master/functions.php#L276
			 */
			wp_enqueue_style( 'conj-lite-google-font', self::google_fonts_url(), FALSE, CONJ_LITE_THEME_VERSION, 'all' );

			/**
			 * The core CSS libraries can be found in /assets/css/vendor/
			 */
			wp_register_style( 'feather', get_theme_file_uri( '/assets/css/vendor/feather.css' ), FALSE, '4.19.0', 'all' );
			wp_register_style( 'js-offcanvas', get_theme_file_uri( '/assets/css/vendor/js-offcanvas.css' ), FALSE, '1.2.9', 'screen' );
			wp_register_style( 'slinky', get_theme_file_uri( '/assets/css/vendor/slinky.css' ), FALSE, '4.0.2', 'screen' );
			$stylesheet_deps = (array) apply_filters( 'conj_lite_vendor_stylesheet_deps', array( 'feather', 'js-offcanvas', 'slinky' ) );
			wp_enqueue_style( 'conj-lite-styles', sprintf( '%s/style.css', get_template_directory_uri() ), $stylesheet_deps, CONJ_LITE_THEME_VERSION );
			wp_style_add_data( 'conj-lite-styles', 'rtl', 'replace' );
			wp_add_inline_style( 'conj-lite-styles', Conj_Lite_Customizer_Styles::css() );

			/**
			 * The core JS libraries can be found in /assets/js/vendor/
			 */
			wp_register_script( 'js-offcanvas', get_theme_file_uri( '/assets/js/vendor/js-offcanvas.pkgd.js' ), array( 'jquery' ), '1.2.9', TRUE );
			wp_register_script( 'conj-lite-underscores-navigation', get_theme_file_uri( '/assets/js/vendor/navigation.js' ), array( 'jquery' ), '20151215', TRUE );
			wp_register_script( 'conj-lite-underscores-skip-link-focus-fix', get_theme_file_uri( '/assets/js/vendor/skip-link-focus-fix.js' ), array( 'jquery', 'conj-lite-underscores-navigation' ), '20151215', TRUE );
			wp_register_script( 'slinky', get_theme_file_uri( '/assets/js/vendor/slinky.js' ), array( 'jquery', 'js-offcanvas' ), '4.0.2', TRUE );
			wp_register_script( 'jquery-fitvids', get_theme_file_uri( '/assets/js/vendor/jquery.fitvids.js' ), array( 'jquery' ), '1.1.0', TRUE );
			$javascript_deps = (array) apply_filters( 'conj_lite_vendor_javascript_deps', array( 'jquery', 'js-offcanvas', 'conj-lite-underscores-navigation', 'conj-lite-underscores-skip-link-focus-fix', 'slinky', 'jquery-fitvids' ) );
			wp_register_script( 'conj-lite-scripts', get_theme_file_uri( '/assets/js/script.js' ), $javascript_deps, CONJ_LITE_THEME_VERSION, TRUE );

			$conj_lite_l10n = apply_filters( 'conj_lite_scripts_l10n_args', array(
				'is_rtl' => (bool) is_rtl(),
				'is_mobile' => (bool) wp_is_mobile()
			) );

			wp_localize_script( 'conj-lite-scripts', 'conj_lite_vars', $conj_lite_l10n );
			wp_enqueue_script( 'conj-lite-scripts' );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			} // End If Statement

		}
		
		/**
		 * Enqueue extra CSS & JavaScript to improve the user experience in the WordPress dashboard.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_localize_script/
		 * @access 	public
		 * @return 	void
		 */
		public function admin_enqueue() {

			wp_enqueue_style( 'conj-lite-admin-styles', get_theme_file_uri( '/assets/admin/css/style.css' ), array(), CONJ_LITE_THEME_VERSION, 'all' );
			wp_style_add_data( 'conj-lite-admin-styles', 'rtl', 'replace' );

			$conj_lite_admin_l10n = array(
				'dismiss_upsell_nonce' => wp_create_nonce( 'conj-lite-upsell-dismiss-nonce' )
			);

			wp_register_script( 'conj-lite-admin-scripts', get_theme_file_uri( '/assets/admin/js/script.js' ), array( 'jquery' ), CONJ_LITE_THEME_VERSION, TRUE );
			wp_localize_script( 'conj-lite-admin-scripts', 'conj_lite_vars', $conj_lite_admin_l10n );
			wp_enqueue_script( 'conj-lite-admin-scripts' );

		}

		/**
		 * Enqueue block editor scripts and styles to extend Gutenberg editor.
		 *
		 * @see 	https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#add-the-stylesheet
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_add_inline_style/
		 * @access 	public
		 * @return 	void
		 */
		public function enqueue_editor_assets() {

			/**
			 * Google font handle is inspired by "Twenty Seventeen" `functions.php`
			 * 
			 * @see 	https://github.com/WordPress/twentyseventeen/blob/master/functions.php#L276
			 */
			wp_enqueue_style( 'conj-lite-google-font', self::google_fonts_url(), FALSE, CONJ_LITE_THEME_VERSION, 'all' );
			wp_enqueue_style( 'conj-lite-block-editor-styles', get_theme_file_uri( '/assets/admin/css/style-editor.css' ), array( 'wp-edit-blocks' ), CONJ_LITE_THEME_VERSION, 'all' );
			wp_style_add_data( 'conj-lite-block-editor-styles', 'rtl', 'replace' );
			wp_enqueue_script( 'conj-lite-block-editor-scripts', get_theme_file_uri( '/assets/admin/js/block-editor.js' ), array( 'wp-data', 'wp-dom-ready', 'wp-block-editor', 'wp-edit-post' ), CONJ_LITE_THEME_VERSION, TRUE );

			// General			
			$general_background_color = sanitize_hex_color_no_hash( get_background_color() );
			$general_background_color_dark = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_background_color, -20 ) );
			$general_heading_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_heading_color', '#464855' ) );
			$general_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_text_color', '#6B6F81' ) );
			$general_text_color_light = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_text_color, 30 ) );
			$general_text_color_lighter = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_text_color, 50 ) );
			$general_link_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_link_color', '#666EE8' ) );
			$general_link_alt_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_link_alt_color', '#414B92' ) );
			$button_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_button_text_color', '#FFFFFF' ) );
			$button_background_color = sanitize_hex_color( get_theme_mod( 'conj_lite_button_background_color', '#666EE8' ) );
			$button_background_color_lighter = sanitize_hex_color( conj_lite_adjust_color_brightness( $button_background_color, 50 ) );
			$button_alt_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_button_alt_text_color', '#666EE8' ) );
			// Retrieving Customizer theme mod values

			$inline_css = "
				body.post-type-post #editor .editor-block-list__block[data-align='full'],
				.wp-block-pullquote:not(.is-style-solid-color) blockquote:after,
				.wp-block-pullquote:not(.is-style-solid-color) blockquote:before,
			 	.edit-post-visual-editor {
					background-color: #{$general_background_color};
				}
				.wp-block-freeform.block-library-rich-text__tinymce pre {
					background-color: {$general_background_color_dark};
				}
				.wp-block-calendar table caption,
				.editor-post-title .editor-post-title__input,
				.wp-block-freeform.block-library-rich-text__tinymce dd:not(.wp-caption-text),
				.editor-block-list__layout h1,
				.editor-block-list__layout h2,
				.editor-block-list__layout h3,
				.editor-block-list__layout h4,
				.editor-block-list__layout h5,
				.editor-block-list__layout h6 {
					color: {$general_heading_color};
				}
				.wp-block-pullquote, 
				.editor-block-list__layout .wp-block-quote cite, 
				.editor-block-list__layout blockquote.wp-block-quote,
				.wp-block-calendar tbody,
				.wp-block-freeform.block-library-rich-text__tinymce .wp-caption .wp-caption-dd,
				.editor-block-list__layout .wp-block-archives li,
				.editor-block-list__layout .wp-block-archives a,
				.editor-block-list__layout .wp-block-latest-posts li,
				.editor-block-list__layout .wp-block-latest-posts a,
				.editor-block-list__layout .wp-block-categories li,
				.editor-block-list__layout .wp-block-categories a,
				.editor-block-list__layout .editor-block-list__block,
				.edit-post-visual-editor {
					color: {$general_text_color};
				}
				.wp-block-tag-cloud a,
				.wp-block-search .wp-block-search__label,
				.wp-block-freeform.block-library-rich-text__tinymce dt {
					color: {$general_text_color_light};
				}
				.wp-block-calendar thead th,
                .wp-block-calendar tfoot a {
					color: {$general_text_color_lighter};
				}
				.wp-block-calendar tfoot a:hover,
				.wp-block-file .wp-block-file__textlink,
				.wp-block-freeform.block-library-rich-text__tinymce a,
				.editor-block-list__layout .wp-block-archives a:hover,
				.editor-block-list__layout .wp-block-latest-posts a:hover,
				.editor-block-list__layout .wp-block-categories a:hover,
				.editor-rich-text__tinymce a,
				.editor-block-list__layout a {
					color: {$general_link_color};
				}
				.wp-block-file .wp-block-file__textlink:hover,
				.wp-block-freeform.block-library-rich-text__tinymce a:hover,
				.editor-block-list__layout a:hover {
					color: {$general_link_alt_color};
				}
				.wp-block-button__link:not(.has-text-color),
				.wp-block-button__link:not(.has-text-color):hover {
					color: {$button_text_color};
				}
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background) {
					background-color: {$button_background_color};
				}
				.wp-block-calendar tbody td > a {
					background-color: {$button_background_color_lighter};
					color: {$button_text_color};
				}
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color) {
					border-color: {$button_background_color};
					color: {$button_background_color};
				}
				.wp-block-file .wp-block-file__button,
				.wp-block-search .wp-block-search__button {
                    color: {$button_text_color};
                    background-color: {$button_background_color};
                    border-color: {$button_background_color};
                }
                .block-editor .wp-block-more input[type='text'],
                .wp-block-calendar #today,
                .wp-block-tag-cloud a:hover {
                    background-color: {$button_background_color};
                    color: {$button_text_color};
                }
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):hover,
				.block-editor .wp-block-more input[type='text']:focus {
					background-color: {$button_alt_text_color};
				}
				.wp-block-file.wp-block-file .wp-block-file__button:hover,
				.wp-block-search .wp-block-search__button:hover,
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):hover {
					border-color: {$button_alt_text_color};
					color: {$button_alt_text_color};
				}
			";

			wp_add_inline_style( 'conj-lite-block-editor-styles', wp_strip_all_tags( $inline_css ) );

		}

		/**
  		 * Adds a custom parameter to the editor settings that is used
  		 * to track whether the main sidebar has widgets.
  		 *
  		 * @see 	https://developer.wordpress.org/reference/hooks/block_editor_settings/
  		 * @see 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
  		 * @access 	public
  		 * @param 	array   	$settings 	Default editor settings.
  		 * @param 	WP_Post 	$post 		Post being edited.
  		 * @return 	array 					Filtered block editor settings.
  		 */
  		public function custom_editor_settings( $settings, $post ) {
			
			$settings['conjLiteHasSidebarActive'] =	FALSE;

			if ( is_active_sidebar( 'sidebar-1' ) ) {
				$settings['conjLiteHasSidebarActive'] = TRUE;
			} // End If Statement

			return $settings;

  		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 *
		 * Wait for the WooCommerce...
		 *
		 * @access 	public
		 * @return 	void
		 */
		public function child_scripts() {

			if ( is_child_theme() ) {
				wp_enqueue_style( 'conj-child-styles', get_theme_file_uri( '/style.css' ), array(), NULL, 'all' );
			} // End If Statement

		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/body_class/
		 * @access 	public
		 * @param  	array 	$classes 	Classes for the body element.
		 * @return 	array
		 */
		public function body_classes( $classes ) {

			// Adds a class of group-blog to blogs with more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			} // End If Statement
			
			// Add class of hfeed to non-singular pages.
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			} // End If Statement

			// Add class if WooCommerce breadcrumbs removed.
			if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
				$classes[]	= 'no-wc-breadcrumb';
			} // End If Statement

			// Add class if we're viewing the Customizer for easier styling of theme options.
			if ( is_customize_preview() ) {
				$classes[] = 'customizer-running';
			} // End If Statement

			// Add a class if there is a custom header.
			if ( has_header_image() ) {
				$classes[] = 'has-header-image';
			} // End If Statement

			$layout_sidebar = (string) get_theme_mod( 'conj_layout_sidebar', 'left-sidebar' );
			// Add class if sidebar is used.
			if ( is_active_sidebar( 'sidebar-1' ) && ! is_404() && ! conj_lite_is_fluid_template() ) {
				$classes[] = 'has-sidebar';
				// Add a class to define sidebar placement.
				if ( ! empty( $layout_sidebar ) ) {
					$classes[] = esc_attr( $layout_sidebar );
				} // End If Statement
			} // End If Statement

			// Add class if the current page is a blog post archive/single.
			if ( conj_lite_is_blog_archive() ) {
				$classes[]	= 'blog-archive';
			} // End If Statement

			return apply_filters( 'conj_lite_body_classes', (array) $classes );

		}

		/**
		 * Replaces "[...]" (appended to automatically generated excerpts) with `...`
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/excerpt_more/
		 * @access 	public
		 * @param 	string $excerpt Excerpt more string.
		 * @return 	string
		 */
		public function custom_excerpt_more( $more ) {

			// Bail out, if the current request IS for an ADMINISTRATIVE interface page.
			if ( is_admin() ) {
				return $more;
			} // End If Statement

			return apply_filters( 'conj_lite_custom_excerpt_more', '&hellip;' );

		}

		/**
		 * Modifies tag cloud widget arguments to display all tags in the same font size
		 * and use list format for better accessibility.
		 *
		 * @param 	array $args Arguments for tag cloud widget.
		 * @access 	public
		 * @return 	array The filtered arguments for tag cloud widget.
		 */
		public function widget_tag_cloud_args( $args ) {

			$args['largest']  = 1;
			$args['smallest'] = 1;
			$args['unit'] = 'em';
			$args['format'] = 'list';

			return $args;
			
		}

		/**
		 * Flush out the transients used in conj_categorized_blog.
		 *
		 * @see 	https://codex.wordpress.org/Function_Reference/delete_transient
		 * @access 	public
		 * @return 	void
		 */
		public function category_transient_flusher() {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			} // End If Statement

			delete_transient( 'conj_lite_categories' );

		}

		/**
		 * Move the comment text field to the bottom.
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/comment_form_fields/
		 * @param  	array  $fields 		The comment fields..
		 * @return 	array
		 */
		public function move_comment_field_to_bottom( $fields ) {

			$comment_field = $fields['comment'];
        	unset( $fields['comment'] );
        	$fields['comment'] = $comment_field;

        	return $fields;

		}

		/**
		 * Adds a span around post counts in category widget.
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/wp_list_categories/
		 * @access 	public
		 * @param  	html  	$links 		HTML markup of the links.
		 * @return 	html
		 */
		public function cat_count_span( $links ) {

			$links = str_replace( '</a> (', '<span class="count">(', $links );
			$links = str_replace( ')', ')</span></a>', $links );

			return $links;

		}

		/**
		 * Adds a span around post counts in archive widget.
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/get_archives_link/
		 * @access 	public
		 * @param  	html  	$links 		HTML markup of the links.
		 * @return 	html
		 */
		public function archive_count_span( $links ) {

			$links = str_replace( '</a>&nbsp;(', '<span class="count">(', $links );
			$links = str_replace( ')', ')</span></a>', $links );

			return $links;

		}
		
		/**
		 * Adds a span around post counts in archive widget.
		 *
		 * @see 	http://justintadlock.com/archives/2012/09/06/post-formats-aside
		 * @access 	public
		 * @param  	html  	$content 	Content of the post.
		 * @return 	html 				Content of the post with an infinite symbol permalink appended to it.
		 */
		public function aside_to_infinity_and_beyond( $content ) {

			if ( has_post_format( 'aside' ) && ! is_singular() ) {
				$content .= sprintf( ' <a href="%s">&#8734;</a>', esc_url( get_permalink() ) );
			} // End If Statement

			return $content;

		}

		/**
		 * Make Get_Post_Gallery work for Gutenberg powered sites.
		 *
		 * @see 	https://gist.github.com/BinaryMoon/cd1eb239d4a14ba3ab45b756e4c64828
		 * @access 	public
		 * @param  	array  			$gallery 	The first-found post gallery.
		 * @param  	int|WP_Post  	$post 		Post ID or object.
		 * @return 	array 						Associative array of all found post galleries.
		 */
		public function polyfill_get_post_gallery( $gallery, $post ) {

			// Already found a gallery so lets quit.
			if ( $gallery ) {
				return $gallery;
			} // End If Statement

			// Check the post exists.
			$post = get_post( $post );
			if ( ! $post ) {
				return $gallery;
			} // End If Statement

			// Not using Gutenberg so let's quit.
			if ( ! function_exists( 'has_blocks' ) ) {
				return $gallery;
			} // End If Statement

			// Not using blocks so let's quit.
			if ( ! has_blocks( $post->post_content ) ) {
				return $gallery;
			} // End If Statement

			/**
			 * Search for gallery blocks and then, if found, return the html from the
			 * first gallery block.
			 *
			 * Thanks to Gabor for help with the regex:
			 * https://twitter.com/javorszky/status/1043785500564381696.
			 */
			$pattern = "/<!--\ wp:gallery.*-->([\s\S]*?)<!--\ \/wp:gallery -->/i";
			preg_match_all( $pattern, $post->post_content, $the_galleries );

			// Check a gallery was found and if so change the gallery html.
			if ( ! empty( $the_galleries[1] ) ) {
				$gallery 	=	 reset( $the_galleries[1] );
			} // End If Statement

			return $gallery;

		}

	}

endif;
// End Class.

return new Conj_Lite();
