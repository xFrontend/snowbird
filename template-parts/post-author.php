<?php
/**
 * Displayes Author Bio
 */
$author_bio = snowbird_get_author_bio(); ?>

<div class="xf__author-bio" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author">
	<div class="bio-header clear">
		<?php echo get_avatar( get_post()->post_author, '80', '', '', array( 'extra_attr' => 'itemprop="image"' ) ); ?>

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
		do_action( 'snowbird_author_bio', get_post()->post_author );
	endif; ?>
</div>
