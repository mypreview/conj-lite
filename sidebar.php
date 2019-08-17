<?php
/**
 * The sidebar containing the main widget area
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! is_active_sidebar( 'sidebar-1' ) || apply_filters( 'conj_lite_disable_sidebar', FALSE ) ) {
	return;
} // End If Statement
?>
<aside id="secondary" class="widget-area" role="complementary" itemscope="itemscope" itemtype="https://schema.org/WPSideBar">
	<div class="widget-area__wrapper">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</aside><!-- #secondary -->