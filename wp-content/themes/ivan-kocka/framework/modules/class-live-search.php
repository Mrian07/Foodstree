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

class Ivan_Module_Live_Search extends Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_live_search';

	/**
	 * Calls the respective template part or markup that must be displayed
	 *
	 * @since     1.0.0
	 */
	public static function display( $classes = '' ) {
		?>

		<div class="iv-module live-search <?php echo $classes; ?>">
			<div class="centered">
				<a href="#" class="trigger"><i class="fa fa-search"></i></a>
				<div class="inner-wrapper">
					<div class="inner-form">
					 	<form method="get" action="<?php echo iv_get_home_url(); ?>">
							<input type="search" name="s" id="s" />

							<?php
							// Enable only products search if you're using a WooCommerce shop
							if( true == ivan_get_option('search-shop-switch') ) : ?>
								<input type="hidden" name="post_type" value="product" />
							<?php endif; ?>

							<a class="submit-form" href="#"><i class="fa fa-search"></i></a>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php
	}

}

