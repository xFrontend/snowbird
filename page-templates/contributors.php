<?php
/**
 * Template Name: Contributor Page
 */

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

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="xf__container xf__entry-container">
					<?php
					/**
					 * Page Meta (for the Scheme markup).
					 */
					get_template_part( 'template-parts/page-meta' ); ?>

					<div class="entry-content" itemprop="text">
						<?php
						/**
						 * Page Content
						 */
						the_content(); ?>

						<h3 class="aligncenter"><?php echo esc_html( _n( 'Contributor', 'Contributors', snowbird_get_contributor_count(), 'snowbird' ) ); ?></h3>

						<?php
						/**
						 * Output the contributors list
						 */
						snowbird_list_contributors(); ?>
					</div>
				</div>
			</article>

			<?php
			/**
			 * Comments and Form
			 */
			comments_template(); ?>

		</div>

	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
