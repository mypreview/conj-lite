<?php
/**
 * Conj Lite hooks
 *
 * @package conjws
 */

/**
 * Before site
 *
 * @see  conjws_lite_handheld_navigation()
 */
add_action( 'conjws_lite_before_site', 	'conjws_lite_handheld_navigation',     				10 );

/**
 * Header
 *
 * @see  conjws_lite_skip_links()
 * @see  conjws_lite_site_branding()
 * @see  conjws_lite_primary_navigation()
 * @see  conjws_lite_header_image()
 */
add_action( 'conjws_lite_header', 			'conjws_lite_skip_links',                         0 );
add_action( 'conjws_lite_header', 			'conjws_lite_site_branding',                     30 );
add_action( 'conjws_lite_header', 			'conjws_lite_primary_navigation',                60 );
add_action( 'conjws_lite_header', 			'conjws_lite_header_image', 					 99 );

/**
 * Site container
 *
 * @see  conjws_lite_site_container_wrapper()
 * @see  conjws_lite_site_container_wrapper_close()
 */
add_action( 'conjws_lite_site_content_top', 	 'conjws_lite_site_container_wrapper', 		  5 );
add_action( 'conjws_lite_site_content_bottom',	 'conjws_lite_site_container_wrapper_close',  5 );

/**
 * Footer
 *
 * @see  conjws_lite_footer_widgets()
 * @see  conjws_lite_credit()
 */
add_action( 'conjws_lite_footer', 			 'conjws_lite_footer_widgets',			  		  10 );
add_action( 'conjws_lite_footer', 			 'conjws_lite_credit',					  		  20 );