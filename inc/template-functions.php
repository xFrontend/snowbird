<?php

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly
endif;


/**
 * Returns IDs of Contributors.
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
 * Returns Blog Authors Count, using `snowbird_get_contributor_ids` function.
 *
 * @return int
 */
function snowbird_get_contributor_count() {
	$contributor_ids = snowbird_get_contributor_ids();

	return count( $contributor_ids );
}


/**
 * Returns Author Name/Link.
 *
 * @return string
 */
function snowbird_get_author() {
	if ( is_multi_author() ) {
		$the_author = sprintf(
			'<a class="url" href="%1$s" title="%2$s" itemprop="url" rel="author">%3$s</a>',
			esc_url( get_author_posts_url( get_post()->post_author ) ),
			esc_attr( sprintf( esc_html__( 'Posts by %s', 'snowbird' ), get_the_author_meta( 'display_name', get_post()->post_author ) ) ),
			esc_html( get_the_author_meta( 'display_name', get_post()->post_author ) )
		);
	} else {
		$the_author = esc_html( get_the_author_meta( 'display_name', get_post()->post_author ) );
	}

	return apply_filters( 'snowbird_get_author', $the_author );
}


if ( ! function_exists( 'snowbird_get_author_bio' ) ) :
	/**
	 * Returns Author Biography.
	 *
	 * @param bool|false $generate
	 *
	 * @return string
	 */
	function snowbird_get_author_bio( $generate = false ) {
		$bio = get_the_author_meta( 'description', get_post()->post_author );

		if ( $generate && empty( $bio ) ) {
			$post_count = count_user_posts( get_post()->post_author );

			// Translators: 1: author 2: total posts count
			$bio = sprintf(
				esc_html__( '%1$s has been contributed to a whooping %2$s.', 'snowbird' ),
				get_the_author_meta( 'display_name', get_post()->post_author ),
				sprintf( _n( '%d article', '%d articles', number_format_i18n( $post_count ), 'snowbird' ), number_format_i18n( $post_count ) )
			);
		}

		return $bio;
	}

endif;


/**
 * Returns Query object for Related Posts.
 *
 * @param int $count
 * @param int $current_post_id
 * @param bool|true $cache
 *
 * @return mixed|WP_Error|WP_Query
 */
function snowbird_get_related_posts( $count = 4, $current_post_id = 0, $cache = true ) {
	$count           = 0 < intval( $count ) ? $count : 4;
	$current_post_id = 0 < $current_post_id ? $current_post_id : get_the_ID();

	if ( ! is_single() || 1 > $current_post_id ) {
		return new WP_Error( 'skipped', esc_html__( 'No posts to show.', 'snowbird' ) );
	}

	$cache_key  = Snowbird()->cache_key( 'd', 'related_posts' . $count . $current_post_id );
	$cache_time = apply_filters( 'snowbird_related_posts_cache_time', MINUTE_IN_SECONDS );

	if ( false === ( $data = get_transient( $cache_key ) ) || false === $cache ) {
		$post_cats = wp_get_object_terms( $current_post_id, 'category', array( 'fields' => 'ids' ) );
		$post_tags = wp_get_object_terms( $current_post_id, 'post_tag', array( 'fields' => 'ids' ) );

		$args = apply_filters( 'snowbird_related_posts_query', array(
			// date | rand
			'orderby'        => 'rand',
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'posts_per_page' => $count,
			'paged'          => 1,
			// Exclude current post
			'post__not_in'   => array( $current_post_id ),
			// has_password true means posts with passwords, false means posts without.
			'has_password'   => false,
			'no_found_rows'  => true,
			'tax_query'      => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $post_cats,
					'operator' => 'IN',
				),
				array(
					'taxonomy' => 'post_tag',
					'field'    => 'id',
					'terms'    => $post_tags,
					'operator' => 'IN',
				),
			),
		), $count, $current_post_id, $post_cats, $post_tags );

		$data = new WP_Query( $args );

		set_transient( $cache_key, $data, $cache_time );
	}

	return $data;
}


