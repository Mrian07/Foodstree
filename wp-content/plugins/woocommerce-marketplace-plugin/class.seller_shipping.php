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
 
                    $this->enabled            = "no"; 
                    $this->title              = "WMP Shipping"; 
 
                    $this->init();
                }
 
                

                function init() {
                    $this->init_form_fields(); 
                    $this->init_settings();
 
                   add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }
 
               
                public function calculate_shipping( $package ) {
                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => '10.99',
                        'calc_tax' => 'per_item'
                    );
 
                    // Register the rate
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
