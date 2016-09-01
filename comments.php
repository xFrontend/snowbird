<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/**
 * Proceed further only if we have comments to display,
 * or if it's Okee to show the comment form
 */
if ( have_comments() || comments_open() ) : ?>
	<div id="comments" class="xf__block comments-area">
		<div class="xf__container xf__entry-container">

			<?php
			/**
			 * Do we've Comments to show?
			 */
			if ( have_comments() ) : ?>
				<div class="xf__block-header">
					<h3 class="xf__block-title comments-title">
						<?php
						printf(
						// WPCS: XSS OK.
							esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'snowbird' ) ),
							number_format_i18n( get_comments_number() )
						); ?>
					</h3>
				</div>

				<ol class="xf__comments-lists comment-list">
					<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 80,
						'callback'    => 'snowbird_list_comments'
					) ); ?>
				</ol>

				<?php
				/**
				 * Are there comments to navigate through?
				 */
				if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<nav id="comment-nav-below" class="xf__nav-pages comment-navigation">
						<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'snowbird' ); ?></h2>

						<div class="nav-links">
							<div
								class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'snowbird' ) ); ?></div>
							<div
								class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'snowbird' ) ); ?></div>
						</div>
					</nav>
				<?php endif; ?>

			<?php endif; // Check for have_comments(). ?>

			<?php
			/**
			 * If comments are closed and there are comments, let's leave a little note, shall we?
			 */
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="no-comments"><i
						class="fa fa-info"></i>&nbsp; <?php esc_html_e( 'Comments are closed.', 'snowbird' ); ?></p>
			<?php endif; ?>


			<?php
			/**
			 * Comment Form
			 */
			if ( comments_open() ) :

				$commenter = wp_get_current_commenter();

				$req      = get_option( 'require_name_email' );
				$req_aria = $req ? ' aria-required="true" ' : '';
				$req_text = $req ? _x( '*', 'required field mark', 'snowbird' ) : '';

				comment_form( array(
					'id_form'              => 'comment-form',
					'title_reply'          => '<span>' . esc_html__( 'Leave a Reply', 'snowbird' ) . '</span>',
					'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'snowbird' ),
					'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'snowbird' ),
					'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'Your email address will not be published.', 'snowbird' ) . ( $req ? ' ' . sprintf( esc_html__( 'Required fields are marked %s', 'snowbird' ), $req_text ) : '' ) . '</p>',
					'comment_notes_after'  => '',
					'comment_field'        => '<p class="form-comment"><label  class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'snowbird' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
					'fields'               => apply_filters( 'snowbird_comment_form_default_fields', array(
						'author' => '<p class="form-author"><label class="screen-reader-text" for="author">' . sprintf( esc_html__( 'Name %s', 'snowbird' ), $req_text ) . '</label><input id="author" name="author" type="text" placeholder="' . sprintf( esc_attr__( 'Name %s', 'snowbird' ), $req_text ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $req_aria . ' ></p>',
						'email'  => '<p class="form-email"><label class="screen-reader-text" for="email">' . sprintf( esc_html__( 'Email %s', 'snowbird' ), $req_text ) . '</label><input id="email" name="email" type="text" placeholder="' . sprintf( esc_attr__( 'Email %s', 'snowbird' ), $req_text ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . $req_aria . ' ></p>',
						'url'    => '<p class="form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'snowbird' ) . '</label><input id="url" name="url" type="text"  placeholder="' . esc_attr__( 'Website', 'snowbird' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" ></p>'
					) ),
					'label_submit'         => esc_html__( 'Post Comment', 'snowbird' ),
				) );

			endif; ?>

		</div>
	</div>
<?php endif; ?>
