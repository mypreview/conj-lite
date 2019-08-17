<?php
/**
 * This file represents of the code that Conj Lite theme 
 * would use to register the required plugins.
 *
 * @link 		http://tgmpluginactivation.com/configuration/ for detailed documentation.
 * @link       	https://github.com/TGMPA/TGM-Plugin-Activation
 * @since 	    1.2.0
 * @package 	conj-lite
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Conj_Lite_NUX_TGMPA_Register' ) ) :

	/**
	 * The TGMPA Register class
	 */
	final class Conj_Lite_NUX_TGMPA_Register {

		/**
		 * Setup class.
		 *
		 * @access  public
		 * @return  void
		 */
		public function __construct() {

			add_action( 'tgmpa_register',     	array( $this, 'tgmpa_register' ),           10 );

		}

		/**
		 * Registers the required plugins to be installed with Conj theme.
		 *
		 * @access  public
		 * @return  void
		 */
		public function tgmpa_register() {

			$plugins = apply_filters( 'conj_lite_register_tgmpa_plugin_args', array(
				array(
					'name' => 'WooCommerce',
					'slug' => 'woocommerce',
					'version' => '3.0.0'
				),
				array(
					'name' => 'One Click Demo Import',
					'slug' => 'one-click-demo-import'
				)
			) );

			/*
			 * Array of configuration settings. Amend each line as needed.
			 */
			$config = array(
				'id' => 'conj-lite',                 	
				'default_path' => '',                      
				'menu' => 'tgmpa-install-plugins', 
				'has_notices' => TRUE,                    
				'dismissable' => TRUE,                   
				'dismiss_msg' => '',                      
				'is_automatic' => FALSE,                   
				'message' => '',                 
				/*
				'strings' => array(
					'page_title' => __( 'Install Required Plugins', 'conj-lite' ),
					'menu_title' => __( 'Install Plugins', 'conj-lite' ),
					/* translators: %s: plugin name. * /
					'installing' => __( 'Installing Plugin: %s', 'conj-lite' ),
					/* translators: %s: plugin name. * /
					'updating' => __( 'Updating Plugin: %s', 'conj-lite' ),
					'oops' => __( 'Something went wrong with the plugin API.', 'conj-lite' ),
					'notice_can_install_required' => _n_noop(
						/* translators: 1: plugin name(s). * /
						'This theme requires the following plugin: %1$s.',
						'This theme requires the following plugins: %1$s.',
						'conj-lite'
					),
					'notice_can_install_recommended'  => _n_noop(
						/* translators: 1: plugin name(s). * /
						'This theme recommends the following plugin: %1$s.',
						'This theme recommends the following plugins: %1$s.',
						'conj-lite'
					),
					'notice_ask_to_update' => _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
						'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
						'conj-lite'
					),
					'notice_ask_to_update_maybe' => _n_noop(
						/* translators: 1: plugin name(s). * /
						'There is an update available for: %1$s.',
						'There are updates available for the following plugins: %1$s.',
						'conj-lite'
					),
					'notice_can_activate_required' => _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following required plugin is currently inactive: %1$s.',
						'The following required plugins are currently inactive: %1$s.',
						'conj-lite'
					),
					'notice_can_activate_recommended' => _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following recommended plugin is currently inactive: %1$s.',
						'The following recommended plugins are currently inactive: %1$s.',
						'conj-lite'
					),
					'install_link' => _n_noop(
						'Begin installing plugin',
						'Begin installing plugins',
						'conj-lite'
					),
					'update_link' => _n_noop(
						'Begin updating plugin',
						'Begin updating plugins',
						'conj-lite'
					),
					'activate_link' => _n_noop(
						'Begin activating plugin',
						'Begin activating plugins',
						'conj-lite'
					),
					'return' => __( 'Return to Required Plugins Installer', 'conj-lite' ),
					'plugin_activated' => __( 'Plugin activated successfully.', 'conj-lite' ),
					'activated_successfully' => __( 'The following plugin was activated successfully:', 'conj-lite' ),
					/* translators: 1: plugin name. * /
					'plugin_already_active' => __( 'No action taken. Plugin %1$s was already active.', 'conj-lite' ),
					/* translators: 1: plugin name. * /
					'plugin_needs_higher_version' => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'conj-lite' ),
					/* translators: 1: dashboard link. * /
					'complete' => __( 'All plugins installed and activated successfully. %1$s', 'conj-lite' ),
					'dismiss' => __( 'Dismiss this notice', 'conj-lite' ),
					'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'conj-lite' ),
					'contact_admin' => __( 'Please contact the administrator of this site for help.', 'conj-lite' ),

					'nag_type' => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
				),
				*/
			);

			tgmpa( $plugins, $config );

		}

	}

endif;
// End Class.

return new Conj_Lite_NUX_TGMPA_Register();