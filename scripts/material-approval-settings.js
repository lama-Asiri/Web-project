document.addEventListener("DOMContentLoaded", () => {
  const settingsBtn = document.getElementById("settings-btn");

  const headerPic = document.getElementById("header-profile-img");
  // تحميل البيانات من الخادم
  fetch("../php/get_profile.php")
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              if (data.photo) {
                  headerPic.src = data.photo;
              } else {
                  headerPic.src = "../images/avtar.png";
              }
          }
      });
  if (settingsBtn) {
      settingsBtn.addEventListener("click", () => {
          window.location.href = "../php/settings.php";
      });
  }
});
