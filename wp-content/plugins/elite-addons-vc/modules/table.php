<?php
/***
 * Module > Table
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_table extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'el_class' => '',
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
			$classes = '';

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>
			<div class="ivan-table <?php echo $classes; ?> <?php echo $prefixClass; ?>">
				<?php echo do_shortcode($content); ?>
			</div>
			<?php
			$output .= ob_get_clean();

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
			'table_css' => array(
				// Font
				'font-family' => 'table',
				//'font-weight' => 'table',
				//'font-size' => 'table',
				//'line-height' => 'table',
				//'text-transform' => 'table',
				//'color' => 'table',
				// Dimensions
				//'width' => 'table',
				//'height' => 'table',
				// Spacing
				'margin-top' => 'table',
				'margin-right' => 'table',
				'margin-bottom' => 'table',
				'margin-left' => 'table',
				//'padding-top' => 'table',
				//'padding-right' => 'table',
				//'padding-bottom' => 'table',
				//'padding-left' => 'table',
				// Bg
				'background-color' => 'table',
				// Border Radius
				'border-top-left-radius' => 'table',
				'border-top-right-radius' => 'table',
				'border-bottom-left-radius' => 'table',
				'border-bottom-right-radius' => 'table',
				// Border
				'border-top-width' => 'table',
				'border-right-width' => 'table',
				'border-bottom-width' => 'table',
				'border-left-width' => 'table',
				'border-style' => 'table',
				'border-color' => 'table',
				// Hovers
				//'color-hover' => 'table',
				//'border-color-hover' => 'table',
				//'background-color-hover' => 'table',
			),
			'th_css' => array(
				// Font
				'font-family' => 'table > thead > tr > th',
				'font-weight' => 'table > thead > tr > th',
				'font-size' => 'table > thead > tr > th',
				'line-height' => 'table > thead > tr > th',
				'text-transform' => 'table > thead > tr > th',
				'color' => 'table > thead > tr > th',
				// Dimensions
				//'width' => 'table > thead > tr > th',
				//'height' => 'table > thead > tr > th',
				// Spacing
				//'margin-top' => 'table > thead > tr > th',
				//'margin-right' => 'table > thead > tr > th',
				//'margin-bottom' => 'table > thead > tr > th',
				//'margin-left' => 'table > thead > tr > th',
				'padding-top' => 'table > thead > tr > th',
				'padding-right' => 'table > thead > tr > th',
				'padding-bottom' => 'table > thead > tr > th',
				'padding-left' => 'table > thead > tr > th',
				// Bg
				'background-color' => 'table > thead > tr > th',
				// Border Radius
				'border-top-left-radius' => 'table > thead > tr > th',
				'border-top-right-radius' => 'table > thead > tr > th',
				'border-bottom-left-radius' => 'table > thead > tr > th',
				'border-bottom-right-radius' => 'table > thead > tr > th',
				// Border
				'border-top-width' => 'table > thead > tr > th',
				'border-right-width' => 'table > thead > tr > th',
				'border-bottom-width' => 'table > thead > tr > th',
				'border-left-width' => 'table > thead > tr > th',
				'border-style' => 'table > thead > tr > th',
				'border-color' => 'table > thead > tr > th',
				// Hovers
				//'color-hover' => 'table > thead > tr > th',
				//'border-color-hover' => 'table > thead > tr > th',
				//'background-color-hover' => 'table > thead > tr > th',
			),
			'th_odd_css' => array(
				// Font
				'color' => 'table > thead > tr > th:nth-child(2n)',
				// Dimensions
				//'width' => 'table > tbody > tr:nth-child(2n) > td',
				//'height' => 'table > tbody > tr:nth-child(2n) > td',
				// Spacing
				// Bg
				'background-color' => 'table > thead > tr > th:nth-child(2n)',
				// Border
				'border-top-width' => 'table > thead > tr > th:nth-child(2n)',
				'border-right-width' => 'table > thead > tr > th:nth-child(2n)',
				'border-bottom-width' => 'table > thead > tr > th:nth-child(2n)',
				'border-left-width' => 'table > thead > tr > th:nth-child(2n)',
				'border-style' => 'table > thead > tr > th:nth-child(2n)',
				'border-color' => 'table > thead > tr > th:nth-child(2n)',
			),
			'td_css' => array(
				// Font
				'font-family' => 'table > tbody > tr > td',
				'font-weight' => 'table > tbody > tr > td',
				'font-size' => 'table > tbody > tr > td',
				'line-height' => 'table > tbody > tr > td',
				'text-transform' => 'table > tbody > tr > td',
				'color' => 'table > tbody > tr > td',
				// Dimensions
				//'width' => 'table > tbody > tr > td',
				//'height' => 'table > tbody > tr > td',
				// Spacing
				//'margin-top' => 'table > tbody > tr > td',
				//'margin-right' => 'table > tbody > tr > td',
				//'margin-bottom' => 'table > tbody > tr > td',
				//'margin-left' => 'table > tbody > tr > td',
				'padding-top' => 'table > tbody > tr > td',
				'padding-right' => 'table > tbody > tr > td',
				'padding-bottom' => 'table > tbody > tr > td',
				'padding-left' => 'table > tbody > tr > td',
				// Bg
				'background-color' => 'table > tbody > tr > td',
				// Border
				'border-top-width' => 'table > tbody > tr > td',
				'border-right-width' => 'table > tbody > tr > td',
				'border-bottom-width' => 'table > tbody > tr > td',
				'border-left-width' => 'table > tbody > tr > td',
				'border-style' => 'table > tbody > tr > td',
				'border-color' => 'table > tbody > tr > td',
			),
			'td_odd_css' => array(
				// Font
				'color' => 'table > tbody > tr:nth-child(2n) > td',
				// Dimensions
				//'width' => 'table > tbody > tr:nth-child(2n) > td',
				//'height' => 'table > tbody > tr:nth-child(2n) > td',
				// Spacing
				// Bg
				'background-color' => 'table > tbody > tr:nth-child(2n) > td',
				// Border
				'border-top-width' => 'table > tbody > tr:nth-child(2n) > td',
				'border-right-width' => 'table > tbody > tr:nth-child(2n) > td',
				'border-bottom-width' => 'table > tbody > tr:nth-child(2n) > td',
				'border-left-width' => 'table > tbody > tr:nth-child(2n) > td',
				'border-style' => 'table > tbody > tr:nth-child(2n) > td',
				'border-color' => 'table > tbody > tr:nth-child(2n) > td',
			),

			'col_odd_css' => array(
				// Font
				'color' => 'table > tbody > tr > td:nth-child(2n)',
				// Dimensions
				//'width' => 'table > tbody > tr:nth-child(2n) > td',
				//'height' => 'table > tbody > tr:nth-child(2n) > td',
				// Spacing
				// Bg
				'background-color' => 'table > tbody > tr > td:nth-child(2n)',
				// Border
				'border-top-width' => 'table > tbody > tr > td:nth-child(2n)',
				'border-right-width' => 'table > tbody > tr > td:nth-child(2n)',
				'border-bottom-width' => 'table > tbody > tr > td:nth-child(2n)',
				'border-left-width' => 'table > tbody > tr > td:nth-child(2n)',
				'border-style' => 'table > tbody > tr > td:nth-child(2n)',
				'border-color' => 'table > tbody > tr > td:nth-child(2n)',
			),

			'tfoot_css' => array(
				// Font
				'font-family' => 'table > tfoot > tr > td',
				'font-weight' => 'table > tfoot > tr > td',
				'font-size' => 'table > tfoot > tr > td',
				'line-height' => 'table > tfoot > tr > td',
				'text-transform' => 'table > tfoot > tr > td',
				'color' => 'table > tfoot > tr > td',
				// Dimensions
				//'width' => 'table > tfoot > tr > td',
				//'height' => 'table > tfoot > tr > td',
				// Spacing
				//'margin-top' => 'table > tfoot > tr > td',
				//'margin-right' => 'table > tfoot > tr > td',
				//'margin-bottom' => 'table > tfoot > tr > td',
				//'margin-left' => 'table > tfoot > tr > td',
				'padding-top' => 'table > tfoot > tr > td',
				'padding-right' => 'table > tfoot > tr > td',
				'padding-bottom' => 'table > tfoot > tr > td',
				'padding-left' => 'table > tfoot > tr > td',
				// Bg
				'background-color' => 'table > tfoot > tr > td',
				// Border Radius
				'border-top-left-radius' => 'table > tfoot > tr > td',
				'border-top-right-radius' => 'table > tfoot > tr > td',
				'border-bottom-left-radius' => 'table > tfoot > tr > td',
				'border-bottom-right-radius' => 'table > tfoot > tr > td',
				// Border
				'border-top-width' => 'table > tfoot > tr > td',
				'border-right-width' => 'table > tfoot > tr > td',
				'border-bottom-width' => 'table > tfoot > tr > td',
				'border-left-width' => 'table > tfoot > tr > td',
				'border-style' => 'table > tfoot > tr > td',
				'border-color' => 'table > tfoot > tr > td',
				// Hovers
				//'color-hover' => 'table > tfoot > tr > td',
				//'border-color-hover' => 'table > tfoot > tr > td',
				//'background-color-hover' => 'table > tfoot > tr > td',
			),			
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_table;
	$ivan_vc_table = new WPBakeryShortCode_ivan_table( array('name' => 'Table', 'base' => 'ivan_table') );

} // #end class check