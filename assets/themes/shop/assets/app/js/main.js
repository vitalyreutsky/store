/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/_components.js":
/*!*******************************!*\
  !*** ./src/js/_components.js ***!
  \*******************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_remove_preload_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/remove-preload.js */ "./src/js/components/remove-preload.js");
/* harmony import */ var _components_auth_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/auth.js */ "./src/js/components/auth.js");
/* harmony import */ var _components_cart_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/cart.js */ "./src/js/components/cart.js");




/***/ }),

/***/ "./src/js/components/auth.js":
/*!***********************************!*\
  !*** ./src/js/components/auth.js ***!
  \***********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _functions_validation_form_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../functions/validation-form.js */ "./src/js/functions/validation-form.js");

const globalForm = document.querySelector("form");
const registerSubmitForm = document.querySelector(".register-submit-form");
const registrationSuccessMessage = document.querySelector(".registration-success-message");
registerSubmitForm.addEventListener("click", e => {
  let form = e.target.closest("form"),
    email = form.querySelector("#account_email"),
    emailWrap = email.parentElement;
  let form_data = new FormData(form);
  let form_data_result = JSON.stringify(Object.fromEntries(form_data));
  if (!(0,_functions_validation_form_js__WEBPACK_IMPORTED_MODULE_0__.validationForm)(form)) {
    async function post(data) {
      const _domain = window.location.origin;
      const response = await fetch(`${_domain}/wp-admin/admin-ajax.php`, {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/x-www-form-urlencoded"
        }),
        body: `action=RegisterUser&form=${data}`
      });
      return await response.json();
    }
    post(form_data_result).then(data => {
      if (data.error === true) {
        switch (data.code) {
          case 0:
            alert("An error has occurred. Please reload the page");
            break;
          case 1:
            (0,_functions_validation_form_js__WEBPACK_IMPORTED_MODULE_0__.validationForm)(form);
            break;
          case 2:
            emailWrap.classList.add("field-error");
            emailWrap.querySelector(".form-message").textContent = "Email already exists";
            break;
          default:
            (0,_functions_validation_form_js__WEBPACK_IMPORTED_MODULE_0__.validationForm)(form);
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
  if (!(0,_functions_validation_form_js__WEBPACK_IMPORTED_MODULE_0__.validationForm)(form)) {
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        data: form.serialize(),
        action: "AuthorizeUser"
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
              emailWrap.addClass("field-error").find(".form-message").text("correct_email");
              break;
            case 2:
              //checkRequired(form);
              (0,_functions_validation_form_js__WEBPACK_IMPORTED_MODULE_0__.validationForm)(form);
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
      }
    });
  }
});
$(document).on("click", ".forgot-password-button", function () {
  let form = $(this).closest("form"),
    email = $("#forgot-email"),
    emailWrap = email.parent();
  if (!(0,_functions_validation_form_js__WEBPACK_IMPORTED_MODULE_0__.validationForm)(form)) {
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        data: form.serialize(),
        action: "ForgotPassword"
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
              emailWrap.addClass("field-error").find(".form-message").text("user_not_found");
              break;
            case 2:
              emailWrap.addClass("field-error").find(".form-message").text("correct_email");
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
      }
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
      action: "ResetPassword"
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
    }
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

/***/ }),

