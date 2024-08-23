<?php

namespace App\Posts;

class Init
{
    public function __construct()
    {
        add_action('save_post', [__CLASS__, 'create_time_reade'], 10, 3);
    }

    public static function create_time_reade($post_ID, $post, $update)
    {
        if ($post->post_type == 'post') {
            $text = $post->post_content;
            $count_text = mb_strlen($text, 'utf-8');
            $count_text = ceil($count_text / 1500);
            if ($update) {
                if ($count_text != 0) {
                    update_post_meta($post_ID, 'count_text', $count_text);
                }
            } else {
                update_post_meta($post_ID, 'count_text', $count_text);
            }
        }
    }
}
