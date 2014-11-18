<?php
/***
 * Module > Image Block
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	class WPBakeryShortCode_ivan_image_block extends WPBakeryShortCode {

		// Shortcode
		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'ivan_bg_img' => '',
				'ivan_img_size' => 'full',
				'ivan_custom_height' => '',

				// Frontal Block
				'ico_family' => 'fa fa-',
				'ico_custom' => '',
				'ico' => '',
				'ico_size' => 'fa-3x',

				'heading' => '',
				'heading_tag' => 'h3',
				'description' => '',

				'btn_text' => '',
				'btn_link' => '',
				'btn_target' => '',

				'align' => 'to-center',
				'v_align' => 'v-middle',
				'overlay' => '',

				// Flip Block
				'f_ico_family' => 'fa fa-',
				'f_ico_custom' => '',
				'f_ico' => '',
				'f_ico_size' => 'fa-3x',

				'f_heading' => '',
				'f_heading_tag' => 'h3',

				'f_btn_text' => '',
				'f_btn_link' => '',
				'f_btn_target' => '',

				'f_align' => 'to-center',
				'f_v_align' => 'v-middle',
				'f_overlay' => '',
				
				'el_class' => '',
				'template' => '',
			), $atts) );
			
			$output = '';
			$classes = '';
			$inlineStyles = '';
			
			$mainClasses = '';
			$hasMainBlock = false;

			$flipClasses = '';
			$hasFlipBlock = false;

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

			// Custom Height
			if( $ivan_custom_height != '') {
				$inlineStyles .= 'height:' . ivan_style_val( $ivan_custom_height ) . ';';
			}

			// Custom Bg
			if($ivan_bg_img != '') {
				$url = wp_get_attachment_image_src($ivan_bg_img, $ivan_img_size);
				$inlineStyles .= 'background-image: url('.$url['0'].');';
			}

			//
			// Main Block
			//
				$icon_markup = '';

				if('' != $ico) :
					$icon_markup = '<i class="'.$ico_family.$ico.' '.$ico_size.'"></i>';
					$hasMainBlock = true;
				endif;

				if('' != $ico_custom) :
					$icon_markup = '<i class="'.$ico_custom.' '.$ico_size.'"></i>';
					$hasMainBlock = true;
				endif;

				if( $heading != '' OR $description != '' OR $btn_text != '' OR $overlay != 'no')
					$hasMainBlock = true;

				if( $hasMainBlock ) {
					$mainClasses .= ' ' . $align;
					$mainClasses .= ' ' . $v_align;
				}

			//
			// Flip Block
			//
				$f_icon_markup = '';

				if('' != $f_ico) :
					$f_icon_markup = '<i class="'.$f_ico_family.$f_ico.' '.$f_ico_size.'"></i>';
					$hasFlipBlock = true;
				endif;

				if('' != $f_ico_custom) :
					$f_icon_markup = '<i class="'.$f_ico_custom.' '.$f_ico_size.'"></i>';
					$hasFlipBlock = true;
				endif;

				if( $f_heading != '' OR $content != '' OR $f_btn_text != '' OR $f_overlay != 'no')
					$hasFlipBlock = true;

				if( $hasFlipBlock ) {
					$flipClasses .= ' ' . $f_align;
					$flipClasses .= ' ' . $f_v_align;
					$classes .= ' with-flip';
				}

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			ob_start();	
			?>

			<div class="ivan-image-block-wrapper <?php echo $prefixClass; ?>">
				<div class="ivan-image-block <?php echo $classes; ?>" style="<?php echo $inlineStyles; ?>">
					
					<?php if( $hasMainBlock ) : ?>

						<div class="img-main-block <?php echo $mainClasses; ?>">

							<?php if( $overlay != 'no' ) : ?>
								<div class="block-overlay"></div>
							<?php endif; ?>

							<div class="block-holder">
								<div class="block-inner">
									
									<?php if( $icon_markup != '' ) : ?>
										<div class="block-icon-holder"><?php echo $icon_markup; ?></div>
									<?php endif; ?>

									<?php if( $heading != '' ) : ?>
										<div class="block-heading">
											<<?php echo $heading_tag; ?> class="block-header"><?php echo $heading; ?></<?php echo $heading_tag; ?>>
										</div>
									<?php endif; ?>

									<?php if( $description != '' ) : ?>
										<div class="block-desc"><?php echo $description; ?></div>
									<?php endif; ?>

									<?php if( $btn_text != '' ) : ?>
										<div class="block-btn">
											<a class="block-btn-a" href="<?php echo $btn_link; ?>" <?php if($btn_target == 'yes') echo ' target="_blank"'; ?>>
												<?php echo $btn_text; ?>
											</a>
										</div>
									<?php endif; ?>

								</div>
							</div>
						</div>

					<?php endif; ?>

					<?php if( $hasFlipBlock ) : ?>

						<div class="img-main-block img-flip-block <?php echo $flipClasses; ?>">

							<?php if( $f_overlay != 'no' ) : ?>
								<div class="block-overlay"></div>
							<?php endif; ?>

							<div class="block-holder">
								<div class="block-inner">
									
									<?php if( $f_icon_markup != '' ) : ?>
										<div class="block-icon-holder"><?php echo $f_icon_markup; ?></div>
									<?php endif; ?>

									<?php if( $f_heading != '' ) : ?>
										<div class="block-heading">
											<<?php echo $f_heading_tag; ?> class="block-header"><?php echo $f_heading; ?></<?php echo $f_heading_tag; ?>>
										</div>
									<?php endif; ?>

									<?php if( $content != '' ) : ?>
										<div class="block-desc"><?php echo nl2br($content); ?></div>
									<?php endif; ?>

									<?php if( $f_btn_text != '' ) : ?>
										<div class="block-btn">
											<a class="block-btn-a" href="<?php echo $btn_link; ?>" <?php if($f_btn_target == 'yes') echo ' target="_blank"'; ?>>
												<?php echo $f_btn_text; ?>
											</a>
										</div>
									<?php endif; ?>

								</div>
							</div>
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
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				'margin-top' => '.ivan-image-block',
				'margin-right' => '.ivan-image-block',
				'margin-bottom' => '.ivan-image-block',
				'margin-left' => '.ivan-image-block',
				'padding-top' => '.block-inner',
				'padding-right' => '.block-inner',
				'padding-bottom' => '.block-inner',
				'padding-left' => '.block-inner',
				// Bg
				//'background-color' => '.ivan-project .entry',
				// Border
				//'border-top-width' => '.thumbnail',
				//'border-right-width' => '.thumbnail',
				//'border-bottom-width' => '.thumbnail',
				//'border-left-width' => '.thumbnail',
				//'border-style' => '.thumbnail',
				//'border-color' => '.thumbnail',
				// Border Radius
				//'border-top-left-radius' => '.thumbnail, img',
				//'border-top-right-radius' => '.thumbnail, img',
				//'border-bottom-left-radius' => '.thumbnail, img',
				//'border-bottom-right-radius' => '.thumbnail, img',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'overlay_css' => array(
				// Bg
				'background-color' => '.block-overlay',
			),
			'icon_css' => array(
				'color' => '.block-icon-holder',
				// Spacing
				'margin-top' => '.block-icon-holder',
				'margin-right' => '.block-icon-holder',
				'margin-bottom' => '.block-icon-holder',
				'margin-left' => '.block-icon-holder',
			),
			'title_css' => array(
				// Font
				'font-family' => '.block-header',
				'font-weight' => '.block-header',
				'font-size' => '.block-header',
				'line-height' => '.block-header',
				'text-transform' => '.block-header',
				'color' => '.block-header',
				// Spacing
				'margin-top' => '.block-heading',
				'margin-right' => '.block-heading',
				'margin-bottom' => '.block-heading',
				'margin-left' => '.block-heading',
			),
			'desc_css' => array(
				// Font
				'font-family' => '.block-desc',
				'font-weight' => '.block-desc',
				'font-size' => '.block-desc',
				'line-height' => '.block-desc',
				'text-transform' => '.block-desc',
				'color' => '.block-desc',
				// Spacing
				'margin-top' => '.block-desc',
				'margin-right' => '.block-desc',
				'margin-bottom' => '.block-desc',
				'margin-left' => '.block-desc',
			),
			'btn_css' => array(
				// Font
				'font-family' => '.block-btn-a',
				'font-weight' => '.block-btn-a',
				'font-size' => '.block-btn-a',
				'line-height' => '.block-btn-a',
				'text-transform' => '.block-btn-a',
				'color' => '.block-btn-a',
				// Spacing
				'padding-top' => '.block-btn-a',
				'padding-right' => '.block-btn-a',
				'padding-bottom' => '.block-btn-a',
				'padding-left' => '.block-btn-a',
				// Bg
				'background-color' => '.block-btn-a',
				// Border Radius
				'border-top-left-radius' => '.block-btn-a',
				'border-top-right-radius' => '.block-btn-a',
				'border-bottom-left-radius' => '.block-btn-a',
				'border-bottom-right-radius' => '.block-btn-a',
				// Border
				'border-top-width' => '.block-btn-a',
				'border-right-width' => '.block-btn-a',
				'border-bottom-width' => '.block-btn-a',
				'border-left-width' => '.block-btn-a',
				'border-style' => '.block-btn-a',
				'border-color' => '.block-btn-a',
				// Hovers
				'color-hover' => '.block-btn-a:hover',
				'border-color-hover' => '.block-btn-a:hover',
				'background-color-hover' => '.block-btn-a:hover',
			),
			// Flip Face
			'f_overlay_css' => array(
				// Bg
				'background-color' => '.img-flip-block .block-overlay',
			),
			'f_icon_css' => array(
				'color' => '.img-flip-block .block-icon-holder',
				// Spacing
				'margin-top' => '.img-flip-block .block-icon-holder',
				'margin-right' => '.img-flip-block .block-icon-holder',
				'margin-bottom' => '.img-flip-block .block-icon-holder',
				'margin-left' => '.img-flip-block .block-icon-holder',
			),
			'f_title_css' => array(
				// Font
				'font-family' => '.img-flip-block .block-header',
				'font-weight' => '.img-flip-block .block-header',
				'font-size' => '.img-flip-block .block-header',
				'line-height' => '.img-flip-block .block-header',
				'text-transform' => '.img-flip-block .block-header',
				'color' => '.img-flip-block .block-header',
				// Spacing
				'margin-top' => '.img-flip-block .block-heading',
				'margin-right' => '.img-flip-block .block-heading',
				'margin-bottom' => '.img-flip-block .block-heading',
				'margin-left' => '.img-flip-block .block-heading',
			),
			'f_desc_css' => array(
				// Font
				'font-family' => '.img-flip-block .block-desc',
				'font-weight' => '.img-flip-block .block-desc',
				'font-size' => '.img-flip-block .block-desc',
				'line-height' => '.img-flip-block .block-desc',
				'text-transform' => '.img-flip-block .block-desc',
				'color' => '.img-flip-block .block-desc',
				// Spacing
				'margin-top' => '.img-flip-block .block-desc',
				'margin-right' => '.img-flip-block .block-desc',
				'margin-bottom' => '.img-flip-block .block-desc',
				'margin-left' => '.img-flip-block .block-desc',
			),
			'f_btn_css' => array(
				// Font
				'font-family' => '.img-flip-block .block-btn-a',
				'font-weight' => '.img-flip-block .block-btn-a',
				'font-size' => '.img-flip-block .block-btn-a',
				'line-height' => '.img-flip-block .block-btn-a',
				'text-transform' => '.img-flip-block .block-btn-a',
				'color' => '.img-flip-block .block-btn-a',
				// Spacing
				'padding-top' => '.img-flip-block .block-btn-a',
				'padding-right' => '.img-flip-block .block-btn-a',
				'padding-bottom' => '.img-flip-block .block-btn-a',
				'padding-left' => '.img-flip-block .block-btn-a',
				// Bg
				'background-color' => '.img-flip-block .block-btn-a',
				// Border Radius
				'border-top-left-radius' => '.img-flip-block .block-btn-a',
				'border-top-right-radius' => '.img-flip-block .block-btn-a',
				'border-bottom-left-radius' => '.img-flip-block .block-btn-a',
				'border-bottom-right-radius' => '.img-flip-block .block-btn-a',
				// Border
				'border-top-width' => '.img-flip-block .block-btn-a',
				'border-right-width' => '.img-flip-block .block-btn-a',
				'border-bottom-width' => '.img-flip-block .block-btn-a',
				'border-left-width' => '.img-flip-block .block-btn-a',
				'border-style' => '.img-flip-block .block-btn-a',
				'border-color' => '.img-flip-block .block-btn-a',
				// Hovers
				'color-hover' => '.img-flip-block .block-btn-a:hover',
				'border-color-hover' => '.img-flip-block .block-btn-a:hover',
				'background-color-hover' => '.img-flip-block .block-btn-a:hover',
			),
		);

		public $prefix = '';

	} // #end class

	// Init global var to store this module data
	global $ivan_vc_image_block;
	$ivan_vc_image_block = new WPBakeryShortCode_ivan_image_block( array('name' => 'Image Block', 'base' => 'ivan_image_block') );


 } // #end class check