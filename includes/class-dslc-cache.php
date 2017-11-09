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

	private $type; // Cache for code type: html, css.
	private $cache;
	private $enabled = true; // True/False – cache enabled/disabled.
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
	 * ]
	 */

	function __construct( $cache_type = false ) {
		if ( 'init' === $cache_type ) {
			add_action( 'save_post', array( $this, 'on_post_save' ) );
			add_action( 'added_post_meta', array( $this, 'on_meta_added' ), 10, 4 );
		} else {
			$this->type = $cache_type;
		}

		// If the transient does not exist, does not have a value,
		// or has expired, then get_transient will return false.
		$this->cache = get_transient( 'lc_cache' );

		$caching_engine_setting = dslc_get_option( 'lc_caching_engine', 'dslc_plugin_options_performance' );

		if ( 'disabled' === $caching_engine_setting ) {
			$this->enabled = false;
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
			$this->cache = array( 'html', 'css' );
		}
		*/

		/*
		 Remove previous version of HTML render from page cache.
		if ( isset( $this->cache['html'][ $post_id ] ) ) {
			unset( $this->cache['html'][ $post_id ] );
		}

		if ( isset( $this->cache['css'][ $post_id ] ) ) {
			unset( $this->cache['css'][ $post_id ] );
		}*/

		/*
		For now we rest all the cache after any post or page saved.
		This is temporary solution to have post grids and sliders to show
		actual information and template designs to updates properly.
		*/
		$this->cache = array(
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
		if ( $identificator && $this->cached( $identificator, $cache_type ) ) {
			if ( ! $cache_type ) {
				$cache_type = $this->type;
			}

			return $this->cache[ $cache_type ][ $identificator ];
		} else {
			return false;
		}
	}

	/**
	 * Save cached code (HTML or CSS).
	 */
	public function set_cache( $code_to_cache = false, $identificator = false, $cache_type = false ) {
		if ( $code_to_cache ) {
			if ( ! $cache_type ) {
				$cache_type = $this->type;
			}

			$this->cache[ $cache_type ][ $identificator ] = $code_to_cache;
			$this->update_db();
		}
	}

	/**
	 * Update code in the database.
	 */
	public function update_db() {
		set_transient( 'lc_cache', $this->cache, 0 );
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

		if ( isset( $this->cache[ $cache_type ] )
				&& isset( $this->cache[ $cache_type ][ $identificator ] ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if cache enabled.
	 */
	public function enabled() {
		return $this->enabled;
	}
}

$site_cache = new DSLC_Cache( 'init' );
