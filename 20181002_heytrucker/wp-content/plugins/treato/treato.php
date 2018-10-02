<?php
/*
Plugin Name: Treato WordPress Plugin
Plugin URI:  https://treato.com/
Description: Treato travels around the web to collect and analyze patient written forum and blog posts. The plugin gives access to this new aggregated information.
Version:     1.1.1
Author:      Treato
Author URI:  https://treato.com/
Text Domain: treato
*/



/**
 * Security check
 * Prevent direct access to the file.
 *
 * @since 1.0.9
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Include plugin files
 */
include_once ( plugin_dir_path( __FILE__ ) . 'includes/i18n.php' );    // Add i18n support
include_once ( plugin_dir_path( __FILE__ ) . 'includes/widgets.php' ); // Add WordPress Widgets
