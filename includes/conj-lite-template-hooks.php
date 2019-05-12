<?php
/**
 * Conj Lite hooks
 *
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

/**
 * Before site
 *
 * @see  	conj_lite_handheld_navigation()
 */
add_action( 'conj_lite_before_site', 		'conj_lite_handheld_navigation',     		  10 );

/**
 * Header
 *
 * @see  	conj_lite_skip_links()
 * @see  	conj_lite_site_branding()
 * @see  	conj_lite_primary_navigation()
 */
add_action( 'conj_lite_header', 			'conj_lite_skip_links',                         0 );
add_action( 'conj_lite_header', 			'conj_lite_site_branding',                     10 );
add_action( 'conj_lite_header', 			'conj_lite_primary_navigation',                40 );

/**
 * Footer
 *
 * @see  	conj_lite_footer_widgets()
 * @see  	conj_lite_credit()
 */
add_action( 'conj_lite_footer', 			 'conj_lite_footer_widgets',			  	   10 );
add_action( 'conj_footer', 			 		 'conj_lite_credit',					  	   20 );