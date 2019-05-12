<?php
/**
 * The template for displaying posts in the `Gallery` post format.
 * Inspired by Twenty Seventeen `content-gallery.php`
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link 		https://developer.wordpress.org/reference/functions/get_post_gallery/
 * @link 		https://github.com/WordPress/twentyseventeen/blob/master/components/post/content-gallery.php
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
	<div class="entry-wrapper">
		<div class="entry-meta">
			<?php 
			conj_lite_entry_footer( $posted_categories = TRUE, $posted_tags = FALSE );  ?>
			conj_lite_post_title(); ?>
			<div class="post-meta">
				<?php conj_lite_posted_on(); conj_lite_comments_link(); ?>
			</div><!-- .post-meta -->
		</div><!-- .entry-meta -->

		<?php
		// If not a single post, highlight the gallery.
		if ( ! is_singular( 'post' ) && get_post_gallery() ) :
			?>
			<div class="entry-gallery">
				<?php echo get_post_gallery(); ?>
			</div>
			<?php
		endif; // End If ! is_singular( 'post' ) && get_post_gallery()

		if ( has_post_thumbnail() && empty( $image ) ) {
			conj_lite_post_thumbnail();
		} // End If Statement ?>

		<div class="entry-content" itemprop="mainContentOfPage"><?php
			if ( is_singular( 'post' ) || ! get_post_gallery() ) {
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
			} // End If Statement

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'conj-lite' ),
				'after' => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after' => '</span>'
			) );
		?></div><!-- .entry-content -->

		<?php if ( is_singular( 'post' ) ) : ?>
			<footer class="entry-footer">
				<?php conj_lite_entry_footer( $posted_categories = FALSE, $posted_tags = TRUE ); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>

	</div><!-- .entry-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->