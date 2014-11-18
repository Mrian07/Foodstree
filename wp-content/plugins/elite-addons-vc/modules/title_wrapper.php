<?php
/***
 * Module > Title Wrapper
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_title extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'title_tag' => 'h3',
				'ico_family' => '',
				'ico' => '',
				'ico_custom' => '',
				'above_icon' => 'no',
				'align' => 'center',
				'display' => 'default-display',
				'mark' => '',
				'sub' => '',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';
			$inner_classes = '';

			//$content = 'Heading <strong>Featured</strong>';

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

			// Main Classes
			$classes .= ' ' . $align;

			// Inner Classes
			$inner_classes .= ' ' . $display;

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			$icon_markup = '';

			if('' != $ico) :
				$icon_markup = '<i class="'.$ico_family.$ico.'"></i>';
			endif;

			if('' != $ico_custom) :
				$icon_markup = '<i class="'.$ico_custom.'"></i>';
			endif;

			// Output Form
			ob_start();
			?>
			<div class="ivan-title-main <?php echo $prefixClass; ?>">
				<div class="ivan-title-wrapper <?php echo $classes; ?>">
					<div class="title-wrapper <?php echo $inner_classes; ?>">
						<?php if('' != $icon_markup && 'yes' == $above_icon) : ?>
							<div class="icon-above">
								<?php echo $icon_markup; ?>
							</div>
						<?php endif; ?>
						<<?php echo $title_tag; ?> class="title-heading">
							<?php if('' != $icon_markup && 'no' == $above_icon) : ?>
								<?php echo $icon_markup; ?>
							<?php endif; ?>
							<?php echo do_shortcode($content); ?>
						</<?php echo $title_tag; ?>>
						<?php if( $mark == 'yes' ) : ?>
							<div class="ivan-vc-separator small <?php echo $align; ?>"></div>
						<?php endif; ?>
						<?php if('' != $sub) : ?>
							<h4 class="sub"><?php echo do_shortcode($sub); ?></h4>
						<?php endif; ?>
					</div>
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
			'title_css' => array(
				// Font
				'font-family' => '.title-heading',
				'font-weight' => '.title-heading',
				'font-size' => '.title-heading',
				'line-height' => '.title-heading',
				'text-transform' => '.title-heading',
				'color' => '.title-heading',
				// Spacing
				'margin-top' => '.ivan-title-wrapper',
				'margin-right' => '.ivan-title-wrapper',
				'margin-bottom' => '&',
				'margin-left' => '.ivan-title-wrapper',
				'padding-top' => '.title-wrapper',
				'padding-right' => '.title-wrapper',
				'padding-bottom' => '.title-wrapper',
				'padding-left' => '.title-wrapper',
				// Bg
				'background-color' => '.title-wrapper',
				// Border Radius
				'border-top-left-radius' => '.title-wrapper',
				'border-top-right-radius' => '.title-wrapper',
				'border-bottom-left-radius' => '.title-wrapper',
				'border-bottom-right-radius' => '.title-wrapper',
				// Border
				'border-top-width' => '.title-wrapper',
				'border-right-width' => '.title-wrapper',
				'border-bottom-width' => '.title-wrapper',
				'border-left-width' => '.title-wrapper',
				'border-style' => '.title-wrapper',
				'border-color' => '.title-wrapper',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'highlight_css' => array(
				// Font
				'font-weight' => 'a, strong',
				'color' => 'a, strong',
				// Hovers
				'color-hover' => 'a:hover',
			),
			'subtitle_css' => array(
				// Font
				'font-family' => '.sub',
				'font-weight' => '.sub',
				'font-size' => '.sub',
				'line-height' => '.sub',
				'text-transform' => '.sub',
				'color' => '.sub, .sub a',
				// Hovers
				'color-hover' => '.sub a:hover',
				// Spacing
				'margin-top' => '.sub',
				'margin-right' => '.sub',
				'margin-bottom' => '.sub',
				'margin-left' => '.sub',
			),
			'mark_css' => array(
				// Bg
				'background-color' => '.ivan-vc-separator.small',
				// Dimensions
				'width' => '.ivan-vc-separator.small',
				'height' => '.ivan-vc-separator.small',
				// Spacing
				'margin-top' => '.ivan-vc-separator.small',
				'margin-right' => '.ivan-vc-separator.small',
				'margin-bottom' => '.ivan-vc-separator.small',
				'margin-left' => '.ivan-vc-separator.small',
			),
			'icon_css' => array(
				// Font
				'font-size' => '.icon-above i',
				'color' => '.icon-above i',
				// Spacing
				'margin-top' => '.icon-above',
				'margin-right' => '.icon-above',
				'margin-bottom' => '.icon-above',
				'margin-left' => '.icon-above',
			),			
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_title_wrapper;
	$ivan_vc_title_wrapper = new WPBakeryShortCode_ivan_title( array('name' => 'Title Wrapper', 'base' => 'ivan_title') );

} // #end class check