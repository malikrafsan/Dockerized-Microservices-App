const lib = new Lib();

let isEmailValid = true;
let isUsernameValid = true;

function changeBorderColor(element, color) {
  element.style.border = "2px solid " + color;
  element.style.outlineColor = color;
}

function changeFontColor(element, color) {
  element.style.color = color;
}

function checkRegister() {
  if (isEmailValid && isUsernameValid) {
    document.getElementById("submit-button").disabled = false;
  } else {
    document.getElementById("submit-button").disabled = true;
  }
}

async function checkUsername() {
  errorTag = document.getElementById("username-error");
  inputTag = document.getElementById("input-username");
  value = inputTag.value;

  const payload = {
    username: value
  }

  const res = await lib.post('/api/auth/check-username', payload);
  const data = JSON.parse(res);

  errorElmt = document.getElementById("username-error");
  if (data.success) {
    if (data.data) {
      // terdapat username yang sama
      errorElmt.innerText = "Username already exists!";
      isUsernameValid = false;
      changeBorderColor(inputTag, "red");
      changeFontColor(errorTag, "red");
    } else {
      errorElmt.innerText = "Username available";
      isUsernameValid = true;
      changeBorderColor(inputTag, "green");
      changeFontColor(errorTag, "green");
    }
  }
  checkRegister();
}

async function checkEmail() {
  errorTag = document.getElementById("email-error");
  inputTag = document.getElementById("input-email");
  value = inputTag.value;

  const res = await lib.post('/api/auth/check-email', {
    "email": value
  });
  const data = JSON.parse(res);

  errorElmt = document.getElementById("email-error");
  if (data.success) {
    if (data.data) {
      // terdapat username yang sama
      errorElmt.innerText = "Email already exists!";
      isEmailValid = false;
      changeBorderColor(inputTag, "red");
      changeFontColor(errorTag, "red");
    } else {
      errorElmt.innerText = "Email available";
      isEmailValid = true;
      changeBorderColor(inputTag, "green");
      changeFontColor(errorTag, "green");
    }
  }
  checkRegister();
}

function validateEmail() {
  errorTag = document.getElementById("email-error");
  inputTag = document.getElementById("input-email");
  value = inputTag.value;

  emailExpression = /^[\w]+@[\w]+(.[\w]+){0,}\.[\w]+$/;

  errorElmt = document.getElementById("email-error");
  if (value.match(emailExpression)) {
    errorElmt.innerText = "";
    checkEmail();
  } else {
    errorElmt.innerText = "Not a valid email!";
    isEmailValid = false;
    changeBorderColor(inputTag, "red");
    changeFontColor(errorTag, "red");
  }
  checkRegister();
}

async function submitRegister(e) {
  e.preventDefault();

  const nama = document.getElementById('input-nama').value;
  const username = document.getElementById('input-username').value;
  const email = document.getElementById('input-email').value;
  const password = document.getElementById('input-password').value;
  const confirmPassword = document.getElementById('input-confirm-password').value;

  const data = {
    nama,
    username,
    email,
    password,
    "confirm-password": confirmPassword
  }

  const res = await lib.post('/api/auth/register', data);
  const json = JSON.parse(res);

  if (json.success === false) {
    alert(json.message);
  } else {
    window.location.href = "/";
  }
}

const usernameChange = lib.debounce(() => checkUsername());
const emailChange = lib.debounce(() => validateEmail());