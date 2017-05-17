README
======

*What is this repository for?*

Beaver Builder Extra Fields allows for the use of custom fields in your custom modules. There are currently the following extra fields:

- toggle field A multi-option button like field that could substitute for yes/no selectboxes or one/two/three options. It has no set constraints on number of options though but make sure it fits on screen.

- slider-field using the jquery-ui allows for easy creation of sliders with full-range, min-and-up and up-to-max ranges. Can use step-size. see https://jqueryui.com/slider/ for available options.

- sliderrange-field using the jquery-ui allows for easy creation of sliders with both min and max range. Can use stepsize. see https://jqueryui.com/slider/ for available options.


Version 1.1
-------------------

*How do I get set up?*

download the zip-file
go to /plugins/new plugins
install zip-file
activate
or

upload zip-file contents to wp-contents/plugins/ using a FTP-client
activate the plugin in the admin-panel
using the fields

In custom modules register a module and add the field type as you would any other field, for instance:

Toggle
------

    'my_favorite_animal'   => array(
                    'type'          => 'toggle',
                    'label'         => __( 'Favorite Animal', 'textdomain' ),
                    'default'       => 'kitten',
                    'options'       => array(
                        'cat'           => __( 'Cat', 'textdomain' ),
                        'unicorn'       => __( 'Unicorn', 'textdomain' ),
                        'hamster'       => __( 'Hamster', 'textdomain'),
                    ),
                    'toggle'        => array (
                        'cat'       => array (
                            'fields'    => array ( 'name', 'size' ),
                        ),
                        'unicorn'       => array (),
                        'hamster'       => array (),
                    ),
                    'hide'          => array(),
                    'trigger'       => array(),
                    'oncolor'       => '#333333',
                    'offcolor'      => '#d1d1d1',
                ),

Slider
------

    'number_of_unicorns'      => array(
                    'type'      => 'slider',
                    'label'     => __( 'Unicorns' , 'textdomain' ),
                    'settings'  => array (
                        'min'       => 0,                   // min value for slider
                        'max'       => 60,              // max value for slider
                        'value'     => 30,              // default value to use when not set
                        'range'     => 'min',           // optional: min|max , do not set if no min- or max-range needed
                        'step'      => 5,                   // optional: step size, default to one
                        'color'     => '#666666',
                  ),
                ),

Slider Range
------------

    'number_of_kittens'      => array(
                  'type'        => 'sliderrange',
                  'label'       => __( 'Kittens' , 'textdomain' ),
                  'settings'     => array (
                      'min'       => 0,     // min value for slider
                      'max'       => 10,    // max value for slider
                      'defmin'    => 0,     // default min value
                      'defmax'    => 10,    // default max value
                      'value'     => 2,     // default value to use when not set
                      'step'      => 2,     // step size
                      'color'     => '#666666',
                  ),
                ),

Using the returned values
-------------------------
**Toggle & Slider field**
Both Toggle and Slider field return the set value. From the code examples above, you should be able to get the field-value by using the

    echo 'Your favorite animal is a(n) ' . $settings->my_favorite_animal;

and

    echo 'You have a total of ' . $settings->number_of_unicorns . 'unicorns!';

**Sliderrange field**
The sliderrange will have 2 values, that you will need to explode in order to get two seperate values.

    $values = explode( '|' , $settings->number_of_kittens );
    echo 'having ' . $values[1] . ' kittens is more than having ' . $values[0];


Dependencies
------------

Since your custom modules will need to be sure to have the custom field available, make sure to test for the existence of the bbExtraFields class at the top of your modules code (somewhere right after the opening php tag. If not, don't register the module and return. it won't show in Beaver Builder until you reactivate the bb-extra-fields plugin.

    if ( ! class_exists ( bbExtraFields ) ) { return; }

version history
1.1   removed the geotag field. Updated toggle-field code, sliderrange-field. Fields have fallback default settings.
1.0   -
