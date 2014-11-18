<?php
/*
 * Widget Module Customization
 */

if( !class_exists('Ivan_VC_Widget') ) {
	class Ivan_VC_Widget {

		public $prefix = '';

		// Contructor
		public function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_custom_widget_shortcode_before', array($this, 'custom_output_before'), 15, 3 );

			add_filter( 'ivan_custom_widget_shortcode_after', array($this, 'custom_output_after'), 15, 3 );

		}

		// Shortcode
		public function custom_output_before($output, $atts, $content) {

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

			$output = '<div class="ivan-widget-area-wrap '. $prefixClass .'">';
			
			return $output;
		}

		// Shortcode
		public function custom_output_after($output, $atts, $content) {
			
			global $ivan_custom_css;

			$output = '</div>';

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
			'widget_css' => array(
				// Font
				//'font-family' => '.widget',
				//'font-weight' => '.widget',
				//'font-size' => 'li',
				//'line-height' => 'li',
				//'color' => '.widget',
				//'text-transform' => 'li',
				// Spacing
				'margin-top' => '.widget',
				'margin-right' => '.widget',
				'margin-bottom' => '.widget',
				'margin-left' => '.widget',
				'padding-top' => '.widget',
				'padding-right' => '.widget',
				'padding-bottom' => '.widget',
				'padding-left' => '.widget',
				// Bg
				'background-color' => '.widget',
				// Border
				'border-top-width' => '.widget',
				'border-right-width' => '.widget',
				'border-bottom-width' => '.widget',
				'border-left-width' => '.widget',
				'border-style' => '.widget',
				'border-color' => '.widget',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'title_css' => array(
				// Font
				'font-family' => '.widget-title',
				'font-weight' => '.widget-title',
				'font-size' => '.widget-title',
				'line-height' => '.widget-title',
				'color' => '.widget-title',
				'text-transform' => '.widget-title',
				// Spacing
				'margin-top' => '.widget-title',
				'margin-right' => '.widget-title',
				'margin-bottom' => '.widget-title',
				'margin-left' => '.widget-title',
				'padding-top' => '.widget-title',
				'padding-right' => '.widget-title',
				'padding-bottom' => '.widget-title',
				'padding-left' => '.widget-title',
				// Bg
				'background-color' => '.widget-title',
				// Border
				'border-top-width' => '.widget-title',
				'border-right-width' => '.widget-title',
				'border-bottom-width' => '.widget-title',
				'border-left-width' => '.widget-title',
				'border-style' => '.widget-title',
				'border-color' => '.widget-title',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'p_css' => array(
				// Font
				'font-family' => 'p, .widget',
				'font-weight' => 'p, .widget',
				'font-size' => 'p, .widget',
				'line-height' => 'p, .widget',
				'color' => 'p, .widget',
				// Spacing
				'margin-top' => 'p, .widget',
				'margin-right' => 'p, .widget',
				'margin-bottom' => 'p, .widget',
				'margin-left' => 'p, .widget',
				'padding-top' => 'p, .widget',
				'padding-right' => 'p, .widget',
				'padding-bottom' => 'p, .widget',
				'padding-left' => 'p, .widget',
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
			'label_css' => array(
				// Font
				'font-family' => 'label',
				'font-weight' => 'label',
				'font-size' => 'label',
				'line-height' => 'label',
				'text-transform' => 'label',
				'color' => 'label, .ninja-forms-req-symbol',
				// Spacing
				'margin-top' => 'label',
				'margin-right' => 'label',
				'margin-bottom' => 'label',
				'margin-left' => 'label',
				'padding-top' => 'label',
				'padding-right' => 'label',
				'padding-bottom' => 'label',
				'padding-left' => 'label',
				// Bg
				'background-color' => 'label',
				// Border Radius
				//'border-top-left-radius' => 'label',
				//'border-top-right-radius' => 'label',
				//'border-bottom-left-radius' => 'label',
				//'border-bottom-right-radius' => 'label',
				// Border
				//'border-top-width' => 'label',
				//'border-right-width' => 'label',
				//'border-bottom-width' => 'label',
				//'border-left-width' => 'label',
				//'border-style' => 'label',
				//'border-color' => 'label',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'input_css' => array(
				// Font
				'font-family' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'font-weight' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'font-size' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'line-height' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'text-transform' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'color' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				// Spacing
				'margin-top' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'margin-right' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'margin-bottom' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'margin-left' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'padding-top' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'padding-right' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'padding-bottom' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'padding-left' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				// Bg
				'background-color' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				// Border Radius
				'border-top-left-radius' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-top-right-radius' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-bottom-left-radius' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-bottom-right-radius' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				// Border
				'border-top-width' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-right-width' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-bottom-width' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-left-width' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-style' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				'border-color' => 'select,textarea,input[type="text"],input[type="number"],input[type="email"],input[type="url"],input[type="tel"],input[type="search"]',
				// Hovers
				'color-focus' => 'select:focus,textarea:focus,input[type="text"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="tel"]:focus,input[type="search"]:focus',
				'border-color-focus' => 'select:focus,textarea:focus,input[type="text"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="tel"]:focus,input[type="search"]:focus',
				'background-color-focus' => 'select:focus,textarea:focus,input[type="text"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="tel"]:focus,input[type="search"]:focus',
			),
			'submit_css' => array(
				// Font
				'font-family' => 'input[type="submit"]',
				'font-weight' => 'input[type="submit"]',
				'font-size' => 'input[type="submit"]',
				'line-height' => 'input[type="submit"]',
				'text-transform' => 'input[type="submit"]',
				'color' => 'input[type="submit"]',
				// Spacing
				'margin-top' => 'input[type="submit"]',
				'margin-right' => 'input[type="submit"]',
				'margin-bottom' => 'input[type="submit"]',
				'margin-left' => 'input[type="submit"]',
				'padding-top' => 'input[type="submit"]',
				'padding-right' => 'input[type="submit"]',
				'padding-bottom' => 'input[type="submit"]',
				'padding-left' => 'input[type="submit"]',
				// Bg
				'background-color' => 'input[type="submit"]',
				// Border Radius
				'border-top-left-radius' => 'input[type="submit"]',
				'border-top-right-radius' => 'input[type="submit"]',
				'border-bottom-left-radius' => 'input[type="submit"]',
				'border-bottom-right-radius' => 'input[type="submit"]',
				// Border
				'border-top-width' => 'input[type="submit"]',
				'border-right-width' => 'input[type="submit"]',
				'border-bottom-width' => 'input[type="submit"]',
				'border-left-width' => 'input[type="submit"]',
				'border-style' => 'input[type="submit"]',
				'border-color' => 'input[type="submit"]',
				// Hovers
				'color-hover' => 'input[type="submit"]:hover',
				'border-color-hover' => 'input[type="submit"]:hover',
				'background-color-hover' => 'input[type="submit"]:hover',
			),
		);

	} // #end class

	// Ignition!
	global $ivan_vc_widgets;

	$ivan_vc_widgets = new Ivan_VC_Widget();

	if ( !function_exists( 'vc_theme_before_vc_widget_sidebar' ) ) {
		function vc_theme_before_vc_widget_sidebar($atts, $content = null) {
			return apply_filters( 'ivan_custom_widget_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_widget_sidebar' ) ) {
		function vc_theme_after_vc_widget_sidebar($atts, $content = null) {
			return apply_filters( 'ivan_custom_widget_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check