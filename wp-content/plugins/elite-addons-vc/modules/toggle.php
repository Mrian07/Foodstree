<?php
/***
 * Extension > Toggle
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Toggle') && class_exists('WPBakeryShortCode') ) {
	class Ivan_VC_Toggle extends WPBakeryShortCode {

		public function __construct( $settings ) {
			parent::__construct( $settings );

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_toggle_shortcode_before', array($this, 'custom_output_before'), 10, 3 );

			add_filter( 'ivan_vc_toggle_shortcode', array($this, 'custom_output'), 12, 3 );

			add_filter( 'ivan_vc_toggle_shortcode_after', array($this, 'custom_output_after'), 15, 3 );
			
		}

		// Custom Output
		public function custom_output($output, $atts, $content) {
			$output = $title = $el_class = $open = $css_animation = '';
			extract(shortcode_atts(array(
			    'title' => __("Click to toggle", "js_composer"),
			    'el_class' => '',
			    'open' => 'false',
			    'css_animation' => '',
			    'style' => 'with_arrow'
			), $atts));

			// Define custom accordion class
			$toggle_class = "";
			switch( $style ) {
			    case "boxed":
			        $toggle_class .= "iv-toggle boxed ";
			        break;
			    case "boxed_arrow":
			        $toggle_class .= "iv-toggle boxed-arrow ";
			        break;
			    default:
			        $toggle_class = "iv-toggle with-arrow";
			}

			$el_class = $this->getExtraClass($el_class);
			$open = ( $open == 'true' ) ? ' wpb_toggle_title_active' : '';
			$el_class .= ( $open == ' wpb_toggle_title_active' ) ? ' wpb_toggle_open' : '';

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle ' . $toggle_class . $open, $this->settings['base'], $atts );
			$css_class .= $this->getCSSAnimation($css_animation);

			$boxed_arrow_markup = '';

			if( $style == 'boxed_arrow' )
				$boxed_arrow_markup = '<span class="toggle-mark right-mark"><span class="toggle-mark-icon"></span></span>';

			$output .= apply_filters('wpb_toggle_heading', 
				'<h4 class="'.$css_class.'"><span class="accordion-mark left-mark"><span class="accordion-mark-icon"></span></span><span class="tab-title">'.$title.$boxed_arrow_markup.'</span></h4>',
				 array('title'=>$title, 'open'=>$open));

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle_content '.$style.' ' . $el_class, $this->settings['base'], $atts );
			$output .= '<div class="'.$css_class.'">'.wpb_js_remove_wpautop($content, true).'</div>'.$this->endBlockComment('toggle')."\n";

			return $output;
		}

		// Before
		public function custom_output_before($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'template' => '',
			), $atts) );
			
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

			$output = '<div class="ivan-toggle-wrap '.$template. ' '. $prefixClass .'">';
			
			return $output;
		}

		// After
		public function custom_output_after($output, $atts, $content) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			/*
			extract( shortcode_atts( array(
				'row_width_style' => 'theme_default',
			), $atts) );
			*/

			$output = '';

			if(is_admin())
				$output .= '<div class="dummy_div_to_margin"></div>';

			$output .= '</div>';

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
			'toggle_css' => array(
				// Font
				'font-family' => '.wpb_toggle',
				'font-weight' => '.wpb_toggle',
				'font-size' => '.wpb_toggle',
				'line-height' => '.wpb_toggle',
				'text-transform' => '.wpb_toggle',
				'color' => '.wpb_toggle',
				// Spacing
				'margin-top' => '.wpb_toggle',
				'margin-right' => '.wpb_toggle',
				'margin-bottom' => '.wpb_toggle',
				'margin-left' => '.wpb_toggle',
				'padding-top' => '.wpb_toggle',
				'padding-right' => '.wpb_toggle',
				'padding-bottom' => '.wpb_toggle',
				'padding-left' => '.wpb_toggle',
				// Bg
				'background-color' => '.wpb_toggle',
				// Border Radius
				'border-top-left-radius' => '.wpb_toggle',
				'border-top-right-radius' => '.wpb_toggle',
				'border-bottom-left-radius' => '.wpb_toggle',
				'border-bottom-right-radius' => '.wpb_toggle',
				// Border
				'border-top-width' => '.wpb_toggle',
				'border-right-width' => '.wpb_toggle',
				'border-bottom-width' => '.wpb_toggle',
				'border-left-width' => '.wpb_toggle',
				'border-style' => '.wpb_toggle',
				'border-color' => '.wpb_toggle',
				// Hovers
				'color-hover' => '.wpb_toggle_title_active',
				'border-color-hover' => '.wpb_toggle_title_active',
				'background-color-hover' => '.wpb_toggle_title_active',
			),
			'mark_css' => array(
				// Font
				//'font-family' => '.wpb_accordion_header a',
				//'font-weight' => '.wpb_accordion_header a',
				//'font-size' => '.accordion-mark-icon',
				//'line-height' => '.wpb_accordion_header a',
				//'text-transform' => '.wpb_accordion_header a',
				'color' => '.accordion-mark-icon',
				// Spacing
				//'margin-top' => '.wpb_accordion_header',
				//'margin-right' => '.wpb_accordion_header a',
				//'margin-bottom' => '.wpb_accordion_header',
				//'margin-left' => '.wpb_accordion_header a',
				//'padding-top' => '.wpb_accordion_header a',
				//'padding-right' => '.wpb_accordion_header a',
				//'padding-bottom' => '.wpb_accordion_header a',
				//'padding-left' => '.wpb_accordion_header a',
				// Bg
				'background-color' => '.accordion-mark',
				// Border Radius
				'border-top-left-radius' => '.accordion-mark',
				'border-top-right-radius' => '.accordion-mark',
				'border-bottom-left-radius' => '.accordion-mark',
				'border-bottom-right-radius' => '.accordion-mark',
				// Border
				'border-top-width' => '.accordion-mark',
				'border-right-width' => '.accordion-mark',
				'border-bottom-width' => '.accordion-mark',
				'border-left-width' => '.accordion-mark',
				'border-style' => '.accordion-mark',
				'border-color' => '.accordion-mark',
				// Hovers
				'color-hover' => '.wpb_toggle_title_active .accordion-mark-icon',
				'border-color-hover' => '.wpb_toggle_title_active .accordion-mark',
				'background-color-hover' => '.wpb_toggle_title_active .accordion-mark',
			),
			'content_css' => array(
				// Font
				'font-family' => '.wpb_toggle_content',
				'font-weight' => '.wpb_toggle_content',
				'font-size' => '.wpb_toggle_content',
				'line-height' => '.wpb_toggle_content',
				'text-transform' => '.wpb_toggle_content',
				'color' => '.wpb_toggle_content h1, .wpb_toggle_content h2, .wpb_toggle_content h3, 
					.wpb_toggle_content h4, .wpb_toggle_content p, .wpb_toggle_content a, .wpb_toggle_content li',
				// Spacing
				'margin-top' => '.wpb_toggle_content',
				'margin-right' => '.wpb_toggle_content',
				'margin-bottom' => '.wpb_toggle_content',
				'margin-left' => '.wpb_toggle_content',
				'padding-top' => '.wpb_toggle_content',
				'padding-right' => '.wpb_toggle_content',
				'padding-bottom' => '.wpb_toggle_content',
				'padding-left' => '.wpb_toggle_content',
				// Bg
				'background-color' => '.wpb_toggle_content',
				// Border Radius
				'border-top-left-radius' => '.wpb_toggle_content',
				'border-top-right-radius' => '.wpb_toggle_content',
				'border-bottom-left-radius' => '.wpb_toggle_content',
				'border-bottom-right-radius' => '.wpb_toggle_content',
				// Border
				'border-top-width' => '.wpb_toggle_content',
				'border-right-width' => '.wpb_toggle_content',
				'border-bottom-width' => '.wpb_toggle_content',
				'border-left-width' => '.wpb_toggle_content',
				'border-style' => '.wpb_toggle_content',
				'border-color' => '.wpb_toggle_content',
				// Hovers
				'color-hover' => '.wpb_toggle_content a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			/*
			'toggle_css' => array(
				// Font
				'font-family' => '.wpb_toggle',
				'font-weight' => '.wpb_toggle',
				'font-size' => '.wpb_toggle',
				'line-height' => '.wpb_toggle',
				'text-transform' => '.wpb_toggle',
				'color' => '.wpb_toggle',
				// Spacing
				'margin-top' => '.wpb_toggle',
				'margin-right' => '.wpb_toggle',
				'margin-bottom' => '.wpb_toggle',
				'margin-left' => '.wpb_toggle',
				'padding-top' => '.wpb_toggle',
				'padding-right' => '.wpb_toggle',
				'padding-bottom' => '.wpb_toggle',
				'padding-left' => '.wpb_toggle',
				// Bg
				'background-color' => '.wpb_toggle',
				// Border Radius
				'border-top-left-radius' => '.wpb_toggle',
				'border-top-right-radius' => '.wpb_toggle',
				'border-bottom-left-radius' => '.wpb_toggle',
				'border-bottom-right-radius' => '.wpb_toggle',
				// Border
				'border-top-width' => '.wpb_toggle',
				'border-right-width' => '.wpb_toggle',
				'border-bottom-width' => '.wpb_toggle',
				'border-left-width' => '.wpb_toggle',
				'border-style' => '.wpb_toggle',
				'border-color' => '.wpb_toggle',
				// Hovers
				'color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				'border-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				'background-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
			),
			'content_css' => array(
				// Font
				//'font-family' => 'p',
				//'font-weight' => 'p',
				//'font-size' => 'h4',
				//'line-height' => 'p',
				//'text-transform' => 'p',
				'color' => '.wpb_toggle_content h1, .wpb_toggle_content h2, .wpb_toggle_content h3, .wpb_toggle_content h4, .wpb_toggle_content p, .wpb_toggle_content a, .wpb_toggle_content li',
				// Spacing
				'margin-top' => '.wpb_toggle_content',
				'margin-right' => '.wpb_toggle_content',
				'margin-bottom' => '.wpb_toggle_content',
				'margin-left' => '.wpb_toggle_content',
				'padding-top' => '.wpb_toggle_content',
				'padding-right' => '.wpb_toggle_content',
				'padding-bottom' => '.wpb_toggle_content',
				'padding-left' => '.wpb_toggle_content',
				// Bg
				'background-color' => '.wpb_toggle_content',
				// Border Radius
				'border-top-left-radius' => '.wpb_toggle_content',
				'border-top-right-radius' => '.wpb_toggle_content',
				'border-bottom-left-radius' => '.wpb_toggle_content',
				'border-bottom-right-radius' => '.wpb_toggle_content',
				// Border
				'border-top-width' => '.wpb_toggle_content',
				'border-right-width' => '.wpb_toggle_content',
				'border-bottom-width' => '.wpb_toggle_content',
				'border-left-width' => '.wpb_toggle_content',
				'border-style' => '.wpb_toggle_content',
				'border-color' => '.wpb_toggle_content',
				// Hovers
				'color-hover' => '.wpb_toggle_content a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			*/
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_toggle;
	$ivan_vc_toggle = new Ivan_VC_Toggle( array( 'base' => 'vc_toggle' ) );

	if ( !function_exists( 'vc_theme_before_vc_toggle' ) ) {
		function vc_theme_before_vc_toggle($atts, $content = null) {
			return apply_filters( 'ivan_vc_toggle_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_vc_toggle' ) ) {
		function vc_theme_vc_toggle($atts, $content = null) {
			return apply_filters( 'ivan_vc_toggle_shortcode', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_toggle' ) ) {
		function vc_theme_after_vc_toggle($atts, $content = null) {
			return apply_filters( 'ivan_vc_toggle_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check