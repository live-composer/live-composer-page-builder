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

	static function vertical_padding( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Vertical padding', 'live-composer-page-builder' ),
				'id' => 'css_padding_vert_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function horizontal_padding( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Horizontal padding', 'live-composer-page-builder' ),
				'id' => 'css_padding_hor_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'padding-left,padding-right',
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

			return array(
				array(
					'label' => __( $args['label'] . 'Padding', 'live-composer-page-builder' ),
					'id' => 'css_padding_' . $args['id'],
					'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $args['selector'],
					'affect_on_change_rule' => 'padding',
					'section' => 'styling',
					'ext' => $ext,
					'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
				)
			);
		}

		$pad_args = array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'id' => $args['id'],
        	'label' => $args['label']
		);

		if( count( $parts ) == 2 ) {

			$parts = array(
				self::vertical_padding( array_merge( $pad_args, array( 'value' => $parts[0] ) ) ),
		        self::horizontal_padding( array_merge( $pad_args, array( 'value' => $parts[1] ) ) )
		    );

		    return array( $parts[0][0], $parts[1][0] );
		}

		if( count( $parts ) == 3 ) {

			$parts = array(
				self::padding_top( array_merge( $pad_args, array( 'value' => $parts[0] ) ) ),
			    self::horizontal_padding( array_merge( $pad_args, array( 'value' => $parts[1] ) ) ),
				self::padding_bottom( array_merge( $pad_args, array( 'value' => $parts[2] ) ) )
			);

			return array( $parts[0][0],	$parts[1][0], $parts[2][0] );
		}

		if( count( $parts ) == 4 ) {

			$parts = array(
				self::padding_top( array_merge( $pad_args, array( 'value' => $parts[0] ) ) ),
			    self::padding_right( array_merge( $pad_args, array( 'value' => $parts[1] ) ) ),
				self::padding_bottom( array_merge( $pad_args, array( 'value' => $parts[2] ) ) ),
		        self::padding_left( array_merge( $pad_args, array( 'value' => $parts[3] ) ) )
			);

			return array( $parts[0][0], $parts[1][0], $parts[2][0], $parts[3][0] );
		}
	}

	static function vertical_margin( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Vertical margin', 'live-composer-page-builder' ),
				'id' => 'css_margin_vert_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'margin-top,margin-bottom',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function horizontal_margin( $args ) {

		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		return array(
			array(
				'label' => __( $args['label'] . 'Horizontal margin', 'live-composer-page-builder' ),
				'id' => 'css_margin_hor_' . $args['id'],
				'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'styling',
				'ext' => $ext,
				'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
			)
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

		if( count( $parts ) == 1 ) {

			return array(
				array(
					'label' => __( $args['label'] . 'Margin', 'live-composer-page-builder' ),
					'id' => 'css_margin_' . $args['id'],
					'std' => isset ( $args['value'] ) ? intval( $args['value'] ) : 0,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $args['selector'],
					'affect_on_change_rule' => 'margin',
					'section' => 'styling',
					'ext' => $ext,
					'tab' =>  __( $args['tab'], 'live-composer-page-builder' )
				)
			);
		}

		$mrg_args = array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'id' => $args['id'],
        	'label' => $args['label']
		);

		if( count( $parts ) == 2 ) {

			$parts = array(
				self::vertical_margin( array_merge( $mrg_args, array( 'value' => $parts[0] ) ) ),
		        self::horizontal_margin( array_merge( $mrg_args, array( 'value' => $parts[1] ) ) )
		    );

		    return array( $parts[0][0],	$parts[1][0] );
		}

		if( count( $parts ) == 3 ) {

			$parts = array(
				self::margin_top( array_merge( $mrg_args, array( 'value' => $parts[0] ) ) ),
			    self::horizontal_margin( array_merge( $mrg_args, array( 'value' => $parts[1] ) ) ),
				self::margin_bottom( array_merge( $mrg_args, array( 'value' => $parts[2] ) ) )
			);

			return array( $parts[0][0], $parts[1][0], $parts[2][0] );
		}

		if( count( $parts ) == 4 ) {

			$parts = array(
				self::margin_top( array_merge( $mrg_args, array( 'value' => $parts[0] ) ) ),
			    self::margin_right( array_merge( $mrg_args, array( 'value' => $parts[1] ) ) ),
				self::margin_bottom( array_merge( $mrg_args, array( 'value' => $parts[2] ) ) ),
		        self::margin_left( array_merge( $mrg_args, array( 'value' => $parts[3] ) ) )
			);

			return array( $parts[0][0], $parts[1][0], $parts[2][0],	$parts[3][0] );
		}
	}

	static function border_style( $args ) {

		return array(
			array(
				'label' => __( $args['label'] . 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_filter_border_' . $args['id'],
				'std' => $args['value'],
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

	static function border( $args ) {

		$values = explode( " ", trim( $args['value'] ) );
		$ext = strpos( @$args['value'], "%" ) > -1 ? "%" : 'px';

		if( trim( $values[1] ) != 'solid' ) {

			$style = explode( ".", trim( $values[1] ) );
			$style_out = '';

			for($i = 0; $i < 4; $i++) {

				if( $style[$i] != 'none' ){

					switch ($i) {
						case 0: $style_out .= 'top'; break;
						case 1: $style_out .= ' right'; break;
						case 2: $style_out .= ' bottom'; break;
						case 3: $style_out .= ' left'; break;
					}
				}
			}
		} else {

			$style_out = 'top right bottom left';
		}



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
				'std' => $style_out,
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
				'tab' => __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function background_attachment( $args ) {

		return array(

	         array(
				'label' => __( $args['label'] . 'Bg image attachment', 'live-composer-page-builder' ),
				'id' => 'css_bg_img_attch' . $args['id'],
				'std' => $args['value'],
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'live-composer-page-builder' ),
						'value' => 'scroll',
					),
					array(
						'label' => __( 'Fixed', 'live-composer-page-builder' ),
						'value' => 'fixed',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
				'tab' => __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}

	static function background_repeat( $args ) {

		return array(

	        array(
				'label' => __( $args['label'] . 'BG image repeat', 'live-composer-page-builder' ),
				'id' => 'css_bg_img_repeat' . $args['id'],
				'std' => $args['value'],
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'live-composer-page-builder' ),
						'value' => 'repeat',
					),
					array(
						'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
						'value' => 'repeat-x',
					),
					array(
						'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
						'value' => 'repeat-y',
					),
					array(
						'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
						'value' => 'no-repeat',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
				'tab' => __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function background_color( $args ) {

		return array(

			array(
				'label' => __( $args['label'] . 'BG color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color' . $args['id'],
				'std' => $args['value'],
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}


	static function background_position( $args ) {

		return array(

			array(
				'label' => __( $args['label'] .'BG image position', 'live-composer-page-builder' ),
				'id' => 'css_bg_img_pos' . $args['id'],
				'std' => $args['value'],
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'left top',
					),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'right top',
					),
					array(
						'label' => __( 'Top Center', 'live-composer-page-builder' ),
						'value' => 'Center Top',
					),
					array(
						'label' => __( 'Center Left', 'live-composer-page-builder' ),
						'value' => 'left center',
					),
					array(
						'label' => __( 'Center Right', 'live-composer-page-builder' ),
						'value' => 'right center',
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center center',
					),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'left bottom',
					),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'right bottom',
					),
					array(
						'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
						'value' => 'center bottom',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
				'tab' => __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}


	static function background_image( $args ) {

		return array(
			array(
				'label' => __( $args['label'] . 'BG Image', 'live-composer-page-builder' ),
				'id' => 'css_bg_img' . $args['id'],
				'std' => $args['value'],
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
				'tab' => __( $args['tab'], 'live-composer-page-builder' )
			),
		);
	}

	/*static function background_size( $args ) {

		if ( explode( trim ( $args['value'] ), " " ) > 0 ) {

			$value = explode( " ", trim ( $args['value'] ) );

			return array(
				array(
					'label' => __( $args['label'] . 'BG Size Vertical', 'live-composer-page-builder' ),
					'id' => 'css_bg_size_y' . $args['id'],
					'std' => $value[1],
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $args['selector'],
					'affect_on_change_rule' => 'background-size-y',
					'section' => 'styling',
					'tab' => __( $args['tab'], 'live-composer-page-builder' )
				),
				array(
					'label' => __( $args['label'] . 'BG Size Horizontal', 'live-composer-page-builder' ),
					'id' => 'css_bg_size_x' . $args['id'],
					'std' => $value[0],
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $args['selector'],
					'affect_on_change_rule' => 'background-siz-x',
					'section' => 'styling',
					'tab' => __( $args['tab'], 'live-composer-page-builder' )
				)
			);
		}

		return array(
			array(
				'label' => __( $args['label'] . 'BG Image', 'live-composer-page-builder' ),
				'id' => 'css_bg_size' . $args['id'],
				'std' => $args['value'],
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => $args['selector'],
				'affect_on_change_rule' => 'background-size',
				'section' => 'styling',
				'tab' => __( $args['tab'], 'live-composer-page-builder' )
			)
		);
	}*/

	static function background( $args ) {

		$out = array();
		$mrg_args = array(
			'selector' => $args['selector'],
        	'tab' => $args['tab'],
        	'rule' => $args['rule'],
        	'id' => $args['id'],
        	'label' => $args['label']
		);

		/// Background color
		preg_match( '/\s?#[\S]{6}|#[\S]{3}\s?/', $args['value'], $matches );

		if( count( $matches ) > 0 ) {

			$array = self::background_color(
		   	   	array_merge(
   	   	            $mrg_args,
   	   	            array( 'value' => trim( $matches[0] ) )
   	   	        )
	   	   	);

			$out[] = array_shift( $array );
		}

		/// Background image
		preg_match( '/\s?url\((.*)\)\s?/', $args['value'], $matches );

		if( count( $matches ) > 0 ) {

			$array = self::background_image(
		   	   	array_merge(
	   	            $mrg_args,
	   	            array( 'value' => $matches[1] )
	   	        )
   	        );

			$out[] = array_shift( $array );
		}

		/// Background attachment
		preg_match( '/\s?fixed|scroll\s?/', $args['value'], $matches );

		if( count( $matches ) > 0 ) {

			$array = self::background_attachment(
		   	   	array_merge(
   	   	            $mrg_args,
   	   	            array( 'value' => $matches[0] )
   	   	        )
   	   	    );

			$out[] = array_shift( $array );
		}


		/// Background position
		preg_match_all( '/\s?(left|right|center|top|bottom)\s?/i', $args['value'], $matches );

		if( count( $matches ) > 0 ) {

			$array = self::background_position(
		   	   	array_merge(
   	   	            $mrg_args,
   	   	            array( 'value' => implode( ' ', $matches[1] ) )
   	   	        )
   	   	    );

			$out[] = array_shift( $array );
		}

		/// Background repeat
		preg_match( '/\s?(no-repeat|repeat|repeat-x|repeat-y)\s?/i', $args['value'], $matches );

		if( count( $matches ) > 0 ) {

			$array = self::background_repeat(
		   	   	array_merge(
   	   	            $mrg_args,
   	   	            array( 'value' => $matches[1] )
   	   	        )
   	   	    );

			$out[] = array_shift( $array );
		}

		return $out;
	}


}