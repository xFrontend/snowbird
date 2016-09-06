<div class="xf__entry-sidebar clear">

	<div class="xf__entry-meta">
		<?php if ( is_author() || ! is_multi_author() ) : ?>

			<p class="entry-author vcard screen-reader-text" itemtype="http://schema.org/Person" itemscope="itemscope"
			   itemprop="author">
				<span><?php esc_html_e( 'by:', 'snowbird' ); ?></span> <span class="fn author"
				                                                             itemprop="name"><?php echo snowbird_get_author(); ?></span>
			</p>

			<?php if ( ! post_password_required() ) : ?>
				<p class="comment-count">
					<?php comments_popup_link(
						esc_html__( 'Add Comment', 'snowbird' ),
						'<span class="count">' . number_format_i18n( 1 ) . '</span> ' . esc_html__( 'Comment', 'snowbird' ),
						'<span class="count">%</span> ' . esc_html__( 'Comments', 'snowbird' )
					); ?>
				</p>
			<?php endif; ?>

		<?php else : ?>

			<?php echo get_avatar( get_post()->post_author, '85' ); ?>
			<p class="entry-author vcard" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author">
				<span><?php esc_html_e( 'by:', 'snowbird' ); ?></span>
				<span class="fn author" itemprop="name"><?php echo snowbird_get_author(); ?></span></p>

			<?php if ( ! post_password_required() ) : ?>
				<p class="comment-count">
					<?php comments_popup_link(
						esc_html__( 'Add Comment', 'snowbird' ),
						esc_html__( '1 Comment', 'snowbird' ),
						esc_html__( '% Comments', 'snowbird' ),
						'',
						''
					); ?>
				</p>
			<?php endif; ?>

		<?php endif; ?>

		<hr class="separator">
	</div>

	<?php
	/**
	 * Share this post
	 */
	$thumbnail = '';
	$thumb     = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

	if ( isset( $thumb[0] ) ) {
		$thumbnail = $thumb[0];
	}

	/**
	 * Check for registered action, if available
	 * bail to the action callback.
	 *
	 * @see https://developer.wordpress.org/reference/functions/add_action/
	 */
	if ( has_action( 'snowbird_share_this_loop' ) ) :
		do_action( 'snowbird_share_this_loop', $thumbnail );
	else : ?>
		<div class="xf__entry-share">
			<p class="share-title"><?php esc_html_e( 'Share on:', 'snowbird' ); ?></p>

			<p>
				<a class="facebook" title="<?php esc_html_e( 'Share on Facebook', 'snowbird' ); ?>"
				   href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>&amp;t=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>">
					<i class="fa fa-facebook"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'Facebook', 'snowbird' ); ?></span></a>
				<a class="twitter" title="<?php esc_html_e( 'Tweet This', 'snowbird' ); ?>"
				   href="https://twitter.com/share?text=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
					<i class="fa fa-twitter"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'Twitter', 'snowbird' ); ?></span></a>
				<a class="pinterest" title="<?php esc_html_e( 'Pin This', 'snowbird' ); ?>"
				   href="https://www.pinterest.com/pin/create/button/?url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>&amp;description=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;media=<?php echo urlencode( esc_url( $thumbnail ) ) ?>">
					<i class="fa fa-pinterest-p"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'Pinterest', 'snowbird' ); ?></span></a>
				<a class="gplus" title="<?php esc_html_e( 'Share on Google+', 'snowbird' ); ?>"
				   href="https://plus.google.com/share?url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
					<i class="fa fa-google-plus"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'Google+', 'snowbird' ); ?></span></a>
				<a class="linkedin" title="<?php esc_html_e( 'Share on LinkedIn', 'snowbird' ); ?>"
				   href="https://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
					<i class="fa fa-linkedin"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'LinkedIn', 'snowbird' ); ?></span></a>
				<a class="mail" title="<?php esc_html_e( 'Email This', 'snowbird' ); ?>"
				   href="mailto:?subject=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;body=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
					<i class="fa fa-envelope-o"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'Email', 'snowbird' ); ?></span></a>
			</p>
		</div>
		<?php
	endif;

	/**
	 * Make use of the spot for something cool.
	 *
	 * @see https://developer.wordpress.org/reference/functions/add_action/
	 */
	if ( has_action( 'snowbird_loop_sidebar' ) ) :
		do_action( 'snowbird_loop_sidebar' );
	endif; ?>
</div>
