	<h2 class="title-heading-header">
				View Cart
		</h2>
		

<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();




if( isset($_POST['apply_coupon']) && isset($_POST['coupon_code']) && $_POST['coupon_code'] == '' ){ ?>
<div class="ivan-message  with-icon error woo-msg-wrapper woocommerce-message">
	<div class="ivan-message-inner">

		<div class="ivan-message-icon-holder">
			<div class="ivan-message-icon">
				<div class="ivan-message-icon-inner">
					<i class="fa fa-close fa-lg"></i>
				</div>
			</div>
		</div>

		<div class="ivan-message-text-holder">
			<div class="ivan-message-text">
				<div class="ivan-message-text-inner">
					<ul class="woocommerce-error">
						<li>Coupon code was empty!</li>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>
<?php } ?>




<?php
do_action( 'woocommerce_before_cart' ); ?>
<br><br>
<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<div class="row">
	<div class="col-md-8">
		<div class="col-wrapper">

			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<table class="shop_table cart" cellspacing="0">
				<thead>
					<tr>
						<th class="product-name" colspan="2"><?php _e( 'Product', 'woocommerce' ); ?></th>
						<th class="product-thumbnail">&nbsp;</th>
						
						<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
						<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
						<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							?>
							<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

								<td class="product-remove">
									<?php
										echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
									?>
								</td>

								<td class="product-thumbnail">
									<?php
										$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

										if ( ! $_product->is_visible() )
											echo $thumbnail;
										else
											printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
									?>
								</td>

								<td class="product-name">
									<?php
										if ( ! $_product->is_visible() )
											echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
										else
											echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

										// Meta data
										echo WC()->cart->get_item_data( $cart_item );

			               				// Backorder notification
			               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
			               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
									?>
								</td>

								<td class="product-price">
									<?php
										echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									?>
								</td>

								<td class="product-quantity">
									<?php
										if ( $_product->is_sold_individually() ) {
											$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
										} else {
											$product_quantity = woocommerce_quantity_input( array(
												'input_name'  => "cart[{$cart_item_key}][qty]",
												'input_value' => $cart_item['quantity'],
												'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
											), $_product, false );
										}

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
									?>
								</td>

								<td class="product-subtotal">
									<?php
										echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
									?>
								</td>
							</tr>
							<?php
						}
					}

					do_action( 'woocommerce_cart_contents' );
					?>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</tbody>
			</table>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>

			<?php do_action( 'woocommerce_cart_collaterals' ); ?>

		</div><!--.col-wrapper-->
	</div><!--.col-table-->

	<div class="col-md-4 cart-details-col">
		<div class="col-wrapper">

			<div class="cart-collaterals">

				<?php woocommerce_cart_totals(); ?>

				<div class="cart-actions">

					<input type="submit" class="button btn-bg" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" /> <input type="submit" class="checkout-button button alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />

					<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>

					<div class="clearfix"></div>

				</div>

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button btn-bg" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />

						<?php do_action('woocommerce_cart_coupon'); ?>

						<div class="clearfix"></div>

					</div>
				<?php } ?>


				<?php woocommerce_shipping_calculator(); ?>

			</div>

		</div><!--.col-wrapper-->
	</div><!--.col-collaterals-->
</div><!--.row-->

</form>

<?php do_action( 'woocommerce_after_cart' ); ?>