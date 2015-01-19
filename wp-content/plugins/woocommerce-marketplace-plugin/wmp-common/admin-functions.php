<?php

/**
 * Filter all the shop orders to remove child orders
 *
 * @param WP_Query $query
 */
function wmp_admin_shop_order_remove_parents( $query ) {
    if ( $query->is_main_query() && $query->query['post_type'] == 'shop_order' ) {
        $query->set( 'orderby', 'ID' );
        $query->set( 'order', 'DESC' );
    }
}

add_action( 'pre_get_posts', 'wmp_admin_shop_order_remove_parents' );

/**
 * Remove child orders from WC reports
 *
 * @param array $query
 * @return array
 */
function wmp_admin_order_reports_remove_parents( $query ) {

    $query['where'] .= ' AND posts.post_parent = 0';

    return $query;
}

add_filter( 'woocommerce_reports_get_order_report_query', 'wmp_admin_order_reports_remove_parents' );

/**
 * Change the columns shown in admin.
 * 
 * @param array $existing_columns
 * @return array
 */
function wmp_admin_shop_order_edit_columns( $existing_columns ) {
    $current_role = get_user_role(get_current_user_id());

    $columns = array();

    $columns['cb']               = '<input type="checkbox" />';
    $columns['order_status']     = '<span class="status_head tips" data-tip="' . esc_attr__( 'Status', 'wmp' ) . '">' . esc_attr__( 'Status', 'wmp' ) . '</span>';
    $columns['order_title']      = __( 'Order', 'wmp' );
    $columns['order_items']      = __( 'Purchased', 'wmp' );
    $columns['shipping_address'] = __( 'Ship to', 'wmp' );

    //$columns['customer_message'] = '<span class="notes_head tips" data-tip="' . esc_attr__( 'Customer Message', 'wmp' ) . '">' . esc_attr__( 'Customer Message', 'wmp' ) . '</span>';
    //$columns['order_notes']      = '<span class="order-notes_head tips" data-tip="' . esc_attr__( 'Order Notes', 'wmp' ) . '">' . esc_attr__( 'Order Notes', 'wmp' ) . '</span>';
    $columns['order_date']       = __( 'Date', 'wmp' );
    $columns['order_total']      = __( 'Total', 'wmp' );
    $columns['order_actions']    = __( 'Actions', 'wmp' );

    if($current_role != 'seller'){
    $columns['seller']        = __( 'Seller', 'wmp' );
    $columns['suborder']        = __( 'Sub Order', 'wmp' );
    }

    return $columns;
}

add_filter( 'manage_edit-shop_order_columns', 'wmp_admin_shop_order_edit_columns', 11 );

/**
 *
 * @global type $post
 * @global type $woocommerce
 * @global WC_Order $the_order
 * @param type $col
 */
function wmp_shop_order_custom_columns( $col ) {
    global $post, $woocommerce, $the_order;

    if ( empty( $the_order ) || $the_order->id != $post->ID ) {
        $the_order = new WC_Order( $post->ID );
    }

    switch ($col) {
        case 'order_title':
            if ($post->post_parent !== 0) {
                echo '<strong>';
                echo __( 'Sub Order of', 'wmp' );
                printf( ' <a href="%s">#%s</a>', admin_url( 'post.php?action=edit&post=' . $post->post_parent ), $post->post_parent );
                echo '</strong>';
            }
            break;

        case 'suborder':
            $has_sub = get_post_meta( $post->ID, 'has_sub_order', true );

            if ( $has_sub == '1' ) {
                printf( '<a href="#" class="show-sub-orders" data-class="parent-%1$d" data-show="%2$s" data-hide="%3$s">%2$s</a>', $post->ID, __( 'Show Sub-Orders', 'wmp' ), __( 'Hide Sub-Orders', 'wmp' ));
            }
            break;

        case 'seller':
            $has_sub = get_post_meta( $post->ID, 'has_sub_order', true );

            if ( $has_sub != '1' ) {
                $seller = get_user_by( 'id', $post->post_author );
                printf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=edit-seller&action=edit&seller=' . $seller->ID ), get_seller_name($post->post_author) );
            }

            break;
    }
}

