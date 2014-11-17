<?php
/**
 * Used in Login with AJAX plugin
 *
 */

// Deregister default CSS
if( function_exists('login_with_ajax') ) {

	add_action('init', 'iv_deregister_lwa_style', 99);
	function iv_deregister_lwa_style() {
		wp_deregister_style( 'login-with-ajax' );
	}

}