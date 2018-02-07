<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Posts extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Posts';
		$this->module_title = __( 'Posts', 'live-composer-page-builder' );
		$this->module_icon = 'th-large';
		$this->module_category = 'Post-Based';

	}

	/**
	 * Module options.
	 * Function build array with all the module functionality and styling options.
	 * Based on this array Live Composer builds module settings panel.
	 * – Every array inside $dslc_options means one option = one control.
	 * – Every option should have unique (for this module) id.
	 * – Options divides on "Functionality" and "Styling".
	 * – Styling options start with css_XXXXXXX
	 * – Responsive options start with css_res_t_ (Tablet) or css_res_p_ (Phone)
	 * – Options can be hidden.
	 * – Options can have a default value.
	 * – Options can request refresh from server on change or do live refresh via CSS.
	 *
	 * @return array All the module options in array.
	 */
	function options() {

		// Check if we have this module options already calculated
		// and cached in WP Object Cache.
		$cached_dslc_options = wp_cache_get( 'dslc_options_' . $this->module_id, 'dslc_modules' );
		if ( $cached_dslc_options ) {
			return apply_filters( 'dslc_module_options', $cached_dslc_options, $this->module_id );
		}

		// Get registered post types.
		$post_types = get_post_types( array(
			'public' => true,
		), 'objects' );
		$post_types_choices = array();

		// System post types that should not appear in selector.
		$post_types_to_ignore = array(
			'dslc_templates',
			'dslc_hf',
			'attachment',
		);

		// Generate usable array of post types.
		foreach ( $post_types as $post_type_id => $post_type ) {

			// Do not output system post-types.
			if ( ! in_array( $post_type_id, $post_types_to_ignore ) ) {
				$post_types_choices[] = array(
					'label' => $post_type->labels->name,
					'value' => $post_type_id,
				);
			}
		}

		// Options.
		$dslc_options = array(

			array(
				'label' => __( 'Show On', 'live-composer-page-builder' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'live-composer-page-builder' ),
						'value' => 'desktop',
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet',
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone',
					),
				),
			),
			array(
				'label' => __( 'Post Types', 'live-composer-page-builder' ),
				'id' => 'post_type',
				'std' => 'post',
				'type' => 'select',
				'choices' => $post_types_choices,
				'tab' => 'posts query',
			),

			array(
				'label' => __( 'Type', 'live-composer-page-builder' ),
				'id' => 'type',
				'std' => 'grid',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Grid', 'live-composer-page-builder' ),
						'value' => 'grid',
					),
					array(
						'label' => __( 'Masonry Grid', 'live-composer-page-builder' ),
						'value' => 'masonry',
					),
					array(
						'label' => __( 'Carousel', 'live-composer-page-builder' ),
						'value' => 'carousel',
					),
				),
			),
			array(
				'label' => __( 'Posts Per Row', 'live-composer-page-builder' ),
				'id' => 'columns',
				'std' => '3',
				'type' => 'select',
				'choices' => $this->shared_options( 'posts_per_row_choices' ),
			),
			array(
				'label' => __( 'Orientation', 'live-composer-page-builder' ),
				'id' => 'orientation',
				'std' => 'vertical',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Vertical', 'live-composer-page-builder' ),
						'value' => 'vertical',
					),
					array(
						'label' => __( 'Horizontal', 'live-composer-page-builder' ),
						'value' => 'horizontal',
					),
				),
			),
			array(
				'label' => __( 'Posts Per Page', 'live-composer-page-builder' ),
				'id' => 'amount',
				'std' => '4',
				'type' => 'text',
				'tab' => 'pagination',
			),
			array(
				'label' => __( 'Pagination', 'live-composer-page-builder' ),
				'id' => 'pagination_type',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Numbered', 'live-composer-page-builder' ),
						'value' => 'numbered',
					),
					array(
						'label' => __( 'Prev/Next', 'live-composer-page-builder' ),
						'value' => 'prevnext',
					),
					array(
						'label' => __( 'Load More', 'live-composer-page-builder' ),
						'value' => 'loadmore',
					),
				),
				'tab' => 'pagination',
			),
			array(
				'label' => __( 'Order By', 'live-composer-page-builder' ),
				'id' => 'orderby',
				'std' => 'date',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Publish Date', 'live-composer-page-builder' ),
						'value' => 'date',
					),
					array(
						'label' => __( 'Modified Date', 'live-composer-page-builder' ),
						'value' => 'modified',
					),
					array(
						'label' => __( 'Random', 'live-composer-page-builder' ),
						'value' => 'rand',
					),
					array(
						'label' => __( 'Alphabetic', 'live-composer-page-builder' ),
						'value' => 'title',
					),
					array(
						'label' => __( 'Comment Count', 'live-composer-page-builder' ),
						'value' => 'comment_count',
					),
				),
			),
			array(
				'label' => __( 'Order', 'live-composer-page-builder' ),
				'id' => 'order',
				'std' => 'DESC',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Ascending', 'live-composer-page-builder' ),
						'value' => 'ASC',
					),
					array(
						'label' => __( 'Descending', 'live-composer-page-builder' ),
						'value' => 'DESC',
					),
				),
			),
			array(
				'label' => __( 'Offset', 'live-composer-page-builder' ),
				'id' => 'offset',
				'std' => '0',
				'type' => 'text',
				'tab' => 'posts query',
			),
			array(
				'label' => __( 'Sticky Posts', 'live-composer-page-builder' ),
				'id' => 'sticky_posts',
				'help' => __( 'If enabled sticky posts will be pushed to the top. If disabled sticky posts will follow regular order.', 'live-composer-page-builder' ),
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
				),
				'tab' => 'pagination',
			),
			array(
				'label' => __( 'Include (IDs)', 'live-composer-page-builder' ),
				'id' => 'query_post_in',
				'std' => '',
				'type' => 'text',
				'tab' => 'posts query',
			),
			array(
				'label' => __( 'Exclude (IDs)', 'live-composer-page-builder' ),
				'id' => 'query_post_not_in',
				'std' => '',
				'type' => 'text',
				'tab' => 'posts query',
			),

			/**
			 * Archive Listinging
			 */

			array(
				'label' => __( 'Archive/Search Listing', 'live-composer-page-builder' ),
				'id' => 'query_alter',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Apply Page Query', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
					array(
						'label' => __( 'Ignore Page Query', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
				),
				'tab' => 'posts query',
				'help' => __( 'Apply Page Query – show posts according to the selected tag, category, author or search query.<br /> Ignore Page Query – ignore the page query and list posts as on any other page.', 'live-composer-page-builder' ),
			),

			/**
			 * Styling
			 */

			array(
				'label' => __( 'Elements', 'live-composer-page-builder' ),
				'id' => 'elements',
				'std' => '',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Heading', 'live-composer-page-builder' ),
						'value' => 'main_heading',
					),
					array(
						'label' => __( 'Filters', 'live-composer-page-builder' ),
						'value' => 'filters',
					),
				),
				'section' => 'styling',
			),

			array(
				'label' => __( 'Post Elements', 'live-composer-page-builder' ),
				'id' => 'post_elements',
				'std' => 'thumbnail meta title excerpt button',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Thumbnail', 'live-composer-page-builder' ),
						'value' => 'thumbnail',
					),
					array(
						'label' => __( 'Title', 'live-composer-page-builder' ),
						'value' => 'title',
					),
					array(
						'label' => __( 'Meta', 'live-composer-page-builder' ),
						'value' => 'meta',
					),
					array(
						'label' => __( 'Excerpt', 'live-composer-page-builder' ),
						'value' => 'excerpt',
					),
					array(
						'label' => __( 'Button', 'live-composer-page-builder' ),
						'value' => 'button',
					),
				),
				'section' => 'styling',
			),

			array(
				'label' => __( 'Carousel Elements', 'live-composer-page-builder' ),
				'id' => 'carousel_elements',
				'std' => 'arrows circles',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Arrows', 'live-composer-page-builder' ),
						'value' => 'arrows',
					),
					array(
						'label' => __( 'Circles', 'live-composer-page-builder' ),
						'value' => 'circles',
					),
				),
				'section' => 'styling',
			),

			/**
			 * Wrapper
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-posts',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'increment' => 5,
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-posts',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Separator
			 */

			array(
				'label' => __( 'Enable/Disable', 'live-composer-page-builder' ),
				'id' => 'separator_enabled',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
				),
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_sep_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Height', 'live-composer-page-builder' ),
				'id' => 'css_sep_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'max' => 300,
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thickness', 'live-composer-page-builder' ),
				'id' => 'css_sep_thickness',
				'onlypositive' => true, // Value can't be negative.
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-bottom-width',
				'ext' => 'px',
				'max' => 50,
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Style', 'live-composer-page-builder' ),
				'id' => 'css_sep_style',
				'std' => 'dashed',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Invisible', 'live-composer-page-builder' ),
						'value' => 'none',
					),
					array(
						'label' => __( 'Solid', 'live-composer-page-builder' ),
						'value' => 'solid',
					),
					array(
						'label' => __( 'Dashed', 'live-composer-page-builder' ),
						'value' => 'dashed',
					),
					array(
						'label' => __( 'Dotted', 'live-composer-page-builder' ),
						'value' => 'dotted',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),

			/**
			 * Thumbnail
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_thumb_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_thumb_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_color',
				'std' => '#e6e6e6',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '4',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb, .dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb, .dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'thumb_margin',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Right', 'live-composer-page-builder' ),
				'id' => 'thumb_margin_right',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_thumb_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_thumb_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Height', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'visibility' => 'hidden',
			),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'thumb_width',
				'onlypositive' => true, // Value can't be negative.
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'min' => 1,
				'max' => 100,
				'ext' => '%',
			),

			/**
			 * Main
			 */

			array(
				'label' => __( 'Location', 'live-composer-page-builder' ),
				'id' => 'main_location',
				'std' => 'bellow',
				'type' => 'select',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Bellow Thumbnail', 'live-composer-page-builder' ),
						'value' => 'bellow',
					),
					array(
						'label' => __( 'Inside Thumbnail ( hover )', 'live-composer-page-builder' ),
						'value' => 'inside',
					),
					array(
						'label' => __( 'Inside Thumbnail ( always visible )', 'live-composer-page-builder' ),
						'value' => 'inside_visible',
					),
				),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_main_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_main_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_main_border_trbl',
				'std' => 'right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '4',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_main_min_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'max' => 500,
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_main_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_main_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'wihtout_inner_shadow' => true,
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),

			/**
			 * Main Inner
			 */

			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'main_position',
				'std' => 'center',
				'type' => 'select',
				'section' => 'styling',
				'tab' => __( 'Main Inner', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'topleft',
					),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'topright',
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center',
					),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'bottomleft',
					),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'bottomright',
					),
				),
			),
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_main_inner_margin',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main-inner',
				'affect_on_change_rule' => 'margin',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main Inner', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'css_main_inner_width',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main-inner',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'ext' => '%',
				'tab' => __( 'Main Inner', 'live-composer-page-builder' ),
			),

			/**
			 * Title Options
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'title_color',
				'std' => '#4d4d4d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'title_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2:hover,.dslc-cpt-post-title h2 a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'title_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_title_font_weight',
				'std' => '500',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_title_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'title_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '29',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'title_margin',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_title_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'live-composer-page-builder' ),
						'value' => 'none',
					),
					array(
						'label' => __( 'Capitalize', 'live-composer-page-builder' ),
						'value' => 'capitalize',
					),
					array(
						'label' => __( 'Uppercase', 'live-composer-page-builder' ),
						'value' => 'uppercase',
					),
					array(
						'label' => __( 'Lowercase', 'live-composer-page-builder' ),
						'value' => 'lowercase',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			/**
			 * Meta
			 */

			array(
				'label' => __( 'Meta Elements', 'live-composer-page-builder' ),
				'id' => 'meta_elements',
				'std' => 'author date',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Author', 'live-composer-page-builder' ),
						'value' => 'author',
					),
					array(
						'label' => __( 'Date', 'live-composer-page-builder' ),
						'value' => 'date',
					),
				),
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_meta_border_color',
				'std' => '#e5e5e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_meta_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_meta_border_trbl',
				'std' => 'top bottom',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_meta_color',
				'std' => '#a8a8a8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_meta_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_meta_font_family',
				'std' => 'Libre Baskerville',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_meta_font_weight',
				'std' => '400',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_meta_margin_bottom',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_meta_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 60,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_meta_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Link - Color', 'live-composer-page-builder' ),
				'id' => 'css_meta_link_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Link - Hover - Color', 'live-composer-page-builder' ),
				'id' => 'css_meta_link_color_hover',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Meta', 'live-composer-page-builder' ),
			),

			/**
			 * Excerpt
			 */

			array(
				'label' => __( 'Excerpt or Content', 'live-composer-page-builder' ),
				'id' => 'excerpt_or_content',
				'std' => 'excerpt',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Excerpt', 'live-composer-page-builder' ),
						'value' => 'excerpt',
					),
					array(
						'label' => __( 'Content', 'live-composer-page-builder' ),
						'value' => 'content',
					),
				),
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_color',
				'std' => '#a6a6a6',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_weight',
				'std' => '500',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_family',
				'std' => 'Bitter',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt, .dslc-cpt-post-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'excerpt_margin',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Max Length ( amount of words )', 'live-composer-page-builder' ),
				'id' => 'excerpt_length',
				'std' => '20',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),

			/**
			 * Button
			 */

			array(
				'label' => __( 'Text', 'live-composer-page-builder' ),
				'id' => 'button_text',
				'std' => 'CONTINUE READING',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_button_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_bg_color_hover',
				'std' => '#4b7bc2',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_button_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_button_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_button_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_button_border_radius',
				'onlypositive' => true, // Value can't be negative.
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_button_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_button_font_weight',
				'std' => '800',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_button_font_family',
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Show Icon', 'live-composer-page-builder' ),
				'id' => 'show_icon',
				'std' => 'font',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Font', 'live-composer-page-builder' ),
						'value' => 'font',
					),
					array(
						'label' => __( 'SVG', 'live-composer-page-builder' ),
						'value' => 'svg',
					),
				),
				'dependent_controls' => array(
					'font' => 'button_icon_id',
					'svg' => 'button_inline_svg, css_button_icon_size_svg',
				),
				'help' => __( 'Select type of icon.', 'live-composer-page-builder' ),
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon', 'live-composer-page-builder' ),
				'id' => 'button_icon_id',
				'std' => '',
				'type' => 'icon',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Inline SVG', 'live-composer-page-builder' ),
				'id' => 'button_inline_svg',
				'std' => '',
				'type' => 'textarea',
				'section' => 'functionality',
				'help' => __( 'Paste your SVG code.', 'live-composer-page-builder' ),
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Size ( SVG )', 'live-composer-page-builder' ),
				'id' => 'css_button_icon_size_svg',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a svg',
				'affect_on_change_rule' => 'width, height',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Icon - Color', 'live-composer-page-builder' ),
				'id' => 'css_button_icon_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a .dslc-icon, .dslc-cpt-post-read-more a svg',
				'affect_on_change_rule' => 'color, fill',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon - Hover - Color', 'live-composer-page-builder' ),
				'id' => 'css_button_icon_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a:hover .dslc-icon, .dslc-cpt-post-read-more a:hover svg',
				'affect_on_change_rule' => 'color, fill',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_button_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a .dslc-icon, .dslc-cpt-post-read-more a svg',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Separator - Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_sep_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumb_margin',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Thumbnail - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumb_margin_right',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumb_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumb_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '29',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2, .dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_margin',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Meta - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_meta_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Meta - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_meta_margin_bottom',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Meta - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_meta_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 60,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Meta - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_meta_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt, .dslc-cpt-post-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_margin',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Icon - Size ( SVG )', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_icon_size_svg',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a svg',
				'affect_on_change_rule' => 'width, height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a .dslc-icon, .dslc-cpt-post-read-more a svg',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Separator - Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_sep_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumb_margin',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Thumbnail - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumb_margin_right',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumb_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumb_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '29',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title h2,.dslc-cpt-post-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_margin',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Meta - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_meta_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Meta - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_meta_margin_bottom',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Meta - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_meta_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 60,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Meta - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_meta_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-meta',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt, .dslc-cpt-post-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_margin',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Icon - Size ( SVG )', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_icon_size_svg',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a svg',
				'affect_on_change_rule' => 'width, height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cpt-post-read-more a .dslc-icon, .dslc-cpt-post-read-more a svg',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'carousel_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'heading_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'filters_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'carousel_arrows_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'carousel_circles_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'pagination_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		// Cache calculated array in WP Object Cache.
		wp_cache_add( 'dslc_options_' . $this->module_id, $dslc_options ,'dslc_modules' );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	/**
	 * Module HTML output.
	 *
	 * @param  array $options Module options to fill the module template.
	 * @return void
	 */
	function output( $options ) {
		// Render the module output in the shortcode
		// to make sure it's not cached in LC and pagination works as expected.
		// @todo: add conditional caching only if pagination used.
		// if ( 'disabled' === $options['pagination_type'] )
		// # code...
		// }
		echo '[dslc_module_posts_output]' . serialize( $options ) . '[/dslc_module_posts_output]';
	}
}

