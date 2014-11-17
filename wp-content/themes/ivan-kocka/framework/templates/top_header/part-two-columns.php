<?php
/**
 *
 * Template Part called at class Ivan_Layout_Top_Header_Two_Columns
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
		'theme_location' => 'secondary',
		'container' => 'div',
		'container_class' => 'hidden-xs hidden-sm iv-module-menu menu-wrapper',
		'menu_class' => ivan_get_option_display( 'top-header-v-sign-switch', ' with-arrow', '' ) . ' menu' . '',
		'menu_holder' => 'centered'
	);
?>

<div class="<?php echo apply_filters( 'iv_top_header_classes', 'iv-layout top-header two-columns '. $_classes ); ?>">
	<div class="container">
		<div class="row">

			<div class="col-xs-6 col-sm-6 col-md-<?php echo ivan_get_option('top-header-left-width'); ?> top-header-left-area">

				<?php 
				if( ivan_get_option('top-header-menu-left-switch') == true && ivan_get_option('top-header-menu-disable') == false ) {
					Ivan_Module_Menu::display( $menu_args );
				}
				?>

				<?php
				if( ivan_get_option( 'top-header-text-switch' ) ) :
					Ivan_Module_Custom_Text::display( 'top-header-text-content', 'hidden-xs hidden-sm' );
				endif;
				?>

				<?php
				if( ivan_get_option( 'top-header-wpml-lang-switch' ) ) :
					Ivan_Module_WPML_Lang::display();
				endif;
				?>

				<?php
				if( ivan_get_option( 'top-header-wpml-currency-switch' ) ) :
					Ivan_Module_WPML_Currency::display();
				endif;
				?>
								
			</div>
			
			<div class="col-xs-6 col-sm-6 col-md-<?php echo ivan_get_option('top-header-right-width'); ?> top-header-right-area">

				<?php
					if( ivan_get_option( 'top-header-woo-cart-switch' ) ) :
						Ivan_Module_Woo_Cart::display('max-hover');
					endif;
				?>

				<?php
				if( ivan_get_option( 'top-header-search-switch' ) ) :
					Ivan_Module_Live_Search::display('max-hover');
				endif; ?>

				<?php
					if( ivan_get_option( 'top-header-login-ajax-switch' ) ) :
						Ivan_Module_Login_Ajax::display('max-hover');
					endif;
				?>

				<?php
				if( ivan_get_option( 'top-header-social-switch' ) ) :
					Ivan_Module_Social_Icons::display( 'top-header-social-icons', 'hidden-xs hidden-sm' ); // @todo: replace 'option_id' by the correct option ID
				endif;
				?>

				<?php
					// ensure the text, social or menu is being displayed, else isn't necessary display the responsive menu...
					if( ivan_get_option( 'top-header-text-switch' ) OR ivan_get_option( 'top-header-social-switch' ) OR ivan_get_option('top-header-menu-disable') == false ) :
						Ivan_Module_Responsive_Menu::display('.top-header', 'top-header-menu-wrap');
					endif;
				?>

				<?php
				if( ivan_get_option('top-header-menu-left-switch') != true && ivan_get_option('top-header-menu-disable') == false ) {
					Ivan_Module_Menu::display( $menu_args );
				}
				?>
			</div>

		</div>					
	</div>
</div>