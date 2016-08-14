<footer class="xf__footer" itemtype="http://schema.org/WPFooter" itemscope="itemscope">
	<?php
	/**
	 * Footer Widgets Area
	 */
	if ( $columns = snowbird_maybe_display_footer() ) : ?>
		<div class="widget-area">
			<div class="xf__container row clear">
				<?php
				for ( $i = 1; $i <= $columns; $i ++ ) {
					if ( is_active_sidebar( 'footer-' . $i ) ) {
						echo '<div class="' . esc_attr( snowbird_get_footer_widget_classes() ) . ( 1 == $i ? ' first' : '' ) . ( $i == $columns ? ' last' : '' ) . '">';

						dynamic_sidebar( 'footer-' . $i );

						echo '</div>';
					}
				} ?>
			</div>
		</div>
	<?php endif ?>

	<div class="xf__site-info clear">
		<div class="xf__container">
			<?php
			/**
			 * Footer Menu
			 */
			if ( 'social' === Snowbird()->mod( 'footer_menu_location' ) && has_nav_menu( 'social' ) ) :

				wp_nav_menu( array(
					'theme_location'  => 'social',
					'container'       => 'nav',
					'container_class' => 'xf__nav-social',
					'depth'           => 1,
					'menu_class'      => 'xf__social colors circle',
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
				) );

			elseif ( 'secondary' === Snowbird()->mod( 'footer_menu_location' ) && has_nav_menu( 'secondary' ) ) :

				wp_nav_menu( array(
					'theme_location'  => 'secondary',
					'container'       => 'nav',
					'container_class' => 'xf__nav-footer',
					'depth'           => 1,
				) );

			endif; ?>

			<?php /* translators: 1. Current Year 1. Site Link 3. WordPress Link 4. xFrontend Link */ ?>
			<p class="xf__copyright"><?php echo apply_filters( 'snowbird_footer_text', sprintf(
					esc_html__( '&copy; %1$d %2$s. Powered by %3$s &amp; %4$s.', 'snowbird' ),
					date( 'Y' ),
					sprintf(
						'<a href="%1$s" title="%2$s">%3$s</a>',
						esc_url( home_url( '/' ) ),
						esc_attr( get_bloginfo( 'name' ) ),
						esc_html( get_bloginfo( 'name' ) )
					),
					sprintf(
						'<a href="%1$s" title="%2$s">%3$s</a>',
						'https://wordpress.org/',
						esc_attr__( 'WordPress', 'snowbird' ),
						esc_html__( 'WordPress', 'snowbird' )
					),
					sprintf(
						'<a href="%1$s" title="%2$s">%3$s</a>',
						'https://xfrontend.com/',
						esc_attr__( 'xFrontend', 'snowbird' ),
						esc_html__( 'xFrontend', 'snowbird' )
					)
				) ); ?></p>
		</div>
	</div>
</footer>

</div>
</div>


<?php get_sidebar(); ?>

<button class="xf__toggle xf__toggle-show">
	<i class="fa fa-align-justify"></i>
	<span class="screen-reader-text"><?php esc_html_e( 'Show Sidebar', 'snowbird' ); ?></span>
</button>

<?php wp_footer(); ?>
</body>
</html>
