<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>
    <div class="registration-container new-password">
        <div class="wrapper">
            <div class="new-password-wrapper">
                <h1 class="registration-container__title"><?php esc_html_e('New password', 'onmacabim'); ?></h1>
                <form action="">
                    <input type="hidden" name="reset_key" value="<?php echo esc_attr($args['key']); ?>" />
                    <input type="hidden" name="reset_login" value="<?php echo esc_attr($args['login']); ?>" />
                    <div class="password-wrapper row">
                        <div class="col-6">
                            <h4><?php esc_html_e('New password *', 'onmacabim'); ?></h4>
                            <div class="form-group required-field">
                                <input name="password" class="password password-reset-input" type="password">
                                <span class="toggle-password"></span>
                                <div class="password-wrapper-notice"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4><?php esc_html_e('Confirm new password *', 'onmacabim'); ?></h4>
                            <div class="form-group required-field">
                                <input name="password_repeat" class="password password-reset-input" type="password">
                                <span class="toggle-password"></span>
                            </div>
                        </div>
                        <div class="col-12 reset-password-wrap">
                            <button type="button" class="btn btn-primary reset-password disabled">
                                <?php esc_html_e('Reset password', 'onmacabim'); ?>
                            </button>
                        </div>
                    </div>

                </form>
                <p class="text"></p>
            </div>
            <div class="success-reset" style="display: none">
                <h3 class="title"><?php esc_html_e('Your password has been reset', 'onmacabim'); ?></h3>
                <p class="subtitle"><?php esc_html_e('You may now use new password to log in account. We have also sent an email to your recovery address confirming that your password has been reset.', 'onmacabim'); ?></p>
                <a href="<?php echo get_home_url(); ?>" class="btn btn-primary"><?php esc_html_e('Go to homepage', 'onmacabim'); ?></a>
            </div>
        </div>
    </div>
<?php
do_action( 'woocommerce_after_reset_password_form' );