<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
  global $woocommerce;

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    //if(is_woocommerce()){

    
    $data = array(
      'ajax_url'=>admin_url('admin-ajax.php'),
      'theme_url'=>get_stylesheet_directory_uri(),
      'checkout_url'=>$woocommerce->cart->get_checkout_url(),
      );

      if(isset($_COOKIE['pincode'])){
        $data['pincode'] = $_COOKIE['pincode'];
      }

      if(is_single()){
        global $post;
        $data['product_id'] = $post->ID;
        $data['seller_id'] = $post->post_author;
      }

       wp_enqueue_script('pincode_popup', get_stylesheet_directory_uri() . '/js/pincode_popup.js', array('jquery'), '', true);
       wp_localize_script( 'pincode_popup', 'pincode_data', $data );
    //}
}


function get_authored_products($query) {

  
  if($query->is_main_query()){

    if(((!empty($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'product') || is_woocommerce()) && !is_admin() ){
      
    //check if post type is product or page is woocommerce template and not admin dashboard interface
   // if(($query->query_vars['post_type'] == 'product' || is_woocommerce()) && !is_admin()){
      $authors = get_pincode_sellers();
      $query->set('author__in',  $authors);
    //}

    }

  }

  //echo $_SESSION['all_sellers'];

  return $query;
}

//add_action( 'pre_get_posts', 'get_authored_products' );











// get seller ids based on pincode value saved in the cookie
function get_pincode_sellers(){
    global $wpdb;
    
    $sellers = array();
    if(isset($_COOKIE['pincode'])){
       $seller_ids = $wpdb->get_var( $wpdb->prepare("SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode like %s ",$_COOKIE['pincode'] ));
       $seller_ids = maybe_unserialize($seller_ids);

             
       if(empty($seller_ids)){
           // NOT to fetch products if the pincode has no sellers
           $sellers[] = 0;
       }else{
                        
           foreach ($seller_ids as $seller){
               //$sellers[] = (int)$seller;

                $sellers[] = $seller['user_id'];

           }

       }
        
    }else{
        // NOT to fetch products if the user_pincode is not set
        $sellers[] = 0;
    }
    return array_unique($sellers);
}

// terms filter to display the count of products in a category based on pincode selection
function get_terms_posts_count_filter( $terms, $taxonomies, $args ){
  global $wpdb;
        
  $taxonomy = $taxonomies[0];

        if ( ! is_array($terms) && count($terms) < 1 )
                return $terms;
            
        if($taxonomy == 'product_cat' && !is_admin()){
            foreach ( $terms as $term )
            {
                $author_ids = get_pincode_sellers();
                $author_ids = implode(',',$author_ids);
                
                $result = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts p JOIN $wpdb->term_relationships "
                        . "rl ON p.ID = rl.object_id WHERE rl.term_taxonomy_id = $term->term_taxonomy_id AND "
                        . "p.post_status = 'publish' AND p.post_author IN ($author_ids)");
                $term->count = $result;
            }
        }
        
  return $terms;
}



function set_pincode_session(){
if($_SESSION['all_sellers'] !='yes'){
add_filter('get_terms', 'get_terms_posts_count_filter', 10, 3);
add_action( 'pre_get_posts', 'get_authored_products' );
}
}
//add_action('init', 'set_pincode_session');



function register_my_menu() {
  register_nav_menu('secondry-menu',__( 'Secondry' ));
}
add_action( 'init', 'register_my_menu' );






//Getting city names from db
add_action('wp_ajax_nopriv_citylist', 'pincode_city_list');
add_action( 'wp_ajax_citylist', 'pincode_city_list' );

function pincode_city_list() {

  global $wpdb;

  $keyword = $_POST['keyword'];

  $query = "SELECT DISTINCT city FROM {$wpdb->prefix}pincodes WHERE city LIKE '".$keyword."%' ORDER BY city ASC LIMIT 0, 10";
  $pincodes = $wpdb->get_results($query, ARRAY_A);

  foreach($pincodes as $pincode){
    echo '<li class="pin_city" data-city="'.$pincode['city'].'">'.$pincode['city'].'</li>';
  }
  die();
}




