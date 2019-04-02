<?php
/**
 * Main plugin class
 */

	// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

if ( ! class_exists( 'LC_Predesigned_Sections' ) ) :
	/**
	 * LC_Predesigned_Sections.
	 */
	class LC_Predesigned_Sections {
		protected $version = DS_LIVE_COMPOSER_VER;
		protected $design_lib_url = 'https://livecomposerplugin.com/designs/';

		// Main post type name.
		const POST_TYPE_NAME = 'lc-designs';
		const POST_TAXONOMY_CATEGORY = 'lc-designs-category';

		public function __construct() {

			// If debug always refresh css/js, otherwise use the main plugin version.
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$this->version = time();
			}

			// Add JavaScript and CSS.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			// Register new custom post type for sections storage.
			add_action( 'init', array( $this, 'custom_post_type' ) );
			// Add plugin HTML in page footer.
			add_action( 'admin_footer', array( $this, 'render_panel_html' ) );
			// 
			add_action( 'admin_footer', array( $this, 'add_predesigned_sections_from_xml' ) );

			add_action( 'admin_menu', array( $this, 'add_admin_lc_submenu' ) );
		}

		/**
		 * Delete all predesigned sections.
		 */
		static public function remove_predesigned_sections() {
			$custom_posts = get_posts(array(
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'post_type'      => self::POST_TYPE_NAME,
			));

			foreach ( $custom_posts as $custom_post ) {
				// Delete's each post to trash
				wp_delete_post( $custom_post->ID, false );
			}
		}

		/**
		 * Remove by user.
		 */
		static public function remove_predesigned_section_post() {
			return self::remove_predesigned_section( $_POST['delete_ps'] );
		}

		/**
		 * Remove predesigned section (only with right to delete).
		 */
		static public function remove_predesigned_section( $id ) {
			if ( ! current_user_can( 'delete_posts' ) ) {
				return false;
			}

			$result = wp_delete_post( intval( $id ), false );

			if ( false === $result ) {
				return false;
			}

			return true;
		}

		/**
		 * Hook: this plugin activation action.
		 */
		static public function add_predesigned_sections_from_xml() {
			$sections = wp_count_posts( self::POST_TYPE_NAME );
			$published_sections = $sections->publish;

			// Already have some sections imported. Stop processing.
			if ( $published_sections > 0 ) {
				return;
			}

			require_once 'class-lc-wrx-parser.php';
			$parser = new LCPS_WRX_parser();

			$files = array(
				'content.xml',
				'counter.xml',
				'features.xml',
				'pricing-tables.xml',
				// 'test.xml',
				// 'test-media.xml',
			);

			$all_parsed_posts = array();

			foreach ( $files as $key => $file ) {
				$xml_file = LCPS_XML_FILE . $file;

				if ( file_exists( $xml_file ) ) {
					$parsed_posts = $parser->parse( $xml_file );

					// PS XML From plugin.
					if ( is_array( $parsed_posts ) && isset( $parsed_posts['posts'] ) ) {
						$all_parsed_posts = array_merge( $all_parsed_posts, $parsed_posts['posts'] );
					}
				}
			}

			if ( count( $all_parsed_posts ) ) {
				$all_parsed_posts['posts'] = $all_parsed_posts;
				$parser->posts = $all_parsed_posts;
				$parser->process_posts();
			}
		}

		/**
		 * Hook: this plugin activation action.
		 */
		static public function add_admin_lc_submenu() {
			global $dslc_plugin_options;

			// lc-designs
			add_submenu_page(
				'dslc_plugin_options',
				__( 'Section Designs', 'live-composer-page-builder' ),
				'Section Designs',
				'activate_plugins',
				'edit.php?post_type=' . self::POST_TYPE_NAME,
				null
			);
		}

		// (array) Return all posts sections with meta fields
		// + filter against duplication
		// @todo: cache results!
		private function get_all_sections() {
			$result = array();

			$posts = get_posts( array(
				'posts_per_page' => 9999, // Never use -1. It's too slow.s
				'post_type'      => self::POST_TYPE_NAME,
				'orderby'        => 'post_title',
				'order'          => 'ASC',
			) );

			// Add meta fields.
			foreach ( $posts as $post ) {
				// Post obj attr`s to array.
				$tmp = (array) $post;

				// Search PS img by post ID / title (1.jpg, 11.png...)
				$tmp['lcps_img'] = $this->_find_img_for_section( $tmp );

				// PS Categories
				$tmp['lcps_category'] = wp_get_post_terms(
					$post->ID,
					self::POST_TAXONOMY_CATEGORY,
					array(
						'fields' => 'names',
					)
				);

				if ( empty( $tmp['lcps_category'] ) ) {
					continue;
				}

				// (!) Fill sections by groups & group by tilte (filter against duplication)
				foreach ( $tmp['lcps_category'] as $categoryName ) {
					$result[ $categoryName ][ $tmp['post_title'] ] = $tmp;
				}

				// $post['dslc_code'] = get_post_meta( $post->ID, 'dslc_code', true );
			}

			return $result;
		}

		/**
		 * Searching img for current section.
		 */
		private function _find_img_for_section( $post ) {
			$result = '';
			$category_section = get_the_terms( $post['ID'], self::POST_TAXONOMY_CATEGORY );
			$category_slug = $category_section[0]->slug;

			$_img_types = array( '.jpg', '.png', '.gif' );

			foreach ( $_img_types as $type ) {
				$img_file_name = strtolower(
					str_replace( ' ', '-', $post['post_title'] )
				);

				// All possible img paths
				$_paths = array(
					LCPS_XML_IMG_URL . $category_slug . '/' . $img_file_name . $type =>
					LCPS_XML_IMG_PATH . $category_slug . '/' . $img_file_name . $type,
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

		/**
		 * Main html part.
		 */
		public function render_panel_html() {
			$groups = $this->get_all_sections();

			// if ( empty( $groups ) ) {
			// 	return;
			// }

			// $dir = plugin_dir_path( __FILE__ );
			// $dir_path = $dir . 'desings/sections/content.xml';
			// $dslc_code = file_get_contents( $dir_path );


			// $dslc_code = get_post_custom_values( 'dslc_code', $element['ID'] );
			/*
			$groups = array (
				'headers' => array (
					'icon'=>'dashicons dashicons-welcome-learn-more',
					'title'=>'Headers',
					'items'=> array (
						'header_1' => array (
							'set' => 'default/headers',
							'image' => 'header-1',
							'file' => $dslc_code,
						),
						'header_2' => array (
							'set' => 'default/headers',
							'image' => 'header-2',
							'file' => 'Somecode',
						),
						'header_3' => array (
							'set' => 'default/headers',
							'image' => 'header-3',
							'file' => 'Somecode',
						),
						'header_4' => array (
							'set' => 'default/headers',
							'image' => 'header-4',
							'file' => 'Somecode',
						),
						'header_5' => array (
							'set' => 'default/headers',
							'image' => 'header-5',
							'file' => 'Somecode',
						),
						'header_6' => array (
							'set' => 'default/headers',
							'image' => 'header-6',
							'file' => 'Somecode',
						),
						'header_7' => array (
							'set' => 'default/headers',
							'image' => 'header-7',
							'file' => 'Somecode',
						),
					)
				),
				'hero' => array (
					'icon'=>'dashicons dashicons-megaphone',
					'title'=>'Hero',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'content' => array (
					'icon'=>'dashicons dashicons-text',
					'title'=>'Content',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'cta' => array (
					'icon'=>'dashicons dashicons-carrot',
					'title'=>'Call to actions',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'clients' => array (
					'icon'=>'dashicons dashicons-businessman',
					'title'=>'Clients',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'testimonials' => array (
					'icon'=>'dashicons dashicons-format-quote',
					'title'=>'Testimonials',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'social-share' => array (
					'icon'=>'dashicons dashicons-share',
					'title'=>'Social Share',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'contacts' => array (
					'icon'=>'dashicons dashicons-email',
					'title'=>'Contacts',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'features' => array (
					'icon'=>'dashicons dashicons-star-filled',
					'title'=>'Features',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'pricing' => array (
					'icon'=>'dashicons dashicons-cart',
					'title'=>'Pricing Tables',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'grid' => array (
					'icon'=>'dashicons dashicons-screenoptions',
					'title'=>'Post Grids',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'teams' => array (
					'icon'=>'dashicons dashicons-id',
					'title'=>'Teams',
					'items'=> array (
						'Header 1' => 'Somecode',
						'Header 2' => 'Somecode',
					)
				),
				'footers' => array (
					'icon'=>'dashicons dashicons-arrow-down-alt',
					'title'=>'Footers',
					'items'=> array (
						'Footer 1' => 'Somecode',
						'Footer 2' => 'Somecode',
					)
				),
			);
			*/

			// ( ! ) HTML output:
			echo '<div id="lcps-panel">';
				echo '<div id="lcps-activate-butt" class="show-button noselect"><div class="label"><span class="dslca-icon dslc-icon-windows"></span>&nbsp;&nbsp;&nbsp;Section Designs</div></div>';
				echo '<div class="lcps-panel__body">';
					echo '<ul class="lcps-cats">';

					// Select
					// 	reset( $groups );
					// 	$first_key = key( $groups );
					// 	echo '<div class="groupTitle noselect"><span class="title">' . $first_key . '</span><span class="lc-icon-list-item-icon dslc-icon-caret-down"></span></div>';

					// Menu
					// 	echo '<ul class="menu noselect">';
					// foreach ( $groups as $group_title => $group ) {
					// 	echo '<li class="noselect" rel="lcps-g-' . str_replace( array( ':', '\\', '/', '*', ' ' ), '', $group_title ) . '" >' . $group_title . '</li>';
					// }
					// 	echo '</ul>';

						// Elements
						$count = 0;
						foreach ( $groups as $group_key => $group_category ) {
							?>
								<li class="lcps_cat" data-design-category="<?php echo esc_attr( $group_key ); ?>"><span class="lcps_cat__icon <?php echo esc_attr( $group_key ); ?>"></span><?php echo esc_attr( $group_key ); ?></li>

							<?php
						}

					echo '</ul>'; // lcps-categories.
				echo '</div>';
				?>
				<div class="lcps-designs">
				<?php
				foreach ( $groups as $group_key => $group_designs ) :
					?>
						<ul class="lcps-designs__category <?php echo esc_attr( $group_key ) ?>">
							<?php foreach ( $group_designs as $design_title => $design_data ) : ?>
								<li class="lcps-designs__single" ondragstart="return false" ondrop="return false" >
									<img src="<?php echo esc_attr( $design_data['lcps_img'] ) ?>" alt="" title="<?php esc_html_e( 'Click to insert', 'live-composer-page-builder' ) ?>" ondragstart="return false" ondrop="return false" />
									<span class="shortcode" style="display: none;" ><?php echo get_post_meta( $design_data['ID'], 'dslc_code', true ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>

					<?php
				endforeach;
			echo '</div>';
		}

		/**
		 * Register new custom post type to store sections code.
		 */
		static public function custom_post_type() {
			$args = array(
				'labels'             => array(
					'name'               => 'Section Designs',
					'singular_name'      => 'Section',
					'add_new'            => __( 'Add New', 'section', 'live-composer-page-builder' ),
					'add_new_item'       => __( 'Add New Section', 'live-composer-page-builder' ),
					'edit_item'          => __( 'Edit Section', 'live-composer-page-builder' ),
					'new_item'           => __( 'New Section', 'live-composer-page-builder' ),
					'all_items'          => __( 'All Sections', 'live-composer-page-builder' ),
					'view_item'          => __( 'View Section', 'live-composer-page-builder' ),
					'search_items'       => __( 'Search Sections', 'live-composer-page-builder' ),
					'not_found'          => __( 'No sections found', 'live-composer-page-builder' ),
					'not_found_in_trash' => __( 'No sections found in the Trash', 'live-composer-page-builder' ),
					'parent_item_colon'  => '',
					'menu_name'          => 'Section Designs',
				),
				'taxonomies'         => array( 'lc-designs-category' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => false,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor', 'custom-fields' ),
			);

			register_post_type( self::POST_TYPE_NAME, $args );
			self::custom_taxonomy();
		}

		/**
		 * Register Custom Taxonomy to categorize sections.
		 */
		static public function custom_taxonomy() {
			$labels = array(
				'name'                       => _x( 'Sections categories', 'Taxonomy General Name', 'live-composer-page-builder' ),
				'singular_name'              => _x( 'Sections category', 'Taxonomy Singular Name', 'live-composer-page-builder' ),
				'menu_name'                  => __( 'Taxonomy', 'live-composer-page-builder' ),
				'all_items'                  => __( 'All Items', 'live-composer-page-builder' ),
				'parent_item'                => __( 'Parent Item', 'live-composer-page-builder' ),
				'parent_item_colon'          => __( 'Parent Item:', 'live-composer-page-builder' ),
				'new_item_name'              => __( 'New Item Name', 'live-composer-page-builder' ),
				'add_new_item'               => __( 'Add New Item', 'live-composer-page-builder' ),
				'edit_item'                  => __( 'Edit Item', 'live-composer-page-builder' ),
				'update_item'                => __( 'Update Item', 'live-composer-page-builder' ),
				'view_item'                  => __( 'View Item', 'live-composer-page-builder' ),
				'separate_items_with_commas' => __( 'Separate items with commas', 'live-composer-page-builder' ),
				'add_or_remove_items'        => __( 'Add or remove items', 'live-composer-page-builder' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'live-composer-page-builder' ),
				'popular_items'              => __( 'Popular Items', 'live-composer-page-builder' ),
				'search_items'               => __( 'Search Items', 'live-composer-page-builder' ),
				'not_found'                  => __( 'Not Found', 'live-composer-page-builder' ),
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
			register_taxonomy( self::POST_TAXONOMY_CATEGORY, array( self::POST_TYPE_NAME ), $args );
		}

		/**
		 * Load JS and CSS files while LC in editing mode.
		 */
		public function enqueue_scripts( $hook ) {

			// Output only on the LC editing page.
			if ( 'toplevel_page_livecomposer_editor' != $hook ) {
				return;
			}

			wp_enqueue_style( 'lc-predesigned-section-style', plugins_url( '/css/lc-predesigned-section.css' , __FILE__ ), array(), $this->version, 'all' );
			wp_enqueue_script( 'lc-predesigned-section-script',  plugins_url( '/js/lc-predesigned-section.js', __FILE__ ) ,array( 'jquery', 'hoverIntent' ), $this->version );
		}
	}
endif;