<?php
/**
 * Customizer settings CSS styles.
 *
 * @since 	    1.2.0
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
	final class Conj_Lite_Customizer_Styles {

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
			$general_background_color_dark = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_background_color, -20 ) );
			$general_background_color_darker = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_background_color, -5 ) );
			$general_heading_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_heading_color', '#464855' ) );
			$general_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_text_color', '#6B6F81' ) );
			$general_text_color_light = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_text_color, 30 ) );
			$general_text_color_lighter = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_text_color, 50 ) );
			$general_link_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_link_color', '#666EE8' ) );
			$general_link_color_lighter = sanitize_hex_color( conj_lite_adjust_color_brightness( $general_link_color, 80 ) );
			$general_link_alt_color = sanitize_hex_color( get_theme_mod( 'conj_lite_general_link_alt_color', '#414B92' ) );
			// Button
			$button_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_button_text_color', '#FFFFFF' ) );
			$button_alt_text_color = sanitize_hex_color( get_theme_mod( 'conj_lite_button_alt_text_color', '#666EE8' ) );
			$button_background_color = sanitize_hex_color( get_theme_mod( 'conj_lite_button_background_color', '#666EE8' ) );
			$button_background_color_lighter = sanitize_hex_color( conj_lite_adjust_color_brightness( $button_background_color, 50 ) );
			// Header
			$header_background_attachment_url = ( get_header_image() ) 	?  esc_url( get_header_image() ) : NULL;

	        // Global inline styles
        	$customizer_css = "
        		.site-description,
				.site-title a {
        			color: #{$general_site_title_color};
        		}
        		/* General */
        		.c-offcanvas-content-wrap,
				.blog-archive:not(.has-sidebar) article.post .alignfull,
				.single-post:not(.has-sidebar) article.post .alignfull,
				.wp-block-pullquote:not(.is-style-solid-color) blockquote:after,
                .wp-block-pullquote:not(.is-style-solid-color) blockquote:before {
					background-color: #{$general_background_color};
				}
				[class*='search-type-'],
				article.post .cat-links > .post-categories a,
				article.post:not([class*='category']) .cat-tags-links .cat-links,
				.wp-block-tag-cloud a,
				.widget_tag_cloud a {
					color: {$general_text_color_light};
					background-color: #{$general_background_color};
				}
				.primary-navigation div.menu > ul ul.children:before,
				.primary-navigation div.menu > ul ul.children,
				.site-header ul.sub-menu > li > ul.sub-menu:before,
				.site-header ul.menu > li.menu-item-has-children > ul.sub-menu:before,
				.site-header ul.sub-menu {
					border-color: #{$general_background_color};
				}
				.site-header {
					border-color: {$general_background_color_darker};
				}
				pre:not(.wp-block-verse):not(.wp-block-code) {
					background-color: {$general_background_color_dark};
				}
				audio::-webkit-media-controls-panel {
					background-color: {$general_background_color_dark};
				}
				.widget-area__wrapper .widget_calendar caption,
				.wp-block-calendar caption,
				.search-results article .entry-footer a,
				.search-results article .entry-title a,
				.search-results:not(.post-type-archive) .site-main article .entry-header a,
				body:not(.single-post) article.post.hentry .entry-header a,
				.comment-meta .comment-author .fn,
				.comment-respond #reply-title,
				article.post .entry-title a,
				.widget-area__wrapper .widget-title,
				dd,
				h1,
				h2,
				h3,
				h4,
				h5,
				h6 {
					color: {$general_heading_color};
				}
				.widget-area__wrapper .widget_archive a,
				.widget-area__wrapper .widget_meta a,
				.widget-area__wrapper .menu-item > a,
				.widget-area__wrapper .page_item a,
				.primary-navigation div.menu > ul ul.children > li > a,
				.site-header ul.sub-menu > li > a,
				.primary-navigation div.menu > ul > li > a,
				.primary-navigation > ul.menu > .menu-item > a,
				blockquote,
				.wp-block-quote,
                .wp-block-quote cite,
                .wp-block-pullquote,
				.wp-block-calendar tbody,
				.type-attachment .post-meta a,
				.type-attachment .post-meta .byline a,
				article.post .post-meta a,
				.error-404-first .widget_recent_entries a,
				.wp-block-latest-posts a,
				.widget-area__wrapper .widget_recent_entries a,
				.widget_categories a,
				.wp-block-categories a,
				.ui-datepicker-calendar th,
				article.post .entry-footer .tags-links > a,
				article.type-post .post-meta .byline a,
				.wp-block-archives a,
				body {
					color: {$general_text_color};
				}
				.primary-navigation ul.menu > li.menu-item-has-children > a:after,
				.page-links a>.page-number,
				.post-navigation .nav-links a,
				.pagination .page-numbers,
				label,
				dt {
					color: {$general_text_color_light};
				}
				.comment.byuser img.avatar,
				.comment-metadata a time,
				.comment-meta .comment-author .says,
				.wp-block-calendar tfoot a,
				.calendar_wrap tfoot td a,
				.wp-block-calendar thead th,
				.calendar_wrap thead tr th,
				.type-attachment .post-meta .byline,
				article.type-post .post-meta .byline {
					color: {$general_text_color_lighter};
				}
				.widget_calendar tfoot td a:hover,
				.widget-area__wrapper .widget_nav_menu [class*='current'] > a,
                .widget-area__wrapper .menu-item:hover > a,
				#site-navigation > div.menu > ul ul.children > li[class*='current'] > a,
				#site-navigation > div.menu > ul ul.children > li:hover > a,
				#masthead ul.sub-menu [class*='current'] > a,
				#masthead ul.sub-menu > li:hover > a,
				body.single-post article.post.hentry .entry-footer .tags-links > a:hover,
				body:not(.single-post) article.post.hentry .entry-header a:hover,
				.entry-footer .edit-link .post-edit-link,
				.error-404-first .widget_recent_entries a:hover,
				.widget-area__wrapper .widget_recent_entries a:hover,
				.widget_categories a:hover,
                .widget-area__wrapper .widget_categories [class*='current'] > a,
				.widget-area__wrapper .widget_pages [class*='current'] > a,
                .widget-area__wrapper .page_item a:hover,
				.widget-area__wrapper .widget_meta a abbr,
                .widget-area__wrapper .widget_meta a:hover,
				.wp-block-categories a:hover,
				.widget_categories a:not(.has-text-color):hover,
				.wp-block-calendar tfoot a:hover,
				.calendar_wrap tfoot td a:hover,
				.widget-area__wrapper .widget_archive a:hover,
				.wp-block-archives a:hover,
				.wp-block-latest-posts a:hover,
				.pagination .page-numbers:not(.dots):hover,
				.pagination .page-numbers.current,
				.search-results article .entry-footer a:hover,
				.search-results article .entry-title a:hover,
				.search-results:not(.post-type-archive) .site-main article .entry-header a:hover,
				.type-attachment .post-meta .byline a:hover,
				.type-attachment .post-meta a:hover,
				.comment-metadata a:hover time,
				.comment-navigation a:hover,
				.post-navigation .nav-links a:hover,
				article.type-post .post-meta .byline a:hover,
				article.type-post .page-links > a:first-child .page-number,
				article.post .entry-title a:hover,
				article.post .post-meta a:hover,
				.page-links a > .page-number:hover,
				.page-links .page-number,
				.site-title a:hover,
				input[type='checkbox']:checked:before,
				a {
					color: {$general_link_color};
				}
				mark,
				input[type='radio']:checked:before {
					background-color: {$general_link_color};
				}
				article.type-post .page-links > a:first-child .page-number,
				article.post.format-chat .entry-content > *:nth-child(even),
				article.post.format-chat .entry-content > *:nth-child(even):before {
					border-color: {$general_link_color};
				}
				a:hover {
					color: {$general_link_alt_color};
				}
				/* Button */
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background) {
					background-color: {$button_background_color};
				}
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):hover {
					background-color: {$button_alt_text_color};
				}
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color) {
					color: {$button_background_color};
					border-color: {$button_background_color};
				}
				.wp-block-calendar tbody td > a,
				.widget_calendar tbody td > a {
					background-color: {$button_background_color_lighter};
					color: {$button_text_color};
				}
				#subscribe-submit [type='submit']:hover,
				.ui-datepicker-header .ui-datepicker-next, 
				.ui-datepicker-header .ui-datepicker-prev,
				.ui-datepicker-header .ui-datepicker-next:hover, 
				.ui-datepicker-header .ui-datepicker-prev:hover,
				.wp-block-button__link:not(.has-text-color),
				.wp-block-button__link:not(.has-text-color):hover,
				button[name='apply_coupon']:active,
				button[name='apply_coupon']:hover,
				button[name='apply_coupon']:focus,
				input[type='submit'][name='apply_coupon']:hover,
				input[type='submit'][name='apply_coupon']:focus {
					color: {$button_text_color};
				}
				.wp-block-file .wp-block-file__button,
				article.post .entry-content .more-link,
				.button,
				button,
				input[type='button'], 
				input[type='reset'],
				input[type='submit'] {
					background-color: {$button_background_color};
					border-color: {$button_background_color};
					color: {$button_text_color};
				}
				.ui-datepicker .ui-datepicker-calendar td a:hover,
				.ui-datepicker .ui-datepicker-calendar td a.ui-state-active,
				.ui-datepicker .ui-datepicker-title select,
				.ui-datepicker .ui-datepicker-header,
				.widget_tag_cloud a:hover,
				.wp-block-calendar #today,
				.wp-block-tag-cloud a:hover,
				.widget_calendar #today,
				article.post .entry-footer .tags-links > a:hover,
				article.post .cat-links > .post-categories a:hover {
					background-color: {$button_background_color};
					color: {$button_text_color};
				}
				.ui-datepicker .ui-datepicker-title select {
					background-image: -webkit-linear-gradient(45deg, transparent 50%, {$button_text_color} 50%), -webkit-linear-gradient(315deg, {$button_text_color} 50%, transparent 50%), -webkit-linear-gradient(left, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
					background-image: -o-linear-gradient(45deg, transparent 50%, {$button_text_color} 50%), -o-linear-gradient(315deg, {$button_text_color} 50%, transparent 50%), -o-linear-gradient(left, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
					background-image: linear-gradient(45deg, transparent 50%, {$button_text_color} 50%), linear-gradient(135deg, {$button_text_color} 50%, transparent 50%), linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
				} 
				.wp-block-file a.wp-block-file__button:hover {
					color: {$button_alt_text_color};
				}
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):hover,
				article.post .entry-content .more-link:hover,
				.button:focus, 
				.button.disabled,
				button.disabled,
				.button[disabled],
				button[disabled], 
				button:focus, 
				input[type='button']:focus, 
				input[type='reset']:focus,
				input[type='submit']:focus,
				.button:active, 
				button:active, 
				input[type='button']:active, 
				input[type='reset']:active, 
				input[type='submit']:active,
				.button:hover, 
				button:hover, 
				input[type='button']:hover, 
				input[type='reset']:hover, 
				input[type='submit']:hover {
					color: {$button_alt_text_color};
					border-color: {$button_alt_text_color};
				}
				.wp-block-file a.wp-block-file__button:hover{
					border-color: {$button_alt_text_color};
				}
				/* Header */
				body.has-header-image #masthead {
    				background-image: url({$header_background_attachment_url});
    			}
        	";

        	/**
        	 * If the WooCommerce plugin is already activated then
        	 * append the following CSS styles to the Customizer style tag.
        	 */
			if ( conj_lite_is_woocommerce_activated() ) :
				$customizer_css .= "
					/* General */
					.product_list_widget li > a,
	                .product_list_widget .woocommerce-Price-amount,
	                .product_list_widget .product-title,
					.woocommerce-MyAccount-content legend,
					.woocommerce-form-login .woocommerce-LostPassword a,
					.woocommerce-table--order-downloads .download-product a,
					.woocommerce-table--order-details a,
					.woocommerce-thankyou-order-received,
					.woocommerce-MyAccount-content table.shop_table_responsive th,
					.woocommerce-MyAccount-content table.shop_table_responsive tr td:before,
					.woocommerce-table--order-details th,
					.woocommerce-checkout-review-order-table td.product-name,
					.woocommerce-cart-form__cart-item td,
					.woocommerce-cart-form__cart-item td a,
					.woocommerce-loop-category__title mark,
					.woocommerce-mini-cart__total > strong,
					.woocommerce-mini-cart-item a,
					.woocommerce-Tabs-panel--additional_information .shop_attributes td,
					.comment-text .woocommerce-review__author {
						color: {$general_heading_color};
					}
					.widget_product_categories [class*='current'] > a,
                	.widget_product_categories li a:hover,
                	.woocommerce-widget-layered-nav li a:hover,
                	.woocommerce-widget-layered-nav li.chosen a
					.woocommerce-form-login .woocommerce-LostPassword a:hover,
					.woocommerce-MyAccount-navigation-link:not(.is-active) > a:hover,
					.woocommerce-MyAccount-navigation-link.is-active > a,
					.woocommerce-table--order-downloads .download-product a:hover,
					.woocommerce-table--order-details a:hover,
					ul.woocommerce-thankyou-order-details li strong,
					.woocommerce-checkout-review-order-table td.product-total,
					.woocommerce-cart-form__cart-item td a:hover,
					a:hover > .woocommerce-loop-category__title mark,
                	a:hover > .woocommerce-loop-category__title,
					.product_list_widget li > a:hover,
                	.product_list_widget .product-title:hover,
					.widget_rating_filter li a:hover,
					.widget_product_categories .product-categories li a:hover,
					.woocommerce-mini-cart__total > .woocommerce-Price-amount,
					.woocommerce-mini-cart-item .woocommerce-Price-amount,
					.woocommerce-mini-cart-item .quantity,
					.woocommerce-tabs ul.tabs li.active a,
					.woocommerce-tabs ul.tabs li:hover a,
					.woocommerce-product-rating .woocommerce-review-link:hover,
					li.product > .price,
					.woocommerce-loop-product__title:hover,
					li.product .added_to_cart:after,
					li.product .button:after {
						color: {$general_link_color};
					}
					.widget_price_filter .ui-slider .ui-slider-range,
					.search-results:not(.post-type-archive) .site-main article.type-product .woocommerce-Price-amount,
					div.product .entry-summary .woocommerce-Price-amount {
						background-color: {$general_link_color};
					}
					.woocommerce-pagination ul li .page-numbers:not(.dots):hover,
                	.woocommerce-pagination ul li .page-numbers.current,
					.woocommerce-mini-cart__buttons > a:not(.checkout):hover {
						border-color: {$general_link_color};
						color: {$general_link_color};
					}
					form.track_order > p:first-of-type {
						background: -webkit-linear-gradient(315deg, {$general_link_color} 39%, {$general_link_color_lighter} 100%);
						background: -o-linear-gradient(315deg, {$general_link_color} 39%, {$general_link_color_lighter} 100%);
						background: linear-gradient(135deg, {$general_link_color} 39%, {$general_link_color_lighter} 100%);
					}
					.woocommerce-MyAccount-downloads-file,
					.woocommerce-orders-table__cell-order-actions .woocommerce-button {
						color: {$general_link_color} !important;
					}
					.woocommerce-MyAccount-downloads-file:hover,
					.woocommerce-orders-table__cell-order-actions .woocommerce-button:hover {
						color: {$general_link_alt_color} !important;
					}
					.widget_product_categories [class*='current'] > a:hover,
					.woocommerce-orders-table__cell-order-actions .woocommerce-button:hover,
					li.product .added_to_cart:hover:after,
					li.product .button:hover:after {
						color: {$general_link_alt_color};
					}
					.site-header__search form[role='search'].woocommerce-product-search:before,
					ul.woocommerce-thankyou-order-details li,
					abbr.required:before,
					.woocommerce-remove-coupon:before,
					.product-remove .remove:before,
					.woocommerce-review__published-date,
					div.product .entry-summary del,
					.search-results:not(.post-type-archive) .site-main article.type-product del .woocommerce-Price-amount,
					div.product .entry-summary del .woocommerce-Price-amount,
					li.product .price .price-label {
						color: {$general_text_color_lighter};
					}
					.woocommerce-checkout-review-order-table thead th,
					.woocommerce-cart-form table th,
					.woocommerce-pagination ul li .page-numbers,
					div.product .entry-summary .cart .quantity .qty,
					div.product .entry-summary .product_meta,
					.woocommerce-product-rating .woocommerce-review-link {
						color: {$general_text_color_light};
					}
					.widget_rating_filter li a,
					.cart_totals .shipping label,
					.woocommerce-checkout-review-order__heading,
					.site-footer-bar .widget_price_filter .price_label,
					.woocommerce-mini-cart__buttons > a:not(.checkout),
					.woocommerce-MyAccount-navigation-link:not(.is-active) > a,
					.star-rating,
					.woocommerce-widget-layered-nav li a,
					.widget_product_categories li a,
					.woocommerce-tabs ul.tabs li a {
						color: {$general_text_color};
					}
					.woocommerce-terms-and-conditions {
						background-color: #{$general_background_color};
					}
					.category-flash,
					.sold-out-flash
					.woocommerce-product-gallery__trigger,
					.widget_product_tag_cloud a {
	                    color: {$general_text_color_light};
	                    background-color: #{$general_background_color};
	                }
					/* Button */
					.select2-container.select2-container--default .select2-results__option[aria-selected=true], 
					.select2-container.select2-container--default .select2-results__option[data-selected=true],
					.select2-container.select2-container--default .select2-results__option--highlighted[aria-selected], 
					.select2-container.select2-container--default .select2-results__option--highlighted[data-selected],
					.widget_product_tag_cloud a:hover,
					.site-header__cart li:not(.current-menu-item) .cart-contents {
						background-color: {$button_background_color};
						border-color: {$button_background_color};
						color: {$button_text_color};
					}
					.site-header__cart li.current-menu-item .cart-contents,
	                .site-header__cart:focus li .cart-contents, 
	                .site-header__cart:hover li .cart-contents {
	                    color: {$button_alt_text_color};
	                }
				";
			endif; // End If conj_lite_is_woocommerce_activated();

        	$customizer_css = apply_filters( 'conj_lite_customizer_inline_css', $customizer_css );
        	return wp_strip_all_tags( $customizer_css );

        }

	}
endif;
// End Class.
