<?php
/**
 * Conj Lite admin NUX
 *
 * @since 	    1.2.0
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
	final class Conj_Lite_NUX_Admin {

		/**
		 * Setup class.
		 *
		 * @access 	public
		 * @return void
		 */
		public function __construct() {

			add_action( 'admin_notices', 	  							array( $this, 'upsell_notice' ), 	     	 	 1 );
			add_action( 'switch_theme', 	  							array( $this, 'switch_theme' ), 				10 );
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

			// Bail out, if the notice already dismissed by the user.
			if ( get_transient( 'conj_lite_dismiss_upsell_flag' ) ) {
				return;
			} // End If Statement

			?>
			<div class="notice notice-warning notice-alt notice-large is-dismissible conj-lite-upsell">
				<span class="notice__icon"></span>
				<div class="notice__content">
					<h2><?php _ex( '', 'upsell notice heading', 'conj-lite' ); ?></h2>
					<p><?php _ex( '', 'upsell notice content', 'conj-lite' ); ?></p>
					<div class="notice_btns"><?php
						/* translators: 1: Open anchor tag, 2: Close anchor tag. */
						printf( esc_html__( '%1$sOpen Customizer %2$s', 'conj-lite' ), sprintf( '<a href="%s" class="button button-secondary">', esc_url( add_query_arg( 'return', admin_url( 'themes.php' ), admin_url( 'customize.php' ) ) ) ), '</a>' );
						?><span><?php _ex( 'OR', 'upsell notice content', 'conj-lite' ); ?></span><?php
						/* translators: 1: Open anchor tag, 2: Emoji unicode, 3: Close anchor tag. */
						printf( esc_html__( '%1$sGo Premium %2$s %3$s', 'conj-lite' ), sprintf( '<a href="%s" class="button button-primary" target="_blank" rel="noopener noreferrer">', esc_url( CONJ_LITE_THEME_AUTHOR_URI ) ), '💰', '</a>' );
					?></div>
				</div>
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

			delete_transient( 'conj_lite_dismiss_upsell_flag' );

		}

		/**
		 * AJAX dismiss up-sell admin notice.
		 * 
		 * @see 	https://developer.wordpress.org/reference/functions/set_transient/
		 * @see 	https://developer.wordpress.org/reference/functions/check_ajax_referer/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_die/
		 * @link 	https://wordpress.stackexchange.com/questions/242705/how-to-stop-showing-admin-notice-after-close-button-has-been-clicked
		 * @access 	public
		 * @return 	void
		 */
		public function dismiss_upsell_notice() {

			check_ajax_referer( 'conj-lite-upsell-dismiss-nonce' );
			set_transient( 'conj_lite_dismiss_upsell_flag', TRUE, DAY_IN_SECONDS );
			wp_die();

		}

	}
endif;
// End Class.

return new Conj_Lite_NUX_Admin();