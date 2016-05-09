README

WHY USE THE GEOCODE FIELD

Using the geocode field you can see if your markers will pan out to a location on the map. You can then easily add markers. Each marker is checked on validity each time you open the module.

HOW TO USE THE GEOCODE-FIELD

Include the GEOCODE within your module settings as a field

    'geocode'     => array(
        'type'      =>"geocode",
        'label'     => __( 'Geocode' , 'textdomain' ),
        'settings'  => array (
            'default' => '',
            'placeholder' => 'enter location',
            'foundcolor'	  => '#060',
            'notfoundcolor' => '#900',
        ),
    ),

Button text is handled by the textdomain translation files

USING THE SET FIELD-VALUE WITHIN YOUR CODE

The Field-value is a uriencoded json value. This means the set data has to be urldecoded first and then json decoded:

<?php

	// frontend.php / frontend.js.php // frontend.css.php

	$geocode = ( json_decode( urldecode( $settings->geocode ) ) );

	$address = $geocode->address;
	$lat = $geocode->marker->lat;
	$lng = $geocode->marker->lng;
?>

or Using Javascript / jQuery

var myValueArray = JSON.parse( decodeURIComponent( '<?php echo $settings->geocode; ?>'' ) );

then access them using

var address = myValueArray.address;
var lat = myValueArray.marker.lat;
var lng = myValueArray.marker.lng;
