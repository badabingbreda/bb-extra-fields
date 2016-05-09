/**
 * Get the Lat Lng Marker location using GMaps geocode
 * @param  string location [description]
 * @return {[type]}          [description]
 */


( function ( $ )  {

	$( document ).ready ( function () {
		$( 'body' ).delegate( '.geo-button', 'click', function() {
			GEO._getGeoLocation( $ ( '#geo_' + $( this ).data( 'field-name' ) + '_address' ).val() , $( this ).data( 'field-name' ) );
		});
	});

	GEO = {
		_getGeoLocation : function ( location , fieldname ) {
			GMaps.geocode ({ address: location,
				callback: function (results, status) {
					if (status == 'OK') {
						latlng = results[0].geometry.location;
						var marker = { lat:latlng.lat() , lng: latlng.lng() };
						// remove red, add green class to the button to indicate that it is all good
						$( '#geo_' + fieldname + '_button' ).removeClass('red').addClass('green').attr( 'value' , $( '#geo_' + fieldname + '_button' ).data( 'found-value' ) );

						var fielddata = { marker: marker , address : location };
						$( '#' + fieldname ).attr( 'value' , encodeURIComponent( JSON.stringify( fielddata ) ) );
					} else {
						console.log ('there was an error getting the location');
						// remove green, add red class to the button to indicate that it is not good
						$( '#geo_' + fieldname + '_button' ).removeClass('green').addClass('red').attr( 'value' , $( '#geo_' + fieldname + '_button' ).data( 'notfound-value' ) );

					}
				}
			});
		},

		_getData : function ( fieldname ) {
				var fielddata = JSON.parse( decodeURIComponent( $( '#'+ fieldname ).val() ) );
				$( '#geo_'+ fieldname +'_address' ).attr( 'value' , fielddata.address );
				this._getGeoLocation( fielddata.address , fieldname );
		},

		_clearField : function ( fieldname ) {
				var buttonname = '#geo_' + fieldname + '_button';
				$( buttonname ).removeClass('green').removeClass('red').attr( 'value' , $( buttonname ).data( 'init-value' ) );
				$( '#'+fieldname ).attr( 'value' , '' );
		}
	}

} ) ( jQuery );
