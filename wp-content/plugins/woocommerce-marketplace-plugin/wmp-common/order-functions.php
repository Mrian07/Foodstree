<?php
/**
 * Get all the orders from a specific seller
 *
 * @global object $wpdb
 * @param int $seller_id
 * @return array
 */
function wmp_get_seller_orders( $seller_id, $status = 'all', $limit = 10, $offset = 0 ) {
    global $wpdb;

    $cache_key = 'wmp-seller-orders-' . $status . '-' . $seller_id;
    $orders = wp_cache_get( $cache_key, 'wmp' );

    if ( $orders === false ) {
        $status_where = ( $status == 'all' ) ? '' : $wpdb->prepare( ' AND order_status = %s', $status );

        $sql = "SELECT do.order_id, p.post_date
                FROM {$wpdb->prefix}wmp_orders AS do
                LEFT JOIN $wpdb->posts p ON do.order_id = p.ID
                WHERE
                    do.seller_id = %d AND
                    p.post_status = 'publish'
                    $status_where
                GROUP BY do.order_id
                ORDER BY p.post_date DESC
                LIMIT $offset, $limit";

        $orders = $wpdb->get_results( $wpdb->prepare( $sql, $seller_id ) );
        wp_cache_set( $cache_key, $orders, 'wmp' );
    }

    return $orders;
}

/**
 * Get the orders total from a specific seller
 *
 * @global object $wpdb
 * @param int $seller_id
 * @return array
 */
function wmp_get_seller_orders_number( $seller_id, $status = 'all' ) {
    global $wpdb;

    $cache_key = 'wmp-seller-orders-count-' . $status . '-' . $seller_id;
    $count = wp_cache_get( $cache_key, 'wmp' );

    if ( $count === false ) {
        $status_where = ( $status == 'all' ) ? '' : $wpdb->prepare( ' AND order_status = %s', $status );

        $sql = "SELECT COUNT(do.order_id) as count
                FROM {$wpdb->prefix}wmp_orders AS do
                LEFT JOIN $wpdb->posts p ON do.order_id = p.ID
                WHERE
                    do.seller_id = %d AND
                    p.post_status = 'publish'
                    $status_where";

        $result = $wpdb->get_row( $wpdb->prepare( $sql, $seller_id ) );
        $count = $result->count;

        wp_cache_set( $cache_key, $count, 'wmp' );
    }

    return $count;
}





//Check if seller has orders
function wmp_is_seller_has_orders( $seller_id ) {
  global $wpdb;
  $where = "WHERE seller_id = " . $seller_id;
  $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}wmp_orders $where" );
  if($count<=0){
    return false;
  }else{
    return true;
  }
}






/**
 * Get all the orders from a specific seller
 *
 * @global object $wpdb
 * @param int $seller_id
 * @return array
 */
function wmp_is_seller_has_order( $seller_id, $order_id ) {
    global $wpdb;

    $sql = "SELECT do.order_id, p.post_date
            FROM {$wpdb->prefix}wmp_orders AS do
            LEFT JOIN $wpdb->posts p ON do.order_id = p.ID
            WHERE
                do.seller_id = %d AND
                p.post_status = 'publish' AND
                do.order_id = %d
            GROUP BY do.order_id";

    return $wpdb->get_row( $wpdb->prepare( $sql, $seller_id, $order_id ) );
}

/**
 * Count orders for a seller
 *
 * @global WPDB $wpdb
 * @param int $user_id
 * @return array
 */
