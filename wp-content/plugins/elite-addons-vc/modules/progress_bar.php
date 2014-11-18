<?php
/***
 * Module > Button
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_progress extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'title' => '',
				'title_tag' => 'h5',
				'percent' => '',
				'height' => '',
				'hide_per' => '',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';
			$heightStyle = '';

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

			// Custom height
			if($height != '')
				$heightStyle = ' style="height:' . ivan_style_val( $height ) . ';"';

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>

			<div class="ivan-progress-wrapper <?php echo $prefixClass; ?>">
				<div class="ivan-progress <?php echo $classes; ?>">

					<<?php echo $title_tag; ?> class="progress-title-holder">
						<span class="progress-title-text"><?php echo $title; ?></span>
						<?php if( $hide_per != 'yes' ) : ?><span class="progress-title-counter"><span>0</span>%</span><?php endif; ?>
					</<?php echo $title_tag; ?>>

					<div class="ivan-progress-outer"<?php echo $heightStyle; ?>>
						<div class="ivan-progress-inner" data-percentage="<?php echo $percent; ?>"<?php echo $heightStyle; ?>></div>
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
			'block_css' => array(
				// Font
				//'font-family' => '.ivan-progress',
				//'font-weight' => '.ivan-progress',
				//'font-size' => '.ivan-progress',
				//'line-height' => '.ivan-progress',
				//'text-transform' => '.ivan-progress',
				//'color' => '.ivan-progress',
				// Dimensions
				//'width' => '.ivan-progress',
				//'height' => '.ivan-progress',
				// Spacing
				'margin-top' => '.ivan-progress',
				'margin-right' => '.ivan-progress',
				'margin-bottom' => '.ivan-progress',
				'margin-left' => '.ivan-progress',
				//'padding-top' => '.ivan-progress',
				//'padding-right' => '.ivan-progress',
				//'padding-bottom' => '.ivan-progress',
				//'padding-left' => '.ivan-progress',
				// Bg
				//'background-color' => '.ivan-progress',
				// Border Radius
				//'border-top-left-radius' => '.ivan-progress',
				//'border-top-right-radius' => '.ivan-progress',
				//'border-bottom-left-radius' => '.ivan-progress',
				//'border-bottom-right-radius' => '.ivan-progress',
				// Border
				//'border-top-width' => '.ivan-progress',
				//'border-right-width' => '.ivan-progress',
				//'border-bottom-width' => '.ivan-progress',
				//'border-left-width' => '.ivan-progress',
				//'border-style' => '.ivan-progress',
				//'border-color' => '.ivan-progress',
				// Hovers
				//'color-hover' => '.ivan-progress',
				//'border-color-hover' => '.ivan-progress',
				//'background-color-hover' => '.ivan-progress',
			),
			'title_css' => array(
				// Font
				'font-family' => '.progress-title-holder',
				'font-weight' => '.progress-title-holder',
				'font-size' => '.progress-title-holder',
				'line-height' => '.progress-title-holder',
				'text-transform' => '.progress-title-holder',
				'color' => '.progress-title-holder',
				// Dimensions
				//'width' => '.progress-title-holder',
				//'height' => '.progress-title-holder',
				// Spacing
				'margin-top' => '.progress-title-holder',
				'margin-right' => '.progress-title-holder',
				'margin-bottom' => '.progress-title-holder',
				'margin-left' => '.progress-title-holder',
				//'padding-top' => '.progress-title-holder',
				//'padding-right' => '.progress-title-holder',
				//'padding-bottom' => '.progress-title-holder',
				//'padding-left' => '.progress-title-holder',
				// Bg
				//'background-color' => '.progress-title-holder',
				// Border Radius
				//'border-top-left-radius' => '.progress-title-holder',
				//'border-top-right-radius' => '.progress-title-holder',
				//'border-bottom-left-radius' => '.progress-title-holder',
				//'border-bottom-right-radius' => '.progress-title-holder',
				// Border
				//'border-top-width' => '.progress-title-holder',
				//'border-right-width' => '.progress-title-holder',
				//'border-bottom-width' => '.progress-title-holder',
				//'border-left-width' => '.progress-title-holder',
				//'border-style' => '.progress-title-holder',
				//'border-color' => '.progress-title-holder',
				// Hovers
				//'color-hover' => '.progress-title-holder',
				//'border-color-hover' => '.progress-title-holder',
				//'background-color-hover' => '.progress-title-holder',
			),
			'outer_css' => array(
				// Font
				//'font-family' => '.ivan-progress-outer',
				//'font-weight' => '.ivan-progress-outer',
				//'font-size' => '.ivan-progress-outer',
				//'line-height' => '.ivan-progress-outer',
				//'text-transform' => '.ivan-progress-outer',
				//'color' => '.ivan-progress-outer',
				// Dimensions
				//'width' => '.ivan-progress-outer',
				//'height' => '.ivan-progress-outer',
				// Spacing
				'margin-top' => '.ivan-progress-outer',
				'margin-right' => '.ivan-progress-outer',
				'margin-bottom' => '.ivan-progress-outer',
				'margin-left' => '.ivan-progress-outer',
				//'padding-top' => '.ivan-progress-outer',
				//'padding-right' => '.ivan-progress-outer',
				//'padding-bottom' => '.ivan-progress-outer',
				//'padding-left' => '.ivan-progress-outer',
				// Bg
				'background-color' => '.ivan-progress-outer',
				// Border Radius
				'border-top-left-radius' => '.ivan-progress-outer, .ivan-progress-inner',
				'border-top-right-radius' => '.ivan-progress-outer, .ivan-progress-inner',
				'border-bottom-left-radius' => '.ivan-progress-outer, .ivan-progress-inner',
				'border-bottom-right-radius' => '.ivan-progress-outer, .ivan-progress-inner',
				// Border
				'border-top-width' => '.ivan-progress-outer',
				'border-right-width' => '.ivan-progress-outer',
				'border-bottom-width' => '.ivan-progress-outer',
				'border-left-width' => '.ivan-progress-outer',
				'border-style' => '.ivan-progress-outer',
				'border-color' => '.ivan-progress-outer',
				// Hovers
				//'color-hover' => '.ivan-progress-outer',
				//'border-color-hover' => '.ivan-progress-outer',
				//'background-color-hover' => '.ivan-progress-outer',
			),
			'inner_css' => array(
				// Font
				//'font-family' => '.ivan-progress-outer',
				//'font-weight' => '.ivan-progress-outer',
				//'font-size' => '.ivan-progress-outer',
				//'line-height' => '.ivan-progress-outer',
				//'text-transform' => '.ivan-progress-outer',
				//'color' => '.ivan-progress-outer',
				// Dimensions
				//'width' => '.ivan-progress-outer',
				//'height' => '.ivan-progress-outer',
				// Spacing
				//'margin-top' => '.ivan-progress-outer',
				//'margin-right' => '.ivan-progress-outer',
				//'margin-bottom' => '.ivan-progress-outer',
				//'margin-left' => '.ivan-progress-outer',
				//'padding-top' => '.ivan-progress-outer',
				//'padding-right' => '.ivan-progress-outer',
				//'padding-bottom' => '.ivan-progress-outer',
				//'padding-left' => '.ivan-progress-outer',
				// Bg
				'background-color' => '.ivan-progress-inner',
				// Border Radius
				//'border-top-left-radius' => '.ivan-progress-outer',
				//'border-top-right-radius' => '.ivan-progress-outer',
				//'border-bottom-left-radius' => '.ivan-progress-outer',
				//'border-bottom-right-radius' => '.ivan-progress-outer',
				// Border
				//'border-top-width' => '.ivan-progress-outer',
				//'border-right-width' => '.ivan-progress-outer',
				//'border-bottom-width' => '.ivan-progress-outer',
				//'border-left-width' => '.ivan-progress-outer',
				//'border-style' => '.ivan-progress-outer',
				//'border-color' => '.ivan-progress-outer',
				// Hovers
				//'color-hover' => '.ivan-progress-outer',
				//'border-color-hover' => '.ivan-progress-outer',
				//'background-color-hover' => '.ivan-progress-outer',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_progress;
	$ivan_vc_progress = new WPBakeryShortCode_ivan_progress( array('name' => 'Progress Bar', 'base' => 'ivan_progress') );

} // #end class check