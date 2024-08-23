export function validationForm(form) {
  let form_groups = form.querySelectorAll(".form-group");
  let error_check = false;

  form_groups.forEach((index) => {
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
