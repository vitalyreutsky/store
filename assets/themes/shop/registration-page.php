<?php

/**
 * Template name: Registration page
 */

get_header();
?>

<div class="registration-container is-hidden registrationForm">
   <div class="wrapper">
      <h1 class="registration-container__title"><?php _e('Registration', 'onmacabim'); ?></h1>

      <div class="registration-success-message is-hidden">
         <div class="alert-message"><?php _e('Your account has been created and a verification link has been sent to the email address you entered. Note that you must verify the account by selecting the verification link when you get the email and then an administrator will activate your account before you can login.', 'onmacabim'); ?></div>
      </div>

      <form class="registration-form form-onmacabim" onsubmit="return false;" action="" data-type="registration" autocomplete="off">
         <div class="form-group-wrapper">
            <h2><?php _e('Personal data', 'onmacabim'); ?></h2>
            <div class="form-group-flex">
               <div class="form-group required-field">
                  <label for="register-first-name"><?php esc_html_e('First Name', 'onmacabim') ?></label>
                  <input type="text" name="register-first-name" id="account_first_name">
                  <div class="form-message"></div>
               </div>

               <div class="form-group required-field">
                  <label for="register-last-name"><?php esc_html_e('Last Name', 'onmacabim') ?></label>
                  <input type="text" name="register-last-name" id="account_last_name">
                  <div class="form-message"></div>
               </div>
            </div>

            <div class="form-group-flex">
               <div class="form-group required-field">
                  <label for="register-email"><?php esc_html_e('Email', 'onmacabim') ?></label>
                  <input type="email" name="register-email" id="account_email">
                  <div class="form-message"></div>
               </div>
               <div class="form-group required-field">
                  <label for="register-phone"><?php esc_html_e('Phone', 'onmacabim') ?></label>
                  <input type="text" name="register-phone" id="billing_phone">
                  <div class="form-message"></div>
               </div>
            </div>

            <div class="form-group-flex">
               <div class="form-group required-field">
                  <label for="register-password"><?php esc_html_e('Create password', 'onmacabim') ?></label>
                  <input type="password" name="register-password" autocomplete="false" class="password"
                     id="password_1">
                  <span class="toggle-password"></span>
                  <div class="form-message"></div>
               </div>
               <div class="form-group required-field">
                  <label for="register-password-2"><?php esc_html_e('Confirm password', 'onmacabim') ?></label>
                  <input type="password" name="register-password-2" autocomplete="false" class="confirm-password"
                     id="password_2">
                  <span class="toggle-password"></span>
                  <div class="form-message"></div>
                  <p class="match-passwords-error"></p>
               </div>
            </div>
         </div>

         <div class="form-group-wrapper">
            <h2><?php _e('Delivery address', 'onmacabim'); ?></h2>
            <div class="form-group-flex">
               <div class="form-group">
                  <label for="register-city"><?php esc_html_e('City', 'onmacabim') ?></label>
                  <input type="text" name="register-city" id="register_city">
                  <div class="form-message"></div>
               </div>
               <div class="form-group">
                  <label for="register-address"><?php esc_html_e('Address', 'onmacabim') ?></label>
                  <input type="text" name="register-address" id="register_address">
                  <div class="form-message"></div>
               </div>
            </div>
         </div>
         <div class="buttons-group">
            <button type="button" class="register-submit-form btn"><?php esc_html_e('Create an account', 'onmacabim') ?></button>
            <div class="already_register">
               <h6><?php esc_html_e('Already a member?', 'onmacabim') ?></h6> <a class="log-in"><?php esc_html_e('Log in', 'onmacabim') ?></a>
            </div>
         </div>
      </form>
   </div>
</div>


<div class="registration-container loginForm">
   <div class="wrapper">
      <h2 class="registration-container__title"><?php _e('Login', 'onmacabim'); ?></h2>
      <form class="login-form form-onmacabim" data-type="authorization" autocomplete="false">

         <div class="form-group-flex">
            <div class="form-group required-field">
               <label for="login-email"><?php esc_html_e('Email', 'onmacabim') ?></label>
               <input type="email" name="login-email" id="login_email">
               <div class="form-message"></div>
            </div>

            <div class="form-group required-field">
               <label for="login-password"><?php esc_html_e('Password ', 'onmacabim') ?></label>
               <input type="password" name="login-password" autocomplete="false" class="password"
                  id="login_password">
               <div class="form-message"></div>
            </div>

         </div>

         <div class="form-group d-flex form-button">
            <div class="checkbox">
               <input type="checkbox" id="check" name="check" class="filled">
               <label for="check"><?php esc_html_e('Remember me', 'onmacabim') ?></label>
            </div>
            <a class="forgot-password links-register"><?php esc_html_e('Forgot password?', 'onmacabim') ?></a>
         </div>

         <div class="buttons-group">
            <button type="button" class="login-submit-form btn"><?php esc_html_e('Login', 'onmacabim') ?></button>
            <div class="already_register">
               <h6><?php esc_html_e('Don’t have an account?', 'onmacabim') ?></h6> <a class="register"><?php esc_html_e('Registration', 'onmacabim') ?></a>
            </div>
         </div>
      </form>
   </div>
</div>

<div class="registration-container forgotPassword is-hidden">
   <div class="wrapper before-send">
      <h2 class="registration-container__title"><?php _e('Forgot password?', 'onmacabim'); ?></h2>
      <p class="subtitle"><?php _e('Enter your email address and we will send you futher access instructions.', 'onmacabim'); ?></p>
      <form class="form-onmacabim" action="" onsubmit="return false;">
         <div class="form-group required-field">
            <label for="forgot-email"><?php esc_html_e('Email', 'onmacabim') ?></label>
            <input type="email" name="forgot-email" id="forgot-email">
            <div class="form-message"></div>
         </div>
         <div class="buttons-group">
            <button class="forgot-password-button btn btn-primary" type="button"><?php _e('Reset password', 'onmacabim'); ?></button>
            <div class="already_register">
               <a class="back-to-login"><?php _e('Back to Login', 'onmacabim'); ?></a>
            </div>
         </div>
         <a class="reset-password-button" style="display: none">.</a>
      </form>
   </div>

   <div class="wrapper after-send is-hidden">
      <h2 class="registration-container__title"><?php _e('Check your Email', 'onmacabim'); ?></h2>
      <p class="subtitle"><?php _e('We have sent you the confirmation link to create a new password.', 'onmacabim'); ?></p>
   </div>
</div>

<?php
get_footer();
