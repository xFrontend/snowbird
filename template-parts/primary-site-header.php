<header class="xf__header">
	<div class="content xf__container">
		<?php
		/**
		 * Logo - Text or Image
		 */
		if ( '' !== Snowbird()->mod( 'logo_image' ) ) : ?>
			<span class="screen-reader-text" itemprop="headline"><?php bloginfo( 'name' ); ?></span>
			<a class="xf__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"
				><?php echo snowbird_get_logo() ?></a>

		<?php else : ?>

			<h2 class="xf__page-title" itemprop="headline">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h2>

			<?php
			/**
			 * Site Tagline
			 */
			$description = get_bloginfo( 'description', 'display' );

			if ( $description || is_customize_preview() ) : ?>
				<div class="xf__page-description site-description"><p><?php echo esc_html( $description ); ?></p></div>
			<?php endif; ?>

		<?php endif; ?>
	</div>

	<?php
	/**
	 * Primary Site Header Image
	 */
	get_template_part( 'template-parts/primary-site-header-image' ); ?>
</header>
