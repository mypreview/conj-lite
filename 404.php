<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link 		https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package 	mypreview-conj
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'conj-lite' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'conj-lite' ); ?></p>
					<div aria-label="<?php esc_html_e( 'Search', 'conj-lite' ); ?>">
						<?php
						if ( class_exists( 'WooCommerce' ) ) {

			                the_widget( 'WC_Widget_Product_Search', 'title=' );

						} else {
							get_search_form();
						} // End If Statement
						?>
					</div>

					<section class="error-404-first">
						
						<?php

						if ( class_exists( 'WooCommerce' ) ) {

							/* translators: 1: Div tag open 2: Aria-label quotation close. */
							printf( esc_html__( '%1$sPromoted Products%2$s', 'conj-lite' ), '<div class="promoted-products" aria-label="', '">' );

							mypreview_conj_lite_wc_promoted_products();

							printf( '</div><!-- .promoted-products -->' );

							/* translators: 1: Nav tag open 2: Aria-label quotation close. */
							printf( esc_html__( '%1$sProduct Categories%2$s', 'conj-lite' ), '<nav class="product-categories" aria-label="', '">' );

							the_widget( 'WC_Widget_Product_Categories', array(
								'count' => 1,
							) );

							printf( '</nav><!-- .product-categories -->' );
						
						} else {

							/* translators: 1: Div tag open 2: Aria-label quotation close. */
							printf( esc_html__( '%1$sRecent Posts%2$s', 'conj-lite' ), '<div class="recent-posts" aria-label="', '">' );

							the_widget( 'WP_Widget_Recent_Posts' );

							printf( '</div><!-- .recent-posts -->' );

							/* translators: 1: Div tag open 2: Aria-label quotation close. */
							printf( esc_html__( '%1$sCategories%2$s', 'conj-lite' ), '<div class="widget widget_categories" aria-label="', '">' );

							/* translators: 1: Head tag open 2: Head tag close. */
							printf( esc_html__( '%1$sMost Used Categories%2$s', 'conj-lite' ), '<h2 class="widget-title">', '</h2><ul>' );

							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );

							printf( '</ul></div><!-- .widget_categories -->' );

						} // End If Statement

						?>

					</section><!-- .error-404-first -->

					<section class="error-404-last">

					<?php

						if ( class_exists( 'WooCommerce' ) ) {

							/* translators: 1: Div tag open 2: Aria-label quotation close. */
							printf( esc_html__( '%1$sBest-Selling Products%2$s', 'conj-lite' ), '<div class="best-selling-products" aria-label="', '">' );
							/* translators: 1: Head tag open 2: Head tag close. */
							printf( esc_html__( '%1$sBest-Selling Products%2$s', 'conj-lite' ), '<h2>', '</h2>' );

							echo wp_kses_post( mypreview_conj_lite_do_shortcode( 'best_selling_products', array(
								'per_page' => 4,
								'columns'  => 4,
							) ) );

							printf( '</div><!-- .best-selling-products -->' );

						} else {

							/* translators: %1$s: smiley */
							$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'conj-lite' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

							the_widget( 'WP_Widget_Tag_Cloud' );

						} // End If Statement
					?>

					</section><!-- .error-404-last -->

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();