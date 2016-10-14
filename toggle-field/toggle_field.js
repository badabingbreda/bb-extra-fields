( function ( $ ) {

	function toggleChanged ( select ) {
		//var select  = $(this),
			toggle  = select.attr('data-toggle'),
			hide    = select.attr('data-hide'),
			trigger = select.attr('data-trigger'),
			val     = select.val(),
			i       = 0,
			k       = 0;

		// TOGGLE sections, fields or tabs.
		if(typeof toggle !== 'undefined') {

			toggle = JSON.parse(toggle);

			for(i in toggle) {
				FLBuilder._settingsSelectToggle(toggle[i].fields, 'hide', '#fl-field-');
				FLBuilder._settingsSelectToggle(toggle[i].sections, 'hide', '#fl-builder-settings-section-');
				FLBuilder._settingsSelectToggle(toggle[i].tabs, 'hide', 'a[href*=fl-builder-settings-tab-', ']');
			}

			if(typeof toggle[val] !== 'undefined') {
				FLBuilder._settingsSelectToggle(toggle[val].fields, 'show', '#fl-field-');
				FLBuilder._settingsSelectToggle(toggle[val].sections, 'show', '#fl-builder-settings-section-');
				FLBuilder._settingsSelectToggle(toggle[val].tabs, 'show', 'a[href*=fl-builder-settings-tab-', ']');
			}
		}

		// HIDE sections, fields or tabs.
		if(typeof hide !== 'undefined') {

			hide = JSON.parse(hide);

			if(typeof hide[val] !== 'undefined') {
				FLBuilder._settingsSelectToggle(hide[val].fields, 'hide', '#fl-field-');
				FLBuilder._settingsSelectToggle(hide[val].sections, 'hide', '#fl-builder-settings-section-');
				FLBuilder._settingsSelectToggle(hide[val].tabs, 'hide', 'a[href*=fl-builder-settings-tab-', ']');
			}
		}

		// TRIGGER select inputs.
		if(typeof trigger !== 'undefined') {

			trigger = JSON.parse(trigger);

			if(typeof trigger[val] !== 'undefined') {
				if(typeof trigger[val].fields !== 'undefined') {
					for(i = 0; i < trigger[val].fields.length; i++) {
						$('#fl-field-' + trigger[val].fields[i]).find('select').trigger('change');
					}
				}
			}
		}
	}

	$ ( document ).ready (function () {
		// make sure the FLBuilder exists
		if ( typeof FLBuilder != 'object' ) return;
		// have the radio:checked toggle take place
		$( 'body' ).delegate( '.fl-builder-settings-fields :radio:checked' , 'change' ,  function () { toggleChanged($(this));  } );

		// toggle fields, tabs, sections when loading the module-settings
		$.onCreate( '.fl-lightbox-header' , function () { $( '.fl-lightbox-content .fl-builder-settings-fields :radio:checked' ).each( function ( ) { toggleChanged( $( this ) ); } ); } , true );
	});


} )( jQuery );
