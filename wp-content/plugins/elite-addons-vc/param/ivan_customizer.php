<?php
// Ivan Customizer Field
if( !class_exists('Ivan_VC_Customizer') ) {
	class Ivan_VC_Customizer {

		protected $settings = array();
		protected $value = '';

		function __construct() {

		}

		/**
		 * Setters/Getters {{
		 */
		function settings($settings = null) {
			if (is_array($settings)) $this->settings = $settings;
			return $this->settings;
		}

		function setting($key) {
			return isset($this->settings[$key]) ? $this->settings[$key] : '';
		}

		function value($value = null) {
			if (is_string($value)) {
				$this->value = $value;
			}
			return $this->value;
		}
		/*
		function params($values = null) {
			if (is_array($values)) $this->params = $values;
			return $this->params;
		}
		*/
		// }}

		function render() {
			$output = '<div class="vc-ivan-customizer row vc-row vc_row" data-ivan-customizer="true">';

			$fields = $this->setting('customize');
			if( is_array($fields) ) {

				$colPrefix = 'vc_span';

				if( true == defined("IVAN_VC_RUN_LATEST") )
					$colPrefix = 'vc_col-xs-';

				/* Font Controls */
				if( array_key_exists('font-family', $fields)
					OR array_key_exists('font-weight', $fields) 
					OR array_key_exists('font-size', $fields) 
					OR array_key_exists('line-height', $fields) 
					OR array_key_exists('color', $fields) 
					OR array_key_exists('text-transform', $fields) 
					) :

				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Font', 'iv_js_composer') . '</label>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'6">';

						if( array_key_exists('font-family', $fields) )
						$output .= '<input type="text value="" name="font-family" class="vc-font-family-control ivan-field" data-property="font-family" placeholder="Font Family">';

						/*if( array_key_exists('font-family', $fields) )
						$output .= '<select name="font-family" class="vc-font-family-control ivan-field" data-property="font-family">
								<option value="">Font Family</option>
								<option value="Oswald">Oswald</option>
								<option value="Open Sans">Open Sans</option>
							</select>';*/

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'6">';

						if( array_key_exists('font-weight', $fields) )
						$output .= '<select name="font-weight" class="vc-font-family-control ivan-field" data-property="font-weight">
								<option value="">Font Weight</option>
								<option value="100">Ultra-Light 100</option>
								<option value="200">Light 200</option>
								<option value="300">Book 300</option>
								<option value="400">Normal 400</option>
								<option value="500">Medium 500</option>
								<option value="600">Semi-Bold 600</option>
								<option value="700">Bold 700</option>
								<option value="800">Extra-Bold 800</option>
								<option value="900">Ultra-Bold 900</option>
							</select>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';

						if( array_key_exists('color', $fields) )
						$output .= '<div class="color-group"><input type="text" name="color" value="" class="vc-color-control vc_color-control ivan-field" data-property="color"></div>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';

						if( array_key_exists('font-size', $fields) )
						$output .= '<input type="text" name="font-size" value="" class="vc-font-size-control ivan-field" data-property="font-size" placeholder="Size"><span class="small-label">Size</span>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						
						if( array_key_exists('line-height', $fields) )
						$output .= '<input type="text" name="line-height" value="" class="vc-line-height-control ivan-field" data-property="line-height" placeholder="Line Height"><span class="small-label">Line Height</span>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';

						if( array_key_exists('text-transform', $fields) )
						$output .= '<select name="" class="vc-text-transform-control ivan-field" data-property="text-transform">
								<option value="">Text Transform</option>
								<option value="uppercase">Uppercase</option>
								<option value="lowercase">Lowercase</option>
								<option value="initial">Initial</option>
								<option value="capitalize">Capitalize</option>
							</select>';

					$output .= '</div>';
				
				$output .= '</div>';

				endif;

				/* Text Align */
				if( array_key_exists('width', $fields) OR array_key_exists('height', $fields) ) :
					$output .= '<div class="vc-settings">';

						$output .= '<div class="'. $colPrefix .'12">';

							$output .= '<label>' . __('Dimensions', 'iv_js_composer') . '</label>';

						$output .= '</div>';

						if( array_key_exists('width', $fields) ) :

							$output .= '<div class="'. $colPrefix .'6">';

								$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="width" placeholder="Width"><span class="small-label">Width</span>';

							$output .= '</div>';

						endif;

						if( array_key_exists('height', $fields) ) :

							$output .= '<div class="'. $colPrefix .'6">';

								$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="height" placeholder="Height"><span class="small-label">Height</span>';

							$output .= '</div>';

						endif;

					
					$output .= '</div>';
				endif;

				/* Text Align */
				if( array_key_exists('text-align', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'6">';

						$output .= '<label>' . __('Text Align', 'iv_js_composer') . '</label>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'6">';

						$output .= '<select name="" class="vc-text-align-control ivan-field" data-property="text-align">
								<option value="">Text Align</option>
								<option value="left">Left</option>
								<option value="center">Center</option>
								<option value="right">Right</option>
							</select>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Color Hover */
				if( array_key_exists('color-hover', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Color Hover', 'iv_js_composer') . '</label>';

						$output .= '<div class="color-group"><input type="text" name="" value="" class="vc-color-control vc_color-control ivan-field" data-property="color-hover"></div>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Color Focus */
				if( array_key_exists('color-focus', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Color Focus', 'iv_js_composer') . '</label>';

						$output .= '<div class="color-group"><input type="text" name="" value="" class="vc-color-control vc_color-control ivan-field" data-property="color-focus"></div>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Background Controls */
				if( array_key_exists('background-color', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Background', 'iv_js_composer') . '</label>';

						$output .= '<div class="color-group"><input type="text" name="background-color" value="" class="vc-color-control vc_color-control ivan-field" data-property="background-color"></div>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Background Hover */
				if( array_key_exists('background-color-hover', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Background Hover', 'iv_js_composer') . '</label>';

						$output .= '<div class="color-group"><input type="text" name="" value="" class="vc-color-control vc_color-control ivan-field" data-property="background-color-hover"></div>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Background Focus */
				if( array_key_exists('background-color-focus', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Background Focus', 'iv_js_composer') . '</label>';

						$output .= '<div class="color-group"><input type="text" name="" value="" class="vc-color-control vc_color-control ivan-field" data-property="background-color-focus"></div>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Spacing Controls */
				if( array_key_exists('margin-top', $fields)
					OR array_key_exists('padding-top', $fields) 
					) :
				$output .= '<div class="vc-settings">';

					if( array_key_exists('margin-top', $fields) ) :
					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Margin', 'iv_js_composer') . '</label>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="margin-top" placeholder="Top"><span class="small-label">Top</span>';
					$output .= '</div>';
					
					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="margin-bottom" placeholder="Bottom"><span class="small-label">Bottom</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="margin-left" placeholder="Left"><span class="small-label">Left</span>';
					$output .= '</div>';
					
					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="margin-right" placeholder="Right"><span class="small-label">Right</span>';
					$output .= '</div>';
					
					endif;

					if( array_key_exists('padding-top', $fields) ) :
					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Padding', 'iv_js_composer') . '</label>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="padding-top" placeholder="Top"><span class="small-label">Top</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="padding-bottom" placeholder="Bottom"><span class="small-label">Bottom</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="padding-left" placeholder="Left"><span class="small-label">Left</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="padding-right" placeholder="Right"><span class="small-label">Right</span>';
					$output .= '</div>';

					endif;		

				$output .= '</div>';
				endif;

				/* Border */
				if( array_key_exists('border-top-left-radius', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Border Radius', 'iv_js_composer') . '</label>';

					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-top-left-radius" placeholder="Top Left"><span class="small-label">Top Left</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-top-right-radius" placeholder="Top Right"><span class="small-label">Top Right</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-bottom-left-radius" placeholder="Bottom Left"><span class="small-label">Bottom Left</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-bottom-right-radius" placeholder="Bottom Right"><span class="small-label">Bottom Right</span>';
					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Border */
				if( array_key_exists('border-top-width', $fields) OR array_key_exists('border-style', $fields) OR array_key_exists('border-color', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Border Width / Color', 'iv_js_composer') . '</label>';

					$output .= '</div>';

					if( array_key_exists('border-top-width', $fields) ) :
					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-top-width" placeholder="Top"><span class="small-label">Top</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-bottom-width" placeholder="Bottom"><span class="small-label">Bottom</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-left-width" placeholder="Left"><span class="small-label">Left</span>';
					$output .= '</div>';

					$output .= '<div class="'. $colPrefix .'3">';
						$output .= '<input type="text" name="" value="" class="vc-spacing-control ivan-field" data-property="border-right-width" placeholder="Right"><span class="small-label">Right</span>';
					$output .= '</div>';
					endif;

					if( array_key_exists('border-color', $fields) ) :
					$output .= '<div class="'. $colPrefix .'6">';
						$output .= '<div class="color-group"><input type="text" name="" value="" class="vc-color-control vc_color-control ivan-field" data-property="border-color"></div>';
					$output .= '</div>';
					endif;

					if( array_key_exists('border-style', $fields) ) :
					$output .= '<div class="'. $colPrefix .'6">';
						$output .= '<select name="" class="vc-border-style-control ivan-field" data-property="border-style">
								<option value="">Style</option>
								<option value="solid">Solid</option>
								<option value="dotted">Dotted</option>
								<option value="dashed">Dashed</option>
								<option value="double">Double</option>
								<option value="none">None</option>
							</select>';
					$output .= '</div>';
					endif;

				$output .= '</div>';
				endif;

				/* Border Hover */
				if( array_key_exists('border-color-hover', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Border Color Hover', 'iv_js_composer') . '</label>';

						$output .= '<div class="color-group"><input type="text" name="" value="" class="vc-color-control vc_color-control ivan-field" data-property="border-color-hover"></div>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

				/* Border Hover */
				if( array_key_exists('border-color-focus', $fields) ) :
				$output .= '<div class="vc-settings">';

					$output .= '<div class="'. $colPrefix .'12">';

						$output .= '<label>' . __('Border Color Focus', 'iv_js_composer') . '</label>';

						$output .= '<div class="color-group"><input type="text" name="" value="" class="vc_color-control ivan-field" data-property="border-color-focus"></div>';

					$output .= '</div>';

				$output .= '</div>';
				endif;

			}

			// Hidden field to store Custom CSS
			$output .= '<input name="' . $this->setting('param_name') . '" class="wpb_vc_param_value  ' . $this->setting('param_name') . ' ' . $this->setting('type') . '_field" type="hidden" value="' . esc_attr($this->value()) . '"/>';

			$output .= '</div>';// Wrapper

			return apply_filters('vc_ivan_customizer', $output);
		}

		// Font/Color Customization
		function font_field() {

			return $output;
		}

		// Bg Customization
		function bg_field() {

			

			return $output;
		}

		// Spacing Customization
		function spacing_field() {

			

			return $output;
		}

		// Border Customization
		function border_field() {

			

			return $output;
		}

		// Color Hover
		function color_hover_field() {

			return $output;
		}

	} // #end class
} // #end if class

// Call form field
function ivan_vc_customizer_field($settings, $value) {
	$customizer_editor = new Ivan_VC_Customizer();
	$customizer_editor->settings($settings);
	$customizer_editor->value($value);
	return $customizer_editor->render();
}

// Generate style from array
function ivan_vc_customizer_get_style($cssByJS, &$selectors, $prefix, $keyName = '') {

	$cssByJS = explode(';', $cssByJS);
	$protocol = is_ssl() ? 'https://' : 'http://';

	$temp = array();
	foreach ($cssByJS as $line) {
		if('' != $line) {
			$line = explode(':', $line);
			if(isset( $line[1] ) ) // check to avoid notices and see if the format is the expected
				$temp[ $line[0] ] = $line[1];
		}
	}

	$style = '';

	if($keyName != '' && strpos($keyName,'mob_') !== false ) {
		$style .= '@media (max-width:480px){';
	}

	$previousSelector = '';
	foreach ($temp as $key => $value) {
		if( isset($selectors[$key]) ) {

			$selector = str_replace('&', ' ', $selectors[$key]); // allow select the wrapper itself ;D
			$selector = str_replace(',', ','.$prefix, $selector); // allow multiple selectors

			if($previousSelector != $selector) {
				if('' != $previousSelector)
					$style .= '}';
			}

			if($previousSelector != $selector) {
				$style .= $prefix . $selector . '{';
			}

				// If a font-family is the selector
				if($key == 'font-family') {
					// If it has the keyword gf- it's trying to enqueue a Google Font
					if (strpos($value,'gf-') !== false) {
						$fontName = str_replace('gf-', '', $value);
						$value = str_replace('gf-', '', $value);

						$nameToEnqueue = strtolower( str_replace(' ', '-', $fontName) );
						$googleName = str_replace(' ', '+', $fontName);
						
						wp_enqueue_style( 'iv-'.$nameToEnqueue.'-webfont', $protocol . 'fonts.googleapis.com/css?family='.$googleName.':400,300,500,700,100,200,900' . apply_filters('ivan_customizer_font_enqueue', ''), array(), '1' );
						//http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,100,900&subset=latin,cyrillic-ext
					}
				}

				$style .= str_replace(array('-hover', '-focus'), '', $key) . ':' . $value . ' !important;'; // Display the property
			
			$previousSelector = $selector;

		}
	}

	if('' != $style)
		$style .= '}'; // Last close tag

	if($keyName != '' && strpos($keyName,'mob_') !== false ) {
		$style .= '}';
	}

	return $style;
}

// List all registered image sizes
function ivan_vc_img_sizes(){
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach( get_intermediate_image_sizes() as $s ) {
		
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		} else {
			
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
		}
	}

	$opts = array();
	$opts['Image Size'] = '';
	$opts['Full'] = 'full';
	foreach( $sizes as $size => $atts ){
		//echo $size . ' ' . implode( 'x', $atts ) . "\n";
		$opts[$size . ' ' . implode( 'x', $atts )] = $size;
	}

	return $opts;
}	

// List all registered post formats
function ivan_vc_cpt(){
	$args = array(
		'_builtin' => false,
		'public' => true,
	);

	$output = 'objects'; // names or objects

	$post_types = get_post_types( $args, $output );

	$opts = array();
	$opts['Posts'] = 'post';

	foreach ( $post_types  as $post_type ) {

		$opts[$post_type->labels->name] = $post_type->name;
	}

	return $opts;
}	