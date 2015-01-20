<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>

<?php
if( true == ivan_get_option( 'header-negative-height' ) && false == ivan_get_option('woo-disable-title') ) : 

	$title_class = 'normal';

	if( ivan_get_option('title-wrapper-layout') == 'Ivan_Layout_Title_Wrapper_Large' )
		$title_class = 'large';
	
?>
<div id="iv-layout-title-wrapper" class="<?php echo apply_filters( 'iv_title_wrapper_classes', 'iv-layout title-wrapper title-wrapper-shop title-wrapper-' . $title_class); ?> <?php echo ivan_get_option('title-wrapper-color-scheme'); ?>">
	<div class="container">
		<div class="row">

			<div class="col-md-12">
				<h2><?php echo ivan_get_option('title-text-shop'); ?></h2>
				<?php // Display optional description of shop
				if( ivan_get_option('title-desc-shop') != '' ) : ?>
					<div class="title-description">
						<p><?php echo nl2br(ivan_get_option('title-desc-shop')); ?></p>
					</div>
				<?php 
				endif;	
				?>
		
			</div>

		</div><!--.row -->
	</div><!--.container-->
</div>
<?php else : ?>
	<div class="title-wrapper-divider"></div>
<?php endif; ?>

	<?php
	/* @todo: adds who is being hooked */
	do_action( 'ivan_content_before' ); 
	?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<div class="<?php echo apply_filters( 'iv_content_wrapper_classes', 'iv-layout content-wrapper single-product-wrapper ', 'shop' ); ?>">
			<div class="container">

			<h2 class="title-heading-header">
				
				<?php
					/**
					 * Breadcrumb to Single Page
					 **/
					if( false == ivan_get_option('woo-disable-breadcrumb') ) :
						get_template_part( 'woocommerce/single-product/single', 'breadcrumb' );
					endif;
				?>
		</h2>
		<!--<div class=" text-center"><br>
							<p>Categories: Imported Products, Packaged Food.</p>
		</div>-->
				<?php
				// Boxed Page Logic
				if( true == ivan_get_option('shop-boxed-page') && false == ivan_get_option('header-negative-height') ) : ?>
				<div class="boxed-page-wrapper">
					<div class="boxed-page-inner">
				<?php endif; ?>

					<div class="row">

						<?php
						$_layout = ivan_get_option('woo-product-layout');

						get_template_part( 'woocommerce/layouts/product', $_layout );
						?>

					</div>

				<?php
				// Boxed Page Logic
				if( true == ivan_get_option('shop-boxed-page') && false == ivan_get_option('header-negative-height') ) : ?>
					</div><!-- .boxed-page-inner -->
				</div><!-- .boxed-page-wrapper -->
				<?php endif; ?>
							
			</div>
		</div>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>