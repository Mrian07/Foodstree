<?php
/**
 * Main class
 *
 * @author  Ajency.in
 * @package Woocommerce Marketplace plugin
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


if ( ! class_exists( 'AJENCY_WMP' ) ) {
    /**
     * Woocommerce Marketplace plugin
     *
     */
    class AJENCY_WMP {
        /**
         * Plugin version
         *
         * @var string
         */
        public $version = '1.1.0';

        /**
         * Constructor
         *
         * @since 1.1.0
         */
        public function __construct() {

            // actions
            add_action( 'init', array( $this, 'init' ) );
            add_action( 'admin_menu', array( $this, 'registerDashboardMenu' ) );

            add_filter( 'query_vars', array( $this, 'sellerpage_rewrite_add_var') );
            add_action('init', array( $this, 'sellerpage_rewrite_rule'));
            add_action( 'template_redirect', array( $this, 'sellerpage_rewrite_catch') );

        }


        /**
         * Init method
         *
         * @access public
         * @since  1.1.0
         */
        public function init() {
            ob_start();
        }


        /**
         * Load and register dashboard menu
         *
         * @access public
         * @since  1.1.0
         */
        public function registerDashboardMenu() {
        	add_menu_page(__( 'Sellers', 'wmp' ), __( 'Sellers', 'wmp' ), 'manage_options', 'sellers', array(&$this, 'sellersListing'), '', 21);
            add_submenu_page( 'sellers', __( 'Add New Seller', 'wmp' ), __( 'Add New', 'wmp' ), 'manage_options', 'add-new-seller', array(&$this, 'newSeller'));
            add_submenu_page( 'null', __( 'Edit Seller', 'wmp' ), __( 'Edit Seller', 'wmp' ), 'manage_options', 'edit-seller', array(&$this, 'editSeller'));
        }




        public function sellersListing(){
           include(WMP_DIR.'admin-templates/seller-list.php');
        }

        public function newSeller(){
            include(WMP_DIR.'admin-templates/seller-new.php');
        }


         public function editSeller(){
            include(WMP_DIR.'admin-templates/seller-edit.php');
        }



function sellerpage_rewrite_add_var( $vars ) {
    $vars[] = 'seller';
    return $vars;
}


// Create the rewrites
function sellerpage_rewrite_rule() {
    add_rewrite_tag( '%seller%', '([^&]+)' );
    add_rewrite_rule(
        '^seller/([^/]*)/?',
        'index.php?seller=$matches[1]',
        'top'
    );
}


// Catch the URL and redirect it to a template file
function sellerpage_rewrite_catch() {
    global $wp_query;

    if ( array_key_exists( 'seller', $wp_query->query_vars ) ) {

       if ( '' != locate_template( 'seller-page.php' ) ) {
        include (TEMPLATEPATH.'/seller-page.php');
           exit;
       }else{
         include (WMP_DIR.'frontend-templates/seller-page.php');
         exit; 
     }

 }
}





    }
}




