<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;

/**
 * Snowbird functions and definitions
 */


/**
 * Snowbird only works in WordPress 4.5 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.5', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}


if ( ! function_exists( 'snowbird_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function snowbird_setup() {
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Snowbird, use a find and replace
		 * to change 'snowbird' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'snowbird', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'     => 200,
			'width'      => 200,
			'flex-width' => true,
		) );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1600, 600, array( 'top', 'center' ) );

		/**
		 * Menu Locations
		 */
		register_nav_menus( array(
			'primary'   => esc_html_x( 'Primary Menu', 'admin', 'snowbird' ),
			'secondary' => esc_html_x( 'Secondary Menu', 'admin', 'snowbird' ),
			'social'    => esc_html_x( 'Social Menu', 'admin', 'snowbird' )
		) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		) );

		/**
		 * Supports for SuperPack
		 */
		add_theme_support( 'superpack', array(
			'comment_avatar_size'    => 70,
			'enqueue_shortcodes_css' => false,
			'enqueue_widgets_css'    => false,
			'image_size_about'       => 'snowbird-thumb',
			'image_size_posts'       => 'snowbird-small',
			'social_icons'           => array(
				'menu_class' => 'xf__social colors circle',
			),
			'contact_fields'         => array(
				'container_class' => 'author-links',
				'action_hooks'    => 'snowbird_author_bio',
			),
		) );

		/**
		 * Custom Media sizes
		 */
		add_image_size( 'snowbird-large', 1110, 480, array( 'top', 'center' ) );
		add_image_size( 'snowbird-thumb', 400, 400, array( 'top', 'center' ) );
		add_image_size( 'snowbird-small', 120, 120, array( 'top', 'center' ) );

		/**
		 * Editor Styles
		 */
		$ext_css = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';

		add_editor_style( array(
			Snowbird()->protocol( get_template_directory_uri() . '/assets/css/font-awesome.min.css?v=4.6.3' ),
			Snowbird()->protocol( get_template_directory_uri() . '/assets/css/editor-style' . $ext_css . '?v=' . Snowbird()->version() ),
			admin_url( 'admin-ajax.php?action=' . Snowbird()->codename( 'editor-style' ) ),
		) );

		if ( snowbird_fonts_url() ) {
			add_editor_style( array( snowbird_fonts_url() ) );
		}
	}

endif;

add_action( 'after_setup_theme', 'snowbird_setup' );


if ( ! function_exists( 'snowbird_content_width' ) ) :
	/**
	 * Sets the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function snowbird_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'snowbird_content_width', 1110 );
	}

endif;

add_action( 'after_setup_theme', 'snowbird_content_width', 0 );


/**
 * Registers widget area for the theme.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function snowbird_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html_x( 'Sidebar', 'admin', 'snowbird' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	for ( $i = 1; $i <= 4; $i ++ ) {
		register_sidebar( array(
			'id'            => 'footer-' . $i,
			'name'          => sprintf( esc_html_x( 'Footer-%s', 'admin', 'snowbird' ), number_format_i18n( $i ) ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		) );
	}
}

add_action( 'widgets_init', 'snowbird_widgets_init' );


/**
 * Enqueues scripts and styles for the theme.
 */
function snowbird_scripts() {

	/**
	 * CSS
	 */
	$ext_css = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';

	if ( snowbird_fonts_url() ) {
		wp_enqueue_style( 'snowbird-fonts', snowbird_fonts_url(), array(), null );
	}

	wp_enqueue_style( 'font-awesome',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/css/font-awesome.min.css' ),
		array(),
		'4.6.3'
	);

	wp_enqueue_style( 'snowbird-style',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/css/style' . $ext_css ),
		array(),
		Snowbird()->version()
	);

	/**
	 * JavaScript
	 */
	$ext_js = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

	wp_enqueue_script( 'jquery-fitvids',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/vendor/jquery.fitvids.min.js' ),
		array( 'jquery' ),
		'1.1',
		true
	);

	wp_enqueue_script( 'jquery-nicescroll',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/vendor/jquery.nicescroll.min.js' ),
		array( 'jquery' ),
		'3.6.8',
		true
	);

	wp_enqueue_script( 'jquery-magnific-popup',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/vendor/jquery.magnific-popup.min.js' ),
		array( 'jquery' ),
		'1.1.0',
		true
	);

	wp_enqueue_script( 'snowbird-script',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/functions' . $ext_js ),
		array( 'jquery', 'jquery-fitvids', 'jquery-nicescroll', 'jquery-magnific-popup' ),
		Snowbird()->version(),
		true
	);

	wp_enqueue_script( 'snowbird-skip-link-focus-fix',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/skip-link-focus-fix' . $ext_js ),
		array(),
		Snowbird()->version(),
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular( array( 'attachment', 'post' ) ) || wp_attachment_is_image() ) {
		wp_enqueue_script( 'snowbird-keyboard-navigation',
			Snowbird()->protocol( get_template_directory_uri() . '/assets/js/keyboard-navigation' . $ext_js ),
			array( 'jquery' ),
			Snowbird()->version(),
			true
		);
	}

	wp_localize_script( 'snowbird-script', 'snowbirdReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'snowbird' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'snowbird' ) . '</span>',
	) );


	/**
	 * Remove Inline CSS from core Widget Comments
	 */
	add_filter( 'show_recent_comments_widget_style', '__return_false' );

}

add_action( 'wp_enqueue_scripts', 'snowbird_scripts' );


if ( ! function_exists( 'snowbird_fonts_url' ) ) :
	/**
	 * Returns Google Fonts URL for the theme.
	 *
	 * @return string
	 */
	function snowbird_fonts_url() {
		$fonts_url = '';
		$fonts     = array();

		/* translators: If there are characters in your language that are not supported by Anton, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== esc_html_x( 'on', 'Anton font: on or off', 'snowbird' ) ) {
			$fonts['heading'] = 'Anton';
		}

		/* translators: If there are characters in your language that are not supported by Droid Serif, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== esc_html_x( 'on', 'Droid Serif font: on or off', 'snowbird' ) ) {
			$fonts['body'] = 'Droid Serif:400,400italic,700,700italic';
		}

		$fonts   = apply_filters( 'snowbird_google_fonts', $fonts );
		$subsets = apply_filters( 'snowbird_google_fonts_subsets', array( 'latin', 'latin-ext' ), $fonts );

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( implode( ',', array_unique( $subsets ) ) ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}

endif;


/**
 * Core File for the theme.
 */
require get_template_directory() . '/inc/class-snowbird.php';

/**
 * Implements Customizer Settings and output.
 */
require get_template_directory() . '/inc/customizer-choices.php';
require get_template_directory() . '/inc/customizer-controls.php';
require get_template_directory() . '/inc/customizer-sanitize.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * Functions for the color schemes.
 */
require get_template_directory() . '/inc/scheme-functions.php';

/**
 * Custom template functions for the theme.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Actions/Filters and Custom functions that act independently.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Plugins Recommendation for theme.
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/plugins.php';
