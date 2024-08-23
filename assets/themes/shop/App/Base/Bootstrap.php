<?php

namespace App\Base;

use WP_HTML_Tag_Processor;

final class Bootstrap
{

    public const MENUS = [
        'header'       => 'header-menu',
    ];

    public function __construct()
    {
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_action('init', [self::class, 'registerMenus']);
        add_filter('upload_mimes', [self::class, 'allowUploadSvg']);
        remove_action('begin_fetch_post_thumbnail_html', '_wp_post_thumbnail_class_filter_add');
        add_filter('excerpt_length', [self::class, 'new_excerpt_length']);

        add_filter('render_block', [self::class, 'remove_wp_classes'], 10, 2);

        add_filter('the_content', [self::class, 'remove_post_image_class']);
    }

    public static function remove_post_image_class($content)
    {
        $post_string = $content;
        $post_string = preg_replace('/<img class=".*?"/', '<img', $post_string);
        return $post_string;
    }

    public static function remove_wp_classes($block_content, $block)
    {

        if ('core/heading' === $block['blockName']) {
            $block_content = new WP_HTML_Tag_Processor($block_content);
            $block_content->next_tag();
            $block_content->add_class('block-heading');
            $block_content->remove_class('wp-block-heading');
            $block_content->get_updated_html();
        }

        if ('core/group' === $block['blockName']) {
            $block_content = new WP_HTML_Tag_Processor($block_content);
            $block_content->next_tag();
            $block_content->add_class('block-group');
            $block_content->remove_class('wp-block-group');
            $block_content->remove_class('wp-block-group-is-layout-constrained');
            $block_content->get_updated_html();
        }

        if ('core/columns' === $block['blockName']) {
            $block_content = new WP_HTML_Tag_Processor($block_content);
            $block_content->next_tag();
            $block_content->add_class('block-columns');
            $content = $block_content->get_updated_html();
            $class_name = '';

            if (strripos($content, 'wp-container-') !== false) {
                $start = strripos($content, 'wp-container-');
                $end = strpos($content, ' ', $start);
                $class_name = mb_substr($content, $start, $end - $start);
            }

            if ($class_name) {
                $block_content->remove_class($class_name);
            }

            $block_content->remove_class('wp-block-columns');

            $block_content->remove_class('wp-block-columns-is-layout-flex');
            $block_content->get_updated_html();
        }

        if ('core/column' === $block['blockName']) {
            $block_content = new WP_HTML_Tag_Processor($block_content);
            $block_content->next_tag();
            $block_content->add_class('block-column');
            $block_content->remove_class('wp-block-column');
            $block_content->remove_class('wp-block-column-is-layout-flow');
            $block_content->get_updated_html();
        }

        if ('core/image' === $block['blockName']) {
            $block_content = new WP_HTML_Tag_Processor($block_content);
            $block_content->next_tag();
            $block_content->add_class('block-image');
            $block_content->remove_class('wp-block-image');
            $block_content->get_updated_html();

            $content = $block_content->get_updated_html();

            if (strripos($content, 'class="wp-image-') !== false) {
                $start = strripos($content, 'class="wp-image-');
                $end = strpos($content, ' ', $start);
                $start_str = mb_substr($content, 0, $start - 2);
                $end_str = mb_substr($content, $end - 1, -1);

                return $start_str . $end_str;
            }
        }

        if ('core/table' === $block['blockName']) {
            $block_content = new WP_HTML_Tag_Processor($block_content);
            $block_content->next_tag();
            $block_content->add_class('block-table');
            $block_content->remove_class('wp-block-table');
            $block_content->get_updated_html();
        }

        return $block_content;
    }

    public static function new_excerpt_length($length)
    {
        return 9999;
    }

    public static function registerMenus()
    {
        register_nav_menus(
            array(
                self::MENUS['header'] => __('Header Menu', TM_TEXTDOMAIN),
            )
        );
    }

    public static function bootstrap_header_menu()
    {
        wp_nav_menu(array(
            'theme_location' => self::MENUS['header']
        ));
    }

    public static function allowUploadSvg($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
}
