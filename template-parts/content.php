<?php
/**
 * Template part for displaying posts.
 *
 * @package Snowbird
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/BlogPosting"
         itemscope="itemscope" itemprop="blogPost">

	<?php
	/**
	 * Featured Image
	 */
	get_template_part( 'template-parts/featured-image' ); ?>

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
			the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php
			/**
			 * Post Sidebar
			 */
			get_template_part( 'template-parts/loop-sidebar' ); ?>
		</header>

		<?php
		/**
		 * Post Content
		 */
		if ( 'full' == Snowbird()->mod( 'loop_content' ) && get_the_content() ) : ?>
			<div class="content entry-content" itemprop="text">
				<?php the_content(); ?>
			</div>
			<?php
		/**
		 * Post Excerpt
		 */
		elseif ( 'excerpt' == Snowbird()->mod( 'loop_content' ) && get_the_excerpt() ) : ?>
			<div class="content entry-content entry-summary" itemprop="text">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>
	</div>
</article>
