<?php
/***
 * Module > Button
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_progress extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';

			// Output customizer rules
			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					preg_match("!\{\s*([^\}]+)\s*\}!", $atts[$key], $match);
					if( !empty($match[0]) ) {
						$this->prefix = str_replace(array('{', '}'), '', $match[0]) . ' ';
						$atts[$key] = str_replace( $match[0], "", $atts[$key] );
					}
				}
			}

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>

			<div class="ivan-button-wrapper <?php echo str_replace('.', '', $this->prefix); ?>">
				<div class="ivan-button <?php echo $classes; ?>">
				
				</div>
			</div>

			<?php
			$output .= ob_get_clean();

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

			return $output;
		}

		// H1 Selectors
		public $selectors = array(
			'btn_css' => array(
				// Font
				'font-family' => 'a',
				'font-weight' => 'a',
				'font-size' => 'a',
				'line-height' => 'a',
				'text-transform' => 'a',
				'color' => 'a',
				// Spacing
				'margin-top' => 'a',
				'margin-right' => 'a',
				'margin-bottom' => 'a',
				'margin-left' => 'a',
				'padding-top' => 'a',
				'padding-right' => 'a',
				'padding-bottom' => 'a',
				'padding-left' => 'a',
				// Bg
				'background-color' => 'a',
				// Border Radius
				'border-top-left-radius' => 'a',
				'border-top-right-radius' => 'a',
				'border-bottom-left-radius' => 'a',
				'border-bottom-right-radius' => 'a',
				// Border
				'border-top-width' => 'a',
				'border-right-width' => 'a',
				'border-bottom-width' => 'a',
				'border-left-width' => 'a',
				'border-style' => 'a',
				'border-color' => 'a',
				// Hovers
				'color-hover' => 'a:hover',
				'border-color-hover' => 'a:hover',
				'background-color-hover' => 'a:hover',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_progress;
	$ivan_vc_progress = new WPBakeryShortCode_ivan_progress( array('name' => 'Progress Bar', 'base' => 'ivan_progress') );

} // #end class check