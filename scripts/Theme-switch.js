// theme-switch.js
function setupThemeToggle() {
  const toggleBtn = document.getElementById("theme-toggle");
  const themeIcon = document.getElementById("theme-icon");
  const darkStyle = document.getElementById("dark-theme");

  if (!toggleBtn || !themeIcon || !darkStyle) {
    console.warn("⚠️ Theme toggle elements not found.");
    return;
  }

  // Initial theme check
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") {
    darkStyle.disabled = false;
    themeIcon.classList.replace("fa-moon", "fa-sun");
  }

  toggleBtn.addEventListener("click", () => {
    const isDark = darkStyle.disabled === false;

    darkStyle.disabled = isDark;
    localStorage.setItem("theme", isDark ? "light" : "dark");

    themeIcon.classList.toggle("fa-sun", !isDark);
    themeIcon.classList.toggle("fa-moon", isDark);
  });
}

// Run once DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  setupThemeToggle();
});
