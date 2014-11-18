<?php
/***
 * Module > List Styled
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_list extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'style' => 'number',
				'num_type' => 'circle-in',
				'css_animation' => '',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';

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

			// Style
			$classes .= ' ' . $style;

			// Num Type
			if( $style == 'number' )
				$classes .= ' ' . $num_type;

			// El Class
			$classes .= ' '. $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>

			<div class="ivan-list-wrapper <?php echo $prefixClass; ?>"><!-- adds prefix class -->
				<div class="ivan-list <?php echo $classes; ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
					<?php echo $content; ?>
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
			'block_css' => array(
				// Font
				'font-family' => '.ivan-list',
				'font-weight' => '.ivan-list li',
				'font-size' => '.ivan-list li',
				'line-height' => '.ivan-list li',
				'text-transform' => '.ivan-list li',
				'color' => '.ivan-list li',
				// Spacing
				'margin-top' => '.ivan-list',
				'margin-right' => '.ivan-list',
				'margin-bottom' => '.ivan-list',
				'margin-left' => '.ivan-list',
				'padding-top' => '.ivan-list',
				'padding-right' => '.ivan-list',
				'padding-bottom' => '.ivan-list',
				'padding-left' => '.ivan-list',
				// Bg
				'background-color' => '.ivan-list',
				// Border Radius
				'border-top-left-radius' => '.ivan-list',
				'border-top-right-radius' => '.ivan-list',
				'border-bottom-left-radius' => '.ivan-list',
				'border-bottom-right-radius' => '.ivan-list',
				// Border
				'border-top-width' => '.ivan-list',
				'border-right-width' => '.ivan-list',
				'border-bottom-width' => '.ivan-list',
				'border-left-width' => '.ivan-list',
				'border-style' => '.ivan-list',
				'border-color' => '.ivan-list',
				// Hovers
				//'color-hover' => '.ivan-list',
				//'border-color-hover' => '.ivan-list',
				//'background-color-hover' => '.ivan-list',
			),
			'mark_css' => array(
				// Font
				'font-family' => '.ivan-list ul > li:before',
				'font-weight' => '.ivan-list ul > li:before',
				'font-size' => '.ivan-list ul > li:before',
				'line-height' => '.ivan-list ul > li:before',
				//'text-transform' => '.ivan-list ul > li:before',
				'color' => '.ivan-list ul > li:before',
				// Dimension
				'width' => '.ivan-list ul > li:before',
				'height' => '.ivan-list ul > li:before',
				// Spacing
				'margin-top' => '.ivan-list li',
				'margin-right' => '.ivan-list li',
				'margin-bottom' => '.ivan-list li',
				'margin-left' => '.ivan-list li',
				'padding-top' => '.ivan-list li',
				'padding-right' => '.ivan-list li',
				'padding-bottom' => '.ivan-list li',
				'padding-left' => '.ivan-list li',
				// Bg
				'background-color' => '.ivan-list ul > li:before',
				// Border Radius
				'border-top-left-radius' => '.ivan-list ul > li:before',
				'border-top-right-radius' => '.ivan-list ul > li:before',
				'border-bottom-left-radius' => '.ivan-list ul > li:before',
				'border-bottom-right-radius' => '.ivan-list ul > li:before',
				// Border
				'border-top-width' => '.ivan-list ul > li:before',
				'border-right-width' => '.ivan-list ul > li:before',
				'border-bottom-width' => '.ivan-list ul > li:before',
				'border-left-width' => '.ivan-list ul > li:before',
				'border-style' => '.ivan-list ul > li:before',
				'border-color' => '.ivan-list ul > li:before',
				// Hovers
				//'color-hover' => '.ivan-list ul > li:before',
				//'border-color-hover' => '.ivan-list ul > li:before',
				//'background-color-hover' => '.ivan-list ul > li:before',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_list;
	$ivan_vc_list = new WPBakeryShortCode_ivan_list( array('name' => 'List Styled', 'base' => 'ivan_list') );

} // #end class check