console.log("JS loaded")
document.addEventListener("DOMContentLoaded", function () {
  const strengthBar = document.querySelector("#password-strength div");
  const strengthText = document.querySelector("#password-strength span");
  const saveButton = document.getElementById("save-password-btn");
  const requirementsList = document.querySelectorAll("#password-requirements li");
  const errorMessage = document.createElement("p");

  // Insert error message below confirm password field
  errorMessage.textContent = "Passwords do not match";
  errorMessage.classList.add("text-red-500", "text-sm", "mt-2", "hidden");
  document.querySelector("#confirm-password-field").appendChild(errorMessage);

  /** 👁️ Toggle password visibility */
  const toggleButtons = document.querySelectorAll(
    "#current-password-field button, #new-password-field button, #confirm-password-field button"
  );
  toggleButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const input = this.previousElementSibling;
      input.type = input.type === "password" ? "text" : "password";
      this.innerHTML = input.type === "password"
        ? '<i class="fa-regular fa-eye"></i>'
        : '<i class="fa-regular fa-eye-slash"></i>';
    });
  });

  /** 🔍 Password strength check */
  function checkPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength += 1;
    if (password.match(/[A-Z]/)) strength += 1;
    if (password.match(/[a-z]/)) strength += 1;
    if (password.match(/\d/)) strength += 1;
    if (password.match(/[!@#$%^&*(),.?":{}|<>]/)) strength += 1;

    return {
      percent: [20, 40, 60, 80, 100][strength - 1] || 0,
      label: ["Very Weak", "Weak", "Moderate", "Strong", "Very Strong"][strength - 1] || "Very Weak",
      color: ["#f87171", "#f97316", "#facc15", "#4ade80", "#16a34a"][strength - 1] || "#f87171",
      valid: strength === 5
    };
  }

  /** ✅ Validation logic */
  function validatePassword() {
    const password = document.getElementById("new-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;
    const currentPassword = document.getElementById("current-password").value.trim();
    const strength = checkPasswordStrength(password);
    let allValid = true;

    // Update strength bar
    strengthBar.style.width = `${strength.percent}%`;
    strengthBar.style.backgroundColor = strength.color;
    strengthText.textContent = strength.label;
    strengthText.style.color = strength.color;

    // Check requirements
    const conditions = [
      { regex: /.{8,}/, element: requirementsList[0] },
      { regex: /(?=.*[a-z])(?=.*[A-Z])/, element: requirementsList[1] },
      { regex: /\d/, element: requirementsList[2] },
      { regex: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/, element: requirementsList[3] },
    ];

    conditions.forEach(({ regex, element }) => {
      if (regex.test(password)) {
        element.innerHTML = `<i class="fa-solid fa-check text-green-500"></i> ${element.textContent.trim()}`;
      } else {
        element.innerHTML = `<i class="fa-solid fa-xmark text-red-500"></i> ${element.textContent.trim()}`;
        allValid = false;
      }
    });

    // Password match check
    if (password !== confirmPassword || password === "") {
      errorMessage.classList.remove("hidden");
      allValid = false;
    } else {
      errorMessage.classList.add("hidden");
    }

    if (!currentPassword) {
      allValid = false;
    }

    // Toggle save button
    if (allValid) {
      saveButton.disabled = false;
      saveButton.classList.remove("bg-gray-400", "cursor-not-allowed");
      saveButton.classList.add("bg-blue-600", "hover:bg-blue-700");
    } else {
      saveButton.disabled = true;
      saveButton.classList.remove("bg-blue-600", "hover:bg-blue-700");
      saveButton.classList.add("bg-gray-400", "cursor-not-allowed");
    }
  }

  // Live validation
  document.getElementById("new-password").addEventListener("input", validatePassword);
  document.getElementById("confirm-password").addEventListener("input", validatePassword);

  /** 🔐 Submit to backend */
  saveButton.addEventListener("click", async () => {
    if (saveButton.disabled) return;

    const currentPassword = document.getElementById("current-password").value;
    const newPassword = document.getElementById("new-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    // Loading UI
    saveButton.disabled = true;
    saveButton.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Saving...';

    try {
      const response = await fetch("../php/update_password.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ currentPassword, newPassword, confirmPassword }),
      });

      const result = await response.json();

      if (result.status === "success") {
        showToast("Password updated successfully!", "success");
        setTimeout(() => {
          window.location.href = "settings.php";
        }, 2000);
      } else {
        showToast(result.message || "Failed to update password", "error");
        saveButton.disabled = false;
        saveButton.innerHTML = "Save Changes";
      }
    } catch (err) {
      showToast("Something went wrong!", "error");
      saveButton.disabled = false;
      saveButton.innerHTML = "Save Changes";
    }
  });
});
