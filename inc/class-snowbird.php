<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;

if ( ! class_exists( 'Snowbird' ) ) :

	/**
	 * Core Class for the theme.
	 *
	 * Helper functions to handle Theme Options/Mods/Cache.
	 */
	final class Snowbird {
		protected static $instance = null;

		public static function instance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function __construct() {
		}

		/**
		 * Returns Default Mods for the theme.
		 *
		 * @return array
		 */
		public function mods() {
			$color_scheme = snowbird_get_color_scheme();

			return apply_filters( 'snowbird_default_mods', array(
				/**
				 * Theme Settings
				 */
				'site_sidebar_type'           => 'left',
				// since v1.2
				'site_display_search'         => 1,
				/**
				 * Loop - Posts Listing
				 */
				// since v1.2
				'loop_layout_type'            => 'default',
				'loop_content'                => 'full',
				'loop_excerpt_length'         => 55,
				/**
				 * Post (Single)
				 */
				// since v1.2
				'post_layout_type'            => 'default',
				// since v1.2
				'post_full_content_width'     => 0,
				'post_display_author_bio'     => 1,
				'post_display_share_this'     => 1,
				'post_display_navigation'     => 1,
				'post_display_related'        => 1,
				/**
				 * Page
				 */
				// since v1.2
				'page_full_content_width'     => 0,
				'page_display_share_this'     => 0,
				/**
				 * Footer
				 */
				'footer_widget_area'          => 'one-third',
				'footer_menu_location'        => 'social',
				/**
				 * Scheme
				 */
				'color_scheme'                => 'default',
				/**
				 * Colors - Header
				 */
				'header_text_color'           => $color_scheme['header_text_color'],
				'header_background_color'     => $color_scheme['header_background_color'],
				/**
				 * Colors - Content
				 */
				'content_title_color'         => $color_scheme['content_title_color'],
				'content_text_color'          => $color_scheme['content_text_color'],
				'content_alt_text_color'      => $color_scheme['content_alt_text_color'],
				'content_accent_color'        => $color_scheme['content_accent_color'],
				'content_background_color'    => $color_scheme['content_background_color'],
				/**
				 * Colors - Footer
				 */
				'footer_title_color'          => $color_scheme['footer_title_color'],
				'footer_text_color'           => $color_scheme['footer_text_color'],
				'footer_alt_text_color'       => $color_scheme['footer_alt_text_color'],
				'footer_accent_color'         => $color_scheme['footer_accent_color'],
				'footer_background_color'     => $color_scheme['footer_background_color'],
				/**
				 * Colors - Button
				 */
				'button_text_color'           => $color_scheme['button_text_color'],
				'button_background_color'     => $color_scheme['button_background_color'],
				/**
				 * Header Image
				 */
				'header_overlay_color'        => '#000000',
				'header_overlay_opacity'      => 30,
			) );
		}

		/**
		 * Returns Default Options for the theme.
		 *
		 * @return mixed|null|void
		 */
		public function options() {

			return apply_filters( 'snowbird_default_options', array(
				'custom_css'  => '',
			) );
		}

		/**
		 * Returns Default Theme Mod value.
		 *
		 * @param $name
		 *
		 * @return mixed|null|void
		 */
		public function mod_default( $name ) {
			$def = self::mods();


			if ( isset( $def[ $name ] ) ) {
				return apply_filters( "snowbird_theme_mod_{$name}", $def[ $name ] );
			}

			return null;
		}

		/**
		 * Returns Theme Setting value. Wrapper function for get_theme_mod.
		 *
		 * @param $name
		 * @param bool|false $default
		 *
		 * @return mixed|string|void
		 */
		public function mod( $name, $default = false ) {
			// Look into WordPress
			if ( false !== get_theme_mod( $name ) ) {
				return get_theme_mod( $name );
			}

			// Look into Theme Defaults
			$def = self::mods();

			if ( isset( $def[ $name ] ) ) {
				return apply_filters( "snowbird_theme_mod_{$name}", $def[ $name ] );
			}

			unset( $def );

			return apply_filters( "snowbird_theme_mod_{$name}", $default );
		}

		/**
		 * Returns Default Theme Option value.
		 *
		 * @param $name
		 *
		 * @return mixed|null|void
		 */
		public function option_default( $name ) {
			$def = self::options();

			if ( isset( $def[ $name ] ) ) {
				return apply_filters( "snowbird_option_{$name}", $def[ $name ] );
			}

			return null;
		}

		/**
		 * Returns Theme Option Key.
		 *
		 * @return string
		 */
		public function option_key( $name = null ) {
			$codename = self::codename( 'settings' );

			return ! is_null( $name ) ? $codename . '[' . sanitize_title_with_dashes( $name ) . ']' : $codename;
		}

		/**
		 * Returns Theme Option value. Wrapper function for get_option.
		 *
		 * @param $name
		 * @param bool|false $default
		 *
		 * @return mixed|void
		 */
		public function option( $name, $default = false ) {

			$options = get_option( self::option_key() );

			if ( isset( $options[ $name ] ) ) {
				return $options[ $name ];
			}

			// Look into Theme Defaults
			$def = self::options();

			if ( isset( $def[ $name ] ) ) {
				return apply_filters( "snowbird_option_{$name}", $def[ $name ] );
			}

			unset( $def );

			return apply_filters( "snowbird_option_{$name}", $default );
		}

		/**
		 * Returns Theme Name. Helper function to generate handler/setting name.
		 *
		 * @param null $key
		 *
		 * @return string
		 */
		public function codename( $key = null ) {
			if ( wp_get_theme()->parent() ) {
				$codename = wp_get_theme()->parent()->get( 'Name' );
			} else {
				$codename = wp_get_theme()->get( 'Name' );
			}

			$codename = sanitize_title_with_dashes( $codename );

			return ! is_null( $key ) ? $codename . '-' . sanitize_title_with_dashes( $key ) : $codename;
		}

		/**
		 * Returns Theme Version.
		 *
		 * @return string
		 */
		public function version() {
			return wp_get_theme()->get( 'Version' );
		}

		/**
		 * Helper function to prepare name for generating cache.
		 *
		 * @param $group
		 * @param $key
		 *
		 * @return string
		 */
		public function cache_key( $group, $key ) {
			return substr( self::codename(), 0, 6 ) . '-' . substr( $group, 0, 4 ) . '-' . md5( self::version() . $key );
		}

		/**
		 * Helper function to prepare group name for cache.
		 *
		 * @return string
		 */
		public function cache_group() {
			return self::codename() . '-' . self::version();
		}

		/**
		 * Helper function for converting Opacity to float.
		 *
		 * @param $value
		 *
		 * @return float|mixed
		 */
		public function css_opacity( $value ) {
			$value = intval( $value );
			$value = min( $value, 100 );

			return 0 < $value ? ( $value / 100 ) : $value;
		}

		/**
		 * Helper function for Schema less URL.
		 *
		 * @param $url
		 *
		 * @return string
		 */
		public function protocol( $url ) {
			$url = str_replace( array( 'http://', 'https://' ), '//', $url );

			return esc_url( $url );
		}

		/**
		 * Helper function to convert Colors.
		 *
		 * @param $color
		 *
		 * @return array
		 */
		public function hex_to_rgb( $color ) {
			$color = trim( $color, '#' );

			if ( 3 == strlen( $color ) ) {
				$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
				$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
				$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
			} else if ( 6 == strlen( $color ) ) {
				$r = hexdec( substr( $color, 0, 2 ) );
				$g = hexdec( substr( $color, 2, 2 ) );
				$b = hexdec( substr( $color, 4, 2 ) );
			} else {
				return array();
			}

			return array( 'red' => $r, 'green' => $g, 'blue' => $b );
		}

		/**
		 * Helper function for CSS RGBA values.
		 *
		 * @param $color
		 * @param $opacity
		 *
		 * @return string|void
		 */
		public function rgba( $color, $opacity ) {
			$array = self::hex_to_rgb( $color );
			$alpha = self::css_opacity( $opacity );

			if ( empty ( $array ) ) {
				return;
			}

			$array['opacity'] = $alpha;

			return vsprintf( 'rgba( %1$s, %2$s, %3$s, %4$1.2f)', $array );
		}

		/**
		 * Helper function to Get image data based on image url.
		 *
		 * @param $url
		 * @param string $size
		 *
		 * @return array|string
		 */
		public function url_to_image_data( $url, $size = 'full' ) {
			$data = '';

			if ( $id = attachment_url_to_postid( $url ) ) {
				$thumb = wp_get_attachment_image_src( $id, $size );

				if ( $thumb ) {

					$data = array(
						'id'     => absint( $id ),
						'url'    => esc_url_raw( $thumb[0] ),
						'width'  => absint( $thumb[1] ),
						'height' => absint( $thumb[2] )
					);

				}

				unset( $thumb );
				unset( $id );
			}

			return $data;
		}

		/**
		 * Helper function to Identify Browser/OS.
		 *
		 * @param $query
		 *
		 * @return bool
		 */
		public function current_agent( $query ) {
			if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
				return false;
			}

			preg_match( "/iPhone|iPad|iPod|Android|webOS|Safari|Chrome|Firefox|Opera|MSIE/", $_SERVER['HTTP_USER_AGENT'], $matches );

			$_agent = null;
			$agent  = current( $matches );

			switch ( $agent ) {
				case 'iPhone':
				case 'iPad':
				case 'iPod':
					$_agent = 'iOS';
					break;
				case 'MSIE':
					$_agent = 'IE';
					break;
			}

			switch ( $agent ) {
				case 'iPhone':
				case 'iPad':
				case 'iPod':
				case 'Android':
				case 'webOS':
				case 'Safari':
				case 'Chrome':
				case 'Firefox':
				case 'Opera':
					break;
			}

			return ( strtolower( $query ) == strtolower( $_agent ) || strtolower( $query ) == strtolower( $agent ) );
		}

		/**
		 * Helper function to Identify WooCommerce.
		 *
		 * @return bool
		 */
		public function woo_commerce_is_active() {
			if ( ! class_exists( 'WC', false ) ) {
				return false;
			}

			return true;
		}

		//
		// Debug Helpers
		//

		public function esc_array( &$item, $key ) {
			$item = is_string( $item ) ? esc_html( $item ) : $item;
		}

		public function print_pre( $var, $esc = true ) {
			if ( $esc && is_array( $var ) ) {
				array_walk_recursive( $var, array( __CLASS__, 'esc_array' ) );
			} elseif ( $esc && is_string( $var ) ) {
				$var = esc_html( $var );
			}

			print '<pre class="alignleft">';
			print_r( $var );
			print '</pre>';
		}

		public function print_dump( $var, $esc = true ) {
			if ( $esc && is_array( $var ) ) {
				array_walk_recursive( $var, array( __CLASS__, 'esc_array' ) );
			} elseif ( $esc && is_string( $var ) ) {
				$var = esc_html( $var );
			}

			print '<pre class="alignleft">';
			var_dump( $var );
			print '</pre>';
		}
	}

endif;


/**
 * Returns the main instance of Snowbird Core Class.
 *
 * @return Snowbird instance.
 */
function Snowbird() {
	return Snowbird::instance();
}

Snowbird();
