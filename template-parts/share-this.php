<?php
/**
 * Share this
 */

$thumbnail = '';
$thumb     = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

if ( isset( $thumb[0] ) ) {
	$thumbnail = $thumb[0];
}

/**
 * Check for registered action, if available
 * bail to the action callback and exit.
 *
 * @see https://developer.wordpress.org/reference/functions/add_action/
 */
if ( has_action( 'snowbird_share_this' ) ) {
	do_action( 'snowbird_share_this', $thumbnail );

	return;
}

?>

<div class="xf__share-container xf__share-this">
	<span><?php esc_html_e( 'Share this:', 'snowbird' ); ?></span>

	<a class="facebook" title="<?php esc_html_e( 'Share on Facebook', 'snowbird' ); ?>"
	   href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>&amp;t=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>">
		<i class="fa fa-facebook"></i>
		<?php esc_html_e( 'Facebook', 'snowbird' ); ?></a>
	<a class="twitter" title="<?php esc_html_e( 'Tweet This', 'snowbird' ); ?>"
	   href="https://twitter.com/share?text=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
		<i class="fa fa-twitter"></i>
		<?php esc_html_e( 'Twitter', 'snowbird' ); ?></a>
	<a class="pinterest" title="<?php esc_html_e( 'Pin This', 'snowbird' ); ?>"
	   href="https://www.pinterest.com/pin/create/button/?url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>&amp;description=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;media=<?php echo urlencode( esc_url( $thumbnail ) ) ?>">
		<i class="fa fa-pinterest-p"></i>
		<?php esc_html_e( 'Pinterest', 'snowbird' ); ?></a>
	<a class="gplus" title="<?php esc_html_e( 'Share on Google+', 'snowbird' ); ?>"
	   href="https://plus.google.com/share?url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
		<i class="fa fa-google-plus"></i>
		<?php esc_html_e( 'Google+', 'snowbird' ); ?></a>
	<a class="linkedin" title="<?php esc_html_e( 'Share on LinkedIn', 'snowbird' ); ?>"
	   href="https://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;url=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
		<i class="fa fa-linkedin"></i>
		<?php esc_html_e( 'LinkedIn', 'snowbird' ); ?></a>
	<a class="mail" title="<?php esc_html_e( 'Email This', 'snowbird' ); ?>"
	   href="mailto:?subject=<?php echo urlencode( esc_attr( get_the_title() ) ) ?>&amp;body=<?php echo urlencode( esc_url( get_the_permalink() ) ) ?>">
		<i class="fa fa-envelope-o"></i>
		<?php esc_html_e( 'Email', 'snowbird' ); ?></a>
</div>
