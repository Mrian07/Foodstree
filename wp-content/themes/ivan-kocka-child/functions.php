<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    if(is_woocommerce()){
       wp_enqueue_script('pincode_popup', get_stylesheet_directory_uri() . '/js/pincode_popup.js', array('jquery'), '', true);
       wp_localize_script( 'pincode_popup', 'pincode_data', array('ajax_url'=>admin_url('admin-ajax.php'), 'theme_url'=>get_stylesheet_directory_uri()) );
    }
}


function get_authored_products($query) {
    
    //check if post type is product or page is woocommerce template and not admin dashboard interface
    if(($query->query_vars['post_type'] == 'product' || is_woocommerce()) && !is_admin()){
        $authors = get_pincode_sellers();
        $query->set('author__in',  $authors);
    }
    
    return $query;
}

if($_SESSION['all_sellers'] !='yes'){
add_filter('pre_get_posts', 'get_authored_products');
}

// get seller ids based on pincode value saved in the cookie
function get_pincode_sellers(){
    global $wpdb;
    
    $sellers = array();
    if(isset($_COOKIE['user_pincode'])){
       $seller_ids = $wpdb->get_var( $wpdb->prepare("SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode like %s ",$_COOKIE['user_pincode'] ));
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


if($_SESSION['all_sellers'] !='yes'){
add_filter('get_terms', 'get_terms_posts_count_filter', 10, 3);
}



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
add_action('wp_ajax_nopriv_allseller', 'set_product_listing_session');
add_action( 'wp_ajax_allseller', 'set_product_listing_session' );

function set_product_listing_session() {

$key = $_POST['setseller'];
session_start();

$_SESSION['all_sellers'] = $key;

echo $_SESSION['all_sellers'];
die();
}





add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
  global $woocommerce;

if(isset($_POST['billing_postcode'])){
  if ( !is_numeric($_POST['billing_postcode']) || strlen($_POST['billing_postcode']) > 6 || strlen($_POST['billing_postcode']) < 6){
    $woocommerce->add_error( __('Please enter 6 digit number for postcode') );
  }
}

if(isset($_POST['shipping_postcode'])){
  if ( !is_numeric($_POST['shipping_postcode']) || strlen($_POST['shipping_postcode']) > 6 || strlen($_POST['shipping_postcode']) < 6){
    $woocommerce->add_error( __('Please enter 6 digit number for postcode') );
  }
}

if(isset($_POST['billing_phone'])){
  if ( strlen($_POST['billing_phone']) > 10 || strlen($_POST['billing_phone']) < 10){
    $woocommerce->add_error( __('Please enter 10 digit number for phone') );
  }
}

}











