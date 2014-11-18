<?php
/***
 * Module > Pie Chart
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_pie_chart extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'percent' => '95',
				'normal_color' => '',
				'active_color' => '',
				'line_width' => '',
				'heading' => '',
				'heading_tag' => 'h4',
				'separator' => '', // yes or no
				'width' => '',

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

			// Default values to pie chart
			if( $template == '' ) {
				if( $normal_color == '' )
					$normal_color = apply_filters('ivan_pie_chart_normal_color', '#f7f7f7');

				if( $active_color == '' )
					$active_color = apply_filters('ivan_pie_chart_active_color', '#c0c0c0' );
			}
			// Clean Template
			else if( $template == 'clean-color' ) {
				if( $normal_color == '' )
					$normal_color = apply_filters('ivan_pie_chart_normal_white', 'rgba(255, 255, 255, 0.4)' );

				if( $active_color == '' )
					$active_color = apply_filters('ivan_pie_chart_active_white', '#ffffff');
			}
			// Gray Template
			else if( $template == 'gray-bg' ) {
				if( $normal_color == '' )
					$normal_color = apply_filters('ivan_pie_chart_normal_gray', '#ddd' );

				if( $active_color == '' )
					$active_color = apply_filters('ivan_pie_chart_active_gray', '#bbb');
			}
			// Dark Template
			else if( $template == 'dark-bg' ) {
				if( $normal_color == '' )
					$normal_color = apply_filters('ivan_pie_chart_normal_dark', '#7F7F7F' );

				if( $active_color == '' )
					$active_color = apply_filters('ivan_pie_chart_active_dark', '#2B333B');
			}
			// Primary Template
			else if( $template == 'primary-bg' ) {
				if( $normal_color == '' )
					$normal_color = apply_filters('ivan_pie_chart_normal_primary', '#f7f7f7' );

				if( $active_color == '' )
					$active_color = apply_filters('ivan_pie_chart_active_primary', '#2AC56C');
			}

			if( $line_width == '' )
				$line_width = apply_filters('ivan_pie_chart_line_width', 10);

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>

			<div class="ivan-pie-chart-wrapper <?php echo $prefixClass; ?>">
				<div class="ivan-pie-chart-holder <?php echo $classes; ?>">
				
					<div class="ivan-pie-chart" data-percent="<?php echo $percent; ?>" <?php if($width != '') echo ' data-piewidth="'.$width.'"'; ?> data-linewidth="<?php echo $line_width; ?>" data-normalbg="<?php echo $normal_color; ?>" data-active="<?php echo $active_color; ?>">
						<span class="pie-chart-counter"><span class="pie-chart-counter-inner"><?php echo $percent; ?></span>%</span>
					</div>

					<?php if( $heading != '' OR $content != '' ) : ?>
						<div class="ivan-pie-chart-content">
							<?php if( $heading != '' ) : ?>
								<<?php echo $heading_tag; ?> class="pie-chart-heading"><?php echo $heading; ?></<?php echo $heading_tag; ?>>
								
								<?php if($separator == 'yes') : ?>
									<div class="ivan-vc-separator small"></div>
								<?php endif; ?>

								<?php if($content != '' ) : ?>
									<div class="pie-chart-content-inner">
										<?php echo do_shortcode($content); ?>
									</div>
								<?php endif; ?>

							<?php endif; ?>

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
				//'font-family' => '.ivan-pie-chart-holder',
				//'font-weight' => '.ivan-pie-chart-holder',
				//'font-size' => '.ivan-pie-chart-holder',
				//'line-height' => '.ivan-pie-chart-holder',
				//'text-transform' => '.ivan-pie-chart-holder',
				//'color' => '.ivan-pie-chart-holder',
				// Dimensions
				//'width' => '.ivan-pie-chart-holder',
				//'height' => '.ivan-pie-chart-holder',
				// Spacing
				'margin-top' => '.ivan-pie-chart-holder',
				'margin-right' => '.ivan-pie-chart-holder',
				'margin-bottom' => '.ivan-pie-chart-holder',
				'margin-left' => '.ivan-pie-chart-holder',
				'padding-top' => '.ivan-pie-chart-holder',
				'padding-right' => '.ivan-pie-chart-holder',
				'padding-bottom' => '.ivan-pie-chart-holder',
				'padding-left' => '.ivan-pie-chart-holder',
				// Bg
				'background-color' => '.ivan-pie-chart-holder',
				// Border Radius
				'border-top-left-radius' => '.ivan-pie-chart-holder',
				'border-top-right-radius' => '.ivan-pie-chart-holder',
				'border-bottom-left-radius' => '.ivan-pie-chart-holder',
				'border-bottom-right-radius' => '.ivan-pie-chart-holder',
				// Border
				'border-top-width' => '.ivan-pie-chart-holder',
				'border-right-width' => '.ivan-pie-chart-holder',
				'border-bottom-width' => '.ivan-pie-chart-holder',
				'border-left-width' => '.ivan-pie-chart-holder',
				'border-style' => '.ivan-pie-chart-holder',
				'border-color' => '.ivan-pie-chart-holder',
				// Hovers
				//'color-hover' => '.ivan-pie-chart-holder',
				//'border-color-hover' => '.ivan-pie-chart-holder',
				//'background-color-hover' => '.ivan-pie-chart-holder',
			),
			'counter_css' => array(
				// Font
				'font-family' => '.pie-chart-counter',
				'font-weight' => '.pie-chart-counter',
				'font-size' => '.pie-chart-counter',
				//'line-height' => '.pie-chart-counter',
				//'text-transform' => '.pie-chart-counter',
				'color' => '.pie-chart-counter',
				// Dimensions
				//'width' => '.pie-chart-counter',
				//'height' => '.pie-chart-counter',
				// Spacing
				//'margin-top' => '.pie-chart-counter',
				//'margin-right' => '.pie-chart-counter',
				//'margin-bottom' => '.pie-chart-counter',
				//'margin-left' => '.pie-chart-counter',
				//'padding-top' => '.pie-chart-counter',
				//'padding-right' => '.pie-chart-counter',
				//'padding-bottom' => '.pie-chart-counter',
				//'padding-left' => '.pie-chart-counter',
				// Bg
				//'background-color' => '.pie-chart-counter',
				// Border Radius
				//'border-top-left-radius' => '.pie-chart-counter',
				//'border-top-right-radius' => '.pie-chart-counter',
				//'border-bottom-left-radius' => '.pie-chart-counter',
				//'border-bottom-right-radius' => '.pie-chart-counter',
				// Border
				//'border-top-width' => '.pie-chart-counter',
				//'border-right-width' => '.pie-chart-counter',
				//'border-bottom-width' => '.pie-chart-counter',
				//'border-left-width' => '.pie-chart-counter',
				//'border-style' => '.pie-chart-counter',
				//'border-color' => '.pie-chart-counter',
				// Hovers
				//'color-hover' => '.pie-chart-counter',
				//'border-color-hover' => '.pie-chart-counter',
				//'background-color-hover' => '.pie-chart-counter',
			),
			'title_css' => array(
				// Font
				'font-family' => '.pie-chart-heading',
				'font-weight' => '.pie-chart-heading',
				'font-size' => '.pie-chart-heading',
				'line-height' => '.pie-chart-heading',
				'text-transform' => '.pie-chart-heading',
				'color' => '.pie-chart-heading',
				// Dimensions
				//'width' => '.pie-chart-heading',
				//'height' => '.pie-chart-heading',
				// Spacing
				'margin-top' => '.pie-chart-heading',
				'margin-right' => '.pie-chart-heading',
				'margin-bottom' => '.pie-chart-heading',
				'margin-left' => '.pie-chart-heading',
				//'padding-top' => '.pie-chart-heading',
				//'padding-right' => '.pie-chart-heading',
				//'padding-bottom' => '.pie-chart-heading',
				//'padding-left' => '.pie-chart-heading',
				// Bg
				//'background-color' => '.pie-chart-heading',
				// Border Radius
				//'border-top-left-radius' => '.pie-chart-heading',
				//'border-top-right-radius' => '.pie-chart-heading',
				//'border-bottom-left-radius' => '.pie-chart-heading',
				//'border-bottom-right-radius' => '.pie-chart-heading',
				// Border
				//'border-top-width' => '.pie-chart-heading',
				//'border-right-width' => '.pie-chart-heading',
				//'border-bottom-width' => '.pie-chart-heading',
				//'border-left-width' => '.pie-chart-heading',
				//'border-style' => '.pie-chart-heading',
				//'border-color' => '.pie-chart-heading',
				// Hovers
				//'color-hover' => '.pie-chart-heading',
				//'border-color-hover' => '.pie-chart-heading',
				//'background-color-hover' => '.pie-chart-heading',
			),
			'sep_css' => array(
				// Font
				//'font-family' => '.ivan-vc-separator small',
				//'font-weight' => '.ivan-vc-separator small',
				//'font-size' => '.ivan-vc-separator small',
				//'line-height' => '.ivan-vc-separator small',
				//'text-transform' => '.ivan-vc-separator small',
				//'color' => '.ivan-vc-separator small',
				// Dimensions
				'width' => '.ivan-vc-separator small',
				'height' => '.ivan-vc-separator small',
				// Spacing
				//'margin-top' => '.ivan-vc-separator small',
				'margin-right' => '.ivan-vc-separator small',
				'margin-bottom' => '.ivan-vc-separator small',
				'margin-left' => '.ivan-vc-separator small',
				//'padding-top' => '.ivan-vc-separator small',
				//'padding-right' => '.ivan-vc-separator small',
				//'padding-bottom' => '.ivan-vc-separator small',
				//'padding-left' => '.ivan-vc-separator small',
				// Bg
				'background-color' => '.ivan-vc-separator small',
				// Border Radius
				//'border-top-left-radius' => '.ivan-vc-separator small',
				//'border-top-right-radius' => '.ivan-vc-separator small',
				//'border-bottom-left-radius' => '.ivan-vc-separator small',
				//'border-bottom-right-radius' => '.ivan-vc-separator small',
				// Border
				//'border-top-width' => '.ivan-vc-separator small',
				//'border-right-width' => '.ivan-vc-separator small',
				//'border-bottom-width' => '.ivan-vc-separator small',
				//'border-left-width' => '.ivan-vc-separator small',
				//'border-style' => '.ivan-vc-separator small',
				//'border-color' => '.ivan-vc-separator small',
				// Hovers
				//'color-hover' => '.ivan-vc-separator small',
				//'border-color-hover' => '.ivan-vc-separator small',
				//'background-color-hover' => '.ivan-vc-separator small',
			),
			'text_css' => array(
				// Font
				'font-family' => '.pie-chart-content-inner',
				'font-weight' => '.pie-chart-content-inner',
				'font-size' => '.pie-chart-content-inner',
				'line-height' => '.pie-chart-content-inner',
				'text-transform' => '.pie-chart-content-inner',
				'color' => '.pie-chart-content-inner, .pie-chart-content-inner a',
				// Dimensions
				//'width' => '.pie-chart-content-inner',
				//'height' => '.pie-chart-content-inner',
				// Spacing
				//'margin-top' => '.pie-chart-content-inner',
				//'margin-right' => '.pie-chart-content-inner',
				//'margin-bottom' => '.pie-chart-content-inner',
				//'margin-left' => '.pie-chart-content-inner',
				//'padding-top' => '.pie-chart-content-inner',
				//'padding-right' => '.pie-chart-content-inner',
				//'padding-bottom' => '.pie-chart-content-inner',
				//'padding-left' => '.pie-chart-content-inner',
				// Bg
				//'background-color' => '.pie-chart-content-inner',
				// Border Radius
				//'border-top-left-radius' => '.pie-chart-content-inner',
				//'border-top-right-radius' => '.pie-chart-content-inner',
				//'border-bottom-left-radius' => '.pie-chart-content-inner',
				//'border-bottom-right-radius' => '.pie-chart-content-inner',
				// Border
				//'border-top-width' => '.pie-chart-content-inner',
				//'border-right-width' => '.pie-chart-content-inner',
				//'border-bottom-width' => '.pie-chart-content-inner',
				//'border-left-width' => '.pie-chart-content-inner',
				//'border-style' => '.pie-chart-content-inner',
				//'border-color' => '.pie-chart-content-inner',
				// Hovers
				//'color-hover' => '.pie-chart-content-inner',
				//'border-color-hover' => '.pie-chart-content-inner',
				//'background-color-hover' => '.pie-chart-content-inner',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_pie_chart;
	$ivan_vc_pie_chart = new WPBakeryShortCode_ivan_pie_chart( array('name' => 'Pie Chart', 'base' => 'ivan_pie_chart') );

} // #end class check