//Getting pincode list by city name
add_action('wp_ajax_nopriv_pinlist', 'pincode_list_by_city');
add_action( 'wp_ajax_pinlist', 'pincode_list_by_city' );

function pincode_list_by_city() {

  global $wpdb;

  $city = $_POST['city'];

  $query = "SELECT pincode FROM {$wpdb->prefix}pincodes WHERE city = '".$city."' ORDER BY pincode ASC";
  $pincodes = $wpdb->get_results($query, ARRAY_A);

  echo '<div class="pinlist_title">Select your pincode:</div>';
  foreach($pincodes as $pincode){
    echo '<a class="pin_code" data-pincode="'.$pincode['pincode'].'">'.$pincode['pincode'].'</a>';
  }

  die();
}



//set session for listing page
//add_action('wp_ajax_nopriv_allseller', 'set_product_listing_session');
//add_action( 'wp_ajax_allseller', 'set_product_listing_session' );

function set_product_listing_session() {

$key = $_POST['setseller'];
session_start();

$_SESSION['all_sellers'] = $key;

echo $_SESSION['all_sellers'];
die();
}




//Custom validation for checkout page
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
  global $woocommerce;

if(isset($_POST['billing_postcode'])){
  if ( !is_numeric($_POST['billing_postcode']) || strlen($_POST['billing_postcode']) > 6 || strlen($_POST['billing_postcode']) < 6){
    //$woocommerce->add_error( __('Please enter 6 digit number for postcode') );
    wc_add_notice( 'Please enter 6 digit number for postcode', 'error' );
  }
}


if(isset($_POST['billing_phone'])){
  if ( strlen($_POST['billing_phone']) > 10 || strlen($_POST['billing_phone']) < 10){
    //$woocommerce->add_error( __('Please enter 10 digit number for phone') );
    wc_add_notice( 'Please enter 10 digit number for phone', 'error' );
  }
}

}









//Get product category name by id
function get_product_category_by_id( $category_id ) {
    $term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' );
    return $term['name'];
}

//Get product category description by id
function get_product_category_description_by_id( $category_id ) {
    $term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' );
    return $term['description'];
}



//Add product description tab to a new location
/*function price_below(){
  wc_get_template( 'single-product/tabs/tabs.php' );
}
add_action( 'woocommerce_single_product_summary', 'price_below', 12 );

//Remove tab description block from current position
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );


//Remove add to cart from current position
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

//Register add to cart to a new location
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 35);
*/





/*add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

  $tabs['description']['title'] = __( 'Additional Information' );   // Rename the description tab
 
  return $tabs;

}
*/


//Remove reviews tab
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    // unset( $tabs['reviews'] ); 
    return $tabs;
}


//Hide trailing zeros for product price
add_filter( 'woocommerce_price_trim_zeros', 'wc_hide_trailing_zeros', 10, 1 );
function wc_hide_trailing_zeros( $trim ) {
    // set to false to show trailing zeros
    return true;
}





add_filter( 'woocommerce_get_availability', 'custom_get_availability', 1, 2);
  
function custom_get_availability( $availability, $_product ) {
    
    if ( $_product->is_in_stock() ) $availability['availability'] = __('', 'woocommerce');
  
   
    if ( !$_product->is_in_stock() ) $availability['availability'] = __('', 'woocommerce');
        return $availability;
    }













function isKVInArray($k, $v, $array) {
    $filtered = array_filter($array, function($item) use($k,$v) {
        return $item[$k] == $v;
    });
    if(count($filtered)>=1) return true;
    else return false;
}




/*function calculate_seller_ship_amount($id, $subtotal){

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

    $pincode = $_POST['calc_shipping_postcode'];

    $rate = get_rate_by_pincode($id,$pincode);

  }


  }


}


return $rate;
}






function get_rate_by_pincode($user_id,$pincode){
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






 
function seller_subtotal_data(){
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

$shipping_amount = calculate_seller_ship_amount($merge['seller_id'], $merge['subtotal']);

$seller_shipping[] = array('seller_id'=>$merge['seller_id'], 'shipping_amount'=>$shipping_amount);

}


$rate_data = array();
foreach($seller_shipping as $ship_rate){
$rate_data[] = $ship_rate['shipping_amount'];
}

$final_shipping_rate = array_sum($rate_data);

//echo $final_shipping_rate;


echo '<pre>';
print_r($seller_shipping);
echo '</pre>';

}

add_action('woocommerce_cart_calculate_fees', 'seller_subtotal_data');*/







