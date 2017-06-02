<?php
/**
 * Custom Shipping class based on seller
 *
 * @author  Ajency.in
 * @package Woocommerce Marketplace plugin
 * @version 1.1.0
 */



 
    function your_shipping_method_init() {
        if ( ! class_exists( 'WC_WMP_Shipping_Method' ) ) {
            class WC_WMP_Shipping_Method extends WC_Shipping_Method {
               
                public function __construct() {
                    $this->id                 = 'wmp_shipping'; 
                    $this->method_title       = __( 'WMP Shipping' ); 
                    $this->method_description = __( 'Custom marketplace shipping method, based on custom rate for each seller' ); 
 
                    //$this->enabled            = "yes"; 
                    //$this->title              = "WMP Shipping"; 
 
                    $this->init();
                }
 
                

                function init() {
                    $this->init_form_fields(); 
                    $this->init_settings();

                    $this->enabled      = $this->settings['enabled'];
                    $this->title        = $this->settings['title'];
                    $this->availability = $this->settings['availability'];
                    $this->countries    = $this->settings['countries'];
 
                   add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }



                function init_form_fields() {
                    global $woocommerce;

                    $this->form_fields = array(
                        'enabled'      => array(
                            'title'            => __('Enable/Disable', 'woocommerce'),
                            'type'             => 'checkbox',
                            'label'            => __('Enable WMP Shipping', 'woocommerce'),
                            'default'          => 'yes'
                            ),
                        'title'        => array(
                            'title'            => __('Method Title', 'woocommerce'),
                            'type'             => 'text',
                    //'description'      => __('Titel', 'woocommerce'),
                            'default'          => __('WMP Shipping', 'woocommerce')
                            ),
                        'availability' => array(
                            'title'            => __('Method availability', 'woocommerce'),
                            'type'             => 'select',
                            'default'          => 'all',
                            'class'            => 'availability',
                            'options'          => array(
                                'all'          => __('All allowed countries', 'woocommerce'),
                                'specific'     => __('Specific Countries', 'woocommerce')
                                )
                            ),
                        'countries'    => array(
                            'title'            => __('Specific Countries', 'woocommerce'),
                            'type'             => 'multiselect',
                            'class'            => 'chosen_select',
                            'css'              => 'width: 450px;',
                            'default'          => '',
                            'options'          => $woocommerce->countries->countries
                            )
                        );
}


               
public function calculate_shipping( $package ) {
    global $ajency_wmp;
    $rate = array(
        'id' => $this->id,
        'label' => $this->title,
        'cost' => $ajency_wmp->wmp_shipping_rate($package),
        'calc_tax' => 'per_item'
        );

                  
    $this->add_rate( $rate );
}












            }
        }
    }
 
    add_action( 'woocommerce_shipping_init', 'your_shipping_method_init' );
 
    function add_your_shipping_method( $methods ) {
        $methods[] = 'WC_WMP_Shipping_Method';
        return $methods;
    }
 
    add_filter( 'woocommerce_shipping_methods', 'add_your_shipping_method' );








 






 /*function cp_add_custom_price( $cart_object ) {

    global $woocommerce;
    $specialfeecat = 10; // category id for the special fee
    $spfee = 0.00; // initialize special fee
    $spfeeperprod = 5.00; //special fee per product
    
    foreach ( $cart_object->cart_contents as $key => $value ) {
        
        $proid = $value['product_id']; //get the product id from cart
        $quantiy = $value['quantity']; //get quantity from cart

        $terms = get_the_terms( $proid, 'product_cat' ); //get taxonamy of the prducts
        if ( $terms && ! is_wp_error( $terms ) ) :
            foreach ( $terms as $term ) {
                $catid = $term->term_id;
                if($specialfeecat == $catid ) {
                    $spfee = $spfee + $quantiy * $spfeeperprod;
                }
            }
        endif;  
    }

    if($spfee > 0 ) {
    
        $woocommerce->cart->add_fee( 'Special fee', $spfee, true, 'standard' );
    }
    
}

add_action( 'woocommerce_cart_calculate_fees', 'cp_add_custom_price' );*/