<?php

namespace App\WooCommerce;

class Setup
{
    public function __construct()
    {
        add_action( 'after_setup_theme', [$this, 'activateWooCommerceSupport']);
    }

    public function activateWooCommerceSupport(): void
    {
        add_theme_support( 'woocommerce' );
    }
}