<?php
/**
 * Add Templates to Visual Composer Modules
 *
 * This is used to create different ready styles to Visual Composer
 * Modules
 */

/**
 * Pie Charts
**/

add_filter('ivan_pie_chart_active_primary', 'custom_ivan_pie_chart_active_primary', 100);
function custom_ivan_pie_chart_active_primary( $color ) {
	return '#0ab6a2';
}

/**
 * Title Wrapper
**/
/*
add_filter('ivan_vc_title_wrapper', 'ivan_vc_title_wrapper_templates');
function ivan_vc_title_wrapper_templates( $templates ) {

	// Custom templates
	$templates['Magazine Flat'] = 'magazine-flat';

	return $templates;

}
*/