/***/ "./src/js/components/cart.js":
/*!***********************************!*\
  !*** ./src/js/components/cart.js ***!
  \***********************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
document.addEventListener("DOMContentLoaded", () => {
  const btnsToCart = document.querySelectorAll(".add-to-cart");
  const btnsInCart = document.querySelectorAll(".remove-from-cart");
  btnsToCart.forEach(btn => {
    btn.addEventListener("click", e => {
      let id = btn.getAttribute("data-product_id");
      let quantity = btn.getAttribute("data-quantity");
      btn.classList.add("in-cart");
      btn.nextElementSibling.classList.add("show");
      addToCart(id, quantity);
    });
  });
  btnsInCart.forEach(btn => {
    btn.addEventListener("click", e => {
      let id = btn.getAttribute("data-product_id");
      btn.classList.remove("show");
      btn.previousElementSibling.removeAttribute("href");
      btn.previousElementSibling.classList.remove("in-cart");
      removeProductFromCart(id);
    });
  });
  async function addToCart(id, quantity) {
    const _domain = window.location.origin;
    const response = await fetch(`${_domain}/wp-admin/admin-ajax.php`, {
      method: "post",
      headers: new Headers({
        "Content-Type": "application/x-www-form-urlencoded"
      }),
      body: `action=addProductToCart&id=${id}&quantity=${quantity}`
    });
    const data = await response.json();
    if (data) {
      setCountInCart(+data);
    }
  }
  async function removeProductFromCart(id) {
    const _domain = window.location.origin;
    const response = await fetch(`${_domain}/wp-admin/admin-ajax.php`, {
      method: "post",
      headers: new Headers({
        "Content-Type": "application/x-www-form-urlencoded"
      }),
      body: `action=removeProductFromCart&id=${id}`
    });
    const data = await response.json();
    if (data) {
      setCountInCart(+data);
    }
  }
});
function setCountInCart(result) {
  const cart = document.querySelector(".header__cart");
  const cartCount = cart.querySelector("span");
  checkCart(result, cartCount);
  if (cart && cartCount) {
    cartCount.textContent = result;
  } else {
    cart.innerHTML = `
        <span>${result}</span>
        `;
  }
}
function checkCart(data, cart) {
  if (data == 0) {
    cart.classList.add("hide");
  } else {
    if (cart) cart.classList.remove("hide");
  }
}

/***/ }),

/***/ "./src/js/components/remove-preload.js":
/*!*********************************************!*\
  !*** ./src/js/components/remove-preload.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
window.addEventListener("load", () => {
  document.body.classList.remove("preload");
});

/***/ }),

/***/ "./src/js/functions/validation-form.js":
/*!*********************************************!*\
  !*** ./src/js/functions/validation-form.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   validationForm: () => (/* binding */ validationForm)
/* harmony export */ });
function validationForm(form) {
  let form_groups = form.querySelectorAll(".form-group");
  let error_check = false;
  form_groups.forEach(index => {
    if (index.classList.contains("required-field")) {
      let input = index.querySelector("input"),
        input_value = input.value,
        input_name = input.getAttribute("name"),
        error_message = index.querySelector(".form-message");
      if (input.getAttribute("type") == "text") {
        if (input_name.includes("phone")) {
          if (!check_phone_format(input_value)) {
            index.classList.add("field-error");
            error_message.textContent = "Please enter correct phone number";
            error_check = true;
          }
        } else {
          if (!input_value) {
            index.classList.add("field-error");
            error_message.textContent = "Field is empty";
            error_check = true;
          }
        }
      } else if (input.getAttribute("type") == "email") {
        if (!check_email_format(input_value)) {
          index.classList.add("field-error");
          error_message.textContent = "Please enter correct email";
          error_check = true;
        }
      } else if (input.getAttribute("type") == "password") {
        if (input_name.includes("password-2")) {
          if (input_value != input_name.includes("password-1").value) {
            index.classList.add("field-error");
            error_message.textContent = "Passwords don't match";
            error_check = true;
          }
        } else {
          let message = check_is_password_weak(input_value);
          if (message !== false) {
            index.classList.add("field-error");
            error_message.textContent = message;
            error_check = true;
          }
        }
      }
    }
  });
  return error_check;
}
function check_email_format(email) {
  let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,9})+$/;
  return !!email.match(mailformat);
}
function check_phone_format(phone) {
  let phone_format = /^[+]?[(]?[0-9]{3}[)]?[-s.]?[0-9]{3}[-s.]?[0-9]{4,10}$/im;
  return !!phone.match(phone_format);
}
function check_is_password_weak(pass) {
  if (pass.length < 8) {
    return "minimum_characters";
  }
  return false;
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_components.js */ "./src/js/_components.js");

/******/ })()
;
//# sourceMappingURL=main.js.map