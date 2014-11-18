<?php
/***
 * Module > Icon List
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_icon_li extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'item' => '', // item content
				'style' => '',
				'ico_family' => 'fa fa-',
				'ico' => '',
				'ico_custom' => '',
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

			// El Class
			$classes .= ' '. $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Font Icon
			$icon_markup = '';

			if('' != $ico) :
				$icon_markup = '<i class="pull-left '.$ico_family.$ico.'"></i>';
			endif;

			if('' != $ico_custom) :
				$icon_markup = '<i class="pull-left '.$ico_custom.'"></i>';
			endif;

			// Output Form
			ob_start();
			?>

			<div class="ivan-icon-list-wrapper <?php echo $prefixClass; ?>"><!-- adds prefix class -->
				<div class="ivan-icon-list <?php echo $classes; ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
					<?php echo $icon_markup; ?>
					<p><?php echo $item; ?></p>
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
				'font-family' => 'ivan-icon-list',
				'font-weight' => '.ivan-icon-list p',
				'font-size' => '.ivan-icon-list p',
				'line-height' => '.ivan-icon-list p',
				'text-transform' => '.ivan-icon-list p',
				'color' => '.ivan-icon-list p',
				// Spacing
				'margin-top' => 'ivan-icon-list',
				'margin-right' => 'ivan-icon-list',
				'margin-bottom' => 'ivan-icon-list',
				'margin-left' => 'ivan-icon-list',
				'padding-top' => 'ivan-icon-list',
				'padding-right' => 'ivan-icon-list',
				'padding-bottom' => 'ivan-icon-list',
				'padding-left' => 'ivan-icon-list',
				// Bg
				'background-color' => 'ivan-icon-list',
				// Border Radius
				'border-top-left-radius' => 'ivan-icon-list',
				'border-top-right-radius' => 'ivan-icon-list',
				'border-bottom-left-radius' => 'ivan-icon-list',
				'border-bottom-right-radius' => 'ivan-icon-list',
				// Border
				'border-top-width' => 'ivan-icon-list',
				'border-right-width' => 'ivan-icon-list',
				'border-bottom-width' => 'ivan-icon-list',
				'border-left-width' => 'ivan-icon-list',
				'border-style' => 'ivan-icon-list',
				'border-color' => 'ivan-icon-list',
				// Hovers
				//'color-hover' => 'ivan-icon-list',
				//'border-color-hover' => 'ivan-icon-list',
				//'background-color-hover' => 'ivan-icon-list',
			),
			'mark_css' => array(
				// Font
				'font-family' => 'i',
				'font-weight' => 'i',
				'font-size' => 'i',
				'line-height' => 'i',
				//'text-transform' => 'i',
				'color' => 'i',
				// Dimension
				'width' => 'i',
				'height' => 'i',
				// Spacing
				'margin-top' => '.ivan-icon-list p',
				'margin-right' => '.ivan-icon-list p',
				'margin-bottom' => '.ivan-icon-list p',
				'margin-left' => '.ivan-icon-list p',
				'padding-top' => '.ivan-icon-list p',
				'padding-right' => '.ivan-icon-list p',
				'padding-bottom' => '.ivan-icon-list p',
				'padding-left' => '.ivan-icon-list p',
				// Bg
				'background-color' => 'i',
				// Border Radius
				'border-top-left-radius' => 'i',
				'border-top-right-radius' => 'i',
				'border-bottom-left-radius' => 'i',
				'border-bottom-right-radius' => 'i',
				// Border
				'border-top-width' => 'i',
				'border-right-width' => 'i',
				'border-bottom-width' => 'i',
				'border-left-width' => 'i',
				'border-style' => 'i',
				'border-color' => 'i',
				// Hovers
				//'color-hover' => 'i',
				//'border-color-hover' => 'i',
				//'background-color-hover' => 'i',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_icon_list;
	$ivan_vc_icon_list = new WPBakeryShortCode_ivan_icon_li( array('name' => 'Icon List', 'base' => 'ivan_icon_li') );

} // #end class check