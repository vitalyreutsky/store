<?php

namespace App\WooCommerce;

use App\WooCommerce\Helpers;

class Cart
{
    public function __construct()
    {
        add_action('wp_ajax_addProductToCart', [$this, 'addProductToCart']);
        add_action('wp_ajax_nopriv_addProductToCart', [$this, 'addProductToCart']);

        add_action('wp_ajax_removeProductFromCart', [$this, 'removeProductFromCart']);
        add_action('wp_ajax_nopriv_removeProductFromCart', [$this, 'removeProductFromCart']);

        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
    }

    public static function addProductToCart()
    {
        $quantity = $_POST['quantity'];
        $id = $_POST['id'];
        if (WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($id))) {
            $cart_item_key = WC()->cart->generate_cart_id($id);
            WC()->cart->set_quantity($cart_item_key, $quantity);
        } else {
            WC()->cart->add_to_cart($id, $quantity);
        }
        wp_send_json(self::getTopCartCount());
    }

    public static function removeProductFromCart()
    {
        $id = $_POST['id'];

        if (WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($id))) {
            $cart_item_key = WC()->cart->generate_cart_id($id);
            WC()->cart->remove_cart_item($cart_item_key);
        }

        wp_send_json(self::getTopCartCount());
    }


    public static function getTopCartCount(): string
    {
        $cart_count = count(WC()->cart->get_cart());
        if ($cart_count > 0) {
            return $cart_count;
        }

        return 0;
    }
}
