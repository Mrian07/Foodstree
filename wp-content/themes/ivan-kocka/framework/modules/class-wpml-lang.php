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

class Ivan_Module_WPML_Lang extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_wpml_lang';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $classes = '' ) {
		if( function_exists('icl_get_languages') ) : 
		?>

		<div class="iv-module wpml-lang <?php echo $classes; ?>">
			<div class="centered">
				<?php echo ivan_language_selector_flags_return(); ?>
			</div>
		</div>

		<?php
		endif;
	}

}