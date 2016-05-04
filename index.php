<?php get_header(); ?>

<main class="xf__main" itemprop="mainContentOfPage">
	<?php if ( have_posts() ) : ?>

		<div id="main" class="xf__posts" itemtype="http://schema.org/Blog" itemscope="itemscope">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php endwhile; ?>
		</div>

		<?php get_template_part( 'template-parts/loop-pagination' ); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content-none' ); ?>

	<?php endif; ?>
</main>

<?php get_footer(); ?>
