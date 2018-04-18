<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package 	mypreview-conj
 */
	
	/**
	 * Functions hooked in to mypreview_conj_lite_before_footer action
	 *
	 * @hooked mypreview_conj_lite_site_container_wrapper_close		- 5
	 */
	do_action( 'mypreview_conj_lite_site_content_bottom' );
	?>

	</div><!-- #content -->

	<?php
	/**
	 * Functions hooked in to mypreview_conj_lite_before_footer action
	 *
	 * @hooked mypreview_conj_lite_footer_bar			 - 10
	 */
	do_action( 'mypreview_conj_lite_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to mypreview_conj_lite_footer action
			 *
			 * @hooked mypreview_conj_lite_footer_widgets			 - 10
			 */
			do_action( 'mypreview_conj_lite_footer' ); ?>

			<div class="site-info">

				<?php
				/* translators: 1: WordPress.org URL. */
				printf( esc_html__( '%1$sProudly powered by %2$s ', 'conj-lite' ), '<span class="site-wp-credits">', '<a href="https://wordpress.org" target="_blank">WordPress</a></span>' );

				printf( wp_kses_post( '%1$s%2$s%3$s' ), '<span>', apply_filters( 'mypreview_conj_lite_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date_i18n( __( 'Y', 'conj-lite' ) ) ), '</span>' );

				/* translators: 1: Seperator, 2: Theme name, 3: Theme author. */
				printf( esc_html__( '%1$s Theme: %2$s by %3$s', 'conj-lite' ), '<span><span class="sep"> | </span>', esc_html( MYPREVIEW_CONJ_LITE_THEME_NAME ), '<a href="' . esc_url( MYPREVIEW_CONJ_LITE_THEME_URI ) . '">' . esc_html( MYPREVIEW_CONJ_LITE_THEME_AUTHOR ) . '</a>.</span>' );

				?>

			</div><!-- .site-info -->
		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php
	/**
	 * Functions hooked in to mypreview_conj_lite_before_footer action
	 *
	 * @hooked mypreview_conj_lite_wc_add_to_cart_bar		- 999
	 */
	do_action( 'mypreview_conj_lite_after_footer' ); ?>
	
</div><!-- #page -->

<?php 
do_action( 'mypreview_conj_lite_after_site' );

wp_footer(); ?>

</body>
</html>