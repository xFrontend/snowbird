
<?php if ( get_header_image() ) : ?>
	<div class="background">
		<img src="<?php header_image(); ?>"
		     width="<?php echo esc_attr( get_custom_header()->width ); ?>"
		     height="<?php echo esc_attr( get_custom_header()->height ); ?>"
		     alt="">

		<div class="overlay"></div>
	</div>
<?php endif; // End header image check. ?>
