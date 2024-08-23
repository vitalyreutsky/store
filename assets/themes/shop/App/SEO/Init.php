<?php

namespace App\Seo;

final class Init
{
    public function __construct()
    {
        add_filter('locale', function () {
            return 'en-US';
        });
        add_filter('wpseo_locale', [self::class, 'change_og_locale']);
        remove_action('wp_head', 'wp_generator');
        add_filter('wpseo_json_ld_output', '__return_false');
        add_filter('wpseo_debug_markers', '__return_false');
        add_action('wp_head', [self::class, 'remove_comments_yoast'], ~PHP_INT_MAX);
        add_filter('w3tc_can_print_comment', [self::class, 'remove_comments_w3tc'], 10, 1);
        add_action('wpseo_register_extra_replacements', [self::class, 'register_custom_yoast_variables']);
        add_filter('wpseo_opengraph_image', [self::class, 'wpseo_opengraph_image_filter'], 10, 2);

        if (!is_user_logged_in()) {
            remove_action('rest_api_init', 'wp_oembed_register_route');
            remove_action('template_redirect', 'rest_output_link_header', 11);
            remove_action('wp_head', 'rest_output_link_wp_head', 10);
            remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
            remove_action('wp_head', 'wp_oembed_add_discovery_links');
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wp_shortlink_wp_head', 10);
        }
    }

    public static function wpseo_opengraph_image_filter($image_url, $presentation)
    {
        $image_id = get_field('social_media_image', 'options');

        if ($image_id) {
            return wp_get_attachment_image_url($image_id, 'full');
        }

        return $image_url;
    }

    public static function register_custom_yoast_variables()
    {
        wpseo_register_var_replacement('%%get_month%%', [self::class, 'get_month'], 'advanced', 'some help text');
    }

    public static function get_month()
    {
        return date('F');
    }


    public static function change_og_locale($locale)
    {
        return 'en_US';
    }

    public static function remove_comments_yoast()
    {
        ob_start(function ($o) {
            return preg_replace('/\n?<.*?Yoast SEO plugin.*?>/mi', '', $o);
        });
    }

    public static function remove_comments_w3tc($w3tc_setting)
    {
        return false;
    }
}
