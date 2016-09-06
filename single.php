<?php get_header(); ?>

<?php
/**
 * Conditional Primary Site Header
 */
if ( 'alternate' == Snowbird()->mod( 'post_layout_type' ) ) {
	get_template_part( 'template-parts/primary-site-header' );
} ?>

<main class="xf__main" itemprop="mainContentOfPage">
	<?php while ( have_posts() ) : the_post(); ?>

		<div itemscope="itemscope" itemtype="http://schema.org/Blog">
			<?php
			/**
			 * Post Details
			 */
			if ( 'alternate' == Snowbird()->mod( 'post_layout_type' ) ) :
				get_template_part( 'template-parts/content-single-alternate', get_post_format() );
			else:
				get_template_part( 'template-parts/content-single', get_post_format() );
			endif;
			?>

			<?php
			/**
			 * Related Posts
			 */
			snowbird_display_related_posts(); ?>

			<?php
			/**
			 * Comments and Form
			 */
			comments_template(); ?>
		</div>

	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
