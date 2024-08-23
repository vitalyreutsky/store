<?php

namespace App\Contact;

final class Init
{
    public function __construct()
    {
        add_action('wp_ajax_send_feedback', [self::class, 'send_feedback']);
        add_action('wp_ajax_nopriv_send_feedback', [self::class, 'send_feedback']);
    }

    public static function send_feedback()
    {
        $fields = $_POST['fields'];
        $token = $_POST['token'];

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $params = [
            'secret' => get_field('recapthca_secret_key', 'option'),
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        if (!empty($response)) $decoded_response = json_decode($response);

        if ($decoded_response && $decoded_response->success && $decoded_response->action == 'add_comment' && $decoded_response->score > 0) {
            $to = get_field('email_send_to', 'option');
            $subject = 'Message from ' . $_SERVER['SERVER_NAME'];
            $message = '<h1>' . $subject . '</h1><br>';

            foreach ($fields as $field) {
                $message .= key($field) . ': <b>' . $field[key($field)] . '</b><br>';
            }

            $headers = array(
                "Content-type: text/html; charset=utf-8",
                "From: " . $_SERVER['SERVER_NAME'] . " <no-reply@" . $_SERVER['SERVER_NAME'] . ">",
            );

            $result = wp_mail($to, $subject, $message, $headers);

            if (!$result) {
                $return = array('result' => $result, 'message' => 'There was an error. Please try again.');
            } else {
                $return = array('result' => $result, 'message' => 'Thank you, the letter has been sent.');
            }
        } else {
            $return = array('result' => false, 'message' => 'There was an error. Please try again.');
        }

        wp_send_json($return);
    }
}
