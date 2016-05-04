<?php
/**
 * Return early if it's attachment, or, obey the setting
 */
if ( is_attachment() || ! Snowbird()->mod( 'post_display_navigation' ) ) {
	return;
}

$previous = snowbird_get_previous_post_link( '%link', '%thumb <div class="xf__title" data-title="Prev">%title</div>' );
$next     = snowbird_get_next_post_link( '%link', '%thumb <div class="xf__title" data-title="Next">%title</div>' );

if ( empty( $next ) && empty( $previous ) ) {
	return;
} ?>
<nav class="xf__post-navigation">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'snowbird' ); ?></h2>

	<div class="xf__nav-post">
		<?php echo $previous; ?>
		<?php echo $next; ?>
	</div>
</nav>
