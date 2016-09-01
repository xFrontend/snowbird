<?php
/**
 * The Pagination
 */
the_posts_pagination( array(
	'mid_size'           => 1,
	'prev_text'          => esc_html_x( 'Newer Entries', 'previous page', 'snowbird' ),
	'next_text'          => esc_html_x( 'Older Entries', 'next page', 'snowbird' ),
	'screen_reader_text' => esc_html__( 'Posts navigation', 'snowbird' ),
	'type'               => 'plain',
) );
