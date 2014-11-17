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

class Ivan_Module_WPML_Currency extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_wpml_currency';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $classes = '' ) {
		?>

		<div class="iv-module wpml-currency <?php echo $classes; ?>">
			<div class="centered">
				<?php do_action('currency_switcher', array('format' => '%symbol%', 'switcher_style' => 'list', 'orientation' => 'horizontal')); ?>
			</div>
		</div>

		<?php
	}

}