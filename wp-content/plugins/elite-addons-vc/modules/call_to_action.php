<?php
/***
 * Extension > Call to Action
 *
 * This is an extension of default VC Component
 *
 **/

if(class_exists('WPBakeryShortCodesContainer')) {

	// Class
	class WPBakeryShortCode_ivan_call_action extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = '' ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'heading' => '',
				'heading_tag' => 'h3',
				'style' => 'boxed',
				'type' => '',

				'ico_family' => 'fa fa-',
				'ico' => '',
				'ico_custom' => '',
				'ico_image' => '',

				'desc' => '',
				
				'size' => 'fa-3x',
				'template' => apply_filters('ivan_vc_call_action_default_template', 'primary-bg'),
				'el_class' => '',
			), $atts) );

			$output = '';
			$classes = '';

			//$size = 'fa-lg';
			//$size = 'fa-2x';
			//$size = 'fa-3x';
			//$size = 'fa-4x';
			//$size = 'fa-5x';

			//$template = 'gray-bg';
			//$template = 'dark-bg';
			//$template = 'light-bg';
			//$template = 'primary-bg';


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

			// Icon Sizes
			if( $ico_image != '') {
				switch ( $size ) {
					case 'fa-lg':
						$classes .= ' small-icon';
						break;
					case 'fa-2x':
						$classes .= ' medium-icon';
						break;
					case 'fa-3x':
						$classes .= ' large-icon';
						break;
					case 'fa-4x':
						$classes .= ' very-large-icon';
						break;
					case 'fa-5x':
						$classes .= ' extra-large-icon';
						break;
				}
			}

			$output_icon = '';
			$icon_markup = '';

			if( $type == 'with-icon' ) {
				// has icon

				// Generate Icon Markup
				if( '' == $ico_image ) {

					// Generate Icon Markup
					$icon_i = '';

					if('' != $ico) :
						$icon_i = $ico_family.$ico;
					endif;

					if('' != $ico_custom) :
						$icon_i = $ico_custom;
					endif;

					$icon_markup = '<i class="'.$icon_i.' '.$size.'"></i>';

					$classes .= ' with-icon';

				} else {
					// if it's using an image

					if( is_numeric($ico_image) ) {
						$image_src = wp_get_attachment_url( $ico_image );
					} else {
						$image_src = $ico_image;
					}

					$icon_markup = '<img src="'.$image_src.'" alt="">';

					$classes .= ' with-icon image-icon';
				}

				$output_icon .= '<div class="call-action-icon-holder">';
				$output_icon .= '<div class="call-action-icon">';
				$output_icon .= '<div class="call-action-icon-inner">';

					$output_icon .= $icon_markup;

				$output_icon .= '</div>';
				$output_icon .= '</div>';
				$output_icon .= '</div>';
			}

			// El Class
			$classes .= ' '. $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>

			<div class="ivan-call-action-wrapper <?php echo $prefixClass; ?>"><!-- adds prefix class -->
				<div class="ivan-call-action <?php echo $classes; ?>">
					<div class="ivan-call-action-inner">

						<div class="call-action-text-holder">
							<div class="call-action-text-inner">
								<?php echo $output_icon; ?>

								<div class="call-action-heading-text-holder">

									<div class="call-action-heading"><<?php echo $heading_tag; ?> class="call-action-heading-text"><?php echo $heading; ?></<?php echo $heading_tag; ?>></div>

									<?php if($desc != '') : ?>
										<div class="call-action-text"><?php echo $desc; ?></div>
									<?php endif; ?>

								</div>
							</div>
						</div>

						<?php if($content != '' && $content != null) : ?>
							<div class="call-action-btn-holder">
								<?php echo do_shortcode( $content ); ?>
							</div>
						<?php endif;?>

					</div>
				</div>
			</div>

			<?php
			$output .= ob_get_clean();

			$output = str_replace(array("\n", "\t", "\r"), '', $output);

			// Transfer color scheme to button as well...
			if($template != '')
				$output = str_replace('place-template', $template, $output);

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
				// Spacing
				'margin-top' => '.ivan-call-action',
				'margin-right' => '.ivan-call-action',
				'margin-bottom' => '.ivan-call-action',
				'margin-left' => '.ivan-call-action',
				'padding-top' => '.ivan-call-action',
				'padding-right' => '.ivan-call-action',
				'padding-bottom' => '.ivan-call-action',
				'padding-left' => '.ivan-call-action',
				// Bg
				'background-color' => '.ivan-call-action',
				// Border Radius
				'border-top-left-radius' => '.ivan-call-action',
				'border-top-right-radius' => '.ivan-call-action',
				'border-bottom-left-radius' => '.ivan-call-action',
				'border-bottom-right-radius' => '.ivan-call-action',
				// Border
				'border-top-width' => '.ivan-call-action',
				'border-right-width' => '.ivan-call-action',
				'border-bottom-width' => '.ivan-call-action',
				'border-left-width' => '.ivan-call-action',
				'border-style' => '.ivan-call-action',
				'border-color' => '.ivan-call-action',
			),
			'title_css' => array(
				// Font
				'font-family' => '.call-action-heading-text',
				'font-weight' => '.call-action-heading-text',
				'font-size' => '.call-action-heading-text',
				'line-height' => '.call-action-heading-text',
				'text-transform' => '.call-action-heading-text',
				'color' => '.call-action-heading-text',
			),
			'desc_css' => array(
				// Font
				'font-family' => '.call-action-text',
				'font-weight' => '.call-action-text',
				'font-size' => '.call-action-text',
				'line-height' => '.call-action-text',
				'text-transform' => '.call-action-text',
				'color' => '.call-action-text',
				// Spacing
				'margin-top' => '.call-action-text',
				'margin-right' => '.call-action-text',
				'margin-bottom' => '.call-action-text',
				'margin-left' => '.call-action-text',
			),
			'icon_css' => array(
				// Font
				//'font-family' => '.call-action-icon-holder',
				//'font-weight' => '.call-action-icon-holder',
				'font-size' => '.call-action-icon-holder i',
				//'line-height' => '.call-action-icon-holder',
				//'text-transform' => '.call-action-icon-holder',
				'color' => '.call-action-icon-holder i',
				// Dimensions
				'width' => '.call-action-icon-holder img',
				'height' => '.call-action-icon-holder img',
				// Spacing
				'padding-top' => '.call-action-icon-holder',
				'padding-right' => '.call-action-icon-holder',
				'padding-bottom' => '.call-action-icon-holder',
				'padding-left' => '.call-action-icon-holder',
			),
			'btn_css' => array(
				// Spacing
				'padding-top' => '.call-action-btn-holder',
				'padding-right' => '.call-action-btn-holder',
				'padding-bottom' => '.call-action-btn-holder',
				'padding-left' => '.call-action-btn-holder',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_call_action;
	$ivan_vc_call_action = new WPBakeryShortCode_ivan_call_action( array('name' => 'Call to Action', 'base' => 'ivan_call_action') );

} // #end class check