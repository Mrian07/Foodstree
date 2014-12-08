<?php

//count product by seller_id
function count_seller_products( $seller_id ) {
global $wpdb;
$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $seller_id AND post_type IN ('product') and post_status = 'publish'" );
}



//Change default icon for 'Sellers' dashboard menu
function wmp_admin_head(){
?>
<style type="text/css">#adminmenu #toplevel_page_sellers div.wp-menu-image:before { content: "\f307"; }</style>
<?php
}   

add_action('admin_head', 'wmp_admin_head');




//Save additional data for seller
add_action( 'user_register', 'wmp_seller_additionaldata_save', 10, 1 );

function wmp_seller_additionaldata_save( $user_id ) {
  global $aj_csvimport;

  if ( isset( $_POST['seller_name'] ) ){
    update_user_meta($user_id, 'seller_name', $_POST['seller_name']);
  }

  if ( isset( $_POST['seller_address'] ) ){
    update_user_meta($user_id, 'seller_address', $_POST['seller_address']);
  }


  //if ( isset($_POST['seller_activate'])){
    update_user_meta($user_id, 'seller_activate', '1');
  //}else{
    //update_user_meta($user_id, 'seller_activate', '0');
  //}


    update_user_meta($user_id, 'activate', $_POST['activate']);
    
    //update sellers pin codes they sell to 
    if(isset($_FILES['seller_pincode_list']) && $aj_csvimport->is_valid_file($_FILES['seller_pincode_list'])){
            unset_user_pincodes($user_id);
            $csv_json = $aj_csvimport->parseCSV($_FILES['seller_pincode_list']['tmp_name']);
            
            $pincodeData = json_decode($csv_json);
            $i=1;
            while ($i <= count($pincodeData) ) {
                update_seller_to_pincode($user_id,$pincodeData[$i][0]);
                $i++;
            }
    }

  }

//Update additional data for seller
add_action( 'edit_user_profile_update', 'wmp_seller_additionaldata_save', 10, 1 );








//Removing seller listing from users table
function wmp_user_query($user_search) {
  $user = wp_get_current_user();
  
    global $wpdb;

    $user_search->query_where = 
        str_replace('WHERE 1=1', 
            "WHERE 1=1 AND {$wpdb->users}.ID IN (
                 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
                    WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
                    AND {$wpdb->usermeta}.meta_value NOT LIKE '%seller%')", 
            $user_search->query_where
        );
 
}
add_action('pre_user_query','wmp_user_query');






//Author dropdown to product page
add_action('init', 'wpse_74054_add_author_woocommerce', 999 );

function wpse_74054_add_author_woocommerce() {
    add_post_type_support( 'product', 'author' );
}





//Adding seller tab to single product page
add_filter( 'woocommerce_product_tabs', 'wmp_seller_product_tab' );
function wmp_seller_product_tab( $tabs ) {

//checking if product belongs to seller
global $post;
$role = get_user_role($post->post_author);
 
  if($role == 'seller'){

    $tabs['seller_tab'] = array(
        'title'     => __( 'Seller', 'woocommerce' ),
        'priority'  => 50,
        'callback'  => 'wmp_seller_tab_content'
    );
}
    return $tabs;
}

//Seller Tab Content
function wmp_seller_tab_content(){
  global $post;
  $seller_id = $post->post_author;
  $seller_name = get_user_meta( $seller_id, 'seller_name', true );
  echo '<div class="seller-name"><a href="'.get_site_url().'/seller/'.get_the_author().'">'.$seller_name.'</a></div>';
  }



//Get seller name by id
function get_seller_name($seller_id){
  $seller_name = get_user_meta( $seller_id, 'seller_name', true );
  if($seller_name){
    return $seller_name;
  }else{
    $user_info = get_userdata($seller_id);
    return $user_info->user_login;
  }
}


//Get seller id by login name - seller page
function get_query_id(){
if(get_query_var( 'seller' )){
$seller = get_userdatabylogin(get_query_var( 'seller' ));
return $seller->ID;
}
}


//Get products in array
function get_seller_product_ids($seller_id){
$args = array( 'author' => $seller_id, 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1 );
 $products = query_posts( $args );
 $id = array();
 if ( have_posts() ) : while ( have_posts() ) : the_post();
 $id[] = get_the_ID();
 endwhile; endif;
 return $id;
}



//list seller products
function seller_listing($seller_id){
  if(count(get_seller_product_ids($seller_id))>0){
    $ids = implode(',', get_seller_product_ids($seller_id));
    $seller_shortcode = '[products ids="'.$ids.'"]';
    return do_shortcode($seller_shortcode);
  }else{
    return '<div class="no-products">No products found</div>';
  }

}




//get user role
function get_user_role($uid) {
    global $wpdb;
$role = $wpdb->get_var("SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'wp_capabilities' AND user_id = {$uid}");
  if(!$role) return 'non-user';
$rarr = unserialize($role);
$roles = is_array($rarr) ? array_keys($rarr) : array('non-user');
return $roles[0];
}



//Display seller info after product title on single product page
function wmp_seller_info() {
  global $post;
  $seller_id = $post->post_author;
  $role = get_user_role($seller_id);
  if($role == 'seller'){
    $seller_name = get_user_meta( $seller_id, 'seller_name', true );
    echo '<div class="seller-name">Sold by: <a href="'.get_site_url().'/seller/'.get_the_author().'">'.$seller_name.'</a></div>';
  }
}
add_action( 'woocommerce_single_product_summary', 'wmp_seller_info', 6 );





