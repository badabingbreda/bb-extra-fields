<?php

// value desktop
// checkbox
// 		value middle
// 		value small
// check within modules:
// $global_settings = FLBuilderModel::get_global_settings();
// bind results to media queries

/**
 * set callback for the responsive control field
 */
add_action('fl_builder_control_responsive', 'fl_responsive_field', 1, 3);


function fl_responsive_field ( $name , $value , $field ) {

?>
<div class="bb-responsive">
	<div class="bb-responsive-field">
		<label for="bb-responsive-label" name="<?php echo $name ; ?>" data-field-name="<?php echo $name; ?>">
		<input name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="bb-responsive-desktop">
		<input name="<?php echo $name; ?>_isresp" id="<?php echo $name; ?>_isresp" class="bb-responsive-is_resp">
		<input name="<?php echo $name; ?>_medium" id="<?php echo $name; ?>_medium" class="bb-responsive-medium">
		<input name="<?php echo $name; ?>_small" id="<?php echo $name; ?>_small" class="bb-responsive-small">
	</div>
</div>
<?php

}