function wmp_count_orders( $user_id ) {
    global $wpdb;

    $cache_key = 'wmp-count-orders-' . $user_id;
    $counts = wp_cache_get( $cache_key, 'wmp' );

    if ( $counts === false ) {
        $counts = array('pending' => 0, 'completed' => 0, 'on-hold' => 0, 'processing' => 0, 'refunded' => 0, 'cancelled' => 0, 'total' => 0);

        $sql = "SELECT do.order_status
                FROM {$wpdb->prefix}wmp_orders AS do
                LEFT JOIN $wpdb->posts p ON do.order_id = p.ID
                WHERE
                    do.seller_id = %d AND
                    p.post_type = 'shop_order' AND
                    p.post_status = 'publish'";

        $results = $wpdb->get_results( $wpdb->prepare( $sql, $user_id ) );

        if ($results) {
            $total = 0;

            foreach ($results as $order) {
                if ( isset( $counts[$order->order_status] ) ) {
                    $counts[$order->order_status] += 1;
                    $counts['total'] += 1;
                }
            }
        }

        $counts = (object) $counts;
        wp_cache_set( $cache_key, $counts, 'wmp' );
    }

    return $counts;
}

/**
 * Update the child order status when a parent order status is changed
 *
 * @global object $wpdb
 * @param int $order_id
 * @param string $old_status
 * @param string $new_status
 */
function wmp_on_order_status_change( $order_id, $old_status, $new_status ) {
    global $wpdb;

    
    $wpdb->update( $wpdb->prefix . 'wmp_orders',
        array( 'order_status' => $new_status ),
        array( 'order_id' => $order_id ),
        array( '%s' ),
        array( '%d' )
    );

    // if any child orders found, change the orders as well
    $sub_orders = get_children( array( 'post_parent' => $order_id, 'post_type' => 'shop_order' ) );
    if ( $sub_orders ) {
        foreach ($sub_orders as $order_post) {
            $order = new WC_Order( $order_post->ID );
            $order->update_status( $new_status );
        }
    }
}

add_action( 'woocommerce_order_status_changed', 'wmp_on_order_status_change', 10, 3 );


/**
 * Mark the parent order as complete when all the child order are completed
 *
 * @param int $order_id
 * @param string $old_status
 * @param string $new_status
 * @return void
 */
function wmp_on_child_order_status_change( $order_id, $old_status, $new_status ) {
    $order_post = get_post( $order_id );

    // we are monitoring only child orders
    if ( $order_post->post_parent === 0 ) {
        return;
    }

    // get all the child orders and monitor the status
    $parent_order_id = $order_post->post_parent;
    $sub_orders = get_children( array( 'post_parent' => $parent_order_id, 'post_type' => 'shop_order' ) );


    // return if any child order is not completed
    $all_complete = true;

    if ( $sub_orders ) {
        foreach ($sub_orders as $sub) {
            $order = new WC_Order( $sub->ID );

            if ( $order->status != 'completed' ) {
                $all_complete = false;
            }
        }
    }

    // seems like all the child orders are completed
    // mark the parent order as complete
    if ( $all_complete ) {
        $parent_order = new WC_Order( $parent_order_id );
        $parent_order->update_status( 'completed', __( 'Mark parent order completed as all child orders are completed.', 'wmp' ) );
    }
}

add_action( 'woocommerce_order_status_changed', 'wmp_on_child_order_status_change', 99, 3 );


/**
 * Delete a order row from sync table when a order is deleted from WooCommerce
 *
 * @global object $wpdb
 * @param type $order_id
 */
function wmp_delete_sync_order( $order_id ) {
    global $wpdb;

    $wpdb->delete( $wpdb->prefix . 'wmp_orders', array( 'order_id' => $order_id ) );
}


/**
 * Insert a order in sync table once a order is created
 *
 * @global object $wpdb
 * @param int $order_id
 */
function wmp_sync_insert_order( $order_id ) {
    global $wpdb;

    $order = new WC_Order( $order_id );
    $seller_id = wmp_get_seller_id_by_order( $order_id );
    //$percentage = wmp_get_seller_percentage( $seller_id );
    $percentage = 100;
    $order_total = $order->get_total();

    $wpdb->insert( $wpdb->prefix . 'wmp_orders',
        array(
            'order_id' => $order_id,
            'seller_id' => $seller_id,
            'order_total' => $order_total,
            'net_amount' => ($order_total * $percentage)/100,
            'order_status' => $order->status,
        ),
        array(
            '%d',
            '%d',
            '%f',
            '%f',
            '%s',
        )
    );
}

