<?php get_header(); ?>

<header class="xf__header">
	<div class="content xf__container">
		<?php the_archive_title( '<h1 class="xf__page-title" itemprop="headline">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="xf__page-description">', '</div>' ); ?>
	</div>

	<?php
	/**
	 * Primary Site Header Image
	 */
	get_template_part( 'template-parts/primary-site-header-image' ); ?>

</header>

<main class="xf__main" itemprop="mainContentOfPage">
	<?php if ( have_posts() ) : ?>

		<div class="xf__page-meta">
			<div class="xf__container">
				<span class="item-icon"><i class="fa fa-clock-o"></i></span>
				<span class="item-content"><?php esc_html_e( 'Recent Posts', 'snowbird' ); ?></span>
			</div>
		</div>

		<div id="main" class="xf__posts" itemtype="http://schema.org/Blog" itemscope="itemscope">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Post Contents
				 */
				if ( 'alternate' == Snowbird()->mod( 'loop_layout_type' ) ) :
					get_template_part( 'template-parts/content-alternate', get_post_format() );
				else:
					get_template_part( 'template-parts/content', get_post_format() );
				endif;
				?>

			<?php endwhile; ?>
		</div>

		<?php get_template_part( 'template-parts/loop-pagination' ); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content-none' ); ?>

	<?php endif; ?>
</main>

<?php get_footer(); ?>
