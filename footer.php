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
			 * @hooked mypreview_conj_lite_credit        			 - 20
			 */
			do_action( 'mypreview_conj_lite_footer' ); ?>

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