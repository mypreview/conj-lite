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
 *
 * @package 	mypreview-conj
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php

			if ( class_exists( 'WooCommerce' ) && is_singular( 'product' ) ) {

				woocommerce_content();

			} else {

				while ( have_posts() ) : the_post();

					if ( is_singular( 'post' ) ) {

						get_template_part( 'template-parts/content', get_post_type() );

						the_posts_pagination( apply_filters( 'mypreview_conj_lite_post_pagination_args', array(
							'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'conj-lite' ) . '</span>',
							'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'conj-lite' ) . '</span>',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'conj-lite' ) . ' </span>',
						) ) );

						the_post_navigation( apply_filters( 'mypreview_conj_lite_post_navigation_args', array(
							'prev_text' => '<span>' . __( 'Previous', 'conj-lite' ) . '</span>',
							'next_text' => '<span>' . __( 'Next', 'conj-lite' ) . '</span>'
						) ) );

					} else {

						get_template_part( 'template-parts/content', 'page' );

					} // End If Statement

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					} // End If Statement

				endwhile; // End of the loop.

			} // End If Statement

			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();