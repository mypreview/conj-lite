=== Conj Lite ===
Contributors: mypreview, mahdiyazdani, gookaani
Tags: two-columns, three-columns, four-columns, left-sidebar, right-sidebar, grid-layout, flexible-header, custom-background, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, full-width-template, sticky-post, theme-options, threaded-comments, translation-ready, rtl-language-support, blog, e-commerce, block-styles, wide-blocks
Donate link: https://www.conj.ws
Requires at least: 5.0
Tested up to: 5.2.2
Requires PHP: 7.0.0
Stable tag: 1.2.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Meet CONJ – a super-fast, super-lightweight and super-stylish theme with impressive usability, both on the front and back end for creating a stylish WooCommerce webshop or stunning company website with its unique mobile-first and grid-based architecture.

== Description ==
Meet CONJ – a super-fast, super-lightweight and super-stylish theme with impressive usability, both on the front and back end for creating a stylish WooCommerce webshop or stunning company website with its unique mobile-first and grid-based architecture which comes with built-in one click demo import to help you have your new website up and running in a matter of minutes. Intuitive, flexible and compatible with the new Gutenberg block-based content editor — Demo → https://www.conj.ws/lite

== Installation ==
1. Upload the entire `conj-lite` folder to the `/wp-content/themes/` directory.
2. Activate the theme through the `Themes` menu in WordPress.
3. Start by visiting theme customizer at `Appearance` » `Customize`.