add_action( 'woocommerce_checkout_update_order_meta', 'wmp_sync_insert_order' );
add_action( 'wmp_checkout_update_order_meta', 'wmp_sync_insert_order' );


/**
 * Get a seller ID based on WooCommerce order.
 *
 * If multiple post author is found, then this order contains products
 * from multiple sellers. In that case, the seller ID becomes `0`.
 *
 * @global object $wpdb
 * @param int $order_id
 * @return int
 */
function wmp_get_seller_id_by_order( $order_id ) {
    global $wpdb;

    $sql = "SELECT p.post_author AS seller_id
            FROM {$wpdb->prefix}woocommerce_order_items oi
            LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oim.order_item_id = oi.order_item_id
            LEFT JOIN $wpdb->posts p ON oim.meta_value = p.ID
            WHERE oim.meta_key = '_product_id' AND oi.order_id = %d GROUP BY p.post_author";

    $sellers = $wpdb->get_results( $wpdb->prepare( $sql, $order_id ) );

    if ( count( $sellers ) == 1 ) {
        return (int) reset( $sellers )->seller_id;
    }

    return 0;
}


/**
 * Get bootstrap label class based on order status
 *
 * @param string $status
 * @return string
 */
function wmp_get_order_status_class( $status ) {
    switch ($status) {
        case 'completed':
            return 'success';
            break;

        case 'pending':
            return 'danger';
            break;

        case 'on-hold':
            return 'warning';
            break;

        case 'processing':
            return 'info';
            break;

        case 'refunded':
            return 'default';
            break;

        case 'cancelled':
            return 'default';
            break;

        case 'failed':
            return 'danger';
            break;
    }
}









function wmp_create_sub_order( $parent_order_id ) {

    $parent_order = new WC_Order( $parent_order_id );
    $order_items = $parent_order->get_items();

    $sellers = array();
    foreach ($order_items as $item) {
        $seller_id = get_post_field( 'post_author', $item['product_id'] );
        $sellers[$seller_id][] = $item;
    }

    // return if we've only ONE seller
    if ( count( $sellers ) == 1 ) {
        $temp = array_keys( $sellers );
        $seller_id = reset( $temp );
        wp_update_post( array( 'ID' => $parent_order_id, 'post_author' => $seller_id ) );
        wmp_seller_order_email($parent_order_id,$seller_id);
        return;
    }

    // flag it as it has a suborder
    update_post_meta( $parent_order_id, 'has_sub_order', true );

    // seems like we've got multiple sellers
    foreach ($sellers as $seller_id => $seller_products ) {
        wmp_create_seller_order( $parent_order, $seller_id, $seller_products );
    }
}

add_action( 'woocommerce_checkout_update_order_meta', 'wmp_create_sub_order' );








/**
 * Creates a sub order
 *
 * @param int $parent_order
 * @param int $seller_id
 * @param array $seller_products
 */
