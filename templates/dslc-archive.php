<?php
/**
 * Archive page template for Live Composer.
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

get_header();
?>

	<?php the_content(); ?>

<?php get_footer(); ?>