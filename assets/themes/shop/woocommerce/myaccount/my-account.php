<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

use App\WooCommerce\Helpers;

defined( 'ABSPATH' ) || exit; ?>


<div class="view" style="padding-top: 140px">
    <div class="wrapper">
        <div class="view-wrapper">
            <?php

            do_action('woocommerce_account_navigation');
            ?>
            <div class="woocommerce-MyAccount-content">
                <?php $user_id = get_current_user_id();
                if ($user_id) :
                    if (Helpers::user_has_role($user_id, 'customer')) : ?>
                        <div class="not-approved-account__wrapper">
                            <p><?php _e('Your account is not verified as "Cosmetologist", please wait for account verification.', 'onmacabim'); ?></p>
                        </div>
                    <?php endif;
                endif;

                do_action('woocommerce_account_content');
                ?>
            </div>
        </div>
    </div>
</div>

