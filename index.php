<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :
			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );
			endwhile; // End of the loop.

			the_posts_pagination( apply_filters( 'conj_post_pagination_args', array(
				/* translators: 1: Open span tag, 2: Close span tag. */
				'prev_text' => sprintf( esc_html_x( '%1$sPrevious page%2$s', 'posts pagination', 'conj-lite' ), '<span class="screen-reader-text">', '</span>' ),
				/* translators: 1: Open span tag, 2: Close span tag. */
				'next_text' => sprintf( esc_html_x( '%1$sNext page%2$s', 'posts pagination', 'conj-lite' ), '<span class="screen-reader-text">', '</span>' ),
				/* translators: 1: Open span tag, 2: Close span tag. */
				'before_page_number' => sprintf( esc_html_x( '%1$sPage%2$s', 'posts pagination label', 'conj-lite' ), '<span class="meta-nav screen-reader-text">', ' </span>' )
			) ) );
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();