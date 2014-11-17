<?php
/**
 *
 * Template Part called at class Ivan_Layout_Bottom_Footer_Two_Columns
 *
 * @package   IvanFramework
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 * @version 1.0
 * @since 1.0
 */

?>

<?php
	$_classes = '';

	$menu_args = array(
		'theme_location' => 'bottom_footer',
		'container' => 'div',
		'container_class' => 'hidden-xs hidden-sm iv-module-menu menu-wrapper',
		'menu_class' => 'menu',
		'menu_holder' => 'centered',
		'depth' => 1,
	);
?>

<?php if( true == ivan_get_option('bottom-footer-da-before-enable') ) : ?>
<div class="<?php echo apply_filters('iv_dynamic_footer_classes', 'iv-layout dynamic-area dynamic-footer dynamic-bottom-footer-top'); ?>">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">

			<?php
				$_id = ivan_get_option('bottom-footer-da-before');
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
if( true != ivan_get_option('bottom-footer-enable') ) :
?>

	<div class="<?php echo apply_filters( 'iv_bottom_footer_classes', 'iv-layout bottom-footer two-columns '. $_classes ); ?>">
		<div class="container">
			<div class="row">

				<?php
				// Responsive Columns
				$_responsiveCols = 6;

				// If right column is 0, our big column will be 12 at mobile as well...
				if( 0 == ivan_get_option('bottom-footer-right-width') )
					$_responsiveCols = 12;
				?>

				<div class="col-xs-<?php echo $_responsiveCols; ?> col-sm-<?php echo $_responsiveCols; ?> col-md-<?php echo ivan_get_option('bottom-footer-left-width'); ?> bottom-footer-left-area">

					<?php
					if( ivan_get_option( 'bottom-footer-text-switch' ) ) :
						Ivan_Module_Custom_Text::display( 'bottom-footer-text-content', '' );
					endif;
					?>

					<?php 
					if( ivan_get_option('bottom-footer-menu-left-switch') == true && ivan_get_option('bottom-footer-menu-disable') == false ) {
						Ivan_Module_Menu::display( $menu_args );
					}
					?>

				<?php
				// If right column is greater than 0 display the markup
				if( 0 != ivan_get_option('bottom-footer-right-width') ) : ?>
				</div>
				
				<div class="col-xs-6 col-sm-6 col-md-<?php echo ivan_get_option('bottom-footer-right-width'); ?> bottom-footer-right-area">
				<?php endif; ?>

					<?php
					if( ivan_get_option( 'bottom-footer-social-switch' ) ) :
						Ivan_Module_Social_Icons::display( 'bottom-footer-social-icons', '' ); // @todo: replace 'option_id' by the correct option ID
					endif;
					?>

					<?php
						if( ivan_get_option('bottom-footer-menu-disable') == false ) {
							Ivan_Module_Responsive_Menu::display('.bottom-footer', 'bottom-footer-menu-wrap');
						}
					?>

					<?php
					if( ivan_get_option('bottom-footer-menu-left-switch') != true && ivan_get_option('bottom-footer-menu-disable') == false ) {
						Ivan_Module_Menu::display( $menu_args );
					}
					?>
				</div>

			</div>					
		</div>
	</div>

<?php
endif; // ends footer disabled check...
?>

<?php if( true == ivan_get_option('bottom-footer-da-after-enable') ) : ?>
<div class="<?php echo apply_filters('iv_dynamic_footer_classes', 'iv-layout dynamic-area dynamic-footer dynamic-bottom-footer-bottom'); ?>">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">

			<?php
				$_id = ivan_get_option('bottom-footer-da-after');
				ivan_display_dynamic_area( $_id );
			?>

			</div>
		</div>
	</div>
</div>
<?php endif; ?>