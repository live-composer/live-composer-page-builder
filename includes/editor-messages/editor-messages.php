<?php

/**
 * Display the editor messages
 *
 * @since 1.0
 */
function dslc_print_editor_messages() {

	if ( false === get_option( 'dslc_editor_messages_flag' ) ) {

		$messages = array(
			'message_1' => 'Our <a href="https://livecomposerplugin.com/downloads/woocommerce-page-builder/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=woo-integration" target="_blank">WooCommerce integration add-on</a> is almost ready for realese. Price growths with every update. <a href="https://livecomposerplugin.com/downloads/woocommerce-page-builder/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=woo-integration" target="_blank">Buy it today to save 30%!</a>',
			'message_2' => 'Our <a href="https://livecomposerplugin.com/downloads/google-maps-add-on/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=woo-integration" target="_blank">Google Maps integration add-on</a>',
			'message_3' => 'Our <a href="https://livecomposerplugin.com/downloads/additional-animations/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=woo-integration" target="_blank">Additional Animations</a>',
			'message_4' => 'Our <a href="https://livecomposerplugin.com/downloads/bundle-buy-all-extensions/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=woo-integration" target="_blank">Official Extensions Pack</a>',
		);

		add_option( 'dslc_editor_messages', $messages );
		add_option( 'dslc_editor_messages_flag', '1' );
	}

?>

 	<div class="dslca_editor_messages_section">
		<a href="#" class="dslca_editor_messages_title"><span>Live Composer</span> Updates</a>
		<a href="#" class="dslca_editor_messages_hide"><span class="dslc-icon dslc-icon-remove"></span>Hide this Line</a>
		<ul id="editor_messages">
			<?php
				$array_messages = get_option( 'dslc_editor_messages' );
			?>
			<?php foreach ( $array_messages as $message ) { ?>
				<li>
					<span class="dslc-icon dslc-icon-align-left"></span><?php echo $message; ?>
				</li>
			<?php } ?>
		</ul>
	</div>

<?php }
