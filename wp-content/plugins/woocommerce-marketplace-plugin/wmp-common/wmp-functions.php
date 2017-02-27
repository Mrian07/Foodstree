<?php


//Override woocommerce template in plugin
function myplugin_plugin_path() {
  // gets the absolute path to this plugin directory
  return untrailingslashit( WMP_DIR );
}
add_filter( 'woocommerce_locate_template', 'myplugin_woocommerce_locate_template', 10, 3 );
function myplugin_woocommerce_locate_template( $template, $template_name, $template_path) {
  global$woocommerce;
  $_template= $template;
  if( ! $template_path) $template_path= $woocommerce->template_url;
  $plugin_path= myplugin_plugin_path() . '/frontend-templates/';
  // Look within passed path within the theme - this is priority
  $template= locate_template(
    array(
      $template_path. $template_name,
      $template_name
    )
  );
  // Modification: Get the template from this plugin, if it exists
  if( ! $template && file_exists( $plugin_path. $template_name) )
   $template= $plugin_path. $template_name;
   
  // Use default template
  if( ! $template)
    $template= $_template;
  // Return what we found
  return $template;
}





//count product by seller_id
function count_seller_products( $seller_id ) {
global $wpdb;
$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $seller_id AND post_type IN ('product') and post_status = 'publish'" );
return $count;
}



//count all products except deleted product of seller by id
function count_seller_all_products( $seller_id ) {
global $wpdb;
$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $seller_id AND post_type IN ('product') and post_status != 'trash'" );
return $count;
}



//Change default icon for 'Sellers' dashboard menu
function wmp_admin_head(){
?>
<style type="text/css">
#adminmenu #toplevel_page_sellers div.wp-menu-image:before { content: "\f307"; }
#adminmenu #menu-posts-shop_order div.wp-menu-image:before { content: "\f157"; }
#adminmenu #toplevel_page_seller-profile div.wp-menu-image:before { content: "\f110"; }
.form-table .error{ display:block; margin-top:2px; color:red; }
</style>
<?php
}   

add_action('admin_head', 'wmp_admin_head');




//Save additional data for seller
add_action( 'user_register', 'wmp_seller_additionaldata_save', 10, 1 );

//Update additional data for seller
add_action( 'edit_user_profile_update', 'wmp_seller_additionaldata_save', 10, 2 );

