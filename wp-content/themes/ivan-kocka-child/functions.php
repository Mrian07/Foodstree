<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    if(is_woocommerce()){
        wp_enqueue_script('pincode_popup', get_stylesheet_directory_uri() . '/js/pincode_popup.js', array('jquery'), '', true);
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
add_filter('pre_get_posts', 'get_authored_products');

// get seller ids based on pincode value saved in the cookie
function get_pincode_sellers(){
    global $wpdb;
    
    $sellers = array();
    if(isset($_COOKIE['user_pincode'])){
       $sellers_data = $wpdb->get_var( $wpdb->prepare("SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode like %s ",$_COOKIE['user_pincode'] ));
       $sellers_data = maybe_unserialize($sellers_data);
       
       if(empty($sellers_data)){
           // NOT to fetch products if the pincode has no sellers
           $sellers[] = 0;
       }else{
           foreach ($sellers_data as $seller)
               $sellers[] = (int)$seller['user_id'];
       }
        
    }else{
        // NOT to fetch products if the user_pincode is not set
        $sellers[] = 0;
    }
    return $sellers;
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
add_filter('get_terms', 'get_terms_posts_count_filter', 10, 3);

//disable cod if sellers of cart products has no cod for the pincode
function disable_cod_pincode_not_serviceable( $available_gateways ) {
    global $woocommerce;
    
    $seller_ids = array();
    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
           $data = $values['data'];
           $post_data = $data->post;
           $seller_ids[] = (int)$post_data->post_author;
    }
    
    $seller_ids = array_unique($seller_ids);
    
    if(! is_cod_serviceable($seller_ids)){
    
        unset(  $available_gateways['cod'] );
    }
    
    return $available_gateways;

}
add_filter('woocommerce_available_payment_gateways','disable_cod_pincode_not_serviceable',10,1); 

//check if sellers have COD on for the pincode
function is_cod_serviceable($seller_ids){
    global $wpdb;
    
    if(isset($_COOKIE['user_pincode'])){
       $sellers_data = $wpdb->get_var( $wpdb->prepare("SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode like %s ",$_COOKIE['user_pincode'] ));
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