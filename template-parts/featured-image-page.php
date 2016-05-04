<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
	<div class="background">
		<?php the_post_thumbnail( 'post-thumbnail', array(
			'alt'      => get_the_title(),
			'itemprop' => 'image'
		) ); ?>

		<div class="overlay"></div>
	</div>
<?php elseif ( get_header_image() ) : ?>
	<div class="background">
		<img src="<?php header_image(); ?>"
		     width="<?php echo esc_attr( get_custom_header()->width ); ?>"
		     height="<?php echo esc_attr( get_custom_header()->height ); ?>"
		     alt="">

		<div class="overlay"></div>
	</div>
<?php endif; // End header image check. ?>
