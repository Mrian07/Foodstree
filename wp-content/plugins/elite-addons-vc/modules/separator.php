<?php
/***
 * Extension > Separator
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Separator') && class_exists('WPBakeryShortCode') ) {

	class Ivan_VC_Separator extends WPBakeryShortCode {

		public function __construct( $settings ) {
			parent::__construct( $settings );

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_separator_shortcode', array($this, 'custom_output'), 12, 3 );
		}

		public function custom_output($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'el_class'				=> '',
				'template' 				=> '',
			    'type' 					=> '',
			    'position' 				=> '',
			    'color' 				=> '',
				'opacity' 				=> '',
			    'thickness' 			=> '',
			    'width' 				=> '',
			    'up' 					=> '',
			    'down' 					=> '',
			), $atts) );

			$classes = 'vc_separator wpb_content_element';
			$styles = '';
			$output = '';

			$classes .= $this->getExtraClass($el_class);

			$classes .= ' ' . $type;
			$classes .= ' ' . $position;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Styles...

			if($up != '') {
				$styles .= 'margin-top: '.ivan_style_val( $up ).';';
			}

			if($down != '') {
				$styles .= 'margin-bottom: '.ivan_style_val( $down ).';';
			}

			if($color != '') {
				$styles .= 'background-color: '.$color.';';
			}

			if($opacity !== '') {
				$styles .= 'opacity: '.$opacity.';';
			}

			if($thickness != '') {
				$styles .= 'height: '.ivan_style_val( $thickness ).';';
			}

			if($width != '') {
				$styles .= 'width: '.ivan_style_val( $width ).';';
			}

			// Filter classes to output...
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $classes, $this->settings['base'], $atts );

			$output .= '<div class="ivan-vc-separator '.esc_attr(trim( $css_class )).'" style="'.esc_attr(trim( $styles )).'">';
			$output .= '</div>'."\n";

			return $output;
		}

	} // #end class

	// Ignition!
	global $ivan_vc_separator;
	$ivan_vc_separator = new Ivan_VC_Separator( array( 'base' => 'vc_separator' ) );

	if ( !function_exists( 'vc_theme_vc_separator' ) ) {
		function vc_theme_vc_separator($atts, $content = null) {
			return apply_filters( 'ivan_vc_separator_shortcode', '', $atts, $content );
		}
	}

} // #end class check