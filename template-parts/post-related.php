<?php
/**
 * Return early based on the setting
 */
if ( ! Snowbird()->mod( 'post_display_related' ) ) {
	return;
}

/**
 * Get Related posts data
 */
$data = snowbird_get_related_posts( 4 );

if ( ! is_wp_error( $data ) && $data->have_posts() ) : ?>
	<div class="xf__block xf__related">
		<?php
		switch ( $data->post_count ) {
			case 4:
				$class_container = 'xf__full-width';
				$class_item      = 'related-item one-fourth';
				break;

			case 3:
				$class_container = 'xf__full-width';
				$class_item      = 'related-item one-third';
				break;

			default:
				$class_container = 'xf__container';
				$class_item      = 'related-item one-half';
		} ?>
		<div class="<?php echo esc_attr( $class_container ); ?>">
			<div class="xf__block-header screen-reader-text">
				<h3 class="xf__block-title related-title"><?php _e( 'Related Entries', 'snowbird' ); ?></h3>
			</div>

			<div class="row">
				<?php while ( $data->have_posts() ) : $data->the_post(); ?>

					<div class="column <?php echo esc_attr( $class_item ); ?>">
						<a href="<?php the_permalink(); ?>">
							<div class="wrapper">
								<div class="content">
									<h4 class="post-title"><?php the_title(); ?></h4>

									<?php
									printf(
										'<span class="post-date"><time class="entry-date published" datetime="%1$s">%2$s</time></span>',
										esc_attr( get_the_time( 'c' ) ),
										esc_html( get_the_time( get_option( 'date_format' ) ) )
									); ?>
								</div>
							</div>

							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'snowbird-thumb' ); ?>

								<div class="overlay"></div>
							<?php endif; ?>
						</a>
					</div>

				<?php endwhile; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php
/**
 * Reset WP Query
 */
wp_reset_query(); ?>
