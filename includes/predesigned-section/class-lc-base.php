<?php
/**
 * Main plugin class
 */

if( !class_exists( 'LCPS_Base' ) ) {
class LCPS_Base
{
	protected $version;

	// Main class name
	const CLASS_NAME = 'LC_Predesigned_Sections';

	// Main post type name
	const POST_TYPE_NAME = 'lc_desing_sections';
	const POST_TAXONOMY_CATEGORY = 'lc_desing_sections_category';

	/**
	 * Construct
	 */
	public function __construct()
	{
		// If debug always refresh css/js
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG )
			$this->version = time();

		// Add JavaScript
		add_action( 'admin_enqueue_scripts', array( $this, 'js_load' ) );
		// Add CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'css_load' ) );
	}

	// Add action to Register new custom post type
	static public function init_custom_post_type()
	{
		add_action( 'init', array(
				'LC_Predesigned_Sections',
				'custom_post_type'
			)
		);
	}

	// Register new custom post type
	static public function custom_post_type()
	{
		$args = array(
			'labels'             => array(
				'name'               => 'Predesigned sections for Live Composer',
				'singular_name'      => 'Predesigned sections for Live Composer',
				'add_new'            => __( 'Add New', 'section' ),
				'add_new_item'       => __( 'Add New Section' ),
				'edit_item'          => __( 'Edit Section' ),
				'new_item'           => __( 'New Section' ),
				'all_items'          => __( 'All Sections' ),
				'view_item'          => __( 'View Section' ),
				'search_items'       => __( 'Search Sections' ),
				'not_found'          => __( 'No sections found' ),
				'not_found_in_trash' => __( 'No sections found in the Trash' ), 
				'parent_item_colon'  => '',
				'menu_name'          => 'Predesigned sections'
			),
			'taxonomies'         => array( 'lc_desing_sections_category' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);


		register_post_type( 'lc_desing_sections', $args );
		self::custom_taxonomy();
	}

	// Register Custom Taxonomy
	static public function custom_taxonomy()
	{
		$labels = array(
			'name'                       => _x( 'Sections categories', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Sections category', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Taxonomy', 'text_domain' ),
			'all_items'                  => __( 'All Items', 'text_domain' ),
			'parent_item'                => __( 'Parent Item', 'text_domain' ),
			'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
			'new_item_name'              => __( 'New Item Name', 'text_domain' ),
			'add_new_item'               => __( 'Add New Item', 'text_domain' ),
			'edit_item'                  => __( 'Edit Item', 'text_domain' ),
			'update_item'                => __( 'Update Item', 'text_domain' ),
			'view_item'                  => __( 'View Item', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
			'popular_items'              => __( 'Popular Items', 'text_domain' ),
			'search_items'               => __( 'Search Items', 'text_domain' ),
			'not_found'                  => __( 'Not Found', 'text_domain' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'lc_desing_sections_category', array( 'lc_desing_sections' ), $args );
	}

	public function css_load()
	{
		// List of all css files
		$files = array(
			'lc-predesigned-section-style' => '/css/lc-predesigned-section.css',
		);

		foreach ( $files as $fileKey => $filePath ) {
			wp_register_style( $fileKey, plugins_url( $filePath , __FILE__ ), array(), $this->version, 'all' );
			wp_enqueue_style( $fileKey );
		}
	}

	public function js_load()
	{
		// List of all js files
		$files = array(
			'lc-predesigned-section-script' => '/js/lc-predesigned-section.js',
			// 'jquery-ui-draggable'     => '',
			// 'jquery-ui-droppable'     => '',
		);

		foreach ( $files as $fileKey => $filePath ) {
			if ( !empty($filePath) )
				wp_register_script( $fileKey, plugins_url( $filePath, __FILE__ ), array( 'jquery' ), $this->version );
			else
				wp_register_script( $fileKey, array( 'jquery' ), $this->version );

			wp_enqueue_script( $fileKey );
		}
	}

	protected function json( $var )
	{
		if ( empty( $var ) )
			return '';

		if ( is_string( $var ) )
			// if text - sent message for user
			return json_encode( array( 'message' => $var ), JSON_HEX_QUOT );
		else
			return json_encode( $var, JSON_HEX_QUOT );
	}

	protected function echo_json( $var )
	{
		header('Content-Type: application/json');
		echo $this->json( $var );
	}

	// VarDump для переменных
	static public function pe($var = '', $head = null)
	{
		self::p($var, $head);
		exit();
	}
	static public function p($var = '', $head = null)
	{
	// Проверка прав вывода отладочной информации
	if ( !defined( 'WP_DEBUG' ) || !WP_DEBUG )
		return;

	if (empty($var) && php_sapi_name() != 'cli') {
		echo '<br />';
		return;
	}
	// для консольных приложений
	elseif (php_sapi_name() == 'cli') {
		echo PHP_EOL;
		return;
	}

	if (!empty($head))
		echo '<h1>' . $head . '</h1>';

	if (is_array($var) || is_object($var)) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	elseif (php_sapi_name() != 'cli')
		echo PHP_EOL . '<br />' . $var;
	else
		echo PHP_EOL . $var;
	}
}}