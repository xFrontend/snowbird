<?php
/**
 * Snowbird functions and definitions
 *
 * @package Snowbird
 */

/**
 * Snowbird only works in WordPress 4.1.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1.1', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
if ( ! function_exists( 'snowbird_setup' ) ) :

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
			'social_icons'           => true,
			'social_icons_class'     => 'xf__social colors circle',
		) );

		/**
		 * Custom Media sizes
		 */
		add_image_size( 'snowbird-thumb', 400, 400, array( 'top', 'center' ) );
		add_image_size( 'snowbird-small', 120, 120, array( 'top', 'center' ) );

		/**
		 * Editor Styles
		 */
		$ext_css = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';

		add_editor_style( array(
			Snowbird()->protocol( get_template_directory_uri() . '/assets/css/editor-style' . $ext_css . '?v=' . Snowbird()->version() ),
			snowbird_fonts_url(),
			admin_url( 'admin-ajax.php?action=' . Snowbird()->codename( 'editor-style' ) ),
		) );
	}

endif;

add_action( 'after_setup_theme', 'snowbird_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function snowbird_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'snowbird_content_width', 920 );
}

add_action( 'after_setup_theme', 'snowbird_content_width', 0 );


/**
 * Register widget area.
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
 * Enqueue scripts and styles.
 */
