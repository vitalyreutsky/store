<?php

namespace App\Base;

final class Enqueue
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [self::class, 'enqueueStyles']);
        add_action('wp_enqueue_scripts', [self::class, 'enqueueScripts']);
        add_action('admin_enqueue_scripts', [self::class, 'admin_styles']);
    }

    public static function admin_styles()
    {

        wp_enqueue_style(
            "admin-style",
            get_template_directory_uri() . '/assets/admin-script-style/admin.css',
            false,
            1.1,
        );
    }

    public static function enqueueStyles()
    {
        wp_enqueue_style('vendor', get_template_directory_uri() . '/assets/app/css/vendor.css', array(), filemtime(get_template_directory() . '/assets/app/css/vendor.css'));
        wp_enqueue_style('main', get_template_directory_uri() . '/assets/app/css/main.css', array(), filemtime(get_template_directory() . '/assets/app/css/main.css'));
    }

    public static function enqueueScripts()
    {
        wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/app/js/main.js', array(), filemtime(get_template_directory() . '/assets/app/js/main.js'), true);

        wp_localize_script(
            "main-js",
            'consts',
            array(
                // 'recapthca_client_key' => get_field('recapthca_client_key', 'option'),
            )
        );
    }
}
