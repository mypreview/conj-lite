<?php
/**
 * Conj Lite Customizer class
 *
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Conj_Lite_Customizer' ) ) :
	/**
	 * The Conj Customizer class
	 */
	final class Conj_Lite_Customizer {

		/**
		 * Setup class.
		 *
		 * @access  public
		 * @return  void
		 */
		public function __construct() {

			add_action( 'customize_register',                    array( $this, 'customize_register' ), 		10, 1 );
            add_action( 'customize_controls_enqueue_scripts',    array( $this, 'panels_enqueue' ),             10 );

		}

		/**
		 * Used to customize and manipulate the Theme Customization admin screen.
		 *
		 * @see  	https://developer.wordpress.org/reference/hooks/customize_register/
		 * @see  	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
		 * @see  	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
		 * @see  	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
		 * @see  	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
		 * @access  public
		 * @param 	WP_Customize_Manager 	$wp_customize 	Theme Customizer object.
		 * @return  void
		 */
		public function customize_register( $wp_customize ) {

            // Load Customizer custom controls.
            require get_parent_theme_file_path( '/includes/customizer/class-conj-lite-customizer-control-more.php' );

			/**
			 * Add the panels
			 * Colors
			 */
			$wp_customize->add_panel( 'conj_lite_colors_pnl', array(
			    'priority' => 30,
			    'capability' => 'edit_theme_options',
			    'title' => esc_html_x( 'Colors', 'panel title', 'conj-lite' ),
			    'description' => esc_html_x( 'This option allows you to choose a color, view color suggestions, refine with the color picker and apply background color changes.', 'panel description', 'conj-lite' )
			) );

			/**
			 * Add the sections
			 * Colors
			 */
			$wp_customize->add_section( 'conj_lite_button_colors_sec', array(
			    'priority' => 20,
			    'capability' => 'edit_theme_options',
			    'title' => esc_html_x( 'Button', 'section title', 'conj-lite' ),
			    'panel' => 'conj_lite_colors_pnl'
			) );

			$wp_customize->add_section( 'conj_lite_layout_sec', array(
			    'priority' => 100,
			    'capability' => 'edit_theme_options',
			    'title' => esc_html_x( 'Layout', 'section title', 'conj-lite' )
			) );

            $wp_customize->add_section( 'conj_lite_more_sec', array(
                'priority' => 9999,
                'capability' => 'edit_theme_options',
                /* translators: %s: Emoji unicode */
                'title' => sprintf( esc_html_x( 'More %s', 'section title', 'conj-lite' ), '⚡' )
            ) );

			/**
			 * Add the controls
			 * Colors
			 */
            $wp_customize->add_setting( 'conj_lite_general_heading_color', array(
            	'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_general_heading_color_default', '#464855' ),
                'sanitize_callback'	=> 'sanitize_hex_color'
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'conj_lite_general_heading_color', array(
                'label' => esc_html_x( 'Heading', 'control label', 'conj-lite' ) ,
                'section' => 'colors',
                'settings' => 'conj_lite_general_heading_color',
                'priority' => 20
            ) ) );

            $wp_customize->add_setting( 'conj_lite_general_text_color', array(
            	'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_general_text_color_default', '#6B6F81' ),
                'sanitize_callback'	=> 'sanitize_hex_color'
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'conj_lite_general_text_color', array(
                'label' => esc_html_x( 'Text', 'control label', 'conj-lite' ) ,
                'section' => 'colors',
                'settings' => 'conj_lite_general_text_color',
                'priority' => 30
            ) ) );

            $wp_customize->add_setting( 'conj_lite_general_link_color', array(
            	'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_general_link_color_default', '#666EE8' ),
                'sanitize_callback'	=> 'sanitize_hex_color'
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'conj_lite_general_link_color', array(
                'label' => esc_html_x( 'Link', 'control label', 'conj-lite' ) ,
                'section' => 'colors',
                'settings' => 'conj_lite_general_link_color',
                'priority' => 40
            ) ) );

            $wp_customize->add_setting( 'conj_lite_general_link_alt_color', array(
            	'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_general_link_alt_color_default', '#414B92' ),
                'sanitize_callback'	=> 'sanitize_hex_color'
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'conj_lite_general_link_alt_color', array(
                'label' => esc_html_x( 'Link', 'control label', 'conj-lite' ) ,
                'description' => esc_html_x( 'Alternate', 'control description', 'conj-lite' ) ,
                'section' => 'colors',
                'settings' => 'conj_lite_general_link_alt_color',
                'priority' => 50
            ) ) );

            $wp_customize->add_setting( 'conj_lite_button_text_color', array(
            	'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_button_text_color_default', '#FFFFFF' ),
                'sanitize_callback'	=> 'sanitize_hex_color'
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'conj_lite_button_text_color', array(
                'label' => esc_html_x( 'Text', 'control label', 'conj-lite' ) ,
                'section' => 'conj_lite_button_colors_sec',
                'settings' => 'conj_lite_button_text_color',
                'priority' => 10
            ) ) );

            $wp_customize->add_setting( 'conj_lite_button_alt_text_color', array(
            	'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_button_alt_text_color_default', '#666EE8' ),
                'sanitize_callback'	=> 'sanitize_hex_color'
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'conj_lite_button_alt_text_color', array(
                'label' => esc_html_x( 'Text', 'control label', 'conj-lite' ) ,
                'description' => esc_html_x( 'Alternate', 'control description', 'conj-lite' ) ,
                'section' => 'conj_lite_button_colors_sec',
                'settings' => 'conj_lite_button_alt_text_color',
                'priority' => 20
            ) ) );

            $wp_customize->add_setting( 'conj_lite_button_background_color', array(
            	'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_button_background_color_default', '#666EE8' ),
                'sanitize_callback'	=> 'sanitize_hex_color'
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'conj_lite_button_background_color', array(
                'label' => esc_html_x( 'Background', 'control label', 'conj-lite' ) ,
                'section' => 'conj_lite_button_colors_sec',
                'settings' => 'conj_lite_button_background_color',
                'priority' => 30
            ) ) );

            /**
			 * Add the controls
			 * Layout
			 */
            $wp_customize->add_setting( 'conj_lite_layout_sidebar', array(
				'type' => 'theme_mod',
            	'transport' => 'refresh',
                'capability' => 'edit_theme_options',
                'default' => apply_filters( 'conj_lite_layout_sidebar_default', 'left-sidebar' ),
                'sanitize_callback'	=> array( $this, 'sanitize_choices' )
            ) );
            $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'conj_lite_layout_sidebar', array(
            	'label' => esc_html_x( 'Sidebar layout', 'control label', 'conj-lite' ) ,
                'type' => 'radio',
                'section' => 'conj_lite_layout_sec',
                'settings' => 'conj_lite_layout_sidebar',
                'choices' => array(
        			'left-sidebar' => esc_html_x( 'Left', 'control choice', 'conj-lite' ),
                    'right-sidebar' => esc_html_x( 'Right', 'control choice', 'conj-lite' )
                ),
                'priority' => 10
            ) ) );

            /**
             * Add the controls
             * More
             */
            $wp_customize->add_setting( 'conj_lite_more', array(
                'type' => 'theme_mod',
                'transport' => 'refresh',
                'sanitize_callback' => 'sanitize_text_field'
            ) );
            $wp_customize->add_control( new Conj_Lite_More_Control( $wp_customize, 'conj_lite_more', array(
                'label' => esc_html_x( 'Looking for more options?', 'control label', 'conj-lite' ) ,
                'section' => 'conj_lite_more_sec',
                'settings' => 'conj_lite_more',
                'priority' => 10
            ) ) );

			// Default controls
			$wp_customize->remove_control( 'display_header_text' );
			$wp_customize->get_section( 'colors' )->panel = 'conj_lite_colors_pnl';
			$wp_customize->get_section( 'colors' )->title = esc_html_x( 'General', 'section title', 'conj-lite' );
			$wp_customize->get_section( 'colors' )->priority = 10;
			$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
			$wp_customize->get_control( 'header_textcolor' )->label = esc_html_x( 'Site title', 'control label', 'conj-lite' );
            $wp_customize->get_control( 'header_textcolor' )->priority = 10;
			$wp_customize->get_control( 'background_color' )->label = esc_html_x( 'Background', 'control label', 'conj-lite' );
            $wp_customize->get_control( 'background_color' )->priority = 70;

			// Selective refresh.
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
				$wp_customize->selective_refresh->add_partial( 'blogname', array(
					'selector' => '.site-title a',
					'render_callback' => function() {
						return get_bloginfo( 'name', 'display' );
					}
				) );
				$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
					'selector' => '.site-description',
					'render_callback' => function() {
						return get_bloginfo( 'description', 'display' );
					}
				) );

			} // End If Statement

		}

        /**
         * Enqueue extra CSS & JavaScript to improve the user experience in the Customizer.
         *
         * @see     https://developer.wordpress.org/reference/functions/wp_enqueue_style/
         * @access  public
         * @return  void
         */
        public function panels_enqueue() {

            wp_enqueue_style( 'conj-lite-panel-customizer-styles', get_theme_file_uri( '/assets/admin/css/panel-customizer.css' ), array(), CONJ_LITE_THEME_VERSION, 'screen' );
            wp_style_add_data( 'conj-lite-panel-customizer-styles', 'rtl', 'replace' );

        }

	    /**
		 * Sanitizes choices (selects / radios)
		 * Checks that the input matches one of the available choices
		 *
		 * @see 	https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
		 * @see 	https://developer.wordpress.org/reference/functions/sanitize_key/
		 * @access  public
		 * @param  	array 	$input 		the available choices.
		 * @param  	array 	$setting 	the setting object.
		 * @return 	string.
		 */
		public function sanitize_choices( $input, $setting ) {

			// Ensure input is a slug.
			$input = sanitize_key( $input );
			// Get list of choices from the control associated with the setting.
			$choices = $setting->manager->get_control( $setting->id )->choices;
			// If the input is a valid key, return it; otherwise, return the default.
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

		}

	}
endif;
// End Class.

return new Conj_Lite_Customizer();