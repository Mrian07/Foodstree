<?php
/**
 *
 * Class used as base to create main layouts
 *
 * @package   IvanFramework
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 * @version 1.0
 * @since 1.0
 */

class Ivan_Main_Layout_Normal extends Ivan_Main_Layout {

	// Main Layout slug used as parameters to actions and filters
	public $slug = 'normal';

	/**
	 * Initialize the layout defining actions, filters and any necessary function/task
	 *
	 * @since     1.0.0
	 */
	public function __construct( $_slug = null ) {

		if( $_slug != null )
			$this->$slug = $_slug;

		/* Actions and Filters */
		//add_action( '@TODO', array( $this, 'action_method_name' ) );
		//add_filter( '@TODO', array( $this, 'filter_method_name' ) );

	}

	/**
	 * Function hooked to @ivan_before action
	 *
	 * @since     1.0.0
	 */
	public function before() {
		do_action( 'ivan_top_banner' );
	}

	/**
	 * Function hooked to @ivan_header_section action
	 *
	 * @since     1.0.0
	 */
	public function header_section() {
		do_action( 'ivan_top_header' );
		do_action( 'ivan_header' );
		do_action( 'ivan_fixed_header' );
		do_action( 'ivan_bottom_header' );

		?>
		<div class="negative-push"></div>
		<?php
	}

	/**
	 * Function hooked to @ivan_before_content action
	 *
	 * @since     1.0.0
	 */
	public function before_content() {
		//do_action( 'ivan_title_wrapper' );
		do_action( 'ivan_before_content' );
	}

	/**
	 * Function hooked to @ivan_after_content action
	 *
	 * @since     1.0.0
	 */
	public function after_content() {
		do_action( 'ivan_after_content' );
	}

	/**
	 * Function hooked to @ivan_footer_section action
	 *
	 * @since     1.0.0
	 */
	public function footer_section() {
		do_action( 'ivan_top_footer' );
		do_action( 'ivan_footer' );
		do_action( 'ivan_bottom_footer' );
	}

	/**
	 * Function hooked to @ivan_after action
	 *
	 * @since     1.0.0
	 */
	public function after() {
		
	}

	/**
	 * Add additional classes to body tag, useful to CSS and JS
	 *
	 * @since     1.0.0
	 */
	public function add_body_classes( $classes ) {

		$classes[] = 'ivan-main-layout-normal';

		return $classes;
	}

	/**
	 * This function add the relations between the actions
	 * and the functions declared above
	 *
	 * @since     1.0.0
	 */
	public function render() {

		add_filter( 'body_class', array( $this, 'add_body_classes' ));

		add_action( 'ivan_before', array( $this, 'before' ) );
			add_action( 'ivan_header_section', array( $this, 'header_section' ) );

			add_action( 'ivan_content_before', array( $this, 'before_content' ) );
			add_action( 'ivan_content_after', array( $this, 'after_content' ) );
			
			add_action( 'ivan_footer_section', array( $this, 'footer_section' ) );
		add_action( 'ivan_after', array( $this, 'after' ) );
		
	}

}