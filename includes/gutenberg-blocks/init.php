<?php
/** 
 * Live Composer Blocks for Gutenberg
 */

class LiveComposer_Gutenberg_Blocks {

	/**
	 * The unique identifier slug.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $name    The string used to uniquely identify.
	 */
	protected $name;

	/**
	 * Define the core functionality.
	 *
	 * @since    1.0.0
	 */
  public function __construct() {
        
    $this->name = 'livecomposer-gutenberg-blocks';

    // Register hooks
    add_action( 'init', array( $this, 'register_pages_block_action' ) );
    add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  /**
   * Registers the simple block JS script and its styles
   *
   * @since    1.0.0
   * @return void
   */
  public function register_pages_block_action ( ) {

    $block_name = 'block-pages';
    $block_namespace = 'livecomposer-gutenberg-blocks/' . $block_name;

    $script_slug = $this->name . '-' . $block_name;
    $style_slug = $this->name . '-' . $block_name . '-style';
    $editor_style_slug = $this->name . '-' . $block_name . '-editor-style';

    // The JS block script
    $script_file = $block_name . '/block.build.js';

    wp_enqueue_script( 
			$script_slug, 
			plugin_dir_url(__FILE__) . $script_file, 
			[  // Dependencies that will have to be imported on the block JS file
					'wp-blocks', // Required: contains registerBlockType function that creates a block
					'wp-element', // Required: contains element function that handles HTML markup
					'wp-i18n', // contains registerBlockType function that creates a block
			], 
			plugin_dir_path(__FILE__) . $script_file
    );

    // The block style
    // It will be loaded on the editor and on the site
    wp_register_style(
			$style_slug,
			plugin_dir_url( __FILE__ )  . $block_name . '/css/style.css', 
			['wp-blocks'], // General style
			DS_LIVE_COMPOSER_VER
    );            

    // The block style for the editor only
    wp_register_style(
			$editor_style_slug,
			plugin_dir_url( __FILE__ ) . $block_name . '/css/editor.css', 
			['wp-edit-blocks'], // Style for the editor
			DS_LIVE_COMPOSER_VER
    );
    
    // Registering the block
    register_block_type(
			$block_namespace,  // Block name with namespace
			[
					'style' => $style_slug, // General block style slug
					'editor_style' => $editor_style_slug, // Editor block style slug
					'editor_script' => $script_slug,  // The block script slug
					'render_callback' => [$this, 'block_dynamic_render_cb'], // The render callback
			]
    );

  }  

  /**
	 * CALLBACK
	 * 
	 * Render callback for the dynamic block.
	 * 
	 * Instead of rendering from the block's save(), this callback will render the front-end
	 *
	 * @since    1.0.0
	 * @param $att Attributes from the JS block
	 * @return string Rendered HTML
	 */
	public function block_dynamic_render_cb ( $attributes, $content ) {

		$page_id = $attributes['selectedPage'];
		$dslc_code = get_post_meta( $page_id, 'dslc_code', true );
		$content = dslc_render_content($dslc_code, true);

		echo do_shortcode( $content );
		echo dslc_custom_css( $dslc_code );
	}


	/**
	 * Register REST API
	 */
	public function register_routes() {

		register_rest_route(
				'livecomposer-gutenberg-blocks/block-pages/v1',
				'/get-all-lc-pages',
				array(
						'methods'             => WP_REST_SERVER::READABLE,
						'callback'            => array( $this, 'get_lc_pages' ),
				)
		);
}
    
	/**
	 * Get the user roles
	 *
	 * @return $roles JSON feed of returned objects
	 */
	public function get_lc_pages() {
			
		$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'page',
		);

		$the_query = new WP_Query( $args );

		$pages_array = $the_query->posts; 
		$post_title_array = wp_list_pluck( $pages_array, 'post_title', 'ID' );
		$lc_pages = [];

		foreach ( $post_title_array as $id => $title ) {
			if ( ! get_post_meta( $id, 'dslc_code', true ) ) {
				unset( $post_title_array[$id] );
			}
		}

		return $post_title_array;
	}
}

$lcgb = new LiveComposer_Gutenberg_Blocks();

