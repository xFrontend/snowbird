<?php
/**
 * Template part for displaying posts.
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

		<div class="content entry-content entry-summary" itemprop="text">
			<?php
			/**
			 * Display Post Excerpt for Search Listing
			 */
			the_excerpt(); ?>
		</div>
	</div>
</article>
