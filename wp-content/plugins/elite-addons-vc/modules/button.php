<?php
/***
 * Module > Button
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_button extends WPBakeryShortCode {

		protected function content( $atts, $content = '' ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'link' => '',
				'target' => '',
				'size' => '',
				'border_r' => '',
				'style' => '',
				'dark_op' => '',
				'display' => 'btn-inline',
				'align' => '',

				'icon_area' => '',
				'icon_pos' => '',			
				'ico_family' => 'fa fa-',
				'ico' => '',
				'ico_custom' => '',
				'ico_txt' => '',

				'icon_cover' => '',
				'icon_sep' => '',
				'icon_glow' => '',
				'icon_zoom' => '',
				'social_auto' => '',

				'e_desc' => '',
				'desc_txt' => '',

				'css_animation' => '',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';
			$originalContent = $content;

			//$social_auto = 'yes';
			//$icon_glow = 'yes';

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

			//$template = 'gray-bg';
			//$template = 'dark-bg';
			//$template = 'light-bg';
			//$template = 'primary-bg';

			$attr_target = '';
			if('yes' == $target)
				$attr_target = ' target="_blank"';

			// Font Icon
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

			<?php 
			//if('' != $align && 'default-align' != $align)
				//echo '<div class="ivan-button-align '.$align.'">';
			?>

			<?php
			$btn_classes = '';

			// Outline and Solid (default)
			$btn_classes .= ' ' . $style;
			//$btn_classes .= ' outline';
			//$btn_classes .= ' no-border';

			if($dark_op == 'yes')
				$btn_classes .= ' dark-op';

			// Border Radius
			$btn_classes .= ' ' . $border_r;
			//$btn_classes .= ' square';
			//$btn_classes .= ' round';
			//$btn_classes .= ' round-square';
			//$btn_classes .= ' circular';

			// Sizes
			$btn_classes .= ' ' . $size;
			//$btn_classes .= ' large';
			//$btn_classes .= ' x-large';
			//$btn_classes .= ' compact';
			// $btn_classes .= ' circular-mega'; (only to circular style )

			// After and Before Button
			$btn_after = '';
			$btn_before = '';

			$content_before = '';
			$content_after = '';

			// Icon or Text
			if( $icon_area != '' ) {
				$icon_markup = '';

				if( $icon_area == 'icon' ) {
					// Icon Logic
					if('' != $ico) :
						$icon_markup = '<span class="icon-simple"><i class="'.$ico_family.$ico.'"></i></span>';
					endif;

					if('' != $ico_custom) :
						$icon_markup = '<span class="icon-simple"><i class="'.$ico_custom.'"></i></span>';
					endif;
				}
				else if( $icon_area == 'text' ) {
					// Text Logic
					$icon_markup = '<span class="icon-simple icon-text">'.$ico_txt.'</span>';
				}

				// Adds the icon/text to the button
				if( $icon_pos == '' ) :
					$btn_before .= $icon_markup;
					$btn_classes .= ' with-icon icon-before';
				elseif( $icon_pos == 'right' ) :
					$btn_after .= $icon_markup;
					$btn_classes .= ' with-icon icon-after';
				endif;

				// Icon Cover Logic (not work with text separator)
				if( $icon_cover == 'yes' )
					$btn_classes .= ' icon-cover';
				// Text Separator (not work with icon-cover)
				if( $icon_sep == 'yes' )
					$btn_classes .= ' text-separator';

				// Icon Glow Effect
				if( $icon_glow == 'yes' )
					$btn_classes .= ' glow-icon';
			}

			// Specific Circular Markup
			if( $border_r == 'circular' ) {
				$btn_before = '<span class="center-holder"><span class="center-inner">' . $btn_before;
				$btn_after = $btn_after . '</span></span>';
			}

			// Adds Content to button
			if( $content != '' && $content != null) {
				$content = '<span class="text-btn">'.$content.'</span>';
				$btn_classes .= ' with-text';
			} else {
				// Logic testing if only icon is added
				$btn_classes .= ' only-icon';
			}

			// Description Support
			if( $content != '' && $content != null && $e_desc == 'yes') {
				$content_before = '<span class="text-btn"><span class="text-btn-inner">';
				$content = $originalContent;
				$content_after = '</span>';

				if( $desc_txt != '')
					$content_after .= '<span class="text-desc">'. $desc_txt .'</span>';

				$content_after .= '</span>';
				$btn_classes .= ' btn-desc';
			}

			// Button Zoom
			if( $icon_zoom == 'yes' )
				$btn_classes .= ' button-zoom';

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template) {
				$btn_classes .= ' ' . $template;
				$display .= ' ' . $template;
			} else {
				$btn_classes .= ' place-template';
				$display .= ' place-template';
			}

			// Adds Social Auto Color Support
			if( $social_auto != '' && $ico != '' )
				$btn_classes .= ' social-auto sa-' . $ico;

			// Adjust Content
			$content =  str_replace(array('<p>', '</p>'), '', $content );

			?>

			<?php 
			if('' != $align)
				echo '<div class="ivan-button-align '.$align.'">';
			?>

			<div class="ivan-button-wrapper <?php echo $display; ?> <?php echo $prefixClass; ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
				<a href="<?php echo $link; ?>" class="ivan-button <?php echo $btn_classes; ?>"<?php echo $attr_target; ?>><?php echo $btn_before; ?><?php echo $content_before; ?><?php echo $content; ?><?php echo $content_after; ?><?php echo $btn_after; ?></a>
			</div>

			<?php 
			if('' != $align)
				echo '</div>';
			?>

			<?php
			$output .= ob_get_clean();

			//$output = str_replace(array("\n", "\t", "\r"), '', $output);
			//
			// Customizer CSS Output
			//
				$style = '';
				foreach ($this->selectors as $key => $value) {
					if( isset($atts[$key]) && '' != $atts[$key]) {
						$style .= ivan_vc_customizer_get_style( $atts[$key], $this->selectors[$key], $this->prefix, $key );
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
			'btn_css' => array(
				// Font
				'font-family' => 'a',
				'font-weight' => 'a',
				'font-size' => 'a',
				'line-height' => 'a',
				'text-transform' => 'a',
				'color' => 'a',
				// Dimensions
				'width' => '.ivan-button',
				'height' => '.ivan-button',
				// Spacing
				'margin-top' => 'a',
				'margin-right' => 'a',
				'margin-bottom' => 'a',
				'margin-left' => 'a',
				'padding-top' => 'a',
				'padding-right' => '.text-btn',
				'padding-bottom' => 'a',
				'padding-left' => '.text-btn',
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
			'icon_css' => array(
				// Font
				'font-family' => '.icon-simple',
				'font-weight' => '.icon-simple',
				'font-size' => '.icon-simple',
				'line-height' => '.icon-simple',
				'text-transform' => '.icon-simple',
				'color' => '.icon-simple',
				// Spacing
				//'margin-top' => '.icon-simple',
				//'margin-right' => '.icon-simple',
				//'margin-bottom' => '.icon-simple',
				//'margin-left' => '.icon-simple',
				'padding-top' => '.icon-simple',
				'padding-right' => '.icon-simple',
				'padding-bottom' => '.icon-simple',
				'padding-left' => '.icon-simple',
				// Bg
				'background-color' => 'a.icon-cover.with-icon .icon-simple',
				// Border Radius
				//'border-top-left-radius' => '.icon-simple',
				//'border-top-right-radius' => '.icon-simple',
				//'border-bottom-left-radius' => '.icon-simple',
				//'border-bottom-right-radius' => '.icon-simple',
				// Border
				//'border-top-width' => '.icon-simple',
				//'border-right-width' => '.icon-simple',
				//'border-bottom-width' => '.icon-simple',
				//'border-left-width' => '.icon-simple',
				//'border-style' => '.icon-simple',
				'border-color' => 'a.text-separator.with-icon .text-btn',
				// Hovers
				'color-hover' => 'a:hover .icon-simple',
				'border-color-hover' => 'a.text-separator.with-icon:hover .text-btn',
				'background-color-hover' => 'a.icon-cover.with-icon:hover .icon-simple',
			),
			'hr_css' => array(
				'background-color' => 'a hr',
				// Hovers
				'background-color-hover' => 'a:hover hr',
			),
			'desc_css' => array(
				// Font
				'font-family' => '.text-btn-inner',
				'font-weight' => '.text-btn-inner',
				'font-size' => '.text-btn-inner',
				'line-height' => '.text-btn-inner',
				'text-transform' => '.text-btn-inner',
				'color' => '.text-btn-inner',
				// Hovers
				'color-hover' => 'a:hover .text-btn-inner',
			),
			'small_css' => array(
				// Font
				'font-family' => '.text-desc',
				'font-weight' => '.text-desc',
				'font-size' => '.text-desc',
				'line-height' => '.text-desc',
				'text-transform' => '.text-desc',
				'color' => '.text-desc',
				// Hovers
				'color-hover' => 'a:hover .text-desc',
			),

			'mob_btn_css' => array(
				// Font
				'font-family' => 'a',
				'font-weight' => 'a',
				'font-size' => 'a',
				'line-height' => 'a',
				'text-transform' => 'a',
				'color' => 'a',
				// Dimensions
				'width' => '.ivan-button',
				'height' => '.ivan-button',
				// Spacing
				'margin-top' => 'a',
				'margin-right' => 'a',
				'margin-bottom' => 'a',
				'margin-left' => 'a',
				'padding-top' => 'a',
				'padding-right' => '.text-btn',
				'padding-bottom' => 'a',
				'padding-left' => '.text-btn',
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
			'mob_icon_css' => array(
				// Font
				'font-family' => '.icon-simple',
				'font-weight' => '.icon-simple',
				'font-size' => '.icon-simple',
				'line-height' => '.icon-simple',
				'text-transform' => '.icon-simple',
				'color' => '.icon-simple',
				// Spacing
				//'margin-top' => '.icon-simple',
				//'margin-right' => '.icon-simple',
				//'margin-bottom' => '.icon-simple',
				//'margin-left' => '.icon-simple',
				'padding-top' => '.icon-simple',
				'padding-right' => '.icon-simple',
				'padding-bottom' => '.icon-simple',
				'padding-left' => '.icon-simple',
				// Bg
				'background-color' => 'a.icon-cover.with-icon .icon-simple',
				// Border Radius
				//'border-top-left-radius' => '.icon-simple',
				//'border-top-right-radius' => '.icon-simple',
				//'border-bottom-left-radius' => '.icon-simple',
				//'border-bottom-right-radius' => '.icon-simple',
				// Border
				//'border-top-width' => '.icon-simple',
				//'border-right-width' => '.icon-simple',
				//'border-bottom-width' => '.icon-simple',
				//'border-left-width' => '.icon-simple',
				//'border-style' => '.icon-simple',
				'border-color' => 'a.text-separator.with-icon .text-btn',
				// Hovers
				'color-hover' => 'a:hover .icon-simple',
				'border-color-hover' => 'a.text-separator.with-icon:hover .text-btn',
				'background-color-hover' => 'a.icon-cover.with-icon:hover .icon-simple',
			),
			'mob_hr_css' => array(
				'background-color' => 'a hr',
				// Hovers
				'background-color-hover' => 'a:hover hr',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_button;
	$ivan_vc_button = new WPBakeryShortCode_ivan_button( array('name' => 'Button', 'base' => 'ivan_button') );

} // #end class check

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	class WPBakeryShortCode_ivan_dual_btn extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'align' => 'to-center',
				'middle_txt' => '',
				'css_animation' => '',
				'template' => 'large-borders',
				'el_class' => '',
			), $atts) );

			$output = '';

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

			//$template = 'thin-borders';
			//$template = 'no-borders';

			// Add custom template class
			if('' != $template)
				$align .= ' ' . $template;

			if($middle_txt != '')
				$middle_txt = '<span class="middle-text"><span class="middle-inner">'.$middle_txt.'</span></span>';

			$output .= '<div class="ivan-dual-button '.$align.' '. $prefixClass . ' ' . $this->getCSSAnimation($css_animation).'"><div class="buttons">'.do_shortcode($content). '</div></div>';

			$output = str_replace(array("\n", "\t", "\r"), '', $output);

			$output = str_replace('</a></div><div', '</a>'.$middle_txt.'</div><div', $output);

			//
			// Customizer CSS Output
			//
				$style = '';
				foreach ($this->selectors as $key => $value) {
					if( isset($atts[$key]) && '' != $atts[$key]) {
						$style .= ivan_vc_customizer_get_style( $atts[$key], $this->selectors[$key], $this->prefix, $key );
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
			'mid_css' => array(
				// Font
				'font-family' => '.middle-text',
				'font-weight' => '.middle-text',
				'font-size' => '.middle-text',
				//'line-height' => '.middle-text',
				'text-transform' => '.middle-text',
				'color' => '.middle-text',
				// Dimensions
				'width' => '.middle-text',
				'height' => '.middle-text',
				// Spacing
				//'margin-top' => '.middle-text',
				//'margin-right' => '.middle-text',
				//'margin-bottom' => '.middle-text',
				//'margin-left' => '.middle-text',
				//'padding-top' => '.middle-text',
				//'padding-right' => '.middle-text',
				//'padding-bottom' => '.middle-text',
				//'padding-left' => '.middle-text',
				// Bg
				'background-color' => '.middle-text',
				// Border Radius
				'border-top-left-radius' => '.middle-text',
				'border-top-right-radius' => '.middle-text',
				'border-bottom-left-radius' => '.middle-text',
				'border-bottom-right-radius' => '.middle-text',
				// Border
				'border-top-width' => '.middle-text',
				'border-right-width' => '.middle-text',
				'border-bottom-width' => '.middle-text',
				'border-left-width' => '.middle-text',
				'border-style' => '.middle-text',
				'border-color' => '.middle-text',
				// Hovers
				'color-hover' => '&:hover .middle-text',
				'border-color-hover' => '&:hover .middle-text',
				'background-color-hover' => '&:hover .middle-text',
			),
			'mob_mid_css' => array(
				// Font
				'font-family' => '.middle-text',
				'font-weight' => '.middle-text',
				'font-size' => '.middle-text',
				//'line-height' => '.middle-text',
				'text-transform' => '.middle-text',
				//'color' => '.middle-text',
				// Dimensions
				'width' => '.middle-text',
				'height' => '.middle-text',
				// Spacing
				//'margin-top' => '.middle-text',
				//'margin-right' => '.middle-text',
				//'margin-bottom' => '.middle-text',
				//'margin-left' => '.middle-text',
				//'padding-top' => '.middle-text',
				//'padding-right' => '.middle-text',
				//'padding-bottom' => '.middle-text',
				//'padding-left' => '.middle-text',
				// Bg
				//'background-color' => '.middle-text',
				// Border Radius
				//'border-top-left-radius' => '.middle-text',
				//'border-top-right-radius' => '.middle-text',
				//'border-bottom-left-radius' => '.middle-text',
				//'border-bottom-right-radius' => '.middle-text',
				// Border
				'border-top-width' => '.middle-text',
				'border-right-width' => '.middle-text',
				'border-bottom-width' => '.middle-text',
				'border-left-width' => '.middle-text',
				//'border-style' => '.middle-text',
				//'border-color' => '.middle-text',
				// Hovers
				//'color-hover' => '&:hover .middle-text',
				//'border-color-hover' => '&:hover .middle-text',
				//'background-color-hover' => '&:hover .middle-text',
			),
		);

		public $prefix = '';

	} // end class

	global $ivan_vc_dual_btn;
	$ivan_vc_dual_btn = new WPBakeryShortCode_ivan_dual_btn( array('name' => 'Dual Button', 'base' => 'dual_btn') );
}