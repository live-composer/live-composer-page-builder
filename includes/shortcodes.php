<?php

/**
 * Table Of Contents
 *
 * dslc_sc_notification ( Notification Shortcode )
 * dslc_sc_get_custom_field ( Custom Field Shortcode )
 * dslc_sc_site_url ( Site URL Shortcode )
 * dslc_sc_icon ( Icon Shortcode )
 * dslc_sc_user_avatar ( User Avatar Shortcode )
 * dslc_sc_category_description ( Category Description Shortcode )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}


/**
 * Notification Shortcode
 *
 * Outputs a notification
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string HTML notification
 */
function dslc_sc_notification( $atts, $content ) {
	// Attributes
	$args = shortcode_atts(
		array(
			'color' => 'default',
		),
		$atts
	);
	$color = sanitize_key(esc_attr($args['color']));

	// Return notification HTML
	return '<div class="dslc-notification dslc-' . $color . '">' . $content . '<span class="dslc-notification-close"><span class="dslc-icon dslc-icon-remove-sign"></span></span></div>';
} add_shortcode( 'dslc_notification', 'dslc_sc_notification' );

/**
 * Custom Field Shortcode
 *
 * Outputs custom field value of a post
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Custom field value
 */
function dslc_sc_get_custom_field( $atts, $content ) {

	// Attributes
	$args = shortcode_atts(
		array(
			'id' => false,
			'post_id' => false,
		),
		$atts
	);

	$id = $args['id'];
	// If no custom field ID return error message
	if ( ! $id ) {
		return 'Custom field ID not supplied ( "id" parameter ).';
	}
	$id = sanitize_key(esc_attr($args['id']));
	$post_id = $args['post_id'];
	if ($post_id) {
		$post_id = sanitize_key(esc_attr($args['post_id']));
	}

	// If no post ID but in the loop, get current ID
	if ( ! $post_id && in_the_loop() ) {
		$post_id = get_the_ID();
	}

	// If no post ID use $_POST ( this is mostly for the editor usage )
	if ( ! $post_id ) {
		$post_id = $_POST['dslc_post_id'];
	}

	// If the post has the custom field return the value
	if ( get_post_meta( $post_id, $id, true ) ) {
		return do_shortcode( get_post_meta( $post_id, $id, true ) );
	}

} add_shortcode( 'dslc_custom_field', 'dslc_sc_get_custom_field' );

/**
 * Site URL Shortcode
 *
 * Outputs the site URL ( URL to homepage )
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Site URL
 */
function dslc_sc_site_url( $atts, $content ) {

	// Return site URL
	return site_url();

} add_shortcode( 'dslc_site_url', 'dslc_sc_site_url' );

/**
 * Icon Shortcode
 *
 * Outputs an icon
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Icon HTML
 */
function dslc_sc_icon( $atts, $content ) {

	// Attributes
	$args = shortcode_atts(
		array(
			'id' => false,
		),
		$atts
	);

	$id = $args['id'];
	// If no ID return empty
	if ( ! $id ) {
		return '';
	}
	$id = sanitize_key(esc_attr($args['id']));
	// Return Icon HTML
	return '<span class="dslc-icon dslc-icon-' . $id . ' dslc-icon-sc"></span>';

} add_shortcode( 'dslc_icon', 'dslc_sc_icon' );

/**
 * User Avatar Shortcode
 *
 * Outputs the user avatar
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string HTML avatar image
 */
function dslc_sc_user_avatar( $atts, $content ) {

	// Attributes
	$args = shortcode_atts(
		array(
			'user' => false,
			'size' => 100,
			'url' => false,
			'target' => '_self',
		),$atts);

	$size = (int)$args['size'];
	$user = (bool)$args['user'];
	$url = $args['url'];

	// If URL not supplied return avatar HTML without link
	if ( ! $url ) {
		return '<span class="dslc-sc-user-avatar">' . get_avatar( get_current_user_id(), $size ) . '</span>';
		// If URL supplied wrap the avatar HTML in a link
	} else {
		$url = sanitize_url(esc_url($args['url']));
		$target = sanitize_key(esc_attr($args['target']));
		return '<a href="' . $url . '" target="' . $target . '"><span class="dslc-sc-user-avatar">' . get_avatar( get_current_user_id(), $size ) . '</span></a>';
	}

} add_shortcode( 'dslc_user_avatar', 'dslc_sc_user_avatar' );

/**
 * Category Description Shortcode
 *
 * Outputs category description
 *
 * @since 1.0.4
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Category description
 */