add_action( 'manage_shop_order_posts_custom_column', 'wmp_shop_order_custom_columns', 11 );

/**
 * Adds css classes on admin shop order table
 *
 * @global WP_Post $post
 * @param array $classes
 * @param int $post_id
 * @return array
 */
function wmp_admin_shop_order_row_classes( $classes, $post_id ) {
    global $post;


if(isset($_GET['all_posts']) && $_GET['all_posts']=='1'){
    
    if ( $post->post_type == 'shop_order' && $post->post_parent != 0 ) {
        $classes[] = 'sub-order parent-' . $post->post_parent;
    }

}

    return $classes;
}

add_filter( 'post_class', 'wmp_admin_shop_order_row_classes', 10, 2);

/**
 * Show/hide sub order css/js
 *
 * @return void
 */
function wmp_admin_shop_order_scripts() {

    $current_role = get_user_role(get_current_user_id());
    ?>
    <script type="text/javascript">
    jQuery(function($) {
        $('tr.sub-order').hide();

        $('a.show-sub-orders').on('click', function(e) {
            e.preventDefault();

            var $self = $(this),
                el = $('tr.' + $self.data('class') );

            if ( el.is(':hidden') ) {
                el.show();
                $self.text( $self.data('hide') );
            } else {
                el.hide();
                $self.text( $self.data('show') );
            }
        });


       <?php if(!(isset($_GET['all_posts'])) && $_GET['all_posts']!='1'){ ?>
        $('.post-type-shop_order tr.author-self').hide();
        <?php } ?>



<?php if($current_role == 'seller'){ ?>

    $('.post-type-shop_order ul.subsubsub').html('<?php echo wmp_generate_order_status_count(); ?>');

    $('.post-type-shop_order tr.sub-order').toggle();

<?php if(!wmp_is_seller_has_orders( get_current_user_id() )){ ?>

<?php } ?>


<?php }else{ ?>

$('.post-type-shop_order ul.subsubsub').html('<?php echo wmp_generate_order_status_admin_count(); ?>');

$('button.toggle-sub-orders').on('click', function(e) {
            e.preventDefault();

            $('tr.sub-order').toggle();
        });
<?php } ?>

        


    });
    </script>

    <style type="text/css">
        tr.sub-order {
            background: #ECFFF2;
        }
    </style>
    <?php
}



function wmp_is_seller(){
   if(get_user_role(get_current_user_id()) == 'seller' ){
    return true;
   }else{
    return false;
   } 
}




function wmp_seller_product_listing_scripts() {
    $current_role = get_user_role(get_current_user_id());
    ?>
    <script type="text/javascript">
    jQuery(function($) {
        <?php if($current_role == 'seller'){ ?>
                 
          $('.post-type-product ul.subsubsub').html('<?php echo wmp_generate_product_status_count(); ?>');
           
            <?php if(count_seller_all_products( get_current_user_id() ) <=0 ){ ?>
                
                <?php } ?>


                <?php } ?>

            });
    </script> <?php
}







add_action( 'admin_footer-edit.php', 'wmp_admin_shop_order_scripts' );

add_action( 'admin_footer-edit.php', 'wmp_seller_product_listing_scripts' );

/**
 * Delete sub orders when parent order is trashed
 *
 * @param int $post_id
 */
function wmp_admin_on_trash_order( $post_id ) {
    $post = get_post( $post_id );

    if ( $post->post_type == 'shop_order' && $post->post_parent == 0 ) {
        $sub_orders = get_children( array( 'post_parent' => $post_id, 'post_type' => 'shop_order' ) );

        if ( $sub_orders ) {
            foreach ($sub_orders as $order_post) {
                wp_trash_post( $order_post->ID );
            }
        }
    }
}

