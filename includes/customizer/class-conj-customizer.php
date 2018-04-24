<?php
/**
 * Conj Customizer class
 *
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'MyPreview_Conj_Lite_Customizer' ) ) :
	/**
	 * The Conj Lite Customizer class
	 */
	class MyPreview_Conj_Lite_Customizer {
		/**
		 * Setup class.
		 *
		 * @return  void
		 */
		public function __construct() {

			add_action( 'customize_register',      					array( $this, 'customize_register' ), 	20, 1 );
			add_action( 'customize_controls_enqueue_scripts',   	array( $this, 'panels_enqueue' ), 		    0 );

		}

		/**
		 * Theme Customizer along with several other settings.
		 *
		 * @link  https://developer.wordpress.org/reference/hooks/customize_register/
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_register( $wp_customize ) {

			// Load Customizer custom controls.
			require get_parent_theme_file_path( '/includes/customizer/class-conj-customizer-conj-pro.php' );

			// Register custom section types.
			$wp_customize->register_section_type( 'MyPreview_Conj_Lite_Customizer_CONJ_PRO_Control' );
			// Register sections.
			$wp_customize->add_section(
				new MyPreview_Conj_Lite_Customizer_CONJ_PRO_Control(
					$wp_customize,
					'mypreview_conj_lite_get_premium_sec',
					array(
						'title'    	=> 	esc_html__( 'CONJ PRO', 'conj-lite' ),
						'pro_text' 	=> 	esc_html__( 'GO PREMIUM', 'conj-lite' ),
						'pro_url'  	=> 	esc_url( MYPREVIEW_CONJ_LITE_THEME_URI )
					)
				)
			);

		}

		/**
		 * Enqueue extra CSS & JavaScript to improve the user experience in the Customizer.
		 *
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
		 * @see 	https://developer.wordpress.org/reference/functions/wp_localize_script/
		 * @return 	void
		 */
		public function panels_enqueue() {

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'mypreview-conj-lite-panel-customizer-styles', get_theme_file_uri( '/assets/admin/css/panel-customizer' . $suffix . '.css' ), array(), MYPREVIEW_CONJ_LITE_THEME_VERSION );

			wp_enqueue_script( 'mypreview-conj-lite-panel-customizer-scripts', get_theme_file_uri( '/assets/admin/js/panel-customizer.js' ), array( 'jquery', 'customize-controls' ), MYPREVIEW_CONJ_LITE_THEME_VERSION, TRUE );

		}

	}

endif;

// End Class.
return new MyPreview_Conj_Lite_Customizer();