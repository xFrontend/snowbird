<?php
/**
 * Page Meta (for the Scheme markup).
 */ ?>
<div class="xf__post-header screen-reader-text">
	<p class="xf__meta">
		<?php
		/**
		 * Post Time - Published on (for the Scheme markup).
		 */
		printf(
			'<span class="xf__meta-item posted-on"><a href="%1$s" rel="bookmark"><time class="entry-date published" datetime="%2$s" itemprop="datePublished" >%3$s</time></a></span>',
			esc_attr( get_the_permalink() ),
			esc_attr( get_the_time( 'c' ) ),
			esc_html( get_the_time( get_option( 'date_format' ) ) )
		);
		/* Post Time - Updated On (for the Scheme markup). */
		printf(
			'<span class="xf__meta-item updated-on"><time class="entry-date updated" datetime="%1$s" itemprop="dateModified" >%2$s</time></span>',
			esc_attr( get_the_modified_time( 'c' ) ),
			esc_html( get_the_modified_time( get_option( 'date_format' ) ) )
		); ?>

		<?php
		/**
		 * Page Author (for the Scheme markup).
		 */ ?>
		<span class="xf__meta-item entry-author vcard" itemtype="http://schema.org/Person"
		      itemscope="itemscope"
		      itemprop="author">
			<?php esc_html_e( 'by:', 'snowbird' ); ?>
			<span class="fn author"
			      itemprop="name"><?php echo snowbird_get_author(); ?></span>
		</span>
	</p>

	<?php
	/**
	 * Page Title (for the Scheme markup).
	 */
	the_title( '<h2 class="entry-title" itemprop="headline">', '</h2>' ); ?>
</div>
