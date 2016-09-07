<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Add theme support for Jetpack Infinite Scroll.
 *
 * @See: https://jetpack.me/support/infinite-scroll/
 */
function snowbird_jetpack_setup() {

	$footer_widgets = snowbird_maybe_display_footer();

	add_theme_support( 'infinite-scroll', array(
		'type'           => ( $footer_widgets ) ? 'click' : 'scroll',
		'footer_widgets' => $footer_widgets,
		'container'      => 'main',
		'render'         => 'snowbird_jetpack_infinite_scroll_render',
	) );
}

add_action( 'after_setup_theme', 'snowbird_jetpack_setup' );


/**
 * Custom render function for Jetpack Infinite Scroll.
 */
function snowbird_jetpack_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();

		/**
		 * Load Posts Content based on Setting.
		 */
		if ( 'alternate' == Snowbird()->mod( 'loop_layout_type' ) ) :
			get_template_part( 'template-parts/content-alternate', get_post_format() );
		else:
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}
