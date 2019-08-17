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
        		.site-branding .site-description,
				.site-branding .site-title a {
        			color: #{$general_site_title_color};
        		}
        		/* General */
        		.wp-block-pullquote:not(.is-style-solid-color) blockquote:after,
				.wp-block-pullquote:not(.is-style-solid-color) blockquote:before,
				.c-offcanvas-content-wrap,
				.search-results:not(.post-type-archive) .site-main article:not(.type-product):not(.type-post) .entry-meta span,
				article.post.hentry .cat-tags-links .post-categories a,
				.entry-footer .edit-link .post-edit-link,
				.widget_tag_cloud ul li,
				.conj-lite-blog__archive.has-sidebar.post-template-template-fluid article.post.hentry .alignfull,
				.conj-lite-blog__archive:not(.has-sidebar) article.post.hentry .alignfull,
				body {
					background-color: #{$general_background_color};
				}
				#site-navigation > div.menu > ul ul.children:before,
				#site-navigation > div.menu > ul ul.children,
				#masthead ul.sub-menu > li > ul.sub-menu:before,
				#masthead ul.menu > li.menu-item-has-children > ul.sub-menu:before,
				#masthead ul.sub-menu {
					border-color: #{$general_background_color};
				}
				#masthead {
					border-color: {$general_background_color_darker};
				}
				pre:not(.wp-block-verse):not(.wp-block-code) {
					background-color: {$general_background_color_dark};
				}
				audio::-webkit-media-controls-panel {
					background-color: {$general_background_color_dark};
				}
				body.search-results article .entry-footer a,
				body.search-results article .entry-title a,
				.search-results:not(.post-type-archive) .site-main article .entry-header a,
				body:not(.single-post) article.post.hentry .entry-header a,
				.comment-meta .comment-author .fn,
				.comment-respond .comment-reply-title,
				.comment-respond #reply-title,
				.main-navigation .widget_calendar .calendar_wrap caption,
				.wp-block-calendar table caption,
				.conj-lite-secondary-widget-area__wrapper .widget_calendar .calendar_wrap caption,
				.conj-lite-secondary-widget-area__wrapper .widget-title,
				dd,
				h1,
				h2,
				h3,
				h4,
				h5,
				h6 {
					color: {$general_heading_color};
				}
				#site-navigation > div.menu > ul ul.children > li > a,
				#masthead ul.sub-menu > li > a,
				#site-navigation > div.menu > ul > li > a,
				.primary-navigation > ul.menu > .menu-item > a,
				.wp-block-pullquote,
				.wp-block-quote__citation,
				.wp-block-quote footer,
				blockquote,
				.wp-block-calendar table tbody,
				.ui-datepicker .ui-datepicker-calendar th,
				body.single-post article.post.hentry .entry-footer .tags-links > a,
				.type-attachment .post-meta a,
				article.post.hentry .post-meta a,
				.type-attachment .post-meta .byline a,
				.single-post article.type-post .post-meta .byline a,
				.error-404-first .widget_recent_entries a,
				.wp-block-latest-posts a,
				.conj-lite-secondary-widget-area__wrapper .widget_recent_entries a,
				.conj-lite-secondary-widget-area__wrapper .widget_pages ul a,
				.conj-lite-secondary-widget-area__wrapper .widget ul.menu li > a,
				.conj-lite-secondary-widget-area__wrapper .widget_meta a,
				.widget_categories a,
				.wp-block-categories.wp-block-categories-list a,
				.conj-lite-secondary-widget-area__wrapper .widget_archive a,
				ul.wp-block-archives a,
				body {
					color: {$general_text_color};
				}
				.primary-navigation ul.menu > li.menu-item-has-children > a:after,
				.wp-block-tag-cloud a.tag-cloud-link,
				.page-links a>.page-number,
				.nav-links a,
				.pagination .page-numbers:not(.current),
				.search-results:not(.post-type-archive) .site-main article:not(.type-product):not(.type-post) .entry-meta span,
				article.post.hentry .cat-tags-links .post-categories a,
				.widget_tag_cloud a,
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
				.single-post article.type-post .post-meta .byline {
					color: {$general_text_color_lighter};
				}
				#site-navigation > div.menu > ul ul.children > li[class*='current'] > a,
				#site-navigation > div.menu > ul ul.children > li:hover > a,
				#masthead ul.sub-menu [class*='current'] > a,
				#masthead ul.sub-menu > li:hover > a,
				body.search-results article .entry-footer a:hover,
				body.search-results article .entry-title a:hover,
				body.single-post article.post.hentry .entry-footer .tags-links > a:hover,
				.single-post article.type-post .post-meta .byline a:hover,
				.type-attachment .post-meta .byline a:hover,
				.search-results:not(.post-type-archive) .site-main article .entry-header a:hover,
				body:not(.single-post) article.post.hentry .entry-header a:hover,
				.type-attachment .post-meta a:hover,
				article.post.hentry .post-meta a:hover,
				.entry-footer .edit-link .post-edit-link,
				.page-links a>.page-number:hover,
				.site-main .comment-navigation a:hover,
				.post-navigation .nav-links a:hover,
				.pagination .page-numbers:not(.dots):hover,
				.pagination .page-numbers.current,
				body:not(.single-post) article.type-post .page-links > a:first-child .page-number,
				.page-links .page-number,
				.comment-metadata a:hover time,
				.error-404-first .widget_recent_entries a:hover,
				.conj-lite-secondary-widget-area__wrapper .widget_recent_entries a:hover,
				.conj-lite-secondary-widget-area__wrapper .widget_categories .current-cat-parent > a,
				.conj-lite-secondary-widget-area__wrapper .widget_categories .current-cat > a,
				.conj-lite-secondary-widget-area__wrapper ul.menu .current_page_parent > a,
				.conj-lite-secondary-widget-area__wrapper ul.menu .current_page_item > a,
				.conj-lite-secondary-widget-area__wrapper .widget_pages .current_page_parent > a,
				.conj-lite-secondary-widget-area__wrapper .widget_pages .current_page_item > a,
				.conj-lite-secondary-widget-area__wrapper .widget_pages ul a:hover,
				.conj-lite-secondary-widget-area__wrapper .widget ul.menu li:hover > a,
				.conj-lite-secondary-widget-area__wrapper .widget_meta a abbr,
				.conj-lite-secondary-widget-area__wrapper .widget_meta a:hover,
				.wp-block-categories.wp-block-categories-list a:hover,
				.widget_categories a:not(.has-text-color):hover,
				.wp-block-calendar tfoot a:hover,
				.calendar_wrap tfoot td a:hover,
				.conj-lite-secondary-widget-area__wrapper .widget_archive a:hover,
				ul.wp-block-archives a:hover,
				.wp-block-latest-posts > li > a:hover,
				.site-branding .site-title a:hover,
				input[type='checkbox']:checked:before,
				a {
					color: {$general_link_color};
				}
				mark,
				input[type='radio']:checked:before {
					background-color: {$general_link_color};
				}
				body:not(.single-post) article.type-post .page-links > a:first-child .page-number,
				article.post.hentry.format-chat .entry-content > *:nth-child(even),
				article.post.hentry.format-chat .entry-content > *:nth-child(even):before {
					border-color: {$general_link_color};
				}
				a:hover {
					color: {$general_link_alt_color};
				}
				/* Button */
				.wp-block-tag-cloud a.tag-cloud-link:hover,
				.ui-datepicker .ui-datepicker-calendar td a:hover,
				.ui-datepicker .ui-datepicker-calendar td a.ui-state-active,
				.ui-datepicker .ui-datepicker-title select,
				.ui-datepicker .ui-datepicker-header,
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background),
				body.single-post article.post.hentry .entry-footer .tags-links > a:hover,
				article.post.hentry .cat-tags-links .post-categories a:hover,
				body:not(.single-post) article.post.hentry .entry-content .more-link,
				.wp-block-file .wp-block-file__button,
				.widget_tag_cloud ul li:hover,
				.wp-block-calendar tbody td#today,
				.calendar_wrap #today,
				.button:not(:focus):not(:active):not(:hover):not([disabled]):not([name='apply_coupon']), 
				button:not(.close-btn):not(.handheld-menu-toggle):not(.pswp__button):not(:focus):not(:active):not(:hover):not([disabled]):not([name='apply_coupon']), 
				input[type='button']:not(:focus):not(:active):not(:hover), 
				input[type='reset']:not(:focus):not(:active):not(:hover), 
				button[name='apply_coupon']:active,
				button[name='apply_coupon']:hover,
				button[name='apply_coupon']:focus,
				input[type='submit'][name='apply_coupon']:hover,
				input[type='submit'][name='apply_coupon']:focus,
				input[type='submit']:not([name='apply_coupon']):not(:focus):not(:active):not(:hover) {
					background-color: {$button_background_color};
				}
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color) {
					color: {$button_background_color};
				}
				.wp-block-file a.wp-block-file__button,
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color),
				body:not(.single-post) article.post.hentry .entry-content .more-link,
				.button:not(:focus):not(:active):not(:hover):not([disabled]):not([name='apply_coupon']), 
				button:not(.close-btn):not(.handheld-menu-toggle):not(.pswp__button):not(:focus):not(:active):not(:hover):not([disabled]):not([name='apply_coupon']), 
				input[type='button']:not(:focus):not(:active):not(:hover), 
				input[type='reset']:not(:focus):not(:active):not(:hover), 
				button[name='apply_coupon']:active,
				button[name='apply_coupon']:hover,
				button[name='apply_coupon']:focus,
				input[type='submit'][name='apply_coupon']:hover,
				input[type='submit'][name='apply_coupon']:focus,
				input[type='submit']:not([name='apply_coupon']):not(:focus):not(:active):not(:hover) {
					border-color: {$button_background_color};
				}
				.wp-block-calendar tbody td > a,
				.widget_calendar .calendar_wrap tbody td > a {
					background-color: {$button_background_color_lighter};
				}
				.wp-block-tag-cloud a.tag-cloud-link:hover,
				#subscribe-submit [type='submit']:hover,
				.ui-datepicker.ui-widget .ui-datepicker-header,
				.ui-datepicker .ui-datepicker-calendar td a:hover,
				.ui-datepicker .ui-datepicker-calendar td a.ui-state-active,
				.ui-datepicker .ui-datepicker-title select,
				.ui-datepicker-header .ui-datepicker-next, 
				.ui-datepicker-header .ui-datepicker-prev,
				.ui-datepicker-header .ui-datepicker-next:hover, 
				.ui-datepicker-header .ui-datepicker-prev:hover,
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color):hover,
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color),
				body.single-post article.post.hentry .entry-footer .tags-links > a:hover,
				article.post.hentry .cat-tags-links .post-categories a:hover,
				body:not(.single-post) article.post.hentry .entry-content .more-link,
				.wp-block-file .wp-block-file__button,
				.widget_tag_cloud ul li:hover a,
				.wp-block-calendar tbody td > a,
				.widget_calendar .calendar_wrap tbody td > a,
				.wp-block-calendar tbody td#today,
				.calendar_wrap #today,
				.button:not(:focus):not(:active):not(:hover):not([disabled]):not([name='apply_coupon']), 
				button:not(.close-btn):not(.handheld-menu-toggle):not(.pswp__button):not(:focus):not(:active):not(:hover):not([disabled]):not([name='apply_coupon']), 
				input[type='button']:not(:focus):not(:active):not(:hover), 
				input[type='reset']:not(:focus):not(:active):not(:hover), 
				button[name='apply_coupon']:active,
				button[name='apply_coupon']:hover,
				button[name='apply_coupon']:focus,
				input[type='submit'][name='apply_coupon']:hover,
				input[type='submit'][name='apply_coupon']:focus,
				input[type='submit']:not([name='apply_coupon']):not(:focus):not(:active):not(:hover) {
					color: {$button_text_color};
				}
				.ui-datepicker .ui-datepicker-title select {
					background-image: -webkit-linear-gradient(45deg, transparent 50%, {$button_text_color} 50%), -webkit-linear-gradient(315deg, {$button_text_color} 50%, transparent 50%), -webkit-linear-gradient(left, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
					background-image: -o-linear-gradient(45deg, transparent 50%, {$button_text_color} 50%), -o-linear-gradient(315deg, {$button_text_color} 50%, transparent 50%), -o-linear-gradient(left, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
					background-image: linear-gradient(45deg, transparent 50%, {$button_text_color} 50%), linear-gradient(135deg, {$button_text_color} 50%, transparent 50%), linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
				}
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):hover,
				.wp-block-file a.wp-block-file__button:active, 
				.wp-block-file a.wp-block-file__button:focus, 
				.wp-block-file a.wp-block-file__button:hover, 
				.wp-block-file a.wp-block-file__button:visited,
				body:not(.single-post) article.post.hentry .entry-content .more-link:hover,
				.button:not([name='apply_coupon']):focus, 
				.button[disabled], 
				button[disabled], 
				button:not(.close-btn):not(.handheld-menu-toggle):not(.pswp__button):not([name='apply_coupon']):focus, 
				input[type='button']:focus, 
				input[type='reset']:focus, 
				button[name='apply_coupon'],
				input[type='submit'][name='apply_coupon'],
				input[type='submit']:not([name='apply_coupon']):focus,
				.button:not([name='apply_coupon']):active, 
				button:not(.close-btn):not(.handheld-menu-toggle):not(.pswp__button):not([name='apply_coupon']):active, 
				input[type='button']:active, 
				input[type='reset']:active, 
				input[type='submit']:not([name='apply_coupon']):active,
				.button:not([name='apply_coupon']):hover, 
				button:not(.close-btn):not(.handheld-menu-toggle):not(.pswp__button):not([name='apply_coupon']):hover, 
				input[type='button']:hover, 
				input[type='reset']:hover, 
				input[type='submit']:not([name='apply_coupon']):hover {
					color: {$button_alt_text_color};
				}
				.wp-block-file a.wp-block-file__button:active, 
				.wp-block-file a.wp-block-file__button:focus, 
				.wp-block-file a.wp-block-file__button:hover, 
				.wp-block-file a.wp-block-file__button:visited,
				.button:active, 
				button:active, 
				button[disabled],
				input[type='button']:active,
				input[type='submit']:active,
				.button:focus, 
				button:focus, 
				input[type='button']:focus,
				input[type='submit']:focus,
				.button:hover, 
				button:hover,
				button[name='apply_coupon'],
				input[type='submit'][name='apply_coupon'],
				input[type='button']:hover,
				input[type='submit']:hover, 
				.wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color):hover,
				body:not(.single-post) article.post.hentry .entry-content .more-link:hover {
					border-color: {$button_alt_text_color};
				}
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):hover {
					background-color: {$button_alt_text_color};
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
					.woocommerce-MyAccount-content legend,
					.woocommerce-account:not(.logged-in) .entry-content > .woocommerce > .woocommerce-form-login .woocommerce-LostPassword,
					#customer_login .woocommerce-LostPassword a,
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
					.product_list_widget li > a,
					.woocommerce-mini-cart__total > strong,
					.woocommerce-mini-cart-item a,
					.woocommerce-Tabs-panel--additional_information .shop_attributes td,
					ol.commentlist .comment-text .woocommerce-review__author,
					.product_list_widget .woocommerce-Price-amount,
	        		.product_list_widget .product-title {
						color: {$general_heading_color};
					}
					.widget_product_categories .product-categories li.current-cat-parent > a,
					.widget_product_categories .product-categories li.current-cat > a,
					#customer_login .woocommerce-LostPassword a:hover,
					.woocommerce-account:not(.logged-in) .entry-content > .woocommerce > .woocommerce-form-login .woocommerce-LostPassword a:hover,
					.woocommerce-MyAccount-navigation-link:not(.is-active) > a:hover,
					.woocommerce-MyAccount-navigation-link.is-active > a,
					.woocommerce-table--order-downloads .download-product a:hover,
					.woocommerce-table--order-details a:hover,
					ul.woocommerce-thankyou-order-details li strong,
					.woocommerce-checkout-review-order-table td.product-total,
					.woocommerce-cart-form__cart-item td a:hover,
					li.product-category a:hover .woocommerce-loop-category__title mark,
					li.product-category a:hover .woocommerce-loop-category__title,
					.product_list_widget li > a:hover,
					.woocommerce.widget_rating_filter li a:hover,
					.woocommerce-widget-layered-nav ul li a:hover,
					.woocommerce-pagination ul li .page-numbers:not(.dots):hover,
					.woocommerce-pagination ul li .page-numbers.current,
					.widget_product_categories .product-categories li a:hover,
					.woocommerce-mini-cart__total > .woocommerce-Price-amount,
					.woocommerce-mini-cart-item .woocommerce-Price-amount,
					.woocommerce-mini-cart-item .quantity,
					.woocommerce-tabs ul.tabs li.active a,
					.woocommerce-tabs ul.tabs li:hover a,
					.woocommerce-product-rating .woocommerce-review-link:hover,
					ul.products li.product > .price,
					ul.products li.product .woocommerce-loop-product__link .woocommerce-loop-product__title:hover,
					.product_list_widget .product-title:hover,
					ul.products li.product .added_to_cart:after,
					ul.products li.product .button:after {
						color: {$general_link_color};
					}
					.widget_price_filter .ui-slider .ui-slider-range,
					.search-results:not(.post-type-archive) .site-main article.type-product .woocommerce-Price-amount,
					.single-product div.product .entry-summary .woocommerce-Price-amount {
						background-color: {$general_link_color};
					}
					.woocommerce-pagination ul li .page-numbers:not(.dots):hover,
					.woocommerce-pagination ul li .page-numbers.current {
						border-color: {$general_link_color};
					}
					.woocommerce-mini-cart__buttons > a:not(.checkout):hover {
						border-color: {$general_link_color} !important;
					}
					form.track_order > p:first-of-type {
						background: -webkit-linear-gradient(315deg, {$general_link_color} 39%, {$general_link_color_lighter} 100%);
						background: -o-linear-gradient(315deg, {$general_link_color} 39%, {$general_link_color_lighter} 100%);
						background: linear-gradient(135deg, {$general_link_color} 39%, {$general_link_color_lighter} 100%);
					}
					.woocommerce-mini-cart__buttons > a:not(.checkout):hover,
					.woocommerce-MyAccount-downloads-file,
					.woocommerce-orders-table__cell-order-actions .woocommerce-button {
						color: {$general_link_color} !important;
					}
					.woocommerce-MyAccount-downloads-file:hover,
					.woocommerce-orders-table__cell-order-actions .woocommerce-button:hover {
						color: {$general_link_alt_color} !important;
					}
					.widget_product_categories .product-categories li.current-cat-parent > a:hover,
					.widget_product_categories .product-categories li.current-cat > a:hover,
					.woocommerce-orders-table__cell-order-actions .woocommerce-button:hover,
					ul.products li.product .added_to_cart:hover:after,
					ul.products li.product .button:hover:after {
						color: {$general_link_alt_color};
					}
					ul.woocommerce-thankyou-order-details li,
					abbr.required:before,
					.woocommerce-remove-coupon:before,
					.product-remove .remove:before,
					.woocommerce-review__published-date,
					.single-product div.product .entry-summary del,
					.search-results:not(.post-type-archive) .site-main article.type-product del .woocommerce-Price-amount,
					.single-product div.product .entry-summary del .woocommerce-Price-amount,
					ul.products li.product .price .price-label {
						color: {$general_text_color_lighter};
					}
					.widget_product_tag_cloud .tagcloud a,
					.woocommerce-product-gallery__trigger,
					ul.products li.product .category-flash,
					ul.products li.product .sold-out-flash,
					.woocommerce-checkout-review-order-table thead th,
					.woocommerce-cart-form table th,
					.woocommerce-pagination ul li .page-numbers,
					.single-product div.product .entry-summary .cart .quantity .qty,
					.single-product div.product .entry-summary .product_meta,
					.woocommerce-product-rating .woocommerce-review-link {
						color: {$general_text_color_light};
					}
					.cart_totals .shipping label,
					.site-footer-bar .widget_price_filter .price_label,
					.woocommerce-MyAccount-navigation-link:not(.is-active) > a,
					.woocommerce.widget_rating_filter li a,
					.star-rating,
					.woocommerce-widget-layered-nav ul li a,
					.widget_product_categories .product-categories li a,
					.woocommerce-tabs ul.tabs li a {
						color: {$general_text_color};
					}
					.woocommerce-mini-cart__buttons > a:not(.checkout) {
						color: {$general_text_color} !important;
					}
					.woocommerce-terms-and-conditions,
					.widget_product_tag_cloud .tagcloud a,
					.woocommerce-product-gallery__trigger,
					.category-flash,
					.sold-out-flash {
						background-color: #{$general_background_color};
					}
					/* Button */
					#main .woocommerce-variation-add-to-cart-disabled .button.disabled {
						border-color: {$button_alt_text_color};
					}
					.select2-container.select2-container--default .select2-results__option[aria-selected=true], 
					.select2-container.select2-container--default .select2-results__option[data-selected=true],
					.select2-container.select2-container--default .select2-results__option--highlighted[aria-selected], 
					.select2-container.select2-container--default .select2-results__option--highlighted[data-selected],
					.widget_product_tag_cloud .tagcloud a:hover,
					.site-header-cart:not(:hover):not(:focus) li:not(.current-menu-item) .cart-contents:not(:focus):not(:active):not(:hover) {
						background-color: {$button_background_color};
						border-color: {$button_background_color};
						color: {$button_text_color};
					}
					#main .woocommerce-variation-add-to-cart-disabled .button.disabled,
					.site-header-cart .current-menu-item .cart-contents,
					.site-header-cart .cart-contents:active,
					.site-header-cart .cart-contents:focus,
					.site-header-cart:focus .cart-contents, 
					.site-header-cart:hover .cart-contents:hover, 
					.site-header-cart:hover .cart-contents, 
					.site-header-cart .cart-contents:hover {
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
