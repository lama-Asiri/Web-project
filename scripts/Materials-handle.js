// handler for category pills
document.addEventListener("DOMContentLoaded", function () {
  const categoryButtons = document.querySelectorAll("#category-pills button");

  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const selectedCategory = this.textContent.trim();

      // ✅ Refresh cards each time
      const materialCards = document.querySelectorAll("#materials-grid > div");

      materialCards.forEach((card) => {
        const subjectTag = card.querySelector("span")?.textContent.trim();
        card.style.display =
          selectedCategory === "All" || subjectTag === selectedCategory
            ? "block"
            : "none";
      });

      categoryButtons.forEach((btn) => {
        btn.classList.remove(
          "bg-blue-600",
          "text-white",
          "ring-2",
          "ring-offset-2",
          "ring-blue-500"
        );
      });

      this.classList.add("ring-2", "ring-offset-2", "ring-blue-500");
    });
  });
});

// handler for search, subject, and grade filters
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector("#search-input");
  const subjectFilter = document.querySelector("#subject-filter");
  const gradeFilter = document.querySelector("#grade-filter");

  function filterMaterials() {
    const searchText = searchInput.value.toLowerCase();
    const selectedSubject = subjectFilter.value;
    const selectedGrade = gradeFilter.value;

    // ✅ Always get fresh list of cards
    const materialCards = document.querySelectorAll("#materials-grid > div");

    materialCards.forEach((card) => {
      const title = card.querySelector("h3")?.textContent.toLowerCase() || "";
      const description = card.querySelector("p")?.textContent.toLowerCase() || "";
      const subject = card.querySelector("span")?.textContent.trim() || "";
      const grade = card.getAttribute("data-grade") || "";

      const matchesSearch = title.includes(searchText) || description.includes(searchText);
      const matchesSubject = selectedSubject === "All Subjects" || subject === selectedSubject;
      const matchesGrade = selectedGrade === "All Grades" || grade === selectedGrade;

      card.style.display = (matchesSearch && matchesSubject && matchesGrade)
        ? "block"
        : "none";
    });
  }

  searchInput.addEventListener("input", filterMaterials);
  subjectFilter.addEventListener("change", filterMaterials);
  gradeFilter.addEventListener("change", filterMaterials);
});

// toggle switches
document.addEventListener("DOMContentLoaded", function () {
  const toggleSwitches = document.querySelectorAll(".toggle-switch");

  toggleSwitches.forEach((switchButton) => {
    switchButton.addEventListener("click", function () {
      this.classList.toggle("bg-gray-200");
      this.classList.toggle("bg-blue-600");

      const switchCircle = this.querySelector(".switch-circle");
      if (switchCircle) {
        switchCircle.classList.toggle("translate-x-5");
      }
    });
  });
});

// toggle content sections (e.g., account settings)
function setupToggleButtons() {
  const toggleButtons = document.querySelectorAll(".toggle-btn");

  toggleButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.getAttribute("data-target");
      const targetContent = document.getElementById(targetId);

      if (targetContent) {
        targetContent.classList.toggle("hidden");

        const chevronIcon = button.querySelector("i.fa-chevron-down");
        if (chevronIcon) {
          chevronIcon.classList.toggle("rotate-180");
        }
      }
    });
  });
}

document.addEventListener("DOMContentLoaded", setupToggleButtons);

// subject label to pill class mapping
function subjectToClass(subject) {
  switch (subject.toLowerCase()) {
    case "mathematics": return "pill-math";
    case "physics": return "pill-physics";
    case "chemistry": return "pill-chem";
    case "biology": return "pill-bio";
    case "literature": return "pill-lit";
    case "history": return "pill-hist";
    default: return "bg-blue-100 text-blue-600";
  }
}

// upload modal handlers
document.addEventListener("DOMContentLoaded", function () {
  const uploadBtn = document.getElementById("upload-btn");
  const uploadModal = document.getElementById("upload-modal");
  const cancelUpload = document.getElementById("cancel-upload");

  uploadBtn?.addEventListener("click", function () {
    uploadModal?.classList.add("active");
  });

  cancelUpload?.addEventListener("click", function () {
    uploadModal?.classList.remove("active");
  });
});
