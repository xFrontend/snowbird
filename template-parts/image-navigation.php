<?php
/**
 * Return early if attachment is not image
 */
if ( ! wp_attachment_is_image() ) {
	return;
}

/**
 * Previous Image Link
 */
ob_start();
previous_image_link( 'snowbird-small' );

$previous = ob_get_clean();

/**
 * Next Image Link
 */
ob_start();
next_image_link( 'snowbird-small' );

$next = ob_get_clean();

if ( empty( $next ) && empty( $previous ) ) {
	return;
} ?>
<nav class="xf__nav-image">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Image navigation', 'snowbird' ); ?></h2>

	<?php if ( ! empty( $previous ) ) : ?>
		<div class="nav-previous">
			<?php echo $previous; ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $next ) ) : ?>
		<div class="nav-next">
			<?php echo $next; ?>
		</div>
	<?php endif; ?>
</nav>
