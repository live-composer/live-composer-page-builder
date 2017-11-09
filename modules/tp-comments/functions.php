<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function dslc_display_comments( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :

		case 'pingback' :
		case 'trackback' :
			?>
			<li class="dslc-comments-pingback">
				<p><?php _e( 'Pingback:', 'live-composer-page-builder' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'live-composer-page-builder' ), ' ' ); ?></p>
			<?php
		break;
		default :

			if ( $comment->comment_approved == '1' ) :

				?>

				<li <?php comment_class( 'dslc-comment' ); ?> id="dslc-comment-<?php comment_ID(); ?>">

					<div id="comment-<?php comment_ID(); ?>" class="dslc-comment-inner">

						<div class="dslc-comment-info dslc-clearfix">

							<ul class="dslc-comment-meta dslc-clearfix">
								<li class="dslc-comment-meta-author"><span class="dslc-comment-author-avatar"><?php echo get_avatar( $comment, 33 ); ?></span><?php echo get_comment_author_link(); ?></li>
								<li class="dslc-comment-meta-date"><?php echo get_comment_date(); ?></li>
							</ul>

							<span class="dslc-comment-reply">
								<?php comment_reply_link( array_merge( $args, array(
									'depth' => $depth,
									'max_depth' => $args['max_depth'],
								) ) ); ?>
							</span>

						</div><!-- .comment-info -->

						<div class="dslc-comment-main">

							<?php comment_text(); ?>

						</div><!-- .comment-main -->

					</div><!-- .comment-inner -->

				<?php

				endif;

			break;
	endswitch;

}
