<?php
/**
 * This file is toggle_field.php
 *
 * @author Badabing
 * @package package name
 * @subpackage Customizations
 */

/**
 * Enqueue styles and scripts for this toggle control field
 */
add_action( 'wp_enqueue_scripts', 'sw_enqueue_toggle' );

/**
 * set callback for the toggle control field
 */
add_action('fl_builder_control_toggle', 'fl_toggle_field_true', 1, 3);


/**
 * Render the Toggle Field to the browser
 *
 * @param  string $name  unique name of the field
 * @param  string $value assigned value for $name
 * @param  array $field settings for field
 * @return void
 *
  * 'line_bar'   => array(
 *   'type'          => 'toggle',
 *   'label'         => __( 'Graph Type', 'textdomain' ),
 *   'default'       => 'Line',
 *   'options'       => array(
 *       'Line'      => __( 'Line', 'textdomain' ),
 *       'Bar'      => __( 'Bar', 'textdomain' ),
 *       'Radar'     => __( 'Radar', 'textdomain'),
 *   ),
 *   'toggle'      => array (
 *       'Line'      => array (
 *           'fields'    => array ( 'usebeziers', 'beziercurvetension' ),
 *       ),
 *       'Bar'          => array (),
 *       'Radar'          => array (),
 *   ),
 *   'hide'        => array(),
 *   'trigger'      => array(),
 *   'oncolor'         => '#333333',
 *   'offcolor'        => '#d1d1d1',
 *
 */
function fl_toggle_field_true( $name , $value , $field ) {

  $offcolor = array_key_exists( 'offcolor' , $field ) ? $field[ 'offcolor' ] : '#e4e4e4';
  $oncolor = array_key_exists( 'oncolor' , $field ) ? $field[ 'oncolor' ] : '#A5DC86';
  $buttoncount = count($field['options']);

?>
<div class="toggle-field">
  <style>
    .toggle-field .<?php echo $name; ?> {
      background-color: <?php echo $offcolor; ?>;
    }
      .toggle-field  .<?php echo $name; ?>:checked + .<?php echo $name; ?> {
      background-color: <?php echo $oncolor; ?>;
}
  </style>
<?php

    //if ( array_key_exists( 'options' , $field ) ) {

  foreach ( $field[ 'options' ] as $key => $option ) {

    $checked = '';
    if ( isset( $value ) && $key == $value ) {
      $checked = 'checked';
    } elseif ( !isset( $value ) && $key == $field[ 'default' ] ) {
      $checked = 'checked';
    }

    $toggle = isset( $field[ 'toggle' ][ $key ]) ? 'data-toggle=\''. json_encode( $field[ 'toggle' ] ) . '\'' : '';
    $hide = isset( $field[ 'hide' ][ $key ]) ? 'data-hide="'. json_encode( $field[ 'hide' ] ) . '"' : '';
    $trigger = isset( $field[ 'trigger' ][ $key ] )? 'data-trigger="'. json_encode( $field[ 'trigger' ] ) . '"' : '';

    $html  = sprintf( '<input type="radio" class="%s" id="%s" name="%s" value="%s" %s' , $name , $name . '_' . $key , $name , $key , $checked);
    $html .= sprintf( ' %s %s %s />' , $toggle , $hide , $trigger );
    $html .= sprintf( '<label class="%s" for="%s">%s</label>' , $name , $name . '_' . $key , $option );

    echo $html;
  }
?>
</div>
<?php
}

/**
 * Enqueue toggle field stylesheet and javascript to handle toggle hide and trigger actions
 *
 * @return void
 */
function sw_enqueue_toggle() {
	wp_enqueue_style( 'bbtoggle-css', BBEXTRA_FIELDS_URL . 'toggle-field/toggle.css' , null , BBEXTRA_FIELDS_VERSION , 'all' );
  wp_enqueue_script( 'bbtoggle-js', BBEXTRA_FIELDS_URL . 'toggle-field/toggle_field.js' , null , BBEXTRA_FIELDS_VERSION , true );
}
