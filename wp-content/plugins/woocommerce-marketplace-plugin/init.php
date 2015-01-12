<?php
/**
 * Plugin Name: Woocommerce Marketplace plugin
 * Plugin URI: http://ajency.in/
 * Description: Marketplace plugin for woocommerce.
 * Version: 1.1.0
 * Author: Ajency.in
 * Author URI: http://ajency.in/
 * Text Domain: wmp
 * Domain Path: /languages/
 *
 * @author  Ajency.in
 * @package Woocommerce Marketplace plugin
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly



register_activation_hook( __FILE__, 'wmp_activate' );
register_deactivation_hook( __FILE__, 'wmp_deactivate' );



/**
 * Required functions
 */
if ( ! defined( 'WMP_FUNCTIONS' ) ) {
    require_once( 'wmp-common/db-functions.php' );
    /*require_once( 'wmp-common/wmp-functions.php' );*/
}

function wmp_constructor() {
    global $woocommerce;
    if ( ! isset( $woocommerce ) ) {
        return;
    }

    load_plugin_textdomain( 'wmp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    define( 'WMP_URL', plugin_dir_url( __FILE__ ) );
    define( 'WMP_DIR', plugin_dir_path( __FILE__ ) );
    define( 'WMP_VERSION', '1.1.0' );

    // Load required classes and functions
    require_once( 'wmp-common/wmp-functions.php' );
    require_once( 'wmp-common/order-functions.php' );
    require_once( 'wmp-common/admin-functions.php' );
    require_once( 'wmp-common/wmp-countries.php' );
    require_once( 'wmp-list-table.php' );
    require_once( 'class.wmp.php' );

    // Let's start the game!
    global $ajency_wmp;
    $ajency_wmp = new AJENCY_WMP();
}

add_action( 'plugins_loaded', 'wmp_constructor' );
