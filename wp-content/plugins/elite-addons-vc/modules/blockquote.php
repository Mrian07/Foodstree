<?php
/***
 * Module > Tweet
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_iv_quote extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'text' => '',
				'author' => '',
				'icon' => '',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';
			$bq_classes = '';

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

			if($icon == 'yes')
				$bq_classes .= ' with-icon';

			// Output Form
			ob_start();
			?>
			<div class="ivan-quote-wrap <?php echo $prefixClass; ?>">
				<div class="ivan-quote <?php echo $classes; ?>">
					<blockquote class="<?php echo $bq_classes; ?>">
					<?php if($icon == 'yes') {
					    echo "<i class='fa fa-quote-right pull-left'></i>";
					}
					?>
					<h5 class="blockquote-text"><?php echo $text; ?></h5>
					<?php if($author != '' ) : ?>
						<h6 class="author"><?php echo $author; ?></h6>
					<?php endif; ?>
					</blockquote>
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
				//'font-family' => 'blockquote',
				//'font-weight' => 'blockquote',
				//'font-size' => 'blockquote',
				//'line-height' => 'blockquote',
				//'text-transform' => 'blockquote',
				//'color' => 'blockquote',
				// Spacing
				'margin-top' => 'blockquote',
				'margin-right' => 'blockquote',
				'margin-bottom' => 'blockquote',
				'margin-left' => 'blockquote',
				'padding-top' => 'blockquote',
				'padding-right' => 'blockquote',
				'padding-bottom' => 'blockquote',
				'padding-left' => 'blockquote',
				// Bg
				'background-color' => 'blockquote',
				// Border Radius
				'border-top-left-radius' => 'blockquote',
				'border-top-right-radius' => 'blockquote',
				'border-bottom-left-radius' => 'blockquote',
				'border-bottom-right-radius' => 'blockquote',
				// Border
				'border-top-width' => 'blockquote',
				'border-right-width' => 'blockquote',
				'border-bottom-width' => 'blockquote',
				'border-left-width' => 'blockquote',
				'border-style' => 'blockquote',
				'border-color' => 'blockquote',
				// Hovers
				//'color-hover' => 'blockquote',
				//'border-color-hover' => 'blockquote',
				//'background-color-hover' => 'blockquote',
			),
			'quote_css' => array(
				// Font
				'font-family' => 'h5',
				'font-weight' => 'h5',
				'font-size' => 'h5',
				'line-height' => 'h5',
				'text-transform' => 'h5',
				'color' => 'h5',
				// Spacing
				//'margin-top' => 'h5',
				//'margin-right' => 'h5',
				//'margin-bottom' => 'h5',
				//'margin-left' => 'h5',
				//'padding-top' => 'h5',
				//'padding-right' => 'h5',
				//'padding-bottom' => 'h5',
				//'padding-left' => 'h5',
				// Bg
				//'background-color' => 'h5',
				// Border Radius
				//'border-top-left-radius' => 'h5',
				//'border-top-right-radius' => 'h5',
				//'border-bottom-left-radius' => 'h5',
				//'border-bottom-right-radius' => 'h5',
				// Border
				//'border-top-width' => 'h5',
				//'border-right-width' => 'h5',
				//'border-bottom-width' => 'h5',
				//'border-left-width' => 'h5',
				//'border-style' => 'h5',
				//'border-color' => 'h5',
				// Hovers
				//'color-hover' => 'h5',
				//'border-color-hover' => 'h5',
				//'background-color-hover' => 'h5',
			),
			'author_css' => array(
				// Font
				'font-family' => '.author',
				'font-weight' => '.author',
				'font-size' => '.author',
				'line-height' => '.author',
				'text-transform' => '.author',
				'color' => '.author',
				// Spacing
				'margin-top' => '.author',
				'margin-right' => '.author',
				'margin-bottom' => '.author',
				'margin-left' => '.author',
				//'padding-top' => '.author',
				//'padding-right' => '.author',
				//'padding-bottom' => '.author',
				//'padding-left' => '.author',
				// Bg
				//'background-color' => '.author',
				// Border Radius
				//'border-top-left-radius' => '.author',
				//'border-top-right-radius' => '.author',
				//'border-bottom-left-radius' => '.author',
				//'border-bottom-right-radius' => '.author',
				// Border
				//'border-top-width' => '.author',
				//'border-right-width' => '.author',
				//'border-bottom-width' => '.author',
				//'border-left-width' => '.author',
				//'border-style' => '.author',
				//'border-color' => '.author',
				// Hovers
				//'color-hover' => '.author',
				//'border-color-hover' => '.author',
				//'background-color-hover' => '.author',
			),
			'icon_css' => array(
				// Font
				//'font-family' => '.pull-left',
				//'font-weight' => '.pull-left',
				'font-size' => '.pull-left',
				//'line-height' => '.pull-left',
				//'text-transform' => '.pull-left',
				'color' => '.pull-left',
			),
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_quote;
	$ivan_vc_quote = new WPBakeryShortCode_iv_quote( array('name' => 'Blockquote', 'base' => 'iv_quote') );

} // #end class check