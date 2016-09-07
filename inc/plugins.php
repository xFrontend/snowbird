<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;

/**
 * Recommends Plugins for the theme.
 */
function snowbird_recommended_plugins() {

	$plugins = apply_filters( 'snowbird_recommended_plugins', array(
		array(
			'name'    => 'SuperPack',
			'slug'    => 'superpack',
			'version' => '0.3.1',
		),
		array(
			'name' => 'Jetpack by WordPress.com',
			'slug' => 'jetpack',
		),
		array(
			'name' => 'Contact Form 7',
			'slug' => 'contact-form-7',
		),
	) );

	$config = apply_filters( 'snowbird_recommended_plugins_config', array(
		// Default absolute path to pre-packaged plugins.
		'default_path' => '',
		// Menu slug.
		'menu'         => 'install-plugins',
		// Show admin notices or not.
		'has_notices'  => true,
		// If false, a user cannot dismiss the nag message.
		'dismissable'  => true,
		// If 'dismissable' is false, this message will be output at top of nag.
		'dismiss_msg'  => '',
		// Automatically activate plugins after installation or not.
		'is_automatic' => false,
		// Message to output right before the plugins table.
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html_x( 'Install Recommended Plugins', 'admin', 'snowbird' ),
			'menu_title'                      => esc_html_x( 'Install Plugins', 'admin', 'snowbird' ),
			// %s = plugin name.
			'installing'                      => esc_html_x( 'Installing Plugin: %s', 'admin', 'snowbird' ),
			'oops'                            => esc_html_x( 'Something went wrong with the plugin API.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_install_required'     => _nx_noop( 'Current theme requires the following plugin: %1$s.', 'Current Theme requires the following plugins: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_install_recommended'  => _nx_noop( 'Current theme recommends the following plugin: %1$s.', 'Current Theme recommends the following plugins: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_cannot_install'           => _nx_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_activate_required'    => _nx_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_activate_recommended' => _nx_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_cannot_activate'          => _nx_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_ask_to_update'            => _nx_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with current Theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with current Theme: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_cannot_update'            => _nx_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'admin', 'snowbird' ),
			'install_link'                    => _nx_noop( 'Begin installing plugin', 'Begin installing plugins', 'admin', 'snowbird' ),
			'activate_link'                   => _nx_noop( 'Begin activating plugin', 'Begin activating plugins', 'admin', 'snowbird' ),
			'return'                          => esc_html_x( 'Return to Recommended Plugins Installer', 'admin', 'snowbird' ),
			'plugin_activated'                => esc_html_x( 'Plugin activated successfully.', 'admin', 'snowbird' ),
			// %s = dashboard link.
			'complete'                        => esc_html_x( 'All plugins installed and activated successfully. %s', 'admin', 'snowbird' ),
			// Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			'nag_type'                        => 'updated'
		)
	) );

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'snowbird_recommended_plugins' );
