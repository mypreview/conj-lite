<?php
/**
 * Conj Lite admin NUX
 *
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Conj_Lite_NUX_Admin' ) ) :

	/**
	 * The admin NUX class
	 */
	class Conj_Lite_NUX_Admin {

		/**
		 * Setup class.
		 *
		 * @access 	public
		 * @return void
		 */
		public function __construct() {

			add_action( 'admin_notices', 	  							array( $this, 'upsell_notice' ), 	     	 	 1 );
			add_action( 'switch_theme', 	  							array( $this, 'switch_theme' ), 				10 );
			add_action( 'after_switch_theme', 							array( $this, 'after_switch_theme' ), 			10 );
			add_action( 'wp_ajax_conj_lite_dismiss_upsell_notice', 		array( $this, 'dismiss_upsell_notice' ), 		10 );

		}

		/**
		 * Output admin notice to notify the user to upgrade to PRO version.
		 *
		 * @see 	https://developer.wordpress.org/reference/hooks/admin_notices/
		 * @see 	https://developer.wordpress.org/reference/functions/get_option/
		 * @see 	https://developer.wordpress.org/reference/functions/get_transient/
		 * @access 	public
		 * @return 	void
		 */
		public function upsell_notice() {

			// Bail out, if the theme recently activated.
			if ( get_transient( 'conj_lite_did_just_activate_transient' ) ) {
				return;
			} // End If Statement

			// Bail out, if the notice already dismissed by the user.
			if ( get_transient( 'conj_lite_dismiss_upsell_notice_flag' ) ) {
				return;
			} // End If Statement

			?>
			<div id="conj-lite-upsell-notice" class="notice is-dismissible">
				<div id="conj-lite-upsell-banner__top-text">
					<span class="dashicons dashicons-info"></span>
					<span><?php esc_html_e( 'You&rsquo;re currently using free version of the Conj theme. By upgrading to premium version, you would be able to unlock powerful e-Commerce features and performance tools for your webshop.', 'conj-lite' ); ?></span>
				</div><!-- #conj-lite-upsell-banner__top-text -->
				<div id="conj-lite-upsell-banner__message">
					<div id="conj-lite-upsell-banner__message--inner">
						<div class="conj-lite-upsell-banner__message--inner-col1">
							<img src="<?php echo get_theme_file_uri( 'assets/admin/img/upsell-banner-img.jpg' ); ?>" width="250" />
							<p>
								<?php
								/* translators: 1: Open anchor tag, 2: Emoji unicode, 3: Close anchor tag. */
								printf( esc_html__( '%1$sGo Premium %2$s %3$s', 'conj-lite' ), '<a href="https://themeforest.net/item/conj-ecommerce-wordpress-theme/21935639?ref=mypreview" class="button button-primary" target="_blank" rel="noopener">', '💰', '</a>' ); ?>
								<small><em>
									<?php esc_html_e( 'By clicking the button, you will be redirected to the item details page on ThemeForest.', 'conj-lite' ); ?>
								</em></small>
							</p>
						</div>
						<div class="conj-lite-upsell-banner__message--inner-col2">
							<h2><?php esc_html_e( 'Stay Focused on Your Business!', 'conj-lite' ); ?></h2>
							<p><?php esc_html_e( 'Block editor components, built-in e-Commerce features, and customization options are all thoroughly documented with live website examples for easier use and customization — just like WordPress itself. Not comfortable diving that deep? No worries,  a huge set of base elements and pre-built block editor templates are already set up for you. You just have to get started!', 'conj-lite' ); ?></p>
							<div class="conj-lite-upsell-banner__message--inner-features">
								<div>
									<h3><?php esc_html_e( 'Structure', 'conj-lite' ); ?></h3>
									<ul>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Based on Underscores', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Fully Responsive', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Flexible CSS grid', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s HiDPI / Retina ready', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s JetPack integration', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Designed for WooCommerce', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Extended documentation', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Continuous free updates', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
									</ul>
								</div>
								<div>
									<h3><?php esc_html_e( 'Features', 'conj-lite' ); ?></h3>
									<ul>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Header customizer', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Modular mega-menu', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Gutenberg blocks', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s +%s template blocks', 'more_feature', 'conj-lite' ), '✅', '💯' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Demo content install', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s GDPR cookie notice', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s WPML compatible', 'more_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Google Analytics integration', 'more_feature', 'conj-lite' ), '✅' ); ?></li>
									</ul>
								</div>
								<div>
									<h3><?php esc_html_e( 'e-Commerce', 'conj-lite' ); ?></h3>
									<ul>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Quick view', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Product brands', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Attribute swatches', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Store vacation', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Sale percent badge', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Two-steps checkout', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Product archive customizer', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Distraction free checkout', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
									</ul>
								</div>
								<div>
									<h3><?php esc_html_e( 'Customization', 'conj-lite' ); ?></h3>
									<ul>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Customize colors', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Customize typography', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Extandable styles', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Child theme ready', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s Translation ready', 'upsell_feature', 'conj-lite' ), '✅' ); ?></li>
										<li><?php 
										/* translators: %s: Emoji unicode */
										printf( esc_html_x( '%s &hellip;&hellip;and much more', 'more_feature', 'conj-lite' ), '🔥' ); ?></li>
									</ul>
								</div>
							</div>
						</div>
					</div><!-- #conj-lite-upsell-banner__message--inner -->
				</div><!-- #conj-lite-upsell-banner__message -->
			</div>
			<?php

		}

		/**
		 * Run when switching to another theme.
		 *
		 * @link 	https://developer.wordpress.org/reference/hooks/switch_theme/
		 * @see 	https://developer.wordpress.org/reference/functions/delete_transient/
		 * @access 	public
		 * @return 	void
		 */
		public function switch_theme() {

			delete_transient( 'conj_lite_dismiss_upsell_notice_flag' );
			delete_transient( 'conj_lite_did_just_activate_transient' );

		}

		/**
		 * Fires on the first WP load after a theme switch if the old theme still exists.
		 *
		 * @link 	https://developer.wordpress.org/reference/hooks/after_switch_theme/
		 * @see 	https://developer.wordpress.org/reference/functions/set_transient/
		 * @access 	public
		 * @return 	void
		 */
		public function after_switch_theme() {

			set_transient( 'conj_lite_did_just_activate_transient', TRUE, DAY_IN_SECONDS );

		}

		/**
		 * AJAX dismiss up-sell banner notice.
		 *
		 * @see 	https://wordpress.stackexchange.com/questions/242705/how-to-stop-showing-admin-notice-after-close-button-has-been-clicked
		 * @return 	void
		 */
		public function dismiss_upsell_notice() {

			$nonce = ! empty( $_POST['nonce'] ) ? $_POST['nonce'] : FALSE;
			
			if ( ! $nonce || ! wp_verify_nonce( $nonce, 'conj_lite_upsell_notice_dismiss_nonce' ) || ! current_user_can( 'manage_options' ) ) {
				wp_die();
			} // End If Statement
			
			delete_transient( 'conj_lite_dismiss_upsell_notice_flag' );
			set_transient( 'conj_lite_dismiss_upsell_notice_flag', TRUE, WEEK_IN_SECONDS );

		}

	}
endif;
// End Class.

return new Conj_Lite_NUX_Admin();