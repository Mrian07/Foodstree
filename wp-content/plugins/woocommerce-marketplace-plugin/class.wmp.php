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












public function wmp_shipping_rate(){
    global $woocommerce; 

    $items = $woocommerce->cart->get_cart();

    $seller_count = array();
    foreach($items as $item => $values) {

        $_product = $values['data']->post;
        $seller_id = $_product->post_author;
        $subtotal = $values['line_subtotal'];

        $seller_count[] = array('seller_id'=>$seller_id, 'subtotal'=>$subtotal);

    }

    $merged = array();

    foreach ($seller_count as $count) {
        if (isset($merged[$count['seller_id']])) {
            $merged[$count['seller_id']]['subtotal'] += $count['subtotal'];
        } else {
            $merged[$count['seller_id']] = $count;
        }
    }


    $seller_shipping = array();
    foreach ($merged as $merge) {

        $shipping_amount = $this->seller_ship_amount($merge['seller_id'], $merge['subtotal']);

        $seller_shipping[] = array('seller_id'=>$merge['seller_id'], 'shipping_amount'=>$shipping_amount);

    }


    $rate_data = array();
    foreach($seller_shipping as $ship_rate){
        $rate_data[] = $ship_rate['shipping_amount'];
    }

    $final_shipping_rate = array_sum($rate_data);

    return $final_shipping_rate;

}







public function seller_ship_amount($id, $subtotal){
 $value = maybe_unserialize(get_user_meta( $id, 'seller_shipping_methods', true ));

 foreach( $value as $method ){
  $min_total = $method['min_total'];
  $max_total = $method['max_total'];

  if($subtotal>$min_total && $subtotal<=$max_total){

  //for fixed shipping price
      if($method['method'] == 'fixed'){

        $rate = $method['rate'];

  //for pincode base shipping price  
    }else{

    //$pincode = $_POST['calc_shipping_postcode'];
        $pincode = $_COOKIE['user_pincode'];

     $rate = $this->ship_rate_by_pincode($id,$pincode);

     //$rate = 10;
    }

}

}

return $rate; 
}








public function ship_rate_by_pincode($user_id,$pincode){

    global $wpdb;
    $query = $wpdb->prepare( "SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode LIKE %s", $pincode );
    $sellers_info = $wpdb->get_var( $query );  
    if(is_null($sellers_info)){
        $rate = 0;
    }else{

     $sellers_info = maybe_unserialize($sellers_info);
     $found = 0;
     foreach ($sellers_info as  $seller_info){
        if((int)$seller_info['user_id'] != $user_id){
            continue;
        }else{
            $shipping = ($seller_info['shipping'])? $seller_info['shipping'] : 0;
            $rate = $shipping;
            $found = 1;
            break;
        }
    }

    if($found == 0)
        $rate = 0;

}

return $rate;
}












public function wmp_additional_cod_charge(){
    global $woocommerce; 

    $items = $woocommerce->cart->get_cart();

    $seller_count = array();
    foreach($items as $item => $values) {

        $_product = $values['data']->post;
        $seller_id = $_product->post_author;
        $subtotal = $values['line_subtotal'];

        $seller_count[] = array('seller_id'=>$seller_id, 'subtotal'=>$subtotal);

    }

    $merged = array();

    foreach ($seller_count as $count) {
        if (isset($merged[$count['seller_id']])) {
            $merged[$count['seller_id']]['subtotal'] += $count['subtotal'];
        } else {
            $merged[$count['seller_id']] = $count;
        }
    }


    $seller_cod = array();
    foreach ($merged as $merge) {

        $cod_amount = $this->seller_additional_cod_amount($merge['seller_id'], $merge['subtotal']);

        $seller_cod[] = array('seller_id'=>$merge['seller_id'], 'cod_amount'=>$cod_amount);

    }


    $rate_data = array();
    foreach($seller_cod as $cod_rate){
        $rate_data[] = $cod_rate['cod_amount'];
    }

    $final_cod_amount = array_sum($rate_data);

    return $final_cod_amount;

}







public function seller_additional_cod_amount($id, $subtotal){
 $value = maybe_unserialize(get_user_meta( $id, 'seller_shipping_methods', true ));

 foreach( $value as $method ){
  $min_total = $method['min_total'];
  $max_total = $method['max_total'];

  if($subtotal>$min_total && $subtotal<=$max_total){


        $rate = $method['cod_charges'];

        if(!$rate || $rate<=0){
            $cod_rate = 0;
        }else{
            $cod_rate = $rate;
        }

        break;
}

}

return $cod_rate; 
}














    }
}




