<?php
/**
 *
 * Class used as base to create modules that can be attached to layouts 
 *
 * @package   IvanFramework
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 * @version 1.0
 * @since 1.0
 */

class Ivan_Module_Woo_Cart extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_woo_cart';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $classes = '' ) {
		
		if( true == is_woocommerce_activated() ) {

			global $woocommerce;

			?>
			<div class="iv-module woo-cart <?php echo $classes; ?>">
				<div class="centered">
					<a class="cart-contents trigger" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
						<span class="cart-total"><?php echo $woocommerce->cart->get_cart_total(); ?></span>
						<div class="basket-wrapper">
							<div class="top"></div>
							<div class="basket"><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></div>
						</div>
					</a>
					<div class="inner-wrapper">
						<div class="inner-cart inner-form">
						 	<div class="widget_shopping_cart_content"></div>
						</div>
					</div>
					
				</div>
			</div>
			<?php
		}
	}

}