== Frequently Asked Questions ==
= What are the server requirements to install this theme? =
To run the [Conj Lite](https://www.conj.ws/lite) on your server we require your host supports:

* PHP version 7 or greater.
* MySQL version 5.6 or greater OR MariaDB version 10.0 or greater.
* WordPress version 5.0 or greater.
* WooCommerce version 3.5 or greater.
* WP Memory limit of 64 MB or greater (128 MB or higher is preferred).

== Copyright ==
Conj Lite WordPress Theme, Copyright (C) 2015 - 2019 MY PREVIEW LLC. https://www.conj.ws
Conj Lite is distributed under the terms of the GNU GPL Version 3.

You can redistribute this program and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

== Changelog ==
= 1.2.0 =
* Fix: Compliant with BEM CSS conventions `http://getbem.com`.
* Fix: Multiple code standards improvements.
* Fix: If no widgets are present in the sidebar, a full-width layout will be applied to all pages.
* Fix: Correct position of product flashes on shop loop items.
* Fix: Removed 100% width for container on single post page using fluid-template.
* Fix: Shipping totals properly aligned in small screens.
* Fix: Ensure all checkboxes and radio-buttons function correctly with new markup.
* Fix: Improved semantic HTML for pages and template files.
* Fix: Removed duplicate inline background-color style for the body tag.
* Fix: Show cancel button when a user focuses on search input.
* Fix: Remove submenu from the view when the menu item has not hovered.
* Update: One-click demo import files.
* Update: Gutenberg editor styles.
* Update: Classic editor styles.
* Update: Language files.
* Update: Extensive improvements to the responsive design.
* Update: Refactored all underlying code and re-organized/ static resources.
* Tweak: Styling in IE 11 (Internet Explorer) browser.
* Tweak: RTL (Right-to-left) language styling.
* Tweak: Use transition instead of `keyframe` animation in submenu openning.
* Tweak: Trigger a `wp_body_open` action immediately after the opening `body` tag.
* Compatibility: WooCommerce 3.7.0

= 1.1.1 =
* Fix: Adjust background color in block mover controls to improve visibility in either dark or light color scheme.
* Fix: Correct block inserter position to avoid overlapping select block over the next one in the editor.
* Fix: Prevent product images from getting stretched in Gutenberg editor block.
* Tweak: Improved responsiveness of `core/columns` Gutenberg editor block.
* Tweak: Use `wp_style_add_data` to set the rtl property to replace for editor stylesheet.
* Tweak: RTL (Right-to-left) language styling.
* Compatibility: WordPress 5.2.2
* Compatibility: WooCommerce 3.6.4

= 1.1.0 =
* Fix: HTML validation errors.
* Fix: Typography scaling issues.
* Fix: Warning flags raised by ThemeCheck plugin.
* Fix: WooCommerce pagination styling issue.
* Fix: Align wide and full positioning in post editor.
* Fix: Filling the space in the last column of 3x footer widget.
* Fix: Adjust widget title border position in the footer.
* Feature: Site-wide header image integration and support.
* Feature: Added system font stack as fallback for Google web-fonts.
* Feature: Update block editor width on page template change.
* Feature: Single attachment (media) view page design.
* Feature: Added style to Aksimet privacy notice.
* Feature: Added style to comment privacy consent checkbox.
* Feature: Added style to comment awaiting moderation notice.
* Feature: `wp_body_open` hook support.
* Feature: Left and right sidebar positioning support.
* Feature: RTL (Right-to-left) language support.
* Feature: Responsive embedded content support.
* Feature: Registered site-wide color alter controls under the Customizer window.
* Feature: Integrated with `One Click Demo Import` plugin to import built-in demo files.
* Feature: Added style to the WooCommerce `Products by Attribute` Gutenberg editor blocks.
* Feature: Added style to the WooCommerce `Featured Product` Gutenberg editor blocks.
* Feature: Added style to the WooCommerce `Hand-Picked Products` Gutenberg editor blocks.
* Feature: Added style to the WooCommerce `Best-Selling Products` Gutenberg editor blocks.
* Feature: Added style to the WooCommerce `Top-Rated Products` Gutenberg editor blocks.
* Feature: Added style to the WooCommerce `Newest Products` Gutenberg editor blocks.
* Feature: Added style to the WooCommerce `On-Sale Products` Gutenberg editor blocks.
* Feature: Added style to the WooCommerce `Products by Category ` Gutenberg editor blocks.
* Feature: Reflect site-wide typography settings in Gutenberg editor.
* Feature: Reflect site-wide color scheme in Gutenberg editor.
* Feature: Reflect blog post styling to Gutenberg post edit view.
* Update: Language file.
* Update Core WordPress widgets style.
* Update WooCommerce widgets style.
* Update Comment pagination style.
* Update: Theme screenshot.
* Update: Classic editor styles.
* Update: `Feather` CSS font icon pack to version 4.19.0
* Update: Escaping the `pingback` URL.
* Update: JS handlers switched to `.on()` method instead of using shortcut method.
* Tweak: 404 page layout style and HTML markup.
* Tweak: Replaced CSS variables with actual values to support IE 11.
* Tweak: Typography hierarchy.
* Tweak: Styling in Edge browser.
* Tweak: RTL (Right-to-left) language styling.
* Tweak: Registered third-party libraries to load independently.
* Remove: `_authorname_` to prevent double prefixing.
* Dev: Added TGMPA to recommend plugin installation.
* Compatibility: Tested against the WordPress Unit Test data.
* Compatibility: WordPress.com-specific functions and definitions.
* Compatibility: WPML translation plugin.
* Compatibility: IE 11 (Internet Explorer) browser.
* Compatibility: Post formats.
* Compatibility: WordPress 5.2.1
* Compatibility: WooCommerce 3.6.3

= 1.0.9 =
* Fix: Minor styling issues.
* Update: Language file.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==
= 1.0.0 =
* Nothing so far.

== Credits ==
* [_s, or Underscores](https://github.com/Automattic/_s)
* [WooCommerce](https://github.com/woocommerce/woocommerce)
* [Storefront](https://github.com/woocommerce/storefront)
* [Twentythirteen](https://github.com/WordPress/WordPress/tree/master/wp-content/themes/twentythirteen)
* [Twentysixteen](https://github.com/WordPress/twentysixteen)
* [Twentyseventeen](https://github.com/WordPress/twentyseventeen)
* [One Click Demo Import](https://github.com/proteusthemes/one-click-demo-import)
* [Feather Icons](https://github.com/feathericons/feather)
* [FitVids](https://github.com/davatron5000/FitVids.js)
* [JS Offcanvas](https://github.com/vmitsaras/js-offcanvas)
* [Skip to content](https://github.com/Automattic/_s/pull/136)
* [Slinky](https://github.com/alizahid/slinky)
* [Browsers support badges for GitHub](https://github.com/godban/browsers-support-badges)
* [Rubik](https://fonts.google.com/specimen/Rubik)
* [Homemade Apple](https://fonts.google.com/specimen/Homemade+Apple)
* [Montserrat](https://fonts.google.com/specimen/Montserrat)
* [Screenshot Image 1](https://www.pexels.com/photo/app-earbuds-earphones-google-play-music-39592)
* [Screenshot Image 2](https://www.pexels.com/photo/console-controller-gamer-gaming-21067)
* [Screenshot Image 3](https://www.pexels.com/photo/red-ceramic-mug-filled-with-coffee-near-jam-jar-on-table-2147683)
* [Screenshot Image 4](https://www.pexels.com/photo/samsung-samsung-galaxy-s6-edge-plus-edge-plus-s6-edge-47261)
* [Screenshot Image 5](https://www.pexels.com/photo/round-grey-speaker-on-brown-board-1072851)