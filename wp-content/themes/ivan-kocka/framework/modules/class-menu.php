<?php
/**
 *
 * Class used as base to create modules that can be attached to layouts 
 *
 * @package   IvanFramework
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 * @version 1.0
 * @since 1.0
 */

class Ivan_Module_Menu extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_menu';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $args = null ) {
		$_args = array();

		if( $args != null )
			$_args = $args;

		if( is_singular() ) {

			if( null != ivan_get_post_option( 'menu-replace-' . $_args['theme_location'] ) ) {
				$_args['menu'] = ivan_get_post_option( 'menu-replace-' . $_args['theme_location'] );
				//$_args['theme_location'] = '';
				//var_dump($args);
			} 
		}

		$_args['fallback_cb'] = 'ivan_menu_fb';

		if( has_nav_menu( $_args['theme_location'] ) ) {
			wp_nav_menu( apply_filters('ivan_menu_args_filter', $_args ) );
		} else {
			?>
			<div class="iv-module custom-text hidden-xs hidden-sm">
				<div class="centered">
					<?php _e('Assign a menu at Appearance > Menus', 'ivan_domain'); ?>	
				</div>
			</div>
			<?php
		}
	}
}