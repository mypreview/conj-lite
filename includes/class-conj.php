<?php
/**
 * Conj Lite Class
 *
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.9
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

			add_action( 'after_setup_theme',        							array( $this, 'setup' ),                           10 );
			add_action( 'wp_head',          									array( $this, 'javascript_detection' ),             0 );
			add_action( 'wp_head',          									array( $this, 'pingback_header' ),                 10 );
			add_action( 'widgets_init',             							array( $this, 'widgets_init' ),                     5 );
			add_action( 'wp_resource_hints',        							array( $this, 'resource_hints' ),               10, 2 );
			add_action( 'wp_enqueue_scripts',       							array( $this, 'enqueue' ),                     	   10 );
			add_action( 'admin_enqueue_scripts', 								array( $this, 'admin_enqueue' ),  		   		   10 );
			add_action( 'wp_enqueue_scripts',       							array( $this, 'child_scripts' ),       			   30 );
			add_filter( 'body_class',               							array( $this, 'body_classes' ), 				10, 1 );
			add_filter( 'excerpt_more',             							array( $this, 'custom_excerpt_more' ), 			10, 1 );
			add_filter( 'widget_tag_cloud_args',    							array( $this, 'widget_tag_cloud_args' ), 		10, 1 );
			add_action( 'edit_category',            							array( $this, 'category_transient_flusher' ), 	   10 );
			add_action( 'save_post',                							array( $this, 'category_transient_flusher' ), 	   10 );
			add_filter( 'comment_form_fields',      							array( $this, 'move_comment_field_to_bottom' ), 10, 1 );
			add_filter( 'wp_list_categories', 									array( $this, 'cat_count_span' ), 				10, 1 );
			add_filter( 'get_archives_link', 									array( $this, 'archive_count_span' ), 			10, 1 );
			add_filter( 'the_content', 											array( $this, 'aside_to_infinity_and_beyond' ),  9, 1 );
			add_action( 'admin_notices', 										array( $this, 'upsell_notice' ),  		   		   10 );
			add_action( 'wp_ajax_mypreview_conj_lite_dismiss_upsell_notice', 	array( $this, 'dismiss_upsell_notice' ), 		   10 );
			add_action( 'switch_theme', 										array( $this, 'bring_back_upsell_notice' ), 	   10 );
			add_action( 'admin_menu', 											array( $this, 'register_upsell_menu' ),  		   10 );

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
		 * Enqueue extra CSS & JavaScript to improve the user experience in the WordPress dashboard.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_localize_script/
		 * @return 	void
		 */
		public function admin_enqueue() {

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'mypreview-conj-upsell-styles', get_theme_file_uri( '/assets/admin/css/upsell' . $suffix . '.css' ), '', MYPREVIEW_CONJ_LITE_THEME_VERSION );

			$mypreview_conj_lite_admin_l10n = array(
					'ajaxurl' 				=> 		admin_url( 'admin-ajax.php' ),
					'notice_nonce'	 		=> 		wp_create_nonce( 'mypreview_conj_lite_upsell_dismissed_mEwAPEpdyU' )
			);
			wp_register_script( 'mypreview-conj-upsell-scripts', get_theme_file_uri( '/assets/admin/js/upsell' . $suffix . '.js' ), array( 'jquery' ) , MYPREVIEW_CONJ_LITE_THEME_VERSION, TRUE );
			wp_localize_script( 'mypreview-conj-upsell-scripts', 'MyPreviewConjUpsellNotice', $mypreview_conj_lite_admin_l10n );
			wp_enqueue_script( 'mypreview-conj-upsell-scripts' );

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
		 * @see 	https://developer.wordpress.org/reference/functions/is_admin/
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

		/**
		 * Output admin notices.
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/admin_notices/
		 * @return 	void
		 */
		public function upsell_notice() {

			// Bail out, if the user already closed up-sell notice.
			if ( TRUE === (bool) get_option( 'mypreview_conj_lite_upsell_dismissed_mEwAPEpdyU' ) ) {
				return;
			} // End If Statement
			?>

			<div id="conj-upsell-notice" class="notice notice-info is-dismissible">
				<div class="conj-upsell-notice__logo">
					<img class="mypreview-logo" src="<?php echo get_theme_file_uri( 'assets/admin/img/mypreview-logo.png' ); ?>" alt="<?php esc_attr_e( 'MyPreview LLC', 'conj-lite' ); ?>" />
				</div>
				<div class="conj-upsell-notice__wrapper">
					<div class="conj-upsell-notice__content">
						<h3><?php esc_html_e( 'CONJ - eCommerce WordPress Theme', 'conj-lite' ); ?></h3>
						<p><?php 
						/* translators: 1: Open anchor tag, 2: Close anchor tag. */
						printf( esc_html__( 'This item is only available to purchase from %1$sThemeforest%2$s marketplace.', 'conj-lite' ), '<a href="' . esc_url( MYPREVIEW_CONJ_LITE_THEME_URI ) . '" target="_blank">', '</a>' ); ?></p>
					</div><!-- .notice-content -->
					<div class="conj-upsell-notice__btns">
						<a href="<?php echo esc_url( MYPREVIEW_CONJ_LITE_THEME_URI ); ?>" class="button-primary" target="_blank"><strong><?php esc_html_e( 'Upgrade to CONJ PRO', 'conj-lite' ); ?> &rarr;</strong></a>
						<a href="<?php echo esc_url ( admin_url( 'themes.php?page=conj-pro-upsell-screen' ) ); ?>" class="button-secondary" target="_self"><strong><?php esc_html_e( 'Get to Know More', 'conj-lite' ); ?></strong></a>
					</div>
				</div><!-- .conj-upsell-notice__wrapper -->
			</div><!-- #conj-upsell-notice -->

			<?php

		}

		/**
		 * AJAX dismiss up-sell notice.
		 *
		 * @see 	https://wordpress.stackexchange.com/questions/242705/how-to-stop-showing-admin-notice-after-close-button-has-been-clicked
		 * @return 	void
		 */
		public function dismiss_upsell_notice() {

			$nonce = ! empty( $_POST['nonce'] ) ? $_POST['nonce'] : FALSE;
			
			if ( ! $nonce || ! wp_verify_nonce( $nonce, 'mypreview_conj_lite_upsell_dismissed_mEwAPEpdyU' ) || ! current_user_can( 'manage_options' ) ) {
				wp_die();
			} // End If Statement
			
			update_option( 'mypreview_conj_lite_upsell_dismissed_mEwAPEpdyU', TRUE );

		}

		/**
		 * Bring back CONJ pro up-sell notice once the CONJ lite theme has been switched.
		 *
		 * @see 	https://codex.wordpress.org/Function_Reference/switch_theme
		 * @return 	void
		 */
		public function bring_back_upsell_notice() {

			update_option( 'mypreview_conj_lite_upsell_dismissed_mEwAPEpdyU', FALSE );

		}

		/**
		 * Register the up-sell screen page.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/add_theme_page/
		 * @return 	void
		 */
		public function register_upsell_menu() {

			$page_title 	= 	esc_html__( 'Upgrade to CONJ PRO', 'conj-lite' );
			$menu_title 	= 	esc_html__( 'CONJ PRO', 'conj-lite' );
			add_theme_page( $page_title, $menu_title, 'manage_options', 'conj-pro-upsell-screen', array(
				$this,
				'upsell_screen'
			) );

		}

		/**
		 * The function to be called to output the up-sell content for this page.
		 *
		 * @return 	void
		 */
		public function upsell_screen() {

			?>
			<div class="wrap upgrade-to-conj-pro-wrapper">
				<h2><?php esc_html_e( 'Meet Conj Pro', 'conj-lite' ); ?></h2>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<!-- main content -->
						<div id="post-body-content">
							<div class="meta-box-sortables ui-sortable">
								<div class="postbox">
									<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle', 'conj-lite' ); ?>"><br /></div><!-- .handlediv -->
									<!-- Toggle -->
									<div id="upgrade-to-conj-pro">
										<h2 class="hndle"><span><?php esc_html_e( 'Cool features you get with CONJ PRO theme', 'conj-lite' ); ?></span></h2>
										<div class="inside">
											<h3><?php esc_html_e( 'Get started with Conj which is the one thing you need to build your own stunning eCommerce website in a fast and efficient way.', 'conj-lite' ); ?></h3>
											<p><?php esc_html_e( 'Conj\'s fantastic out of the box deep code and design integration with WooCommerce, the premier eCommerce solution for WordPress, enables your store to be bulletproof against any conflicts during major WooCommerce updates.', 'conj-lite' ); ?></p>
											<p><?php esc_html_e( 'The entire platform of Conj is built on top of the Underscores starter theme which is a solid foundation of code and also used for all themes released by Automattic on WordPress.com.', 'conj-lite' ); ?></p>
											<br/>
											<table cellpadding="10" id="conj-pro-features-list">
												<tbody>
													<tr>
														<td class="icon"><span class="dashicons dashicons-editor-table"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Layout alignment', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Easily swap the content area & the sidebar layout from left to right or vice versa.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-products"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Copyright credit', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Customize the copyright content as well as disable the WordPress and/or Conj theme credit links as well.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-search"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Header search field', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Displays search form in site navigation that makes users search the site quickly.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-update"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Automatic updates', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'You can update the theme automatically via the WordPress admin panel providing you have activated a valid license key.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-format-gallery"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Product image flipper', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Secondary product thumbnail on archives that is revealed when you hover over the main product image.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-sort"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Reorder homepage components', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Lightweight option that allows you to toggle the visibility & reorder the homepage components of the theme.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-translation"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Translation ready', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Conj theme is translation-ready and localized using the GNU framework.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-editor-expand"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Fluid post, page & product template', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Create a fluid template which spans from right to left takes most of the screen\'s width.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-admin-site"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'WPML compatible', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Conj theme is fully compatible and tested with most popular WordPress plugin that supports the creation of multilingual layouts.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-format-aside"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Aside post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'For brief snippets of text that are not entirely whole blog posts, such as quick thoughts and anecdotes. Similar to a Facebook note update.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-format-image"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Image post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php 
															/* translators: 1: Open code tag, 2: Close code tag. */
															printf( esc_html__( 'A single image. The first %1$s<img/>%2$s tag in the post content or uploaded featured image will be considered as an image post format.', 'conj-lite' ), '<code>', '</code>' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-format-video"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Video post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php 
															/* translators: 1: Open code tag, 2: Close code tag. */
															printf( esc_html__( 'A single video or video playlist. The first %1$s<video/>%2$s tag or embed in the post content will be considered as a video post format.', 'conj-lite' ), '<code>', '</code>' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-format-quote"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Quote post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'A quotation. The theme would add blockquote tag to the quote content automatically if the user didn\'t add it.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-images-alt2"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Gallery post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'A gallery of images. Post will likely contain a gallery shortcode and will have image attachments.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-admin-links"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Link post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'For those days when you just want to share a link to a fantastic article you read which creates a post that links to external resources right from the title.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-format-audio"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Audio post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php 
															/* translators: 1: Open code tag, 2: Close code tag. */
															printf( esc_html__( 'An audio file of your tunes or podcasts. The first %1$s<audio/>%2$s tag or embed in the post content will be considered as a audio post format.', 'conj-lite' ), '<code>', '</code>' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-format-chat"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Chat post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'To highlight an interesting conversation or a chat transcript you have with friends, both on- and offline.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-format-status"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Status post format', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'A quick update on what you are doing right now most likely to a Twitter status update because updates are no longer reserved for social networks.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-art"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Color scheme', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'You can use this option to choose a color, view color suggestions, refine with the color picker, & apply background color changes.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-align-center"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Footer bar', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'A full-width widgetized region which will display any widget added to this region above the Conj footer widget area.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-share"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Social network menu', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Navigation social media links to services like Twitter & Facebook, allowing visitors to access your social profiles quickly.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-arrow-right-alt"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Breadcrumbs', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'A simple yet useful feature to generate locational Schema.org compatible breadcrumb trails for posts, pages  & products.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-filter"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Product archive customizer', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Toggle the display of core elements & enable some that are not included in WooCommerce core.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-admin-customizer"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Product details customizer', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Change the layout & customize every element of the product single view page.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-schedule"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Sticky navigation', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'This control gives you the option to lock the entire navigation to the top of the page as the user scrolls.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-download"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'One click demo import', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'The easiest way to build your website, import whole demo content and set up your shop to look just like our demo in one click only.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-store"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'WooCommerce integration', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Designed & developed with WooCommerce functionality in mind & features a tight-knit integration with its extensions as well.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-hammer"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Header layout customizer', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Toggle and rearrange header components such as logo, mini-cart, search field, navigation, etc. with drag & drop.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-tagcloud"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Mega-Menu dropdowns', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Use drag & drop to add widgets that can be rearranged and resized to display any content you wish in your site navigation.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-pressthis"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Sticky add to cart', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'A content bar at the top of the browser window which includes the product name, price, rating, stock status and the add to cart button.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-store"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Distraction free checkout', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Remove any components that might be a distraction at checkout allowing the customer to focus on completing the checkout form.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-redo"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Two-Step checkout', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Enables two-step checkout, which separates the input of customer details / payment details into two pages.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-phone"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Contact info widget', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Display your location, hours, & contact information along with an optional Google map view.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-welcome-widgets-menus"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Sticky order review', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'The order review section sticks to the top of the browser window as the user scrolls down the checkout page.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-email"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'MailChimp newsletter integration', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'An easy, lightweight way to let your users sign up for several different MailChimp lists by creating multiple instances of the widget.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-menu"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Push menu', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Turn the mobile navigation into an off-screen, off-canvas sidebar menu with a hamburger toggle.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-star-half"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Featured reviews', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Display reviews on your homepage in a variety of styles & increase conversions by highlighting positive & selected product reviews.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-editor-textcolor"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Typography', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Easy access to any fonts you want from Google Web Fonts, the best free fonts available. Choose between dozens of popular fonts.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-cart"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Hero product', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Add an elegant hero component to the homepage template of your Conj powered webshop & watch conversions soar!', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-admin-generic"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Service component', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Service component makes it really easy to select a custom font icon to go along with any feature or service you provide.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-wordpress"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Based on Underscores', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'The entire platform of Conj is built on top of the Underscores starter theme which is a solid foundation of code by WordPress.com.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-megaphone"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Promo box widget', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'An image promo is an ideal way to convert more of your passive website visitors into active leads and customers.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-screenoptions"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Flexible CSS grid', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Conj uses a mobile-first grid-based architecture that renders beautifully formatted content on phones, tablets, & desktop monitors.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-slides"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Product pagination', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Display next & previous links on single product pages with a product thumbnail that will be revealed on hover.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-smartphone"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Handheld footer bar', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Display a sleek sticky bar with links to the user\'s account, search, & the shopping cart on devices with smaller screens.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-share-alt2"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Social Media widget', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Lets you easily add icons for the most popular social networks to your sidebar or any other widget area.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-visibility"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Retina ready', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Conj aesthetic galore HiDPI is achieved through CSS & vector graphics to ensure pixel perfection is reflected in the developed theme.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-share-alt"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Share buttons', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Buttons designed to be minimal, yet powerful, with support of popular networks to make your products go viral & get more traffic.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-align-right"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Sticky sidebar', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'This control gives you the option to lock the entire sidebar area to the top of the page as the user scrolls.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-slides"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Slider post type', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Image & content slider which supports touch navigation with a swipe gesture.', 'conj-lite' ); ?>
														</td>
													</tr>
													<tr>
														<td class="icon"><span class="dashicons dashicons-hidden"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'Page title toggle', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Easily remove the page title from specific single pages, shop or homepage template.', 'conj-lite' ); ?>
														</td>
														<td class="icon"><span class="dashicons dashicons-welcome-view-site"></span></td>
														<td class="content">
															<strong><?php esc_html_e( 'IE 11 compatible', 'conj-lite' ); ?></strong>
															<br/>
															<?php esc_html_e( 'Although Internet Explorer relatively is an old browser, Conj theme supports the browser globally and is compatible with IE 11 fully.', 'conj-lite' ); ?>
														</td>
													</tr>
												</tbody>
											</table>
										</div><!-- .inside -->
									</div><!-- #upgrade-to-conj-pro -->
								</div><!-- .postbox -->
							</div><!-- .meta-box-sortables -->
						</div><!-- #post-body-content -->
						<!-- sidebar -->
						<div id="postbox-container-1" class="postbox-container">
							<div class="meta-box-sortables">
								<div class="postbox">
									<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle', 'conj-lite' ); ?>"><br /></div><!-- .handlediv -->
									<!-- Toggle -->
									<div id="upgrade-to-conj-pro-sidebar">
										<h2 class="hndle"><span><?php esc_html_e( 'Get the one thing you need!', 'conj-lite' ); ?></span></h2>
										<div class="inside">
											<p align="center">
												<a href="<?php echo esc_url( MYPREVIEW_CONJ_LITE_THEME_URI ); ?>" target="_blank">
													<img class="conj-pro-featured-image" src="<?php echo get_theme_file_uri( 'assets/admin/img/buy-conj-pro-ecommerce-wordpress-theme.jpg' ); ?>" alt="CONJ PRO - eCommerce WordPress Theme" />
												</a>
											</p>
											<p align="center">
												<a href="<?php echo esc_url( MYPREVIEW_CONJ_LITE_THEME_URI ); ?>" class="button-primary" target="_blank"><strong><?php esc_html_e( 'Buy Now', 'conj-lite' ); ?></strong></a>
												<a href="<?php echo esc_url( 'https://www.conj.ws' ); ?>" class="button-secondary" target="_blank"><strong><?php esc_html_e( 'Live Demo', 'conj-lite' ); ?></strong></a>
											</p>
										</div><!-- .inside -->
									</div><!-- #upgrade-to-conj-pro-sidebar -->
								</div><!-- .postbox -->
								<div class="postbox">
									<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle', 'conj-lite' ); ?>"><br /></div><!-- .handlediv -->
									<!-- Toggle -->
									<div id="conj-support-docs-sidebar">
										<h2 class="hndle"><span><?php esc_html_e( 'Support and Documentation', 'conj-lite' ); ?></span></h2>
										<div class="inside">
											<p><?php esc_html_e( 'As you might have already gathered, we love hearing your feedback, And you seem to love giving it!', 'conj-lite' ); ?></p>
											<p><?php echo esc_html_e( 'Our top priority is that you have a great experience with us and learn to create amazing code-free websites quickly.', 'conj-lite' ); ?></p>
											<p align="center">
												<a href="<?php echo esc_url( MYPREVIEW_CONJ_LITE_THEME_DOC_URI ); ?>" class="button-secondary" target="_blank"><strong><?php esc_html_e( 'Documentation', 'conj-lite' ); ?></strong></a>
											</p>
										</div><!-- .inside -->
									</div><!-- #upgrade-to-conj-pro-sidebar -->
								</div><!-- .postbox -->
							</div><!-- .meta-box-sortables -->
						</div><!-- .postbox-container -->
					</div><!-- #post-body -->
				</div><!-- #poststuff -->
			</div><!-- .wrap -->
			<?php

		}

	}

endif;
// End Class.

return new MyPreview_Conj_Lite();