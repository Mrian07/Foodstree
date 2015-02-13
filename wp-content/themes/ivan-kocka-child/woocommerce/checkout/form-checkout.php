<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();


do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" autocomplete="off">
<br><br>
	<div class="row">
		<div class="col-md-7">
			<div class="col-wrapper">

				<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div class="" id="customer_details">

							<?php do_action( 'woocommerce_checkout_billing' ); ?>

							<?php do_action( 'woocommerce_checkout_shipping' ); ?>

					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>

			</div><!--.col-wrapper-->
		</div><!--.col-billing-->

		<div class="col-md-5 checkout-sidebar">
			<div class="col-wrapper">

				<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

				<?php do_action( 'woocommerce_checkout_order_review' ); ?>

			</div><!--.col-wrapper-->
		</div><!--.col-order-review-->

	</div><!--.row-->

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>