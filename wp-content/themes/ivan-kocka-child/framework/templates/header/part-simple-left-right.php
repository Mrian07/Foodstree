<?php
/**
 *
 * Template Part called at class Ivan_Layout_Header_Simple_Right_Menu
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

	// Check if Fixed Height Header option is enabled and output the respective class.
	$_classes .= ivan_get_option_display( 'layout-header-fixed-height', ' fixed-height', '' );

	if(ivan_get_option('header-aside-menu-centered-switch')) {
		$_classes .= ' centered-menu-items';
	}

	// Apply color scheme to header
	$_classes .= ' ' . ivan_get_option( 'aside-header-color-scheme' );

	// Locally Disabled Modules
	$disabled_items = ivan_get_post_option( 'header-local-disabled-modules' );
	if( $disabled_items == null )
		$disabled_items = array();

	$enabled_items = ivan_get_post_option( 'header-local-enabled-modules' );
	if( $enabled_items == null )
		$enabled_items = array();

?>

<div class="<?php echo apply_filters( 'iv_header_classes', 'iv-layout header simple-left-right'. $_classes ); ?>">
	<div class="container-fit">
		<div class="row-fit">

			<div class="header-top-area">
				<?php Ivan_Module_Logo::display( true ); ?>
			</div>

			<div class="header-bottom-area">

				<div class="modules-row">

					<?php
						Ivan_Module_Responsive_Menu::display('.header', 'header-menu-wrap');
					?>	

					<?php
					if( ivan_get_option( 'header-search-switch' ) || in_array('live_search', $enabled_items) == true ) :
						if( in_array('live_search', $disabled_items) == false )	
							Ivan_Module_Live_Search::display();
					endif; ?>

					<?php
						if( ivan_get_option( 'header-login-ajax-switch' ) || in_array('login_ajax', $enabled_items) == true ) :
							if( in_array('login_ajax', $disabled_items) == false )	
								Ivan_Module_Login_Ajax::display();
						endif;
					?>

					<?php
						if( ivan_get_option( 'header-woo-cart-switch' ) || in_array('woo_cart', $enabled_items) == true ) :
							if( in_array('woo_cart', $disabled_items) == false )
								Ivan_Module_Woo_Cart::display();
						endif;
					?>

				</div>

				<?php 
				$menu_args = array(
					'theme_location' => 'primary',
					'container' => 'div',
					'container_class' => 'hidden-xs hidden-sm iv-module menu-wrapper',
					'menu_class' => ivan_get_option_display( 'header-v-sign-switch', ' with-arrow', '' ) . ' menu' . '',
					'menu_holder' => ''
					);

				Ivan_Module_Menu::display( $menu_args ); 
				?>

				<div class="hidden-xs hidden-sm single-module-row">
					<?php
					if( ivan_get_option( 'header-social-switch' ) || in_array('social_icons', $enabled_items) == true ) :
						if( in_array('social_icons', $disabled_items) == false )
							Ivan_Module_Social_Icons::display( 'header-social-icons', 'hidden-xs hidden-sm' ); // @todo: replace 'option_id' by the correct option ID
					endif;
					?>

					<?php
					if( ivan_get_option( 'header-text-switch' ) || in_array('text_module', $enabled_items) == true ) :
						if( in_array('text_module', $disabled_items) == false )	
							Ivan_Module_Custom_Text::display( 'header-text-content', 'hidden-xs hidden-sm' );
					endif;
					?>
				</div>

				<div class="hidden-xs hidden-sm portfolio-filter-receiver">

				</div>

				<?php
				// Check if is not disabled in options panel...
				if( true != ivan_get_option('layout-header-widget-area') ) : ?>

					<div class="hidden-xs hidden-sm widget-area">
						<?php
							dynamic_sidebar( 'sidebar-aside' );
						?>
					</div>

				<?php endif; ?>

			</div>

		</div>					
	</div>
</div>