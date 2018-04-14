<?php
/**
 * The template for displaying all single posts
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @link 		https://developer.wordpress.org/reference/functions/the_posts_pagination/
 * @link 		https://developer.wordpress.org/reference/functions/the_post_navigation/
 * 
 * @package 	mypreview-conj
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			do_action( 'mypreview_conj_lite_post_before' );

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

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			} // End If Statement

			do_action( 'mypreview_conj_lite_post_after' );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();