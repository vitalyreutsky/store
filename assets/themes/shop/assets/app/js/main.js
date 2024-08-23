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
/* harmony import */ var _components_cart_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/cart.js */ "./src/js/components/cart.js");



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