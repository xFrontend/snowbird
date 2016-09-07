<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;

/**
 * Snowbird back compat functionality
 *
 * Prevents Snowbird from running on WordPress versions prior to 4.5,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.5.
 */


/**
 * Prevents switching to Snowbird on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function snowbird_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'snowbird_upgrade_notice' );
}

add_action( 'after_switch_theme', 'snowbird_switch_theme' );


/**
 * Adds message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Snowbird on WordPress versions prior to 4.5.
 *
 * @global string $wp_version
 */
function snowbird_upgrade_notice() {
	$message = sprintf( esc_html_x( 'Snowbird requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'admin', 'snowbird' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}


/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.5.
 *
 * @global string $wp_version
 */
function snowbird_customize() {
	wp_die( sprintf( esc_html_x( 'Snowbird requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'admin', 'snowbird' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}

add_action( 'load-customize.php', 'snowbird_customize' );


/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.5.
 *
 * @global string $wp_version
 */
function snowbird_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html_x( 'Snowbird requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'admin', 'snowbird' ), $GLOBALS['wp_version'] ) );
	}
}

add_action( 'template_redirect', 'snowbird_preview' );
