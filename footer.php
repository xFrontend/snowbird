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

			<?php if ( '' !== snowbird_get_footer_content() ) : ?>
				<p class="xf__copyright"><?php echo snowbird_get_footer_content(); ?></p>
			<?php endif; ?>
		</div>
	</div>
</footer>

</div>
</div>
<!--// End Site -->

<?php get_sidebar(); ?>

<button class="xf__toggle xf__toggle-show">
	<i class="fa fa-align-justify"></i>
	<span class="screen-reader-text"><?php esc_html_e( 'Show Sidebar', 'snowbird' ); ?></span>
</button>

<?php wp_footer(); ?>
</body>
</html>
