<?php
/**
 * The template for displaying product content within loops. List styled template...
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

$attachment_ids = $product->get_gallery_attachment_ids();

// Restart Columns
$woocommerce_loop['columns'] = 1;

$classes[] = 'col-xs-12 col-sm-12 col-md-12';
$classes[] = 'product-list-style';

?>

<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="main-link">
		<div class="row">
		<div>

		<div class="product-thumbnail col-md-4">
			<div class="col-wrapper">
			<a href="<?php the_permalink(); ?>" class="main-link">

			<div class="frontal-image">
				<?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?>
			</div>

			<?php
			// Display Back Image of Product
			if( $attachment_ids ) :

				$counter = 0;				
				
				// Loop in attachment	
				foreach ( $attachment_ids as $attachment_id ) {
					
					// Get attachment image URL
					$image_link = wp_get_attachment_url( $attachment_id );
					
					// If isn't a URL we go to next attachment
					if ( !$image_link )
						continue;
								
					$counter++;

					?>
						<div class="back-image"><?php echo wp_get_attachment_image( $attachment_id, 'shop_catalog' ); ?></div>
					<?php	
					
					// If we found any image, we stop the loop
					if ($counter == 1) 
						break;	
				}

			endif; ?>

			<?php if(false == ivan_get_option('woo-disable-quick-view') && false == ivan_get_option('woo-catalog-mode') ) : ?>
				<div class="quick-view" data-product-id="<?php echo $post->ID; ?>"><?php _e( 'Quick View', 'ivan_domain'); ?></div>
			<?php endif; ?>

			<?php
			// Adds Wishlist Button
			if( class_exists( 'YITH_WCWL' ) ) : ?>
				<?php echo '<div class="yith-wrapper">' . do_shortcode('[yith_wcwl_add_to_wishlist]') . '</div>'; ?>
			<?php endif; ?>

			<?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>

			</a><!--.main-link-->
			</div>
		</div><!--.product-thumbnail-->

		<div class="product-info col-md-8">
			<div class="col-wrapper">

			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

			<div class="entry-excerpt">
				<?php the_excerpt(); ?>
			</div>

			</div>
		</div><!--.product-info-->

		</div><!--div-->
		</div><!--.row-->

	</div>

</li>
