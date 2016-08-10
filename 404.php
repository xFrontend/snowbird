<?php get_header(); ?>

<?php
/**
 * Primary Site Header
 */
get_template_part( 'template-parts/primary-site-header' ); ?>

<main class="xf__mainn xf__entry" itemprop="mainContentOfPage">
	<div class="xf__container xf__entry-container error-404 not-found">
		<div class="entry-content">
			<h1 class="page-title"><?php esc_html_e( "Doh! You've found it!", 'snowbird' ); ?></h1>

			<p><?php esc_html_e( 'Sorry to break it to you, but looks like nothing was found at this location. Try one of the links below or a search maybe?', 'snowbird' ); ?></p>

			<div class="widget xf__search">
				<?php get_search_form(); ?>
			</div>
		</div>

		<div class="xf__block">
			<div class="row">
				<div class="column one-half widget widget_recent_entries">
					<?php
					/**
					 * Widget - Recent Posts
					 */
					the_widget( 'WP_Widget_Recent_Posts', 'show_date=1', array(
						'before_widget' => '<div class="widget widget-404-page">',
						'after_widget'  => '</div>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					) ); ?>
				</div>

				<div class="column one-half widget widget_categories">
					<h3 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'snowbird' ); ?></h3>
					<ul>
						<?php
						/**
						 * Most used categories
						 */
						wp_list_categories( array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'show_count' => 1,
							'title_li'   => '',
							'number'     => 10,
						) ); ?>
					</ul>
				</div>
			</div>
		</div>

	</div>
</main>

<?php get_footer(); ?>