function dslc_module_posts_output( $atts, $content = null ) {
	// Uncode module options passed as serialized content.
	$options = unserialize( $content );

	ob_start();

	if ( is_feed() ) {
		// Prevent category/tag feeds to stuck in an infinite loop.
		return false;
	}

		global $dslc_active;

	if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
		$dslc_is_admin = true;
	} else {
		$dslc_is_admin = false;
	}

		// Fix slashes on apostrophes.
	if ( isset( $options['button_text'] ) ) {
		$options['button_text'] = stripslashes( $options['button_text'] );
	}

		/* CUSTOM START */

	if ( ! isset( $options['excerpt_length'] ) ) {
		$options['excerpt_length'] = 20;
	}

		$post_type = array();

	if ( isset( $options['post_type'] ) ) {

		$post_type_str = trim( $options['post_type'] );

		if ( stristr( $post_type_str , ' ' ) ) {

			// Many post types selected.
			$post_type = explode( ' ', trim( $options['post_type'] ) );

		} else {

			// Single post type selected
			$post_type[] = $post_type_str;
		}
	}

	/**
	 * Query
	 */

	// Fix for pagination.
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}

	// Fix for pagination from other modules affecting this one when pag disabled.
	if ( 'disabled' === $options['pagination_type'] ) {
		$paged = 1;
	}

	// Fix for offset braking pagination.
	$query_offset = $options['offset'];
	if ( $query_offset > 0 && $paged > 1 ) {
		$query_offset = ( $paged - 1 ) * $options['amount'] + $options['offset'];
	}

	// General args.
	$args = array(
		'paged' => $paged,
		'post_type' => $post_type,
		'posts_per_page' => $options['amount'],
		'order' => $options['order'],
		'orderby' => $options['orderby'],
	);

	// Add offset.
	if ( $query_offset > 0 ) {
		$args['offset'] = $query_offset;
	}

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		$args['post_status'] = array( 'publish', 'private' );
	}

	// Category args.
	if ( isset( $options['categories'] ) && '' !== $options['categories'] ) {
		$cats_array = explode( ' ', $options['categories'] );
		$args['category__in'] = $cats_array;
	}

	// Exlcude and Include arrays.
	$exclude = array();
	$include = array();

	// Exclude current post.
	if ( is_singular( get_post_type() ) ) {
		$exclude[] = get_the_ID();
	}

	// Exclude posts ( option ).
	if ( $options['query_post_not_in'] ) {
		$exclude = array_merge( $exclude, explode( ' ', $options['query_post_not_in'] ) );
	}

	// Include posts ( option ).
	if ( $options['query_post_in'] ) {
		$include = array_merge( $include, explode( ' ', $options['query_post_in'] ) );
	}

	// Include query parameter.
	if ( ! empty( $include ) ) {
		$args['post__in'] = $include;
	}

	// Exclude query parameter.
	if ( ! empty( $exclude ) ) {
		$args['post__not_in'] = $exclude;
	}

	// Author archive page.
	if ( is_author() && 'enabled' === $options['query_alter'] ) {
		global $authordata;
		$args['author__in'] = array( $authordata->data->ID );
	}

	// No paging.
	if ( 'disabled' === $options['pagination_type'] ) {
		$args['no_found_rows'] = true;
	}

	// Sticky Posts.
	if ( 'disabled' === $options['sticky_posts'] ) {
		$args['ignore_sticky_posts'] = true;
	}

	// Do the query.
	if ( ( is_category() || is_tag() || is_tax() || is_search() || is_date() ) && 'enabled' === $options['query_alter'] ) {
		global $wp_query;
		$dslc_query = $wp_query;

		if ( isset( $options['amount'] ) ) {
			$dslc_query->set( 'posts_per_page', $options['amount'] );
			$dslc_query->query( $dslc_query->query_vars );
		}
	} else {
		$dslc_query = new WP_Query( $args );
	}

	/**
	 * Unnamed
	 */

	$columns_class = 'dslc-col dslc-' . $options['columns'] . '-col ';
	$count = 0;
	$real_count = 0;
	$increment = $options['columns'];
	$max_count = 12;

	/**
	 * Elements to show
	 */

	// Main Elements
	$elements = $options['elements'];
	if ( ! empty( $elements ) ) {
		$elements = explode( ' ', trim( $elements ) );
	} else {
		$elements = array();
	}

	// Post Elements
	$post_elements = $options['post_elements'];
	if ( ! empty( $post_elements ) ) {
		$post_elements = explode( ' ', trim( $post_elements ) );
	} else {
		$post_elements = 'all';
	}

	// Carousel Elements
	$carousel_elements = $options['carousel_elements'];
	if ( ! empty( $carousel_elements ) ) {
		$carousel_elements = explode( ' ', trim( $carousel_elements ) );
	} else {
		$carousel_elements = array();
	}

	/**
	 * Classes generation
	 */

	// Posts container.
	$container_class = 'dslc-posts dslc-cpt-posts dslc-clearfix dslc-cpt-posts-type-' . $options['type'] . ' dslc-posts-orientation-' . $options['orientation'] . ' ';
	if ( $options['type'] == 'masonry' ) {
		$container_class .= 'dslc-init-masonry ';
	} elseif ( $options['type'] == 'grid' ) {
		$container_class .= 'dslc-init-grid ';
	}

	// Post
	$element_class = 'dslc-post dslc-cpt-post ';
	if ( $options['type'] == 'masonry' ) {
		$element_class .= 'dslc-masonry-item ';
	} elseif ( $options['type'] == 'carousel' ) {
		$element_class .= 'dslc-carousel-item ';
	}

	/**
	 * What is shown
	 */

	$show_header = false;
	$show_heading = false;
	$show_filters = false;
	$show_carousel_arrows = false;
	$show_view_all_link = false;

	if ( in_array( 'main_heading', $elements, true ) ) {
		$show_heading = true;
	}

	if ( ( 'all' === $elements || in_array( 'filters', $elements, true ) ) && 'carousel' !== $options['type'] ) {
		$show_filters = true;
	}

	if ( 'carousel' === $options['type'] && in_array( 'arrows', $carousel_elements, true ) ) {
		$show_carousel_arrows = true;
	}

	if ( $show_heading || $show_filters || $show_carousel_arrows ) {
		$show_header = true;
	}
	
	if ( $show_carousel_arrows && ( $options['arrows_position'] == 'aside' ) ) {
		$container_class .= 'dslc-carousel-arrow-aside ';
	}

	/**
	 * Carousel Items
	 */

	switch ( $options['columns'] ) {
		case 12 :
			$carousel_items = 1;
			break;
		case 6 :
			$carousel_items = 2;
			break;
		case 4 :
			$carousel_items = 3;
			break;
		case 3 :
			$carousel_items = 4;
			break;
		case 2 :
			$carousel_items = 6;
			break;
		default:
			$carousel_items = 6;
			break;
	}

	/**
	 * Heading ( output )
	 */

	if ( $show_header ) : ?>
		<div class="dslc-module-heading">

			<!-- Heading -->
			<?php if ( $show_heading ) : ?>
				<div class="dslc-post-heading">

					<h2 class="dslca-editable-content" data-id="main_heading_title" data-type="simple" <?php if ( $dslc_is_admin ) { echo 'contenteditable';} ?> ><?php echo stripslashes( $options['main_heading_title'] ); ?></h2>

					<!-- View all -->

					<?php if ( isset( $options['view_all_link'] ) && $options['view_all_link'] !== '' ) : ?>

						<span class="dslc-module-heading-view-all"><a href="<?php echo $options['view_all_link']; ?>" class="dslca-editable-content" data-id="main_heading_link_title" data-type="simple" <?php if ( $dslc_is_admin ) { echo 'contenteditable';} ?> ><?php echo $options['main_heading_link_title']; ?></a></span>

					<?php endif; ?>

				</div>
			<?php endif; ?>

			<!-- Filters -->
			<?php
			$taxonomy_name = '';
			if ( $show_filters ) {

				$cats_array = array();
				$cats_count = 0;

				if ( $dslc_query->have_posts() ) {
					while ( $dslc_query->have_posts() ) {
						$dslc_query->the_post();
						$cats_count++;

						if ( $cats_count == 1 ) {
							$post_type_taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
							foreach ( $post_type_taxonomies as $taxonomy ) {
								if ( $taxonomy->hierarchical == true ) {
									$taxonomy_name = $taxonomy->name;
								}
							}
						}

						$post_cats = get_the_terms( get_the_ID(), $taxonomy_name );
						if ( ! empty( $post_cats ) ) {
							foreach ( $post_cats as $post_cat ) {
								$cats_array[ $post_cat->slug ] = $post_cat->name;
							}
						}
					}
				}
			?>
				<div class="dslc-post-filters">
					<span class="dslc-post-filter dslc-active dslca-editable-content" data-filter-id="show-all" <?php if ( $dslc_is_admin ) { echo 'data-id="main_filter_title_all" data-type="simple" contenteditable '; } ?>><?php echo $options['main_filter_title_all']; ?></span>

					<?php foreach ( $cats_array as $cat_slug => $cat_name ) : ?>
						<span class="dslc-post-filter dslc-inactive" data-filter-id="<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></span>
					<?php endforeach; ?>

				</div><!-- .dslc-post-filters --><?php
		} // End if( $show_filters ).

		?>

		<!-- Carousel -->

		<?php if ( $show_carousel_arrows && ( $options['arrows_position'] == 'above' ) ) : ?>
							<span class="dslc-carousel-nav fr">
								<span class="dslc-carousel-nav-inner">
									<a href="#" class="dslc-carousel-nav-prev"><span class="dslc-icon-chevron-left"></span></a>
									<a href="#" class="dslc-carousel-nav-next"><span class="dslc-icon-chevron-right"></span></a>
								</span>
							</span><!-- .carousel-nav -->
						<?php endif; ?>

			</div><!-- .dslc-module-heading -->
				<?php

			endif;

	/**
	 * Posts ( output )
	 */

	if ( $dslc_query->have_posts() ) { ?>
		<div class="<?php echo $container_class; ?>">
			
			<?php if ( $show_carousel_arrows && ( $options['arrows_position'] == 'aside' ) ) : ?>
				<a href="#" class="dslc-carousel-nav-prev position-aside"><span class="dslc-icon-chevron-left"></span></a>
			<?php endif; ?>
			
			<div class="dslc-posts-inner"><?php

				if ( $options['type'] == 'carousel' ) : ?>
					<div class="dslc-loader"></div>
					<div class="dslc-carousel"
						data-stop-on-hover="<?php echo $options['carousel_autoplay_hover']; ?>"
						data-autoplay="<?php echo $options['carousel_autoplay']; ?>"
						data-columns="<?php echo $carousel_items; ?>"
						data-pagination="<?php
							if ( in_array( 'circles', $carousel_elements ) ) {
								echo 'true';
							} else {
								echo 'false';
							} ?>"
						data-slide-speed="<?php echo $options['arrows_slide_speed']; ?>"
						data-pagination-speed="<?php echo $options['circles_slide_speed']; ?>"><?php
				endif; // End if carousel.

				while ( $dslc_query->have_posts() ) :
					$dslc_query->the_post();
					$count += $increment;
					$real_count++;

					if ( $count == $max_count ) {
						$count = 0;
						$extra_class = ' dslc-last-col';
					} elseif ( $count == $increment ) {
						$extra_class = ' dslc-first-col';
					} else {
						$extra_class = '';
					}

					if ( ! has_post_thumbnail() ) {
						$extra_class .= ' dslc-post-no-thumb';
					}

					$post_cats_data = '';
					if ( isset( $taxonomy_name ) ) {
								$post_cats = get_the_terms( get_the_ID(), $taxonomy_name );
						if ( ! empty( $post_cats ) ) {
							foreach ( $post_cats as $post_cat ) {
								$post_cats_data .= $post_cat->slug . ' ';
							}
						}
					} ?>

					<div class="<?php echo $element_class . $columns_class . $extra_class; ?>" data-cats="<?php echo $post_cats_data; ?>">
						<?php if ( $post_elements == 'all' || in_array( 'thumbnail', $post_elements ) ) : ?>
							<?php
							/**
							 * Manual Resize
							 */

							$manual_resize = false;

							if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) || isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {

								$manual_resize = true;
								$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
								$thumb_url = $thumb_url[0];

								$thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
								if ( ! $thumb_alt ) {
									$thumb_alt = '';
								}

								$resize_width = false;
								$resize_height = false;

								if ( isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {
									$resize_width = $options['thumb_resize_width_manual'];
								}

								if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) ) {
									$resize_height = $options['thumb_resize_height'];
								}
							}
							?>
							<?php if ( has_post_thumbnail() ) : ?>

								<div class="dslc-post-thumb dslc-cpt-post-thumb dslc-on-hover-anim">

									<div class="dslc-cpt-post-thumb-inner dslca-post-thumb">
										<?php if ( $manual_resize ) : ?>
											<a href="<?php the_permalink(); ?>"><img src="<?php $res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true );
											echo $res_img; ?>" alt="<?php echo $thumb_alt; ?>" /></a>
										<?php else : ?>
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
										<?php endif; ?>
									</div><!-- .dslc-cpt-post-thumb-inner -->

									<?php if ( ( $options['main_location'] == 'inside' || $options['main_location'] == 'inside_visible' ) && ( $post_elements == 'all' || in_array( 'title', $post_elements ) || in_array( 'meta', $post_elements ) || in_array( 'excerpt', $post_elements ) || in_array( 'button', $post_elements ) ) ) : ?>

										<div class="dslc-post-main dslc-cpt-post-main dslc-init-<?php echo $options['main_position']; ?> <?php if ( $options['main_location'] == 'inside_visible' ) { echo 'dslc-cpt-post-main-visible';} ?> dslc-on-hover-anim-target dslc-anim-<?php echo $options['css_anim_hover']; ?>" data-dslc-anim="<?php echo $options['css_anim_hover'] ?>" data-dslc-anim-speed="<?php echo $options['css_anim_speed']; ?>">

											<div class="dslc-cpt-post-main-inner dslc-init-target">

												<?php if ( $post_elements == 'all' || in_array( 'title', $post_elements ) ) : ?>

													<div class="dslc-cpt-post-title">
														<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													</div><!-- .dslc-cpt-post-title -->

												<?php endif; ?>

												<?php if ( $post_elements == 'all' || in_array( 'meta', $post_elements ) ) : ?>

													<?php
														// Meta Elements
														$meta_elements = $options['meta_elements'];
														$meta_elements = explode( ' ', trim( $meta_elements ) );
													?>

													<div class="dslc-cpt-post-meta">

														<?php if ( in_array( 'author', $meta_elements ) ) : ?>
															<div class="dslc-cpt-post-meta-author">
																<?php _e( 'By', 'live-composer-page-builder' ); ?> <?php the_author_posts_link(); ?>
															</div><!-- .dslc-cpt-post-meta-author -->
														<?php endif; ?>

														<?php if ( in_array( 'date', $meta_elements ) ) : ?>
															<div class="dslc-cpt-post-meta-date">
																<?php the_time( get_option( 'date_format' ) ); ?>
															</div><!-- .dslc-cpt-post-meta-date -->
														<?php endif; ?>

													</div><!-- .dslc-cpt-post-meta -->

												<?php endif; ?>

												<?php if ( $post_elements == 'all' || in_array( 'excerpt', $post_elements ) ) : ?>
													<div class="dslc-cpt-post-read-more">
														<a href="<?php the_permalink(); ?>">
															<?php if ( 'svg' == $options['show_icon'] ) : ?>
																<?php echo stripslashes( $options['button_inline_svg'] ); ?>
															<?php else : ?>
																<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
															<?php endif; ?>
															<?php echo $options['button_text']; ?>
														</a>
													</div><!-- .dslc-cpt-post-read-more -->
													<div class="dslc-cpt-post-excerpt">
														<?php if ( $options['excerpt_or_content'] == 'content' ) : ?>
															<?php
															if ( $options['excerpt_length'] > 0 ) {
																echo wp_trim_words( get_the_content(), $options['excerpt_length'] );
															} else {
																echo get_the_content();
															}
														?>
														<?php else : ?>
															<?php
															if ( $options['excerpt_length'] > 0 ) {
																if ( has_excerpt() ) {
																	echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] );
																} else { echo wp_trim_words( get_the_content(), $options['excerpt_length'] );
																}
															} else {
																if ( has_excerpt() ) {
																	echo get_the_excerpt();
																} else { echo get_the_content();
																}
															}
															?>
														<?php endif; ?>
													</div><!-- .dslc-cpt-post-excerpt -->

												<?php endif; ?>

												<?php if ( $post_elements == 'all' || in_array( 'button', $post_elements ) ) : ?>

													<div class="dslc-cpt-post-read-more">
														<a href="<?php the_permalink(); ?>">
															<?php if ( 'svg' == $options['show_icon'] ) : ?>
																<?php echo stripslashes( $options['button_inline_svg'] ); ?>
															<?php else : ?>
																<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
															<?php endif; ?>
															<?php echo $options['button_text']; ?>
														</a>
													</div><!-- .dslc-cpt-post-read-more -->

												<?php endif; ?>

											</div><!-- .dslc-cpt-post-main-inner -->

											<a href="<?php the_permalink(); ?>" class="dslc-post-main-inner-link-cover"></a>

										</div><!-- .dslc-cpt-post-main -->

									<?php endif; ?>

								</div><!-- .dslc-cpt-post-thumb -->

							<?php endif; ?>
						<?php endif; ?>

						<?php if ( $options['main_location'] == 'bellow' && ( $post_elements == 'all' || in_array( 'title', $post_elements ) || in_array( 'meta', $post_elements ) || in_array( 'excerpt', $post_elements ) || in_array( 'button', $post_elements ) ) ) : ?>

							<div class="dslc-post-main dslc-cpt-post-main">

								<?php if ( $post_elements == 'all' || in_array( 'title', $post_elements ) ) : ?>

									<div class="dslc-cpt-post-title">
										<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									</div><!-- .dslc-cpt-post-title -->

								<?php endif; ?>

								<?php if ( $post_elements == 'all' || in_array( 'meta', $post_elements ) ) : ?>

									<?php
										// Meta Elements
										$meta_elements = $options['meta_elements'];
										$meta_elements = explode( ' ', trim( $meta_elements ) );
									?>

									<div class="dslc-cpt-post-meta">

										<?php if ( in_array( 'author', $meta_elements ) ) : ?>
											<div class="dslc-cpt-post-meta-author">
												<?php _e( 'By', 'live-composer-page-builder' ); ?> <?php the_author_posts_link(); ?>
											</div><!-- .dslc-cpt-post-meta-author -->
										<?php endif; ?>

										<?php if ( in_array( 'date', $meta_elements ) ) : ?>
											<div class="dslc-cpt-post-meta-date">
												<?php the_time( get_option( 'date_format' ) ); ?>
											</div><!-- .dslc-cpt-post-meta-date -->
										<?php endif; ?>

									</div><!-- .dslc-cpt-post-meta -->

								<?php endif; ?>

								<?php if ( $post_elements == 'all' || in_array( 'excerpt', $post_elements ) ) : ?>
									<div class="dslc-cpt-post-excerpt">
										<?php if ( $options['excerpt_or_content'] == 'content' ) : ?>
											<?php
											if ( $options['excerpt_length'] > 0 ) {
												echo wp_trim_words( get_the_content(), $options['excerpt_length'] );
											} else {
												echo get_the_content();
											}
											?>
											<div class="dslc-cpt-post-read-more">
												<a href="<?php the_permalink(); ?>">
													<?php if ( 'svg' == $options['show_icon'] ) : ?>
														<?php echo stripslashes( $options['button_inline_svg'] ); ?>
													<?php else : ?>
														<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
													<?php endif; ?>
													<?php echo $options['button_text']; ?>
												</a>
											</div><!-- .dslc-cpt-post-read-more -->
										<?php else : ?>
											<?php
											if ( $options['excerpt_length'] > 0 ) {
												if ( has_excerpt() ) {
													echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] );
												} else { echo wp_trim_words( get_the_content(), $options['excerpt_length'] );
												}
											} else {
												if ( has_excerpt() ) {
													echo get_the_excerpt();
												} else { echo get_the_content();
												}
											}
											?>
										<?php endif; ?>
									</div><!-- .dslc-cpt-post-excerpt -->

								<?php endif; ?>

								<?php if ( $post_elements == 'all' || in_array( 'button', $post_elements ) ) : ?>

									<div class="dslc-cpt-post-read-more">
										<a href="<?php the_permalink(); ?>">
											<?php if ( 'svg' == $options['show_icon'] ) : ?>
												<?php echo stripslashes( $options['button_inline_svg'] ); ?>
											<?php else : ?>
												<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
											<?php endif; ?>
											<?php echo $options['button_text']; ?>
										</a>
									</div><!-- .dslc-cpt-post-read-more -->

								<?php endif; ?>

							</div><!-- .dslc-cpt-post-main -->

						<?php endif; ?>

					</div><!-- .dslc-cpt-post --><?php

					// Row Separator
					if ( $options['type'] == 'grid' && $count == 0 && $real_count != $dslc_query->found_posts && $real_count != $options['amount'] && $options['separator_enabled'] == 'enabled' ) {
						echo '<div class="dslc-post-separator"></div>';
					}

				endwhile; // End while have_posts.

				if ( $options['type'] == 'carousel' ) : ?>
					</div><!-- dslc-carousel --><?php
				endif; ?>
			</div><!--.dslc-posts-inner -->
			
			<?php if ( $show_carousel_arrows && ( $options['arrows_position'] == 'aside' ) ) : ?>
				<a href="#" class="dslc-carousel-nav-next position-aside"><span class="dslc-icon-chevron-right"></span></a>
			<?php endif; ?>	
			
		</div><!-- .dslc-cpt-posts --><?php
	} else {
		if ( $dslc_is_admin ) : ?>
			<div class="dslc-notification dslc-red"><?php _e( 'You do not have any posts of that post type at the moment.', 'live-composer-page-builder' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
		endif;
	} // End if().

	/**
	 * Pagination
	 */

	if ( isset( $options['pagination_type'] ) && $options['pagination_type'] != 'disabled' ) {
		$num_pages = $dslc_query->max_num_pages;
		if ( $options['offset'] > 0 ) {
			$num_pages = ceil( ( $dslc_query->found_posts - $options['offset'] ) / $options['amount'] );
		}
		dslc_post_pagination( array(
			'pages' => $num_pages,
			'type' => $options['pagination_type'],
		) );
	}

		wp_reset_postdata();

	$shortcode_rendered = ob_get_contents();
	ob_end_clean();

	return $shortcode_rendered;

} add_shortcode( 'dslc_module_posts_output', 'dslc_module_posts_output' );
