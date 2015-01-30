<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version	 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>

<?php
//@todo: Add category header shortcode display right here...
?>

<?php
$_classes = '';

$title_class = 'normal';

if( ivan_get_option('title-wrapper-layout') == 'Ivan_Layout_Title_Wrapper_Large' )
	$title_class = 'large';

// Title Logic
if( ( false == ivan_get_option('woo-disable-title') && false == ivan_get_option('shop-boxed-page') )
	OR ( true == ivan_get_option('header-negative-height') && false == ivan_get_option('woo-disable-title') ) ) :
?>
	<div id="iv-layout-title-wrapper" class="<?php echo apply_filters( 'iv_title_wrapper_classes', 'iv-layout title-wrapper title-wrapper-shop title-wrapper-' . $title_class); ?> <?php echo ivan_get_option('title-wrapper-color-scheme'); ?>">
		<div class="container">
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 ivan-title-inner">
					<!--<h2><?php echo ivan_get_option('title-text-shop'); ?></h2>-->
					<?php // Display optional description of shop
					if( ivan_get_option('title-desc-shop') != '' ) : ?>
						<div class="title-description">
							<p><?php echo nl2br(ivan_get_option('title-desc-shop')); ?></p>
						</div>
					<?php 
					endif;	
					?>
		<h2 class="title-heading-header">

			<?php
			if(is_product_category()){
			$product_cats = get_product_category_by_id( get_queried_object_id() );
			echo $product_cats;
			}else{
				echo "Products";
			}
			?>

		</h2>
		<div class=" text-center"><br>
							<p>
								<?php
								if(is_product_category()){
									$product_desc = get_product_category_description_by_id( get_queried_object_id() );
									echo $product_desc;
								}
								?>
							</p>
		</div>
					<?php if( ivan_get_option('breadcrumb-shop-disable') == false && $title_class != 'large' ) : ?>
							<?php 
							// Display Breadcrumb
							$defaults = array(
								'wrap_before'  => '<div class="ivan-breadcrumb ivan-woo-breadcrumb"><ul class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . apply_filters('ivan_you_are_here_shop', '<li class="intro">'. __('You are here:', 'ivan_domain') .'</li>'),
								'wrap_after' => '</ul></div>',
								'before'   => '<li typeof="v:Breadcrumb">',
								'after'   => '</li>',
								'home'	=> __('Home', 'ivan_domain'),
								'delimiter'  => '<li class="separator">/</li>',
							);
							$args = wp_parse_args( $defaults );
							woocommerce_get_template( 'global/breadcrumb.php', $args );
							?>
					<?php endif; ?>

				</div>

			</div><!--.row -->
		</div><!--.container-->
	</div>
<?php
else :

	if( ( false == ivan_get_option('header-negative-height') && true == ivan_get_option('title-wrapper-enable-switch') ) OR
		true == ivan_get_option('shop-boxed-page') )
		echo apply_filters('ivan_blog_divider', '<div class="title-wrapper-divider blog-version"></div>');

	if( true == ivan_get_option('title-wrapper-enable-switch') && false == ivan_get_option('shop-boxed-page') )
		$_classes .= ' no-title-wrapper';
endif; 
?>
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

		<div class="<?php echo apply_filters( 'iv_content_wrapper_classes', 'iv-layout content-wrapper shop-wrapper ', 'shop' ); ?>">
			<div class="container">





				<?php if(isset($_COOKIE['user_pincode']) || isset($_SESSION['all_sellers'])){ ?>

				<div id="pin_options" class="text-center">
					<h4>
						<?php
						if(isset($_SESSION['all_sellers']) && $_SESSION['all_sellers']=='yes'){
							echo "You currently viewing products from all sellers";
						}else{
							echo "<i class='fa fa-map-marker'></i> Your city is <strong>".$_COOKIE['user_city']."</strong> and pincode <strong>".$_COOKIE['user_pincode']."</strong> <a id='change-pincode'>[ Change Pincode ]</a>";
						}
						?>
			
						<?php
						if(isset($_SESSION['all_sellers']) && $_SESSION['all_sellers']=='yes'){
							echo '<a id="set_all_seller" data-seller="no">[ View products based on your pincode ]</a>';
						}else{
							echo '<a id="set_all_seller" data-seller="yes">[ View products from all sellers ]</a>';
						}
						?>
					</h4>
				</div>

				<?php } ?>






				<?php
				// Boxed Page Logic
				if( true == ivan_get_option('shop-boxed-page') && false == ivan_get_option('header-negative-height') ) : ?>
				<div class="boxed-page-wrapper">

					<?php
					// Adds Title
					if( false == ivan_get_option('title-wrapper-enable-switch') && true == ivan_get_option('shop-boxed-page')
						&& false == ivan_get_option('header-negative-height') ) :
						
						// Display Title again but now inside the boxed div..
						?>
							<div id="iv-layout-title-wrapper" class="<?php echo apply_filters( 'iv_title_wrapper_classes', 'iv-layout title-wrapper title-wrapper-shop title-wrapper-' . $title_class); ?> <?php echo ivan_get_option('title-wrapper-color-scheme'); ?>">
								<div class="container">
									<div class="row">

										<div class="col-xs-12 col-sm-12 col-md-12 ivan-title-inner">
											<h2 ><?php echo ivan_get_option('title-text-shop'); ?></h2>
											<?php // Display optional description of shop
											if( ivan_get_option('title-desc-shop') != '' ) : ?>
												<div class="title-description">
													<p><?php echo nl2br(ivan_get_option('title-desc-shop')); ?></p>
												</div>
											<?php 
											endif;	
											?>

											<?php if( ivan_get_option('breadcrumb-shop-disable') == false && $title_class != 'large' ) : ?>
													<?php 
													// Display Breadcrumb
													$defaults = array(
														'wrap_before'  => '<div class="ivan-breadcrumb ivan-woo-breadcrumb"><ul class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . apply_filters('ivan_you_are_here_shop', '<li class="intro">'. __('You are here:', 'ivan_domain') .'</li>'),
														'wrap_after' => '</ul></div>',
														'before'   => '<li typeof="v:Breadcrumb">',
														'after'   => '</li>',
														'home'	=> __('Home', 'ivan_domain'),
														'delimiter'  => '<li class="separator">/</li>',
													);
													$args = wp_parse_args( $defaults );
													woocommerce_get_template( 'global/breadcrumb.php', $args );
													?>
											<?php endif; ?>
											
										</div>

									</div><!--.row -->
								</div><!--.container-->
							</div>
						<?php
					endif; ?>

					<div class="boxed-page-inner">
				<?php endif; ?>

					

					<div class="row">

						<?php
						$_layout = ivan_get_option('woo-shop-layout');

						get_template_part( 'woocommerce/layouts/shop', $_layout );
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
	<div class="container">
<div class="row">
		<div class="col-sm-1 hidden-xs"><BR><hr class="dark-hr"></div> 
		<div class="col-sm-3  col-xs-4 text-center facility "><div class="sales center-block shake"></div>  <B>QUALITY</B> <hr></div>
		<div class="col-sm-4 col-xs-4 text-center facility"><div class="free center-block shake"></div> <B>CASH ON DELIVERY </B><hr></div>
		<div class="col-sm-3 col-xs-4 text-center facility"><div class="shipping-track center-block shake"></div><B>24*7 SUPPORT </B><hr></div>
		<div class="col-sm-1 hidden-xs"><BR><hr class="dark-hr"></div>
</div>
</div>
<BR><BR>
<?php get_footer( 'shop' ); ?>