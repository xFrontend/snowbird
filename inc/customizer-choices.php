<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Options for Footer Menu Location.
 *
 * @return mixed|void
 */
function snowbird_choices_footer_menu_location() {
	return apply_filters( 'snowbird_choices_footer_menu_location', array(
		'secondary' => esc_html_x( 'Secondary', 'admin', 'snowbird' ),
		'social'    => esc_html_x( 'Social', 'admin', 'snowbird' ),
	) );
}


/**
 * Options for Footer Widget Area.
 *
 * @return mixed|void
 */
function snowbird_choices_footer_widget_area() {
	return apply_filters( 'snowbird_choices_footer_widget_area', array(
		'off'        => esc_html_x( 'Disable', 'admin', 'snowbird' ),
		'one'        => esc_html_x( 'One', 'admin', 'snowbird' ),
		'one-half'   => esc_html_x( 'Two', 'admin', 'snowbird' ),
		'one-third'  => esc_html_x( 'Three', 'admin', 'snowbird' ),
		'one-fourth' => esc_html_x( 'Four', 'admin', 'snowbird' ),
	) );
}


/**
 * Options for Loop Content.
 *
 * @return mixed|void
 */
function snowbird_choices_loop_content() {
	return apply_filters( 'snowbird_choices_loop_content', array(
		'full'    => esc_html_x( 'Full', 'admin', 'snowbird' ),
		'excerpt' => esc_html_x( 'Excerpt', 'admin', 'snowbird' ),
		'none'    => esc_html_x( 'None', 'admin', 'snowbird' ),
	) );
}


/**
 * Options for Loop Excerpt Length.
 *
 * @return mixed|void
 */
function snowbird_choices_loop_excerpt_length() {
	return apply_filters( 'snowbird_choices_loop_excerpt_length', array(
		'min'  => 20,
		'max'  => 200,
		'step' => 1,
	) );
}


/**
 * Options for Loop Layout Type.
 *
 * @return mixed|void
 */
function snowbird_choices_loop_layout_type() {
	return apply_filters( 'snowbird_choices_loop_layout_type', array(
		'default'   => esc_html_x( 'Default', 'admin', 'snowbird' ),
		'alternate' => esc_html_x( 'Alternate', 'admin', 'snowbird' ),
	) );
}


/**
 * Options for Opacity.
 *
 * @return mixed|void
 */
function snowbird_choices_opacity() {
	return apply_filters( 'snowbird_choices_opacity', array(
		'min'  => 1,
		'max'  => 100,
		'step' => 1,
	) );
}


/**
 * Options for Post Layout Type.
 *
 * @return mixed|void
 */
function snowbird_choices_post_layout_type() {
	return apply_filters( 'snowbird_choices_post_layout_type', array(
		'default'   => esc_html_x( 'Default', 'admin', 'snowbird' ),
		'alternate' => esc_html_x( 'Alternate', 'admin', 'snowbird' ),
	) );
}


/**
 * Options for Posts per Page.
 *
 * @return mixed|void
 */
function snowbird_choices_posts_per_page() {
	return apply_filters( 'snowbird_choices_posts_per_page', array(
		'min'  => 2,
		'max'  => 20,
		'step' => 1,
	) );
}


/**
 * Options for Sidebar Type.
 *
 * @return mixed|void
 */
function snowbird_choices_sidebar_type() {
	return apply_filters( 'snowbird_choices_sidebar_type', array(
		'left'  => esc_html_x( 'Left', 'admin', 'snowbird' ),
		'right' => esc_html_x( 'Right', 'admin', 'snowbird' ),
	) );
}
