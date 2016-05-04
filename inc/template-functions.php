<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * List IDs of Contributors.
 *
 * @return array
 */
function snowbird_get_contributor_ids() {
	return apply_filters( 'snowbird_get_contributor_ids', get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) ) );
}


/**
 * Count Blog Authors. Reusing the same query used in `snowbird_list_authors` function.
 *
 * @return int
 */
function snowbird_get_contributor_count() {
	$contributor_ids = snowbird_get_contributor_ids();

	return count( $contributor_ids );
}


/**
 * Author Name/Link
 *
 * @return string
 */
function snowbird_get_author() {
	if ( is_multi_author() ) {
		$the_author = sprintf(
			'<a class="url" href="%1$s" title="%2$s" itemprop="url" rel="author">%3$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( esc_html__( 'Posts by %s', 'snowbird' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	} else {
		$the_author = esc_html( get_the_author() );
	}

	return apply_filters( 'snowbird_get_author', $the_author );
}


/**
 * Author Biography
 *
 * @param bool|false $generate
 *
 * @return string
 */
if ( ! function_exists( 'snowbird_get_author_bio' ) ) :

	function snowbird_get_author_bio( $generate = false ) {
		$bio = get_the_author_meta( 'description', get_the_author_meta( 'ID' ) );

		if ( $generate && empty( $bio ) ) {
			$post_count = count_user_posts( get_the_author_meta( 'ID' ) );

			// Translators: 1: author 2: total posts count
			$bio = sprintf(
				esc_html__( '%1$s has been contributed to a whooping %2$s.', 'snowbird' ),
				get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ),
				sprintf( _n( '%d article', '%d articles', number_format_i18n( $post_count ), 'snowbird' ), number_format_i18n( $post_count ) )
			);
		}

		return $bio;
	}

endif;


/**
 * Author Social Links
 *
 * @param int $author_id
 *
 * @return string
 */
if ( ! function_exists( 'snowbird_get_author_social_links' ) ) :

	function snowbird_get_author_social_links( $author_id = 0 ) {
		if ( $author_id < 1 ) {
			$author_id = get_the_author_meta( 'ID' );
		}
		$social = array(
			'facebook' => array(
				'title'      => esc_html__( 'Facebook', 'snowbird' ),
				'icon_class' => 'fa fa-facebook-f',
				'url'        => get_user_meta( $author_id, 'facebook', true ),
			),
			'twitter'  => array(
				'title'      => esc_html__( 'Twitter', 'snowbird' ),
				'icon_class' => 'fa fa-twitter',
				'url'        => get_user_meta( $author_id, 'twitter', true ),
			),
			'gplus'    => array(
				'title'      => esc_html__( 'Google+', 'snowbird' ),
				'icon_class' => 'fa fa-google-plus',
				'url'        => get_user_meta( $author_id, 'gplus', true ),
			),
			'linkedin' => array(
				'title'      => esc_html__( 'Linkedin', 'snowbird' ),
				'icon_class' => 'fa fa-linkedin',
				'url'        => get_user_meta( $author_id, 'linkedin', true ),
			),
			'link'     => array(
				'title'      => esc_html__( 'Link', 'snowbird' ),
				'icon_class' => 'fa fa-external-link-square',
				'url'        => get_the_author_meta( 'url', $author_id ),
			),
			'email'    => array(
				'title'      => esc_html__( 'Email', 'snowbird' ),
				'icon_class' => 'fa fa-envelope',
				'url'        => get_user_meta( $author_id, 'email_public', true ),
				'type'       => 'email',
			),
		);

		$html = '';

		foreach ( $social as $site => $arg ) {
			$default_attr = array(
				'class' => $site,
				'rel'   => 'me',
			);

			$attr = apply_filters( 'snowbird_social_link_attributes', $default_attr, $site );
			$attr = array_map( 'esc_attr', $attr );

			$icon = '<i ' . ( ! empty( $arg['icon_class'] ) ? ' class="' . esc_attr( $arg['icon_class'] ) . '"' : '' ) . '></i>';

			if ( isset( $arg['type'] ) && 'email' == $arg['type'] ) {
				$arg['url'] = Snowbird_Sanitize::email_output( $arg['url'] );
			} else {
				$arg['url'] = esc_url( $arg['url'] );
			}

			if ( ! empty( $arg['url'] ) ) {
				$html .= '<li>';
				$html .= '<a';
				$html .= ' href="' . $arg['url'] . '" ';
				foreach ( $attr as $name => $value ) {
					$html .= " $name=" . '"' . $value . '"';
				}
				$html .= '>' . $icon . '</a> ';
				$html .= '</li>';
			}
		}

		if ( ! empty ( $html ) ) {
			$html = '<ul class="author-links">' . $html . '</ul>';
		}

		return $html;
	}

endif;

/**
 * Next/Prev Links
 *
 * @param $format
 * @param $link
 * @param bool|false $in_same_term
 * @param string $excluded_terms
 * @param bool|true $previous
 * @param string $taxonomy
 *
 * @return mixed|void
 */
