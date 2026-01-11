function showError(inputId, errorId, msg) {
  const input = document.getElementById(inputId);
  const err = document.getElementById(errorId);
  if (input) input.classList.add("error");
  if (input) input.classList.remove("success");
  if (err) {
    err.innerText = msg;
    err.style.display = "block";
  }
}

function showSuccess(inputId, errorId) {
  const input = document.getElementById(inputId);
  const err = document.getElementById(errorId);
  if (input) input.classList.remove("error");
  if (input) input.classList.add("success");
  if (err) err.style.display = "none";
}

function validEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validPhone(phone) {
  return /^[0-9]{10,15}$/.test(phone);
}


function hasLetter(str) {
  for (let i = 0; i < str.length; i++) {
    const c = str.charCodeAt(i);
    const isUpper = (c >= 65 && c <= 90);
    const isLower = (c >= 97 && c <= 122);
    if (isUpper || isLower) return true;
  }
  return false;
}

function hasDigit(str) {
  for (let i = 0; i < str.length; i++) {
    const c = str.charCodeAt(i);
    if (c >= 48 && c <= 57) return true;
  }
  return false;
}

function hasSpecial(str) {
  for (let i = 0; i < str.length; i++) {
    const c = str.charCodeAt(i);
    const isUpper = (c >= 65 && c <= 90);
    const isLower = (c >= 97 && c <= 122);
    const isDigit = (c >= 48 && c <= 57);
    if (!(isUpper || isLower || isDigit)) return true;
  }
  return false;
}

function togglePassword(id) {
  const el = document.getElementById(id);
  if (!el) return;
  el.type = (el.type === "password") ? "text" : "password";
}

function checkStrength(pass) {
  const bar = document.getElementById("strength");
  if (!bar) return;
  let score = 0;
  if (pass.length >= 8) score++;
  if (hasLetter(pass)) score++;
  if (hasDigit(pass)) score++;
  if (hasSpecial(pass)) score++;

  // just basic width (no fancy colors)
  bar.style.width = (score * 25) + "%";
}


/* Registration validation */
async function registerValidate() {
  let ok = true;

  const fname = document.getElementById("regFname").value.trim();
  const lname = document.getElementById("regLname").value.trim();
  const email = document.getElementById("regEmail").value.trim();
  const phone = document.getElementById("regPhone").value.trim();
  const dob   = document.getElementById("regDob").value.trim();
  const pass  = document.getElementById("regPass").value;

  if (!fname) { showError("regFname", "regFnameError", "First name required"); ok = false; }
  else showSuccess("regFname", "regFnameError");

  if (!lname) { showError("regLname", "regLnameError", "Last name required"); ok = false; }
  else showSuccess("regLname", "regLnameError");

  if (!email) { showError("regEmail", "regEmailError", "Email required"); ok = false; }
  else if (!validEmail(email)) { showError("regEmail", "regEmailError", "Invalid email format"); ok = false; }
  else showSuccess("regEmail", "regEmailError");

  if (!phone) { showError("regPhone", "regPhoneError", "Phone required"); ok = false; }
  else if (!validPhone(phone)) { showError("regPhone", "regPhoneError", "Phone must be 10-15 digits"); ok = false; }
  else showSuccess("regPhone", "regPhoneError");

  if (!dob) { showError("regDob", "regDobError", "Date of birth required"); ok = false; }
  else showSuccess("regDob", "regDobError");

  if (!pass) { showError("regPass", "regPassError", "Password required"); ok = false; }
  else if (pass.length < 8) { showError("regPass", "regPassError", "Minimum 8 characters"); ok = false; }
  else if (!(hasLetter(pass) && hasDigit(pass))) { showError("regPass", "regPassError", "Must include letters & numbers"); ok = false; }
  else showSuccess("regPass", "regPassError");

  // duplicate email check (only if basic email ok)
  if (ok) {
    const exists = await checkEmailExists(email);
    if (exists) {
      showError("regEmail", "regEmailError", "Email already exists");
      ok = false;
    }
  }

  return ok;
}

/* Login validation */
async function loginValidate() {
  let ok = true;
  const email = document.getElementById("logEmail").value.trim();
  const pass  = document.getElementById("logPass").value;

  if (!email) { showError("logEmail", "logEmailError", "Email required"); ok = false; }
  else if (!validEmail(email)) { showError("logEmail", "logEmailError", "Invalid email"); ok = false; }
  else showSuccess("logEmail", "logEmailError");

  if (!pass) { showError("logPass", "logPassError", "Password required"); ok = false; }
  else showSuccess("logPass", "logPassError");

  // If user hasn't registered, show popup
  if (ok) {
    const exists = await checkEmailExists(email);
    if (!exists) {
      openPopup("No account found. Please register first.");
      ok = false;
    }
  }

  return ok;
}

/* Forgot validation */
async function forgotValidate() {
  let ok = true;
  const email = document.getElementById("forEmail").value.trim();
  const pass  = document.getElementById("forPass").value;

  if (!email) { showError("forEmail", "forEmailError", "Email required"); ok = false; }
  else if (!validEmail(email)) { showError("forEmail", "forEmailError", "Invalid email"); ok = false; }
  else showSuccess("forEmail", "forEmailError");

  if (!pass) { showError("forPass", "forPassError", "New password required"); ok = false; }
  else if (pass.length < 8) { showError("forPass", "forPassError", "Minimum 8 characters"); ok = false; }
  else if (!(hasLetter(pass) && hasDigit(pass))) { showError("forPass", "forPassError", "Must include letters & numbers"); ok = false; }
  else showSuccess("forPass", "forPassError");

  if (ok) {
    const exists = await checkEmailExists(email);
    if (!exists) {
      openPopup("No account found with this email.");
      ok = false;
    }
  }

  return ok;
}

/* Popup */
function openPopup(msg) {
  const pop = document.getElementById("popup");
  const text = document.getElementById("popupText");
  if (text) text.innerText = msg;
  if (pop) pop.style.display = "flex";
}
function closePopup() {
  const pop = document.getElementById("popup");
  if (pop) pop.style.display = "none";
}
