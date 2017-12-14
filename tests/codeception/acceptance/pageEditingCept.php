<?php

/**
 * Test page editing workflow in Live Composer.
 *
 * @since 1.3.10
 */

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Check page creation and editing.' );

$I->loginAsAdmin();
$I->waitForElement('#footer-thankyou', 10);

// Publish new page.
$I->amOnPage('/wp-admin/post-new.php?post_type=page');
$I->waitForElement('[name="post_title"]', 30); // secs
$I->fillField(['name' => 'post_title'], 'Codeception Automatic Testing');
$I->see( 'Publish' ); $I->click( 'Publish' );

// Check default interface elements on the LC editing screen.
$I->click( 'View page' );
$I->click( 'Edit in Live Composer' );
$I->see( 'Elements');
$I->see( 'Info Box');
$I->see( 'Publish Changes');
$I->see( 'Close');

# switch to editing frame.
$I->switchToIframe( 'page-builder-frame' );
$I->see( 'Add Modules Row');

// Test BUTTON module import:
// Click import row button.
$I->click( '.dslca-import-modules-section-hook' );

# switch to parent iframe (we have code modal in the parent).
$I->switchToIFrame();
$lc_element_button = '[{"element_type":"row","columns_spacing":"spacing","custom_class":"","show_on":"desktop tablet phone","section_instance_id":"e44f6713d7a","custom_id":"","type":"wrapper","bg_color":"","bg_image_thumb":"disabled","bg_image":"","bg_image_repeat":"repeat","bg_image_position":"left top","bg_image_attachment":"scroll","bg_image_size":"auto","bg_video":"","bg_video_overlay_color":"#000000","bg_video_overlay_opacity":"0","border_color":"","border_width":"0","border_style":"solid","border":"top right bottom left","margin_h":"0","margin_b":"0","padding":"80","padding_h":"0","content":[{"element_type":"module_area","last":"yes","first":"no","size":"12","content":[{"css_show_on":"desktop tablet phone","button_text":"TEST BUTTON","button_url":"#","button_target":"_self","css_align":"left","css_bg_color":"#5890e5","css_bg_color_hover":"#4b7bc2","css_border_color":"#000","css_border_trbl":"top right bottom left","css_border_radius":"3","css_padding_vertical":"12","css_padding_horizontal":"12","css_width":"inline-block","css_button_color":"#ffffff","css_button_color_hover":"#ffffff","css_button_font_size":"11","css_button_font_style":"normal","css_button_font_weight":"800","css_button_font_family":"Lato","button_state":"enabled","icon_pos":"left","button_icon_id":"link","css_icon_margin":"5","css_wrapper_bg_img_repeat":"repeat","css_wrapper_bg_img_attch":"scroll","css_wrapper_bg_img_pos":"top left","css_wrapper_border_trbl":"top right bottom left","css_res_t":"disabled","css_res_t_padding_vertical":"12","css_res_t_padding_horizontal":"12","css_res_t_button_font_size":"11","css_res_t_icon_margin":"5","css_res_t_align":"left","css_res_p":"disabled","css_res_p_padding_vertical":"12","css_res_p_padding_horizontal":"12","css_res_p_button_font_size":"11","css_res_p_icon_margin":"5","css_res_ph_align":"left","css_anim":"none","css_anim_duration":"650","css_anim_easing":"ease","css_load_preset":"none","module_instance_id":"b2396c744a5","post_id":"23","dslc_m_size":"12","module_id":"DSLC_Button","element_type":"module","last":"yes"}]}]}]';
$I->fillField( '.dslca-prompt-modal-active .dslca-prompt-modal-descr textarea', $lc_element_button );
$I->click('.dslca-prompt-modal-active .dslca-prompt-modal-confirm-hook');

# switch to editing frame.
$I->switchToIframe( 'page-builder-frame' );
$I->waitForElement('.dslc-module-DSLC_Button', 10); // LC code import takes some time.
$I->see( 'TEST BUTTON');

# switch to parent iframe.
$I->switchToIFrame();
$I->click('Publish Changes');
$I->waitForElementNotVisible('.dslca-save-composer', 10); // secs
$I->click('.dslca-close-composer-hook'); // DISABLE EDITOR
// Click 'Confirm'
$I->click('.dslca-prompt-modal-active .dslca-prompt-modal-confirm-hook');

// Check button rendered on Front-End
$I->waitForElement('.dslc-module-DSLC_Button', 10); // LC code import takes some time.
$I->see( 'TEST BUTTON');


// if ($scenario->running()) {
    // Logger::log('test');
// }

// $this->loginAs($this->config['adminUsername'], $this->config['adminPassword']);
// codecept_debug($I);
// codecept_debug($scenario);


// EOF
