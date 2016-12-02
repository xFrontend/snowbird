<?php
/**
 * Featured Image
 */
if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
	<figure class="xf__feaured-image" aria-hidden="true">
		<?php if ( is_singular() ) {

			the_post_thumbnail( 'post-thumbnail', array(
				'alt'      => get_the_title(),
				'itemprop' => 'image',
			) );

		} else {

			printf(
				'<a href="%s">%s</a>',
				esc_url( get_the_permalink() ),
				get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', array(
					'alt'      => get_the_title(),
					'itemprop' => 'image',
				) )
			);

		} ?>
	</figure>
<?php endif; ?>
