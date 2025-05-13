document.addEventListener("DOMContentLoaded", function () {
    const headerContainer = document.getElementById("header");
  
    if (!headerContainer) {
      console.warn("⚠️ Could not find the #header element in the DOM.");
      return;
    }
  
    // 🧠 Check login status and inject header
    fetch('../php/Faq-cont.php?checkLogin=true', {
      method: 'GET',
      credentials: 'include'
    })
      .then(res => res.json())
      .then(data => {
        if (data.isLoggedIn) {
          headerContainer.innerHTML = typeof privateHeader !== 'undefined' ? privateHeader : "";
        } else {
          headerContainer.innerHTML = typeof publicHeader !== 'undefined' ? publicHeader : "";
        }
  
        // 🛠 Wait a frame before binding anything
        requestAnimationFrame(() => {
          // ✅ Theme toggle
          if (typeof setupThemeToggle === 'function') setupThemeToggle();
  
          // ✅ Settings button
          const settingsBtn = document.getElementById("settings-btn");
          if (settingsBtn) {
            settingsBtn.addEventListener("click", () => {
              window.location.href = "../php/settings.php";
            });
          }
  
          // ✅ Setup FAQ interactivity
          setupFAQPage();
        });
      })
      .catch(err => {
        console.error("❌ Login check failed", err);
        headerContainer.innerHTML = typeof publicHeader !== 'undefined' ? publicHeader : "";
  
        requestAnimationFrame(() => {
          if (typeof setupFAQPage === 'function') setupFAQPage();
        });
      });
  });
  
  // ✅ All FAQ toggle logic
  function setupFAQPage() {
    console.log("🎛️ Initializing FAQ interaction handlers...");
  
    const askQuestionBtn = document.getElementById("ask-question-btn");
    const askQuestionContent = document.getElementById("ask-question-content");
    const courseRelatedBtn = document.getElementById("course-related-btn");
    const courseRelatedContent = document.getElementById("course-related-content");
    const paymentRelatedBtn = document.getElementById("payment-related-btn");
    const paymentRelatedContent = document.getElementById("payment-related-content");
    const technicalSupportBtn = document.getElementById("technical-support-btn");
    const technicalSupportContent = document.getElementById("technical-support-content");
  
    askQuestionBtn?.addEventListener("click", () => {
      askQuestionContent.classList.toggle("hidden");
      askQuestionBtn.querySelector("i.fa-chevron-down")?.classList.toggle("rotate-180");
    });
  
    courseRelatedBtn?.addEventListener("click", () => {
      courseRelatedContent.classList.toggle("hidden");
      courseRelatedBtn.querySelector("i.fa-chevron-down")?.classList.toggle("rotate-180");
    });
  
    paymentRelatedBtn?.addEventListener("click", () => {
      paymentRelatedContent.classList.toggle("hidden");
      paymentRelatedBtn.querySelector("i.fa-chevron-down")?.classList.toggle("rotate-180");
    });
  
    technicalSupportBtn?.addEventListener("click", () => {
      technicalSupportContent.classList.toggle("hidden");
      technicalSupportBtn.querySelector("i.fa-chevron-down")?.classList.toggle("rotate-180");
    });
  
    // 📨 Submit question
    const form = document.getElementById('question-Form');
    if (!form) {
      console.warn("⚠️ Question form not found.");
      return;
    }
  
    form.addEventListener('submit', function (e) {
      e.preventDefault();
  
      const subject = document.getElementById('subject-text').value.trim();
      const email = document.getElementById('email-text').value.trim();
      const question = document.getElementById('question-text').value.trim();
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
      if (!subject || !email || !question) {
        alert("Please fill in all fields.");
        return;
      }
  
      if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return;
      }
  
      fetch('../php/Faq-cont.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ subject, email, question })
      })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
          if (data.success) {
            form.reset();
          }
        })
        .catch(err => {
          alert("There was an error submitting your question.");
          console.error(err);
        });
    });
  }
  