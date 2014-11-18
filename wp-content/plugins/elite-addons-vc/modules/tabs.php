<?php
/***
 * Extension > Tabs
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Tabs') && class_exists('WPBakeryShortCode') ) {
	class Ivan_VC_Tabs extends WPBakeryShortCode {

		public function __construct( $settings ) {
			parent::__construct( $settings );

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_tabs_shortcode_before', array($this, 'custom_output_before'), 10, 3 );

			add_filter( 'ivan_vc_tabs_shortcode', array($this, 'custom_output'), 12, 3 );

			add_filter( 'ivan_vc_tabs_shortcode_after', array($this, 'custom_output_after'), 15, 3 );

			//if(is_admin())
				add_filter('vc_shortcode_output', array($this, 'shortcode_admin'), 10, 2);
			
		}

		// Admin Output Wrappers
		public function shortcode_admin($output, $obj) {
			
			if('WPBakeryShortCode_VC_Tabs' == get_class($obj) ) {

				$atts = $obj->atts;
				
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

				$output = str_replace('wpb_tabs wpb_content_element', 'wpb_tabs wpb_content_element ivan-tabs-wrap ' . $prefixClass, $output);
			}
			
			return $output;
		}

		// Output
		public function custom_output($output, $atts, $content) {
			$output = $title = $interval = $el_class = '';
			extract( shortcode_atts( array(
				'title' => '',
				'interval' => 0,
				'el_class' => '',
				'style' => 'h_left',
			), $atts ) );

			wp_enqueue_script( 'jquery-ui-tabs' );

			$el_class = $this->getExtraClass( $el_class );

			$element = 'wpb_tabs';
			if ( 'vc_tour' == $this->shortcode ) $element = 'wpb_tour';

			// Extract tab titles
			preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
			$tab_titles = array();
			/**
			 * vc_tabs
			 *
			 */
			if ( isset( $matches[1] ) ) {
				$tab_titles = $matches[1];
			}
			$tabs_nav = '';
			$tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix">';
			foreach ( $tab_titles as $tab ) {
				$tab_atts = shortcode_parse_atts($tab[0]);
				if(isset($tab_atts['title'])) {
					$tabs_nav .= '<li><a href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '">' . $tab_atts['title'] . '</a></li>';
				}
			}
			$tabs_nav .= '</ul>' . "\n";

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' . $el_class ), $this->settings['base'], $atts );

			$style_class = '';

			switch($style) {
			    case 'boxed':
			        $style_class = 'iv-boxed';
			        break;
			    case 'v_left':
			        $style_class = 'iv-vertical left';
			        break;
			    case 'v_right':
			        $style_class = 'iv-vertical right';
			        break;
			    case 'h_center':
			        $style_class = 'iv-horizontal center';
			        break;
			    case 'h_left':
			        $style_class = 'iv-horizontal left';
			        break;
			    case 'h_right':
			        $style_class = 'iv-horizontal right';
			        break;
			}

			$output .= "\n\t" . '<div class="' . $css_class . '" data-interval="' . $interval . '">';
			$output .= "\n\t\t" . '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix iv-tabs ' . $style_class .'">';
			$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => $element . '_heading' ) );
			$output .= "\n\t\t\t" . $tabs_nav;
			$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
			if ( 'vc_tour' == $this->shortcode ) {
				$output .= "\n\t\t\t" . '<div class="wpb_tour_next_prev_nav vc_clearfix"> <span class="wpb_prev_slide"><a href="#prev" title="' . __( 'Previous tab', 'js_composer' ) . '">' . __( 'Previous tab', 'js_composer' ) . '</a></span> <span class="wpb_next_slide"><a href="#next" title="' . __( 'Next tab', 'js_composer' ) . '">' . __( 'Next tab', 'js_composer' ) . '</a></span></div>';
			}
			$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
			$output .= "\n\t" . '</div> ' . $this->endBlockComment( $element );

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

			$output = '';

			if(!is_admin())
				$output = '<div class="ivan-tabs-wrap '. $template . ' ' . $prefixClass .'">';
			
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

			if(!is_admin())
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
			'tabs_css' => array(
				// Font
				'font-family' => '.wpb_tabs_nav a',
				'font-weight' => '.wpb_tabs_nav a',
				'font-size' => '.wpb_tabs_nav a',
				'line-height' => '.wpb_tabs_nav a',
				'text-transform' => '.wpb_tabs_nav a',
				'color' => '.wpb_tabs_nav a',
				// Spacing
				'margin-top' => '.wpb_tabs_nav',
				'margin-right' => '.wpb_tabs_nav li',
				'margin-bottom' => '.wpb_tabs_nav',
				'margin-left' => '.wpb_tabs_nav li',
				'padding-top' => '.wpb_tabs_nav a',
				'padding-right' => '.wpb_tabs_nav a',
				'padding-bottom' => '.wpb_tabs_nav a',
				'padding-left' => '.wpb_tabs_nav a',
				// Bg
				'background-color' => '.wpb_tabs_nav li, .wpb_tabs_nav a',
				// Border Radius
				'border-top-left-radius' => '.wpb_tabs_nav a',
				'border-top-right-radius' => '.wpb_tabs_nav a',
				'border-bottom-left-radius' => '.wpb_tabs_nav a',
				'border-bottom-right-radius' => '.wpb_tabs_nav a',
				// Border
				'border-top-width' => '.wpb_tabs_nav a',
				'border-right-width' => '.wpb_tabs_nav a',
				'border-bottom-width' => '.wpb_tabs_nav a',
				'border-left-width' => '.wpb_tabs_nav a',
				'border-style' => '.wpb_tabs_nav a',
				'border-color' => '.wpb_tabs_nav a',
				// Hovers
				'color-hover' => '.wpb_tabs_nav li.ui-tabs-active a, .wpb_tabs_nav li.ui-tabs-active',
				'border-color-hover' => '.wpb_tabs_nav li.ui-tabs-active a',
				'background-color-hover' => '.wpb_tabs_nav li.ui-tabs-active a, .wpb_tabs_nav li.ui-tabs-active a:after',
			),
			'content_css' => array(
				// Font
				//'font-family' => 'p',
				//'font-weight' => 'p',
				//'font-size' => 'h4',
				//'line-height' => 'p',
				//'text-transform' => 'p',
				//'color' => '.wpb_toggle_content h1, .wpb_toggle_content h2, .wpb_toggle_content h3, .wpb_toggle_content h4, .wpb_toggle_content p, .wpb_toggle_content a, .wpb_toggle_content li',
				// Spacing
				'margin-top' => '.wpb_tab',
				'margin-right' => '.wpb_tab',
				'margin-bottom' => '.wpb_tab',
				'margin-left' => '.wpb_tab',
				'padding-top' => '.wpb_tab',
				'padding-right' => '.wpb_tab',
				'padding-bottom' => '.wpb_tab',
				'padding-left' => '.wpb_tab',
				// Bg
				'background-color' => '.wpb_tab',
				// Border Radius
				'border-top-left-radius' => '.wpb_tab',
				'border-top-right-radius' => '.wpb_tab',
				'border-bottom-left-radius' => '.wpb_tab',
				'border-bottom-right-radius' => '.wpb_tab',
				// Border
				'border-top-width' => '.wpb_tab',
				'border-right-width' => '.wpb_tab',
				'border-bottom-width' => '.wpb_tab',
				'border-left-width' => '.wpb_tab',
				'border-style' => '.wpb_tab',
				'border-color' => '.wpb_tab',
				// Hovers
				//'color-hover' => '.wpb_toggle_content a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),	
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_tabs;
	$ivan_vc_tabs = new Ivan_VC_Tabs( array( 'base' => 'vc_tabs' ) );

	if ( !function_exists( 'vc_theme_before_vc_tabs' ) ) {
		function vc_theme_before_vc_tabs($atts, $content = null) {
			return apply_filters( 'ivan_vc_tabs_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_vc_tabs' ) ) {
		function vc_theme_vc_tabs($atts, $content = null) {
			return apply_filters( 'ivan_vc_tabs_shortcode', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_tabs' ) ) {
		function vc_theme_after_vc_tabs($atts, $content = null) {
			return apply_filters( 'ivan_vc_tabs_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check