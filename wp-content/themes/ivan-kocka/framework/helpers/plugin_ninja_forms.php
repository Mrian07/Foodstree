<?php
/**
 * Used in Ninja Forms plugin
 *
 */

// Ninja Forms Columns implementation...
function ivan_custom_ninja_wrapper_open( $form_id ) {
	echo '<div class="row">';
}
add_action( 'ninja_forms_display_before_fields', 'ivan_custom_ninja_wrapper_open' );

function ivan_custom_ninja_wrapper_close( $form_id ) {
	echo '</div><!--.row-->';
}
add_action( 'ninja_forms_display_after_fields', 'ivan_custom_ninja_wrapper_close' );

// Custom Field
add_action('init', 'ninja_forms_register_edit_field_custom_col');
function ninja_forms_register_edit_field_custom_col(){
	add_action('ninja_forms_edit_field_after_registered', 'ninja_forms_edit_field_custom_col', 10);
}

function ninja_forms_edit_field_custom_col($field_id){
	global $ninja_forms_fields;
	$field_row = ninja_forms_get_field_by_id($field_id);
	$field_type = $field_row['type'];
	$field_data = $field_row['data'];
	$reg_field = $ninja_forms_fields[$field_type];

	if(isset($field_data['bootstrap-cols'])){
		$class = $field_data['bootstrap-cols'];
	}else{
		$class = 'col-xs-12 col-sm-12 col-md-12';
	}

	ninja_forms_edit_field_el_output($field_id, 'text', __( 'Custom Bootstrap Classes', 'ivan_domain_redux' ), 'bootstrap-cols', $class, 'wide', '', 'widefat');	
}

// Display Columns in the fields...
// Ninja Forms Columns implementation...
function ivan_custom_ninja_field_col_open( $field_id, $data ) {

	$_cols = 'col-xs-12 col-sm-12 col-md-12';

	if( isset( $data['bootstrap-cols'] ) )
		$_cols = $data['bootstrap-cols'];

	echo '<div class="'.$_cols.'">';
}
add_action( 'ninja_forms_display_before_field', 'ivan_custom_ninja_field_col_open', 10, 2 );

function ivan_custom_ninja_field_col_close( $form_id ) {
	echo '</div><!--.col-#-#-->';
}
add_action( 'ninja_forms_display_after_field', 'ivan_custom_ninja_field_col_close', 10, 2 );

// Remove required notice
add_action('ninja_forms_display_init', 'ivan_ninja_remove_req');
function ivan_ninja_remove_req() {
	remove_action('ninja_forms_display_before_fields', 'ninja_forms_display_req_items', 12);
}