<?php
/***
 * Module > Service Block
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_service extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'heading' => '',
				'heading_tag' => 'h4',
				'ico_family' => 'fa fa-',
				'ico' => 'anchor',
				'ico_custom' => '',
				'ico_size' => 'fa-3x',
				'icon_style' => 'normal',

				'css_animation' => '',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';

			//$icon_style = 'circle';
			//$icon_style = 'square';
			//$icon_style = 'normal';

			$classes .= ' ' . $icon_style;

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

			// Icon Markup
			$icon_i = '';

			if('' != $ico) :
				$icon_i = $ico_family.$ico;
			endif;

			if('' != $ico_custom) :
				$icon_i = $ico_custom;
			endif;

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>

			<div class="ivan-service-wrapper <?php echo $prefixClass; ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
				<div class="ivan-service <?php echo $classes; ?>">

					<div class="top-section-holder">
						<div class="top-section-inner">

							<?php if( $heading != '' ) : ?>
								<<?php echo $heading_tag; ?> class="service-title"><?php echo $heading; ?></<?php echo $heading_tag; ?>>
							<?php endif; ?>

							<?php
								switch ($icon_style) {
									case 'circle': ?>
									<div class="service-icon-holder">
										<div class="service-icon-inner fa-stack <?php echo $ico_size; ?>">
											<i class="main-icon <?php echo $icon_i; ?> fa-stack-1x"></i>
										</div>
									</div>
									<?php
										break;
									case 'square': ?>
										<div class="service-icon-holder">
											<div class="service-icon-inner fa-stack <?php echo $ico_size; ?>">
												<i class="main-icon <?php echo $icon_i; ?> fa-stack-1x"></i>
											</div>
										</div>
										<?php
										break;
									default: ?>
										<div class="service-icon-holder">
											<div class="service-icon-inner">
												<i class="main-icon <?php echo $icon_i; ?> <?php echo $ico_size; ?>"></i>
											</div>
										</div>
										<?php
										break;
								}
							?>

						</div>
					</div>

					<?php if( $content != '' && $content != null ) : ?>
					<div class="content-section-holder">
						<div class="content-section-inner"><?php echo do_shortcode( $content ); ?></div>
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
			'main_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				//'font-size' => 'h2',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				//'color' => 'h2',
				// Spacing
				'margin-top' => '.ivan-service',
				'margin-right' => '.ivan-service',
				'margin-bottom' => '.ivan-service',
				'margin-left' => '.ivan-service',
				'padding-top' => '.ivan-service',
				'padding-right' => '.ivan-service',
				'padding-bottom' => '.ivan-service',
				'padding-left' => '.ivan-service',
				// Bg
				'background-color' => '.ivan-service',
				// Border Radius
				'border-top-left-radius' => '.ivan-service',
				'border-top-right-radius' => '.ivan-service',
				'border-bottom-left-radius' => '.ivan-service',
				'border-bottom-right-radius' => '.ivan-service',
				// Border
				'border-top-width' => '.ivan-service',
				'border-right-width' => '.ivan-service',
				'border-bottom-width' => '.ivan-service',
				'border-left-width' => '.ivan-service',
				'border-style' => '.ivan-service',
				'border-color' => '.ivan-service',
				// Hovers
				//'color-hover' => 'label:hover',
				'border-color-hover' => '.ivan-service:hover',
				'background-color-hover' => '.ivan-service:hover',
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
				'background-color' => '.fa-stack',
				// Border Radius
				'border-top-left-radius' => '.fa-stack',
				'border-top-right-radius' => '.fa-stack',
				'border-bottom-left-radius' => '.fa-stack',
				'border-bottom-right-radius' => '.fa-stack',
				// Border
				'border-top-width' => '.fa-stack',
				'border-right-width' => '.fa-stack',
				'border-bottom-width' => '.fa-stack',
				'border-left-width' => '.fa-stack',
				'border-style' => '.fa-stack',
				'border-color' => '.fa-stack',
				// Hovers
				'color-hover' => '.ivan-service:hover .main-icon',
				'border-color-hover' => '.ivan-service:hover .fa-stack',
				'background-color-hover' => '.ivan-service:hover .fa-stack',
			),
			'title_css' => array(
				// Font
				'font-family' => '.service-title',
				'font-weight' => '.service-title',
				'font-size' => '.service-title',
				'line-height' => '.service-title',
				'text-transform' => '.service-title',
				'color' => '.service-title',
				// Spacing
				'margin-top' => '.service-title',
				'margin-right' => '.service-title',
				'margin-bottom' => '.service-title',
				'margin-left' => '.service-title',
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
				'color-hover' => '.ivan-service:hover .service-title',
				//'border-color-hover' => '.ivan-info-box:hover',
				//'background-color-hover' => '.ivan-info-box:hover',
			),
			'content_css' => array(
				// Font
				'font-family' => '.content-section-holder',
				'font-weight' => '.content-section-holder',
				'font-size' => '.content-section-holder',
				'line-height' => '.content-section-holder',
				'text-transform' => '.content-section-holder',
				'color' => '.content-section-holder li, .content-section-holder p, .content-section-holder a',
				// Spacing
				//'margin-top' => '.content-section-holder',
				//'margin-right' => '.content-section-holder',
				//'margin-bottom' => '.content-section-holder',
				//'margin-left' => '.content-section-holder',
				'padding-top' => '.content-section-holder li, .content-section-holder p',
				'padding-right' => '.content-section-holder li, .content-section-holder p',
				'padding-bottom' => '.content-section-holder li, .content-section-holder p',
				'padding-left' => '.content-section-holder li, .content-section-holder p',
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
				//'border-bottom-width' => '.content-section-holder li, .content-section-holder p',
				//'border-left-width' => '.ivan-info-box',
				'border-style' => '.content-section-holder li, .content-section-holder p',
				'border-color' => '.content-section-holder li, .content-section-holder p',
				// Hovers
				'color-hover' => '.ivan-service:hover .content-section-holder li, .ivan-service:hover .content-section-holder p, .ivan-service:hover .content-section-holder a, .content-section-holder a:hover',
				'border-color-hover' => '.ivan-service:hover .content-section-holder li, .ivan-service:hover .content-section-holder p',
				//'background-color-hover' => '.ivan-info-box:hover',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_service;
	$ivan_vc_service = new WPBakeryShortCode_ivan_service( array('name' => 'Service Block', 'base' => 'ivan_service') );

} // #end class check