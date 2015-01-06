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

class Ivan_Module_Social_Icons extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_social_icons';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $optionID, $classes = '' ) {
		
		$icons = ivan_get_option( $optionID );

		if($icons != false) {
		?>

		<div class="iv-module social-icons <?php echo $classes; ?>">
			<div class="centered">
			<?php
				if( !empty( $icons ) ) : ?>

				<?php foreach ($icons as $icon) : ?>
					<a href="<?php echo $icon['title']; ?>" target="_blank"><i class="fa fw fa-<?php echo $icon['url']; ?>"></i></a>
				<?php endforeach; ?>

			<?php endif; ?>
			</div>
		</div>

		<?php
		} // #endif
	}

}