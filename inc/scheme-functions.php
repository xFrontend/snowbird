<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Returns all the Color Schemes.
 *
 * @return array
 */
function snowbird_get_color_schemes() {
	return apply_filters( 'snowbird_get_color_schemes', array(
		'default' => array(
			'label'  => esc_html_x( 'Default', 'admin', 'snowbird' ),
			'colors' => array(
				// Header
				'header_text_color'        => '#ffffff',
				'header_background_color'  => '#455a64',
				// Content
				'content_title_color'      => '#212121',
				'content_text_color'       => '#424242',
				'content_alt_text_color'   => '#616161',
				'content_accent_color'     => '#ff8a80',
				'content_background_color' => '#f8f8f8',
				// Footer
				'footer_title_color'       => '#eceff1',
				'footer_text_color'        => '#cfd8dc',
				'footer_alt_text_color'    => '#90a4ae',
				'footer_accent_color'      => '#ff8a80',
				'footer_background_color'  => '#263238',
				// Button
				'button_text_color'        => '#ffffff',
				'button_background_color'  => '#37474f',
			),
		),
		'dark'    => array(
			'label'  => esc_html_x( 'Dark', 'admin', 'snowbird' ),
			'colors' => array(
				// Header
				'header_text_color'        => '#ffffff',
				'header_background_color'  => '#161616',
				// Content
				'content_title_color'      => '#e0f2f1',
				'content_text_color'       => '#e5e5e5',
				'content_alt_text_color'   => '#c1c1c1',
				'content_accent_color'     => '#00e5ff',
				'content_background_color' => '#1a1a1a',
				// Footer
				'footer_title_color'       => '#e0f2f1',
				'footer_text_color'        => '#e5e5e5',
				'footer_alt_text_color'    => '#c1c1c1',
				'footer_accent_color'      => '#00e5ff',
				'footer_background_color'  => '#1a1a1a',
				// Button
				'button_text_color'        => '#ffffff',
				'button_background_color'  => '#004d40',
			),
		),
		'blue'    => array(
			'label'  => esc_html_x( 'Blue', 'admin', 'snowbird' ),
			'colors' => array(
				// Header
				'header_text_color'        => '#ffffff',
				'header_background_color'  => '#03a9f4',
				// Content
				'content_title_color'      => '#212121',
				'content_text_color'       => '#424242',
				'content_alt_text_color'   => '#616161',
				'content_accent_color'     => '#29b6f6',
				'content_background_color' => '#ffffff',
				// Footer
				'footer_title_color'       => '#e1f5fe',
				'footer_text_color'        => '#b3e5fc',
				'footer_alt_text_color'    => '#81d4fa',
				'footer_accent_color'      => '#29b6f6',
				'footer_background_color'  => '#0277bd',
				// Button
				'button_text_color'        => '#ffffff',
				'button_background_color'  => '#0288d1',
			),
		),
		'green'   => array(
			'label'  => esc_html_x( 'Green', 'admin', 'snowbird' ),
			'colors' => array(
				// Header
				'header_text_color'        => '#ffffff',
				'header_background_color'  => '#43a047',
				// Content
				'content_title_color'      => '#212121',
				'content_text_color'       => '#424242',
				'content_alt_text_color'   => '#616161',
				'content_accent_color'     => '#00c853',
				'content_background_color' => '#dcedc8',
				// Footer
				'footer_title_color'       => '#f1f8e9',
				'footer_text_color'        => '#dcedc8',
				'footer_alt_text_color'    => '#c5e1a5',
				'footer_accent_color'      => '#00e676',
				'footer_background_color'  => '#689f38',
				// Button
				'button_text_color'        => '#ffffff',
				'button_background_color'  => '#9ccc65',
			),
		),
		'pink'    => array(
			'label'  => esc_html_x( 'Pink', 'admin', 'snowbird' ),
			'colors' => array(
				// Header
				'header_text_color'        => '#ffffff',
				'header_background_color'  => '#d81b60',
				// Content
				'content_title_color'      => '#212121',
				'content_text_color'       => '#424242',
				'content_alt_text_color'   => '#616161',
				'content_accent_color'     => '#ff4081',
				'content_background_color' => '#fce4ec',
				// Footer
				'footer_title_color'       => '#fce4ec',
				'footer_text_color'        => '#f8bbd0',
				'footer_alt_text_color'    => '#f48fb1',
				'footer_accent_color'      => '#ff4081',
				'footer_background_color'  => '#880e4f',
				// Button
				'button_text_color'        => '#ffffff',
				'button_background_color'  => '#ad1457',
			),
		),
		'yellow'  => array(
			'label'  => esc_html_x( 'Yellow', 'admin', 'snowbird' ),
			'colors' => array(
				// Header
				'header_text_color'        => '#ffffff',
				'header_background_color'  => '#4e342e',
				// Content
				'content_title_color'      => '#3b3721',
				'content_text_color'       => '#3b3721',
				'content_alt_text_color'   => '#774e24',
				'content_accent_color'     => '#7f7d6f',
				'content_background_color' => '#ffef8e',
				// Footer
				'footer_title_color'       => '#3b3721',
				'footer_text_color'        => '#3b3721',
				'footer_alt_text_color'    => '#774e24',
				'footer_accent_color'      => '#7f7d6f',
				'footer_background_color'  => '#ffef8e',
				// Button
				'button_text_color'        => '#ffffff',
				'button_background_color'  => '#3e2723',
			),
		),
	) );
}

