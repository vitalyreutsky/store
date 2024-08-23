import { validationForm } from "../functions/validation-form.js";

const globalForm = document.querySelector("form");
const registerSubmitForm = document.querySelector(".register-submit-form");
const registrationSuccessMessage = document.querySelector(
  ".registration-success-message"
);

registerSubmitForm.addEventListener("click", (e) => {
  let form = e.target.closest("form"),
    email = form.querySelector("#account_email"),
    emailWrap = email.parentElement;

  let form_data = new FormData(form);
  let form_data_result = JSON.stringify(Object.fromEntries(form_data));

  if (!validationForm(form)) {
    async function post(data) {
      const _domain = window.location.origin;
      const response = await fetch(`${_domain}/wp-admin/admin-ajax.php`, {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/x-www-form-urlencoded",
        }),
        body: `action=RegisterUser&form=${data}`,
      });

      return await response.json();
    }

    post(form_data_result).then((data) => {
      if (data.error === true) {
        switch (data.code) {
          case 0:
            alert("An error has occurred. Please reload the page");
            break;
          case 1:
            validationForm(form);
            break;
          case 2:
            emailWrap.classList.add("field-error");
            emailWrap.querySelector(".form-message").textContent =
              "Email already exists";
            break;
          default:
            validationForm(form);
            break;
        }
      } else {
        registrationSuccessMessage.classList.remove("is-hidden");
        globalForm.classList.add("is-hidden");
      }
    });
  }
});

$(document).on("click", ".login-submit-form", function () {
  let form = $(this).closest("form"),
    email = $("#login-email"),
    emailWrap = email.parent();

  if (!validationForm(form)) {
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        data: form.serialize(),
        action: "AuthorizeUser",
      },
      beforeSend: function () {
        form.css("opacity", ".5").css("pointer-events", "none");
      },
      success: function (data) {
        form.css("opacity", "1").css("pointer-events", "all");
        if (data.error === true) {
          switch (data.code) {
            case 0:
              alert("error_plz_reload");
              break;
            case 1:
              emailWrap
                .addClass("field-error")
                .find(".form-message")
                .text("correct_email");
              break;
            case 2:
              //checkRequired(form);
              validationForm(form);
              break;
            default:
              form.find(".required-field").each(function () {
                $(this).addClass("field-error");
              });
              emailWrap.find(".form-message").text("incorrect_email_password");
              break;
          }
        } else {
          window.location.href = `/my-account/`;
        }
      },
    });
  }
});

$(document).on("click", ".forgot-password-button", function () {
  let form = $(this).closest("form"),
    email = $("#forgot-email"),
    emailWrap = email.parent();

  if (!validationForm(form)) {
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        data: form.serialize(),
        action: "ForgotPassword",
      },
      beforeSend: function () {
        form.addClass("submitting");
        form.css("opacity", ".5").css("pointer-events", "none");
      },
      success: function (data) {
        form.removeClass("submitting");
        form.css("opacity", "1").css("pointer-events", "all");
        if (data.error === true) {
          switch (data.code) {
            case 0:
              alert("error_plz_reload");
              break;
            case 1:
              emailWrap
                .addClass("field-error")
                .find(".form-message")
                .text("user_not_found");
              break;
            case 2:
              emailWrap
                .addClass("field-error")
                .find(".form-message")
                .text("correct_email");
              break;
            default:
              form.find(".required-field").each(function () {
                $(this).addClass("field-error");
              });
              break;
          }
        } else {
          $(".reset-password-button").trigger("click");
        }
      },
    });
  }
});

$(document).on("click", ".reset-password-button", function () {
  $(".forgotPassword .before-send").addClass("is-hidden");
  $(".forgotPassword .after-send").removeClass("is-hidden");
});

$(document).on("click", ".btn.reset-password", function () {
  let form = $(this).closest("form"),
    notice = $(".password-wrapper-notice");
  $.ajax({
    url: "/wp-admin/admin-ajax.php",
    type: "POST",
    data: {
      data: form.serialize(),
      action: "ResetPassword",
    },
    beforeSend: function () {
      form.css("opacity", ".5").css("pointer-events", "none");
    },
    success: function (data) {
      form.css("opacity", "1").css("pointer-events", "all");
      if (data.error === true) {
        switch (data.code) {
          case 0:
            form.find("h6").addClass("error-pass");
            notice.text("reset_link");
            break;
          case 1:
            form.find("h6").addClass("error-pass");
            notice.text("passwords_dont_match");
            break;
          case 2:
            form.find("h6").addClass("error-pass");
            notice.text("minimum_characters");
            break;
        }
      } else {
        $(".new-password-wrapper").hide();
        $(".success-reset").show();
      }
    },
  });
});

$(document).on("input", ".form-onmacabim .field-error input", function () {
  $(this).closest(".form-group").removeClass("field-error");
  $(this).closest(".form-group").find(".form-message").text("");
});

$(document).on("click", ".loginForm .register", function () {
  $(".loginForm").addClass("is-hidden");
  $(".registrationForm").removeClass("is-hidden");
});

$(document).on("click", ".loginForm .forgot-password", function () {
  $(".loginForm").addClass("is-hidden");
  $(".forgotPassword").removeClass("is-hidden");
});

$(document).on("click", ".registrationForm .log-in", function () {
  $(".loginForm").removeClass("is-hidden");
  $(".registrationForm").addClass("is-hidden");
});

$(document).on("click", ".forgotPassword .back-to-login", function () {
  $(".loginForm").removeClass("is-hidden");
  $(".forgotPassword").addClass("is-hidden");
});

$(document).ready(function () {
  if ($("body").hasClass("page-template-registration-page")) {
    if (/action=lostpassword/.test(location.href)) {
      $(".registrationForm").addClass("is-hidden");
      $(".loginForm").addClass("is-hidden");
      $(".forgotPassword").removeClass("is-hidden");
    }
    if (/action=login/.test(location.href)) {
      $(".registrationForm").addClass("is-hidden");
      $(".loginForm").removeClass("is-hidden");
      $(".forgotPassword").addClass("is-hidden");
    }
    if (/action=registration/.test(location.href)) {
      $(".registrationForm").removeClass("is-hidden");
      $(".loginForm").addClass("is-hidden");
      $(".forgotPassword").addClass("is-hidden");
    }
  }
});
