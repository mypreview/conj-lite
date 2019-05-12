<?php
/**
 * The template for displaying posts in the `Link` post format
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
	<div class="entry-wrapper">
		<div class="entry-meta">
			<?php conj_lite_entry_footer( $posted_categories = TRUE, $posted_tags = FALSE );  ?>

			<header class="entry-header">
				<?php
				$content = get_the_content();
				$has_url = get_url_in_content( $content );
				$has_url = ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );

				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( $has_url ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</header><!-- .entry-header -->

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