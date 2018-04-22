<?php
/**
 * The template for displaying posts in the `Quote` post format.
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link 		http://justintadlock.com/archives/2012/08/27/post-formats-quote
 *
 * @package 	mypreview-conj
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">

	<?php if ( 'post' === get_post_type() ) : ?>
	<div class="entry-meta">
		<div class="post-meta">
			<?php 
			mypreview_conj_lite_posted_on();
			mypreview_conj_lite_entry_footer( $posted_categories = TRUE, $posted_tags = FALSE ); 
			mypreview_conj_lite_comments_link();
			?>
		</div><!-- .post-meta -->
	</div><!-- .entry-meta -->
	<?php endif; ?>

	<div class="entry-wrapper">

		<?php
		 // Check if post has a featured image attached!
		if ( '' !== get_the_post_thumbnail() ) {
			mypreview_conj_lite_post_thumbnail();
		} // End If Statement 
		?>

		<div class="entry-content" itemprop="mainContentOfPage">
			<?php

				if ( ! is_singular( 'post' ) ) {

					$get_content 	= 	trim( get_the_content() );
					preg_match( '/<blockquote.*?>/', $get_content, $quote_matches );

					if ( empty( $quote_matches ) ) :
						?> <blockquote><?php the_content( '' ); ?></blockquote> <?php
					else : 
						the_content( '' );
					endif;

				} // End If Statement

				if ( is_singular( 'post' ) ) {

					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'conj-lite' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );

				} // End If Statement

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'conj-lite' ),
					'after'  => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>'
				) );
			?>
		</div><!-- .entry-content -->

		<?php if ( is_singular( 'post' ) ) : ?>
			<footer class="entry-footer">
				<?php mypreview_conj_lite_entry_footer( $posted_categories = FALSE, $posted_tags = TRUE ); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>

	</div><!-- .entry-wrapper -->

</article><!-- #post-<?php the_ID(); ?> -->