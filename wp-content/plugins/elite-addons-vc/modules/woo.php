<?php
/***
 * Module > WooCommerce Shortcodes
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_woo extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'per_page' => '4',
				'columns' => '4',
				'ids' => '',
				'code' => 'recent_products',
				'el_class' => '',
			), $atts) );

			$output = '';
			$classes = '';

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			$code = '[' . $code;

			if('' != $columns)
				$code .= ' columns="'.$columns.'"';

			if('' != $per_page)
				$code .= ' per_page="'.$per_page.'"';

			if('products' == $code && '' != $ids)
				$code .= ' ids="'.$ids.'"';

			$code .= ']';

			// Output Form
			ob_start();
			?>
			<div class="ivan-woo-shortcode <?php echo $classes; ?>">
				<?php echo do_shortcode($code); ?>
			</div>
			<?php
			$output .= ob_get_clean();

			return $output;
		}
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_woocommerce;
	$ivan_vc_woocommerce = new WPBakeryShortCode_ivan_woo( array('name' => 'WooCommerce', 'base' => 'ivan_woo') );

} // #end class check