<?php
/**
 * Test Template in Live Composer.
 *
 * @since 1.0.0
 */


$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Load Page Design.' );
$I->loginAsAdmin();
$I->waitForElement('#footer-thankyou');

// Publish new template.
$I->amOnPage( '/wp-admin/post-new.php?post_type=dslc_templates' );
$I->waitForElement( '[name="post_title"]', 30 );
$I->fillField( [ 'name' => 'post_title' ], 'Codeception Automatic Testing ( Template )' );
$I->click( '#dslc_template_for1' );
$I->click( 'span#enternew' );
$I->fillField( 'input#metakeyinput', 'dslc_code' );
$dslc_code = '[{"type":"wrapped","columns_spacing":"spacing","border_color":"","border_width":"0","border_style":"","border":"","bg_color":"","bg_image_thumb":"disabled","bg_image":"","bg_video":"","bg_video_overlay_color":"","bg_video_overlay_opacity":"","bg_image_repeat":"repeat","bg_image_attachment":"scroll","bg_image_position":"left top","bg_image_size":"auto","padding":"61","padding_h":"0","margin_h":"0","margin_b":"0","custom_class":"","custom_id":"","element_type":"row","show_on":"desktop tablet phone","section_instance_id":"9524cb2bad1","dslca-img-url":"","content":[{"element_type":"module_area","last":"yes","first":"no","size":"12","content":[{"css_show_on":"desktop tablet phone","css_border_width":"0","css_border_trbl":"top right bottom left","css_border_radius_top":"0","css_border_radius_bottom":"0","css_margin_bottom":"0","css_min_height":"0","css_padding_vertical":"0","css_padding_horizontal":"0","css_font_size":"25","css_font_weight":"400","css_font_family":"Open Sans","css_line_height":"40","css_text_align":"left","css_text_transform":"none","css_res_t":"disabled","css_res_t_margin_bottom":"0","css_res_t_padding_vertical":"0","css_res_t_padding_horizontal":"0","css_res_t_font_size":"25","css_res_t_line_height":"40","css_res_p":"disabled","css_res_p_margin_bottom":"0","css_res_p_padding_vertical":"0","css_res_p_padding_horizontal":"0","css_res_p_font_size":"25","css_res_p_line_height":"40","css_anim":"none","css_anim_delay":"0","css_anim_duration":"650","css_anim_easing":"ease","css_load_preset":"none","module_instance_id":"bccfde242b9","post_id":"1488","dslc_m_size":"12","module_id":"DSLC_TP_Title","element_type":"module","last":"yes"}]}]}]';
$I->fillField( 'textarea#metavalue', $dslc_code );
$I->see( 'Publish' );
$I->click( 'Publish' );

// Publish new post.
$I->amOnPage( '/wp-admin/post-new.php' );
$I->waitForElement( '[name="post_title"]', 30 );
$I->fillField( [ 'name' => 'post_title' ], 'Codeception Automatic Testing ( Template )' );
$I->see( 'Publish' );
$I->click( 'Publish' );
$I->click( 'View post' );
$I->see( 'Codeception Automatic Testing ( Template )' );

