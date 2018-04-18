<?php
/**
 * Conj Lite template functions.
 *
 * @package 	mypreview-conj
 */

/**
 * Accesible offcanvas panel.
 * 
 * @return  void
 */
if ( ! function_exists( 'mypreview_conj_lite_handheld_navigation' ) ) :
	function mypreview_conj_lite_handheld_navigation() {

		?>
		<div id="left" class="handheld-offcanvas c-offcanvas is-hidden" role="complementary">
			<button class="close-btn">
				<i class="feather-x"></i>
			</button>
			<div id="handheld-slinky-menu">
				<?php
				    wp_nav_menu(
					    array(
						    'theme_location'	=> 	'handheld',
							'container_class'	=> 	'handheld-navigation'
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
if ( ! function_exists( 'mypreview_conj_lite_skip_links' ) ) :
	function mypreview_conj_lite_skip_links() {

		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'conj-lite' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'conj-lite' ); ?></a>
		<?php	

	}
endif;

/**
 * Site branding wrapper and display.
 * 
 * @return  void
 */
if ( ! function_exists( 'mypreview_conj_lite_site_branding' ) ) :
	function mypreview_conj_lite_site_branding() {

		?>
		<div class="site-branding">
			<?php mypreview_conj_lite_site_title_or_logo(); ?>
		</div>
		<?php

	}
endif;

/**
 * The primary navigation wrapper.
 * 
 * @return  void
 */
if ( ! function_exists( 'mypreview_conj_lite_primary_navigation' ) ) :
	function mypreview_conj_lite_primary_navigation() {

		?>
		<div class="primary-navigation">
			<nav id="site-navigation" class="main-navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
				<button class="handheld-menu-toggle js-offcanvas-toggler js-handheld-offcanvas-toggler" aria-controls="handheld-navigation" aria-expanded="FALSE">
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
							'theme_location'	=> 'primary',
							'container_class'	=> 'primary-navigation'
							)
					);
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .primary-navigation -->
		<?php

	}
endif;

/**
 * Display the image markup for a custom header image.
 *
 * @see 	https://developer.wordpress.org/reference/functions/the_header_image_tag/
 * @return  void
 */
if ( ! function_exists( 'mypreview_conj_lite_header_image' ) ) :
	function mypreview_conj_lite_header_image() {

		if ( get_header_image() ) {
			the_header_image_tag( array( 'class' => 'jarallax-img' ) );
		}

	}
endif;

/**
 * Site page container wrapper.
 *
 * @return  void
 */
if ( ! function_exists( 'mypreview_conj_lite_site_container_wrapper' ) ) :
	function mypreview_conj_lite_site_container_wrapper() {

		?><div class="conj-col__full">
		<?php

	}
endif;

/**
 * Site page container wrapper close.
 *
 * @return  void
 */
if ( ! function_exists( 'mypreview_conj_lite_site_container_wrapper_close' ) ) :
	function mypreview_conj_lite_site_container_wrapper_close() {

		?></div><!-- .conj-col__full -->
		<?php

	}
endif;

/**
 * Display the footer widget regions.
 * 
 * @return  void
 */
if ( ! function_exists( 'mypreview_conj_lite_footer_widgets' ) ) :
	function mypreview_conj_lite_footer_widgets() {

		$row 	 = 	1;
		$regions = 	intval( apply_filters( 'mypreview_conj_lite_footer_widget_columns', 4 ) );

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

	}
endif;