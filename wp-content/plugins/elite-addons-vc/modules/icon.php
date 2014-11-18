<?php
/***
 * Module > Icon
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_icon extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'ico' => '',
				'style' => '',
				'size' => 'fa-3x',
				'social_auto' => '',
				'glow' => '',
				'link' => '',
				'target' => '',
				'align' => '',
				'css_animation' => '',
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

			//$style = '';
			//$style = 'square';
			//$link = '';
			//$glow = '';

			// Style
			$classes .= ' ' . $style;

			if( $link != '' )
				$size .= ' with-link';

			if( $glow != '' )
				$classes .= ' glow-icon';

			// El Class
			$classes .= ' '. $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Adds Social Auto Color Support
			if( $social_auto != '' && $style != '' )
				$classes .= ' social-auto sa-' . $ico;

			// Output Form
			ob_start();
			?>

			<div class="ivan-icon-wrapper <?php echo $align; ?> <?php echo $prefixClass; ?>"><!-- adds prefix class -->
				<div class="ivan-icon <?php echo $classes; ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
					
						
						<?php
						switch ($style) {
							case 'circle': ?>

								<span class="fa-stack ivan-font-stack <?php echo $size; ?>">

								<?php if( $link != '' ) : ?>
									<a href="<?php echo $link; ?>" <?php if($target == 'yes') echo 'target="_blank"'; ?>>
								<?php endif;?>

									<i class="stack-holder fa fa-circle fa-stack-base fa-stack-2x"></i>
									<i class="main-icon fa fa-<?php echo $ico; ?> fa-stack-1x"></i>

							<?php
								break;

							case 'square': ?>

								<span class="stack-holder fa-stack ivan-font-stack-square <?php echo $size; ?>">

								<?php if( $link != '' ) : ?>
									<a href="<?php echo $link; ?>" <?php if($target == 'yes') echo 'target="_blank"'; ?>>
								<?php endif;?>

									<i class="main-icon fa fa-<?php echo $ico; ?>"></i>
							
							<?php
								break;
							
							default: ?>
								
								<span class="ivan-font-stack-icon">

								<?php if( $link != '' ) : ?>
									<a href="<?php echo $link; ?>" <?php if($target == 'yes') echo 'target="_blank"'; ?>>
								<?php endif;?>

									<i class="main-icon fa fa-<?php echo $ico; ?>  <?php echo $size; ?>"></i>

							<?php	break;
						} ?>

						<?php if( $link != '' ) : ?>
							</a>
						<?php endif;?>

						</span>
					
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
			'icon_css' => array(
				// Font
				//'font-family' => '*replace',
				//'font-weight' => '*replace',
				'font-size' => '.main-icon',
				//'line-height' => '*replace',
				//'text-transform' => '*replace',
				'color' => '.main-icon',
				// Dimensions
				//'width' => '*replace',
				//'height' => '*replace',
				// Spacing
				'margin-top' => '&',
				'margin-right' => '&',
				'margin-bottom' => '&',
				'margin-left' => '&',
				'padding-top' => '.main-icon',
				'padding-right' => '.main-icon',
				'padding-bottom' => '.main-icon',
				'padding-left' => '.main-icon',
				// Bg
				'background-color' => '.main-icon',
				// Border Radius
				'border-top-left-radius' => '.main-icon',
				'border-top-right-radius' => '.main-icon',
				'border-bottom-left-radius' => '.main-icon',
				'border-bottom-right-radius' => '.main-icon',
				// Border
				'border-top-width' => '.main-icon',
				'border-right-width' => '.main-icon',
				'border-bottom-width' => '.main-icon',
				'border-left-width' => '.main-icon',
				'border-style' => '.main-icon',
				'border-color' => '.main-icon',
				// Hovers
				'color-hover' => 'a:hover .main-icon',
				'border-color-hover' => 'a:hover .main-icon',
				'background-color-hover' => 'a:hover .main-icon',
			),
			'holder_css' => array(
				// Font
				//'font-family' => '*replace',
				//'font-weight' => '*replace',
				//'font-size' => '.main-icon',
				//'line-height' => '*replace',
				//'text-transform' => '*replace',
				'color' => '.ivan-font-stack .stack-holder',
				// Dimensions
				//'width' => '*replace',
				//'height' => '*replace',
				// Spacing
				//'margin-top' => '&',
				//'margin-right' => '&',
				//'margin-bottom' => '&',
				//'margin-left' => '&',
				//'padding-top' => '.main-icon',
				//'padding-right' => '.main-icon',
				//'padding-bottom' => '.main-icon',
				//'padding-left' => '.main-icon',
				// Bg
				'background-color' => '.ivan-font-stack-square',
				// Border Radius
				//'border-top-left-radius' => '.main-icon',
				//'border-top-right-radius' => '.main-icon',
				//'border-bottom-left-radius' => '.main-icon',
				//'border-bottom-right-radius' => '.main-icon',
				// Border
				//'border-top-width' => '.main-icon',
				//'border-right-width' => '.main-icon',
				//'border-bottom-width' => '.main-icon',
				//'border-left-width' => '.main-icon',
				//'border-style' => '.main-icon',
				//'border-color' => '.main-icon',
				// Hovers
				'color-hover' => '.ivan-font-stack.with-link:hover .stack-holder',
				//'border-color-hover' => 'a:hover .main-icon',
				'background-color-hover' => '.ivan-font-stack-square.with-link:hover',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_icon;
	$ivan_vc_icon = new WPBakeryShortCode_ivan_icon( array('name' => 'Icon', 'base' => 'ivan_icon') );

} // #end class check