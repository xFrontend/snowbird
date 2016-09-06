<footer class="xf__footer" itemtype="http://schema.org/WPFooter" itemscope="itemscope">
	<?php
	/**
	 * Footer Widgets
	 */
	snowbird_display_footer_widgets(); ?>

	<div class="xf__site-info clear">
		<div class="xf__container">
			<?php
			/**
			 * Footer Menu
			 */
			snowbird_display_footer_menu(); ?>

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
