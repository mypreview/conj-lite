<?php
/**
 * The template for displaying posts in the `Status` post format
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
	<div class="entry-wrapper">
		<div class="entry-meta">
			<?php conj_lite_entry_footer( TRUE, FALSE );  ?>

			<div class="post-meta">
				<?php conj_lite_posted_on(); conj_lite_comments_link(); ?>
			</div><!-- .post-meta -->
		</div><!-- .entry-meta -->

		<?php
		 // Display, if post has a featured image attached!
		conj_lite_post_thumbnail(); ?>

		<div class="entry-content" itemprop="mainContentOfPage"><?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Read more<span class="screen-reader-text"> "%s"</span>', 'conj-lite' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( apply_filters( 'conj_lite_wp_link_pages_args', array(
				/* translators: %s: Open div tag. */
				'before' => sprintf( esc_html_x( '%sPages:', 'page links', 'conj-lite' ), '<div class="page-links">' ),
				'after' => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after' => '</span>'
			) ) );
		?></div><!-- .entry-content -->

		<?php if ( is_singular( 'post' ) ) : ?>
			<footer class="entry-footer">
				<?php conj_lite_entry_footer( FALSE, TRUE ); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>

	</div><!-- .entry-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->