function is_cod_servicable_current_cart(){
  global $woocommerce;
    
    $seller_ids = array();
    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
           $data = $values['data'];
           $post_data = $data->post;
           $seller_ids[] = (int)$post_data->post_author;
    }
    
    $seller_ids = array_unique($seller_ids);
    
    if(! is_cod_serviceable($seller_ids)){
    
        return false;
    }else{
      return true;
    }

}



//disable cod if sellers of cart products has no cod for the pincode
function disable_cod_pincode_not_serviceable( $available_gateways ) {
        
    /*if(! is_cod_servicable_current_cart()){
    
        unset(  $available_gateways['cod'] );
    }*/

    if(WC()->session->cart_cod == 'yes'){
      unset(  $available_gateways['ccavenue'] );
    }else{
      unset(  $available_gateways['cod'] );
    }
    
    return $available_gateways;

}
add_filter('woocommerce_available_payment_gateways','disable_cod_pincode_not_serviceable',10,1);







//check if sellers have COD on for the pincode
function is_cod_serviceable($seller_ids){
    global $wpdb;
    
    if(isset($_COOKIE['pincode'])){
       //$sellers_data = $wpdb->get_var( $wpdb->prepare("SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode like %s ",$_COOKIE['user_pincode'] ));
       $sellers_data = $wpdb->get_var( $wpdb->prepare("SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode like %s ",$_COOKIE['pincode'] ));
       $sellers_data = maybe_unserialize($sellers_data);
       
       if(empty($sellers_data))
           return false;
       
       foreach($sellers_data as $seller_data){
           
           if(! in_array((int) $seller_data['user_id'],$seller_ids))
                continue;
           
           if(!$seller_data['cod'])
               return false;
           
       }
       
       return true;
    }
    else{
        return false;
    }
} 







add_action('wmp_cod_is_available', 'cod_enable_field', 0);

function cod_enable_field() {

 if(is_cod_servicable_current_cart()){

  global $ajency_wmp;

  $cod_charge = $ajency_wmp->wmp_additional_cod_charge();

  if($cod_charge > 0){
    $label = 'Cash on Delivery (Additional fees - Rs.'.$ajency_wmp->wmp_additional_cod_charge().').';
  }else{
    $label = 'Cash on Delivery';
  }

  echo '<div id="enable_cod_div" class="coupon">';
  woocommerce_form_field( 'enable_cod', array(
    'type'          => 'checkbox',
    'class'        => array('enable_cod'),
    'label'        => __($label),
    'required'        => false,
    ));

  echo '<div class="clearfix"></div>';

  echo '</div>';

}

}




function remove_cod_session_on_cart_load(){
  global $woocommerce;
  if(is_cart()){
  WC()->session->set( 'cart_cod', 'no' );
}
}
add_action('template_redirect', 'remove_cod_session_on_cart_load');






function wp_add_cod_charge( $cart_object ) {

 if(WC()->session->cart_cod == 'yes'){

   if(is_cod_servicable_current_cart()){
 
    global $woocommerce;

    global $ajency_wmp;

    $cod_charge = $ajency_wmp->wmp_additional_cod_charge();
  
  
    $woocommerce->cart->add_fee( 'Additional COD fees', $cod_charge, true, 'standard' );

  }
}

  
  
}
 
add_action( 'woocommerce_cart_calculate_fees', 'wp_add_cod_charge' );







//Setting pincode session and checking products availibility
add_action('wp_ajax_nopriv_pincode_session', 'check_pincode_session');
add_action( 'wp_ajax_pincode_session', 'check_pincode_session' );

