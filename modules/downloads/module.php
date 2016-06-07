<?php
/**
 * Downloads module class
 */

if ( dslc_is_module_active( 'DSLC_Downloads' ) )
	include DS_LIVE_COMPOSER_ABS . '/modules/downloads/functions.php';

/**
 * Class DSLC_Downloads
 */
class DSLC_Downloads extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	/**
	 * @inherited
	 */
	function __construct( $settings = [], $atts = [] ) {

		$this->module_ver = 2;
		$this->module_id = __CLASS__;
		$this->module_title = __( 'Downloads', 'live-composer-page-builder' );
		$this->module_icon = 'download';
		$this->module_category = 'posts';

		parent::__construct( $settings, $atts );
	}

	/**
	 * @inherited
	 */
	function options() {

		$cats = get_terms( 'dslc_downloads_cats' );
		$cats_choices = array();

		foreach ( $cats as $cat ) {
			if(!is_array($cat)){
				$cats_choices[] = array(
					'label' => $cat->name,
					'value' => $cat->slug
				);
			}
		}

		$dslc_options = array(

			array(
				'label' => __( 'Show On', 'live-composer-page-builder' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'live-composer-page-builder' ),
						'value' => 'desktop'
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet'
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone'
					),
				),
			),
			array(
				'label' => __( 'Link', 'live-composer-page-builder' ),
				'id' => 'link',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Link to download item page', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT link to download item page', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				)
			),
			array(
				'label' => __( 'Type', 'live-composer-page-builder' ),
				'id' => 'type',
				'std' => 'grid',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Grid', 'live-composer-page-builder' ),
						'value' => 'grid'
					),
					array(
						'label' => __( 'Masonry Grid', 'live-composer-page-builder' ),
						'value' => 'masonry'
					),
					array(
						'label' => __( 'Carousel', 'live-composer-page-builder' ),
						'value' => 'carousel'
					)
				)
			),
			array(
				'label' => __( 'Orientation', 'live-composer-page-builder' ),
				'id' => 'orientation',
				'std' => 'vertical',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Vertical', 'live-composer-page-builder' ),
						'value' => 'vertical'
					),
					array(
						'label' => __( 'Horizontal', 'live-composer-page-builder' ),
						'value' => 'horizontal'
					)
				)
			),
			array(
				'label' => __( 'Posts Per Page', 'live-composer-page-builder' ),
				'id' => 'amount',
				'std' => '8',
				'type' => 'text',
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
			),
			array(
				'label' => __( 'Categories', 'live-composer-page-builder' ),
				'id' => 'categories',
				'std' => '',
				'type' => 'checkbox',
				'choices' => $cats_choices
			),
			array(
				'label' => __( 'Categories Operator', 'live-composer-page-builder' ),
				'id' => 'categories_operator',
				'std' => 'IN',
				'help' => __( '<strong>IN</strong> - Posts must be in at least one chosen category.<br><strong>AND</strong> - Posts must be in all chosen categories.<br><strong>NOT IN</strong> Posts must not be in the chosen categories.', 'live-composer-page-builder' ),
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'IN', 'live-composer-page-builder' ),
						'value' => 'IN',
					),
					array(
						'label' => __( 'AND', 'live-composer-page-builder' ),
						'value' => 'AND',
					),
					array(
						'label' => __( 'NOT IN', 'live-composer-page-builder' ),
						'value' => 'NOT IN',
					),
				)
			),
			array(
				'label' => __( 'Items Per Row', 'live-composer-page-builder' ),
				'id' => 'posts_per_row',
				'std' => '3',
				'type' => 'select',
				'choices' => $this->shared_options('posts_per_row_choices'),
			),
			array(
				'label' => __( 'Order By', 'live-composer-page-builder' ),
				'id' => 'orderby',
				'std' => 'date',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Publish Date', 'live-composer-page-builder' ),
						'value' => 'date'
					),
					array(
						'label' => __( 'Modified Date', 'live-composer-page-builder' ),
						'value' => 'modified'
					),
					array(
						'label' => __( 'Random', 'live-composer-page-builder' ),
						'value' => 'rand'
					),
					array(
						'label' => __( 'Alphabetic', 'live-composer-page-builder' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Comment Count', 'live-composer-page-builder' ),
						'value' => 'comment_count'
					),
				)
			),
			array(
				'label' => __( 'Order', 'live-composer-page-builder' ),
				'id' => 'order',
				'std' => 'DESC',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Ascending', 'live-composer-page-builder' ),
						'value' => 'ASC'
					),
					array(
						'label' => __( 'Descending', 'live-composer-page-builder' ),
						'value' => 'DESC'
					)
				)
			),
			array(
				'label' => __( 'Offset', 'live-composer-page-builder' ),
				'id' => 'offset',
				'std' => '0',
				'type' => 'text',
			),
			array(
				'label' => __( 'Include (IDs)', 'live-composer-page-builder' ),
				'id' => 'query_post_in',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Exclude (IDs)', 'live-composer-page-builder' ),
				'id' => 'query_post_not_in',
				'std' => '',
				'type' => 'text',
			),

			// Query Altering
			array(
				'label' => __( 'On Author Archive', 'live-composer-page-builder' ),
				'id' => 'query_alter_author',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Show Posts Of That Author', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT Alter Query', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'tab' => __( 'Query Alter', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'On Category/Tag Archive', 'live-composer-page-builder' ),
				'id' => 'query_alter_cat',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Show Posts Of That Category/Tag', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT Alter Query', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'tab' => __( 'Query Alter', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'On Search Results Page', 'live-composer-page-builder' ),
				'id' => 'query_alter_search',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Show Posts Matching Search Term', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT Alter Query', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'tab' => __( 'Query Alter', 'live-composer-page-builder' ),
			),

			/**
			 * General
			 */

			array(
				'label' => __( 'Elements', 'live-composer-page-builder' ),
				'id' => 'elements',
				'std' => '',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Heading', 'live-composer-page-builder' ),
						'value' => 'main_heading'
					),
					array(
						'label' => __( 'Filters', 'live-composer-page-builder' ),
						'value' => 'filters'
					),
				),
				'section' => 'styling'
			),

			array(
				'label' => __( 'Post Elements', 'live-composer-page-builder' ),
				'id' => 'post_elements',
				'std' => 'thumbnail title tags excerpt button count',
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
						'label' => __( 'Tags', 'live-composer-page-builder' ),
						'value' => 'tags',
					),
					array(
						'label' => __( 'Excerpt', 'live-composer-page-builder' ),
						'value' => 'excerpt',
					),
					array(
						'label' => __( 'Download Button', 'live-composer-page-builder' ),
						'value' => 'button',
					),
					array(
						'label' => __( 'Download Count', 'live-composer-page-builder' ),
						'value' => 'count',
					),
				),
				'section' => 'styling'
			),

			array(
				'label' => __( 'Carousel Elements', 'live-composer-page-builder' ),
				'id' => 'carousel_elements',
				'std' => 'arrows circles',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Arrows', 'live-composer-page-builder' ),
						'value' => 'arrows'
					),
					array(
						'label' => __( 'Circles', 'live-composer-page-builder' ),
						'value' => 'circles'
					),
				),
				'section' => 'styling'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-downloads',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-downloads',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
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
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled'
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
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 0,
				'max' => 300,
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thickness', 'live-composer-page-builder' ),
				'id' => 'css_sep_thickness',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-bottom-width',
				'ext' => 'px',
				'min' => 0,
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
						'value' => 'none'
					),
					array(
						'label' => __( 'Solid', 'live-composer-page-builder' ),
						'value' => 'solid'
					),
					array(
						'label' => __( 'Dashed', 'live-composer-page-builder' ),
						'value' => 'dashed'
					),
					array(
						'label' => __( 'Dotted', 'live-composer-page-builder' ),
						'value' => 'dotted'
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
				'affect_on_change_el' => '.dslc-download-thumb',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb',
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
				'affect_on_change_el' => '.dslc-download-thumb-inner',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
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
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_border_radius_top',
				'std' => '4',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner, .dslc-download-thumb img',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner, .dslc-download-thumb img',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
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
				'tab' => __( 'thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'thumbnail', 'live-composer-page-builder' ),
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'thumb_width',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'min' => 1,
				'max' => 100,
				'ext' => '%'
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
						'value' => 'bellow'
					),
					array(
						'label' => __( 'Inside Thumbnail ( hover )', 'live-composer-page-builder' ),
						'value' => 'inside'
					),
					array(
						'label' => __( 'Inside Thumbnail ( always visible )', 'live-composer-page-builder' ),
						'value' => 'inside_visible'
					),
				),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_main_border_color',
				'std' => '#e0e0e0',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_main_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
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
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_bottom',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_main_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'min' => 0,
				'max' => 500
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_vertical',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_horizontal',
				'std' => '34',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_main_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'text-align',
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
						'value' => 'topleft'
					),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'topright'
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center'
					),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'bottomleft'
					),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'bottomright'
					),
				)
			),
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_main_inner_margin',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main-inner',
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
				'affect_on_change_el' => '.dslc-download-main-inner',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'ext' => '%',
				'tab' => __( 'Main Inner', 'live-composer-page-builder' ),
			),

			/**
			 * Title
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_title_color',
				'std' => '#3d3d3d;',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_title_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2:hover,.dslc-download-title h2 a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_title_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_title_font_weight',
				'std' => '600',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_title_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_title_line_height',
				'std' => '26',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_title_margin',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_title_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'live-composer-page-builder' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Capitalize', 'live-composer-page-builder' ),
						'value' => 'capitalize'
					),
					array(
						'label' => __( 'Uppercase', 'live-composer-page-builder' ),
						'value' => 'uppercase'
					),
					array(
						'label' => __( 'Lowercase', 'live-composer-page-builder' ),
						'value' => 'lowercase'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			/**
			 * Tags
			 */

			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_tags_border_color',
				'std' => '#e5e5e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_tags_text_color',
				'std' => '#9e9e9e',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_tags_font_family',
				'std' => 'Droid Serif',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_tags_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_tags_font_weight',
				'std' => '500',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_tags_padding_vertical',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Link - Color', 'live-composer-page-builder' ),
				'id' => 'css_tags_link_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Link - Hover - Color', 'live-composer-page-builder' ),
				'id' => 'css_tags_link_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Link - Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_tags_link_font_weight',
				'std' => '600',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Tags', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
						'value' => 'excerpt'
					),
					array(
						'label' => __( 'Content', 'live-composer-page-builder' ),
						'value' => 'content'
					),
				),
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_color',
				'std' => '#9e9e9e',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_margin_bottom',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Max Length ( amount of words )', 'live-composer-page-builder' ),
				'id' => 'excerpt_length',
				'std' => '16',
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
				'std' => 'DOWNLOAD',
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
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_bg_color_hover',
				'std' => '#4678c2',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_button_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
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
				'affect_on_change_el' => '.dslc-download-download a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_button_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_button_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_button_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_button_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_button_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_button_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_button_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_button_margin_bottom',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_vertical',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Icon', 'live-composer-page-builder' ),
				'id' => 'button_icon_id',
				'std' => 'download-alt',
				'type' => 'icon',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon - Color', 'live-composer-page-builder' ),
				'id' => 'css_button_icon_color',
				'std' => '#9fbeeb',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_button_icon_margin',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),

			/**
			 * Count
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_count_color',
				'std' => '#9e9e9e',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-info',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Count', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_count_font_size',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-info',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Count', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_count_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-info',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Count', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_count_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-info',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Count', 'live-composer-page-builder' ),
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
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-downloads',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Separator - Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_sep_height',
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumbnail_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumbnail_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumbnail_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_vertical',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'std' => '34',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_line_height',
				'std' => '26',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_margin',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Tags - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_tags_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Tags - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_tags_padding_vertical',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_margin_bottom',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_margin_bottom',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_padding_vertical',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_icon_margin',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Count - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_count_font_size',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-info',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
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
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-downloads',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Separator - Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_sep_height',
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumbnail_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumbnail_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumbnail_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_vertical',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_horizontal',
				'std' => '34',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_line_height',
				'std' => '26',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title h2,.dslc-download-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_margin',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Tags - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_tags_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Tags - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_tags_padding_vertical',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-tags',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_margin_bottom',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_margin_bottom',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_padding_vertical',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_icon_margin',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-download a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Count - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_count_font_size',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-download-info',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options('carousel_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('heading_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('filters_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('carousel_arrows_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('carousel_circles_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('pagination_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('animation_options') );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	/**
	 * @inherited
	 */
	function afterRegister() {

		add_action( 'wp_enqueue_scripts', function(){

			global $LC_Registry;

			$path = explode( '/', __DIR__ );
			$path = array_pop( $path );

			if ( $LC_Registry->get( 'dslc_active' ) == true ) {

				wp_enqueue_script( 'js-downloads-editor-extender', DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/editor-script.js', array( 'jquery' ) );
			}

			wp_enqueue_script( 'js-downloads-extender', DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/script.js', array( 'jquery' ) );
		});
	}

	/**
	 * Returns filter HTML string
	 * @return string
	 */
	function downloads_filter() {

		global $LC_Registry;

		$dslc_query = $this->get_downloads();
		$LC_Registry->set( 'dslc-downloads-query', $dslc_query );

		$taxonomy_name = '';

		$cats_array = array();

		$cats_count = 0;

		if ( $dslc_query->have_posts() ) {

			while ( $dslc_query->have_posts() ) {

				$dslc_query->the_post();
				$post_cats = get_the_terms( get_the_ID(), 'dslc_downloads_cats' );

				if ( ! empty( $post_cats ) ) {

					foreach( $post_cats as $post_cat ) {

						$cats_array[$post_cat->slug] = $post_cat->name;
					}
				}
			}
		}

		ob_start();

		foreach ( $cats_array as $cat_slug => $cat_name ) {?>
			<span class="dslc-post-filter dslc-downloads-module dslc-inactive" data-id="<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></span>
		<?php }

		return ob_get_clean();
	}

	/**
	 * Return categories data to each post. Template function.
	 * @return string
	 */
	function downloads_categories() {

		$downloads_cats_data = '';
		$downloads_cats = get_the_terms( get_the_ID(), 'dslc_downloads_cats' );

		if ( ! empty( $downloads_cats ) ) {

			foreach( $downloads_cats as $downloads_cat ) {

				$downloads_cats_data .= 'in-cat-' . $downloads_cat->slug . ' ';
			}
		}

		return $downloads_cats_data . ' in-cat-all';
	}

	/**
	 * Posts fetcher.
	 * @return WP_Query
	 */
	function get_downloads() {

		global $dslc_active;

		$options = $this->getPropsValues();

		// Fix slashes on apostrophes
		if ( isset( $options['button_text'] ) ) {
			$options['button_text'] = stripslashes( $options['button_text'] );
		}

		/* CUSTOM START */

		if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

			if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

			// Fix for pagination from other modules affecting this one when pag disabled
			if ( $options['pagination_type'] == 'disabled' ) $paged = 1;

			// Fix for offset braking pagination
			$query_offset = $options['offset'];
			if ( $query_offset > 0 && $paged > 1 ) $query_offset = ( $paged - 1 ) * $options['amount'] + $options['offset'];

			$args = array(
				'paged' => $paged,
				'post_type' => 'dslc_downloads',
				'posts_per_page' => $options['amount'],
				'order' => $options['order'],
				'orderby' => $options['orderby'],
			);

			// Add offset
			if ( $query_offset > 0 ) {
				$args['offset'] = $query_offset;
			}

			if ( defined('DOING_AJAX') && DOING_AJAX ) {
				$args['post_status'] = array( 'publish', 'private' );
			}

			if ( isset( $options['categories'] ) && $options['categories'] != '' ) {

				$cats_array = explode( ' ', trim( $options['categories'] ));

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'dslc_downloads_cats',
						'field' => 'slug',
						'terms' => $cats_array,
						'operator' => $options['categories_operator']
					)
				);

			}

			// Exlcude and Include arrays
			$exclude = array();
			$include = array();

			// Exclude current post
			if ( is_singular( get_post_type() ) )
				$exclude[] = get_the_ID();

			// Exclude posts ( option )
			if ( $options['query_post_not_in'] )
				$exclude = array_merge( $exclude, explode( ' ', $options['query_post_not_in'] ) );

			// Include posts ( option )
			if ( $options['query_post_in'] )
				$include = array_merge( $include, explode( ' ', $options['query_post_in'] ) );

			// Include query parameter
			if ( ! empty( $include ) )
				$args['post__in'] = $include;

			// Exclude query parameter
			if ( ! empty( $exclude ) )
				$args['post__not_in'] = $exclude;

			// Author archive page
			if ( is_author() && $options['query_alter_author'] == 'enabled' ) {
				global $authordata;
				$args['author__in'] = array( $authordata->data->ID );
			}

			// Do the query
			if ( ( is_category() || is_tag() || is_tax() ) && $options['query_alter_cat'] == 'enabled' ) {
				global $wp_query;
				$dslc_query = $wp_query;
			} elseif ( is_search() && $options['query_alter_search'] == 'enabled' ) {
				global $wp_query;
				$dslc_query = $wp_query;
			} else {
				$dslc_query = new WP_Query( $args );
			}

		return $dslc_query;
	}

	/**
	 * Posts render. Template function.
	 *
	 * @param  array $atts
	 * @param  array $content
	 *
	 * @return string
	 */
	function render_downloads( $atts, $content ) {

		global $LC_Registry;

		$out = '';
		$dslc_query = $LC_Registry->get( 'dslc-downloads-query' );

		if ( $dslc_query == null ) {

			$dslc_query = $this->get_downloads();
			$LC_Registry->set( 'dslc-downloads-query', $dslc_query );
		}

		if ( $dslc_query->have_posts() ) {

			$LC_Registry->set( 'curr_class', $this );

			$options = $this->getPropsValues();
			$cnt = 0;

			while ( $dslc_query->have_posts() ) {

				$dslc_query->the_post();
				$LC_Registry->set( 'dslc-downloads-elem-index', $cnt );

				$link_to_single = true;
				if ( $options['link'] == 'disabled' ) {

					$link_to_single = false;
				}

				$LC_Registry->set( 'dslc-download-link-to-single', $link_to_single );

				$out .= DSLC_Main::dslc_do_shortcode( $content );

				if ( 	$options['type'] == 'grid' &&
				 		$cnt > 0 &&
				 		($cnt + 1) % $options['posts_per_row'] == 0 &&
				 		$options['separator_enabled'] != 'disabled' &&
				 		($cnt + 1) < $dslc_query->found_posts &&
				 		($cnt + 1) < $dslc_query->query_vars['posts_per_page']
				 	) {

					$out .= '<div class="dslc-post-separator"></div>';
				}

				$cnt++;
				$LC_Registry->set( 'dslc-download-link-to-single', null );
			}

			unset( $cnt );

			$LC_Registry->set( 'dslc-downloads-elem-index', null );
			$LC_Registry->set( 'curr_class', null );
		}

		return $out;
	}

	function download_tags() {

		ob_start();
		$download_tags_count = 0;
		$download_tags = get_the_terms( get_the_ID(), 'dslc_downloads_tags' );

		if ( ! empty( $download_tags ) ) : ?>

				<div class="dslc-download-tags">
					In
					<?php foreach ( $download_tags as $download_tag ) : $download_tags_count++; ?>
						<?php if ( $download_tags_count > 1 ) { echo ', '; } ?>
						<a href="<?php echo get_term_link( $download_tag->slug, 'dslc_downloads_tags' ); ?>"><?php echo $download_tag->name; ?></a>
					<?php endforeach; ?>
				</div><!-- .dslc-download-tags -->

		<?php endif;

		return ob_get_clean();
	}

	/**
	 * Return download button HTML.
	 * @return string
	 */
	function download_button() {

		ob_start();
		$options = $this->getPropsValues();
		if ( get_post_meta( get_the_ID(), 'dslc_download_file', true ) ) {

			$download_link = wp_get_attachment_url( get_post_meta( get_the_ID(), 'dslc_download_file', true ) );
		} elseif ( get_post_meta( get_the_ID(), 'dslc_download_url', true ) ) {

			$download_link = get_post_meta( get_the_ID(), 'dslc_download_url', true );
		} else {

			$download_link = false;
		}


		?>
		<a target="_blank" class="dslc-download-count-hook" data-post-id="<?php echo get_the_ID(); ?>" href="<?php echo $download_link; ?>">
			<?php if ( isset( $options['button_icon_id'] ) && $options['button_icon_id'] != '' ) : ?>
				<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>
			<?php endif; ?>
			<?php echo $options['button_text']; ?>
		</a>
		<?php

		return ob_get_clean();
	}

	/**
	 * Returns download info
	 * @return string
	 */
	function download_info() {

		$download_count = get_post_meta( get_the_ID(), 'dslc_download_count', true );

		if ( ! $download_count ) {

			$download_count = 0;
		}

		ob_start();
		printf( __( 'Downloaded %d times.', 'live-composer-page-builder' ), $download_count );
		return ob_get_clean();
	}

	/**
	 * Returns last col class
	 * @return string
	 */
	function extra_col_class() {

		global $LC_Registry;

		$opts = $this->getPropsValues();
		$index = $LC_Registry->get( 'dslc-downloads-elem-index' );
		$extra_class = '';

		if ( $opts['type'] == 'grid' && $index > 0 && ($index + 1) % $opts['posts_per_row'] == 0 && $opts['separator_enabled'] != 'disabled' ) {

			$extra_class = 'dslc-last-col ';
		}

		if ( ! has_post_thumbnail() ) {

			$extra_class .= 'dslc-post-no-thumb';
		}

		return $extra_class;
	}

	/**
	 * Returns permalink. Repeater function.
	 * @return  string
	 */
	function permalink() {

		global $post;

		return get_post_permalink( $post->ID );
	}

	/**
	 * Returns excerpt or content. Repeater function.
	 * @return string
	 */
	function excerpt() {

		$options = $this->getPropsValues();

		ob_start();
		if ( $options['excerpt_or_content'] == 'content' ) {

			the_content();
		} else {

			if ( $options['excerpt_length'] > 0 ) {
				if ( has_excerpt() )
					echo do_shortcode( wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ) );
				else
					echo do_shortcode( wp_trim_words( get_the_content(), $options['excerpt_length'] ) );
			} else {
				if ( has_excerpt() )
					echo do_shortcode( get_the_excerpt() );
				else
					echo do_shortcode( get_the_content() );
			}
		}

		return ob_get_clean();
	}

	/**
	 * Returns post title.Repeater function.
	 * @return string
	 */
	function post_title() {

		global $LC_Registry;
		$link_to_single = $LC_Registry->get( 'dslc-download-link-to-single' );

		ob_start();
		?>
		<?php if ( $link_to_single ) : ?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php else : ?>
			<h2><?php the_title(); ?></h2>
		<?php endif; ?>
		<?php

		return ob_get_clean();
	}

	/**
	 * Returns post thumbnail. Repeater function.
	 * @return  string
	 */
	function post_thumb() {

		if ( ! has_post_thumbnail() ) return '';

		$manual_resize = false;
		$options = $this->getPropsValues();

		if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) || isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {

			$manual_resize = true;
			$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$thumb_url = $thumb_url[0];

			$thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
			if ( ! $thumb_alt ) $thumb_alt = '';

			$resize_width = false;
			$resize_height = false;

			if ( isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {
				$resize_width = $options['thumb_resize_width_manual'];
			}

			if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) ) {
				$resize_height = $options['thumb_resize_height'];
			}
		}

		ob_start();
		?>
		<div class="dslc-cpt-post-thumb-inner dslca-post-thumb">
			<a href="<?php the_permalink() ?>">
				<?php if ( $manual_resize ) {?>
					<img src="<?php $res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true ); echo $res_img; ?>" alt="<?php echo $thumb_alt; ?>" />
				<?php } else { ?>
					<?php the_post_thumbnail( 'full' ); ?>
				<?php } ?>
			</a>
		</div><!-- .dslc-cpt-post-thumb-inner -->
		<?php

		return ob_get_clean();
	}

	/**
	 * Returns navigation HTML. Template shortcode function
	 * @param  array $atts
	 * @return string
	 */
	function pagination_nav( $atts ) {

		global $LC_Registry;

		$options = $this->getPropsValues();
		$dslc_query = $LC_Registry->get( 'dslc-downloads-query' );

		ob_start();

		if ( isset( $options['pagination_type'] ) && $options['pagination_type'] != 'disabled' ) {

			$num_pages = $dslc_query->max_num_pages;

			if ( $options['offset'] > 0 ) {
				$num_pages = ceil ( ( $dslc_query->found_posts - $options['offset '] ) / $options['amount'] );
			}

			dslc_post_pagination( array( 'pages' => $num_pages, 'type' => $options['pagination_type'] ) );
		}

		return ob_get_clean();
	}

	/**
	 * @inherited
	 */
	function output( $options = [] ) {

		$this->module_start();

		/* Module output stars here */
		echo $this->renderModule();
		/* Module output ends here */

		$this->module_end();
	}

}

/// Register module
( new DSLC_Downloads )->register();