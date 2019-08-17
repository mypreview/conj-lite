<?php
/**
 * Template part for displaying results in search pages
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-wrapper">
		<div class="entry-meta">
			<?php 
			$get_post_id = (int) get_the_ID();
			$get_post_type = (string) get_post_type( $get_post_id );
			$get_post_type_class_name =	(string) strtolower( $get_post_type );
			$get_post_type_class_name =	(string) str_replace( ' ', '-', $get_post_type_class_name );

			printf( '<span class="conj-lite-search-post__type-%1$s">%2$s</span>', esc_attr( $get_post_type_class_name ), esc_html( $get_post_type ) );

			// Display, if post has a featured image attached!
			if ( conj_lite_is_woocommerce_activated() && 'product' === $get_post_type ) {
				conj_lite_post_thumbnail();
			} // End If Statement
			?>
		</div><!-- .entry-meta -->

		<div class="entry-content" itemprop="mainContentOfPage">
			<?php 
			conj_lite_post_title(); 
			
			if ( conj_lite_is_woocommerce_activated() && 'product' === $get_post_type ) {
				woocommerce_template_single_price();
				conj_lite_wc_show_product_categories();
			} else {
				the_excerpt();
			} // End If Statement
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->