/**
 * Returns Next/Prev Link w/ thumbnail when available.
 * A replacement for `get_adjacent_post_link` core function.
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
 * Returns Previous Post Link w/ thumbnail when available.
 * A replacement for `get_previous_post_link` core function.
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
 * Returns Next Post Link w/ thumbnail when available.
 * A replacement for `get_next_post_link` core function.
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
 * Returns Image Data for Sidebar Header.
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
 * Returns Footer Widget Classes.
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


if ( ! function_exists( 'snowbird_maybe_display_footer' ) ) :
	/**
	 * Returns whether to display Footer Widgets Area.
	 *
	 * @return bool|int
	 */
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


if ( ! function_exists( 'snowbird_site_brand' ) ) :
	/**
	 * Displays Site Brand - Text or Image based on Settings.
	 */
	function snowbird_site_brand() {

		if ( has_custom_logo() ) :

			the_custom_logo();

		else : ?>

			<h2 class="site-title" itemprop="headline">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>

			<?php
			/**
			 * Site Tagline
			 */
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>

		<?php endif;
	}

endif;


if ( ! function_exists( 'snowbird_display_sidebar_search' ) ) :
	/**
	 * Displays Serach box on Sidebar based on Settings.
	 */
	function snowbird_display_sidebar_search() {
		if ( Snowbird()->mod( 'site_display_search' ) ): ?>
			<div class="xf__search_container widget">
				<?php echo snowbird_filter_get_search_form(); ?>
			</div>
		<?php else : ?>
			<div class="xf__search_container" style="display: none;"></div>
			<?php
		endif;
	}

endif;


if ( ! function_exists( 'snowbird_display_author_bio' ) ) :
	/**
	 * Displays Author Bio on Single Post based on Settings.
	 */
	function snowbird_display_author_bio() {

		if ( is_customize_preview() && ! Snowbird()->mod( 'post_display_author_bio' ) ) :
			?>
			<div class="xf__author-bio" style="display: none"></div>
			<?php
		elseif ( ! Snowbird()->mod( 'post_display_author_bio' ) ) : ?>
			<p class="entry-author vcard screen-reader-text" itemtype="http://schema.org/Person" itemscope="itemscope"
			   itemprop="author">
				<span><?php esc_html_e( 'Written by', 'snowbird' ); ?></span>
				<span class="fn" itemprop="name"><?php echo snowbird_get_author(); ?></span></p>
			<?php
		else :
			get_template_part( 'template-parts/post-author' );
		endif;
	}

endif;


if ( ! function_exists( 'snowbird_display_share_this' ) ) :
	/**
	 * Displays Share This on Single Post/Page based on Settings.
	 */
	function snowbird_display_share_this() {
		if ( is_single() && ! is_attachment() && Snowbird()->mod( 'post_display_share_this' ) ) :
			get_template_part( 'template-parts/share-this' );
		elseif ( is_page() && Snowbird()->mod( 'page_display_share_this' ) ) :
			get_template_part( 'template-parts/share-this' );
		elseif ( is_customize_preview() ) : ?>
			<div class="xf__share-container" style="display: none;"></div>
		<?php endif;
	}

endif;


