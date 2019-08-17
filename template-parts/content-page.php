<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	// Display, if page title is set to be displayed!
	conj_lite_post_title();
	// Display, if page has a featured image attached!
	conj_lite_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( apply_filters( 'conj_lite_wp_link_pages_args', array(
			/* translators: %s: Open div tag. */
			'before' => sprintf( esc_html_x( '%sPages:', 'page links', 'conj-lite' ), '<div class="page-links">' ),
			'after' => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after' => '</span>'
		) ) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->