function dslc_sc_category_description( $atts, $content ) {

	// Attributes
	$args = shortcode_atts(
		array(
			'id' => false,
		),$atts);
	
     $category_Id =$args['id'];

	// If category ID not supplied, get current category
	if ( ! $category_Id ) {
		$category_Id = get_query_var( 'cat' );
	}

	$category_Id = sanitize_key(esc_attr($args['id']));
	
	// Get category description
	$category_description = category_description( $category_Id );

	// Placeholder description
	if ( ! is_category() && empty( $category_description ) && dslc_is_editor_active( 'access' ) ) {
		$category_description = __( 'Category description will be shown here.', 'live-composer-page-builder' );
	}

	// Return category description
	return $category_description;

} add_shortcode( 'dslc_category_description', 'dslc_sc_category_description' );

/**
 * Add Shortcode:
 * [dslc_page_title]
 *
 * Outputs the curent page title
 * http://codex.wordpress.org/Function_Reference/the_title
 */
function dslc_sc_page_title() {
	$output = the_title( '', '', false );
	return $output;
}
add_shortcode( 'dslc_page_title', 'dslc_sc_page_title' );
add_shortcode( 'lbmn_pagetitle', 'dslc_sc_page_title' );


/**
 * Add Shortcode:
 * [dslc_bloghome]
 *
 * Outputs the blog index page URL
 * http://codex.wordpress.org/Function_Reference/get_option
 */
add_shortcode( 'dslc_bloghome', 'dslc_bloghome_shortcode' );
add_shortcode( 'lbmn_bloghome', 'dslc_bloghome_shortcode' );
function dslc_bloghome_shortcode() {
	// Code
	$output =sanitize_url(esc_url(home_url()));

	return $output;
}

/**
 * Add Shortcode:
 * [dslc_authorbio]
 *
 * Outputs the curent author bio info
 * http://codex.wordpress.org/Function_Reference/get_the_author_meta
 */
function dslc_sc_authorbio() {
	$output = get_the_author_meta( 'description' );

	if ( ! $output ) {
		$output = ' ';
		// to prevent "Looks like there is no content" message
		// in the Live Composer
	}

	return $output;
}
add_shortcode( 'dslc_authorbio', 'dslc_sc_authorbio' );
add_shortcode( 'lbmn_authorbio', 'dslc_sc_authorbio' );

/**
 * Add Shortcode:
 * [dslc_commentscount]
 *
 * Outputs comments count
 */
add_shortcode( 'dslc_commentscount', 'dslc_sc_commentscount' );
add_shortcode( 'lbmn_commentscount', 'dslc_sc_commentscount' );
function dslc_sc_commentscount() {
	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

	if ( $num_comments == 0 ) {
		$comments = __( 'No Comments', 'live-composer-page-builder' );
	} elseif ( $num_comments > 1 ) {
		$comments = $num_comments . __( ' Comments', 'live-composer-page-builder' );
	} else {
		$comments = __( '1 Comment', 'live-composer-page-builder' );
	}

	$output = $comments;

	return $output;
}

/**
 * Add Shortcode:
 * [dslc_archive_heading]
 *
 * Outputs archive page headings.
 */
