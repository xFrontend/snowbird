<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Sanitizes checkbox to save in database.
 *
 * @param $value
 *
 * @return int
 */
function snowbird_sanitize_checkbox( $value ) {
	$value = (int) $value;

	return ( 1 === $value || true === $value ) ? 1 : 0;
}


/**
 * Sanitizes checkbox for JavaScript.
 *
 * @param $value
 *
 * @return bool
 */
function snowbird_sanitize_checkbox_js( $value ) {
	$value = (int) $value;

	return ( 1 === $value || true === $value ) ? true : false;
}


/**
 * Sanitizes select field.
 *
 * @param $value
 * @param $field
 *
 * @return mixed|null
 */
function snowbird_sanitize_choice( $value, $field ) {
	$default = null;
	$choices = array();

	if ( is_object( $field ) ) {
		$ID      = $field->id;
		$default = $field->manager->get_setting( $ID )->default;
		$choices = $field->manager->get_control( $ID )->choices;
	} elseif ( is_array( $field ) && isset( $field['control']['choices'] ) ) {
		$default = isset( $field['default'] ) ? $field['default'] : null;
		$choices = $field['control']['choices'];
	}

	return array_key_exists( $value, $choices ) ? $value : $default;
}


/**
 * Sanitizes CSS/JavaScript code.
 *
 * @param $code
 *
 * @return mixed|string
 */
function snowbird_sanitize_css_js( $code ) {
	/**
	 * Code snippet taken from Jetpack_Custom_CSS module
	 */
	$code = preg_replace( '/\\\\([0-9a-fA-F]{4})/', '\\\\\\\\$1', $prev = $code );

	if ( $code != $prev ) {
		return ''; // preg_replace found stuff'
	}

	// Some people put weird stuff in their CSS, KSES tends to be greedy
	$code = str_replace( '<=', '&lt;=', $code );
	// Why KSES instead of strip_tags?  Who knows?
	$code = wp_kses_split( $prev = $code, array(), array() );
	$code = str_replace( '&gt;', '>', $code ); // kses replaces lone '>' with &gt;
	// Why both KSES and strip_tags?  Because we just added some '>'.
	$code = strip_tags( $code );

	if ( $code != $prev ) {
		return ''; // kses found stuff
	}

	return $code;
}


/**
 * Sanitizes an email address.
 *
 * @param $email
 *
 * @return string
 */
function snowbird_sanitize_email( $email ) {
	$email = trim( $email );

	return ! empty( $email ) ? sanitize_email( $email ) : '';
}


/**
 * Sanitizes and converts an email address to link w/ HTML entities to block spam bots.
 *
 * @param $email
 *
 * @return string
 */
function snowbird_sanitize_email_output( $email ) {
	$email = snowbird_sanitize_email( $email );

	return ! empty( $email ) ? antispambot( 'mailto:' . $email ) : '';
}


/**
 * Sanitizes a hex color.
 *
 * @param $color
 *
 * @return null|string
 */
function snowbird_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}


/**
 * Sanitizes a hex color without a hash. Use snowbird_sanitize_hex_color() when possible.
 *
 * @param $color
 *
 * @return null|string
 */
function snowbird_sanitize_hex_color_no_hash( $color ) {
	$color = ltrim( $color, '#' );

	if ( '' === $color ) {
		return '';
	}

	return snowbird_sanitize_hex_color( '#' . $color ) ? $color : null;
}


/**
 * Sanitizes and ensures that any hex color is properly hashed.
 *
 * @param $color
 *
 * @return string
 */
function snowbird_sanitize_maybe_hash_hex_color( $color ) {
	if ( $unhashed = snowbird_sanitize_hex_color_no_hash( $color ) ) {
		return '#' . $unhashed;
	}

	return $color;
}


/**
 * Sanitize content for allowed HTML tags for post content.
 *
 * @param $input
 *
 * @return string
 */
function snowbird_sanitize_html( $input ) {
	return wp_kses_post( balanceTags( $input, true ) );
}
