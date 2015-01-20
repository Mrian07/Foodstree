<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<div class="ivan-message  with-icon info woo-msg-wrapper">
	<div class="ivan-message-inner">

		<div class="ivan-message-icon-holder">
			<div class="ivan-message-icon">
				<div class="ivan-message-icon-inner">
					<i class="fa fa-bell-o fa-lg"></i>
				</div>
			</div>
		</div>
						
		<div class="ivan-message-text-holder">
			<div class="ivan-message-text">
				<div class="ivan-message-text-inner">
					<?php foreach ( $messages as $message ) : ?>
						<div class="woocommerce-info"><?php echo wp_kses_post( $message ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

	</div><!-- .message-inner -->
</div>