<?php

/**
 * Proceed if there's more than one page.
 */
if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
	$args = array(
		'mid_size'           => 1,
		'prev_text'          => esc_html_x( 'Newer Entries', 'previous page', 'snowbird' ),
		'next_text'          => esc_html_x( 'Older Entries', 'next page', 'snowbird' ),
		'screen_reader_text' => esc_html__( 'Posts navigation', 'snowbird' ),
		'type'               => 'plain',
	);

	// Set up paginated links.
	$links = paginate_links( $args );

	if ( $links ) {
		$template = '
		<nav class="xf__nav-pagination">
			<h2 class="screen-reader-text">%1$s</h2>
			<div class="xf__container">
				<div class="nav-links">%2$s</div>
			</div>
		</nav>';

		printf( $template, esc_html( $args['screen_reader_text'] ), $links );
	}
}
