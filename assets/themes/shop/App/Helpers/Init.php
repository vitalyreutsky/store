<?php

namespace App\Helpers;

class Init
{
    public const MONTH = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];

    public const SHORT_MONTH = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
    ];

    public const CURRENT_DAY = [
        'Monday',
        'Tuesday',
        'Wednes­day',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    public function __construct()
    {
        add_filter('body_class', [self::class, 'add_class_for_body']);
        add_shortcode('current_month', [self::class, 'get_current_month']);
        add_shortcode('short_current_month', [self::class, 'get_short_current_month']);
        add_shortcode('current_year', [self::class, 'get_current_year']);
        add_shortcode('current_year', [self::class, 'get_current_year']);

        // shortcodes for meta
        add_filter('wpseo_title', 'do_shortcode');
        add_filter('wpseo_metadesc', 'do_shortcode');
        add_filter('the_title', 'do_shortcode');
    }


    public static function get_current_month()
    {
        return self::MONTH[date('n') - 1];
    }

    public static function get_short_current_month()
    {
        return self::SHORT_MONTH[date('n') - 1];
    }

    public static function get_current_year()
    {
        $year = date('Y');
        return $year;
    }

    public static function get_current_day()
    {
        return self::CURRENT_DAY[date('N') - 1];
    }

    public static function add_class_for_body($classes)
    {
        $classes[] = 'preload page';

        return $classes;
    }
}
