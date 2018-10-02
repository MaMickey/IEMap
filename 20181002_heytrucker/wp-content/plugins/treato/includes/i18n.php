<?php
/**
 * Security check
 * Prevent direct access to the file.
 *
 * @since 1.1.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Internationalization
 * Load plugin translation files.
 *
 * @since 1.1.1
 */
class Treatoi18n {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

	}

	/**
	 * Load text domain for translation
	 */
	public function load_textdomain() {

		load_plugin_textdomain( 'treato' );

	}

}
new Treatoi18n();
