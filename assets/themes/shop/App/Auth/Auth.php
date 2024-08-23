<?php

namespace App\Auth;

use WP_User;

class Auth
{
    public function __construct()
    {
        add_action('wp_ajax_RegisterUser', [$this, 'RegisterUser']);
        add_action('wp_ajax_nopriv_RegisterUser', [$this, 'RegisterUser']);

        add_action('wp_ajax_AuthorizeUser', [$this, 'AuthorizeUser']);
        add_action('wp_ajax_nopriv_AuthorizeUser', [$this, 'AuthorizeUser']);

        add_action('wp_ajax_ForgotPassword', [$this, 'ForgotPassword']);
        add_action('wp_ajax_nopriv_ForgotPassword', [$this, 'ForgotPassword']);

        add_action('wp_ajax_ResetPassword', [$this, 'ResetPassword']);
        add_action('wp_ajax_nopriv_ResetPassword', [$this, 'ResetPassword']);

        add_action('init', [$this, 'get_admin_certificate']);

        remove_filter('lostpassword_url', [$this, 'wc_lostpassword_url'], 10);
        add_filter('lostpassword_url', [$this, 'reset_pass_url'], 10, 2);
    }

    public static function RegisterUser()
    {
        $data = [];
        parse_str($_POST['form'], $data);
        $email = sanitize_email($data['register-email']);
        $first_name = sanitize_text_field($data['register-first-name']);
        $last_name = sanitize_text_field($data['register-last-name']);
        $phone = sanitize_text_field($data['register-phone']);
        $password = sanitize_text_field($data['register-password']);
        $register_city = sanitize_text_field($data['register-city']);
        $register_address = sanitize_text_field($data['register-address']);
        $register_city_salon = sanitize_text_field($data['register-city-salon']);
        $register_address_salon = sanitize_text_field($data['register-address-salon']);
        $register_utr = sanitize_text_field($data['register-utr']);

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

        if (!empty($data)) {
            if (empty($first_name) || empty($last_name) || empty($phone) || empty($password) || empty($email) ) {
                $return = [
                    'error' => true,
                    'code' => 1,
                ];
            } else {
                if (email_exists($email)) {
                    $return = [
                        'error' => true,
                        'code' => 2,
                    ];
                } else {
                    $user_id = wc_create_new_customer($email, $first_name . ' ' . $last_name . ' - ' . $email, $password);

                    if ($user_id) {
                        update_user_meta($user_id, "first_name", $first_name);
                        update_user_meta($user_id, "last_name", $last_name);
                        $user_nickname = $first_name . ' ' . $last_name;

                        update_user_meta($user_id, 'nickname', $user_nickname);
                        update_user_meta($user_id, "billing_first_name", $first_name);
                        update_user_meta($user_id, "billing_last_name", $last_name);
                        update_user_meta($user_id, "billing_email", $email);
                        update_user_meta($user_id, "billing_phone", $phone);
                        update_user_meta( $user_id, "billing_address_1", $register_address );
                        update_user_meta( $user_id, "billing_city", $register_city );

                        update_user_meta($user_id, "city_salon", $register_city_salon);
                        update_user_meta($user_id, "address_salon", $register_address_salon);
                        update_user_meta($user_id, "utr", $register_utr);
                        update_user_meta($user_id, "certificate_link", $certificate_link);

                        wp_clear_auth_cookie();
                        clean_user_cache($user_id);
                        wp_set_current_user($user_id);
                        wp_set_auth_cookie($user_id);

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

    public static function AuthorizeUser()
    {
        $data = [];
        parse_str($_POST['data'], $data);
        $email = sanitize_email($data['login-email']);
        $password = $data['login-password'];
        $check = false;
        if ($data['check'] == 'on') {
            $check = true;
        }
        if (!empty($data)) {
            if (empty($email)) {
                $return = [
                    'error' => true,
                    'code' => 1,
                ];
            } elseif (empty($password)) {
                $return = [
                    'error' => true,
                    'code' => 2,
                ];
            } else {
                $userdata = [
                    'user_login' => $email,
                    'user_password' => $password,
                    'remember' => $check,
                ];

                $signon = wp_signon($userdata, false);

                if (is_wp_error($signon)) {
                    $return = [
                        'error' => true,
                        'code' => 3,
                    ];
                } else {
                    wp_clear_auth_cookie();
                    clean_user_cache($signon->ID);
                    wp_set_current_user($signon->ID);
                    wp_set_auth_cookie($signon->ID);
                    update_user_caches($signon);
                    $return = [
                        'error' => false,
                        'code' => 0,
                    ];
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

    public static function ForgotPassword()
    {
        $data = [];
        parse_str($_POST['data'], $data);
        $email = $data['forgot-email'];

        if (empty($email)) {
            $return = [
                'error' => true,
                'code' => 0,
            ];
        } elseif (!email_exists($email)) {
            $return = [
                'error' => true,
                'code' => 1,
            ];
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $return = [
                'error' => true,
                'code' => 2,
            ];
        } else {
            $user_id = get_user_by_email($email);
            $user = new WP_User($user_id->ID);
            $reset_key = get_password_reset_key($user);
            $wc_emails = WC()->mailer()->get_emails();
            $wc_emails['WC_Email_Customer_Reset_Password']->trigger($user->user_login, $reset_key);
            $return = [
                'error' => false,
                'code' => 3,
            ];
        }

        wp_send_json($return);
    }

    public static function ResetPassword()
    {
        $data = [];
        parse_str($_POST['data'], $data);
        $reset_key = $data['reset_key'];
        $login = $data['reset_login'];
        $pass1 = $data['password'];
        $pass2 = $data['password_repeat'];

        $test_key = check_password_reset_key($reset_key, $login);
        if (is_wp_error($test_key)) {
            $return = [
                'error' => true,
                'code' => 0,
            ];
        } else {
            if ($pass1 === $pass2) {
                if (strlen($pass1) < 8) {
                    $return = [
                        'error' => true,
                        'code' => 2,
                    ];
                } else {
                    $return = [
                        'error' => false,
                        'code' => 3,
                    ];
                    wp_set_password($pass1, $test_key->ID);
                }
            } else {
                $return = [
                    'error' => true,
                    'code' => 1,
                ];
            }
        }
        wp_send_json($return);
    }

    public static function get_admin_certificate()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $path = wp_parse_url($uri, PHP_URL_PATH);

        if ('/index.php' === $path) {
            $infilename = $_GET["download"];
            $file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/privatepdf/' . $infilename;
            function is_site_admin($infilename)
            {
                if (strpos(get_the_author_meta('certificate_link', wp_get_current_user()->ID), $infilename) > 0) {
                    return true;
                }
                return in_array('administrator', wp_get_current_user()->roles);
            }
            if (is_site_admin($infilename)) {
                if (!empty($file)) {
                    if (file_exists($file)) {
                        if (ob_get_level()) {
                            ob_end_clean();
                        }
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename=' . basename($file));
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file));
                        readfile($file);
                        die();
                    } else {
                        echo '<br/>' . _e('File does not exists on given path', 'onmacabim');
                        die();
                    }
                }
            } else {
                wp_redirect(home_url());
                die;
            }
        }
    }

    public static function reset_pass_url()
    {
        $siteURL = get_option('siteurl');
        return "{$siteURL}/login/?action=lostpassword";
    }
}