add_shortcode( 'dslc_archive_heading', 'dslc_archive_heading_shortcode' );
add_shortcode( 'lbmn_archive_heading', 'dslc_archive_heading_shortcode' );
function dslc_archive_heading_shortcode() {

	$output = '';

	if ( DS_LIVE_COMPOSER_ACTIVE ) :
		$output .= __( 'This heading will be automatically generated by a theme', 'live-composer-page-builder' );

	elseif ( is_category() ) :
		$output .= sprintf( __( 'Category Archives: %s', 'live-composer-page-builder' ), '<span>' . single_cat_title( '', false ) . '</span>' );

	elseif ( is_tag() ) :
		$output .= sprintf( __( 'Tag Archives: %s', 'live-composer-page-builder' ), '<span>' . single_tag_title( '', false ) . '</span>' );

	elseif ( is_author() ) :
		/* Queue the first post, that way we know
		 * what author we're dealing with (if that is the case).
		*/
		the_post();
		$output .= sprintf( __( 'Author Archives: %s', 'live-composer-page-builder' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();

	elseif ( is_day() ) :
		$output .= sprintf( __( 'Daily Archives: %s', 'live-composer-page-builder' ), '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		$output .= sprintf( __( 'Monthly Archives: %s', 'live-composer-page-builder' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif ( is_year() ) :
		$output .= sprintf( __( 'Yearly Archives: %s', 'live-composer-page-builder' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		$output .= __( 'Asides', 'live-composer-page-builder' );

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		$output .= __( 'Images', 'live-composer-page-builder' );

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		$output .= __( 'Videos', 'live-composer-page-builder' );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		$output .= __( 'Quotes', 'live-composer-page-builder' );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		$output .= __( 'Links', 'live-composer-page-builder' );

	elseif ( is_tax() ) :
		$output .= sprintf( __( 'Category Archives: %s', 'live-composer-page-builder' ), '<span>' . single_cat_title( '', false ) . '</span>' );

	elseif ( is_search() ) : // special title for search result page
		// get number of posts found for search query
		global $wp_query;
		$search_results_count = $wp_query->found_posts;

		$output .= __( 'You are searching for: ', 'live-composer-page-builder' );
		$output .= '<strong>' . get_query_var( 's' ) . '</strong>. <br />';

		if ( 1 == $search_results_count ) {
			$output .= __( 'There is one post that match your criteria...', 'live-composer-page-builder' );
		} elseif ( 1 < $search_results_count ) {
			$output .= sprintf( __( 'Here are %s posts that match your criteria...', 'live-composer-page-builder' ), '<span>' . $search_results_count . '</span>' );
		} else {
			$output .= __( 'Looks like nothing was found. Sorry.', 'live-composer-page-builder' );
		}

	elseif ( is_front_page() ) :
		$output .= get_bloginfo( 'description' );

	else :
		$output .= __( 'Archives', 'live-composer-page-builder' );

	endif;

	return $output;
}

/**
 * Add Shortcode: [nextpost_url] [prevpost_url]
 * Output an URL to the next previous post the same way as next post link works
 * https://codex.wordpress.org/Function_Reference/get_next_posts_link
 * http://wordpress.org/support/topic/nextpreviews-post-url-only
 * https://codex.wordpress.org/Function_Reference/get_adjacent_post
 */

// [nextpost_url]
add_shortcode( 'dslc_nextpost_url', 'dslc_nextpost_url_shortcode' );
add_shortcode( 'lbmn_nextpost_url', 'dslc_nextpost_url_shortcode' );
function dslc_nextpost_url_shortcode( $atts ) {

	// Attributes
		$args = shortcode_atts(
		array(
			'previous'            => false,
			// Whether to retrieve previous or next post.
			'in_same_cat'         => false,
			// Whether post should be in same category. Whether post should be in same category.
			'excluded_categories' => '',
			// Excluded categories IDs.
		),
		$atts
	);
	$previous = (bool)$args['previous'];
	$in_same_cat = (bool)$args['in_same_cat'];
	$excluded_categories = sanitize_key(esc_attr($args['excluded_categories']));

	// Code
	$output = get_permalink( get_adjacent_post( $in_same_cat, $excluded_categories, $previous ) );

	// for your reference:  get_adjacent_post( $in_same_cat, $excluded_categories, $previous )
	return $output;
}

// [prevpost_url]
add_shortcode( 'dslc_prevpost_url', 'dslc_prevpost_url_shortcode' );
add_shortcode( 'lbmn_prevpost_url', 'dslc_prevpost_url_shortcode' );
function dslc_prevpost_url_shortcode( $atts ) {

	// Attributes
		$args = shortcode_atts(
		array(
			'previous'            => true,
			// Whether to retrieve previous or next post.
			'in_same_cat'         => false,
			// Whether post should be in same category. Whether post should be in same category.
			'excluded_categories' => '',
			// Excluded categories IDs.
		),
		$atts
	);
	$previous = (bool)$args['previous'];
	$in_same_cat = (bool)$args['in_same_cat'];
	$excluded_categories = sanitize_key(esc_attr($args['excluded_categories']));

	// Code
	$output = get_permalink( get_adjacent_post( $in_same_cat, $excluded_categories, $previous ) );

	// for your reference:  get_adjacent_post( $in_same_cat, $excluded_categories, $previous )
	return $output;
}

/**
 * Add Shortcode:
 * [dslc_postpagination]
 *
 * Outputs single post pagination
 */
add_shortcode( 'dslc_postpagination', 'dslc_postpagination_shortcode' );
add_shortcode( 'lbmn_postpagination', 'dslc_postpagination_shortcode' );
function dslc_postpagination_shortcode() {
	$output = wp_link_pages( array(
		'before' => '<div class="page-links"><span class="page-links__title">' . __( 'Pages:', 'live-composer-page-builder' ) . '</span><span class="page-numbers">',
		'after'  => '</span></div>',
		'echo'   => 0,
	) );

	if ( ! $output ) {
		$output = ' ';
		// to prevent "Looks like there is no content" message
		// in the Live Composer
	}

	return $output;
}
