<?php
/**
 * Main plugin class
 */
if( !class_exists( 'LC_Predesigned_Sections' ) ) {
class LC_Predesigned_Sections extends LCPS_Base
{
	protected $version = '0.2';

	public function __construct( $flgAjax = false )
	{
		parent::__construct( $flgAjax );

		// Init Predesigned Sections post type
		$this->init_custom_post_type();

		// Add plugin HTML to page
		add_action( 'wp_footer', array( $this, 'add_panel_html' ) );
	}

	// Delete all predesigned sections
	static public function remove_predesigned_sections()
	{
		$custom_posts = get_posts(array(
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'post_type'      => self::POST_TYPE_NAME
		));

		foreach( $custom_posts as $custom_post ) {
			// Delete's each post to trash
			wp_delete_post( $custom_post->ID, false );
		}
	}

	// Remove by user
	static public function remove_predesigned_section_post()
	{
		return self::remove_predesigned_section( $_POST['delete_ps'] );
	}

	// Remove predesigned section (only with right to delete)
	static public function remove_predesigned_section( $id )
	{
		if ( !current_user_can( 'delete_posts' ) )
			return false;

		$result = wp_delete_post( intval( $id ), false );

		if ( false === $result)
			return false;

		return true;
	}

	// Hook: this plugin activation action
	static public function add_predesigned_sections_from_xml()
	{
		// Check count of custom post types in db (if empty add from xml)
		if ( wp_count_posts( self::POST_TYPE_NAME )->publish > 0 )
			return;

		require_once 'class-lc-wrx-parser.php';
		$parser = new LCPS_WRX_parser();

		// XML Parsing
		if ( file_exists( LCPS_CUSTOM_THEME_XML_FILE ) ) {
			// PS XML From active Theme
			$parser->posts = $parser->parse( LCPS_CUSTOM_THEME_XML_FILE );
			$parser->process_posts();
		}
		elseif ( file_exists( LCPS_PLUGIN_XML_FILE ) ) {
			// PS XML From plugin
			$parser->posts = $parser->parse( LCPS_PLUGIN_XML_FILE );
			$parser->process_posts();
		}
	}

	// Hook: this plugin activation action
	static public function add_admin_lc_submenu()
	{
		global $dslc_plugin_options;

		//lc_desing_sections
		add_submenu_page(
			'dslc_plugin_options',
			'Predesigned Sections',
			'Predesigned Sections',
			'activate_plugins',
			'edit.php?post_type=' . LCPS_Base::POST_TYPE_NAME,
			null
		);
	}

	// (array) Return all posts sections with meta fields
	// + filter against duplication
	private function get_all_sections()
	{
		$result = array();

		$posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type'      => self::POST_TYPE_NAME,
			'orderby'        => 'post_title',
			'order'          => 'ASC',
		));

		if ( empty( $posts ) )
			return $result;

		// Add meta fields
		foreach ( $posts as $post ) {
			// Post obj attr`s to array
			$tmp = (array) $post;

			// Search PS img by post ID / title (1.jpg, 11.png...)
			$tmp['lcps_img'] = $this->_find_img_for_section( $tmp );

			// PS Categories
			$tmp['lcps_category'] = wp_get_post_terms(
				$post->ID,
				self::POST_TAXONOMY_CATEGORY,
				array( 'fields' => 'names' )
			);

			if ( empty( $tmp['lcps_category'] ) )
				continue;

			// (!) Fill sections by groups & group by tilte (filter against duplication)
			foreach ($tmp['lcps_category'] as $categoryName) {
				$result[ $categoryName ][ $tmp['post_title'] ] = $tmp;
			}
		}

		return $result;
	}

	// Searching img for current section
	// possible places: LCPS_PLUGIN_XML_IMG_PATH / LCPS_CUSTOM_THEME_XML_IMG_PATH
	// possible names: [ID] + '.(jpg|png|gif)' OR [TITLE] + '.(jpg|png|gif)'
	private function _find_img_for_section( $post )
	{
		$result = '';

		$_img_types = array( '.jpg', '.png', '.gif' );

		foreach ( $_img_types as $type ) {
			$img_file_name = strtolower(
				str_replace( ' ', '-', $post['post_title'] )
			);

			// All possible img paths
			$_paths = array(
				LCPS_PLUGIN_XML_IMG_URL . $post['ID'] . $type =>
				LCPS_PLUGIN_XML_IMG_PATH . $post['ID'] . $type,

				LCPS_CUSTOM_THEME_XML_IMG_URL . $post['ID'] . $type =>
				LCPS_CUSTOM_THEME_XML_IMG_PATH . $post['ID'] . $type,

				LCPS_PLUGIN_XML_IMG_URL . $img_file_name . $type =>
				LCPS_PLUGIN_XML_IMG_PATH . $img_file_name . $type,

				LCPS_CUSTOM_THEME_XML_IMG_URL . $img_file_name . $type =>
				LCPS_CUSTOM_THEME_XML_IMG_PATH . $img_file_name . $type,
			);

			foreach ( $_paths as $_url => $_path ) {
				if ( is_file( $_path ) ) {
					$result = $_url;
					break;
				}
			}
		}

		return $result;
	}

	// Main html part
	public function add_panel_html()
	{
		$groups = $this->get_all_sections();
		if ( empty( $groups ) )
			return;

		// ( ! ) HTML output:
		echo '<div id="lcps-panel">';
			echo '<div id="lcps-activate-butt" class="show-button noselect"><div class="label"><span class="dslca-icon dslc-icon-windows"></span>&nbsp;&nbsp;&nbsp;Section Designs</div></div>';
			echo '<div class="body">';

			// Select
			reset( $groups );
			$first_key = key( $groups );
			echo '<div class="groupTitle noselect"><span class="title">' . $first_key . '</span><span class="lc-icon-list-item-icon dslc-icon-caret-down"></span></div>';

			// Menu
			echo '<ul class="menu noselect">';
			foreach ( $groups as $group_title => $group ) {
				echo '<li class="noselect" rel="lcps-g-' . str_replace( '"', '', $group_title ) . '" >' . $group_title . '</li>';
			}
			echo '</ul>';

			// Elements
			$count = 0;
			foreach ( $groups as $group_title => $group ) {
				echo '<ul class="elements noselect' . ( 0 === $count++ ? ' active' : '' ) . '" id="lcps-g-' . str_replace( '"', '', $group_title ) . '">';

				foreach ( $group as $element ) {

					echo $this->_panel_elements_html( $element );
				}

				echo '</ul>';
			}

			echo '</div>';
		echo '</div>';
	}

	private function _panel_elements_html( $element )
	{
		$result = '';
		$dslc_code = get_post_custom_values( 'dslc_code', $element['ID'] );

		$result .= '<li class="ps">';
			if ( !empty( $element['lcps_img'] ) )
				$result .= '<div class="img-form" data-title="Click to insert on the page"><img src="' . $element['lcps_img'] . '" /></div>';

			// Options menu
			$result .= '
			<ul class="options">
				<li class="dropdown">
					<span title="Options" class="lc-icon-list-item-icon dslc-icon-gear"></span>
					<ul style="display: none;" class="dropdown-menu">
						<li><a target="__blank" class="editElement" href="/wp-admin/admin.php?page=livecomposer_editor&page_id=' . $element['ID'] .'">Edit section</a></li>
						<li><a class="deleteElement" href="#" rel="' . $element['ID'] . '">Delete section</a></li>
					</ul>
				</li>
			</ul>';

			$result .= '<div class="title">' . $element['post_title'] . '</div>';

			$result .= '<div class="shortcode" style="display: none;" >' . $dslc_code[0] . '</div>';
		$result .= '</li>';

		return $result;
	}
}}