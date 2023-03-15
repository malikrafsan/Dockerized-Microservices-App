const login = async (e) => {
  e.preventDefault();

  const email_uname = document.getElementById('email_uname').value;
  const password = document.getElementById('password').value;

  const data = {
    email_uname,
    password
  };

  const lib = new Lib();
  const res = await lib.post('/api/auth/login', data);
  const json = JSON.parse(res);
  console.log(json);

  if (json.success) {
    window.location.href = '/';
  } else {
    alert(json.message);
  }
}

async function checkIfUsernameEmpty() {
  value = document.getElementById("email_uname").value;
  if (value == "") {
    errorElmt = document.getElementById("username-error");
    errorElmt.innerText = "Please enter your SoundClown username or email address.";
  } else {
    errorElmt = document.getElementById("username-error");
    errorElmt.innerText = "";
  }
}
async function checkIfPasswordEmpty() {
  value = document.getElementById("password").value;
  if (value == "") {
    errorElmt = document.getElementById("password-error");
    errorElmt.innerText = "Please enter your password.";
  } else {
    errorElmt = document.getElementById("password-error");
    errorElmt.innerText = "";
  }
}

const unameChange = () => {
  checkIfUsernameEmpty();
}
const passwordChange = () => {
  checkIfPasswordEmpty();
}