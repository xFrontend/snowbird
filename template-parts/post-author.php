<?php
/**
 * Return early if it's attachment, or, obey the setting
 */
if ( is_attachment() || ! Snowbird()->mod( 'post_display_author_bio' ) ) {
	return;
}

$author_bio = snowbird_get_author_bio(); ?>
<div class="xf__author-bio" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author">
	<div class="bio-header clear">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), '80', '', '', array( 'extra_attr' => 'itemprop="image"' ) ); ?>

		<div class="entry-author vcard">
			<?php printf( esc_html__( 'Written by %1$s', 'snowbird' ), '<span class="fn author" itemprop="name" >' . snowbird_get_author() . '</span>' ); ?>
		</div>
	</div>

	<hr class="separator">

	<?php if ( ! empty( $author_bio ) ) : ?>
		<p class="bio-content" itemprop="description"><?php echo $author_bio; ?></p>

		<hr class="separator">
	<?php endif; ?>

	<?php
	/**
	 * Make use of the spot for something cool.
	 *
	 * @see https://developer.wordpress.org/reference/functions/add_action/
	 */
	if ( has_action( 'snowbird_author_bio' ) ) :
		do_action( 'snowbird_author_bio', array( 'user_id' => get_the_author_meta( 'ID' ) ) );
	endif; ?>
</div>