//get seller rating
function wmp_get_seller_rating( $seller_id ) {
    global $wpdb;

    $sql = "SELECT AVG(cm.meta_value) as average, COUNT(wc.comment_ID) as count FROM $wpdb->posts p
        INNER JOIN $wpdb->comments wc ON p.ID = wc.comment_post_ID
        LEFT JOIN $wpdb->commentmeta cm ON cm.comment_id = wc.comment_ID
        WHERE p.post_author = %d AND p.post_type = 'product' AND p.post_status = 'publish'
        AND ( cm.meta_key = 'rating' OR cm.meta_key IS NULL) AND wc.comment_approved = 1
        ORDER BY wc.comment_post_ID";

    $result = $wpdb->get_row( $wpdb->prepare( $sql, $seller_id ) );

    return array( 'rating' => number_format( $result->average, 2), 'count' => (int) $result->count );
}



//get seller rating with html formatting
function wmp_get_readable_seller_rating( $seller_id ) {
    $rating = wmp_get_seller_rating( $seller_id );

    if ( ! $rating['count'] ) {
        echo __( 'No ratings found yet!', 'wmp' );
        return;
    }

    $long_text = _n( __( '%s rating from %d review', 'wmp' ), __( '%s rating from %d reviews', 'wmp' ), $rating['count'], 'wmp' );
    $text = sprintf( __( 'Rated %s out of %d', 'wmp' ), $rating['rating'], number_format( 5 ) );
    $width = ( $rating['rating']/5 ) * 100;
    ?>
        <span class="seller-rating">
            <span title="<?php echo esc_attr( $text ); ?>" class="star-rating" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
                <span class="width" style="width: <?php echo $width; ?>%"></span>
                <span style=""><strong itemprop="ratingValue"><?php echo $rating['rating']; ?></strong></span>
            </span>
        </span>

        <span class="text"><a href="#"><?php printf( $long_text, $rating['rating'], $rating['count'] ); ?></a></span>

    <?php
}

// function to hook into CSV plugin filter and configure csv upload components
function theme_add_csv_components($defined_csv_components){

    $defined_csv_components['pincodes'] = array('pincode',
                                                'Taluk',
                                                'statename');
    return $defined_csv_components;

}
add_filter('add_csv_components_filter','theme_add_csv_components',10,1);

// function to import a pincode record by hooking into the CSV plugin filter ajci_import_record_pincodes
function import_csv_pincode_record($import_response,$record){
 
    if(count($record) != 3){
       $import_response['imported'] = false;
       $import_response['reason'] = 'Column count does not match';
    }
    elseif(pincode_exists_db($record[0])){
       $import_response['imported'] = false;
       $import_response['reason'] = 'Pin code already exists';       
    }
    else{
       //insert pincode entry 
       add_pincode_db($record); 
       $import_response['imported'] = true;
    }
    
    return $import_response;
}
add_filter('ajci_import_record_pincodes','import_csv_pincode_record',10,2);

function pincode_exists_db($pincode){
    global $wpdb;

    $query = $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}pincodes WHERE pincode LIKE %s", $pincode );
    $record = $wpdb->get_var( $query );

    return is_numeric( $record );
}

function add_pincode_db($record){
    global $wpdb;
    $pincode_data = array('pincode'=>$record[0],'city'=>$record[1],'state'=>$record[2]);
    $wpdb->insert( $wpdb->prefix . "pincodes",
    $pincode_data );

    return $wpdb->insert_id;
}

function update_seller_to_pincode($user_id,$pincode){
    global $wpdb;

    $update_seller_ids = array();
    $query = $wpdb->prepare( "SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode LIKE %s", $pincode );
    $seller_ids = $wpdb->get_var( $query );
    if(is_null($seller_ids)){
        $update_seller_ids = array();
        $update_seller_ids[] = $user_id;
    }
    else{
        //var_dump($seller_ids);
        $update_seller_ids = maybe_unserialize($seller_ids);
        if(!in_array($user_id, $update_seller_ids)){
            $update_seller_ids[] = $user_id;
        }
    }
    
    if(!empty($update_seller_ids)){
        $wpdb->update( $wpdb->prefix . "pincodes",array('seller_id' => maybe_serialize($update_seller_ids)),array('pincode'=>$pincode) );
    }
}

function unset_user_pincodes($user_id){
    global $wpdb;
    
    $like_string = '%"'.$user_id.'";%';
    $query = $wpdb->prepare( "SELECT id,seller_id FROM {$wpdb->prefix}pincodes WHERE seller_id LIKE %s", $like_string );
    $seller_pincodes = $wpdb->get_results( $query );
    
    foreach($seller_pincodes as $pincode){
        $seller_ids = maybe_unserialize($pincode->seller_id);
        
        if (($key = array_search($user_id, $seller_ids)) !== FALSE) {
            unset($seller_ids[$key]);
        }
        
        $wpdb->update( $wpdb->prefix . "pincodes",array('seller_id' => maybe_serialize($seller_ids)),array('id'=>$pincode->id) );
    }
    
}