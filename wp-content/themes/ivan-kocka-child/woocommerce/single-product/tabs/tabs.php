<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

$tabStyle = ivan_get_option('woo-product-tabs-layout');

if ( $tabStyle == 'default' && ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs">
		<ul class="tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>

				<li class="<?php echo $key ?>_tab">
					<a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>

			<?php endforeach; ?>

			<?php
			// Custom Tab Option
			if( true == ivan_get_option('woo-product-extra-tab') ) :
			?>
			<li class="extra_tab">
				<a href="#tab-extra"><?php echo ivan_get_option('woo-product-extra-tab-title'); ?></a>
			</li>
			<?php
			endif;
			?>

		</ul>
		<?php foreach ( $tabs as $key => $tab ) : ?>

			<div class="panel entry-content" id="tab-<?php echo $key ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>

		<?php endforeach; ?>

		<?php
			// Custom Tab Content
			if( true == ivan_get_option('woo-product-extra-tab') ) :
			?> 
			<div class="panel entry-content" id="tab-extra">
				 <?php echo do_shortcode( ivan_get_option('woo-product-extra-tab-content') ); ?>
			</div>	
		<?php
			endif;
		?>

	</div>

<?php endif; ?>

<?php
// Block Style
if ( $tabStyle == 'block' && ! empty( $tabs ) ) : ?>

	<div class="single-product-blocks">
		
		<?php foreach ( $tabs as $key => $tab ) : ?>

			<div class="single-product-block">
				<div class="row">

					<div class="col-xs-12 col-sm-12 col-md-2">
						<h4 class="single-product-block-title"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></h4>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-10">
						<div class="panel entry-content">
							<?php call_user_func( $tab['callback'], $key, $tab ) ?>
						</div>
					</div>

				</div><!-- .row -->
			</div>

		<?php endforeach; ?>

		<?php
		// Custom Tab Option
		if( true == ivan_get_option('woo-product-extra-tab') ) :
		?>
		<div class="single-product-block">
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-2">
					<h4 class="single-product-block-title"><?php echo ivan_get_option('woo-product-extra-tab-title'); ?></h4>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-10">
					<div class="panel entry-content">
						<?php echo do_shortcode( ivan_get_option('woo-product-extra-tab-content') ); ?>
					</div>
				</div>

			</div><!-- .row -->
		</div>
		<?php
		endif;
		?>

	</div><!--.single-product-blocks-->

<?php endif; ?>

<?php

// Vertical Style
if ( $tabStyle == 'vertical' && ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs tabs-vertical">
	<div class="row">
		<div class="col-md-4">
			<ul class="tabs tabs-vertical">
				<?php foreach ( $tabs as $key => $tab ) : ?>

					<li class="<?php echo $key ?>_tab">
						<a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
					</li>

				<?php endforeach; ?>

				<?php
				if( true == ivan_get_option('woo-product-extra-tab') ) :
				?>
				<li class="extra_tab">
					<a href="#tab-extra"><?php echo ivan_get_option('woo-product-extra-tab-title'); ?></a>
				</li>
				<?php
				endif;
				?>

			</ul>
		</div>

		<div class="col-md-8">
			<?php foreach ( $tabs as $key => $tab ) : ?>

				<div class="panel entry-content" id="tab-<?php echo $key ?>">
					<?php call_user_func( $tab['callback'], $key, $tab ) ?>
				</div>

			<?php endforeach; ?>

			<?php
			// Custom Tab Content
			if( true == ivan_get_option('woo-product-extra-tab') ) :
				?> 
				<div class="panel entry-content" id="tab-extra">
					 <?php echo do_shortcode( ivan_get_option('woo-product-extra-tab-content') ); ?>
				</div>	
			<?php
			endif;
			?>
		</div>

	</div><!--.row-->
	</div>

<?php endif; ?>