function snowbird_get_post_link( $format, $link, $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {
	if ( $previous && is_attachment() ) {
		$post = get_post( get_post()->post_parent );
	} else {
		$post = get_adjacent_post( $in_same_term, $excluded_terms, $previous, $taxonomy );
	}

	if ( ! $post ) {
		$output = '';
	} else {
		$title = $post->post_title;

		if ( empty( $post->post_title ) ) {
			$title = $previous ? esc_html__( 'Previous Post', 'snowbird' ) : esc_html__( 'Next Post', 'snowbird' );
		}

		$title = apply_filters( 'the_title', $title, $post->ID );

		$date = mysql2date( get_option( 'date_format' ), $post->post_date );
		$rel  = $previous ? 'prev' : 'next';

		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'snowbird-small' );

		if ( isset( $thumbnail[0] ) ) {
			$media_html = '<img class="xf__img" width="120" src="' . esc_url( $thumbnail[0] ) . '" alt="">';
		} else {
			$media_html = '';
		}

		$string = '<a href="' . esc_url( get_permalink( $post ) ) . '" rel="' . $rel . '">';

		$inlink = str_replace( '%title', $title, $link );
		$inlink = str_replace( '%date', $date, $inlink );

		$inlink = str_replace( '%thumb', $media_html, $inlink );

		$inlink = $string . $inlink . '</a>';

		$output = str_replace( '%link', $inlink, $format );
	}

	$adjacent = $previous ? 'previous' : 'next';

	return apply_filters( "snowbird_{$adjacent}_post_link", $output, $format, $link, $post, $adjacent );
}


/**
 * Previous Post Link
 *
 * @param string $format
 * @param string $link
 * @param bool|false $in_same_term
 * @param string $excluded_terms
 * @param string $taxonomy
 *
 * @return mixed|void
 */
function snowbird_get_previous_post_link( $format = '&laquo; %link', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	return snowbird_get_post_link( $format, $link, $in_same_term, $excluded_terms, true, $taxonomy );
}


/**
 * Next Post Link
 *
 * @param string $format
 * @param string $link
 * @param bool|false $in_same_term
 * @param string $excluded_terms
 * @param string $taxonomy
 *
 * @return mixed|void
 */
function snowbird_get_next_post_link( $format = '%link &raquo;', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	return snowbird_get_post_link( $format, $link, $in_same_term, $excluded_terms, false, $taxonomy );
}


/**
 * Get Logo Image
 *
 * @return string
 */
function snowbird_get_logo() {
	$html  = '';
	$logo  = snowbird_get_logo_data();
	$logo2 = snowbird_get_logo_data_2x();

	if ( '' === $logo ) {
		return $html;
	}

	$url_2x = isset( $logo2['url'] ) && $logo['url'] !== $logo2['url'] ? Snowbird()->protocol( $logo2['url'] ) : '';

	$html = sprintf(
		'<img class="xf__brand" alt="%s" width="%d" height="%d" src="%s" %s/>',
		esc_attr( get_bloginfo( 'name' ) ),
		(int) $logo['width'],
		(int) $logo['height'],
		esc_url( Snowbird()->protocol( $logo['url'] ) ),
		( '' !== $url_2x ) ? 'srcset="' . esc_attr( "$url_2x 2x" ) . '"' : ''
	);

	return apply_filters( 'snowbird_get_logo', $html );
}


/**
 * Get Logo Image Data.
 *
 * @return array|string
 */
function snowbird_get_logo_data() {

	if ( is_customize_preview() ) {
		return Snowbird()->url_to_image_data( get_theme_mod( 'logo_image' ) );
	}

	return get_theme_mod( 'logo_image_data', '' );
}


/**
 * Get Logo Image (Retina) Data.
 *
 * @return array|string
 */
function snowbird_get_logo_data_2x() {

	if ( is_customize_preview() ) {
		return Snowbird()->url_to_image_data( get_theme_mod( 'logo_image_2x' ) );
	}

	return get_theme_mod( 'logo_image_2x_data', '' );
}


/**
 * Sidebar Header Image
 *
 * @return array|false
 */
function snowbird_get_header_image_src() {
	if ( ! get_header_image() ) {
		return false;
	}

	if ( isset( get_custom_header()->attachment_id ) ) {
		$attachment_id = get_custom_header()->attachment_id;
	} else {
		$attachment_id = attachment_url_to_postid( get_header_image() );
	}

	return wp_get_attachment_image_src( $attachment_id, 'snowbird-thumb' );
}


/**
 * Footer Content
 *
 * @return mixed|void
 */
function snowbird_get_footer_content() {
	// Get Footer text/macro
	$html = Snowbird()->option( 'footer_text' );

	// Current Year
	$html = str_replace( '%CUR_YEAR%', date( 'Y' ), $html );
	// Site Title
	$html = str_replace( '%SITE_TITLE%', get_bloginfo( 'name' ), $html );
	// Site Link
	$html = str_replace( '%SITE_LINK%',
		sprintf(
			'<a href="%1$s" title="%3$s">%2$s</a>',
			esc_url( home_url( '/' ) ),
			esc_html( get_bloginfo( 'name' ) ),
			esc_attr( get_bloginfo( 'name' ) )
		),
		$html
	);
	// WordPress Link
	$html = str_replace( '%WP_LINK%',
		sprintf(
			'<a href="%1$s">%2$s</a>',
			'http://wordpress.org',
			esc_html__( 'WordPress', 'snowbird' )
		),
		$html
	);

	return apply_filters( 'snowbird_get_footer_content', $html );
}