function wmp_seller_additionaldata_save( $user_id ) {
  global $aj_csvimport;

  $additional_fields = array(
    'seller_display_name',
    'first_name',
    'last_name',
    'seller_name',
    'mobile_number',
    'seller_address',
    'seller_city',
    'seller_pincode',
    'seller_state',
    'seller_country',
    'seller_billing_address',
    'seller_billing_city',
    'seller_billing_pincode',
    'seller_billing_state',
    'seller_billing_country',
    'seller_billing_yes',
    'seller_shipping_methods',
    'seller_pan',
    'seller_vat',
    'seller_rtgs',
    'seller_beneficiary',
    'seller_account_number',
    'seller_account_type',
    'seller_bank_name',
    'seller_branch_name',
    'seller_registration',
    'seller_tan',
    'seller_company_description',
    'seller_activate'
    );


  $uploads = array(
    'seller_logo',
    'seller_pan_copy',
    'seller_cancelled_cheque',
    'seller_tan_copy',
    'seller_registration_copy'
    );



  if ( isset( $_POST['pass1'] ) &&  !empty($_POST['pass1'])){
    if($_POST['pass1'] == $_POST['pass2']){
      //print_r($_POST['pass1']);
      wp_set_password( $_POST['pass1'], $user_id );
    }    
  }

  if ( isset( $_POST['email'] ) &&  !empty($_POST['email'])){
    wp_update_user( array( 'ID' => $user_id, 'user_email' => $_POST['email'] ) );
  }

  if ( !isset( $_POST['seller_activate'] )){
    update_user_meta($user_id, 'seller_activate', 0);
  }



  foreach($additional_fields as $field){
    if ( isset( $_POST[$field] ) ){
      update_user_meta($user_id, $field, maybe_serialize($_POST[$field]));
    }
  }



  foreach($uploads as $upload){


    if (!empty($_FILES[$upload]['name'])) {



      $file = $_FILES[$upload]['tmp_name'];
      $filename = $_FILES[$upload]['name'];

      $upload_file = wp_upload_bits($filename, null, file_get_contents($file));

      if (!$upload_file['error']) {

  /*$seller_directory_uri = wp_upload_dir('url').'/seller/' . $user_id;

  $seller_directory = WP_CONTENT_DIR . '/uploads/seller/' . $user_id;
  if (!file_exists($seller_directory)){
  wp_mkdir_p(WP_CONTENT_DIR . '/uploads/seller/' . $user_id);
}*/


$wp_upload_dir = wp_upload_dir();
$wp_filetype = wp_check_filetype($filename, null );
$attachment = array(
  'guid'           => $wp_upload_dir['url'] . '/' . $filename,
    //'guid'           => $seller_directory_uri . '/' . $filename,
  'post_mime_type' => $wp_filetype['type'],
  'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
  'post_content' => '',
  'post_author' => get_current_user_id(),
  'post_status' => 'inherit'
  );
$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );


$imgExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES[$upload]['name']);
$extension = end($temp);
if(in_array($extension, $imgExts)){

  if (!is_wp_error($attachment_id)) {
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
    wp_update_attachment_metadata( $attachment_id,  $attachment_data );
  }


}



update_user_meta($user_id, $upload, $attachment_id);
}



}






}



    if(get_user_role(get_current_user_id()) == 'seller'){
     $subject = 'A seller details has been updated';
     $message = "Following seller details has been updated on your website:\n\n";
     $message .= 'Display Name: '.get_user_meta($user_id, 'seller_display_name', true).'<br />';
     $message .= 'Seller Name: '.get_user_meta($user_id, 'seller_name', true).'<br />';
     $message .= 'Mobile Number: '.get_user_meta($user_id, 'mobile_number', true).'<br />';
     $message .= 'Seller Address: '.get_user_meta($user_id, 'seller_address', true).'<br />';
     $message .= 'Seller City: '.get_user_meta($user_id, 'seller_city', true).'<br />';
     $message .= 'Seller Pincode: '.get_user_meta($user_id, 'seller_pincode', true).'<br />';
     $message .= 'Seller State: '.get_user_meta($user_id, 'seller_state', true).'<br />';
     $message .= 'Seller Country: '.get_user_meta($user_id, 'seller_country', true).'<br />';
     $message .= 'Seller Billing Address: '.get_user_meta($user_id, 'seller_billing_address', true).'<br />';
     $message .= 'Seller Billing City: '.get_user_meta($user_id, 'seller_billing_city', true).'<br />';
     $message .= 'Seller Billing Pincode: '.get_user_meta($user_id, 'seller_billing_pincode', true).'<br />';
     $message .= 'Seller Billing State: '.get_user_meta($user_id, 'seller_billing_state', true).'<br />';
     $message .= 'Seller Billing Country: '.get_user_meta($user_id, 'seller_billing_country', true).'<br />';
     $message .= 'PAN: '.get_user_meta($user_id, 'seller_pan', true).'<br />';
     $message .= 'VAT: '.get_user_meta($user_id, 'seller_vat', true).'<br />';
     $message .= 'RTGS: '.get_user_meta($user_id, 'seller_rtgs', true).'<br />';
     $message .= 'Beneficiary: '.get_user_meta($user_id, 'seller_beneficiary', true).'<br />';
     $message .= 'Account Number: '.get_user_meta($user_id, 'seller_account_number', true).'<br />';
     $message .= 'Account Type: '.get_user_meta($user_id, 'seller_account_type', true).'<br />';
     $message .= 'Bank Name: '.get_user_meta($user_id, 'seller_bank_name', true).'<br />';
     $message .= 'Branch Name: '.get_user_meta($user_id, 'seller_branch_name', true).'<br />';
     $message .= 'Registration No.: '.get_user_meta($user_id, 'seller_registration', true).'<br />';
     $message .= 'TAN: '.get_user_meta($user_id, 'seller_tan', true).'<br />';
     $message .= 'Updated from (IP): '.wmp_get_client_ip().'<br />';
     $message .= 'Updated on: '.current_time( 'mysql' ).'<br />';

     if(!$mailsent){
     wp_mail( get_option( 'admin_email' ), $subject, $message );
     $mailsent = true;
    }
     
   }





}







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





// Add seller coloumn in products page
add_filter('manage_product_posts_columns', 'wmp_columns_head_only_sellers', 10);
add_action('manage_product_posts_custom_column', 'wmp_columns_content_only_sellers', 10, 2);
 
