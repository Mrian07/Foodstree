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

class Ivan_Module {

	// Module slug used as parameters to actions and filters
	public $slug = '_default_slug';

	/**
	 * Initialize the layout defining actions, filters and any necessary function/task
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		/* Actions and Filters */
		//add_action( '@TODO', array( $this, 'action_method_name' ) );
		//add_filter( '@TODO', array( $this, 'filter_method_name' ) );

	}
	
}