function check_pincode_session() {

  global $wpdb;
  global $woocommerce;

  $pincode = $_POST['pincode'];
  $cod = $_POST['cod'];
 
  setcookie('pincode', $pincode, time() + (86400 * 30), "/");

 
    $unavailable_products = array();
    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
           $data = $values['data'];
           $post_data = $data->post;
           $seller_id = (int)$post_data->post_author;

           if(!check_if_seller_available($seller_id, $pincode)){
            $unavailable_products[] = $post_data->post_title;
           }
     }


     if(count($unavailable_products)>0){
      $response = array(
        'status' => 'false',
        'products' => $unavailable_products
        );
     }else{

      WC()->session->set( 'cart_cod', $cod );

      $response = array(
        'status' => 'true'
        );
     }

    
echo json_encode($response);
  

  die();
}










//Setting pincode session and checking if the product is available
add_action('wp_ajax_nopriv_available_pincode_product', 'check_is_pincode_available_for_product');
add_action( 'wp_ajax_available_pincode_product', 'check_is_pincode_available_for_product' );

function check_is_pincode_available_for_product() {

  global $wpdb;
  global $woocommerce;

  $pincode = $_POST['pincode'];
  $seller_id = $_POST['seller_id'];
  $product_id = $_POST['product_id'];



  $ispinchange = '';
 if (!isset($_COOKIE['pincode'])){
    setcookie('pincode', $pincode, time() + (86400 * 30), "/");
    $woocommerce->cart->empty_cart();
    $ispinchange = 'data-pinchanged="true"';
  }else if($_COOKIE['pincode'] != $pincode){
    setcookie('pincode', $pincode, time() + (86400 * 30), "/");
    $woocommerce->cart->empty_cart();
    $ispinchange = 'data-pinchanged="true"';
  }

  
 

  $post = get_post($product_id);

 
  if(!check_if_seller_available($seller_id, $pincode)){
    $response = array(
      'status' => 'false',
      'message' => '<h4>Sorry! "'.$post->post_title.'" cannot be shipped to your pincode. >>> <a class="pincode-change" data-product-id="'.$product_id.'" data-seller-id="'.$seller_id.'"><strong>Change pincode</strong></a>.</h4>',
      'pinchange'=> $ispinchange
      );
  }else{

   
    $response = array(
      'status' => 'true'
      );
  }

    
echo json_encode($response);
  

  die();
}









//Setting pincode session and checking if the product is available
add_action('wp_ajax_nopriv_wmp_change_pincode', 'wmp_change_pincode');
add_action( 'wp_ajax_wmp_change_pincode', 'wmp_change_pincode' );

function wmp_change_pincode() {

  global $woocommerce;
 

$pincode = $_POST['pincode'];

 


 
  if(!isset($_COOKIE['pincode'])){
     setcookie('pincode', $pincode, time() + (86400 * 30), "/");
    $woocommerce->cart->empty_cart();
  }else if($_COOKIE['pincode'] != $pincode){
    setcookie('pincode', $pincode, time() + (86400 * 30), "/");
       $woocommerce->cart->empty_cart();
  }

  $response = array(
      'status' => 'true'
      );
     
echo json_encode($response);
  

  die();

}








function check_if_seller_available($seller_id, $pincode){
  global $wpdb;
   $seller_ids = $wpdb->get_var( $wpdb->prepare("SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode like %s ",$pincode ));
  $seller_ids = maybe_unserialize($seller_ids);
  if($seller_ids){

    foreach($seller_ids as $seller){

      if($seller['user_id'] == $seller_id){
        $exist = true;
        break;
      }

    }

    if($exist){
      return true;
    }else{
      return false;
    }
  }else{
    return false;
  }
}





function wmp_order_by_discount($query) {



  if ($query->is_main_query()/* && $query->is_post_type_archive()*/) {


$args = array_merge( $query->query_vars, array( 'post_type' => 'product' ) );
  
$posts_array = query_posts( $args );

$discount_data = array();
foreach($posts_array as $pro){

  $regular_price = get_post_meta($pro->ID, '_regular_price', true);
  $sale_price = get_post_meta($pro->ID, '_sale_price', true);
  if($regular_price != '' && $sale_price != ''){
    $discount = ((int)$regular_price - (int)$sale_price);
  }else{
    $discount = 0;
  }
  $discount_data[$pro->ID] = $discount;
}

arsort($discount_data, SORT_NUMERIC);
$data = array_reverse($discount_data, true);

$product_ids = array_keys($discount_data);

/*echo "<pre>";
print_r($product_ids);
echo "</pre>";*/

 
  $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
  if ( 'discount' == $orderby_value ) {
  $query->set('post__in', $product_ids);
  $query->set('order_by', 'FIELD(ID, '.implode(',',$product_ids).')');
}
  }
  return $query;
}






