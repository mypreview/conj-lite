<?php
/**
 * Conj Lite hooks
 *
 * @author  	Mahdi Yazdani
 * @package 	conj-lite
 * @since 	    1.1.0
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
 * @see  	conj_lite_header_image()
 */
add_action( 'conj_lite_header', 			'conj_lite_skip_links',                         0 );
add_action( 'conj_lite_header', 			'conj_lite_site_branding',                     30 );
add_action( 'conj_lite_header', 			'conj_lite_primary_navigation',                60 );
add_action( 'conj_lite_header', 			'conj_lite_header_image', 					   99 );

/**
 * Site container
 *
 * @see  	conj_lite_site_container_wrapper()
 * @see  	conj_lite_site_container_wrapper_close()
 */
add_action( 'conj_lite_site_content_top', 	 'conj_lite_site_container_wrapper', 		    5 );
add_action( 'conj_lite_site_content_bottom', 'conj_lite_site_container_wrapper_close',  	5 );

/**
 * Footer
 *
 * @see  	conj_lite_footer_widgets()
 * @see  	conj_lite_credit()
 */
add_action( 'conj_lite_footer', 			 'conj_lite_footer_widgets',			  	   10 );
add_action( 'conj_footer', 			 		 'conj_lite_credit',					  	   20 );