function wmp_columns_head_only_sellers($defaults) {
    $defaults['seller_name'] = 'Seller';
    return $defaults;
}
function wmp_columns_content_only_sellers($column_name, $post_ID) {
    if ($column_name == 'seller_name') {
        $post_tmp = get_post($post_ID);
        $seller_id = $post_tmp->post_author;
        echo get_seller_name($seller_id);
    }
}





function wmp_get_suborders($orderid){
  $args = array(
  'post_parent' => $orderid,
  'post_type'   => 'shop_order', 
  'posts_per_page' => -1,
  'post_status' => 'any' );

$suborders = get_children( $args, OBJECT );

return $suborders;
}





//Add seller box in product add/edit page
function seller_meta_box() {

  $screens = array( 'product' );

  foreach ( $screens as $screen ) {

    add_meta_box(
      'product_seller',
      __( 'Seller', '' ),
      'seller_meta_box_callback',
      $screen,'side','high'
    );
  }
}


if( current_user_can('administrator') ) {
  add_action( 'add_meta_boxes', 'seller_meta_box' );
}



function seller_meta_box_callback( $post ) {

    $default_seller_id = DEFAULT_SELLER_ID;
      $users = get_users('who=seller');

    $output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";

    //Leave the admin in the list
    //$output .= '<option value="'.$default_seller_id.'">'.get_seller_name($default_seller_id).'</option>';  

    $seller_list = get_all_seller();

    foreach($seller_list as $key=>$value)
    {
        

        global $current_screen;
        if( $current_screen->post_type =='product' && $current_screen->action == 'add'){
            $sel = ($default_seller_id == $value)?"selected='selected'":'';
}else{
    $sel = ($post->post_author == $value)?"selected='selected'":'';
}


 

         $output .= '<option value="'.$value.'"'.$sel.'>'.get_seller_name($value).'</option>';
     }
    $output .= "</select>";
    echo $output;
}


