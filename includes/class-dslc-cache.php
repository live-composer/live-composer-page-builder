<?php
/**
 * Simple HTML and CSS caching class. Designed to reduce load on the server
 * in cases when advanced caching plugins not installed.
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Very simple HTML and CSS caching class.
 */
class DSLC_Cache {
	/**
	 * Properties: init, enabled and cache are defined once
	 * for the whole session. These properties defined based on data
	 * from the database and are expensite.
	 */
	private static $init = false;
	private static $enabled = true; // Cache enabled/disabled.
	private static $cache;
	private $type = 'html'; // Cache for code type: html (default), css, font.

	/**
	 * Here is the structure of the cache array.
	 * _transient_lc_cache [
	 * 	– html
	 * 	–– post_id
	 * 	–– post_id
	 *
	 * 	– css
	 * 	–– md5 hashtag – based on html code for the current css code.
	 * 	–– md5 hashtag
	 *
	 *  – fonts
	 * ]
	 */

	function __construct( $cache_type = '' ) {
		if ( ! self::$init ) {
			$caching_engine_setting = dslc_get_option(
				'lc_caching_engine',
				'dslc_plugin_options_performance'
			);

			/*
			 * If dslc_plugin_options is an empty needed to add a cache as default ( enabled )
			 */
			if ( empty( $caching_engine_setting ) ) {
				$caching_engine_setting = 'enabled';
			}

			if ( 'disabled' === $caching_engine_setting ) {
				self::$enabled = false;
			} elseif ( $this->should_disable_cache() && is_admin() ) {
				self::$enabled = false;

				// Disable the caching option in the plugin settings.
				if ( 'enabled' === $caching_engine_setting ) {
					$dslc_plugin_options = get_option( 'dslc_plugin_options' );
					$dslc_plugin_options['lc_caching_engine'] = 'disabled';
					update_option( 'dslc_plugin_options', $dslc_plugin_options );
				}
			} else {
				// Run these functions only once per session.
				add_action( 'save_post', array( $this, 'on_post_save' ) );
				add_action( 'added_post_meta', array( $this, 'on_meta_added' ), 10, 4 );

				// If the transient does not exist, does not have a value,
				// or has expired, then get_transient will return false.
				self::$cache = get_transient( 'lc_cache' );
			}

			// Mark init as completed to not repeat it again.
			self::$init = true;
		}

		if ( $cache_type ) {
			$this->type = $cache_type;
		}
	}

	/**
	 * Delete cached code (HTML or CSS) on page code update.
	 *
	 * @return void
	 */
	public function on_meta_added( $meta_id, $post_id, $meta_key, $meta_value ) {
		if ( 'dslc_code' === $meta_key ) {
			$this->on_post_save( $post_id );
		}
	}

	/**
	 * Function indicated that cache should be disabled in website already
	 * using some of the popular WordPress caching plugins.
	 *
	 * @return true/false
	 */
	public function should_disable_cache() {
		$disable_cache = false;
		if ( defined( 'W3TC' ) || defined( 'WPCACHEHOME' ) || class_exists( 'autoptimizeCache' ) ) {
			$disable_cache = true;
		}

		return $disable_cache;
	}

	public function delete_cache() {
		delete_transient( 'lc_cache' );
	}

	/**
	 * Delete cached code (HTML or CSS) on page save.
	 *
	 * @return void
	 */
	public function on_post_save( $post_id ) {
		/*
		Remove cached pages or particular post type.
		💂 Needs more work. Not ready for production.

		$post_type = get_post_type( $post_id );

		$post_types_reset_cache = array(
			'dslc_templates',
			'dslc_downloads',
			'post',
		);

		if ( in_array( $post_type, $post_types_reset_cache ) ) {
			self::$cache = array( 'html', 'css' );
		}
		*/

		/*
		 Remove previous version of HTML render from page cache.
		if ( isset( self::$cache['html'][ $post_id ] ) ) {
			unset( self::$cache['html'][ $post_id ] );
		}

		if ( isset( self::$cache['css'][ $post_id ] ) ) {
			unset( self::$cache['css'][ $post_id ] );
		}*/

		/*
		For now we reset all the cached data after any post or page saved.
		This is temporary solution to have post grids and sliders to show
		actual information and template designs to updates properly.
		*/
		self::$cache = array(
				'html' => array(),
				'css' => array(),
				'fonts' => array(),
			);
		$this->update_db();
	}

	/**
	 * Return cached code (HTML or CSS).
	 *
	 * @return string/boolean Cached code or false if not found.
	 */
	public function get_cache( $identificator = false, $cache_type = false ) {

		if ( self::$enabled && $identificator && $this->cached( $identificator, $cache_type ) ) {
			if ( ! $cache_type ) {
				$cache_type = $this->type;
			}

			return self::$cache[ $cache_type ][ $identificator ];
		} else {
			return false;
		}
	}

	/**
	 * Save cached code (HTML or CSS).
	 */
	public function set_cache( $code_to_cache = false, $identificator = false, $cache_type = false ) {
		if ( self::$enabled && $code_to_cache ) {

			if ( ! $cache_type ) {
				$cache_type = $this->type;
			}

			self::$cache[ $cache_type ][ $identificator ] = $code_to_cache;
			$this->update_db();
		}
	}

	/**
	 * Update code in the database.
	 */
	public function update_db() {
		set_transient( 'lc_cache', self::$cache, DAY_IN_SECONDS * 3 ); // max cache live is 3 days.
	}

	/**
	 * Is html/css code for the page cached or not?
	 *
	 * @return boolean True/False.
	 */
	public function cached( $identificator = false, $cache_type = false ) {
		if ( ! $cache_type ) {
			$cache_type = $this->type;
		}

		if ( self::$enabled && isset( self::$cache[ $cache_type ] )
				&& isset( self::$cache[ $cache_type ][ $identificator ] ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if cache enabled.
	 */
	public function enabled() {
		return self::$enabled;
	}
}

/**
 * Run cache for page rendering requests only (not cron);
 * Allow ajax requests only when saving the changes (is set dslc_code).
 * Function wp_doing_cron were introduced recently 4.8,
 * so we need an aditional check for its existence.
 */
if ( ( function_exists( 'wp_doing_cron' ) && ! wp_doing_cron() ) && ( ! wp_doing_ajax() || isset( $_POST['dslc_code'] ) ) ) {
	$site_cache = new DSLC_Cache();
}

/**
 * When our or any other plugin saves the settins it will be redirected
 * shortly to the options.php. This is when we need to reset cache.
 */
add_action( 'load-options.php', 'lbmn_reset_cache_on_settings_save' );
function lbmn_reset_cache_on_settings_save() {
	$site_cache = new DSLC_Cache();
	$site_cache->delete_cache();
}
