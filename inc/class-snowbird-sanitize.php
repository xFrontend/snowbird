<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;

/**
 * Class Snowbird_Sanitize - Sanitize Helper
 */
class Snowbird_Sanitize {

	public static function checkbox( $value ) {
		$value = (int) $value;

		return ( 1 === $value || true === $value ) ? 1 : 0;
	}

	public static function checkbox_js( $value ) {
		$value = (int) $value;

		return ( 1 === $value || true === $value ) ? true : false;
	}

	public static function choice( $value, $field ) {
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

	public static function email( $email ) {
		$email = trim( $email );

		return ! empty( $email ) ? sanitize_email( $email ) : '';
	}

	public static function email_output( $email ) {
		$email = self::email( $email );

		return ! empty( $email ) ? antispambot( 'mailto:' . $email ) : '';
	}

	//
	// Colors
	//

	/**
	 * Sanitizes a hex color.
	 *
	 * @param $color
	 *
	 * @return null|string
	 */
	public static function hex_color( $color ) {
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
	 * Sanitizes a hex color without a hash. Use hex_color() when possible.
	 *
	 * @param $color
	 *
	 * @return null|string
	 */
	public static function hex_color_no_hash( $color ) {
		$color = ltrim( $color, '#' );

		if ( '' === $color ) {
			return '';
		}

		return self::hex_color( '#' . $color ) ? $color : null;
	}

	/**
	 * Ensures that any hex color is properly hashed.
	 *
	 * @param $color
	 *
	 * @return string
	 */
	public static function maybe_hash_hex_color( $color ) {
		if ( $unhashed = self::hex_color_no_hash( $color ) ) {
			return '#' . $unhashed;
		}

		return $color;
	}

	//
	// Kses/Post Content
	//

	public static function css_js( $code ) {
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

	public static function embed( $html ) {
		// WP's default allowed tags
		global $allowedtags;

		// allow iframe only in this instance
		$iframe = array(
			'iframe' => array(
				'src'             => array(),
				'width'           => array(),
				'height'          => array(),
				'frameborder'     => array(),
				'allowFullScreen' => array(), // add any other attributes you wish to allow
			)
		);

		$allowed_html = array_merge( $allowedtags, $iframe );

		return wp_kses( $html, $allowed_html );
	}

	public static function html( $input ) {
		return wp_kses_post( balanceTags( $input, true ) );
	}

}
