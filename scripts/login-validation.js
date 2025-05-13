document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("login-form");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const emailError = document.getElementById("email-error");
  const passwordError = document.getElementById("password-error");
  const successMsg = document.getElementById("login-success");

  const isPasswordStrong = (pw) =>
    pw.length >= 8 &&
    /[A-Z]/.test(pw) &&
    /[0-9]/.test(pw) &&
    /[^A-Za-z0-9]/.test(pw);

  const validateEmail = (email) =>
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      console.log("Login form submitted.");

      // Reset errors
      emailError.classList.add("hidden");
      passwordError.classList.add("hidden");
      successMsg.classList.add("hidden");

      const emailVal = email.value.trim();
      const passwordVal = password.value.trim();
      let valid = true;

      if (!emailVal || !validateEmail(emailVal)) {
        emailError.textContent = "Please enter a valid email.";
        emailError.classList.remove("hidden");
        valid = false;
      }

      if (!isPasswordStrong(passwordVal)) {
        passwordError.textContent =
          "Password must be at least 8 characters, include a capital letter, number and symbol.";
        passwordError.classList.remove("hidden");
        valid = false;
      }

      if (valid) {
        ////////////////Start send data of User into php/login.php//////////////////////////////
        const formData = new FormData();
        formData.append("email", emailVal);
        formData.append("password", passwordVal);
        fetch("../php/process_login.php", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              showToast("User logged in!", "success");
              successMsg.classList.remove("hidden");
        
              setTimeout(() => {
                window.location.href = data.redirect;  // ✅ Use dynamic redirect from PHP
              }, 1500);
              
            } else {
              passwordError.textContent = data.message || "Invalid login.";
              passwordError.classList.remove("hidden");
            }
          })
          .catch((err) => {
            passwordError.textContent = "Login failed: " + err.message;
            passwordError.classList.remove("hidden");
            console.error("Login error:", err);
          });
        
          
        ////////////////End send data of User into php/login.php//////////////////////////////
      }

    });
  }
});
//TODO:php password check