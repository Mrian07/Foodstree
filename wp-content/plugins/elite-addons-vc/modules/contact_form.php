<?php
/***
 * Module > Contact Form
 *
 * This module extends default VC class,  turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_contact extends WPBakeryShortCode {

		protected function content( $atts,  $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'el_class' => '', 
				'template' => '', 
			),  $atts) );

			$output = '';
			$classes = '';

			//
			// Start Customizer Prefix
			//
				$prefixClass = '';
				if( isset($atts['c_id']) ) {
					$this->prefix = $atts['c_id'] . ' ';
					$prefixClass = str_replace('.',  '',  $atts['c_id']);
				} else {
					$this->prefix = '.vc_custom_' . rand(25,  3000) . ' ';
					$prefixClass = str_replace('.',  '',  $this->prefix);
				}
			// End Customizer Prefix

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>
			<div class="ivan-form-wrapper <?php echo $prefixClass; ?>">
				<div class="ivan-contact-form <?php echo $classes; ?>">
					<?php
					$out = do_shortcode($content);
					if(is_admin()) {
						$out = str_replace('_wpnonce',  '_wpnonce_null',  $out);
						$out = str_replace('_wp_http_referer',  '_wp_http_referer_null',  $out);
					}
					echo $out;
					?>
				</div>
			</div>
			<?php
			$output .= ob_get_clean();

			//
			// Customizer CSS Output
			//
				$style = '';
				foreach ($this->selectors as $key => $value) {
					if( isset($atts[$key]) && '' != $atts[$key]) {
						$style .= ivan_vc_customizer_get_style( $atts[$key],  $this->selectors[$key],  $this->prefix );
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
			'label_css' => array(
				// Font
				'font-family' => 'label', 
				'font-weight' => 'label', 
				'font-size' => 'label', 
				'line-height' => 'label', 
				'text-transform' => 'label', 
				'color' => 'label,  .ninja-forms-req-symbol', 
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
				'font-family' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'font-weight' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'font-size' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'line-height' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'text-transform' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'color' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				// Spacing
				'margin-top' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'margin-right' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'margin-bottom' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'margin-left' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'padding-top' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'padding-right' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'padding-bottom' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'padding-left' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				// Bg
				'background-color' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				// Border Radius
				'border-top-left-radius' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-top-right-radius' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-bottom-left-radius' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-bottom-right-radius' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				// Border
				'border-top-width' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-right-width' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-bottom-width' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-left-width' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-style' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				'border-color' => 'select, textarea, input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="tel"]', 
				// Hovers
				'color-focus' => 'select:focus, textarea:focus, input[type="text"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="tel"]:focus', 
				'border-color-focus' => 'select:focus, textarea:focus, input[type="text"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="tel"]:focus', 
				'background-color-focus' => 'select:focus, textarea:focus, input[type="text"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="tel"]:focus', 
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
			'error_css' => array(
				// Font
				'font-family' => '.ninja-forms-field-error', 
				'font-weight' => '.ninja-forms-field-error', 
				'font-size' => '.ninja-forms-field-error', 
				'line-height' => '.ninja-forms-field-error', 
				'text-transform' => '.ninja-forms-field-error', 
				'color' => '.ninja-forms-field-error', 
			), 
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_contact_form;
	$ivan_vc_contact_form = new WPBakeryShortCode_ivan_contact( array('name' => 'Contact Form',  'base' => 'ivan_contact') );

} // #end class check