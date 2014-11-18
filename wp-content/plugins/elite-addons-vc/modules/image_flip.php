<?php
/***
 * Module > Image Flip
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_image_flip extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'image' => '',
				'flip_image' => '',
				'link' => '',
				'target' => '',

				'css_animation' => '',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';

			$image_src = $image;
			$image_flip_src = $flip_image;

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

			// Main Image
			if( $image != '' && is_numeric($image) ) {
				$image_src = wp_get_attachment_url( $image );
			}

			// Flip Image
			if( $flip_image != '' && is_numeric($flip_image) ) {
				$image_flip_src = wp_get_attachment_url( $flip_image );
				$classes .= ' with-hover-image';
			}

			// Target
			$attr_target = '';
			if('yes' == $target)
				$attr_target = ' target="_blank"';


			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>

			<div class="ivan-image-flip-wrapper <?php echo str_replace('.', '', $this->prefix); ?>">
				<div class="ivan-image-flip <?php echo $classes; ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
					<div class="ivan-image-flip-holder">
						<?php if($link != '' ) : ?>
							<a href="<?php echo $link; ?>"<?php echo $attr_target; ?>>
						<?php endif; ?>

							<img class="active-image" src="<?php echo $image_src; ?>" alt="">

							<?php if( $image_flip_src != '' ) : ?>
								<img class="hover-image" src="<?php echo $image_flip_src; ?>" alt="">
							<?php endif; ?>

						<?php if($link != '' ) : ?>
							</a>
						<?php endif; ?>
					</div>
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
	global $ivan_vc_image_flip;
	$ivan_vc_image_flip = new WPBakeryShortCode_ivan_image_flip( array('name' => 'Image Flip', 'base' => 'ivan_image_flip') );

} // #end class check