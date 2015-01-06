<?php
/**
 * Functions used to return values from theme options panel
 *
 */

global $iv_aries;
global $iv_local_opts;
$iv_local_opts = $iv_aries;

// Return option from theme options.
function ivan_get_option( $id ) {
	global $iv_local_opts;

	if(!isset($iv_local_opts[$id]))
		return null;

	$value = $iv_local_opts[$id];

	// Used to overwrite a few properties defined in metabox
	if(is_singular()) {
		$_val = ivan_get_post_option( $id . '-local' );

		if('' != $_val && null != $_val) {
			$value = $_val;
		}
	}

	//return apply_filters('ivan_get_option_filter', $value, $id);
	return apply_filters('ivan_get_option_filter_' . $id , $value);
}

// Return $true if option is true or $false if not.
function ivan_get_option_display( $id, $true = true, $false = false ) {
	global $iv_local_opts;

	if(!isset($iv_local_opts[$id]))
		return null;

	$value = $iv_local_opts[$id];

	// Used to overwrite a few properties defined in metabox
	if(is_singular()) {

		$_val = ivan_get_post_option( $id . '-local' );

		if('' != $_val && null != $_val) {
			$value = $_val;
		}
	}

	//$value = apply_filters('ivan_get_option_filter', $value, $id);
	$value = apply_filters('ivan_get_option_filter_' . $id , $value);

	if( true == $value )
		return $true;
	else
		return $false;
}

// Return post option [from metaboxes]
function ivan_get_post_option( $id ) {

	global $post;
	if(!isset($post->ID))
		return null;

	//$options = get_post_meta( get_the_ID(), IVAN_FW_THEME_OPTS, true ); dropped because Redux Metabox update...
	$options = redux_post_meta(IVAN_FW_THEME_OPTS, get_the_ID());

	if( isset( $options[$id] ) )
		return apply_filters('ivan_get_post_option_filter', $options[$id], $id);
	else
		return null;
}

// Return $true if post option is true or $false if not [from metaboxes]
function ivan_get_post_option_display( $id, $true = true, $false = false ) {

	if( true == is_singular() ) :
		$opt = ivan_get_post_option( $postID, $id );

		if( $opt == true )
			return $true;
		else
			return $false;
	else :
		return null;
	endif;
}

// Ivan Current Callers
global $ivan_current_callers;

$ivan_current_callers = array(
	'main-layout' => '',
	'layout' => '',
	);

// Define current caller, that is the layout being displayed in the moment.
function ivan_set_current_caller( $name, $value ) {
	global $ivan_current_callers;

	$ivan_current_callers[ $name ] = $value;
}

// Return current caller to allow know which layou is being rendered.
function ivan_get_current_caller( $name ) {
	global $ivan_current_callers;

	return $ivan_current_callers[ $name ];
}