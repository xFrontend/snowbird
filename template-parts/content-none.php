<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

?>

<div class="xf__entry no-results not-found">
	<div class="xf__container xf__entry-container">

		<div class="entry-content">
			<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'snowbird' ); ?></h2>

			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'snowbird' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php elseif ( is_search() ) : ?>

				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'snowbird' ); ?></p>
				<?php get_search_form(); ?>

			<?php else : ?>

				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'snowbird' ); ?></p>
				<?php get_search_form(); ?>

			<?php endif; ?>
		</div>
	</div>
</div>
