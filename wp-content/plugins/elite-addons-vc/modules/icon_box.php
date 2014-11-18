<?php
/***
 * Module > Icon Box
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_icon_box extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'box_type' => 'normal',
				'ico_family' => 'fa fa-',
				'ico' => 'anchor',
				'ico_custom' => '',
				'ico_image' => '',
				'icon_style' => 'circle',
				'icon_pos' => 'top',
				'size' => 'fa-4x',
				/*
				'use_custom_size' => '',
				'custom_icon_size' => '',
				'custom_icon_size_inner' => '',
				'custom_icon_margin' => '',
				*/
				'title' => '',
				'title_tag' => 'h4',
				'link_text' => '',
				'link' => '',
				'show_sep' => '',
				'target' => '',
				'el_class' => '',
				'css_animation' => '',
				'template' => '',
				
			), $atts) );

			$classes = '';
			$classes_template = '';
	
			//$box_type = 'inside-box';
			
			//$icon_style = 'circle';
			//$icon_style = 'square';
			//$icon_style = 'normal';

			//$size = 'fa-lg';
			//$size = 'fa-2x';
			//$size = 'fa-3x';
			//$size = 'fa-4x';
			//$size = 'fa-5x';

			//$show_sep = 'yes';


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

			// Size class
			$real_icon_size = '';

			switch ($size) {
				case 'fa-lg':
					$real_icon_size = 'tiny';
					break;
				case 'fa-2x':
					$real_icon_size = 'small-ico';
					break;
				case 'fa-3x':
					$real_icon_size = 'medium';
					break;
				case 'fa-4x':
					$real_icon_size = 'large';
					break;
				case 'fa-5x':
					$real_icon_size = 'very-large';
					break;
				default:
					$real_icon_size = 'small-ico';
			}

			// Icon Style
			$real_icon_style = '';

			if( '' != $ico_image )
				$icon_style = 'image';

			switch ($icon_style) {
				case 'normal':
					$real_icon_style = 'normal-icon';
					break;
				case 'square':
					$real_icon_style = 'square';
					break;
				case 'circle':
					$real_icon_style = 'circle';
					break;
				case 'image':
					if($box_type == 'normal')
						$real_icon_style = 'icon-image';
				   	else
						$real_icon_style = 'image';
					break;
			}

			if( $real_icon_style == 'normal-icon' && $box_type == 'inside-box' ) {
				$real_icon_style = 'circle'; // if not set icon style in box type, set to circle by default
				$icon_style = 'circle';
			}

			// Add custom classes provided by users
			if('' != $el_class)
				$classes_template .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes_template .= ' ' . $template;

			// HTML Outputs
			$output = '';
			$output_icon = '';

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

				// If not using image
				switch ($icon_style) {
					case 'circle':
						$output_icon .= '<span class="fa-stack main-icon-holder '.$size.'">';
							$output_icon .= '<i class="main-icon '.$icon_i.' fa-stack-1x"></i>';
						$output_icon .= '</span>';
						break;
					case 'square':
						$output_icon .= '<span class="fa-stack main-icon-holder '.$size.'">';
							$output_icon .= '<i class="main-icon '.$icon_i.'"></i>';
					  	$output_icon .= '</span>';
						break;
					default:
						$output_icon .= '<span class="ivan-icon-box-icon main-icon-holder">';
					   		$output_icon .= '<i class="main-icon '.$icon_i.' '.$size.'"></i>';
						$output_icon .= '</span>';
						break;
				}
			} else {
				// if it's using an image

				if( is_numeric($ico_image) ) {
					$image_src = wp_get_attachment_url( $ico_image );
				} else {
					$image_src = $ico_image;
				}

				$output_icon = '<img src="'.$image_src.'" alt="">';
			}

			// Generate Box Markup
			if( $box_type == 'normal' ) {

				$classes_holder = '';

				$classes_holder .= ' ' . $box_type;
				$classes_holder .= ' ' . $real_icon_style;
				$classes_holder .= ' ' . $real_icon_size;

				if( $icon_pos == 'top' ) {
					$classes_holder .= ' center';
				}

				if( $icon_pos == 'left-title' )
					$classes_holder .= ' left-title';

				$output .= '<div class="ivan-icon-box '. $classes_holder . $classes_template .'">';

					if( $icon_pos != 'left-title' ) {
						// Output if not left from title
						$output .= '<div class="icon-box-holder">';
							$output .= $output_icon;
						$output .= '</div>';
					}

					// Heading Holder
					$output .= '<div class="icon-box-text-holder">';
					$output .= '<div class="icon-box-text-inner">';

						if( $icon_pos == 'left-title' ) {
							$output .= '<div class="icon-box-title-holder">';

							// Output if not left from title
							$output .= '<div class="icon-box-holder">';
								$output .= $output_icon;
							$output .= '</div>';
						}

						// Title
						$output .= '<'.$title_tag.' class="icon-box-title">'.$title.'</'.$title_tag.'>';

						if( $icon_pos == 'left-title' ) {
							$output .= '</div>';
						}

						// Content
						if($content != '' && $content != null) {
							$output .= '<div class="icon-box-content">' . do_shortcode($content) . '</div>';
						}

						// Link
						if( $link_text != '' ) {

							if($target == 'yes') {
								$target = 'target="_blank"';
							} else {
								$target = '';
							}

							if($show_sep == 'yes' && $icon_pos == 'top')
								$output .= '<hr>';

							$output .= '<div class="icon-box-link-holder">';
								$output .= '<a class="icon-read-more" href="'. $link .'" '.$target.'>' . $link_text . '</a>';
							$output .= '</div>';

						}

					$output .= '</div>';
					$output .= '</div>';

				$output .= '</div>';


			} else {
				
				$classes_holder = '';

				$classes_holder .= ' ' . $box_type;
				$classes_holder .= ' ' . $real_icon_style;

				$output .= '<div class="iv-boxed-auto-spacer ' . $real_icon_size .'"></div>';

				$output .= '<div class="ivan-icon-boxed-holder '. $classes_template .'">';

					$output .= '<div class="ivan-icon-boxed-icon">';
						$output .= '<div class="ivan-icon-boxed-icon-inner '. $real_icon_size . ' '.$classes_holder.'">';
							$output .= $output_icon;
						$output .= '</div>';
					$output .= '</div>';

					$output .= '<div class="ivan-icon-boxed-inner '. $real_icon_size . ' center">';

						$output .= '<'.$title_tag.' class="icon-box-title">'.$title.'</'.$title_tag.'>';

						// Content
						if($content != '' && $content != null) {
							$output .= '<div class="icon-box-content">' . do_shortcode($content) . '</div>';
						}

					$output .= '</div>';

				$output .= '</div>';
			}

			// Output Icon Box
			ob_start();
			?>
				<div class="ivan-icon-box-wrapper <?php echo $prefixClass; ?>">
					<div class="ivan-icon-box-holder <?php echo $classes; ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
						<?php echo $output; ?>
					</div>
				</div>

			<?php
			$output_final = ob_get_clean();

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

			return $output_final;
		}

		// H1 Selectors
		public $selectors = array(
			'main_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				//'font-size' => 'h2',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				//'color' => 'h2',
				// Spacing
				'margin-top' => '&',
				'margin-right' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'margin-bottom' => '&',
				'margin-left' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'padding-top' => '.ivan-icon-box, .ivan-icon-boxed-inner',
				'padding-right' => '.ivan-icon-box, .ivan-icon-boxed-inner',
				'padding-bottom' => '.ivan-icon-box, .ivan-icon-boxed-inner',
				'padding-left' => '.ivan-icon-box, .ivan-icon-boxed-inner',
				// Bg
				'background-color' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				// Border Radius
				'border-top-left-radius' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-top-right-radius' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-bottom-left-radius' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-bottom-right-radius' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				// Border
				'border-top-width' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-right-width' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-bottom-width' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-left-width' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-style' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				'border-color' => '.ivan-icon-box, .ivan-icon-boxed-holder',
				// Hovers
				//'color-hover' => 'label:hover',
				'border-color-hover' => '.ivan-icon-box:hover, .ivan-icon-boxed-holder:hover',
				'background-color-hover' => '.ivan-icon-box:hover, .ivan-icon-boxed-holder:hover',
			),	
			'icon_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				'font-size' => '.main-icon',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				'color' => '.main-icon',
				// Spacing
				//'margin-top' => '.main-icon-holder',
				//'margin-right' => '.main-icon-holder',
				//'margin-bottom' => '.main-icon-holder',
				//'margin-left' => '.main-icon-holder',
				//'padding-top' => '.main-icon-holder',
				//'padding-right' => '.main-icon-holder',
				//'padding-bottom' => '.main-icon-holder',
				//'padding-left' => '.main-icon-holder',
				// Bg
				'background-color' => '.main-icon-holder',
				// Border Radius
				'border-top-left-radius' => '.main-icon-holder',
				'border-top-right-radius' => '.main-icon-holder',
				'border-bottom-left-radius' => '.main-icon-holder',
				'border-bottom-right-radius' => '.main-icon-holder',
				// Border
				'border-top-width' => '.main-icon-holder',
				'border-right-width' => '.main-icon-holder',
				'border-bottom-width' => '.main-icon-holder',
				'border-left-width' => '.main-icon-holder',
				'border-style' => '.main-icon-holder',
				'border-color' => '.main-icon-holder',
				// Hovers
				'color-hover' => '.ivan-icon-box-holder:hover .main-icon',
				'border-color-hover' => '.ivan-icon-box-holder:hover .main-icon-holder',
				'background-color-hover' => '.ivan-icon-box-holder:hover .main-icon-holder',
			),
			'title_css' => array(
				// Font
				'font-family' => '.icon-box-title',
				'font-weight' => '.icon-box-title',
				'font-size' => '.icon-box-title',
				'line-height' => '.icon-box-title',
				'text-transform' => '.icon-box-title',
				'color' => '.icon-box-title',
				// Spacing
				'margin-top' => '.icon-box-title',
				'margin-right' => '.icon-box-title',
				'margin-bottom' => '.icon-box-title',
				'margin-left' => '.icon-box-title',
				//'padding-top' => '.icon-box-title',
				//'padding-right' => '.icon-box-title',
				//'padding-bottom' => '.icon-box-title',
				//'padding-left' => '.ivan-info-box',
				// Bg
				//'background-color' => '.ivan-info-box',
				// Border Radius
				//'border-top-left-radius' => '.ivan-info-box',
				//'border-top-right-radius' => '.ivan-info-box',
				//'border-bottom-left-radius' => '.ivan-info-box',
				//'border-bottom-right-radius' => '.ivan-info-box',
				// Border
				//'border-top-width' => '.ivan-info-box',
				//'border-right-width' => '.ivan-info-box',
				//'border-bottom-width' => '.ivan-info-box',
				//'border-left-width' => '.ivan-info-box',
				//'border-style' => '.ivan-info-box',
				//'border-color' => '.ivan-info-box',
				// Hovers
				'color-hover' => '.ivan-icon-box-holder:hover .icon-box-title',
				//'border-color-hover' => '.ivan-info-box:hover',
				//'background-color-hover' => '.ivan-info-box:hover',
			),
			'content_css' => array(
				// Font
				'font-family' => '.icon-box-content',
				'font-weight' => '.icon-box-content',
				'font-size' => '.icon-box-content',
				'line-height' => '.icon-box-content',
				'text-transform' => '.icon-box-content',
				'color' => '.icon-box-content, .icon-box-content a',
				// Spacing
				'margin-top' => '.icon-box-content',
				'margin-right' => '.icon-box-content',
				'margin-bottom' => '.icon-box-content',
				'margin-left' => '.icon-box-content',
				'padding-top' => '.icon-box-text-holder',
				'padding-right' => '.icon-box-text-holder',
				'padding-bottom' => '.icon-box-text-holder',
				'padding-left' => '.icon-box-text-holder',
				// Bg
				//'background-color' => '.ivan-info-box',
				// Border Radius
				//'border-top-left-radius' => '.ivan-info-box',
				//'border-top-right-radius' => '.ivan-info-box',
				//'border-bottom-left-radius' => '.ivan-info-box',
				//'border-bottom-right-radius' => '.ivan-info-box',
				// Border
				//'border-top-width' => '.ivan-info-box',
				//'border-right-width' => '.ivan-info-box',
				//'border-bottom-width' => '.ivan-info-box',
				//'border-left-width' => '.ivan-info-box',
				//'border-style' => '.ivan-info-box',
				//'border-color' => '.ivan-info-box',
				// Hovers
				'color-hover' => '.ivan-icon-box-holder:hover .icon-box-content, .ivan-icon-box-holder:hover .icon-box-content a',
				//'border-color-hover' => '.ivan-info-box:hover',
				//'background-color-hover' => '.ivan-info-box:hover',
			),
			'btn_css' => array(
				// Font
				'font-family' => '.icon-read-more',
				'font-weight' => '.icon-read-more',
				'font-size' => '.icon-read-more',
				'line-height' => '.icon-read-more',
				'text-transform' => '.icon-read-more',
				'color' => '.icon-read-more',
				// Dimensions
				//'width' => '.icon-read-more',
				//'height' => '.icon-read-more',
				// Spacing
				'margin-top' => '.icon-box-link-holder',
				'margin-right' => '.icon-read-more',
				'margin-bottom' => '.icon-box-link-holder',
				'margin-left' => '.icon-read-more',
				'padding-top' => '.icon-read-more',
				'padding-right' => '.icon-read-more',
				'padding-bottom' => '.icon-read-more',
				'padding-left' => '.icon-read-more',
				// Bg
				'background-color' => '.icon-read-more',
				// Border Radius
				'border-top-left-radius' => '.icon-read-more',
				'border-top-right-radius' => '.icon-read-more',
				'border-bottom-left-radius' => '.icon-read-more',
				'border-bottom-right-radius' => '.icon-read-more',
				// Border
				'border-top-width' => '.icon-read-more',
				'border-right-width' => '.icon-read-more',
				'border-bottom-width' => '.icon-read-more',
				'border-left-width' => '.icon-read-more',
				'border-style' => '.icon-read-more',
				'border-color' => '.icon-read-more',
				// Hovers
				'color-hover' => '.ivan-icon-box-holder:hover .icon-read-more, .icon-read-more:hover',
				'border-color-hover' => '.ivan-icon-box-holder:hover .icon-read-more, .icon-read-more:hover',
				'background-color-hover' => '.ivan-icon-box-holder:hover .icon-read-more, .icon-read-more:hover',
			),
			'sep_css' => array(
				// Font
				//'font-family' => 'hr',
				//'font-weight' => 'hr',
				//'font-size' => 'hr',
				//'line-height' => 'hr',
				//'text-transform' => 'hr',
				//'color' => 'hr',
				// Dimensions
				//'width' => 'hr',
				//'height' => 'hr',
				// Spacing
				'margin-top' => 'hr',
				'margin-right' => 'hr',
				'margin-bottom' => 'hr',
				'margin-left' => 'hr',
				//'padding-top' => 'hr',
				//'padding-right' => 'hr',
				//'padding-bottom' => 'hr',
				//'padding-left' => 'hr',
				// Bg
				//'background-color' => 'hr',
				// Border Radius
				//'border-top-left-radius' => 'hr',
				//'border-top-right-radius' => 'hr',
				//'border-bottom-left-radius' => 'hr',
				//'border-bottom-right-radius' => 'hr',
				// Border
				'border-top-width' => 'hr',
				//'border-right-width' => 'hr',
				//'border-bottom-width' => 'hr',
				//'border-left-width' => 'hr',
				'border-style' => 'hr',
				'border-color' => 'hr',
				// Hovers
				//'color-hover' => 'hr',
				'border-color-hover' => '.ivan-icon-box-holder:hover hr',
				//'background-color-hover' => 'hr',
			),
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_icon_box;
	$ivan_vc_icon_box = new WPBakeryShortCode_ivan_icon_box( array('name' => 'Icon Box', 'base' => 'ivan_icon_box') );

} // #end class check