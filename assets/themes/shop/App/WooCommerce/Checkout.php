<?php

namespace App\WooCommerce;


class Checkout
{
    public function __construct()
    {
        add_filter('woocommerce_billing_fields', [$this, 'custom_billing_fields'], 10, 1);

        add_filter( 'woocommerce_package_rates', [$this, 'remove_free_shippings'], 10, 2 );
    }

    public static function remove_free_shippings( $rates, $package )
    {
        $new_rates = array();
        $min_amount = 100;
        $current = WC()->cart->get_subtotal();

        if ( $current > $min_amount ) {
            foreach ( $rates as $rate_id => $rate ) {
                if ( 'free_shipping' === $rate->method_id ) {
                    $new_rates[ $rate_id ] = $rate;
                }
            }

        }

        return ! empty( $new_rates ) ? $new_rates : $rates;
    }

    public static function custom_billing_fields($fields)
    {
        unset($fields['billing_address_2']);
        $fields['billing_first_name']['class'] = ['col-12 col-sm-6'];
        $fields['billing_last_name']['class']  = ['col-12 col-sm-6'];
        $fields['billing_company']['class']    = ['col-12 col-sm-6'];
        $fields['billing_country']['class']    = ['col-12 col-sm-6'];
        $fields['billing_address_1']['class']  = ['col-12 col-sm-6'];
        $fields['billing_city']['class']       = ['col-12 col-sm-6'];
        $fields['billing_state']['class']      = ['col-12 col-sm-6'];
        $fields['billing_postcode']['class']   = ['col-12 col-sm-6'];
        $fields['billing_phone']['class']      = ['col-12 col-sm-6'];
        $fields['billing_email']['class']      = ['col-12 col-sm-6'];

        return $fields;
    }
}