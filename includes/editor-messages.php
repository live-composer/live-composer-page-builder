<?php
/**
 * Editor Messages
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Main Editor_Messages Class.
 */
class LC_Editor_Messages {

	/**
	 * Messages
	 *
	 * @var array
	 */
	public $messages = array();

	/**
	 * Premium user
	 *
	 * @var bool
	 */
	public $premium_user = false;

	/**
	 * Construct
	 */
	public function __construct() {

		$this->messages = $this->get_messages();

		if ( empty( $this->messages ) ) {
			$this->on_plugin_install();
			$this->messages = $this->get_messages();
		}

		if ( $this->is_premium_user() ) {
			$this->premium_user = true;
		}
	}

	/**
	 * Get all messages
	 */
	public function get_messages() {
		return get_option( 'dslc_editormessages', false );
	}

	/**
	 * Add messages
	 *
	 * @param array $messages Messages.
	 */
	public function add_messages( $messages ) {

		if ( ! $this->messages ) {
			add_option( 'dslc_editormessages', $messages );
		} else {

			$get_messages = $this->get_messages();

			foreach ( $messages as $key => $message ) {

				if ( ! array_key_exists( $key, $get_messages ) ) {
					$get_messages[ $key ] = $message;
				}
			}

			update_option( 'dslc_editormessages', $get_messages );
		}
	}

	/**
	 * Delete messages
	 *
	 * @param array $keys Keys.
	 */
	public function delete_messages( $keys ) {

		$get_messages = $this->get_messages();

		foreach ( $keys as $key ) {

			if ( array_key_exists( $key, $get_messages ) ) {
				unset( $get_messages[ $key ] );
			}
		}

		update_option( 'dslc_editormessages', $get_messages );
	}

	/**
	 * Plugin install
	 */
	public function on_plugin_install() {
		$default_messages = array(
			'woo-integration' => array(
				'text' => 'Our WooCommerce integration add-on is almost ready for realese. Price growths with every update. <strong>Buy it today to save 30%!</strong>',
				'link' => 'https://livecomposerplugin.com/downloads/woocommerce-page-builder/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=woo-integration',
				'icon' => 'dslc-icon-shopping-cart',
				'color' => '',
			),
			'all-extensions' => array(
				'text' => 'Extend the page builder with our official extensions bundle. Save $10 with <strong>10USDOFF</strong> coupon.',
				'link' => 'https://livecomposerplugin.com/downloads/bundle-buy-all-extensions/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=all-extensions',
				'icon' => 'dslc-icon-cubes',
				'color' => '',
			),
			'779590' => array(
				'text' => 'Live Composer developers recommend WP Engine for their best-in-class architecture to keep WordPress fast and secure.',
				'link' => 'http://www.shareasale.com/r.cfm?B=779590&U=871461&M=41388&urllink=',
				'icon' => 'dslc-icon-codepen ',
				'color' => '',
			),
			'965751' => array(
				'text' => 'Do you need high-quality website content fast? Get $20 free joining bonus at Contentmart.com USE CODE: <strong>JOIN20</strong>',
				'link' => 'http://www.shareasale.com/r.cfm?B=965751&U=871461&M=65777&urllink=',
				'icon' => 'dslc-icon-pencil',
				'color' => '',
			),
			'381388' => array(
				'text' => 'LinkFool! We build natural links, each month, to help our customers grow their SEO rankings without fear of being banned by the search engines.',
				'link' => 'http://www.shareasale.com/r.cfm?B=381388&U=871461&M=35654&urllink=',
				'icon' => 'dslc-icon-link',
				'color' => '',
			),
		);

		$this->add_messages( $default_messages );
	}

	/**
	 * Our addon active
	 */
	public function is_addon_active() {

		if ( function_exists( 'lc_gallery_grid_module_init' ) ||
			function_exists( 'lcgooglemaps_plugin_init' ) ||
			function_exists( 'sklc_linecons_alter_icons' ) ||
			function_exists( 'sklc_addon_anim_filter' ) ||
			function_exists( 'lc_video_embed_module_init' ) ||
			function_exists( 'sklc_addon_prnep_register_module' ) ||
			function_exists( 'sklc_ppcw_options' ) ||
			function_exists( 'lcwoo_plugin_init' ) ||
			class_exists( 'LC_Before_After_Image' ) ||
			class_exists( 'LC_Extensions_Core' )
		) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Premium User
	 */
	public function is_premium_user() {

		if ( true == get_option( 'dslc_premium_user' ) ) {
			return true;
		} else {
			if ( true == $this->is_addon_active() ) {
				update_option( 'dslc_premium_user', true );
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Get hidden ( panel )
	 */
	public function get_hidden() {
		return get_option( 'dslc_editor_messages_hidden', false );
	}

	/**
	 * Display the editor messages
	 */
	public function print_messages() {
	?>
	    <div class="dslc-editor-messages-section">
	    	<a href="#" class="dslc-editor-messages-title"><?php echo __( 'Live Composer Updates', 'live-composer-page-builder' ); ?></a>
	    	<a href="#" data-can-hide="<?php echo $this->premium_user; ?>" class="dslc-editor-messages-hide"><span class="dslc-icon dslc-icon-remove"></span><?php echo __( 'Hide this', 'live-composer-page-builder' ); ?></a>
	    	<ul id="editor-messages">
	    		<?php foreach ( $this->messages as $key => $message ) { ?>
					<li>
						<span class="dslc-icon <?php echo $message['icon']; ?>"></span><?php echo $message['text']; ?><a href="<?php echo $message['link']; ?>" target="_blank"></a>
					</li>
				<?php } ?>
	    	</ul>
	    </div>
	<?php
	}
}
