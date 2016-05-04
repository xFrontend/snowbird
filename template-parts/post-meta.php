<?php
/**
 * Display for only Post
 */
if ( 'post' === get_post_type() ) : ?>
	<div class="xf__meta" itemprop="text">
		<?php
		/**
		 * Icons for Sticky, Private/Protected Post
		 */
		if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="xf__meta-item sticky"><i class="fa fa-thumb-tack"></i> </span>
		<?php elseif ( post_password_required() || 'private' === get_post_status() ) : ?>
			<span class="xf__meta-item private"><i class="fa fa-lock"></i> </span>
		<?php endif; ?>

		<?php
		/**
		 * Post Categories
		 */
		$categories_list = get_the_category_list( esc_html_x( ', ', 'category separator', 'snowbird' ) );

		if ( $categories_list ) : ?>
			<span class="xf__meta-item link-category"><?php echo $categories_list; ?></span>
		<?php endif; ?>

		<?php
		/**
		 * Post Time - Published on
		 */
		printf(
			'<span class="xf__meta-item posted-on"><a href="%1$s" rel="bookmark"><time class="entry-date published" datetime="%2$s" itemprop="datePublished" >%3$s</time></a></span>',
			esc_attr( get_the_permalink() ),
			esc_attr( get_the_time( 'c' ) ),
			esc_html( get_the_time( get_option( 'date_format' ) ) )
		);
		/* Post Time - Updated On */
		printf(
			'<span class="xf__meta-item updated-on screen-reader-text"><time class="entry-date updated" datetime="%1$s" itemprop="dateModified" >%2$s</time></span>',
			esc_attr( get_the_modified_time( 'c' ) ),
			esc_html( get_the_modified_time( get_option( 'date_format' ) ) )
		); ?>
	</div>
<?php endif; ?>
