<?php
/**
 * Conj Lite template functions.
 *
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

/**
 * Accesible offcanvas panel.
 *
 * @uses 	wp_nav_menu()
 * @return  void
 */
if ( ! function_exists( 'conj_lite_handheld_navigation' ) ) :
	function conj_lite_handheld_navigation() {

		?><div id="handheld-offcanvas" class="handheld-offcanvas c-offcanvas is-hidden" role="complementary"><button class="close-btn"><i class="feather-x"></i></button><div id="handheld-slinky-menu"><?php
			wp_nav_menu(
			    apply_filters( 'conj_lite_handheld_nav_menu_args', array(
				    'theme_location' => 'handheld',
					'container_class' => 'handheld-navigation'
			    ) )
		    );
		?></div></div><div class="offcanvas-nav d-block d-md-none" data-set="bs"></div></div><?php

	}
endif;

/**
 * Skip links.
 * 
 * @return  void
 */
if ( ! function_exists( 'conj_lite_skip_links' ) ) :
	function conj_lite_skip_links() {

		/* translators: 1: Open anchor tag, 2: Close anchor tag. */
		printf( esc_html_x( '%1$sSkip to navigation%2$s', 'screen reader text', 'conj-lite' ), '<a class="skip-link screen-reader-text" href="#site-navigation">', '</a>' );
		/* translators: 1: Open anchor tag, 2: Close anchor tag. */
		printf( esc_html_x( '%1$sSkip to content%2$s', 'screen reader text', 'conj-lite' ), '<a class="skip-link screen-reader-text" href="#content">', '</a>' );	

	}
endif;

/**
 * Site branding wrapper and display.
 *
 * @uses 	conj_lite_site_title_or_logo()
 * @return  void
 */
if ( ! function_exists( 'conj_lite_site_branding' ) ) :
	function conj_lite_site_branding() {

		?><div class="site-branding">
			<?php conj_lite_site_title_or_logo(); ?>
		</div><!-- .site-branding --><?php

	}
endif;

/**
 * The primary navigation wrapper.
 *
 * @uses 	wp_nav_menu()
 * @return  void
 */
if ( ! function_exists( 'conj_lite_primary_navigation' ) ) :
	function conj_lite_primary_navigation() {

		?><div class="primary-navigation">
			<nav id="site-navigation" class="main-navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement"><?php
				/* translators: 1: Open `push-menu` button tag, 2: Close `push-menu` close tag(s). */
				printf( esc_html__( '%1$sMenu%2$s', 'conj-lite' ), '<button class="handheld-menu-toggle js-offcanvas-toggler js-handheld-offcanvas-toggler">', '<span class="hamburger-nav-icon"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></span></button>' );
				wp_nav_menu(
					apply_filters( 'conj_lite_primary_nav_menu_args', array(
						'theme_location' => 'primary',
						'container_class' => 'primary-navigation'
					) )
				);
		?></nav></div><?php

	}
endif;

/**
 * Site page container wrapper.
 *
 * @return  void
 */
if ( ! function_exists( 'conj_lite_site_container_wrapper' ) ) :
	function conj_lite_site_container_wrapper() {

		?><div class="col-full"><?php

	}
endif;

/**
 * Site page container wrapper close.
 *
 * @return  void
 */
if ( ! function_exists( 'conj_lite_site_container_wrapper_close' ) ) :
	function conj_lite_site_container_wrapper_close() {

		?></div><?php

	}
endif;

/**
 * Display the footer widget regions.
 *
 * @uses	conj_lite_get_dynamic_sidebar()
 * @uses	is_active_sidebar()
 * @return  void
 */
if ( ! function_exists( 'conj_lite_footer_widgets' ) ) :
	function conj_lite_footer_widgets() {

		$rows = intval( apply_filters( 'conj_lite_footer_widget_rows', 1 ) );
		$regions = intval( apply_filters( 'conj_lite_footer_widget_columns', 4 ) );

		for ( $row = 1; $row <= $rows; $row++ ) :
			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region-- ) {
				if ( is_active_sidebar( 'footer-' . strval( $region + $regions * ( $row - 1 ) ) ) ) {
					$columns = $region;
					break;
				} // End If Statement
			} // End For Loop

			if ( isset( $columns ) ) :
				printf( '<div class="footer-widgets row-%d col-%d fix">', strval( $row ), strval( $columns ) );
					for ( $column = 1; $column <= $columns; $column++ ) :
						$footer_n = $column + $regions * ( $row - 1 );

						// Determines whether a sidebar is in use.
						if ( is_active_sidebar( 'footer-' . strval( $footer_n ) ) ) :
							printf( '<div class="block footer-widget-%1$s">%2$s</div>', strval( $column ), conj_lite_get_dynamic_sidebar( 'footer-' . strval( $footer_n ) ) ); // WPCS: XSS okay.
						endif;
					endfor;
				?></div><!-- .footer-widgets --><?php
				unset( $columns );
			endif; // End If Statement
		endfor; // End For Loop		

	}
endif;

/**
 * Display the theme credit.
 *
 * @uses 	date_i18n()
 * @uses 	get_bloginfo()
 * @return  void
 */
if ( ! function_exists( 'conj_lite_credit' ) ) :
	function conj_lite_credit() {

		$copyright_text = sprintf( '&copy; %s&nbsp;%s', get_bloginfo( 'name' ), date_i18n( esc_html_x( 'Y', 'date in localized format', 'conj-lite' ) ) );

		?><div class="site-info"><?php 
			if ( apply_filters( 'conj_lite_credit_wp_link', TRUE ) ) {
				/* translators: 1: WordPress.org URL. */
				printf( esc_html__( '%1$sProudly powered by %2$s ', 'conj-lite' ), '<span class="site-info__wp-credits">', '<a href="https://wordpress.org" target="_blank" rel="noopener noreferrer nofollow">WordPress</a></span>' );
			} // End If Statement

			printf( wp_kses_post( '%1$s%2$s%3$s' ), '<span class="site-info__copyright">', apply_filters( 'conj_lite_copyright_text', wp_kses_post( $copyright_text ) ), '</span>' );
			/* translators: 1: Seperator, 2: Theme name, 3: Theme author. */
			printf( esc_html__( '%1$s Theme: %2$s by %3$s', 'conj-lite' ), '<span class="site-info__author-credits"><span class="sep"> | </span>', esc_html( CONJ_LITE_THEME_NAME ), sprintf( '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a></span>', esc_url( CONJ_LITE_THEME_AUTHOR_URI ), esc_html( CONJ_LITE_THEME_AUTHOR ) ) ); ?>
		</div><!-- .site-info --><?php	

	}
endif;