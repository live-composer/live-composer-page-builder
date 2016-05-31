<?php
/**
 * Panel options
 */

/**
 * DSLC_Panel_Style_Opts class
 */
class DSLC_Panel_Style_Opts {

	static function get_option( $args ) {

		if ( ! is_array( $args ) ) return array();

		$method_name = preg_replace( '/[\W]/', "_", strtolower($args['rule'] ) );

		if ( method_exists( __CLASS__, $method_name ) ) {

			return self::$method_name( $args );
		} else {

			return array();
		}
	}

	static function width( $args ) {

		$ext = strpos( $args['value'], "%" ) > -1 ? "%" : 'px';

		return array(

			array(
				'label' => __(  $args['label'] . 'Width', 'live-composer-page-builder' ),
				'id' => 'css_width_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}

	static function max_width( $args ) {

		$ext = strpos( $args['value'], "%" ) > -1 ? "%" : 'px';

		return array(

			array(
				'label' => __(  $args['label'] . 'Max width', 'live-composer-page-builder' ),
				'id' => 'css_max_width_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}

	static function line_height( $args ) {

		$ext = strpos( $args['value'], "%" ) > -1 ? "%" : 'px';

		return array(

			array(
				'label' => __(  $args['label'] . 'Line height', 'live-composer-page-builder' ),
				'id' => 'css_line_height_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function max_height( $args ) {

		$ext = strpos( $args['value'], "%" ) > -1 ? "%" : 'px';

		return array(

			array(
				'label' => __(  $args['label'] . 'Max height', 'live-composer-page-builder' ),
				'id' => 'css_max_height_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function height( $args ) {

		$ext = strpos( $args['value'], "%" ) > -1 ? "%" : 'px';

		return array(

			array(
				'label' => __( $args['label'] . 'Height', 'live-composer-page-builder' ),
				'id' => 'css_height_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}

	static function color( $args ) {

		return array(

			array(
				'label' => __( $args['label'] . 'Color', 'live-composer-page-builder' ),
				'id' => 'css_color_' . $args['id'],
				'std' => $args['value'],
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function text_align( $args ) {

		return array(

			array(
				'label' => __( $args['label'] . 'Text align', 'live-composer-page-builder' ),
				'id' => 'css_text_align_' . $args['id'],
				'std' => $args['value'],
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}

	static function font_family( $args ) {

		return array(

			array(
				'label' => __( $args['label'] . 'Font family', 'live-composer-page-builder' ),
				'id' => 'css_font_' . $args['id'],
				'std' => $args['value'],
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function letter_spacing( $args ) {

		return array(

			array(
				'label' => __( $args['label'] . 'Letter spacing', 'live-composer-page-builder' ),
				'id' => 'css_letter_s_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' ),
				'min' => 0,
				'max' => 50,
				'ext' => 'px'
			),
		);
	}

	static function font_weight( $args ) {

		switch ($args['value']) {
			case 'bold': $args['value'] = 800; break;
			case 'normal': $args['value'] = 400; break;
		}

		return array(

			array(
				'label' => __( $args['label'] . 'Font weight', 'live-composer-page-builder' ),
				'id' => 'css_font_weight_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function font_size( $args ) {

		$ext = strpos( $args['value'], "em" ) > -1 ? "em" : 'px';

		return array(

			array(
				'label' => __( $args['label'] . 'Font size', 'live-composer-page-builder' ),
				'id' => 'css_font_size_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function text_transform( $args ) {

		$ext = strpos( $args['value'], "em" ) > -1 ? "em" : 'px';

		return array(

			array(
				'label' => __( $args['label'] . 'Text transform', 'live-composer-page-builder' ),
				'id' => 'css_text_transform_' . $args['id'],
				'std' => $args['value'],
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Uppercase',
						'value' => 'uppercase'
					),
					array(
						'label' => 'Capitalize',
						'value' => 'capitalize'
					),
					array(
						'label' => 'Lowercase',
						'value' => 'lowercase'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function border_radius( $args ) {

		return array(

			array(
				'label' => __( $args['label'] . 'Border radius', 'live-composer-page-builder' ),
				'id' => 'css_border_radius_' . $args['id'],
				'std' => intval( $args['value'] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => $args['rule'],
				'section' => 'styling',
				'ext' => 'px',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function padding_top( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Padding top', 'live-composer-page-builder' ),
				'id' => 'css_padding_top_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function padding_right( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Padding right', 'live-composer-page-builder' ),
				'id' => 'css_padding_right_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function padding_bottom( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Padding bottom', 'live-composer-page-builder' ),
				'id' => 'css_padding_bottom_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function padding_left( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Padding left', 'live-composer-page-builder' ),
				'id' => 'css_padding_left_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function padding( $args ) {

		$parts = explode( " ", trim( $args['value'] ) );

		if( count( $parts ) == 1 ) {

			$parts = array(
				$parts[0],
				$parts[0],
				$parts[0],
				$parts[0]
			);
		}

		if( count( $parts ) == 2 ) {

			$parts = array(
				$parts[0],
				$parts[1],
				$parts[0],
				$parts[1]
			);
		}

		if( count( $parts ) == 3 ) {

			$parts = array(
				$parts[0],
				$parts[1],
				$parts[2],
				$parts[1]
			);
		}

		if( count( $parts ) == 4 ) {

			$parts = array(
				$parts[0],
				$parts[1],
				$parts[2],
				$parts[3]
			);
		}

		$parts[0] = self::padding_top( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => $parts[0],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		$parts[1] = self::padding_right( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => @$parts[1],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		$parts[2] = self::padding_bottom( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => @$parts[2],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		$parts[3] = self::padding_left( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => @$parts[3],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		return array(

			$parts[0][0],
			$parts[1][0],
			$parts[2][0],
			$parts[3][0]
		);
	}


	static function margin_top( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Margin top', 'live-composer-page-builder' ),
				'id' => 'css_marging_top_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function margin_right( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Margin right', 'live-composer-page-builder' ),
				'id' => 'css_margin_right_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function margin_bottom( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Margin bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function margin_left( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Margin left', 'live-composer-page-builder' ),
				'id' => 'css_margin_left_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function margin( $args ) {

		$parts = explode( " ", trim( $args['value'] ) );

		$parts[0] = self::margin_top( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => $parts[0],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		$parts[1] = self::margin_right( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => @$parts[1],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		$parts[2] = self::margin_bottom( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => @$parts[2],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		$parts[3] = self::margin_left( array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'value' => @$parts[3],
        	'id' => $args['id'],
        	'label' => $args['label']
        ));

		return array(

			$parts[0][0],
			$parts[1][0],
			$parts[2][0],
			$parts[3][0]
		);
	}

	static function border( $args ) {

		$values = explode( " ", trim( $args['value'] ) );
		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
            array(
				'label' => __( $args['label'] . 'Border color', 'live-composer-page-builder' ),
				'id' => 'css_border_color_' . $args['id'],
				'std' => isset ( $values[2] ) ? $values[2] : '#000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
			array(
				'label' => __( $args['label'] . 'Border width', 'live-composer-page-builder' ),
				'id' => 'css_border_width_' . $args['id'],
				'std' => intval( $values[0] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
			array(
				'label' => __( $args['label'] . 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_filter_border' . $args['id'],
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => 'Top',
						'value' => 'top'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					),
					array(
						'label' => 'Bottom',
						'value' => 'bottom'
					),
					array(
						'label' => 'Left',
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function border_top( $args ) {

		$values = explode( " " , trim( $args['value'] ) );
		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
            array(
				'label' => __( $args['label'] . 'Border color', 'live-composer-page-builder' ),
				'id' => 'css_border_color_' . $args['id'],
				'std' => isset ( $values[2] ) ? $values[2] : '#000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-top-color',
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
			array(
				'label' => __( $args['label'] . 'Border width', 'live-composer-page-builder' ),
				'id' => 'css_border_width_' . $args['id'],
				'std' => intval( $values[0] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-top-width',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function border_right( $args ) {

		$values = explode( " ", trim( $args['value'] ) );
		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
            array(
				'label' => __( $args['label'] . 'Border color', 'live-composer-page-builder' ),
				'id' => 'css_border_color_' . $args['id'],
				'std' => isset ( $values[2] ) ? $values[2] : '#000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-right-color',
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
			array(
				'label' => __( $args['label'] . 'Border width', 'live-composer-page-builder' ),
				'id' => 'css_border_width_' . $args['id'],
				'std' => intval( $values[0] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-right-width',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function border_bottom( $args ) {

		$values = explode( " ", trim( $args['value'] ) );
		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
            array(
				'label' => __( $args['label'] . 'Border color', 'live-composer-page-builder' ),
				'id' => 'css_border_color_' . $args['id'],
				'std' => isset ( $values[2] ) ? $values[2] : '#000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-bottom-color',
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
			array(
				'label' => __( $args['label'] . 'Border width', 'live-composer-page-builder' ),
				'id' => 'css_border_width_' . $args['id'],
				'std' => intval( $values[0] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-bottom-width',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function border_left( $args ) {

		$values = explode( " ", trim( $args['value'] ) );
		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
            array(
				'label' => __( $args['label'] . 'Border color', 'live-composer-page-builder' ),
				'id' => 'css_border_color_' . $args['id'],
				'std' => isset ( $values[2] ) ? $values[2] : '#000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-left-color',
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			),
			array(
				'label' => __( $args['label'] . 'Border width', 'live-composer-page-builder' ),
				'id' => 'css_border_width_' . $args['id'],
				'std' => intval( $values[0] ),
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'border-left-width',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function box_shadow( $args ) {

		return array(
			array(
				'label' => __( $args['label'] . 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_box_shadow' . $args['id'],
				'std' => $args['value'],
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function text_shadow( $args ) {

		return array(
			array(
				'label' => __( $args['label'] . 'Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_text_shadow_' . $args['id'],
				'std' => $args['value'],
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( $args['tab'], 'live-composer-page-builder' ),
			)
		);
	}
}