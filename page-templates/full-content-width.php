<?php
/**
 * Template Name: Full Content Width
 */

// Following filter override Global Content Width for the page
add_filter( 'snowbird_page_full_content_width', '__return_true' );

get_header(); ?>

<header class="xf__header">
	<div class="content xf__container">
		<?php the_title( '<h1 class="xf__page-title" itemprop="headline">', '</h1>' ); ?>
	</div>

	<?php
	/**
	 * Featured Image
	 */
	get_template_part( 'template-parts/featured-image-page' ); ?>
</header>

<main class="xf__main" itemprop="mainContentOfPage">
	<?php while ( have_posts() ) : the_post(); ?>

		<div itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
			<?php
			/**
			 * Page Content
			 */
			get_template_part( 'template-parts/content-page' ); ?>

			<?php
			/**
			 * Comments and Form
			 */
			comments_template(); ?>
		</div>

	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
