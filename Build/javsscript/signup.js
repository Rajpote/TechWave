const togglePassword = document.getElementById("togglePassword");
const passwordField = document.getElementById("passwordField");
const toggleIcon = document.getElementById("toggleIcon");

togglePassword.addEventListener("click", function () {
   const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
   passwordField.setAttribute("type", type);
   toggleIcon.classList.toggle("fa-eye");
   toggleIcon.classList.toggle("fa-eye-slash");
});

// signup validation
document.getElementById("uname").addEventListener("input", function () {
   const uname = this.value.trim();
   const unameError = document.getElementById("unameError");
   if (uname === "") {
      unameError.textContent = "Please enter your User Name.";
   } else {
      unameError.textContent = "";
   }
});

document.getElementById("phnumber").addEventListener("input", function () {
   const phnumber = this.value.trim();
   const phnumberError = document.getElementById("phnumberError");

   if (phnumber === "") {
      phnumberError.textContent = "enter your Phone Number.";
   } else if (!isValidPhoneNumber(phnumber)) {
      phnumberError.textContent = "enter a valid Phone Number.";
   } else {
      phnumberError.textContent = "";
   }
});

function isValidPhoneNumber(phnumber) {
   // Regular expression to allow only numbers
   const regex = /^[0-9]*$/;
   return regex.test(phnumber);
}

document.getElementById("email").addEventListener("input", function () {
   const email = this.value.trim();
   const emailError = document.getElementById("emailError");
   if (email === "") {
      emailError.textContent = "Please enter your Email.";
   } else if (!isValidEmail(email)) {
      emailError.textContent = "Please enter a valid Email.";
   } else {
      emailError.textContent = "";
   }
});

document.getElementById("passwordField").addEventListener("input", function () {
   const password = this.value.trim();
   const passwordError = document.getElementById("passwordError");
   if (password === "") {
      passwordError.textContent = "Please enter your Password.";
   } else if (password.length < 6) {
      passwordError.textContent = "Password must be at least 6 characters long.";
   } else {
      passwordError.textContent = "";
   }
});

function isValidEmail(email) {
   // This function checks if the email format is valid
   const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
   return regex.test(email);
}
