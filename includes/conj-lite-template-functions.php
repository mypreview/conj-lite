<?php
/**
 * Conj Lite template functions.
 *
 * @since 	    1.1.0
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

		?>
		<div id="left" class="handheld-offcanvas c-offcanvas is-hidden" role="complementary">
			<button class="close-btn">
				<i class="feather-x"></i>
			</button>
			<div id="handheld-slinky-menu">
				<?php
				    wp_nav_menu(
					    array(
						    'theme_location' => 'handheld',
							'container_class' => 'handheld-navigation'
					    )
				    );
			    ?>	
			</div><!-- #handheld-slinky-menu -->
			<div class="offcanvas-nav d-block d-md-none" data-set="bs"></div>
		</div><!-- .handheld-offcanvas -->
		<?php	

	}
endif;

/**
 * Skip links.
 * 
 * @return  void
 */
if ( ! function_exists( 'conj_lite_skip_links' ) ) :
	function conj_lite_skip_links() {

		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'conj-lite' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'conj-lite' ); ?></a>
		<?php	

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

		?>
		<div class="site-branding">
			<?php conj_lite_site_title_or_logo(); ?>
		</div><!-- .site-branding -->
		<?php

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

		?>
		<div class="primary-navigation">
			<nav id="site-navigation" class="main-navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
				<button class="handheld-menu-toggle js-offcanvas-toggler js-handheld-offcanvas-toggler">
					<?php esc_html_e( 'Menu', 'conj-lite' ); ?>
					<span class="hamburger-nav-icon">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</span>
				</button><!-- .handheld-menu-toggle -->
				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'primary-navigation'
						)
					);
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .primary-navigation -->
		<?php

	}
endif;

/**
 * Display the footer widget regions.
 *
 * @uses	dynamic_sidebar()
 * @uses	is_active_sidebar()
 * @return  void
 */
if ( ! function_exists( 'conj_lite_footer_widgets' ) ) :
	function conj_lite_footer_widgets() {

		$rows = intval( apply_filters( 'conj_lite_footer_widget_rows', 2 ) );
		$regions = intval( apply_filters( 'conj_lite_footer_widget_columns', 4 ) );

		for ( $row = 1; $row <= $rows; $row++ ) :
			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region-- ) {
				if ( is_active_sidebar( 'footer-' . strval( $region + $regions * ( $row - 1 ) ) ) ) {
					$columns = $region;
					break;
				} // End If Statement
			}

			if ( isset( $columns ) ) : ?>
				<div class=<?php echo '"footer-widgets row-' . strval( $row ) . ' col-' . strval( $columns ) . ' fix"'; ?>><?php
					for ( $column = 1; $column <= $columns; $column++ ) :
						$footer_n = $column + $regions * ( $row - 1 );

						if ( is_active_sidebar( 'footer-' . strval( $footer_n ) ) ) : ?>

							<div class="block footer-widget-<?php echo strval( $column ); ?>">
								<?php dynamic_sidebar( 'footer-' . strval( $footer_n ) ); ?>
							</div><?php

						endif;
					endfor; ?>
				</div><!-- .footer-widgets.row-<?php echo strval( $row ); ?> --><?php
				unset( $columns );
			endif;
		endfor;		

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

		?><div class="site-info"><?php 

		if ( apply_filters( 'conj_lite_credit_wp_link', TRUE ) ) {
			/* translators: 1: WordPress.org URL. */
			printf( esc_html__( '%1$sProudly powered by %2$s ', 'conj-lite' ), '<span class="site-wp-credits">', '<a href="https://wordpress.org" target="_blank" rel="noopener noreferrer nofollow">WordPress</a></span>' );
		} // End If Statement

		printf( wp_kses_post( '%1$s%2$s%3$s' ), '<span class="site-copyright">', apply_filters( 'conj_lite_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date_i18n( __( 'Y', 'conj-lite' ) ) ), '</span>' );
		 
		if ( apply_filters( 'conj_lite_credit_author_link', TRUE ) ) {
			/* translators: 1: Seperator, 2: Theme name, 3: Theme author. */
			printf( esc_html__( '%1$s Theme: %2$s by %3$s', 'conj-lite' ), '<span class="site-author-credits"><span class="sep"> | </span>', esc_html( CONJ_LITE_THEME_NAME ), '<a href="' . esc_url( CONJ_LITE_THEME_URI ) . '" target="_blank" rel="noopener noreferrer nofollow">' . esc_html( CONJ_LITE_THEME_AUTHOR ) . '</a>.</span>' );
		} // End If Statement ?>

		</div><!-- .site-info --><?php		

	}
endif;