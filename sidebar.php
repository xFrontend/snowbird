<aside class="xf__sidebar">
	<div class="sidebar-area">

		<header class="xf__header" itemtype="http://schema.org/WPHeader" itemscope="itemscope">
			<div class="content xf__header-logo">
				<?php
				/**
				 * Site Logo/Title
				 */
				snowbird_site_brand(); ?>
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
			<?php
			/**
			 * Display Search
			 */
			snowbird_display_sidebar_search(); ?>

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
