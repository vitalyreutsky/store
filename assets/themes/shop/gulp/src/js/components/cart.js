document.addEventListener("DOMContentLoaded", () => {
  const btnsToCart = document.querySelectorAll(".add-to-cart");
  const btnsInCart = document.querySelectorAll(".remove-from-cart");

  btnsToCart.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      let id = btn.getAttribute("data-product_id");
      let quantity = btn.getAttribute("data-quantity");
      btn.classList.add("in-cart");

      btn.nextElementSibling.classList.add("show");

      addToCart(id, quantity);
    });
  });

  btnsInCart.forEach((btn) => {
    btn.addEventListener("click", (e) => {
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
        "Content-Type": "application/x-www-form-urlencoded",
      }),
      body: `action=addProductToCart&id=${id}&quantity=${quantity}`,
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
        "Content-Type": "application/x-www-form-urlencoded",
      }),
      body: `action=removeProductFromCart&id=${id}`,
    });

    const data = await response.json();

    if (data) {
      setCountInCart(+data);
    }

    if (data == 0) {
      console.log(false);
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
