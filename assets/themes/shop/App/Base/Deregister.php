<?php

namespace App\Base;

final class Deregister
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [self::class, 'deregisterStyles'], 100);
        add_action('wp_enqueue_scripts', [self::class, 'deregisterScripts']);
        self::disableEmoji();
    }

    public static function deregisterStyles()
    {
        if (current_user_can('update_core')) {
            return;
        }
        wp_dequeue_style('dashicons');
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('safe-svg-svg-icon-style');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
        wp_dequeue_style('core-block-supports');
        add_action('wp_footer', function () {
            wp_dequeue_style('core-block-supports');
        });
    }

    public static function deregisterScripts()
    {
        wp_dequeue_script('wp-emoji');
    }

    public static function disableEmoji()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }
}
