<?php
/**
 * Conj Lite Class
 *
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MyPreview_Conj_Lite' ) ) :

	/**
	 * The main Conj Lite class
	 */
	class MyPreview_Conj_Lite {

		/**
		 * Setup class.
		 *
		 * @return  void
		 */
		public function __construct() {

			add_action( 'after_setup_theme',        array( $this, 'setup' ),                           10 );
			add_action( 'wp_head',          		array( $this, 'javascript_detection' ),             0 );
			add_action( 'wp_head',          		array( $this, 'pingback_header' ),                 10 );
			add_action( 'widgets_init',             array( $this, 'widgets_init' ),                     5 );
			add_action( 'wp_resource_hints',        array( $this, 'resource_hints' ),               10, 2 );
			add_action( 'wp_enqueue_scripts',       array( $this, 'enqueue' ),                     	   10 );
			add_action( 'wp_enqueue_scripts',       array( $this, 'child_scripts' ),       			   30 );
			add_filter( 'body_class',               array( $this, 'body_classes' ), 				10, 1 );
			add_filter( 'excerpt_more',             array( $this, 'custom_excerpt_more' ), 			10, 1 );
			add_filter( 'widget_tag_cloud_args',    array( $this, 'widget_tag_cloud_args' ), 		10, 1 );
			add_action( 'edit_category',            array( $this, 'category_transient_flusher' ), 	   10 );
			add_action( 'save_post',                array( $this, 'category_transient_flusher' ), 	   10 );
			add_filter( 'comment_form_fields',      array( $this, 'move_comment_field_to_bottom' ), 10, 1 );
			add_filter( 'wp_list_categories', 		array( $this, 'cat_count_span' ), 				10, 1 );
			add_filter( 'get_archives_link', 		array( $this, 'archive_count_span' ), 			10, 1 );
			add_filter( 'the_content', 				array( $this, 'aside_to_infinity_and_beyond' ),  9, 1 );

		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @return  void
		 */
		public function setup() {

			/**
			 * Set the content width based on the theme's design and stylesheet.
			 *
			 * @see 	https://codex.wordpress.org/Content_Width
			 */
			if ( ! isset( $content_width ) ) {
				$content_width = apply_filters( 'mypreview_conj_lite_content_width', 1210 ); /* pixels */
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
			add_theme_support( 'custom-logo', array(
				'height'      => 140,
				'width'       => 400,
				'flex-width'  => TRUE
			) );

			/**
			 * Set up the WordPress core custom header feature.
			 *
			 * @see 	https://developer.wordpress.org/themes/functionality/custom-headers
			 */
			add_theme_support( 'custom-header', apply_filters( 'mypreview_conj_lite_custom_header_args', array(
				'default-text-color' => 	'6B6F81',
				'width'              => 	1950,
				'height'             => 	500,
				'flex-height'        => 	TRUE,
				'wp-head-callback'   => 	array( $this, 'header_styles' )
			) ) );

			/**
			 * Set up the WordPress core custom background feature.
			 *
			 * @see 	https://codex.wordpress.org/Custom_Backgrounds
			 */
			add_theme_support( 'custom-background', apply_filters( 'mypreview_conj_lite_custom_background_args', array(
				'default-color' 	=> 		'F4F5FA',
				'default-image' 	=> 		'',
				'wp-head-callback'  => 		array( $this, 'background_styles' )
			) ) );

			/**
			 * This theme uses wp_nav_menu() in four location.
			 *
			 * @see 	https://developer.wordpress.org/reference/functions/wp_nav_menu/
			 */
			register_nav_menus( array(
				'primary'   => __( 'Primary Menu', 'conj-lite' ),
				'handheld'	=> __( 'Push Menu', 'conj-lite' )
			) );

			/**
			* Enable support for post formats.
			*
			* @see 		https://codex.wordpress.org/Post_Formats
			*/
			add_theme_support( 'post-formats', array(
				'image'
			) );

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets'
			) );

			// Declare support for title theme feature.
			add_theme_support( 'title-tag' );

			// Declare support for selective refreshing of widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );

			/*
			 * This theme styles the visual editor to resemble the theme style,
			 * specifically font, colors, and column width.
		 	 */
			add_editor_style( array( 'assets/css/editor-style.css', self::google_fonts_url() ) );

		}

		/**
		 * Get site header text color.
		 *
		 * @return string
		 */
		public function header_styles() {

			$header_text_color = get_header_textcolor();

			// If no custom options for text are set, let's bail.
			// get_header_textcolor() options: add_theme_support( 'custom-header' ) is default, hide text (returns 'blank') or any hex value.
			if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
				return;
			}

			// If we get this far, we have custom styles. Let's do this.
			?>
			<style type="text/css">
			<?php
				// Has the text been hidden?
				if ( 'blank' === $header_text_color ) : ?>
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
				// If the user has set a custom color for the text use that.
				else : ?>
				.site-title,
				.site-title a,
				.site-description {
					color: #<?php echo sanitize_hex_color_no_hash( $header_text_color ); ?>;
				}
			<?php endif; ?>
			</style>
			<?php

		}

		/**
		 * Get the background color.
		 *
		 * @return string
		 */
		public function background_styles() {

			$background_color = get_background_color();

			?>
			<style type="text/css">
				body {
					background-color: #<?php echo sanitize_hex_color_no_hash( $background_color ); ?>;
				}
			</style>
			<?php

		}

		/**
		 * Handles JavaScript detection.
		 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
		 *
		 * @return  void
		 */
		public function javascript_detection() {

			echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

		}

		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles.
		 *
		 * @return  void
		 */
		public function pingback_header() {

			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
			}

		}

		/**
		 * Register widget area.
		 *
		 * @see 	https://codex.wordpress.org/Function_Reference/register_sidebar
		 * @return  void
		 */
		public function widgets_init() {

			$sidebar_args['sidebar'] = array(
				'name'          => __( 'Sidebar', 'conj-lite' ),
				'id'            => 'sidebar-1',
				'description'   => __( 'Widgets added to this region will appear in archive/shop pages.', 'conj-lite' )
			);

			$regions = intval( apply_filters( 'mypreview_conj_lite_footer_widget_columns', 4 ) );

			for ( $region = 1; $region <= $regions; $region++ ) {

				$footer   = sprintf( 'footer_%d', $region );

				/* translators: 1: Decimal number. */
				$footer_region_name = sprintf( __( 'Footer Column %1$d', 'conj-lite' ), $region );
				/* translators: 1: Decimal number. */
				$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'conj-lite' ), $region );

				$sidebar_args[ $footer ] = array(
					'name'        => $footer_region_name,
					/* translators: 1: Decimal number. */
					'id'          => sprintf( 'footer-%d', $region ),
					'description' => $footer_region_description,
				);
			}

			$sidebar_args = apply_filters( 'mypreview_conj_lite_sidebar_args', $sidebar_args );

			foreach ( $sidebar_args as $sidebar => $args ) {

				if ( 'mega-menu-sidebar' === $args['id'] ) {
					$wrapper_tag = 'li';
					$title_tag = 'h2';
				} else {
					$wrapper_tag = 'div';
					$title_tag = 'span';
				}// End If Statement

				$widget_tags = array(
					'before_widget' => '<' . esc_html( $wrapper_tag ) . ' id="%1$s" class="widget %2$s">',
					'after_widget'  => '</' . esc_html( $wrapper_tag ) . '>',
					'before_title'  => '<' . esc_html( $title_tag ) . ' class="widget-title">',
					'after_title'   => '</' . esc_html( $title_tag ) . '>',
				);
				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 *
				 * 'mypreview_conj_lite_sidebar_widget_tags'
				 *
				 * 'mypreview_conj_lite_footer_1_widget_tags'
				 * 'mypreview_conj_lite_footer_2_widget_tags'
				 * 'mypreview_conj_lite_footer_3_widget_tags'
				 * 'mypreview_conj_lite_footer_4_widget_tags'
				 */
				$filter_hook = sprintf( 'mypreview_conj_lite_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );
				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}

		}

		/**
		 * Add preconnect for Google Fonts.
		 *
		 * @param  array  $urls            URLs to print for resource hints.
		 * @param  array  $relation_type   The relation type the URLs are printed.
		 * @return array  $urls            URLs to print for resource hints.
		 */
		public function resource_hints( $urls, $relation_type ) {

			if ( wp_style_is( 'mypreview-conj-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
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
		 * @return string|url
		 */
		public static function google_fonts_url() {

			$fonts_url = '';
			/*
			 * Translators: If there are characters in your language that are not
			 * supported by Montserrat, translate this to 'off'. Do not translate
			 * into your own language.
			 */
			$montserrat = _x( 'on', 'montserrat font: on or off', 'conj-lite' );

			if ( 'off' !== $montserrat ) {
				$font_families = array();
				$font_families[] = 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
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
		 * @see 	https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
		 * @return 	void
		 */
		public function enqueue() {

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'mypreview-conj-google-font', self::google_fonts_url(), array(), null );
			wp_enqueue_style( 'feather', get_theme_file_uri( '/assets/css/vendor/feather' . $suffix . '.css' ), array(), MYPREVIEW_CONJ_LITE_THEME_VERSION );
			wp_enqueue_style( 'mypreview-conj-styles', get_stylesheet_uri(), '', MYPREVIEW_CONJ_LITE_THEME_VERSION );

			wp_enqueue_script( 'mypreview-conj-scripts', get_theme_file_uri( '/assets/js/conj' . $suffix . '.js' ), array( 'jquery' ), MYPREVIEW_CONJ_LITE_THEME_VERSION, TRUE );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

				wp_enqueue_script( 'comment-reply' );

			} // End If Statement

		}
		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 *
		 * @return void
		 */
		public function child_scripts() {

			if ( is_child_theme() ) {

				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( 'mypreview-conj-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );

			} // End If Statement

		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param  array $classes Classes for the body element.
		 * @return array
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

			// Add class if we're viewing the Customizer for easier styling of theme options.
			if ( is_customize_preview() ) {
				$classes[] = 'mypreview-conj-customizer';
			} // End If Statement

			// Add a class if there is a custom header.
			if ( has_header_image() ) {
				$classes[] = 'has-header-image';
			} // End If Statement

			// Add class if sidebar is used.
			if ( is_active_sidebar( 'sidebar-1' ) && ! is_404() ) {
				$classes[] = 'has-sidebar left-sidebar';
			} // End If Statement

			// Add class if the site title and tagline is hidden.
			if ( 'blank' === get_header_textcolor() ) {
				$classes[] = 'title-tagline-hidden';
			} // End If Statement

			// Add class if WooCommerce breadcrumbs removed.
			if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
				$classes[]	= 'no-wc-breadcrumb';
			} // End If Statement

			return $classes;

		}

		/**
		 * Replaces "[...]" (appended to automatically generated excerpts) with `...`
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/excerpt_more/
		 * @param 	string $excerpt Excerpt more string.
		 * @return 	string
		 */
		public function custom_excerpt_more( $more ) {

			if ( is_admin() ) {
				return $more;
			}

			return apply_filters( 'mypreview_conj_lite_excerpt_more', '&hellip;' );

		}

		/**
		 * Modifies tag cloud widget arguments to display all tags in the same font size
		 * and use list format for better accessibility.
		 *
		 * @param 	array $args Arguments for tag cloud widget.
		 * @return 	array The filtered arguments for tag cloud widget.
		 */
		public function widget_tag_cloud_args( $args ) {

			$args['largest']  = 1;
			$args['smallest'] = 1;
			$args['unit']     = 'em';
			$args['format']   = 'list';

			return $args;
			
		}

		/**
		 * Flush out the transients used in mypreview_conj_lite_categorized_blog.
		 *
		 * @see 	https://codex.wordpress.org/Function_Reference/delete_transient
		 * @return 	void
		 */
		public function category_transient_flusher() {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			} // End If Statement

			delete_transient( 'mypreview_conj_lite_categories' );

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
		 * @param  	html  $links 		HTML markup of the links.
		 * @return 	html
		 */
		public function cat_count_span( $links ) {

			$links 	= 	str_replace( '</a> (', '<span class="count">(', $links );
			$links 	= 	str_replace( ')', ')</span></a>', $links );

			return $links;

		}

		/**
		 * Adds a span around post counts in archive widget.
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/get_archives_link/
		 * @param  	html  $links 		HTML markup of the links.
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
		 * @param  	html  $content 		Content of the post.
		 * @return 	html 				Content of the post with an infinite symbol permalink appended to it.
		 */
		public function aside_to_infinity_and_beyond( $content ) {

			if ( has_post_format('aside') && ! is_singular() ) {
				$content .= ' <a href="' . esc_url( get_permalink() ) . '">&#8734;</a>';
			} // End If Statement

			return $content;

		}

	}

endif;
// End Class.

return new MyPreview_Conj_Lite();