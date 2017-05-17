<?php
/**
 * Plugin Name: Beaver Builder Custom Field Types
 * Plugin URI: http://www.badabing.nl
 * Description: Custom Field Types for the Beaver Builder Plugin.
 * Version: 1.1
 * Author: Badabing
 * Author URI: http://www.badabing.nl
 */

define( 'BBEXTRA_FIELDS_VERSION' , '1.1' );
define( 'BBEXTRA_FIELDS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BBEXTRA_FIELDS_URL', plugins_url( '/', __FILE__ ) );

function BBEXTRA_extra_fields() {

  if ( class_exists( 'FLBuilder' ) ) {

  	require_once ( 'toggle-field/toggle_field.php' );
  	require_once ( 'slider-field/slider_field.php' );

  }
}

add_action( 'init', 'BBEXTRA_extra_fields' );

// Create a dummy class so we can do a quick test when loading custom modules
// if ( ! class_exists ( bbExtraFields ) ) { return; }
class bbExtraFields { }
