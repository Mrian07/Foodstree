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

class Ivan_Module_Custom_Text extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_custom_text';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $optionID, $classes = '' ) {
		// get the right option ID
		$text = ivan_get_option( $optionID );

		if( $text != '' ) :
		?>

		<div class="iv-module custom-text <?php echo $classes; ?>">
			<div class="centered">
				<?php echo do_shortcode( nl2br( $text ) ); ?>
			</div>
		</div>

		<?php
		endif;
	}

}