document.addEventListener("DOMContentLoaded", function () {
  // عناصر واجهة المستخدم
  const changePasswordLink = document.getElementById("change-password-link");
  const cancelButton = document.querySelector("#action-buttons button:last-child");
  const settingsBtn = document.getElementById("settings-btn");

  const profilePic = document.getElementById("profile-picture");
  const headerPic = document.getElementById("header-profile-img");
  const photoUpload = document.getElementById("photo-upload");
  const changePhotoBtn = document.getElementById("change-photo-btn");
  const saveProfileBtn = document.getElementById("save-profile-btn");
  const displayNameInput = document.getElementById("display-name-input");
  const successNotification = document.getElementById("success-notification");
  const nameWarning = document.getElementById("name-warning");

  const twoFactorToggle = document.getElementById("two-factor-toggle");
  const emailNotificationToggle = document.querySelector("#preferences-content .toggle-switch");
  const deleteAccountBtn = document.getElementById("delete-account-btn");


  // تحميل البيانات من الخادم
  fetch("../php/get_profile.php")
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        if (data.photo) {
          profilePic.src = data.photo;
          headerPic.src = data.photo;
        } else {
            headerPic.src = "../images/avtar.png";
            profilePic.src = "../images/avtar.png";
        }
        if (data.name) {
          displayNameInput.value = data.name;
        }
        if (data.two_factor_enabled) {
          twoFactorToggle.classList.remove("bg-gray-200");
          twoFactorToggle.classList.add("bg-blue-600");
          twoFactorToggle.querySelector("span").classList.add("translate-x-5");
        }
        if (data.notification_enabled) {
          emailNotificationToggle.classList.remove("bg-gray-200");
          emailNotificationToggle.classList.add("bg-blue-600");
          emailNotificationToggle.querySelector("span").classList.add("translate-x-5");
        }
      }
    });

  // التبديل بين الأقسام
  document.querySelectorAll(".toggle-btn").forEach((button) => {
    button.addEventListener("click", function () {
      let targetId = this.getAttribute("data-target");
      let target = document.getElementById(targetId);
      if (!target) return;

      if (target.classList.contains("hidden")) {
        target.classList.remove("hidden");
        target.style.maxHeight = target.scrollHeight + "px";
      } else {
        target.classList.add("hidden");
        target.style.maxHeight = null;
      }
      
      

      const chevronIcon = this.querySelector("i.fa-chevron-down");
      if (chevronIcon) {
        chevronIcon.classList.toggle("rotate-180");
      }
    });
  });

  // تحديث الاسم والصورة
  saveProfileBtn.addEventListener("click", function () {
    const name = displayNameInput.value.trim();
    const photo = photoUpload.files[0];

    if (name === "") {
      nameWarning.classList.remove("hidden");
      return;
    }
    nameWarning.classList.add("hidden");

    const formData = new FormData();
    formData.append("display_name", name);
    if (photo) formData.append("profile_photo", photo);

    fetch("../php/update_profile.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.text())
      .then(text => {
        try {
          const data = JSON.parse(text);
          if (data.success) {
            successNotification.classList.remove("hidden");
            setTimeout(() => {
              successNotification.classList.add("hidden");
            }, 3000);
          } else {
            showToast(data.error || "Something went wrong", "error");
          }
        } catch (err) {
          console.error("❌ Failed to parse JSON:", text);
          showToast("Unexpected error. Try again.", "error");
        }
      });
    
  });

  // تغيير الصورة
  changePhotoBtn.addEventListener("click", () => photoUpload.click());
  photoUpload.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        profilePic.src = e.target.result;
        headerPic.src = e.target.result;
      };

      reader.readAsDataURL(file);
    }
  });

  // المصادقة الثنائية
  twoFactorToggle.addEventListener("click", function () {
    const isActive = this.classList.toggle("bg-blue-600");
    this.classList.toggle("bg-gray-200", !isActive);

    const enabled = isActive ? 1 : 0;

    this.querySelector("span").classList.toggle("translate-x-5");

    fetch("../php/update_two_factor.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ enabled })
    }).then(res => res.json())
      .then(data => {
        if (data.success) {
          if (enabled === 1) {
            showToast("Two-factor authentication has been successfully activated.", "success");
          } else {
            showToast("Two-factor authentication has been successfully deactivated.", "success");
          }
        } else {
          showToast("Failed to update two-factor authentication.", "error");
        }
      });
  });

  // تفعيل الإشعارات
  emailNotificationToggle.addEventListener("click", function () {
    const isActive = this.classList.toggle("bg-blue-600");
    this.classList.toggle("bg-gray-200", !isActive);

    const enabled = isActive ? 1 : 0;
    
    this.querySelector("span").classList.toggle("translate-x-5");

    fetch("../php/update_notifications.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ enabled })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          if (enabled === 1) {
            showToast("Notifications have been successfully activated.", "success");
          } else {
            showToast("Notifications have been successfully deactivated.", "success");
          }
        } else {
          showToast("Failed to update notifications.", "error");
        }
      });
  });

  // حذف الحساب
  deleteAccountBtn.addEventListener("click", function () {
    if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
      fetch("../php/delete_account.php", { method: "POST" })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            showToast("Your account has been deleted.", "success");
            setTimeout(() => {
              window.location.href = "login.php";
            }, 3000);
          } else {
            showToast(data.error || "Something went wrong. Please try again.", "error");
          }
        });
    }
  });
  

  // التوجيه
  if (changePasswordLink) changePasswordLink.addEventListener("click", () => window.location.href = "password.php");
  if (cancelButton) cancelButton.addEventListener("click", () => window.location.href = "settings.php");
  if (settingsBtn) settingsBtn.addEventListener("click", () => window.location.href = "settings.php");
});
