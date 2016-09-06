<?php
/**
 * Template part for displaying single posts.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/BlogPosting"
         itemscope="itemscope" itemprop="blogPost">
	<?php
	/**
	 * Featured Image
	 */
	get_template_part( 'template-parts/featured-image' ); ?>

	<div class="xf__post-wrapper">
		<div class="xf__container xf__entry-container">

			<header class="xf__post-header">
				<?php
				/**
				 * Post Meta
				 */
				get_template_part( 'template-parts/post-meta' ); ?>

				<?php
				/**
				 * Post Title
				 */
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
			</header>

			<?php
			/**
			 * Post Author Bio
			 */
			snowbird_display_author_bio(); ?>

			<div class="content entry-content" itemprop="text">
				<?php
				/**
				 * Post Content
				 */
				the_content(); ?>

				<?php
				/**
				 * Post Pages Links
				 */
				wp_link_pages( array(
					'before'      => '<div class="xf__nav-pagination">' . esc_html__( 'Pages:', 'snowbird' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-numbers">',
					'link_after'  => '</span>'
				) ); ?>
			</div>

			<footer class="xf__post-footer">
				<?php
				/**
				 * Post Tags
				 */
				$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'tags separator', 'snowbird' ) );

				if ( $tags_list && ! post_password_required() ) : ?>
					<p class="xf__meta-item link-tag" itemprop="text">
						<span><?php esc_html_e( 'Tagged with: ', 'snowbird' ); ?></span> <?php echo $tags_list; ?>
					</p>
				<?php endif; ?>

				<?php
				/**
				 * Social Share
				 */
				snowbird_display_share_this(); ?>
			</footer>
		</div>

		<?php
		/**
		 * Post Navigation (Prev/Next)
		 */
		get_template_part( 'template-parts/post-navigation' ); ?>
	</div>
</article>
