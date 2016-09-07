<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Sets up the WordPress core custom header feature.
 */
function snowbird_custom_header_and_background() {
	$color_scheme = snowbird_get_color_scheme();

	$header_text_color = trim( Snowbird()->mod( 'header_text_color', $color_scheme['header_text_color'] ), '#' );

	// Core Custom Header feature.
	add_theme_support( 'custom-header', apply_filters( 'snowbird_custom_header_args', array(
		'default-text-color' => $header_text_color,
		'default-image'      => '',
		'width'              => 1600,
		'height'             => 360,
		'header-text'        => false,
	) ) );
}

add_action( 'after_setup_theme', 'snowbird_custom_header_and_background' );


/**
 * Registers Settings/Controls for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function snowbird_customize_register( $wp_customize ) {

	/**
	 * Theme Settings
	 */
	$wp_customize->add_section( 'snowbird_settings', array(
		'title'    => esc_html_x( 'Theme Settings', 'admin', 'snowbird' ),
		'priority' => 30,
	) );

	// site_sidebar_type
	$wp_customize->add_setting( 'site_sidebar_type', array(
		'default'           => Snowbird()->mod_default( 'site_sidebar_type' ),
		'sanitize_callback' => 'snowbird_sanitize_choice',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'site_sidebar_type', array(
		'label'   => esc_html_x( 'Sidebar Position', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'radio',
		'choices' => snowbird_choices_sidebar_type(),
	) );

	// site_display_search
	$wp_customize->add_setting( 'site_display_search', array(
		'default'              => Snowbird()->mod_default( 'site_display_search' ),
		'sanitize_callback'    => 'snowbird_sanitize_checkbox',
		'sanitize_js_callback' => 'snowbird_sanitize_checkbox_js',
		'transport'            => 'postMessage',
	) );

	$wp_customize->add_control( 'site_display_search', array(
		'label'   => esc_html_x( 'Display "Search" in Sidebar', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'checkbox',
	) );


	/**
	 * Loop
	 */
	// loop_heading_line_filter
	$wp_customize->add_setting( 'loop_heading_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'loop_heading_line_filter', array(
		'label'   => esc_html_x( 'Posts Listing', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'misc-heading-line'
	) ) );

	// loop_layout_type
	$wp_customize->add_setting( 'loop_layout_type', array(
		'default'           => Snowbird()->mod_default( 'loop_layout_type' ),
		'sanitize_callback' => 'snowbird_sanitize_choice',
	) );

	$wp_customize->add_control( 'loop_layout_type', array(
		'label'   => esc_html_x( 'Layout', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'radio',
		'choices' => snowbird_choices_loop_layout_type(),
	) );

	// loop_content
	$wp_customize->add_setting( 'loop_content', array(
		'default'           => Snowbird()->mod_default( 'loop_content' ),
		'sanitize_callback' => 'snowbird_sanitize_choice',
	) );

	$wp_customize->add_control( 'loop_content', array(
		'label'   => esc_html_x( 'Display Content', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'radio',
		'choices' => snowbird_choices_loop_content(),
	) );

	// loop_excerpt_length
	$wp_customize->add_setting( 'loop_excerpt_length', array(
		'default'           => Snowbird()->mod_default( 'loop_excerpt_length' ),
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'loop_excerpt_length', array(
		'label'       => esc_html_x( 'Excerpt Length (Max Words)', 'admin', 'snowbird' ),
		'section'     => 'snowbird_settings',
		'type'        => 'range',
		'input_attrs' => snowbird_choices_loop_excerpt_length(),
	) );

	// posts_per_page
	$wp_customize->add_setting( 'posts_per_page', array(
		'default'           => Snowbird()->mod_default( 'posts_per_page' ),
		'sanitize_callback' => 'absint',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'posts_per_page', array(
		'label'       => esc_html_x( 'Posts Per Page', 'admin', 'snowbird' ),
		'section'     => 'snowbird_settings',
		'type'        => 'range',
		'input_attrs' => snowbird_choices_posts_per_page(),
	) );


	/**
	 * Post (Single)
	 */
	// post_heading_line_filter
	$wp_customize->add_setting( 'post_heading_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'post_heading_line_filter', array(
		'label'   => esc_html_x( 'Post (Single)', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'misc-heading-line'
	) ) );

	// post_layout_type
	$wp_customize->add_setting( 'post_layout_type', array(
		'default'           => Snowbird()->mod_default( 'post_layout_type' ),
		'sanitize_callback' => 'snowbird_sanitize_choice',
	) );

	$wp_customize->add_control( 'post_layout_type', array(
		'label'   => esc_html_x( 'Layout', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'radio',
		'choices' => snowbird_choices_post_layout_type(),
	) );

	// post_full_content_width
	$wp_customize->add_setting( 'post_full_content_width', array(
		'default'              => Snowbird()->mod_default( 'post_display_full_width' ),
		'sanitize_callback'    => 'snowbird_sanitize_checkbox',
		'sanitize_js_callback' => 'snowbird_sanitize_checkbox_js',
		'transport'            => 'postMessage',
	) );

	$wp_customize->add_control( 'post_full_content_width', array(
		'label'   => esc_html_x( 'Display in Full Content Width', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'checkbox',
	) );

	// post_display_author_bio
	$wp_customize->add_setting( 'post_display_author_bio', array(
		'default'              => Snowbird()->mod_default( 'post_display_author_bio' ),
		'sanitize_callback'    => 'snowbird_sanitize_checkbox',
		'sanitize_js_callback' => 'snowbird_sanitize_checkbox_js',
		'transport'            => 'postMessage',
	) );

	$wp_customize->add_control( 'post_display_author_bio', array(
		'label'   => esc_html_x( 'Display Author Bio', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'checkbox',
	) );

	// post_display_share_this
	$wp_customize->add_setting( 'post_display_share_this', array(
		'default'              => Snowbird()->mod_default( 'post_display_share_this' ),
		'sanitize_callback'    => 'snowbird_sanitize_checkbox',
		'sanitize_js_callback' => 'snowbird_sanitize_checkbox_js',
		'transport'            => 'postMessage',
	) );

	$wp_customize->add_control( 'post_display_share_this', array(
		'label'   => esc_html_x( 'Display Share This', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'checkbox',
	) );

	// post_display_related
	$wp_customize->add_setting( 'post_display_related', array(
		'default'              => Snowbird()->mod_default( 'post_display_related' ),
		'sanitize_callback'    => 'snowbird_sanitize_checkbox',
		'sanitize_js_callback' => 'snowbird_sanitize_checkbox_js',
		'transport'            => 'postMessage',
	) );

	$wp_customize->add_control( 'post_display_related', array(
		'label'   => esc_html_x( 'Display Related Posts', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'checkbox',
	) );


	/**
	 * Page
	 */
	// page_heading_line_filter
	$wp_customize->add_setting( 'page_heading_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'page_heading_line_filter', array(
		'label'   => esc_html_x( 'Page', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'misc-heading-line'
	) ) );

	// page_full_content_width
	$wp_customize->add_setting( 'page_full_content_width', array(
		'default'              => Snowbird()->mod_default( 'page_full_content_width' ),
		'sanitize_callback'    => 'snowbird_sanitize_checkbox',
		'sanitize_js_callback' => 'snowbird_sanitize_checkbox_js',
		'transport'            => 'postMessage',
	) );

	$wp_customize->add_control( 'page_full_content_width', array(
		'label'   => esc_html_x( 'Display in Full Content Width', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'checkbox',
	) );

	// page_display_share_this
	$wp_customize->add_setting( 'page_display_share_this', array(
		'default'              => Snowbird()->mod_default( 'page_display_share_this' ),
		'sanitize_callback'    => 'snowbird_sanitize_checkbox',
		'sanitize_js_callback' => 'snowbird_sanitize_checkbox_js',
		'transport'            => 'postMessage',
	) );

	$wp_customize->add_control( 'page_display_share_this', array(
		'label'   => esc_html_x( 'Display Share This', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'checkbox',
	) );


	/**
	 * Footer
	 */
	// footer_line_filter
	$wp_customize->add_setting( 'footer_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'footer_line_filter', array(
		'section' => 'snowbird_settings',
		'type'    => 'misc-line'
	) ) );

	// footer_widget_area
	$wp_customize->add_setting( 'footer_widget_area', array(
		'default'           => Snowbird()->mod_default( 'footer_widget_area' ),
		'sanitize_callback' => 'snowbird_sanitize_choice',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'footer_widget_area', array(
		'label'   => esc_html_x( 'Footer Widgets Area', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'radio',
		'choices' => snowbird_choices_footer_widget_area(),
	) );

	// footer_menu_location
	$wp_customize->add_setting( 'footer_menu_location', array(
		'default'           => Snowbird()->mod_default( 'footer_menu_location' ),
		'sanitize_callback' => 'snowbird_sanitize_choice',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'footer_menu_location', array(
		'label'   => esc_html_x( 'Footer Menu Location', 'admin', 'snowbird' ),
		'section' => 'snowbird_settings',
		'type'    => 'radio',
		'choices' => snowbird_choices_footer_menu_location(),
	) );


	/**
	 * Colors
	 */
	// Add color scheme setting and control.
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => Snowbird()->mod_default( 'color_scheme' ),
		'sanitize_callback' => 'snowbird_sanitize_choice',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => esc_html_x( 'Base Color Scheme', 'admin', 'snowbird' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => snowbird_get_color_scheme_choices(),
		'priority' => 1,
	) );

	// scheme_after_line_filter
	$wp_customize->add_setting( 'scheme_after_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'scheme_after_line_filter', array(
		'section' => 'colors',
		'type'    => 'misc-line'
	) ) );


	/**
	 * Colors - Header
	 */
	// header_text_color
	$wp_customize->add_setting( 'header_text_color', array(
		'default'           => Snowbird()->mod_default( 'header_text_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_text_color', array(
		'label'   => esc_html_x( 'Header Text Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// header_background_color
	$wp_customize->add_setting( 'header_background_color', array(
		'default'           => Snowbird()->mod_default( 'header_background_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background_color', array(
		'label'   => esc_html_x( 'Header Background Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// header_after_line_filter
	$wp_customize->add_setting( 'header_after_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'header_after_line_filter', array(
		'section' => 'colors',
		'type'    => 'misc-line'
	) ) );


	/**
	 * Colors - Content
	 */
	// content_title_color
	$wp_customize->add_setting( 'content_title_color', array(
		'default'           => Snowbird()->mod_default( 'content_title_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_title_color', array(
		'label'   => esc_html_x( 'Content Title Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// content_text_color
	$wp_customize->add_setting( 'content_text_color', array(
		'default'           => Snowbird()->mod_default( 'content_text_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_text_color', array(
		'label'   => esc_html_x( 'Content Text Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// content_alt_text_color
	$wp_customize->add_setting( 'content_alt_text_color', array(
		'default'           => Snowbird()->mod_default( 'content_alt_text_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_alt_text_color', array(
		'label'   => esc_html_x( 'Content Secondary Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// content_accent_color
	$wp_customize->add_setting( 'content_accent_color', array(
		'default'           => Snowbird()->mod_default( 'content_accent_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_accent_color', array(
		'label'   => esc_html_x( 'Content Accent Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// content_background_color
	$wp_customize->add_setting( 'content_background_color', array(
		'default'           => Snowbird()->mod_default( 'content_background_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_background_color', array(
		'label'   => esc_html_x( 'Content Background Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// content_after_line_filter
	$wp_customize->add_setting( 'content_after_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'content_after_line_filter', array(
		'section' => 'colors',
		'type'    => 'misc-line'
	) ) );


	/**
	 * Colors - Footer
	 */
	// footer_title_color
	$wp_customize->add_setting( 'footer_title_color', array(
		'default'           => Snowbird()->mod_default( 'footer_title_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_title_color', array(
		'label'   => esc_html_x( 'Footer Title Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// footer_text_color
	$wp_customize->add_setting( 'footer_text_color', array(
		'default'           => Snowbird()->mod_default( 'footer_text_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color', array(
		'label'   => esc_html_x( 'footer Text Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// footer_alt_text_color
	$wp_customize->add_setting( 'footer_alt_text_color', array(
		'default'           => Snowbird()->mod_default( 'footer_alt_text_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_alt_text_color', array(
		'label'   => esc_html_x( 'Footer Secondary Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// footer_accent_color
	$wp_customize->add_setting( 'footer_accent_color', array(
		'default'           => Snowbird()->mod_default( 'footer_accent_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_accent_color', array(
		'label'   => esc_html_x( 'Footer Accent Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// footer_background_color
	$wp_customize->add_setting( 'footer_background_color', array(
		'default'           => Snowbird()->mod_default( 'footer_background_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background_color', array(
		'label'   => esc_html_x( 'Footer Background Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// footer_after_line_filter
	$wp_customize->add_setting( 'footer_after_line_filter', array(
		'type'              => 'filter',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new Snowbird_Customize_Control_Misc( $wp_customize, 'footer_after_line_filter', array(
		'section' => 'colors',
		'type'    => 'misc-line'
	) ) );


	/**
	 * Colors - Button
	 */
	// button_text_color
	$wp_customize->add_setting( 'button_text_color', array(
		'default'           => Snowbird()->mod_default( 'button_text_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_text_color', array(
		'label'   => esc_html_x( 'Button Text Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );

	// button_background_color
	$wp_customize->add_setting( 'button_background_color', array(
		'default'           => Snowbird()->mod_default( 'button_background_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_background_color', array(
		'label'   => esc_html_x( 'Button Background Color', 'admin', 'snowbird' ),
		'section' => 'colors',
	) ) );


	/**
	 * Header Image
	 */
	// header_overlay_color
	$wp_customize->add_setting( 'header_overlay_color', array(
		'default'           => Snowbird()->mod_default( 'header_overlay_color' ),
		'sanitize_callback' => 'snowbird_sanitize_maybe_hash_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_overlay_color', array(
		'label'       => esc_html_x( 'Overlay Color', 'admin', 'snowbird' ),
		'description' => esc_html_x( 'Adjust overlay color/opacity to display when you upload a header image.', 'admin', 'snowbird' ),
		'section'     => 'header_image',
	) ) );

	// header_overlay_opacity
	$wp_customize->add_setting( 'header_overlay_opacity', array(
		'default'           => Snowbird()->mod_default( 'header_overlay_opacity' ),
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'header_overlay_opacity', array(
		'label'       => esc_html_x( 'Overlay Opacity', 'admin', 'snowbird' ),
		'section'     => 'header_image',
		'type'        => 'range',
		'input_attrs' => snowbird_choices_opacity(),
	) );


	/**
	 * Custom CSS
	 */
	$wp_customize->add_section( 'snowbird_editors', array(
		'title'    => esc_html_x( 'Custom CSS', 'admin', 'snowbird' ),
		'priority' => 200,
	) );

	$wp_customize->add_setting( Snowbird()->option_key( 'custom_css' ), array(
		'default'           => Snowbird()->option_default( 'custom_css' ),
		'sanitize_callback' => 'snowbird_sanitize_css_js',
		'transport'         => 'postMessage',
		'type'              => 'option'
	) );

	$wp_customize->add_control( Snowbird()->option_key( 'custom_css' ), array(
		'label'       => esc_html_x( 'Custom CSS', 'admin', 'snowbird' ),
		'description' => esc_html_x( 'Add your custom CSS rules here without any &lt;style&gt;&lt;/style&gt; tag.', 'admin', 'snowbird' ),
		'section'     => 'snowbird_editors',
		'type'        => 'textarea',
	) );


	/**
	 * Adjust Message Transportation
	 */
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';


	/**
	 * Partials for Selective Refresh
	 */
	$wp_customize->selective_refresh->add_partial( 'site_brand', array(
		'selector'        => '.xf__header-logo',
		'settings'        => array( 'custom_logo' ),
		'render_callback' => 'snowbird_site_brand',
	) );

	$wp_customize->selective_refresh->add_partial( 'site_display_search', array(
		'selector'            => '.xf__search_container',
		'settings'            => array( 'site_display_search' ),
		'render_callback'     => 'snowbird_display_sidebar_search',
		'container_inclusive' => true,
		'fallback_refresh'    => false,
	) );

	$wp_customize->selective_refresh->add_partial( 'display_author_bio', array(
		'selector'            => '.xf__author-bio',
		'settings'            => array( 'post_display_author_bio' ),
		'render_callback'     => 'snowbird_display_author_bio',
		'container_inclusive' => true,
		'fallback_refresh'    => false,
	) );

	$wp_customize->selective_refresh->add_partial( 'display_share_this', array(
		'selector'            => '.xf__share-container',
		'settings'            => array( 'post_display_share_this', 'page_display_share_this' ),
		'render_callback'     => 'snowbird_display_share_this',
		'container_inclusive' => true,
		'fallback_refresh'    => false,
	) );

	$wp_customize->selective_refresh->add_partial( 'display_related_posts', array(
		'selector'            => '.xf__related',
		'settings'            => array( 'post_display_related' ),
		'render_callback'     => 'snowbird_display_related_posts',
		'container_inclusive' => true,
		'fallback_refresh'    => false,
	) );

	$wp_customize->selective_refresh->add_partial( 'footer_widget_area', array(
		'selector'            => '.xf__footer > .widget-area',
		'settings'            => array( 'footer_widget_area' ),
		'render_callback'     => 'snowbird_display_footer_widgets',
		'container_inclusive' => true,
		'fallback_refresh'    => false,
	) );

	$wp_customize->selective_refresh->add_partial( 'footer_menu_location', array(
		'selector'            => '.xf__container > .xf__footer-menu',
		'settings'            => array( 'footer_menu_location' ),
		'render_callback'     => 'snowbird_display_footer_menu',
		'container_inclusive' => true,
		'fallback_refresh'    => false,
	) );
}

add_action( 'customize_register', 'snowbird_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function snowbird_customize_preview_js() {
	$ext_js = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

	wp_enqueue_script(
		'snowbird-customizer-js',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/customizer-preview' . $ext_js ),
		array( 'jquery', 'customize-preview', 'customize-selective-refresh' ),
		Snowbird()->version(),
		true
	);
}

add_action( 'customize_preview_init', 'snowbird_customize_preview_js' );


/**
 * Binds JS handlers for Customize Controls.
 */
function snowbird_customize_controls_scripts() {
	$ext_js = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '.js' : '.min.js';

	wp_enqueue_script(
		'snowbird-customize-controls-js',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/customizer-controls' . $ext_js ),
		array( 'customize-controls', 'iris', 'underscore', 'wp-util' ),
		Snowbird()->version(),
		true
	);

	wp_localize_script(
		'snowbird-customize-controls-js',
		'snowbirdColorScheme',
		snowbird_get_color_schemes()
	);

}

add_action( 'customize_controls_print_footer_scripts', 'snowbird_customize_controls_scripts' );


/**
 * Outputs an Underscore template for generating CSS for active color scheme.
 *
 * The template generates the css dynamically for instant display in Live Customize Panel.
 */
function snowbird_color_scheme_css_template() {

	$colors = apply_filters( 'snowbird_color_scheme_css_template_colors', array(
		// Header
		'header_text_color'        => '{{ data.header_text_color }}',
		'header_background_color'  => '{{ data.header_background_color }}',
		'header_border_rgba'       => '{{ data.header_border_rgba }}',
		// Content
		'content_title_color'      => '{{ data.content_title_color }}',
		'content_text_color'       => '{{ data.content_text_color }}',
		'content_alt_text_color'   => '{{ data.content_alt_text_color }}',
		'content_accent_color'     => '{{ data.content_accent_color }}',
		'content_background_color' => '{{ data.content_background_color }}',
		'content_border_rgba'      => '{{ data.content_border_rgba }}',
		'content_accent_rgba'      => '{{ data.content_accent_rgba }}',
		// Footer
		'footer_title_color'       => '{{ data.footer_title_color }}',
		'footer_text_color'        => '{{ data.footer_text_color }}',
		'footer_alt_text_color'    => '{{ data.footer_alt_text_color }}',
		'footer_accent_color'      => '{{ data.footer_accent_color }}',
		'footer_background_color'  => '{{ data.footer_background_color }}',
		'footer_border_rgba'       => '{{ data.footer_border_rgba }}',
		'footer_accent_rgba'       => '{{ data.footer_accent_rgba }}',
		// Button
		'button_text_color'        => '{{ data.button_text_color }}',
		'button_background_color'  => '{{ data.button_background_color }}',
	) );
	?>
	<script type="text/html" id="tmpl-snowbird-color-scheme">
		<?php echo snowbird_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}

add_action( 'customize_controls_print_footer_scripts', 'snowbird_color_scheme_css_template' );


/**
 * Enqueues front-end CSS for the Header Overlay.
 *
 * @see wp_add_inline_style()
 */
function snowbird_header_overlay_css() {

	$header_overlay_color   = Snowbird()->mod( 'header_overlay_color' );
	$header_overlay_opacity = Snowbird()->mod( 'header_overlay_opacity' );
	$header_overlay_rgba    = Snowbird()->rgba( $header_overlay_color, $header_overlay_opacity );

	if ( $header_overlay_color === Snowbird()->mod_default( 'header_overlay_color' ) && $header_overlay_opacity === Snowbird()->mod_default( 'header_overlay_opacity' ) || empty ( $header_overlay_rgba ) ) {
		return;
	}

	$css = '
		/* Header Overlay */
		.xf__header .background .overlay {
			background-color: %s;
		}
	';

	$css = apply_filters( 'snowbird_header_overlay_css', sprintf( $css, $header_overlay_rgba ) );

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'snowbird-style', strip_tags( $css ) );
	}
}

add_action( 'wp_enqueue_scripts', 'snowbird_header_overlay_css' );


/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function snowbird_color_scheme_css() {

	$color_scheme_option = Snowbird()->mod( 'color_scheme' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = snowbird_get_color_scheme();

	// Convert text hex color to rgba.
	$header_border_rgba = Snowbird()->rgba( $color_scheme['header_background_color'], 10 );

	$content_border_rgba = Snowbird()->rgba( $color_scheme['content_text_color'], 10 );
	$content_accent_rgba = Snowbird()->rgba( $color_scheme['content_accent_color'], 65 );

	$footer_border_rgba = Snowbird()->rgba( $color_scheme['footer_text_color'], 10 );
	$footer_accent_rgba = Snowbird()->rgba( $color_scheme['footer_accent_color'], 65 );

	// If the rgba values are empty return early.
	if ( empty( $header_border_rgba ) || empty( $content_border_rgba ) || empty( $content_accent_rgba ) || empty( $footer_border_rgba ) || empty( $footer_accent_rgba ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$colors = array(
		// Header
		'header_text_color'        => $color_scheme['header_text_color'],
		'header_background_color'  => $color_scheme['header_background_color'],
		'header_border_rgba'       => $header_border_rgba,
		// Content
		'content_title_color'      => $color_scheme['content_title_color'],
		'content_text_color'       => $color_scheme['content_text_color'],
		'content_alt_text_color'   => $color_scheme['content_alt_text_color'],
		'content_accent_color'     => $color_scheme['content_accent_color'],
		'content_background_color' => $color_scheme['content_background_color'],
		'content_border_rgba'      => $content_border_rgba,
		'content_accent_rgba'      => $content_accent_rgba,
		// Footer
		'footer_title_color'       => $color_scheme['footer_title_color'],
		'footer_text_color'        => $color_scheme['footer_text_color'],
		'footer_alt_text_color'    => $color_scheme['footer_alt_text_color'],
		'footer_accent_color'      => $color_scheme['footer_accent_color'],
		'footer_background_color'  => $color_scheme['footer_background_color'],
		'footer_border_rgba'       => $footer_border_rgba,
		'footer_accent_rgba'       => $footer_accent_rgba,
		// Button
		'button_text_color'        => $color_scheme['button_text_color'],
		'button_background_color'  => $color_scheme['button_background_color'],

	);

	$css = snowbird_get_color_scheme_css( $colors );

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'snowbird-style', strip_tags( $css ) );
	}
}

add_action( 'wp_enqueue_scripts', 'snowbird_color_scheme_css' );


/**
 * Enqueues front-end CSS for user defined colors.
 *
 * @see wp_add_inline_style()
 */
function snowbird_custom_colors_css() {
	$css = '';

	// Header
	$css .= snowbird_get_header_colors_css( snowbird_get_header_colors() );

	// Content
	$css .= snowbird_get_content_title_color_css( snowbird_get_content_title_color() );
	$css .= snowbird_get_content_text_color_css( snowbird_get_content_text_color() );
	$css .= snowbird_get_content_alt_text_color_css( snowbird_get_content_alt_text_color() );
	$css .= snowbird_get_content_accent_color_css( snowbird_get_content_accent_color() );
	$css .= snowbird_get_content_background_color_css( snowbird_get_content_background_color() );

	// Footer
	$css .= snowbird_get_footer_title_color_css( snowbird_get_footer_title_color() );
	$css .= snowbird_get_footer_text_color_css( snowbird_get_footer_text_color() );
	$css .= snowbird_get_footer_alt_text_color_css( snowbird_get_footer_alt_text_color() );
	$css .= snowbird_get_footer_accent_color_css( snowbird_get_footer_accent_color() );
	$css .= snowbird_get_footer_background_color_css( snowbird_get_footer_background_color() );

	// Buttons
	$css .= snowbird_get_button_text_color_css( snowbird_get_button_text_color() );
	$css .= snowbird_get_button_background_color_css( snowbird_get_button_background_color() );

	$css = apply_filters( 'snowbird_custom_colors_css', $css );

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'snowbird-style', strip_tags( $css ) );
	}
}

add_action( 'wp_enqueue_scripts', 'snowbird_custom_colors_css', 11 );


/**
 * Enqueues User defined CSS into front-end.
 *
 * @see wp_add_inline_style()
 */
function snowbird_user_defined_css() {

	$user_defined_css = Snowbird()->option( 'custom_css' );

	if ( empty( $user_defined_css ) ) {
		return;
	}

	$css = '
		/* User defined CSS */
		%1$s
	';

	wp_add_inline_style( 'snowbird-style', sprintf(
		$css,
		strip_tags( $user_defined_css )
	) );
}

add_action( 'wp_enqueue_scripts', 'snowbird_user_defined_css', 999 );


/**
 * Outputs Editor CSS for color scheme via wp_ajax callback.
 */
function snowbird_editor_colors_css() {
	ob_clean();

	header( 'Content-Type: text/css; charset=' . get_option( 'blog_charset' ) );

	$color_scheme = snowbird_get_color_scheme();

	// Convert text hex color to rgba.
	$content_border_rgba = Snowbird()->rgba( $color_scheme['content_text_color'], 10 );
	$content_accent_rgba = Snowbird()->rgba( $color_scheme['content_accent_color'], 65 );

	// If the rgba values are empty return early.
	if ( empty( $content_border_rgba ) || empty( $content_accent_rgba ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$colors = array(
		// Content
		'content_title_color'      => $color_scheme['content_title_color'],
		'content_text_color'       => $color_scheme['content_text_color'],
		'content_alt_text_color'   => $color_scheme['content_alt_text_color'],
		'content_accent_color'     => $color_scheme['content_accent_color'],
		'content_background_color' => $color_scheme['content_background_color'],
		'content_border_rgba'      => $content_border_rgba,
		'content_accent_rgba'      => $content_accent_rgba,
		// Button
		'button_text_color'        => $color_scheme['button_text_color'],
		'button_background_color'  => $color_scheme['button_background_color'],
	);

	$css = <<<CSS

	/* Content Background Color */
	body {
		background-color: {$colors['content_background_color']};
		color: {$colors['content_text_color']};
	}

	/* Content Text Color */
	body,
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	select,
	textarea,
	.xf__button,
	.xf__nav-pages .nav-previous a,
	.xf__nav-pages .nav-next a,
	.xf__nav-pagination .prev,
	.xf__nav-pagination .next {
		color: {$colors['content_text_color']};
	}

	/* Content Border Color */
	code,
	kbd,
	tt,
	var,
	hr {
		background-color: {$colors['content_border_rgba']};
	}

	blockquote,
	table tr,
	.xf__nav-pages .nav-links {
		border-color: {$colors['content_border_rgba']};
	}


	/* Content Secondary Colors */
	hr.separator {
		background-color: {$colors['content_alt_text_color']};
	}

	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	select,
	textarea,
	.wp-caption {
		color: {$colors['content_alt_text_color']};
	}

	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	select,
	textarea {
		border-color: {$colors['content_alt_text_color']};
	}

	h1,
	h2,
	h3,
	h4,
	h5,
	h6 {
		color: {$colors['content_title_color']};
	}

	/* Content Accent Colors */
	a,
	blockquote,
	.xf__nav-pages .nav-next a:hover,
	.xf__nav-pages .nav-next a:focus,
	.xf__nav-pages .nav-previous a:hover,
	.xf__nav-pages .nav-previous a:focus,
	.xf__nav-pagination .next:hover,
	.xf__nav-pagination .next:focus,
	.xf__nav-pagination .prev:hover,
	.xf__nav-pagination .prev:focus {
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
	.xf__social.colors a,
	.xf__button:hover,
	.xf__button:focus {
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
	.xf__button:focus {
		border-color: {$colors['content_accent_color']};
	}

	/* Content Accent RGBA Colors */
	a:hover,
	a:focus,
	blockquote::before {
		color: {$colors['content_accent_rgba']};
	}

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
	.xf__button,
	.xf__button:hover,
	.xf__button:focus {
		color: {$colors['button_text_color']};
	}


	/* Button Background Color */
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.xf__button {
		background-color: {$colors['button_background_color']};
	}

	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.xf__button {
		border-color: {$colors['button_background_color']};
	}

CSS;

	$css = apply_filters( 'snowbird_editor_colors_css', $css );

	die( strip_tags( $css ) );
}

add_action( 'wp_ajax_' . Snowbird()->codename( 'editor-style' ), 'snowbird_editor_colors_css' );