function wmp_create_seller_order( $parent_order, $seller_id, $seller_products ) {
    $order_data = apply_filters( 'woocommerce_new_order_data', array(
        'post_type'     => 'shop_order',
        'post_title'    => sprintf( __( 'Order &ndash; %s', 'woocommerce' ), strftime( _x( '%b %d, %Y @ %I:%M %p', 'Order date parsed by strftime', 'woocommerce' ) ) ),
        'post_status'   => 'publish',
        'ping_status'   => 'closed',
        'post_excerpt'  => isset( $posted['order_comments'] ) ? $posted['order_comments'] : '',
        'post_author'   => $seller_id,
        'post_parent'   => $parent_order->id,
        'post_password' => uniqid( 'order_' )   // Protects the post just in case
    ) );

    $order_id = wp_insert_post( $order_data );

    if ( $order_id && !is_wp_error( $order_id ) ) {

        $order_total = $order_tax = 0;
        $product_ids = array();

        // now insert line items
        foreach ($seller_products as $item) {
            $order_total += (float) $item['line_total'];
            $order_tax += (float) $item['line_tax'];
            $product_ids[] = $item['product_id'];

            $item_id = wc_add_order_item( $order_id, array(
                'order_item_name' => $item['name'],
                'order_item_type' => 'line_item'
            ) );

            if ( $item_id ) {
                wc_add_order_item_meta( $item_id, '_qty', $item['qty'] );
                wc_add_order_item_meta( $item_id, '_tax_class', $item['tax_class'] );
                wc_add_order_item_meta( $item_id, '_product_id', $item['product_id'] );
                wc_add_order_item_meta( $item_id, '_variation_id', $item['variation_id'] );
                wc_add_order_item_meta( $item_id, '_line_subtotal', $item['line_subtotal'] );
                wc_add_order_item_meta( $item_id, '_line_total', $item['line_total'] );
                wc_add_order_item_meta( $item_id, '_line_tax', $item['line_tax'] );
                wc_add_order_item_meta( $item_id, '_line_subtotal_tax', $item['line_subtotal_tax'] );
            }
        } // foreach

        $bill_ship = array(
            '_billing_country', '_billing_first_name', '_billing_last_name', '_billing_company',
            '_billing_address_1', '_billing_address_2', '_billing_city', '_billing_state', '_billing_postcode',
            '_billing_email', '_billing_phone', '_shipping_country', '_shipping_first_name', '_shipping_last_name',
            '_shipping_company', '_shipping_address_1', '_shipping_address_2', '_shipping_city',
            '_shipping_state', '_shipping_postcode'
        );

        // save billing and shipping address
        foreach ($bill_ship as $val) {
            $order_key = ltrim( $val, '_' );
            update_post_meta( $order_id, $val, $parent_order->$order_key );
        }

        // do shipping
        $shipping_cost = wmp_create_sub_order_shipping( $parent_order, $order_id, $seller_products );

        // add coupons if any
        wmp_create_sub_order_coupon( $parent_order, $order_id, $product_ids );
        $discount = wmp_sub_order_get_total_coupon( $order_id );

        // calculate the total
        $order_in_total = $order_total + $shipping_cost + $order_tax - $discount;

        // set order meta
        update_post_meta( $order_id, '_payment_method',         $parent_order->payment_method );
        update_post_meta( $order_id, '_payment_method_title',   $parent_order->payment_method_title );

        update_post_meta( $order_id, '_order_shipping',         woocommerce_format_decimal( $shipping_cost ) );
        update_post_meta( $order_id, '_order_discount',         woocommerce_format_decimal( $discount ) );
        update_post_meta( $order_id, '_cart_discount',          '0' );
        update_post_meta( $order_id, '_order_tax',              woocommerce_format_decimal( $order_tax ) );
        update_post_meta( $order_id, '_order_shipping_tax',     '0' );
        update_post_meta( $order_id, '_order_total',            woocommerce_format_decimal( $order_in_total ) );
        update_post_meta( $order_id, '_order_key',              apply_filters('woocommerce_generate_order_key', uniqid('order_') ) );
        update_post_meta( $order_id, '_customer_user',          $parent_order->customer_user );
        update_post_meta( $order_id, '_order_currency',         get_post_meta( $parent_order->id, '_order_currency', true ) );
        update_post_meta( $order_id, '_prices_include_tax',     $parent_order->prices_include_tax );
        update_post_meta( $order_id, '_customer_ip_address',    get_post_meta( $parent_order->id, '_customer_ip_address', true ) );
        update_post_meta( $order_id, '_customer_user_agent',    get_post_meta( $parent_order->id, '_customer_user_agent', true ) );

        do_action( 'wmp_checkout_update_order_meta', $order_id );

        // Order status
        wp_set_object_terms( $order_id, 'pending', 'shop_order_status' );

        wmp_seller_order_email($order_id,$seller_id);

    } // if order
}




