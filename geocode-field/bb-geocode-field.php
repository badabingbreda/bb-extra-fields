<?php

// register scripts that we will use to get the geocode data
wp_register_script( 'bb_ggmap' ,'https://cdn.rawgit.com/hpneo/gmaps/master/gmaps.js', array ( 'jquery' ), 1 , false );
wp_register_script( 'bb_gmaps' ,'http://maps.google.com/maps/api/js?sensor=true&.js', array ( 'jquery' ), 1 , false );
wp_register_style( 'bb_geocodecss' , BBEXTRA_FIELDS_URL . 'geocode-field/bb-geocode.css', false , BBEXTRA_FIELDS_VERSION , 'all' );
wp_register_script( 'bb_geocodejs' , BBEXTRA_FIELDS_URL . 'geocode-field/bb-geocode.js' , array( 'jquery' ) ,BBEXTRA_FIELDS_VERSION , false );
// enqueue script and style-files for slider & sliderrange
add_action( 'wp_enqueue_scripts', 'fl_enqueue_geocode' );

// register hook for geocode field
add_action( 'fl_builder_control_geocode', 'fl_geocode_field', 1, 3 );

/**
 * Render a geocode field that stores lat and long position when address has been found.
 * These coordinates can be used to place markers on a map by address
 *
 * @param  string $name
 * @param  string $value
 * @param  array $field
 * @return void
 */
function fl_geocode_field ( $name , $value , $field ) {
	$value = ( !$value ) ? $field[ 'settings' ][ 'default' ] :  $value ;
	?>
<div class="bb-geocode">
	<div class="bb-geocode-field">
		<label class="geocode-label" for="<?php echo 'geo_' . $name . '_address' ;?>" data-field-name="<?php echo $name; ?>">
		<input type="text" name="" id="<?php echo 'geo_' . $name . '_address' ;?>" class="geo-address" data-field-name="<?php echo $name; ?>" placeholder="<?php echo $field[ 'settings' ][ 'placeholder' ]; ?>" />
		<input type="button" value="<?php _e( 'get coordinates', 'textdomain' );?>" class="geo-button" data-init-value="<?php _e( 'get coordinates' , 'textdomain'); ?>" data-found-value="<?php _e( 'found it!' , 'textdomain' ); ?>" data-notfound-value="<?php _e( 'not found' , 'textdomain' ); ?>" data-field-name="<?php echo $name; ?>" id="geo_<?php echo $name; ?>_button" />
		<input type="hidden" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo ($value); ?>" data-field-name="<?php echo $name; ?>" />
	</div>
</div>
<script>
	( function ( $ ) {

		$( document ).ready ( function () {
			// decode and parse field value (need to codeURI to allow for certain characters )
			if ( $( '#<?php echo $name; ?>' ).val() !== '' ) { GEO._getData ( '<?php echo $name; ?>' );	}
			// add a delegate for this field to monitor changes and set button color accordingly
			$( '#geo_<?php echo $name; ?>_address' ).on('change keyup paste', function() { GEO._clearField( $( this ).data('field-name') ); });

		});
	}) ( jQuery );
</script>
<?php if ( array_key_exists( 'foundcolor' , $field['settings'] ) || array_key_exists( 'notfoundcolor' , $field['settings'] ) ){?>
<style>
<?php if ( array_key_exists( 'foundcolor' , $field['settings'] ) ) {
?>
input#geo_<?php echo $name; ?>_button.green[type="button"] {
	background-color: <?php echo $field[ 'settings' ][ 'foundcolor' ]; ?>;
	color: #fff;
}
<?php }
if ( array_key_exists( 'notfoundcolor' , $field['settings'] ) ) {
?>
input#geo_<?php echo $name; ?>_button.red[type="button"] {
	background-color: <?php echo $field[ 'settings' ][ 'notfoundcolor' ]; ?>;
	color: #fff;
}
<?php } ?>
</style>
<?php }?>
<?php
}

function fl_enqueue_geocode () {
    // don't bother enqueueing if builder not active
    if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
		wp_enqueue_script( 'bb_ggmap' );
		wp_enqueue_script( 'bb_gmaps' );
		wp_enqueue_style( 'bb_geocodecss' );
		wp_enqueue_script( 'bb_geocodejs' );
	}
}
