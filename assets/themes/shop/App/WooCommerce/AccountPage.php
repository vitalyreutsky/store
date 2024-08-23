<?php

namespace App\WooCommerce;

class AccountPage
{
    public function __construct()
    {
        add_action('init', [$this, 'accountSettings']);

        add_role('cosmetolog','Cosmetologist', array() );

        add_action('wp_ajax_ChangeUserProfile', [$this, 'ChangeUserProfile']);
        add_action('wp_ajax_nopriv_ChangeUserProfile', [$this, 'ChangeUserProfile']);
    }

    public static function accountSettings($items)
    {
        $url = $_SERVER['REQUEST_URI'];
        if (!is_user_logged_in()) {
            if (strpos($url, 'my-account') !== false) {
                if (strpos($url, 'lost-password') === false) {
                    $siteURL = get_option('siteurl');
                    header('location:' . $siteURL . '/login/?action=login');
                    exit;
                }
            }
        }

        add_filter('woocommerce_account_menu_items', static function () {

            $menuOrder = [
                'orders' => __('Orders', 'woocommerce'),
                'edit-account' => __('User profile', 'onmacabim'),
                'customer-logout' => __('Logout', 'woocommerce'),
            ];

            return $menuOrder;
        });
    }

    public static function ChangeUserProfile() {
        $data = [];
        parse_str($_POST['form'], $data);

        $billing_first_name = sanitize_text_field($data['billing_first_name']);
        $billing_last_name = sanitize_text_field($data['billing_last_name']);
        $billing_email = sanitize_email($data['billing_email']);
        $billing_phone = sanitize_text_field($data['billing_phone']);
        $billing_country = sanitize_text_field($data['billing_country']);
        $billing_state = sanitize_text_field($data['billing_state']);
        $billing_city = sanitize_text_field($data['billing_city']);
        $billing_postcode = sanitize_text_field($data['billing_postcode']);
        $billing_address_1 = sanitize_text_field($data['billing_address_1']);
        $salon_city = sanitize_text_field($data['salon_city']);
        $salon_address_1 = sanitize_text_field($data['salon_address_1']);
        $salon_utr = sanitize_text_field($data['salon_utr']);

        $path = wp_upload_dir()['basedir'] . '/privatepdf/';
        $prefix = uniqid('_', true);
        $tmp_name = $_FILES["file"]["tmp_name"];
        move_uploaded_file($tmp_name, $path . $prefix . '-' . $_FILES["file"]["name"]);
        $certificate_link = '';
        if (!is_null($_FILES["file"])) {
            if (count($_FILES["file"])) {
                $certificate_link = home_url() . '/index.php?download=' . $prefix . '-' . $_FILES["file"]["name"];
            }
        }
        $current_user = wp_get_current_user();

        if (!empty($data)) {
            if (empty($billing_first_name) || empty($billing_last_name) || empty($billing_phone) || empty($billing_email)) {
                $return = [
                    'error' => true,
                    'code' => 1,
                ];
            } else {
                if (email_exists($billing_email) && $billing_email !== $current_user->user_email) {
                    $return = [
                        'error' => true,
                        'code' => 2,
                    ];
                } else {
                    $user_id = get_current_user_id();

                    if ($user_id) {
                        update_user_meta($user_id, "first_name", $billing_first_name);
                        update_user_meta($user_id, "last_name", $billing_last_name);
                        update_user_meta($user_id, "billing_first_name", $billing_first_name);
                        update_user_meta($user_id, "billing_last_name", $billing_last_name);
                        update_user_meta($user_id, "billing_email", $billing_email);
                        update_user_meta($user_id, "billing_phone", $billing_phone);
                        update_user_meta( $user_id, "billing_country", $billing_country );
                        update_user_meta( $user_id, "billing_state", $billing_state );
                        update_user_meta( $user_id, "billing_postcode", $billing_postcode );
                        update_user_meta( $user_id, "billing_address_1", $billing_address_1 );
                        update_user_meta( $user_id, "billing_city", $billing_city );

                        update_user_meta($user_id, "city_salon", $salon_city);
                        update_user_meta($user_id, "address_salon", $salon_address_1);
                        update_user_meta($user_id, "utr", $salon_utr);
                        if ($certificate_link) {
                            update_user_meta($user_id, "certificate_link", $certificate_link);
                        }


                        $return = [
                            'error' => false,
                            'code' => 0,
                        ];
                    }
                }
            }
        } else {
            $return = [
                'error' => true,
                'code' => 0,
            ];
        }
        wp_send_json($return);
    }
}