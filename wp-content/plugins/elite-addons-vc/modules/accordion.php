<?php
/***
 * Extension > Accordion
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Accordion') && class_exists('WPBakeryShortCode') ) {
	class Ivan_VC_Accordion extends WPBakeryShortCode {

		public function __construct( $settings ) {
			parent::__construct( $settings );

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_accordion_shortcode_before', array($this, 'custom_output_before'), 10, 3 );

			add_filter( 'ivan_vc_accordion_shortcode', array($this, 'custom_output'), 12, 3 );

			add_filter( 'ivan_vc_accordion_shortcode_after', array($this, 'custom_output_after'), 15, 3 );
			
		}

		// Custom Output
		public function custom_output($output, $atts, $content) {
			wp_enqueue_script('jquery-ui-accordion');
			$output = $title = $interval = $el_class = $collapsible = $active_tab = '';
			//
			extract(shortcode_atts(array(
			    'title' => '',
			    'interval' => 0,
			    'el_class' => '',
			    'collapsible' => 'no',
			    'active_tab' => '1',
			    'style' => 'accordion',
			), $atts));

			// Define custom accordion class
			$accordion_class = "";
			switch( $style ) {
			    case "boxed_accordion":
			        $accordion_class .= "iv-accordion boxed ";
			        break;
			    case "boxed_arrow":
			        $accordion_class .= "iv-accordion with-arrow ";
			        break;
			    default:
			        $accordion_class = "iv-accordion with-toggle";
			}

			$el_class = $this->getExtraClass($el_class);
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion ivan_acc_holder wpb_content_element ' . $accordion_class . $el_class . ' not-column-inherit', $this->settings['base'], $atts );

			$output .= "\n\t".'<div class="'.$css_class.'" data-collapsible='.$collapsible.' data-active-tab="'.$active_tab.'">'; //data-interval="'.$interval.'"
			$output .= "\n\t\t".'<div class="wpb_wrapper wpb_accordion_wrapper ui-accordion">';
			$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_accordion_heading'));

			$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
			$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
			$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_accordion');

			return $output;
		}

		// Before Shortcode
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

			$output = '<div class="ivan-accordion-wrap '.$template. ' '. $prefixClass .'">';
			
			return $output;
		}

		// After Shortcode
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
				'font-family' => '.wpb_accordion_header',
				'font-weight' => '.wpb_accordion_header',
				'font-size' => '.wpb_accordion_header',
				'line-height' => '.wpb_accordion_header',
				'text-transform' => '.wpb_accordion_header',
				'color' => '.wpb_accordion_header, .wpb_accordion_header a',
				// Spacing
				'margin-top' => '.wpb_accordion_header',
				'margin-right' => '.wpb_accordion_header',
				'margin-bottom' => '.wpb_accordion_header',
				'margin-left' => '.wpb_accordion_header',
				'padding-top' => '.wpb_accordion_header',
				'padding-right' => '.wpb_accordion_header',
				'padding-bottom' => '.wpb_accordion_header',
				'padding-left' => '.wpb_accordion_header',
				// Bg
				'background-color' => '.wpb_accordion_header',
				// Border Radius
				'border-top-left-radius' => '.wpb_accordion_header',
				'border-top-right-radius' => '.wpb_accordion_header',
				'border-bottom-left-radius' => '.wpb_accordion_header',
				'border-bottom-right-radius' => '.wpb_accordion_header',
				// Border
				'border-top-width' => '.wpb_accordion_header',
				'border-right-width' => '.wpb_accordion_header',
				'border-bottom-width' => '.wpb_accordion_header',
				'border-left-width' => '.wpb_accordion_header',
				'border-style' => '.wpb_accordion_header',
				'border-color' => '.wpb_accordion_header',
				// Hovers
				'color-hover' => '.ui-accordion-header-active a',
				'border-color-hover' => '.ui-accordion-header-active',
				'background-color-hover' => '.ui-accordion-header-active',
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
				'color-hover' => '.ui-state-active .accordion-mark-icon',
				'border-color-hover' => '.ui-state-active .accordion-mark',
				'background-color-hover' => '.ui-state-active .accordion-mark',
			),
			'content_css' => array(
				// Font
				'font-family' => '.wpb_accordion_content',
				'font-weight' => '.wpb_accordion_content',
				'font-size' => '.wpb_accordion_content',
				'line-height' => '.wpb_accordion_content',
				'text-transform' => '.wpb_accordion_content',
				'color' => '.wpb_accordion_content h1, .wpb_accordion_content h2, .wpb_accordion_content h3, 
					.wpb_accordion_content h4, .wpb_accordion_content p, .wpb_accordion_content a, .wpb_accordion_content li',
				// Spacing
				'margin-top' => '.wpb_accordion_content',
				'margin-right' => '.wpb_accordion_content',
				'margin-bottom' => '.wpb_accordion_content',
				'margin-left' => '.wpb_accordion_content',
				'padding-top' => '.wpb_accordion_content',
				'padding-right' => '.wpb_accordion_content',
				'padding-bottom' => '.wpb_accordion_content',
				'padding-left' => '.wpb_accordion_content',
				// Bg
				'background-color' => '.wpb_accordion_content',
				// Border Radius
				'border-top-left-radius' => '.wpb_accordion_content',
				'border-top-right-radius' => '.wpb_accordion_content',
				'border-bottom-left-radius' => '.wpb_accordion_content',
				'border-bottom-right-radius' => '.wpb_accordion_content',
				// Border
				'border-top-width' => '.wpb_accordion_content',
				'border-right-width' => '.wpb_accordion_content',
				'border-bottom-width' => '.wpb_accordion_content',
				'border-left-width' => '.wpb_accordion_content',
				'border-style' => '.wpb_accordion_content',
				'border-color' => '.wpb_accordion_content',
				// Hovers
				'color-hover' => '.wpb_accordion_content a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),	
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_accordion;
	$ivan_vc_accordion = new Ivan_VC_Accordion( array( 'base' => 'vc_accordion' ) );

	if ( !function_exists( 'vc_theme_before_vc_accordion' ) ) {
		function vc_theme_before_vc_accordion($atts, $content = null) {
			return apply_filters( 'ivan_vc_accordion_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_vc_accordion' ) ) {
		function vc_theme_vc_accordion($atts, $content = null) {
			return apply_filters( 'ivan_vc_accordion_shortcode', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_accordion' ) ) {
		function vc_theme_after_vc_accordion($atts, $content = null) {
			return apply_filters( 'ivan_vc_accordion_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check

/***
 * Extension > Accordion Tab
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Accordion_Tab') && class_exists('WPBakeryShortCode') ) {

	class Ivan_VC_Accordion_Tab extends WPBakeryShortCode {

		public function __construct( $settings ) {
			parent::__construct( $settings );

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_accordion_tab_shortcode', array($this, 'custom_output'), 12, 3 );
		}

		public function custom_output($output, $atts, $content) {
			$output = $title = '';

			extract(shortcode_atts(array(
				'title' => __("Section", "js_composer")
			), $atts));

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings['base'], $atts );
			$output .= "\n\t\t\t" . '<div class="'.$css_class.'">';

			    $output .= "\n\t\t\t\t" . '<h3 class="wpb_accordion_header ui-accordion-header"><a href="#'.sanitize_title($title).'">';
			    	$output .= '<span class="accordion-mark left-mark"><span class="accordion-mark-icon"></span></span>';
			    		$output .= '<span class="tab-title">'.$title.'</span>';
			    	//$output .= '<span class="accordion-mark right-mark"><span class="accordion-mark-icon"></span></span>';
			    $output .=  '</a></h3>';

			    $output .= "\n\t\t\t\t" . '<div class="wpb_accordion_content ui-accordion-content vc_clearfix">';
			        $output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
			        $output .= "\n\t\t\t\t" . '</div>';
			    $output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_accordion_section') . "\n";

			return $output;
		}

	} // #end class

	// Ignition!
	$ivan_vc_accordion_tab = new Ivan_VC_Accordion_Tab( array( 'base' => 'vc_accordion_tab' ) );

	if ( !function_exists( 'vc_theme_vc_accordion_tab' ) ) {
		function vc_theme_vc_accordion_tab($atts, $content = null) {
			return apply_filters( 'ivan_vc_accordion_tab_shortcode', '', $atts, $content );
		}
	}

} // #end class check