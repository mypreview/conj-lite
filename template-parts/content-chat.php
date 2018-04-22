<?php
/**
 * The template for displaying posts in the `Chat` post format
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
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

		<header class="entry-header">
			<?php
			if ( is_singular() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			} // End If Statement
			?>
		</header><!-- .entry-header -->

		<div class="entry-content" itemprop="mainContentOfPage">
			<?php
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