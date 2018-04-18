<?php
/**
 * Conj Lite hooks
 *
 * @package 	mypreview-conj
 */

/**
 * Before site
 *
 * @see  mypreview_conj_lite_handheld_navigation()
 */
add_action( 'mypreview_conj_lite_before_site', 	'mypreview_conj_lite_handheld_navigation',     				10 );

/**
 * Header
 *
 * @see  mypreview_conj_lite_skip_links()
 * @see  mypreview_conj_lite_site_branding()
 * @see  mypreview_conj_lite_primary_navigation()
 * @see  mypreview_conj_lite_header_image()
 */
add_action( 'mypreview_conj_lite_header', 			'mypreview_conj_lite_skip_links',                         0 );
add_action( 'mypreview_conj_lite_header', 			'mypreview_conj_lite_site_branding',                     30 );
add_action( 'mypreview_conj_lite_header', 			'mypreview_conj_lite_primary_navigation',                60 );
add_action( 'mypreview_conj_lite_header', 			'mypreview_conj_lite_header_image', 					 99 );

/**
 * Site container
 *
 * @see  mypreview_conj_lite_site_container_wrapper()
 * @see  mypreview_conj_lite_site_container_wrapper_close()
 */
add_action( 'mypreview_conj_lite_site_content_top', 	 'mypreview_conj_lite_site_container_wrapper', 		  5 );
add_action( 'mypreview_conj_lite_site_content_bottom',	 'mypreview_conj_lite_site_container_wrapper_close',  5 );

/**
 * Footer
 *
 * @see  mypreview_conj_lite_footer_widgets()
 */
add_action( 'mypreview_conj_lite_footer', 			 'mypreview_conj_lite_footer_widgets',			  		  10 );