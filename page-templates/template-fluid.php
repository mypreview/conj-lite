<?php
/**
 * The template for displaying all pages/posts with fluid width.
 *
 * Template Name: 		Fluid Template
 * Template Post Type:	post, page, product
 *
 * @link 		https://developer.wordpress.org/themes/template-files-section/page-template-files/
 * @link 		https://developer.wordpress.org/reference/functions/the_posts_pagination/
 * @link 		https://developer.wordpress.org/reference/functions/the_post_navigation/
 * @link 		https://docs.woocommerce.com/wc-apidocs/function-woocommerce_content.html
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			if ( conj_lite_is_woocommerce_activated() && is_singular( 'product' ) ) :
				woocommerce_content();
			else :
				while ( have_posts() ) : the_post();
					if ( is_singular( 'post' ) ) {

						get_template_part( 'template-parts/content', get_post_type() );

						the_post_navigation( apply_filters( 'conj_lite_post_navigation_args', array(
							/* translators: 1: Open span tag, 2: Close span tag. */
							'prev_text' => sprintf( esc_html_x( '%1$sPrevious%2$s', 'post navigation', 'conj-lite' ), '<span>', '</span>' ),
							/* translators: 1: Open span tag, 2: Close span tag. */
							'next_text' => sprintf( esc_html_x( '%1$sNext%2$s', 'post navigation', 'conj-lite' ), '<span>', '</span>' )
						) ) );

					} else {
						get_template_part( 'template-parts/content', 'page' );
					} // End If Statement

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					} // End If Statement

				endwhile; // End of the loop.
			endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();