add_action( 'wp_trash_post', 'wmp_admin_on_trash_order' );

/**
 * Untrash sub orders when parent orders are untrashed
 *
 * @param int $post_id
 */
function wmp_admin_on_untrash_order( $post_id ) {
    $post = get_post( $post_id );

    if ( $post->post_type == 'shop_order' && $post->post_parent == 0 ) {
        $sub_orders = get_children( array( 'post_parent' => $post_id, 'post_type' => 'shop_order' ) );

        if ( $sub_orders ) {
            foreach ($sub_orders as $order_post) {
                wp_untrash_post( $order_post->ID );
            }
        }
    }
}

add_action( 'wp_untrash_post', 'wmp_admin_on_untrash_order' );


/**
  *
 * @param int $post_id
 */
function wmp_admin_on_delete_order( $post_id ) {
    $post = get_post( $post_id );

    if ( $post->post_type == 'shop_order' ) {
        wmp_delete_sync_order( $post_id );

        $sub_orders = get_children( array( 'post_parent' => $post_id, 'post_type' => 'shop_order' ) );

        if ( $sub_orders ) {
            foreach ($sub_orders as $order_post) {
                wp_delete_post( $order_post->ID );
            }
        }
    }
}

add_action( 'delete_post', 'wmp_admin_on_delete_order' );

/**
 * Show a toggle button to toggle all the sub orders
 *
 * @global WP_Query $wp_query
 */
function wmp_admin_shop_order_toggle_sub_orders() {
    global $wp_query;

    if ( isset( $wp_query->query['post_type'] ) && $wp_query->query['post_type'] == 'shop_order' ) {


if(get_user_role(get_current_user_id()) != 'seller'){
        echo '<button class="toggle-sub-orders button">' . __( 'Toggle Sub-orders', 'wmp' ) . '</button>';
}

    }
}

add_action( 'restrict_manage_posts', 'wmp_admin_shop_order_toggle_sub_orders');




/**
 * Send notification to the seller once a product is published from pending
 * 
 * @param WP_Post $post
 * @return void
 */
function wmp_send_notification_on_product_publish( $post ) {
    if ( $post->post_type != 'product' ) {
        return;
    }

    $seller = get_user_by( 'id', $post->post_author );
    
}

add_action( 'pending_to_publish', 'wmp_send_notification_on_product_publish' );








function wmp_seller_profile_menu() {
    add_menu_page( 'Profile', 'Profile', 'read', 'seller-profile', 'wmp_create_seller_profile' );
}

function wmp_create_seller_profile() {
    include(WMP_DIR.'admin-templates/seller-profile.php');
}

function seller_login_redirect($redirect_to, $request, $user) {
$redirect_url = admin_url( 'edit.php?post_type=product' );
 if(get_user_role($user->ID) == 'seller'){
return $redirect_url;
}else{
  return admin_url('index.php');
}

}



//Remove additional menu items for seller dashboard
function remove_additional_menu(){
  remove_menu_page( 'profile.php' );
  remove_menu_page( 'upload.php' );
  remove_menu_page( 'index.php' );
  remove_menu_page( 'plugins.php' );
  //remove_menu_page( 'post-new.php?post_type=shop_order' );      
}



if(wmp_is_seller()){
add_action('admin_menu', 'wmp_seller_profile_menu' );
add_action( 'admin_menu', 'remove_additional_menu' );
}

add_filter("login_redirect", "seller_login_redirect", 10, 3);





function wmp_seller_order_query($query){

 global $pagenow;
 
 global $current_user;

 if($query->query_vars['post_type'] == 'shop_order' && wmp_is_seller()){
       
    $query->set('author', $current_user->ID); 
}

return $query;
}

add_action( 'pre_get_posts', 'wmp_seller_order_query' );




