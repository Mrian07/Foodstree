<?php
/**
 * The template for displaying product content inside our popup
 *
 */

global $post, $product, $woocommerce;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	if ( post_password_required() ) {
		echo get_the_password_form();
		return;
	}
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6">
			<div class="single-product-main-images owl-carousel">
			<?php
				// Display Product Images/Slider items
				?>
				<div class="product-thumb-item">
					<span itemprop="image"><?php echo get_the_post_thumbnail( $post->ID, apply_filters( 'ivan_woo_quick_view_thumb', 'shop_single' ) ) ?></span>
				</div>

				<?php

				$attachment_ids = $product->get_gallery_attachment_ids();

				// Display Other Attachment Images
				if( $attachment_ids ) :

					// Loop in attachment	
					foreach ( $attachment_ids as $attachment_id ) {
						
						$image = wp_get_attachment_image( $attachment_id, apply_filters( 'ivan_woo_quick_view_thumb', 'shop_single' ) );

						if( '' == $image )
							continue;

						?>
							<div class="product-thumb-item">
								<span itemprop="image"><?php echo $image; ?></span>
							</div>
						<?php	
					
					}

				endif;
			?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6">

			<div class="summary entry-summary">

				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<?php
					/**
					 * woocommerce_single_product_quick_view_summary hook
					 *
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_quick_view_summary' );
				?>

			</div><!-- .summary -->

		</div>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />

	</div><!--.row -->
</div><!-- #product-<?php the_ID(); ?> -->