if ( ! function_exists( 'snowbird_display_related_posts' ) ) :
	/**
	 * Displays Related Posts based on Settings.
	 */
	function snowbird_display_related_posts() {
		/**
		 * Return early based on the setting
		 */
		if ( is_customize_preview() && ! Snowbird()->mod( 'post_display_related' ) ) {
			?>
			<div class="xf__block xf__related" style="display: none;"></div><?php

			return;
		} elseif ( ! Snowbird()->mod( 'post_display_related' ) ) {
			return;
		}

		/**
		 * Get Related posts data
		 */
		$data = snowbird_get_related_posts( 4 );

		if ( ! is_wp_error( $data ) && $data->have_posts() ) : ?>
			<div class="xf__block xf__related">
				<?php
				switch ( $data->post_count ) {
					case 4:
						$class_container = 'xf__full-width';
						$class_item      = 'related-item one-fourth';
						break;

					case 3:
						$class_container = 'xf__full-width';
						$class_item      = 'related-item one-third';
						break;

					default:
						$class_container = 'xf__container';
						$class_item      = 'related-item one-half';
				} ?>
				<div class="<?php echo esc_attr( $class_container ); ?>">
					<div class="xf__block-header screen-reader-text">
						<h3 class="xf__block-title related-title"><?php _e( 'Related Entries', 'snowbird' ); ?></h3>
					</div>

					<div class="row">
						<?php while ( $data->have_posts() ) : $data->the_post(); ?>

							<div class="column <?php echo esc_attr( $class_item ); ?>">
								<a href="<?php the_permalink(); ?>">
									<div class="wrapper">
										<div class="content">
											<h4 class="post-title"><?php the_title(); ?></h4>

											<?php
											printf(
												'<span class="post-date"><time class="entry-date published" datetime="%1$s">%2$s</time></span>',
												esc_attr( get_the_time( 'c' ) ),
												esc_html( get_the_time( get_option( 'date_format' ) ) )
											); ?>
										</div>
									</div>

									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'snowbird-thumb' ); ?>

										<div class="overlay"></div>
									<?php elseif ( has_action( 'snowbird_related_post_default_thumbnail' ) ) :
										do_action( 'snowbird_related_post_default_thumbnail' ); ?>

										<div class="overlay"></div>
									<?php endif; ?>
								</a>
							</div>

						<?php endwhile; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php
		/**
		 * Restores the $post global
		 */
		wp_reset_postdata();
	}

endif;


if ( ! function_exists( 'snowbird_display_footer_widgets' ) ) :
	/**
	 * Displays Footer Widgets based on Settings.
	 */
	function snowbird_display_footer_widgets() {
		if ( $columns = snowbird_maybe_display_footer() ) :
			?>
			<div class="widget-area">
				<div class="xf__container row clear">
					<?php
					for ( $i = 1; $i <= $columns; $i ++ ) {
						if ( is_active_sidebar( 'footer-' . $i ) ) {
							echo '<div class="' . esc_attr( snowbird_get_footer_widget_classes() ) . ( 1 == $i ? ' first' : '' ) . ( $i == $columns ? ' last' : '' ) . '">';

							dynamic_sidebar( 'footer-' . $i );

							echo '</div>';
						}
					} ?>
				</div>
			</div>
			<?php

		elseif ( is_customize_preview() ) :
			echo '<nav class="widget-area" style="display:none;"></nav>';
		endif;
	}

endif;


if ( ! function_exists( 'snowbird_display_footer_menu' ) ) :
	/**
	 * Displays Footer Menu based on Settings.
	 */
	function snowbird_display_footer_menu() {
		if ( 'social' === Snowbird()->mod( 'footer_menu_location' ) && has_nav_menu( 'social' ) ) :

			wp_nav_menu( array(
				'theme_location'  => 'social',
				'container'       => 'nav',
				'container_class' => 'xf__footer-menu xf__nav-social',
				'depth'           => 1,
				'menu_class'      => 'xf__social colors circle',
				'link_before'     => '<span class="screen-reader-text">',
				'link_after'      => '</span>',
			) );

		elseif ( 'secondary' === Snowbird()->mod( 'footer_menu_location' ) && has_nav_menu( 'secondary' ) ) :

			wp_nav_menu( array(
				'theme_location'  => 'secondary',
				'container'       => 'nav',
				'container_class' => 'xf__footer-menu xf__nav-footer',
				'depth'           => 1,
			) );

		elseif ( is_customize_preview() ) :
			echo '<nav class="xf__footer-menu" style="display:none;"></nav>';
		endif;
	}

endif;


if ( ! function_exists( 'snowbird_list_comments' ) ) :
	/**
	 * Displays Comments.
	 *
	 * @param $comment
	 * @param $args
	 * @param $depth
	 */
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


if ( ! function_exists( 'snowbird_list_contributors' ) ) :
	/**
	 * Displays Contributors.
	 */
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

						<?php
						/**
						 * Make use of the spot for something cool.
						 *
						 * @see https://developer.wordpress.org/reference/functions/add_action/
						 */
						if ( has_action( 'snowbird_author_bio' ) ) :
							do_action( 'snowbird_author_bio', $contributor_id );
						endif; ?>

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
