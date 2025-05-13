document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("signup-form");
  const nameInput = document.getElementById("fullname");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  const confirmInput = document.getElementById("confirm-password");
  const agreeCheckbox = document.getElementById("agree");

  const nameError = document.getElementById("name-error");
  const emailError = document.getElementById("email-error");
  const passwordError = document.getElementById("password-error");
  const confirmError = document.getElementById("confirm-error");
  const agreeError = document.getElementById("agree-error");
  const successMsg = document.getElementById("signup-success");

  const isPasswordStrong = (password) => {
    return (
      password.length >= 8 &&
      /[A-Z]/.test(password) &&
      /[0-9]/.test(password) &&
      /[^A-Za-z0-9]/.test(password)
    );
  };

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    // Reset all errors
    nameError.classList.add("hidden");
    emailError.classList.add("hidden");
    passwordError.classList.add("hidden");
    confirmError.classList.add("hidden");
    agreeError.classList.add("hidden");
    successMsg.classList.add("hidden");

    let valid = true;

    if (!nameInput.value.trim()) {
      nameError.classList.remove("hidden");
      valid = false;
    }

    if (!emailInput.value.trim() || !emailInput.value.includes("@")) {
      emailError.classList.remove("hidden");
      valid = false;
    }

    if (!isPasswordStrong(passwordInput.value)) {
      passwordError.classList.remove("hidden");
      valid = false;
    }

    if (passwordInput.value !== confirmInput.value) {
      confirmError.classList.remove("hidden");
      valid = false;
    }

    if (!agreeCheckbox.checked) {
      agreeError.classList.remove("hidden");
      valid = false;
    }

    if (valid) {
      ////////////////Start send data of student into php/register.php//////////////////////////////
      const formData = new FormData();
      formData.append("username", nameInput.value);
      formData.append("email", emailInput.value);
      formData.append("password", passwordInput.value);
      formData.append("role", "student");

      fetch("../php/register.php", {
        method: "POST",
        body: formData
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            showToast("Account created successfully!", "success");
            successMsg.classList.remove("hidden");
            setTimeout(() => {
              window.location.href = "login.php";
            }, 1000);
          } else {
            showToast(data.message || "Registration failed", "error");
          }
        });
      ////////////////End send data of student into php/register.php//////////////////////////////
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const tForm = document.getElementById("teacher-form");

  const tName = document.getElementById("t-name");
  const tEmail = document.getElementById("t-email");
  const tPassword = document.getElementById("t-password");
  const tConfirm = document.getElementById("t-confirm");
  const tMajor = document.getElementById("t-major");
  const tDegree = document.getElementById("t-degree");
  const tCV = document.getElementById("t-cv");
  const tCert = document.getElementById("t-cert");
  const tAgree = document.getElementById("t-agree");
  const tBio = document.getElementById("t-bio");

  const tSuccess = document.getElementById("t-success");
  const show = (id) => document.getElementById(id).classList.remove("hidden");
  const hide = (id) => document.getElementById(id).classList.add("hidden");

  const isStrong = (pw) =>
    pw.length >= 8 &&
    /[A-Z]/.test(pw) &&
    /[0-9]/.test(pw) &&
    /[^A-Za-z0-9]/.test(pw);

  tForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Reset all errors
    [
      "t-name-error",
      "t-email-error",
      "t-password-error",
      "t-confirm-error",
      "t-major-error",
      "t-degree-error",
      "t-cv-error",
      "t-cert-error",
      "t-agree-error",
    ].forEach(hide);

    let valid = true;

    if (!tName.value.trim()) show("t-name-error"), (valid = false);
    if (!tEmail.value.trim() || !tEmail.value.includes("@"))
      show("t-email-error"), (valid = false);
    if (!isStrong(tPassword.value)) show("t-password-error"), (valid = false);
    if (tPassword.value !== tConfirm.value)
      show("t-confirm-error"), (valid = false);
    if (!tMajor.value) show("t-major-error"), (valid = false);
    if (!tDegree.value) show("t-degree-error"), (valid = false);
    if (!tCV.value) show("t-cv-error"), (valid = false);
    if (!tCert.value) show("t-cert-error"), (valid = false);
    if (!tAgree.checked) show("t-agree-error"), (valid = false);

    if (valid) {
      ////////////////Start send data of Teacher into php/register.php//////////////////////////////
      const formData = new FormData(tForm);
      formData.append("username", tName.value.trim()); // not "name"
      formData.append("email", tEmail.value.trim());
      formData.append("password", tPassword.value.trim());
      formData.append("role", "teacher");
      formData.append("major", tMajor.value);
      formData.append("degree", tDegree.value);
      formData.append("cv_file", tCV.files[0]);     // important: match the name expected by PHP
      formData.append("cert_file", tCert.files[0]); // same here
      formData.append("about", tBio.value);         // match expected name
      
      fetch("../php/register.php", {
        method: "POST",
        body: formData
      })
        .then(async (res) => {
          const text = await res.text();           // read raw response
          console.log("Raw PHP response text:", text); // print the error
          try {
            const data = JSON.parse(text);
            if (data.success) {
              showToast("Account created successfully!", "success");
              tSuccess.classList.remove("hidden");
              setTimeout(() => {
                window.location.href = "login.php";
              }, 1000);
            } else {
              showToast(data.message || "Registration failed", "error");
            }
          } catch (err) {
            console.error("❌ JSON Parse error:", err.message);
            showToast("PHP returned an error:\n" + text.slice(0, 200), "error");
          }
        })
        .catch((err) => {
          console.error("❌ Fetch failed:", err);
          showToast("Connection failed", "error");
        });
      
      ////////////////End send data of Teacher into php/register.php//////////////////////////////
    }
  });
});

