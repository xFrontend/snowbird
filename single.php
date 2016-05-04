<?php get_header(); ?>

<main class="xf__main" itemprop="mainContentOfPage">
	<?php while ( have_posts() ) : the_post(); ?>

		<div itemscope="itemscope" itemtype="http://schema.org/Blog">
			<?php
			/**
			 * Post Details
			 */
			get_template_part( 'template-parts/content-single', get_post_format() ); ?>

			<?php
			/**
			 * Related Posts
			 */
			get_template_part( 'template-parts/post-related' ); ?>

			<?php
			/**
			 * Comments and Form
			 */
			comments_template(); ?>
		</div>

	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