// add_filter( 'woocommerce_get_catalog_ordering_args', 'wmp_discount_catalog_ordering_args' );
function wmp_discount_catalog_ordering_args( $args ) {
  $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
  if ( 'discount' == $orderby_value ) {
   
    $args['post_type'] = 'product';

    $posts_array = query_posts( $args );
    
    $discount_data = array();
foreach($posts_array as $pro){

  $regular_price = get_post_meta($pro->ID, '_regular_price', true);
  $sale_price = get_post_meta($pro->ID, '_sale_price', true);
  if($regular_price != '' && $sale_price != ''){
    $discount = ((int)$regular_price - (int)$sale_price);
  }else{
    $discount = 0;
  }
  $discount_data[$pro->ID] = $discount;
}

arsort($discount_data, SORT_NUMERIC);
$data = array_reverse($discount_data, true);

/*$product_ids = array_keys($data);*/
$product_ids = array_keys($discount_data);

$args['post__in'] = implode(',',$product_ids);

$args['order_by'] = 'FIELD(ID, '.implode(',',$product_ids).')';

}
  return $args;
}

// add_filter( 'woocommerce_default_catalog_orderby_options', 'wmp_add_salediscount_to_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'wmp_add_salediscount_to_catalog_orderby' );
function wmp_add_salediscount_to_catalog_orderby( $sortby ) {
  // unset( $sortby['rating'] );
  // unset( $sortby['popularity'] );
  // $sortby['discount']   = 'Sort by discount';
  $sortby['date']   = 'New';
  $sortby['title']  = 'A-Z';
  $sortby['price']   = 'Low to High';
  $sortby['price-desc']   = 'High to Low';
  $sortby['popularity']   = 'Popularity';
  $sortby['rating'] = 'Rating';

  return $sortby;
}









 //add_action( 'pre_get_posts', 'wmp_order_by_discount' );




 // add_filter( 'posts_orderby', 'sort_query_by_post_in', 10, 2 );

  function sort_query_by_post_in( $sortby, $query ) {
    

if ($query->is_main_query() && $query->is_post_type_archive()) {


$args = array_merge( $query->query_vars, array( 'post_type' => 'product' ) );
  
$posts_array = query_posts( $args );

$discount_data = array();
foreach($posts_array as $pro){

  $regular_price = get_post_meta($pro->ID, '_regular_price', true);
  $sale_price = get_post_meta($pro->ID, '_sale_price', true);
  if($regular_price != '' && $sale_price != ''){
    $discount = ((int)$regular_price - (int)$sale_price);
  }else{
    $discount = 0;
  }
  $discount_data[$pro->ID] = $discount;
}

arsort($discount_data, SORT_NUMERIC);
$data = array_reverse($discount_data, true);

$product_ids = array_keys($discount_data);

//print_r($product_ids);


$orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
  if ( 'discount' == $orderby_value ) {
      //$sortby = "find_in_set(ID, '" . implode(',', $product_ids) . "')";
    $sortby = 'FIELD(ID, '.implode(',',$product_ids).')';
    }

    return $sortby;
  }
  }






  function wmp_modify_cart_button(){
     global $post;
    if(isset($_COOKIE['pincode'])){
     if(!check_if_seller_available($post->post_author, $_COOKIE['pincode'])){
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
      }else{
         add_action( 'woocommerce_single_product_summary', 'current_pincode_text', 30 );
      }
    }
  }
  add_action('template_redirect','wmp_modify_cart_button');


  add_action('woocommerce_single_product_summary','wmp_replace_add_to_cart',30);
  function wmp_replace_add_to_cart() {

    global $product;
    if(isset($_COOKIE['pincode'])){
     if(!check_if_seller_available($product->post->post_author, $_COOKIE['pincode'])){  
        
        echo 'This product cannot be shipped to your pincode - '.$_COOKIE['pincode'].' >>> <a id="change-pincode-list" data-product-id="'.$product->ID.'" data-seller-id="'.$product->post->post_author.'"><strong>Change pincode</strong></a>';
        
       }
    }
  }



  function current_pincode_text(){
    global $product;
    echo 'Your pincode is '.$_COOKIE['pincode'].' >>> <a id="change-pincode-list" data-product-id="'.$product->ID.'" data-seller-id="'.$product->post->post_author.'"><strong>Change pincode</strong></a>';
  }


