<?php
/*
 * Text Module Customization
 */

if( !class_exists('Ivan_VC_Text') ) {
	class Ivan_VC_Text {

		public $prefix = '';

		// Contructor
		public function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_custom_text_shortcode_before', array($this, 'shortcode_before'), 15, 3 );

			// Apply filter to component class name
			add_filter( 'vc_shortcodes_css_class', array($this, 'custom_class'), 15, 2 );

		}

		public function custom_class($classes, $base) {
			if( 'vc_column_text' == $base ) {
				$classes .= ' ' . str_replace('.', '', $this->prefix);
			}

			return $classes;
		}

		// Shortcode
		public function shortcode_before($output, $atts, $content) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			//extract( shortcode_atts( array(
			//), $atts) );

			$output = '';

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
			
			return $output;
		}

		// H1 Selectors
		public $selectors = array(
			'h1_css' => array(
				// Font
				'font-family' => 'h1',
				'font-weight' => 'h1',
				'font-size' => 'h1',
				'line-height' => 'h1',
				'color' => 'h1',
				'text-transform' => 'h1',
				// Spacing
				'margin-top' => 'h1',
				'margin-right' => 'h1',
				'margin-bottom' => 'h1',
				'margin-left' => 'h1',
				'padding-top' => 'h1',
				'padding-right' => 'h1',
				'padding-bottom' => 'h1',
				'padding-left' => 'h1',
				// Bg
				'background-color' => 'h1',
				// Border
				'border-top-width' => 'h1',
				'border-right-width' => 'h1',
				'border-bottom-width' => 'h1',
				'border-left-width' => 'h1',
				'border-style' => 'h1',
				'border-color' => 'h1',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h2_css' => array(
				// Font
				'font-family' => 'h2',
				'font-weight' => 'h2',
				'font-size' => 'h2',
				'line-height' => 'h2',
				'color' => 'h2',
				'text-transform' => 'h2',
				// Spacing
				'margin-top' => 'h2',
				'margin-right' => 'h2',
				'margin-bottom' => 'h2',
				'margin-left' => 'h2',
				'padding-top' => 'h2',
				'padding-right' => 'h2',
				'padding-bottom' => 'h2',
				'padding-left' => 'h2',
				// Bg
				'background-color' => 'h2',
				// Border
				'border-top-width' => 'h2',
				'border-right-width' => 'h2',
				'border-bottom-width' => 'h2',
				'border-left-width' => 'h2',
				'border-style' => 'h2',
				'border-color' => 'h2',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h3_css' => array(
				// Font
				'font-family' => 'h3',
				'font-weight' => 'h3',
				'font-size' => 'h3',
				'line-height' => 'h3',
				'color' => 'h3',
				'text-transform' => 'h3',
				// Spacing
				'margin-top' => 'h3',
				'margin-right' => 'h3',
				'margin-bottom' => 'h3',
				'margin-left' => 'h3',
				'padding-top' => 'h3',
				'padding-right' => 'h3',
				'padding-bottom' => 'h3',
				'padding-left' => 'h3',
				// Bg
				'background-color' => 'h3',
				// Border
				'border-top-width' => 'h3',
				'border-right-width' => 'h3',
				'border-bottom-width' => 'h3',
				'border-left-width' => 'h3',
				'border-style' => 'h3',
				'border-color' => 'h3',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h4_css' => array(
				// Font
				'font-family' => 'h4',
				'font-weight' => 'h4',
				'font-size' => 'h4',
				'line-height' => 'h4',
				'color' => 'h4',
				'text-transform' => 'h4',
				// Spacing
				'margin-top' => 'h4',
				'margin-right' => 'h4',
				'margin-bottom' => 'h4',
				'margin-left' => 'h4',
				'padding-top' => 'h4',
				'padding-right' => 'h4',
				'padding-bottom' => 'h4',
				'padding-left' => 'h4',
				// Bg
				'background-color' => 'h4',
				// Border
				'border-top-width' => 'h4',
				'border-right-width' => 'h4',
				'border-bottom-width' => 'h4',
				'border-left-width' => 'h4',
				'border-style' => 'h4',
				'border-color' => 'h4',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h5_css' => array(
				// Font
				'font-family' => 'h5',
				'font-weight' => 'h5',
				'font-size' => 'h5',
				'line-height' => 'h5',
				'color' => 'h5',
				'text-transform' => 'h5',
				// Spacing
				'margin-top' => 'h5',
				'margin-right' => 'h5',
				'margin-bottom' => 'h5',
				'margin-left' => 'h5',
				'padding-top' => 'h5',
				'padding-right' => 'h5',
				'padding-bottom' => 'h5',
				'padding-left' => 'h5',
				// Bg
				'background-color' => 'h5',
				// Border
				'border-top-width' => 'h5',
				'border-right-width' => 'h5',
				'border-bottom-width' => 'h5',
				'border-left-width' => 'h5',
				'border-style' => 'h5',
				'border-color' => 'h5',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h6_css' => array(
				// Font
				'font-family' => 'h6',
				'font-weight' => 'h6',
				'font-size' => 'h6',
				'line-height' => 'h6',
				'color' => 'h6',
				'text-transform' => 'h6',
				// Spacing
				'margin-top' => 'h6',
				'margin-right' => 'h6',
				'margin-bottom' => 'h6',
				'margin-left' => 'h6',
				'padding-top' => 'h6',
				'padding-right' => 'h6',
				'padding-bottom' => 'h6',
				'padding-left' => 'h6',
				// Bg
				'background-color' => 'h6',
				// Border
				'border-top-width' => 'h6',
				'border-right-width' => 'h6',
				'border-bottom-width' => 'h6',
				'border-left-width' => 'h6',
				'border-style' => 'h6',
				'border-color' => 'h6',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'p_css' => array(
				// Font
				'font-family' => 'p',
				'font-weight' => 'p',
				'font-size' => 'p',
				'line-height' => 'p',
				'color' => 'p',
				// Spacing
				'margin-top' => 'p',
				'margin-right' => 'p',
				'margin-bottom' => 'p',
				'margin-left' => 'p',
				'padding-top' => 'p',
				'padding-right' => 'p',
				'padding-bottom' => 'p',
				'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border
				//'border-top-width' => 'p',
				//'border-right-width' => 'p',
				//'border-bottom-width' => 'p',
				//'border-left-width' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'link_css' => array(
				// Font
				'font-family' => 'a',
				'font-weight' => 'a',
				'font-size' => 'a',
				'line-height' => 'a',
				'color' => 'a',
				// Spacing
				//'margin-top' => 'p',
				//'margin-right' => 'p',
				//'margin-bottom' => 'p',
				//'margin-left' => 'p',
				//'padding-top' => 'p',
				//'padding-right' => 'p',
				//'padding-bottom' => 'p',
				//'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border
				//'border-top-width' => 'p',
				//'border-right-width' => 'p',
				//'border-bottom-width' => 'p',
				//'border-left-width' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'list_css' => array(
				// Font
				'font-family' => 'li',
				'font-weight' => 'li',
				'font-size' => 'li',
				'line-height' => 'li',
				'color' => 'ul, ol, li',
				'text-transform' => 'li',
				// Spacing
				'margin-top' => 'li',
				'margin-right' => 'li',
				'margin-bottom' => 'li',
				'margin-left' => 'li',
				'padding-top' => 'p',
				'padding-right' => 'p',
				'padding-bottom' => 'p',
				'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border
				//'border-top-width' => 'p',
				//'border-right-width' => 'p',
				//'border-bottom-width' => 'p',
				//'border-left-width' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
		);

	} // #end class

	// Ignition!
	global $ivan_vc_text;
	$ivan_vc_text = new Ivan_VC_Text();

	if ( !function_exists( 'vc_theme_before_vc_column_text' ) ) {
		function vc_theme_before_vc_column_text($atts, $content = null) {
			return apply_filters( 'ivan_custom_text_shortcode_before', '', $atts, $content );
		}
	}

} // #end class check