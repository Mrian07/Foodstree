<?php
/***
 * Module > Pricing Table
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_pricing extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'el_class' => '',
				'template' => 'subtitle',
				'scheme' => '',
				'image_support' => 'no',
				'image_id' => '',
				'title' => '',
				'subtitle' => '',
				'price' => '',
				'currency' => '',
				'period' => '',
				'link' => '',
				'button_text' => '',
				'featured' => '',
				'featured_text' => '',
				'template_theme' => '',
			), $atts) );

			$output = '';
			$classes = '';

			//$scheme = 'dark-bg';
			//$scheme = 'black-bg';
			//$scheme = 'light-bg';
			//$scheme = 'primary-bg';

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

			// Handle attributes
			$classes .= ' ' . $template;

			// Handle attributes
			$classes .= ' ' . $scheme;

			// Featured
			if( ( 'subtitle' == $template OR 'small-desc' == $template OR 'default' == $template) && 'yes' == $featured) {
				$classes .= ' featured-table';

				if( '' != $featured_text )
					$classes .= ' with-marker';
			}

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template_theme)
				$classes .= ' ' . $template_theme;

			// Output Pricing Table
			ob_start();
			?>
			<div class="ivan-pricing-table-wrapper <?php echo $prefixClass; ?>">
				<div class="ivan-pricing-table <?php echo $classes; ?>">

					<?php if( ( 'subtitle' == $template OR 'small-desc' == $template OR 'default' == $template) && 
						'yes' == $featured && '' != $featured_text) : ?>
						<div class="featured-table-text"><?php echo $featured_text; ?></div>
					<?php endif; ?>

					<div class="top-section">

						<?php if('yes' == $image_support) : ?>
						<div class="plan-image">
							<?php if($image_id != '') {
								$url = wp_get_attachment_image_src($image_id, 'full');

								echo '<img src="'. $url['0'].'" alt="">';
							} ?>
						</div>
						<?php endif; ?>

						<h3 class="plan-title"><?php echo $title; ?></h3>

						<?php if( ( 'subtitle' == $template ) && '' != $subtitle) : ?>
							<div class="plan-subtitle"><?php echo $subtitle; ?></div>
						<?php endif; ?>

						<div class="plan-infos">
							<span class="price">
								<span class="currency"><?php echo $currency; ?></span><span class="price-inner"><?php echo $price; ?></span>
							</span>
							<?php if('' != $period) : ?><span class="month"><?php echo $period; ?></span><?php endif; ?>
						</div>

						<?php if( ( 'small-desc' == $template ) && '' != $subtitle) : ?>
							<div class="plan-subtitle"><?php echo $subtitle; ?></div>
						<?php endif; ?>

						<?php if('big-price' == $template && '' != $link) : ?>
							<div class="adquire-plan">
								<a href="<?php echo $link; ?>" class="signup"><?php echo $button_text; ?></a>
							</div>
						<?php endif; ?>

					</div>

					<div class="content-section">
						<?php echo do_shortcode($content); ?>
					</div>

					<?php if('big-price' != $template) : ?>
						<div class="bottom-section">
							<?php if('' != $link) : ?>
							<div class="adquire-plan">
								<a href="<?php echo $link; ?>" class="signup"><?php echo $button_text; ?></a>
							</div>
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
			'table_css' => array(
				// Font
				'font-family' => '.ivan-pricing-table, .plan-title',
				//'font-weight' => '.read-more a',
				//'font-size' => '.read-more a',
				//'line-height' => '.read-more a',
				//'text-transform' => '.read-more a',
				//'color' => '.read-more a',
				// Spacing
				'margin-top' => '.ivan-pricing-table',
				'margin-right' => '.ivan-pricing-table',
				'margin-bottom' => '.ivan-pricing-table',
				'margin-left' => '.ivan-pricing-table',
				'padding-top' => '.ivan-pricing-table',
				'padding-right' => '.ivan-pricing-table',
				'padding-bottom' => '.ivan-pricing-table',
				'padding-left' => '.ivan-pricing-table',
				// Bg
				'background-color' => '.ivan-pricing-table',
				// Border Radius
				'border-top-left-radius' => '.ivan-pricing-table',
				'border-top-right-radius' => '.ivan-pricing-table',
				'border-bottom-left-radius' => '.ivan-pricing-table',
				'border-bottom-right-radius' => '.ivan-pricing-table',
				// Border
				'border-top-width' => '.ivan-pricing-table',
				'border-right-width' => '.ivan-pricing-table',
				'border-bottom-width' => '.ivan-pricing-table',
				'border-left-width' => '.ivan-pricing-table',
				'border-style' => '.ivan-pricing-table',
				'border-color' => '.ivan-pricing-table',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'top_section_css' => array(
				// Font
				//'font-family' => '.read-more a',
				//'font-weight' => '.read-more a',
				//'font-size' => '.read-more a',
				//'line-height' => '.read-more a',
				//'text-transform' => '.read-more a',
				//'color' => '.read-more a',
				// Spacing
				//'margin-top' => '.ivan-pricing-table',
				//'margin-right' => '.ivan-pricing-table',
				//'margin-bottom' => '.ivan-pricing-table',
				//'margin-left' => '.ivan-pricing-table',
				'padding-top' => '.top-section',
				'padding-right' => '.top-section',
				'padding-bottom' => '.top-section',
				'padding-left' => '.top-section',
				// Bg
				'background-color' => '.top-section',
				// Border Radius
				'border-top-left-radius' => '.top-section',
				'border-top-right-radius' => '.top-section',
				'border-bottom-left-radius' => '.top-section',
				'border-bottom-right-radius' => '.top-section',
				// Border
				'border-top-width' => '.top-section',
				'border-right-width' => '.top-section',
				'border-bottom-width' => '.top-section',
				'border-left-width' => '.top-section',
				'border-style' => '.top-section',
				'border-color' => '.top-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'content_section_css' => array(
				// Font
				//'font-family' => '.read-more a',
				//'font-weight' => '.read-more a',
				//'font-size' => '.read-more a',
				//'line-height' => '.read-more a',
				//'text-transform' => '.read-more a',
				//'color' => '.read-more a',
				// Spacing
				'margin-top' => '.content-section',
				'margin-right' => '.content-section',
				'margin-bottom' => '.content-section',
				'margin-left' => '.content-section',
				'padding-top' => '.content-section',
				'padding-right' => '.content-section',
				'padding-bottom' => '.content-section',
				'padding-left' => '.content-section',
				// Bg
				'background-color' => '.content-section',
				// Border Radius
				'border-top-left-radius' => '.content-section',
				'border-top-right-radius' => '.content-section',
				'border-bottom-left-radius' => '.content-section',
				'border-bottom-right-radius' => '.content-section',
				// Border
				'border-top-width' => '.content-section',
				'border-right-width' => '.content-section',
				'border-bottom-width' => '.content-section',
				'border-left-width' => '.content-section',
				'border-style' => '.content-section',
				'border-color' => '.content-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'bottom_section_css' => array(
				// Font
				//'font-family' => '.read-more a',
				//'font-weight' => '.read-more a',
				//'font-size' => '.read-more a',
				//'line-height' => '.read-more a',
				//'text-transform' => '.read-more a',
				//'color' => '.read-more a',
				// Spacing
				//'margin-top' => '.ivan-pricing-table',
				//'margin-right' => '.ivan-pricing-table',
				//'margin-bottom' => '.ivan-pricing-table',
				//'margin-left' => '.ivan-pricing-table',
				'padding-top' => '.bottom-section',
				'padding-right' => '.bottom-section',
				'padding-bottom' => '.bottom-section',
				'padding-left' => '.bottom-section',
				// Bg
				'background-color' => '.bottom-section',
				// Border Radius
				'border-top-left-radius' => '.bottom-section',
				'border-top-right-radius' => '.bottom-section',
				'border-bottom-left-radius' => '.bottom-section',
				'border-bottom-right-radius' => '.bottom-section',
				// Border
				'border-top-width' => '.bottom-section',
				'border-right-width' => '.bottom-section',
				'border-bottom-width' => '.bottom-section',
				'border-left-width' => '.bottom-section',
				'border-style' => '.bottom-section',
				'border-color' => '.bottom-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'title_css' => array(
				// Font
				'font-family' => '.plan-title',
				'font-weight' => '.plan-title',
				'font-size' => '.plan-title',
				'line-height' => '.plan-title',
				'text-transform' => '.plan-title',
				'color' => '.plan-title',
				// Spacing
				'margin-top' => '.plan-title',
				'margin-right' => '.plan-title',
				'margin-bottom' => '.plan-title', 
				'margin-left' => '.plan-title',
				//'padding-top' => '.bottom-section',
				//'padding-right' => '.bottom-section',
				//'padding-bottom' => '.bottom-section',
				//'padding-left' => '.bottom-section',
				// Bg
				//'background-color' => '.bottom-section',
				// Border Radius
				//'border-top-left-radius' => '.bottom-section',
				//'border-top-right-radius' => '.bottom-section',
				//'border-bottom-left-radius' => '.bottom-section',
				//'border-bottom-right-radius' => '.bottom-section',
				// Border
				//'border-top-width' => '.bottom-section',
				//'border-right-width' => '.bottom-section',
				//'border-bottom-width' => '.bottom-section',
				//'border-left-width' => '.bottom-section',
				//'border-style' => '.bottom-section',
				//'border-color' => '.bottom-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'subtitle_css' => array(
				// Font
				'font-family' => '.plan-subtitle',
				'font-weight' => '.plan-subtitle',
				'font-size' => '.plan-subtitle',
				'line-height' => '.plan-subtitle',
				'text-transform' => '.plan-subtitle',
				'color' => '.plan-subtitle',
				// Spacing
				'margin-top' => '.plan-subtitle',
				'margin-right' => '.plan-subtitle',
				'margin-bottom' => '.plan-subtitle',
				'margin-left' => '.plan-subtitle',
				//'padding-top' => '.bottom-section',
				//'padding-right' => '.bottom-section',
				//'padding-bottom' => '.bottom-section',
				//'padding-left' => '.bottom-section',
				// Bg
				//'background-color' => '.bottom-section',
				// Border Radius
				//'border-top-left-radius' => '.bottom-section',
				//'border-top-right-radius' => '.bottom-section',
				//'border-bottom-left-radius' => '.bottom-section',
				//'border-bottom-right-radius' => '.bottom-section',
				// Border
				//'border-top-width' => '.bottom-section',
				//'border-right-width' => '.bottom-section',
				//'border-bottom-width' => '.bottom-section',
				//'border-left-width' => '.bottom-section',
				//'border-style' => '.bottom-section',
				//'border-color' => '.bottom-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'currency_css' => array(
				// Font
				'font-family' => '.currency',
				'font-weight' => '.currency',
				'font-size' => '.currency',
				'line-height' => '.currency',
				'text-transform' => '.currency',
				'color' => '.currency',
				// Spacing
				'margin-top' => '.currency',
				'margin-right' => '.currency',
				'margin-bottom' => '.currency',
				'margin-left' => '.currency',
				//'padding-top' => '.bottom-section',
				//'padding-right' => '.bottom-section',
				//'padding-bottom' => '.bottom-section',
				//'padding-left' => '.bottom-section',
				// Bg
				//'background-color' => '.bottom-section',
				// Border Radius
				//'border-top-left-radius' => '.bottom-section',
				//'border-top-right-radius' => '.bottom-section',
				//'border-bottom-left-radius' => '.bottom-section',
				//'border-bottom-right-radius' => '.bottom-section',
				// Border
				//'border-top-width' => '.bottom-section',
				//'border-right-width' => '.bottom-section',
				//'border-bottom-width' => '.bottom-section',
				//'border-left-width' => '.bottom-section',
				//'border-style' => '.bottom-section',
				//'border-color' => '.bottom-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'price_css' => array(
				// Font
				'font-family' => '.price-inner',
				'font-weight' => '.price-inner',
				'font-size' => '.price-inner',
				'line-height' => '.price-inner',
				'text-transform' => '.price-inner',
				'color' => '.price-inner',
				// Spacing
				'margin-top' => '.price-inner',
				'margin-right' => '.price-inner',
				'margin-bottom' => '.price-inner',
				'margin-left' => '.price-inner',
				//'padding-top' => '.bottom-section',
				//'padding-right' => '.bottom-section',
				//'padding-bottom' => '.bottom-section',
				//'padding-left' => '.bottom-section',
				// Bg
				//'background-color' => '.bottom-section',
				// Border Radius
				//'border-top-left-radius' => '.bottom-section',
				//'border-top-right-radius' => '.bottom-section',
				//'border-bottom-left-radius' => '.bottom-section',
				//'border-bottom-right-radius' => '.bottom-section',
				// Border
				//'border-top-width' => '.bottom-section',
				//'border-right-width' => '.bottom-section',
				//'border-bottom-width' => '.bottom-section',
				//'border-left-width' => '.bottom-section',
				//'border-style' => '.bottom-section',
				//'border-color' => '.bottom-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'period_css' => array(
				// Font
				'font-family' => '.month',
				'font-weight' => '.month',
				'font-size' => '.month',
				'line-height' => '.month',
				'text-transform' => '.month',
				'color' => '.month',
				// Spacing
				'margin-top' => '.month',
				'margin-right' => '.month',
				'margin-bottom' => '.month',
				'margin-left' => '.month',
				//'padding-top' => '.bottom-section',
				//'padding-right' => '.bottom-section',
				//'padding-bottom' => '.bottom-section',
				//'padding-left' => '.bottom-section',
				// Bg
				//'background-color' => '.bottom-section',
				// Border Radius
				//'border-top-left-radius' => '.bottom-section',
				//'border-top-right-radius' => '.bottom-section',
				//'border-bottom-left-radius' => '.bottom-section',
				//'border-bottom-right-radius' => '.bottom-section',
				// Border
				//'border-top-width' => '.bottom-section',
				//'border-right-width' => '.bottom-section',
				//'border-bottom-width' => '.bottom-section',
				//'border-left-width' => '.bottom-section',
				//'border-style' => '.bottom-section',
				//'border-color' => '.bottom-section',
				// Hovers
				//'color-hover' => '.read-more a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'items_css' => array(
				// Font
				'font-family' => 'li',
				'font-weight' => 'li',
				'font-size' => 'li',
				'line-height' => 'li',
				'text-transform' => 'li',
				'color' => 'li, li a',
				// Spacing
				'margin-top' => 'li',
				'margin-right' => 'li',
				'margin-bottom' => 'li',
				'margin-left' => 'li',
				'padding-top' => 'li',
				'padding-right' => 'li',
				'padding-bottom' => 'li',
				'padding-left' => 'li',
				// Bg
				//'background-color' => 'li',
				// Border Radius
				//'border-top-left-radius' => 'li',
				//'border-top-right-radius' => 'li',
				//'border-bottom-left-radius' => 'li',
				//'border-bottom-right-radius' => 'li',
				// Border
				'border-top-width' => 'li',
				'border-right-width' => 'li',
				'border-bottom-width' => 'li',
				'border-left-width' => 'li',
				'border-style' => 'li',
				'border-color' => 'li',
				// Hovers
				'color-hover' => 'li, li a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'strong_css' => array(
				// Font
				'font-family' => 'strong',
				'font-weight' => 'strong',
				'font-size' => 'strong',
				'line-height' => 'strong',
				'text-transform' => 'strong',
				'color' => 'strong',
				// Spacing
				//'margin-top' => 'li',
				//'margin-right' => 'li',
				//'margin-bottom' => 'li',
				//'margin-left' => 'li',
				//'padding-top' => 'li',
				//'padding-right' => 'li',
				//'padding-bottom' => 'li',
				//'padding-left' => 'li',
				// Bg
				//'background-color' => 'li',
				// Border Radius
				//'border-top-left-radius' => 'li',
				//'border-top-right-radius' => 'li',
				//'border-bottom-left-radius' => 'li',
				//'border-bottom-right-radius' => 'li',
				// Border
				//'border-top-width' => 'li',
				//'border-right-width' => 'li',
				//'border-bottom-width' => 'li',
				//'border-left-width' => 'li',
				//'border-style' => 'li',
				//'border-color' => 'li',
				// Hovers
				//'color-hover' => 'li, li a:hover',
				//'border-color-hover' => '.read-more a:hover',
				//'background-color-hover' => '.read-more a:hover',
			),
			'signup_css' => array(
				// Font
				'font-family' => '.signup',
				'font-weight' => '.signup',
				'font-size' => '.signup',
				'line-height' => '.signup',
				'text-transform' => '.signup',
				'color' => '.signup',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				'padding-top' => '.signup',
				'padding-right' => '.signup',
				'padding-bottom' => '.signup',
				'padding-left' => '.signup',
				// Bg
				'background-color' => '.signup',
				// Border Radius
				'border-top-left-radius' => '.signup',
				'border-top-right-radius' => '.signup',
				'border-bottom-left-radius' => '.signup',
				'border-bottom-right-radius' => '.signup',
				// Border
				'border-top-width' => '.signup',
				'border-right-width' => '.signup',
				'border-bottom-width' => '.signup',
				'border-left-width' => '.signup',
				'border-style' => '.signup',
				'border-color' => '.signup',
				// Hovers
				'color-hover' => '.signup:hover',
				'border-color-hover' => '.signup:hover',
				'background-color-hover' => '.signup:hover',
			),
			'featured_css' => array(
				// Font
				'font-family' => '.featured-table-text',
				'font-weight' => '.featured-table-text',
				'font-size' => '.featured-table-text',
				'line-height' => '.featured-table-text',
				'text-transform' => '.featured-table-text',
				'color' => '.featured-table-text',
				// Spacing
				//'margin-top' => '.featured-table-text',
				//'margin-right' => '.featured-table-text',
				//'margin-bottom' => '.featured-table-text',
				//'margin-left' => '.featured-table-text',
				'padding-top' => '.featured-table-text',
				'padding-right' => '.featured-table-text',
				'padding-bottom' => '.featured-table-text',
				'padding-left' => '.featured-table-text',
				// Bg
				'background-color' => '.featured-table-text',
				// Border Radius
				'border-top-left-radius' => '.featured-table-text',
				'border-top-right-radius' => '.featured-table-text',
				'border-bottom-left-radius' => '.featured-table-text',
				'border-bottom-right-radius' => '.featured-table-text',
				// Border
				'border-top-width' => '.featured-table-text',
				'border-right-width' => '.featured-table-text',
				'border-bottom-width' => '.featured-table-text',
				'border-left-width' => '.featured-table-text',
				'border-style' => '.featured-table-text',
				'border-color' => '.featured-table-text',
				// Hovers
				//'color-hover' => '.featured-table-text',
				//'border-color-hover' => '.featured-table-text',
				//'background-color-hover' => '.featured-table-text',
			),
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_pricing_table;
	$ivan_vc_pricing_table = new WPBakeryShortCode_ivan_pricing( array('name' => 'Pricing Table', 'base' => 'ivan_pricing') );

} // #end class check