function wmp_seller_product_query($query){

 global $pagenow;
 
 global $current_user;

 if($query->query_vars['post_type'] == 'product' && wmp_is_seller()){
       
    $query->set('author', $current_user->ID); 
}

return $query;
}

add_action( 'pre_get_posts', 'wmp_seller_product_query' );



function wmp_generate_product_status_count(){
     global $current_user;
     global $wpdb;

    $post_author = $current_user->ID;
    $count_all = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('product')" );
    $count_published = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('product') and post_status = 'publish'" );
    $count_pending = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('product') and post_status = 'pending'" );
    $count_trash = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('product') and post_status = 'trash'" );

    $list = '<li class="all"><a href="edit.php?post_type=product&amp;all_posts=1">All <span class="count">('.$count_all.')</span></a> |</li>';
    $list .= '<li class="publish"><a href="edit.php?post_status=publish&amp;post_type=product">Published <span class="count">('.$count_published.')</span></a> |</li>';
    $list .= '<li class="pending"><a href="edit.php?post_status=pending&amp;post_type=product">Pending <span class="count">('.$count_pending.')</span></a> |</li>';
    $list .= '<li class="trash"><a href="edit.php?post_status=trash&amp;post_type=product">Trash <span class="count">('.$count_trash.')</span></a></li>';
    echo $list;
}

function wmp_generate_order_status_count(){
     global $current_user;
     global $wpdb;

    $post_author = $current_user->ID;
    $count_all = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('shop_order') and post_status != 'auto-draft'" );
    $count_processing = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('shop_order') and post_status = 'wc-processing'" );
    $count_on_hold = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('shop_order') and post_status = 'wc-on-hold'" );
    $count_completed = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $post_author AND post_type IN ('shop_order') and post_status = 'wc-completed'" );
    
    $list = '<li class="all"><a href="edit.php?post_type=shop_order&amp;all_posts=1">All <span class="count">('.$count_all.')</span></a> |</li>';
    $list .= '<li class="wc-processing"><a href="edit.php?post_status=wc-processing&amp;post_type=shop_order">Processing <span class="count">('.$count_processing.')</span></a> |</li>';
    $list .= '<li class="wc-on-hold"><a href="edit.php?post_status=wc-on-hold&amp;post_type=shop_order">On hold <span class="count">('.$count_on_hold.')</span></a> |</li>';
    $list .= '<li class="wc-completed"><a href="edit.php?post_status=wc-completed&amp;post_type=shop_order">Completed <span class="count">('.$count_completed.')</span></a></li>';

    echo $list;
}



function wmp_generate_order_status_admin_count(){
    global $current_user;
    global $wpdb;


    $count_all = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type IN ('shop_order') and post_status != 'auto-draft' and post_parent <= 0" );
    $count_processing = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}wmp_orders WHERE order_status = 'processing' and seller_id > 0" );
    $count_on_hold = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}wmp_orders WHERE order_status = 'on-hold' and seller_id > 0" );
    $count_completed = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}wmp_orders WHERE order_status = 'completed' and seller_id > 0" );
    
    $list = '<li class="all"><a href="edit.php?post_type=shop_order&amp;all_posts=1">All <span class="count">('.$count_all.')</span></a> |</li>';
    $list .= '<li class="wc-processing"><a href="edit.php?post_status=wc-processing&amp;post_type=shop_order">Processing <span class="count">('.$count_processing.')</span></a> |</li>';
    $list .= '<li class="wc-on-hold"><a href="edit.php?post_status=wc-on-hold&amp;post_type=shop_order">On hold <span class="count">('.$count_on_hold.')</span></a> |</li>';
    $list .= '<li class="wc-completed"><a href="edit.php?post_status=wc-completed&amp;post_type=shop_order">Completed <span class="count">('.$count_completed.')</span></a></li>';

    echo $list;
}




/*global $woocommerce;
remove_action( 'init', array( $woocommerce, 'wc_processing_order_count' ) );*/