<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    if(is_woocommerce()){
        //wp_enqueue_script('pincode_popup', get_stylesheet_directory_uri() . '/js/pincode_popup.js', array('jquery'), '', true);
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
//add_filter('pre_get_posts', 'get_authored_products');

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
           
           foreach ($seller_ids as $seller_id)
               $sellers[] = (int)$seller_id;
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
//add_filter('get_terms', 'get_terms_posts_count_filter', 10, 3);
