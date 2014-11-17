<?php
/**
 *
 * Template Part called at class Ivan_Layout_Footer_Normal
 *
 * @package   IvanFramework
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 * @version 1.0
 * @since 1.0
 */

$_classes = '';

?>

<?php if( true == ivan_get_option('footer-da-before-enable') ) : ?>
<div class="<?php echo apply_filters('iv_dynamic_footer_classes', 'iv-layout dynamic-area dynamic-footer dynamic-footer-top'); ?>">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">

			<?php
				$_id = ivan_get_option('footer-da-before');
				ivan_display_dynamic_area( $_id );
			?>

			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
//Check if layout is not disabled - this check is being made here because Dynamic Areas should still be visible even
// without footer enabled...
if( true != ivan_get_option('footer-enable-switch') ) :
?>

	<div class="<?php echo apply_filters( 'iv_footer_classes', 'iv-layout footer footer-normal '. $_classes ); ?>">
		<div class="container">
			<div class="row">

				<?php
				if(0 != ivan_get_option('footer-column-1')) : ?>
					<div class="col-xs-12 col-sm-<?php echo ivan_get_option('footer-column-1'); ?> col-md-<?php echo ivan_get_option('footer-column-1'); ?> widget-col widget-col-1">
						<?php dynamic_sidebar( 'widgets-footer-1' ); ?>
					</div>
				<?php endif; ?>

				<?php
				if(0 != ivan_get_option('footer-column-2')) : ?>
					<div class="col-xs-12 col-sm-<?php echo ivan_get_option('footer-column-2'); ?> col-md-<?php echo ivan_get_option('footer-column-2'); ?> widget-col widget-col-2">
						<?php dynamic_sidebar( 'widgets-footer-2' ); ?>
					</div>
				<?php endif; ?>

				<?php
				if(0 != ivan_get_option('footer-column-3')) : ?>
					<div class="col-xs-12 col-sm-<?php echo ivan_get_option('footer-column-3'); ?> col-md-<?php echo ivan_get_option('footer-column-3'); ?> widget-col widget-col-3">
						<?php dynamic_sidebar( 'widgets-footer-3' ); ?>
					</div>
				<?php endif; ?>

				<?php
				if(0 != ivan_get_option('footer-column-4')) : ?>
					<div class="col-xs-12 col-sm-<?php echo ivan_get_option('footer-column-4'); ?> col-md-<?php echo ivan_get_option('footer-column-4'); ?> widget-col widget-col-4">
						<?php dynamic_sidebar( 'widgets-footer-4' ); ?>
					</div>
				<?php endif; ?>

			</div>					
		</div>
	</div>

<?php
endif; // ends footer disabled check...
?>

<?php if( true == ivan_get_option('footer-da-after-enable') ) : ?>
<div class="<?php echo apply_filters('iv_dynamic_footer_classes', 'iv-layout dynamic-area dynamic-footer dynamic-footer-bottom'); ?>">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">

			<?php
				$_id = ivan_get_option('footer-da-after');
				ivan_display_dynamic_area( $_id );
			?>

			</div>
		</div>
	</div>
</div>
<?php endif; ?>