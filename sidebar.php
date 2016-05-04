<aside class="xf__sidebar">
	<div class="sidebar-area">

		<header class="xf__header" itemtype="http://schema.org/WPHeader" itemscope="itemscope">
			<div class="content">
				<?php
				/**
				 * Logo - Text or Image
				 */
				if ( '' !== Snowbird()->mod( 'logo_image' ) ) : ?>
					<span class="screen-reader-text" itemprop="headline"><?php bloginfo( 'name' ); ?></span>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"
						><?php echo snowbird_get_logo() ?></a>

				<?php else : ?>

					<h2 class="site-title" itemprop="headline">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h2>

					<?php
					/**
					 * Site Tagline
					 */
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>

				<?php endif; ?>
			</div>

			<button class="xf__close">
				<i class="fa fa-close"></i>
				<span class="screen-reader-text"><?php esc_html_e( 'Hide Sidebar', 'snowbird' ); ?></span>
			</button>

			<?php
			/**
			 * Site Header Image
			 */
			if ( $header_img = snowbird_get_header_image_src() ) : ?>
				<div class="background">
					<img src="<?php echo esc_url( $header_img[0] ); ?>"
					     width="<?php echo esc_attr( $header_img[1] ); ?>"
					     height="<?php echo esc_attr( $header_img[2] ); ?>" alt="">

					<div class="overlay"></div>
				</div>
			<?php endif; ?>
		</header>

		<div class="widget-area">
			<div class="widget">
				<?php echo snowbird_filter_get_search_form(); ?>
			</div>

			<?php
			/**
			 * Primary Menu
			 */
			if ( has_nav_menu( 'primary' ) ) :

				wp_nav_menu( array(
					'theme_location'  => 'primary',
					'menu_class'      => 'menu',
					'container'       => 'nav',
					'container_class' => 'widget widget_nav_menu main-navigation',
					'items_wrap'      => '<ul class="%2$s">%3$s</ul>'
				) );

			endif; ?>

			<?php
			/**
			 * Show the sidebar widgets
			 */
			dynamic_sidebar( 'sidebar-1' ); ?>

			<?php
			/**
			 * If we've Primary Menu, or Sidebar Widgets- show this
			 */
			if ( has_nav_menu( 'primary' ) || is_active_sidebar( 'sidebar-1' ) ) : ?>
				<a class="xf__top" href="javascript:void(0)"><i
						class="fa fa-long-arrow-up"></i> <?php esc_html_e( 'Back to Top', 'snowbird' ); ?></a>
			<?php endif; ?>
		</div>

	</div>
</aside>
