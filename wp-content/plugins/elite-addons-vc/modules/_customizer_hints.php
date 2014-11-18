<?php

vc_add_param("vc_column_text", array(
	"type" => "ivan_customizer_id",
	"heading" => __("Customization ID", 'iv_js_composer'),
	"param_name" => "c_id",
	"value" => "",
));

array(
	"type" => "ivan_customizer_id",
	"heading" => __("Customization ID", 'iv_js_composer'),
	"param_name" => "c_id",
	"value" => "",
),

global $ivan_custom_css;

//
// Start Customizer Prefix
//
	$prefixClass = '';
	if( isset($atts['c_id']) ) {
		$this->prefix = $atts['c_id'] . ' ';
		$prefixClass = str_replace('.', '', $atts['c_id']);
	} else {
		$this->prefix = '.vc_custom_' . rand(25, 3000) . ' ';
		$prefixClass = str_replace('.', '', $this->prefix);
	}
// End Customizer Prefix

?>

<?php echo $prefixClass; ?>

<?php

//
// Customizer CSS Output
//
	$style = '';
	foreach ($this->selectors as $key => $value) {
		if( isset($atts[$key]) && '' != $atts[$key]) {
			$style .= ivan_vc_customizer_get_style( $atts[$key], $this->selectors[$key], $this->prefix );
		}
	}

	// Print style
	if(is_admin()) {
		$output .= '<style type="text/css">'
		. $style
		. '</style>';
	}
	else {
		$ivan_custom_css .= $style;
	}
// End Customizer Output

array(
	"type" => "ivan_customizer",
	"class" => "",
	"heading" => __("Main Block", 'iv_js_composer'),
	"param_name" => "block_css",
	"customize" => $ivan_vc_counter->selectors['block_css'],
	"value" => "",
	"group" => __('Customizer', 'iv_js_composer'),
),

'block_css' => array(
	// Font
	'font-family' => '*replace',
	//'font-weight' => '*replace',
	//'font-size' => '*replace',
	//'line-height' => '*replace',
	//'text-transform' => '*replace',
	//'color' => '*replace',
	// Dimensions
	//'width' => '*replace',
	//'height' => '*replace',
	// Spacing
	'margin-top' => '*replace',
	'margin-right' => '*replace',
	'margin-bottom' => '*replace',
	'margin-left' => '*replace',
	'padding-top' => '*replace',
	'padding-right' => '*replace',
	'padding-bottom' => '*replace',
	'padding-left' => '*replace',
	// Bg
	'background-color' => '*replace',
	// Border Radius
	'border-top-left-radius' => '*replace',
	'border-top-right-radius' => '*replace',
	'border-bottom-left-radius' => '*replace',
	'border-bottom-right-radius' => '*replace',
	// Border
	'border-top-width' => '*replace',
	'border-right-width' => '*replace',
	'border-bottom-width' => '*replace',
	'border-left-width' => '*replace',
	'border-style' => '*replace',
	'border-color' => '*replace',
	// Hovers
	//'color-hover' => '*replace',
	//'border-color-hover' => '*replace',
	//'background-color-hover' => '*replace',
),

//

array(
	"type" => "dropdown",
	"heading" => __("Template", 'iv_js_composer'),
	"param_name" => "template",
	'admin_label' => true,
	'value' => apply_filters( 'ivan_vc_progress', array(
		__( 'Default', 'iv_js_composer' ) => '',
		'Gray' => 'gray-bg',
		'Dark' => 'dark-bg',
		'Clean' => 'clean-color',
		'Light' => 'light-bg',
		'Primary' => 'primary-bg',
	) ),
	'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
),

vc_add_param("vc_separator", array(
	"type" => "dropdown",
	"heading" => __("Template", 'iv_js_composer'),
	"param_name" => "template",
	'admin_label' => true,
	'value' => apply_filters( 'ivan_vc_separator', array(
		__( 'Default', 'iv_js_composer' ) => '',
		'Gray' => 'gray-bg',
		'Dark' => 'dark-bg',
		'Clean' => 'clean-color',
		'Light' => 'light-bg',
		'Primary' => 'primary-bg',
	) ),
	'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
));

'template' => '',

// Add custom template class
if('' != $template)
	$classes .= ' ' . $template;

// Scheme Gray
&.gray-bg {

}

// Scheme Dark
&.dark-bg {

}

// Scheme Clean
&.clean-color {

}

// Scheme Light
&.light-bg {

}

// Scheme Primary
&.primary-bg {

}