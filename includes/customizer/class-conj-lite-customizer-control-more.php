<?php // @codingStandardsIgnoreLine.
/**
 * Class to create a Customizer control for displaying information
 *
 * @see         http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
 * @since 	    1.1.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

/**
 * The arbitrary control class
 */
final class Conj_Lite_More_Control extends WP_Customize_Control {

	/**
	 * Renter the control
	 *
	 * @access  protected
	 * @return 	void
	 */
	protected function render_content() {

		?>
		<label id="conj-lite-customizer-more-control">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
			<p>
				<?php
				esc_html_e( 'CONJ aims to remove all barriers between you and 3rd party plugins by offering all the things that you need to run a successful webshop. Give us a try, and we promise you won&rsquo;t regret it.', 'conj-lite' ); ?>
			</p>
			<span class="customize-control-title">
				<?php
				/* translators: %1$s: Open Br, small and em tags, Close em and small tags. */
				printf( esc_html__( 'Something missing?%1$sThere&rsquo;s a built-in feature for that!%2$s', 'conj-lite' ), '<br/><small><em>', '</em></small>' ); ?>
			</span>
			<p>	
				<ul>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Header Customizer', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Modular Mega-Menu', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Gutenberg Blocks', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%1$s +%2$s Template Blocks', 'CONJ PRO feature', 'conj-lite' ), '✅', '💯' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Two-Steps Checkout', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Product Brands', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Store Vacation', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Attribute Swatches', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Product Quick View', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Distraction Free Checkout', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Product Archive Customizer', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s WPML Compatible', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s Google Analytics Integration', 'CONJ PRO feature', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html_x( '%s &hellip;&hellip;and much more', 'CONJ PRO feature', 'conj-lite' ), '🔥' ); ?></li>
				</ul>
			</p>
			<p>
				<?php
				/* translators: 1: Open anchor tag, 2: Emoji unicode, 3: Close anchor tag. */
				printf( esc_html__( '%1$sGo Premium %2$s %3$s', 'conj-lite' ), sprintf( '<a href="%s" class="button button-primary" target="_blank" rel="noopener noreferrer">', esc_url( CONJ_LITE_THEME_AUTHOR_URI ) ), '💰', '</a>' ); ?>
			</p>
			<hr/>
			<span class="customize-control-title">
				<?php
				/* translators: %s: Conj Lite */
				printf( esc_html__( 'Enjoying %s?', 'conj-lite' ), esc_html( CONJ_LITE_THEME_NAME ) ); ?>
			</span>
			<p>
				<?php
				/* translators: 1: Emoji unicode, 2: Open anchor tag, 3: Close anchor tag, 4: Br tag. */
				printf( esc_html_( 'Why not leave us a %1$s review on %2$sWordPress.org%3$s?%4$sWe&rsquo;d really appreciate it!', 'conj-lite' ), '⭐⭐⭐⭐⭐', '<a href="https://wordpress.org/support/theme/conj-lite/reviews/#new-post" target="_blank" rel="noopener noreferrer nofollow">', '</a>', '<br/>' ); ?>
			</p>
		</label>
		<?php
		
	}

}