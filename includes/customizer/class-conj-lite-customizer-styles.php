<?php
/**
 * Customizer settings CSS styles.
 *
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview, @gookalani)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Conj_Lite_Customizer_Styles' ) ) :

	/**
	 * The Conj Lite Customizer settings class
	 */
	class Conj_Lite_Customizer_Styles {

		/**
         * Add extra CSS styles to a registered stylesheet.
         *
         * @see 	https://developer.wordpress.org/reference/functions/get_theme_mod/
		 * @see 	https://developer.wordpress.org/reference/functions/esc_attr/
		 * @see 	https://developer.wordpress.org/reference/functions/sanitize_hex_color/
		 * @see 	https://developer.wordpress.org/reference/functions/get_header_textcolor/
		 * @see 	https://developer.wordpress.org/reference/functions/get_header_textcolor/
         * @access  public
         * @return 	string
         */
        public static function css() {

        	// General
			$general_site_title_color = get_header_textcolor();
			$general_background_color = sanitize_hex_color_no_hash( get_background_color() );
			// Header
			$header_background_attachment_url = ( get_header_image() ) 	?  esc_url( get_header_image() ) : NULL;

	        // Global inline styles
        	$customizer_css = "
        		.site-branding .site-description,
				.site-branding .site-title a {
        			color: #{$general_site_title_color};
        		}
        		/* General */
				.conj-lite-blog__archive.has-sidebar.post-template-template-fluid article.post.hentry .alignfull,
				.conj-lite-blog__archive:not(.has-sidebar) article.post.hentry .alignfull,
				body {
					background-color: #{$general_background_color};
				}
				/* Header */
				body.has-header-image #masthead {
    				background-image: url({$header_background_attachment_url});
    			}
        	";

        	$customizer_css = apply_filters( 'conj_lite_customizer_inline_css', $customizer_css );

        	return wp_strip_all_tags( $customizer_css );

        }

	}
endif;
// End Class.