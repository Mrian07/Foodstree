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

class Ivan_Module_Responsive_Menu extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_responsive_menu';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $menu_selector, $wrap_id ) {
		?>

		<div class="iv-module responsive-menu hidden-lg hidden-md">
			<div class="centered">
				<a class="mobile-menu-trigger" href="#" data-selector="<?php echo $menu_selector; ?>" data-id="<?php echo $wrap_id; ?>"><i class="fa fa-bars"></i></a>
			</div>
		</div>

		<?php
	}

}