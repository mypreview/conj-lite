<?php
/**
 * The template for displaying all single posts
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @link 		https://developer.wordpress.org/reference/functions/the_posts_pagination/
 * @link 		https://developer.wordpress.org/reference/functions/the_post_navigation/
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			do_action( 'conj_lite_before_post_content' );

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation( apply_filters( 'conj_lite_post_navigation_args', array(
				/* translators: 1: Open span tag, 2: Close span tag. */
				'prev_text' => sprintf( esc_html_x( '%1$sPrevious%2$s', 'post navigation', 'conj-lite' ), '<span>', '</span>' ),
				/* translators: 1: Open span tag, 2: Close span tag. */
				'next_text' => sprintf( esc_html_x( '%1$sNext%2$s', 'post navigation', 'conj-lite' ), '<span>', '</span>' )
			) ) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			} // End If Statement

			do_action( 'conj_lite_after_post_content' );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();