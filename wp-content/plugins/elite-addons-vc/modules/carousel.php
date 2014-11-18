<?php
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	class WPBakeryShortCode_ivan_carousel extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;

			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'ivan_columns' => '1',
					'ivan_columns_desktop' => '',
					'ivan_columns_desktop_small' => '',
					'ivan_columns_tablet' => '',
					'ivan_columns_mobile' => '',
				'margin' => '', // normal
				'ivan_carousel_nav' => 'no',
				'ivan_carousel_bullets' => 'yes',
					'ivan_bullets_h' => '',
					'ivan_bullets_v' => '',
				'arrows_hover' => '',
				'mouse_drag' => 'yes',
				'el_class' => '',
				'template' => '',
				'arr_style' => 'style-outline-circle',
				'force_g' => 'yes',
			), $atts) );

			wp_enqueue_script( 'ivan_owl_carousel' );
			wp_enqueue_style( 'ivan_owl_carousel' );

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

			// Apply force gray cirlce
			if( $ivan_bullets_v == '' && $ivan_carousel_bullets == 'yes' && $force_g == 'yes'  ) {
				$arr_style .= ' outer-gray';
				$el_class .= ' outer-gray';
			}

			if( $ivan_bullets_v == '' && $ivan_carousel_bullets == 'yes' ) {
				$arr_style .= ' with-bullets';
				$el_class .= ' with-bullets';
			}

			$arrow_styles = $arr_style; // adds the final style

			$output = '';

			$class = '';

			if(!is_admin())
				$class = 'owl-carousel';

			$class .= ' ' . $ivan_bullets_h;
			$class .= ' ' . $ivan_bullets_v;

			// Add custom template class
			if('' != $template)
				$class .= ' ' . $template;

			if('yes' == $arrows_hover)
				$class .= ' arrows-at-hover';

			//if(is_admin())
			//	$output .= '<div class="ivan-carousel-preview preview-'. $prefixClass .'">Carousel: <a href="#" class="on">On</a><a href="#" class="off">Off</a></div>';

			$output .= '<div class="ivan-carousel '. $el_class . ' ' . $prefixClass .'">';

			if( $margin == 'normal' )
				$output .= '<div class="row">';

					$output .= '<div class="carousel-wrapper '.$class.'">';

						$output .= do_shortcode($content);

					$output .= '</div>';

				if( $margin == 'normal' )
					$output .= '</div>';

			$output .= '</div>';

			$wrapDivsCode = '';

			if( $margin == 'normal' )
				$wrapDivsCode .= '_this.children().wrap( \'<div class="col-xs-12 col-sm-12 col-md-12"></div>\' );';

			$carouselCode = '_this.owlCarousel({';

				// Items configuration
				$carouselCode .= 'items:' . $ivan_columns . ',';
				$carouselCode .= 'theme:' . '"'. $arrow_styles . '",'; // defines theme
				if($ivan_columns == '1')
					$carouselCode .= 'singleItem: true,';

				if('' != $ivan_columns_desktop)
					$carouselCode .= 'itemsDesktop:[1199,'.$ivan_columns_desktop.'],';

				if('' != $ivan_columns_desktop_small)
					$carouselCode .= 'itemsDesktopSmall:[980,'.$ivan_columns_desktop_small.'],';

				if('' != $ivan_columns_tablet)
					$carouselCode .= 'itemsTablet:[768,'.$ivan_columns_tablet.'],';

				if('' != $ivan_columns_mobile)
					$carouselCode .= 'itemsMobile:[479,'.$ivan_columns_mobile.'],';

				if('no' == $ivan_carousel_bullets)
					$carouselCode .= 'pagination : false,';

				if('yes' == $ivan_carousel_nav) {
				$carouselCode .= 'navigation: true,
					navigationText: [\'<i class="fa fa-angle-left"></i>\', \'<i class="fa fa-angle-right"></i>\'],';
				}

				if('no' == $mouse_drag)
					$carouselCode .= 'mouseDrag : false,';

			$carouselCode .= 'autoHeight : true }); var _navH = 0;';

			if( !is_admin() ) {
			$output .= '<script type="text/javascript">
				jQuery(document).ready(function() {

					var _this = jQuery("'.$this->prefix.' .carousel-wrapper");

					'.$wrapDivsCode.'

					'.$carouselCode.'

				});
				</script>';
			}

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
				'margin-top' => '&',
				'margin-right' => '&',
				'margin-bottom' => '&',
				'margin-left' => '&',
				'padding-top' => '&',
				'padding-right' => '&',
				'padding-bottom' => '&',
				'padding-left' => '&',
			),
			'bullets_css' => array(
				// Font
				//'font-family' => '.ivan-vc-filters a',
				//'font-weight' => '.ivan-vc-filters a',
				//'font-size' => '.ivan-vc-filters a',
				//'line-height' => '.ivan-vc-filters a',
				//'text-transform' => '.ivan-vc-filters a',
				//'color' => '.owl-buttons div',
				// Dimensions
				'width' => '.owl-controls .owl-page span',
				'height' => '.owl-controls .owl-page span',
				// Spacing
				'margin-top' => '.owl-pagination',
				'margin-bottom' => '.owl-pagination',
				'margin-right' => '.owl-controls .owl-page span',
				'margin-left' => '.owl-controls .owl-page span',
				'padding-top' => '.owl-controls .owl-page span',
				'padding-right' => '.owl-controls .owl-page span',
				'padding-bottom' => '.owl-controls .owl-page span',
				'padding-left' => '.owl-controls .owl-page span',
				// Border Radius
				'border-top-left-radius' => '.owl-controls .owl-page span',
				'border-top-right-radius' => '.owl-controls .owl-page span',
				'border-bottom-left-radius' => '.owl-controls .owl-page span',
				'border-bottom-right-radius' => '.owl-controls .owl-page span',
				// Bg
				'background-color' => '.owl-controls .owl-page span',
				// Border
				'border-top-width' => '.owl-controls .owl-page span',
				'border-right-width' => '.owl-controls .owl-page span',
				'border-bottom-width' => '.owl-controls .owl-page span',
				'border-left-width' => '.owl-controls .owl-page span',
				'border-style' => '.owl-controls .owl-page span',
				'border-color' => '.owl-controls .owl-page span',
				// Hovers
				//'color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
				'border-color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
				'background-color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
			),
			'navigation_css' => array(
				// Font
				//'font-family' => '.ivan-vc-filters a',
				//'font-weight' => '.ivan-vc-filters a',
				'font-size' => '.owl-buttons div',
				//'line-height' => '.ivan-vc-filters a',
				//'text-transform' => '.ivan-vc-filters a',
				'color' => '.owl-buttons div',
				// Dimensions
				'width' => '.owl-buttons div',
				'height' => '.owl-buttons div',
				// Spacing
				'padding-top' => '.owl-buttons div',
				'padding-right' => '.owl-buttons div',
				'padding-bottom' => '.owl-buttons div',
				'padding-left' => '.owl-buttons div',
				// Border Radius
				'border-top-left-radius' => '.owl-buttons div',
				'border-top-right-radius' => '.owl-buttons div',
				'border-bottom-left-radius' => '.owl-buttons div',
				'border-bottom-right-radius' => '.owl-buttons div',
				// Bg
				'background-color' => '.owl-buttons div',
				// Border
				'border-top-width' => '.owl-buttons div',
				'border-right-width' => '.owl-buttons div',
				'border-bottom-width' => '.owl-buttons div',
				'border-left-width' => '.owl-buttons div',
				'border-style' => '.owl-buttons div',
				'border-color' => '.owl-buttons div',
				// Hovers
				'color-hover' => '.owl-buttons div:hover',
				'border-color-hover' => '.owl-buttons div:hover',
				'background-color-hover' => '.owl-buttons div:hover',
			),
		);

		public $prefix = '';

	} // end class

	global $ivan_vc_carousel;
	$ivan_vc_carousel = new WPBakeryShortCode_ivan_carousel( array('name' => 'Content Carousel', 'base' => 'ivan_carousel') );
}