//Disable plugin auto update
add_filter( 'auto_update_plugin', '__return_false' );

//Disable theme auto update
add_filter( 'auto_update_theme', '__return_false' );




 // add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart' );

function update_review_for_old_products(){
  global $wpdb;

  $select="select ID from ".$wpdb->prefix."posts where post_type='product'";
  $res=$wpdb->get_results($select,ARRAY_A);

  foreach ($res as $value) {
    $post_id=$value['ID'];
    update_post_meta( $post_id,'wpcr3_enable', 1 );
    update_post_meta( $post_id,'wpcr3_format', 'product' );
  }
  
}

// add_action( 'init', 'update_review_for_old_products' );


 // add_filter( 'posts_request', 'dump_request' );

function dump_request( $input ) {

    var_dump($input);

    return $input;
}



/**
 * Adds a woocommerce categories to menu.
 *
 * @param      <type>  $items  The items
 * @param      <type>  $menu   The menu 
 * @return     array     
 */
function   add_woocommerce_categories_to_menu( $items, $menu )  {


      $menu_name ="Primary Menu";
      $parent_object_id = 1756; 


      // If no menu found, just return the items without adding anything
      if ( $menu->name != $menu_name && $menu->slug != $menu_name ) {
          return $items;
      }



        // Find the menu item ID corresponding to the given post/page object ID
        // If no post/page found, the subitems won't have any parent (will be on 1st level)
        $parent_menu_item_id = 0;
        foreach ( $items as $item ) {
            if ( $parent_object_id == $item->object_id ) {
                $parent_menu_item_id = $item->ID;
                break;
            }
        }

        $menu_order = count( $items ) + 1;  

        $taxonomy     = 'product_cat';
        $orderby      = 'name';  
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no  
        $title        = '';  
        $empty        = 0;

        $cat_args = array(
               'taxonomy'     => $taxonomy,
               'orderby'      => $orderby,
               'order'        => 'ASC',
               'show_count'   => $show_count,
               'pad_counts'   => $pad_counts,
               'hierarchical' => $hierarchical,
               'title_li'     => $title,
               'hide_empty'   => $empty,
        );
       $all_categories = get_categories( $cat_args );
       foreach ($all_categories as $cat) {
          if($cat->category_parent == 0) {
              $category_id = $cat->term_id;       
              $cat_link =   get_term_link($cat->slug, 'product_cat') ;


           
              
              $new_submenu_item = array(
                  'text' => $cat->name,
                  'url'  => $cat_link
              );



            // Create objects containing all (and only) those properties from WP_Post 
            // used by WP to create a menu item
              $items[] = (object) array(
                'ID'                => $menu_order + 1000000000, // ID that WP won't use
                'title'             => $new_submenu_item['text'],
                'url'               => $new_submenu_item['url'],
                'menu_item_parent'  => $parent_menu_item_id,
                'menu_order'        => $menu_order,
                // These are not necessary, but PHP warning will be thrown if undefined
                'type'              => '',
                'object'            => '',
                'object_id'         => '',
                'db_id'             => '',
                'classes'           => '',
            );
            $menu_order++;




            }
        }
 
        

     /* echo "AJAJ AJENCY <pre> ";

      print_r($items);*/
        
        return $items;
    }



add_filter( 'wp_get_nav_menu_items','add_woocommerce_categories_to_menu' , 10, 2);