function snowbird_scripts() {

	/**
	 * CSS
	 */
	$ext_css = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';

	wp_enqueue_style( 'snowbird-fonts', snowbird_fonts_url(), array(), null );

	wp_enqueue_style( 'font-awesome',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/css/font-awesome.min.css' ),
		array(),
		'4.4.0'
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

	wp_enqueue_script( 'fitvids',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/vendor/jquery.fitvids.min.js' ),
		array( 'jquery' ),
		'1.1',
		true
	);

	wp_enqueue_script( 'nicescroll',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/vendor/jquery.nicescroll.min.js' ),
		array( 'jquery' ),
		'3.6.0',
		true
	);

	wp_enqueue_script( 'magnific-popup',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/vendor/jquery.magnific-popup.min.js' ),
		array( 'jquery' ),
		'1.0.0',
		true
	);

	wp_enqueue_script( 'snowbird-script',
		Snowbird()->protocol( get_template_directory_uri() . '/assets/js/functions' . $ext_js ),
		array( 'jquery', 'fitvids', 'nicescroll', 'magnific-popup' ),
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


/**
 * Adds classes for the TinyMCE Editor
 */
function snowbird_editor_settings( $settings ) {
	$settings['body_class'] .= ' xf__entry xf__singular entry-content';

	return $settings;
}

add_filter( 'tiny_mce_before_init', 'snowbird_editor_settings' );


/**
 * Add Social Links for User/Profile.
 *
 * @param $user_contact_methods
 *
 * @return mixed
 */
function snowbird_user_contacts_fields( $user_contact_methods ) {
	unset( $user_contact_methods['yim'] );
	unset( $user_contact_methods['aim'] );
	unset( $user_contact_methods['jabber'] );

	$user_contact_methods['facebook']     = esc_html_x( 'Facebook Profile URL', 'admin', 'snowbird' );
	$user_contact_methods['twitter']      = esc_html_x( 'Twitter Profile URL', 'admin', 'snowbird' );
	$user_contact_methods['gplus']        = esc_html_x( 'Google+ Profile URL', 'admin', 'snowbird' );
	$user_contact_methods['linkedin']     = esc_html_x( 'LinkedIn Profile URL', 'admin', 'snowbird' );
	$user_contact_methods['email_public'] = esc_html_x( 'Email (Public)', 'admin', 'snowbird' );

	return $user_contact_methods;
}

add_filter( 'user_contactmethods', 'snowbird_user_contacts_fields' );

/**
 * Returns Google Fonts URL for the theme
 *
 * @return string
 */
if ( ! function_exists( 'snowbird_fonts_url' ) ) :

	function snowbird_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Anton, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== esc_html_x( 'on', 'Anton font: on or off', 'snowbird' ) ) {
			$fonts[] = 'Anton';
		}

		/* translators: If there are characters in your language that are not supported by Droid Serif, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== esc_html_x( 'on', 'Droid Serif font: on or off', 'snowbird' ) ) {
			$fonts[] = 'Droid+Serif:400,400italic,700,700italic';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => implode( '%7C', $fonts ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}

endif;

/**
 * Load the Core Files.
 */
require get_template_directory() . '/inc/class-snowbird.php';
require get_template_directory() . '/inc/class-snowbird-choices.php';
require get_template_directory() . '/inc/class-snowbird-sanitize.php';
require get_template_directory() . '/inc/class-snowbird-customize-controls.php';

/**
 * Implements Customizer Settings and output.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Functions for the color schemes.
 */
require get_template_directory() . '/inc/scheme-functions.php';

/**
 * Custom template functions for this theme.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Actions/Filters and Custom functions that act independently.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Loads TGM Plugin Activation Class
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';


/**
 * Recommends Plugins for Snowbird
 */
function snowbird_recommend_plugins() {

	$plugins = array(
		array(
			'name'     => 'SuperPack',
			'slug'     => 'superpack',
			'required' => false,
		),
		array(
			'name'     => 'Jetpack by WordPress.com',
			'slug'     => 'jetpack',
			'required' => false,
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => 'WordPress SEO',
			'slug'     => 'wordpress-seo',
			'required' => false,
		),
	);

	$config = array(
		// Default absolute path to pre-packaged plugins.
		'default_path' => '',
		// Menu slug.
		'menu'         => 'install-plugins',
		// Show admin notices or not.
		'has_notices'  => true,
		// If false, a user cannot dismiss the nag message.
		'dismissable'  => true,
		// If 'dismissable' is false, this message will be output at top of nag.
		'dismiss_msg'  => '',
		// Automatically activate plugins after installation or not.
		'is_automatic' => false,
		// Message to output right before the plugins table.
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html_x( 'Install Recommended Plugins', 'admin', 'snowbird' ),
			'menu_title'                      => esc_html_x( 'Install Plugins', 'admin', 'snowbird' ),
			// %s = plugin name.
			'installing'                      => esc_html_x( 'Installing Plugin: %s', 'admin', 'snowbird' ),
			'oops'                            => esc_html_x( 'Something went wrong with the plugin API.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_install_required'     => _nx_noop( 'Current theme requires the following plugin: %1$s.', 'Current Theme requires the following plugins: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_install_recommended'  => _nx_noop( 'Current theme recommends the following plugin: %1$s.', 'Current Theme recommends the following plugins: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_cannot_install'           => _nx_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_activate_required'    => _nx_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_can_activate_recommended' => _nx_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_cannot_activate'          => _nx_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_ask_to_update'            => _nx_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with current Theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with current Theme: %1$s.', 'admin', 'snowbird' ),
			// %1$s = plugin name(s).
			'notice_cannot_update'            => _nx_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'admin', 'snowbird' ),
			'install_link'                    => _nx_noop( 'Begin installing plugin', 'Begin installing plugins', 'admin', 'snowbird' ),
			'activate_link'                   => _nx_noop( 'Begin activating plugin', 'Begin activating plugins', 'admin', 'snowbird' ),
			'return'                          => esc_html_x( 'Return to Recommended Plugins Installer', 'admin', 'snowbird' ),
			'plugin_activated'                => esc_html_x( 'Plugin activated successfully.', 'admin', 'snowbird' ),
			// %s = dashboard link.
			'complete'                        => esc_html_x( 'All plugins installed and activated successfully. %s', 'admin', 'snowbird' ),
			// Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			'nag_type'                        => 'updated'
		)
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'snowbird_recommend_plugins' );
