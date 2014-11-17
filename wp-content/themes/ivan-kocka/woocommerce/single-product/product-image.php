<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images">

	<?php
	// Adds Wishlist Button
	if( class_exists( 'YITH_WCWL' ) ) : ?>
		<?php echo '<div class="yith-wrapper">' . do_shortcode('[yith_wcwl_add_to_wishlist]') . '</div>'; ?>
	<?php endif; ?>

	<div class="single-product-main-images owl-carousel">
		<?php
			if ( has_post_thumbnail() ) {

				$size = 'shop_single';

				if(true == ivan_get_option('woo-thumbnail-stacked'))
					$size = 'large';


				$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
				$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', $size ), array(
					'title' => $image_title,
					'data-zoom-image' => $image_link
					) );

				//Get attachment IDS
				$attachment_ids = $product->get_gallery_attachment_ids();

				$attachment_count   = count( $attachment_ids );

				if ( $attachment_count > 0 ) {
					$gallery = '[product-gallery]';
				} else {
					$gallery = '';
				}

				//data-zoom-image="large/image1.jpg"

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );

				// Display Attachment Images as well
				if( $attachment_ids ) :

					// Loop in attachment	
					foreach ( $attachment_ids as $attachment_id ) {
						
						// Get attachment image URL
						$image_link = wp_get_attachment_url( $attachment_id );

						$image_title = esc_attr( get_the_title( $attachment_id ) );
						
						// If isn't a URL we go to next attachment
						if ( !$image_link )
							continue;

						$image = wp_get_attachment_image( $attachment_id, 'shop_single', array(
							'data-zoom-image' => $image_link
							) );

						//var_dump($image);
						
						// Display other items
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );
					}

				endif;

			} else {

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );

			}
		?>
	</div><!--.owl-carousel-->

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
