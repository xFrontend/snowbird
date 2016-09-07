<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Action/Filters and Custom functions that act independently.
 */


/**
 * Displays Header Meta markups for the theme.
 *
 * @see wp_head()
 */
function snowbird_header_meta() {
	echo '<meta charset="' . esc_attr( get_bloginfo( 'charset' ) ) . '">' . "\n";
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . "\n";

	if ( has_action( 'snowbird_head_meta' ) ) {
		do_action( 'snowbird_head_meta' );
	}
}

add_action( 'wp_head', 'snowbird_header_meta', 0 );


/**
 * Displays Header Link markups for the theme.
 *
 * @see wp_head()
 */
function snowbird_header_link() {
	echo '<link rel="profile" href="http://gmpg.org/xfn/11" >' . "\n";

	if ( is_singular() && pings_open( get_queried_object() ) ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";
	}

	if ( has_action( 'snowbird_head_link' ) ) {
		do_action( 'snowbird_head_link' );
	}
}

add_action( 'wp_head', 'snowbird_header_link', 1 );


/**
 * Adds a header to Force IE Edge.
 *
 * @param $headers
 *
 * @return mixed
 */
function snowbird_add_ie_header( $headers ) {
	if ( Snowbird()->current_agent( 'IE' ) ) {
		$headers['X-UA-Compatible'] = 'IE=edge,chrome=1';
	}

	return $headers;
}

add_filter( 'wp_headers', 'snowbird_add_ie_header' );


/**
 * Adds classes for the TinyMCE Editor
 */
function snowbird_editor_settings( $settings ) {
	$settings['body_class'] .= ' xf__entry xf__singular entry-content';

	return $settings;
}

add_filter( 'tiny_mce_before_init', 'snowbird_editor_settings' );


/**
 * Returns Body Classes.
 *
 * @param $classes
 *
 * @return array
 */
function snowbird_body_classes( $classes ) {
	if ( is_404() ) {
		$classes[] = 'page';
	}

	$classes[] = 'scheme-' . Snowbird()->mod( 'color_scheme' );

	if ( is_single() && 'alternate' == Snowbird()->mod( 'post_layout_type' ) ) {
		$classes[] = 'layout-single-alt';
	}
	if ( ! is_singular() && 'alternate' == Snowbird()->mod( 'loop_layout_type' ) ) {
		$classes[] = 'layout-alt';
	}

	if ( is_single() && false != apply_filters( 'snowbird_single_full_content_width', Snowbird()->mod( 'post_full_content_width' ) ) ) {
		$classes[] = 'full-content-width';
	} elseif ( is_page() && false != apply_filters( 'snowbird_page_full_content_width', Snowbird()->mod( 'page_full_content_width' ) ) ) {
		$classes[] = 'full-content-width';
	}

	if ( 'right' === Snowbird()->mod( 'site_sidebar_type' ) ) {
		$classes[] = 'content-sidebar';
	} else {
		$classes[] = 'sidebar-content';
	}

	/**
	 * To disable Lightbox (Magnific-Popup) add the following line in a child theme
	 * into functions.php
	 *
	 * add_filter( 'snowbird_display_popup', '__return_false' );
	 */
	if ( apply_filters( 'snowbird_display_popup', true ) ) {
		$classes[] = 'snowbird-popup';
	}

	return apply_filters( 'snowbird_body_classes', array_map( 'esc_attr', $classes ) );
}

add_filter( 'body_class', 'snowbird_body_classes' );


/**
 * Returns Post Classes.
 *
 * @param $classes
 *
 * @return array
 */
function snowbird_post_classes( $classes ) {
	$classes[] = 'xf__entry';

	if ( is_singular( 'post' ) && Snowbird()->mod( 'post_display_author_bio' ) ) {
		$classes[] = 'has-author-bio';
	}

	if ( is_single() && false == apply_filters( 'snowbird_single_full_content_width', Snowbird()->mod( 'post_full_content_width' ) ) ) {
		$classes[] = 'xf__singular';
	} elseif ( is_page() && false == apply_filters( 'snowbird_page_full_content_width', Snowbird()->mod( 'page_full_content_width' ) ) ) {
		$classes[] = 'xf__singular';
	} elseif ( is_singular( array( 'post', 'page' ) ) ) {
		$classes[] = 'xf__singular-full';
	}

	return apply_filters( 'snowbird_post_classes', array_map( 'esc_attr', $classes ) );
}

add_filter( 'post_class', 'snowbird_post_classes' );


/**
 * Returns Read More Button markup for Post Content.
 *
 * @param $more
 *
 * @return string
 */
function snowbird_filter_content_more_link() {
	$read_more_button = '<a class="xf__more xf__button" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'snowbird' ) . '</a>';

	return apply_filters( 'snowbird_filter_content_more_link', '<p><span class="xf__dots">...</span>' . $read_more_button . '</p>' );
}

add_filter( 'the_content_more_link', 'snowbird_filter_content_more_link' );


/**
 * Returns Read More Button markup for Post Excerpt.
 *
 * @return string
 */
function snowbird_filter_excerpt_more() {
	$read_more_button = '<a class="xf__more xf__button" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'snowbird' ) . '</a>';

	return apply_filters( 'snowbird_filter_excerpt_more', '<p><span class="xf__dots">...</span>' . $read_more_button . '</p>' );
}

add_filter( 'excerpt_more', 'snowbird_filter_excerpt_more' );


/**
 * Returns Post Excerpt Length based on Setting.
 *
 * @param $length
 *
 * @return int
 */
