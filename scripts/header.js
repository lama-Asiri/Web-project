const publicHeader = `
  <header id="header" class="bg-white shadow-md" role="banner">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-8">
        <h1 class="text-2xl font-bold text-blue-600">EduHub</h1>
        <nav class="hidden md:flex space-x-6" role="navigation" aria-label="Main navigation">
          <a href="../php/welcome.php" class="nav-link text-gray-600 hover:text-blue-600">Home</a>
          <a href="../php/faq.php" class="nav-link text-gray-600 hover:text-blue-600">FAQ</a>
        </nav>
      </div>
      <div class="flex items-center space-x-4">
        <a href="../php/login.php" class="nav-link text-gray-600 hover:text-blue-600 font-medium">Login</a>
        <a href="../php/signup.php"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
          Sign Up
        </a>
        <button id="theme-toggle" aria-label="Toggle Dark Mode" class="text-gray-600 hover:text-blue-600 text-xl">
          <i id="theme-icon" class="fa-regular fa-moon"></i>
        </button>
      </div>
    </div>
  </header>
`;

const privateHeader = `
  <header id="header" class="bg-white shadow-md" role="banner">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-8">
        <h1 class="text-2xl font-bold text-blue-600">EduHub</h1>
        <nav class="hidden md:flex space-x-6" role="navigation" aria-label="Main navigation">
          <a href="../php/home.php" class="nav-link text-gray-600 hover:text-blue-600">Home</a>
          <a href="../php/metrials-student.php" class="nav-link text-gray-600 hover:text-blue-600">Materials</a>
          <a href="../php/faq.php" class="nav-link text-gray-600 hover:text-blue-600">FAQ</a>
        </nav>
      </div>
      <div class="flex items-center space-x-4">
        <button aria-label="Notifications" class="text-gray-600 hover:text-blue-600">
          <i class="fa-regular fa-bell text-xl"></i>
        </button>
        <button id="theme-toggle" aria-label="Toggle Dark Mode" class="text-gray-600 hover:text-blue-600 text-xl">
          <i id="theme-icon" class="fa-regular fa-moon"></i>
        </button>
        <button id="settings-btn" aria-label="Settings" class="text-gray-600 hover:text-blue-600">
                        <i class="fa-solid fa-cog text-xl"></i>
                    </button>
        <img id="header-profile-img" class="w-10 h-10 rounded-full" src="../images/avtar.png" alt="Profile image" />
      </div>
    </div>
  </header>
`;

document.addEventListener("DOMContentLoaded", () => {
  const headerContainer = document.getElementById('header');

  if (!headerContainer) {
    console.warn("⚠️ Could not find element with ID 'header-container'. Make sure it's in your HTML.");
    return;
  }

  console.log("🔍 Fetching login status...");

  fetch('../php/Faq-cont.php?checkLogin=true', {
    method: 'GET',
    credentials: 'include'
  })

    .then(response => {
      console.log("📬 Received response:", response);
      if (!response.ok) throw new Error("Bad response from server: " + response.status);
      return response.json();
    })
    .then(data => {
      console.log("✅ Login status data:", data);
      if (data.isLoggedIn) {
        console.log("🙋‍♂️ User is logged in — injecting privateHeader.");
        headerContainer.innerHTML = privateHeader;
      } else {
        console.log("👤 User is NOT logged in — injecting publicHeader.");
        headerContainer.innerHTML = publicHeader;
      }
    
      // ✅ Re-run the theme setup after header injection
      setTimeout(() => {
        if (typeof setupThemeToggle === 'function') {
          setupThemeToggle();
        } else {
          console.warn("⚠️ setupThemeToggle() not found.");
        }
      
        // ✅ Add this: settings redirect
        const settingsBtn = document.getElementById("settings-btn");
        if (settingsBtn) {
          settingsBtn.addEventListener("click", () => {
            window.location.href = "../php/settings.php"; // ✅ Update path if needed
          });
        } else {
          console.warn("⚠️ settings-btn not found.");
        }
      }, 0);
      
    })
    
    .catch(error => {
      console.error("❌ Failed to fetch login status:", error);
      console.log("🔁 Using fallback: publicHeader.");
      headerContainer.innerHTML = publicHeader;
    });
});
