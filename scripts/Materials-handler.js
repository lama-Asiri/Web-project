document.addEventListener("DOMContentLoaded", function () {
  console.log("📄 DOM fully loaded");

  const confirmBtn = document.getElementById("confirmUpload");
  if (!confirmBtn) {
    console.error("❌ confirmUpload button not found!");
    return;
  }

  confirmBtn.addEventListener("click", function () {
    console.log("✅ Upload button clicked");

    const title = document.getElementById("material-name").value.trim();
    const description = document.getElementById("material-description").value.trim();
    const fileInput = document.getElementById("material-file");
    const file = fileInput.files[0];

    if (!title || !description || !file) {
      console.warn("⚠️ Missing title, description, or file", { title, description, file });
      showToast("All fields must be filled", "error");
      return;
    }

    const formData = new FormData();
    formData.append("title", title);
    formData.append("description", description);
    formData.append("file", file);
    formData.append("subject", document.getElementById("material-subject").value);
    formData.append("grade", document.getElementById("material-grade").value);

    const userId = getCookie("user_id");
    console.log("👤 Uploader ID from cookie:", userId);
    formData.append("uploader_id", userId);

    console.log("📦 Sending material to server...");

    fetch("upload_metrial.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => {
        console.log("🔁 Response received from server");
        return res.json();
      })
      .then((data) => {
        console.log("📬 Server response:", data);

        if (data.success && data.material) {
          document.getElementById("material-name").value = '';
          document.getElementById("material-description").value = '';
          document.getElementById("material-file").value = '';

          const modal = document.getElementById("upload-modal");
          if (modal) {
            modal.classList.remove("active");
            console.log("📤 Upload modal closed");
          }

          if (data.material.status === "approved") {
            console.log("🟢 Material approved, creating card...");
            createMaterialCard(data.material);
            showToast("Material uploaded and published successfully!", "success");
          } else if (data.material.status === "pending") {
            console.warn("🟡 Material is pending — not displaying in grid");
            showToast("Material is pending approval and won't be visible yet.", "warning");
          }
        } else {
          console.error("❌ Upload failed, server message:", data.message);
          showToast(data.message || "Upload failed.", "error");
        }
      })
      .catch((error) => {
        console.error("❌ Fetch error:", error);
        showToast("Something went wrong!", "error");
      });
  });
});

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) {
    const result = parts.pop().split(";").shift();
    console.log(`🍪 Cookie fetched: ${name} = ${result}`);
    return result;
  }
  console.warn(`🍪 Cookie ${name} not found`);
  return null;
}

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

function createMaterialCard(material) {
  console.log("🧱 Creating new material card with:", material);

  const card = document.createElement('div');
  card.className = "bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition animate-fadeIn";
  card.setAttribute('data-grade', material.grade);

  const subjectClass = subjectToClass(material.subject);

  card.innerHTML = `
    <div class="p-6 pb-8">
      <div class="flex items-center justify-between mb-4">
        <span class="${subjectClass} px-3 py-1 rounded-full text-sm">${material.subject}</span>
        <button class="text-gray-400 hover:text-gray-600">
          <i class="fa-regular fa-bookmark"></i>
        </button>
      </div>
      <h3 class="text-xl font-bold text-gray-800 mb-2">${material.title}</h3>
      <p class="text-gray-600 mb-4">${material.description}</p>
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <img src="${material.uploader_image || '../images/avtar.png'}" alt="Author" class="w-8 h-8 rounded-full">
          <span class="text-sm font-medium">${material.uploader_name}</span>
        </div>
        <a href="../php/uploads_materials/${material.file_path}" class="text-blue-600 hover:text-blue-700" download>
          <i class="fa-solid fa-download"></i>
        </a>
      </div>
    </div>
  `;

  const grid = document.getElementById("materials-grid");
  if (grid) {
    grid.prepend(card);
    console.log("📦 Card inserted into materials-grid");
  } else {
    console.error("❌ Could not find materials-grid element");
  }

  setupSearchAndFilter();

  // Optional: re-trigger current search filter (auto-apply)
  const event = new Event("input");
  document.querySelector("#search-input").dispatchEvent(event);
}

function setupSearchAndFilter() {
  console.log("🔁 Rebinding filter/search/pill events");

  const searchInput = document.querySelector("#search-input");
  const subjectFilter = document.querySelector("#subject-filter");
  const gradeFilter = document.querySelector("#grade-filter");

  function filterMaterials() {
    const materialCards = document.querySelectorAll("#materials-grid > div");

    const searchText = searchInput.value.toLowerCase();
    const selectedSubject = subjectFilter.value;
    const selectedGrade = gradeFilter.value;

    materialCards.forEach((card) => {
      const title = card.querySelector("h3")?.textContent.toLowerCase() || "";
      const description = card.querySelector("p")?.textContent.toLowerCase() || "";
      const subject = card.querySelector("span")?.textContent.trim() || "";
      const grade = card.getAttribute("data-grade") || "";

      const matchesSearch = title.includes(searchText) || description.includes(searchText);
      const matchesSubject = selectedSubject === "All Subjects" || subject === selectedSubject;
      const matchesGrade = selectedGrade === "All Grades" || grade === selectedGrade;

      card.style.display = (matchesSearch && matchesSubject && matchesGrade) ? "block" : "none";
    });
  }

  searchInput.addEventListener("input", filterMaterials);
  subjectFilter.addEventListener("change", filterMaterials);
  gradeFilter.addEventListener("change", filterMaterials);

  // ✅ Rebind category pills
  const categoryButtons = document.querySelectorAll("#category-pills button");
  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const selectedCategory = this.textContent.trim();
      const materialCards = document.querySelectorAll("#materials-grid > div");

      materialCards.forEach((card) => {
        const subjectTag = card.querySelector("span")?.textContent.trim();
        card.style.display =
          selectedCategory === "All" || subjectTag === selectedCategory
            ? "block"
            : "none";
      });

      categoryButtons.forEach((btn) =>
        btn.classList.remove("bg-blue-600", "text-white", "ring-2", "ring-offset-2", "ring-blue-500")
      );

      this.classList.add("ring-2", "ring-offset-2", "ring-blue-500");
    });
  });
}
