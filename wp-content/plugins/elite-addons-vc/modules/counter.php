<?php
/***
 * Module > Counter
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_counter extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'ico_family' => '',
				'ico' => '',
				'ico_custom' => '',
				'sub' => '',
				'animated' => '', // yes to animate the numbers
				'separator' => ',', // separator to thousand values
				'decimals' => '0', // number of decimal places
				'decimal' => '.', // separator to decimal values
				'prefix' => '', // Added before the number, e.g. $
				'sufix' => '', // Added after number, e.g. %
				'start' => '0', // number from where start
				'duration' => '2.5', // number in seconds of duration
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';
			$inner_classes = '';

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

			if( $icon_markup != '' )
				$classes .= ' with-icon';

			// Output Form
			ob_start();
			?>
			<div class="ivan-counter-main <?php echo $prefixClass; ?>">
				<div class="ivan-counter-wrapper <?php echo $classes; ?>">
					<div class="counter-wrapper <?php echo $inner_classes; ?>">
						<?php
						if( $icon_markup != '') : ?>
							<div class="icon-above">
								<?php echo $icon_markup; ?>
							</div>
						<?php endif; ?>
						<?php if($content != '') : ?>
						<h2 id="<?php echo str_replace(' ', '', $prefixClass); ?>-counter">
							<?php echo do_shortcode($content); ?>
						</h2>
						<?php endif; ?>
						<?php if('' != $sub) : ?>
							<div class="sub"><?php echo do_shortcode($sub); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
			$output .= ob_get_clean();

			$counterCode = '';

			if( $animated == 'yes' && $content != '' ) :

				$counterCode .= '
				var options = {
				  useEasing : true, 
				  useGrouping : true, 
				  separator : "'.$separator.'", 
				  decimal : "'.$decimal.'",
				  prefix : "'.$prefix.'",
				  suffix : "'.$sufix.'"
				}';

				$var_num = str_replace(' ', '', $prefixClass);

				$counterCode .= '
				var _iv_counter = new countUp("'.$var_num.'-counter", '.$start.', '.str_replace(',', '', $content).', '.$decimals.', '.$duration.', options);
				
				if (typeof jQuery.fn.waypoint !== "undefined") {
				  jQuery("#'.$var_num.'-counter").parents(".ivan-counter-wrapper:not(.counter_started)").waypoint(function () {
				  	_iv_counter.start();				    
				  }, { offset:"85%" });
				}
				';

				if(!is_admin()) {

					$output .= '<script type="text/javascript">
						jQuery(document).ready( function() {
							';
						
						$output .= $counterCode;
					
						
					$output .= '});</script>';
				
				}
				/*
				else {
					$output .= '<textarea class="ivan-script">

						jQuery(document).ready( function() {
							';

							$output .= $counterCode;

					$output .= '});</textarea>';
				}
				*/

			endif; // end animated if		

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
				'font-family' => '.ivan-counter-wrapper',
				//'font-weight' => '',
				//'font-size' => '',
				//'line-height' => '',
				//'text-transform' => '',
				//'color' => '',
				// Spacing
				'margin-top' => '.ivan-counter-wrapper',
				'margin-right' => '.ivan-counter-wrapper',
				'margin-bottom' => '.ivan-counter-wrapper',
				'margin-left' => '.ivan-counter-wrapper',
				'padding-top' => '.ivan-counter-wrapper',
				'padding-right' => '.ivan-counter-wrapper',
				'padding-bottom' => '.ivan-counter-wrapper',
				'padding-left' => '.ivan-counter-wrapper',
				// Bg
				'background-color' => '.ivan-counter-wrapper',
				// Border Radius
				'border-top-left-radius' => '.ivan-counter-wrapper',
				'border-top-right-radius' => '.ivan-counter-wrapper',
				'border-bottom-left-radius' => '.ivan-counter-wrapper',
				'border-bottom-right-radius' => '.ivan-counter-wrapper',
				// Border
				'border-top-width' => '.ivan-counter-wrapper',
				'border-right-width' => '.ivan-counter-wrapper',
				'border-bottom-width' => '.ivan-counter-wrapper',
				'border-left-width' => '.ivan-counter-wrapper',
				'border-style' => '.ivan-counter-wrapper',
				'border-color' => '.ivan-counter-wrapper',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'title_css' => array(
				// Font
				'font-family' => 'h2',
				'font-weight' => 'h2',
				'font-size' => 'h2',
				'line-height' => 'h2',
				'text-transform' => 'h2',
				'color' => 'h2',
				// Spacing
				'margin-top' => '.counter-wrapper',
				'margin-right' => '.counter-wrapper',
				'margin-bottom' => '.counter-wrapper',
				'margin-left' => '.counter-wrapper',
				'padding-top' => '.counter-wrapper',
				'padding-right' => '.counter-wrapper',
				'padding-bottom' => '.counter-wrapper',
				'padding-left' => '.counter-wrapper',
				// Bg
				'background-color' => '.counter-wrapper',
				// Border Radius
				'border-top-left-radius' => '.counter-wrapper',
				'border-top-right-radius' => '.counter-wrapper',
				'border-bottom-left-radius' => '.counter-wrapper',
				'border-bottom-right-radius' => '.counter-wrapper',
				// Border
				'border-top-width' => '.counter-wrapper',
				'border-right-width' => '.counter-wrapper',
				'border-bottom-width' => '.counter-wrapper',
				'border-left-width' => '.counter-wrapper',
				'border-style' => '.counter-wrapper',
				'border-color' => '.counter-wrapper',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
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
			'icon_css' => array(
				// Font
				'font-size' => '.icon-above',
				'color' => '.icon-above',
				// Spacing
				'margin-top' => '.icon-above',
				'margin-right' => '.icon-above',
				'margin-bottom' => '.icon-above',
				'margin-left' => '.icon-above',
				'padding-top' => '.icon-above',
				'padding-right' => '.icon-above',
				'padding-bottom' => '.icon-above',
				'padding-left' => '.icon-above',
				// Bg
				'background-color' => '.icon-above',
				// Border Radius
				'border-top-left-radius' => '.icon-above',
				'border-top-right-radius' => '.icon-above',
				'border-bottom-left-radius' => '.icon-above',
				'border-bottom-right-radius' => '.icon-above',
				// Border
				'border-top-width' => '.icon-above',
				'border-right-width' => '.icon-above',
				'border-bottom-width' => '.icon-above',
				'border-left-width' => '.icon-above',
				'border-style' => '.icon-above',
				'border-color' => '.icon-above',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),			
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_counter;
	$ivan_vc_counter = new WPBakeryShortCode_ivan_counter( array('name' => 'Counter', 'base' => 'ivan_counter') );

} // #end class check