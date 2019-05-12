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
class Conj_Lite_More_Control extends WP_Customize_Control {

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
				esc_html_e( 'CONJ aims to remove all barriers between you and 3rd party plugins by offering all the things that you need to run a successful webshop. Give us a try, and we promise you won’t regret it.', 'conj-lite' ); ?>
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
					printf( esc_html__( '%s Header Customizer', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Modular Mega-Menu', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Gutenberg Blocks', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s +%s Template Blocks', 'conj-lite' ), '✅', '💯' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Two-Steps Checkout', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Product Brands', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Store Vacation', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Attribute Swatches', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Product Quick View', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Distraction Free Checkout', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Product Archive Customizer', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s WPML Compatible', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s Google Analytics Integration', 'conj-lite' ), '✅' ); ?></li>
					<li><?php 
					/* translators: %s: Emoji unicode */
					printf( esc_html__( '%s .....and much more', 'conj-lite' ), '🔥' ); ?></li>
				</ul>
			</p>
			<p>
				<?php
				/* translators: %s: Emoji unicode */
				printf( esc_html__( '%sUpgrade Now %s %s', 'conj-lite' ), '<a href="https://themeforest.net/item/conj-ecommerce-wordpress-theme/21935639?ref=mypreview" class="button button-primary" target="_blank" rel="noopener">', '💰', '</a>' ); ?>
			</p>
			<hr/>
			<span class="customize-control-title">
				<?php
				/* translators: %s: Conj Lite */
				printf( esc_html__( 'Enjoying %s?', 'conj-lite' ), CONJ_LITE_THEME_NAME ); ?>
			</span>
			<p>
				<?php
				/* translators: 1: Emoji unicode, 2: Open anchor tag, 3: Close anchor tag, 4: Br tag. */
				printf( esc_html__( 'Why not leave us a %1$s review on %2$sWordPress.org%3$s?%4$sWe&rsquo;d really appreciate it!', 'conj-lite' ), '⭐⭐⭐⭐⭐', '<a href="https://wordpress.org/support/theme/conj-lite/reviews/#new-post" target="_blank" rel="noopener noreferrer nofollow">', '</a>', '<br/>' ); ?>
			</p>
		</label>
		<?php
		
	}

}