/**
 * Get discount coupon total from a order
 *
 * @global WPDB $wpdb
 * @param int $order_id
 * @return int
 */
function wmp_sub_order_get_total_coupon( $order_id ) {
    global $wpdb;

    $sql = $wpdb->prepare( "SELECT SUM(oim.meta_value) FROM {$wpdb->prefix}woocommerce_order_itemmeta oim
            LEFT JOIN {$wpdb->prefix}woocommerce_order_items oi ON oim.order_item_id = oi.order_item_id
            WHERE oi.order_id = %d AND oi.order_item_type = 'coupon'", $order_id );

    $result = $wpdb->get_var( $sql );
    if ( $result ) {
        return $result;
    }

    return 0;
}



/**
 * Create coupons for a sub-order if neccessary
 *
 * @param WC_Order $parent_order
 * @param int $order_id
 * @param array $product_ids
 * @return type
 */
function wmp_create_sub_order_coupon( $parent_order, $order_id, $product_ids ) {
    $used_coupons = $parent_order->get_used_coupons();

    if ( ! count( $used_coupons ) ) {
        return;
    }

    if ( $used_coupons ) {
        foreach ($used_coupons as $coupon_code) {
            $coupon = new WC_Coupon( $coupon_code );

            if ( $coupon && !is_wp_error( $coupon ) && array_intersect( $product_ids, $coupon->product_ids ) ) {

                // we found some match
                $item_id = wc_add_order_item( $order_id, array(
                    'order_item_name' => $coupon_code,
                    'order_item_type' => 'coupon'
                ) );

                // Add line item meta
                if ( $item_id ) {
                    wc_add_order_item_meta( $item_id, 'discount_amount', isset( WC()->cart->coupon_discount_amounts[ $coupon_code ] ) ? WC()->cart->coupon_discount_amounts[ $coupon_code ] : 0 );
                }
            }
        }
    }
}


/**
 * Create shipping for a sub-order if neccessary
 *
 * @param WC_Order $parent_order
 * @param int $order_id
 * @param array $product_ids
 * @return type
 */
function wmp_create_sub_order_shipping( $parent_order, $order_id, $seller_products ) {
    // take only the first shipping method
    $shipping_methods = $parent_order->get_shipping_methods();
    $shipping_method = is_array( $shipping_methods ) ? reset( $shipping_methods ) : array();

    // bail out if no shipping methods found
    if ( !$shipping_method ) {
        return;
    }

    $shipping_products = array();
    $packages = array();

    // emulate shopping cart for calculating the shipping method
    foreach ($seller_products as $product_item) {
        $product = get_product( $product_item['product_id'] );

        if ( $product->needs_shipping() ) {
            $shipping_products[] = array(
                'product_id' => $product_item['product_id'],
                'variation_id' => $product_item['variation_id'],
                'variation' => '',
                'quantity' => $product_item['qty'],
                'data' => $product,
                'line_total' => $product_item['line_total'],
                'line_tax' => $product_item['line_tax'],
                'line_subtotal' => $product_item['line_subtotal'],
                'line_subtotal_tax' => $product_item['line_subtotal_tax'],
            );
        }
    }

    if ( $shipping_products ) {
        $package = array(
            'contents' => $shipping_products,
            'contents_cost' => array_sum( wp_list_pluck( $shipping_products, 'line_total' ) ),
            'applied_coupons' => array(),
            'destination' => array(
                'country' => $parent_order->shipping_country,
                'state' => $parent_order->shipping_state,
                'postcode' => $parent_order->shipping_postcode,
                'city' => $parent_order->shipping_city,
                'address' => $parent_order->shipping_address_1,
                'address_2' => $parent_order->shipping_address_2,
            )
        );

        $wc_shipping = WC_Shipping::instance();
        $pack = $wc_shipping->calculate_shipping_for_package( $package );

        if ( array_key_exists( $shipping_method['method_id'], $pack['rates'] ) ) {
            $method = $pack['rates'][$shipping_method['method_id']];
            $cost = wc_format_decimal( $method->cost );

            $item_id = wc_add_order_item( $order_id, array(
                'order_item_name'       => $method->label,
                'order_item_type'       => 'shipping'
            ) );

            if ( $item_id ) {
                wc_add_order_item_meta( $item_id, 'method_id', $method->id );
                wc_add_order_item_meta( $item_id, 'cost', $cost );
            }

            return $cost;
        };
    }

    return 0;
}








/**************************EMAILS************************
*********************************************************/


///Send order mail to seller
function wmp_seller_order_email($order_id,$seller_id) {
    global $woocommerce;
    $order = new WC_Order( $order_id );
    $seller_info = get_userdata($seller_id);
    $author_email = $seller_info->user_email;
    $site_title = __('Foodstree');
    $email_subject = __('New order from: '.$site_title.'');
    $email_heading = __('New customer order');
    $admin_email = get_option( 'admin_email' );
    $headers = 'From:'.$site_title.' <'.$admin_email.'>' . "";
    ob_start();
    woocommerce_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
    woocommerce_get_template( 'emails/admin-new-order.php', array( 'order' => $order ) );
    woocommerce_get_template( 'emails/email-footer.php' );
    $message = ob_get_contents();
    ob_end_clean();
    wp_mail($author_email, $email_subject, $message, $headers);
}

add_filter('wp_mail_content_type','set_content_type');

function set_content_type($content_type){
    return 'text/html';
}



//Processing order subject
add_filter('woocommerce_email_subject_customer_processing_order', 'change_processing_order_subject', 1, 2);
function change_processing_order_subject( $subject, $order ) {
    global $woocommerce;

    $combined_order = wp_get_post_parent_id( $order->id );
    if($combined_order > 0){
     $subject = 'Part of your combined order #'.$combined_order.' being processed';
 }
 return $subject;
}


//Processing order heading
add_filter('woocommerce_email_heading_customer_processing_order', 'change_processing_order_heading', 10, 2);
function change_processing_order_heading( $heading, $order ) {
    global $woocommerce;

    $combined_order = wp_get_post_parent_id( $order->id );
    if($combined_order > 0){
        $heading = 'Part of your order being processed';
    }
    return $heading;
}



//Completed order subject
add_filter('woocommerce_email_subject_customer_completed_order', 'change_completed_order_subject', 1, 2);
function change_completed_order_subject( $subject, $order ) {
    global $woocommerce;

    $combined_order = wp_get_post_parent_id( $order->id );
    if($combined_order > 0){
     $subject = 'Part of your combined order #'.$combined_order.' is complete';
 }
 return $subject;
}


//Completed order heading
add_filter('woocommerce_email_heading_customer_completed_order', 'change_completed_order_heading', 10, 2);
function change_completed_order_heading( $heading, $order ) {
    global $woocommerce;

    $combined_order = wp_get_post_parent_id( $order->id );
    if($combined_order > 0){
        $heading = 'Part of your order is complete';
    }
    return $heading;
}



//Send cc to admin upon order status change
add_filter( 'woocommerce_email_recipient_customer_completed_order', 'admin_cc_email_recipient_on_status_change', 10, 2);
add_filter( 'woocommerce_email_recipient_customer_processing_order', 'admin_cc_email_recipient_on_status_change', 10, 2);
function admin_cc_email_recipient_on_status_change($recipient, $object) {
    $admin_email = get_option( 'admin_email' );
    $recipient = $recipient . ', '.$admin_email;
    return $recipient;
}