/**
 * Returns colors value for active color scheme.
 *
 * @return array
 */
function snowbird_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$color_schemes       = snowbird_get_color_schemes();
	$colors              = $color_schemes['default']['colors'];

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		$colors = $color_schemes[ $color_scheme_option ]['colors'];
	}

	return apply_filters( 'snowbird_get_color_scheme', $colors, $color_scheme_option );
}

/**
 * Returns list of available color schemes to choose from.
 *
 * @return array
 */
function snowbird_get_color_scheme_choices() {
	$color_schemes                = snowbird_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return apply_filters( 'snowbird_get_color_scheme_choices', $color_scheme_control_options );
}

/**
 * Returns CSS for the color scheme.
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function snowbird_get_color_scheme_css( $colors ) {

	$colors = wp_parse_args( $colors, array(
		// Header
		'header_text_color'        => '',
		'header_background_color'  => '',
		'header_border_rgba'       => '',
		// Content
		'content_title_color'      => '',
		'content_text_color'       => '',
		'content_alt_text_color'   => '',
		'content_accent_color'     => '',
		'content_background_color' => '',
		'content_border_rgba'      => '',
		'content_accent_rgba'      => '',
		// Footer
		'footer_title_color'       => '',
		'footer_text_color'        => '',
		'footer_alt_text_color'    => '',
		'footer_accent_color'      => '',
		'footer_background_color'  => '',
		'footer_border_rgba'       => '',
		'footer_accent_rgba'       => '',
		// Button
		'button_text_color'        => '',
		'button_background_color'  => '',
	) );

	$css = '';

	// Header
	$css .= snowbird_get_header_colors_css( $colors );

	// Content
	$css .= snowbird_get_content_title_color_css( $colors );
	$css .= snowbird_get_content_text_color_css( $colors );
	$css .= snowbird_get_content_alt_text_color_css( $colors );
	$css .= snowbird_get_content_accent_color_css( $colors );
	$css .= snowbird_get_content_background_color_css( $colors );

	// Footer
	$css .= snowbird_get_footer_title_color_css( $colors );
	$css .= snowbird_get_footer_text_color_css( $colors );
	$css .= snowbird_get_footer_alt_text_color_css( $colors );
	$css .= snowbird_get_footer_accent_color_css( $colors );
	$css .= snowbird_get_footer_background_color_css( $colors );

	// Buttons
	$css .= snowbird_get_button_text_color_css( $colors );
	$css .= snowbird_get_button_background_color_css( $colors );

	return apply_filters( 'snowbird_get_color_scheme_css', $css, $colors );
}


/**
 * Returns user defined Header Colors.
 *
 * @return string|void
 */