/**
 * Footer Widget Classes
 *
 * @return string
 */
function snowbird_get_footer_widget_classes() {
	$option = Snowbird()->mod( 'footer_widget_area' );

	switch ( $option ) {
		case 'one-fourth':
			$classes[] = 'column';
			$classes[] = 'one-fourth';
			break;

		case 'one-third':
			$classes[] = 'column';
			$classes[] = 'one-third';
			break;

		case 'one-half':
			$classes[] = 'column';
			$classes[] = 'one-half';
			break;

		case 'one':
			$classes[] = 'full';
			break;

		default:
			$classes[] = 'column';
			$classes[] = 'one-third';
			break;
	}

	$classes = array_map( 'esc_attr', $classes );

	return apply_filters( 'snowbird_get_footer_widget_classes', trim( join( ' ', $classes ) ) );
}


/**
 * Whether to display Footer Widgets Area?
 *
 * @return bool|int
 */
if ( ! function_exists( 'snowbird_maybe_display_footer' ) ) :

	function snowbird_maybe_display_footer() {
		$option = Snowbird()->mod( 'footer_widget_area' );

		switch ( $option ) {
			case 'one-fourth':
				$columns = 4;
				break;

			case 'one-third':
				$columns = 3;
				break;

			case 'one-half':
				$columns = 2;
				break;

			case 'one':
				$columns = 1;
				break;

			default:
				$columns = 0;
				break;
		}

		if ( 1 > $columns ) {
			return false;
		}

		for ( $i = 1; $i <= $columns; $i ++ ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				return $columns;
			}
		}

		return false;
	}

endif;

/**
 * Display Comments
 *
 * @param $comment
 * @param $args
 * @param $depth
 */
if ( ! function_exists( 'snowbird_list_comments' ) ) :

	function snowbird_list_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?> itemtype="https://schema.org/Comment" itemscope="itemscope" itemprop="comment" >

		<div class="xf__wrap">
			<div class="gravatar">
				<?php echo get_avatar( $comment, '80' ); ?>
			</div>

			<div class='comment-content'>
				<header class="comment-header">
					<h5 class="comment-author-name" itemtype="https://schema.org/Person" itemscope="itemscope"
					    itemprop="creator">
						<?php $link = get_comment_author_url(); ?>
						<?php if ( ! empty( $link ) ) : ?>
							<a href="<?php echo esc_url( $link ) ?>" itemprop="url"><cite
									itemprop="name"><?php echo get_comment_author() ?></cite></a>
						<?php else : ?>
							<cite itemprop="name"><?php echo get_comment_author() ?></cite>
						<?php endif; ?>
					</h5>

					<div class="comment-date xf__meta">
						<a href="<?php echo esc_url( get_comment_link() ); ?>">
							<?php // Translators: 1: date 2: time ?>
							<time datetime="<?php echo esc_attr( get_comment_time( 'c' ) ); ?>"
							      itemprop="dateCreated"><?php printf( esc_html__( '%1$s at %2$s', 'snowbird' ), get_comment_date(), get_comment_time() ) ?></time>
						</a>
					</div>
				</header>

				<div class="content entry-content" itemprop="text">
					<?php comment_text(); ?>

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="xf__meta"><?php esc_html_e( 'Your comment is awaiting moderation.', 'snowbird' ) ?></p>
					<?php endif; ?>
				</div>

				<?php comment_reply_link( array_merge( $args, array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<footer class="comment-footer">',
					'after'     => '</footer>'
				) ) ); ?>
			</div>
		</div>
		<?php
	}

endif;


/**
 * Display Contributors
 */
if ( ! function_exists( 'snowbird_list_contributors' ) ) :

	function snowbird_list_contributors() {
		$contributor_ids = snowbird_get_contributor_ids();

		foreach ( $contributor_ids as $contributor_id ) {
			$post_count = count_user_posts( $contributor_id );

			// Whether to hide if user has not published a post (yet).
			$hide_non_published_author = apply_filters( 'snowbird_hide_non_published_author', true );

			if ( false !== $hide_non_published_author && ! $post_count ) {
				continue;
			} ?>
			<div class="xf__contributor">
				<div class="wrapper">
					<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 170 ); ?></div>

					<div class="content">
						<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>

						<p class="contributor-bio">
							<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
						</p>

						<?php echo snowbird_get_author_social_links( $contributor_id ); ?>

						<?php if ( $post_count ) : ?>
							<a class="xf__button contributor-posts-link"
							   href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
								<?php printf( _n( '%d Article', '%d Articles', number_format_i18n( $post_count ), 'snowbird' ), number_format_i18n( $post_count ) ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
		}
	}

endif;