//get all seller id
function get_all_seller(){
global $wpdb;
$seller = $wpdb->get_col("SELECT user_id FROM $wpdb->usermeta WHERE $wpdb->usermeta.meta_key = 'seller_name' ORDER BY $wpdb->usermeta.meta_value ASC");
return $seller;
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
  //$seller_name = get_user_meta( $seller_id, 'seller_name', true );
  $seller_name = get_seller_display_name($seller_id);
  $seller_var = get_seller_query_var($seller_id);
  echo '<div class="seller-name"><a href="'.get_site_url().'/seller/'.$seller_var.'">'.$seller_name.'</a></div>';
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




//Get seller name by id
function get_seller_display_name($seller_id){
  $seller_name = get_user_meta( $seller_id, 'seller_display_name', true );
  $seller_name2 = get_user_meta( $seller_id, 'seller_name', true );
  if($seller_name){
    return $seller_name;
  }else if($seller_name2){
    return $seller_name2;
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





function get_userid_by_company($company_name){
global $wpdb;
$company = urldecode($company_name);
$results = $wpdb->get_col("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'seller_name' AND meta_value = '".$company."' ");
return $results[0];
}



function get_seller_query_var($seller_id){
   $seller_query_var = urlencode(get_seller_name($seller_id));
   return $seller_query_var;
}




//Get products list in array by seller id
function get_seller_product_ids($seller_id){
$args = array( 'author' => $seller_id, 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1 );
 $products = query_posts( $args );
 $id = array();
 if ( have_posts() ) : while ( have_posts() ) : the_post();
 $id[] = get_the_ID();
 endwhile; endif;
 return $id;
}






/*function wmp_seller_new_order_email_recipient( $recipient, $order ) {
    global $woocommerce;
    if ( check_user_role( 'customer' ) ) {
        $recipient = "accounts@yourdomain.com";
    } else {
        $recipient = "newbusiness@yourdomain.com";
    }
    return $recipient;
}
add_filter('woocommerce_email_recipient_new_order', 'wmp_seller_new_order_email_recipient', 1, 2);
*/





//output seller products by seller id
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
if ( is_multisite() ) { 
$role = $wpdb->get_var("SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'wp_".get_current_blog_id()."_capabilities' AND user_id = {$uid}");
}else{
  $role = $wpdb->get_var("SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'wp_capabilities' AND user_id = {$uid}");
}
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
    //$seller_name = get_user_meta( $seller_id, 'seller_name', true );
    $seller_name = get_seller_display_name($seller_id);
     $seller_var = get_seller_query_var($seller_id);
    echo '<div class="seller-name">Sold by: <a href="'.get_site_url().'/seller/'.$seller_var.'">'.$seller_name.'</a></div>';
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

//hook into CSV plugin filter and configure csv upload components
function theme_add_csv_components($defined_csv_components){

    $defined_csv_components['pincodes'] = array('pincode',
                                                'Taluk',
                                                'statename');
    
    $defined_csv_components['seller_pincodes'] = array('Postal Code',
                                                        'City Name',
                                                        'State',
                                                        'Domestic Service',
                                                        'International Services',
                                                        'ODA-OPA / Regular Classification (Dom +Intl)',
                                                        'COD Serviceable (Domestic Only)',
                                                        'Shipping rate');
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

//check if pincode exists in db
function pincode_exists_db($pincode){
    global $wpdb;

    $query = $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}pincodes WHERE pincode LIKE %s", $pincode );
    $record = $wpdb->get_var( $query );

    return is_numeric( $record );
}

//add pincode to the custom pincodes table
function add_pincode_db($record){
    global $wpdb;
    $pincode_data = array('pincode'=>$record[0],'city'=>$record[1],'state'=>$record[2]);
    $wpdb->insert( $wpdb->prefix . "pincodes",
    $pincode_data );

    return $wpdb->insert_id;
}

// update a seller id to a pincode
function update_seller_to_pincode($user_id,$record){
    global $wpdb;

    $flag = 0;
    $update_seller_ids = array();
    $query = $wpdb->prepare( "SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode LIKE %s", $record[0] );
    $seller_ids = $wpdb->get_var( $query );
    if(is_null($seller_ids)){
        $sellers_data = array();
        $temparray =  array('user_id' => (string) $user_id,'cod'=> (bool) $record[6],'shipping'=> (int) $record[7]);
        array_push($sellers_data, $temparray);
        $flag = 1;
    }
    else{
        $sellers_data = maybe_unserialize($seller_ids);
        foreach($sellers_data as $seller_data){
            $update_seller_ids[] = $seller_data['user_id'];
        }
        
        if(!in_array($record[0], $update_seller_ids)){
            $temparray = array('user_id' => (string) $user_id,'cod'=> (bool) $record[6],'shipping'=> (int) $record[7]);
            $flag = 1;
            array_push($sellers_data, $temparray);
        }
    }
    
    // update only if seller was not associated to pincode
    if($flag == 1){
        $wpdb->update( $wpdb->prefix . "pincodes",array('seller_id' => maybe_serialize($sellers_data)),array('pincode'=>$record[0]) );
    }
}

function unset_seller_pincodes($user_id){
    global $wpdb;
    
    $like_string = '%"'.$user_id.'";%';
    $query = $wpdb->prepare( "SELECT id,seller_id FROM {$wpdb->prefix}pincodes WHERE seller_id LIKE %s", $like_string );
    $seller_pincodes = $wpdb->get_results( $query );
    
    foreach($seller_pincodes as $pincode){
        $seller_ids = array();
        $sellers_data = maybe_unserialize($pincode->seller_id);
        foreach($sellers_data as $key => $seller_data){
            $seller_ids[$key] = $seller_data['user_id'];
        }
        if (($key = array_search($user_id, $seller_ids)) !== FALSE) {
            unset($sellers_data[$key]);
        }
        
        $wpdb->update( $wpdb->prefix . "pincodes",array('seller_id' => maybe_serialize($sellers_data)),array('id'=>$pincode->id) );
    }
    
}


// seller pincodes csv file upload function 
function pincode_csv_upload(){
    global $aj_csvimport;
    $parse_valid_csv = $aj_csvimport->csv_validate();
    if($parse_valid_csv['success']){
        $preview_data = ajci_display_csv_preview($_POST['csv_component'],$parse_valid_csv);
        wp_send_json($preview_data);
    }else{
       $response = $parse_valid_csv['msg'];
       wp_send_json($response);
    }
}
add_action("wp_ajax_pincode_csv_upload", "pincode_csv_upload");

function pincode_csv_upload_confirm(){
    global $aj_csvimport;
    
    $uniquefilename = $_POST['uniquename'];
    $realfilename = $_POST['realname'];
    $component = $_POST['csv_component'];       
    $meta = array();
    $meta['header'] = (isset($_POST['csv_header']))? true:false ;
    $meta['user_id'] = (int) $_POST['user_id']; 
    $id = $aj_csvimport->init_csv_data($uniquefilename,$realfilename,$component,$meta);
    if(!is_wp_error($id)){
        $response = array('csv_id'=>$id);
        
        wp_send_json($response);
    }
    else{
        wp_send_json($id);
    }
    
}
add_action("wp_ajax_pincode_csv_upload_confirm", "pincode_csv_upload_confirm");

// function to add a pincode to a seller by hooking into the CSV plugin filter ajci_import_record_seller_pincodes
function import_csv_seller_pincode_record($import_response,$record,$csv_master_info){
 
    if(count($record) != 8){
       $import_response['imported'] = false;
       $import_response['reason'] = 'Column count does not match';
    }
    else{
        $metadata = maybe_unserialize($csv_master_info->meta);
       //add a seller to a pincode $record[0]
       update_seller_to_pincode($metadata['user_id'],$record);
       $import_response['imported'] = true;
    }
    
    return $import_response;
}
add_filter('ajci_import_record_seller_pincodes','import_csv_seller_pincode_record',10,3);


//ajax method to reset a seller pincodes
function ajax_reset_seller_pincodes(){
    if(isset($_POST['user_id']) && intval($_POST['user_id']) > 0){
        unset_seller_pincodes($_POST['user_id']);
        $response= array('code'=>'OK','msg'=>'Pincodes reseted for seller');
        wp_send_json($response);
    }else{
        $response= array('code'=>'ERROR','msg'=>'Invalid user id');
        wp_send_json($response);
    }
}
add_action("wp_ajax_reset_seller_pincodes", "ajax_reset_seller_pincodes");

//ajax method to get a seller information for a pincode
function ajax_get_seller_pincode_info(){
    global $wpdb;
    
    $pincode = $_POST['pincode'];
    $user_id = $_POST['user_id'];
    $query = $wpdb->prepare( "SELECT seller_id FROM {$wpdb->prefix}pincodes WHERE pincode LIKE %s", $pincode );
    $sellers_info = $wpdb->get_var( $query );  
    if(is_null($sellers_info)){
        $response = array('code'=>'OK','msg'=>'Pincode not assigned to seller');
    }else{
        $sellers_info = maybe_unserialize($sellers_info);
        $found = 0;
        foreach ($sellers_info as  $seller_info){
            if((int)$seller_info['user_id'] != $user_id){
                continue;
            }else{
                $cod = ($seller_info['cod'])? 'available' : 'not available';
                $shipping = ($seller_info['shipping'])? $seller_info['shipping'] : 'not available';
                $msg = 'Pincode is assigned to seller , COD: '.$cod.', Custom shipping rate : '.$shipping;
                $response = array('code'=>'OK','msg'=>$msg);
                $found = 1;
                break;
            }
        }
        
        if($found == 0)
            $response = array('code'=>'OK','msg'=>'Pincode not assigned to seller');
    }
    
    
    wp_send_json($response);
    
}
add_action("wp_ajax_get_seller_pincode_info", "ajax_get_seller_pincode_info");









function wmp_get_client_ip()
 {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';

      return $ipaddress;
 }










 function wmp_product_update_notification( $post_id ) {

  $post = get_post($post_id);

  $author_id=$post->post_author;

  $post_type = $post->post_type;

      // If this is just a revision, don't send the email.
  if ( wp_is_post_revision( $post_id ) ) {
    return;
  }

//return if new post
  if( $post->post_modified_gmt == $post->post_date_gmt ){
        return;
    }

  if($post_type == 'product' && !is_super_admin( get_current_user_id() )){
    $post_title = get_the_title( $post_id );
    $post_url = get_permalink( $post_id );
    $manage_stock = get_post_meta($post_id, '_manage_stock', true);
    $stock = get_post_meta($post_id, '_stock', true);
    $last_modified = $post->post_modified;
    $sku = get_post_meta($post_id, '_sku', true);

    $subject = 'A product has been updated';

    $message = "Following product has been updated on your website:\n\n";
    $message .= 'Product: '.$post_title.'<br />';
    $message .= 'SKU: '.$sku.'<br />';
    $message .= 'Product URL: '.$post_url.'<br />';
    if($manage_stock == 'yes'){
      $message .= 'Product Stock: '.(int)$stock.'<br />';
    }
    $message .= 'Seller: '.get_seller_name($author_id).'<br />';
    $message .= 'IP: '.wmp_get_client_ip().'<br />';
    $message .= 'Modified: '.$last_modified.'<br />';

    // Send email to admin.
    wp_mail( get_option( 'admin_email' ), $subject, $message );
  }


}
add_action( 'save_post', 'wmp_product_update_notification' ); 