function snowbird_get_header_colors() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['header_text_color']       = Snowbird()->mod( 'header_text_color', $color_scheme['header_text_color'] );
	$colors['header_background_color'] = Snowbird()->mod( 'header_background_color', $color_scheme['header_background_color'] );

	$colors['content_text_color']      = Snowbird()->mod( 'content_text_color', $color_scheme['content_text_color'] );
	$colors['header_border_rgba']      = Snowbird()->rgba( $colors['content_text_color'], 10 );  // 10 = 0.1

	if ( $colors['header_text_color'] === $color_scheme['header_text_color'] && $colors['header_background_color'] === $color_scheme['header_background_color'] || empty( $colors['header_border_rgba'] ) ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Header Colors.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_header_colors_css( $colors ) {

	if ( ! isset( $colors['header_text_color'] ) && ! isset( $colors['header_background_color'] ) && ! isset( $colors['header_border_rgba'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Header Text Color */
	.xf__header,
	.xf__header a,
	.xf__header a:hover,
	.xf__header a:focus,
	.xf__header .xf__page-title {
		color: {$colors['header_text_color']};
	}
	/* Header Background Color and Header Border RGBA */
	.xf__header {
		background-color: {$colors['header_background_color']};
		box-shadow: 0 0 1px {$colors['header_border_rgba']};
	}

CSS;

	return $css;
}


/**
 * Returns user defined Content Title Color.
 *
 * @return string|void
 */
function snowbird_get_content_title_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['content_title_color'] = Snowbird()->mod( 'content_title_color', $color_scheme['content_title_color'] );

	if ( $colors['content_title_color'] === $color_scheme['content_title_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Content Title Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_content_title_color_css( $colors ) {

	if ( ! isset( $colors['content_title_color'] ) ) {
		return;
	}

	$css = <<<CSS
	/* Content Title Color */
	h1, h2,
	h3, h4,
	h5, h6,
	.widget_recent_comments .comment-author-link,
	.widget_recent_comments .comment-author-link a,
	.comment .comment-author-name,
	.comment .comment-author-name a,
	.comment-reply-title span,
	.pingback .comment-author-name,
	.pingback .comment-author-name a,
	.xf__block .xf__block-title,
	.xf__entry .entry-title,
	.xf__entry .entry-title a {
		color: {$colors['content_title_color']};
	}

	@media screen and (max-width: 980px) {
		.xf__nav-post a[rel="next"],
		.xf__nav-post a[rel="prev"] {
			color: {$colors['content_title_color']};
		}
	}

CSS;

	return $css;
}


/**
 * Returns user defined Content Text Color.
 *
 * @return string|void
 */
function snowbird_get_content_text_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['content_text_color']  = Snowbird()->mod( 'content_text_color', $color_scheme['content_text_color'] );
	$colors['content_border_rgba'] = Snowbird()->rgba( $colors['content_text_color'], 10 ); // 10 = 0.1

	if ( $colors['content_text_color'] === $color_scheme['content_text_color'] || empty( $colors['content_border_rgba'] ) ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Content Text Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_content_text_color_css( $colors ) {

	if ( ! isset( $colors['content_text_color'] ) && ! isset( $colors['content_border_rgba'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Content Text Color */
	body,
	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	select,
	textarea,
	.dropdown-toggle,
	.dropdown-toggle:hover,
	.dropdown-toggle:active,
	.dropdown-toggle:focus,
	.screen-reader-text:hover,
	.screen-reader-text:active,
	.screen-reader-text:focus,
	.superpack__widget-tags a,
	.superpack__widget-comments .post-title,
	.superpack__widget-comments .user-nick strong,
	.superpack__widget-posts .post-title,
	.widget a,
	.widget p,
	.xf__author-bio .author,
	.xf__author-bio .entry-author a,
	.xf__contributor .contributor-name,
	.xf__contributor .contributor-name a,
	.xf__meta-item + .xf__meta-item::after,
	.xf__nav-pages .nav-previous a,
	.xf__nav-pages .nav-next a,
	.xf__nav-pagination .prev,
	.xf__nav-pagination .next,
	.xf__search button[type="submit"],
	.xf__top {
		color: {$colors['content_text_color']};
	}

	/* Content Border Color */
	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	select,
	textarea,
	blockquote,
	table tr,
	pre,
	.comment > .xf__wrap,
	.pingback > .xf__wrap,
	.xf__nav-pages .nav-links,
	.xf__nav-pagination .nav-links,
	.superpack__widget-tags a,
	.superpack__widget-comments li,
	.superpack__widget-posts li,
	.widget table tr,
	.xf__contributor,
	.xf__entry-share a,
	.xf__page-meta .item-icon,
	.xf__page-meta .item-icon::after,
	.xf__page-meta .item-icon::before,
	.xf__page-meta .item-content::after,
	.xf__page-meta .item-content::before {
		border-color: {$colors['content_border_rgba']};
	}

	code,
	kbd,
	tt,
	var,
	hr,
	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	select,
	textarea,
	.xf__search input[type="text"],
	.xf__related .related-item {
		background-color: {$colors['content_border_rgba']};
	}

	.xf__sidebar {
		box-shadow: 0 1px 3px {$colors['content_border_rgba']};
	}

	@media screen and (max-width: 980px) {
		.xf__nav-post a[rel="next"],
		.xf__nav-post a[rel="prev"] {
			border-color: {$colors['content_border_rgba']};
		}
	}

CSS;

	return $css;
}


/**
 * Returns user defined Content Secondary Color.
 *
 * @return string|void
 */
function snowbird_get_content_alt_text_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['content_alt_text_color'] = Snowbird()->mod( 'content_alt_text_color', $color_scheme['content_alt_text_color'] );

	if ( $colors['content_alt_text_color'] === $color_scheme['content_alt_text_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Content Secondary Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_content_alt_text_color_css( $colors ) {

	if ( ! isset( $colors['content_alt_text_color'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Content Secondary Colors */
	pre,
	.comment .xf__meta,
	.main-navigation .menu-item-description,
	.pingback .xf__meta,
	.superpack__widget-comments .user-nick,
	.superpack__widget-posts .post-date,
	.widget,
	.widget_calendar tbody > tr > td,
	.widget_recent_entries .post-date,
	.widget_rss .rssSummary,
	.wp-caption,
	.xf__entry .xf__post-footer,
	.xf__author-bio .entry-author,
	.xf__meta,
	.xf__meta a,
	.xf__entry-sidebar,
	.xf__entry-sidebar a {
		color: {$colors['content_alt_text_color']};
	}

	.xf__entry hr.separator {
		background-color: {$colors['content_alt_text_color']};
	}

	input[type="text"]:focus,
	input[type="email"]:focus,
	input[type="url"]:focus,
	input[type="password"]:focus,
	input[type="search"]:focus,
	select:focus,
	textarea:focus {
		border-color: {$colors['content_alt_text_color']};
	}

	@media screen and (max-width: 980px) {
		.xf__nav-post a[rel="next"]:before,
		.xf__nav-post a[rel="next"] .xf__title:before,
		.xf__nav-post a[rel="prev"]:before,
		.xf__nav-post a[rel="prev"] .xf__title:before {
			color: {$colors['content_alt_text_color']};
		}
	}

CSS;

	return $css;
}


/**
 * Returns user defined Content Accent Color.
 *
 * @return string|void
 */
function snowbird_get_content_accent_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['content_accent_color'] = Snowbird()->mod( 'content_accent_color', $color_scheme['content_accent_color'] );
	$colors['content_accent_rgba']  = Snowbird()->rgba( $colors['content_accent_color'], 85 );

	if ( $colors['content_accent_color'] === $color_scheme['content_accent_color'] || empty( $colors['content_accent_rgba'] ) ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Content Accent Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_content_accent_color_css( $colors ) {

	if ( ! isset( $colors['content_accent_color'] ) && ! isset( $colors['content_accent_rgba'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Content Accent Colors */
	a,
	blockquote,
	.comment .comment-author-name a:hover,
	.comment .comment-author-name a:focus,
	.pingback .comment-author-name a:hover,
	.pingback .comment-author-name a:focus,
	.superpack__widget-about a,
	.superpack__widget-comments .post-title:hover,
	.superpack__widget-comments .post-title:focus,
	.superpack__widget-posts .post-title:hover,
	.superpack__widget-posts .post-title:focus,
	.superpack__widget-tags a:hover,
	.superpack__widget-tags a:focus,
	.widget a:hover,
	.widget a:focus,
	.xf__author-bio .entry-author a:hover,
	.xf__author-bio .entry-author a:focus,
	.xf__contributor .contributor-name a:hover,
	.xf__contributor .contributor-name a:focus,
	.xf__entry-sidebar a:hover,
	.xf__entry-sidebar a:focus,
	.xf__meta a:hover,
	.xf__meta a:focus,
	.xf__nav-pages .nav-next a:hover,
	.xf__nav-pages .nav-next a:focus,
	.xf__nav-pages .nav-previous a:hover,
	.xf__nav-pages .nav-previous a:focus,
	.xf__nav-pagination .next:hover,
	.xf__nav-pagination .next:focus,
	.xf__nav-pagination .prev:hover,
	.xf__nav-pagination .prev:focus	{
		color: {$colors['content_accent_color']};
	}

	button:hover,
	button:focus,
	input[type="button"]:hover,
	input[type="button"]:focus,
	input[type="reset"]:hover,
	input[type="reset"]:focus,
	input[type="submit"]:hover,
	input[type="submit"]:focus,
	ins,
	mark,
	.comment .comment-content .comment-reply-link:hover,
	.comment .comment-content .comment-reply-link:focus,
	.pingback .comment-content .comment-reply-link:hover,
	.pingback .comment-content .comment-reply-link:focus,
	.xf__button:hover,
	.xf__button:focus,
	.xf__header .xf__close,
	.xf__toggle,
	#infinite-handle span:hover,
	#infinite-handle span:focus {
		background-color: {$colors['content_accent_color']};
	}

	button:hover,
	button:focus,
	input[type="button"]:hover,
	input[type="button"]:focus,
	input[type="reset"]:hover,
	input[type="reset"]:focus,
	input[type="submit"]:hover,
	input[type="submit"]:focus,
	.xf__button:hover,
	.xf__button:focus,
	.xf__header .xf__close,
	.xf__toggle,
	#infinite-handle span:hover,
	#infinite-handle span:focus {
		border-color: {$colors['content_accent_color']};
	}

	/* Content Accent RGBA Colors */
	a:hover,
	a:focus,
	blockquote::before {
		color: {$colors['content_accent_rgba']};
	}

	@media screen and (max-width: 980px) {
		.xf__nav-post a[rel="next"]:hover,
		.xf__nav-post a[rel="next"]:hover .xf__title:before,
		.xf__nav-post a[rel="next"]:focus,
		.xf__nav-post a[rel="next"]:focus .xf__title:before,
		.xf__nav-post a[rel="prev"]:hover,
		.xf__nav-post a[rel="prev"]:hover .xf__title:before,
		.xf__nav-post a[rel="prev"]:focus,
		.xf__nav-post a[rel="prev"]:focus .xf__title:before {
			color: {$colors['content_accent_color']};
		}
	}

CSS;

	return $css;
}


/**
 * Returns user defined Content Background Color.
 *
 * @return string|void
 */
function snowbird_get_content_background_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['content_background_color'] = Snowbird()->mod( 'content_background_color', $color_scheme['content_background_color'] );

	if ( $colors['content_background_color'] === $color_scheme['content_background_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Content Background Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_content_background_color_css( $colors ) {

	if ( ! isset( $colors['content_background_color'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Content Background Color */
	body,
	.screen-reader-text:hover,
	.screen-reader-text:active,
	.screen-reader-text:focus,
	.xf__sidebar {
		background-color: {$colors['content_background_color']};
	}

	.xf__page-author .avatar {
		border-color: {$colors['content_background_color']};
	}

CSS;

	return $css;
}


/**
 * Returns user defined Footer Title Color.
 *
 * @return string|void
 */
function snowbird_get_footer_title_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['footer_title_color'] = Snowbird()->mod( 'footer_title_color', $color_scheme['footer_title_color'] );

	if ( $colors['footer_title_color'] === $color_scheme['footer_title_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Footer Title Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_footer_title_color_css( $colors ) {

	if ( ! isset( $colors['footer_title_color'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Footer Title Color */
	.xf__footer h1,
	.xf__footer h2,
	.xf__footer h3,
	.xf__footer h4,
	.xf__footer h5,
	.xf__footer h6,
	.xf__footer .widget-title,
	.xf__footer .widget-title a,
	.xf__footer .widget_calendar tbody a,
	.xf__footer .widget_recent_comments .comment-author-link,
	.xf__footer .widget_recent_comments .comment-author-link a,
	.xf__footer .superpack__widget-comments .user-nick strong {
		color: {$colors['footer_title_color']};
	}

CSS;

	return $css;
}


/**
 * Returns user defined Footer Text Color.
 *
 * @return string|void
 */
function snowbird_get_footer_text_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['footer_text_color']  = Snowbird()->mod( 'footer_text_color', $color_scheme['footer_text_color'] );
	$colors['footer_border_rgba'] = Snowbird()->rgba( $colors['footer_text_color'], 10 ); // 10 = 0.1

	if ( $colors['footer_text_color'] === $color_scheme['footer_text_color'] || empty( $colors['footer_border_rgba'] ) ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Footer Text Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_footer_text_color_css( $colors ) {

	if ( ! isset( $colors['footer_text_color'] ) && ! isset( $colors['footer_border_rgba'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Footer Text Color */
	.xf__footer,
	.xf__footer .dropdown-toggle,
	.xf__footer .dropdown-toggle:hover,
	.xf__footer .dropdown-toggle:active,
	.xf__footer .dropdown-toggle:focus,
	.xf__footer .screen-reader-text:hover,
	.xf__footer .screen-reader-text:active,
	.xf__footer .screen-reader-text:focus,
	.xf__footer .superpack__widget-tags a,
	.xf__footer .superpack__widget-comments .post-title,
	.xf__footer .superpack__widget-comments .user-nick strong,
	.xf__footer .superpack__widget-posts .post-title,
	.xf__footer .widget a,
	.xf__footer .widget p,
	.xf__footer .xf__search button[type="submit"],
	.xf__site-info a {
		color: {$colors['footer_text_color']};
	}

	/* Footer Border Color */
	.xf__footer .widget input[type="text"],
	.xf__footer .widget input[type="email"],
	.xf__footer .widget input[type="url"],
	.xf__footer .widget input[type="password"],
	.xf__footer .widget input[type="search"],
	.xf__footer .widget select,
	.xf__footer .widget textarea,
	.xf__footer blockquote,
	.xf__footer table tr,
	.xf__footer pre,
	.xf__footer .superpack__widget-tags a,
	.xf__footer .superpack__widget-comments li,
	.xf__footer .superpack__widget-posts li,
	.xf__footer .widget table tr,
	.xf__footer .widget-area {
		border-color: {$colors['footer_border_rgba']};
	}

	.xf__footer code,
	.xf__footer kbd,
	.xf__footer tt,
	.xf__footer var,
	.xf__footer hr,
	.xf__footer .xf__search input[type="text"] {
		background-color: {$colors['footer_border_rgba']};
	}

CSS;

	return $css;
}


/**
 * Returns user defined Footer Secondary Color.
 *
 * @return string|void
 */
function snowbird_get_footer_alt_text_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['footer_alt_text_color'] = Snowbird()->mod( 'footer_alt_text_color', $color_scheme['footer_alt_text_color'] );

	if ( $colors['footer_alt_text_color'] === $color_scheme['footer_alt_text_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Footer Secondary Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_footer_alt_text_color_css( $colors ) {

	if ( ! isset( $colors['footer_alt_text_color'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Footer Secondary Color */
	.xf__footer pre,
	.xf__footer .widget input[type="text"],
	.xf__footer .widget input[type="email"],
	.xf__footer .widget input[type="url"],
	.xf__footer .widget input[type="password"],
	.xf__footer .widget input[type="search"],
	.xf__footer .widget select,
	.xf__footer .widget textarea,
	.xf__footer .superpack__widget-posts .post-date,
	.xf__footer .superpack__widget-comments .user-nick,
	.xf__footer .widget,
	.xf__footer .widget_calendar tbody > tr > td,
	.xf__footer .widget_recent_entries .post-date,
	.xf__footer .widget_rss .rssSummary,
	.xf__footer .wp-caption {
		color: {$colors['footer_alt_text_color']};
	}

	.xf__footer .widget input[type="text"]:focus,
	.xf__footer .widget input[type="email"]:focus,
	.xf__footer .widget input[type="url"]:focus,
	.xf__footer .widget input[type="password"]:focus,
	.xf__footer .widget input[type="search"]:focus,
	.xf__footer .widget select:focus,
	.xf__footer .widget textarea:focus {
		border-color: {$colors['footer_alt_text_color']};
	}

CSS;

	return $css;
}


/**
 * Returns user defined Footer Accent Color.
 *
 * @return string|void
 */
function snowbird_get_footer_accent_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['footer_accent_color'] = Snowbird()->mod( 'footer_accent_color', $color_scheme['footer_accent_color'] );
	$colors['footer_accent_rgba']  = Snowbird()->rgba( $colors['footer_accent_color'], 85 );

	if ( $colors['footer_accent_color'] === $color_scheme['footer_accent_color'] || empty( $colors['footer_accent_rgba'] ) ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Footer Accent Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_footer_accent_color_css( $colors ) {

	if ( ! isset( $colors['footer_accent_color'] ) && ! isset( $colors['footer_accent_rgba'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Footer Accent Colors */
	.xf__footer blockquote,
	.xf__footer .superpack__widget-about a,
	.xf__footer .superpack__widget-comments .post-title:hover,
	.xf__footer .superpack__widget-comments .post-title:focus,
	.xf__footer .superpack__widget-posts .post-title:hover,
	.xf__footer .superpack__widget-posts .post-title:focus,
	.xf__footer .superpack__widget-tags a:hover,
	.xf__footer .superpack__widget-tags a:focus,
	.xf__footer .widget a:hover,
	.xf__footer .widget a:focus,
	.xf__site-info a:hover,
	.xf__site-info a:focus {
		color: {$colors['footer_accent_color']};
	}

	.xf__footer button:hover,
	.xf__footer button:focus,
	.xf__footer ins,
	.xf__footer mark,
	.xf__footer .widget input[type="button"]:hover,
	.xf__footer .widget input[type="button"]:focus,
	.xf__footer .widget input[type="reset"]:hover,
	.xf__footer .widget input[type="reset"]:focus,
	.xf__footer .widget input[type="submit"]:hover,
	.xf__footer .widget input[type="submit"]:focus,
	.xf__footer .xf__button:hover,
	.xf__footer .xf__button:focus {
		background-color: {$colors['footer_accent_color']};
	}

	.xf__footer button:hover,
	.xf__footer button:focus,
	.xf__footer .widget input[type="button"]:hover,
	.xf__footer .widget input[type="button"]:focus,
	.xf__footer .widget input[type="reset"]:hover,
	.xf__footer .widget input[type="reset"]:focus,
	.xf__footer .widget input[type="submit"]:hover,
	.xf__footer .widget input[type="submit"]:focus,
	.xf__footer .xf__button:hover,
	.xf__footer .xf__button:focus {
		border-color: {$colors['footer_accent_color']};
	}

	/* Footer Accent RGBA Colors */
	.xf__footer .superpack__widget-about a:hover,
	.xf__footer .superpack__widget-about a:focus,
	.xf__footer blockquote::before {
		color: {$colors['footer_accent_rgba']};
	}

CSS;

	return $css;
}


/**
 * Returns user defined Footer Background Color.
 *
 * @return string|void
 */
function snowbird_get_footer_background_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['footer_background_color'] = Snowbird()->mod( 'footer_background_color', $color_scheme['footer_background_color'] );

	if ( $colors['footer_background_color'] === $color_scheme['footer_background_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Footer Background Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_footer_background_color_css( $colors ) {

	if ( ! isset( $colors['footer_background_color'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Footer Background Color */
	/*.xf__footer .widget input[type="text"],
	.xf__footer .widget input[type="email"],
	.xf__footer .widget input[type="url"],
	.xf__footer .widget input[type="password"],
	.xf__footer .widget input[type="search"],
	.xf__footer .widget select,
	.xf__footer .widget textarea,*/
	.xf__footer {
		background-color: {$colors['footer_background_color']};
	}

CSS;

	return $css;
}


/**
 * Returns user defined Button Text Color.
 *
 * @return string|void
 */
function snowbird_get_button_text_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['button_text_color'] = Snowbird()->mod( 'button_text_color', $color_scheme['button_text_color'] );

	if ( $colors['button_text_color'] === $color_scheme['button_text_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Button Text Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_button_text_color_css( $colors ) {

	if ( ! isset( $colors['button_text_color'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Button Text Color */
	button,
	button:hover,
	button:focus,
	input[type="button"],
	input[type="button"]:hover,
	input[type="button"]:focus,
	input[type="reset"],
	input[type="reset"]:hover,
	input[type="reset"]:focus,
	input[type="submit"],
	input[type="submit"]:hover,
	input[type="submit"]:focus,
	ins,
	mark,
	.comment .comment-content .comment-reply-link,
	.pingback .comment-content .comment-reply-link,
	.xf__button,
	.xf__button:hover,
	.xf__button:focus,
	.xf__header .xf__close,
	.xf__toggle,
	#infinite-handle span,
	#infinite-handle span:hover,
	#infinite-handle span:focus {
		color: {$colors['button_text_color']};
	}

	@media screen and (min-width: 981px) {
		.xf__nav-image .nav-next a,
		.xf__nav-image .nav-previous a,
		.xf__nav-post a[rel="next"],
		.xf__nav-post a[rel="prev"] {
      		color: {$colors['button_text_color']};
		}
	}

CSS;

	return $css;
}


/**
 * Returns user defined Button Background Color.
 *
 * @return string|void
 */
function snowbird_get_button_background_color() {
	$color_scheme = snowbird_get_color_scheme();
	$colors       = array();

	$colors['button_background_color'] = Snowbird()->mod( 'button_background_color', $color_scheme['button_background_color'] );

	if ( $colors['button_background_color'] === $color_scheme['button_background_color'] ) {
		return;
	}

	return $colors;
}

/**
 * Returns CSS for Button Background Color.
 *
 * @param $colors
 *
 * @return string|void
 */
function snowbird_get_button_background_color_css( $colors ) {

	if ( ! isset( $colors['button_background_color'] ) ) {
		return;
	}

	$css = <<<CSS

	/* Button Background Color */
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.comment .comment-content .comment-reply-link,
	.pingback .comment-content .comment-reply-link,
	.xf__button,
	#infinite-handle span {
		background-color: {$colors['button_background_color']};
	}

	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.xf__button,
	#infinite-handle span {
		border-color: {$colors['button_background_color']};
	}

	@media screen and (min-width: 981px) {
		.xf__nav-image .nav-next a,
		.xf__nav-image .nav-previous a,
		.xf__nav-post a[rel="next"],
		.xf__nav-post a[rel="prev"] {
			background-color: {$colors['button_background_color']};
		}
	}

CSS;

	return $css;
}
