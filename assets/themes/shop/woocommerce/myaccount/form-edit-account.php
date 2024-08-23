<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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

do_action( 'woocommerce_before_edit_account_form' ); ?>
<div class="account-details registration-container">
    <h3 class="title"><?php _e('User Profile', 'onmacabim'); ?></h3>

    <div class="success__change d-none">
        <p><?php _e('Your data has been successfully changed', 'onmacabim'); ?></p>
    </div>

    <form class="woocommerce-EditAccountForm edit-account form-onmacabim" action="" method="post" autocomplete="off" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

        <?php do_action('woocommerce_edit_account_form_start'); ?>

        <div class="user-profile form-group-wrapper">
            <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                <?php $customer = new WC_Customer($user->ID);
                woocommerce_form_field('billing_first_name', array(
                    'type'        => 'text',
                    'required'    => true,
                    'label'       => __('First Name', 'onmacabim'),
                    'class'       => ''
                ), $user->first_name);?>
                <div class="form-message"></div>
            </div>
            <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                <?php $customer = new WC_Customer($user->ID);
                woocommerce_form_field('billing_last_name', array(
                    'type'        => 'text',
                    'required'    => true,
                    'label'       => __('Last Name', 'onmacabim'),
                    'class'       => ''
                ), $user->last_name);?>
                <div class="form-message"></div>
            </div>
            <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                <?php $customer = new WC_Customer($user->ID);
                woocommerce_form_field('billing_email', array(
                    'type'        => 'email',
                    'required'    => true,
                    'label'       => __('Email', 'onmacabim'),
                    'class'       => ''
                ), $user->user_email);?>
                <div class="form-message"></div>
            </div>

            <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                <?php $customer = new WC_Customer($user->ID);
                woocommerce_form_field('billing_phone', array(
                    'type'        => 'text',
                    'required'    => true,
                    'label'       => __('Phone', 'onmacabim'),
                    'class'       => ''
                ), $user->billing_phone);?>
                <div class="form-message"></div>
            </div>
        </div>

        <div class="billing-address form-group-wrapper">
            <h3 class="billing-address__title"><?php _e('Delivery address', 'onmacabim'); ?></h3>
            <div class="billing-address__wrapper form-group-wrapper">
                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('billing_country', array(
                        'type'        => 'country',
                        'required'    => true,
                        'label'       => __('Country / Region', 'onmacabim'),
                        'class'       => ''
                    ), $user->billing_country);?>
                    <div class="form-message"></div>
                </div>

                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('billing_state', array(
                        'type'        => 'text',
                        'required'    => true,
                        'label'       => __('State / County', 'onmacabim'),
                        'class'       => ''
                    ), $user->billing_state);?>
                    <div class="form-message"></div>
                </div>

                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('billing_city', array(
                        'type'        => 'text',
                        'required'    => true,
                        'label'       => __('Town / City', 'onmacabim'),
                        'class'       => ''
                    ), $user->billing_city);?>
                    <div class="form-message"></div>
                </div>

                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('billing_postcode', array(
                        'type'        => 'text',
                        'required'    => true,
                        'label'       => __('Postcode / ZIP', 'onmacabim'),
                        'class'       => ''
                    ), $user->billing_postcode);?>
                    <div class="form-message"></div>
                </div>

                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('billing_address_1', array(
                        'type'        => 'text',
                        'required'    => true,
                        'label'       => __('Street address', 'onmacabim'),
                        'class'       => ''
                    ), $user->billing_address_1);?>
                    <div class="form-message"></div>
                </div>
            </div>
        </div>

        <div class="salon-address">
            <h3 class="salon-address__title"><?php _e('Salon / Clinic Address', 'onmacabim'); ?></h3>
            <div class="salon-address__wrapper form-group-wrapper">
                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('salon_city', array(
                        'type'        => 'text',
                        'required'    => true,
                        'label'       => __('Town / City', 'onmacabim'),
                        'class'       => ''
                    ), get_the_author_meta('city_salon', $user->ID));?>
                    <div class="form-message"></div>
                </div>
                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('salon_address_1', array(
                        'type'        => 'text',
                        'required'    => true,
                        'label'       => __('Street address', 'onmacabim'),
                        'class'       => ''
                    ), get_the_author_meta('address_salon', $user->ID));?>
                    <div class="form-message"></div>
                </div>
                <div class="woocommerce-address-fields__field-wrapper required-field form-group">
                    <?php $customer = new WC_Customer($user->ID);
                    woocommerce_form_field('salon_utr', array(
                        'type'        => 'text',
                        'required'    => true,
                        'label'       => __('UTR (TIN)', 'onmacabim'),
                        'class'       => ''
                    ), get_the_author_meta('utr', $user->ID));?>
                    <div class="form-message"></div>
                </div>

                <div class="certificate-wrapper">
                    <h3><?php _e('Photo of a document confirming the completion of courses or getting an education', 'onmacabim'); ?></h3>
                    <p class="certificate-wrapper__par">
                        <a target="_blank" href="<?php echo get_the_author_meta('certificate_link', $user->ID); ?>"><?php esc_html_e('Download downloaded file', 'onmacabim'); ?></a>
                    </p>
                    <label class="certificate" id="certificate" for="files"
                           title="Allowed filetypes: *.pdf, *.doc, *.docx, *.jpg, *.png. Maximum filesize: 20Mb. ">
                        <input type="file" id="files" name="certificate"
                               accept="image/jpg, image/jpeg , image/png, application/pdf, application/msword">
                    </label>
                    <div class="file-error"></div>
                </div>
            </div>
        </div>

        <?php do_action('woocommerce_edit_account_form'); ?>

        <div>
            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
            <button type="submit" class="btn save-change-button"
                    name="save_account_details" disabled="disabled"
                    value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
            <input type="hidden" name="action" value="save_account_details"/>
        </div>

        <?php do_action('woocommerce_edit_account_form_end'); ?>
    </form>

</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