function snowbird_filter_excerpt_length( $length ) {
	return Snowbird()->mod( 'loop_excerpt_length' ) ? (int) Snowbird()->mod( 'loop_excerpt_length' ) : $length;
}

add_filter( 'excerpt_length', 'snowbird_filter_excerpt_length', 999 );


/**
 * Returns Search Form markup. Ensures proper ID of the form html.
 *
 * @return string
 */
function snowbird_filter_get_search_form() {
	static $_id_number = 0;
	$_id_number ++;

	return apply_filters( 'snowbird_filter_get_search_form', sprintf(
		'<form id="%1$s" class="xf__search" method="get" action="%3$s" >
			<h3 class="screen-reader-text"><label for="%2$s">%4$s</label></h3>
			<input type="text" placeholder="%5$s" value="%6$s" name="s" id="%2$s" >
			<button type="submit"><span class="fa fa-search"></span></button>
		</form>',
		'search-' . $_id_number,    // form-id
		's-' . $_id_number,         // input-id
		esc_url( home_url( '/' ) ),
		esc_html__( 'Search for:', 'snowbird' ),
		esc_attr__( 'Search...', 'snowbird' ),
		get_search_query()
	) );
}

add_filter( 'get_search_form', 'snowbird_filter_get_search_form' );


/**
 * Cleanups for html5 Validation of oEmbed markup.
 *
 * @param $html
 *
 * @return string
 */
function snowbird_oembed_dataparse( $html ) {
	// Proper html5 attributes
	$html = str_ireplace( array(
		'allowfullscreen="true"',
		"allowfullscreen='true'",
	),
		'allowfullscreen',
		$html
	);

	$html = str_ireplace( array(
		'scrolling="no"',
		"scrolling='no'",
		'frameborder="no"',
		"frameborder='no'",
		'frameborder="0"',
		"frameborder='0'",
		'webkitallowfullscreen',
		'mozallowfullscreen',
		'type="text/html"',
		"type='text/html'",
	),
		'',
		$html
	);

	// Properly encode ambiguous ampersand
	$html = str_ireplace( '&#38;', '&amp;', $html );
	$html = str_ireplace( '&#038;', '&amp;', $html );
	$html = str_ireplace( '&#x26;', '&amp;', $html );
	$html = preg_replace( '/&(?![0-9a-zA-Z]+;)/', '&amp;', $html );

	return apply_filters( 'snowbird_oembed_dataparse', $html );
}

add_filter( 'oembed_dataparse', 'snowbird_oembed_dataparse' );
add_filter( 'video_embed_html', 'snowbird_oembed_dataparse' );


/**
 * Wraps embed html for proper styling.
 *
 * @param $html
 *
 * @return mixed|void
 */
function snowbird_embed_html_wrapper( $html ) {
	return apply_filters( 'snowbird_embed_html_wrapper', '<div class="embed-wrappar">' . $html . '</div>', $html );
}

add_filter( 'oembed_dataparse', 'snowbird_embed_html_wrapper', 11 );
add_filter( 'video_embed_html', 'snowbird_embed_html_wrapper', 11 );


/**
 * Sets up paginated links markup template.
 *
 * @return string
 */
function snowbird_navigation_markup_template( $template, $class ) {

	if ( 'pagination' == $class ) {
		$template = '
		<nav class="xf__nav-pagination %1$s" role="navigation">
			<h2 class="screen-reader-text">%2$s</h2>
			<div class="xf__container">
				<div class="nav-links">%3$s</div>
			</div>
		</nav>';
	}

	/**
	 * Filters the navigation markup template.
	 *
	 * Note: The filtered template HTML must contain specifiers for the navigation
	 * class (%1$s), the screen-reader-text value (%2$s), and placement of the
	 * navigation links (%3$s):
	 *
	 *     <nav class="navigation %1$s" role="navigation">
	 *         <h2 class="screen-reader-text">%2$s</h2>
	 *         <div class="nav-links">%3$s</div>
	 *     </nav>
	 *
	 * @param string $template The default template.
	 * @param string $class    The class passed by the calling function.
	 * @return string Navigation template.
	 */
	$template = apply_filters( 'snowbird_navigation_markup_template', $template, $class );

	return $template;
}

add_filter( 'navigation_markup_template', 'snowbird_navigation_markup_template', 10, 2 );


/**
 * Updates old snowbird logo data to WordPress core custom-logo feature.
 *
 * @todo: Remove the procedure in a future release.
 */
function snowbird_logo_data_update() {

	/**
	 * Bail early if we're not in Admin, or current user does not have proper permission.
	 */
	if ( ! is_admin() || ! current_user_can( 'edit_theme_options') ) {
		return;
	}

	$the_key = Snowbird()->codename( 'update_logo_data' );

	/**
	 * Bail if we've done it before.
	 */
	if ( get_option( $the_key ) ) {
		return;
	}

	$logo_data = Snowbird()->url_to_image_data( Snowbird()->mod( 'logo_image' ) );

	if ( '' !== $logo_data ) {
		/**
		 * Sets custom-logo data.
		 */
		set_theme_mod( 'custom_logo', $logo_data['id'] );

		/**
		 * Removes old data.
		 */
		remove_theme_mod( 'logo_image' );
		remove_theme_mod( 'logo_image_data' );
		remove_theme_mod( 'logo_image_2x' );
		remove_theme_mod( 'logo_image_2x_data' );
	}

	/**
	 * Mark we're done.
	 */
	add_option( $the_key, Snowbird()->version() );
}

add_action( 'after_setup_theme', 'snowbird_logo_data_update', 99 );