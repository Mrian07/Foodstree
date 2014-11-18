<?php
/***
 * Module > Message
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_message extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'type' => '',
				'msg_type' => 'info',
				'ico_family' => 'fa fa-',
				'ico' => '',
				'ico_custom' => '',
				'ico_size' => 'fa-lg',
				'el_class' => '',
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

			// Type
			$classes .= ' ' . $type;

			// Msg Type
			$classes .= ' ' . $msg_type;

			// Set Default Icons
			if( $type == 'with-icon' && '' == $ico && '' == $ico_custom) {
				if( $msg_type == 'info')
					$ico = 'bell-o';
				else if( $msg_type == 'success')
					$ico = 'check';
				else if( $msg_type == 'warning')
					$ico = 'exclamation';
				else if( $msg_type == 'error' )
					$ico = 'close';
			}

			// El Class
			$classes .= ' '. $el_class;

			// Font Icon
			$icon_markup = '';

			if('' != $ico) :
				$icon_markup = '<i class="'.$ico_family.$ico.' '.$ico_size.'"></i>';
			endif;

			if('' != $ico_custom) :
				$icon_markup = '<i class="'.$ico_custom.' '.$ico_size.'"></i>';
			endif;

			// Output Form
			ob_start();
			?>

			<div class="ivan-message-wrapper <?php echo $prefixClass; ?>"><!-- adds prefix class -->
				<div class="ivan-message <?php echo $classes; ?>">
					<div class="ivan-message-inner">

						<?php if($type == 'with-icon') : ?>
							<div class="ivan-message-icon-holder"><div class="ivan-message-icon"><div class="ivan-message-icon-inner">
								<?php echo $icon_markup; ?>
							</div></div></div>
						<?php endif; ?>

						<div class="ivan-message-text-holder"><div class="ivan-message-text"><div class="ivan-message-text-inner">
							<?php echo do_shortcode($content); ?>
						</div></div></div>

					</div><!-- .message-inner -->

					<a href="#" class="close"><i class="fa fa-times"></i></a>
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
				//'font-family' => '.ivan-message',
				//'font-weight' => '.ivan-message',
				//'font-size' => '.ivan-message',
				//'line-height' => '.ivan-message',
				//'text-transform' => '.ivan-message',
				//'color' => '.ivan-message',
				// Spacing
				'margin-top' => '.ivan-message',
				'margin-right' => '.ivan-message',
				'margin-bottom' => '.ivan-message',
				'margin-left' => '.ivan-message',
				'padding-top' => '.ivan-message',
				'padding-right' => '.ivan-message',
				'padding-bottom' => '.ivan-message',
				'padding-left' => '.ivan-message',
				// Bg
				'background-color' => '.ivan-message',
				// Border Radius
				'border-top-left-radius' => '.ivan-message, .ivan-message-icon-holder',
				'border-top-right-radius' => '.ivan-message',
				'border-bottom-left-radius' => '.ivan-message, .ivan-message-icon-holder',
				'border-bottom-right-radius' => '.ivan-message',
				// Border
				'border-top-width' => '.ivan-message',
				'border-right-width' => '.ivan-message',
				'border-bottom-width' => '.ivan-message',
				'border-left-width' => '.ivan-message',
				'border-style' => '.ivan-message',
				'border-color' => '.ivan-message',
				// Hovers
				//'color-hover' => '.ivan-message',
				//'border-color-hover' => '.ivan-message',
				//'background-color-hover' => '.ivan-message',
			),
			'msg_css' => array(
				// Font
				'font-family' => '.ivan-message-text',
				'font-weight' => '.ivan-message-text',
				'font-size' => '.ivan-message-text',
				'line-height' => '.ivan-message-text',
				'text-transform' => '.ivan-message-text',
				'color' => '.ivan-message-text, a.close',
				// Spacing
				//'margin-top' => '.ivan-message-text',
				//'margin-right' => '.ivan-message-text',
				//'margin-bottom' => '.ivan-message-text',
				//'margin-left' => '.ivan-message-text',
				//'padding-top' => '.ivan-message-text',
				//'padding-right' => '.ivan-message-text',
				//'padding-bottom' => '.ivan-message-text',
				//'padding-left' => '.ivan-message-text',
				// Bg
				//'background-color' => '.ivan-message-text',
				// Border Radius
				//'border-top-left-radius' => '.ivan-message-text',
				//'border-top-right-radius' => '.ivan-message-text',
				//'border-bottom-left-radius' => '.ivan-message-text',
				//'border-bottom-right-radius' => '.ivan-message-text',
				// Border
				//'border-top-width' => '.ivan-message-text',
				//'border-right-width' => '.ivan-message-text',
				//'border-bottom-width' => '.ivan-message-text',
				//'border-left-width' => '.ivan-message-text',
				//'border-style' => '.ivan-message-text',
				//'border-color' => '.ivan-message-text',
				// Hovers
				//'color-hover' => '.ivan-message-text',
				//'border-color-hover' => '.ivan-message-text',
				//'background-color-hover' => '.ivan-message-text',
			),
			'icon_css' => array(
				// Font
				//'font-family' => '.pull-left',
				//'font-weight' => '.pull-left',
				'font-size' => '.ivan-message-icon i',
				//'line-height' => '.pull-left',
				//'text-transform' => '.pull-left',
				'color' => '.ivan-message-icon i',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_message;
	$ivan_vc_message = new WPBakeryShortCode_ivan_message( array('name' => 'Message', 'base' => 'ivan_message') );

} // #end class check