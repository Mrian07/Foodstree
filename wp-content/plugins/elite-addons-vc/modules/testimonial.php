<?php
/***
 * Module > Testimonial
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_testimonial extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'author' => '',
				'desc' => '',
				'image_id' => '',
				'q_style' => 'centered-quote',
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

			// Main Styles
			$classes .= ' ' . $q_style;

			// Main Classes
			if('image-left' == $q_style)
				$classes .= ' img-at-left';
			else if('image-right' == $q_style)
				$classes .= ' img-at-right';

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>
			<div class="ivan-testimonial-main <?php echo $prefixClass; ?>">
				<div class="ivan-testimonial <?php echo $classes; ?>">

					<?php if('image-left' == $q_style && '' != $image_id) : ?>
						<div class="img-wrap">
							<?php
							$url = wp_get_attachment_image_src($image_id, 'full');
							echo '<img src="'. $url['0'].'" alt="">';
							?>
						</div>
					<?php endif; ?>

					<div class="main-wrap">
						<div class="testimonial-content"><?php echo do_shortcode($content); ?></div>

						<?php if('' != $author) : ?>
							<div class="testimonial-meta">
								<div class="meta-inner">

									<div class="author-infos-holder">
										<?php if('' != $image_id && ('image-left' != $q_style && 'image-right' != $q_style) ) :
											$url = wp_get_attachment_image_src($image_id, 'full');
											echo '<div class="author-img"><img src="'. $url['0'].'" alt=""></div>';
										endif; ?>

										<div class="author-infos">
											<?php if($author != '') : ?>
												<div class="author-name"><?php echo $author; ?></div>
											<?php endif; ?>
											
											
											<?php if($desc != '') : ?>
												<div class="author-desc"><?php echo $desc; ?></div>
											<?php endif; ?>
										</div>
									</div>

								</div>
							</div>
						<?php endif; ?>
					</div>

					<?php if('image-right' == $q_style && '' != $image_id) : ?>
						<div class="img-wrap">
							<?php
							$url = wp_get_attachment_image_src($image_id, 'full');
							echo '<img src="'. $url['0'].'" alt="">';
							?>
						</div>
					<?php endif; ?>

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
				'font-family' => '.testimonial-content',
				'font-weight' => '.testimonial-content',
				'font-size' => '.testimonial-content',
				'line-height' => '.testimonial-content',
				'text-transform' => '.testimonial-content',
				'color' => '.testimonial-content, .testimonial-content a, .testimonial-content a:hover',
				// Dimensions
				//'width' => '.testimonial-content',
				//'height' => '.testimonial-content',
				// Spacing
				'margin-top' => '&',
				'margin-right' => '&',
				'margin-bottom' => '&',
				'margin-left' => '&',
				//'padding-top' => '.testimonial-content',
				//'padding-right' => '.testimonial-content',
				//'padding-bottom' => '.testimonial-content',
				//'padding-left' => '.testimonial-content',
				// Bg
				'background-color' => '.testimonial-content',
				// Border Radius
				'border-top-left-radius' => '.testimonial-content',
				'border-top-right-radius' => '.testimonial-content',
				'border-bottom-left-radius' => '.testimonial-content',
				'border-bottom-right-radius' => '.testimonial-content',
				// Border
				//'border-top-width' => '.testimonial-content',
				//'border-right-width' => '.testimonial-content',
				//'border-bottom-width' => '.testimonial-content',
				//'border-left-width' => '.testimonial-content',
				//'border-style' => '.testimonial-content',
				'border-color' => '.testimonial-content:after',
				// Hovers
				//'color-hover' => '.author-name',
				//'border-color-hover' => '.author-name',
				//'background-color-hover' => '.author-name',
			),
			'author_css' => array(
				// Font
				'font-family' => '.author-name',
				'font-weight' => '.author-name',
				'font-size' => '.author-name',
				'line-height' => '.author-name',
				'text-transform' => '.author-name',
				'color' => '.author-name',
				// Margins
				'margin-top' => '.testimonial-meta',
				'margin-right' => '.author-name',
				'margin-bottom' => '.author-name',
				'margin-left' => '.author-name',
			),
			'desc_css' => array(
				// Font
				'font-family' => '.author-desc',
				'font-weight' => '.author-desc',
				'font-size' => '.author-desc',
				'line-height' => '.author-desc',
				'text-transform' => '.author-desc',
				'color' => '.author-desc',
				// Margins
				'margin-top' => '.author-desc',
				'margin-right' => '.author-desc',
				'margin-bottom' => '.author-desc',
				'margin-left' => '.author-desc',
			),
			'img_css' => array(
				// Dimensions
				'width' => '.author-img img',
				'height' => '.author-img img',
				// Spacing
				'margin-top' => '.author-img img',
				'margin-right' => '.author-img img',
				'margin-bottom' => '.author-img img',
				'margin-left' => '.author-img img',
				// Border Radius
				'border-top-left-radius' => '.author-img img',
				'border-top-right-radius' => '.author-img img',
				'border-bottom-left-radius' => '.author-img img',
				'border-bottom-right-radius' => '.author-img img',
				// Border
				'border-top-width' => '.author-img img',
				'border-right-width' => '.author-img img',
				'border-bottom-width' => '.author-img img',
				'border-left-width' => '.author-img img',
				'border-style' => '.author-img img',
				'border-color' => '.author-img img',
			),	
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_testimonial;
	$ivan_vc_testimonial = new WPBakeryShortCode_ivan_testimonial( array('name' => 'Testimonial', 'base' => 'ivan_testimonial') );

} // #end class check