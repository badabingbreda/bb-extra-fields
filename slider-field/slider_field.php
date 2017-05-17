<?php

wp_register_script( 'jquery_ui_js', 'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js' , array( 'jquery' ), '1.0.0' );
wp_register_style( 'jquery_ui_css', 'https://code.jquery.com/ui/jquery-ui-git.css', 0 ,'1.12' , 'all' );
wp_register_style( 'bb-slider-css', BBEXTRA_FIELDS_URL . 'slider-field/slider.css', array(), '' );

// enqueue script and style-files for slider & sliderrange
add_action( 'wp_enqueue_scripts', 'fl_slider_field_assets' );

// register hook for sliderrange field
add_action('fl_builder_control_sliderrange', 'fl_sliderrange_field', 1, 3);

// register hook for slider field
add_action('fl_builder_control_slider', 'fl_slider_field', 1, 3);

/**
 * Render the Slider Range Field
 *
 *  * @param  string $name
 * @param  string $value
 * @param  array $field
 * @return void
 * @example
 */
function fl_sliderrange_field ( $name , $value , $field ) {

  $field = array_merge(
      array( 'settings' => array(
        'min' => 0 ,
        'max' => 10 ,
        'defmin' => 0 ,
        'defmax' => 10 ,
        'value' => '0|10' ,
        'step' => 1 ,
        'color' => '#666666'
      )
    ) , $field );

	if ( sizeof( $value = explode( '|' , $value ) ) !== 2 ) {
    $value = array ( $field[ 'settings' ][ 'defmin' ], $field[ 'settings' ]['defmax' ] );
  }
?>
<script>
( function( $ ) {
  $( function() {
    $( "#slider-range-<?php echo $name ; ?>" ).slider( {
      range: true,
      min: <?php echo $field[ 'settings' ][ 'min' ]; ?>,
      max: <?php echo $field[ 'settings' ][ 'max' ];?>,
      values: <?php echo ('['. $value[0]. ',' .$value[1] . ']');?> ,
      <?php if ( $field[ 'settings' ][ 'step' ] != null ) {
      ?>
      step: <?php echo $field[ 'settings' ][ 'step' ]; ?>,
      <?php
      }
      ?>
      slide: function( event, ui ) {
        $( "#slid<?php echo $name ; ?>" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        $( "#<?php echo $name ; ?>" ).val( ui.values[ 0 ] + "|" + ui.values[ 1 ] );
      },
    });
    $( "#slid<?php echo $name ; ?>" ).val( $( "#slider-range-<?php echo $name ; ?>" ).slider( "values", 0 ) + " - " + $( "#slider-range-<?php echo $name ; ?>" ).slider( "values", 1 ) );
  });
})(jQuery);
</script>
<div class="slider-field">
  <div class="slider-field-flex">
    <div class="flex-item slider-value"><input type="text" id="slid<?php echo $name; ?>" readonly style="border:0; color:<?php echo (isset($field['settings']['color']))?$field['settings']['color']:'#f6931f';?>; font-weight:bold;"></div>
    <div class="flex-item slider-slider"><div id="slider-range-<?php echo $name ; ?>"></div>
  </div>
  <input type="hidden" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value[0]."|".$value[1];?>">
</div>
<?php
}


function fl_slider_field ( $name , $value , $field ) {


  $field = array_merge(
      array( 'settings' => array(
        'min' => 0 ,
        'max' => 10 ,
        'range' => 'min',
        'value' => 10 ,
        'step' => 1 ,
        'color' => '#666666'
      )
    ) , $field );

  if ( $value==null ) $value = $field[ 'settings' ][ 'value' ];

?>
<script>
( function( $ ) {
  $( function( ) {
    $( "#slider-<?php echo $name ; ?>" ).slider( {
      <?php if ( isset($field['settings']['range']) ) echo 'range: "'.$field['settings']['range'].'",' ; ?>
      min: <?php echo $field[ 'settings' ][ 'min' ];?>,
      max: <?php echo $field[ 'settings' ][ 'max' ];?>,
      value: <?php echo $field['settings']['value']; ?>,
      <?php if ( isset( $field[ 'settings' ][ 'step' ] ) ) { ?>
      step: <?php echo $field[ 'settings' ][ 'step' ]; ?>,
      <?php } ?>
      slide: function( event, ui ) {
        $( "#slid<?php echo $name ; ?>" ).val( ui.value );
        $( "#<?php echo $name ; ?>" ).attr( "value",ui.value );
      },
    } );
    $( "#slid<?php echo $name ; ?>" ).val( $( "#slider-<?php echo $name ; ?>" ).slider( "value" ) );
  } );
} )( jQuery );
</script>
<div class="slider-field">
  <div class="slider-field-flex">
    <div class="flex-item slider-value">
      <input type="text" id="slid<?php echo $name; ?>" readonly style="border:0; color:<?php echo  $field['settings']['color'] ;?>;font-weight:bold;">
    </div>
    <div class="flex-item slider-slider">
      <div id="slider-<?php echo $name ; ?>">
    </div>
  </div>
  <input type="hidden" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value;?>">
</div>
<?php
}

/**
 * enqueue the registered classes if needed
 * @return void
 */
function fl_slider_field_assets() {
    // don't bother enqueueing if builder not active
    if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
      wp_enqueue_script( "jquery_ui_js" );
      wp_enqueue_style ( "jquery_ui_css" );
      wp_enqueue_style( "bb-slider-css" );
    }
}

