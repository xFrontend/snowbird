<?php get_header(); ?>

<?php
/**
 * Primary Site Header
 */
get_template_part( 'template-parts/primary-site-header' ); ?>

<main class="xf__main" itemprop="mainContentOfPage">
	<?php while ( have_posts() ) : the_post(); ?>

		<div itemscope="itemscope" itemtype="http://schema.org/Blog">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/BlogPosting"
			         itemscope="itemscope" itemprop="blogPost">

				<div class="xf__post-wrapper">
					<div class="xf__container xf__entry-container">

						<header class="xf__post-header">
							<div class="xf__meta" itemprop="text">
								<?php
								/**
								 * Attachment Time - Published on
								 */
								printf(
									'<span class="xf__meta-item posted-on"><a href="%1$s" rel="bookmark"><time class="entry-date published" datetime="%2$s" itemprop="datePublished" >%3$s</time></a></span>',
									esc_attr( get_the_permalink() ),
									esc_attr( get_the_time( 'c' ) ),
									esc_html( get_the_time( get_option( 'date_format' ) ) )
								);
								/* Attachment Time - Updated On */
								printf(
									'<span class="xf__meta-item updated-on screen-reader-text"><time class="entry-date updated" datetime="%1$s" itemprop="dateModified" >%2$s</time></span>',
									esc_attr( get_the_modified_time( 'c' ) ),
									esc_html( get_the_modified_time( get_option( 'date_format' ) ) )
								); ?>

								<span
									class="xf__meta-item parent-post"><?php echo esc_html__( 'Posted on:', 'snowbird' ) . ' ' . get_previous_post_link( '%link' ); ?></span>
							</div>

							<?php
							/**
							 * Attachment Title
							 */
							the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
						</header>

						<div class="content entry-content" itemprop="text">
							<?php
							/**
							 * Attachment Content
							 */
							the_content(); ?>
						</div>

					</div>

					<?php
					/**
					 * Image Navigation
					 */
					get_template_part( 'template-parts/image-navigation' ); ?>

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
