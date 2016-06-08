<?php
/**
 * Staff module class
 */

if ( dslc_is_module_active( 'DSLC_Staff' ) )
	include DS_LIVE_COMPOSER_ABS . '/modules/staff/functions.php';

/**
 * Class DSLC_Staff
 */
class DSLC_Staff extends DSLC_Module {

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
		$this->module_title = __( 'Staff', 'live-composer-page-builder' );
		$this->module_icon = 'user';
		$this->module_category = 'posts';

		parent::__construct( $settings, $atts );
	}

	/**
	 * @inherited
	 */
	function options() {

		$cats = get_terms( 'dslc_staff_cats' );
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
						'label' => __( 'Link to staff member page', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT link to staff member page', 'live-composer-page-builder' ),
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
				'label' => __( 'Posts Per Page', 'live-composer-page-builder' ),
				'id' => 'amount',
				'std' => '4',
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
				'label' => __( 'Items Per Row', 'live-composer-page-builder' ),
				'id' => 'posts_per_row',
				'std' => '3',
				'type' => 'select',
				'choices' => $this->shared_options('posts_per_row_choices'),
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
			array(
				'label' => __( 'Social - Link Behaviour', 'live-composer-page-builder' ),
				'id' => 'social_link_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Open in same tab', 'live-composer-page-builder' ),
						'value' => '_self'
					),
					array(
						'label' => __( 'Open in new tab', 'live-composer-page-builder' ),
						'value' => '_blank'
					)
				),
				'section' => 'functionality',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
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
				'std' => 'thumbnail social title position excerpt',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Thumbnail', 'live-composer-page-builder' ),
						'value' => 'thumbnail',
					),
					array(
						'label' => __( 'Social Links', 'live-composer-page-builder' ),
						'value' => 'social',
					),
					array(
						'label' => __( 'Title', 'live-composer-page-builder' ),
						'value' => 'title',
					),
					array(
						'label' => __( 'Position', 'live-composer-page-builder' ),
						'value' => 'position',
					),
					array(
						'label' => __( 'Excerpt', 'live-composer-page-builder' ),
						'value' => 'excerpt',
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
				'affect_on_change_el' => '.dslc-staff',
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
				'affect_on_change_el' => '.dslc-staff',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner, .dslc-staff-member-thumb img',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner, .dslc-staff-member-thumb img',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
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

			/**
			 * Social
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_social_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_social_bg_color',
				'std' => '#4f87db',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_social_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_social_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_social_border_trbl',
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
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_social_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_social_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_social_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_social_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_social_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon - Color', 'live-composer-page-builder' ),
				'id' => 'css_social_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon - Size', 'live-composer-page-builder' ),
				'id' => 'css_social_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Social', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'affect_on_change_el' => '.dslc-staff-member-main',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_bottom',
				'std' => '4',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'std' => '31',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_horizontal',
				'std' => '36',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'affect_on_change_el' => '.dslc-staff-member-main',
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
				'affect_on_change_el' => '.dslc-staff-member-main-inner',
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
				'affect_on_change_el' => '.dslc-staff-member-main-inner',
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
				'std' => '#3d3d3d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
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
				'affect_on_change_el' => '.dslc-staff-member-title h2:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_title_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_title_font_weight',
				'std' => '900',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
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
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_title_line_height',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_bottom',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title',
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
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			/**
			 * Position
			 */

			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_position_border_color',
				'std' => '#e5e5e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_position_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'border-top-width,border-bottom-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_position_border_trbl',
				'std' => 'top bottom',
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
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_position_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_position_font_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_position_font_weight',
				'std' => '200',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_position_font_family',
				'std' => 'Bitter',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Style', 'live-composer-page-builder' ),
				'id' => 'css_position_font_style',
				'std' => 'italic',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'live-composer-page-builder' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'live-composer-page-builder' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_position_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_position_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Position', 'live-composer-page-builder' ),
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
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
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
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
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
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
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
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'affect_on_change_el' => '.dslc-staff',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_social_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_social_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_social_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social Icon - Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_social_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_vertical',
				'std' => '31',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'std' => '36',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_line_height',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_margin_bottom',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Position - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_position_font_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Position - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_position_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Position - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_position_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
				'affect_on_change_rule' => 'line-height',
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
				'affect_on_change_el' => '.dslc-staff',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
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
				'affect_on_change_el' => '.dslc-staff-member-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_social_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_social_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_social_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Social Icon - Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_social_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-social a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_vertical',
				'std' => '31',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_horizontal',
				'std' => '36',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_line_height',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_margin_bottom',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Position - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_position_font_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Position - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_position_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Position - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_position_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-position',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-staff-member-excerpt',
				'affect_on_change_rule' => 'line-height',
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

				wp_enqueue_script( 'js-staff-editor-extender', DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/editor-script.js', array( 'jquery' ) );
			}

			wp_enqueue_script( 'js-staff-extender', DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/script.js', array( 'jquery' ) );
		});
	}

	/**
	 * Returns filter HTML string
	 * @return string
	 */
	function staff_filter() {

		global $LC_Registry;

		$dslc_query = $this->get_staff();
		$LC_Registry->set( 'dslc-staff-query', $dslc_query );

		$taxonomy_name = '';

		$cats_array = array();

		$cats_count = 0;

		if ( $dslc_query->have_posts() ) {

			while ( $dslc_query->have_posts() ) {

				$dslc_query->the_post();

				$cats_count++;

				$post_cats = get_the_terms( get_the_ID(), 'dslc_staff_cats' );

				if ( ! empty( $post_cats ) ) {

					foreach( $post_cats as $post_cat ) {

						$cats_array[$post_cat->slug] = $post_cat->name;
					}
				}
			}
		}

		ob_start();

		foreach ( $cats_array as $cat_slug => $cat_name ) {?>
			<span class="dslc-post-filter dslc-staff-module dslc-inactive" data-id="<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></span>
		<?php }

		return ob_get_clean();
	}

	/**
	 * Return categories data to each post. Template function.
	 * @return string
	 */
	function staff_categories() {

		$staff_cats_data = '';
		$staff_cats = get_the_terms( get_the_ID(), 'dslc_staff_cats' );

		if ( ! empty( $staff_cats ) ) {

			foreach( $staff_cats as $staff_cat ) {

				$staff_cats_data .= 'in-cat-' . $staff_cat->slug . ' ';
			}
		}

		return $staff_cats_data . ' in-cat-all';
	}

	/**
	 * Staff fetcher.
	 * @return WP_Query
	 */
	function get_staff() {

		$options = $this->getPropsValues();

		if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

		if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

		// Fix for pagination from other modules affecting this one when pag disabled
		if ( $options['pagination_type'] == 'disabled' ) $paged = 1;

		// Fix for offset braking pagination
		$query_offset = $options['offset'];
		if ( $query_offset > 0 && $paged > 1 ) $query_offset = ( $paged - 1 ) * $options['amount'] + $options['offset'];

		$args = array(
			'paged' => $paged,
			'post_type' => 'dslc_staff',
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
					'taxonomy' => 'dslc_staff_cats',
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

		// No paging
		if ( $options['pagination_type'] == 'disabled' )
			$args['no_found_rows'] = true;

		// Do the query
		if ( is_category() || is_tax() || is_search() ) {
			global $wp_query;
			$dslc_query = $wp_query;
		} else {
			$dslc_query = new WP_Query( $args );
		}

		return $dslc_query;
	}


	/**
	 * Staff render. Template function.
	 *
	 * @param  array $atts
	 * @param  array $content
	 *
	 * @return string
	 */
	function render_staff( $atts, $content ) {

		global $LC_Registry;

		$out = '';
		$dslc_query = $LC_Registry->get( 'dslc-staff-query' );

		if ( $dslc_query == null ) {

			$dslc_query = $this->get_staff();
			$LC_Registry->set( 'dslc-staff-query', $dslc_query );
		}

		if ( $dslc_query->have_posts() ) {

			$LC_Registry->set( 'curr_class', $this );

			$options = $this->getPropsValues();
			$cnt = 0;

			while ( $dslc_query->have_posts() ) {

				$dslc_query->the_post();
				$LC_Registry->set( 'dslc-staff-elem-index', $cnt );

				$staff_member_info = [];
				$staff_member_info['twitter'] = get_post_meta( get_the_ID(), 'dslc_staff_social_twitter', true );
				$staff_member_info['facebook'] = get_post_meta( get_the_ID(), 'dslc_staff_social_facebook', true );
				$staff_member_info['googleplus'] = get_post_meta( get_the_ID(), 'dslc_staff_social_googleplus', true );
				$staff_member_info['linkedin'] = get_post_meta( get_the_ID(), 'dslc_staff_social_linkedin', true );
				$staff_member_info['email'] = get_post_meta( get_the_ID(), 'dslc_staff_social_email', true );
				$staff_member_info['position'] = get_post_meta( get_the_ID(), 'dslc_staff_position', true );

				$LC_Registry->set( 'dslc-staff-member-info', $staff_member_info );

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
			}

			unset( $cnt );

			$LC_Registry->set( 'dslc-staff-elem-index', null );
			$LC_Registry->set( 'curr_class', null );
			$LC_Registry->set( 'dslc-staff-member-social', null );
		}

		return $out;
	}


	/**
	 * Return current member position. Template function
	 * @return string
	 */
	function position() {

		global $LC_Registry;
		$staff_member_info = $LC_Registry->get( 'dslc-staff-member-info' );

		return $staff_member_info['position'];
	}

	/**
	 * Returns staff social info.
	 * @return string
	 */
	function member_social() {

		global $LC_Registry;
		ob_start();

		$options = $this->getPropsValues();
		$member_social = $LC_Registry->get( 'dslc-staff-member-info' );

		if ( isset( $member_social['twitter'] ) || isset( $member_social['facebook'] ) || isset( $member_social['googleplus'] ) || isset( $member_social['linkedin'] ) || isset( $member_social['email'] ) ){?>

			<div class="dslc-staff-member-social">

				<?php if ( isset( $member_social['twitter'] ) ) : ?>
					<a target="<?php echo $options['social_link_target']; ?>" href="<?php echo $member_social['twitter']; ?>">
						<span class="dslc-icon dslc-icon-twitter"></span>
					</a>
				<?php endif; ?>

				<?php if ( isset( $member_social['facebook'] ) ) : ?>
					<a target="<?php echo $options['social_link_target']; ?>" href="<?php echo $member_social['facebook']; ?>">
						<span class="dslc-icon dslc-icon-facebook"></span>
					</a>
				<?php endif; ?>

				<?php if ( isset( $member_social['googleplus'] ) ) : ?>
					<a target="<?php echo $options['social_link_target']; ?>" href="<?php echo $member_social['googleplus']; ?>">
						<span class="dslc-icon dslc-icon-google-plus"></span>
					</a>
				<?php endif; ?>

				<?php if ( isset( $member_social['linkedin'] ) ) : ?>
					<a target="<?php echo $options['social_link_target']; ?>" href="<?php echo $member_social['linkedin']; ?>">
						<span class="dslc-icon dslc-icon-linkedin"></span>
					</a>
				<?php endif; ?>

				<?php if ( isset( $member_social['email'] ) ) : ?>
					<a target="<?php echo $options['social_link_target']; ?>" href="<?php echo $member_social['email']; ?>">
						<span class="dslc-icon dslc-icon-envelope"></span>
					</a>
				<?php endif; ?>

			</div><!-- .dslc-staff-member-social -->
		<?php };

		return ob_get_clean();
	}

	/**
	 * Returns last col class
	 * @return string
	 */
	function extra_col_class() {

		global $LC_Registry;

		$opts = $this->getPropsValues();
		$index = $LC_Registry->get( 'dslc-staff-elem-index' );
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
	 * Returns author's post link. Repeater function.
	 * @return string
	 */
	function author_posts_link() {

		ob_start();
		echo get_the_author_posts_link();

		return ob_get_clean();
	}

	/**
	 * Returns post date. Repeater function.
	 * @return  string
	 */
	function post_date() {

		ob_start();
		the_time( get_option( 'date_format' ) );

		return ob_get_clean();
	}

	/**
	 * Returns post title.Repeater function.
	 * @return string
	 */
	function post_title() {

		ob_start();
		the_title();

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

		if ( $options['link'] != 'disabled' ) {
		?>
				<a href="<?php the_permalink() ?>">
		<?php }

			 if ( $manual_resize ) {?>
				<img src="<?php $res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true ); echo $res_img; ?>" alt="<?php echo $thumb_alt; ?>" />
			<?php } else { ?>
				<?php the_post_thumbnail( 'full' ); ?>
			<?php }

		if ( $options['link'] != 'disabled' ) {
		?>
			</a>
		<?php }

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
		$dslc_query = $LC_Registry->get( 'dslc-staff-query' );

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
( new DSLC_Staff )->register();