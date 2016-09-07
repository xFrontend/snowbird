<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Registers Controls for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function snowbird_register_customize_controls( $wp_customize ) {

	/**
	 * Class Snowbird_Customize_Control_Misc
	 */
	class Snowbird_Customize_Control_Misc extends WP_Customize_Control {
		public $type = 'misc-line';

		public function render_content() {
			switch ( $this->type ) {
				case 'misc-description' :
					echo '<span class="description customize-control-description">' . $this->description . '</span>';
					break;

				case 'misc-heading-line' :
					echo '<br>';
					echo '<hr>';
					echo '<br>';
					echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
					if ( ! empty( $this->description ) ) {
						echo '<span class="description customize-control-description">' . $this->description . '</span>';
					}

					break;

				case 'misc-heading' :
					echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
					if ( ! empty( $this->description ) ) {
						echo '<span class="description customize-control-description">' . $this->description . '</span>';
					}

					break;

				case 'misc-line' :
				default:
					echo '<br>';
					echo '<hr>';
					break;
			}
		}

	}

}

add_action( 'customize_register', 'snowbird_register_customize_controls' );
