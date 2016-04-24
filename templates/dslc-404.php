<?php get_header(); ?>

	<?php
		$args = array(
			'page_id' => dslc_get_option( '404_page', 'dslc_plugin_options_archives' ),
			'post_type'=> 'any', // enable 3-rd party themes to set 404 page using custom content types
			'ignore_sticky_posts' => true
		);
		$adslc_query = new WP_Query( $args );
		if ( $adslc_query->have_posts() ) : while ( $adslc_query->have_posts() ) : $adslc_query->the_post();
			the_content();
		endwhile; endif; wp_reset_query();
	?>

<?php get_footer(); ?>