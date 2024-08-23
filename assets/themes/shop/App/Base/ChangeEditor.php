<?php

namespace App\Base;

final class ChangeEditor
{

    public function __construct()
    {
        if (current_user_can('editor')) {

            remove_action('admin_init', '_maybe_update_core');
            remove_action('admin_init', '_maybe_update_plugins');
            remove_action('admin_init', '_maybe_update_themes');

            remove_action('load-plugins.php', 'wp_update_plugins');
            remove_action('load-themes.php', 'wp_update_themes');

            add_filter('pre_site_transient_browser_' . md5($_SERVER['HTTP_USER_AGENT']), '__return_empty_array');
        }

        add_filter('auto_update_core', '__return_false');
        add_filter('auto_update_theme', '__return_false');
        add_filter('auto_update_plugin', '__return_false');
        add_filter('auto_update_translation', '__return_false');
    }
}
